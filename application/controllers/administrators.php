<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class administrators extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('uri');
        $this->load->library('logger');
        $this->load->model('templates/main_nav_model');
        $this->load->model('templates/main_table_01_model');
        $this->load->model('modules/administrators_model');

        // auto login starts
        $this->load->model('admin_model');
        $auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
        if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
            $this->session->set_userdata('SESS_USER_ID', 1);
        }
        // auto login ends

        $method = $this->uri->segment(2);

        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
        }
        $data2 = null;
        //controller/module protection starts
        $userModules       = $this->main_nav_model->get_user_access_modules($this->session->userdata('SESS_USER_ID'));
        $modulesArray      = explode(", ", $userModules);
        $data2['condition1'] = (!in_array('administrator_modules', $modulesArray));
        // if (!in_array('administrator_modules', $modulesArray)) {
        if ($data2['condition1']  && !$this->session->userdata('SESS_ADMIN')) {
            $data2['echo1'] = 'module denied';
            redirect('login/session_expired');
        }
        //controller/module protection ends

        //pages/sub modules protection starts


        // $temporaryRouteAccess = array('user_access_api','update_user_access','update_settings','employee_update','get_employee_data','update_data',
        // 'remote_attendance_api','user_activation_api','user_activation','homesettings','structuresettings','skill_assign','adjustments','allowances','companies',
        // 'branches','divisions','deductions','taxable_deductions','non_taxable_deductions','positions','employment_types','skill_levels','genders','nationalities',
        // 'shirt_sizes','marital_statuses','skill_names','hmos','departments','sections','groups','lines','teams','blood_types','religions','banks','asset_categories',
        // 'GET_USER_ACCESS_BY_ID','UPDATE_USER_ACCESS','ADD_USER_ACCESS','leave_types','company_locations','employee_types','holidays','knowledge_articles','knowledge_categories',
        // 'pay_grade','stockrooms','termination_reasons','resignation_reasons','employee_requirements','biometrics','years','taxable_allowances','loan_types','non_taxable_allowances',
        // 'ip_address','ip_address_form','insert_ip_address','delete_id_address','reset_empl_password','update_empl_user_access','update_setting','update_ip_address','update_status',
        // 'update_general_settings','termination_types');

        // $data2['method'] = $method;

        // $data2['condition2'] = (!empty($method) && !(in_array($method, $temporaryRouteAccess)));
        // // $data2['condition3'] = (!(in_array($method, $temporaryRouteAccess)));


        // // if (!empty($method) && !(in_array($method, $temporaryRouteAccess))) {
        // if ($data2['condition2']) {
        //     $userPages = $this->main_nav_model->get_user_access_pages($this->session->userdata('SESS_USER_ID'));
        //     $pagesArray = array(
        //         'access'=>"Access Management", 
        //         'activity_logs'=>"Activity Logs(Admin)",
        //         'useraccess'=>"User Accessibility",
        //         'taxable_allowances'=>"Standard Settings",
        //         'ip_address'=>"IP Address",
        //         'generalsettings'=>"General Settings",
        //         'self_service_settings'=>'Self Service Settings',
        //     );

        //     if (!array_key_exists($method, $pagesArray)) {
        //         $data2['echo2']= 'page denied method not found in keys';
        //         var_dump($data2); die();
        //         redirect('login/session_expired');
        //     }
        //     $pageValue = $pagesArray[$method];
        //     if (strpos($userPages, $pageValue) === false) {
        //         $data2['echo3']= 'page denied';
        //         redirect('login/session_expired'); 
        //     }
        // }
        // var_dump($data2);
        // die();
        $maintenance      = $this->login_model->GET_MAINTENANCE();
        $isAdmin          = $this->session->userdata('SESS_ADMIN');
        if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
        }
    }

    function index()
    {
        $data["Modules"]    =  array(
            array("title" => "Access Management",           "value" => "Access Management",     "icon" => "building-lock-duotone.svg",        "info" => "Allows administrators to define different user roles, each with specific permissions and access levels. Common roles may include HR administrators, managers, and other staff members. ",        "url" => "administrators/access",               "access" => "Administrator", "id" => "access_management"),
            // array("title" => "Home Settings",               "value" => "Home Settings",         "icon" => "fa-duotone fa-house-user",                   "url" => "administrators/homesettings",         "access" => "Administrator", "id" => "home_settings"),
            array("title" => "User Accessibility",          "value" => "User Accessibility",    "icon" => "plane-circle-check-duotone.svg",   "info" => "Allows administrators to have fine-tuned permissions tailored to their job responsibilities. This ensures that individuals only have access to the features and data necessary for their roles.",        "url" => "administrators/useraccess",           "access" => "Administrator", "id" => "user_accessibility"),
            // array("title" => "Default Options",           "value" => "Standard Settings",     "icon" => "building-shield-duotone.svg",      "info"=>"Let administrators assign specific roles within the system based on their positions or responsibilities in the organization.",        "url" => "administrators/positions",             "access" => "Administrator", "id" => "standard_settings"),
            array("title" => "User Access Logs",            "value" => "User Access Logs",     "icon" => "plane-circle-check-duotone.svg", "info" => " Provide records of user activities, detailing who accessed the system and when. Enhance security and accountability by tracking user interactions, and helps administrators monitor system usage efficiently.",               "url" => "administrators/user_access_logs",    "access" => "Administrator", "id" => "user_access_logs"),
            array("title" => "Activity Logs",               "value" => "Admin-Activity Logs",  "icon" => "universal-access-duotone.svg",     "info" => "These logs provide a comprehensive audit trail of changes, updates, and interactions within the HRMS.",               "url" => "administrators/activity_logs",        "access" => "Administrator", "id" => "activity_logs"),
            array("title" => "IP Address",                  "value" => "IP Address",            "icon" => "block-brick-fire-duotone.svg",     "info" => "Lets you view or add users allowed to access the HRMS based on their IP (Internet Protocol) address.",        "url" => "administrators/ip_address",           "access" => "Administrator", "id" => "ip_address"),
            array("title" => "General Settings",            "value" => "General Settings",      "icon" => "gears-duotone.svg",       "info" => "Allows administrators configure parameters and options that control the overall behavior and appearance of the system.",          "url" => "administrators/generalsettings",      "access" => "Administrator", "id" => "general_settings"),
            // array("title" => "Self Service Settings",       "value" => "Self Service Settings", "icon" => "solar-system-duotone.svg",         "info" => "Allows administrators disable or enable additional type of absences (Absences AWOL or Absences LWOP)",        "url" => "administrators/self_service_settings", "access" => "Administrator", "id" => "self_service_settings"),
            array("title" => "Request List",       "value" => "Admin-Request List", "icon" => "solar-system-duotone.svg",         "info" => "",        "url" => "administrators/request_list", "access" => "Administrator", "id" => "request_list_admin"),
            // array("title" => "Geo Fencing Settings",       "value" => "Admin-Geo Fencing Settings", "icon" => "solar-system-duotone.svg",         "info" => "",        "url" => "administrators/geo_fencing_settings", "access" => "Administrator", "id" => "admin_geo_fencing_settings"),
        );

        $data["title_page"]                    = "Administrator Module";
        $data["title_description"]              = "Serves as the central control panel for managing system-wide settings, user access, and overall configuration";
        $user_access_id                        = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
        $data['DISP_USER_ACCESS_PAGE']         = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
        $array_page                            = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
        $data["maiya_theme"]                               = $this->administrators_model->GET_MAYA_THEME();
        $data['Modules']                       = filter_array($data["Modules"], $array_page);

        $this->load->view('templates/header');
        $this->load->view('templates/main_container', $data);
    }

    function request_list()
    {
        $selectColumns = [
            ['selectStatement' => 'id,request_details,status'],
        ];
        $filter = [
            // ['year' => $tab],
        ];
        $table = 'tbl_requests_list';
        $dataTable               = $this->administrators_model->get_table($table, $filter, $selectColumns);
        //   $dataTable               = json_encode($dataTable);
        $data["dataTable"]    = $dataTable;
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/request_list_views', $data);
    }

    function add_request_list()
    {
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
        $res = $this->administrators_model->insert_data_table($table, $input_data);
        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added new request list');
            $this->session->set_flashdata('SUCC', 'Successfully Submitted');
        } else {
            $this->session->set_flashdata('ERR', 'Submission Failed');
        }
        redirect($this->input->server('HTTP_REFERER'));
    }

    function view_request_list($id)
    {
        $selectColumns = [
            ['selectStatement' => 'id,request_details,status'],
        ];
        $filter = [
            ['id' => $id],
        ];
        $table = 'tbl_requests_list';
        $dataTable               = $this->administrators_model->get_table($table, $filter, $selectColumns);

        $data["dataTable"]    = $dataTable;
        echo json_encode($data);
    }

    function activity_logs()
    {
        $employee                              = $this->input->get('employee');
        $limit                                 = $this->input->get('row') ? $this->input->get('row') : 25;
        $page                                  = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                                = $limit * ($page - 1);

        $data['C_ACTIVITIES']                  = $this->administrators_model->GET_ACTIVITY_LOGS($employee, $limit, $offset);
        $total_count                           = $this->administrators_model->GET_ACTIVITY_LOGS_COUNT($employee);
        $excess                                = $total_count % $limit;
        $data['C_DATA_COUNT']                  = $total_count;
        $data['PAGES_COUNT']                   = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']                          = $page;
        $data['ROW']                           = $limit;
        $data['C_ROW_DISPLAY']                 = array(10, 25, 50);
        $data['EMPLOYEE_FILTER']               = $employee;
        $data['DATE_FORMAT']                   = $this->administrators_model->GET_SYSTEM_SETTING("date_format");
        $data['C_EMPLOYEES_ID']                = $this->administrators_model->GET_EMPLOYEE_IDS();
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/activity_log_views', $data);
    }
    function user_access_logs()
    {
        $data['DATE_FORMAT']                            = $this->administrators_model->GET_SYSTEM_SETTING("date_format");
        $data['EMPLOYEES']                              = $this->administrators_model->get_employee_list();
        $employee                                       = $this->input->get('employee');
        $data['TABLE_DATA']                             = array();
        $status                                         = $this->input->get('status');
        $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                                         =  $limit * ($page - 1);

        $data['STATUS']                                 = $status;
        $data['STATUSES']                               = array('Pending', 'Approved', 'Rejected');
        $data['TABLE_DATA']                             = $this->administrators_model->GET_USER_ACCESS_LOGS($employee, $limit, $offset);
        $total_count                                    = $this->administrators_model->GET_USER_ACCESS_LOGS_COUNT($employee);
        $excess                                         = $total_count % $limit;
        $data['C_DATA_COUNT']                           = $total_count;
        $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']                                   = $page;
        $data['ROW']                                    = $limit;
        $data['C_ROW_DISPLAY']                          = array(10, 25, 50);
        // echo '<pre>';
        // var_dump($data['EMPLOYEES'] )
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/user_access_log_views', $data);
    }
    function access()
    {
        $search                                = str_replace('_', ' ', $this->input->get('search') ?? "");
        $page                                  = $this->input->get('page');
        $row                                   = $this->input->get('row');
        $tab                                   = $this->input->get('tab');

        $company                               = $this->input->get('company');
        $dept                                  = $this->input->get('dept');
        $sec                                   = $this->input->get('sec');
        $group                                 = $this->input->get('group');
        $line                                  = $this->input->get('line');
        $branch                                = $this->input->get('branch');
        $division                              = $this->input->get('division');
        $clubhouse                             = $this->input->get('clubhouse');
        $team                                  = $this->input->get('team');

        $is_active = 0;
        if ($row == null) {
            $row = 10;
        }
        if ($page  == null) {
            $page = 1;
        }
        if ($tab == null) {
            $tab = 'Active';
        }
        if ($tab == 'Inactive') {
            $is_active = 1;
        }
        $data['TAB'] = $tab;
        $data['INACTIVES']                      = $this->administrators_model->GET_INACTIVE_USER_COUNT();
        $data['ACTIVES']                        = $this->administrators_model->GET_ACTIVE_USER_COUNT();

        $offset = $row * ($page - 1);

        $user_count                             = $this->administrators_model->GET_USER_COUNT($is_active);

        if ($this->input->get('search') == null) {
            $data['C_USERS']                    = $this->administrators_model->GET_USERS($row, $offset, $is_active, $company, $dept, $sec, $group, $line, $branch, $division, $team, $clubhouse);
        } else {
            $data['C_USERS']                    = $this->administrators_model->GET_SEARCHED_USERS($row, $offset, $search, $is_active);
            $user_count                         = $this->administrators_model->GET_SEARCH_USER_COUNT($search, $is_active);
            $data['INACTIVES']                  = $this->administrators_model->GET_SEARCH_IS_ACTIVE_COUNT($search, 1);
            $data['ACTIVES']                    = $this->administrators_model->GET_SEARCH_IS_ACTIVE_COUNT($search, 0);
        }

        $data['C_POSITIONS']                    = $this->administrators_model->GET_POSITIONS();
        $data['C_USER_ACCESS']                  = $this->administrators_model->GET_USER_ACCESS();
        $excess                                 = $user_count % $row;
        $data['ROW']                            = $row;
        $page_count                             = $user_count / $data['ROW'];
        $data['PAGE']                           = $page;
        $data['PAGES_COUNT']                    = $excess > 0 ? intval($page_count) + 1 : intval($page_count);
        $data['ALL']                            = $search;
        $data['C_DATA_COUNT']                   = $user_count;

        $data['DISP_VIEW_COMPANY']              = $this->administrators_model->GET_SYSTEM_SETTING("com_company");
        $data['DISP_VIEW_BRANCH']               = $this->administrators_model->GET_SYSTEM_SETTING("com_branch");
        $data['DISP_VIEW_DIVISION']             = $this->administrators_model->GET_SYSTEM_SETTING("com_division");
        $data['DISP_VIEW_CLUBHOUSE']             = $this->administrators_model->GET_SYSTEM_SETTING("com_clubhouse");
        $data['DISP_VIEW_TEAM']                 = $this->administrators_model->GET_SYSTEM_SETTING("com_team");
        $data['DISP_VIEW_DEPARTMENT']           = $this->administrators_model->GET_SYSTEM_SETTING("com_Department");
        $data['DISP_VIEW_SECTION']              = $this->administrators_model->GET_SYSTEM_SETTING("com_section");
        $data['DISP_VIEW_GROUP']                = $this->administrators_model->GET_SYSTEM_SETTING("com_group");
        $data['DISP_VIEW_LINE']                 = $this->administrators_model->GET_SYSTEM_SETTING("com_line");

        $data['C_COMPANY']                      = $this->administrators_model->GET_COMPANY();
        $data['C_DEPARTMENTS']                  = $this->administrators_model->GET_DEPARTMENTS();
        $data['C_SECTIONS']                     = $this->administrators_model->GET_SECTIONS();
        $data['C_GROUPS']                       = $this->administrators_model->GET_GROUPS();
        $data['C_CLUBHOUSE']                    = $this->administrators_model->GET_CLUBHOUSE();
        $data['C_LINES']                        = $this->administrators_model->GET_LINES();
        $data['C_TEAMS']                        = $this->administrators_model->GET_TEAMS();
        $data['C_BRANCH']                       = $this->administrators_model->GET_BRANCHES();
        $data['C_DIVISIONS']                    = $this->administrators_model->GET_DIVISIONS();

        // Search Employee List starts
        $employeeSearchRaw                  = $this->administrators_model->GET_ALL_EMPLOYEES_SEARCH_DIRECTORIES();
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
        $this->load->view('modules/administrator/user_access_management_views', $data);
    }

    function employee_update()
    {

        $data['C_POSITIONS']                    = $this->administrators_model->GET_POSITION();
        $data['C_USER_ACCESS']                  = $this->administrators_model->GET_USER_ACCESS();

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/employee_quick_update_views', $data);
    }

    function get_employee_data()
    {

        $result = array();
        $data                                   = $this->administrators_model->GET_EMPLOYEE_DATA();
        $position                               = $this->administrators_model->GET_POSITION();
        $user_access                            = $this->administrators_model->GET_USER_ACCESS();

        foreach ($data as $row) {
            $result[] = [
                'id' => $row->id,
                'col_empl_cmid' => $row->col_empl_cmid,
                'fullname' => $row->fullname,
                'col_empl_posi' => $this->convert_id2name($position, $row->col_empl_posi),
                'col_user_access' => $this->convert_id2name_userAccess($user_access, $row->col_user_access),
                'remote_att' => ($row->remote_att == 1) ? 'Enabled' : 'Disabled',
                'disabled' => ($row->disabled == 0) ? 'Active' : 'Inactive',
            ];
        }

        echo (json_encode($result));
    }

    function update_data()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $count = 0;
            foreach ($data as $innerArray) {
                if (isset($innerArray[6]) && $innerArray[6] === 'Active') {
                    $count++;
                }
            }
            $result = $this->administrators_model->CHECK_ACTIVE_LIMIT($count);
            if ($result) {
                $response = $result;
                echo json_encode($response);
                return;
            }

            foreach ($data as $data_row) {
                $this->administrators_model->update_data($data_row);
            }
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated employee data (bulk update)');
            $response = array('messageSuccess' => 'Data updated successfully', 'result' => $result, 'count' => $count, 'data' => $data);
            echo json_encode($response);
            return;
        } catch (Exception $e) {
            $response = array('messageError' => 'Error updating data: ' . $e->getMessage());
            echo json_encode($response);
            return;
        }
    }

    function convert_id2name_userAccess($array, $id)
    {
        $name = "";
        foreach ($array as $e) {
            if ($id == $e->id) {
                $name = $e->user_access;
                return $name;
            }
        }
        return 0;
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
        return 0;
    }

    function user_access_api()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $result = $this->administrators_model->SET_USER_ACCESS_EMPLOYEE($data['userId'], $data['value']);
            if (!$result) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated user access for employee ID: ' . $data['userId']);
                $this->session->set_flashdata('SUCC', 'Updating User Successful');
                $response = array('messageSuccess' => 'Updating User Successful');
            } else if ($result && $result['messageError']) {
                $this->session->set_flashdata('ERR', $result['messageError']);
                $response = $result;
            } else {
                $this->session->set_flashdata('ERR', 'Unexpected Error Occured');
                $response = array('messageError' => 'Unexpected Error Occured');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('ERR', 'Error updating data: ' . $e->getMessage());
            $response = array('messageError' => 'Error updating data: ' . $e->getMessage());
        }
        echo json_encode($response);
    }

    function remote_attendance_api()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $result = $this->administrators_model->SET_REMOTE_ATTENDANCE_EMPLOYEE($data['userId'], $data['value']);
            if (!$result) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated remote attendance for employee ID: ' . $data['userId']);
                $this->session->set_flashdata('SUCC', 'Updating User Successful');
                $response = array('messageSuccess' => 'Updating User Successful');
            } else if ($result && $result['messageError']) {
                $this->session->set_flashdata('ERR', $result['messageError']);
                $response = $result;
            } else {
                $this->session->set_flashdata('ERR', 'Unexpected Error Occured');
                $response = array('messageError' => 'Unexpected Error Occured');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('ERR', 'Error updating data: ' . $e->getMessage());
            $response = array('messageError' => 'Error updating data: ' . $e->getMessage());
        }
        echo json_encode($response);
    }

    function user_activation_api()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        try {
            $result = $this->administrators_model->SET_ACTIVATION_EMPLOYEE($data['userId'], $data['value']);
            if (!$result) {
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated user activation status for employee ID: ' . $data['userId']);
                $this->session->set_flashdata('SUCC', 'Updating User Successful');
                $response = array('messageSuccess' => 'Updating User Successful');
            } else if ($result && $result['messageError']) {
                $this->session->set_flashdata('ERR', $result['messageError']);
                $response = $result;
            } else {
                $this->session->set_flashdata('ERR', 'Unexpected Error Occured');
                $response = array('messageError' => 'Unexpected Error Occured');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('ERR', 'Error updating data: ' . $e->getMessage());
            $response = array('messageError' => 'Error updating data: ' . $e->getMessage());
        }

        echo json_encode($response);
    }

    function user_activation($user_id, $is_disabled)
    {
        $this->administrators_model->SET_ACTIVATION_EMPLOYEE($user_id, $is_disabled);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), ($is_disabled ? 'Deactivated' : 'Activated') . ' user ID: ' . $user_id);
        redirect("administrators/access");
    }

    function homesettings()
    {
        $data["HOME_ANNOUNCEMENT"]              = $this->administrators_model->GET_HOME_ANNOUNCEMENT();
        $data["HOME_CELEB"]                     = $this->administrators_model->GET_HOME_CELEBRATION();
        $data["HOME_DATE"]                      = $this->administrators_model->GET_HOME_DATE();
        $data["HOME_LEAVE"]                     = $this->administrators_model->GET_HOME_LEAVE();
        $data["HOME_WHOS_OUT"]                  = $this->administrators_model->GET_HOME_WHOS_OUT();
        $data["HOME_START_GUIDE"]               = $this->administrators_model->GET_HOME_START_GUIDE();
        $data["HOME_NEW_MEMBER"]                = $this->administrators_model->GET_HOME_NEW_MEMBER();

        $data["HOME_TIMERECORD"]              = $this->administrators_model->GET_HOME_TIMERECORD();
        $data["HOME_ATTENDANCE_SUMMARY"]                     = $this->administrators_model->GET_HOME_ATTENDANCE_SUMMARY();
        $data["HOME_REQUEST"]                      = $this->administrators_model->GET_HOME_REQUEST();
        $data["HOME_APPROVAL"]                     = $this->administrators_model->GET_HOME_APPROVAL();
        $data["HOME_UPCOMING_HOLIDAYS"]                  = $this->administrators_model->GET_HOME_UPCOMING_HOLIDAYS();

        $this->load->view('templates/header', $data);
        $this->load->view('modules/administrator/home_setting_views', $data);
    }
    function time_keeping_settings()
    {
        $data['remoteCamera']                               = $this->administrators_model->get_system_setup_by_setting('remoteCamera');
        $data['remoteGPS']                                  = $this->administrators_model->get_system_setup_by_setting('remoteGPS');
        $data['requireApprovers']                           = $this->administrators_model->get_system_setup_by_setting('requireApprovers');
        $this->load->view('templates/header', $data);
        $this->load->view('modules/administrator/time_keeping_setting_views', $data);
    }
    function employee_settings()
    {
        $data['requireApprovers']                           = $this->administrators_model->get_system_setup_by_setting('requireApprovers');
        $this->load->view('templates/header', $data);
        $this->load->view('modules/administrator/employee_setting_views', $data);
    }
    function company_settings()
    {
        $data['COM_COMPANY']                                = $this->administrators_model->get_system_setup_by_setting('com_company');
        $data['COM_BRANCH']                                 = $this->administrators_model->get_system_setup_by_setting('com_branch');
        $data['COM_DEPARTMENT']                             = $this->administrators_model->get_system_setup_by_setting('com_Department');
        $data['COM_DIVISION']                               = $this->administrators_model->get_system_setup_by_setting('com_division');
        $data['COM_CLUBHOUSE']                              = $this->administrators_model->get_system_setup_by_setting('com_clubhouse');
        $data['COM_SECTION']                                = $this->administrators_model->get_system_setup_by_setting('com_section');
        $data['COM_GROUP']                                  = $this->administrators_model->get_system_setup_by_setting('com_group');
        $data['COM_TEAM']                                   = $this->administrators_model->get_system_setup_by_setting('com_team');
        $data['COM_LINE']                                   = $this->administrators_model->get_system_setup_by_setting('com_line');
        $this->load->view('templates/header', $data);
        $this->load->view('modules/administrator/company_setting_views', $data);
    }
    function administrator_settings()
    {
        $data['system_administrator']                       = $this->administrators_model->get_system_setup_by_setting('system_administrator');
        $data['hr_administrator']                           = $this->administrators_model->get_system_setup_by_setting('hr_administrator');
        $data['payroll_administrator']                      = $this->administrators_model->get_system_setup_by_setting('payroll_administrator');
        $data['allow_admin_access_payroll']                 = $this->administrators_model->get_system_setup_by_setting('allow_admin_access_payroll');
        $data['allow_payroll_access_hr']                    = $this->administrators_model->get_system_setup_by_setting('allow_payroll_access_hr');
        $data['EMPLOYEE_LISTS']                             = $this->administrators_model->get_employee_list();
        $this->load->view('templates/header', $data);
        $this->load->view('modules/administrator/administrator_setting_views', $data);
    }
    function payroll_settings()
    {
        $payroll_rankandfile                                 = $this->administrators_model->get_system_setup_by_setting('payroll_rankandfile');
        $data['payroll_rankandfile']                        = explode(",", $payroll_rankandfile['value']);
        $payroll_managers                                   = $this->administrators_model->get_system_setup_by_setting('payroll_managers');
        $data['EMPLOYEE_LISTS']                             = $this->administrators_model->get_employee_list();
        $data['payroll_managers']                            = explode(",", $payroll_managers['value']);
        $this->load->view('templates/header', $data);
        $this->load->view('modules/administrator/payroll_setting_views', $data);
    }
    function update_settings()
    {
        $input_data = $this->input->post();
        // var_dump($input_data); die();
        $validKeys = [
            'home_announcement',
            'home_celebration',
            'home_date',
            'home_team_members',
            'home_leave_info',
            'home_whos_out',
            'home_start_guide',
            'home_new_member',
            'home_holiday',
            'home_my_time_record',
            'home_attendance_summary',
            'home_requests',
            'home_approval',
            'home_upcoming_holidays',
            'remoteGPS',
            'remoteCamera',
            'requireApprovers',
            'com_company',
            'com_branch',
            'com_Department',
            'com_division',
            'com_clubhouse',
            'com_section',
            'com_group',
            'com_team',
            'com_line',
            'system_administrator',
            'hr_administrator',
            'payroll_administrator',
            'allow_admin_access_payroll',
            'allow_payroll_access_hr',
            'payroll_rankandfile',
            'payroll_managers',

        ];
        $input_data             = array_intersect_key($input_data, array_flip($validKeys));

        // echo '<pre>';
        // var_dump($input_data);
        // return;
        // $settings= array_keys($input_data);
        $res = $this->administrators_model->UPDATE_HOME_SETTINGS($input_data);
        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated system settings');
            $this->session->set_flashdata('SUCC', 'Successfully updated');
        } else {
            $this->session->set_flashdata('ERR', 'Settings Unable to update');
        }
        redirect($this->input->server('HTTP_REFERER'));
    }
    function structuresettings()
    {
        $data["C_COM_STRUCTURE"]                = $this->administrators_model->GET_COMP_STRUCTURE();
        $data["C_COM_COMPANY"]                  = $this->administrators_model->GET_SYSTEM_SETTING_DATA('com_company');

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/company_structure_setting_views', $data);
    }

    function generalsettings()
    {
        $data['DISP_COMPANY_NAME']                          = $this->administrators_model->get_company_name();
        $data['DISP_NAVBAR_LOGO']                           = $this->administrators_model->get_navbar();
        $data['DISP_LOGIN_LOGO']                            = $this->administrators_model->get_login_logo();
        $data['DISP_HEADER_LOGO']                           = $this->administrators_model->get_header();
        $data['DISP_HEADER_CONTENT']                        = $this->administrators_model->get_header_content();
        $data['NUM_APPROVERS']                              = $this->administrators_model->get_system_setup_by_setting('num_approvers');

        // Home settings
        $data['HOME_ANNOUNCEMENT']                          = $this->administrators_model->get_system_setup_by_setting('home_announcement');
        $data['HOME_CELEBRATION']                           = $this->administrators_model->get_system_setup_by_setting('home_celebration');
        $data['HOME_DATE']                                  = $this->administrators_model->get_system_setup_by_setting('home_date');
        $data['HOME_LEAVE_INFO']                            = $this->administrators_model->get_system_setup_by_setting('home_leave_info');
        $data['HOME_WHOS_OUT']                              = $this->administrators_model->get_system_setup_by_setting('home_whos_out');
        $data['HOME_STARTER_GUIDE']                         = $this->administrators_model->get_system_setup_by_setting('home_start_guide');
        $data['HOME_NEW_MEMBER']                            = $this->administrators_model->get_system_setup_by_setting('home_new_member');
        $data['HOME_MY_TIME_RECORD']                        = $this->administrators_model->get_system_setup_by_setting('home_my_time_record');
        $data['HOME_ATTENDANCE_SUMMARY']                    = $this->administrators_model->get_system_setup_by_setting('home_attendance_summary');
        $data['HOME_REQUEST']                               = $this->administrators_model->get_system_setup_by_setting('home_requests');
        $data['HOME_APPROVAL']                              = $this->administrators_model->get_system_setup_by_setting('home_approval');
        $data['HOME_HOLIDAY']                               = $this->administrators_model->get_system_setup_by_setting('home_upcoming_holidays');
        // Company Structure
        $data['COM_COMPANY']                                = $this->administrators_model->get_system_setup_by_setting('com_company');
        $data['COM_BRANCH']                                 = $this->administrators_model->get_system_setup_by_setting('com_branch');
        $data['COM_DEPARTMENT']                             = $this->administrators_model->get_system_setup_by_setting('com_Department');
        $data['COM_DIVISION']                               = $this->administrators_model->get_system_setup_by_setting('com_division');
        $data['COM_CLUBHOUSE']                               = $this->administrators_model->get_system_setup_by_setting('com_clubhouse');
        $data['COM_SECTION']                                = $this->administrators_model->get_system_setup_by_setting('com_section');
        $data['COM_GROUP']                                  = $this->administrators_model->get_system_setup_by_setting('com_group');
        $data['COM_TEAM']                                   = $this->administrators_model->get_system_setup_by_setting('com_team');
        $data['COM_LINE']                                   = $this->administrators_model->get_system_setup_by_setting('com_line');

        // Administrators
        $data['system_administrator']                       = $this->administrators_model->get_system_setup_by_setting('system_administrator');
        $data['hr_administrator']                           = $this->administrators_model->get_system_setup_by_setting('hr_administrator');
        $data['payroll_administrator']                      = $this->administrators_model->get_system_setup_by_setting('payroll_administrator');
        $data['allow_admin_access_payroll']                 = $this->administrators_model->get_system_setup_by_setting('allow_admin_access_payroll');
        $data['allow_payroll_access_hr']                    = $this->administrators_model->get_system_setup_by_setting('allow_payroll_access_hr');
        $data['EMPLOYEE_LISTS']                             = $this->administrators_model->get_employee_list();
        // Payroll Staffs
        $payroll_rankandfile                                 = $this->administrators_model->get_system_setup_by_setting('payroll_rankandfile');
        $data['payroll_rankandfile']                        = explode(",", $payroll_rankandfile['value']);
        $payroll_managers                                   = $this->administrators_model->get_system_setup_by_setting('payroll_managers');
        $data['payroll_managers']                            = explode(",", $payroll_managers['value']);

        // echo "<pre>";
        // echo "data";
        // echo "<br>";
        // print_r($data);
        // echo "<pre>"; die();


        // Date Format
        $data['DATE_FORMAT']                       = $this->administrators_model->get_date_format();

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/general_setting_views', $data);
    }
    function home_settings()
    {
        $data['HOME_ANNOUNCEMENT']                          = $this->administrators_model->get_system_setup_by_setting('home_announcement');
        $data['HOME_CELEBRATION']                           = $this->administrators_model->get_system_setup_by_setting('home_celebration');
        $data['HOME_LEAVE_INFO']                            = $this->administrators_model->get_system_setup_by_setting('home_leave_info');
        $data['HOME_NEW_MEMBER']                            = $this->administrators_model->get_system_setup_by_setting('home_new_member');
        $data['HOME_HOLIDAY']                               = $this->administrators_model->get_system_setup_by_setting('home_upcoming_holidays');
        $data['HOME_TEAM_MEMBERS']                          = $this->administrators_model->get_system_setup_by_setting('home_team_members');
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/admin_home_setting_views', $data);
    }
    function geo_fencing_settings()
    {
        // $data['GEO_FENCING']          = $this->administrators_model->get_system_setup_by_setting('geo_fencing');
        // $data['GEO_FENCE_AREA']       = $this->administrators_model->get_system_setup_by_setting('geo_fencing_coordinates');
        $data['GEO_FENCING']          = $this->administrators_model->get_system_setup_by_setting2('geo_fencing', 0);
        $data['GEO_FENCE_AREA']       = $this->administrators_model->get_system_setup_by_setting2('geo_fencing_coordinates', '');
        // $data['GEO_FENCE_AREA']       = $data['GEO_FENCE_AREA']['value'];
        // echo '<pre>';
        // var_dump($data['GEO_FENCE_AREA']);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/administrator/admin_geo_fencing_setting_views', $data);
    }
    function update_geo_fence()
    {
        $input_data = $this->input->post();
        // var_dump($input_data);
        // return;

        $validKeys = [
            'geo_fencing',
            'geo_fencing_coordinates'
        ];
        $input_data             = array_intersect_key($input_data, array_flip($validKeys));
        $input_data['geo_fencing'] = $input_data['geo_fencing'] == "on" ? 1 : 0;
        // echo '<pre>';
        // var_dump($input_data['geo_fencing']);
        // return;
        $res = $this->administrators_model->UPDATE_HOME_SETTINGS($input_data);
        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated geo fence settings');
            $this->session->set_flashdata('SUCC', 'Successfully updated');
        } else {
            $this->session->set_flashdata('ERR', 'Settings Unable to update');
        }
        redirect($this->input->server('HTTP_REFERER'));
    }
    function self_service_settings()
    {
        $data["AWOL"]                                       = $this->administrators_model->get_system_setup_setting('awol');
        $data["LWOP"]                                       = $this->administrators_model->get_system_setup_setting('lwop');

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/self_service_setting_views', $data);
    }

    function employee_password_settings()
    {
        $data['forgot_pass_disable_enable']               = $this->administrators_model->get_system_setup_by_setting2('forgot_pass_disable_enable', '0');

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/employee_password_setting_views', $data);
    }

    function update_employee_password_enable_disable()
    {
        $input_data = $this->input->post();
        $validKeys = [
            'forgot_pass_disable_enable'
        ];
        $input_data             = array_intersect_key($input_data, array_flip($validKeys));

        $res = $this->administrators_model->UPDATE_SYSTEM_SETUP($input_data);
        // var_dump($res);die();
        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated employee password settings');
            $this->session->set_flashdata('SUCC', 'Settings Successfully updated');
        } else {
            $this->session->set_flashdata('ERR', 'Settings Unable to update');
        }
        redirect($this->input->server('HTTP_REFERER'));
    }


    function useraccess()
    {
        $data["USER_ACCESS"]                                = $this->administrators_model->GET_ALL_USER_ACCESS();
        $data["MODULES"]                                    = $this->administrators_model->GET_MODULE_ACCESS();
        $data["MODULES"]['general_userguide']               = $this->administrators_model->get_system_setup_by_setting2('general_userguide', '1');
        $data["MODULES"]['hr_userguide']                    = $this->administrators_model->get_system_setup_by_setting2('hr_userguide', '1');
        $data["MODULES"]['admin_userguide']                 = $this->administrators_model->get_system_setup_by_setting2('admin_userguide', '1');

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/user_access_views', $data);
    }

    function skill_assign()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type           = ['all', 'edit_user', $user];
        $data["module_name"]      = $module              = 'administrators';
        $data["page_name"]        = $page_name           = 'skill_assign';
        $data["model_name"]       = $model               = "main_table_02_model";
        $data["table_name"]       = $table               = "tbl_employee_skillassign";
        $data["module"]           = [base_url() . $module, "Administrators", "Skill Assignment"];
        $data["id_prefix"]        = "DDA";
        $data["excel_output"]     = [true, "skill_assign.xlsx"];
        $data["add_button"]       = [true, "Add Assignment"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("username", "text", 256, 1, 1, 1, 20, "Employee Name", "user", 1, "0"),
                array("name", "text", 256, 1, 1, 1, 15, "Skill", "array1", 1, "0"),
                array("values", "text", 256, 1, 1, 1, 15, "Level", "array2", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                         = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                            = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                       = $this->$model->get_empl_name();
        $data["C_ARRAY_1"]                              = $this->$model->get_skill_name();
        $data["C_ARRAY_2"]                              = $this->$model->get_skill_level();
        $page                                           = $this->input->get('page');
        $row                                            = $this->input->get('row');
        $tab                                            = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                      = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                      = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                      = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                      = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                         = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                            = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_02_views', $data);
    }

    function adjustments()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type           = ['all', 'edit_user', $user];
        $data["module_name"]      = $module              = 'administrators';
        $data["page_name"]        = $page_name           = 'adjustments';
        $data["model_name"]       = $model               = "main_table_01_model";
        $data["table_name"]       = $table               = "tbl_std_adjustments";
        $data["module"]           = [base_url() . $module, "Adjustments", "Adjustments"];
        $data["id_prefix"]        = "ADJ";
        $data["excel_output"]     = [true, "adjustments.xlsx"];
        $data["add_button"]       = [true, "Add Adjustments"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date",   "datetime-local", 0, 0, 0, 0, 0,  "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function allowances()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type          = ['all', 'edit_user', $user];
        $data["module_name"]      = $module             = 'administrators';
        $data["page_name"]        = $page_name          = 'allowances';
        $data["model_name"]       = $model              = "main_table_01_model";
        $data["table_name"]       = $table              = "tbl_std_allowances";
        $data["module"]           = [base_url() . $module, "Administrators", "Allowances"];
        $data["id_prefix"]        = "ALL";
        $data["excel_output"]     = [true, "allowances.xlsx"];
        $data["add_button"]       = [true, "Add Allowance"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 35, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function companies()
    {
        $user                                         = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]                            = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]                          = $module       = 'administrators';
        $data["page_name"]                            = $page_name    = 'companies';
        $data["model_name"]                           = $model        = "main_table_01_model";
        $data["table_name"]                           = $table        = "tbl_std_companies";
        $data["module"]                               = [base_url() . $module, "Administrators", "Companies"];
        $data["id_prefix"]                            = "BRC";
        $data["excel_output"]                         = [true, "companies.xlsx"];
        $data["add_button"]                           = [true, "Add Company"];
        $data["status_text"]                          = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]                        = $filter_row = [25, 50, 100];
        $c_data_tab                                   = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function branches()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'branches';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_branches";
        $data["module"]           = [base_url() . $module, "Administrators", "Branches"];
        $data["id_prefix"]        = "BRC";
        $data["excel_output"]     = [true, "branches.xlsx"];
        $data["add_button"]       = [true, "Add Branch"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATEE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function divisions()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type          = ['all', 'edit_user', $user];
        $data["module_name"]      = $module             = 'administrators';
        $data["page_name"]        = $page_name          = 'divisions';
        $data["model_name"]       = $model              = "main_table_01_model";
        $data["table_name"]       = $table              = "tbl_std_divisions";
        $data["module"]           = [base_url() . $module, "Administrators", "Divisions"];
        $data["id_prefix"]        = "DIV";
        $data["excel_output"]     = [true, "divisions.xlsx"];
        $data["add_button"]       = [true, "Add Division"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function deductions()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'deductions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_deductions";
        $data["module"]           = [base_url() . $module, "Administrators", "Deductions"];
        $data["id_prefix"]        = "DDL";
        $data["excel_output"]     = [true, "deductions.xlsx"];
        $data["add_button"]       = [true, "Add Deduction"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function taxable_deductions()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'taxable_deductions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_deductions_tax";
        $data["module"]           = [base_url() . $module, "Administrators", "Taxable Deductions"];
        $data["id_prefix"]        = "TDE";
        $data["excel_output"]     = [true, "taxable_deductions.xlsx"];
        $data["add_button"]       = [true, "Add Taxable Deductions"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function non_taxable_deductions()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'non_taxable_deductions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_deductions_nontax";
        $data["module"]           = [base_url() . $module, "Administrators", "Non Taxable Deductions"];
        $data["id_prefix"]        = "NDE";
        $data["excel_output"]     = [true, "non_taxable_deductions.xlsx"];
        $data["add_button"]       = [true, "Non Taxable Deductions"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                         = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                            = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                       = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                        = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                           = $this->input->get('page');
        $row                                            = $this->input->get('row');
        $tab                                            = $this->input->get('tab');
        $tab_filter                                     = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                       = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                       = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                       = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                       = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                          = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                             = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function positions()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'positions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_positions";
        $data["module"]           = [base_url() . $module, "Administrators", "Positions"];
        $data["id_prefix"]        = "POS";
        $data["excel_output"]     = [true, "positions.xlsx"];
        $data["add_button"]       = [true, "Add Position"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, 'CREATE DATE', "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page = $this->input->get('page');
        $row  = $this->input->get('row');
        $tab  = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function employment_types()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'employment_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_employeetypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Employment Types"];
        $data["id_prefix"]        = "ETY";
        $data["excel_output"]     = [true, "employment_types.xlsx"];
        $data["add_button"]       = [true, "Add Employment Type"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        $offset = $row * ($page - 1);
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function skill_levels()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'skill_levels';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_skilllevels";
        $data["module"]           = [base_url() . $module, "Administrators", "Skill Levels"];
        $data["id_prefix"]        = "SKL";
        $data["excel_output"]     = [true, "skill_levels.xlsx"];
        $data["add_button"]       = [true, "Add Skill Level"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function genders()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'genders';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_genders";
        $data["module"]           = [base_url() . $module, "Administrators", "Genders"];
        $data["id_prefix"]        = "GND";
        $data["excel_output"]     = [true, "genders.xlsx"];
        $data["add_button"]       = [true, "Add Gender"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab             = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                   = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                   = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                   = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                   = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function nationalities()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'nationalities';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_nationalities";
        $data["module"]           = [base_url() . $module, "Administrators", "Nationalities"];
        $data["id_prefix"]        = "NAT";
        $data["excel_output"]     = [true, "nationalities.xlsx"];
        $data["add_button"]       = [true, "Add Nationality"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function shirt_sizes()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'shirt_sizes';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_shirtsizes";
        $data["module"]           = [base_url() . $module, "Administrators", "Shirt Sizes"];
        $data["id_prefix"]        = "SSZ";
        $data["excel_output"]     = [true, "shirt_sizes.xlsx"];
        $data["add_button"]       = [true, "Add Shirt Size"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                       = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                          = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                     = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                      = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                         = $this->input->get('page');
        $row                                          = $this->input->get('row');
        $tab                                          = $this->input->get('tab');
        $tab_filter                                   = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function marital_statuses()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'marital_statuses';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_maritalstatuses";
        $data["module"]           = [base_url() . $module, "Administrators", "Marital Statuses"];
        $data["id_prefix"]        = "MAR";
        $data["excel_output"]     = [true, "marital_statuses.xlsx"];
        $data["add_button"]       = [true, "Add Marital Status"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function skill_names()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'skill_names';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_skillnames";
        $data["module"]           = [base_url() . $module, "Administrators", "Skill Names"];
        $data["id_prefix"]        = "SKN";
        $data["excel_output"]     = [true, "skills.xlsx"];
        $data["add_button"]       = [true, "Add Skill"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function hmos()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'hmos';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_hmos";
        $data["module"]           = [base_url() . $module, "Administrators", "HMOs"];
        $data["id_prefix"]        = "HMO";
        $data["excel_output"]     = [true, "HMOs.xlsx"];
        $data["add_button"]       = [true, "Add HMO"];;
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function departments()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'departments';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_departments";
        $data["module"]           = [base_url() . $module, "Administrators", "Departments"];
        $data["id_prefix"]        = "DEP";
        $data["excel_output"]     = [true, "departments.xlsx"];
        $data["add_button"]       = [true, "Add Department"];
        $data["status_text"]      = ["Active", "Inactive", "", ""];
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 30, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function sections()
    {
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'sections';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_sections";
        $data["module"]           = [base_url() . $module, "Administrators", "Sections"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "SEC";
        $data["excel_output"]     = [true, "sections.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Section"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function groups()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'groups';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_groups";
        $data["module"]           = [base_url() . $module, "Administrators", "Groups"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "GRP";
        $data["excel_output"]     = [true, "groups.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Group"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page = $this->input->get('page');
        $row  = $this->input->get('row');
        $tab  = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function lines()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'lines';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_lines";
        $data["module"]           = [base_url() . $module, "Administrators", "Lines"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "LIN";
        $data["excel_output"]     = [true, "lines.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Line"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function teams()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'teams';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_teams";
        $data["module"]           = [base_url() . $module, "Administrators", "Teams"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "TMS";
        $data["excel_output"]     = [true, "teams.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Team"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }


    function blood_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'blood_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_bloodtypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Blood Type"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "BLD";
        $data["excel_output"]     = [true, "blood_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Type"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                         = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                            = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                       = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                        = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                           = $this->input->get('page');
        $row                                            = $this->input->get('row');
        $tab                                            = $this->input->get('tab');
        $tab_filter                                     = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }

        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function religions()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'religions';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_religions";
        $data["module"]           = [base_url() . $module, "Administrators", "Religion"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "RLG";
        $data["excel_output"]     = [true, "religions.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Religion"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }

        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function banks()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'banks';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_banks";
        $data["module"]           = [base_url() . $module, "Administrators", "Banks"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "BNK";
        $data["excel_output"]     = [true, "banks.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Bank"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function asset_categories()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'asset_categories';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_assetcategories";
        $data["module"]           = [base_url() . $module, "Administrators", "Asset Categories"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "ASC";
        $data["excel_output"]     = [true, "asset_categories.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Category"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function get_user_access_by_id($id)
    {
        // position_id
        $data                                       = $this->administrators_model->GET_USER_ACCESS_BY_ID($id);
        echo json_encode($data);
    }
    function UPDATE_USER_ACCESS()
    {
        $name                                       = $this->input->post('position_name');
        if ($this->input->post("data")) {

            $data                                   = implode(", ", $this->input->post("data"));
            $modules                                = implode(", ", $this->input->post("module"));
            $response                               = $this->administrators_model->UPDATE_USER_ACCESS_DATA($this->input->post('position_id'), $name, $data, $modules);
        } else {
            $response                               = $this->administrators_model->UPDATE_USER_ACCESS_DATA($this->input->post('position_id'), $name, "", "");
        }
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated user access: ' . $name);
        echo 'test';
        var_dump($data2);
        $this->session->set_userdata('SESS_SUCC_MSG', 'User Accessibility List Updated Successfully!');
        redirect("administrators/useraccess");
    }

    function ADD_USER_ACCESS()
    {
        $name = $this->input->post('position_name');

        $data = $this->input->post("data");
        $modules = $this->input->post("module");

        if (!is_array($data) || !is_array($modules)) {
            $this->session->set_userdata('SESS_ERR_MSG', 'Please check and include need modules!');
            redirect("administrators/useraccess");
            return;
        }

        $data = implode(", ", $data);
        $modules = implode(", ", $modules);

        $this->administrators_model->ADD_USER_ACCESS($name, $data, $modules);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added new user access: ' . $name);
        $this->session->set_userdata('SESS_SUCC_MSG', 'New List Added Successfully!');
        redirect("administrators/useraccess");
    }

    function leave_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'leave_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_leavetypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Leave Types"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "LVT";
        $data["excel_output"]     = [true, "leave_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Type"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function company_locations()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'company_locations';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_companylocations";
        $data["module"]           = [base_url() . $module, "Administrators", "Company Locations"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "COL";
        $data["excel_output"]     = [true, "company_locations.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Company Location"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }


    function employee_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'employee_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_employeetypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Employee Types"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "EMT";
        $data["excel_output"]     = [true, "employee_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Employee Types"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }


    function holidays()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'holidays';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_holidays";
        $data["module"]           = [base_url() . $module, "Administrators", "Holidays"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "HLD";
        $data["excel_output"]     = [false, "holidayss.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Holidays"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 0, 0, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("col_holi_date", "date", 256, 1, 1, 1, 20, "DATE", "date", 1, "0"),
                array("name", "text", 256, 1, 1, 1, 40, "TITLE", "none", 1, "0"),
                array("col_holi_type", "text", 256, 1, 1, 1, 30, "TYPE", "status", 1, "Regular Holiday;Special Non-Working Holiday"),
                array("year", "text", 256, 1, 1, 1, 10, "YEAR", "status", 1, "2024;2023;2022;2021"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }


    function knowledge_articles()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'knowledge_articles';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_knowledgearticles";
        $data["module"]           = [base_url() . $module, "Administrators", "Knowledge Article"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "KWA";
        $data["excel_output"]     = [true, "knowledge_articles.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Knowledge Article"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]      = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }


    function knowledge_categories()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'knowledge_categories';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_knowledgecategories";
        $data["module"]           = [base_url() . $module, "Administrators", "Knowledge Categories"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "KWC";
        $data["excel_output"]     = [true, "knowledge_categories.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Knowledge Categories"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }


    function pay_grade()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'pay_grade';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_paygrade";
        $data["module"]           = [base_url() . $module, "Administrators", "Pay Grade"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "PYG";
        $data["excel_output"]     = [true, "pay_grade.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Pay Grade"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function stockrooms()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'stockrooms';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_stockrooms";
        $data["module"]           = [base_url() . $module, "Administrators", "Stockrooms"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "STM";
        $data["excel_output"]     = [true, "stockrooms.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Stockrooms"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]   = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }


    function termination_reasons()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'termination_reason';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_terminationtypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Termination Reasons"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "TMT";
        $data["excel_output"]     = [true, "termination_reason.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Termination Reasons"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function resignation_reasons()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'resignation_reason';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_resignationtypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Resignation Reason"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "RST";
        $data["excel_output"]     = [true, "resignation_reason.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Resignation Reason"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function employee_requirements()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'employee_requirements';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_requirements";
        $data["module"]           = [base_url() . $module, "Administrators", "Employee Requirements"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "RST";
        $data["excel_output"]     = [true, "employee_requirements.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Employee Requirement"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "Title", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function biometrics()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'biometrics';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_biometrics";
        $data["module"]           = [base_url() . $module, "Administrators", "biometrics"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "BIO";
        $data["excel_output"]     = [true, "biometrics.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add biometrics"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("terminal_sn", "text", 256, 1, 1, 1, 55, "TERMINAL SN", "none", 1, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "NAME", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function years()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'years';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_years";
        $data["module"]           = [base_url() . $module, "Administrators", "Years"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "YRS";
        $data["excel_output"]     = [true, "year.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add years"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "NAME", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                        = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                   = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                    = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        $tab                                        = $this->input->get('tab');
        $tab_filter                                 = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function taxable_allowances()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'taxable_allowances';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_allowances_tax";
        $data["module"]           = [base_url() . $module, "Administrators", "Taxable Allowances"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "TAL";
        $data["excel_output"]     = [true, "taxable_allowances.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Taxable Allowances"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab             = array(
            array("Active", "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]  = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 35, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();

        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');
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
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function loan_types()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'loan_types';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_loantypes";
        $data["module"]           = [base_url() . $module, "Administrators", "Loan Types"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "LNT";
        $data["excel_output"]     = [true, "loan_types.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Add Type"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]    = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "CREATE DATE", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 55, "TITLE", "none", 1, "0"),
                array("status", "sel", 256, 1, 1, 1, 15, "STATUS", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');

        if ($tab_filter == null) {
            $tab_filter = $c_data_tab[0][1];
        }
        if ($row == null) {
            $row = $filter_row[0];
        }
        if ($tab == null) {
            $tab = $c_data_tab[0][0];
        }
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                       = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                          = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }
    function non_taxable_allowances()
    {
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user                     = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
        $data["module_name"]      = $module       = 'administrators';
        $data["page_name"]        = $page_name    = 'non_taxable_allowances';
        $data["model_name"]       = $model        = "main_table_01_model";
        $data["table_name"]       = $table        = "tbl_std_allowances_nontax";
        $data["module"]           = [base_url() . $module, "Administrators", "Non Taxable Allowances"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "NAL";
        $data["excel_output"]     = [true, "non_taxable_allowances.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true, "Non Taxable Allowances"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
        $c_data_tab               = array(
            array("Active",   "status", "Active", 0),
            array("Inactive", "status", "Inactive", 0)
        );
        $data["C_BULK_BUTTON"]   = array(
            array(true, "btn_mark_active",   "circle-check-solid_mark.svg", "Mark as Active",   "status", "Active"),
            array(true, "btn_mark_inactive", "circle-x-solid_mark_as.svg", "Mark as Inactive", "status", "Inactive")
        );
        $data["C_DB_DESIGN"]  =
            array(
                array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
                array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
                array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
                array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
                array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
                array("name", "text", 256, 1, 1, 1, 35, "Title", "none", 1, "0"),
                array("type", "text", 256, 1, 1, 1, 25, "Type", "dropdown", 1, "Fixed;Attendance"),
                array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
            );
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                      = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                         = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]                    = $this->$model->get_empl_name();
        $data["C_COM_STRUCTURE"]                     = $this->administrators_model->GET_COMP_STRUCTURE();
        $page                                        = $this->input->get('page');
        $row                                         = $this->input->get('row');
        $tab                                         = $this->input->get('tab');
        $tab_filter                                  = $this->input->get('tab_filter');
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
        if ($this->input->get('all') == null) {
            $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
            $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        } else {
            $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
            $data["C_DATA_COUNT"]                    = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
            // $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
        }
        $i = 0;
        foreach ($c_data_tab as $c_data_tab_row) {
            $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                         = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_01_views', $data);
    }

    function ip_address()
    {

        $search                                     = str_replace('_', ' ', $this->input->get('all') ?? "");
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
        $data["SYSTEM_IP_ADDRESS"]                  = $this->administrators_model->GET_SYSTEM_IP_ADDRESS();

        if ($this->input->get('all') == null) {
            $data["DISP_IP_ADDRESS"]                = $this->administrators_model->GET_IP_ADDRESS($offset, $row);
            $data["C_DATA_COUNT"]                   = count($this->administrators_model->get_count_ip_address($offset, $row));
        } else {
            $data["DISP_IP_ADDRESS"]                = $this->administrators_model->get_search_ip_address($search);
            $data["C_DATA_COUNT"]                   = count($this->administrators_model->get_search_ip_address($search));
        }

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/ip_address_views', $data);
    }

    function ip_address_form()
    {

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/ip_address_form_views');
    }

    function insert_ip_address()
    {
        $create_date                             = date("Y-m-d H:i:s");
        $status                                  = $this->input->post('insrt_status');
        $ip_add                                  = $this->input->post('insrt_ip_add');
        $remarks                                 = $this->input->post('insrt_remarks');

        $this->administrators_model->MOD_INSERT_IP($create_date, $ip_add, $remarks, $status);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added IP address: ' . $ip_add);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT', 'IP Address Added Successfully!');
        redirect('administrators/ip_address');
    }

    function delete_id_address($id)
    {
        $this->administrators_model->MOD_DELETE_IP_ADDRESS($id);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted IP address ID: ' . $id);
        $this->session->set_userdata('SESS_SUCC_MSG_DELETE', 'IP Address Deleted Successfully!');
        redirect('administrators/ip_address');
    }

    function reset_empl_password()
    {
        $empl_id                            = $this->input->post('empl_id');
        $reset_pass                         = $this->input->post('reset_pass');
        // echo $reset_pass;
        // echo $empl_id;
        // var_dump($empl_id);
        // var_dump($reset_pass);
        $res                                = $this->administrators_model->MOD_RESET_USER_PASSWORD($empl_id, $reset_pass);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Reset password for employee ID: ' . $empl_id);
        echo $res;
        // redirect('administrators/access');
        // echo(json_encode($data));
    }

    function update_empl_user_access()
    {
        $disable                            = $this->input->post('disable');
        $user_access                        = $this->input->post('user_access');
        $remote_attendance                  = $this->input->post('remote_attendance');
        $empl_id                            = $this->input->post('empl_id');

        $data = $this->administrators_model->MOD_UPDT_USER_ACCESS($user_access, $remote_attendance, $disable, $empl_id);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated user access for employee ID: ' . $empl_id);
        echo (json_encode($data));
    }

    function update_setting()
    {
        $id                                 = $this->input->post('id');
        $value                              = $this->input->post('check_status');
        $checked = ($value == '') ? 0 : 1;
        var_dump($checked);
        $this->administrators_model->MOD_UPDATE_STATUS($checked, $id);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated structure setting ID: ' . $id);
        redirect("administrators/structuresettings");
    }

    function update_ip_address()
    {
        $setting                            = "ip_address";
        $value                              = $this->input->post('val_setting');
        $checked                            = ($value == '') ? 0 : 1;
        $this->administrators_model->MOD_UPDATE_IP_ADDRESS($checked, $setting);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated IP address restriction setting');
        redirect("administrators/ip_address");
    }

    function update_status($id)
    {
        $checked                            = isset($_POST["check_status"]) ? 1 : 0;
        $res                                = $this->administrators_model->MOD_UPDATE_STATUS($checked, $id);
        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated status setting ID: ' . $id);
            $this->session->set_userdata('SUCC', 'Successfully updated');
            return;
        }
    }

    function update_general_settings()
    {
        $data = array(
            1   => $this->input->post('update_comp_name'),
            24  => $this->input->post('update_header_content'),
            76  => empty($this->input->post('remoteCamera')) ? 0 : 1,
            77  => empty($this->input->post('remoteGPS')) ? 0 : 1,
            78  => empty($this->input->post('requireApprovers')) ? 0 : 1,
            105 => empty($this->input->post('num_approvers')) ? 0 : $this->input->post('num_approvers'),
            136 => $this->input->post('date_format'),
        );

        $this->administrators_model->update_general_setting($data);
        $this->load->library('upload');

        $logo_inputs = array(
            'update_nav_logo' => 3,
            'update_login_logo' =>  2,
            'update_header_logo' => 4
        );

        // Loop through each logo input and process the upload
        foreach ($logo_inputs as $input_name => $id) {
            $logo_file                               = $_FILES[$input_name]['name'];

            if (!empty($logo_file)) {
                $rand = uniqid();

                $file_extension = pathinfo($logo_file, PATHINFO_EXTENSION);

                // Define a fixed file name based on the input key
                $fixed_file_name = '';

                // Set default file names for 'update_login_logo' and 'update_header_logo'
                if ($input_name == 'update_login_logo') {
                    $fixed_file_name = 'login_logo.' . $file_extension;
                } elseif ($input_name == 'update_header_logo') {
                    $fixed_file_name = 'header_logo.' . $file_extension;
                } elseif ($input_name == 'update_nav_logo') {
                    $fixed_file_name = 'navbar_logo.' . $file_extension;
                } else {
                    // If not 'update_login_logo' or 'update_header_logo', use the generated unique name
                    $fixed_file_name = $input_name . '_' . $rand . '.' . $file_extension;
                }

                // Set the fixed file name before initializing the upload configuration
                $_FILES[$input_name]['name'] = $fixed_file_name;

                $config['upload_path']               = './assets_system/images/';
                $config['allowed_types']             = 'gif|jpg|png|jpeg';
                $config['max_size']                  = '5000';
                // $config['file_name']                 = $rand . '_' . $logo_file;
                $config['file_name']                 = $fixed_file_name;
                $config['overwrite']                 = 'TRUE';
                // $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // check if old image exist, if it exists this condition will remove old existing image
                $old_file                           = $this->administrators_model->get_old_logo($id);
                if ($old_file && file_exists('./assets_system/images/' . $old_file)) {
                    unlink('./assets_system/images/' . $old_file);
                }

                if ($this->upload->do_upload($input_name)) {

                    // If the upload is successful, save the new logo to the database
                    $data_upload                    = array($input_name => $this->upload->data());
                    $upload_img                     = $data_upload[$input_name]['file_name'];
                    $this->administrators_model->update_login_logo($upload_img, $id);
                    $this->session->set_flashdata('SESS_SUCC_INSRT', 'Logos updated successfully');
                } else {
                    // If the upload fails, display an error message
                    $error_msg                      = $this->upload->display_errors();
                    $this->session->set_flashdata('error_msg', $error_msg);
                }
            }
        }

        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated general settings');
        $this->session->set_userdata('SESS_SUCC_UPDATE', ' General Settings Updated Successfully!');
        redirect('administrators/generalsettings');
    }
    function update_date_settings()
    {

        $inputDate = $this->input->post('date_format');
        $setting_id = $this->administrators_model->GET_SETTING_ID();

        // Save the user-provided date format directly without validation
        $data = array(
            $setting_id => $inputDate, // Assuming '136' is the field ID or key for the date format in your database
        );

        $this->administrators_model->update_general_setting($data);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated date format settings');
        $this->session->set_userdata('SESS_SUCC_UPDATE', 'Date Settings Updated Successfully!');
        redirect('administrators/date_format_settings');
    }

    function date_format_settings()
    {
        $date = $this->input->post('date_format');
        $formatted_date = $this->administrators_model->get_date_format('date_format');
        $dateFormats = $formatted_date['value'];
        $this->administrators_model->AUTO_INSERT_SETTINGS('date_format');

        $data['DATE_FORMAT']                   = $this->administrators_model->GET_SYSTEM_SETTING("date_format");
        $data["DATE_FORMAT"] = $dateFormats;
        $sample_date = date($dateFormats);
        $data["SAMPLE_DATE"] = $sample_date;

        $this->load->view('templates/header');
        $this->load->view('modules/administrator/date_format_settings_views', $data);
    }
}

function filter_array($user_modules, $user_access)
{
    $modules = array();
    foreach ($user_modules as $module) {
        foreach ($user_access as $access) {
            if ($module["value"] == $access) {
                $modules[] = $module;
            }
        }
    }
    return $modules;
}
