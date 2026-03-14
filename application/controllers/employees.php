    <?php defined('BASEPATH') or exit('No direct script access allowed');
    define('PUBPATH', str_replace(SELF, '', FCPATH)); // added
    ob_start();
    class employees extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('templates/main_table_01_model');
            $this->load->model('templates/main_nav_model');
            $this->load->model('templates/main_table_02_model');
            $this->load->model('templates/employee_module_model');
            $this->load->model('modules/employees_model');
            $this->load->model('modules/assets_model');
            $this->load->library('logger');
            $this->load->library('system_functions');
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

            $data2 = null;
            //controller/module protection starts
            $userModules       = $this->main_nav_model->get_user_access_modules($this->session->userdata('SESS_USER_ID'));
            $modulesArray      = explode(", ", $userModules);
            $data2['condition1'] = (!in_array('employee_modules', $modulesArray));
            // if (!in_array('administrator_modules', $modulesArray)) {
            if ($data2['condition1']  && !$this->session->userdata('SESS_ADMIN')) {
                $data2['echo1'] = 'module denied';
                redirect('login/session_expired');
            }
            //controller/module protection ends

            $maintenance              = $this->login_model->GET_MAINTENANCE();
            $isAdmin                  = $this->session->userdata('SESS_ADMIN');
            if ($maintenance == '1' && $isAdmin != 1) {
                redirect('login/maintenance');
            }
        }
        function index()
        {
            // employee module test
            $data["Modules"] =  array(
                array("title" => "Employee Directory",                "icon" => "users-gear-duotone.svg",             "url" => "employees/directories",                 "info" => "Views essential information for each employee, status, designation.",    "access" => "Employee", "id" => "employee_directory"),
                array("title" => "Manage Salary",                     "icon" => "money-bill-1-wave-duotone.svg",      "url" => "employees/salary_details",              "info" => "Configure salary amount and type for each employee",                     "access" => "Employee", "id" => "salary_details"),
                array("title" => "Payroll Assignment",                "icon" => "object-ungroup-duotone.svg",         "url" => "employees/payroll_assignment",          "info" => "Configure payslip processing designation",                               "access" => "Payroll", "id" => "payroll_assignment"),
                array("title" => "Custom Group Assignment",           "icon" => "people-group-duotone.svg",           "url" => "employees/custom_group_assignment",     "info" => "Assign employees on custom groups",                                      "access" => "Payroll", "id" => "custom_group_assignment"),
                array("title" => "Setup Organizational Chart",        "icon" => "sitemap-duotone.svg",                "url" => "employees/setup_organization",          "info" => "Define employee positions and roles within the organization",            "access" => "Employee", "id" => "setup_organizational_chart"),
                array("title" => "Approval Route",                    "icon" => "check-to-slot-duotone.svg",          "url" => "employees/approval_routes",             "info" => "Establish approvers and a sequential workflow for requests to move through predefined approver orders.",             "access" => "Employee", "id" => "approval_route"),
                array("title" => "Work Days",                         "icon" => "calendar-check-duotone.svg",         "url" => "employees/work_days",                   "info" => "Configure employee working days in a year",                              "access" => "Employee", "id" => "work_days"),
                array("title" => "Assign Geo Fence",                  "icon" => "solar-system-duotone.svg",           "url" => "employees/assign_geo_fences",           "info" => "Assign geo fences in each employee",                                     "access" => "Employee", "id" => "assign_geo_fences"),
                array("title" => "Max Wire",                          "icon" => "solar-system-duotone.svg",           "url" => "employees/max_wire",                    "info" => "",                                     "access" => "Employee", "id" => "max_wire"),
                // array("title" => "Offboarding",                  "icon" => "object-ungroup-duotone.svg",         "url" => "employees/offboarding",              "info" => "View employee's departure information from the organization.",           "access" => "Employee", "id" => "offboarding"), 
                // array("title" => "Onboarding",                  "icon" => "object-ungroup-duotone.svg",         "url" => "employees/onboarding",              "info" => "View employee's departure information from the organization.",           "access" => "Employee", "id" => "onboarding"), 
            );
            $data['approvers_count']            = $this->employees_model->GET_APPROVER_COUNT();
            $data['salary_type_and_rate_count'] = $this->employees_model->GET_SALARY_TYPE_AND_RATE_COUNT();
            $data['assign_to_count']            = $this->employees_model->ASSIGN_TO_COUNT();
            $data['payroll_assign_count']       = $this->employees_model->GET_PAYROLL_ASSIGNMENT_COUNT();

            $data['settings']                   = "employees/setting_general";
            $data["title_page"]                 = "Employee Information Management";
            $data["title_description"]          = "Provides HR with tools and functionalities to efficiently handle employee data, and ensure compliance.";
            $data["maiya_theme"]                = $this->employees_model->GET_MAYA_THEME();
            $user_access_id                     = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
            $data['DISP_USER_ACCESS_PAGE']      = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
            $array_page                         = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
            $data['Modules']                    = filter_array($data["Modules"], $array_page);
            $this->load->view('templates/header');
            $this->load->view('templates/main_container', $data);
        }

        function setting_general()
        {
            $data['num_approvers']             = $this->employees_model->GET_SYSTEM_SETTING('num_approvers');
            $data['multiple_request']           = $this->employees_model->get_system_setup_by_setting('multiple_request', '0');
            $data['forgot_pass_disable_enable'] = $this->employees_model->get_system_setup_by_setting('forgot_pass_disable_enable', '0');

            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_general_views', $data);
        }


        function update_setting_general()
        {
            $data  = json_decode(file_get_contents('php://input'), true);
            $allowedKeys = array("num_approvers", "multiple_request", "forgot_pass_disable_enable");
            $edit_user = $this->session->userdata('SESS_USER_ID');
            if (!$edit_user) {
                echo json_encode(array('session_expired' => true));
            }
            $filteredData = array_intersect_key($data, array_flip($allowedKeys));
            $updateError = '';
            try {
                foreach ($filteredData as $key => $value) {
                    $res = $this->employees_model->update_setting_general2($value, $key, $edit_user);
                    if (!$res) {
                        if (empty($updateError)) {
                            $updateError = 'Update Failed for ' . $key;
                        } else {
                            $updateError = $updateError . ' .Update Failed for ' . $key;
                        }
                    }
                }
                if (empty($updateError)) {
                    $response = array('success_message' => 'Update Successful!', 'data' => $data);
                } else {
                    $response = array('warning_message' => $updateError);
                }
            } catch (Exception $e) {
                $response = array('warning_message' => 'Updating Failed!', 'Error' => $e->getMessage());
            }
            echo json_encode($response);
        }

        function update_max_wire()
        {
            $data  = json_decode(file_get_contents('php://input'), true);
            $empl_id = $data['empl_id'];
            $checkbox = $data['checkbox'];

            try {
                $res = $this->employees_model->update_max_wire($empl_id, $checkbox);

                $response = array('success_message' => 'Updated Successfully!');
            } catch (Exception $e) {
                $response = array('warning_message' => 'Updating Failed!', 'Error' => $e->getMessage());
            }
            echo json_encode($response);
        }

        function auto_approve()
        {
            $data['auto_approve']                    = $this->employees_model->get_system_setup_by_setting('auto_approve', '0');
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_autoapprove_views', $data);
        }

        function update_auto_approve()
        { {
                $input_data = $this->input->post();
                $validKeys = [
                    'auto_approve',
                ];
                $input_data             = array_intersect_key($input_data, array_flip($validKeys));
                // echo '<pre>';
                // var_dump($input_data);
                // return;
                // $settings= array_keys($input_data);
                $res = $this->employees_model->update_system_setup($input_data);
                // var_dump($res);die();
                if ($res) {
                    $this->session->set_flashdata('SUCC', 'Employee Settings Successfully Updated');
                } else {
                    $this->session->set_flashdata('ERR', 'Employee Settings Unable to update');
                }
                redirect($this->input->server('HTTP_REFERER'));
            }
        }

        function employee_offset_access()
        {
            $selfservice_offset                             = $this->employees_model->get_system_setup_by_settings('selfservice_offset');
            $data['selfservice_offset']                     = explode(",", $selfservice_offset['value']);
            $teams_offset                                   = $this->employees_model->get_system_setup_by_settings('teams_offset');
            $data['EMPLOYEE_LISTS']                         = $this->employees_model->get_employee_list_offset();
            $data['teams_offset']                           = explode(",", $teams_offset['value']);
            
            $this->load->view('templates/header', $data);
            $this->load->view('modules/employees/setting_offset_views', $data);
        }

        function exempt_undertime_access()
        {

            $selfservice_exempt_undertime                   = $this->employees_model->get_system_setup_by_settings('selfservice_exempt_undertime');
            $data['selfservice_exempt_undertime']           = explode(",", $selfservice_exempt_undertime['value']);
            $teams_exempt_undertime                         = $this->employees_model->get_system_setup_by_settings('teams_exempt_undertime');
            $data['EMPLOYEE_LISTS']                         = $this->employees_model->get_employee_list_offset();
            $data['teams_exempt_undertime']                 = explode(",", $teams_exempt_undertime['value']);
            
            $this->load->view('templates/header', $data);
            $this->load->view('modules/employees/setting_exempt_undertime_views', $data);
        }

        function update_offset_access()
        {
            $input_data = $this->input->post();
            // var_dump($input_data); die();
            $validKeys = [
                'selfservice_offset',
                'teams_offset'
            ];
            $input_data             = array_intersect_key($input_data, array_flip($validKeys));

            $res = $this->employees_model->UPDATE_OFFSET_ACCESS($input_data);
            if ($res) {
                $this->session->set_flashdata('SUCC', 'Successfully Updated!');
            } else {
                $this->session->set_flashdata('ERR', 'Settings Unable to update');
            }
            redirect($this->input->server('HTTP_REFERER'));
        }

        function update_exemptundertime_access(){
            $input_data = $this->input->post();
            $res = $this->employees_model->UPDATE_OFFSET_ACCESS($input_data);
            if ($res) {
                $this->session->set_flashdata('SUCC', 'Successfully Updated!');
            } else {
                $this->session->set_flashdata('ERR', 'Settings Unable to update');
            }
            redirect($this->input->server('HTTP_REFERER'));
        }

        function employee_types()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_EMPLOYEE_TYPES());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_employee_types_views', $data);
        }

        function update_employees_type()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_employees_type($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }
        function requirements()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_REQUIREMENTS());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_requirements_views', $data);
        }
        function update_requirements()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_requirements($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function positions()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_POSITIONS_TYPES());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_positions_views', $data);
        }
        function update_positions()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_positions($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }
        function customize_informations()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_STD_SETTINGS('tbl_std_custominfo'));
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_custom_information_views', $data);
        }
        function companies()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_COMPANIES2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_companies_views', $data);
        }
        function update_customize_info()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_custom_informations($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }
        function update_companies()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_companies($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function branches()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_BRANCHES_TYPES());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_branches_views', $data);
        }
        function update_branches()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_branches($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function departments()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_DEPARTMENTS2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_departments_views', $data);
        }

        function update_departments()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_departments($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function divisions()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_DIVISIONS2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_divisions_views', $data);
        }
        function update_divisions()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_divisions($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function clubhouse()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_CLUBHOUSE2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_clubhouse_views', $data);
        }

        function update_clubhouse()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_clubhouse($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function sections()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_SECTIONS2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_sections_views', $data);
        }
        function update_sections()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_sections($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function groups()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_GROUPS2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_groups_views', $data);
        }
        function update_groups()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_groups($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function teams()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_TEAMS2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_teams_views', $data);
        }
        function update_teams()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_teams($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function lines()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_LINES2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_lines_views', $data);
        }
        function update_lines()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_lines($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function marital_statuses()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_MARITAL_STATUSES());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_marital_statuses_views', $data);
        }
        function update_marital_statuses()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_marital_statuses($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function genders()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_GENDERS2());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_genders_views', $data);
        }
        function update_genders()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_genders($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function nationalities()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_NATIONALITIES());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_nationalities_views', $data);
        }
        function update_nationalities()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_nationalities($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function religions()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_RELIGIONS());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_religions_views', $data);
        }

        function update_religions()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_religions($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function blood_types()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_BLOOD_TYPES());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_blood_types_views', $data);
        }
        function update_blood_types()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_blood_types($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function hmos()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_HMOS());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_hmos_views', $data);
        }
        function update_hmos()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_hmos($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function shirt_sizes()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_SHIRT_SIZES());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_shirt_sizes_views', $data);
        }
        function update_shirt_sizes()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_shirt_sizes($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function banks()
        {
            $data['DATA_LIST'] = json_encode($this->employees_model->GET_BANKS());
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_banks_views', $data);
        }
        function update_banks()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            try {
                $updatedData          = $data['updatedData'];
                $edit_user                         = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($updatedData as $updatedData_row) {
                    $res = $this->employees_model->update_banks($updatedData_row, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                );
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }
        // function custom_groups()
        // {
        //     $data['DATA_LIST'] = json_encode($this->employees_model->GET_BANKS());
        //     $this->load->view('templates/header');
        //     $this->load->view('modules/employees/setting_custom_group_views', $data);
        // }
        function settings_custom_groups()
        {
            $selectColumns = [
                // ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
                ['selectStatement' => 'id,name,status'],
            ];
            $filter = [
                // ['year' => $tab],
            ];
            $table = 'tbl_std_custom_groups';
            $dataTable               = $this->employees_model->get_settings_table($table, $filter, $selectColumns);
            $dataTable               = json_encode($dataTable);
            $data["DATA_LIST"]    = $dataTable;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/setting_custom_group_views', $data);
        }
        function update_settings_custom_groups()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            // $response           = array('data' => $data ); 
            try {
                $updatedData          = $data['updatedData'];
                $keysToKeep = ['id', 'name', 'status'];
                $table = 'tbl_std_custom_groups';
                $filteredData = array_map(function ($obj) use ($keysToKeep) {
                    return array_intersect_key($obj, array_flip($keysToKeep));
                }, $updatedData);
                $edit_user             = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($filteredData as $data) {
                    if (preg_match('/[\s,]/', $data['name'])) {
                        $response           = array('warning_message' => $data['name'] . ' contains spaces and or commas which are not allowed. Please fix and try again');
                        echo json_encode($response);
                        return;
                    }
                    $res = $this->employees_model->update_setting_tables($table, $data, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                    'res' => $res,
                );
                // $this->session->set_flashdata('SUCC','Data updated successfully');
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage(), 'filteredData', $filteredData);
                // $this->session->set_flashdata('ERR', 'Fail to add new data');
            }
            // $response = array('reload'=> true);
            echo json_encode($response);
        }

        function settings()
        {
            $this->load->view('templates/header');
            $this->load->view('modules/employees/employee_setting_views');
        }
        function directories()
        {
            // $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
            $search                             = str_replace('_', ' ', $this->input->get('search') ?? "");
            $dept                               = $this->input->get('dept');
            $sec                                = $this->input->get('sec');
            $group                              = $this->input->get('group');
            $line                               = $this->input->get('line');
            $employment_type                    = $this->input->get('employementtype');
            $branch                             = $this->input->get('branch');
            $division                           = $this->input->get('division');
            $clubhouse                           = $this->input->get('clubhouse');
            $team                               = $this->input->get('team');
            $company                            = $this->input->get('company');
            $status                             = $this->input->get('status');

            $data["C_ROW_DISPLAY"]              = [50];

            $page                               = $this->input->get('page');
            $row                                = $this->input->get('row');
            if ($row == null) {
                $row = 50;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);
            if ($status == null) {
                $status = 0;
            }
            // $data['C_DATA_COUNT']               = count($this->employees_model->FILTER_EMPLOYEE_COUNT($dept,$sec,$group,$line,$branch,$division,$team, $status,$company));
            // $data['C_DATA_COUNT']               = count($this->employees_model->FILTER_EMPLOYEE_COUNT_DIRECTORIES($dept, $sec, $group, $line, $branch, $division, $team, $status, $company, $employment_type));
            // if($this->input->get('all') == null){
            if (!$search) {
                $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_ALL_EMPLOYEES_LIMIT_DIRECTORIES($offset, $row, $dept, $sec, $group, $line, $branch, $division, $clubhouse, $team, $status, $company, $employment_type);
                $data['C_DATA_COUNT']           = count($this->employees_model->FILTER_EMPLOYEE_COUNT_DIRECTORIES($dept, $sec, $group, $line, $branch, $division, $clubhouse, $team, $status, $company, $employment_type));
                // $data['C_DATA_COUNT']           = count($this->employees_model->FILTER_EMPLOYEE_COUNT($dept,$sec,$group,$line,$branch,$division,$team,$status,$company));
            } else {
                // $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_SEARCH_EMPLOYEES($search,$status);
                $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_SEARCH_EMPLOYEES_DIRECTORY($search);
                // $data['C_DATA_COUNT']           = count($this->employees_model->MOD_DISP_SEARCH_EMPLOYEES($search,$status));
                $data['C_DATA_COUNT']           = count($this->employees_model->MOD_DISP_SEARCH_EMPLOYEES_DIRECTORY($search));
            }

            // echo '<pre>';
            // print_r($data['DISP_EMP_LIST']); die();

            $data['EMPLOYEE_TYPE_PROB_ID']      = 2;
            $data['EMPLOYEE_TYPE_PROJ_ID']      = 3;
            $data['EMPLOYEE_TYPE_REG_ID']       = 1;
            $data['EMPLOYEE_TYPE_INTERN_ID']    = 4;

            $data['DISP_ROW_COUNT']             = count($this->employees_model->MOD_DISP_ALL_EMPLOYEES());
            $data['DISP_ROW_ACTIVE_COUNT']      = $this->employees_model->MOD_DISP_ALL_ACTIVE_COUNT();
            // $data['DISP_ROW_ACTIVE_PROB_COUNT'] = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT(2);
            $data['DISP_ROW_ACTIVE_PROB_COUNT'] = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT($data['EMPLOYEE_TYPE_PROB_ID']);
            // $data['DISP_ROW_ACTIVE_PROJ_COUNT'] = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT(3);
            $data['DISP_ROW_ACTIVE_PROJ_COUNT'] = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT($data['EMPLOYEE_TYPE_PROJ_ID']);
            // $data['DISP_ROW_ACTIVE_REG_COUNT']  = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT(1);
            $data['DISP_ROW_ACTIVE_REG_COUNT']  = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT($data['EMPLOYEE_TYPE_REG_ID']);
            $data['DISP_ROW_ACTIVE_INTERN_COUNT']  = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT($data['EMPLOYEE_TYPE_INTERN_ID']);

            $data['DISP_VIEW_COMPANY']           = $this->employees_model->GET_SYSTEM_SETTING("com_company");
            $data['DISP_VIEW_BRANCH']           = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_DIVISION']         = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_TEAM']             = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_DEPARTMENT']       = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_CLUBHOUSE']       = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_SECTION']          = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']            = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']             = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $data["C_COM_STRUCTURE"]            = $this->employees_model->GET_COMP_STRUCTURE();
            $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
            $data['C_COMPANIES']                = $this->employees_model->GET_COMPANIES();
            $data['C_POSITIONS']                = $this->employees_model->GET_POSITION();
            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_EMPLOYMENT_TYPES']         = $this->employees_model->GET_EMPLOYEMENT_TYPES();
            $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
            $data['C_CLUBHOUSE']                = $this->employees_model->GET_CLUBHOUSE();
            $data['C_ALL_DEPENDENTS']           = $this->employees_model->GET_DEPENDENTS();
            $data['C_ALL_EMERGENCY']            = $this->employees_model->GET_EMERGENCY();

            $data['C_ALL_DOCUMENTS']            = $this->employees_model->GET_DOCUMENTS();
            // $data['requirements']            = $this->employees_model->getRequirementsCountNotDone(2);
            // $data['C_ALL_DOCUMENTS']            = array();

            // echo '<pre>';
            // print_r($data['requirements']); die();
            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_DIRECTORIES();
            foreach ($employeeSearchRaw as &$item) {
                if (!empty($item->col_suffix)) {
                    $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            // Search Employee List ends 

            $this->load->view('templates/header');
            $this->load->view('modules/employees/employee_list_views', $data);
        }

        function onboarding()
        {
            if (!isset($_GET["branch"])) {
                $param_branch                               = "all";
            } else {
                $param_branch                               = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept                                 = "all";
            } else {
                $param_dept                                 = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division                             = "all";
            } else {
                $param_division                             = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section                              = "all";
            } else {
                $param_section                              = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group                                = "all";
            } else {
                $param_group                                = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team                                 = "all";
            } else {
                $param_team                                 = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line                                 = "all";
            } else {
                $param_line                                 = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status                               = "all";
            } else {
                $param_status                               = $_GET["status"];
            }
            if (!isset($_GET["search"])) {
                $search                               = "all";
            } else {
                $search                               = $_GET["search"];
            }
            $data["C_ROW_DISPLAY"]                        =  [25, 50, 100];
            $page                                         = $this->input->get('page');
            $row                                          = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_EMP_LIST']                    = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST_PAYROLL_ASSIGNMENT($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $search);

            $data['DISP_DISTINCT_DEPARTMENT']           = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
            $data['DISP_DISTINCT_DIVISION']             = $this->employees_model->MOD_DISP_DISTINCT_DIVISION_2();
            $data['DISP_DISTINCT_SECTION']              = $this->employees_model->MOD_DISP_DISTINCT_SECTION_2();
            $data['DISP_DISTINCT_BRANCH']               = $this->employees_model->MOD_DISP_DISTINCT_BRANCH_2();
            $data['DISP_DISTINCT_GROUP']                = $this->employees_model->MOD_DISP_DISTINCT_GROUP_2();
            $data['DISP_DISTINCT_TEAM']                 = $this->employees_model->MOD_DISP_DISTINCT_TEAM_2();
            $data['DISP_DISTINCT_LINE']                 = $this->employees_model->MOD_DISP_DISTINCT_LINE_2();
            $data['DISP_VIEW_DEPARTMENT']               = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']                 = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']                  = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']                   = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                    = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                     = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                     = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
            foreach ($employeeSearchRaw as &$item) {
                if (!empty($item->col_suffix)) {
                    $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            // Search Employee List ends 

            // previous
            $userId                                         = $this->session->userdata('SESS_USER_ID');
            $data['TABLE_DATA']                             = array();
            $status                                         = $this->input->get('status');
            $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
            $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
            $offset                                         =  $limit * ($page - 1);
            $data['STATUS']                                 = $status;
            $data['STATUSES']                               = array('Partial', 'Not Yet Started', 'Completed', 'Cancelled');
            $data['TABLE_DATA']                             = $this->employees_model->GET_ONBOARDING_LIST($userId, $status, $limit, $offset);
            $total_count                                    = $this->employees_model->GET_ONBOARDING_LIST_COUNT($userId, $status);
            $excess                                         = $total_count % $limit;
            $data['C_DATA_COUNT']                           = $total_count;
            $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
            $data['PAGE']                                   = $page;
            $data['ROW']                                    = $limit;
            $data['EMPLOYEES']                              = $this->employees_model->GET_EMPLOYEE_LIST();

            $this->load->view('templates/header');
            $this->load->view('modules/employees/onboarding_views', $data);
            return;
        }

        function add_onboarding_task()
        {
            $data['EMPLOYEES']             = $this->employees_model->GET_EMPLOYEE_LIST();
            $this->load->view('templates/header');
            $this->load->view('modules/employees/add_onboarding_task_views');
        }

        function request_onboarding_task()
        {
            $input_data                           = $this->input->post();
            $input_data['create_date']            = date('Y-m-d H:i:s');
            $input_data['edit_date']              = date('Y-m-d H:i:s');
            $res = $this->employees_model->ADD_DATA('tbl_employee_onboarding', $input_data);
            if ($res) {
                $this->session->set_userdata('SUCC', 'Successfully added new request');
            } else {
                $this->session->set_userdata('ERR', 'Fail to add new request');
                redirect('employees/add_onboarding_task');
                return;
            }
            redirect('employees/onboarding');
        }

        function edit_onboarding_task($id)
        {
            $data['DISP_ONBOARDINGS']            = $this->employees_model->GET_SPECIFIC_ONBOARDING_DATA($id);
            //  var_dump($data['DISP_ONBOARDINGS']);
            // echo '<pre>';
            // var_dump($data['TASK']);
            // return;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_onboarding_task_views', $data);
        }

        function update_onboarding_task()
        {
            $userId                              = $this->session->userdata('SESS_USER_ID');
            $input_data                          = $this->input->post();

            $table                               = 'tbl_employee_onboarding';
            $input_data['edit_user']             = $userId;
            $input_data['edit_date']             = date('Y-m-d H:i:s');

            $res = $this->employees_model->UPDATE_ONBOARDING_DATA($input_data['id'], $table, $input_data);
            $this->session->set_userdata('SUCC', 'Successfully Updated');
            redirect('employees/onboarding');

            $this->load->view('templates/header');
            $this->load->view('modules/assets/employees/onboarding_views');
        }


        function inactive_list()
        {
            // $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
            $search                             = str_replace('_', ' ', $this->input->get('search') ?? "");
            $dept                               = $this->input->get('dept');
            $sec                                = $this->input->get('sec');
            $group                              = $this->input->get('group');
            $line                               = $this->input->get('line');
            $branch                             = $this->input->get('branch');
            $division                           = $this->input->get('division');
            $team                               = $this->input->get('team');
            $company                               = $this->input->get('company');
            $status                             = $this->input->get('status');

            $data["C_ROW_DISPLAY"]              = [25, 50, 100];

            $page                               = $this->input->get('page');
            $row                                = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);
            if ($status == null) {
                $status = 0;
            }
            $data['C_DATA_COUNT']               = count($this->employees_model->FILTER_EMPLOYEE_COUNT2($dept, $sec, $group, $line, $branch, $division, $team, $status, 1, $company));
            // if($this->input->get('all') == null){
            if (!$search) {
                $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_ALL_EMPLOYEES_LIMIT2($offset, $row, $dept, $sec, $group, $line, $branch, $division, $team, $status, 1, $company);
                $data['C_DATA_COUNT']           = count($this->employees_model->FILTER_EMPLOYEE_COUNT2($dept, $sec, $group, $line, $branch, $division, $team, $status, 1, $company));
            } else {
                // $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_SEARCH_EMPLOYEES($search,$status);
                $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_SEARCH_EMPLOYEES_DIRECTORY($search);
                // $data['C_DATA_COUNT']           = count($this->employees_model->MOD_DISP_SEARCH_EMPLOYEES($search,$status));
                $data['C_DATA_COUNT']           = count($this->employees_model->MOD_DISP_SEARCH_EMPLOYEES_DIRECTORY($search));
            }

            $data['DISP_ROW_COUNT']             = count($this->employees_model->MOD_DISP_ALL_EMPLOYEES());
            $data['DISP_ROW_ACTIVE_COUNT']      = $this->employees_model->MOD_DISP_ALL_ACTIVE_COUNT();
            $data['DISP_ROW_ACTIVE_PROB_COUNT'] = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT(2);
            $data['DISP_ROW_ACTIVE_PROJ_COUNT'] = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT(3);
            $data['DISP_ROW_ACTIVE_REG_COUNT']  = $this->employees_model->MOD_DISP_SPEC_ACTIVE_COUNT(1);

            $data['DISP_VIEW_COMPANY']           = $this->employees_model->GET_SYSTEM_SETTING("com_company");
            $data['DISP_VIEW_BRANCH']           = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_DIVISION']         = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_TEAM']             = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_DEPARTMENT']       = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_SECTION']          = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']            = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']             = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $data["C_COM_STRUCTURE"]            = $this->employees_model->GET_COMP_STRUCTURE();
            $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
            $data['C_POSITIONS']                = $this->employees_model->GET_POSITION();
            $data['C_COMPANIES']                = $this->employees_model->GET_COMPANIES();
            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
            $data['C_ALL_DEPENDENTS']           = $this->employees_model->GET_DEPENDENTS();
            $data['C_ALL_EMERGENCY']            = $this->employees_model->GET_EMERGENCY();
            $data['C_ALL_DOCUMENTS']            = $this->employees_model->GET_DOCUMENTS();

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_INACTIVE();
            foreach ($employeeSearchRaw as &$item) {
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            // Search Employee List ends 

            $this->load->view('templates/header');
            $this->load->view('modules/employees/inactive_list_views.php', $data);
        }
        function directories_education()
        {
            //------------------------------------------------------- START OF DYNAMIC PARAMETERS
            $user = $this->input->get('id');
            $data["view_type"]        = $view_type    = ['user', 'col_empl_id', $user];     //all or user
            $data["module_name"]      = $module       = 'employees';
            $data["page_name"]        = $page_name    = 'directories_education';
            $data["model_name"]       = $model        = "main_table_03_model";
            $data["table_name"]       = $table        = "tbl_employee_education ";
            $data["module"]           = [base_url() . $module, "Employees", "Education"];   // Main Menu Path, Module, Page Title
            $data["id_prefix"]        = "EDU";
            $data["excel_output"]     = [true, "directories_education.xlsx"];               // Enable, File Name
            $data["add_button"]       = [true, "Add Education"];                            // Enable, Button Name modal_add_enable   = true;
            $data["status_text"]      = ["Active", "Inactive", "", ""];                     //Green, Red, Orange, Gray
            $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
            $c_data_tab               = array(
                array("Active",   "status", "Active", 0),
                array("Inactive", "status", "Inactive", 0)
            );
            $data["C_BULK_BUTTON"]  = array(
                // array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
                // array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
            );
            $data["C_DB_DESIGN"]    = array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("col_empl_id", "text", 256, 0, 0, 1, 15, "Employee Name", "user", 1, "0"),
                array("col_educ_degree", "text", 256, 1, 1, 1, 10, "Degree", "none", 1, "0"),
                array("col_educ_school", "text", 256, 1, 1, 1, 10, "School", "none", 1, "0"),
                array("col_educ_from_yr", "text", 256, 1, 1, 1, 10, "From (Year)", "none", 1, "0"),
                array("col_educ_to_yr", "text", 256, 1, 1, 1, 10, "To (Year)", "none", 1, "0"),
                array("col_educ_grade", "text", 256, 1, 1, 0, 0, "Grade", "none", 1, "0"),
                array("address", "text", 256, 0, 0, 0, 0, "Address", "textarea", 1, "0"),
                array("completion", "sel", 256, 1, 1, 1, 10, "Completion", "status", 1, "Incomplete;Completed"),
                array("col_educ_level", "text", 256, 1, 1, 1, 10, "Completion", "status", 1, "Primary;Secondary;Tertiary;Vocational"),
            );
            //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
            $search                     = str_replace('_', ' ', $this->input->get('all') ?? "");
            $data["default_row"]        = $filter_row[0];
            $data["C_DATA_EMPL_NAME"]   = $this->$model->get_empl_name();
            $data["C_COM_STRUCTURE"]    = $this->employees_model->GET_COMP_STRUCTURE();

            $page                       = $this->input->get('page');
            $row                        = $this->input->get('row');
            $tab                        = $this->input->get('tab');

            if ($row == null) {
                $row = $filter_row[0];
            }
            if ($tab == null) {
                $tab = $c_data_tab[0][0];
            }
            $offset = $row * ($page - 1);

            $data["C_DATA_TABLE"]       = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]       = $this->$model->get_data_count($table, $tab, $view_type);
            $i = 0;
            $data["C_DATA_TAB"]         = $c_data_tab;

            $this->load->view('templates/header');
            $this->load->view('templates/main_table_03_views', $data);
        }

        function allowance_assign()
        {

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }

            $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
            $data['DISP_YEARS']                        = $year_list = $this->employees_model->GET_YEARS();
            $data["DISP_ALLOWANCE_TYPES"]             = $this->employees_model->GET_ALLOWANCE_TYPES();


            (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];


            $data['YEAR_INITIAL']             = $year;
            $data["DISP_ALLOWANCE"]              = $this->employees_model->GET_ALLOWANCE_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT'] = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']   = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']    = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']     = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_GROUP']      = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']       = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']       = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_DEPARTMENT']     = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']       = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']        = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']         = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']          = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']           = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']           = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $this->load->view('templates/header');
            $this->load->view('modules/employees/allowance_assign_views', $data);
        }

        function taxable_allowance_assign()
        {
            $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }
            if (!isset($_GET["company"])) {
                $param_company   = "all";
            } else {
                $param_company    = $_GET["company"];
            }

            $data["C_ROW_DISPLAY"]                      =  [25, 50, 100];
            $page                                       = $this->input->get('page');
            $row                                        = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            if ($this->input->get('all') == null) {
                $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $param_company);
                $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $param_company);
            } else {
                $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED($search);
                $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED($search));
            }

            $data['DISP_YEARS']                            = $year_list = $this->employees_model->GET_YEARS();
            $data["DISP_ALLOWANCE_TYPES"]                 = $this->employees_model->GET_TAXABLE_ALLOWANCE_TYPES();
            // $data['C_DATA_COUNT']                   = $this->employees_model->GET_COUNT_EMPLOYEELIST();

            (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];

            $data['YEAR_INITIAL']                   = $year;
            $data["DISP_ALLOWANCE"]                    = $this->employees_model->GET_ALLOWANCE_TAX_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $this->load->view('templates/header');
            $this->load->view('modules/employees/taxable_allowance_assign_views', $data);
        }


        function non_taxable_allowance_assign()
        {
            $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }
            if (!isset($_GET["company"])) {
                $param_company   = "all";
            } else {
                $param_company    = $_GET["company"];
            }
            $data["C_ROW_DISPLAY"]                      =  [25, 50, 100];

            $page                                       = $this->input->get('page');
            $row                                        = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            if ($this->input->get('all') == null) {
                $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $param_company);
                $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $param_company);
            } else {
                $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED($search);
                $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED($search));
            }

            $data['DISP_YEARS']                            = $year_list = $this->employees_model->GET_YEARS();
            $data["DISP_ALLOWANCE_TYPES"]                 = $this->employees_model->GET_NON_TAXABLE_ALLOWANCE_TYPES();


            (!isset($_GET["year"])) ? $year             = $year_list[0]->id : $year = $_GET["year"];

            $data['YEAR_INITIAL']                       = $year;
            $data["DISP_ALLOWANCE"]                        = $this->employees_model->GET_ALLOWANCE_NON_TAX_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT']           = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']             = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']              = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']               = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_GROUP']                = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']                 = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']                 = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_DEPARTMENT']               = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']                 = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']                  = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']                   = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                    = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                     = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                     = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $this->load->view('templates/header');
            $this->load->view('modules/employees/non_taxable_allowance_assign_views', $data);
        }

        function taxable_deduction_assign()
        {

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }

            $data["C_ROW_DISPLAY"]                      =  [25, 50, 100];

            $page                                       = $this->input->get('page');
            $row                                        = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
            $data['DISP_YEARS']                        = $year_list = $this->employees_model->GET_YEARS();
            $data["DISP_DEDUCTION_TYPES"]             = $this->employees_model->GET_TAXABLE_DEDUCTION_TYPES();
            $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);

            (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];

            $data['YEAR_INITIAL']                   = $year;
            // $data["DISP_DEDUCTION"]		            = $this->employees_model->GET_DEDUCTION_TAX_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");


            $this->load->view('templates/header');
            $this->load->view('modules/employees/taxable_deduction_assign_views', $data);
        }

        // Reusable function to remove approver name if disabled
        function removeIfDisabled(&$approver, $property)
        {
            $name = strtok($approver->$property, "-");
            if ($name) {
                $disabled_result = $this->employees_model->GET_DISABLED_EMPLOYEES($name);
                if ($disabled_result) {
                    $approver->$property = "";
                }
            }
        }

        function approval_routes()
        {
            $this->load->library('system_functions');
            $data['DISP_APPROVERS']      = array();
            $status                     = $this->input->get('status');
            $limit                      = $this->input->get('row') ? $this->input->get('row')  : 50;
            $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
            $offset                     =  $limit * ($page - 1);
            $search                     = $this->input->get('all');

            $filter_arr                 = array();
            $filter_arr['company']      = $this->input->get('company');
            $filter_arr['branch']       = $this->input->get('branch');
            $filter_arr['dept']         = $this->input->get('dept');
            $filter_arr['div']          = $this->input->get('division');
            $filter_arr['clubhouse']    = $this->input->get('clubhouse');
            $filter_arr['section']      = $this->input->get('section');
            $filter_arr['group']        = $this->input->get('group');
            $filter_arr['team']         = $this->input->get('team');
            $filter_arr['line']         = $this->input->get('line');
            $filter_arr['id']           = $this->input->get('search');

            $data['DISP_EMPLOYEES_NONFILTERED'] = $this->employees_model->MOD_DISP_ALL_EMPLOYEES();
            $data['DISP_APPROVERS']             = $approvers = $this->employees_model->GET_EMPL_APPROVALS_NEW($search, $limit, $offset, $filter_arr);

            foreach ($approvers as $approver) {
                $this->removeIfDisabled($approver, 'approver_1a_name');
                $this->removeIfDisabled($approver, 'approver_1b_name');
                $this->removeIfDisabled($approver, 'approver_2a_name');
                $this->removeIfDisabled($approver, 'approver_2b_name');
                $this->removeIfDisabled($approver, 'approver_3a_name');
                $this->removeIfDisabled($approver, 'approver_3b_name');
                $this->removeIfDisabled($approver, 'approver_4a_name');
                $this->removeIfDisabled($approver, 'approver_4b_name');
                $this->removeIfDisabled($approver, 'approver_5a_name');
                $this->removeIfDisabled($approver, 'approver_5b_name');
            }
            $total_count = $this->employees_model->GET_EMPL_APPROVALS_COUNT($search, $filter_arr);
            $excess      = $total_count % $limit;
            $data['C_DATA_COUNT']   = $total_count;
            $data['PAGES_COUNT']    = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
            $data['PAGE']           = $page;
            $data['ROW']            = $limit;
            $data['C_ROW_DISPLAY']              = array(50);
            $data['DISP_DISTINCT_BRANCH']     = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_DEPARTMENT'] = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']   = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_CLUBHOUSE']   = $this->employees_model->MOD_DISP_DISTINCT_CLUBHOUSE();
            $data['DISP_DISTINCT_SECTION']    = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_GROUP']      = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']       = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']       = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_COMPANY']         = $this->employees_model->GET_SYSTEM_SETTING("com_company");
            $data['DISP_VIEW_BRANCH']         = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_DIVISION']       = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_CLUBHOUSE']      = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_TEAM']           = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_DEPARTMENT']     = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_SECTION']        = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']          = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']           = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
            foreach ($employeeSearchRaw as &$item) {
                if (!empty($item->col_suffix)) {
                    $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name;
                if (!empty($item->col_midl_name)) {
                    $item->name = $item->name . ' ' . $item->col_midl_name[0] . '.';
                }
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']               = $employeeSearchRaw;
            $data['NUM_APPROVERS']                      = $this->employees_model->GET_SYSTEM_SETTING("num_approvers");
            $data['auto_approve']                      = $this->employees_model->GET_SYSTEM_SETTING("auto_approve");
            // Search Employee List ends 
            // echo '<pre>';
            // var_dump($data['DISP_APPROVERS']);
            // return;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/approval_route_views', $data);
        }
        function update_approval_routes()
        {
            // echo file_get_contents('php://input');
            // return;
            $userId = $this->session->userdata('SESS_USER_ID');
            $response = array('success_message' => 'Update Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
                    $response = array('error_message' => 'Failed to update. No data.');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                foreach ($updatedData as $data_row) {
                    $res = $this->employees_model->update_approval_routes($data_row, $userId);
                    // echo $res;
                    if ($res < 1) {
                        $res2 = $this->employees_model->insert_approval_routes($data_row, $userId);
                    }
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
        }


        function assign_approvers_leave()
        {
            $input_data = $this->input->post();
            $empl_ids = explode(",", $input_data['empl_id']);
            unset($input_data['empl_id']);
            $this->employees_model->ASSIGN_APPROVERS($empl_ids, $input_data);
            redirect('employees/approval_routes');
        }
        function non_taxable_deduction_assign()
        {

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }

            $data["C_ROW_DISPLAY"]                  =  [25, 50, 100];

            $page                                   = $this->input->get('page');
            $row                                    = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
            $data['DISP_YEARS']                        = $year_list = $this->employees_model->GET_YEARS();
            $data["DISP_DEDUCTION_TYPES"]             = $this->employees_model->GET_NON_TAXABLE_DEDUCTION_TYPES();
            $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);

            (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];

            $data['YEAR_INITIAL']                   = $year;
            $data["DISP_DEDUCTION"]                    = $this->employees_model->GET_DEDUCTION_NON_TAX_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");


            $this->load->view('templates/header');
            $this->load->view('modules/employees/non_taxable_deduction_assign_views', $data);
        }


        function process_assigning($user_id, $allowance_val, $year, $type)
        {

            $response                               = $this->employees_model->is_duplicate($user_id, $year, $type);

            if ($response == 0) {
                $res_insrt                          = $this->employees_model->ADD_USER_ALLOWANCE($user_id, $allowance_val, $year, $type);
            } else {
                $res_insrt                          = $this->employees_model->UPDATE_USER_ALLOWANCE($user_id, $allowance_val, $year, $type);
            }

            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        function process_allowance_assigning_tax($user_id, $allowance_val, $year, $type)
        {

            $response                               = $this->employees_model->IS_DUPLICATE_ALLOWANCE_TAX($user_id, $year, $type);

            if ($response == 0) {
                $res_insrt                          = $this->employees_model->ADD_USER_ALLOWANCE_TAX($user_id, $allowance_val, $year, $type);
            } else {
                $res_insrt                          = $this->employees_model->UPDATE_USER_ALLOWANCE_TAX($user_id, $allowance_val, $year, $type);
            }

            $this->session->set_userdata('SESS_SUCCESS', 'Taxable Allowance Updated Successfully!');
            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }

            // redirect('employees/taxable_allowance_assign');
        }

        function process_allowance_assigning_nontax($user_id, $allowance_val, $year, $type)
        {

            $response                               = $this->employees_model->IS_DUPLICATE_ALLOWANCE_NONTAX($user_id, $year, $type);

            if ($response == 0) {
                $res_insrt                          = $this->employees_model->ADD_USER_ALLOWANCE_NONTAX($user_id, $allowance_val, $year, $type);
            } else {
                $res_insrt                          = $this->employees_model->UPDATE_USER_ALLOWANCE_NONTAX($user_id, $allowance_val, $year, $type);
            }

            $this->session->set_userdata('SESS_SUCCESS', 'Non-Taxable Allowance Updated Successfully!');
            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }


        function process_deduction_assigning_tax($user_id, $allowance_val, $year, $type)
        {

            $response                               = $this->employees_model->IS_DUPLICATE_DEDUCTION_TAX($user_id, $year, $type);

            if ($response == 0) {
                $res_insrt                          = $this->employees_model->ADD_USER_DEDUCTION_TAX($user_id, $allowance_val, $year, $type);
            } else {
                $res_insrt                          = $this->employees_model->UPDATE_USER_DEDUCTION_TAX($user_id, $allowance_val, $year, $type);
            }

            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        function process_deduction_assigning_nontax($user_id, $val, $year, $type)
        {

            $response                               = $this->employees_model->IS_DUPLICATE_DEDUCTION_NONTAX($user_id, $year, $type);

            if ($response == 0) {
                $res_insrt                          = $this->employees_model->ADD_USER_DEDUCTION_NONTAX($user_id, $val, $year, $type);
            } else {
                $res_insrt                          = $this->employees_model->UPDATE_USER_DEDUCTION_NONTAX($user_id, $val, $year, $type);
            }

            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }
        }

        function update_allowance()
        {
            $empl_id                     = $this->input->post('UPDATE_ID');
            $allowance_val                 = $this->input->post('UPDT_ALLOWANCE_VAL');
            $type                         = $this->input->post('UPDT_ALLOWANCE_TYPE');
            $year                         = $this->input->post('YEAR');

            $empl_ids = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $result                 = $this->employees_model->IS_DUPLICATE($id, $year, $type);

                if ($result == 0) {
                    $this->employees_model->ADD_USER_ALLOWANCE($id, $allowance_val, $year, $type);
                } else {
                    $this->employees_model->update_user_allowance($id, $allowance_val, $year, $type);
                }
            }
            redirect('employees/allowance_assign');
        }


        function update_allowance_tax()
        {
            $empl_id                     = $this->input->post('UPDATE_ID');
            $allowance_val                 = $this->input->post('UPDT_ALLOWANCE_VAL');
            $type                         = $this->input->post('UPDT_ALLOWANCE_TYPE');
            $year                         = $this->input->post('YEAR');

            $empl_ids                   = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $result                 = $this->employees_model->IS_DUPLICATE_ALLOWANCE_TAX($id, $year, $type);

                if ($result == 0) {
                    $this->employees_model->ADD_USER_ALLOWANCE_TAX($id, $allowance_val, $year, $type);
                } else {
                    $this->employees_model->UPDATE_USER_ALLOWANCE_TAX($id, $allowance_val, $year, $type);
                }
            }
            $this->session->set_userdata('SESS_SUCCESS', 'Taxable Allowance Updated Successfully!');
            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }

            // redirect('employees/taxable_allowance_assign');

        }

        function update_allowance_nontax()
        {
            $empl_id                     = $this->input->post('UPDATE_ID');
            $allowance_val                 = $this->input->post('UPDT_ALLOWANCE_VAL');
            $type                         = $this->input->post('UPDT_ALLOWANCE_TYPE');
            $year                         = $this->input->post('YEAR');

            $empl_ids                   = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $result                 = $this->employees_model->IS_DUPLICATE_ALLOWANCE_NONTAX($id, $year, $type);

                if ($result == 0) {
                    $this->employees_model->ADD_USER_ALLOWANCE_NONTAX($id, $allowance_val, $year, $type);
                } else {
                    $this->employees_model->UPDATE_USER_ALLOWANCE_NONTAX($id, $allowance_val, $year, $type);
                }
            }

            $this->session->set_userdata('SESS_SUCCESS', 'Non-Taxable Allowance Updated Successfully!');
            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }
            // redirect('employees/non_taxable_allowance_assign');

        }

        function update_deduction_tax()
        {
            $empl_id                     = $this->input->post('UPDATE_ID');
            $val                         = $this->input->post('UPDT_DEDUCTION_VAL');
            $type                         = $this->input->post('UPDT_DEDUCTION_TYPE');
            $year                         = $this->input->post('YEAR');

            $empl_ids                   = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $result                 = $this->employees_model->IS_DUPLICATE_DEDUCTION_TAX($id, $year, $type);

                if ($result == 0) {
                    $this->employees_model->ADD_USER_DEDUCTION_TAX($id, $val, $year, $type);
                } else {
                    $this->employees_model->UPDATE_USER_DEDUCTION_TAX($id, $val, $year, $type);
                }
            }
            redirect('employees/taxable_deduction_assign');
        }

        function update_deduction_non_tax()
        {
            $empl_id                     = $this->input->post('UPDATE_ID');
            $val                         = $this->input->post('UPDT_DEDUCTION_VAL');
            $type                         = $this->input->post('UPDT_DEDUCTION_TYPE');
            $year                         = $this->input->post('YEAR');

            $empl_ids                   = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $result                 = $this->employees_model->IS_DUPLICATE_DEDUCTION_NONTAX($id, $year, $type);

                if ($result == 0) {
                    $this->employees_model->ADD_USER_DEDUCTION_NONTAX($id, $val, $year, $type);
                } else {
                    $this->employees_model->UPDATE_USER_DEDUCTION_NONTAX($id, $val, $year, $type);
                }
            }
            redirect('employees/non_taxable_deduction_assign');
        }


        function allowance_assign_old()
        {
            //------------------------------------------------------- START OF DYNAMIC PARAMETERS
            $user = $this->session->userdata('SESS_USER_ID');
            $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
            $data["module_name"]      = $module       = 'employees';
            $data["page_name"]        = $page_name    = 'allowance_assign';
            $data["model_name"]       = $model        = "employee_module_model";
            $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
            $data["module"]           = [base_url() . $module, "Employees", "Allowances Assignment"];         // Main Menu Path, Module, Page Title
            $data["id_prefix"]        = "ALA";
            $data["excel_import"]     = [true];
            $data["excel_output"]     = [true, "allowance_assign.xlsx"];                                                       // Enable, File Name
            $data["add_button"]       = [true, "Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
            $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
            $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
            $c_data_tab             = array(
                array("Active", "status", "Active", 0),
                array("Inactive", "status", "Inactive", 0)
            );
            $data["C_BULK_BUTTON"]  = array(
                array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
                array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
            );
            $data["C_DB_DESIGN"]  =
                array(
                    array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
                    array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
                    array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
                    array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
                    array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
                    array("username", "Employee", "user", "self", 1, 20, 1, 0, 0, 0, 0, 1),
                    array("name", "Allowance", "db-sel", "array1", 1, 20, 1, 1, 1, 1, 1, 1),
                    array("values", "Value", "number", "0", 1, 15, 1, 1, 1, 1, 1, 1),
                    array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),

                );

            $C_ARRAY_TABLE_1 = "tbl_std_allowances";
            $C_ARRAY_TABLE_2 = "";
            $C_ARRAY_TABLE_3 = "";
            $C_ARRAY_TABLE_4 = "";
            $C_ARRAY_TABLE_5 = "";

            //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
            $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
            $data["default_row"]                = $filter_row[0];
            $data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
            $data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
            $data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
            $data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
            $data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
            $data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

            $page                               = $this->input->get('page');
            $row                                = $this->input->get('row');
            $tab                                = $this->input->get('tab');
            $tab_filter                         = $this->input->get('tab_filter');

            if ($row == null) {
                $row = $filter_row[0];
            }
            if ($tab == null) {
                $tab = $c_data_tab[0][0];
            }
            if ($tab_filter == null) {
                $tab_filter = $c_data_tab[0][1];
            }

            $offset = $row * ($page - 1);
            $data["C_TAB_SELECT"] = $tab;

            $dept                               = $this->input->get('dept');
            $sec                                = $this->input->get('sec');
            $group                              = $this->input->get('group');
            $line                               = $this->input->get('line');
            $branch                             = $this->input->get('branch');
            $division                           = $this->input->get('division');
            $team                               = $this->input->get('team');
            $status                             = $this->input->get('status');

            if ($this->input->get('all') == null) {
                $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type, $dept, $sec, $group, $line, $branch, $division, $team, $status);
                $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
            } else {
                $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
                $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
            }
            $i = 0;
            foreach ($c_data_tab as $c_data_tab_row) {
                $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
                $i++;
            }
            $data["C_DATA_TAB"]    = $c_data_tab;

            $data['DISP_VIEW_BRANCH']           = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_DIVISION']         = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_TEAM']             = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_DEPARTMENT']       = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_SECTION']          = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']            = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']             = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();

            $this->load->view('templates/header');
            $this->load->view('templates/employee_module_views', $data);
        }


        function deduction_assign()
        {
            //------------------------------------------------------- START OF DYNAMIC PARAMETERS
            $user = $this->session->userdata('SESS_USER_ID');
            $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
            $data["module_name"]      = $module       = 'employees';
            $data["page_name"]        = $page_name    = 'deduction_assign';
            $data["model_name"]       = $model        = "employee_module_model";
            $data["table_name"]       = $table        = "tbl_employee_deductionassign";
            $data["module"]           = [base_url() . $module, "Employees", "Deduction Assignment"];         // Main Menu Path, Module, Page Title
            $data["id_prefix"]        = "DDA";
            $data["excel_import"]     = [true];
            $data["excel_output"]     = [true, "deduction_assign.xlsx"];                                                       // Enable, File Name
            $data["add_button"]       = [true, "Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
            $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
            $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
            $c_data_tab             = array(
                array("Active", "status", "Active", 0),
                array("Inactive", "status", "Inactive", 0)
            );
            $data["C_BULK_BUTTON"]  = array(
                array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
                array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
            );
            $data["C_DB_DESIGN"]  =
                array(
                    array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
                    array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
                    array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
                    array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
                    array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
                    array("username", "Employee", "user", "self", 1, 20, 1, 0, 0, 0, 0, 1),
                    array("name", "Allowance", "db-sel", "array1", 1, 20, 1, 1, 1, 1, 1, 1),
                    array("values", "Value", "number", "0", 1, 15, 1, 1, 1, 1, 1, 1),
                    array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),



                );

            $C_ARRAY_TABLE_1 = "tbl_std_deductions";
            $C_ARRAY_TABLE_2 = "";
            $C_ARRAY_TABLE_3 = "";
            $C_ARRAY_TABLE_4 = "";
            $C_ARRAY_TABLE_5 = "";
            //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
            $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
            $data["default_row"]                 = $filter_row[0];
            $data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
            $data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
            $data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
            $data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
            $data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
            $data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

            $page                               = $this->input->get('page');
            $row                                = $this->input->get('row');
            $tab                                = $this->input->get('tab');
            $tab_filter                         = $this->input->get('tab_filter');

            if ($row == null) {
                $row = $filter_row[0];
            }
            if ($tab == null) {
                $tab = $c_data_tab[0][0];
            }
            if ($tab_filter == null) {
                $tab_filter = $c_data_tab[0][1];
            }

            $offset = $row * ($page - 1);
            $data["C_TAB_SELECT"] = $tab;

            $dept                               = $this->input->get('dept');
            $sec                                = $this->input->get('sec');
            $group                              = $this->input->get('group');
            $line                               = $this->input->get('line');
            $branch                             = $this->input->get('branch');
            $division                           = $this->input->get('division');
            $team                               = $this->input->get('team');
            $status                             = $this->input->get('status');

            if ($this->input->get('all') == null) {
                $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type, $dept, $sec, $group, $line, $branch, $division, $team, $status);
                $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
            } else {
                $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
                $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
            }
            $i = 0;
            foreach ($c_data_tab as $c_data_tab_row) {
                $c_data_tab[$i][3] = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
                $i++;
            }

            $data['DISP_VIEW_BRANCH']           = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_DIVISION']         = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_TEAM']             = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_DEPARTMENT']       = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_SECTION']          = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']            = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']             = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();

            $data["C_DATA_TAB"]                 = $c_data_tab;
            $this->load->view('templates/header');
            $this->load->view('templates/employee_module_views', $data);
        }



        function skill_assign()
        {
            //------------------------------------------------------- START OF DYNAMIC PARAMETERS
            $user = $this->session->userdata('SESS_USER_ID');
            $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
            $data["module_name"]      = $module       = 'employees';
            $data["page_name"]        = $page_name    = 'skill_assign';
            $data["model_name"]       = $model        = "employee_module_model";
            $data["table_name"]       = $table        = "tbl_employee_skillassign";
            $data["module"]           = [base_url() . $module, "Employees", "Skill Assignment"];         // Main Menu Path, Module, Page Title
            $data["id_prefix"]        = "SKA";
            $data["excel_import"]     = [false];
            $data["excel_output"]     = [false, "skill_assign.xlsx"];                                                       // Enable, File Name
            $data["add_button"]       = [true, "Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
            $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
            $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
            $c_data_tab             = array(
                array("Active", "status", "Active", 0),
                array("Inactive", "status", "Inactive", 0)
            );
            $data["C_BULK_BUTTON"]  = array(
                array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),    //visible,id,icon,Button Name,column,status
                array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")    //visible,id,icon,Button Name,column,status
            );
            $data["C_DB_DESIGN"]  =
                array(
                    array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
                    array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
                    array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
                    array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
                    array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
                    array("username", "Employee", "user", "self", 1, 15, 1, 1, 0, 0, 0, 1),
                    array("name", "Skill Name", "db-sel", "array1", 1, 15, 1, 1, 1, 1, 1, 1),
                    array("value", "Skill Level", "db-sel", "array2", 1, 15, 1, 1, 1, 1, 1, 1),
                    array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),

                );


            $C_ARRAY_TABLE_1 = "tbl_std_skillnames";
            $C_ARRAY_TABLE_2 = "tbl_std_skilllevels";
            $C_ARRAY_TABLE_3 = "";
            $C_ARRAY_TABLE_4 = "";
            $C_ARRAY_TABLE_5 = "";
            //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
            $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
            $data["default_row"]                = $filter_row[0];
            $data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
            $data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
            $data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
            $data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
            $data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
            $data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

            $page                               = $this->input->get('page');
            $row                                = $this->input->get('row');
            $tab                                = $this->input->get('tab');
            $tab_filter                         = $this->input->get('tab_filter');

            if ($row == null) {
                $row = $filter_row[0];
            }
            if ($tab == null) {
                $tab = $c_data_tab[0][0];
            }
            if ($tab_filter == null) {
                $tab_filter = $c_data_tab[0][1];
            }

            $offset = $row * ($page - 1);
            $data["C_TAB_SELECT"] = $tab;

            $dept                               = $this->input->get('dept');
            $sec                                = $this->input->get('sec');
            $group                              = $this->input->get('group');
            $line                               = $this->input->get('line');
            $branch                             = $this->input->get('branch');
            $division                           = $this->input->get('division');
            $team                               = $this->input->get('team');
            $status                             = $this->input->get('status');

            if ($this->input->get('all') == null) {
                $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type, $dept, $sec, $group, $line, $branch, $division, $team, $status);
                $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
            } else {
                $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
                $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
            }
            $i = 0;
            foreach ($c_data_tab as $c_data_tab_row) {
                $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
                $i++;
            }

            $data['DISP_VIEW_BRANCH']           = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_DIVISION']         = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_TEAM']             = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_DEPARTMENT']       = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_SECTION']          = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']            = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']             = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();

            $data["C_DATA_TAB"]                 = $c_data_tab;
            $this->load->view('templates/header');
            $this->load->view('templates/employee_module_views', $data);
        }

        function salary_history()
        {

            $id = $this->uri->segment(3);
            $data['C_LOGS']                      = $this->employees_model->GET_EMPLOYEE_SALARY_LOGS_SPECIFIC($id);
            $personal                            = $this->employees_model->GET_EMPLOYEE_SPECIFIC_NAME($id);
            $data['employee']                   = $personal[0]->employee;
            // $data['LASTNAME']                    = $personal[0]->col_last_name;
            // if (!$data['C_LOGS'] || !$personal) {
            if (empty($personal)) {
                // $this->session->set_flashdata('ERR', 'No Change History');
                redirect('employees/salary_details');
            }
            $this->load->view('templates/header');
            $this->load->view('modules/employees/salary_history_views', $data);
        }

        function salary_details()
        {
            // $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
            $search                             = str_replace('_', ' ', $this->input->get('search') ?? "");

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["company"])) {
                $param_company   = "all";
            } else {
                $param_company    = $_GET["company"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["clubhouse"])) {
                $param_clubhouse = "all";
            } else {
                $param_clubhouse  = $_GET["clubhouse"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }
            $data["C_ROW_DISPLAY"]                   =  [50];

            $page                                       = $this->input->get('page');
            $row                                        = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            // if($this->input->get('all') == null){
            if (!$search) {
                // $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line,$param_company);
                $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company);

                $data['DISP_EMP_LIST_TABLE']            = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST_TABLE($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company);
            } else {
                // $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED($search);
                $data['DISP_EMP_LIST_TABLE']                  = $this->employees_model->GET_SEARCHED_SALARY_DETAILS($search);
                // $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED_SALARY_DETAILS($search);
                // $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED($search));
                $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED_SALARY_DETAILS($search));
            }

            $data['DISP_YEARS']                            = $year_list = $this->employees_model->GET_YEARS();
            // $data["DISP_DEDUCTION_TYPES"] 		    = $this->employees_model->GET_TAXABLE_DEDUCTION_TYPES();


            (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];

            // $data["DISP_DEDUCTION"]		            = $this->employees_model->GET_DEDUCTION_TAX_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_CLUBHOUSE']         = $this->employees_model->MOD_DISP_DISTINCT_CLUBHOUSE();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_COMPANY']           = $this->employees_model->MOD_DISP_DISTINCT_COMPANY();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_COMPANY']              = $this->employees_model->GET_SYSTEM_SETTING("com_company");
            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_CLUBHOUSE']            = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
            foreach ($employeeSearchRaw as &$item) {
                if (!empty($item->col_suffix)) {
                    $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            // Search Employee List ends 

            $this->load->view('templates/header');
            $this->load->view('modules/employees/salary_detail_views', $data);
        }

        function work_days()
        {
            //   $search                                       = str_replace('_', ' ', $this->input->get('all') ?? "");

            if (!isset($_GET["branch"])) {
                $search                               = "all";
            } else {
                $search                             = str_replace('_', ' ', $this->input->get('search') ?? "");
            }
            if (!isset($_GET["branch"])) {
                $param_branch                               = "all";
            } else {
                $param_branch                               = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept                                 = "all";
            } else {
                $param_dept                                 = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division                             = "all";
            } else {
                $param_division                             = $_GET["division"];
            }
            if (!isset($_GET["clubhouse"])) {
                $param_clubhouse = "all";
            } else {
                $param_clubhouse  = $_GET["clubhouse"];
            }
            if (!isset($_GET["section"])) {
                $param_section                              = "all";
            } else {
                $param_section                              = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group                                = "all";
            } else {
                $param_group                                = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team                                 = "all";
            } else {
                $param_team                                 = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line                                 = "all";
            } else {
                $param_line                                 = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status                               = "all";
            } else {
                $param_status                               = $_GET["status"];
            }
            $data["C_ROW_DISPLAY"]                        =  [50];
            $page                                         = $this->input->get('page');
            $row                                          = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_YEARS']                         = $year_list = $this->employees_model->GET_YEARS_DESC();
            if (!isset($_GET["year"])) {
                $year             = $year_list[0]->id;
                foreach ($year_list as $item) {
                    if ($item->name == date("Y")) {
                        $year = $item->id;
                    }
                }
            } else {
                $year = $_GET["year"];
            }
            // $test = null;
            // var_dump($_GET["year"]); 
            // die();

            // var_dump( date("Y"));
            // var_dump($test);
            // var_dump($year); die();
            $data['year'] = $year;
            $data['DISP_EMP_LIST']                    = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST_WORK_DAYS($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $year, $search);
            $data['C_DATA_COUNT']                     = $this->employees_model->GET_FILTERED_EMPLOYEELIST_WORK_DAYS_COUNT($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $year, $search);

            $data['DISP_DISTINCT_DEPARTMENT']           = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
            $data['DISP_DISTINCT_DIVISION']             = $this->employees_model->MOD_DISP_DISTINCT_DIVISION_2();
            $data['DISP_DISTINCT_CLUBHOUSE']             = $this->employees_model->MOD_DISP_DISTINCT_CLUBHOUSE_2();
            $data['DISP_DISTINCT_SECTION']              = $this->employees_model->MOD_DISP_DISTINCT_SECTION_2();
            $data['DISP_DISTINCT_BRANCH']               = $this->employees_model->MOD_DISP_DISTINCT_BRANCH_2();
            $data['DISP_DISTINCT_GROUP']                = $this->employees_model->MOD_DISP_DISTINCT_GROUP_2();
            $data['DISP_DISTINCT_TEAM']                 = $this->employees_model->MOD_DISP_DISTINCT_TEAM_2();
            $data['DISP_DISTINCT_LINE']                 = $this->employees_model->MOD_DISP_DISTINCT_LINE_2();
            $data['DISP_VIEW_DEPARTMENT']               = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']                 = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_CLUBHOUSE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_SECTION']                  = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']                   = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                    = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                     = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                     = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
            foreach ($employeeSearchRaw as &$item) {
                if (!empty($item->col_suffix)) {
                    $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            // Search Employee List ends 

            $this->load->view('templates/header');
            $this->load->view('modules/employees/work_days_views', $data);
        }

        function update_work_days()
        {
            $data                 = json_decode(file_get_contents('php://input'), true);
            // $response           = array('data' => $data ); 
            try {
                $updatedData          = $data['updatedData'];
                $keysToKeep = ['id', 'year', 'days'];
                $table = 'tbl_employee_work_days';
                $filteredData = array_map(function ($obj) use ($keysToKeep) {
                    return array_intersect_key($obj, array_flip($keysToKeep));
                }, $updatedData);
                $edit_user             = $this->session->userdata('SESS_USER_ID');
                $failedInsert = 0;
                $inserted = 0;
                $failedUpdate = 0;
                $updated = 0;
                $unexpted = 0;
                foreach ($filteredData as $data) {
                    $res = $this->employees_model->update_setting_tables_where($table, $data, $edit_user);
                    if ($res == 'failedInsert') {
                        $failedInsert++;
                    } else if ($res == 'inserted') {
                        $inserted++;
                    } else if ($res == 'failedUpdate') {
                        $failedUpdate++;
                    } else if ($res == 'updated') {
                        $updated++;
                    } else {
                        $unexpted++;
                    }
                }
                $response           = array(
                    'success_message' => 'Data updated successfully',
                    'failedInsert' => $failedInsert,
                    'inserted' => $inserted,
                    'failedUpdate' => $failedUpdate,
                    'updated' => $updated,
                    'unexpted' => $unexpted,
                    'res' => $res,
                );
                // $this->session->set_flashdata('SUCC','Data updated successfully');
            } catch (Exception $e) {
                $response           = array('warning_message' => 'Error updating data: ' . $e->getMessage(), 'filteredData', $filteredData);
                // $this->session->set_flashdata('ERR', 'Fail to add new data');
            }
            // $response = array('reload'=> true);
            echo json_encode($response);
        }

        function payroll_assignment()
        {
            //   $search                                       = str_replace('_', ' ', $this->input->get('all') ?? "");
            // $search                             = str_replace('_', ' ', $this->input->get('search') ?? "");
            if (!isset($_GET["branch"])) {
                $param_branch                               = "all";
            } else {
                $param_branch                               = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept                                 = "all";
            } else {
                $param_dept                                 = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division                             = "all";
            } else {
                $param_division                             = $_GET["division"];
            }
            if (!isset($_GET["clubhouse"])) {
                $param_clubhouse                            = "all";
            } else {
                $param_clubhouse                            = $_GET["clubhouse"];
            }
            if (!isset($_GET["section"])) {
                $param_section                              = "all";
            } else {
                $param_section                              = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group                                = "all";
            } else {
                $param_group                                = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team                                 = "all";
            } else {
                $param_team                                 = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line                                 = "all";
            } else {
                $param_line                                 = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status                               = "all";
            } else {
                $param_status                               = $_GET["status"];
            }
            if (!isset($_GET["search"])) {
                $search                               = "all";
            } else {
                $search                               = $_GET["search"];
            }
            $data["C_ROW_DISPLAY"]                        =  [50];
            $page                                         = $this->input->get('page');
            $row                                          = $this->input->get('row');
            if ($row == null) {
                $row = 50;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_EMP_LIST']                    = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST_PAYROLL_ASSIGNMENT($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $search);
            $data['C_DATA_COUNT']                    = $this->employees_model->GET_FILTERED_EMPLOYEELIST_PAYROLL_ASSIGNMENT_COUNT($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $search);


            $data['DISP_YEARS']                         = $year_list = $this->employees_model->GET_YEARS_PAYROLL_ASSIGNMENT();

            (!isset($_GET["year"])) ? $year             = $year_list[0]->id : $year = $_GET["year"];
            $data["DISP_PAYROLL_ASSIGN"]                = $this->employees_model->GET_ALL_PAYROLL_ASSIGNMENT();
            $data['DISP_DISTINCT_DEPARTMENT']           = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
            $data['DISP_DISTINCT_DIVISION']             = $this->employees_model->MOD_DISP_DISTINCT_DIVISION_2();
            $data['DISP_DISTINCT_CLUBHOUSE']             = $this->employees_model->MOD_DISP_DISTINCT_CLUBHOUSE_2();
            $data['DISP_DISTINCT_SECTION']              = $this->employees_model->MOD_DISP_DISTINCT_SECTION_2();
            $data['DISP_DISTINCT_BRANCH']               = $this->employees_model->MOD_DISP_DISTINCT_BRANCH_2();
            $data['DISP_DISTINCT_GROUP']                = $this->employees_model->MOD_DISP_DISTINCT_GROUP_2();
            $data['DISP_DISTINCT_TEAM']                 = $this->employees_model->MOD_DISP_DISTINCT_TEAM_2();
            $data['DISP_DISTINCT_LINE']                 = $this->employees_model->MOD_DISP_DISTINCT_LINE_2();
            $data['DISP_VIEW_DEPARTMENT']               = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']                 = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_CLUBHOUSE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_SECTION']                  = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']                   = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                    = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                     = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                     = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
            foreach ($employeeSearchRaw as &$item) {
                if (!empty($item->col_suffix)) {
                    $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            // Search Employee List ends 

            $this->load->view('templates/header');
            $this->load->view('modules/employees/payroll_assignment_views', $data);
        }
        function assign_geo_fences()
        {
            //   $search                                       = str_replace('_', ' ', $this->input->get('all') ?? "");
            // $search                             = str_replace('_', ' ', $this->input->get('search') ?? "");
            if (!isset($_GET["branch"])) {
                $param_branch                               = "all";
            } else {
                $param_branch                               = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept                                 = "all";
            } else {
                $param_dept                                 = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division                             = "all";
            } else {
                $param_division                             = $_GET["division"];
            }
            if (!isset($_GET["clubhouse"])) {
                $param_clubhouse                            = "all";
            } else {
                $param_clubhouse                            = $_GET["clubhouse"];
            }
            if (!isset($_GET["section"])) {
                $param_section                              = "all";
            } else {
                $param_section                              = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group                                = "all";
            } else {
                $param_group                                = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team                                 = "all";
            } else {
                $param_team                                 = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line                                 = "all";
            } else {
                $param_line                                 = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status                               = "all";
            } else {
                $param_status                               = $_GET["status"];
            }
            if (!isset($_GET["search"])) {
                $search                               = "all";
            } else {
                $search                               = $_GET["search"];
            }
            $data["C_ROW_DISPLAY"]                        =  [50];
            $page                                         = $this->input->get('page');
            $row                                          = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_EMP_LIST']                      = $empl_list = $this->employees_model->GET_EMPLOYEE_FENCES($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $search);
            $data['C_DATA_COUNT']                       = $this->employees_model->GET_FILTERED_EMPLOYEELIST_PAYROLL_ASSIGNMENT_COUNT($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $search);
            $data['DISP_YEARS']                         = $year_list = $this->employees_model->GET_YEARS_PAYROLL_ASSIGNMENT();
            (!isset($_GET["year"])) ? $year             = $year_list[0]->id : $year = $_GET["year"];
            $data["DISP_PAYROLL_ASSIGN"]                = $this->employees_model->GET_ALL_PAYROLL_ASSIGNMENT();
            $data['DISP_DISTINCT_DEPARTMENT']           = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
            $data['DISP_DISTINCT_DIVISION']             = $this->employees_model->MOD_DISP_DISTINCT_DIVISION_2();
            $data['DISP_DISTINCT_CLUBHOUSE']             = $this->employees_model->MOD_DISP_DISTINCT_CLUBHOUSE_2();
            $data['DISP_DISTINCT_SECTION']              = $this->employees_model->MOD_DISP_DISTINCT_SECTION_2();
            $data['DISP_DISTINCT_BRANCH']               = $this->employees_model->MOD_DISP_DISTINCT_BRANCH_2();
            $data['DISP_DISTINCT_GROUP']                = $this->employees_model->MOD_DISP_DISTINCT_GROUP_2();
            $data['DISP_DISTINCT_TEAM']                 = $this->employees_model->MOD_DISP_DISTINCT_TEAM_2();
            $data['DISP_DISTINCT_LINE']                 = $this->employees_model->MOD_DISP_DISTINCT_LINE_2();
            $data['DISP_VIEW_DEPARTMENT']               = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']                 = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_CLUBHOUSE']                = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_SECTION']                  = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']                   = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                    = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                     = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                     = $this->employees_model->GET_SYSTEM_SETTING("com_line");
            $data['FENCES']                             = $this->employees_model->GET_LIST_DATA("tbl_fence_areas");
            // echo '<pre>';
            // var_dump($data['DISP_EMP_LIST']);
            // return;
            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID();
            foreach ($employeeSearchRaw as &$item) {
                if (!empty($item->col_suffix)) {
                    $item->col_last_name = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $item->col_last_name . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name;
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/assign_geo_fence_views', $data);
        }


        function max_wire()
        {
            $data['DISP_EMPLOYEES']             = $this->employees_model->GET_ALL_EMPLOYEES_MAX_WIRE();
            $data['C_DATA_COUNT']                = count($this->employees_model->GET_ALL_EMPLOYEES_MAX_WIRE());
            $data['DISP_DISTINCT_BRANCH']     = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_DEPARTMENT'] = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']   = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']    = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_GROUP']      = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']       = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']       = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_COMPANY']         = $this->employees_model->GET_SYSTEM_SETTING("com_company");
            $data['DISP_VIEW_BRANCH']         = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_DIVISION']       = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_TEAM']           = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_DEPARTMENT']     = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_SECTION']        = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']          = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']           = $this->employees_model->GET_SYSTEM_SETTING("com_line");



            $this->load->view('templates/header');
            $this->load->view('modules/employees/max_wire_views', $data);
        }

        function update_fences()
        {

            $input_data                            = $this->input->post();
            $input_data['fences']                  = isset($input_data['fences']) ? json_encode($input_data['fences']) : '[]';
            $input_data['create_date']             = date('Y-m-d H:i:s');
            $input_data['edit_date']               = date('Y-m-d H:i:s');
            $input_data['edit_user']               = $this->session->userdata('SESS_USER_ID');
            // echo json_encode($input_data);
            $res = $this->employees_model->UPDATE_EMPLOYEE_FENCE($input_data);
            // $this->session->set_userdata('SESS_SUCCESS', 'Assign Fence Updated Successfully!');
            echo $res;
        }

        function meal_allowance()
        {

            $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
            $cutoff                             = $this->input->get('cutoff');

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }
            if (!isset($_GET["company"])) {
                $param_company   = "all";
            } else {
                $param_company    = $_GET["company"];
            }
            $data["C_ROW_DISPLAY"]                   =  [25, 50, 100];

            $page                                       = $this->input->get('page');
            $row                                        = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_CUTOFF_PERIOD']             = $this->employees_model->MOD_DISP_CUTOFF_PERIOD();

            if (!$cutoff || $cutoff == "all") {
                $cutoff = $data['DISP_CUTOFF_PERIOD'][0]->id;
            }

            if ($this->input->get('all') == null) {
                $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $param_company);
                $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line, $param_company);
            } else {
                $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED($search);
                $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED($search));
            }

            $approved_ot = array(); // Initialize the array

            foreach ($empl_list as $row) {
                // Populate the array with new data for the updated $cutoff date
                array_push($approved_ot, $this->employees_model->GET_APPROVED_OT($cutoff, $row->id));
            }

            $data['DISP_APPROVED_OT'] = $approved_ot;


            // $approved_ot = array();
            // foreach($empl_list as $row){
            //     // $data['DISP_APPROVED_OT']               = $this->employees_model->GET_APPROVED_OT($cutoff, $row->id);
            //     array_push($approved_ot,$this->employees_model->GET_APPROVED_OT($cutoff, $row->id));
            // }
            // $data['DISP_APPROVED_OT']               = $approved_ot;


            $data['DISP_YEARS']                            = $year_list = $this->employees_model->GET_YEARS();

            (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");


            $this->load->view('templates/header');
            $this->load->view('modules/employees/meal_allowance_views', $data);
        }




        // =========================================================== NEW EMPLOYEE =====================================================================

        function get_searched_employee()
        {
            $search                         = $this->input->post('search');
            $data                           = $this->employees_model->MOD_GET_SEARCHED_DATA($search);
            echo (json_encode($data));
        }

        function new_employee()
        {
            // $data['DISP_EMP_REPORTING_TO'] = $this->employees_model->MOD_DISP_REPORTING_TO();
            $data['DISP_EMP_GENDER']          = $this->employees_model->GET_GENDERS();
            $data['DISP_EMP_LOCATION']        = $this->employees_model->GET_BRANCHES();
            $data['DISP_EMP_DIVISION']        = $this->employees_model->GET_DIVISIONS();
            $data['DISP_EMP_DEPARTMENT']      = $this->employees_model->GET_DEPARTMENTS();
            $data['DISP_EMP_SECTION']         = $this->employees_model->GET_SECTIONS();
            $data['DISP_EMP_POSITION']        = $this->employees_model->GET_POSITION();
            $data['DISP_EMP_EMPTYPES']        = $this->employees_model->GET_POSITION(); //
            $data['DISP_EMP_ONBOARDING']      = $this->employees_model->GET_POSITION(); //
            $data['DISP_EMP_TEAMS']           = $this->employees_model->GET_POSITION(); //
            $data['DISP_MRTL_STAT']           = $this->employees_model->GET_MARITAL();
            $data['DISP_NATIONALITY']         = $this->employees_model->GET_NATIONALITY();
            $data['DISP_SHRT_SIZE']           = $this->employees_model->GET_SHIRT_SIZE();
            $data['DISP_SECTION']             = $this->employees_model->GET_SECTIONS();
            $data['DISP_GROUP']               = $this->employees_model->GET_GROUPS();
            $data['DISP_LINE']                = $this->employees_model->GET_LINES();

            $data['DISP_VIEW_DEPARTMENT']     = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_SECTION']        = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_GROUP']          = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_LINE']           = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            $this->load->view('templates/header');
            $this->load->view('modules/employees/new_employee_views', $data);
        }
        function add_new_employee()
        {
            $empl_cmid                      = htmlentities($this->input->post('empl_cmid'));
            $last_name                      = ucfirst(htmlentities($this->input->post('last_name')));
            $middle_name                    = ucfirst(htmlentities($this->input->post('middle_name')));
            $first_name                     = ucfirst(htmlentities($this->input->post('first_name')));
            $email                          = htmlentities($this->input->post('email'));
            $birthday                       = htmlentities($this->input->post('birthday'));
            $gender                         = htmlentities($this->input->post('gender'));
            $mobile_num                     = htmlentities($this->input->post('mobile_num'));
            $hired_on                       = htmlentities($this->input->post('hired_on'));
            $empl_type                      = htmlentities($this->input->post('empl_type'));
            $position                       = htmlentities($this->input->post('position'));
            $department                     = htmlentities($this->input->post('department'));
            $section                        = htmlentities($this->input->post('section'));
            $group                          = htmlentities($this->input->post('group'));
            $line                           = htmlentities($this->input->post('line'));
            $home_address                   = htmlentities($this->input->post('home_address'));
            $current_address                = htmlentities($this->input->post('current_address'));
            $marital_status                 = htmlentities($this->input->post('marital_status'));
            $nationality                    = htmlentities($this->input->post('nationality'));
            $shirt_size                     = htmlentities($this->input->post('shirt_size'));
            $salary_rate                    = htmlentities($this->input->post('salary_rate'));
            $salary_type                    = htmlentities($this->input->post('salary_type'));
            // get user profile image

            $check_cmid                     = $this->employees_model->GET_EMPL_CMID($empl_cmid);

            if ($check_cmid > 0) {
                $this->session->set_userdata('SESS_ERROR_INSRT', 'Employee number already exists!');
                redirect('employees/directories');
                return;
            }

            $get_image_name                 = $_FILES['employee_image']['name'];
            $userID                         = $this->employees_model->MOD_INSRT_EMPLOYEE($empl_cmid, $last_name, $middle_name, $first_name, $email, $birthday, $gender, $mobile_num, $hired_on, $empl_type, $position, $department, $section, $group, $line, $home_address, $current_address, $marital_status, $nationality, $shirt_size, $salary_rate, $salary_type);
            // set uploading file config


            $config['upload_path']      = './assets_user/user_profile';
            $config['allowed_types']    = 'gif|jpg|png|jpeg';
            $config['max_size']         = '5000';
            $config['file_name']        = $userID . $get_image_name;
            $config['overwrite']        = 'TRUE';
            $this->load->library('upload', $config);

            if ($_FILES['employee_image']['size'] != 0) {
                if ($this->upload->do_upload('employee_image')) {
                    $data_upload    = array('employee_image' => $this->upload->data());
                    $user_img       = $data_upload['employee_image']['file_name'];
                    $this->employees_model->INSERT_EMPLOYEE_IMAGE($user_img, $userID);

                    // $date1 = '01/1/2021';
                    // $date2 = '12/31/2021';
                    // $start_date = date("Y-m-d", strtotime($date1));
                    // $end_date =  date("Y-m-d", strtotime($date2));
                    // $startTime = strtotime($start_date);
                    // $endTime = strtotime($end_date);
                    // $weeks = array();
                    // while ($startTime <= $endTime) {  
                    //     $weeks[] = date('Y-m-d', $startTime); 
                    //     $startTime += strtotime('+1 day', 0);
                    // }
                    // foreach($weeks as $weeks_row){
                    //     $this->generate_row_model->MOD_INSRT_EACH_DATE($weeks_row,$userID);
                    // }


                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added new employee');
                    $this->session->set_userdata('SESS_SUCC_INSRT', 'New Employee was added successfully!');
                    redirect('employees/directories');
                }
            }

            // else {
            //     $this->session->set_userdata('SESS_ERR_IMAGE', 'No employee photo was selected');
            //     redirect('employees/directories');
            // }

            if ($userID) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added new employee');
                $this->session->set_userdata('SESS_SUCC_INSRT', 'New Employee was added successfully!');
                redirect('employees/directories');
            }
        }
        function edit_image()
        {
            $userID                     = $this->input->post('INSRT_EMPL_ID');
            $url_directory              = $this->input->post('URL_DIRECTORY');
            $input_data                 = $this->input->post();
            $this->employees_model->INSERT_EMPLOYEE_IMAGE($input_data['user_image'], $userID);
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated employee photo');
            $this->session->set_userdata('SESS_SUCC_UPDT_IMG', 'Profile Updated!');
            echo "<script>window.location.href='" . base_url() . "employees/" . $url_directory . "?id=" . $userID . "'</script>";
            return;
            // set uploading file config
            $config['upload_path']      = './assets_user/user_profile';
            $config['allowed_types']    = 'jpg|png|jpeg';
            $config['max_size']         = '5000';
            $config['file_name']        = $userID;
            $config['overwrite']        = 'TRUE';
            $this->load->library('upload', $config);
            if ($_FILES['employee_image']['size'] != 0) {
                if ($this->upload->do_upload('employee_image')) {
                    $data_upload        = array('employee_image' => $this->upload->data());
                    $user_img           = $data_upload['employee_image']['file_name'];
                    $this->employees_model->INSERT_EMPLOYEE_IMAGE($user_img, $userID);
                    $this->session->set_userdata('SESS_SUCC_UPDT_IMG', 'Profile Updated!');
                    echo "<script>window.location.href='" . base_url() . "employees/" . $url_directory . "?id=" . $userID . "'</script>";
                }
            } else {
                $this->session->set_userdata('SESS_ERR_IMAGE', 'No employee photo was selected');
                echo "<script>window.location.href='" . base_url() . "employees/" . $url_directory . "?id=" . $userID . "'</script>";
            }
        }
        function get_filter_data()
        {
            $department = '';
            $section    = '';
            $group      = '';
            $line       = '';
            $status     = '';
            if ($this->input->post('department') != '') {
                $department = "col_empl_dept='" . $this->input->post('department') . "'";
            } else {
                $department = '1=1';
            }
            if ($this->input->post('section') != '') {
                $section    = "col_empl_sect='" . $this->input->post('section') . "'";
            } else {
                $section    = '1=1';
            }
            if ($this->input->post('group') != '') {
                $group      = "col_empl_group='" . $this->input->post('group') . "'";
            } else {
                $group      = '1=1';
            }
            if ($this->input->post('line') != '') {
                $line       = "col_empl_line='" . $this->input->post('line') . "'";
            } else {
                $line       = '1=1';
            }
            $status         = "disabled=" . $this->input->post('status');
            $data           = $this->employees_model->MOD_GET_FILTER_DATA($department, $line, $group, $section, $status);
            echo (json_encode($data));
        }
        function get_filter_data_department()
        {
            $department     = '';
            $section        = '';
            $group          = '';
            $line           = '';
            $status         = '';
            if ($this->input->post('department') != '') {
                $department = "col_empl_dept='" . $this->input->post('department') . "'";
            } else {
                $department = '1=1';
            }
            if ($this->input->post('section') != '') {
                $section    = "col_empl_sect='" . $this->input->post('section') . "'";
            } else {
                $section    = '1=1';
            }
            if ($this->input->post('group') != '') {
                $group      = "col_empl_group='" . $this->input->post('group') . "'";
            } else {
                $group      = '1=1';
            }
            if ($this->input->post('line') != '') {
                $line       = "col_empl_line='" . $this->input->post('line') . "'";
            } else {
                $line       = '1=1';
            }
            $status         = "disabled=" . $this->input->post('status');
            $data           = $this->employees_model->MOD_GET_FILTER_DATA_DEPARTMENT($department, $line, $group, $section, $status);
            echo (json_encode($data));
        }
        function get_filter_data_section()
        {
            $department     = '';
            $section        = '';
            $group          = '';
            $line           = '';
            $status         = '';
            if ($this->input->post('department') != '') {
                $department = "col_empl_dept='" . $this->input->post('department') . "'";
            } else {
                $department = '1=1';
            }
            if ($this->input->post('section') != '') {
                $section    = "col_empl_sect='" . $this->input->post('section') . "'";
            } else {
                $section    = '1=1';
            }
            if ($this->input->post('group') != '') {
                $group      = "col_empl_group='" . $this->input->post('group') . "'";
            } else {
                $group      = '1=1';
            }
            if ($this->input->post('line') != '') {
                $line       = "col_empl_line='" . $this->input->post('line') . "'";
            } else {
                $line       = '1=1';
            }
            $status         = "disabled=" . $this->input->post('status');
            $data           = $this->employees_model->MOD_GET_FILTER_DATA_SECTION($department, $line, $group, $section, $status);
            echo (json_encode($data));
        }
        function get_filter_data_group()
        {
            $department     = '';
            $section        = '';
            $group          = '';
            $line           = '';
            $status         = '';
            if ($this->input->post('department') != '') {
                $department = "col_empl_dept='" . $this->input->post('department') . "'";
            } else {
                $department = '1=1';
            }
            if ($this->input->post('section') != '') {
                $section    = "col_empl_sect='" . $this->input->post('section') . "'";
            } else {
                $section    = '1=1';
            }
            if ($this->input->post('group') != '') {
                $group      = "col_empl_group='" . $this->input->post('group') . "'";
            } else {
                $group      = '1=1';
            }
            if ($this->input->post('line') != '') {
                $line       = "col_empl_line='" . $this->input->post('line') . "'";
            } else {
                $line       = '1=1';
            }
            $status         = "disabled=" . $this->input->post('status');
            $data           = $this->employees_model->MOD_GET_FILTER_DATA_GROUP($department, $line, $group, $section, $status);
            echo (json_encode($data));
        }
        function get_filter_data_line()
        {
            $department     = '';
            $section        = '';
            $group          = '';
            $line           = '';
            $status         = '';
            if ($this->input->post('department') != '') {
                $department = "col_empl_dept='" . $this->input->post('department') . "'";
            } else {
                $department = '1=1';
            }
            if ($this->input->post('section') != '') {
                $section    = "col_empl_sect='" . $this->input->post('section') . "'";
            } else {
                $section    = '1=1';
            }
            if ($this->input->post('group') != '') {
                $group      = "col_empl_group='" . $this->input->post('group') . "'";
            } else {
                $group      = '1=1';
            }
            if ($this->input->post('line') != '') {
                $line       = "col_empl_line='" . $this->input->post('line') . "'";
            } else {
                $line       = '1=1';
            }
            $status         = "disabled=" . $this->input->post('status');
            $data           = $this->employees_model->MOD_GET_FILTER_DATA_LINE($department, $line, $group, $section, $status);
            echo (json_encode($data));
        }
        function get_all_filter_data()
        {
            $data['DISP_DISTINCT_DEPARTMENT']       = $this->p164_department_mod->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_SECTION']          = $this->p165_section_mod->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_Group']                     = $this->p162_group_mod->MOD_DISP_DISTICT_Group();
            $data['DISP_Line']                      = $this->p160_line_views->MOD_DISP_DISTINCT_line();
            echo (json_encode($data));
        }


        // ========================================== PERSONAL TAB =============================================
        function personal()
        {
            $employee_id                        = $this->input->get('id');
            $data['messageError']               = $this->input->get('messageError');
            $data['DATE_FORMAT']                = $this->employees_model->GET_SYSTEM_SETTINGS("date_format");
            $data["C_COM_STRUCTURE"]            = $this->employees_model->GET_COMP_STRUCTURE();
            $data['DISP_VIEW_COMPANY']          = $this->employees_model->GET_SYSTEM_SETTING("com_company");

            $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
            $data['C_POSITIONS']                = $this->employees_model->GET_POSITION_ACTIVE();
            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_COMPANIES']                = $this->employees_model->GET_COMPANIES();
            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_RESIGNATION_REASONS']        = $this->employees_model->GET_RESIGNATION_REASONS();
            $data['C_TERMINATION_REASONS']        = $this->employees_model->GET_TERMINATION_REASONS();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_GENDERS']                  = $this->employees_model->GET_GENDERS();
            $data['C_NATIONALITY']              = $this->employees_model->GET_NATIONALITY();
            $data['C_MARITAL']                  = $this->employees_model->GET_MARITAL();
            $data['C_SHIRT_SIZE']               = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_HMO']                      = $this->employees_model->GET_HMO();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
            $data['C_EDUCATION']                = $this->employees_model->GET_EDUCATION_SPECIFIC($employee_id);
            $data['C_SKILLS_MATRIX']            = $this->employees_model->GET_SKILL_MATRIX_SPECIFIC($employee_id);
            $data['C_WORK_HISTORY']            = $this->employees_model->GET_WORK_HISTORY_SPECIFIC($employee_id);
            $data['C_SKILLS_NAME']              = $this->employees_model->GET_SKILL_NAME();
            $data['C_SKILLS_LEVEL']             = $this->employees_model->GET_SKILL_LEVEL();

            $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);
            $data['C_DEPENDENTS']               = $this->employees_model->GET_DEPENDENTS_SPECIFIC($employee_id);
            $data['C_EMERGENCY']                = $this->employees_model->GET_EMERGENCY_SPECIFIC($employee_id);
            $data['C_DOCUMENTS']                = $this->employees_model->GET_DOCUMENTS_SPECIFIC($employee_id);
            $data['C_LOGS']                     = $this->employees_model->GET_EMPLOYEE_LOGS_SPECIFIC($employee_id);
            $data['C_REQUIREMENTS']             = $this->employees_model->GET_EMPLOYEE_REQUIREMENTS_BY_ID($employee_id);
            $data['C_OTHER_DETAILS']           = $this->employees_model->GET_EMPL_OTHER_INFO($employee_id);

            // echo "<pre>";
            //     var_dump($data['C_REQUIREMENTS']); 
            // echo "</pre>";
            // return;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/employee_personal_views', $data);
        }

        // ========================================== UPDATE PERSONAL DETAIL =============================================

        function edit_personal_detail($employee_id)
        {

            $data['C_SHIRT_SIZE']               = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_GENDERS']                  = $this->employees_model->GET_GENDERS();
            $data['C_MARITAL']                  = $this->employees_model->GET_MARITAL();
            $data['C_NATIONALITY']              = $this->employees_model->GET_NATIONALITY();
            $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);

            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_personal_detail_views', $data);
        }
        function edit_other_detail($employee_id)
        {
            $data['user_id']                = $employee_id;
            $data['SETTINGS']               = $this->employees_model->GET_STD_SETTINGS('tbl_std_custominfo');
            $data['EMPL_OTHER_INFO']        = $this->employees_model->GET_EMPL_OTHER_DATA_INFO($employee_id);
            $data['EMPL_CUSTOM_INFO_ID']    = array();
            foreach ($data['EMPL_OTHER_INFO'] as $key => $info) {
                $data['EMPL_CUSTOM_INFO_ID'][] = $info->custom_info_id;
            }
            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_other_detail_views', $data);
        }
        function customize_form_field()
        {
            $input_data = $this->input->post();
            $custom_id  = isset($input_data['fields']) ? $input_data['fields'] : array(0);
            $empl_id    = isset($input_data['empl_id']) ? $input_data['empl_id'] : 0;
            $empl_field = $this->employees_model->GET_EMPL_OTHER_INFO_FIELD($empl_id, $custom_id);
            $str = "";
            $index = 0;
            foreach ($empl_field as $field) {
                $str .= "<div class='form-group'>" .
                    "<label class='required'>" . $field->field . "</label>" .
                    "<input type='hidden' name='field_data[$index][empl_id]' value='$empl_id' />" .
                    "<input type='hidden' name='field_data[$index][custom_info_id]' value='" . $field->id . "' />" .
                    "<input type='text' required class='form-control' name='field_data[$index][value]' value='" . $field->value . "' >" .
                    "</div>";
                $index += 1;
            }
            echo $str;
        }
        function update_other_details()
        {
            $input_data = $this->input->post();
            $empl_id = $input_data['empl_id'];
            if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                redirect($this->input->server('HTTP_REFERER'));
            }
            $is_deleted = $this->employees_model->DELETE_EMPL_CUSTOMIZE_FIELD($empl_id);
            if ($is_deleted && isset($input_data["field_data"])) {
                $res = $this->employees_model->ADD_EMPL_CUSTOMIZE_FIELD($input_data["field_data"]);
                if ($res) {
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated other details for employee ID: ' . $empl_id);
                    $this->session->set_flashdata('SUCC', 'Successfully Updated Custom Fields');
                } else {
                    $this->session->set_flashdata('ERR', 'Unable to save informations');
                }
            }
            redirect($this->input->server('HTTP_REFERER'));
        }

        function update_personal_detail()
        {

            $user_id                            = $this->input->post('user_id');
            $first_name                         = $this->input->post('UPDATE_FIRSTNAME');
            $middlename                         = $this->input->post('UPDATE_MIDDLENAME');
            $lastname                           = $this->input->post('UPDATE_LASTNAME');
            $marital_status                     = $this->input->post('UPDATE_MART_STAT');
            $mobile_number                      = $this->input->post('UPDATE_MOB_NUM');
            $birthdate                          = $this->input->post('UPDATE_BIRTHDATE');
            $gender                             = $this->input->post('UPDATE_GENDER');
            $nationality                        = $this->input->post('UPDATE_NATIONALITY');
            $shirt_size                         = $this->input->post('UPDATE_SHIRT_SIZE');
            $email                              = $this->input->post('UPDATE_EMAIL');
            $home_address                       = $this->input->post('UPDATE_HOME_ADD');
            $current_address                    = $this->input->post('UPDATE_CURRENT_ADD');

            $old = $this->employees_model->GET_EMPLOYEE_SPECIFIC($user_id);

            $new = [];
            foreach ($old[0] as $key => $value) {
                if ($key == "col_frst_name" && !empty($first_name) && $value != $first_name) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $first_name,
                    ]);
                }
                if ($key == "col_midl_name" && !empty($middlename) && $value != $middlename) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $middlename,
                    ]);
                }
                if ($key == "col_last_name" && !empty($lastname) && $value != $lastname) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $lastname,
                    ]);
                }
                if ($key == "col_mart_stat" && !empty($marital_status) && $value != $marital_status) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_MARITAL(), 'name', $value),
                        returnString($this->employees_model->GET_MARITAL(), 'name', $marital_status),
                    ]);
                }
                if ($key == "col_mobl_numb" && !empty($mobile_number) && $value != $mobile_number) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $mobile_number,
                    ]);
                }
                if ($key == "col_birt_date" && !empty($birthdate) && $value != $birthdate) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $birthdate,
                    ]);
                }
                if ($key == "col_empl_gend" && !empty($gender) && $value != $gender) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_GENDERS(), 'name', $value),
                        returnString($this->employees_model->GET_GENDERS(), 'name', $gender),
                    ]);
                }
                if ($key == "col_empl_nati" && !empty($nationality) && $value != $nationality) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_NATIONALITY(), 'name', $value),
                        returnString($this->employees_model->GET_NATIONALITY(), 'name', $nationality),
                    ]);
                }
                if ($key == "col_shir_size" && !empty($shirt_size) && $value != $shirt_size) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_SHIRT_SIZE(), 'name', $value),
                        returnString($this->employees_model->GET_SHIRT_SIZE(), 'name', $shirt_size),
                    ]);
                }
                if ($key == "col_empl_emai" && !empty($email) && $value != $email) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $email,
                    ]);
                }
                if ($key == "col_home_addr" && !empty($home_address) && $value != $home_address) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $home_address,
                    ]);
                }
                if ($key == "col_curr_addr" && !empty($current_address) && $value != $current_address) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $current_address,
                    ]);
                }
            }

            if (empty($new)) {
                $this->session->set_flashdata('SUCC', 'Personal details No Changes!');
                redirect('employees/personal?id=' . $user_id);
            } else {
                $this->employees_model->UPDATE_PERSONAL_DET($first_name, $middlename, $lastname, $marital_status, $mobile_number, $birthdate, $gender, $nationality, $shirt_size, $email, $home_address, $current_address, $user_id);
                $edit_id = $this->session->userdata('SESS_USER_ID');
                $empl_id = $user_id;
                try {
                    foreach ($new as $new_row) {
                        $category = $new_row[0];
                        $from_val = $new_row[1];
                        $to_val = $new_row[2];
                        $this->employees_model->ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val);
                    }
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated personal details for employee ID: ' . $user_id);
                    $this->session->set_flashdata('SUCC', 'Personal details updated successfully!');
                    redirect('employees/personal?id=' . $user_id);
                    // redirect('employees/edit_personal_detail/'.$user_id);
                } catch (Exception $e) {
                    $this->session->set_flashdata('SUCC', 'Personal details updated successfully!. But Log update error: ' . $e->getMessage());
                    redirect('employees/personal?id=' . $user_id);
                }
            }
        }

        // ========================================== UPDATE EMPLOYMENT DETAL =============================================

        function edit_employment_detail($employee_id)
        {
            $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
            $data['C_POSITIONS']                = $this->employees_model->GET_POSITION_ACTIVE();
            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
            $data['C_CLUBHOUSE']                = $this->employees_model->GET_CLUBHOUSE();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_RESIGNATION_REASONS']      = $this->employees_model->GET_RESIGNATION_REASONS();
            $data['C_TERMINATION_REASONS']      = $this->employees_model->GET_TERMINATION_REASONS();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
            $data['C_HMO']                      = $this->employees_model->GET_HMO();
            $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);

            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_employment_detail_views', $data);
        }

        function update_employment_detail()
        {
            $input_data = $this->input->post();
            // echo '<pre>';
            // print_r($input_data);
            // echo '<pre>';
            $user_id                            = $this->input->post('user_id');
            $hired_date                         = $this->input->post('UPDATE_HIRED_DATE');
            $reg_date                           = $this->input->post('UPDATE_REGULAR_DATE');
            $resign_Date                        = $this->input->post('UPDATE_RESIGN_DATE');
            $end_date                           = $this->input->post('UPDATE_END');
            $termination_date                   = $this->input->post('TERMINATION_DATE');
            $emp_type                           = $this->input->post('UPDATE_EMP_TYPE');
            $position                           = $this->input->post('UPDATE_POSITION');
            $resignation_reason                 = $this->input->post('RESIGNATION_REASON');
            $termination_reason                 = $this->input->post('TERMINATION_REASON');
            $branch                             = $this->input->post('UPDATE_BRANCH');
            $dept                               = $this->input->post('UPDATE_DEPARTMENT');
            $division                           = $this->input->post('UPDATE_DIVISION');
            $clubhouse                          = $this->input->post('UPDATE_CLUBHOUSE');
            $sec                                = $this->input->post('UPDATE_SECTION');
            $group                              = $this->input->post('UPDATE_GROUPS');
            $line                               = $this->input->post('UPDATE_LINE');
            $team                               = $this->input->post('UPDATE_TEAM');
            $com_num                            = $this->input->post('UPDATE_COMP_NUM');
            $com_email                          = $this->input->post('UPDATE_COMP_EMAIL');
            $hmo_prov                           = $this->input->post('UPDATE_HMO_PROV');
            $hmo_num                            = $this->input->post('UPDATE_HMO_NUM');

            $old = $this->employees_model->GET_EMPLOYEE_SPECIFIC($user_id);

            $new = [];
            foreach ($old[0] as $key => $value) {
                if ($key == "termination_reason" && !empty($termination_reason) && $value != $termination_reason) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_TERMINATION_REASONS(), 'name', $value),
                        returnString($this->employees_model->GET_TERMINATION_REASONS(), 'name', $termination_reason),
                    ]);
                }
                if ($key == "resignation_reason" && !empty($resignation_reason) && $value != $resignation_reason) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_RESIGNATION_REASONS(), 'name', $value),
                        returnString($this->employees_model->GET_RESIGNATION_REASONS(), 'name', $resignation_reason),
                    ]);
                }
                if ($key == "termination_date" && !empty($termination_date) && $value != $termination_date) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $termination_date,
                    ]);
                }
                if ($key == "col_hire_date" && !empty($hired_date) && $value != $hired_date) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $hired_date,
                    ]);
                }
                if ($key == "date_regular" && !empty($reg_date) && $value != $reg_date) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $reg_date,
                    ]);
                }
                if ($key == "resignation_date" && !empty($resign_Date) && $value != $resign_Date) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $resign_Date,
                    ]);
                }
                if ($key == "col_endd_date" && !empty($end_date) && $value != $end_date) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $end_date,
                    ]);
                }
                if ($key == "col_empl_type" && !empty($emp_type) && $value != $emp_type) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_TYPE(), 'name', $value),
                        returnString($this->employees_model->GET_TYPE(), 'name', $emp_type),
                    ]);
                }
                if ($key == "col_empl_posi" && !empty($position) && $value != $position) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_POSITION(), 'name', $value),
                        returnString($this->employees_model->GET_POSITION(), 'name', $position),
                    ]);
                }
                if ($key == "col_empl_branch" && !empty($branch) && $value != $branch) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_BRANCHES(), 'name', $value),
                        returnString($this->employees_model->GET_BRANCHES(), 'name', $branch),
                    ]);
                }
                if ($key == "col_empl_dept" && !empty($dept) && $value != $dept) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_DEPARTMENTS(), 'name', $value),
                        returnString($this->employees_model->GET_DEPARTMENTS(), 'name', $dept),
                    ]);
                }
                if ($key == "col_empl_divi" && !empty($division) && $value != $division) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_DIVISIONS(), 'name', $value),
                        returnString($this->employees_model->GET_DIVISIONS(), 'name', $division),
                    ]);
                }
                if ($key == "col_empl_club" && !empty($clubhouse) && $value != $clubhouse) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_CLUBHOUSE(), 'name', $value),
                        returnString($this->employees_model->GET_CLUBHOUSE(), 'name', $clubhouse),
                    ]);
                }
                if ($key == "col_empl_sect" && !empty($sec) && $value != $sec) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_SECTIONS(), 'name', $value),
                        returnString($this->employees_model->GET_SECTIONS(), 'name', $sec),
                    ]);
                }
                if ($key == "col_empl_group" && !empty($group) && $value != $group) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_GROUPS(), 'name', $value),
                        returnString($this->employees_model->GET_GROUPS(), 'name', $group),
                    ]);
                }
                if ($key == "col_empl_line" && !empty($line) && $value != $line) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_LINES(), 'name', $value),
                        returnString($this->employees_model->GET_LINES(), 'name', $line),
                    ]);
                }
                if ($key == "col_empl_team" && !empty($team) && $value != $team) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_TEAMS(), 'name', $value),
                        returnString($this->employees_model->GET_TEAMS(), 'name', $team),
                    ]);
                }
                if ($key == "col_comp_numb" && !empty($com_num) && $value != $com_num) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $com_num,
                    ]);
                }
                if ($key == "col_comp_emai" && !empty($com_email) && $value != $com_email) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $com_email,
                    ]);
                }
                if ($key == "col_empl_hmoo" && !empty($hmo_prov) && $value != $hmo_prov) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        returnString($this->employees_model->GET_HMO(), 'name', $value),
                        returnString($this->employees_model->GET_HMO(), 'name', $hmo_prov),
                    ]);
                }
                if ($key == "col_empl_hmon" && !empty($hmo_num) && $value != $hmo_num) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $hmo_num,
                    ]);
                }
            }

            if (empty($new)) {
                $this->session->set_flashdata('SUCC', 'Employment details No Changes!');
                redirect('employees/personal?id=' . $user_id);
            } else {
                $this->employees_model->UPDATE_EMPLOYMENT_DET($hired_date, $reg_date, $resign_Date, $end_date, $emp_type, $position, $branch, $dept, $division, $clubhouse, $sec, $group, $line, $team, $com_num, $com_email, $hmo_prov, $hmo_num, $termination_reason, $resignation_reason, $termination_date, $user_id);
                //    echo '<pre>';
                // 	var_dump($position);
                //    return;
                $edit_id = $this->session->userdata('SESS_USER_ID');
                $empl_id = $user_id;
                try {
                    foreach ($new as $new_row) {
                        $category = $new_row[0];
                        $from_val = $new_row[1];
                        $to_val = $new_row[2];
                        $this->employees_model->ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val);
                    }
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated employment details for employee ID: ' . $user_id);
                    $this->session->set_flashdata('SUCC', 'Employment details updated successfully!');
                    redirect('employees/personal?id=' . $user_id);
                } catch (Exception $e) {
                    $this->session->set_flashdata('SUCC', 'Employment details updated successfully!. But Log update error: ' . $e->getMessage());
                    redirect('employees/personal?id=' . $user_id);
                }
            }
        }

        // ========================================== UPDATE ID DETAL =============================================

        function edit_id_detail($employee_id)
        {

            $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);

            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_id_detail_views', $data);
        }

        function update_id_detail()
        {
            $user_id                            = $this->input->post('user_id');
            $sss                                = $this->input->post('UPDATE_SSS');
            $hdmf                               = $this->input->post('UPDATE_HDMF');
            $philhealth                         = $this->input->post('UPDATE_PHILHEALTH');
            $tin                                = $this->input->post('UPDATE_TIN');
            $driver_lic                         = $this->input->post('UPDATE_DRIVER_LIC');
            $nat_id                             = $this->input->post('UPDATE_NAT_ID');
            $passport                           = $this->input->post('UPDATE_PASSPORT');

            $old = $this->employees_model->GET_EMPLOYEE_SPECIFIC($user_id);
            $new = [];
            foreach ($old[0] as $key => $value) {
                if ($key == "col_empl_sssc" && !empty($sss) && $value != $sss) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $sss,
                    ]);
                }
                if ($key == "col_empl_hdmf" && !empty($hdmf) && $value != $hdmf) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $hdmf,
                    ]);
                }
                if ($key == "col_empl_phil" && !empty($philhealth) && $value != $philhealth) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $philhealth,
                    ]);
                }
                if ($key == "col_empl_btin" && !empty($tin) && $value != $tin) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $tin,
                    ]);
                }
                if ($key == "col_empl_driv" && !empty($driver_lic) && $value != $driver_lic) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $driver_lic,
                    ]);
                }
                if ($key == "col_empl_naid" && !empty($nat_id) && $value != $nat_id) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $nat_id,
                    ]);
                }
                if ($key == "col_empl_pass" && !empty($passport) && $value != $passport) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $passport,
                    ]);
                }
            }

            if (empty($new)) {
                $this->session->set_flashdata('SUCC', 'ID details No Changes!');
                // echo '<pre>';
                // print_r('flashdata');
                // print_r($this->session->flashdata('SUCC'));
                // echo '<pre>';
                redirect('employees/personal?id=' . $user_id);
            } else {
                $this->employees_model->UPDATE_ID_DET($sss, $hdmf, $philhealth, $tin, $driver_lic, $nat_id, $passport, $user_id);
                $edit_id = $this->session->userdata('SESS_USER_ID');
                $empl_id = $user_id;
                try {
                    foreach ($new as $new_row) {
                        $category = $new_row[0];
                        $from_val = $new_row[1];
                        $to_val = $new_row[2];
                        $this->employees_model->ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val);
                    }
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated ID details for employee ID: ' . $user_id);
                    $this->session->set_flashdata('SUCC', 'ID details updated successfully!');
                    // echo '<pre>';
                    // print_r('flashdata');
                    // print_r( $this->session->flashdata('SUCC'));
                    // echo '<pre>';
                    redirect('employees/personal?id=' . $user_id);
                    // redirect('employees/edit_personal_detail/'.$user_id);
                } catch (Exception $e) {
                    $this->session->set_flashdata('SUCC', 'ID details updated successfully!. But Log update error: ' . $e->getMessage());
                    redirect('employees/personal?id=' . $user_id);
                }
            }
            // $this->session->set_userdata('SESS_SUCC_MSG', 'ID details updated successfully!');
            // redirect('employees/edit_id_detail/'.$user_id);
        }

        function user_activation($user_id, $is_disabled)
        {
            $response = $this->employees_model->SET_ACTIVATION_EMPLOYEE($user_id, $is_disabled);
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated user activation for employee ID: ' . $user_id);
            if ($response && $response['messageError']) {
                redirect("employees/personal?id=$user_id&messageError=" . $response['messageError']);
            }
            redirect("employees/personal?id=$user_id");
        }
        // ========================================== UPDATE COMPENSATION DETAL =============================================

        function edit_compensation_detail($employee_id)
        {

            $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);

            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_compen_detail_views', $data);
        }

        function update_comp_detail()
        {
            $user_id                            = $this->input->post('user_id');
            $salary_type                        = $this->input->post('UPDATE_SAL_TYPE');
            $salary_rate                        = $this->input->post('UPDATE_SAL_RATE');
            $bank                               = $this->input->post('UPDATE_BANK');
            $branch                             = $this->input->post('UPDATE_BRANCH');
            $acc_type                           = $this->input->post('UPDATE_ACC_TYPE');
            $payment_type                       = $this->input->post('UPDATE_PAY_TYPE');
            $acc_num                            = $this->input->post('UPDATE_ACC_NUMBER');

            $old = $this->employees_model->GET_EMPLOYEE_SPECIFIC($user_id);
            $new = [];
            foreach ($old[0] as $key => $value) {
                if ($key == "bank_name" && !empty($bank) && $value != $bank) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $bank,
                    ]);
                }
                if ($key == "branch_name" && !empty($branch) && $value != $branch) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $branch,
                    ]);
                }
                if ($key == "account_type" && !empty($acc_type) && $value != $acc_type) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $acc_type,
                    ]);
                }
                if ($key == "payment_type" && !empty($payment_type) && $value != $payment_type) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $payment_type,
                    ]);
                }
                if ($key == "account_number" && !empty($acc_num) && $value != $acc_num) {
                    array_push($new, [
                        $this->employees_model->columnCategory($key),
                        $value,
                        $acc_num,
                    ]);
                }
            }

            if (empty($new)) {
                $this->session->set_flashdata('SUCC', 'Compensation details No Changes!');
                redirect('employees/personal?id=' . $user_id);
            } else {
                $this->employees_model->UPDATE_COMP_DET($salary_type, $salary_rate, $bank, $branch, $acc_type, $payment_type, $acc_num, $user_id);
                $edit_id = $this->session->userdata('SESS_USER_ID');
                $empl_id = $user_id;
                try {
                    foreach ($new as $new_row) {
                        $category = $new_row[0];
                        $from_val = $new_row[1];
                        $to_val = $new_row[2];
                        $this->employees_model->ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val);
                    }
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated compensation for employee ID: ' . $user_id);
                    $this->session->set_flashdata('SUCC', 'Compensation details updated successfully!');
                    redirect('employees/personal?id=' . $user_id);
                } catch (Exception $e) {
                    $this->session->set_flashdata('SUCC', 'Compensation details updated successfully!. But Log update error: ' . $e->getMessage());
                    redirect('employees/personal?id=' . $user_id);
                }
            }
            // redirect('employees/edit_compensation_detail/'.$user_id);
        }

        // ========================================== UPDATE EDUCATION DETAL =============================================
        function add_education($user_id)
        {
            $data['C_EMP_ID']                   = $user_id;
            $data['C_EDUCATION']                = array();
            $data["C_CURRENT_PAGE"]             = "Add Education";
            $data['C_FUNCTION']                 = 'save_new_education';

            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_educ_detail_views', $data);
        }
        function save_new_education()
        {

            $user_id                            = $this->input->post('user_id');
            $educ_id                            = $this->input->post('educ_id');
            $degree                             = $this->input->post('DEGREE');
            $school                             = $this->input->post('SCHOOL');
            $address                            = $this->input->post('ADDRESS');
            $from_yr                            = $this->input->post('FROM_YR');
            $to_yr                              = $this->input->post('TO_YR');
            $completion                         = $this->input->post('COMPLETION');
            $grade                              = $this->input->post('GRADE');
            $level                              = $this->input->post('LEVEL');

            $res                                = $this->employees_model->ADD_NEW_EDUC($degree, $school, $address, $from_yr, $to_yr, $completion, $user_id, $grade, $level);
            $isAdmin                            = $this->session->userdata('SESS_ADMIN');
            $log_mgs                            = $isAdmin == 1 ? 'Added education(Admin)' : 'Added education';

            if ($res) {

                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SUCC', "Education details successfully added!");
            } else {

                $log_mgs = $isAdmin == 1 ? 'Fail to add education(Admin)' : 'Fail to add education';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('ERR', 'Fail to Add!');
            }

            redirect('employees/personal?id=' . $user_id);
        }

        function edit_educ_detail($id, $user_id)
        {
            $data['C_EMP_ID']                   = $user_id;
            $data['C_EDUCATION']                = $this->employees_model->GET_EDUCATION_SPECIFIC2($id);
            $data["C_CURRENT_PAGE"]             = "Edit Education Details";
            $data['C_FUNCTION'] = 'update_educ_detail';
            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_educ_detail_views', $data);
        }

        function update_educ_detail()
        {
            $user_id                            = $this->input->post('user_id');
            $educ_id                            = $this->input->post('educ_id');
            $degree                             = $this->input->post('DEGREE');
            $school                             = $this->input->post('SCHOOL');
            $address                            = $this->input->post('ADDRESS');
            $from_yr                            = $this->input->post('FROM_YR');
            $to_yr                              = $this->input->post('TO_YR');
            $completion                         = $this->input->post('COMPLETION');
            $grade                              = $this->input->post('GRADE');
            $level                              = $this->input->post('LEVEL');

            $res = $this->employees_model->UPDATE_EDUC_DET($degree, $school, $address, $from_yr, $to_yr, $completion, $educ_id, $user_id, $grade, $level);

            $isAdmin = $this->session->userdata('SESS_ADMIN');
            $log_mgs = $isAdmin == 1 ? 'Updated education(Admin)' : 'Updated education';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SUCC', "Education details successfully updated!");
                redirect('employees/personal?id=' . $user_id);
            } else {
                $log_mgs = $isAdmin == 1 ? 'Fail to  update education(Admin)' : 'Fail to  update education';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('ERR', 'Fail to Update!');
                redirect('employees/personal?id=' . $user_id);
            }
        }
        function delete_empl_education($id)
        {
            $res = $this->employees_model->DELETE_EDUCATION($id);
            echo $res;
        }


        // ========================================== UPDATE SKILL DETAL =============================================
        function add_skills($user_id)
        {
            $data['C_SKILLS_NAME']              = $this->employees_model->GET_SKILL_NAME();
            $data['C_SKILLS_LEVEL']             = $this->employees_model->GET_SKILL_LEVEL();
            $data['C_FUNCTION']                 = "save_new_skill";
            $data['C_SKILLS_MATRIX']            = array();
            $data['C_EMP_ID']                   = $user_id;
            $data['C_current_page']             = 'Add New Skill';
            $data['C_FUNCTION']                 = "save_new_skill/" . $user_id;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_skill_detail_views', $data);
        }
        function save_new_skill($user_id)
        {
            $skill                          = $this->input->post('TITLE');
            $level                          = $this->input->post('LEVEL');
            $res                            = $this->employees_model->ADD_NEW_SKILL($user_id, $level, $skill);
            $isAdmin                        = $this->session->userdata('SESS_ADMIN');
            $log_mgs                        = $isAdmin == 1 ? 'Added new skill(Admin)' : 'Added new skill';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SUCC', "New Skill successfully added");
            } else {
                $log_mgs                    = $isAdmin == 1 ? 'Fail to add new skill(Admin)' : 'Fail to add new skill Skill';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('ERR', 'Fail to Delete!');
            }
            redirect('employees/personal?id=' . $user_id);
        }
        function edit_skill_detail($id, $user_id)
        {
            $data['C_EMP_ID']                   = $user_id;
            $data['C_SKILLS_MATRIX']            = $this->employees_model->GET_SKILL_MATRIX_SPECIFIC2($id);
            $data['C_SKILLS_NAME']              = $this->employees_model->GET_SKILL_NAME_ACTIVE();
            $data['C_SKILLS_LEVEL']             = $this->employees_model->GET_SKILL_LEVEL_ACTIVE();
            $data['C_current_page']             = 'Update Skill';
            $data['C_FUNCTION']                 = "update_skill_detail/" . $user_id;

            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_skill_detail_views', $data);
        }
        function delete_empl_skill($id)
        {
            $res = $this->employees_model->DELETE_EMPL_SKILL($id);
            $isAdmin                            = $this->session->userdata('SESS_ADMIN');
            $log_mgs                            = $isAdmin == 1 ? 'Deleted Skill(Admin)' : 'Deleted Skill';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
            } else {
                $log_mgs                        = $isAdmin == 1 ? 'Fail to Deleted Skill(Admin)' : 'Fail to Deleted Skill';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
            }
            echo $res;
        }
        function update_skill_detail($user_id)
        {

            $skill_id                           = $this->input->post('skill_id');
            $title                              = $this->input->post('TITLE');
            $level                              = $this->input->post('LEVEL');

            $res = $this->employees_model->UPDATE_SKILL_DET($title, $level, $skill_id);
            $isAdmin                            = $this->session->userdata('SESS_ADMIN');
            $log_mgs                            = $isAdmin == 1 ? 'Updated Skill(Admin)' : 'Updated Skill';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SUCC', "Skill updated successfully");
                redirect('employees/personal?id=' . $user_id);
            } else {
                $log_mgs                        = $isAdmin == 1 ? 'Fail to Update Skill(Admin)' : 'Fail to Updated Skill';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('ERR', 'Fail to Update!');
                redirect('employees/personal?id=' . $user_id);
            }
        }
        function work_history($userId)
        {

            $data['USER_ID'] = $userId;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/work_history_views', $data);
        }

        function add_documents($id)
        {
            $data["C_USER_ID"]                              = $id;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/add_document_views', $data);
        }
        function edit_requirements($id)
        {
            $data["C_USER_ID"]                              = $id;
            $data["user_id"]                              = $id;
            $data['C_REQUIREMENTS']                         = $this->employees_model->GET_EMPLOYEE_REQUIREMENTS_BY_ID($id);
            $this->load->view('templates/header');
            $this->load->view('modules/employees/edit_requirements_views', $data);
        }
        function save_edit_requirement_status()
        {
            $raw_post_data = file_get_contents("php://input");
            $id = $this->session->userdata('SESS_USER_ID');
            $data = json_decode($raw_post_data);
            if ($data === null) {
                $response = array('ERR' => 'Invalid JSON data');
                echo json_encode($response);
                return;
            }
            $requirement_id = $data->requirement_id;
            $std_id = $data->std_id;
            $status = $data->status;
            $empl_id = $data->empl_id;

            //     $data = array(
            //     'std_id' => $std_id,
            //     'requirement_id' => $requirement_id,
            //     'status' => $status,
            //     'empl_id' => $empl_id
            // );
            // echo json_encode($data);

            try {
                $message = 'No Insert, No Update';
                $res  = $this->employees_model->UPDATE_EMPL_REQUIREMENTS_STATUS($status, $requirement_id, $id);
                if ($res) {
                    $message = 'Update Successful';
                } else {
                    $res  = $this->employees_model->ADD_EMPL_REQUIREMENTS_STATUS($status, $id, $std_id, $empl_id);
                    $message = 'Add Successful';
                }
                $this->session->set_flashdata('SUCC', $message);
                $response = array(
                    'SUCC' => $message,
                );
                echo json_encode($response);
            } catch (Exception $e) {
                $response = array(
                    'ERR' => 'Failed to add requirement.' . $e->getMessage(),
                );
                echo json_encode($response);
            }
        }
        function save_edit_requirement()
        {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $std_id = $this->input->post('std_id');
                $requirement_id = $this->input->post('requirement_id');
                $empl_id = $this->input->post('empl_id');
                // $data = array(
                //     'std_id' => $std_id,
                //     'requirement_id' => $requirement_id,
                //     'empl_id' => $empl_id
                // );
                // echo json_encode($data);
                if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                    // $id=$this->input->post("user_id");
                    // $file_data                                  = $_FILES["document"];
                    $id = $this->session->userdata('SESS_USER_ID');
                    $file_data = $_FILES['file'];
                    $file_name                                  = $id . '_' . $file_data["name"];
                    $config['upload_path']                      = './assets_user/documents';
                    $config['allowed_types']                    = '*';
                    $config['file_name']                        =  $id . '_' . $file_data["name"];
                    $this->load->library('upload', $config);
                    if ($file_data['size'] != 0) {

                        if ($this->upload->do_upload('file')) {
                            $arr_filename                       =  explode(".", $file_data["name"]);
                            $upload_data                        = $this->upload->data();


                            try {
                                $message = 'No Insert, No Update';
                                $res  = $this->employees_model->UPDATE_EMPL_REQUIREMENTS_ATTACHMENT($upload_data['file_name'], $requirement_id, $id);
                                if ($res) {
                                    $message = 'Update Successful';
                                } else {
                                    $res  = $this->employees_model->ADD_EMPL_REQUIREMENTS_ATTACHMENT($upload_data['file_name'], $id, $std_id, $requirement_id, $empl_id);
                                    $message = 'Add Successful';
                                }
                                $this->session->set_flashdata('SUCC', $message);
                                $response = array(
                                    'SUCC' => $message,
                                );
                                echo json_encode($response);
                            } catch (Exception $e) {
                                $response = array(
                                    'ERR' => 'Failed to add requirement.' . $e->getMessage(),
                                );
                                echo json_encode($response);
                            }

                            // $isAdmin                            = $this->session->userdata('SESS_ADMIN');
                            // $log_mgs                            = $isAdmin==1 ?'Added new requirement(Admin)':'Added new requirement';
                            // if($res){
                            //     $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                            //     $this->session->set_flashdata('SUCC', "Added Successfully");
                            // }else{
                            //     $log_mgs                        = $isAdmin==1 ?'Fail to add new document(Admin)':'Fail to add new requirement';
                            //     $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                            //     $response = array(
                            //         'ERR' => 'Failed to add requirement.',
                            //     );
                            //     echo json_encode($response);
                            // }
                        }


                        // $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Added successfully new document");
                    } else {
                        $response = array(
                            'ERR' => 'No File.',
                        );
                        echo json_encode($response);
                        // $this->session->set_flashdata('ERR', 'No logo was selected');
                        // redirect('employees/add_documents/'.$id);
                        // $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Fail to add new document");
                    }
                } else {
                    $error_message = "An error occurred during file upload.";
                    switch ($_FILES['file']['error']) {
                        case UPLOAD_ERR_INI_SIZE:
                            $error_message = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                            break;
                        case UPLOAD_ERR_FORM_SIZE:
                            $error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                            break;
                    }
                    $response = [
                        'ERR' => $error_message,
                    ];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }

                // $response = array(
                //     'SUCC' => 'Data received and processed successfully.',
                // );
                // echo json_encode($response);
            } else {
                redirect('login/session_expired');
            }
        }
        function save_document()
        {

            $id = $this->input->post("user_id");
            $file_data                                  = $_FILES["document"];
            $file_name                                  = $id . '_' . $file_data["name"];
            $config['upload_path']                      = './assets_user/documents';
            $config['allowed_types']                    = '*';
            $config['file_name']                        =  $id . '_' . $file_data["name"];

            $this->load->library('upload', $config);
            if ($file_data['size'] != 0) {
                if ($this->upload->do_upload('document')) {
                    $arr_filename                       =  explode(".", $file_data["name"]);
                    $upload_data                        = $this->upload->data();

                    $res                                = $this->employees_model->ADD_EMPL_DOCUMENT($upload_data['file_name'], $upload_data['raw_name'], $id);
                    $isAdmin                            = $this->session->userdata('SESS_ADMIN');
                    $log_mgs                            = $isAdmin == 1 ? 'Added new document(Admin)' : 'Added new document';
                    if ($res) {
                        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                        $this->session->set_flashdata('SUCC', "Added Successfully");
                    } else {
                        $log_mgs                        = $isAdmin == 1 ? 'Fail to add new document(Admin)' : 'Fail to add new document';
                        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                        $this->session->set_flashdata('ERR', 'Fail to Add!');
                    }
                }

                $this->session->set_flashdata('SUCC', 'Added successfully new document');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), "Added successfully new document");
            } else {
                $this->session->set_flashdata('ERR', 'No logo was selected');
                // redirect('employees/add_documents/'.$id);
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), "Fail to add new document");
            }
            redirect('employees/personal?id=' . $id);
        }
        function delete_documents($id)
        {
            $res                                        = $this->employees_model->DELETE_EMPL_DOCUMENT($id);
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), "Successfully deleted document");
            } else {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), "Fail to delete document");
            }
            echo $res;
        }
        function download_document()
        {
            $isAdmin                                    = $this->session->userdata('SESS_ADMIN');
            $log_mgs                                    = $isAdmin == 1 ? 'Downloaded document(Admin)' : 'Downloaded document';
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
        }


        function add_emergency_contact($id)
        {
            $data["C_USER_ID"]      = $id;
            $data["current_page"]   = "Add Emergency Contact";
            $data["C_function"]     = "save_emergency_contact";
            $data["C_emergency_contact"] = array();
            $this->load->view('templates/header');
            $this->load->view('modules/employees/emergency_contact_views', $data);
        }
        function save_emergency_contact()
        {
            $empl_id                    = $this->input->post("user_id");
            $relation                   = $this->input->post("relation");
            $contact_name               = $this->input->post("fullname");
            $mobile_num                 = $this->input->post("mobile_number");
            $work_phone_number          = $this->input->post("work_phone");
            $home_phone_number          = $this->input->post("home_phone");
            $current_address            = $this->input->post("current_add");
            $res                        = $this->employees_model->ADD_EMERGENCY_CONTACT($empl_id, $relation, $contact_name, $mobile_num, $work_phone_number, $home_phone_number, $current_address);
            $isAdmin                    = $this->session->userdata('SESS_ADMIN');
            $log_mgs                    = $isAdmin == 1 ? 'Added new emergency contact(Admin)' : 'Added new emergency contact';
            if ($res) {
                $this->session->set_flashdata('SUCC', 'Emergency details added successfully!');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                redirect('employees/personal?id=' . $empl_id);
            } else {
                $log_mgs                = $isAdmin == 1 ? 'Fail to add new emergency contact(Admin)' : 'Fail to add new emergency contact';
                $this->session->set_flashdata('ERR', 'Fail to add!');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), "Fail to Add new emergency contact");
                redirect('employees/personal?id=' . $empl_id);
            }
        }
        function edit_emergency_contact($id, $user_id)
        {
            $data["C_USER_ID"] = $user_id;
            $data["C_ID"] = $id;
            $data["current_page"] = "Edit Emergency Contact";
            $data["C_function"] = "update_emergency_contact/" . $id;
            $data["C_emergency_contact"] = $this->employees_model->GET_EMERGENCY_SPECIFIC_BY_ID($id);
            // echo "<pre>";
            // var_dump($data["C_emergency_contact"]);
            // return;
            $this->load->view('templates/header');
            $this->load->view('modules/employees/emergency_contact_views', $data);
        }
        function update_emergency_contact($id)
        {
            $empl_id                = $this->input->post("user_id");
            $relation               = $this->input->post("relation");
            $contact_name           = $this->input->post("fullname");
            $mobile_num             = $this->input->post("mobile_number");
            $work_phone_number      = $this->input->post("work_phone");
            $home_phone_number      = $this->input->post("home_phone");
            $current_address        = $this->input->post("current_add");
            $res                    = $this->employees_model->UPDATE_EMERGENCY_CONTACT($id, $empl_id, $relation, $contact_name, $mobile_num, $work_phone_number, $home_phone_number, $current_address);
            $isAdmin                = $this->session->userdata('SESS_ADMIN');
            $log_mgs                = $isAdmin == 1 ? 'Updated emergency contact(Admin)' : 'Updated emergency contact';
            if ($res) {
                $this->session->set_flashdata('SUCC', 'Emergency details updated successfully!');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                redirect('employees/personal?id=' . $empl_id);
            } else {
                $log_mgs            = $isAdmin == 1 ? 'Fail to update emergency contact(Admin)' : 'Fail to update emergency contact';
                $this->session->set_flashdata('ERR', 'Fail to update!');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), "Fail to update emergency contact");
                redirect('employees/personal?id=' . $empl_id);
            }
        }
        function delete_emergency_contact($id, $user_id)
        {
            $res                        = $this->employees_model->DELETE_EMERGENCY_CONTACT($id);
            $isAdmin                    = $this->session->userdata('SESS_ADMIN');
            $log_mgs                    = $isAdmin == 1 ? 'Deleted emergency contact(Admin)' : 'Deleted emergency contact';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                echo 1;
            } else {
                $log_mgs                = $isAdmin == 1 ? 'Fail to delete emergency contact(Admin)' : 'Fail to delete emergency contact';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                echo 0;
            }
        }

        function setup_organization_old()
        {
            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["company"])) {
                $param_company  = "all";
            } else {
                $param_company   = $_GET["company"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }

            $data["C_ROW_DISPLAY"]                            =  [25, 50, 100];
            $page                                             = $this->input->get('page');
            $row                                              = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);

            $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
            $data['ALL_EMPLOYEES']                  = $this->employees_model->GET_ALL_EMPLOYEES();
            $data['DISP_YEARS']                        = $year_list = $this->employees_model->GET_YEARS();
            $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_company, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
            (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];

            $data['YEAR_INITIAL']                   = $year;
            $data["DISP_ALLOWANCE"]                      = $this->employees_model->GET_ALLOWANCE_TAX_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_COMPANY']       = $this->employees_model->MOD_DISP_DISTINCT_COMPANY();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");
            $data['DISP_VIEW_COMPANY']           = $this->employees_model->GET_SYSTEM_SETTING("com_company");

            $this->load->view('templates/header');
            $this->load->view('modules/employees/setup_organization_views', $data);
        }

        function setup_organization()
        {
            // $search                             = str_replace('_', ' ', $this->input->get('search') ?? "");

            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["company"])) {
                $param_company   = "all";
            } else {
                $param_company    = $_GET["company"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["clubhouse"])) {
                $param_clubhouse = "all";
            } else {
                $param_clubhouse  = $_GET["clubhouse"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }
            if (!isset($_GET["search"])) {
                $search   = "all";
            } else {
                $search    = $_GET["search"];
            }
            $data["C_ROW_DISPLAY"]                   =  [50];

            $page                                       = $this->input->get('page');
            $row                                        = $this->input->get('row');
            if ($row == null) {
                $row = 25;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);
            if (!$search || true) {
                // $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line,$param_company);
                $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_SETUP_ORGANIZATION_TABLE_COUNT($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company, $search);
                $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_SETUP_ORGANIZATION_TABLE_COUNT($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company, $search);

                $data['DISP_EMP_LIST_TABLE']            = $empl_list = $this->employees_model->GET_FILTERED_SETUP_ORGANIZATION_TABLE($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company, $search);
            } else {
                $data['DISP_EMP_LIST_TABLE']            = $this->employees_model->GET_SEARCHED_SALARY_DETAILS($search);
                $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED_SALARY_DETAILS($search));
            }

            $data['DISP_YEARS']                            = $year_list = $this->employees_model->GET_YEARS();


            (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];

            // $data["DISP_DEDUCTION"]		            = $this->employees_model->GET_DEDUCTION_TAX_DATA($year);

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_CLUBHOUSE']         = $this->employees_model->MOD_DISP_DISTINCT_CLUBHOUSE();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_COMPANY']           = $this->employees_model->MOD_DISP_DISTINCT_COMPANY();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_COMPANY']              = $this->employees_model->GET_SYSTEM_SETTING("com_company");
            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_CLUBHOUSE']            = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_SETUP_ORGANIZATION();
            foreach ($employeeSearchRaw as &$item) {
                $lastNameSuffix = $item->col_last_name;
                if (!empty($item->col_suffix)) {
                    $lastNameSuffix = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $lastNameSuffix . ', ' . $item->col_frst_name;
                if ($item->col_midl_name) {
                    $item->name = $item->col_empl_cmid . '-' . $lastNameSuffix . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name[0] . '.';
                }
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;
            // Search Employee List ends 

            $this->load->view('templates/header');
            $this->load->view('modules/employees/setup_organization_views', $data);
        }
        function custom_group_assignment()
        {
            if (!isset($_GET["branch"])) {
                $param_branch   = "all";
            } else {
                $param_branch    = $_GET["branch"];
            }
            if (!isset($_GET["company"])) {
                $param_company   = "all";
            } else {
                $param_company    = $_GET["company"];
            }
            if (!isset($_GET["dept"])) {
                $param_dept     = "all";
            } else {
                $param_dept      = $_GET["dept"];
            }
            if (!isset($_GET["division"])) {
                $param_division = "all";
            } else {
                $param_division  = $_GET["division"];
            }
            if (!isset($_GET["clubhouse"])) {
                $param_clubhouse = "all";
            } else {
                $param_clubhouse  = $_GET["clubhouse"];
            }
            if (!isset($_GET["section"])) {
                $param_section  = "all";
            } else {
                $param_section   = $_GET["section"];
            }
            if (!isset($_GET["group"])) {
                $param_group    = "all";
            } else {
                $param_group     = $_GET["group"];
            }
            if (!isset($_GET["team"])) {
                $param_team     = "all";
            } else {
                $param_team      = $_GET["team"];
            }
            if (!isset($_GET["line"])) {
                $param_line     = "all";
            } else {
                $param_line      = $_GET["line"];
            }
            if (!isset($_GET["status"])) {
                $param_status   = "all";
            } else {
                $param_status    = $_GET["status"];
            }
            if (!isset($_GET["search"])) {
                $search   = "all";
            } else {
                $search    = $_GET["search"];
            }
            $data["C_ROW_DISPLAY"]                   =  [50];
            $page                                       = $this->input->get('page');
            $row                                        = $this->input->get('row');
            if ($row == null) {
                $row = 10;
            }
            if ($page  == null) {
                $page = 1;
            }
            $offset = $row * ($page - 1);
            // $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line,$param_company);
            $data['C_DATA_COUNT']         = $this->employees_model->get_custom_groups_assignment_count($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company, $search);

            $data['tableData']            = $this->employees_model->get_custom_groups_assignment($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company, $search);
            $selectColumns = [
                // ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
                ['selectStatement' => 'name'],
            ];
            $filter = [
                ['status' => 'Active'],
            ];
            $table = 'tbl_std_custom_groups';
            $order = ['name' => 'name', 'value' => 'ASC'];
            $data['customGroups']               = $this->employees_model->get_settings_table_by_order($table, $filter, $selectColumns, $order);
            // echo '<pre>';
            // print_r($data['tableData']); die();

            $data['DISP_DISTINCT_DEPARTMENT']       = $this->employees_model->MOD_DISP_DISTINCT_DEPARTMENT();
            $data['DISP_DISTINCT_DIVISION']         = $this->employees_model->MOD_DISP_DISTINCT_DIVISION();
            $data['DISP_DISTINCT_CLUBHOUSE']         = $this->employees_model->MOD_DISP_DISTINCT_CLUBHOUSE();
            $data['DISP_DISTINCT_SECTION']          = $this->employees_model->MOD_DISP_DISTINCT_SECTION();
            $data['DISP_DISTINCT_BRANCH']           = $this->employees_model->MOD_DISP_DISTINCT_BRANCH();
            $data['DISP_DISTINCT_COMPANY']           = $this->employees_model->MOD_DISP_DISTINCT_COMPANY();
            $data['DISP_DISTINCT_GROUP']            = $this->employees_model->MOD_DISP_DISTINCT_GROUP();
            $data['DISP_DISTINCT_TEAM']             = $this->employees_model->MOD_DISP_DISTINCT_TEAM();
            $data['DISP_DISTINCT_LINE']             = $this->employees_model->MOD_DISP_DISTINCT_LINE();

            $data['DISP_VIEW_COMPANY']              = $this->employees_model->GET_SYSTEM_SETTING("com_company");
            $data['DISP_VIEW_DEPARTMENT']           = $this->employees_model->GET_SYSTEM_SETTING("com_Department");
            $data['DISP_VIEW_DIVISION']             = $this->employees_model->GET_SYSTEM_SETTING("com_division");
            $data['DISP_VIEW_CLUBHOUSE']            = $this->employees_model->GET_SYSTEM_SETTING("com_clubhouse");
            $data['DISP_VIEW_SECTION']              = $this->employees_model->GET_SYSTEM_SETTING("com_section");
            $data['DISP_VIEW_BRANCH']               = $this->employees_model->GET_SYSTEM_SETTING("com_branch");
            $data['DISP_VIEW_GROUP']                = $this->employees_model->GET_SYSTEM_SETTING("com_group");
            $data['DISP_VIEW_TEAM']                 = $this->employees_model->GET_SYSTEM_SETTING("com_team");
            $data['DISP_VIEW_LINE']                 = $this->employees_model->GET_SYSTEM_SETTING("com_line");

            // Search Employee List starts
            $employeeSearchRaw                  = $this->employees_model->GET_ALL_EMPLOYEES_SEARCH_SETUP_ORGANIZATION();
            foreach ($employeeSearchRaw as &$item) {
                $lastNameSuffix = $item->col_last_name;
                if (!empty($item->col_suffix)) {
                    $lastNameSuffix = $item->col_last_name . ' ' . $item->col_suffix;
                }
                $item->name = $item->col_empl_cmid . '-' . $lastNameSuffix . ', ' . $item->col_frst_name;
                if ($item->col_midl_name) {
                    $item->name = $item->col_empl_cmid . '-' . $lastNameSuffix . ', ' . $item->col_frst_name . ' ' . $item->col_midl_name[0] . '.';
                }
            }
            unset($item);
            $data['DISP_EMP_LIST_SEARCH']              = $employeeSearchRaw;

            $this->load->view('templates/header');
            $this->load->view('modules/employees/custom_group_assignment_views', $data);
        }
        function custom_group_assignment_api()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            $messageError = '';
            $messageSuccess = '';
            $groups = [];
            if (!(!empty($data) && is_array($data))) {
                header('Content-Type: application/json');
                echo json_encode(['messageError' => 'No Changes', 'data' => $data]);
                return;
            }
            foreach ($data as $item) {
                if (isset($item['groups']) && is_array($item['groups'])) {
                    $group_added = '';
                    $group_removed = '';
                    foreach ($item['groups'] as $group => $value) {
                        $res   = $this->employees_model->update_custom_groups($item['empl_id'], $group, $value, $this->session->userdata('SESS_USER_ID'));
                        if ($value) {
                            $group_added = $group_added ? $group_added . ', ' . $group : $group;
                        } else {
                            $group_removed = $group_removed ? $group_removed . ', ' . $group : $group;
                        }
                    }
                    $group_added_string = $group_added ? ' added: ' . $group_added : '';
                    $group_removed_string = $group_removed ? ' removed: ' . $group_removed : '';
                    $and = $group_added && $group_removed ? ' and' : '';
                    $messageSuccess = $messageSuccess ? $messageSuccess . '<br>' . $item['employeeName'] . $group_added_string . $and . $group_removed_string : $item['employeeName'] . $group_added_string . $and . $group_removed_string;
                } else {
                    $messageError = $messageError . '<br>' . $item['employeeName'] . '-assigning failed.';
                    $groups[] = $item['groups'];
                }
            }
            if ($messageSuccess) {
                header('Content-Type: application/json');
                echo json_encode(['messageSuccess' => $messageSuccess, 'groups' => $groups]);
                return;
            }
            if ($messageError) {
                header('Content-Type: application/json');
                echo json_encode(['messageError' => $messageError . ' Try again', 'groups' => $groups]);
                return;
            }
        }

        function update_organization()
        {
            $ids                                    = explode(",", $this->input->post('employee_ids'));
            $reporting_to                           = $this->input->post('reporting_to');
            $res                                    = $this->employees_model->UPDATE_ORGANIZATION($ids, $reporting_to);
            if ($res) {
                $this->session->set_flashdata('SUCC', 'Successfully Updated');
                redirect('employees/setup_organization');
            } else {
                $this->session->set_flashdata('ERR', 'Fail to Update');
                redirect('employees/setup_organization');
            }
        }

        // Dependents
        function add_dependents($user_id)
        {
            $data["C_EMP_ID"] = $user_id;
            $data["C_FUNCTION"] = "save_new_dependent/" . $user_id;
            $data["C_DEPENT_DATA"] = array();
            $this->load->view('templates/header');
            $this->load->view('modules/employees/dependents_views', $data);
        }
        function save_new_dependent($user_id)
        {

            $full_name          = $this->input->post("full_name");
            $b_day              = $this->input->post("b_day");
            $gender             = $this->input->post("gender");
            $relationship       = $this->input->post("relationship");
            $res                = $this->employees_model->ADD_NEW_DEPENDENT($user_id, $full_name, $b_day, $gender, $relationship);
            $isAdmin            = $this->session->userdata('SESS_ADMIN');
            $log_mgs            = $isAdmin == 1 ? 'Added new dependent(Admin)' : 'Added new dependent';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SUCC', "New dependent added successfully");
                redirect('employees/personal?id=' . $user_id);
            } else {
                $log_mgs        = $isAdmin == 1 ? 'Fail to add new dependent(Admin)' : 'Fail to add new dependent';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('ERR', 'Fail to Add!');
                redirect('employees/personal?id=' . $user_id);
            }
        }
        function edit_dependent($id, $user_id)
        {
            $data["C_EMP_ID"] = $user_id;
            $data["C_FUNCTION"] = "update_dependent/" . $id . '/' . $user_id;
            $data["C_DEPENT_DATA"] = $this->employees_model->GET_SPECIFIC_DEPENDENT($id);

            $this->load->view('templates/header');
            $this->load->view('modules/employees/dependents_views', $data);
        }
        function update_dependent($id, $user_id)
        {
            $full_name          = $this->input->post("full_name");
            $b_day              = $this->input->post("b_day");
            $gender             = $this->input->post("gender");
            $relationship       = $this->input->post("relationship");
            $res                = $this->employees_model->UPDATE_SPECIFIC_DEPENDENT($id, $full_name, $b_day, $gender, $relationship);
            $isAdmin            = $this->session->userdata('SESS_ADMIN');
            $log_mgs            = $isAdmin == 1 ? 'Updated dependent(Admin)' : 'Updated dependent';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SUCC', "Dependent updated successfully");
                redirect('employees/personal?id=' . $user_id);
            } else {
                $log_mgs        = $isAdmin == 1 ? 'Fail to updated dependent(Admin)' : 'Fail to update dependent';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('ERR', 'Fail to Update!');
                redirect('employees/personal?id=' . $user_id);
            }
        }
        function DELETE_DEPENDENT($id)
        {
            $res                    = $this->employees_model->DELETE_DEPENDENT($id);
            $isAdmin                = $this->session->userdata('SESS_ADMIN');
            $log_mgs                = $isAdmin == 1 ? 'Deleted dependent(Admin)' : 'Deleted dependent';
            if ($res) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
            } else {
                $log_mgs            = $isAdmin == 1 ? 'Fail to delete dependent(Admin)' : 'Fail to update dependent';
                $this->session->set_flashdata('SESS_ERR_UPDT', 'Fail to Update!');
            }
            echo $res;
        }
        // ========================================================================== TEAMS ===========================================================================

        function csv_upload()
        {

            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_POSITIONS']                = $this->employees_model->GET_POSITION();
            $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
            $data['C_SHIRT_SIZE']               = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_GENDERS']                  = $this->employees_model->GET_GENDERS();
            $data['C_MARITAL']                  = $this->employees_model->GET_MARITAL();
            $data['C_NATIONALITY']              = $this->employees_model->GET_NATIONALITY();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
            $data['C_CLUBHOUSE']                = $this->employees_model->GET_CLUBHOUSE();
            $data['C_HMOS']                     = $this->employees_model->GET_HMO();
            $data['C_USER_ACCESS']              = $this->employees_model->GET_USER_ACCESS();

            $data['DISP_ALL_EMPLOYEES'] = $this->employees_model->MOD_DISP_ALL_EMPLOYEES();
            $this->load->view('templates/header');
            $this->load->view('modules/employees/csv_upload_views', $data);
        }

        function new_employee_upload()
        {

            $data['C_BRANCH']                               = $this->employees_model->GET_BRANCHES();

            $data['C_POSITIONS']                           = $this->employees_model->GET_POSITION();
            $data['C_USER_ACCESS']                         = $this->employees_model->GET_USER_ACCESS();
            $data['C_SECTIONS']                            = $this->employees_model->GET_SECTIONS();
            $data['C_COMPANIES']                           = $this->employees_model->GET_COMPANIES_ACTIVE();
            $data['C_BRANCHES']                            = $this->employees_model->GET_BRANCHES_ACTIVE();
            $data['C_DEPARTMENTS']                         = $this->employees_model->GET_DEPARTMENTS();
            $data['C_TYPE']                                = $this->employees_model->GET_TYPE();
            $data['C_SHIRT_SIZE']                          = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_GENDERS']                             = $this->employees_model->GET_GENDERS();
            $data['C_MARITAL']                             = $this->employees_model->GET_MARITAL();
            $data['C_NATIONALITY']                         = $this->employees_model->GET_NATIONALITY();
            $data['C_GROUPS']                              = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                               = $this->employees_model->GET_LINES();
            $data['C_DIVISIONS']                           = $this->employees_model->GET_DIVISIONS();
            $data['C_CLUBHOUSE']                           = $this->employees_model->GET_CLUBHOUSE();
            $data['C_CLUBHOUSE']                           = $this->employees_model->GET_CLUBHOUSE();
            $data['C_HMO']                                 = $this->employees_model->GET_HMO();
            $data['C_TEAMS']                               = $this->employees_model->GET_TEAMS_ACTIVE();

            $hiddenColumns = [44, 45];
            $handsonIndex = 23;
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_company")) array_push($hiddenColumns, $handsonIndex);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_branch")) array_push($hiddenColumns, $handsonIndex + 1);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_Department")) array_push($hiddenColumns, $handsonIndex + 2);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_division")) array_push($hiddenColumns, $handsonIndex + 3);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_clubhouse")) array_push($hiddenColumns, $handsonIndex + 4);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_section")) array_push($hiddenColumns, $handsonIndex + 5);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_group")) array_push($hiddenColumns, $handsonIndex + 6);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_team")) array_push($hiddenColumns, $handsonIndex + 7);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_line")) array_push($hiddenColumns, $handsonIndex + 8);

            $data['HIDDEN_COLUMNS']                               = $hiddenColumns;

            $this->load->view('templates/header');
            $this->load->view('modules/employees/new_employee_upload_views', $data);
        }

        function employee_update2()
        {

            $data['C_BRANCH']                               = $this->employees_model->GET_BRANCHES();

            $data['C_POSITIONS']                           = $this->employees_model->GET_POSITION();
            $data['C_USER_ACCESS']                         = $this->employees_model->GET_USER_ACCESS();
            $data['C_SECTIONS']                            = $this->employees_model->GET_SECTIONS();
            // $data['C_DEPARTMENTS']                         = $this->employees_model->GET_DEPARTMENTS();
            $data['C_TYPE']                                = $this->employees_model->GET_TYPE();
            $data['C_SHIRT_SIZE']                          = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_GENDERS']                             = $this->employees_model->GET_GENDERS();
            $data['C_MARITAL']                             = $this->employees_model->GET_MARITAL();
            $data['C_NATIONALITY']                         = $this->employees_model->GET_NATIONALITY();
            $data['C_GROUPS']                              = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                               = $this->employees_model->GET_LINES();
            $data['C_DIVISIONS']                           = $this->employees_model->GET_DIVISIONS();
            $data['C_HMO']                                 = $this->employees_model->GET_HMO();
            $data['C_COMPANIES']                           = $this->employees_model->GET_COMPANIES_ACTIVE();
            $data['C_BRANCHES']                            = $this->employees_model->GET_BRANCHES_ACTIVE();
            $data['C_DEPARTMENTS']                         = $this->employees_model->GET_DEPARTMENTS_ACTIVE();
            $data['C_TEAMS']                               = $this->employees_model->GET_TEAMS_ACTIVE();

            $data['employee_search']                       = $this->employees_model->employee_search();

            $hiddenColumns = [];
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_company")) array_push($hiddenColumns, 20);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_branch")) array_push($hiddenColumns, 21);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_Department")) array_push($hiddenColumns, 22);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_division")) array_push($hiddenColumns, 23);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_section")) array_push($hiddenColumns, 24);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_group")) array_push($hiddenColumns, 25);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_team")) array_push($hiddenColumns, 26);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_line")) array_push($hiddenColumns, 27);

            $data['HIDDEN_COLUMNS']                               = $hiddenColumns;

            $this->load->view('templates/header');
            $this->load->view('modules/employees/employee_bulk_update_views2', $data);
        }
        function employee_update()
        {

            $data['C_BRANCH']                               = $this->employees_model->GET_BRANCHES();

            $data['C_POSITIONS']                           = $this->employees_model->GET_POSITION();
            $data['C_USER_ACCESS']                         = $this->employees_model->GET_USER_ACCESS();
            $data['C_SECTIONS']                            = $this->employees_model->GET_SECTIONS();
            // $data['C_DEPARTMENTS']                         = $this->employees_model->GET_DEPARTMENTS();
            $data['C_TYPE']                                = $this->employees_model->GET_TYPE();
            $data['C_SHIRT_SIZE']                          = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_GENDERS']                             = $this->employees_model->GET_GENDERS();
            $data['C_MARITAL']                             = $this->employees_model->GET_MARITAL();
            $data['C_NATIONALITY']                         = $this->employees_model->GET_NATIONALITY();
            $data['C_GROUPS']                              = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                               = $this->employees_model->GET_LINES();
            $data['C_DIVISIONS']                           = $this->employees_model->GET_DIVISION_ACTIVE();
            $data['C_CLUBHOUSE']                           = $this->employees_model->GET_CLUBHOUSE_ACTIVE();
            $data['C_HMO']                                 = $this->employees_model->GET_HMO();
            $data['C_COMPANIES']                           = $this->employees_model->GET_COMPANIES_ACTIVE();
            $data['C_BRANCHES']                            = $this->employees_model->GET_BRANCHES_ACTIVE();
            $data['C_DEPARTMENTS']                         = $this->employees_model->GET_DEPARTMENTS_ACTIVE();
            $data['C_TEAMS']                               = $this->employees_model->GET_TEAMS_ACTIVE();

            $data['employee_search']                       = $this->employees_model->employee_search();

            $hiddenColumns = [44, 45];
            $handsonIndex = 23;
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_company")) array_push($hiddenColumns, $handsonIndex);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_branch")) array_push($hiddenColumns, $handsonIndex + 1);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_Department")) array_push($hiddenColumns, $handsonIndex + 2);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_division")) array_push($hiddenColumns, $handsonIndex + 3);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_clubhouse")) array_push($hiddenColumns, $handsonIndex + 4);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_section")) array_push($hiddenColumns, $handsonIndex + 5);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_group")) array_push($hiddenColumns, $handsonIndex + 6);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_team")) array_push($hiddenColumns, $handsonIndex + 7);
            if (!$this->employees_model->GET_SYSTEM_SETTING("com_line")) array_push($hiddenColumns, $handsonIndex + 8);

            $data['HIDDEN_COLUMNS']                               = $hiddenColumns;

            $this->load->view('templates/header');
            $this->load->view('modules/employees/employee_bulk_update_views', $data);
        }
        function get_tableplus_data_work_history()
        {
            // $employee_id                        = $this->input->get('id');
            $userId = json_decode(file_get_contents('php://input'), true);
            $response                           = $this->employees_model->GET_WORK_HISTORY($userId);
            echo (json_encode($response));
        }
        function get_tableplus_data_work_history_all()
        {
            $response                           = $this->employees_model->GET_WORK_HISTORY_ALL();
            echo (json_encode($response));
        }
        function get_tableplus_education_all()
        {
            $response                           = $this->employees_model->GET_EDUCATION_ALL_NOT_DELETED();
            echo (json_encode($response));
        }
        function get_tableplus_documents_all()
        {
            $response                           = $this->employees_model->GET_DOCUMENTS_ALL_NOT_DELETED();
            echo (json_encode($response));
        }
        function get_tableplus_emergency_contacts_all()
        {
            $response                           = $this->employees_model->GET_EMERGENCY_CONTACTS_ALL_NOT_DELETED();
            echo (json_encode($response));
        }
        function get_tableplus_dependents_all()
        {
            $response                           = $this->employees_model->GET_DEPENDENTS_ALL_NOT_DELETED();
            echo (json_encode($response));
        }
        function get_tableplus_skills_all()
        {
            $response                           = $this->employees_model->GET_SKILLS_ALL_NOT_DELETED();
            echo (json_encode($response));
        }
        function update_work_history_all()
        {
            $response = array('success_message' => 'Update was Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                $deletedId = $data['deletedId'];
                // return $this->output->set_content_type('application/json')->set_output(json_encode($test));
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
                    $response = array('error_message' => 'Invalid JSON data updatedData or userId');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                $filteredData = array_filter($updatedData, function ($subarray) {
                    return !is_array($subarray) || !empty(array_filter($subarray, function ($item) {
                        return $item !== null;
                    }));
                });
                $filteredData = array_values($filteredData);
                foreach ($filteredData as $data_row) {
                    $res = $this->employees_model->UPDATE_WORK_HISTORY_ALL($data_row, $this->session->userdata('SESS_USER_ID'));
                    if ($res) $response = $res;
                }
                if (isset($deletedId) || is_array($deletedId) || !empty($deletedId)) {
                    foreach ($deletedId as $id) {
                        $res = $this->employees_model->DELETE_WORK_HISTORY($id);
                        // if($res)$response = $res;
                        // $response ='test';
                        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
                        // return;
                    }
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated work history');
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        function update_documents_all()
        {
            $response = array('success_message' => 'Update was Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                $deletedId = $data['deletedId'];
                // return $this->output->set_content_type('application/json')->set_output(json_encode($test));
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
                    $response = array('error_message' => 'Invalid JSON data updatedData or userId');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                $filteredData = array_filter($updatedData, function ($subarray) {
                    return !is_array($subarray) || !empty(array_filter($subarray, function ($item) {
                        return $item !== null;
                    }));
                });
                $filteredData = array_values($filteredData);
                foreach ($filteredData as $data_row) {
                    $res = $this->employees_model->UPDATE_DOCUMENTS_ALL($data_row, $this->session->userdata('SESS_USER_ID'));
                    if ($res) $response = $res;
                }
                if (isset($deletedId) || is_array($deletedId) || !empty($deletedId)) {
                    foreach ($deletedId as $id) {
                        $res = $this->employees_model->DELETE_DOCUMENTS_BY_ID($id);
                        // if($res)$response = $res;
                        // $response ='test';
                        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
                        // return;
                    }
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated documents');
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        function update_emergency_contacts_all()
        {
            $response = array('success_message' => 'Update was Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                $deletedId = $data['deletedId'];
                // return $this->output->set_content_type('application/json')->set_output(json_encode($test));
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
                    $response = array('error_message' => 'Invalid JSON data updatedData or userId');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                $filteredData = array_filter($updatedData, function ($subarray) {
                    return !is_array($subarray) || !empty(array_filter($subarray, function ($item) {
                        return $item !== null;
                    }));
                });
                $filteredData = array_values($filteredData);
                foreach ($filteredData as $data_row) {
                    $res = $this->employees_model->UPDATE_EMERGENCY_CONTACTS_ALL($data_row, $this->session->userdata('SESS_USER_ID'));
                    if ($res) $response = $res;
                }
                if (isset($deletedId) || is_array($deletedId) || !empty($deletedId)) {
                    foreach ($deletedId as $id) {
                        $res = $this->employees_model->DELETE_EMERGENCY_CONTACTS_BY_ID($id);
                        // if($res)$response = $res;
                        // $response ='test';
                        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
                        // return;
                    }
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated emergency contacts');
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        function update_dependents_all()
        {
            $response = array('success_message' => 'Update was Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                $deletedId = $data['deletedId'];
                // return $this->output->set_content_type('application/json')->set_output(json_encode($test));
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
                    $response = array('error_message' => 'Invalid JSON data updatedData or userId');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                $filteredData = array_filter($updatedData, function ($subarray) {
                    return !is_array($subarray) || !empty(array_filter($subarray, function ($item) {
                        return $item !== null;
                    }));
                });
                $filteredData = array_values($filteredData);
                foreach ($filteredData as $data_row) {
                    $res = $this->employees_model->UPDATE_DEPENDENTS_ALL($data_row, $this->session->userdata('SESS_USER_ID'));
                    if ($res) $response = $res;
                }
                if (isset($deletedId) || is_array($deletedId) || !empty($deletedId)) {
                    foreach ($deletedId as $id) {
                        $res = $this->employees_model->DELETE_DEPENDENTS_BY_ID($id);
                        // if($res)$response = $res;
                        // $response ='test';
                        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
                        // return;
                    }
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated dependents');
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        function update_education_all()
        {
            $response = array('success_message' => 'Update was Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                $deletedId = $data['deletedId'];
                // return $this->output->set_content_type('application/json')->set_output(json_encode($test));
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
                    $response = array('error_message' => 'Invalid JSON data updatedData or userId');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                $filteredData = array_filter($updatedData, function ($subarray) {
                    return !is_array($subarray) || !empty(array_filter($subarray, function ($item) {
                        return $item !== null;
                    }));
                });
                $filteredData = array_values($filteredData);
                foreach ($filteredData as $data_row) {
                    $res = $this->employees_model->UPDATE_EDUCATION_ALL($data_row, $this->session->userdata('SESS_USER_ID'));
                    if ($res) $response = $res;
                }
                if (isset($deletedId) || is_array($deletedId) || !empty($deletedId)) {
                    foreach ($deletedId as $id) {
                        $res = $this->employees_model->DELETE_EDUCATION_BY_ID($id);
                        // if($res)$response = $res;
                        // $response ='test';
                        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
                        // return;
                    }
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated education');
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }

        function update_skills_all()
        {
            $response = array('success_message' => 'Update was Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                $deletedId = $data['deletedId'];
                // return $this->output->set_content_type('application/json')->set_output(json_encode($test));
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
                    $response = array('error_message' => 'Invalid JSON data updatedData or userId');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                $filteredData = array_filter($updatedData, function ($subarray) {
                    return !is_array($subarray) || !empty(array_filter($subarray, function ($item) {
                        return $item !== null;
                    }));
                });
                $filteredData = array_values($filteredData);
                foreach ($filteredData as $data_row) {
                    $res = $this->employees_model->UPDATE_SKILL_ALL($data_row, $this->session->userdata('SESS_USER_ID'));
                    if ($res) $response = $res;
                }
                if (isset($deletedId) || is_array($deletedId) || !empty($deletedId)) {
                    foreach ($deletedId as $id) {
                        $res = $this->employees_model->DELETE_SKILL_BY_ID($id);
                        // if($res)$response = $res;
                        // $response ='test';
                        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
                        // return;
                    }
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated skills');
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        function update_work_history()
        {
            $response = array('success_message' => 'Update was Successful');
            try {
                $json_data = file_get_contents('php://input');
                $data = json_decode($json_data, true);
                $updatedData = $data['updatedData'];
                $userId = $data['userId'];
                $deletedId = $data['deletedId'];
                // return $this->output->set_content_type('application/json')->set_output(json_encode($test));
                if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData) || !isset($userId) || !$userId) {
                    $response = array('error_message' => 'Invalid JSON data updatedData or userId');
                    $this->output->set_content_type('application/json')->set_output(json_encode($response));
                    return;
                }
                $filteredData = array_filter($updatedData, function ($subarray) {
                    return !is_array($subarray) || !empty(array_filter($subarray, function ($item) {
                        return $item !== null;
                    }));
                });
                $filteredData = array_values($filteredData);
                foreach ($filteredData as $data_row) {
                    $res = $this->employees_model->UPDATE_WORK_HISTORY($data_row, $this->session->userdata('SESS_USER_ID'), $userId);
                    if ($res) $response = $res;
                }
                if (isset($deletedId) || is_array($deletedId) || !empty($deletedId)) {
                    foreach ($deletedId as $id) {
                        $res = $this->employees_model->DELETE_WORK_HISTORY($id);
                        // if($res)$response = $res;
                        // $response ='test';
                        // $this->output->set_content_type('application/json')->set_output(json_encode($response));
                        // return;
                    }
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated work history');
            } catch (Exception $e) {
                $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
                $this->output->set_content_type('application/json')->set_output(json_encode($response));
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
        function bulk_work_history()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated work history');
            $this->load->view('templates/header');
            $this->load->view('modules/employees/bulk_work_history_views');
        }
        function bulk_education()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated education');
            $this->load->view('templates/header');
            $this->load->view('modules/employees/bulk_education_views');
        }
        function bulk_documents()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated documents');
            $this->load->view('templates/header');
            $this->load->view('modules/employees/bulk_documents_views');
        }
        function bulk_emergency_contacts()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated emergency contacts');
            $this->load->view('templates/header');
            $this->load->view('modules/employees/bulk_emergency_contacts_views');
        }
        function bulk_dependents()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated dependents');
            $this->load->view('templates/header');
            $this->load->view('modules/employees/bulk_dependents_views');
        }
        function bulk_skills()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated skills');
            $data['C_SKILLS_NAME']              = $this->employees_model->GET_SKILL_NAME();
            $data['C_SKILLS_LEVEL']             = $this->employees_model->GET_SKILL_LEVEL();
            $this->load->view('templates/header');
            $this->load->view('modules/employees/bulk_skills_views', $data);
        }

        function get_tableplus_data_id()
        {
            $result = array();
            $index = 0;
            $id = $this->input->get('id');
            $data                               = $this->employees_model->GET_TABLEPLUS_ID($id);
            $position                           = $this->employees_model->GET_POSITION();
            $companies_active                   = $this->employees_model->GET_COMPANIES_ACTIVE();
            $companies                          = $this->employees_model->GET_COMPANIES();
            $branches                          = $this->employees_model->GET_BRANCHES();
            $section                            = $this->employees_model->GET_SECTIONS();
            $groups                             = $this->employees_model->GET_GROUPS();
            $teams                             = $this->employees_model->GET_TEAMS();
            $department                         = $this->employees_model->GET_DEPARTMENTS();
            $type                               = $this->employees_model->GET_TYPE();
            $shirt_size                         = $this->employees_model->GET_SHIRT_SIZE();
            $gender                             = $this->employees_model->GET_GENDERS();
            $marital                            = $this->employees_model->GET_MARITAL();
            $nationality                        = $this->employees_model->GET_NATIONALITY();
            $lines                              = $this->employees_model->GET_LINES();
            $division                           = $this->employees_model->GET_DIVISIONS();
            $hmo                                = $this->employees_model->GET_HMO();
            $clubhouse                          = $this->employees_model->GET_CLUBHOUSES();

            foreach ($data as $row) {
                $result[] = [
                    'col_empl_cmid' => $row->col_empl_cmid,
                    'col_last_name' => $row->col_last_name,
                    'col_midl_name' => $row->col_midl_name,
                    'col_frst_name' => $row->col_frst_name,
                    'col_mart_stat' => $this->convert_id2name($marital, $row->col_mart_stat),
                    'col_home_addr' => $row->col_home_addr,
                    'col_curr_addr' => $row->col_curr_addr,
                    'col_province'  => $row->col_province,
                    'col_city'      => $row->col_city,
                    'col_barangay'  => $row->col_barangay,
                    'col_birt_date' => ($row->col_birt_date && strtotime($row->col_birt_date) && $row->col_birt_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->col_birt_date)) : null,
                    // 'col_birt_date' => date("d/m/Y", strtotime($row->col_birt_date)),
                    'col_empl_gend' => $this->convert_id2name($gender, $row->col_empl_gend),
                    'col_empl_nati' => $this->convert_id2name($nationality, $row->col_empl_nati),
                    'col_shir_size' => $this->convert_id2name($shirt_size, $row->col_shir_size),
                    'col_empl_emai' => $row->col_empl_emai,
                    'col_mobl_numb' => $row->col_mobl_numb,
                    'col_hire_date' => ($row->col_hire_date && strtotime($row->col_hire_date) && $row->col_hire_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->col_hire_date)) : null,
                    // 'col_hire_date' => null,
                    // 'col_hire_date' => date("d/m/Y", strtotime($row->col_hire_date)),
                    'date_regular' => ($row->date_regular && strtotime($row->date_regular) && $row->date_regular !== '0000-00-00') ? date("d/m/Y", strtotime($row->date_regular)) : null,
                    // 'date_regular' => date("d/m/Y", strtotime($row->date_regular)),
                    'resignation_date' => ($row->resignation_date && strtotime($row->resignation_date) && $row->resignation_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->resignation_date)) : null,
                    // 'resignation_date' => date("d/m/Y", strtotime($row->resignation_date)),
                    'col_endd_date' => ($row->col_endd_date && strtotime($row->col_endd_date) && $row->col_endd_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->col_endd_date)) : null,
                    // 'col_endd_date' => date("d/m/Y", strtotime($row->col_endd_date)),
                    'col_empl_type' => $this->convert_id2name($type, $row->col_empl_type),
                    'col_empl_posi' => $this->convert_id2name($position, $row->col_empl_posi),
                    'col_empl_company' => $this->convert_id2name($companies, $row->col_empl_company),
                    'col_empl_branch' => $this->convert_id2name($branches, $row->col_empl_branch),
                    'col_empl_divi' => $this->convert_id2name($division, $row->col_empl_divi),
                    'col_empl_club' => $this->convert_id2name($clubhouse, $row->col_empl_club),
                    'col_empl_group' => $this->convert_id2name($groups, $row->col_empl_group),
                    'col_empl_team' => $this->convert_id2name($teams, $row->col_empl_team),
                    'col_empl_line' => $this->convert_id2name($lines, $row->col_empl_line),
                    'col_empl_dept' => $this->convert_id2name($department, $row->col_empl_dept),
                    'col_empl_sect' => $this->convert_id2name($section, $row->col_empl_sect),
                    'col_imag_path' => $row->col_imag_path,
                    'bank_name'     => $row->bank_name,
                    'account_number' => $row->account_number,
                    'col_empl_sssc' => $row->col_empl_sssc,
                    'col_empl_hdmf' => $row->col_empl_hdmf,
                    'col_empl_phil' => $row->col_empl_phil,
                    'col_empl_btin' => $row->col_empl_btin,
                    'col_empl_driv' => $row->col_empl_driv,
                    'col_empl_naid' => $row->col_empl_naid,
                    'col_empl_pass' => $row->col_empl_pass,
                    'col_empl_hmoo' => $this->convert_id2name($hmo, $row->col_empl_hmoo),
                    'col_empl_hmon' => $row->col_empl_hmon,
                    'salary_rate' => $row->salary_rate,
                    'salary_type' => $row->salary_type,
                    'col_suffix' => $row->col_suffix,
                ];
            }

            echo (json_encode($result));
        }
        function get_tableplus_data()
        {
            $result = array();
            $index = 0;
            $data                               = $this->employees_model->GET_TABLEPLUS();
            $position                           = $this->employees_model->GET_POSITION();
            $companies_active                   = $this->employees_model->GET_COMPANIES_ACTIVE();
            $companies                          = $this->employees_model->GET_COMPANIES();
            $branches                          = $this->employees_model->GET_BRANCHES();
            $section                            = $this->employees_model->GET_SECTIONS();
            $groups                             = $this->employees_model->GET_GROUPS();
            $teams                             = $this->employees_model->GET_TEAMS();
            $department                         = $this->employees_model->GET_DEPARTMENTS();
            $type                               = $this->employees_model->GET_TYPE();
            $shirt_size                         = $this->employees_model->GET_SHIRT_SIZE();
            $gender                             = $this->employees_model->GET_GENDERS();
            $marital                            = $this->employees_model->GET_MARITAL();
            $nationality                        = $this->employees_model->GET_NATIONALITY();
            $lines                              = $this->employees_model->GET_LINES();
            $division                           = $this->employees_model->GET_DIVISIONS();
            $clubhouse                          = $this->employees_model->GET_CLUBHOUSE();
            $hmo                                = $this->employees_model->GET_HMO();

            foreach ($data as $row) {
                $result[] = [
                    'col_empl_cmid' => $row->col_empl_cmid,
                    'col_last_name' => $row->col_last_name,
                    'col_midl_name' => $row->col_midl_name,
                    'col_frst_name' => $row->col_frst_name,
                    'col_mart_stat' => $this->convert_id2name($marital, $row->col_mart_stat),
                    'col_home_addr' => $row->col_home_addr,
                    'col_curr_addr' => $row->col_curr_addr,
                    'col_province'  => $row->col_province,
                    'col_city'      => $row->col_city,
                    'col_barangay'  => $row->col_barangay,
                    'col_birt_date' => ($row->col_birt_date && strtotime($row->col_birt_date) && $row->col_birt_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->col_birt_date)) : null,
                    // 'col_birt_date' => date("d/m/Y", strtotime($row->col_birt_date)),
                    'col_empl_gend' => $this->convert_id2name($gender, $row->col_empl_gend),
                    'col_empl_nati' => $this->convert_id2name($nationality, $row->col_empl_nati),
                    'col_shir_size' => $this->convert_id2name($shirt_size, $row->col_shir_size),
                    'col_empl_emai' => $row->col_empl_emai,
                    'col_mobl_numb' => $row->col_mobl_numb,
                    'col_hire_date' => ($row->col_hire_date && strtotime($row->col_hire_date) && $row->col_hire_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->col_hire_date)) : null,
                    // 'col_hire_date' => null,
                    // 'col_hire_date' => date("d/m/Y", strtotime($row->col_hire_date)),
                    'date_regular' => ($row->date_regular && strtotime($row->date_regular) && $row->date_regular !== '0000-00-00') ? date("d/m/Y", strtotime($row->date_regular)) : null,
                    // 'date_regular' => date("d/m/Y", strtotime($row->date_regular)),
                    'resignation_date' => ($row->resignation_date && strtotime($row->resignation_date) && $row->resignation_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->resignation_date)) : null,
                    // 'resignation_date' => date("d/m/Y", strtotime($row->resignation_date)),
                    'col_endd_date' => ($row->col_endd_date && strtotime($row->col_endd_date) && $row->col_endd_date !== '0000-00-00') ? date("d/m/Y", strtotime($row->col_endd_date)) : null,
                    // 'col_endd_date' => date("d/m/Y", strtotime($row->col_endd_date)),
                    'col_empl_type' => $this->convert_id2name($type, $row->col_empl_type),
                    'col_empl_posi' => $this->convert_id2name($position, $row->col_empl_posi),
                    'col_empl_company' => $this->convert_id2name($companies, $row->col_empl_company),
                    'col_empl_branch' => $this->convert_id2name($branches, $row->col_empl_branch),
                    'col_empl_divi' => $this->convert_id2name($division, $row->col_empl_divi),
                    'col_empl_club' => $this->convert_id2name($clubhouse, $row->col_empl_club),
                    'col_empl_group' => $this->convert_id2name($groups, $row->col_empl_group),
                    'col_empl_team' => $this->convert_id2name($teams, $row->col_empl_team),
                    'col_empl_line' => $this->convert_id2name($lines, $row->col_empl_line),
                    'col_empl_dept' => $this->convert_id2name($department, $row->col_empl_dept),
                    'col_empl_sect' => $this->convert_id2name($section, $row->col_empl_sect),
                    'col_imag_path' => $row->col_imag_path,
                    'bank_name'     => $row->bank_name,
                    'account_number' => $row->account_number,
                    'col_empl_sssc' => $row->col_empl_sssc,
                    'col_empl_hdmf' => $row->col_empl_hdmf,
                    'col_empl_phil' => $row->col_empl_phil,
                    'col_empl_btin' => $row->col_empl_btin,
                    'col_empl_driv' => $row->col_empl_driv,
                    'col_empl_naid' => $row->col_empl_naid,
                    'col_empl_pass' => $row->col_empl_pass,
                    'col_empl_hmoo' => $this->convert_id2name($hmo, $row->col_empl_hmoo),
                    'col_empl_hmon' => $row->col_empl_hmon,
                    'salary_rate' => $row->salary_rate,
                    'salary_type' => $row->salary_type,
                    'col_suffix' => $row->col_suffix,
                ];
            }

            echo (json_encode($result));
        }


        function convert_id2name($array, $id)
        {
            $name = "";
            foreach ($array as $e) {
                if ($id == $e->id) {
                    $name = $e->name;
                    return $name;
                }
            }
            return $name;
        }



        function insert_data()
        {
            $data = json_decode(file_get_contents('php://input'), true);
            // $response = array('messageError'=>'Unexpected Error Ocurred');
            try {
                $count = 0;
                foreach ($data as $innerArray) {
                    if (isset($innerArray) && $innerArray['disabled'] !== 'Inactive') {
                        $count++;
                    }
                }
                $result = $this->employees_model->CHECK_ACTIVE_LIMIT('add', 0, $count);
                if ($result) {
                    $response = $result;
                    echo json_encode($response);
                    return;
                }
                // $response = array('messageSuccess' => 'Data inserted successfully');
                $messageSuccess = '';
                $messageError = '';
                foreach ($data as $data_row) {
                    $is_duplicate = $this->employees_model->is_duplicate_data($data_row);
                    if ($is_duplicate > 0) {
                        // $this->employees_model->update_data($data_row);
                        $messageError = $data_row['col_empl_cmid'] . ', ' . $messageError;
                        // $response = array('messageError' => 'Please avoid providing duplicate information.');
                        // echo json_encode($response);
                        // return;
                    } else {

                        $this->employees_model->insert_data($data_row, $this->session->userdata('SESS_USER_ID'));
                        // $response = array('messageSuccess' => 'Data inserted successfully');
                        $messageSuccess = $data_row['col_empl_cmid'] . ', ' . $messageSuccess;
                    }
                }
                // if ($messageError) {
                //     $response = array('messageError' => "Found duplicates: $messageError will not be added");
                // }
                $response = array();
                if ($messageError) {
                    $response['messageError'] = "Found duplicates: $messageError will not be added";
                }
                if ($messageSuccess) {
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Inserted/Updated employee data');
                    $response['messageSuccess'] = "$messageSuccess added successfully";
                }
                if (empty($response)) {
                    $response['unexpectedError'] = 'Unexpected Error Occured';
                }
                echo json_encode($response);
                return;
            } catch (Exception $e) {
                // $response = array('message' => 'Error updating data: '.$e->getMessage());
                $response = array('messageError' => 'Unexpected Catch Error ');
                echo json_encode($response);
                return;
            }
            // echo json_encode(array('count'=>$count, 'result'=>$result));
            // echo json_encode($response);
        }

        function update_data()
        {

            $data = json_decode(file_get_contents('php://input'), true);


            try {
                foreach ($data as $data_row) {
                    $this->employees_model->update_data($data_row, $this->session->userdata('SESS_USER_ID'));
                }

                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Inserted/Updated employee data');
                $response = array('success_message' => 'Data updated successfully');
            } catch (Exception $e) {
                // log_message('error', 'Error updating data: ' . $e->getMessage());
                $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }

            echo json_encode($response);
        }


        function update_salary_detail()
        {
            $data = json_decode(file_get_contents('php://input'), true);

            try {
                foreach ($data as $data_row) {
                    $this->employees_model->UPDATE_SALARY_DETAIL($data_row, $this->session->userdata('SESS_USER_ID'));
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated salary for employee ID: ' . (isset($data[0]['id']) ? $data[0]['id'] : ''));
                $response = array('success_message' => 'Data updated successfully');
            } catch (Exception $e) {
                $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function update_setup_organization()
        {
            $data = json_decode(file_get_contents('php://input'), true);

            try {
                foreach ($data as $data_row) {
                    $this->employees_model->UPDATE_SETUP_ORGANIZATION($data_row, $this->session->userdata('SESS_USER_ID'));
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated organization setup');
                $response = array('success_message' => 'Data updated successfully');
            } catch (Exception $e) {
                $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }
            echo json_encode($response);
        }

        function upload_employee_photo()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Uploaded employee photo');
            $this->load->view('templates/header');
            $this->load->view('modules/employees/bulk_image_upload_views');
        }

        function upload_csv_update_employees()
        {
            $curdate                    = date('Y-m-d h:i:s');
            $rundate                    = substr($curdate, 5, 2) . substr($curdate, 8, 2) . substr($curdate, 2, 2) . "_" . substr($curdate, 11, 2) . substr($curdate, 14, 2) . substr($curdate, 17, 2);
            $file_name                  = 'Employee_' . $rundate;
            $path                       = "assets_system/files/employees/";
            $config['file_name']        = $file_name;
            $config['upload_path']      = "./assets_system/files/employees/";
            $config['allowed_types']    = '*';
            $config['max_size']         = '10000';
            $this->load->library('upload', $config);

            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_POSITIONS']                = $this->employees_model->GET_POSITION();
            $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
            $data['C_SHIRT_SIZE']               = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_GENDERS']                  = $this->employees_model->GET_GENDERS();
            $data['C_MARITAL']                  = $this->employees_model->GET_MARITAL();
            $data['C_NATIONALITY']              = $this->employees_model->GET_NATIONALITY();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
            $data['C_CLUBHOUSE']                = $this->employees_model->GET_CLUBHOUSE();
            $data['C_HMOS']                     = $this->employees_model->GET_HMO();
            $data['C_USER_ACCESS']              = $this->employees_model->GET_USER_ACCESS();


            if ($this->upload->do_upload('file')) {
                $name           = $_FILES["file"]["name"];
                $ext1           = explode(".", $name);
                $ext            = end($ext1);
                $file           = fopen(($path . $file_name . '.' . $ext), "r");
                $ctr            = 0;
                $x[$ctr]        = (fgetcsv($file));

                if (!isset($x[0][0]) || !isset($x[0][1]) || !isset($x[0][2]) || !isset($x[0][3]) || !isset($x[0][4]) || !isset($x[0][5]) || !isset($x[0][6]) || !isset($x[0][7]) || !isset($x[0][8]) || !isset($x[0][9]) || !isset($x[0][10]) || !isset($x[0][11]) || !isset($x[0][12]) || !isset($x[0][13]) || !isset($x[0][14]) || !isset($x[0][15]) || !isset($x[0][16]) || !isset($x[0][17]) || !isset($x[0][18]) || !isset($x[0][19]) || !isset($x[0][20]) || !isset($x[0][21]) || !isset($x[0][22]) || !isset($x[0][23]) || !isset($x[0][24]) || !isset($x[0][25]) || !isset($x[0][26]) || !isset($x[0][27]) || !isset($x[0][28]) || !isset($x[0][29]) || !isset($x[0][30]) || !isset($x[0][31]) || !isset($x[0][32]) || !isset($x[0][33])) {
                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing column.');
                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                    return;
                } else if (($x[0][0] != "Employee ID") || ($x[0][1] != "User Access") || ($x[0][2] != "Last Name") || ($x[0][3] != "Middle Name") || ($x[0][4] != "First Name") || ($x[0][5] != "Marital Status") || ($x[0][6] != "Home Address") || ($x[0][7] != "Current Address") || ($x[0][8] != "Birthday") || ($x[0][9] != "Gender") || ($x[0][10] != "Nationality") || ($x[0][11] != "Shirt Size") || ($x[0][12] != "Email Address") || ($x[0][13] != "Mobile Number") || ($x[0][14] != "Hired On") || ($x[0][15] != "Employment Type") || ($x[0][16] != "Position") || ($x[0][17] != "Division") || ($x[0][18] != "Group")  || ($x[0][19] != "Line") || ($x[0][20] != "Department") || ($x[0][21] != "Section") || ($x[0][22] != "Image File") || ($x[0][23] != "SSS Number") || ($x[0][24] != "Pagibig") || ($x[0][25] != "Philhealth") || ($x[0][26] != "TIN") || ($x[0][27] != "Drivers License") || ($x[0][28] != "National ID") || ($x[0][29] != "Passport") || ($x[0][30] != "HMO") || ($x[0][31] != "HMO Number") || ($x[0][32] != "Salary Rate") || ($x[0][33] != "Salary Type")) {
                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing or incorrect column labels.');
                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                    return;
                } else {
                    $succ_inserted      = [];
                    $data_arr           = [];
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        // $this->employees_model->UPDTRECORD($filedata);
                        // $this->db->update_batch('tbl_employee_infos', $filedata);
                        if (count($filedata) > 0) {
                            $newdate                            = str_replace('/', '-', $filedata[8]);
                            $birthday                           = date("Y-m-d", strtotime($newdate));
                            $newdate_2                          = str_replace('/', '-', $filedata[14]);
                            $hired_on                           = date("Y-m-d", strtotime($newdate_2));

                            $user_acess                         = convert_user_access_id($data['C_USER_ACCESS'], $filedata[1]);
                            if ($user_acess <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', '' . $filedata[2] . ' ' . $filedata[4] . ' User access is invalid.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $mari_stat_id                       = convert_name2id($data['C_MARITAL'], $filedata[5]);
                            if ($mari_stat_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', '' . $filedata[2] . ' ' . $filedata[4] . ' Marital status is invalid.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $nationality_id                     = convert_name2id($data['C_NATIONALITY'], $filedata[10]);
                            $gender_id                          = convert_name2id($data['C_GENDERS'],  $filedata[9]);
                            $shirt_size_id                      = convert_name2id($data['C_SHIRT_SIZE'],  $filedata[11]);

                            $empl_type_id                       = convert_name2id($data['C_TYPE'],  $filedata[15]);
                            if ($empl_type_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Employee type for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $position_id                        = convert_name2id($data['C_POSITIONS'],  $filedata[16]);
                            if ($position_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid position for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $division_id                        = convert_name2id($data['C_DIVISIONS'],  $filedata[17]);
                            if ($division_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid division for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $clubhouse_id                        = convert_name2id($data['C_CLUBHOUSE'],  $filedata[18]);
                            if ($clubhouse_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid clubhouse for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $group_id                           = convert_name2id($data['C_GROUPS'],  $filedata[19]);
                            if ($group_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid group for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $line_id                            = convert_name2id($data['C_LINES'],  $filedata[20]);
                            if ($line_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Line for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $department_id                      = convert_name2id($data['C_DEPARTMENTS'], $filedata[21]);
                            if ($department_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid department for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }
                            $section_id                         = convert_name2id($data['C_SECTIONS'],  $filedata[22]);
                            if ($section_id <= 0) {
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid section for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $hmo_id                             = convert_name2id($data['C_HMOS'],  $filedata[30]);

                            if ((substr(strval($filedata[13]), 0, 1) == '9') || (substr(strval($filedata[13]), 0, 1) == 9)) {
                                $mobile_number = '0' . strval($filedata[13]);
                            } else {
                                $mobile_number = ($filedata[13]);
                            }
                            $employee_id = strval($filedata[0]);
                            $empl_username = str_pad($employee_id, 5, "0", STR_PAD_LEFT);
                            $salt = bin2hex(openssl_random_pseudo_bytes(22));
                            $password = ucfirst($filedata[2] . '.' . date_format(date_create($birthday), "Y"));
                            $encrypted_password = md5($password . '' . $salt);

                            $value_arr = array(
                                'col_empl_cmid' => $employee_id,
                                'col_user_access' => $user_acess,
                                'col_user_date' => date('Y-m-d H:i:s'),
                                'col_user_name' => $empl_username,
                                'col_user_pass' => $encrypted_password,
                                'col_salt_key'  => $salt,
                                'col_last_name' => $filedata[2],
                                'col_midl_name' => $filedata[3],
                                'col_frst_name' => $filedata[4],
                                'col_mart_stat' => $mari_stat_id,
                                'col_home_addr' => $filedata[6],
                                'col_curr_addr' => $filedata[7],
                                'col_birt_date' => $birthday,
                                'col_empl_gend' => $gender_id,
                                'col_empl_nati' => $nationality_id,
                                'col_shir_size' => $shirt_size_id,
                                'col_empl_emai' => $filedata[12],
                                'col_mobl_numb' => $mobile_number,
                                'col_hire_date' => $hired_on,
                                'col_empl_divi' => $division_id,
                                'col_empl_club' => $clubhouse_id,
                                'col_empl_type' => $empl_type_id,
                                'col_empl_posi' => $position_id,
                                'col_empl_group' => $group_id,
                                'col_empl_line' =>  $line_id,
                                'col_empl_dept' => $department_id,
                                'col_empl_sect' => $section_id,
                                'col_imag_path' => $filedata[22],
                                'col_empl_sssc' => $filedata[23],
                                'col_empl_hdmf' => $filedata[24],
                                'col_empl_phil' => $filedata[25],
                                'col_empl_btin' => $filedata[26],
                                'col_empl_driv' => $filedata[27],
                                'col_empl_naid' => $filedata[28],
                                'col_empl_pass' => $filedata[29],
                                'col_empl_hmoo' => $hmo_id,
                                'col_empl_hmon' => $filedata[31],
                                'salary_rate' => $filedata[32],
                                'salary_type' => $filedata[33]
                            );
                            array_push($data_arr, $value_arr);
                            // $sql = "INSERT INTO tbl_employee_infos (col_empl_cmid, col_user_date, col_user_name, col_last_name, col_midl_name, col_frst_name, col_mart_stat, col_home_addr, col_curr_addr, col_birt_date, col_empl_gend, col_empl_nati, col_shir_size, col_empl_emai, col_mobl_numb, col_hire_date, col_empl_type, col_empl_posi, col_empl_dept, col_empl_sect, col_imag_path,col_empl_sssc ,col_empl_hdmf ,col_empl_phil ,col_empl_btin ,col_empl_driv ,col_empl_naid ,col_empl_pass ,col_empl_hmoo ,col_empl_hmon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                            // $this->db->query($sql,array($employee_id, date('Y-m-d H:i:s'), $filedata[11], $filedata[1], $filedata[2], $filedata[3], $filedata[4], $filedata[5], $filedata[6], $birthday, $filedata[8], $filedata[9], $filedata[10], $filedata[11], $mobile_number, $hired_on, $filedata[14], $filedata[15], $filedata[16], $filedata[17], $filedata[18], $filedata[19], $filedata[20], $filedata[21], $filedata[22], $filedata[23], $filedata[24], $filedata[25], $filedata[26], $filedata[27]));
                        }
                        array_push($succ_inserted, 'true');
                    }

                    if ((count($data_arr) > 0)) {
                        $seenValues = array();
                        $duplicates = array();

                        foreach ($data_arr as $subArray) {
                            if (isset($subArray['col_empl_cmid'])) {
                                $value = $subArray['col_empl_cmid'];
                                if (in_array($value, $seenValues)) {
                                    $duplicates[] = $value;
                                } else {
                                    $seenValues[] = $value;
                                }
                            }
                        }

                        if (!empty($duplicates)) {
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ' Duplicate of employee id found: ' . implode(', ', $duplicates));
                            redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                            return;
                        } else {
                            $this->db->update_batch('tbl_employee_infos', $data_arr, 'col_empl_cmid');
                        }
                    }

                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Imported CSV employee updates');
                    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'CSV File Successfully Uploaded!');
                    redirect('employees/directories', 'refresh');
                }
            } else # else for not successful upload
            {
                $error =  $this->upload->display_errors(); #displaying of the error
                //echo ("<script language='javascript'> alert('".$error."'); windows.history.back();</script>");
                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', $error);
                redirect('employees/directories', 'refresh');
            }
        }

        function upload_csv_new_employees()
        {
            $curdate                        = date('Y-m-d h:i:s');
            $rundate                        = substr($curdate, 5, 2) . substr($curdate, 8, 2) . substr($curdate, 2, 2) . "_" . substr($curdate, 11, 2) . substr($curdate, 14, 2) . substr($curdate, 17, 2);
            $file_name                      = 'Employee_' . $rundate;
            $path                           = "assets_system/files/employees/";
            $config['file_name']            = $file_name;
            $config['upload_path']          = "./assets_system/files/employees/";
            $config['allowed_types']        = '*';
            $config['max_size']             = '10000';
            $this->load->library('upload', $config);

            $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
            $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
            $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
            $data['C_POSITIONS']                = $this->employees_model->GET_POSITION();
            $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
            $data['C_SHIRT_SIZE']               = $this->employees_model->GET_SHIRT_SIZE();
            $data['C_GENDERS']                  = $this->employees_model->GET_GENDERS();
            $data['C_MARITAL']                  = $this->employees_model->GET_MARITAL();
            $data['C_NATIONALITY']              = $this->employees_model->GET_NATIONALITY();
            $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
            $data['C_LINES']                    = $this->employees_model->GET_LINES();
            $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
            $data['C_HMOS']                     = $this->employees_model->GET_HMO();
            $data['C_USER_ACCESS']              = $this->employees_model->GET_USER_ACCESS();


            if ($this->upload->do_upload('file')) {
                $name       = $_FILES["file"]["name"];
                $ext1       = explode(".", $name);
                $ext        = end($ext1);
                $file       = fopen(($path . $file_name . '.' . $ext), "r");
                $ctr        = 0;
                $x[$ctr]    = (fgetcsv($file));


                if (!isset($x[0][0]) || !isset($x[0][1]) || !isset($x[0][2]) || !isset($x[0][3]) || !isset($x[0][4]) || !isset($x[0][5]) || !isset($x[0][6]) || !isset($x[0][7]) || !isset($x[0][8]) || !isset($x[0][9]) || !isset($x[0][10]) || !isset($x[0][11]) || !isset($x[0][12]) || !isset($x[0][13]) || !isset($x[0][14]) || !isset($x[0][15]) || !isset($x[0][16]) || !isset($x[0][17]) || !isset($x[0][18]) || !isset($x[0][19]) || !isset($x[0][20]) || !isset($x[0][21]) || !isset($x[0][22]) || !isset($x[0][23]) || !isset($x[0][24]) || !isset($x[0][25]) || !isset($x[0][26]) || !isset($x[0][27]) || !isset($x[0][28]) || !isset($x[0][29]) || !isset($x[0][30]) || !isset($x[0][31]) || !isset($x[0][32]) || !isset($x[0][33])) {
                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing, incomplete, or incorrect field or column labels.');
                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                    return;
                } else if (($x[0][0] != "Employee ID") || ($x[0][1] != "User Access") || ($x[0][2] != "Last Name") || ($x[0][3] != "Middle Name") || ($x[0][4] != "First Name") || ($x[0][5] != "Marital Status") || ($x[0][6] != "Home Address") || ($x[0][7] != "Current Address") || ($x[0][8] != "Birthday") || ($x[0][9] != "Gender") || ($x[0][10] != "Nationality") || ($x[0][11] != "Shirt Size") || ($x[0][12] != "Email Address") || ($x[0][13] != "Mobile Number") || ($x[0][14] != "Hired On") || ($x[0][15] != "Employment Type") || ($x[0][16] != "Position") || ($x[0][17] != "Division") || ($x[0][18] != "Group")  || ($x[0][19] != "Line") || ($x[0][20] != "Department") || ($x[0][21] != "Section") || ($x[0][22] != "Image File") || ($x[0][23] != "SSS Number") || ($x[0][24] != "Pagibig") || ($x[0][25] != "Philhealth") || ($x[0][26] != "TIN") || ($x[0][27] != "Drivers License") || ($x[0][28] != "National ID") || ($x[0][29] != "Passport") || ($x[0][30] != "HMO") || ($x[0][31] != "HMO Number") || ($x[0][32] != "Salary Rate") || ($x[0][33] != "Salary Type")) {
                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing, incomplete, or incorrect field or column labels.');
                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                    return;
                } else {
                    $err_duplication    = [];
                    $succ_inserted      = [];
                    $data_arr           = [];
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $isDuplicated = $this->employees_model->CHECKDUPLICATEEMPLID($filedata[0]);
                        if ($isDuplicated) {
                            if ($isDuplicated[0]->col_empl_cmid) {
                                array_push($err_duplication, $isDuplicated[0]->col_empl_cmid);
                            }
                        } else {
                            // $this->employee_csv_model->insertRecord($filedata);

                            if (count($filedata) > 0) {
                                $newdate                            = str_replace('/', '-', $filedata[8]);
                                $birthday                           = date("Y-m-d", strtotime($newdate));
                                $newdate_2                          = str_replace('/', '-', $filedata[14]);
                                $hired_on                           = date("Y-m-d", strtotime($newdate_2));

                                $user_acess                         = convert_user_access_id($data['C_USER_ACCESS'], $filedata[1]);
                                if ($user_acess <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', '' . $filedata[2] . ' ' . $filedata[4] . ' User access is invalid.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $mari_stat_id                       = convert_name2id($data['C_MARITAL'], $filedata[5]);
                                if ($mari_stat_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', '' . $filedata[2] . ' ' . $filedata[4] . ' Marital status is invalid.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $nationality_id                     = convert_name2id($data['C_NATIONALITY'], $filedata[10]);
                                $gender_id                          = convert_name2id($data['C_GENDERS'],  $filedata[9]);
                                $shirt_size_id                      = convert_name2id($data['C_SHIRT_SIZE'],  $filedata[11]);

                                $empl_type_id                       = convert_name2id($data['C_TYPE'],  $filedata[15]);
                                if ($empl_type_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Employee type for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $position_id                        = convert_name2id($data['C_POSITIONS'],  $filedata[16]);
                                if ($position_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid position for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $division_id                        = convert_name2id($data['C_DIVISIONS'],  $filedata[17]);
                                if ($division_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid division for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $group_id                           = convert_name2id($data['C_GROUPS'],  $filedata[18]);
                                if ($group_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid group for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $line_id                            = convert_name2id($data['C_LINES'],  $filedata[19]);
                                if ($line_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Line for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $department_id                      = convert_name2id($data['C_DEPARTMENTS'], $filedata[20]);
                                if ($department_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid department for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }
                                $section_id                         = convert_name2id($data['C_SECTIONS'],  $filedata[21]);
                                if ($section_id <= 0) {
                                    $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid section for ' . $filedata[2] . ' ' . $filedata[4] . '.');
                                    redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                                    return;
                                }

                                $hmo_id                             = convert_name2id($data['C_HMOS'],  $filedata[30]);

                                if ((substr(strval($filedata[13]), 0, 1) == '9') || (substr(strval($filedata[13]), 0, 1) == 9)) {
                                    $mobile_number = '0' . strval($filedata[13]);
                                } else {
                                    $mobile_number = ($filedata[13]);
                                }
                                $employee_id = strval($filedata[0]);
                                $empl_username = str_pad($employee_id, 5, "0", STR_PAD_LEFT);
                                $salt = bin2hex(openssl_random_pseudo_bytes(22));
                                $password = ucfirst($filedata[2] . '.' . date_format(date_create($birthday), "Y"));
                                $encrypted_password = md5($password . '' . $salt);

                                $value_arr = array(
                                    'col_empl_cmid' => $employee_id,
                                    'col_user_access' => $user_acess,
                                    'col_user_date' => date('Y-m-d H:i:s'),
                                    'col_user_name' => $empl_username,
                                    'col_user_pass' => $encrypted_password,
                                    'col_salt_key'  => $salt,
                                    'col_last_name' => $filedata[2],
                                    'col_midl_name' => $filedata[3],
                                    'col_frst_name' => $filedata[4],
                                    'col_mart_stat' => $mari_stat_id,
                                    'col_home_addr' => $filedata[6],
                                    'col_curr_addr' => $filedata[7],
                                    'col_birt_date' => $birthday,
                                    'col_empl_gend' => $gender_id,
                                    'col_empl_nati' => $nationality_id,
                                    'col_shir_size' => $shirt_size_id,
                                    'col_empl_emai' => $filedata[12],
                                    'col_mobl_numb' => $mobile_number,
                                    'col_hire_date' => $hired_on,
                                    'col_empl_divi' => $division_id,
                                    'col_empl_type' => $empl_type_id,
                                    'col_empl_posi' => $position_id,
                                    'col_empl_group' => $group_id,
                                    'col_empl_line' =>  $line_id,
                                    'col_empl_dept' => $department_id,
                                    'col_empl_sect' => $section_id,
                                    'col_imag_path' => $filedata[22],
                                    'col_empl_sssc' => $filedata[23],
                                    'col_empl_hdmf' => $filedata[24],
                                    'col_empl_phil' => $filedata[25],
                                    'col_empl_btin' => $filedata[26],
                                    'col_empl_driv' => $filedata[27],
                                    'col_empl_naid' => $filedata[28],
                                    'col_empl_pass' => $filedata[29],
                                    'col_empl_hmoo' => $hmo_id,
                                    'col_empl_hmon' => $filedata[31],
                                    'salary_rate' => $filedata[32],
                                    'salary_type' => $filedata[33]
                                );
                                array_push($data_arr, $value_arr);
                                // $sql = "INSERT INTO tbl_employee_infos (col_empl_cmid, col_user_date, col_user_name, col_last_name, col_midl_name, col_frst_name, col_mart_stat, col_home_addr, col_curr_addr, col_birt_date, col_empl_gend, col_empl_nati, col_shir_size, col_empl_emai, col_mobl_numb, col_hire_date, col_empl_type, col_empl_posi, col_empl_dept, col_empl_sect, col_imag_path,col_empl_sssc ,col_empl_hdmf ,col_empl_phil ,col_empl_btin ,col_empl_driv ,col_empl_naid ,col_empl_pass ,col_empl_hmoo ,col_empl_hmon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                // $this->db->query($sql,array($employee_id, date('Y-m-d H:i:s'), $filedata[11], $filedata[1], $filedata[2], $filedata[3], $filedata[4], $filedata[5], $filedata[6], $birthday, $filedata[8], $filedata[9], $filedata[10], $filedata[11], $mobile_number, $hired_on, $filedata[14], $filedata[15], $filedata[16], $filedata[17], $filedata[18], $filedata[19], $filedata[20], $filedata[21], $filedata[22], $filedata[23], $filedata[24], $filedata[25], $filedata[26], $filedata[27]));
                            }
                            array_push($succ_inserted, 'true');
                        }
                    }
                    // 	echo '<pre>';
                    // 	var_dump($data_arr);
                    //    return;


                    if ((count($data_arr) > 0)) {
                        $seenValues = array();
                        $duplicates = array();

                        foreach ($data_arr as $subArray) {
                            if (isset($subArray['col_empl_cmid'])) {
                                $value = $subArray['col_empl_cmid'];
                                if (in_array($value, $seenValues)) {
                                    $duplicates[] = $value;
                                } else {
                                    $seenValues[] = $value;
                                }
                            }
                        }

                        if (!empty($duplicates)) {
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ' Duplicate of employee id found: ' . implode(', ', $duplicates));
                            redirect('employees/csv_upload', 'refresh'); //redirect('csv/index','refresh');
                            return;
                        } else {
                            $this->db->insert_batch('tbl_employee_infos', $data_arr);
                        }
                    }

                    if ((count($err_duplication) > 0) && (count($succ_inserted) == 0)) {
                        $duplicated_ids = '';
                        foreach ($err_duplication as $err_duplication_row) {
                            $duplicated_ids .= $err_duplication_row . ' <br>';
                        }
                        $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', count($err_duplication) . ' Duplicated Employee ids detected. <br>');
                    } else if ((count($succ_inserted) > 0) && (count($err_duplication) == 0)) {
                        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Imported new employees via CSV');
                        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'CSV File Successfully Uploaded!');
                    } else if ((count($succ_inserted) > 0) && (count($err_duplication) > 0)) {
                        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Imported new employees via CSV');
                        $duplicated_ids = '';
                        foreach ($err_duplication as $err_duplication_row) {
                            $duplicated_ids .= $err_duplication_row . ' <br>';
                        }
                        $this->session->set_userdata('SESS_WARN_MSG_INSRT_CSV', count($err_duplication) . 'Duplicated Employee id/s detected. <br>');
                    }

                    // redirect('employees','refresh');
                    redirect('employees/directories', 'refresh'); //redirect('attendance/generate_rows');
                }
            } else # else for not successful upload
            {
                $error =  $this->upload->display_errors(); #displaying of the error
                //echo ("<script language='javascript'> alert('".$error."'); windows.history.back();</script>");
                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', $error);
                redirect('employees/directories', 'refresh');
            }
        }
        // =========================================== ASYNC REQUESTS =======================================
        function get_all_employee()
        {
            $page_num                   = $this->input->post('page_num');
            $num_limit                  = 20;
            if ($page_num <= 1) {
                $num_start = 0;
            } else {
                $num_start = 20 * ($page_num - 1);
            }
            $data                       = $this->employees_model->MOD_DISP_ALL_EMPLOYEES_PAGINATION($num_start, $num_limit);
            echo (json_encode($data));
        }
        function get_all_employee_data()
        {
            $data                       = $this->employees_model->MOD_DISP_ALL_EMPLOYEES();
            echo (json_encode($data));
        }
        function get_empl_data()
        {
            $empl_id                    = $this->input->post('empl_id');
            $data                       = $this->employees_model->MOD_DISP_EMPLOYEE($empl_id);
            echo (json_encode($data));
        }

        function process_salary_update($user_id, $value)
        {

            $this->employees_model->UPDATE_SALARY_DETAILS($user_id, $value);

            $this->session->set_userdata('SESS_SUCCESS', 'Salary Details Updated Successfully!');
            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }
            // redirect('employees/salary_details');
        }

        function process_salary_type_update($user_id, $value)
        {
            $this->employees_model->UPDATE_SALARY_TYPE_DETAILS($user_id, $value);

            $this->session->set_userdata('SESS_SUCCESS', 'Salary Details Updated Successfully!');
            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }
            // redirect('employees/salary_details');
        }


        function update_salary_detail_bulk()
        {
            $empl_id                             = $this->input->post('UPDATE_ID');
            $salary_amount                         = $this->input->post('UPDT_SALARY_AMOUNT');
            $salary_type                         = $this->input->post('UPDT_SALARY_TYPE');

            $empl_ids                           = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $this->employees_model->UPDATE_SALARY_BULK($id, $salary_amount, $salary_type);
            }

            $this->session->set_userdata('SESS_SUCCESS', 'Salary Details Updated Successfully!');
            if (isset($_SERVER["HTTP_REFERER"])) {
                redirect($_SERVER["HTTP_REFERER"]);
            }

            // redirect('employees/salary_details');

        }


        function employee_bulk_activate()
        {
            $empl_id                           = $this->input->post('EMPLOYEE_ID');
            $value                               = $this->input->post('ACTIVATE');

            $empl_ids                         = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $this->employees_model->UPDATE_EMPLOYEE_DISABLED($id, $value);
            }

            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk activated employees');
            redirect('employees/directories');
        }

        function employee_bulk_deactivate()
        {
            $empl_id                           = $this->input->post('EMPLOYEE_DEACTIVATE_ID');
            $value                               = $this->input->post('ACTIVATE');

            $empl_ids                         = explode(",", $empl_id);

            foreach ($empl_ids as $id) {

                $this->employees_model->UPDATE_EMPLOYEE_DISABLED($id, $value);
            }

            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk deactivated employees');
            redirect('employees/directories');
        }

        function update_data_payroll_assignment()
        {
            $data = json_decode(file_get_contents('php://input'), true);

            try {
                foreach ($data as $data_row) {
                    $this->employees_model->update_assignment_data($data_row);
                }
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated payroll assignment');
                $response = array('success_message' => 'Data updated successfully');
            } catch (Exception $e) {
                $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
            }


            echo json_encode($response);
        }

        function offboarding()
        {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Processed employee offboarding');
            $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
            $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
            $offset                     = $limit * ($page - 1);
            $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
            $search_query               = $this->input->get('all');

            $data['DISP_ASSETS_INFO']      = $this->assets_model->MOD_DISP_AST_CAT($limit, $offset, $status, $search_query);
            $data['ACTIVES']            = count($this->assets_model->MOD_DISP_AST_CAT($limit, $offset, 'Active', $search_query));
            $data['INACTIVES']          = count($this->assets_model->MOD_DISP_AST_CAT($limit, $offset, 'Inactive', $search_query));
            $total_count                = $this->assets_model->GET_AST_CAT_COUNT($status);
            $excess                     = $total_count % $limit;
            $data['C_DATA_COUNT']       = $total_count;
            $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
            $data['PAGE']               = $page;
            $data['ROW']                = $limit;
            $data['C_ROW_DISPLAY']      = array(10, 25, 50);
            $data['TAB']                = $status;

            $this->load->view('templates/header');
            $this->load->view('modules/employees/offboarding_views', $data);
        }



        //-------------------------------------------------------- CRUD FUNCTIONS ends
    }


    function convert_name2id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $nameLower = strtolower($e->name);
            if ($nameLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
        // if ($id == "") {
        //     $id = "error: can't be found";
        // }
    }

    function convert_user_access_id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $userAccessLower = strtolower($e->user_access);
            if ($userAccessLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
    }


    function filter_array($user_modules, $user_access)
    {
        $modules = array();
        foreach ($user_modules as $module) {
            foreach ($user_access as $access) {
                if (isset($module["value"])) {
                    if ($module["value"] == $access) {
                        $modules[] = $module;
                    }
                } else {
                    if ($module["title"] == $access) {
                        $modules[] = $module;
                    }
                }
            }
        }
        $modules = array_unique($modules, SORT_REGULAR);
        return $modules;
    }

    function returnString($array, $name, $id)
    {
        $string = '';
        foreach ($array as $item) {
            if ($item->id == $id) {
                $string = $item->$name;
                break;
            };
        }
        return $string;
    }
