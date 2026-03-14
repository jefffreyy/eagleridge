  <?php defined('BASEPATH') or exit('No direct script access allowed');
  ob_start();
  class payrolls extends CI_Controller
  {
    private $SSS_EE_TOTAL_DATA;
    function __construct()
    {
      parent::__construct();
      $this->load->model('templates/main_nav_model');
      $this->load->model('modules/payrolls_model');
      $this->load->model('modules/employees_model');
      $this->load->model('templates/main_table_02_model');
      $this->load->model('templates/main_table_01_model');
      $this->load->library('pagination');
      $this->load->library('logger');

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
      $maintenance          = $this->login_model->GET_MAINTENANCE();
      $isAdmin              = $this->session->userdata('SESS_ADMIN');
      if ($maintenance == '1' && $isAdmin != 1) {
        redirect('login/maintenance');
      }
    }
    function index()
    {
      $data["Modules"] =  array(
        array("title" => "Payroll Generation",              "value" => "Payroll Status",                "info" => "Generate the calculation and distribution of employees net income.",       "icon" => "print-duotone.svg",                "url" => "payrolls/pending",             "access" => "Payroll", "id" => "payroll_status"),
        array("title" => "13th Month Pay",                  "value" => "13th Month Pay",                "info" => "Generate the calculation of employees 13th month bonus.",                  "icon" => "hand-holding-dollar-duotone.svg",  "url" => "payrolls/thitteenthmonthpay",         "access" => "Payroll", "id" => "13th_month_pay"),
        array("title" => "Payroll Schedule",                "value" => "Payroll Schedule",              "info" => "Generate specific payroll date for employees.",                            "icon" => "calendar-check-duotone.svg",       "url" => "payrolls/payroll_schedules",          "access" => "Payroll", "id" => "payrolls"),
        array("title" => "Custom Contributions",            "value" => "Custom Contributions",          "info" => "Generate employees custom benefits.",                                      "icon" => "piggy-bank-duotone.svg",           "url" => "payrolls/custom_contributions",       "access" => "Payroll", "id" => "custom_contributions"),
        array("title" => "Withholding Tax Table",           "value" => "Withholding Tax Table",                   "info" => "Generate employees withholding tax.     ",                      "icon" => "wtax.svg",                         "url" => "payrolls/payroll_tax",                "access" => "Payroll", "id" => "payroll_tax"),
        array("title" => "Government Contribution",         "value" => "Government Contribution",       "info" => "View employees government contributions.",                                 "icon" => "wtax.svg",                         "url" => "payrolls/payroll_sss",                "access" => "Payroll", "id" => "government_contribution"),
        array("title" => "Manage Salary",                   "value" => "Manage Salary",                 "info" => "Configure salary amount and type for each employee",                        "icon" => "money-bill-1-wave-duotone.svg",          "url" => "payrolls/salary_details",       "access" => "Payroll", "id" => "payroll_salary_details"),
        // array("title" => "Payroll Schedule Viewing",        "value" => "Payroll Schedule Viewing",      "info" => "Checking and understanding the payroll timetable for employees.",       "icon" => "wtax.svg",                         "url" => "payrolls/payroll_schedule_viewing",   "access" => "Payroll", "id" => "payroll_schedule_viewing"),
      );
      $data['settings']                       = "payrolls/setting_constant";
      $data['salary_type_and_rate_count'] = $this->employees_model->GET_SALARY_TYPE_AND_RATE_COUNT();
      $data["title_page"]                     = "Payroll Module";
      $data["title_description"]                = "Overseeing payroll processes, ensuring accurate and timely salary payments, and maintaining compliance with tax and labor regulations";
      $user_access_id                         = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
      $data['DISP_USER_ACCESS_PAGE']          = $this->main_nav_model->GET_USER_ACCESS_PAGE($user_access_id['col_user_access']);
      $array_page                             = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
      $data["maiya_theme"]                    = $this->payrolls_model->GET_MAYA_THEME();
      $data['Modules']                        = filter_array($data["Modules"], $array_page);
      $this->load->view('templates/header');
      $this->load->view('templates/main_container', $data);
    }

    function update_salary_detail()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            foreach ($data as $data_row) {
                $this->employees_model->UPDATE_SALARY_DETAIL($data_row, $this->session->userdata('SESS_USER_ID'));
            }
            $response = array('success_message' => 'Data updated successfully');
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated salary details');
        } catch (Exception $e) {
            $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
        }
        echo json_encode($response);
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
            $row = 50;
        }
        if ($page  == null) {
            $page = 1;
        }
        $offset = $row * ($page - 1);

        // if($this->input->get('all') == null){
        if (!$search) {
            // $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line,$param_company);
            $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division,$param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company);

            $data['DISP_EMP_LIST_TABLE']            = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST_TABLE($offset, $row, $param_branch, $param_dept, $param_division,$param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company);
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
        $this->load->view('modules/payrolls/salary_detail_views', $data);
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
        $this->load->view('modules/payrolls/salary_history_views', $data);
    }


    function setting_constant()
    {
      $data['payroll_monthly_constant']                     = $this->payrolls_model->get_system_setup_by_setting('payroll_monthly_constant', '0');
      $data['sss_contribution']                     = $this->payrolls_model->get_system_setup_by_setting('sss_contribution', 'Basic Pay');
      $data['thirteen_month_reference']                     = $this->payrolls_model->get_system_setup_by_setting('thirteen_month_reference', 'Basic Pay');

      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/setting_constant_views', $data);
    }
    function update_settings()
    {
      $input_data = $this->input->post();
      $validKeys = [
        'payroll_monthly_constant',
        'sss_contribution',
        'thirteen_month_reference',
      ];
      $input_data             = array_intersect_key($input_data, array_flip($validKeys));

      $res = $this->payrolls_model->update_settings($input_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Home Settings Successfully updated');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated payroll settings');
      } else {
        $this->session->set_flashdata('ERR', 'Home Settings Unable to update');
      }
      redirect($this->input->server('HTTP_REFERER'));
    }
    function payroll_sss()
    {
      $search               =  $this->input->get('search');
      $year_data            = $this->payrolls_model->GET_PAYROLL_SSS_YEAR();
      if (!isset($_GET["search"])) {
        $table_data         = $this->payrolls_model->GET_PAYROLL_SSS(date("Y"));
      } else {
        $table_data         = $this->payrolls_model->GET_PAYROLL_SSS($search);
      }
      $data['TABLE_DATA']   = $table_data;
      $data['YEAR_LISTS']   = $year_data;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_sss_views', $data);
    }
    function thitteenthmonthpay()
    {
      $search                                   = str_replace('_', ' ', $this->input->get('search') ?? "");
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
      $page                   = $this->input->get('page');
      $row                    = $this->input->get('row');
      if ($row == null) {
        $row                    = 50;
      }
      if ($page  == null) {
        $page                   = 1;
      }
      $offset = $row * ($page - 1);

      $data['DISP_YEARS']                       = $year_list = $this->payrolls_model->GET_YEARS();
      (!isset($_GET["year"])) ? $year           = $year_list[0]->id : $year = $_GET["year"];
      $data['YEAR_INITIAL']                     = $year;


      if ($this->input->get('search') == null) {
        $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division,$param_clubhouse, $param_section, $param_group, $param_team, $param_line);

        $year_name = $this->payrolls_model->GET_YEAR_NAME($year);
        $data['cutoff_period'] = $years = $this->payrolls_model->GET_PAYROLL_PERIOD_YEAR($year_name);

      
        if ($empl_list) {
          foreach ($empl_list as $empl) {
            $basic_pay = $this->payrolls_model->GET_PAYSLIP($empl->id, $years);
            $empl->_13th_month_pay = number_format($basic_pay / 12, 2);
            $empl->total_basic =  number_format($basic_pay, 2);
            $all_basic_pay = $this->payrolls_model->GET_PAYSLIP_BASIC_PAY($empl->id, $years);
            $empl->all_basic_pay[] = $all_basic_pay;
          }
        }

        $data['DISP_EMP_LIST']                  = $empl_list;
        $data['C_DATA_COUNT']                   = $this->payrolls_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division,$param_clubhouse, $param_section, $param_group, $param_team, $param_line);
      } else {
        $empl_list = $this->payrolls_model->GET_EMPLOYEE_SEARCHED($search);

        $year_name = $this->payrolls_model->GET_YEAR_NAME($year);
        $data['cutoff_period'] = $years = $this->payrolls_model->GET_PAYROLL_PERIOD_YEAR($year_name);

        if ($empl_list) {
          foreach ($empl_list as $empl) {
            $basic_pay = $this->payrolls_model->GET_PAYSLIP($empl->id, $years);
            $empl->_13th_month_pay = number_format($basic_pay / 12, 2);
            $empl->total_basic =  number_format($basic_pay, 2);
            $all_basic_pay = $this->payrolls_model->GET_PAYSLIP_BASIC_PAY($empl->id, $years);
            $empl->all_basic_pay[] = $all_basic_pay;
          }
        }

        $data['DISP_EMP_LIST']                = $empl_list;
        $data['C_DATA_COUNT']                 = count($this->payrolls_model->GET_EMPLOYEE_SEARCHED($search));
      }



      $data['DISP_ALL_EMP_LIST_DATA']          = $this->payrolls_model->GET_SEARCHED_ALL_EMPL();
      $data['DISP_DISTINCT_DEPARTMENT']       = $this->payrolls_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
      $data['DISP_DISTINCT_DIVISION']         = $this->payrolls_model->MOD_DISP_DISTINCT_DIVISION_2();
      $data['DISP_DISTINCT_CLUBHOUSE']         = $this->payrolls_model->MOD_DISP_DISTINCT_CLUBHOUSE_2();
      $data['DISP_DISTINCT_SECTION']          = $this->payrolls_model->MOD_DISP_DISTINCT_SECTION_2();
      $data['DISP_DISTINCT_BRANCH']           = $this->payrolls_model->MOD_DISP_DISTINCT_BRANCH_2();
      $data['DISP_DISTINCT_GROUP']            = $this->payrolls_model->MOD_DISP_DISTINCT_GROUP_2();
      $data['DISP_DISTINCT_TEAM']             = $this->payrolls_model->MOD_DISP_DISTINCT_TEAM_2();
      $data['DISP_DISTINCT_LINE']             = $this->payrolls_model->MOD_DISP_DISTINCT_LINE_2();
      $data['DISP_VIEW_DEPARTMENT']           = $this->payrolls_model->GET_SYSTEM_SETTING("com_Department");
      $data['DISP_VIEW_DIVISION']             = $this->payrolls_model->GET_SYSTEM_SETTING("com_division");
      $data['DISP_VIEW_CLUBHOUSE']            = $this->payrolls_model->GET_SYSTEM_SETTING("com_clubhouse");
      $data['DISP_VIEW_SECTION']              = $this->payrolls_model->GET_SYSTEM_SETTING("com_section");
      $data['DISP_VIEW_BRANCH']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_branch");
      $data['DISP_VIEW_GROUP']                = $this->payrolls_model->GET_SYSTEM_SETTING("com_group");
      $data['DISP_VIEW_TEAM']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_team");
      $data['DISP_VIEW_LINE']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_line");
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/thitteenthmonthpay_views', $data);
    }
    function payroll_tax()
    {
      $search               = $this->input->get('search');
      $year_data            = $this->payrolls_model->GET_PAYROLL_TAX_YEAR();
      if (!isset($_GET["search"])) {
        $table_data         = $this->payrolls_model->GET_PAYROLL_TAX(date("Y"));
      } else {
        $table_data         = $this->payrolls_model->GET_PAYROLL_TAX($search);
      }

      $data['TABLE_DATA']   = $table_data;
      $data['YEAR_LISTS']   = $year_data;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_tax_views', $data);
    }
    function payroll_philhealth()
    {
      $search   =  $this->input->get('search');
      $data['TABLE_DATA'] = $this->payrolls_model->GET_PAYROLL_PHILHEALTH($search);
      $data['YEAR_LISTS'] = $this->payrolls_model->GET_PAYROLL_PHILHEALTH_YEAR();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_philhealth_views', $data);
    }
    function payroll_hdmf()
    {
      $search               = $this->input->get('search');
      $year_data            = $this->payrolls_model->GET_PAYROLL_HDMF_YEAR();
      if (!isset($_GET["search"])) {
        $table_data         = $this->payrolls_model->GET_PAYROLL_HDMF(date("Y"));
      } else {
        $table_data         = $this->payrolls_model->GET_PAYROLL_HDMF($search);
      }
      $data['TABLE_DATA']   = $table_data;
      $data['YEAR_LISTS']   = $year_data;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_hdmf_views', $data);
    }
    // Payslip generator functions actions
    function payslip_generator()
    {
      $dateFilter                             = $this->input->get('date');
      $payrollSched                           = $this->payrolls_model->MOD_DISP_PAY_SCHED();
      if ($dateFilter == null) {
        $dateFilter = $payrollSched[0]->id;
      }
      $data['PAYSLIPS']                       = $this->payrolls_model->GET_PAYSLIP_RECORDS($dateFilter);
      $data['COMPANY_NAME']                   = $this->payrolls_model->GET_COMPANY_NAME()->value;
      if (!$dateFilter) {
        $payroll_data                         = $this->payrolls_model->GET_PAYROLL_DATA();
      } else {
        $payroll_data                         = $this->payrolls_model->GET_PAYROLL_DATA_FILTER($dateFilter);
      }
      $arr_data               = array();
      $index                  = 0;
      $id_code                = 'PAY';
      $data["C_PAYROLL_DATA"] = $arr_data;
      $startDate              = "";
      $endDate                = "";
      if (!$dateFilter) {
        $defaultSched         = reset($payrollSched);
        $startDate            = $defaultSched->date_from;
        $endDate              = $defaultSched->date_to;
      } else {
        foreach ($payrollSched as $sched) {
          if ($sched->id == $dateFilter) {
            $startDate = $sched->date_from;
            $endDate = $sched->date_to;
          }
        }
      }
      if ($dateFilter) {
      }
      if ($this->input->get('page') == null && $dateFilter == null) {
        $limitData                                    = 0;
        $employees                                    = $this->payrolls_model->MOD_DISP_EMP_BASED_ON_HIRE_DATE($startDate, $endDate);
        $data['DISP_PAYROLL_DATA']                    = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2($limitData);
        $data['DISP_PAYROLL_DATA_COUNT']              = count($this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_COUNT());
        $data['DISP_PAYROLL_DATA_TOTAL']              = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL();
      } elseif ($this->input->get('page') != null && $dateFilter == null) {
        $page                                         = $this->input->get('page');
        $limitData                                    = ($page * 10) - 10;
        $employees                                    = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
        $data['DISP_PAYROLL_DATA']                    = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2($limitData);
        $data['DISP_PAYROLL_DATA_COUNT']              = count($this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_COUNT());
        $data['DISP_PAYROLL_DATA_TOTAL']              = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL();
      } elseif ($this->input->get('page') != null && $dateFilter != null) {
        $date                                         = $dateFilter;
        $page                                         = $this->input->get('page');
        $limitData                                    = ($page * 10) - 10;
        $employees                                    = $this->payrolls_model->MOD_DISP_EMP_BASED_ON_HIRE_DATE($startDate, $endDate);
        $data['DISP_PAYROLL_DATA']                    = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT($date, $limitData);
        $data['DISP_PAYROLL_DATA_COUNT']              = count($this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_COUNT($date));
        $data['DISP_PAYROLL_DATA_TOTAL']              = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL2($date);
      } elseif ($this->input->get('page') == null && $dateFilter != null) {
        $date                                         = $dateFilter;
        $limitData                                    = 0;
        $employees                                    = $this->payrolls_model->MOD_DISP_EMP_BASED_ON_HIRE_DATE($startDate, $endDate);
        $data['DISP_PAYROLL_DATA']                    = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED($date, $limitData);
        $data['DISP_PAYROLL_DATA_COUNT']              = count($this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_COUNT($date));
        $data['DISP_PAYROLL_DATA_TOTAL']              = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL2($date);
      }
      $data['TOTAL_GENERATED_SALARY']                 = 0.00;
      $total_gen = 0;
      $data['DISP_EMP_LIST']                          = $employees;
      $data['DISP_PAYROLL_SCHED']                     = $payrollSched;
      foreach ($data['DISP_PAYROLL_DATA_TOTAL'] as $netpay) {
        if ($netpay->NET_INCOME) {
          $total_gen += $netpay->NET_INCOME;
        }
      }
      $data['TOTAL_GENERATED_SALARY']               = $total_gen;
      $distinct_empl                                = $this->payrolls_model->MON_DISP_EMPL_NO_PAYSLIP();
      $empl_arr                                     = [];
      $empl_w_no_payslip                            = [];
      $employee_w_payslip                           = [];
      foreach ($employees as $employees_row) {
        array_push($empl_arr, $employees_row->id);
      }
      foreach ($distinct_empl as $row) {
        array_push($employee_w_payslip, $row->empl_id);
      }
      $employee_without_payslip                       = array_diff($empl_arr, array_unique($employee_w_payslip));
      $data['DISP_COUNT_EMPL_NO_PAYSLIP']             = count($employee_without_payslip);
      $data['EMPLOYEE_COUNT']                         = count($employees);
      $data['PAY_SLIPS_NOT_READY']                    = $this->payrolls_model->GET_NOT_READY_PAYSLIP($dateFilter);
      $data['PAY_SLIPS_READY']                        = $this->payrolls_model->GET_READY_PAYSLIP($dateFilter);
      for ($i = 0; $i < count($data['PAY_SLIPS_NOT_READY']); $i++) {
        $position                               = $this->payrolls_model->GET_SPECIFIC_POSITION($data['PAY_SLIPS_NOT_READY'][$i]['col_empl_posi']);
        $employee_type                          = $this->payrolls_model->GET_SPECIFIC_EMPLOYEE_TYPE($data['PAY_SLIPS_NOT_READY'][$i]['col_empl_type']);
        if (!empty($position)) {
          $data['PAY_SLIPS_NOT_READY'][$i]['position'] = $position->name;
        } else {
          $data['PAY_SLIPS_NOT_READY'][$i]['position'] = '';
        }
        if (!empty($employee_type)) {
          $data['PAY_SLIPS_NOT_READY'][$i]['employee_type'] = $employee_type->name;
        } else {
          $data['PAY_SLIPS_NOT_READY'][$i]['employee_type'] = '';
        }
      }
      for ($i = 0; $i < count($data['PAY_SLIPS_READY']); $i++) {
        $position = $this->payrolls_model->GET_SPECIFIC_POSITION($data['PAY_SLIPS_READY'][$i]['col_empl_posi']);
        $employee_type = $this->payrolls_model->GET_SPECIFIC_EMPLOYEE_TYPE($data['PAY_SLIPS_READY'][$i]['col_empl_type']);
        if (!empty($position)) {
          $data['PAY_SLIPS_READY'][$i]['position'] = $position->name;
        } else {
          $data['PAY_SLIPS_READY'][$i]['position'] = '';
        }
        if (!empty($employee_type)) {
          $data['PAY_SLIPS_READY'][$i]['employee_type'] = $employee_type->name;
        } else {
          $data['PAY_SLIPS_READY'][$i]['employee_type'] = '';
        }
      }
      for ($i = 0; $i < count($data['PAYSLIPS']); $i++) {
        $position       = $this->payrolls_model->GET_SPECIFIC_POSITION($data['PAYSLIPS'][$i]['col_empl_posi']);
        $employee_type  = $this->payrolls_model->GET_SPECIFIC_EMPLOYEE_TYPE($data['PAYSLIPS'][$i]['col_empl_type']);
        if (!empty($position)) {
          $data['PAYSLIPS'][$i]['position'] = $position->name;
        } else {
          $data['PAYSLIPS'][$i]['position'] = '';
        }
        if (!empty($employee_type)) {
          $data['PAYSLIPS'][$i]['employee_type'] = $employee_type->name;
        } else {
          $data['PAYSLIPS'][$i]['employee_type'] = '';
        }
      }
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payslip_generator_views', $data);
    }
    function getPayslipData($id, $empl_id)
    {
      $payslip                = $this->payrolls_model->GET_PAYSLIP_DATA($id);
      $password               = $this->payrolls_model->GET_USER_PASSWORD($empl_id);
      $employee_all_loans     = $this->payrolls_model->GET_ALL_LOANS($empl_id);

      if ($employee_all_loans) {
        foreach ($employee_all_loans as $loan) {
          if ($loan->id) {
          }
        }
      }

      // $employee_loans              = $this->payrolls_model->GET_ALL_PAYROLL_LOAN_DATA_EMPL($empl_id);
      $other_deductions             = $this->payrolls_model->GET_ALL_PAYSLIP_OTHER_DEDUCTIONS($id);
      $employee_loans               = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIP_LOAN_DATA($id);
      $payroll_taxable              = $this->payrolls_model->GET_ALL_PAYROLL_TAXABLE_DATA($id);
      $payroll_nontaxable           = $this->payrolls_model->GET_ALL_PAYROLL_NONTAXABLE_DATA($id);
      $employee_loans_payslip       = [];

      if (!empty($employee_loans)) {
        foreach ($employee_loans as $employee_loan) {
          if ($employee_loan->start) {
            $dataRange  = $this->payrolls_model->GET_NAME_PAYROLL_SCHEDULE($employee_loan->start);
            $space_position = strpos($dataRange, ' ');
            $second_space_position = strpos($dataRange, ' ', $space_position + 1);
            $first_two_words = substr($dataRange, 0, $second_space_position); // filter date
            $first_two_words .= ', ' . substr($dataRange, -4); // add year ex. "Jan 1, 2024";
            $employee_loan->start = $first_two_words;
          }
        }
      }

      if ($payslip && $password) {
        $mergedData = array(
          'payslip' => $payslip,
          'password' => $password,
          'loans' => $employee_loans,
          'taxable' => $payroll_taxable,
          'nontaxable' => $payroll_nontaxable,
          'otherDeductions' => $other_deductions,
        );
        echo json_encode($mergedData);
      }
    }
    function delete_payslip()
    {
      $payslip_ids  = $this->input->post('payslip_ids');
      $array_id     = explode(",", $payslip_ids);
      // var_dump($array_id);
      // echo $id;
      $res          = $this->payrolls_model->DELETE_PAYSLIP_DATA($array_id);
      $this->session->set_userdata('SESS_SUCC_MSG_DLT_PAYROLL', 'Deleted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted payslip');
      redirect('payrolls/payslip_generator');
    }
    function deductions()
    {
      $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
      $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
      $employees                                = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
      $loan_types                               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $tab                                      = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                      = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                                     = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                                   = ($page - 1) * $row;
      if ($this->input->get('all') == null) {
        $payroll_loans                          = $this->payrolls_model->GET_DATA($tab, $row, $offset, 'tbl_payroll_deductions');
        $data_count                             = $this->payrolls_model->GET_DATA_COUNT($tab, 'tbl_payroll_deductions');
      } else {
        $payroll_loans                          = $this->payrolls_model->GET_SEARCHED_DATA($tab, $search, 'tbl_payroll_deductions');
        $data_count                             = count($this->payrolls_model->GET_SEARCHED_DATA($tab, $search, 'tbl_payroll_deductions'));
      }
      $payroll_data                             = [];
      $data['ACTIVES']                          = $this->payrolls_model->GET_DATA_COUNT('Active', 'tbl_payroll_deductions');
      $data['INACTIVES']                        = $this->payrolls_model->GET_DATA_COUNT('InActive', 'tbl_payroll_deductions');
      $data['PAGE']                             = $page;
      $page_count                               = intval($data_count / $row);
      $excess                                   = $data_count % $row;
      $data['PAGES_COUNT']                      = $excess > 0 ? $page_count += 1 : $page_count;
      $data['C_DATA_COUNT']                     = $data_count;
      $data['ROW']                              = $row;
      $data['TAB']                              = $tab;
      $index = 0;
      if ($payroll_loans) {
        foreach ($payroll_loans as $payroll_loan) {
          $payroll_data[$index]['id']           = $payroll_loan->id;
          $payroll_data[$index]['date']         = date('F j, Y', strtotime($payroll_loan->loan_date));
          $payroll_data[$index]['loan_amount']  = $payroll_loan->loan_amount > 0 ? number_format((float)$payroll_loan->loan_amount, 2) : $payroll_loan->loan_amount;
          $payroll_data[$index]['term_amount']  = $payroll_loan->loan_terms > 0 ?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms, 2) : $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_terms']   = $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_status']  = $payroll_loan->status;
          $payroll_data[$index]['loan_id']      = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
          $payroll_data[$index]['name']         = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
          $index += 1;
        }
      }
      $data['DISP_PAYROLL_LOAN'] = $payroll_data;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_deduction_views', $data);
    }
    function add_deduction()
    {
      $data['DISP_EMPLOYEES']           = $this->payrolls_model->GET_EMPLOYEE_LIST();
      $data['LOAN_TYPES']               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/add_deduction_views', $data);
    }
    function insert_new_deduction()
    {
      $inputs                           = $this->input->post();
      $res_new                          = $this->payrolls_model->ADD_DEDUCTION($inputs);
      if ($res_new) {
        $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully added!');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added deduction');
      } else {
        $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to add new data!');
      }
      redirect('payrolls/deductions');
    }
    function edit_deduction($id)
    {
      $data['DISP_EMPLOYEES']           = $this->payrolls_model->GET_EMPLOYEE_LIST();
      $data['LOAN_TYPES']               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $data['LOAN_INFO']                = $this->payrolls_model->GET_SPEC_DEDUCTION($id);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/edit_deduction_views', $data);
    }
    function other_deductions()
    {
      $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
      $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
      $employees                                = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
      $loan_types                               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $tab                                      = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                      = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                                     = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                                   = ($page - 1) * $row;
      if ($this->input->get('all') == null) {
        $payroll_loans                          = $this->payrolls_model->GET_DATA($tab, $row, $offset, 'tbl_payroll_deductions');
        $data_count                             = $this->payrolls_model->GET_DATA_COUNT($tab, 'tbl_payroll_deductions');
      } else {
        $payroll_loans                          = $this->payrolls_model->GET_SEARCHED_DATA($tab, $search, 'tbl_payroll_deductions');
        $data_count                             = count($this->payrolls_model->GET_SEARCHED_DATA($tab, $search, 'tbl_payroll_deductions'));
      }
      $payroll_data                             = [];
      $data['ACTIVES']                          = $this->payrolls_model->GET_DATA_COUNT('Active', 'tbl_payroll_deductions');
      $data['INACTIVES']                        = $this->payrolls_model->GET_DATA_COUNT('InActive', 'tbl_payroll_deductions');
      $data['PAGE']                             = $page;
      $page_count                               = intval($data_count / $row);
      $excess                                   = $data_count % $row;
      $data['PAGES_COUNT']                      = $excess > 0 ? $page_count += 1 : $page_count;
      $data['C_DATA_COUNT']                     = $data_count;
      $data['ROW']                              = $row;
      $data['TAB']                              = $tab;
      $index = 0;
      if ($payroll_loans) {
        foreach ($payroll_loans as $payroll_loan) {
          $payroll_data[$index]['id']           = $payroll_loan->id;
          $payroll_data[$index]['date']         = date('F j, Y', strtotime($payroll_loan->loan_date));
          $payroll_data[$index]['loan_amount']  = $payroll_loan->loan_amount > 0 ? number_format((float)$payroll_loan->loan_amount, 2) : $payroll_loan->loan_amount;
          $payroll_data[$index]['term_amount']  = $payroll_loan->loan_terms > 0 ?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms, 2) : $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_terms']   = $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_status']  = $payroll_loan->status;
          $payroll_data[$index]['loan_id']      = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
          $payroll_data[$index]['name']         = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
          $index += 1;
        }
      }
      $payrollSched                           = $this->payrolls_model->MOD_DISP_PAY_SCHED();
      $data['DISP_PAYROLL_SCHED'] = $payrollSched;
      $data['DISP_PAYROLL_LOAN'] = $payroll_data;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/other_deduction_views', $data);
    }
    function get_otherdeductions_data($payroll_id)
    {
      // $result = array();
      // $index = 0;
      $data                                 = $this->payrolls_model->GET_OTHERDEDUCTIONS_DATA($payroll_id);
      $empl_list                            = $this->payrolls_model->GET_OTHERDEDUCTIONS_EMPL_DATA();
      // $position                           = $this->employees_model->GET_POSITION();
      // $section                            = $this->employees_model->GET_SECTIONS();
      // $department                         = $this->employees_model->GET_DEPARTMENTS();
      // $type                               = $this->employees_model->GET_TYPE();
      // $shirt_size                         = $this->employees_model->GET_SHIRT_SIZE();
      // $gender                             = $this->employees_model->GET_GENDERS();
      // $marital                            = $this->employees_model->GET_MARITAL();
      // $nationality                        = $this->employees_model->GET_NATIONALITY();
      // $groups                             = $this->employees_model->GET_GROUPS();
      // $lines                              = $this->employees_model->GET_LINES();
      // $division                           = $this->employees_model->GET_DIVISIONS();
      // $hmo                                = $this->employees_model->GET_HMO();
      foreach ($data as $row) {
        $name = "";
        foreach ($empl_list as $empl_list_row) {
          if ($empl_list_row->col_empl_cmid == $row->empl_id) {
            $name = $empl_list_row->col_last_name . ', ' . $empl_list_row->col_frst_name;
          }
        }
        $result[] = [
          'id'                => $row->id,
          'empl_id'           => $row->empl_id,
          'name'              => $name,
          // 'payroll_period'    => $row->payroll_period,
          'coop'              => $row->coop,
          'vaccine'           => $row->vaccine,
          'vac'               => $row->vac,
          'funeral'           => $row->funeral,
          'cmcl'              => $row->cmcl,
          'rcbc'              => $row->rcbc,
          'canteen'           => $row->canteen
        ];
      }
      echo (json_encode($result));
    }
    function update_otherdeductions_data($payroll_id)
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $id = $data_row[0];
          if ($id) {
            $this->payrolls_model->UPDATE_OTHERDEDUCTIONS_DATA($data_row, $payroll_id);
          } else {
            $this->payrolls_model->INSERT_OTHERDEDUCTIONS_DATA($data_row, $payroll_id);
          }
        }
        $response = array('success_message' => 'Data updated successfully');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated other deductions');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      // echo json_encode($response);
      echo json_encode($response);
    }
    function update_deduction($id)
    {
      $inputs                           = $this->input->post();
      $res_new                          = $this->payrolls_model->UPDATE_DEDUCTION($inputs, $id);
      if ($res_new) {
        $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Updated!');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated deduction');
      } else {
        $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to Update!');
      }
      redirect('payrolls/deductions');
    }
    //   Cash Deductions
    function cash_advances()
    {
      $search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
      $data["C_ROW_DISPLAY"]                =  [25, 50, 100];
      $employees                            = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
      $loan_types                           = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $tab                                  = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                  = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                                 = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                               = ($page - 1) * $row;
      if ($this->input->get('all') == null) {
        $payroll_loans                      = $this->payrolls_model->GET_DATA($tab, $row, $offset, 'tbl_payroll_cashadvance');
        $data_count                         = $this->payrolls_model->GET_DATA_COUNT($tab, 'tbl_payroll_cashadvance');
      } else {
        $payroll_loans                      = $this->payrolls_model->GET_SEARCHED_DATA($tab, $search, 'tbl_payroll_cashadvance');
        $data_count                         = count($this->payrolls_model->GET_SEARCHED_DATA($tab, $search, 'tbl_payroll_cashadvance'));
      }
      $payroll_data                         = [];
      $data['ACTIVES']                      = $this->payrolls_model->GET_DATA_COUNT('Active', 'tbl_payroll_cashadvance');
      $data['INACTIVES']                    = $this->payrolls_model->GET_DATA_COUNT('InActive', 'tbl_payroll_cashadvance');
      $data['PAGE']                         = $page;
      $page_count                           = intval($data_count / $row);
      $excess                               = $data_count % $row;
      $data['PAGES_COUNT']                  = $excess > 0 ? $page_count += 1 : $page_count;
      $data['C_DATA_COUNT']                 = $data_count;
      $data['ROW']                          = $row;
      $data['TAB']                          = $tab;
      $index = 0;
      if ($payroll_loans) {
        foreach ($payroll_loans as $payroll_loan) {
          $payroll_data[$index]['id']                     = $payroll_loan->id;
          $payroll_data[$index]['date']                   = date('F j, Y', strtotime($payroll_loan->loan_date));
          $payroll_data[$index]['loan_amount']            = $payroll_loan->loan_amount > 0 ? number_format((float)$payroll_loan->loan_amount, 2) : $payroll_loan->loan_amount;
          $payroll_data[$index]['term_amount']            = $payroll_loan->loan_terms > 0 ?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms, 2) : $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_terms']             = $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_status']            = $payroll_loan->status;
          $payroll_data[$index]['loan_id']                = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
          $payroll_data[$index]['name']                   = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
          $index += 1;
        }
      }
      $data['DISP_PAYROLL_LOAN'] = $payroll_data;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_cash_advance_views', $data);
    }
    function add_cash_advance()
    {
      $data['DISP_EMPLOYEES']                       = $this->payrolls_model->GET_EMPLOYEE_LIST();
      $data['LOAN_TYPES']                           = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/add_cash_advance_views', $data);
    }
    function insert_new_cash_advance()
    {
      $inputs                                       = $this->input->post();
      $res_new                                      = $this->payrolls_model->ADD_CASH_ADV($inputs);
      if ($res_new) {
        $this->session->set_userdata('SESS_SUCCESS', 'Successfully added!');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added cash advance');
      } else {
        $this->session->set_userdata('SESS_ERROR', 'Fail to add new data!');
      }
      redirect('payrolls/cash_advances');
    }
    function edit_cash_advance($id)
    {
      $data['DISP_EMPLOYEES']                       = $this->payrolls_model->GET_EMPLOYEE_LIST();
      $data['LOAN_TYPES']                           = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $data['LOAN_INFO']                            = $this->payrolls_model->GET_SPEC_CASH_ADV($id);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/edit_cash_advance_views', $data);
    }
    function update_cash_advance($id)
    {
      $inputs                                       = $this->input->post();
      $res_new                                      = $this->payrolls_model->UPDATE_CASH_ADV($inputs, $id);
      if ($res_new) {
        $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Updated!');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated cash advance');
      } else {
        $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to Update!');
      }
      redirect('payrolls/cash_advances');
    }
    //
    function bulk_activate()
    {
      $loan_ids                                  = explode(',', $this->input->post('active'));
      $table                                     = $this->input->post('table');
      $data = array();
      foreach ($loan_ids as $id) {
        $data[] = array('id' => $id, 'status' => 'Active');
      }
      $res                                        = $this->payrolls_model->UPDATE_BULK_ACTIVATE($data, $table);
      $this->session->set_userdata('SESS_SUCCESS', 'Successfully Updated!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk activated payroll records');
      if ($table == 'tbl_payroll_deductions') {
        redirect('payrolls/deductions');
      }
      if ($table == 'tbl_benefits_loan') {
        redirect('payrolls/loans');
      }
      if ($table == 'tbl_payroll_cashadvance') {
        redirect('payrolls/cash_advances');
      }
    }
    function bulk_inactivate()
    {
      $loan_ids                                      = explode(',', $this->input->post('inactive'));
      $table                                         = $this->input->post('table');
      $data = array();
      foreach ($loan_ids as $id) {
        $data[] = array('id' => $id, 'status' => 'Inactive');
      }
      $res                                           = $this->payrolls_model->UPDATE_BULK_ACTIVATE($data, $table);
      $this->session->set_userdata('SESS_SUCCESS', 'Successfully Updated!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk deactivated payroll records');

      if ($table == 'tbl_payroll_deductions') {
        redirect('payrolls/deductions');
      }
      if ($table == 'tbl_benefits_loan') {
        redirect('payrolls/loans');
      }
      if ($table == 'tbl_payroll_cashadvance') {
        redirect('payrolls/cash_advances');
      }
    }

    function attendance_records_lock()
    {
      $data["C_ROW_DISPLAY"]                        =  [10, 25, 50, 100];
      $page                                         = $this->input->get('page');
      $row                                          = $this->input->get('row');
      if ($row == null) {
        $row = 10;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $data['DISP_CUTOFF']                         = $cutoff_list = $this->payrolls_model->GET_CUTOFF();
      if (!isset($_GET["cutoff"])) {
        $cutoff                                    = $cutoff_list[0]->id;
      } else {
        $cutoff                                    = $_GET["cutoff"];
      }
      $data['CUTOFF_INITIAL']                      = $cutoff;
      $data['DISP_ATTENDANCE_LOCK']                = $this->payrolls_model->GET_ATTENDANCE_RECORD_LOCK($cutoff, $offset, $row);
      $data['C_DATA_COUNT']                        = $this->payrolls_model->GET_COUNT_ATTENDANCE_RECORD($cutoff);
      $data['C_TOTAL_RECORD_COUNT']                = $this->payrolls_model->GET_TOTAL_COUNT_ATTENDANCE_RECORD();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/attendace_records_lock_views', $data);
    }
    function payroll_payslips()
    {
      $data["C_ROW_DISPLAY"]                        =  [10, 25, 50, 100];
      $page                                         = $this->input->get('page');
      $row                                          = $this->input->get('row');
      if ($row == null) {
        $row = 10;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $data['DISP_CUTOFF']                         = $cutoff_list = $this->payrolls_model->GET_CUTOFF();
      if (!isset($_GET["cutoff"])) {
        $cutoff                                    = $cutoff_list[0]->id;
      } else {
        $cutoff                                    = $_GET["cutoff"];
      }
      $data['CUTOFF_INITIAL']                      = $cutoff;
      $data['DISP_ATTENDANCE_LOCK']                = $this->payrolls_model->GET_PAYROLL_PAYSLIP($cutoff, $offset, $row);
      $data['C_DATA_COUNT']                        = $this->payrolls_model->GET_COUNT_PAYROLL_PAYSLIP($cutoff, $offset, $row);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_payslip_views', $data);
    }
    function custom_contributions()
    {
      if (!isset($_GET["branch"])) {
        $param_branch                           = "all";
      } else {
        $param_branch                           = $_GET["branch"];
      }
      if (!isset($_GET["dept"])) {
        $param_dept                             = "all";
      } else {
        $param_dept                             = $_GET["dept"];
      }
      if (!isset($_GET["division"])) {
        $param_division                         = "all";
      } else {
        $param_division                         = $_GET["division"];
      }
      if (!isset($_GET["clubhouse"])) {
        $param_clubhouse                        = "all";
      } else {
        $param_clubhouse                       = $_GET["clubhouse"];
      }
      if (!isset($_GET["section"])) {
        $param_section                          = "all";
      } else {
        $param_section                          = $_GET["section"];
      }
      if (!isset($_GET["group"])) {
        $param_group                            = "all";
      } else {
        $param_group                            = $_GET["group"];
      }
      if (!isset($_GET["team"])) {
        $param_team                             = "all";
      } else {
        $param_team                             = $_GET["team"];
      }
      if (!isset($_GET["line"])) {
        $param_line                             = "all";
      } else {
        $param_line                             = $_GET["line"];
      }
      if (!isset($_GET["status"])) {
        $param_status                           = "all";
      } else {
        $param_status                           = $_GET["status"];
      }
      $search                                   = str_replace('_', ' ', $this->input->get('search') ?? "");
      $data["C_ROW_DISPLAY"]                    =  [50];
      $page                                     = $this->input->get('page');
      $row                                      = $this->input->get('row');
      if ($row == null) {
        $row = 50;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      if ($this->input->get('search') == null) {
        $data['DISP_EMP_LIST']                  = $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
        $data['C_DATA_COUNT']                   = $this->payrolls_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
      } else {
        $data['DISP_EMP_LIST']                  = $this->payrolls_model->GET_EMPLOYEE_SEARCHED($search);
        $data['C_DATA_COUNT']                   = count($this->payrolls_model->GET_EMPLOYEE_SEARCHED($search));
      }
      $data['DISP_YEARS']                       = $year_list = $this->payrolls_model->GET_YEARS();
      (!isset($_GET["year"])) ? $year           = $year_list[0]->id : $year = $_GET["year"];
      $data['YEAR_INITIAL']                     = $year;
      $data['DISP_ALL_EMP_LIST_DATA']          = $this->payrolls_model->GET_SEARCHED_ALL_EMPL();
      $data["DISP_SSS"]                         = $this->payrolls_model->GET_CUSTOM_SSS_CONTRIBUTION_DATA($year);
      $data["DISP_PAGIBIG"]                     = $this->payrolls_model->GET_CUSTOM_PAGIBIG_CONTRIBUTION_DATA($year);
      $data["DISP_PHILHEALTH"]                  = $this->payrolls_model->GET_CUSTOM_PHILHEALTH_CONTRIBUTION_DATA($year);
      $data['DISP_DISTINCT_DEPARTMENT']         = $this->payrolls_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
      $data['DISP_DISTINCT_DIVISION']           = $this->payrolls_model->MOD_DISP_DISTINCT_DIVISION_2();
      $data['DISP_DISTINCT_CLUBHOUSE']           = $this->payrolls_model->MOD_DISP_DISTINCT_CLUBHOUSE_2();
      $data['DISP_DISTINCT_SECTION']            = $this->payrolls_model->MOD_DISP_DISTINCT_SECTION_2();
      $data['DISP_DISTINCT_BRANCH']             = $this->payrolls_model->MOD_DISP_DISTINCT_BRANCH_2();
      $data['DISP_DISTINCT_GROUP']              = $this->payrolls_model->MOD_DISP_DISTINCT_GROUP_2();
      $data['DISP_DISTINCT_TEAM']               = $this->payrolls_model->MOD_DISP_DISTINCT_TEAM_2();
      $data['DISP_DISTINCT_LINE']               = $this->payrolls_model->MOD_DISP_DISTINCT_LINE_2();
      $data['DISP_VIEW_DEPARTMENT']             = $this->payrolls_model->GET_SYSTEM_SETTING("com_Department");
      $data['DISP_VIEW_DIVISION']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_division");
      $data['DISP_VIEW_CLUBHOUSE']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_clubhouse");
      $data['DISP_VIEW_SECTION']                = $this->payrolls_model->GET_SYSTEM_SETTING("com_section");
      $data['DISP_VIEW_BRANCH']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_branch");
      $data['DISP_VIEW_GROUP']                  = $this->payrolls_model->GET_SYSTEM_SETTING("com_group");
      $data['DISP_VIEW_TEAM']                   = $this->payrolls_model->GET_SYSTEM_SETTING("com_team");
      $data['DISP_VIEW_LINE']                   = $this->payrolls_model->GET_SYSTEM_SETTING("com_line");
      $data['DISP_CUSTOM_CONTRIBUTION']         = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/custom_contributions_views', $data);
    }
    function government_contribution()
    {
      if (!isset($_GET["branch"])) {
        $param_branch                           = "all";
      } else {
        $param_branch                           = $_GET["branch"];
      }
      if (!isset($_GET["dept"])) {
        $param_dept                             = "all";
      } else {
        $param_dept                             = $_GET["dept"];
      }
      if (!isset($_GET["division"])) {
        $param_division                         = "all";
      } else {
        $param_division                         = $_GET["division"];
      }
      if (!isset($_GET["section"])) {
        $param_section                          = "all";
      } else {
        $param_section                          = $_GET["section"];
      }
      if (!isset($_GET["group"])) {
        $param_group                            = "all";
      } else {
        $param_group                            = $_GET["group"];
      }
      if (!isset($_GET["team"])) {
        $param_team                             = "all";
      } else {
        $param_team                             = $_GET["team"];
      }
      if (!isset($_GET["line"])) {
        $param_line                             = "all";
      } else {
        $param_line                             = $_GET["line"];
      }
      if (!isset($_GET["status"])) {
        $param_status                           = "all";
      } else {
        $param_status                           = $_GET["status"];
      }
      $search                                   = str_replace('_', ' ', $this->input->get('search') ?? "");
      $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
      $page                                     = $this->input->get('page');
      $row                                      = $this->input->get('row');
      if ($row == null) {
        $row = 10;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      if ($this->input->get('search') == null) {
        $data['DISP_EMP_LIST']                  = $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
        $data['C_DATA_COUNT']                   = $this->payrolls_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      } else {
        $data['DISP_EMP_LIST']                  = $this->payrolls_model->GET_EMPLOYEE_SEARCHED($search);
        $data['C_DATA_COUNT']                   = count($this->payrolls_model->GET_EMPLOYEE_SEARCHED($search));
      }
      $data['DISP_YEARS']                       = $year_list = $this->payrolls_model->GET_YEARS();
      (!isset($_GET["year"])) ? $year           = $year_list[0]->id : $year = $_GET["year"];
      $data['YEAR_INITIAL']                     = $year;
      $data['DISP_CUTOFF_PERIOD']               = $cutoff_list = $this->payrolls_model->GET_CUTOFF();
      if (!isset($_GET["cutoff"])) {
        $cutoff                                    = $cutoff_list[0]->id;
      } else {
        $cutoff                                    = $_GET["cutoff"];
      }
      $data['CUTOFF_INITIAL']                      = $cutoff;
      $data['DISP_ALL_EMP_LIST_DATA']           = $this->payrolls_model->GET_SEARCHED_ALL_EMPL();
      $data["DISP_SSS"]                         = $this->payrolls_model->GET_CUSTOM_SSS_CONTRIBUTION_DATA($year);
      $data["DISP_PAGIBIG"]                     = $this->payrolls_model->GET_CUSTOM_PAGIBIG_CONTRIBUTION_DATA($year);
      $data["DISP_PHILHEALTH"]                  = $this->payrolls_model->GET_CUSTOM_PHILHEALTH_CONTRIBUTION_DATA($year);
      $data['DISP_DISTINCT_DEPARTMENT']         = $this->payrolls_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
      $data['DISP_DISTINCT_DIVISION']           = $this->payrolls_model->MOD_DISP_DISTINCT_DIVISION_2();
      $data['DISP_DISTINCT_SECTION']            = $this->payrolls_model->MOD_DISP_DISTINCT_SECTION_2();
      $data['DISP_DISTINCT_BRANCH']             = $this->payrolls_model->MOD_DISP_DISTINCT_BRANCH_2();
      $data['DISP_DISTINCT_GROUP']              = $this->payrolls_model->MOD_DISP_DISTINCT_GROUP_2();
      $data['DISP_DISTINCT_TEAM']               = $this->payrolls_model->MOD_DISP_DISTINCT_TEAM_2();
      $data['DISP_DISTINCT_LINE']               = $this->payrolls_model->MOD_DISP_DISTINCT_LINE_2();
      $data['DISP_VIEW_DEPARTMENT']             = $this->payrolls_model->GET_SYSTEM_SETTING("com_Department");
      $data['DISP_VIEW_DIVISION']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_division");
      $data['DISP_VIEW_SECTION']                = $this->payrolls_model->GET_SYSTEM_SETTING("com_section");
      $data['DISP_VIEW_BRANCH']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_branch");
      $data['DISP_VIEW_GROUP']                  = $this->payrolls_model->GET_SYSTEM_SETTING("com_group");
      $data['DISP_VIEW_TEAM']                   = $this->payrolls_model->GET_SYSTEM_SETTING("com_team");
      $data['DISP_VIEW_LINE']                   = $this->payrolls_model->GET_SYSTEM_SETTING("com_line");
      $data['DISP_CUSTOM_CONTRIBUTION']         = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/government_contributions_views', $data);
    }

    function payroll_schedule_viewing()
    {
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_schedule_viewing_views');
    }



    function payroll_summary()
    {

      // CALCULATION OF PAYROLL
      // 
      // A. RATE CALCULATION
      // MONTHLY RATE                  = SALARY RATE                  ; IF MONTHLY PAID
      // DAILY RATE                    = SALARY RATE * 12 / CONSTANT  ; IF MONTHLY PAID
      // HOURLY RATE                   = DAILY RATE/8                 ; IF MONTHLY PAID
      //
      // DAILY RATE                    = SALARY RATE                  ; IF DAILY PAID
      // MONTHLY RATE                  = DAILY RATE * CONSTANT / 12   ; IF DAILY PAID
      // HOURLY RATE                   = DAILY RATE/8                 ; IF DAILY PAID
      //
      // REGULAR PAY                   = MONTHLY SALARY / 2           ; IF MONTHLY PAID
      // REGULAR PAY                   = DAYS WORKED * DAILY RATE     ; IF DAILY PAID
      //
      //
      // B. BASIC PAY                  = REGULAR PAY + PAID LEAVE - ABSENCES - TARDINESS - UNDERTIME - OVER/UNDERBREAK
      //
      // C. TOTAL OT PAY               = ALL ND AND OT 
      // D. TOTAL TAXABLE ALLOWANCE    = SUM OF ALL TAXABLE ALLOWANCES
      // E. TOTAL NONTAXABLE ALLOWANCE = SUM OF ALL NONTAXABLE ALLOWANCES 
      // F. GROSS PAY                  = BASIC PAY + TOTAL OT PAY + TOTAL TAXABLE ALLOWANCE + TOTAL NONTAXABLE ALLOWANCE
      // G. SSS                        = SSSTABLE (GROSS PAY)
      // H. PAGIBIG                    = PAGIBIGTABLE (BASIC INCOME)
      // I. PHILHEALTH                 = PHILHEALTHTABLE (BASIC INCOME)
      // J. GOVERNMENT CONTRIBUTIONS   = SSS EE + PHILHEALTH EE + PAGIBIG EE
      // K. TAXABLE INCOME             = GROSS PAY - TOTAL NONTAXABLE ALLOWANCE - GOVERNMENT CONTRIBUTIONS
      // L. WTAX                       = TAXTABLE (TAXABLE INCOME)
      // M. TOTAL LOANS                = SUM OF ALL LOANS
      // N. TOTAL DEDUCTIONS           = SUM OF ALL DEDUCTIONS
      // O. NET PAY                    = GROSS PAY - GOVERNMENT CONTRIBUTIONS - WTAX - TOTAL LOANS - TOTAL DEDUCTIONS


      $data['CUTOFF_PERIODS']                   = $this->payrolls_model->GET_CUTOFF_LIST();
      $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
      $period                                   = $this->input->get('period');
      $page                                     = $this->input->get('page');
      $row                                      = $this->input->get('row');
      $tab                                      = $this->input->get('tab');
      if (isset($tab)) {
        $data['TAB']                              = $tab;
      } else {
        $data['TAB']                              = 'pending';
      }
      if ($row == null) {
        $row = 25;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $payroll_list                           = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      if ($period == null && !empty($payroll_list)) {
        $period = $payroll_list[0]->period;
      }
      $specific_payroll_sched = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($period);
      if (!empty($specific_payroll_sched)) {
        ($specific_payroll_sched->chk_sss == null         || $specific_payroll_sched->chk_sss == 1)         ? $en_sss = 0 : $en_sss = 1;
        ($specific_payroll_sched->chk_philhealth == null  || $specific_payroll_sched->chk_philhealth == 1)  ? $en_phil = 0 : $en_phil = 1;
        ($specific_payroll_sched->chk_pagibig == null     || $specific_payroll_sched->chk_pagibig == 1)     ? $en_pagibig = 0 : $en_pagibig = 1;
        ($specific_payroll_sched->chk_withholding == null || $specific_payroll_sched->chk_withholding == 1) ? $en_wtax = 0 : $en_wtax = 1;

        ($specific_payroll_sched->chk_taxable == null    || $specific_payroll_sched->chk_taxable == 1)    ? $en_ti = 0 : $en_ti = 1;
        ($specific_payroll_sched->chk_nontaxable == null  || $specific_payroll_sched->chk_nontaxable == 1)  ? $en_nti = 0 : $en_nti = 1;
        ($specific_payroll_sched->chk_loans == null       || $specific_payroll_sched->chk_loans == 1)       ? $en_loan = 0 : $en_loan = 1;
        ($specific_payroll_sched->chk_tardiness == null   || $specific_payroll_sched->chk_tardiness == 1)   ? $en_absut = 0 : $en_absut = 1;
      }
      preg_match('/\b\d{4}\b/', $specific_payroll_sched->date_from, $matches);
      $year                             = $matches[0] ?? null;

      $year_id                          = $this->payrolls_model->GET_SPECIFIC_YEAR_ID($year);
      $date_from                        = $specific_payroll_sched->date_from;
      $date_to                          = $specific_payroll_sched->date_to;

      $leave_types          = $this->payrolls_model->GET_ALL_LEAVE_TYPE();
      $filteredLeaveTypes   = array();
      foreach ($leave_types as $leave_type) {
        $lowercaseName              = strtolower($leave_type->name);
        $lowercaseExclusionTerm     = strtolower('Leave without Pay');
        $lowercaseExclusionTermLwop = strtolower('LWOP');
        // stripos will return false if string is not found
        if (stripos($lowercaseName, $lowercaseExclusionTerm) === false || stripos($lowercaseName, $lowercaseExclusionTermLwop) === false) {
          $filteredLeaveTypes[] = $leave_type;
        }
      }

      $data['DISP_LEAVE_TYPES'] = $filteredLeaveTypes;

      $employees                                  = $this->payrolls_model->GET_EMPLOYEELIST_3();
      $attendance_record_lock                     = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
      $pasyslip_list                              = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);

      $pasyslipEmplIds = array_map(function ($item) {
        if ($item->status == "Generated" || $item->status == "Published") {
          return $item->empl_id;
        }
      }, $pasyslip_list);

      $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
        return !in_array($employee->id, $pasyslipEmplIds);
      });

      $attendanceRecordLockIds = array_map(function ($item) {
        return $item->empl_id;
      }, $attendance_record_lock);

      $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
        return in_array($employee->id, $attendanceRecordLockIds);
      });

      $arrayOfObjects = array();
      foreach ($attendanceRecordLockFiltered as $item) {
        $arrayOfObjects[] = (object)$item;
      }
      $data['DISP_EMPLOYEES']                   = $arrayOfObjects;
      $data['C_DATA_COUNT']                     = count($attendanceRecordLockFiltered);

      $employeePayrollSummary = [];

      foreach ($attendanceRecordLockFiltered as $employee) {

        $empl_id                                = $employee->id;
        $fullname                               = $employee->fullname;
        $salary_rate                            = $employee->salary_rate;
        $salary_type                            = $employee->salary_type;
        $bank_name                              = $employee->bank_name;
        $account_number                         = $employee->account_number;
        $cmid                                   = $employee->col_empl_cmid;
        $workdaysperyear                        = $employee->days;

        $sss_id                                 = $employee->col_empl_sssc;
        $pagibig_id                             = $employee->col_empl_hdmf;
        $philhealth_id                          = $employee->col_empl_phil;
        $tin_id                                 = $employee->col_empl_btin;
        $designation                            = $this->payrolls_model->convert_department_id_to_name($employee->col_empl_dept);

        //$payroll_monthly_cons = $this->payrolls_model->GET_PAYROLL_MONTHLY_CONSTANT();

        // //---------------------------------- A. RATE CALCULATION ----------------------------------------------
        // MONTHLY RATE                  = SALARY RATE                  ; IF MONTHLY PAID
        // DAILY RATE                    = SALARY RATE * 12 / CONSTANT  ; IF MONTHLY PAID
        // HOURLY RATE                   = DAILY RATE/8                 ; IF MONTHLY PAID
        //
        // DAILY RATE                    = SALARY RATE                  ; IF DAILY PAID
        // MONTHLY RATE                  = DAILY RATE * CONSTANT / 12   ; IF DAILY PAID
        // HOURLY RATE                   = DAILY RATE/8                 ; IF DAILY PAID



        if ($salary_type == "Daily" || $salary_type == "daily") {
          if ($workdaysperyear == null) {
            $workdaysperyear = 0;
          }
          $monthly_salary     = $salary_rate * $workdaysperyear / 12;
          $daily_salary       = $salary_rate;
          $hourly_salary      = $daily_salary / 8;
        } else {
          $monthly_salary     =  $salary_rate;

          if ($workdaysperyear == null) {
            $daily_salary       =  0;
          } else {
            $daily_salary       =  $salary_rate * 12 / $workdaysperyear;
          }

          $hourly_salary      =  $daily_salary / 8;
        }


        $filteredLeaveTypesData   = array();
        foreach ($leave_types as $leave_type) {
          $lowercaseName              = strtolower($leave_type->name);
          $sil                        = strtolower('Service Incentive Leave');
          $sil2                       = strtolower('SIL');
          $vacationLeave              = strtolower('Vacation');
          $sickLeave                  = strtolower('Sick');

          // stripos will return false if string is not found
          if (stripos($lowercaseName, $sil) !== false || stripos($lowercaseName, $sil2) !== false || stripos($lowercaseName, $vacationLeave) !== false || stripos($lowercaseName, $sickLeave) !== false) {
            $filteredLeaveTypesData[] = $leave_type;
          }
        }

        $leave_sil_id = $this->payrolls_model->GET_LEAVE_ID($filteredLeaveTypesData[0]->name);
        $leave_vac_id = $this->payrolls_model->GET_LEAVE_ID($filteredLeaveTypesData[1]->name);
        $leave_sick_id = $this->payrolls_model->GET_LEAVE_ID($filteredLeaveTypesData[2]->name);

        $leave_SIL_total_duration = $this->payrolls_model->GET_ENTITLEMENT_DURATION($empl_id, $leave_sil_id, $year);
        $leave_vac_total_duration = $this->payrolls_model->GET_ENTITLEMENT_DURATION($empl_id, $leave_vac_id, $year);
        $leave_sick_total_duration = $this->payrolls_model->GET_ENTITLEMENT_DURATION($empl_id, $leave_sick_id, $year);

        $leave_entitlements_sil_val = $this->payrolls_model->GET_VALUE_LEAVE_ENTITLEMENT($empl_id, $filteredLeaveTypesData[0]->name, $year_id);
        $leave_entitlements_vac_val = $this->payrolls_model->GET_VALUE_LEAVE_ENTITLEMENT($empl_id, $filteredLeaveTypesData[1]->name, $year_id);
        $leave_entitlements_sick_val = $this->payrolls_model->GET_VALUE_LEAVE_ENTITLEMENT($empl_id, $filteredLeaveTypesData[2]->name, $year_id);

        $leave_sil_bal = 0;
        $leave_vac_bal = 0;
        $leave_sick_bal = 0;

        $sil_duration = ($leave_SIL_total_duration == null) ? 0 :  $leave_SIL_total_duration;
        $vac_duration = ($leave_vac_total_duration == null) ? 0 :  $leave_vac_total_duration;
        $sick_duration = ($leave_sick_total_duration == null) ? 0 :  $leave_sick_total_duration;

        $sil_value = ($leave_entitlements_sil_val == null) ? 0 : $leave_entitlements_sil_val;
        $vac_value = ($leave_entitlements_vac_val == null) ? 0 : $leave_entitlements_vac_val;
        $sick_value = ($leave_entitlements_sick_val == null) ? 0 : $leave_entitlements_sick_val;

        $leave_sil_bal =  $sil_value - $sil_duration;
        $leave_vac_bal = $vac_value - $vac_duration;
        $leave_sick_bal = $sick_value - $sick_duration;

        // Leave entitlement
        $leave_entitlements = $this->payrolls_model->GET_SPECIFIC_LEAVE_ENTITLEMENT($empl_id, $year_id);

        $entitlementValues = array();
        foreach ($filteredLeaveTypesData as $leaveType) {
          foreach ($leave_entitlements as $entitlement) {
            $lowercaseEntitlementType = strtolower($entitlement->type);
            if ($lowercaseEntitlementType === strtolower($leaveType->name)) {
              $entitlementValues[$leaveType->name] = $entitlement->value;
            }
          }
        }



        $DISP_ATTENDANCE_LOCK                   =  isset(($this->payrolls_model->GET_ATTENDANCE_LOCK($empl_id, $period))[0]) ? ($this->payrolls_model->GET_ATTENDANCE_LOCK($empl_id, $period))[0] : 0;
        $DISP_ATTENDANCE_LOCK_BENEFITS          = $this->payrolls_model->GET_ATTENDANCE_LOCK_BENEFITS($DISP_ATTENDANCE_LOCK->id);



        // $DISP_NONTAXABLE_ALLOWANCE              = $this->payrolls_model->GET_NONTAXABLE_ALLOWANCE($empl_id);

        // if (!empty($DISP_NONTAXABLE_ALLOWANCE)) {
        //   foreach ($DISP_NONTAXABLE_ALLOWANCE as $NONTAXABLE_ALLOWANCE) {
        //     $NONTAXABLE_ALLOWANCE->value           = $this->payrolls_model->GET_NONTAXABLE_CATEGORY_VALUE($NONTAXABLE_ALLOWANCE->category);
        //     $NONTAXABLE_ALLOWANCE->type            = $this->payrolls_model->GET_NONTAXABLE_TYPE_NAME($NONTAXABLE_ALLOWANCE->type);

        //     if ($NONTAXABLE_ALLOWANCE->value === null) {
        //       $NONTAXABLE_ALLOWANCE->value = '0';
        //     }
        //   }
        // }

        $nonTaxableAllowance = [];
        $total_rc_alo_ovm = 0;

        // Merge DISP_ATTENDANCE_LOCK_BENEFITS
        foreach ($DISP_ATTENDANCE_LOCK_BENEFITS as $item) {
          $nonTaxableAllowance[] = $item;
        }

        // Merge DISP_NONTAXABLE_ALLOWANCE
        // foreach ($DISP_NONTAXABLE_ALLOWANCE as $item) {
        //   $nonTaxableAllowance[] = $item;
        // }

        if (!empty($nonTaxableAllowance)) {
          foreach ($nonTaxableAllowance as $item) {
            $total_rc_alo_ovm = $total_rc_alo_ovm  +  $item->value;
          }
        }

        $mul_present        = 1;
        $mul_absent         = 1;
        $mul_tardiness      = 1;
        $mul_undertime      = 1;
        $mul_underbreak     = 1;
        $mul_overbreak      = 1;

        $mul_reg_hours      = 1;
        $mul_reg_ot         = 1.25;
        $mul_reg_nd         = 0.1;
        $mul_reg_ndot       = 1.375;
        $mul_rest_hours     = 1.3;
        $mul_rest_ot        = 1.69;
        $mul_rest_nd        = 1.43;
        $mul_rest_ndot      = 1.859;
        $mul_leg_hours      = 1;
        $mul_leg_ot         = 2.6;
        $mul_leg_nd         = 1.2;
        $mul_leg_ndot       = 2.860;
        $mul_legrest_hours  = 2.6;
        $mul_legrest_ot     = 3.38;
        $mul_legrest_nd     = 2.86;
        $mul_legrest_ndot   = 3.718;
        $mul_spe_hours      = 0.3;
        $mul_spe_ot         = 1.69;
        $mul_spe_nd         = 0.43;
        $mul_spe_ndot       = 1.859;
        $mul_sperest_hours  = 1.5;
        $mul_sperest_ot     = 1.95;
        $mul_sperest_nd     = 1.65;
        $mul_sperest_ndot   = 2.145;
        $mul_paid_leave     = 1;


        $tot_reg_hours      = 0;
        $tot_exempt         = 0;
        $tot_offset         = 0;


        $tot_reg_ot         = 0;
        $tot_reg_nd         = 0;
        $tot_reg_ndot       = 0;
        $tot_rest_hours     = 0;
        $tot_rest_ot        = 0;
        $tot_rest_nd        = 0;
        $tot_rest_ndot      = 0;
        $tot_leg_hours      = 0;
        $tot_leg_ot         = 0;
        $tot_leg_nd         = 0;
        $tot_leg_ndot       = 0;
        $tot_legrest_hours  = 0;
        $tot_legrest_ot     = 0;
        $tot_legrest_nd     = 0;
        $tot_legrest_ndot   = 0;
        $tot_spe_hours      = 0;
        $tot_spe_ot         = 0;
        $tot_spe_nd         = 0;
        $tot_spe_ndot       = 0;
        $tot_sperest_hours  = 0;
        $tot_sperest_ot     = 0;
        $tot_sperest_nd     = 0;
        $tot_sperest_ndot   = 0;
        $tot_paid_leave     = 0;
        $basic_pay          = 0;
        $gross_income       = 0;
        $earnings           = 0;
        $tot_absent         = 0;
        $tot_tardiness      = 0;
        $tot_undertime      = 0;
        $tot_underbreak     = 0;
        $tot_overbreak      = 0;
        $tax_allowance_total        = 0;
        $nontax_allowance_total     = 0;
        //---------------------------- INITIAL DECLARATION --
        $sss_ee_prev_1                  = 0;
        $pagibig_ee_prev_1              = 0;
        $philhealth_ee_prev_1           = 0;
        $sss_er_prev_1                  = 0;
        $sss_ec_er_prev_1               = 0;
        $pagibig_er_prev_1              = 0;
        $philhealth_er_prev_1           = 0;
        $sss_ee_prev_2                  = 0;
        $pagibig_ee_prev_2              = 0;
        $philhealth_ee_prev_2           = 0;
        $sss_er_prev_2                  = 0;
        $sss_ec_er_prev_2               = 0;
        $pagibig_er_prev_2              = 0;
        $philhealth_er_prev_2           = 0;
        $sss_ee_prev_3                  = 0;
        $pagibig_ee_prev_3              = 0;
        $philhealth_ee_prev_3           = 0;
        $sss_er_prev_3                  = 0;
        $sss_ec_er_prev_3               = 0;
        $pagibig_er_prev_3              = 0;
        $philhealth_er_prev_3           = 0;
        $sss_ee_prev_4                  = 0;
        $pagibig_ee_prev_4              = 0;
        $philhealth_ee_prev_4           = 0;
        $sss_er_prev_4                  = 0;
        $sss_ec_er_prev_4               = 0;
        $pagibig_er_prev_4              = 0;
        $philhealth_er_prev_4           = 0;
        $sss_ee_prev_5                  = 0;
        $pagibig_ee_prev_5              = 0;
        $philhealth_ee_prev_5           = 0;
        $sss_er_prev_5                  = 0;
        $sss_ec_er_prev_5               = 0;
        $pagibig_er_prev_5              = 0;
        $philhealth_er_prev_5           = 0;
      
        $assume_date        = isset($DISP_ATTENDANCE_LOCK->assume_date) ? $DISP_ATTENDANCE_LOCK->assume_date : 0;
        $assume_day         = isset($DISP_ATTENDANCE_LOCK->assume_day) ? $DISP_ATTENDANCE_LOCK->assume_day : 0;

        $count_present        = isset($DISP_ATTENDANCE_LOCK->present) ? $DISP_ATTENDANCE_LOCK->present : 0;
        $count_present += $assume_day;

        $count_absent = (
        (isset($DISP_ATTENDANCE_LOCK->absent) ? $DISP_ATTENDANCE_LOCK->absent : 0)
        + ((isset($DISP_ATTENDANCE_LOCK->prev_assume_absent) ? $DISP_ATTENDANCE_LOCK->prev_assume_absent : 0) * 8)
        );

        $count_tardiness = (isset($DISP_ATTENDANCE_LOCK->tardiness) ? $DISP_ATTENDANCE_LOCK->tardiness : 0) +
        (isset($DISP_ATTENDANCE_LOCK->prev_assume_tard) ? $DISP_ATTENDANCE_LOCK->prev_assume_tard : 0);
        
        $count_undertime      = isset($DISP_ATTENDANCE_LOCK->undertime) ? $DISP_ATTENDANCE_LOCK->undertime : 0;
        $count_underbreak     = isset($DISP_ATTENDANCE_LOCK->underbreak) ? $DISP_ATTENDANCE_LOCK->underbreak : 0;
        $count_overbreak      = isset($DISP_ATTENDANCE_LOCK->overbreak) ? $DISP_ATTENDANCE_LOCK->overbreak : 0;
        $count_paid_leave     = isset($DISP_ATTENDANCE_LOCK->paid_leave) ? $DISP_ATTENDANCE_LOCK->paid_leave : 0;
        $count_reg_hours      = isset($DISP_ATTENDANCE_LOCK->reg_hours) ? $DISP_ATTENDANCE_LOCK->reg_hours : 0;
        $count_offset         = isset($DISP_ATTENDANCE_LOCK->offset) ? $DISP_ATTENDANCE_LOCK->offset : 0;
        $count_exempt         = isset($DISP_ATTENDANCE_LOCK->exempt) ? $DISP_ATTENDANCE_LOCK->exempt : 0;


        $count_reg_ot         = isset($DISP_ATTENDANCE_LOCK->reg_ot) ? $DISP_ATTENDANCE_LOCK->reg_ot : 0;
        $count_reg_nd         = isset($DISP_ATTENDANCE_LOCK->reg_nd) ? $DISP_ATTENDANCE_LOCK->reg_nd : 0;
        $count_reg_ndot       = isset($DISP_ATTENDANCE_LOCK->reg_ndot) ? $DISP_ATTENDANCE_LOCK->reg_ndot : 0;
        $count_rest_hours     = isset($DISP_ATTENDANCE_LOCK->rest_hours) ? $DISP_ATTENDANCE_LOCK->rest_hours : 0;
        $count_rest_ot        = isset($DISP_ATTENDANCE_LOCK->rest_ot) ? $DISP_ATTENDANCE_LOCK->rest_ot : 0;
        $count_rest_nd        = isset($DISP_ATTENDANCE_LOCK->rest_nd) ? $DISP_ATTENDANCE_LOCK->rest_nd : 0;
        $count_rest_ndot      = isset($DISP_ATTENDANCE_LOCK->rest_ndot) ? $DISP_ATTENDANCE_LOCK->rest_ndot : 0;
        $count_leg_hours      = isset($DISP_ATTENDANCE_LOCK->leg_hours) ? $DISP_ATTENDANCE_LOCK->leg_hours : 0;
        $count_leg_ot         = isset($DISP_ATTENDANCE_LOCK->leg_ot) ? $DISP_ATTENDANCE_LOCK->leg_ot : 0;
        $count_leg_nd         = isset($DISP_ATTENDANCE_LOCK->leg_nd) ? $DISP_ATTENDANCE_LOCK->leg_nd : 0;
        $count_leg_ndot       = isset($DISP_ATTENDANCE_LOCK->leg_ndot) ? $DISP_ATTENDANCE_LOCK->leg_ndot : 0;
        $count_legrest_hours  = isset($DISP_ATTENDANCE_LOCK->legrest_hours) ? $DISP_ATTENDANCE_LOCK->legrest_hours : 0;
        $count_legrest_ot     = isset($DISP_ATTENDANCE_LOCK->legrest_ot) ? $DISP_ATTENDANCE_LOCK->legrest_ot : 0;
        $count_legrest_nd     = isset($DISP_ATTENDANCE_LOCK->legrest_nd) ? $DISP_ATTENDANCE_LOCK->legrest_nd : 0;
        $count_legrest_ndot   = isset($DISP_ATTENDANCE_LOCK->legrest_ndot) ? $DISP_ATTENDANCE_LOCK->legrest_ndot : 0;
        $count_spe_hours      = isset($DISP_ATTENDANCE_LOCK->spe_hours) ? $DISP_ATTENDANCE_LOCK->spe_hours : 0;
        $count_spe_ot         = isset($DISP_ATTENDANCE_LOCK->spe_ot) ? $DISP_ATTENDANCE_LOCK->spe_ot : 0;
        $count_spe_nd         = isset($DISP_ATTENDANCE_LOCK->spe_nd) ? $DISP_ATTENDANCE_LOCK->spe_nd : 0;
        $count_spe_ndot       = isset($DISP_ATTENDANCE_LOCK->spe_ndot) ? $DISP_ATTENDANCE_LOCK->spe_ndot : 0;
        $count_sperest_hours  = isset($DISP_ATTENDANCE_LOCK->sperest_hours) ? $DISP_ATTENDANCE_LOCK->sperest_hours : 0;
        $count_sperest_ot     = isset($DISP_ATTENDANCE_LOCK->sperest_ot) ? $DISP_ATTENDANCE_LOCK->sperest_ot : 0;
        $count_sperest_nd     = isset($DISP_ATTENDANCE_LOCK->sperest_nd) ? $DISP_ATTENDANCE_LOCK->sperest_nd : 0;
        $count_sperest_ndot   = isset($DISP_ATTENDANCE_LOCK->sperest_ndot) ? $DISP_ATTENDANCE_LOCK->sperest_ndot : 0;

        $tot_absent           = $hourly_salary * $mul_absent        * $count_absent;
        $tot_tardiness        = $hourly_salary * $mul_tardiness     * $count_tardiness;
        $tot_undertime        = $hourly_salary * $mul_undertime     * $count_undertime;
        $tot_underbreak       = $hourly_salary * $mul_underbreak    * $count_underbreak;
        $tot_overbreak        = $hourly_salary * $mul_overbreak     * $count_overbreak;
        $tot_paid_leave       = $hourly_salary * $mul_paid_leave    * $count_paid_leave;


        $tot_reg_hours        = $hourly_salary * $mul_reg_hours     * $count_reg_hours;
        $tot_offset_hours     = $hourly_salary * $mul_reg_hours     * $count_offset;
        $tot_exempt_hours     = $hourly_salary * $mul_reg_hours     * $count_exempt;

        $tot_reg_ot           = $hourly_salary * $mul_reg_ot        * $count_reg_ot;
        $tot_reg_nd           = $hourly_salary * $mul_reg_nd        * $count_reg_nd;
        $tot_reg_ndot         = $hourly_salary * $mul_reg_ndot      * $count_reg_ndot;
        $tot_rest_hours       = $hourly_salary * $mul_rest_hours    * $count_rest_hours;
        $tot_rest_ot          = $hourly_salary * $mul_rest_ot       * $count_rest_ot;
        $tot_rest_nd          = $hourly_salary * $mul_rest_nd       * $count_rest_nd;
        $tot_rest_ndot        = $hourly_salary * $mul_rest_ndot     * $count_rest_ndot;
        $tot_leg_hours        = $hourly_salary * $mul_leg_hours     * $count_leg_hours;
        $tot_leg_ot           = $hourly_salary * $mul_leg_ot        * $count_leg_ot;
        $tot_leg_nd           = $hourly_salary * $mul_leg_nd        * $count_leg_nd;
        $tot_leg_ndot         = $hourly_salary * $mul_leg_ndot      * $count_leg_ndot;
        $tot_legrest_hours    = $hourly_salary * $mul_legrest_hours * $count_legrest_hours;
        $tot_legrest_ot       = $hourly_salary * $mul_legrest_ot    * $count_legrest_ot;
        $tot_legrest_nd       = $hourly_salary * $mul_legrest_nd    * $count_legrest_nd;
        $tot_legrest_ndot     = $hourly_salary * $mul_legrest_ndot  * $count_legrest_ndot;
        $tot_spe_hours        = $hourly_salary * $mul_spe_hours     * $count_spe_hours;
        $tot_spe_ot           = $hourly_salary * $mul_spe_ot        * $count_spe_ot;
        $tot_spe_nd           = $hourly_salary * $mul_spe_nd        * $count_spe_nd;
        $tot_spe_ndot         = $hourly_salary * $mul_spe_ndot      * $count_spe_ndot;
        $tot_sperest_hours    = $hourly_salary * $mul_sperest_hours * $count_sperest_hours;
        $tot_sperest_ot       = $hourly_salary * $mul_sperest_ot    * $count_sperest_ot;
        $tot_sperest_nd       = $hourly_salary * $mul_sperest_nd    * $count_sperest_nd;
        $tot_sperest_ndot     = $hourly_salary * $mul_sperest_ndot  * $count_sperest_ndot;


        ////---------------------------------- B. REGULAR HOURS COMPUTATION----------------------------------------------
        // 
        // 
        if ($salary_type == "Daily") {
          $regular_pay        = $tot_reg_hours + $tot_offset_hours + $tot_exempt_hours;
        } else {
          $regular_pay        = ($salary_rate / 2) - $tot_paid_leave;
        }

        //---------------------------------- C. CALCULATION OF BASIC PAY ----------------------------------------------
        // A. BASIC PAY                  = REGULAR PAY + PAID LEAVE - ABSENCES - TARDINESS - UNDERTIME - OVER/UNDERBREAK

        $basic_pay            = $regular_pay + $tot_paid_leave - ($tot_absent + $tot_tardiness + $tot_undertime + $tot_underbreak + $tot_overbreak);


        //---------------------------------- D. TOTAL OT PAY ----------------------------------------------
        // B. TOTAL OT PAY               = ALL ND AND OT 
        $ot_pay               = $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;


        //---------------------------------- E. TOTAL TAXABLE ALLOWANCE ----------------------------------------------
        // C. TOTAL TAXABLE ALLOWANCE    = SUM OF ALL TAXABLE ALLOWANCES

        // $DISP_TAXABLE_ALLOWANCE                 = $this->payrolls_model->GET_TAXABLE_ALLOWANCE($empl_id);

        // if(!empty($DISP_TAXABLE_ALLOWANCE)){
        //   foreach($DISP_TAXABLE_ALLOWANCE as $TAXABLE_ALLOWANCE){
        //     $onetime_attendance = $this->payrolls_model->GET_TAXABLE_TYPE_ONETIME_ATTENDANCE($TAXABLE_ALLOWANCE->type);

        //     if($onetime_attendance == 'Attendance' && $TAXABLE_ALLOWANCE->category != '0')
        //     {
        //       $TAXABLE_ALLOWANCE->category        = $this->payrolls_model->GET_TAXABLE_CATEGORY_VALUE($TAXABLE_ALLOWANCE->category) * $count_present;
        //       $TAXABLE_ALLOWANCE->type            = $this->payrolls_model->GET_TAXABLE_TYPE_NAME($TAXABLE_ALLOWANCE->type);
        //     }

        //     if($onetime_attendance == 'One-Time'  && $TAXABLE_ALLOWANCE->category != '0')
        //     {
        //       $date_from                = strtotime($specific_payroll_sched->date_from);
        //       $date_to                  = strtotime($specific_payroll_sched->date_to);
        //       $taxable_start_date       = strtotime($taxable->start_date);
        //       $taxable_end_date         = strtotime($taxable->end_date);

        //       if ($taxable_start_date <= $date_from && $taxable_end_date >=  $date_to) 
        //       {

        //         $TAXABLE_ALLOWANCE->category        = $this->payrolls_model->GET_TAXABLE_CATEGORY_VALUE($TAXABLE_ALLOWANCE->category) ;
        //       $TAXABLE_ALLOWANCE->type            = $this->payrolls_model->GET_TAXABLE_TYPE_NAME($TAXABLE_ALLOWANCE->type);
        //       }
        //     }

        //   }
        // }


        $taxable_attendance_value_sum     = 0;
        $taxable_onetime_value_sum        = 0;

        $taxable_allowance = $this->payrolls_model->GET_SPECIFIC_TAXABLE_ALLOWANCE($empl_id);

  
        if (!empty($taxable_allowance)) {
          foreach ($taxable_allowance as $taxable) {

            $day = date('d', strtotime( $specific_payroll_sched->payout));
    
            // release date should match on payout date
            if($taxable->release_date == $day || $taxable->release_date == "Every Cut-off"  || $taxable->release_date == ""){

              $onetime_attendance = $this->payrolls_model->GET_TAXABLE_TYPE_ONETIME_ATTENDANCE($taxable->type);

              if ($onetime_attendance == 'Attendance' && $taxable->category != '0') {
                $taxable_attendance_value = $this->payrolls_model->GET_TAXABLE_CATEGORY_VALUE($taxable->category);
                $taxable_attendance_value_sum += $taxable_attendance_value;

                $taxable->category        = $this->payrolls_model->GET_TAXABLE_CATEGORY_VALUE($taxable->category) * $count_present;
                $taxable->type            = $this->payrolls_model->GET_TAXABLE_TYPE_NAME($taxable->type);
              }

              if ($onetime_attendance == 'One-Time'  && $taxable->category != '0' && ($taxable->start_date != '0000-00-00' || $taxable->end_date != '0000-00-00') ) {
                $date_from                = strtotime($specific_payroll_sched->date_from);
                $date_to                  = strtotime($specific_payroll_sched->date_to);
                $taxable_start_date       = strtotime($taxable->start_date);
                $taxable_end_date         = strtotime($taxable->end_date);

                if ($taxable_start_date <= $date_from && $taxable_end_date >=  $date_to) {
                  $taxable_onetime_value = $this->payrolls_model->GET_TAXABLE_CATEGORY_VALUE($taxable->category);
                  $taxable_onetime_value_sum += $taxable_onetime_value;

                  $taxable->category        = $this->payrolls_model->GET_TAXABLE_CATEGORY_VALUE($taxable->category);
                  $taxable->type            = $this->payrolls_model->GET_TAXABLE_TYPE_NAME($taxable->type);
                } else {
                  $taxable->category        = 0;
                  $taxable->type            = $this->payrolls_model->GET_TAXABLE_TYPE_NAME($taxable->type);
                }
              }

              if($onetime_attendance == 'One-Time'  && $taxable->category != '0' && $taxable->start_date == '0000-00-00' && $taxable->end_date == '0000-00-00'){
                $taxable_onetime_value = $this->payrolls_model->GET_TAXABLE_CATEGORY_VALUE($taxable->category);
                  $taxable_onetime_value_sum += $taxable_onetime_value;
              }
            }
          }
        }

        $transportation_tax_allowance = $this->payrolls_model->GET_ALL_TAX_TANSPORTATION_ALLOWANCE($empl_id);
        $total_tansporation_allo = 0;

        if (!empty($transportation_tax_allowance)) {
          foreach ($transportation_tax_allowance as $transpo) {
            $total_tansporation_allo += $this->payrolls_model->GET_NIGHSHIFT_CATEGORY_TAX_VALUE($transpo->nightshift_category);
          }
        }

        $nightshift_allo_tax = $this->payrolls_model->GET_SYSTEM_SETUP_SETTING('night_shift_allowance_tax'); // if night shift is hide the value of allowance should be zero
        if($nightshift_allo_tax == 0){
          $total_tansporation_allo = 0;
        }

        $tax_allowance_total = $total_tansporation_allo + $taxable_onetime_value_sum + ($taxable_attendance_value_sum * $count_present);

        if ($en_ti == 0) {
          $tax_allowance_total = 0;
        }

        //---------------------------------- F. TOTAL NONTAXABLE ALLOWANCE ----------------------------------------------
        // D. TOTAL NONTAXABLE ALLOWANCE = SUM OF ALL NONTAXABLE ALLOWANCES 


        $nontaxable_attendance_value_sum     = 0;
        $nontaxable_onetime_value_sum        = 0;

        $nontaxable_allowance = $this->payrolls_model->GET_SPECIFIC_NONTAXABLE_ALLOWANCE($empl_id);

        if (!empty($nontaxable_allowance)) {
          foreach ($nontaxable_allowance as $nontaxable) {
            $day = date('d', strtotime( $specific_payroll_sched->payout));
            // var_dump( $day);
            // var_dump( $nontaxable->release_date == $day);

            // release date should match on payout date
            if($nontaxable->release_date == $day || $nontaxable->release_date == "Every Cut-off" || $nontaxable->release_date == ""){

              $nontax_onetime_attendance = $this->payrolls_model->GET_NONTAXABLE_TYPE_ONETIME_ATTENDANCE($nontaxable->type);

              if ($nontax_onetime_attendance == 'Attendance' && $nontaxable->category != '0') {
                $nontaxable_attendance_value = $this->payrolls_model->GET_NONTAXABLE_CATEGORY_VALUE($nontaxable->category);
                $nontaxable_attendance_value_sum += $nontaxable_attendance_value;
              }

              if ($nontax_onetime_attendance == 'One-Time'  && $nontaxable->category != '0' && ($nontaxable->start_date != '0000-00-00' || $nontaxable->end_date != '0000-00-00')) {
                $date_from                = strtotime($specific_payroll_sched->date_from);
                $date_to                  = strtotime($specific_payroll_sched->date_to);
                $nontaxable_start_date       = strtotime($nontaxable->start_date);
                $nontaxable_end_date         = strtotime($nontaxable->end_date);

                if ($nontaxable_start_date <= $date_from && $nontaxable_end_date >=  $date_to) {
                  $nontaxable_onetime_value = $this->payrolls_model->GET_NONTAXABLE_CATEGORY_VALUE($nontaxable->category);
                  $nontaxable_onetime_value_sum += $nontaxable_onetime_value;
                }
              }

              if($nontax_onetime_attendance == 'One-Time'  && $nontaxable->category != '0' && $nontaxable->start_date == '0000-00-00' && $nontaxable->end_date == '0000-00-00'){
                $nontaxable_onetime_value = $this->payrolls_model->GET_NONTAXABLE_CATEGORY_VALUE($nontaxable->category);
                $nontaxable_onetime_value_sum += $nontaxable_onetime_value;
              }
            }
          }
        }

        $transportation_nontax_allowance = $this->payrolls_model->GET_ALL_NONTAX_TANSPORTATION_ALLOWANCE($empl_id);
        $total_nontax_tansporation_all = 0;

        if (!empty($transportation_nontax_allowance)) {
          foreach ($transportation_nontax_allowance as $transpo) {
            $total_nontax_tansporation_all += $this->payrolls_model->GET_NIGHSHIFT_CATEGORY_NONTAX_VALUE($transpo->nightshift_category);
          }
        }

        $nightshift_allo_nontax = $this->payrolls_model->GET_SYSTEM_SETUP_SETTING('night_shift_allowance_nontax'); // if night shift is hide the value of allowance should be zero
        if($nightshift_allo_nontax == 0){
          $total_nontax_tansporation_all = 0;
        }

        $nontax_allowance_total = $total_nontax_tansporation_all + $total_rc_alo_ovm + $nontaxable_onetime_value_sum + ($nontaxable_attendance_value_sum * $count_present);

        if ($en_nti == 0) {
          $nontax_allowance_total = 0;
        }
        
        //---------------------------------- TOTAL ADJUSTMENT BENEFITS ----------------------------------------------

        $benefits_adjustment = $this->payrolls_model->GET_BENEFITS_ADJUSTMENT_ASSIGN($empl_id, $period);
        $total_benefits_adjustment = 0;
        if($benefits_adjustment){
          foreach ($benefits_adjustment as $adjustment){
            $total_benefits_adjustment += ($adjustment->value + ($hourly_salary * $adjustment->value_hour));
          }
        }
        

        //---------------------------------- OTHER DEDUCTIONS ----------------------------------------------
        $other_deductions_sum = 0;
        $other_deductions = $this->payrolls_model->GET_SPECIFIC_OTHER_DEDUCTIONS($empl_id, $period);
        if(!empty($other_deductions)){
          foreach ($other_deductions as $deduction){
            $deduction->type = $this->payrolls_model->GET_OTHER_DEDUCTION_TYPE_NAME($deduction->type);
            $other_deductions_sum += $deduction->value;
          }
        }

        //--------------------------------------------------------


        $period_data                      = $this->payrolls_model->GET_PERIOD_DATA($period);
        $period_frequency                 = $period_data->pay_frequency;
        $period_year                      = $period_data->year;
        $period_connected                 = $this->payrolls_model->GET_PERIOD_CONNECTED($period);
        $connected_1 = 0;
        $connected_2 = 0;
        $connected_3 = 0;
        $connected_4 = 0;
        $connected_5 = 0;
        if (count($period_connected) > 0) {
          $connected_1 = $period_connected[0]->connected_period;
          $connected_2 = $period_connected[0]->connected_period_2;
          $connected_3 = $period_connected[0]->connected_period_3;
          $connected_4 = $period_connected[0]->connected_period_4;
          $connected_5 = $period_connected[0]->connected_period_5;
        }

        $employee_leaves = $this->payrolls_model->GET_EMPLOYEE_LEAVE($empl_id, $date_from, $date_to);
        if (!empty($employee_leaves)) {
          foreach ($employee_leaves as $employee_leaves_row) {
            $employee_leaves_row->days = $employee_leaves_row->duration / 8;
            $employee_leaves_row->amount = (float)($employee_leaves_row->duration / 8) * $daily_salary;
          }
        }
        $string_leaves = str_replace('"', '@', json_encode($employee_leaves));
        $employee_specific                  = $this->payrolls_model->GET_EMPLOYEE_INFO_SPECIFIC($empl_id);
        $ID_SSS                             = isset($employee_specific[0]->col_empl_sssc) ? $employee_specific[0]->col_empl_sssc : 0;
        $ID_PAGIBIG                         = isset($employee_specific[0]->col_empl_hdmf) ? $employee_specific[0]->col_empl_hdmf : 0;
        $ID_PHILHEALTH                      = isset($employee_specific[0]->col_empl_phil) ? $employee_specific[0]->col_empl_phil : 0;
        $ID_TIN                             = isset($employee_specific[0]->col_empl_btin) ? $employee_specific[0]->col_empl_btin : 0;





        //---------------------------------- F. CALCULATION OF GROSS PAY ----------------------------------------------
        // E. GROSS PAY                  = BASIC PAY + TOTAL OT PAY + TOTAL TAXABLE ALLOWANCE + TOTAL NONTAXABLE ALLOWANCE
        $gross_income        = $basic_pay + $ot_pay + $tax_allowance_total + $nontax_allowance_total + $total_benefits_adjustment;




        if ($connected_1 == 0) {
          $gross_income_prev_1 = 0;
        } else {
          $connected_data_previous_1          = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_1);
          if (empty($connected_data_previous_1)) {
            $gross_income_prev_1  = 0;
            $sss_ee_prev_1        = 0;
            $pagibig_ee_prev_1    = 0;
            $philhealth_ee_prev_1 = 0;
            $sss_er_prev_1        = 0;
            $sss_ec_er_prev_1     = 0;
            $pagibig_er_prev_1    = 0;
            $philhealth_er_prev_1 = 0;
          } else {
            $gross_income_prev_1    = isset($connected_data_previous_1->GROSS_INCOME)             ? $connected_data_previous_1->GROSS_INCOME : 0;
            $sss_ee_prev_1          = isset($connected_data_previous_1->SSS_EE_CURRENT)           ? $connected_data_previous_1->SSS_EE_CURRENT : 0;
            $pagibig_ee_prev_1      = isset($connected_data_previous_1->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_1->PHILHEALTH_EE_CURRENT : 0;
            $philhealth_ee_prev_1   = isset($connected_data_previous_1->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_1->PAGIBIG_EE_CURRENT : 0;
            $sss_er_prev_1          = isset($connected_data_previous_1->SSS_ER_CURRENT)        ? $connected_data_previous_1->SSS_ER_CURRENT : 0;
            $sss_ec_er_prev_1       = isset($connected_data_previous_1->SSS_EC_ER_CURRENT)     ? $connected_data_previous_1->SSS_EC_ER_CURRENT : 0;
            $pagibig_er_prev_1      = isset($connected_data_previous_1->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_1->PAGIBIG_ER_CURRENT : 0;
            $philhealth_er_prev_1   = isset($connected_data_previous_1->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_1->PHILHEALTH_ER_CURRENT : 0;
          }
        }
        if ($connected_2 == 0) {
          $gross_income_prev_2 = 0;
        } else {
          $connected_data_previous_2 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_2);
          if (empty($connected_data_previous_2)) {
            $gross_income_prev_2  = 0;
            $sss_ee_prev_2        = 0;
            $pagibig_ee_prev_2    = 0;
            $philhealth_ee_prev_2 = 0;
            $sss_er_prev_2        = 0;
            $sss_ec_er_prev_2     = 0;
            $pagibig_er_prev_2    = 0;
            $philhealth_er_prev_2 = 0;
          } else {
            $gross_income_prev_2    = isset($connected_data_previous_2->GROSS_INCOME)             ? $connected_data_previous_2->GROSS_INCOME : 0;
            $sss_ee_prev_2          = isset($connected_data_previous_2->SSS_EE_CURRENT)           ? $connected_data_previous_2->SSS_EE_CURRENT : 0;
            $pagibig_ee_prev_2      = isset($connected_data_previous_2->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_2->PHILHEALTH_EE_CURRENT : 0;
            $philhealth_ee_prev_2   = isset($connected_data_previous_2->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_2->PAGIBIG_EE_CURRENT : 0;
            $sss_er_prev_2          = isset($connected_data_previous_2->SSS_ER_CURRENT)        ? $connected_data_previous_2->SSS_ER_CURRENT : 0;
            $sss_ec_er_prev_2       = isset($connected_data_previous_2->SSS_EC_ER_CURRENT)     ? $connected_data_previous_2->SSS_EC_ER_CURRENT : 0;
            $pagibig_er_prev_2      = isset($connected_data_previous_2->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_2->PAGIBIG_ER_CURRENT : 0;
            $philhealth_er_prev_2   = isset($connected_data_previous_2->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_2->PHILHEALTH_ER_CURRENT : 0;
          }
        }
        if ($connected_3 == 0) {
          $gross_income_prev_3 = 0;
        } else {
          $connected_data_previous_3 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_3);
          if (empty($connected_data_previous_3)) {
            $gross_income_prev_3  = 0;
            $sss_ee_prev_3        = 0;
            $pagibig_ee_prev_3    = 0;
            $philhealth_ee_prev_3 = 0;
            $sss_er_prev_3        = 0;
            $sss_ec_er_prev_3     = 0;
            $pagibig_er_prev_3    = 0;
            $philhealth_er_prev_3 = 0;
          } else {
            $gross_income_prev_3    = isset($connected_data_previous_3->GROSS_INCOME)             ? $connected_data_previous_3->GROSS_INCOME : 0;
            $sss_ee_prev_3          = isset($connected_data_previous_3->SSS_EE_CURRENT)           ? $connected_data_previous_3->SSS_EE_CURRENT : 0;
            $pagibig_ee_prev_3      = isset($connected_data_previous_3->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_3->PHILHEALTH_EE_CURRENT : 0;
            $philhealth_ee_prev_3   = isset($connected_data_previous_3->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_3->PAGIBIG_EE_CURRENT : 0;
            $sss_er_prev_3          = isset($connected_data_previous_3->SSS_ER_CURRENT)        ? $connected_data_previous_3->SSS_ER_CURRENT : 0;
            $sss_ec_er_prev_3       = isset($connected_data_previous_3->SSS_EC_ER_CURRENT)     ? $connected_data_previous_3->SSS_EC_ER_CURRENT : 0;
            $pagibig_er_prev_3      = isset($connected_data_previous_3->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_3->PAGIBIG_ER_CURRENT : 0;
            $philhealth_er_prev_3   = isset($connected_data_previous_3->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_3->PHILHEALTH_ER_CURRENT : 0;
          }
        }
        if ($connected_4 == 0) {
          $gross_income_prev_4 = 0;
        } else {
          $connected_data_previous_4 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_4);
          if (empty($connected_data_previous_4)) {
            $gross_income_prev_4  = 0;
            $sss_ee_prev_4        = 0;
            $pagibig_ee_prev_4    = 0;
            $philhealth_ee_prev_4 = 0;
            $sss_er_prev_4        = 0;
            $sss_ec_er_prev_4     = 0;
            $pagibig_er_prev_4    = 0;
            $philhealth_er_prev_4 = 0;
          } else {
            $gross_income_prev_4    = isset($connected_data_previous_4->GROSS_INCOME)             ? $connected_data_previous_4->GROSS_INCOME : 0;
            $sss_ee_prev_4          = isset($connected_data_previous_4->SSS_EE_CURRENT)           ? $connected_data_previous_4->SSS_EE_CURRENT : 0;
            $pagibig_ee_prev_4      = isset($connected_data_previous_4->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_4->PHILHEALTH_EE_CURRENT : 0;
            $philhealth_ee_prev_4   = isset($connected_data_previous_4->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_4->PAGIBIG_EE_CURRENT : 0;
            $sss_er_prev_4          = isset($connected_data_previous_4->SSS_ER_CURRENT)        ? $connected_data_previous_4->SSS_ER_CURRENT : 0;
            $sss_ec_er_prev_4       = isset($connected_data_previous_4->SSS_EC_ER_CURRENT)     ? $connected_data_previous_4->SSS_EC_ER_CURRENT : 0;
            $pagibig_er_prev_4      = isset($connected_data_previous_4->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_4->PAGIBIG_ER_CURRENT : 0;
            $philhealth_er_prev_4   = isset($connected_data_previous_4->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_4->PHILHEALTH_ER_CURRENT : 0;
          }
        }
        if ($connected_5 == 0) {
          $gross_income_prev_5 = 0;
        } else {
          $connected_data_previous_5 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_5);
          if (empty($connected_data_previous_5)) {
            $gross_income_prev_5  = 0;
            $sss_ee_prev_5        = 0;
            $pagibig_ee_prev_5    = 0;
            $philhealth_ee_prev_5 = 0;
            $sss_er_prev_5        = 0;
            $sss_ec_er_prev_5     = 0;
            $pagibig_er_prev_5    = 0;
            $philhealth_er_prev_5 = 0;
          } else {
            $gross_income_prev_5    = isset($connected_data_previous_5->GROSS_INCOME)             ? $connected_data_previous_5->GROSS_INCOME : 0;
            $sss_ee_prev_5          = isset($connected_data_previous_5->SSS_EE_CURRENT)           ? $connected_data_previous_5->SSS_EE_CURRENT : 0;
            $pagibig_ee_prev_5      = isset($connected_data_previous_5->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_5->PHILHEALTH_EE_CURRENT : 0;
            $philhealth_ee_prev_5   = isset($connected_data_previous_5->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_5->PAGIBIG_EE_CURRENT : 0;
            $sss_er_prev_5          = isset($connected_data_previous_5->SSS_ER_CURRENT)        ? $connected_data_previous_5->SSS_ER_CURRENT : 0;
            $sss_ec_er_prev_5       = isset($connected_data_previous_5->SSS_EC_ER_CURRENT)     ? $connected_data_previous_5->SSS_EC_ER_CURRENT : 0;
            $pagibig_er_prev_5      = isset($connected_data_previous_5->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_5->PAGIBIG_ER_CURRENT : 0;
            $philhealth_er_prev_5   = isset($connected_data_previous_5->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_5->PHILHEALTH_ER_CURRENT : 0;
          }
        }


        $gross_income_total     = $gross_income + $gross_income_prev_1 + $gross_income_prev_2 + $gross_income_prev_3 + $gross_income_prev_4 + $gross_income_prev_5;
        //---------------------------------- CALCULATION OF SSS ----------------------------------------------
        // F. SSS                        = SSSTABLE (GROSS PAY)

        $sss_ee_current         = isset(($this->payrolls_model->GET_SSS_VALUE_PAYSLIP($monthly_salary, $period_year))[0]->ee) ? ($this->payrolls_model->GET_SSS_VALUE_PAYSLIP($monthly_salary, $period_year))[0]->ee : 0;
        $sss_er_current         = isset(($this->payrolls_model->GET_SSS_VALUE_PAYSLIP($monthly_salary, $period_year))[0]->er) ? ($this->payrolls_model->GET_SSS_VALUE_PAYSLIP($monthly_salary, $period_year))[0]->er : 0;
        $sss_ec_er_current      = isset(($this->payrolls_model->GET_SSS_VALUE_PAYSLIP($monthly_salary, $period_year))[0]->ec_er) ? ($this->payrolls_model->GET_SSS_VALUE_PAYSLIP($monthly_salary, $period_year))[0]->ec_er : 0;

        $sss_ee_diff            = $sss_ee_current - $sss_ee_prev_1 - $sss_ee_prev_2 - $sss_ee_prev_3 - $sss_ee_prev_4 - $sss_ee_prev_5;

        $sss_er_diff            = $sss_er_current - $sss_er_prev_1 - $sss_er_prev_2 - $sss_er_prev_3 - $sss_er_prev_4 - $sss_er_prev_5;
        $sss_ec_er_diff         = $sss_ec_er_current - $sss_ec_er_prev_1 - $sss_ec_er_prev_2 - $sss_ec_er_prev_3 - $sss_ec_er_prev_4 - $sss_ec_er_prev_5;

        $sss_manual             = $this->payrolls_model->GET_SPECIFIC_SSS_CONTRIBUTION($empl_id, $year_id);


        if ($sss_manual != null) {
          $sss_ee_diff = $sss_manual;
        }
        if ($en_sss == 0 || $gross_income_total == 0) {
          $sss_ee_diff = 0;
          $sss_er_diff = 0;
          $sss_ec_er_diff = 0;
        }
        //---------------------------------- CALCULATION OF PAGIBIG ----------------------------------------------
        // G. PAGIBIG                    = PAGIBIGTABLE (REGULAR PAY)
        $pagibig_data             = isset(($this->payrolls_model->GET_PAGIBIG_VALUE_PAYSLIP($period_year))[0]) ? ($this->payrolls_model->GET_PAGIBIG_VALUE_PAYSLIP($period_year))[0] : 0;
        $pagibig_percent          = isset($pagibig_data->percent) ? $pagibig_data->percent : 0;
        $pagibig_min_salary       = isset($pagibig_data->min_salary) ? $pagibig_data->min_salary : 0;
        $pagibig_max_contribution = isset($pagibig_data->max_contribution) ? $pagibig_data->max_contribution : 0;

        if ($regular_pay >= $pagibig_min_salary) {
          $pagibig_ee_current     = $pagibig_max_contribution;
          $pagibig_er_current     = $pagibig_max_contribution;
        } else {
          $pagibig_ee_current     = $regular_pay * $pagibig_percent / 100;
          $pagibig_er_current     = $regular_pay * $pagibig_percent / 100;
        }

        $pagibig_ee_diff = $pagibig_ee_current - $pagibig_ee_prev_1 - $pagibig_ee_prev_2 - $pagibig_ee_prev_3 - $pagibig_ee_prev_4 - $pagibig_ee_prev_5;
        $pagibig_er_diff = $pagibig_er_current - $pagibig_er_prev_1 - $pagibig_er_prev_2 - $pagibig_er_prev_3 - $pagibig_er_prev_4 - $pagibig_er_prev_5;
        $pagibig_manual           = $this->payrolls_model->GET_SPECIFIC_PAGIBIG_CONTRIBUTION($empl_id, $year_id);

        if ($pagibig_manual != null) {
          $pagibig_ee_diff = $pagibig_manual;
        }

        if ($en_pagibig == 0 || $gross_income_total == 0) {
          $pagibig_ee_diff = 0;
          $pagibig_er_diff = 0;
        }
        //---------------------------------- CALCULATION OF PHILHEALTHTABLE ----------------------------------------------
        // H. PHILHEALTH                 = PHILHEALTHTABLE (REGULAR PAY)
        $philhealth_data        = isset(($this->payrolls_model->GET_PHILHEALTH_VALUE_PAYSLIP($period_year))[0]) ? ($this->payrolls_model->GET_PHILHEALTH_VALUE_PAYSLIP($period_year))[0] : 0;
        $philhealth_rate        = isset($philhealth_data->rate) ? $philhealth_data->rate : 0;
        $philhealth_min_basic   = isset($philhealth_data->min_basic) ? $philhealth_data->min_basic : 0;
        $philhealth_max_basic   = isset($philhealth_data->max_basic) ? $philhealth_data->max_basic : 0;
        $philhealth_min_premium = isset($philhealth_data->min_premium) ? $philhealth_data->min_premium : 0;
        $philhealth_max_premium = isset($philhealth_data->max_premium) ? $philhealth_data->max_premium : 0;
        if ($monthly_salary <= $philhealth_min_basic) {
          $philhealth_ee_current = $philhealth_min_premium / 2;
          $philhealth_er_current = $philhealth_min_premium / 2;
        } else if ($monthly_salary >= $philhealth_max_basic) {
          $philhealth_ee_current = $philhealth_max_premium / 2;
          $philhealth_er_current = $philhealth_max_premium / 2;
        } else {
          $philhealth_ee_current = ($monthly_salary * ($philhealth_rate / 100)) / 2;
          $philhealth_er_current = ($monthly_salary * ($philhealth_rate / 100)) / 2;
        }

        $philhealth_ee_diff = $philhealth_ee_current - $philhealth_ee_prev_1 - $philhealth_ee_prev_2 - $philhealth_ee_prev_3 - $philhealth_ee_prev_4 - $philhealth_ee_prev_5;


        $philhealth_er_diff = $philhealth_er_current - $philhealth_er_prev_1 - $philhealth_er_prev_2 - $philhealth_er_prev_3 - $philhealth_er_prev_4 - $philhealth_er_prev_5;


        $philhealth_manual        = $this->payrolls_model->GET_SPECIFIC_PHILHEALTH_CONTRIBUTION($empl_id, $year_id);


        if ($philhealth_manual != null) {
          $philhealth_ee_diff = $philhealth_manual;
        }


        if ($en_phil == 0 || $gross_income_total == 0) {
          $philhealth_ee_diff = 0;
          $philhealth_er_diff = 0;
        }
        // I. GOVERNMENT CONTRIBUTIONS   = SSS EE + PHILHEALTH EE + PAGIBIG EE


        $ee_difference_total                    = $sss_ee_diff + $pagibig_ee_diff + $philhealth_ee_diff;
        //---------------------------------- CALCULATION OF TAXABLE INCOME ----------------------------------------------
        $taxable_income                     = $gross_income - $nontax_allowance_total - $ee_difference_total;

        $gross_taxable_income               = $this->payrolls_model->GET_GROSS_TAXABLE_INCOME($empl_id, $year);
        $total_gross_tax_income             = (($gross_taxable_income == null) ? 0 : $gross_taxable_income) + $taxable_income;

        $gross_nontaxable_income            = $this->payrolls_model->GET_GROSS_NONTAX_INCOME($empl_id, $year);
        $total_gross_nontaxe_income         = (($gross_nontaxable_income == null) ? 0 : $gross_nontaxable_income) + $nontax_allowance_total;

        //---------------------------------- CALCULATION OF WITHHOLDING TAX ----------------------------------------------
        $wtax_raw = $this->payrolls_model->GET_TAX_VALUE_PAYSLIP($taxable_income, $period_frequency);

        $wtax_salary_min      = 0;
        $wtax_salary_max      = 0;
        $wtax_salary_fixed    = 0;
        $wtax_salary_clevel   = 0;
        $wtax_salary_cpercent = 0;
        if ($wtax_raw) {
          $wtax_salary_min      = $wtax_raw["salary_min"];
          $wtax_salary_max      = $wtax_raw["salary_max"];
          $wtax_salary_fixed    = $wtax_raw["fixed"];
          $wtax_salary_clevel   = $wtax_raw["c_level"];
          $wtax_salary_cpercent = $wtax_raw["c_percent"];
        }
        $wtax                   = $wtax_salary_fixed + ($taxable_income - $wtax_salary_clevel) * $wtax_salary_cpercent / 100;


        if ($en_wtax == 0) {
          $wtax = 0;
        }

        $gros_wtax                           = $this->payrolls_model->GET_GROSS_WTAX($empl_id, $year);
        $total_gross_wtax                    = (($gros_wtax == null) ? 0 : $gros_wtax) + $wtax;

        //---------------------------------- CALCULATION OF LOANS ----------------------------------------------

        $employee_loan_ids                  = $this->payrolls_model->GET_PAYROLL_LOAN_DATA_EMPL($empl_id);
        $employee_loans                     = $this->payrolls_model->GET_ALL_PAYROLL_LOAN_DATA_EMPL($empl_id);

        $loan_total = 0;

        if (!empty($employee_loans)) { //loans type
          foreach ($employee_loans as $loan_user_all_row) {
            // $loan_contrib                       = (float)$loan_user_all_row->loan_amount / $loan_user_all_row->loan_terms;
            // $loan_total                         = $loan_total + $loan_contrib;
            $loan_total                         = $loan_total + (float)$loan_user_all_row->loan_amount;
            $loan_user_all_row->loan_type       = $this->payrolls_model->GET_SPECIFIC_LOAN_TYPE($loan_user_all_row->loan_type);
            $loan_count                         = $this->payrolls_model->GET_SUM_LOANS($loan_user_all_row->id);
            $laon_total_count                   = $loan_user_all_row->initial_paid + $loan_count + 1;

            $paid_amount                        = (float)$loan_user_all_row->loan_amount * $laon_total_count;
            $loan_user_all_row->paid_amount     = $paid_amount;
            $payable                            = (float)$loan_user_all_row->loan_amount * $loan_user_all_row->loan_terms;
            $loan_user_all_row->payable         = $payable;
            $loan_user_all_row->bal_amount      = $payable - $paid_amount;

            if ($loan_user_all_row->bal_amount < 0) {
              $loan_total = 0;
            }
          }
        }


        if ($en_loan == 0) {
          $loan_total = 0;
          $employee_loan_ids = [];
        }

        $string_loan = $employee_loans;
        //---------------------------------- CALCULATION OF DEDUCTIONS ----------------------------------------------


        $total_deduction = $wtax + $loan_total + $ee_difference_total + $other_deductions_sum;



        //---------------------------------- CALCULATION OF NET PAY ----------------------------------------------

        $earnings                               = 0;
        $deductions                             = $total_deduction;
        $net_income                             = $gross_income - $wtax - $ee_difference_total - $loan_total - $other_deductions_sum;


        //---------------------------------- SENDING DATA TO HANDSONTABLE ----------------------------------------------

        $employeeObject                         = new stdClass();
        $employeeObject->id                     = $empl_id;                                   //DB EMPLOYEE ID (HIDE)
        $employeeObject->period                 = $period;                                    //PAYROLL
        $employeeObject->cmid                   = $cmid;                                      //ACTUAL EMPLOYEE ID
        $employeeObject->fullname               = $fullname;                                  //EMPLOYEE NAME
        $employeeObject->salary_type            = $salary_type;                               //SALARY TYPE
        $employeeObject->salary_rate            = sprintf("%.12f",$salary_rate);             //SALARY RATE
        
        $employeeObject->workdaysperyear        = number_format($workdaysperyear, 2);         //WORK DAYS PER YEAR
        $employeeObject->bank_name              = $bank_name;                                 //BANK NAME
        $employeeObject->bank_account           = $account_number;                            //BANK ACCOUNT

        $employeeObject->sss_id                 = $sss_id;
        $employeeObject->pagibig_id             = $pagibig_id;
        $employeeObject->philhealth_id          = $philhealth_id;
        $employeeObject->tin_id                 = $tin_id;
        $employeeObject->designation            = $designation;

        $employeeObject->monthly_salary         = number_format($monthly_salary, 2);          //MONTHLY SALARY
        $employeeObject->daily_salary           = number_format($daily_salary, 2);            //DAILY SALARY
        $employeeObject->hourly_salary          = number_format($hourly_salary, 2);           //HOURLY SALARY

        $employeeObject->regular_pay            = number_format($regular_pay, 2);             //REGULAR
        $employeeObject->paid_leave             = number_format((float)$tot_paid_leave, 2);   //PAID LEAVE
        $employeeObject->absent                 = number_format($tot_absent, 2);              //ABSENCES
        $employeeObject->tardiness              = number_format($tot_tardiness, 2);           //TARDINESS
        $employeeObject->undertime              = number_format($tot_undertime, 2);           //UNDERTIME
        $employeeObject->underbreak             = number_format($tot_underbreak, 2);          //UNDERBREAK
        $employeeObject->overbreak              = number_format($tot_overbreak, 2);           //OVERBREAK 
        $employeeObject->basic_pay              = number_format((float)$basic_pay, 2);        //BASIC PAY

        $employeeObject->reg_ot                 = number_format($tot_reg_ot, 2);
        $employeeObject->reg_nd                 = number_format($tot_reg_nd, 2);
        $employeeObject->reg_ndot               = number_format($tot_reg_ndot, 2);
        $employeeObject->rest_hour              = number_format($tot_rest_hours, 2);
        $employeeObject->rest_ot                = number_format($tot_rest_ot, 2);
        $employeeObject->rest_nd                = number_format($tot_rest_nd, 2);
        $employeeObject->rest_ndot              = number_format($tot_rest_ndot, 2);
        $employeeObject->leg_hours              = number_format($tot_leg_hours, 2);
        $employeeObject->leg_ot                 = number_format($tot_leg_ot, 2);
        $employeeObject->leg_nd                 = number_format($tot_leg_nd, 2);
        $employeeObject->leg_ndot               = number_format($tot_leg_ndot, 2);
        $employeeObject->legrest_hours          = number_format($tot_legrest_hours, 2);
        $employeeObject->legrest_ot             = number_format($tot_legrest_ot, 2);
        $employeeObject->legrest_nd             = number_format($tot_legrest_nd, 2);
        $employeeObject->legrest_ndot           = number_format($tot_legrest_ndot, 2);
        $employeeObject->spe_hours              = number_format($tot_spe_hours, 2);
        $employeeObject->spe_ot                 = number_format($tot_spe_ot, 2);
        $employeeObject->spe_nd                 = number_format($tot_spe_nd, 2);
        $employeeObject->spe_ndot               = number_format($tot_spe_ndot, 2);            // SPE NDOT
        $employeeObject->sperest_hours          = number_format($tot_sperest_hours, 2);       // SPEREST HOURS
        $employeeObject->sperest_ot             = number_format($tot_sperest_ot, 2);          // SPEREST OT
        $employeeObject->sperest_nd             = number_format($tot_sperest_nd, 2);          // SPEREST ND
        $employeeObject->sperest_ndot           = number_format($tot_sperest_ndot, 2);        // SPEREST NDOT
        $employeeObject->ot_pay                 = number_format($ot_pay, 2);                  // TOTAL OT PAY
        
        $employeeObject->other_deductions_sum   = number_format($other_deductions_sum, 2);    // OTHER DEDUCTIONS
        $employeeObject->tax_allowance_total    = number_format($tax_allowance_total, 2);
        $employeeObject->nontax_allowance_total = number_format($nontax_allowance_total, 2);
        $employeeObject->benefits_adjustment    = number_format($total_benefits_adjustment, 2);
        $employeeObject->total_ndot_pay         = number_format($ot_pay, 2);
        $employeeObject->gross_income           = number_format((float)$gross_income, 2);
        $employeeObject->taxable_income         = number_format((float)$taxable_income, 2);
        $employeeObject->wtax                   = number_format((float)$wtax, 2);

        $employeeObject->sss_ee_current         = number_format((float)$sss_ee_diff, 2);
        $employeeObject->pagibig_ee_current     = number_format((float)$pagibig_ee_diff, 2);
        $employeeObject->philhealth_ee_current  = number_format((float)$philhealth_ee_diff, 2);
        $employeeObject->ee_difference_total    = number_format((float)$ee_difference_total, 2);

        $employeeObject->ytd_gross_tax          = number_format((float)$total_gross_tax_income, 2);
        $employeeObject->ytd_exclusion          = number_format((float)$total_gross_nontaxe_income, 2);
        $employeeObject->ytd_wtax               = number_format((float)$total_gross_wtax, 2);

        $employeeObject->loan_total             = number_format((float)$loan_total, 2);
        $employeeObject->ca_total               = number_format(0, 2);
        $employeeObject->deduct_total           = number_format((float)$deductions, 2);
        $employeeObject->net_income             = number_format((float)$net_income, 2);

        //---------------------------- LAHAT NG NASA TAAS KASAMA ------------------------------------------------

        $employeeObject->sss_er_current         = number_format((float)$sss_er_diff);
        $employeeObject->sss_ec_er_current      = number_format((float)$sss_ec_er_diff);
        $employeeObject->pagibig_er_current     = number_format((float)$pagibig_er_diff);
        $employeeObject->philhealth_er_current  = number_format((float)$philhealth_er_diff);

        $employeeObject->benefits_col           = $nonTaxableAllowance;
        $employeeObject->benefits_tax_allowance = $taxable_allowance;
        $employeeObject->count_present          = $count_present;
        $employeeObject->count_paid_leave       = $count_paid_leave;
        $employeeObject->count_absent           = $count_absent;
        $employeeObject->count_tardiness        = $count_tardiness;
        $employeeObject->count_undertime        = $count_undertime;
        $employeeObject->count_underbreak       = $count_underbreak;
        $employeeObject->count_overbreak        = $count_overbreak;

        $employeeObject->count_reg_hours        = $count_reg_hours;
        $employeeObject->count_reg_ot           = $count_reg_ot;
        $employeeObject->count_reg_nd           = $count_reg_nd;
        $employeeObject->count_reg_ndot         = $count_reg_ndot;
        $employeeObject->count_rest_hours       = $count_rest_hours;
        $employeeObject->count_rest_ot          = $count_rest_ot;
        $employeeObject->count_rest_nd          = $count_rest_nd;
        $employeeObject->count_rest_ndot        = $count_rest_ndot;
        $employeeObject->count_leg_hours        = $count_leg_hours;
        $employeeObject->count_leg_ot           = $count_leg_ot;
        $employeeObject->count_leg_nd           = $count_leg_nd;
        $employeeObject->count_leg_ndot         = $count_leg_ndot;
        $employeeObject->count_legrest_hours    = $count_legrest_hours;
        $employeeObject->count_legrest_ot       = $count_legrest_ot;
        $employeeObject->count_legrest_nd       = $count_legrest_nd;
        $employeeObject->count_legrest_ndot     = $count_legrest_ndot;
        $employeeObject->count_spe_hours        = $count_spe_hours;
        $employeeObject->count_spe_ot           = $count_spe_ot;
        $employeeObject->count_spe_nd           = $count_spe_nd;
        $employeeObject->count_spe_ndot         = $count_spe_ndot;
        $employeeObject->count_sperest_hours    = $count_sperest_hours;
        $employeeObject->count_sperest_ot       = $count_sperest_ot;
        $employeeObject->count_sperest_nd       = $count_sperest_nd;
        $employeeObject->count_sperest_ndot     = $count_sperest_ndot;
        $employeeObject->mul_present            = $mul_present;
        $employeeObject->mul_absent             = $mul_absent;
        $employeeObject->mul_tardiness          = $mul_tardiness;
        $employeeObject->mul_undertime          = $mul_undertime;
        $employeeObject->mul_underbreak         = $mul_underbreak;
        $employeeObject->mul_overbreak          = $mul_overbreak;
        $employeeObject->mul_paid_leave         = $mul_paid_leave;
        $employeeObject->mul_reg_hours          = $mul_reg_hours;
        $employeeObject->mul_reg_ot             = $mul_reg_ot;
        $employeeObject->mul_reg_nd             = $mul_reg_nd;
        $employeeObject->mul_reg_ndot           = $mul_reg_ndot;
        $employeeObject->mul_rest_hours         = $mul_rest_hours;
        $employeeObject->mul_rest_ot            = $mul_rest_ot;
        $employeeObject->mul_rest_nd            = $mul_rest_nd;
        $employeeObject->mul_rest_ndot          = $mul_rest_ndot;
        $employeeObject->mul_leg_hours          = $mul_leg_hours;
        $employeeObject->mul_leg_ot             = $mul_leg_ot;
        $employeeObject->mul_leg_nd             = $mul_leg_nd;
        $employeeObject->mul_leg_ndot           = $mul_leg_ndot;
        $employeeObject->mul_legrest_hours      = $mul_legrest_hours;
        $employeeObject->mul_legrest_ot         = $mul_legrest_ot;
        $employeeObject->mul_legrest_nd         = $mul_legrest_nd;
        $employeeObject->mul_legrest_ndot       = $mul_legrest_ndot;
        $employeeObject->mul_spe_hours          = $mul_spe_hours;
        $employeeObject->mul_spe_ot             = $mul_spe_ot;
        $employeeObject->mul_spe_nd             = $mul_spe_nd;
        $employeeObject->mul_spe_ndot           = $mul_spe_ndot;
        $employeeObject->mul_sperest_hours      = $mul_sperest_hours;
        $employeeObject->mul_sperest_ot         = $mul_sperest_ot;
        $employeeObject->mul_sperest_nd         = $mul_sperest_nd;
        $employeeObject->mul_sperest_ndot       = $mul_sperest_ndot;

        $employeeObject->other_deductions_list  = $other_deductions;
        $employeeObject->loan_list              = $string_loan;
        $employeeObject->leave_vaction_used     = $vac_duration;
        $employeeObject->leave_vaction_bal      = $leave_vac_bal;
        $employeeObject->leave_sick_used        = $sick_duration;
        $employeeObject->leave_sick_bal         = $leave_sick_bal;
        $employeeObject->leave_entitlement      = $entitlementValues;
        $employeeObject->leaves_list            = $string_leaves;

        $employeePayrollSummary[] = $employeeObject;
      }

      $data['DISP_PAYROLL_SUMMARY'] = $employeePayrollSummary;
      // var_dump($employeePayrollSummary);

      $data['PERIOD']                           = $period;
      $data['SPECIFIC_PAYROLL_SCHEDULES']               = $specific_payroll_sched;
      $data['PAYROLL_SCHEDULES']                        = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_summary_views', $data);
    }

    function generate_payslips()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      // try {
      //   foreach ($data as $data_row) {
      //     $this->payrolls_model->GENERATE_PAYSLIP($data_row);
      //   }
      //   $response = array('success_message' => 'Data updated successfully');
      // } catch (Exception $e) {
      //   $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      // }

      
      $warning_messages = array(); // Initialize array to store warning messages

      foreach ($data as $data_row) {
          $result = $this->payrolls_model->GENERATE_PAYSLIP($data_row);

          // Check if there's an error message in the result
          $result_array = json_decode($result ?? '[]', true);

          if (isset($result_array['error'])) {
              $warning_messages[] = $result_array['error'];
          }
      }

      // Prepare response
      $response = array();
      if (!empty($warning_messages)) {
          // If there are warning messages, add them to the response
          $response['warning_messages'] = $warning_messages;
      } else {
          // Otherwise, add a success message
          $response['success_message'] = "Data updated successfully";
          $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Generated payslips');
      }
      echo json_encode($response);
    }

    function payroll_status()
    {
      $period                                     = $this->input->get('period');
      $status                                     = $this->input->get('status');
      $tab                                        = $this->input->get('tab');
      $data['CUTOFF_PERIODS']                     = $this->payrolls_model->GET_CUTOFF_LIST();
      $payroll_list                               = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      if ($period == null && !empty($payroll_list)) {
        $period = $payroll_list[0]->period;
      }
      if ($tab == null || $tab == '') {
        $tab = 'pending';
      }
      $data['TAB']                                = $tab;
      $data['PERIOD']                             = $period;
      $data['PAYROLL_PAYSLIP_GENERATED_LIST']     = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
      $data['GENERATED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
      $data['PAYROLL_PAYSLIP_PUBLISHED_LIST']     = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
      $data['PUBLISHED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
      $generated_sum_net_income                   = 0;
      $published_sum_net_income                   = 0;
      foreach ($payslip_generated_list as $generated_list) {
        $generated_sum_net_income += $generated_list->NET_INCOME;
      }
      foreach ($payslip_published_list as $published_list) {
        $published_sum_net_income += $published_list->NET_INCOME;
      }
      $pasyslip_list                              = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
      $attendance_record_lock                     = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
      $employees_type                             = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
      $employees_positions                        = $this->payrolls_model->GET_ALL_POSITION();
      $employees                                  = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
      foreach ($employees as $employee) {
        foreach ($employees_type as $type) {
          if ($employee->col_empl_type == $type->id) {
            $employee->col_empl_type = $type->name;
          }
        }
        foreach ($employees_positions as $position) {
          if ($employee->col_empl_posi == $position->id) {
            $employee->col_empl_posi = $position->name;
          }
        }
      }
      $pasyslipEmplIds = array_map(function ($item) {
        if ($item->status == "Generated" || $item->status == "Published") {
          return $item->empl_id;
        }
      }, $pasyslip_list);
      $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
        return !in_array($employee->id, $pasyslipEmplIds);
      });
      $attendanceRecordLockIds = array_map(function ($item) {
        return $item->empl_id;
      }, $attendance_record_lock);
      $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
        return !in_array($employee->id, $attendanceRecordLockIds);
      });
      $attendanceRecordLockFilteredIds = array_map(function ($item) {
        return $item->id;
      }, $attendanceRecordLockFiltered);
      $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
        return !in_array($employee->id, $attendanceRecordLockFilteredIds);
      });
      $data['DISP_GENERATED_SUM_NET_INCOME']      = $generated_sum_net_income;
      $data['DISP_PUBLISHED_SUM_NET_INCOME']      = $published_sum_net_income;
      $data['DISP_EMP_LIST']                      = $filteredEmployees2;
      $data['DISP_EMP_LIST_COUNT']                = count($filteredEmployees2);
      $data['DISP_PENDING']                       = $attendanceRecordLockFiltered;
      $data['DISP_PENDING_COUNT']                 = count($attendanceRecordLockFiltered);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_summary_status_views', $data);
    }

    function pending()
    {
      $period                                     = $this->input->get('period');
      $status                                     = $this->input->get('status');
      $tab                                        = $this->input->get('tab');
      $data['CUTOFF_PERIODS']                     = $cuttoff_periods = $this->payrolls_model->GET_CUTOFF_LIST();
      $payroll_list                               = $this->payrolls_model->GET_PERIOD_LIST_LOCK();

      if ($period == null && !empty($payroll_list)) {
        $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

        if($result){
          $period = $payroll_list[0]->period;  
        }else{
          $period = $cuttoff_periods[0]->id;
        }
      } elseif ($period == null && empty($payroll_list)){
        $period = $cuttoff_periods[0]->id;
      }

      if ($tab == null || $tab == '') {
        $tab = 'pending';
      }
      $data['TAB']                                = $tab;
      $data['PERIOD']                             = $period;
      $data['PAYROLL_PAYSLIP_GENERATED_LIST']     = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
      $data['GENERATED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
      $data['PAYROLL_PAYSLIP_PUBLISHED_LIST']     = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
      $data['PUBLISHED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
      $generated_sum_net_income                   = 0;
      $published_sum_net_income                   = 0;
      foreach ($payslip_generated_list as $generated_list) {
        $generated_sum_net_income += $generated_list->NET_INCOME;
      }
      foreach ($payslip_published_list as $published_list) {
        $published_sum_net_income += $published_list->NET_INCOME;
      }
      $pasyslip_list                              = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
      $attendance_record_lock                     = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
      $employees_type                             = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
      $employees_positions                        = $this->payrolls_model->GET_ALL_POSITION();
      $employees                                  = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
      foreach ($employees as $employee) {
        foreach ($employees_type as $type) {
          if ($employee->col_empl_type == $type->id) {
            $employee->col_empl_type = $type->name;
          }
        }
        foreach ($employees_positions as $position) {
          if ($employee->col_empl_posi == $position->id) {
            $employee->col_empl_posi = $position->name;
          }
        }
      }
      $pasyslipEmplIds = array_map(function ($item) {
        if ($item->status == "Generated" || $item->status == "Published") {
          return $item->empl_id;
        }
      }, $pasyslip_list);
      $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
        return !in_array($employee->id, $pasyslipEmplIds);
      });
      $attendanceRecordLockIds = array_map(function ($item) {
        return $item->empl_id;
      }, $attendance_record_lock);
      $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
        return !in_array($employee->id, $attendanceRecordLockIds);
      });
      $attendanceRecordLockFilteredIds = array_map(function ($item) {
        return $item->id;
      }, $attendanceRecordLockFiltered);
      $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
        return !in_array($employee->id, $attendanceRecordLockFilteredIds);
      });
      $data['DISP_GENERATED_SUM_NET_INCOME']      = $generated_sum_net_income;
      $data['DISP_PUBLISHED_SUM_NET_INCOME']      = $published_sum_net_income;
      $data['DISP_EMP_LIST']                      = $filteredEmployees2;
      $data['DISP_EMP_LIST_COUNT']                = count($filteredEmployees2);
      $data['DISP_PENDING']                       = $attendanceRecordLockFiltered;
      $data['DISP_PENDING_COUNT']                 = count($attendanceRecordLockFiltered);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_pending_views', $data);
    }

    function ready()
    {
      $period                                     = $this->input->get('period');
      $status                                     = $this->input->get('status');
      $tab                                        = $this->input->get('tab');
      $data['CUTOFF_PERIODS']                     = $cuttoff_periods = $this->payrolls_model->GET_CUTOFF_LIST();
      $payroll_list                               = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      
      if ($period == null && !empty($payroll_list)) {
        $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

        if($result){
          $period = $payroll_list[0]->period;  
        }else{
          $period = $cuttoff_periods[0]->id;
        }
      } elseif ($period == null && empty($payroll_list)){
        $period = $cuttoff_periods[0]->id;
      }
      
      if ($tab == null || $tab == '') {
        $tab = 'ready';
      }
      $data['TAB']                                = $tab;
      $data['PERIOD']                             = $period;
      $data['PAYROLL_PAYSLIP_GENERATED_LIST']     = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
      $data['GENERATED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
      $data['PAYROLL_PAYSLIP_PUBLISHED_LIST']     = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
      $data['PUBLISHED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
      $generated_sum_net_income                   = 0;
      $published_sum_net_income                   = 0;
      foreach ($payslip_generated_list as $generated_list) {
        $generated_sum_net_income += $generated_list->NET_INCOME;
      }
      foreach ($payslip_published_list as $published_list) {
        $published_sum_net_income += $published_list->NET_INCOME;
      }
      $pasyslip_list                              = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
      $attendance_record_lock                     = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
      $employees_type                             = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
      $employees_positions                        = $this->payrolls_model->GET_ALL_POSITION();
      $employees                                  = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
      foreach ($employees as $employee) {
        foreach ($employees_type as $type) {
          if ($employee->col_empl_type == $type->id) {
            $employee->col_empl_type = $type->name;
          }
        }
        foreach ($employees_positions as $position) {
          if ($employee->col_empl_posi == $position->id) {
            $employee->col_empl_posi = $position->name;
          }
        }
      }
      $pasyslipEmplIds = array_map(function ($item) {
        if ($item->status == "Generated" || $item->status == "Published") {
          return $item->empl_id;
        }
      }, $pasyslip_list);
      $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
        return !in_array($employee->id, $pasyslipEmplIds);
      });
      $attendanceRecordLockIds = array_map(function ($item) {
        return $item->empl_id;
      }, $attendance_record_lock);
      $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
        return !in_array($employee->id, $attendanceRecordLockIds);
      });
      $attendanceRecordLockFilteredIds = array_map(function ($item) {
        return $item->id;
      }, $attendanceRecordLockFiltered);
      $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
        return !in_array($employee->id, $attendanceRecordLockFilteredIds);
      });
      $data['DISP_GENERATED_SUM_NET_INCOME']      = $generated_sum_net_income;
      $data['DISP_PUBLISHED_SUM_NET_INCOME']      = $published_sum_net_income;
      $data['DISP_EMP_LIST']                      = $filteredEmployees2;
      $data['DISP_EMP_LIST_COUNT']                = count($filteredEmployees2);
      $data['DISP_PENDING']                       = $attendanceRecordLockFiltered;
      $data['DISP_PENDING_COUNT']                 = count($attendanceRecordLockFiltered);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_ready_views', $data);
    }

    function generated()
    {
      $period                                     = $this->input->get('period');
      $status                                     = $this->input->get('status');
      $tab                                        = $this->input->get('tab');
      $data['CUTOFF_PERIODS']                     = $cuttoff_periods = $this->payrolls_model->GET_CUTOFF_LIST();
      $payroll_list                               = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      if ($period == null && !empty($payroll_list)) {
        $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

        if($result){
          $period = $payroll_list[0]->period;  
        }else{
          $period = $cuttoff_periods[0]->id;
        }
      } elseif ($period == null && empty($payroll_list)){
        $period = $cuttoff_periods[0]->id;
      }
      if ($tab == null || $tab == '') {
        $tab = 'generated';
      }
      $data['TAB']                                = $tab;
      $data['PERIOD']                             = $period;
      $data['PAYROLL_PAYSLIP_GENERATED_LIST']     = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);

      $negative_data_count = 0;
      foreach ($payslip_generated_list as $list) {
        if ($list->NET_INCOME < 0) {
          $negative_data_count++;
        }
      }

      $data['PAYROLL_PAYSLIP_GENERATED_LIST_NEGATIVE_COUNT']     = $negative_data_count;
      $data['GENERATED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
      $data['PAYROLL_PAYSLIP_PUBLISHED_LIST']     = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
      $data['PUBLISHED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
      $generated_sum_net_income                   = 0;
      $published_sum_net_income                   = 0;
      foreach ($payslip_generated_list as $generated_list) {
        $generated_sum_net_income += $generated_list->NET_INCOME;
      }
      foreach ($payslip_published_list as $published_list) {
        $published_sum_net_income += $published_list->NET_INCOME;
      }
      $pasyslip_list                              = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
      $attendance_record_lock                     = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
      $employees_type                             = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
      $employees_positions                        = $this->payrolls_model->GET_ALL_POSITION();
      $employees                                  = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
      foreach ($employees as $employee) {
        foreach ($employees_type as $type) {
          if ($employee->col_empl_type == $type->id) {
            $employee->col_empl_type = $type->name;
          }
        }
        foreach ($employees_positions as $position) {
          if ($employee->col_empl_posi == $position->id) {
            $employee->col_empl_posi = $position->name;
          }
        }
      }
      $pasyslipEmplIds = array_map(function ($item) {
        if ($item->status == "Generated" || $item->status == "Published") {
          return $item->empl_id;
        }
      }, $pasyslip_list);
      $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
        return !in_array($employee->id, $pasyslipEmplIds);
      });
      $attendanceRecordLockIds = array_map(function ($item) {
        return $item->empl_id;
      }, $attendance_record_lock);
      $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
        return !in_array($employee->id, $attendanceRecordLockIds);
      });
      $attendanceRecordLockFilteredIds = array_map(function ($item) {
        return $item->id;
      }, $attendanceRecordLockFiltered);
      $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
        return !in_array($employee->id, $attendanceRecordLockFilteredIds);
      });
      $data['DISP_GENERATED_SUM_NET_INCOME']      = $generated_sum_net_income;
      $data['DISP_PUBLISHED_SUM_NET_INCOME']      = $published_sum_net_income;
      $data['DISP_EMP_LIST']                      = $filteredEmployees2;
      $data['DISP_EMP_LIST_COUNT']                = count($filteredEmployees2);
      $data['DISP_PENDING']                       = $attendanceRecordLockFiltered;
      $data['DISP_PENDING_COUNT']                 = count($attendanceRecordLockFiltered);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_generated_views', $data);
    }

    function published()
    {
      $period                                     = $this->input->get('period');
      $status                                     = $this->input->get('status');
      $tab                                        = $this->input->get('tab');
      $data['CUTOFF_PERIODS']                     = $this->payrolls_model->GET_CUTOFF_LIST();
      $payroll_list                               = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      if ($period == null && !empty($payroll_list)) {
        $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

        if($result){
          $period = $payroll_list[0]->period;  
        }else{
          $period = $cuttoff_periods[0]->id;
        }
      } elseif ($period == null && empty($payroll_list)){
        $period = $cuttoff_periods[0]->id;
      }
      if ($tab == null || $tab == '') {
        $tab = 'published';
      }
      $data['TAB']                                = $tab;
      $data['PERIOD']                             = $period;
      $data['PAYROLL_PAYSLIP_GENERATED_LIST']     = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
      $data['GENERATED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
      $data['PAYROLL_PAYSLIP_PUBLISHED_LIST']     = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);

      $negative_data_count = 0;
      foreach ($payslip_published_list as $list) {
        if ($list->NET_INCOME < 0) {
          $negative_data_count++;
        }
      }
      $data['PAYROLL_PAYSLIP_PUBLISHED_LIST_NEGATIVE_COUNT']     = $negative_data_count;

      $data['PUBLISHED_LIST_COUNT']               = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
      $generated_sum_net_income                   = 0;
      $published_sum_net_income                   = 0;
      foreach ($payslip_generated_list as $generated_list) {
        $generated_sum_net_income += $generated_list->NET_INCOME;
      }
      foreach ($payslip_published_list as $published_list) {
        $published_sum_net_income += $published_list->NET_INCOME;
      }
      $pasyslip_list                              = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
      $attendance_record_lock                     = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
      $employees_type                             = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
      $employees_positions                        = $this->payrolls_model->GET_ALL_POSITION();
      $employees                                  = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
      foreach ($employees as $employee) {
        foreach ($employees_type as $type) {
          if ($employee->col_empl_type == $type->id) {
            $employee->col_empl_type = $type->name;
          }
        }
        foreach ($employees_positions as $position) {
          if ($employee->col_empl_posi == $position->id) {
            $employee->col_empl_posi = $position->name;
          }
        }
      }
      $pasyslipEmplIds = array_map(function ($item) {
        if ($item->status == "Generated" || $item->status == "Published") {
          return $item->empl_id;
        }
      }, $pasyslip_list);
      $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
        return !in_array($employee->id, $pasyslipEmplIds);
      });
      $attendanceRecordLockIds = array_map(function ($item) {
        return $item->empl_id;
      }, $attendance_record_lock);
      $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
        return !in_array($employee->id, $attendanceRecordLockIds);
      });
      $attendanceRecordLockFilteredIds = array_map(function ($item) {
        return $item->id;
      }, $attendanceRecordLockFiltered);
      $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
        return !in_array($employee->id, $attendanceRecordLockFilteredIds);
      });
      $data['DISP_GENERATED_SUM_NET_INCOME']      = $generated_sum_net_income;
      $data['DISP_PUBLISHED_SUM_NET_INCOME']      = $published_sum_net_income;
      $data['DISP_EMP_LIST']                      = $filteredEmployees2;
      $data['DISP_EMP_LIST_COUNT']                = count($filteredEmployees2);
      $data['DISP_PENDING']                       = $attendanceRecordLockFiltered;
      $data['DISP_PENDING_COUNT']                 = count($attendanceRecordLockFiltered);

      $navbar_val                                 = $this->payrolls_model->get_value_navbar();

      $data['EMPL_ID_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_id_x');
      $data['EMPL_ID_Y']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_id_y');
      $data['EMPL_NAME_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_name_x');
      $data['EMPL_NAME_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_name_y');
      $data['DESIGNATION_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('designation_x');
      $data['DESIGNATION_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('designation_y');
      $data['PERIOD_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payroll_period_x');
      $data['PERIOD_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payroll_period_y');
      $data['PAYOUT_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payout_date_x');
      $data['PAYOUT_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payout_date_y');
      $data['BANK_ACCT_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('bank_account_x');
      $data['BANK_ACCT_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('bank_account_y');
      $data['SALARY_TYPE_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('salary_type_x');
      $data['SALARY_TYPE_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('salary_type_y');
      $data['MONTHLY_SALARY_X']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('monthly_salary_x');
      $data['MONTHLY_SALARY_Y']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('monthly_salary_y');
      $data['DAILY_SALARY_X']                 = $this->payrolls_model->GET_PAYSLIP_COORDINATES('daily_salary_x');
      $data['DAILY_SALARY_Y']                 = $this->payrolls_model->GET_PAYSLIP_COORDINATES('daily_salary_y');
      $data['HDMF_NO_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_no_x');
      $data['HDMF_NO_Y']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_no_y');
      $data['PHILHEALTH_NO_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_no_x');
      $data['PHILHEALTH_NO_Y']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_no_y');
      $data['TIN_NO_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tin_no_x');
      $data['TIN_NO_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tin_no_y');
      $data['SSS_NO_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_no_x');
      $data['SSS_NO_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_no_y');
      $data['WTAX_X']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_x');
      $data['WTAX_Y']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_y');
      $data['SSS_X']                          = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_x');
      $data['SSS_Y']                          = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_y');
      $data['PHILHEALTH_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_x');
      $data['PHILHEALTH_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_y');
      $data['HDMF_X']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_x');
      $data['HDMF_Y']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_y');
      $data['REGWRK_HRS_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_hrs_x');
      $data['REGWRK_HRS_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_hrs_y');
      $data['REGWRK_AMT_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_amt_x');
      $data['REGWRK_AMT_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_amt_y');
      $data['PDLEAVE_HRS_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_hrs_x');
      $data['PDLEAVE_HRS_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_hrs_y');
      $data['PDLEAVE_AMT_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_amt_x');
      $data['PDLEAVE_AMT_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_amt_y');
      $data['LEGHOL_HRS_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_hrs_x');
      $data['LEGHOL_HRS_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_hrs_y');
      $data['LEGHOL_AMT_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_amt_x');
      $data['LEGHOL_AMT_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_amt_y');
      $data['ABSENT_HRS_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_hrs_x');
      $data['ABSENT_HRS_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_hrs_y');
      $data['ABSENT_AMT_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_amt_x');
      $data['ABSENT_AMT_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_amt_y');
      $data['TARD_HRS_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_hrs_x');
      $data['TARD_HRS_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_hrs_y');
      $data['TARD_AMT_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_amt_x');
      $data['TARD_AMT_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_amt_y');
      $data['UT_HRS_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_hrs_x');
      $data['UT_HRS_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_hrs_y');
      $data['UT_AMT_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_amt_x');
      $data['UT_AMT_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_amt_y');
      $data['UBRK_HRS_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_hrs_x');
      $data['UBRK_HRS_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_hrs_y');
      $data['UBRK_AMT_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_amt_x');
      $data['UBRK_AMT_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_amt_y');
      $data['OBRK_HRS_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_hrs_x');
      $data['OBRK_HRS_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_hrs_y');
      $data['OBRK_AMT_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_amt_x');
      $data['OBRK_AMT_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_amt_y');
      $data['TOTALBP_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('totalbp_x');
      $data['TOTALBP_Y']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('totalbp_y');
      $data['OTPAY_DES_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_des_x');
      $data['OTPAY_HRS_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_hrs_x');
      $data['OTPAY_AMT_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_amt_x');
      $data['OTPAY_Y']                        = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_y');
      $data['NDPAY_DES_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_des_x');
      $data['NDPAY_HRS_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_hrs_x');
      $data['NDPAY_AMT_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_amt_x');
      $data['NDPAY_Y']                        = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_y');
      $data['TOTAL_OTND_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_otnd_x');
      $data['TOTAL_OTND_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_otnd_y');
      $data['GROSS_TAX_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('gross_tax_x');
      $data['GROSS_TAX_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('gross_tax_y');
      $data['EXCLUSION_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('exclusion_x');
      $data['EXCLUSION_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('exclusion_y');
      $data['WTAX_YTD_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_ytd_x');
      $data['WTAX_YTD_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_ytd_y');
      $data['TAXABLE_INCOME_Y']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('taxable_income_y');
      $data['TAX_DESC_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tax_description_x');
      $data['TAX_AMT_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tax_amount_x');
      $data['TOTAL_OTH_TAX_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_tax_x');
      $data['TOTAL_OTH_TAX_Y']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_tax_y');
      $data['NON_TAXABLE_INCOME_Y']           = $this->payrolls_model->GET_PAYSLIP_COORDINATES('non_taxable_income_y');
      $data['NON_TAX_DESC_X']                 = $this->payrolls_model->GET_PAYSLIP_COORDINATES('non_tax_description_x');
      $data['NON_TAX_AMT_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('non_tax_amount_x');
      $data['TOTAL_OTH_NONTAX_X']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_nontax_x');
      $data['TOTAL_OTH_NONTAX_Y']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_nontax_y');
      $data['LOAN_OTHER_DEDUCTIONS_Y']        = $this->payrolls_model->GET_PAYSLIP_COORDINATES('loan_deductions_y');
      $data['OTHER_CODE_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_code_x');
      $data['OTHER_START_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_start_x');
      $data['OTHER_PAYABLE_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_payable_x');
      $data['OTHER_DEDUCTED_X']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_deducted_x');
      $data['OTHER_BAL_AMT_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_bal_amt_x');
      $data['LEAVE_VAC_USED_X']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_vac_used_x');
      $data['LEAVE_VAC_y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_vac_y');
      $data['LEAVE_VAC_BAL_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_vac_bal_x');
      $data['LEAVE_SICK_USED_X']              = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_sick_used_x');
      $data['LEAVE_SICK_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_sick_y');
      $data['LEAVE_SICK_BAL_x']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_sick_bal_x');
      $data['TOTAL_GROSS_PAY_X']              = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_gross_pay_x');
      $data['TOTAL_GROSS_PAY_Y']              = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_gross_pay_y');
      $data['TOTAL_DEDUCTIONS_X']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_deductions_x');
      $data['TOTAL_DEDUCTIONS_Y']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_deductions_y');
      $data['TOTAL_NET_PAY_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_net_pay_x');
      $data['TOTAL_NET_PAY_Y']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_net_pay_y');

      if (file_exists(FCPATH . 'assets_system/images/' . $navbar_val)) {
        $data['DISP_NAV'] = $navbar_val;
      } else if (file_exists(FCPATH . 'assets_system/images/default_logo.png')) {
        $data['DISP_NAV'] = 'default_logo.png';
      } else {
        $data['DISP_NAV'] = null;
      }

      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_published_views', $data);
    }

    function delete_generated_payslip()
    {
      $other_deduction_ids  = $this->input->post('otherDeduction');
      $ids                  = $this->input->post('ids');
      $userId               = $this->input->post('userId');
      $cutoffPeriod         = $this->input->post('cutoffPeriod');
      $empl_id              = $this->input->post('empl_id');


      if (!empty($userId)) {

        if(!empty($ids) ){
          $payslip_ids = json_decode($ids[0], true);

          foreach ($payslip_ids as $id) {
            $this->delete_payroll_payslip_loan_id($id);
          }
        }

        if(!empty($other_deduction_ids)){
          $deduction_ids = json_decode($other_deduction_ids[0], true);

          foreach($deduction_ids as $id){
            $this->delete_payroll_payslip_deduction_id($id);
          }
        }

        $this->delete_payslip_by_id($userId);
        $this->payrolls_model->delete_attendance_lock($empl_id, $cutoffPeriod);
        $response = array('success_message' => 'Payslips deleted successfully');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted payslip');
      } else {
        $response = array('fail_message' => 'Failed to delete!');
      }
      echo json_encode($response);
    }

    function delete_payroll_payslip_loan_id($id)
    {
      $sql = "DELETE FROM tbl_payroll_payslip_loan WHERE id=?";
      $this->db->query($sql, array($id));
    }

    function delete_payroll_payslip_deduction_id($id){
      $sql = "DELETE FROM tbl_payroll_payslip_otherdeductions WHERE id=?";
      $this->db->query($sql, array($id));
    }

    function delete_payslip_by_id($id)
    {
      $sql = "DELETE FROM tbl_payroll_payslips WHERE id=?";
      $this->db->query($sql, array($id));
    }
    function published_view_details()
    {
      $period                                   = $this->input->get('period');
      $published_payslip                        = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
      $data['CUTOFF_PERIODS']                   = $this->payrolls_model->GET_CUTOFF_LIST();
      $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
      // $period                                   = $this->input->get('period');
      $page                                     = $this->input->get('page');
      $row                                      = $this->input->get('row');
      $tab                                      = $this->input->get('tab');
      if (isset($tab)) {
        $data['TAB']  = $tab;
      } else {
        $data['TAB']  = 'published';
      }
      if ($row == null) {
        $row = 25;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $payroll_list                           = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      // if ($period == null && !empty($payroll_list)) {
      //   $period = $payroll_list[0]->period;
      // }
      $specific_payroll_sched = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($period);
      ($specific_payroll_sched->chk_sss == null || $specific_payroll_sched->chk_sss == 1) ? $en_sss = 1 : $en_sss = 0;
      ($specific_payroll_sched->chk_philhealth == null || $specific_payroll_sched->chk_philhealth == 1) ? $en_phil = 1 : $en_phil = 0;
      ($specific_payroll_sched->chk_pagibig == null || $specific_payroll_sched->chk_pagibig == 1) ? $en_pagibig = 1 : $en_pagibig = 0;
      ($specific_payroll_sched->chk_withholding == null || $specific_payroll_sched->chk_withholding == 1) ? $en_wtax = 1 : $en_wtax = 0;
      // ($specific_payroll_sched->chk_taxable == null || $specific_payroll_sched->chk_taxable == 1) ? $en_ti = 1 : $en_ti = 0; 
      // ($specific_payroll_sched->chk_nontaxable == null || $specific_payroll_sched->chk_nontaxable == 1) ? $en_nti = 1 : $en_nti = 0; 
      ($specific_payroll_sched->chk_loans == null || $specific_payroll_sched->chk_loans == 1) ? $en_loan = 1 : $en_loan = 0;
      ($specific_payroll_sched->chk_tardiness == null || $specific_payroll_sched->chk_tardiness == 1) ? $en_absut = 1 : $en_absut = 0;
      $employees = $this->payrolls_model->GET_GENERATED_EMPLOYEELIST();
      $matchedEmployees = array();
      foreach ($published_payslip as $published) {
        $emplId = $published->empl_id;
        foreach ($employees as $employee) {
          if ($employee->id == $emplId) {
            $matchedEmployees[] = $employee;
            break;
          }
        }
      }

      // $data['C_DATA_COUNT']                     = $this->payrolls_model->GET_EMPLOYEELIST_COUNT();
      
      $data['C_DATA_COUNT']                     = count($matchedEmployees);
      $data['PERIOD']                           = $period;
      $data['SPECIFIC_PAYROLL_SCHEDULES']       = $specific_payroll_sched;

      $data['PAYROLL_PAYSLIPS']                 = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIP($period ,'Published');
      $data['PAYROLL_SCHEDULES']                = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payslip_published_detail_views', $data);
    }

    function view_details()
    {
      $period                                   = $this->input->get('period');
      $generated_payslip                        = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
      $data['CUTOFF_PERIODS']                   = $this->payrolls_model->GET_CUTOFF_LIST();
      $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
      $page                                     = $this->input->get('page');
      $row                                      = $this->input->get('row');
      $tab                                      = $this->input->get('tab');
      if (isset($tab)) {
        $data['TAB']  = $tab;
      } else {
        $data['TAB']  = 'pending';
      }
      if ($row == null) {
        $row = 25;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $payroll_list                           = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      // if ($period == null && !empty($payroll_list)) {
      //   $period = $payroll_list[0]->period;
      // }
      $specific_payroll_sched = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($period);
      ($specific_payroll_sched->chk_sss == null || $specific_payroll_sched->chk_sss == 1) ? $en_sss = 1 : $en_sss = 0;
      ($specific_payroll_sched->chk_philhealth == null || $specific_payroll_sched->chk_philhealth == 1) ? $en_phil = 1 : $en_phil = 0;
      ($specific_payroll_sched->chk_pagibig == null || $specific_payroll_sched->chk_pagibig == 1) ? $en_pagibig = 1 : $en_pagibig = 0;
      ($specific_payroll_sched->chk_withholding == null || $specific_payroll_sched->chk_withholding == 1) ? $en_wtax = 1 : $en_wtax = 0;
      // ($specific_payroll_sched->chk_taxable == null || $specific_payroll_sched->chk_taxable == 1) ? $en_ti = 1 : $en_ti = 0; 
      // ($specific_payroll_sched->chk_nontaxable == null || $specific_payroll_sched->chk_nontaxable == 1) ? $en_nti = 1 : $en_nti = 0; 
      ($specific_payroll_sched->chk_loans == null || $specific_payroll_sched->chk_loans == 1) ? $en_loan = 1 : $en_loan = 0;
      ($specific_payroll_sched->chk_tardiness == null || $specific_payroll_sched->chk_tardiness == 1) ? $en_absut = 1 : $en_absut = 0;
      $employees = $this->payrolls_model->GET_GENERATED_EMPLOYEELIST();
      $matchedEmployees = array();
      foreach ($generated_payslip as $generated) {
        $emplId = $generated->empl_id;
        foreach ($employees as $employee) {
          if ($employee->id == $emplId) {
            $matchedEmployees[] = $employee;
            break;
          }
        }
      }

      // $data['C_DATA_COUNT']                           = $this->payrolls_model->GET_EMPLOYEELIST_COUNT();
      $data['C_DATA_COUNT']                             = count($matchedEmployees);
      $data['PERIOD']                                   = $period;
      $data['SPECIFIC_PAYROLL_SCHEDULES']               = $specific_payroll_sched;
      $data['PAYROLL_PAYSLIPS']                         = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIP($period ,'Generated');
      $data['PAYROLL_SCHEDULES']                        = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payslip_generate_detail_views', $data);
    }

    function edit_payslip_generated()
    {
      $SSS_EE_TOTAL                 = $this->input->post('SSS_EE_TOTAL');
      $PAGIBIG_EE_TOTAL             = $this->input->post('PAGIBIG_EE_TOTAL');
      $PHILHEALTH_EE_TOTAL          = $this->input->post('PHILHEALTH_EE_TOTAL');
      $TAX_ALLOWANCE_EMPL_ID        = $this->input->post('TAX_ALLOWANCE_EMPL_ID');
      $TAX_ALLOWANCE_NAME           = $this->input->post('TAX_ALLOWANCE_NAME');
      $TAX_ALLOWANCE_VAL            = str_replace(',', '', $this->input->post('TAX_ALLOWANCE_VAL'));
      for ($i = 0; $i < count($TAX_ALLOWANCE_EMPL_ID); $i++) {
        $EMPL_ID = $TAX_ALLOWANCE_EMPL_ID[$i];
        $NAME = $TAX_ALLOWANCE_NAME[$i];
        $VAL = $TAX_ALLOWANCE_VAL[$i];
        $this->payrolls_model->edit_allowance_assign_tax($EMPL_ID, $NAME, $VAL);
      }
      $NONTAX_ALLOWANCE_EMPL_ID        = $this->input->post('NONTAX_ALLOWANCE_EMPL_ID');
      $NONTAX_ALLOWANCE_NAME           = $this->input->post('NONTAX_ALLOWANCE_NAME');
      $NONTAX_ALLOWANCE_VAL            = str_replace(',', '', $this->input->post('NONTAX_ALLOWANCE_VAL'));
      for ($i = 0; $i < count($NONTAX_ALLOWANCE_EMPL_ID); $i++) {
        $EMPL_ID = $NONTAX_ALLOWANCE_EMPL_ID[$i];
        $NAME = $NONTAX_ALLOWANCE_NAME[$i];
        $VAL = $NONTAX_ALLOWANCE_VAL[$i];
        $this->payrolls_model->edit_allowance_assign_nontax($EMPL_ID, $NAME, $VAL);
      }
      $this->SSS_EE_TOTAL_DATA = $SSS_EE_TOTAL;
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Edited payslip');
      redirect($_SERVER['HTTP_REFERER']);
    }
    function generated_payslip($empl_id, $period)
    {
      // $period                                   = $this->input->get('period'); 
      $payroll_list                             = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      if ($period == null && !empty($payroll_list)) {
        $period = $payroll_list[0]->period;
      }
      $data['PAYROLL_CONTRIBUTION'] = $specific_payroll_sched = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($period);
      ($specific_payroll_sched->chk_sss == null || $specific_payroll_sched->chk_sss == 1) ? $en_sss = 1 : $en_sss = 0;
      ($specific_payroll_sched->chk_philhealth == null || $specific_payroll_sched->chk_philhealth == 1) ? $en_phil = 1 : $en_phil = 0;
      ($specific_payroll_sched->chk_pagibig == null || $specific_payroll_sched->chk_pagibig == 1) ? $en_pagibig = 1 : $en_pagibig = 0;
      ($specific_payroll_sched->chk_withholding == null || $specific_payroll_sched->chk_withholding == 1) ? $en_wtax = 1 : $en_wtax = 0;
      ($specific_payroll_sched->chk_taxable == null || $specific_payroll_sched->chk_taxable == 1) ? $en_ti = 1 : $en_ti = 0;
      ($specific_payroll_sched->chk_nontaxable == null || $specific_payroll_sched->chk_nontaxable == 1) ? $en_nti = 1 : $en_nti = 0;
      ($specific_payroll_sched->chk_loans == null || $specific_payroll_sched->chk_loans == 1) ? $en_loan = 1 : $en_loan = 0;
      ($specific_payroll_sched->chk_tardiness == null || $specific_payroll_sched->chk_tardiness == 1) ? $en_absut = 1 : $en_absut = 0;
      $data['DISP_EMPLOYEE']                   = $employee = $this->payrolls_model->GET_SPECIFIC_EMPLOYEE_DATA($empl_id);
      //---------------------------- INITIAL DECLARATION --
      $sss_ee_prev_1 = 0;
      $pagibig_ee_prev_1 = 0;
      $philhealth_ee_prev_1 = 0;
      $sss_er_prev_1 = 0;
      $sss_ec_er_prev_1 = 0;
      $pagibig_er_prev_1 = 0;
      $philhealth_er_prev_1 = 0;
      $sss_ee_prev_2 = 0;
      $pagibig_ee_prev_2 = 0;
      $philhealth_ee_prev_2 = 0;
      $sss_er_prev_2 = 0;
      $sss_ec_er_prev_2 = 0;
      $pagibig_er_prev_2 = 0;
      $philhealth_er_prev_2 = 0;
      $sss_ee_prev_3 = 0;
      $pagibig_ee_prev_3 = 0;
      $philhealth_ee_prev_3 = 0;
      $sss_er_prev_3 = 0;
      $sss_ec_er_prev_3 = 0;
      $pagibig_er_prev_3 = 0;
      $philhealth_er_prev_3 = 0;
      $sss_ee_prev_4 = 0;
      $pagibig_ee_prev_4 = 0;
      $philhealth_ee_prev_4 = 0;
      $sss_er_prev_4 = 0;
      $sss_ec_er_prev_4 = 0;
      $pagibig_er_prev_4 = 0;
      $philhealth_er_prev_4 = 0;
      $sss_ee_prev_5 = 0;
      $pagibig_ee_prev_5 = 0;
      $philhealth_ee_prev_5 = 0;
      $sss_er_prev_5 = 0;
      $sss_ec_er_prev_5 = 0;
      $pagibig_er_prev_5 = 0;
      $philhealth_er_prev_5 = 0;
      // $data['PAYROLL_CONTRIBUTION']           = $this->payrolls_model->GET_PAYROLL_SCHEDULE_CONTRIBUTION($period);
      //---------------------------- CONNECTED PAYROLLS ---------------------------------------------
      $period_connected                       = $this->payrolls_model->GET_PERIOD_CONNECTED($period);
      $connected_1 = 0;
      $connected_2 = 0;
      $connected_3 = 0;
      $connected_4 = 0;
      $connected_5 = 0;
      if (count($period_connected) > 0) {
        $connected_1 = $period_connected[0]->connected_period;
        $connected_2 = $period_connected[0]->connected_period_2;
        $connected_3 = $period_connected[0]->connected_period_3;
        $connected_4 = $period_connected[0]->connected_period_4;
        $connected_5 = $period_connected[0]->connected_period_5;
      }
      if ($connected_1 != "0") {
        $connected_1_name = $this->payrolls_model->GET_PERIOD_NAME($connected_1);
      } else {
        $connected_1_name = "";
      }
      if ($connected_2 != "0") {
        $connected_2_name = $this->payrolls_model->GET_PERIOD_NAME($connected_2);
      } else {
        $connected_2_name = "";
      }
      if ($connected_3 != "0") {
        $connected_3_name = $this->payrolls_model->GET_PERIOD_NAME($connected_3);
      } else {
        $connected_3_name = "";
      }
      if ($connected_4 != "0") {
        $connected_4_name = $this->payrolls_model->GET_PERIOD_NAME($connected_4);
      } else {
        $connected_4_name = "";
      }
      if ($connected_5 != "0") {
        $connected_5_name = $this->payrolls_model->GET_PERIOD_NAME($connected_5);
      } else {
        $connected_5_name = "";
      }
      $employee_specific                  = $this->payrolls_model->GET_EMPLOYEE_INFO_SPECIFIC($empl_id);
      $ID_SSS                             = isset($employee_specific[0]->col_empl_sssc) ? $employee_specific[0]->col_empl_sssc : 0;
      $ID_PAGIBIG                         = isset($employee_specific[0]->col_empl_hdmf) ? $employee_specific[0]->col_empl_hdmf : 0;
      $ID_PHILHEALTH                      = isset($employee_specific[0]->col_empl_phil) ? $employee_specific[0]->col_empl_phil : 0;
      $ID_TIN                             = isset($employee_specific[0]->col_empl_btin) ? $employee_specific[0]->col_empl_btin : 0;
      $loan_user_all                      = $this->payrolls_model->GET_PAYROLL_LOAN_DATA_EMPL($empl_id);
      // $ca_user_all                        = $this->payrolls_model->GET_PAYROLL_CA_DATA_EMPL($empl_id);
      // $deduct_user_all                    = $this->payrolls_model->GET_PAYROLL_DEDUCT_DATA_EMPL($empl_id);
      $loan_total                         = 0;
      $ca_total                           = 0;
      $deduct_total                       = 0;
      if (!empty($loan_user_all)) {
        foreach ($loan_user_all as $loan_user_all_row) {
          $loan_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_LOAN_ID($loan_user_all_row->id);
          $loan_contrib                   = (float)$loan_user_all_row->loan_amount / $loan_user_all_row->loan_terms;
          $loan_user_all_row->contrib     = number_format($loan_contrib, 2);
          $loan_total                     = $loan_total + $loan_contrib;
        }
      }
      // if(!empty($ca_user_all)){
      //   foreach ($ca_user_all as $ca_user_all_row) {
      //     $ca_user_all_row->paid_count    = $this->payrolls_model->GET_COUNT_CA_ID($ca_user_all_row->id);
      //     $ca_contrib                     = 0;
      //     $ca_user_all_row->contrib       = number_format($ca_contrib,2);
      //     $ca_total                       = $ca_total + $ca_contrib;
      //   }
      // }
      // if(!empty($deduct_user_all)){
      //   foreach ($deduct_user_all as $deduct_user_all_row) {
      //     $deduct_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_DEDUCT_ID($deduct_user_all_row->id);
      //     $deduct_contrib                   = 0;
      //     $deduct_user_all_row->contrib     = number_format($deduct_contrib,2);
      //     $deduct_total                     = $deduct_total + $deduct_contrib;
      //   }
      // }
      if ($en_loan == 0) {
        $loan_total = 0;
      }
      $loancadeduct_total                   = $loan_total + $ca_total + $deduct_total;
      $data['DISP_LOAN']                    = $loan_user_all;
      $data['DISP_CA']                      = ""; /*$ca_user_all;*/
      $data['DISP_DEDUCT']                  = ""; /*$deduct_user_all;*/
      $string_loan = str_replace('"', '@', json_encode($loan_user_all));
      $string_ca = ""; /*str_replace('"', '@', json_encode($ca_user_all));*/
      $string_deduct = ""; /*str_replace('"', '@', json_encode($deduct_user_all));*/
      $data['DISP_LOAN_STRING']             = $string_loan;
      $data['DISP_CA_STRING']               = $string_ca;
      $data['DISP_DEDUCT_STRING']           =  $string_deduct;
      $data['DISP_LOANCADED_TOTAL']         = number_format($loancadeduct_total, 2);
      if ($connected_1 == 0) {
        $gross_income_prev_1 = 0;
      } else {
        $connected_data_previous_1          = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_1);
        if (empty($connected_data_previous_1)) {
          $gross_income_prev_1  = 0;
          $sss_ee_prev_1        = 0;
          $pagibig_ee_prev_1    = 0;
          $philhealth_ee_prev_1 = 0;
          $sss_er_prev_1        = 0;
          $sss_ec_er_prev_1     = 0;
          $pagibig_er_prev_1    = 0;
          $philhealth_er_prev_1 = 0;
        } else {
          $gross_income_prev_1    = isset($connected_data_previous_1->GROSS_INCOME)             ? $connected_data_previous_1->GROSS_INCOME : 0;
          $sss_ee_prev_1          = isset($connected_data_previous_1->SSS_EE_CURRENT)           ? $connected_data_previous_1->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_1      = isset($connected_data_previous_1->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_1->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_1   = isset($connected_data_previous_1->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_1->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_1          = isset($connected_data_previous_1->SSS_ER_CURRENT)        ? $connected_data_previous_1->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_1       = isset($connected_data_previous_1->SSS_EC_ER_CURRENT)     ? $connected_data_previous_1->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_1      = isset($connected_data_previous_1->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_1->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_1   = isset($connected_data_previous_1->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_1->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_2 == 0) {
        $gross_income_prev_2 = 0;
      } else {
        $connected_data_previous_2 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_2);
        if (empty($connected_data_previous_2)) {
          $gross_income_prev_2  = 0;
          $sss_ee_prev_2        = 0;
          $pagibig_ee_prev_2    = 0;
          $philhealth_ee_prev_2 = 0;
          $sss_er_prev_2        = 0;
          $sss_ec_er_prev_2     = 0;
          $pagibig_er_prev_2    = 0;
          $philhealth_er_prev_2 = 0;
        } else {
          $gross_income_prev_2    = isset($connected_data_previous_2->GROSS_INCOME)             ? $connected_data_previous_2->GROSS_INCOME : 0;
          $sss_ee_prev_2          = isset($connected_data_previous_2->SSS_EE_CURRENT)           ? $connected_data_previous_2->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_2      = isset($connected_data_previous_2->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_2->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_2   = isset($connected_data_previous_2->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_2->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_2          = isset($connected_data_previous_2->SSS_ER_CURRENT)        ? $connected_data_previous_2->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_2       = isset($connected_data_previous_2->SSS_EC_ER_CURRENT)     ? $connected_data_previous_2->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_2      = isset($connected_data_previous_2->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_2->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_2   = isset($connected_data_previous_2->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_2->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_3 == 0) {
        $gross_income_prev_3 = 0;
      } else {
        $connected_data_previous_3 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_3);
        if (empty($connected_data_previous_3)) {
          $gross_income_prev_3  = 0;
          $sss_ee_prev_3        = 0;
          $pagibig_ee_prev_3    = 0;
          $philhealth_ee_prev_3 = 0;
          $sss_er_prev_3        = 0;
          $sss_ec_er_prev_3     = 0;
          $pagibig_er_prev_3    = 0;
          $philhealth_er_prev_3 = 0;
        } else {
          $gross_income_prev_3    = isset($connected_data_previous_3->GROSS_INCOME)             ? $connected_data_previous_3->GROSS_INCOME : 0;
          $sss_ee_prev_3          = isset($connected_data_previous_3->SSS_EE_CURRENT)           ? $connected_data_previous_3->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_3      = isset($connected_data_previous_3->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_3->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_3   = isset($connected_data_previous_3->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_3->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_3          = isset($connected_data_previous_3->SSS_ER_CURRENT)        ? $connected_data_previous_3->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_3       = isset($connected_data_previous_3->SSS_EC_ER_CURRENT)     ? $connected_data_previous_3->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_3      = isset($connected_data_previous_3->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_3->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_3   = isset($connected_data_previous_3->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_3->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_4 == 0) {
        $gross_income_prev_4 = 0;
      } else {
        $connected_data_previous_4 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_4);
        if (empty($connected_data_previous_4)) {
          $gross_income_prev_4  = 0;
          $sss_ee_prev_4        = 0;
          $pagibig_ee_prev_4    = 0;
          $philhealth_ee_prev_4 = 0;
          $sss_er_prev_4        = 0;
          $sss_ec_er_prev_4     = 0;
          $pagibig_er_prev_4    = 0;
          $philhealth_er_prev_4 = 0;
        } else {
          $gross_income_prev_4    = isset($connected_data_previous_4->GROSS_INCOME)             ? $connected_data_previous_4->GROSS_INCOME : 0;
          $sss_ee_prev_4          = isset($connected_data_previous_4->SSS_EE_CURRENT)           ? $connected_data_previous_4->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_4      = isset($connected_data_previous_4->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_4->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_4   = isset($connected_data_previous_4->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_4->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_4          = isset($connected_data_previous_4->SSS_ER_CURRENT)        ? $connected_data_previous_4->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_4       = isset($connected_data_previous_4->SSS_EC_ER_CURRENT)     ? $connected_data_previous_4->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_4      = isset($connected_data_previous_4->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_4->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_4   = isset($connected_data_previous_4->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_4->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_5 == 0) {
        $gross_income_prev_5 = 0;
      } else {
        $connected_data_previous_5 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_5);
        if (empty($connected_data_previous_5)) {
          $gross_income_prev_5  = 0;
          $sss_ee_prev_5        = 0;
          $pagibig_ee_prev_5    = 0;
          $philhealth_ee_prev_5 = 0;
          $sss_er_prev_5        = 0;
          $sss_ec_er_prev_5     = 0;
          $pagibig_er_prev_5    = 0;
          $philhealth_er_prev_5 = 0;
        } else {
          $gross_income_prev_5    = isset($connected_data_previous_5->GROSS_INCOME)             ? $connected_data_previous_5->GROSS_INCOME : 0;
          $sss_ee_prev_5          = isset($connected_data_previous_5->SSS_EE_CURRENT)           ? $connected_data_previous_5->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_5      = isset($connected_data_previous_5->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_5->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_5   = isset($connected_data_previous_5->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_5->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_5          = isset($connected_data_previous_5->SSS_ER_CURRENT)        ? $connected_data_previous_5->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_5       = isset($connected_data_previous_5->SSS_EC_ER_CURRENT)     ? $connected_data_previous_5->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_5      = isset($connected_data_previous_5->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_5->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_5   = isset($connected_data_previous_5->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_5->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      $DISP_ATTENDANCE_LOCK =  isset(($this->payrolls_model->GET_ATTENDANCE_LOCK($employee->id, $period))[0]) ? ($this->payrolls_model->GET_ATTENDANCE_LOCK($employee->id, $period))[0] : 0;
      $ini_empl_cmid        = !empty($employee_specific) ? $employee_specific[0]->col_empl_cmid : 0;
      $ini_empl_name        = !empty($employee_specific) ? $employee_specific[0]->col_last_name . ', ' . $employee_specific[0]->col_last_name : 0;
      $ini_salary_rate      = !empty($employee_specific) ? $employee_specific[0]->salary_rate : 0;
      $ini_salary_type      = !empty($employee_specific) ? $employee_specific[0]->salary_type : 0;
      if ($ini_salary_type == "Daily") {
        $daily_salary       =  $ini_salary_rate;
        $hourly_salary      = $daily_salary / 8;
      } else {
        $payroll_monthly_cons = $this->payrolls_model->GET_PAYROLL_MONTHLY_CONSTANT();
        $daily_salary       =  $ini_salary_rate * 12 / $payroll_monthly_cons;
        $hourly_salary      = $daily_salary / 8;
      }
      $count_present        = isset($DISP_ATTENDANCE_LOCK->present) ? $DISP_ATTENDANCE_LOCK->present : 0;
      $count_absent         = isset($DISP_ATTENDANCE_LOCK->absent) ? $DISP_ATTENDANCE_LOCK->absent : 0;
      $count_tardiness      = isset($DISP_ATTENDANCE_LOCK->tardiness) ? $DISP_ATTENDANCE_LOCK->tardiness : 0;
      $count_undertime      = isset($DISP_ATTENDANCE_LOCK->undertime) ? $DISP_ATTENDANCE_LOCK->undertime : 0;
      $count_paid_leave     = isset($DISP_ATTENDANCE_LOCK->paid_leave) ? $DISP_ATTENDANCE_LOCK->paid_leave : 0;
      $count_reg_hours      = isset($DISP_ATTENDANCE_LOCK->reg_hours) ? $DISP_ATTENDANCE_LOCK->reg_hours : 0;
      $count_reg_ot         = isset($DISP_ATTENDANCE_LOCK->reg_ot) ? $DISP_ATTENDANCE_LOCK->reg_ot : 0;
      $count_reg_nd         = isset($DISP_ATTENDANCE_LOCK->reg_nd) ? $DISP_ATTENDANCE_LOCK->reg_nd : 0;
      $count_reg_ndot       = isset($DISP_ATTENDANCE_LOCK->reg_ndot) ? $DISP_ATTENDANCE_LOCK->reg_ndot : 0;
      $count_rest_hours     = isset($DISP_ATTENDANCE_LOCK->rest_hours) ? $DISP_ATTENDANCE_LOCK->rest_hours : 0;
      $count_rest_ot        = isset($DISP_ATTENDANCE_LOCK->rest_ot) ? $DISP_ATTENDANCE_LOCK->rest_ot : 0;
      $count_rest_nd        = isset($DISP_ATTENDANCE_LOCK->rest_nd) ? $DISP_ATTENDANCE_LOCK->rest_nd : 0;
      $count_rest_ndot      = isset($DISP_ATTENDANCE_LOCK->rest_ndot) ? $DISP_ATTENDANCE_LOCK->rest_ndot : 0;
      $count_leg_hours      = isset($DISP_ATTENDANCE_LOCK->leg_hours) ? $DISP_ATTENDANCE_LOCK->leg_hours : 0;
      $count_leg_ot         = isset($DISP_ATTENDANCE_LOCK->leg_ot) ? $DISP_ATTENDANCE_LOCK->leg_ot : 0;
      $count_leg_nd         = isset($DISP_ATTENDANCE_LOCK->leg_nd) ? $DISP_ATTENDANCE_LOCK->leg_nd : 0;
      $count_leg_ndot       = isset($DISP_ATTENDANCE_LOCK->leg_ndot) ? $DISP_ATTENDANCE_LOCK->leg_ndot : 0;
      $count_legrest_hours  = isset($DISP_ATTENDANCE_LOCK->legrest_hours) ? $DISP_ATTENDANCE_LOCK->legrest_hours : 0;
      $count_legrest_ot     = isset($DISP_ATTENDANCE_LOCK->legrest_ot) ? $DISP_ATTENDANCE_LOCK->legrest_ot : 0;
      $count_legrest_nd     = isset($DISP_ATTENDANCE_LOCK->legrest_nd) ? $DISP_ATTENDANCE_LOCK->legrest_nd : 0;
      $count_legrest_ndot   = isset($DISP_ATTENDANCE_LOCK->legrest_ndot) ? $DISP_ATTENDANCE_LOCK->legrest_ndot : 0;
      $count_spe_hours      = isset($DISP_ATTENDANCE_LOCK->spe_hours) ? $DISP_ATTENDANCE_LOCK->spe_hours : 0;
      $count_spe_ot         = isset($DISP_ATTENDANCE_LOCK->spe_ot) ? $DISP_ATTENDANCE_LOCK->spe_ot : 0;
      $count_spe_nd         = isset($DISP_ATTENDANCE_LOCK->spe_nd) ? $DISP_ATTENDANCE_LOCK->spe_nd : 0;
      $count_spe_ndot       = isset($DISP_ATTENDANCE_LOCK->spe_ndot) ? $DISP_ATTENDANCE_LOCK->spe_ndot : 0;
      $count_sperest_hours  = isset($DISP_ATTENDANCE_LOCK->sperest_hours) ? $DISP_ATTENDANCE_LOCK->sperest_hours : 0;
      $count_sperest_ot     = isset($DISP_ATTENDANCE_LOCK->sperest_ot) ? $DISP_ATTENDANCE_LOCK->sperest_ot : 0;
      $count_sperest_nd     = isset($DISP_ATTENDANCE_LOCK->sperest_nd) ? $DISP_ATTENDANCE_LOCK->sperest_nd : 0;
      $count_sperest_ndot   = isset($DISP_ATTENDANCE_LOCK->sperest_ndot) ? $DISP_ATTENDANCE_LOCK->sperest_ndot : 0;
      //-----------------TAXABLE ALLOWANCES---------------
      // $tax_allowance_list         = $this->payrolls_model->GET_STD_TAX_ALLOWANCE_LIST();
      // $tax_allowance_total        = 0;
      // foreach ($tax_allowance_list as $tax_list_row) {
      //   $tax_allow_id             = $tax_list_row->id;
      //   $tax_allow_type           = $tax_list_row->type;
      //   $tax_list_row->value      = $this->payrolls_model->GET_TAX_ALLOWANCE_EMPL($tax_allow_id, $empl_id);
      //   $tax_list_row->empl_id    = $empl_id;
      //   if ($tax_allow_type == "Attendance") {
      //     $tax_list_row->count    = $count_present;
      //     // $tax_list_row->subtotal = number_format((float)$tax_list_row->value * $tax_list_row->count, 2);
      //     $tax_list_row->subtotal  = floatval($tax_list_row->value) * floatval($tax_list_row->count);
      //   } else {
      //     $tax_list_row->count    = '-';
      //     // $tax_list_row->subtotal = number_format((float)$tax_list_row->value, 2);
      //     $tax_list_row->subtotal  = floatval($tax_list_row->value);
      //   }
      //   $tax_allowance_total      = $tax_allowance_total + $tax_list_row->subtotal;
      // }
      //-----------------NON-TAXABLE ALLOWANCES---------------
      //  $nontax_allowance_list    = $this->payrolls_model->GET_STD_NONTAX_ALLOWANCE_LIST();
      //  $nontax_allowance_total   = 0;
      //  foreach ($nontax_allowance_list as $nontax_list_row) {
      //    $nontax_allow_id        = $nontax_list_row->id;
      //    $nontax_allow_type      = $nontax_list_row->type;
      //    $nontax_list_row->value = $this->payrolls_model->GET_NONTAX_ALLOWANCE_EMPL($nontax_allow_id, $empl_id);
      //    $nontax_list_row->empl_id    = $empl_id;
      //    if ($nontax_allow_type == "Attendance") {
      //      $nontax_list_row->count     = $count_present;
      //      $nontax_list_row->subtotal  = floatval($nontax_list_row->value) * floatval($nontax_list_row->count);
      //    } else {
      //      $nontax_list_row->count     = '-';
      //      $nontax_list_row->subtotal  = floatval($nontax_list_row->value);
      //    }
      //    $nontax_allowance_total       = $nontax_allowance_total + $nontax_list_row->subtotal;
      //  }
      //--------------------------------------------------------
      if ($en_ti == 0) {
        $tax_allowance_total = 0;
      }
      if ($en_nti == 0) {
        $nontax_allowance_total = 0;
      }
      $mul_present        = 1;
      $mul_absent         = 1;
      $mul_tardiness      = 1;
      $mul_undertime      = 1;
      $mul_paid_leave     = 1;
      $mul_reg_hours      = 1;
      $mul_reg_ot         = 1.25;
      $mul_reg_nd         = 0.1;
      $mul_reg_ndot       = 1.375;
      $mul_rest_hours     = 1.3;
      $mul_rest_ot        = 1.69;
      $mul_rest_nd        = 1.43;
      $mul_rest_ndot      = 1.859;
      $mul_leg_hours      = 1;
      $mul_leg_ot         = 2.6;
      $mul_leg_nd         = 1.2;
      $mul_leg_ndot       = 2.860;
      $mul_legrest_hours  = 2.6;
      $mul_legrest_ot     = 3.38;
      $mul_legrest_nd     = 2.86;
      $mul_legrest_ndot   = 3.718;
      $mul_spe_hours      = 0.3;
      $mul_spe_ot         = 1.69;
      $mul_spe_nd         = 0.43;
      $mul_spe_ndot       = 1.859;
      $mul_sperest_hours  = 1.5;
      $mul_sperest_ot     = 1.95;
      $mul_sperest_nd     = 1.65;
      $mul_sperest_ndot   = 2.145;
      $tot_present        = $ini_salary_rate / 2;
      if ($ini_salary_type == "Daily") {
        $tot_present = 0;
      } else {
        $count_reg_hours = 0;
      }
      $tot_absent         = $hourly_salary * $mul_absent        * $count_absent;
      $tot_tardiness      = $hourly_salary * $mul_tardiness     * $count_tardiness;
      $tot_undertime      = $hourly_salary * $mul_undertime     * $count_undertime;
      $tot_paid_leave     = $hourly_salary * $mul_paid_leave    * $count_paid_leave;
      $tot_reg_hours      = $hourly_salary * $mul_reg_hours     * $count_reg_hours;
      $tot_reg_ot         = $hourly_salary * $mul_reg_ot        * $count_reg_ot;
      $tot_reg_nd         = $hourly_salary * $mul_reg_nd        * $count_reg_nd;
      $tot_reg_ndot       = $hourly_salary * $mul_reg_ndot      * $count_reg_ndot;
      $tot_rest_hours     = $hourly_salary * $mul_rest_hours    * $count_rest_hours;
      $tot_rest_ot        = $hourly_salary * $mul_rest_ot       * $count_rest_ot;
      $tot_rest_nd        = $hourly_salary * $mul_rest_nd       * $count_rest_nd;
      $tot_rest_ndot      = $hourly_salary * $mul_rest_ndot     * $count_rest_ndot;
      $tot_leg_hours      = $hourly_salary * $mul_leg_hours     * $count_leg_hours;
      $tot_leg_ot         = $hourly_salary * $mul_leg_ot        * $count_leg_ot;
      $tot_leg_nd         = $hourly_salary * $mul_leg_nd        * $count_leg_nd;
      $tot_leg_ndot       = $hourly_salary * $mul_leg_ndot      * $count_leg_ndot;
      $tot_legrest_hours  = $hourly_salary * $mul_legrest_hours * $count_legrest_hours;
      $tot_legrest_ot     = $hourly_salary * $mul_legrest_ot    * $count_legrest_ot;
      $tot_legrest_nd     = $hourly_salary * $mul_legrest_nd    * $count_legrest_nd;
      $tot_legrest_ndot   = $hourly_salary * $mul_legrest_ndot  * $count_legrest_ndot;
      $tot_spe_hours      = $hourly_salary * $mul_spe_hours     * $count_spe_hours;
      $tot_spe_ot         = $hourly_salary * $mul_spe_ot        * $count_spe_ot;
      $tot_spe_nd         = $hourly_salary * $mul_spe_nd        * $count_spe_nd;
      $tot_spe_ndot       = $hourly_salary * $mul_spe_ndot      * $count_spe_ndot;
      $tot_sperest_hours  = $hourly_salary * $mul_sperest_hours * $count_sperest_hours;
      $tot_sperest_ot     = $hourly_salary * $mul_sperest_ot    * $count_sperest_ot;
      $tot_sperest_nd     = $hourly_salary * $mul_sperest_nd    * $count_sperest_nd;
      $tot_sperest_ndot   = $hourly_salary * $mul_sperest_ndot  * $count_sperest_ndot;
      if ($en_absut == 0) {
        $tot_tardiness = 0;
      }
      if ($ini_salary_type == "Daily") {
        $payroll_monthly_cons = $this->payrolls_model->GET_PAYROLL_MONTHLY_CONSTANT();
        $basic_income = $daily_salary * $payroll_monthly_cons / 12 / 2;
      } else {
        $basic_income = $tot_present;
      }
      $data['DISP_PERIOD']                             = $this->payrolls_model->GET_PERIOD_NAME($period);
      $basic_pay              = $tot_present + $tot_reg_hours + $tot_paid_leave + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $basic_deduction        = $tot_absent + $tot_tardiness + $tot_undertime;
      $gross_income           = $tot_present + $tot_reg_hours + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $gross_income           = $gross_income + $tot_paid_leave;
      $gross_income           = $gross_income - $basic_deduction;
      $gross_income           = $gross_income + $tax_allowance_total + $nontax_allowance_total;
      $gross_income_total     = $gross_income + $gross_income_prev_1 + $gross_income_prev_2 + $gross_income_prev_3 + $gross_income_prev_4 + $gross_income_prev_5;
      $sss_ee_current         = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ee) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ee : 0;
      $sss_ee_current = $this->SSS_EE_TOTAL_DATA;
      $sss_er_current         = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->er) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->er : 0;
      $sss_ec_er_current      = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ec_er) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ec_er : 0;
      if ($basic_income >= 5000) {
        $pagibig_ee_current     = 100;
        $pagibig_er_current     = 100;
      } else {
        $pagibig_ee_current     = $basic_income * 0.02;
        $pagibig_er_current     = $basic_income * 0.02;
      }
      $philhealth_data        = isset(($this->payrolls_model->GET_PHILHEALTH_VALUE())[0]) ? ($this->payrolls_model->GET_PHILHEALTH_VALUE())[0] : 0;
      $philhealth_rate        = isset($philhealth_data->rate) ? $philhealth_data->rate : 0;
      $philhealth_min_basic   = isset($philhealth_data->min_basic) ? $philhealth_data->min_basic : 0;
      $philhealth_max_basic   = isset($philhealth_data->max_basic) ? $philhealth_data->max_basic : 0;
      $philhealth_min_premium = isset($philhealth_data->min_premium) ? $philhealth_data->min_premium : 0;
      $philhealth_max_premium = isset($philhealth_data->max_premium) ? $philhealth_data->max_premium : 0;
      if ($basic_income <= $philhealth_min_basic) {
        $philhealth_ee_current = $philhealth_min_premium / 2;
        $philhealth_er_current = $philhealth_min_premium / 2;
      } else if ($basic_income >= $philhealth_max_basic) {
        $philhealth_ee_current = $philhealth_max_premium / 2;
        $philhealth_er_current = $philhealth_max_premium / 2;
      } else {
        $philhealth_ee_current = ($basic_income * ($philhealth_rate / 100)) / 2;
        $philhealth_er_current = ($basic_income * ($philhealth_rate / 100)) / 2;
      }
      $sss_ee_diff = $sss_ee_current - $sss_ee_prev_1 - $sss_ee_prev_2 - $sss_ee_prev_3 - $sss_ee_prev_4 - $sss_ee_prev_5;
      $pagibig_ee_diff = $pagibig_ee_current - $pagibig_ee_prev_1 - $pagibig_ee_prev_2 - $pagibig_ee_prev_3 - $pagibig_ee_prev_4 - $pagibig_ee_prev_5;
      $philhealth_ee_diff = $philhealth_ee_current - $philhealth_ee_prev_1 - $philhealth_ee_prev_2 - $philhealth_ee_prev_3 - $philhealth_ee_prev_4 - $philhealth_ee_prev_5;
      $sss_er_diff = $sss_er_current - $sss_er_prev_1 - $sss_er_prev_2 - $sss_er_prev_3 - $sss_er_prev_4 - $sss_er_prev_5;
      $sss_ec_er_diff = $sss_ec_er_current - $sss_ec_er_prev_1 - $sss_ec_er_prev_2 - $sss_ec_er_prev_3 - $sss_ec_er_prev_4 - $sss_ec_er_prev_5;
      $pagibig_er_diff = $pagibig_er_current - $pagibig_er_prev_1 - $pagibig_er_prev_2 - $pagibig_er_prev_3 - $pagibig_er_prev_4 - $pagibig_er_prev_5;
      $philhealth_er_diff = $philhealth_er_current - $philhealth_er_prev_1 - $philhealth_er_prev_2 - $philhealth_er_prev_3 - $philhealth_er_prev_4 - $philhealth_er_prev_5;
      if ($en_sss == 0) {
        $sss_ee_diff = 0;
        $sss_er_diff = 0;
        $sss_ec_er_diff = 0;
      }
      if ($en_pagibig == 0) {
        $pagibig_ee_diff = 0;
        $pagibig_er_diff = 0;
      }
      if ($en_phil == 0) {
        $philhealth_ee_diff = 0;
        $philhealth_er_diff = 0;
      }
      $taxable_income           = $tot_present + $tot_reg_hours + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $taxable_income           = $taxable_income + $tot_paid_leave;
      $taxable_income           = $taxable_income - ($tot_absent + $tot_tardiness + $tot_undertime);
      $taxable_income           = $taxable_income + $tax_allowance_total;
      $taxable_income           = $taxable_income - ($sss_ee_diff + $philhealth_ee_diff + $pagibig_ee_diff);
      $wtax_raw = $this->payrolls_model->GET_TAX_VALUE($taxable_income);
      $wtax_salary_min      = 0;
      $wtax_salary_max      = 0;
      $wtax_salary_fixed    = 0;
      $wtax_salary_clevel   = 0;
      $wtax_salary_cpercent = 0;
      if ($wtax_raw) {
        $wtax_salary_min      = $wtax_raw["salary_min"];
        $wtax_salary_max      = $wtax_raw["salary_max"];
        $wtax_salary_fixed    = $wtax_raw["fixed"];
        $wtax_salary_clevel   = $wtax_raw["c_level"];
        $wtax_salary_cpercent = $wtax_raw["c_percent"];
      }
      $wtax = $wtax_salary_fixed + ($taxable_income - $wtax_salary_clevel) * $wtax_salary_cpercent / 100;
      if ($en_wtax == 0) {
        $wtax = 0;
      }
      $ee_current_total     = $sss_ee_current + $pagibig_ee_current + $philhealth_ee_current;
      $er_current_total     = $sss_er_current + $pagibig_er_current + $philhealth_er_current;
      $ee_previous_total_1  = $sss_ee_prev_1 + $pagibig_ee_prev_1 + $philhealth_ee_prev_1;
      $ee_previous_total_2  = $sss_ee_prev_2 + $pagibig_ee_prev_2 + $philhealth_ee_prev_2;
      $ee_previous_total_3  = $sss_ee_prev_3 + $pagibig_ee_prev_3 + $philhealth_ee_prev_3;
      $ee_previous_total_4  = $sss_ee_prev_4 + $pagibig_ee_prev_4 + $philhealth_ee_prev_4;
      $ee_previous_total_5  = $sss_ee_prev_5 + $pagibig_ee_prev_5 + $philhealth_ee_prev_5;
      $er_previous_total_1  = $sss_er_prev_1 + $pagibig_er_prev_1 + $philhealth_er_prev_1;
      $er_previous_total_2  = $sss_er_prev_2 + $pagibig_er_prev_2 + $philhealth_er_prev_2;
      $er_previous_total_3  = $sss_er_prev_3 + $pagibig_er_prev_3 + $philhealth_er_prev_3;
      $er_previous_total_4  = $sss_er_prev_4 + $pagibig_er_prev_4 + $philhealth_er_prev_4;
      $er_previous_total_5  = $sss_er_prev_5 + $pagibig_er_prev_5 + $philhealth_er_prev_5;
      $ee_difference_total  = $sss_ee_diff + $pagibig_ee_diff + $philhealth_ee_diff;
      $er_difference_total  = $sss_er_diff + $pagibig_er_diff + $philhealth_er_diff;
      $earnings   = $basic_pay + $tax_allowance_total + $nontax_allowance_total;
      $deductions = $basic_deduction + $wtax + $ee_difference_total + $loancadeduct_total;
      $net_income = $earnings - $deductions;
      $data['DISP_CONN_PERIOD_1']                 = $connected_1;
      $data['DISP_CONN_PERIOD_2']                 = $connected_2;
      $data['DISP_CONN_PERIOD_3']                 = $connected_3;
      $data['DISP_CONN_PERIOD_4']                 = $connected_4;
      $data['DISP_CONN_PERIOD_5']                 = $connected_5;
      $data['DISP_CONN_PERIOD_1_NAME']            = $connected_1_name;
      $data['DISP_CONN_PERIOD_2_NAME']            = $connected_2_name;
      $data['DISP_CONN_PERIOD_3_NAME']            = $connected_3_name;
      $data['DISP_CONN_PERIOD_4_NAME']            = $connected_4_name;
      $data['DISP_CONN_PERIOD_5_NAME']            = $connected_5_name;
      $data["COUNT_PRESENT"]                      = $count_present;
      $data["COUNT_ABSENT"]                       = $count_absent;
      $data["COUNT_TARDINESS"]                    = $count_tardiness;
      $data["COUNT_UNDERTIME"]                    = $count_undertime;
      $data["COUNT_PAID_LEAVE"]                   = $count_paid_leave;
      $data["COUNT_REG_HOURS"]                    = $count_reg_hours;
      $data["COUNT_REG_OT"]                       = $count_reg_ot;
      $data["COUNT_REG_ND"]                       = $count_reg_nd;
      $data["COUNT_REG_NDOT"]                     = $count_reg_ndot;
      $data["COUNT_REST_HOURS"]                   = $count_rest_hours;
      $data["COUNT_REST_OT"]                      = $count_rest_ot;
      $data["COUNT_REST_ND"]                      = $count_rest_nd;
      $data["COUNT_REST_NDOT"]                    = $count_rest_ndot;
      $data["COUNT_LEG_HOURS"]                    = $count_leg_hours;
      $data["COUNT_LEG_OT"]                       = $count_leg_ot;
      $data["COUNT_LEG_ND"]                       = $count_leg_nd;
      $data["COUNT_LEG_NDOT"]                     = $count_leg_ndot;
      $data["COUNT_LEGREST_HOURS"]                = $count_legrest_hours;
      $data["COUNT_LEGREST_OT"]                   = $count_legrest_ot;
      $data["COUNT_LEGREST_ND"]                   = $count_legrest_nd;
      $data["COUNT_LEGREST_NDOT"]                 = $count_legrest_ndot;
      $data["COUNT_SPE_HOURS"]                    = $count_spe_hours;
      $data["COUNT_SPE_OT"]                       = $count_spe_ot;
      $data["COUNT_SPE_ND"]                       = $count_spe_nd;
      $data["COUNT_SPE_NDOT"]                     = $count_spe_ndot;
      $data["COUNT_SPEREST_HOURS"]                = $count_sperest_hours;
      $data["COUNT_SPEREST_OT"]                   = $count_sperest_ot;
      $data["COUNT_SPEREST_ND"]                   = $count_sperest_nd;
      $data["COUNT_SPEREST_NDOT"]                 = $count_sperest_ndot;
      $data["MUL_PRESENT"]                        = $mul_present;
      $data["MUL_ABSENT"]                         = $mul_absent;
      $data["MUL_TARDINESS"]                      = $mul_tardiness;
      $data["MUL_UNDERTIME"]                      = $mul_undertime;
      $data["MUL_PAID_LEAVE"]                     = $mul_paid_leave;
      $data["MUL_REG_HOURS"]                      = $mul_reg_hours;
      $data["MUL_REG_OT"]                         = $mul_reg_ot;
      $data["MUL_REG_ND"]                         = $mul_reg_nd;
      $data["MUL_REG_NDOT"]                       = $mul_reg_ndot;
      $data["MUL_REST_HOURS"]                     = $mul_rest_hours;
      $data["MUL_REST_OT"]                        = $mul_rest_ot;
      $data["MUL_REST_ND"]                        = $mul_rest_nd;
      $data["MUL_REST_NDOT"]                      = $mul_rest_ndot;
      $data["MUL_LEG_HOURS"]                      = $mul_leg_hours;
      $data["MUL_LEG_OT"]                         = $mul_leg_ot;
      $data["MUL_LEG_ND"]                         = $mul_leg_nd;
      $data["MUL_LEG_NDOT"]                       = $mul_leg_ndot;
      $data["MUL_LEGREST_HOURS"]                  = $mul_legrest_hours;
      $data["MUL_LEGREST_OT"]                     = $mul_legrest_ot;
      $data["MUL_LEGREST_ND"]                     = $mul_legrest_nd;
      $data["MUL_LEGREST_NDOT"]                   = $mul_legrest_ndot;
      $data["MUL_SPE_HOURS"]                      = $mul_spe_hours;
      $data["MUL_SPE_OT"]                         = $mul_spe_ot;
      $data["MUL_SPE_ND"]                         = $mul_spe_nd;
      $data["MUL_SPE_NDOT"]                       = $mul_spe_ndot;
      $data["MUL_SPEREST_HOURS"]                  = $mul_sperest_hours;
      $data["MUL_SPEREST_OT"]                     = $mul_sperest_ot;
      $data["MUL_SPEREST_ND"]                     = $mul_sperest_nd;
      $data["MUL_SPEREST_NDOT"]                   = $mul_sperest_ndot;
      $data["TOT_PRESENT"]                        = number_format((float)$tot_present, 2);
      $data["TOT_ABSENT"]                         = number_format((float)$tot_absent, 2);
      $data["TOT_TARDINESS"]                      = number_format((float)$tot_tardiness, 2);
      $data["TOT_UNDERTIME"]                      = number_format((float)$tot_undertime, 2);
      $data["TOT_PAID_LEAVE"]                     = number_format((float)$tot_paid_leave, 2);
      $data["TOT_REG_HOURS"]                      = number_format((float)$tot_reg_hours, 2);
      $data["TOT_REG_OT"]                         = number_format((float)$tot_reg_ot, 2);
      $data["TOT_REG_ND"]                         = number_format((float)$tot_reg_nd, 2);
      $data["TOT_REG_NDOT"]                       = number_format((float)$tot_reg_ndot, 2);
      $data["TOT_REST_HOURS"]                     = number_format((float)$tot_rest_hours, 2);
      $data["TOT_REST_OT"]                        = number_format((float)$tot_rest_ot, 2);
      $data["TOT_REST_ND"]                        = number_format((float)$tot_rest_nd, 2);
      $data["TOT_REST_NDOT"]                      = number_format((float)$tot_rest_ndot, 2);
      $data["TOT_LEG_HOURS"]                      = number_format((float)$tot_leg_hours, 2);
      $data["TOT_LEG_OT"]                         = number_format((float)$tot_leg_ot, 2);
      $data["TOT_LEG_ND"]                         = number_format((float)$tot_leg_nd, 2);
      $data["TOT_LEG_NDOT"]                       = number_format((float)$tot_leg_ndot, 2);
      $data["TOT_LEGREST_HOURS"]                  = number_format((float)$tot_legrest_hours, 2);
      $data["TOT_LEGREST_OT"]                     = number_format((float)$tot_legrest_ot, 2);
      $data["TOT_LEGREST_ND"]                     = number_format((float)$tot_legrest_nd, 2);
      $data["TOT_LEGREST_NDOT"]                   = number_format((float)$tot_legrest_ndot, 2);
      $data["TOT_SPE_HOURS"]                      = number_format((float)$tot_spe_hours, 2);
      $data["TOT_SPE_OT"]                         = number_format((float)$tot_spe_ot, 2);
      $data["TOT_SPE_ND"]                         = number_format((float)$tot_spe_nd, 2);
      $data["TOT_SPE_NDOT"]                       = number_format((float)$tot_spe_ndot, 2);
      $data["TOT_SPEREST_HOURS"]                  = number_format((float)$tot_sperest_hours, 2);
      $data["TOT_SPEREST_OT"]                     = number_format((float)$tot_sperest_ot, 2);
      $data["TOT_SPEREST_ND"]                     = number_format((float)$tot_sperest_nd, 2);
      $data["TOT_SPEREST_NDOT"]                   = number_format((float)$tot_sperest_ndot, 2);
      $data["GROSS_INCOME"]                       = number_format((float)$gross_income, 2);
      $data["GROSS_INCOME_PREV_1"]                = number_format((float)$gross_income_prev_1, 2);
      $data["GROSS_INCOME_PREV_2"]                = number_format((float)$gross_income_prev_2, 2);
      $data["GROSS_INCOME_PREV_3"]                = number_format((float)$gross_income_prev_3, 2);
      $data["GROSS_INCOME_PREV_4"]                = number_format((float)$gross_income_prev_4, 2);
      $data["GROSS_INCOME_PREV_5"]                = number_format((float)$gross_income_prev_5, 2);
      $data["GROSS_INCOME_TOTAL"]                 = number_format((float)$gross_income_total, 2);
      $data["TAXABLE_INCOME"]                     = number_format((float)$taxable_income, 2);
      $data["SSS_EE_TOTAL"]                       = number_format((float)$sss_ee_current, 2);
      $data["SSS_EE_CURRENT"]                     = number_format((float)$sss_ee_diff, 2);
      $data["PAGIBIG_EE_TOTAL"]                   = number_format((float)$pagibig_ee_current, 2);
      $data["PAGIBIG_EE_CURRENT"]                 = number_format((float)$pagibig_ee_diff, 2);
      $data["PHILHEALTH_EE_TOTAL"]                = number_format((float)$philhealth_ee_current, 2);
      $data["PHILHEALTH_EE_CURRENT"]              = number_format((float)$philhealth_ee_diff, 2);
      // $data["TOTAL_EE_TOTAL"]                    = number_format((float)$ee_current_total, 2);
      $data["TOTAL_EE_CURRENT"]                   = number_format((float)$ee_difference_total, 2);
      $data["SSS_ER_TOTAL"]                       = number_format((float)$sss_er_current, 2);
      $data["SSS_EC_ER_TOTAL"]                    = number_format((float)$sss_ec_er_current, 2);
      // $data["SSS_ER_CURRENT"]                    = number_format((float)$sss_er_diff, 2);
      // $data["SSS_EC_ER_CURRENT"]                 = number_format((float)$sss_ec_er_diff, 2);
      //---------------------------
      $data["SSS_EE_PREVIOUS_1"]                  = number_format((float)$sss_ee_prev_1, 2);
      $data["PAGIBIG_EE_PREVIOUS_1"]              = number_format((float)$pagibig_ee_prev_1, 2);
      $data["PHILHEALTH_EE_PREVIOUS_1"]           = number_format((float)$philhealth_ee_prev_1, 2);
      $data['INITIAL_SALARY_RATE']                = number_format((float)$ini_salary_rate, 2);
      $data['INITIAL_SALARY_TYPE']                = $ini_salary_type;
      $data['INITIAL_DAILY_RATE']                 = number_format((float)$daily_salary, 2);
      $data['INITIAL_HOURLY_RATE']                = number_format((float)$hourly_salary, 2);
      $data['BASIC_PAY']                          = number_format((float)$basic_pay, 2);
      $data['BASIC_DEDUCTION']                    = number_format((float)$basic_deduction, 2);
      $data['DISP_TAX_ALLOWANCE']                 = $tax_allowance_list;
      $data['DISP_TAX_ALLOWANCE_TOTAL']           = number_format((float)$tax_allowance_total, 2);
      $data['DISP_NONTAX_ALLOWANCE']              = $nontax_allowance_list;
      $data['DISP_NONTAX_ALLOWANCE_TOTAL']        = number_format((float)$nontax_allowance_total, 2);
      $data["WTAX"]                               = number_format((float)$wtax, 2);
      $data["EARNINGS"]                           = number_format((float)$earnings, 2);
      $data["DEDUCTIONS"]                         = number_format((float)$deductions, 2);
      $data["NET_INCOME"]                         = number_format((float)$net_income, 2);
      $data['EN_SSS']                     = $en_sss;
      $data['EN_PHIL']                    = $en_phil;
      $data['EN_PAGIBIG']                 = $en_pagibig;
      $data['EN_WTAX']                    = $en_wtax;
      $data['EN_TI']                      = $en_ti;
      $data['EN_NTI']                     = $en_nti;
      // $data['EN_TD']                      = $en_td;
      // $data['EN_NTD']                     = $en_ntd;
      $data['EN_LOAN']                    = $en_loan;
      $data['EN_ABSUT']                   = $en_absut;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payslip_generated_views', $data);
    }
    function edit_generated_payslip($empl_id, $period)
    {
      $data['DISP_PAYROLL_PAYSLIPS']                      = $this->payrolls_model->GET_PAYROLL_PAYSLIPS($empl_id, $period);
      $data['DISP_PAYROLL_PAYSLIPS_PERIOD']               = $this->payrolls_model->GET_PAYROLL_PAYSLIPS($empl_id, $period);
      $data['DISP_PAYROLL_PAYSLIPS']->PAYSLIP_PERIOD      = $this->payrolls_model->GET_PERIOD_NAME($period);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/edit_payslip_generated_views', $data);
    }
    function edit_generated_payslip_data($id, $empl_id, $period)
    {
      $array = [
        'id'                  => $id,
        'count_present'       => $this->input->post('count_present'),
        'count_absent'        => $this->input->post('count_absent'),
        'count_tardiness'     => $this->input->post('count_tardiness'),
        'count_undertime'     => $this->input->post('count_undertime'),
        'count_paid_leave'    => $this->input->post('count_paid_leave'),
        'count_reg_hours'     => $this->input->post('count_reg_hours'),
        'count_reg_ot'        => $this->input->post('count_reg_ot'),
        'count_reg_nd'        => $this->input->post('count_reg_nd'),
        'count_reg_ndot'      => $this->input->post('count_reg_ndot'),
        'count_rest_hours'    => $this->input->post('count_rest_hours'),
        'count_rest_ot'       => $this->input->post('count_rest_ot'),
        'count_rest_nd'       => $this->input->post('count_rest_nd'),
        'count_rest_ndot'     => $this->input->post('count_rest_ndot'),
        'count_leg_hours'     => $this->input->post('count_leg_hours'),
        'count_leg_ot'        => $this->input->post('count_leg_ot'),
        'count_leg_nd'        => $this->input->post('count_leg_nd'),
        'count_leg_ndot'      => $this->input->post('count_leg_ndot'),
        'count_legrest_hours' => $this->input->post('count_legrest_hours'),
        'count_legrest_ot'    => $this->input->post('count_legrest_ot'),
        'count_legrest_nd'    => $this->input->post('count_legrest_nd'),
        'count_legrest_ndot'  => $this->input->post('count_legrest_ndot'),
        'count_spe_hours'     => $this->input->post('count_spe_hours'),
        'count_spe_ot'        => $this->input->post('count_spe_ot'),
        'count_spe_nd'        => $this->input->post('count_spe_nd'),
        'count_spe_ndot'      => $this->input->post('count_spe_ndot'),
        'count_sperest_hours' => $this->input->post('count_sperest_hours'),
        'count_sperest_ot'    => $this->input->post('count_sperest_ot'),
        'count_sperest_nd'    => $this->input->post('count_sperest_nd'),
        'count_sperest_ndot'  => $this->input->post('count_sperest_ndot'),
      ];
      $this->payrolls_model->EDIT_GENERATED_PAYSLIP($array);
      $this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Edited payslip');
      redirect('payrolls/edit_generated_payslip/' . $empl_id . '/' . $period);
    }
    function published_payslip($empl_id, $period)
    {
      // $period                                   = $this->input->get('period'); 
      $payroll_list                             = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      if ($period == null && !empty($payroll_list)) {
        $period = $payroll_list[0]->period;
      }
      $data['PAYROLL_CONTRIBUTION'] = $specific_payroll_sched = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($period);
      ($specific_payroll_sched->chk_sss == null || $specific_payroll_sched->chk_sss == 1) ? $en_sss = 1 : $en_sss = 0;
      ($specific_payroll_sched->chk_philhealth == null || $specific_payroll_sched->chk_philhealth == 1) ? $en_phil = 1 : $en_phil = 0;
      ($specific_payroll_sched->chk_pagibig == null || $specific_payroll_sched->chk_pagibig == 1) ? $en_pagibig = 1 : $en_pagibig = 0;
      ($specific_payroll_sched->chk_withholding == null || $specific_payroll_sched->chk_withholding == 1) ? $en_wtax = 1 : $en_wtax = 0;
      ($specific_payroll_sched->chk_taxable == null || $specific_payroll_sched->chk_taxable == 1) ? $en_ti = 1 : $en_ti = 0;
      ($specific_payroll_sched->chk_nontaxable == null || $specific_payroll_sched->chk_nontaxable == 1) ? $en_nti = 1 : $en_nti = 0;
      ($specific_payroll_sched->chk_loans == null || $specific_payroll_sched->chk_loans == 1) ? $en_loan = 1 : $en_loan = 0;
      ($specific_payroll_sched->chk_tardiness == null || $specific_payroll_sched->chk_tardiness == 1) ? $en_absut = 1 : $en_absut = 0;
      $data['DISP_EMPLOYEE']                   = $employee = $this->payrolls_model->GET_SPECIFIC_EMPLOYEE_DATA($empl_id);
      //---------------------------- INITIAL DECLARATION --
      $sss_ee_prev_1 = 0;
      $pagibig_ee_prev_1 = 0;
      $philhealth_ee_prev_1 = 0;
      $sss_er_prev_1 = 0;
      $sss_ec_er_prev_1 = 0;
      $pagibig_er_prev_1 = 0;
      $philhealth_er_prev_1 = 0;
      $sss_ee_prev_2 = 0;
      $pagibig_ee_prev_2 = 0;
      $philhealth_ee_prev_2 = 0;
      $sss_er_prev_2 = 0;
      $sss_ec_er_prev_2 = 0;
      $pagibig_er_prev_2 = 0;
      $philhealth_er_prev_2 = 0;
      $sss_ee_prev_3 = 0;
      $pagibig_ee_prev_3 = 0;
      $philhealth_ee_prev_3 = 0;
      $sss_er_prev_3 = 0;
      $sss_ec_er_prev_3 = 0;
      $pagibig_er_prev_3 = 0;
      $philhealth_er_prev_3 = 0;
      $sss_ee_prev_4 = 0;
      $pagibig_ee_prev_4 = 0;
      $philhealth_ee_prev_4 = 0;
      $sss_er_prev_4 = 0;
      $sss_ec_er_prev_4 = 0;
      $pagibig_er_prev_4 = 0;
      $philhealth_er_prev_4 = 0;
      $sss_ee_prev_5 = 0;
      $pagibig_ee_prev_5 = 0;
      $philhealth_ee_prev_5 = 0;
      $sss_er_prev_5 = 0;
      $sss_ec_er_prev_5 = 0;
      $pagibig_er_prev_5 = 0;
      $philhealth_er_prev_5 = 0;
      // $data['PAYROLL_CONTRIBUTION']           = $this->payrolls_model->GET_PAYROLL_SCHEDULE_CONTRIBUTION($period);
      //---------------------------- CONNECTED PAYROLLS ---------------------------------------------
      $period_connected                       = $this->payrolls_model->GET_PERIOD_CONNECTED($period);
      $connected_1 = 0;
      $connected_2 = 0;
      $connected_3 = 0;
      $connected_4 = 0;
      $connected_5 = 0;
      if (count($period_connected) > 0) {
        $connected_1 = $period_connected[0]->connected_period;
        $connected_2 = $period_connected[0]->connected_period_2;
        $connected_3 = $period_connected[0]->connected_period_3;
        $connected_4 = $period_connected[0]->connected_period_4;
        $connected_5 = $period_connected[0]->connected_period_5;
      }
      if ($connected_1 != "0") {
        $connected_1_name = $this->payrolls_model->GET_PERIOD_NAME($connected_1);
      } else {
        $connected_1_name = "";
      }
      if ($connected_2 != "0") {
        $connected_2_name = $this->payrolls_model->GET_PERIOD_NAME($connected_2);
      } else {
        $connected_2_name = "";
      }
      if ($connected_3 != "0") {
        $connected_3_name = $this->payrolls_model->GET_PERIOD_NAME($connected_3);
      } else {
        $connected_3_name = "";
      }
      if ($connected_4 != "0") {
        $connected_4_name = $this->payrolls_model->GET_PERIOD_NAME($connected_4);
      } else {
        $connected_4_name = "";
      }
      if ($connected_5 != "0") {
        $connected_5_name = $this->payrolls_model->GET_PERIOD_NAME($connected_5);
      } else {
        $connected_5_name = "";
      }
      $employee_specific                  = $this->payrolls_model->GET_EMPLOYEE_INFO_SPECIFIC($empl_id);
      $ID_SSS                             = isset($employee_specific[0]->col_empl_sssc) ? $employee_specific[0]->col_empl_sssc : 0;
      $ID_PAGIBIG                         = isset($employee_specific[0]->col_empl_hdmf) ? $employee_specific[0]->col_empl_hdmf : 0;
      $ID_PHILHEALTH                      = isset($employee_specific[0]->col_empl_phil) ? $employee_specific[0]->col_empl_phil : 0;
      $ID_TIN                             = isset($employee_specific[0]->col_empl_btin) ? $employee_specific[0]->col_empl_btin : 0;
      $loan_user_all                      = $this->payrolls_model->GET_PAYROLL_LOAN_DATA_EMPL($empl_id);
      // $ca_user_all                        = $this->payrolls_model->GET_PAYROLL_CA_DATA_EMPL($empl_id);
      // $deduct_user_all                    = $this->payrolls_model->GET_PAYROLL_DEDUCT_DATA_EMPL($empl_id);
      $loan_total                         = 0;
      $ca_total                           = 0;
      $deduct_total                       = 0;
      if (!empty($loan_user_all)) {
        foreach ($loan_user_all as $loan_user_all_row) {
          $loan_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_LOAN_ID($loan_user_all_row->id);
          $loan_contrib                   = (float)$loan_user_all_row->loan_amount / $loan_user_all_row->loan_terms;
          $loan_user_all_row->contrib     = number_format($loan_contrib, 2);
          $loan_total                     = $loan_total + $loan_contrib;
        }
      }
      // if(!empty($ca_user_all)){
      //   foreach ($ca_user_all as $ca_user_all_row) {
      //     $ca_user_all_row->paid_count    = $this->payrolls_model->GET_COUNT_CA_ID($ca_user_all_row->id);
      //     $ca_contrib                     = 0;
      //     $ca_user_all_row->contrib       = number_format($ca_contrib,2);
      //     $ca_total                       = $ca_total + $ca_contrib;
      //   }
      // }
      // if(!empty($deduct_user_all)){
      //   foreach ($deduct_user_all as $deduct_user_all_row) {
      //     $deduct_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_DEDUCT_ID($deduct_user_all_row->id);
      //     $deduct_contrib                   = 0;
      //     $deduct_user_all_row->contrib     = number_format($deduct_contrib,2);
      //     $deduct_total                     = $deduct_total + $deduct_contrib;
      //   }
      // }
      if ($en_loan == 0) {
        $loan_total = 0;
      }
      $loancadeduct_total                   = $loan_total + $ca_total + $deduct_total;
      $data['DISP_LOAN']                    = $loan_user_all;
      $data['DISP_CA']                      = $ca_user_all;
      $data['DISP_DEDUCT']                  = $deduct_user_all;
      $string_loan = str_replace('"', '@', json_encode($loan_user_all));
      $string_ca = ""; /*str_replace('"', '@', json_encode($ca_user_all));*/
      $string_deduct = ""; /*str_replace('"', '@', json_encode($deduct_user_all));*/
      $data['DISP_LOAN_STRING']             = $string_loan;
      $data['DISP_CA_STRING']               = $string_ca;
      $data['DISP_DEDUCT_STRING']           =  $string_deduct;
      $data['DISP_LOANCADED_TOTAL']         = number_format($loancadeduct_total, 2);
      if ($connected_1 == 0) {
        $gross_income_prev_1 = 0;
      } else {
        $connected_data_previous_1          = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_1);
        if (empty($connected_data_previous_1)) {
          $gross_income_prev_1  = 0;
          $sss_ee_prev_1        = 0;
          $pagibig_ee_prev_1    = 0;
          $philhealth_ee_prev_1 = 0;
          $sss_er_prev_1        = 0;
          $sss_ec_er_prev_1     = 0;
          $pagibig_er_prev_1    = 0;
          $philhealth_er_prev_1 = 0;
        } else {
          $gross_income_prev_1    = isset($connected_data_previous_1->GROSS_INCOME)             ? $connected_data_previous_1->GROSS_INCOME : 0;
          $sss_ee_prev_1          = isset($connected_data_previous_1->SSS_EE_CURRENT)           ? $connected_data_previous_1->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_1      = isset($connected_data_previous_1->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_1->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_1   = isset($connected_data_previous_1->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_1->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_1          = isset($connected_data_previous_1->SSS_ER_CURRENT)        ? $connected_data_previous_1->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_1       = isset($connected_data_previous_1->SSS_EC_ER_CURRENT)     ? $connected_data_previous_1->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_1      = isset($connected_data_previous_1->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_1->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_1   = isset($connected_data_previous_1->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_1->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_2 == 0) {
        $gross_income_prev_2 = 0;
      } else {
        $connected_data_previous_2 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_2);
        if (empty($connected_data_previous_2)) {
          $gross_income_prev_2  = 0;
          $sss_ee_prev_2        = 0;
          $pagibig_ee_prev_2    = 0;
          $philhealth_ee_prev_2 = 0;
          $sss_er_prev_2        = 0;
          $sss_ec_er_prev_2     = 0;
          $pagibig_er_prev_2    = 0;
          $philhealth_er_prev_2 = 0;
        } else {
          $gross_income_prev_2    = isset($connected_data_previous_2->GROSS_INCOME)             ? $connected_data_previous_2->GROSS_INCOME : 0;
          $sss_ee_prev_2          = isset($connected_data_previous_2->SSS_EE_CURRENT)           ? $connected_data_previous_2->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_2      = isset($connected_data_previous_2->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_2->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_2   = isset($connected_data_previous_2->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_2->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_2          = isset($connected_data_previous_2->SSS_ER_CURRENT)        ? $connected_data_previous_2->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_2       = isset($connected_data_previous_2->SSS_EC_ER_CURRENT)     ? $connected_data_previous_2->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_2      = isset($connected_data_previous_2->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_2->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_2   = isset($connected_data_previous_2->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_2->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_3 == 0) {
        $gross_income_prev_3 = 0;
      } else {
        $connected_data_previous_3 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_3);
        if (empty($connected_data_previous_3)) {
          $gross_income_prev_3  = 0;
          $sss_ee_prev_3        = 0;
          $pagibig_ee_prev_3    = 0;
          $philhealth_ee_prev_3 = 0;
          $sss_er_prev_3        = 0;
          $sss_ec_er_prev_3     = 0;
          $pagibig_er_prev_3    = 0;
          $philhealth_er_prev_3 = 0;
        } else {
          $gross_income_prev_3    = isset($connected_data_previous_3->GROSS_INCOME)             ? $connected_data_previous_3->GROSS_INCOME : 0;
          $sss_ee_prev_3          = isset($connected_data_previous_3->SSS_EE_CURRENT)           ? $connected_data_previous_3->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_3      = isset($connected_data_previous_3->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_3->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_3   = isset($connected_data_previous_3->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_3->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_3          = isset($connected_data_previous_3->SSS_ER_CURRENT)        ? $connected_data_previous_3->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_3       = isset($connected_data_previous_3->SSS_EC_ER_CURRENT)     ? $connected_data_previous_3->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_3      = isset($connected_data_previous_3->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_3->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_3   = isset($connected_data_previous_3->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_3->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_4 == 0) {
        $gross_income_prev_4 = 0;
      } else {
        $connected_data_previous_4 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_4);
        if (empty($connected_data_previous_4)) {
          $gross_income_prev_4  = 0;
          $sss_ee_prev_4        = 0;
          $pagibig_ee_prev_4    = 0;
          $philhealth_ee_prev_4 = 0;
          $sss_er_prev_4        = 0;
          $sss_ec_er_prev_4     = 0;
          $pagibig_er_prev_4    = 0;
          $philhealth_er_prev_4 = 0;
        } else {
          $gross_income_prev_4    = isset($connected_data_previous_4->GROSS_INCOME)             ? $connected_data_previous_4->GROSS_INCOME : 0;
          $sss_ee_prev_4          = isset($connected_data_previous_4->SSS_EE_CURRENT)           ? $connected_data_previous_4->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_4      = isset($connected_data_previous_4->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_4->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_4   = isset($connected_data_previous_4->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_4->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_4          = isset($connected_data_previous_4->SSS_ER_CURRENT)        ? $connected_data_previous_4->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_4       = isset($connected_data_previous_4->SSS_EC_ER_CURRENT)     ? $connected_data_previous_4->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_4      = isset($connected_data_previous_4->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_4->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_4   = isset($connected_data_previous_4->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_4->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_5 == 0) {
        $gross_income_prev_5 = 0;
      } else {
        $connected_data_previous_5 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $connected_5);
        if (empty($connected_data_previous_5)) {
          $gross_income_prev_5  = 0;
          $sss_ee_prev_5        = 0;
          $pagibig_ee_prev_5    = 0;
          $philhealth_ee_prev_5 = 0;
          $sss_er_prev_5        = 0;
          $sss_ec_er_prev_5     = 0;
          $pagibig_er_prev_5    = 0;
          $philhealth_er_prev_5 = 0;
        } else {
          $gross_income_prev_5    = isset($connected_data_previous_5->GROSS_INCOME)             ? $connected_data_previous_5->GROSS_INCOME : 0;
          $sss_ee_prev_5          = isset($connected_data_previous_5->SSS_EE_CURRENT)           ? $connected_data_previous_5->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_5      = isset($connected_data_previous_5->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_5->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_5   = isset($connected_data_previous_5->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_5->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_5          = isset($connected_data_previous_5->SSS_ER_CURRENT)        ? $connected_data_previous_5->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_5       = isset($connected_data_previous_5->SSS_EC_ER_CURRENT)     ? $connected_data_previous_5->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_5      = isset($connected_data_previous_5->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_5->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_5   = isset($connected_data_previous_5->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_5->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      $DISP_ATTENDANCE_LOCK =  isset(($this->payrolls_model->GET_ATTENDANCE_LOCK($employee->id, $period))[0]) ? ($this->payrolls_model->GET_ATTENDANCE_LOCK($employee->id, $period))[0] : 0;
      $ini_empl_cmid        = !empty($employee_specific) ? $employee_specific[0]->col_empl_cmid : 0;
      $ini_empl_name        = !empty($employee_specific) ? $employee_specific[0]->col_last_name . ', ' . $employee_specific[0]->col_last_name : 0;
      $ini_salary_rate      = !empty($employee_specific) ? $employee_specific[0]->salary_rate : 0;
      $ini_salary_type      = !empty($employee_specific) ? $employee_specific[0]->salary_type : 0;
      if ($ini_salary_type == "Daily") {
        $daily_salary       =  $ini_salary_rate;
        $hourly_salary      = $daily_salary / 8;
      } else {
        $payroll_monthly_cons = $this->payrolls_model->GET_PAYROLL_MONTHLY_CONSTANT();
        $daily_salary       =  $ini_salary_rate * 12 / $payroll_monthly_cons;
        $hourly_salary      = $daily_salary / 8;
      }
      $count_present        = isset($DISP_ATTENDANCE_LOCK->present) ? $DISP_ATTENDANCE_LOCK->present : 0;
      $count_absent         = isset($DISP_ATTENDANCE_LOCK->absent) ? $DISP_ATTENDANCE_LOCK->absent : 0;
      $count_tardiness      = isset($DISP_ATTENDANCE_LOCK->tardiness) ? $DISP_ATTENDANCE_LOCK->tardiness : 0;
      $count_undertime      = isset($DISP_ATTENDANCE_LOCK->undertime) ? $DISP_ATTENDANCE_LOCK->undertime : 0;
      $count_paid_leave     = isset($DISP_ATTENDANCE_LOCK->paid_leave) ? $DISP_ATTENDANCE_LOCK->paid_leave : 0;
      $count_reg_hours      = isset($DISP_ATTENDANCE_LOCK->reg_hours) ? $DISP_ATTENDANCE_LOCK->reg_hours : 0;
      $count_reg_ot         = isset($DISP_ATTENDANCE_LOCK->reg_ot) ? $DISP_ATTENDANCE_LOCK->reg_ot : 0;
      $count_reg_nd         = isset($DISP_ATTENDANCE_LOCK->reg_nd) ? $DISP_ATTENDANCE_LOCK->reg_nd : 0;
      $count_reg_ndot       = isset($DISP_ATTENDANCE_LOCK->reg_ndot) ? $DISP_ATTENDANCE_LOCK->reg_ndot : 0;
      $count_rest_hours     = isset($DISP_ATTENDANCE_LOCK->rest_hours) ? $DISP_ATTENDANCE_LOCK->rest_hours : 0;
      $count_rest_ot        = isset($DISP_ATTENDANCE_LOCK->rest_ot) ? $DISP_ATTENDANCE_LOCK->rest_ot : 0;
      $count_rest_nd        = isset($DISP_ATTENDANCE_LOCK->rest_nd) ? $DISP_ATTENDANCE_LOCK->rest_nd : 0;
      $count_rest_ndot      = isset($DISP_ATTENDANCE_LOCK->rest_ndot) ? $DISP_ATTENDANCE_LOCK->rest_ndot : 0;
      $count_leg_hours      = isset($DISP_ATTENDANCE_LOCK->leg_hours) ? $DISP_ATTENDANCE_LOCK->leg_hours : 0;
      $count_leg_ot         = isset($DISP_ATTENDANCE_LOCK->leg_ot) ? $DISP_ATTENDANCE_LOCK->leg_ot : 0;
      $count_leg_nd         = isset($DISP_ATTENDANCE_LOCK->leg_nd) ? $DISP_ATTENDANCE_LOCK->leg_nd : 0;
      $count_leg_ndot       = isset($DISP_ATTENDANCE_LOCK->leg_ndot) ? $DISP_ATTENDANCE_LOCK->leg_ndot : 0;
      $count_legrest_hours  = isset($DISP_ATTENDANCE_LOCK->legrest_hours) ? $DISP_ATTENDANCE_LOCK->legrest_hours : 0;
      $count_legrest_ot     = isset($DISP_ATTENDANCE_LOCK->legrest_ot) ? $DISP_ATTENDANCE_LOCK->legrest_ot : 0;
      $count_legrest_nd     = isset($DISP_ATTENDANCE_LOCK->legrest_nd) ? $DISP_ATTENDANCE_LOCK->legrest_nd : 0;
      $count_legrest_ndot   = isset($DISP_ATTENDANCE_LOCK->legrest_ndot) ? $DISP_ATTENDANCE_LOCK->legrest_ndot : 0;
      $count_spe_hours      = isset($DISP_ATTENDANCE_LOCK->spe_hours) ? $DISP_ATTENDANCE_LOCK->spe_hours : 0;
      $count_spe_ot         = isset($DISP_ATTENDANCE_LOCK->spe_ot) ? $DISP_ATTENDANCE_LOCK->spe_ot : 0;
      $count_spe_nd         = isset($DISP_ATTENDANCE_LOCK->spe_nd) ? $DISP_ATTENDANCE_LOCK->spe_nd : 0;
      $count_spe_ndot       = isset($DISP_ATTENDANCE_LOCK->spe_ndot) ? $DISP_ATTENDANCE_LOCK->spe_ndot : 0;
      $count_sperest_hours  = isset($DISP_ATTENDANCE_LOCK->sperest_hours) ? $DISP_ATTENDANCE_LOCK->sperest_hours : 0;
      $count_sperest_ot     = isset($DISP_ATTENDANCE_LOCK->sperest_ot) ? $DISP_ATTENDANCE_LOCK->sperest_ot : 0;
      $count_sperest_nd     = isset($DISP_ATTENDANCE_LOCK->sperest_nd) ? $DISP_ATTENDANCE_LOCK->sperest_nd : 0;
      $count_sperest_ndot   = isset($DISP_ATTENDANCE_LOCK->sperest_ndot) ? $DISP_ATTENDANCE_LOCK->sperest_ndot : 0;
      //-----------------TAXABLE ALLOWANCES---------------
      // $tax_allowance_list         = $this->payrolls_model->GET_STD_TAX_ALLOWANCE_LIST();
      // $tax_allowance_total        = 0;
      // foreach ($tax_allowance_list as $tax_list_row) {
      //   $tax_allow_id             = $tax_list_row->id;
      //   $tax_allow_type           = $tax_list_row->type;
      //   $tax_list_row->value      = number_format((float)$this->payrolls_model->GET_TAX_ALLOWANCE_EMPL($tax_allow_id, $empl_id), 2);
      //   if ($tax_allow_type == "Attendance") {
      //     $tax_list_row->count    = $count_present;
      //     $tax_list_row->subtotal = number_format((float)$tax_list_row->value * $tax_list_row->count, 2);
      //   } else {
      //     $tax_list_row->count    = '-';
      //     $tax_list_row->subtotal = number_format((float)$tax_list_row->value, 2);
      //   }
      //   $tax_allowance_total      = $tax_allowance_total + $tax_list_row->subtotal;
      // }
      //-----------------NON-TAXABLE ALLOWANCES---------------
      //  $nontax_allowance_list    = $this->payrolls_model->GET_STD_NONTAX_ALLOWANCE_LIST();
      //  $nontax_allowance_total   = 0;
      //  foreach ($nontax_allowance_list as $nontax_list_row) {
      //    $nontax_allow_id        = $nontax_list_row->id;
      //    $nontax_allow_type      = $nontax_list_row->type;
      //    $nontax_list_row->value = $this->payrolls_model->GET_NONTAX_ALLOWANCE_EMPL($nontax_allow_id, $empl_id);
      //    if ($nontax_allow_type == "Attendance") {
      //      $nontax_list_row->count     = $count_present;
      //      $nontax_list_row->subtotal  = floatval($nontax_list_row->value) * floatval($nontax_list_row->count);
      //    } else {
      //      $nontax_list_row->count     = '-';
      //      $nontax_list_row->subtotal  = floatval($nontax_list_row->value);
      //    }
      //    $nontax_allowance_total       = $nontax_allowance_total + $nontax_list_row->subtotal;
      //  }
      //--------------------------------------------------------
      if ($en_ti == 0) {
        $tax_allowance_total = 0;
      }
      if ($en_nti == 0) {
        $nontax_allowance_total = 0;
      }
      $mul_present        = 1;
      $mul_absent         = 1;
      $mul_tardiness      = 1;
      $mul_undertime      = 1;
      $mul_paid_leave     = 1;
      $mul_reg_hours      = 1;
      $mul_reg_ot         = 1.25;
      $mul_reg_nd         = 0.1;
      $mul_reg_ndot       = 1.375;
      $mul_rest_hours     = 1.3;
      $mul_rest_ot        = 1.69;
      $mul_rest_nd        = 1.43;
      $mul_rest_ndot      = 1.859;
      $mul_leg_hours      = 1;
      $mul_leg_ot         = 2.6;
      $mul_leg_nd         = 1.2;
      $mul_leg_ndot       = 2.860;
      $mul_legrest_hours  = 2.6;
      $mul_legrest_ot     = 3.38;
      $mul_legrest_nd     = 2.86;
      $mul_legrest_ndot   = 3.718;
      $mul_spe_hours      = 0.3;
      $mul_spe_ot         = 1.69;
      $mul_spe_nd         = 0.43;
      $mul_spe_ndot       = 1.859;
      $mul_sperest_hours  = 1.5;
      $mul_sperest_ot     = 1.95;
      $mul_sperest_nd     = 1.65;
      $mul_sperest_ndot   = 2.145;
      $tot_present        = $ini_salary_rate / 2;
      if ($ini_salary_type == "Daily") {
        $tot_present = 0;
      } else {
        $count_reg_hours = 0;
      }
      $tot_absent         = $hourly_salary * $mul_absent        * $count_absent;
      $tot_tardiness      = $hourly_salary * $mul_tardiness     * $count_tardiness;
      $tot_undertime      = $hourly_salary * $mul_undertime     * $count_undertime;
      $tot_paid_leave     = $hourly_salary * $mul_paid_leave    * $count_paid_leave;
      $tot_reg_hours      = $hourly_salary * $mul_reg_hours     * $count_reg_hours;
      $tot_reg_ot         = $hourly_salary * $mul_reg_ot        * $count_reg_ot;
      $tot_reg_nd         = $hourly_salary * $mul_reg_nd        * $count_reg_nd;
      $tot_reg_ndot       = $hourly_salary * $mul_reg_ndot      * $count_reg_ndot;
      $tot_rest_hours     = $hourly_salary * $mul_rest_hours    * $count_rest_hours;
      $tot_rest_ot        = $hourly_salary * $mul_rest_ot       * $count_rest_ot;
      $tot_rest_nd        = $hourly_salary * $mul_rest_nd       * $count_rest_nd;
      $tot_rest_ndot      = $hourly_salary * $mul_rest_ndot     * $count_rest_ndot;
      $tot_leg_hours      = $hourly_salary * $mul_leg_hours     * $count_leg_hours;
      $tot_leg_ot         = $hourly_salary * $mul_leg_ot        * $count_leg_ot;
      $tot_leg_nd         = $hourly_salary * $mul_leg_nd        * $count_leg_nd;
      $tot_leg_ndot       = $hourly_salary * $mul_leg_ndot      * $count_leg_ndot;
      $tot_legrest_hours  = $hourly_salary * $mul_legrest_hours * $count_legrest_hours;
      $tot_legrest_ot     = $hourly_salary * $mul_legrest_ot    * $count_legrest_ot;
      $tot_legrest_nd     = $hourly_salary * $mul_legrest_nd    * $count_legrest_nd;
      $tot_legrest_ndot   = $hourly_salary * $mul_legrest_ndot  * $count_legrest_ndot;
      $tot_spe_hours      = $hourly_salary * $mul_spe_hours     * $count_spe_hours;
      $tot_spe_ot         = $hourly_salary * $mul_spe_ot        * $count_spe_ot;
      $tot_spe_nd         = $hourly_salary * $mul_spe_nd        * $count_spe_nd;
      $tot_spe_ndot       = $hourly_salary * $mul_spe_ndot      * $count_spe_ndot;
      $tot_sperest_hours  = $hourly_salary * $mul_sperest_hours * $count_sperest_hours;
      $tot_sperest_ot     = $hourly_salary * $mul_sperest_ot    * $count_sperest_ot;
      $tot_sperest_nd     = $hourly_salary * $mul_sperest_nd    * $count_sperest_nd;
      $tot_sperest_ndot   = $hourly_salary * $mul_sperest_ndot  * $count_sperest_ndot;
      if ($en_absut == 0) {
        $tot_tardiness = 0;
      }
      if ($ini_salary_type == "Daily") {
        $payroll_monthly_cons = $this->payrolls_model->GET_PAYROLL_MONTHLY_CONSTANT();
        $basic_income = $daily_salary * $payroll_monthly_cons / 12 / 2;
      } else {
        $basic_income = $tot_present;
      }
      $data['DISP_PERIOD']                             = $this->payrolls_model->GET_PERIOD_NAME($period);
      $basic_pay              = $tot_present + $tot_reg_hours + $tot_paid_leave + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $basic_deduction        = $tot_absent + $tot_tardiness + $tot_undertime;
      $gross_income           = $tot_present + $tot_reg_hours + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $gross_income           = $gross_income + $tot_paid_leave;
      $gross_income           = $gross_income - $basic_deduction;
      $gross_income           = $gross_income + $tax_allowance_total + $nontax_allowance_total;
      $gross_income_total     = $gross_income + $gross_income_prev_1 + $gross_income_prev_2 + $gross_income_prev_3 + $gross_income_prev_4 + $gross_income_prev_5;
      $sss_ee_current         = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ee) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ee : 0;
      $sss_er_current         = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->er) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->er : 0;
      $sss_ec_er_current      = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ec_er) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ec_er : 0;
      if ($basic_income >= 5000) {
        $pagibig_ee_current     = 100;
        $pagibig_er_current     = 100;
      } else {
        $pagibig_ee_current     = $basic_income * 0.02;
        $pagibig_er_current     = $basic_income * 0.02;
      }
      $philhealth_data        = isset(($this->payrolls_model->GET_PHILHEALTH_VALUE())[0]) ? ($this->payrolls_model->GET_PHILHEALTH_VALUE())[0] : 0;
      $philhealth_rate        = isset($philhealth_data->rate) ? $philhealth_data->rate : 0;
      $philhealth_min_basic   = isset($philhealth_data->min_basic) ? $philhealth_data->min_basic : 0;
      $philhealth_max_basic   = isset($philhealth_data->max_basic) ? $philhealth_data->max_basic : 0;
      $philhealth_min_premium = isset($philhealth_data->min_premium) ? $philhealth_data->min_premium : 0;
      $philhealth_max_premium = isset($philhealth_data->max_premium) ? $philhealth_data->max_premium : 0;
      if ($basic_income <= $philhealth_min_basic) {
        $philhealth_ee_current = $philhealth_min_premium / 2;
        $philhealth_er_current = $philhealth_min_premium / 2;
      } else if ($basic_income >= $philhealth_max_basic) {
        $philhealth_ee_current = $philhealth_max_premium / 2;
        $philhealth_er_current = $philhealth_max_premium / 2;
      } else {
        $philhealth_ee_current = ($basic_income * ($philhealth_rate / 100)) / 2;
        $philhealth_er_current = ($basic_income * ($philhealth_rate / 100)) / 2;
      }
      $sss_ee_diff = $sss_ee_current - $sss_ee_prev_1 - $sss_ee_prev_2 - $sss_ee_prev_3 - $sss_ee_prev_4 - $sss_ee_prev_5;
      $pagibig_ee_diff = $pagibig_ee_current - $pagibig_ee_prev_1 - $pagibig_ee_prev_2 - $pagibig_ee_prev_3 - $pagibig_ee_prev_4 - $pagibig_ee_prev_5;
      $philhealth_ee_diff = $philhealth_ee_current - $philhealth_ee_prev_1 - $philhealth_ee_prev_2 - $philhealth_ee_prev_3 - $philhealth_ee_prev_4 - $philhealth_ee_prev_5;
      $sss_er_diff = $sss_er_current - $sss_er_prev_1 - $sss_er_prev_2 - $sss_er_prev_3 - $sss_er_prev_4 - $sss_er_prev_5;
      $sss_ec_er_diff = $sss_ec_er_current - $sss_ec_er_prev_1 - $sss_ec_er_prev_2 - $sss_ec_er_prev_3 - $sss_ec_er_prev_4 - $sss_ec_er_prev_5;
      $pagibig_er_diff = $pagibig_er_current - $pagibig_er_prev_1 - $pagibig_er_prev_2 - $pagibig_er_prev_3 - $pagibig_er_prev_4 - $pagibig_er_prev_5;
      $philhealth_er_diff = $philhealth_er_current - $philhealth_er_prev_1 - $philhealth_er_prev_2 - $philhealth_er_prev_3 - $philhealth_er_prev_4 - $philhealth_er_prev_5;
      if ($en_sss == 0) {
        $sss_ee_diff = 0;
        $sss_er_diff = 0;
        $sss_ec_er_diff = 0;
      }
      if ($en_pagibig == 0) {
        $pagibig_ee_diff = 0;
        $pagibig_er_diff = 0;
      }
      if ($en_phil == 0) {
        $philhealth_ee_diff = 0;
        $philhealth_er_diff = 0;
      }
      $taxable_income           = $tot_present + $tot_reg_hours + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $taxable_income           = $taxable_income + $tot_paid_leave;
      $taxable_income           = $taxable_income - ($tot_absent + $tot_tardiness + $tot_undertime);
      $taxable_income           = $taxable_income + $tax_allowance_total;
      $taxable_income           = $taxable_income - ($sss_ee_diff + $philhealth_ee_diff + $pagibig_ee_diff);
      $wtax_raw = $this->payrolls_model->GET_TAX_VALUE($taxable_income);
      $wtax_salary_min      = 0;
      $wtax_salary_max      = 0;
      $wtax_salary_fixed    = 0;
      $wtax_salary_clevel   = 0;
      $wtax_salary_cpercent = 0;
      if ($wtax_raw) {
        $wtax_salary_min      = $wtax_raw["salary_min"];
        $wtax_salary_max      = $wtax_raw["salary_max"];
        $wtax_salary_fixed    = $wtax_raw["fixed"];
        $wtax_salary_clevel   = $wtax_raw["c_level"];
        $wtax_salary_cpercent = $wtax_raw["c_percent"];
      }
      $wtax = $wtax_salary_fixed + ($taxable_income - $wtax_salary_clevel) * $wtax_salary_cpercent / 100;
      if ($en_wtax == 0) {
        $wtax = 0;
      }
      $ee_current_total     = $sss_ee_current + $pagibig_ee_current + $philhealth_ee_current;
      $er_current_total     = $sss_er_current + $pagibig_er_current + $philhealth_er_current;
      $ee_previous_total_1  = $sss_ee_prev_1 + $pagibig_ee_prev_1 + $philhealth_ee_prev_1;
      $ee_previous_total_2  = $sss_ee_prev_2 + $pagibig_ee_prev_2 + $philhealth_ee_prev_2;
      $ee_previous_total_3  = $sss_ee_prev_3 + $pagibig_ee_prev_3 + $philhealth_ee_prev_3;
      $ee_previous_total_4  = $sss_ee_prev_4 + $pagibig_ee_prev_4 + $philhealth_ee_prev_4;
      $ee_previous_total_5  = $sss_ee_prev_5 + $pagibig_ee_prev_5 + $philhealth_ee_prev_5;
      $er_previous_total_1  = $sss_er_prev_1 + $pagibig_er_prev_1 + $philhealth_er_prev_1;
      $er_previous_total_2  = $sss_er_prev_2 + $pagibig_er_prev_2 + $philhealth_er_prev_2;
      $er_previous_total_3  = $sss_er_prev_3 + $pagibig_er_prev_3 + $philhealth_er_prev_3;
      $er_previous_total_4  = $sss_er_prev_4 + $pagibig_er_prev_4 + $philhealth_er_prev_4;
      $er_previous_total_5  = $sss_er_prev_5 + $pagibig_er_prev_5 + $philhealth_er_prev_5;
      $ee_difference_total  = $sss_ee_diff + $pagibig_ee_diff + $philhealth_ee_diff;
      $er_difference_total  = $sss_er_diff + $pagibig_er_diff + $philhealth_er_diff;
      $earnings   = $basic_pay + $tax_allowance_total + $nontax_allowance_total;
      $deductions = $basic_deduction + $wtax + $ee_difference_total + $loancadeduct_total;
      $net_income = $earnings - $deductions;
      $data['DISP_CONN_PERIOD_1']                 = $connected_1;
      $data['DISP_CONN_PERIOD_2']                 = $connected_2;
      $data['DISP_CONN_PERIOD_3']                 = $connected_3;
      $data['DISP_CONN_PERIOD_4']                 = $connected_4;
      $data['DISP_CONN_PERIOD_5']                 = $connected_5;
      $data['DISP_CONN_PERIOD_1_NAME']            = $connected_1_name;
      $data['DISP_CONN_PERIOD_2_NAME']            = $connected_2_name;
      $data['DISP_CONN_PERIOD_3_NAME']            = $connected_3_name;
      $data['DISP_CONN_PERIOD_4_NAME']            = $connected_4_name;
      $data['DISP_CONN_PERIOD_5_NAME']            = $connected_5_name;
      $data["COUNT_PRESENT"]                      = $count_present;
      $data["COUNT_ABSENT"]                       = $count_absent;
      $data["COUNT_TARDINESS"]                    = $count_tardiness;
      $data["COUNT_UNDERTIME"]                    = $count_undertime;
      $data["COUNT_PAID_LEAVE"]                   = $count_paid_leave;
      $data["COUNT_REG_HOURS"]                    = $count_reg_hours;
      $data["COUNT_REG_OT"]                       = $count_reg_ot;
      $data["COUNT_REG_ND"]                       = $count_reg_nd;
      $data["COUNT_REG_NDOT"]                     = $count_reg_ndot;
      $data["COUNT_REST_HOURS"]                   = $count_rest_hours;
      $data["COUNT_REST_OT"]                      = $count_rest_ot;
      $data["COUNT_REST_ND"]                      = $count_rest_nd;
      $data["COUNT_REST_NDOT"]                    = $count_rest_ndot;
      $data["COUNT_LEG_HOURS"]                    = $count_leg_hours;
      $data["COUNT_LEG_OT"]                       = $count_leg_ot;
      $data["COUNT_LEG_ND"]                       = $count_leg_nd;
      $data["COUNT_LEG_NDOT"]                     = $count_leg_ndot;
      $data["COUNT_LEGREST_HOURS"]                = $count_legrest_hours;
      $data["COUNT_LEGREST_OT"]                   = $count_legrest_ot;
      $data["COUNT_LEGREST_ND"]                   = $count_legrest_nd;
      $data["COUNT_LEGREST_NDOT"]                 = $count_legrest_ndot;
      $data["COUNT_SPE_HOURS"]                    = $count_spe_hours;
      $data["COUNT_SPE_OT"]                       = $count_spe_ot;
      $data["COUNT_SPE_ND"]                       = $count_spe_nd;
      $data["COUNT_SPE_NDOT"]                     = $count_spe_ndot;
      $data["COUNT_SPEREST_HOURS"]                = $count_sperest_hours;
      $data["COUNT_SPEREST_OT"]                   = $count_sperest_ot;
      $data["COUNT_SPEREST_ND"]                   = $count_sperest_nd;
      $data["COUNT_SPEREST_NDOT"]                 = $count_sperest_ndot;
      $data["MUL_PRESENT"]                        = $mul_present;
      $data["MUL_ABSENT"]                         = $mul_absent;
      $data["MUL_TARDINESS"]                      = $mul_tardiness;
      $data["MUL_UNDERTIME"]                      = $mul_undertime;
      $data["MUL_PAID_LEAVE"]                     = $mul_paid_leave;
      $data["MUL_REG_HOURS"]                      = $mul_reg_hours;
      $data["MUL_REG_OT"]                         = $mul_reg_ot;
      $data["MUL_REG_ND"]                         = $mul_reg_nd;
      $data["MUL_REG_NDOT"]                       = $mul_reg_ndot;
      $data["MUL_REST_HOURS"]                     = $mul_rest_hours;
      $data["MUL_REST_OT"]                        = $mul_rest_ot;
      $data["MUL_REST_ND"]                        = $mul_rest_nd;
      $data["MUL_REST_NDOT"]                      = $mul_rest_ndot;
      $data["MUL_LEG_HOURS"]                      = $mul_leg_hours;
      $data["MUL_LEG_OT"]                         = $mul_leg_ot;
      $data["MUL_LEG_ND"]                         = $mul_leg_nd;
      $data["MUL_LEG_NDOT"]                       = $mul_leg_ndot;
      $data["MUL_LEGREST_HOURS"]                  = $mul_legrest_hours;
      $data["MUL_LEGREST_OT"]                     = $mul_legrest_ot;
      $data["MUL_LEGREST_ND"]                     = $mul_legrest_nd;
      $data["MUL_LEGREST_NDOT"]                   = $mul_legrest_ndot;
      $data["MUL_SPE_HOURS"]                      = $mul_spe_hours;
      $data["MUL_SPE_OT"]                         = $mul_spe_ot;
      $data["MUL_SPE_ND"]                         = $mul_spe_nd;
      $data["MUL_SPE_NDOT"]                       = $mul_spe_ndot;
      $data["MUL_SPEREST_HOURS"]                  = $mul_sperest_hours;
      $data["MUL_SPEREST_OT"]                     = $mul_sperest_ot;
      $data["MUL_SPEREST_ND"]                     = $mul_sperest_nd;
      $data["MUL_SPEREST_NDOT"]                   = $mul_sperest_ndot;
      $data["TOT_PRESENT"]                        = number_format((float)$tot_present, 2);
      $data["TOT_ABSENT"]                         = number_format((float)$tot_absent, 2);
      $data["TOT_TARDINESS"]                      = number_format((float)$tot_tardiness, 2);
      $data["TOT_UNDERTIME"]                      = number_format((float)$tot_undertime, 2);
      $data["TOT_PAID_LEAVE"]                     = number_format((float)$tot_paid_leave, 2);
      $data["TOT_REG_HOURS"]                      = number_format((float)$tot_reg_hours, 2);
      $data["TOT_REG_OT"]                         = number_format((float)$tot_reg_ot, 2);
      $data["TOT_REG_ND"]                         = number_format((float)$tot_reg_nd, 2);
      $data["TOT_REG_NDOT"]                       = number_format((float)$tot_reg_ndot, 2);
      $data["TOT_REST_HOURS"]                     = number_format((float)$tot_rest_hours, 2);
      $data["TOT_REST_OT"]                        = number_format((float)$tot_rest_ot, 2);
      $data["TOT_REST_ND"]                        = number_format((float)$tot_rest_nd, 2);
      $data["TOT_REST_NDOT"]                      = number_format((float)$tot_rest_ndot, 2);
      $data["TOT_LEG_HOURS"]                      = number_format((float)$tot_leg_hours, 2);
      $data["TOT_LEG_OT"]                         = number_format((float)$tot_leg_ot, 2);
      $data["TOT_LEG_ND"]                         = number_format((float)$tot_leg_nd, 2);
      $data["TOT_LEG_NDOT"]                       = number_format((float)$tot_leg_ndot, 2);
      $data["TOT_LEGREST_HOURS"]                  = number_format((float)$tot_legrest_hours, 2);
      $data["TOT_LEGREST_OT"]                     = number_format((float)$tot_legrest_ot, 2);
      $data["TOT_LEGREST_ND"]                     = number_format((float)$tot_legrest_nd, 2);
      $data["TOT_LEGREST_NDOT"]                   = number_format((float)$tot_legrest_ndot, 2);
      $data["TOT_SPE_HOURS"]                      = number_format((float)$tot_spe_hours, 2);
      $data["TOT_SPE_OT"]                         = number_format((float)$tot_spe_ot, 2);
      $data["TOT_SPE_ND"]                         = number_format((float)$tot_spe_nd, 2);
      $data["TOT_SPE_NDOT"]                       = number_format((float)$tot_spe_ndot, 2);
      $data["TOT_SPEREST_HOURS"]                  = number_format((float)$tot_sperest_hours, 2);
      $data["TOT_SPEREST_OT"]                     = number_format((float)$tot_sperest_ot, 2);
      $data["TOT_SPEREST_ND"]                     = number_format((float)$tot_sperest_nd, 2);
      $data["TOT_SPEREST_NDOT"]                   = number_format((float)$tot_sperest_ndot, 2);
      $data["GROSS_INCOME"]                       = number_format((float)$gross_income, 2);
      $data["GROSS_INCOME_PREV_1"]                = number_format((float)$gross_income_prev_1, 2);
      $data["GROSS_INCOME_PREV_2"]                = number_format((float)$gross_income_prev_2, 2);
      $data["GROSS_INCOME_PREV_3"]                = number_format((float)$gross_income_prev_3, 2);
      $data["GROSS_INCOME_PREV_4"]                = number_format((float)$gross_income_prev_4, 2);
      $data["GROSS_INCOME_PREV_5"]                = number_format((float)$gross_income_prev_5, 2);
      $data["GROSS_INCOME_TOTAL"]                 = number_format((float)$gross_income_total, 2);
      $data["TAXABLE_INCOME"]                     = number_format((float)$taxable_income, 2);
      $data["SSS_EE_TOTAL"]                       = number_format((float)$sss_ee_current, 2);
      $data["SSS_EE_CURRENT"]                     = number_format((float)$sss_ee_diff, 2);
      $data["PAGIBIG_EE_TOTAL"]                   = number_format((float)$pagibig_ee_current, 2);
      $data["PAGIBIG_EE_CURRENT"]                 = number_format((float)$pagibig_ee_diff, 2);
      $data["PHILHEALTH_EE_TOTAL"]                = number_format((float)$philhealth_ee_current, 2);
      $data["PHILHEALTH_EE_CURRENT"]              = number_format((float)$philhealth_ee_diff, 2);
      // $data["TOTAL_EE_TOTAL"]                    = number_format((float)$ee_current_total, 2);
      $data["TOTAL_EE_CURRENT"]                   = number_format((float)$ee_difference_total, 2);
      $data["SSS_ER_TOTAL"]                       = number_format((float)$sss_er_current, 2);
      $data["SSS_EC_ER_TOTAL"]                    = number_format((float)$sss_ec_er_current, 2);
      // $data["SSS_ER_CURRENT"]                    = number_format((float)$sss_er_diff, 2);
      // $data["SSS_EC_ER_CURRENT"]                 = number_format((float)$sss_ec_er_diff, 2);
      //---------------------------
      $data["SSS_EE_PREVIOUS_1"]                  = number_format((float)$sss_ee_prev_1, 2);
      $data["PAGIBIG_EE_PREVIOUS_1"]              = number_format((float)$pagibig_ee_prev_1, 2);
      $data["PHILHEALTH_EE_PREVIOUS_1"]           = number_format((float)$philhealth_ee_prev_1, 2);
      $data['INITIAL_SALARY_RATE']                = number_format((float)$ini_salary_rate, 2);
      $data['INITIAL_SALARY_TYPE']                = $ini_salary_type;
      $data['INITIAL_DAILY_RATE']                 = number_format((float)$daily_salary, 2);
      $data['INITIAL_HOURLY_RATE']                = number_format((float)$hourly_salary, 2);
      $data['BASIC_PAY']                          = number_format((float)$basic_pay, 2);
      $data['BASIC_DEDUCTION']                    = number_format((float)$basic_deduction, 2);
      $data['DISP_TAX_ALLOWANCE']                 = $tax_allowance_list;
      $data['DISP_TAX_ALLOWANCE_TOTAL']           = number_format((float)$tax_allowance_total, 2);
      $data['DISP_NONTAX_ALLOWANCE']              = $nontax_allowance_list;
      $data['DISP_NONTAX_ALLOWANCE_TOTAL']        = number_format((float)$nontax_allowance_total, 2);
      $data["WTAX"]                               = number_format((float)$wtax, 2);
      $data["EARNINGS"]                           = number_format((float)$earnings, 2);
      $data["DEDUCTIONS"]                         = number_format((float)$deductions, 2);
      $data["NET_INCOME"]                         = number_format((float)$net_income, 2);
      $data['EN_SSS']                     = $en_sss;
      $data['EN_PHIL']                    = $en_phil;
      $data['EN_PAGIBIG']                 = $en_pagibig;
      $data['EN_WTAX']                    = $en_wtax;
      $data['EN_TI']                      = $en_ti;
      $data['EN_NTI']                     = $en_nti;
      // $data['EN_TD']                      = $en_td;
      // $data['EN_NTD']                     = $en_ntd;
      $data['EN_LOAN']                    = $en_loan;
      $data['EN_ABSUT']                   = $en_absut;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payslip_published_views', $data);
    }
    function add_payslip_published()
    {
      $payslip_ids                    = $this->input->post('UPDATE_PUBLISH_ID');
      // $loan_id_lists                  = $this->input->post('UPDATE_EMPLOYEE_LOAN_LIST');
      // $net_income_list                = $this->input->post('UPDATE_NET_INCOME');
      $payslip_id                     = explode(",", $payslip_ids);
      // $net_income                     = explode(",", $net_income_list );
      // $loan_id_list                   = json_decode($loan_id_lists, true);

      // $benefits_loan_id = [];
      // foreach ($loan_id_list as $loan_id) {
      //   $benefits_loan_id[] = $this->payrolls_model->GET_ALL_LOAN_ID($loan_id);
      // }

      // if (!empty($benefits_loan_id) && is_array($benefits_loan_id)) {
      //   foreach ($benefits_loan_id as $id) {
      //     $this->payrolls_model->UPDATE_LOAN_BENEFITS($id);
      //   }
      // }

      foreach ($payslip_id as $id) {
        $this->payrolls_model->ADD_PAYSLIP_PUBLISHED($id);
      }

      $this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Published payslip');
      // redirect('payrolls/generated');

      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
    }

    function GET_IDS($id){
          // Remove square brackets from the beginning and end
          $id = trim($id, '[]');

          // Split the string into individual substrings, each representing a group of IDs
          $groups_of_ids = explode('],[', $id);
      
          $loan_ids_array = [];
      
          // Iterate through each group of IDs
          foreach ($groups_of_ids as $group_of_ids) {
            // Remove any extra spaces within the group
            $group_of_ids = trim($group_of_ids);
      
            // Split the group into individual IDs
            $loan_ids = explode(',', $group_of_ids);
      
            // Add the group of IDs to the main array
            $loan_ids_array[] = $loan_ids;
          }

          return $loan_ids_array;
    }

    function bulk_delete_payslip_published()
    {
      $payslip_ids              = $this->input->post('DELETE_PUBLISH_ID');
      $loan_id_lists            = $this->input->post('DELETE_EMPLOYEE_LOAN_LIST');
      $deduction_id_lists       = $this->input->post('DELETE_EMPLOYEE_OTHER_DEDUCTION_LIST');
      $empl_ids                 = $this->input->post('DELETE_EMPL_ID');
      $cutff_period             = $this->input->post('DELETE_CUTOFF_PERIOD');

      $payslip_id               = explode(",", $payslip_ids);
      $empl_id                  = explode(",", $empl_ids);

      $loan_ids_array = $this->GET_IDS($loan_id_lists);
      foreach ($loan_ids_array as $group_of_ids) {
        foreach ($group_of_ids as $loan_id) {
          $this->payrolls_model->DELETE_PAYSLIP_LOAN($loan_id);
        }
      }

      $deduction_ids_array = $this->GET_IDS($deduction_id_lists);
      foreach ($deduction_ids_array as $group_of_ids) {
        foreach ($group_of_ids as $deduct_id) {
          $this->payrolls_model->DELETE_PAYSLIP_OTHER_DEDUCTIONS($deduct_id);
        }
      }

      foreach ($payslip_id as $id) {
        $this->payrolls_model->DELETE_PAYSLIP_BY_ID($id);
      }

      foreach ($empl_id as $id) {
        $this->payrolls_model->delete_attendance_lock($id, $cutff_period);
      }

      $this->session->set_userdata('SESS_SUCCESS', 'Payslip Deleted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Bulk deleted published payslips');
      // redirect('payrolls/generated');

      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
    }



    function view_published_payslip()
    {
      $view_payslip_ids = $this->input->post('VIEW_PUBLISHED_PAYSLIP_ID');
      $array_view_payslip_id = explode(",", $view_payslip_ids);
      // var_dump($array_view_payslip_id);
    }
    function sss_contributions()
    {
      if (!isset($_GET["branch"])) {
        $param_branch                         = "all";
      } else {
        $param_branch                         = $_GET["branch"];
      }
      if (!isset($_GET["dept"])) {
        $param_dept                           = "all";
      } else {
        $param_dept                           = $_GET["dept"];
      }
      if (!isset($_GET["division"])) {
        $param_division                       = "all";
      } else {
        $param_division                       = $_GET["division"];
      }
      if (!isset($_GET["section"])) {
        $param_section                        = "all";
      } else {
        $param_section                        = $_GET["section"];
      }
      if (!isset($_GET["group"])) {
        $param_group                          = "all";
      } else {
        $param_group                          = $_GET["group"];
      }
      if (!isset($_GET["team"])) {
        $param_team                           = "all";
      } else {
        $param_team                           = $_GET["team"];
      }
      if (!isset($_GET["line"])) {
        $param_line                           = "all";
      } else {
        $param_line                           = $_GET["line"];
      }
      if (!isset($_GET["status"])) {
        $param_status                         = "all";
      } else {
        $param_status                         = $_GET["status"];
      }
      $data["C_ROW_DISPLAY"]                  =  [10, 25, 50, 100];
      $page                                   = $this->input->get('page');
      $row                                    = $this->input->get('row');
      if ($row == null) {
        $row = 10;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $data['DISP_EMP_LIST']                  = $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['DISP_YEARS']                     = $year_list = $this->payrolls_model->GET_YEARS();
      $data['C_DATA_COUNT']                   = $this->payrolls_model->GET_COUNT_EMPLOYEELIST();
      (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];
      $data['YEAR_INITIAL']                   = $year;
      $data["DISP_CUSTOM"]                    = $this->payrolls_model->GET_CUSTOM_SSS_CONTRIBUTION_DATA($year);
      $data['DISP_DISTINCT_DEPARTMENT']       = $this->payrolls_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
      $data['DISP_DISTINCT_DIVISION']         = $this->payrolls_model->MOD_DISP_DISTINCT_DIVISION_2();
      $data['DISP_DISTINCT_SECTION']          = $this->payrolls_model->MOD_DISP_DISTINCT_SECTION_2();
      $data['DISP_DISTINCT_BRANCH']           = $this->payrolls_model->MOD_DISP_DISTINCT_BRANCH_2();
      $data['DISP_DISTINCT_GROUP']            = $this->payrolls_model->MOD_DISP_DISTINCT_GROUP_2();
      $data['DISP_DISTINCT_TEAM']             = $this->payrolls_model->MOD_DISP_DISTINCT_TEAM_2();
      $data['DISP_DISTINCT_LINE']             = $this->payrolls_model->MOD_DISP_DISTINCT_LINE_2();
      $data['DISP_VIEW_DEPARTMENT']           = $this->payrolls_model->GET_SYSTEM_SETTING("com_Department");
      $data['DISP_VIEW_DIVISION']             = $this->payrolls_model->GET_SYSTEM_SETTING("com_division");
      $data['DISP_VIEW_SECTION']              = $this->payrolls_model->GET_SYSTEM_SETTING("com_section");
      $data['DISP_VIEW_BRANCH']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_branch");
      $data['DISP_VIEW_GROUP']                = $this->payrolls_model->GET_SYSTEM_SETTING("com_group");
      $data['DISP_VIEW_TEAM']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_team");
      $data['DISP_VIEW_LINE']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_line");
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/custom_sss_contributions_views', $data);
    }
    function pagibig_contributions()
    {
      if (!isset($_GET["branch"])) {
        $param_branch                         = "all";
      } else {
        $param_branch                         = $_GET["branch"];
      }
      if (!isset($_GET["dept"])) {
        $param_dept                           = "all";
      } else {
        $param_dept                           = $_GET["dept"];
      }
      if (!isset($_GET["division"])) {
        $param_division                       = "all";
      } else {
        $param_division                       = $_GET["division"];
      }
      if (!isset($_GET["section"])) {
        $param_section                        = "all";
      } else {
        $param_section                        = $_GET["section"];
      }
      if (!isset($_GET["group"])) {
        $param_group                          = "all";
      } else {
        $param_group                          = $_GET["group"];
      }
      if (!isset($_GET["team"])) {
        $param_team                           = "all";
      } else {
        $param_team                           = $_GET["team"];
      }
      if (!isset($_GET["line"])) {
        $param_line                           = "all";
      } else {
        $param_line                           = $_GET["line"];
      }
      if (!isset($_GET["status"])) {
        $param_status                         = "all";
      } else {
        $param_status                         = $_GET["status"];
      }
      $data["C_ROW_DISPLAY"]                  =  [10, 25, 50, 100];
      $page                                   = $this->input->get('page');
      $row                                    = $this->input->get('row');
      if ($row == null) {
        $row = 10;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $data['DISP_EMP_LIST']                  = $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['DISP_YEARS']                     = $year_list = $this->payrolls_model->GET_YEARS();
      $data['C_DATA_COUNT']                   = $this->payrolls_model->GET_COUNT_EMPLOYEELIST();
      (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];
      $data['YEAR_INITIAL']                   = $year;
      $data["DISP_CUSTOM"]                    = $this->payrolls_model->GET_CUSTOM_PAGIBIG_CONTRIBUTION_DATA($year);
      $data['DISP_DISTINCT_DEPARTMENT']       = $this->payrolls_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
      $data['DISP_DISTINCT_DIVISION']         = $this->payrolls_model->MOD_DISP_DISTINCT_DIVISION_2();
      $data['DISP_DISTINCT_SECTION']          = $this->payrolls_model->MOD_DISP_DISTINCT_SECTION_2();
      $data['DISP_DISTINCT_BRANCH']           = $this->payrolls_model->MOD_DISP_DISTINCT_BRANCH_2();
      $data['DISP_DISTINCT_GROUP']            = $this->payrolls_model->MOD_DISP_DISTINCT_GROUP_2();
      $data['DISP_DISTINCT_TEAM']             = $this->payrolls_model->MOD_DISP_DISTINCT_TEAM_2();
      $data['DISP_DISTINCT_LINE']             = $this->payrolls_model->MOD_DISP_DISTINCT_LINE_2();
      $data['DISP_VIEW_DEPARTMENT']           = $this->payrolls_model->GET_SYSTEM_SETTING("com_Department");
      $data['DISP_VIEW_DIVISION']             = $this->payrolls_model->GET_SYSTEM_SETTING("com_division");
      $data['DISP_VIEW_SECTION']              = $this->payrolls_model->GET_SYSTEM_SETTING("com_section");
      $data['DISP_VIEW_BRANCH']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_branch");
      $data['DISP_VIEW_GROUP']                = $this->payrolls_model->GET_SYSTEM_SETTING("com_group");
      $data['DISP_VIEW_TEAM']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_team");
      $data['DISP_VIEW_LINE']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_line");
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/custom_pagibig_contributions_views', $data);
    }
    function add_loans()
    {
      $data['DISP_EMPLOYEES']             = $this->payrolls_model->GET_EMPLOYEE_LIST();
      $data['LOAN_TYPES']                 = $this->payrolls_model->GET_LOAN_TYPE_DATA();

      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/add_loans_views', $data);
    }
    function insert_new_loans()
    {
      $inputs                             = $this->input->post();
      $res_new                            = $this->payrolls_model->ADD_LOAN($inputs);
      if ($res_new) {
        $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully added new loan!');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added loans');
      } else {
        $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to add new loan!');
      }
      redirect('payrolls/loans');
    }
    function philhealth_contributions()
    {
      if (!isset($_GET["branch"])) {
        $param_branch                         = "all";
      } else {
        $param_branch                         = $_GET["branch"];
      }
      if (!isset($_GET["dept"])) {
        $param_dept                           = "all";
      } else {
        $param_dept                           = $_GET["dept"];
      }
      if (!isset($_GET["division"])) {
        $param_division                       = "all";
      } else {
        $param_division                       = $_GET["division"];
      }
      if (!isset($_GET["section"])) {
        $param_section                        = "all";
      } else {
        $param_section                        = $_GET["section"];
      }
      if (!isset($_GET["group"])) {
        $param_group                          = "all";
      } else {
        $param_group                          = $_GET["group"];
      }
      if (!isset($_GET["team"])) {
        $param_team                           = "all";
      } else {
        $param_team                           = $_GET["team"];
      }
      if (!isset($_GET["line"])) {
        $param_line                           = "all";
      } else {
        $param_line                           = $_GET["line"];
      }
      if (!isset($_GET["status"])) {
        $param_status                         = "all";
      } else {
        $param_status                         = $_GET["status"];
      }
      $data["C_ROW_DISPLAY"]                  =  [10, 25, 50, 100];
      $page                                   = $this->input->get('page');
      $row                                    = $this->input->get('row');
      if ($row == null) {
        $row = 10;
      }
      if ($page  == null) {
        $page = 1;
      }
      $offset = $row * ($page - 1);
      $data['DISP_EMP_LIST']                  = $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['DISP_YEARS']                     = $year_list = $this->payrolls_model->GET_YEARS();
      $data['C_DATA_COUNT']                   = $this->payrolls_model->GET_COUNT_EMPLOYEELIST();
      (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];
      $data['YEAR_INITIAL']                   = $year;
      $data["DISP_CUSTOM"]                    = $this->payrolls_model->GET_CUSTOM_PHILHEALTH_CONTRIBUTION_DATA($year);
      $data['DISP_DISTINCT_DEPARTMENT']       = $this->payrolls_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
      $data['DISP_DISTINCT_DIVISION']         = $this->payrolls_model->MOD_DISP_DISTINCT_DIVISION_2();
      $data['DISP_DISTINCT_SECTION']          = $this->payrolls_model->MOD_DISP_DISTINCT_SECTION_2();
      $data['DISP_DISTINCT_BRANCH']           = $this->payrolls_model->MOD_DISP_DISTINCT_BRANCH_2();
      $data['DISP_DISTINCT_GROUP']            = $this->payrolls_model->MOD_DISP_DISTINCT_GROUP_2();
      $data['DISP_DISTINCT_TEAM']             = $this->payrolls_model->MOD_DISP_DISTINCT_TEAM_2();
      $data['DISP_DISTINCT_LINE']             = $this->payrolls_model->MOD_DISP_DISTINCT_LINE_2();
      $data['DISP_VIEW_DEPARTMENT']           = $this->payrolls_model->GET_SYSTEM_SETTING("com_Department");
      $data['DISP_VIEW_DIVISION']             = $this->payrolls_model->GET_SYSTEM_SETTING("com_division");
      $data['DISP_VIEW_SECTION']              = $this->payrolls_model->GET_SYSTEM_SETTING("com_section");
      $data['DISP_VIEW_BRANCH']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_branch");
      $data['DISP_VIEW_GROUP']                = $this->payrolls_model->GET_SYSTEM_SETTING("com_group");
      $data['DISP_VIEW_TEAM']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_team");
      $data['DISP_VIEW_LINE']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_line");
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/custom_philhealth_contributions_views', $data);
    }
    function process_custom_contribution($user_id, $allowance_val, $year, $type)
    {
      $response                               = $this->payrolls_model->IS_DUPLICATE_CUSTOM_CONTRIBUTION($user_id, $year, $type);
      if ($response == 0) {
        $res_insrt                            = $this->payrolls_model->ADD_USER_CUSTOM_CONTRIBUTION($user_id, $allowance_val, $year, $type);
      } else {
        $res_insrt                            = $this->payrolls_model->UPDATE_USER_CUSTOM_CONTRIBUTION($user_id, $allowance_val, $year, $type);
      }
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
    }
    function process_sss_custom_contribution($user_id, $val, $year)
    {
      $response                               = $this->payrolls_model->IS_DUPLICATE_CUSTOM_SSS_CONTRIBUTION($user_id, $year);
      if ($response == 0) {
        $res_insrt                            = $this->payrolls_model->ADD_USER_CUSTOM_SSS_CONTRIBUTION($user_id, $val, $year);
      } else {
        $res_insrt                            = $this->payrolls_model->UPDATE_USER_CUSTOM_SSS_CONTRIBUTION($user_id, $val, $year);
      }
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
    }
    function update_custom_contribution()
    {
      $empl_id                                = $this->input->post('UPDATE_ID');
      $val                                    = $this->input->post('UPDT_CUSTOM_VAL');
      $type                                   = $this->input->post('UPDT_CUSTOM_TYPE');
      $year                                   = $this->input->post('YEAR');
      $empl_ids                               = explode(",", $empl_id);
      foreach ($empl_ids as $id) {
        $result                               = $this->payrolls_model->IS_DUPLICATE_CUSTOM_CONTRIBUTION($id, $year, $type);
        if ($result == 0) {
          $this->payrolls_model->ADD_USER_CUSTOM_CONTRIBUTION($id, $val, $year, $type);
        } else {
          $this->payrolls_model->UPDATE_USER_CUSTOM_CONTRIBUTION($id, $val, $year, $type);
        }
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated contribution settings');
      redirect('payrolls/custom_contributions');
    }
    function update_sss_custom_contribution()
    {
      $empl_id                              = $this->input->post('UPDATE_ID');
      $val                                  = $this->input->post('UPDT_CUSTOM_VAL');
      $year                                 = $this->input->post('YEAR');
      $empl_ids                             = explode(",", $empl_id);
      foreach ($empl_ids as $id) {
        $result                             = $this->payrolls_model->IS_DUPLICATE_CUSTOM_SSS_CONTRIBUTION($id, $year);
        if ($result == 0) {
          $this->payrolls_model->ADD_USER_CUSTOM_SSS_CONTRIBUTION($id, $val, $year);
        } else {
          $this->payrolls_model->UPDATE_USER_CUSTOM_SSS_CONTRIBUTION($id, $val, $year);
        }
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated contribution settings');
      redirect('payrolls/sss_contributions');
    }
    function process_pagibig_custom_contribution($user_id, $val, $year)
    {
      $response                             = $this->payrolls_model->IS_DUPLICATE_CUSTOM_PAGIBIG_CONTRIBUTION($user_id, $year);
      if ($response == 0) {
        $res_insrt                          = $this->payrolls_model->ADD_USER_CUSTOM_PAGIBIG_CONTRIBUTION($user_id, $val, $year);
      } else {
        $res_insrt                          = $this->payrolls_model->UPDATE_USER_CUSTOM_PAGIBIG_CONTRIBUTION($user_id, $val, $year);
      }
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
    }
    function update_pagibig_custom_contribution()
    {
      $empl_id                              = $this->input->post('UPDATE_ID');
      $val                                  = $this->input->post('UPDT_CUSTOM_VAL');
      $year                                 = $this->input->post('YEAR');
      $empl_ids                             = explode(",", $empl_id);
      foreach ($empl_ids as $id) {
        $result                             = $this->payrolls_model->IS_DUPLICATE_CUSTOM_PAGIBIG_CONTRIBUTION($id, $year);
        if ($result == 0) {
          $this->payrolls_model->ADD_USER_CUSTOM_PAGIBIG_CONTRIBUTION($id, $val, $year);
        } else {
          $this->payrolls_model->UPDATE_USER_CUSTOM_PAGIBIG_CONTRIBUTION($id, $val, $year);
        }
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated contribution settings');
      redirect('payrolls/pagibig_contributions');
    }
    function process_philhealth_custom_contribution($user_id, $val, $year)
    {
      $response                             = $this->payrolls_model->IS_DUPLICATE_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id, $year);
      if ($response == 0) {
        $res_insrt                          = $this->payrolls_model->ADD_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id, $val, $year);
      } else {
        $res_insrt                          = $this->payrolls_model->UPDATE_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id, $val, $year);
      }
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
    }
    function update_philhealth_custom_contribution()
    {
      $empl_id                            = $this->input->post('UPDATE_ID');
      $val                                = $this->input->post('UPDT_CUSTOM_VAL');
      $year                               = $this->input->post('YEAR');
      $empl_ids                           = explode(",", $empl_id);
      foreach ($empl_ids as $id) {
        $result                           = $this->payrolls_model->IS_DUPLICATE_CUSTOM_PHILHEALTH_CONTRIBUTION($id, $year);
        if ($result == 0) {
          $this->payrolls_model->ADD_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($id, $val, $year);
        } else {
          $this->payrolls_model->UPDATE_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($id, $val, $year);
        }
      }
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated contribution settings');
      redirect('payrolls/philhealth_contributions');
    }
    function open_bir_form2316()
    {
      $this->load->library('pdf');
      $pdf = $this->pdf->OpenExistingPDF('./assets_system/forms/form_bir316.pdf');
      $pdf->Output();
    }
    function generator()
    {
      //---------------------------- URI VARIABLES --
      $period                                 = $this->input->get('period');
      $employee                               = $this->input->get('employee');
      $en_sss                                 = $this->input->get('sss');
      $en_phil                                = $this->input->get('phil');
      $en_pagibig                             = $this->input->get('pagibig');
      $en_wtax                                = $this->input->get('wtax');
      $en_ti                                  = $this->input->get('ti');
      $en_nti                                 = $this->input->get('nti');
      $en_td                                  = $this->input->get('td');
      $en_ntd                                 = $this->input->get('ntd');
      $en_loan                                = $this->input->get('loans');
      $en_absut                               = $this->input->get('absut');
      //---------------------------- CHECKBOX DEFAULT VALUES --
      if ($en_sss == null) {
        $en_sss = 1;
      }
      if ($en_phil == null) {
        $en_phil = 1;
      }
      if ($en_pagibig == null) {
        $en_pagibig = 1;
      }
      if ($en_wtax == null) {
        $en_wtax = 1;
      }
      if ($en_ti == null) {
        $en_ti = 1;
      }
      if ($en_nti == null) {
        $en_nti = 1;
      }
      if ($en_td == null) {
        $en_td = 1;
      }
      if ($en_ntd == null) {
        $en_ntd = 1;
      }
      if ($en_loan == null) {
        $en_loan = 1;
      }
      if ($en_absut == null) {
        $en_absut = 1;
      }
      //---------------------------- INITIAL DECLARATION --
      $sss_ee_prev_1 = 0;
      $pagibig_ee_prev_1 = 0;
      $philhealth_ee_prev_1 = 0;
      $sss_er_prev_1 = 0;
      $sss_ec_er_prev_1 = 0;
      $pagibig_er_prev_1 = 0;
      $philhealth_er_prev_1 = 0;
      $sss_ee_prev_2 = 0;
      $pagibig_ee_prev_2 = 0;
      $philhealth_ee_prev_2 = 0;
      $sss_er_prev_2 = 0;
      $sss_ec_er_prev_2 = 0;
      $pagibig_er_prev_2 = 0;
      $philhealth_er_prev_2 = 0;
      $sss_ee_prev_3 = 0;
      $pagibig_ee_prev_3 = 0;
      $philhealth_ee_prev_3 = 0;
      $sss_er_prev_3 = 0;
      $sss_ec_er_prev_3 = 0;
      $pagibig_er_prev_3 = 0;
      $philhealth_er_prev_3 = 0;
      $sss_ee_prev_4 = 0;
      $pagibig_ee_prev_4 = 0;
      $philhealth_ee_prev_4 = 0;
      $sss_er_prev_4 = 0;
      $sss_ec_er_prev_4 = 0;
      $pagibig_er_prev_4 = 0;
      $philhealth_er_prev_4 = 0;
      $sss_ee_prev_5 = 0;
      $pagibig_ee_prev_5 = 0;
      $philhealth_ee_prev_5 = 0;
      $sss_er_prev_5 = 0;
      $sss_ec_er_prev_5 = 0;
      $pagibig_er_prev_5 = 0;
      $philhealth_er_prev_5 = 0;
      //---------------------------- PAYROLL PERIOD ---------------------------------------------
      $payroll_list                           = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
      if ($period == null && !empty($payroll_list)) {
        $period = $payroll_list[0]->period;
      }
      $employee_list                          = $this->payrolls_model->GET_EMPLOYEE_LIST_LOCK($period);
      $period_year                            = $this->payrolls_model->GET_PERIOD_YEAR($period);
      $pay_frequency                          = $this->payrolls_model->GET_PERIOD_FREQUENCY($period);
      if (!$period_year) {
        $period_year = 0;
      } else {
        $period_year = $period_year->years;
      }
      if ($pay_frequency) {
        $pay_frequency = $pay_frequency->pay_frequency;
      } else {
        $pay_frequency = 0;
      }
      $data['PAYROLL_CONTRIBUTION']           = $this->payrolls_model->GET_PAYROLL_SCHEDULE_CONTRIBUTION($period);
      //---------------------------- CONNECTED PAYROLLS ---------------------------------------------
      $period_connected                       = $this->payrolls_model->GET_PERIOD_CONNECTED($period);
      $connected_1 = 0;
      $connected_2 = 0;
      $connected_3 = 0;
      $connected_4 = 0;
      $connected_5 = 0;
      if (count($period_connected) > 0) {
        $connected_1 = $period_connected[0]->connected_period;
        $connected_2 = $period_connected[0]->connected_period_2;
        $connected_3 = $period_connected[0]->connected_period_3;
        $connected_4 = $period_connected[0]->connected_period_4;
        $connected_5 = $period_connected[0]->connected_period_5;
      }
      if ($connected_1 != "0") {
        $connected_1_name = $this->payrolls_model->GET_PERIOD_NAME($connected_1);
      } else {
        $connected_1_name = "";
      }
      if ($connected_2 != "0") {
        $connected_2_name = $this->payrolls_model->GET_PERIOD_NAME($connected_2);
      } else {
        $connected_2_name = "";
      }
      if ($connected_3 != "0") {
        $connected_3_name = $this->payrolls_model->GET_PERIOD_NAME($connected_3);
      } else {
        $connected_3_name = "";
      }
      if ($connected_4 != "0") {
        $connected_4_name = $this->payrolls_model->GET_PERIOD_NAME($connected_4);
      } else {
        $connected_4_name = "";
      }
      if ($connected_5 != "0") {
        $connected_5_name = $this->payrolls_model->GET_PERIOD_NAME($connected_5);
      } else {
        $connected_5_name = "";
      }
      if ($employee == null && !empty($employee_list)) {
        $employee =  $employee_list[0]->empl_id;
      }
      if ($employee == 'null' && !empty($employee_list)) {
        $employee =  $employee_list[0]->empl_id;
      }
      $employee_specific                  = $this->payrolls_model->GET_EMPLOYEE_INFO_SPECIFIC($employee);
      $ID_SSS                             = isset($employee_specific[0]->col_empl_sssc) ? $employee_specific[0]->col_empl_sssc : 0;
      $ID_PAGIBIG                         = isset($employee_specific[0]->col_empl_hdmf) ? $employee_specific[0]->col_empl_hdmf : 0;
      $ID_PHILHEALTH                      = isset($employee_specific[0]->col_empl_phil) ? $employee_specific[0]->col_empl_phil : 0;
      $ID_TIN                             = isset($employee_specific[0]->col_empl_btin) ? $employee_specific[0]->col_empl_btin : 0;
      $data['DISP_EMPLOYEE_NAME']         = isset($employee_specific[0]->col_last_name) ? $employee_specific[0]->col_last_name : 0;
      $data['DISP_EMPLOYEE_INFO']         = $employee_info        = $this->payrolls_model->GET_EMPLOYEE_INFO();
      $data['DISP_PERIOD_INFO']           = $period_info          = $this->payrolls_model->GET_PERIOD_INFO();
      $data['DISP_PAYROLL_INFO']          = $this->payrolls_model->MOD_DISP_PAYROLL();
      $data['DISP_OTHER_TAXABLE_INCOME']  = $this->payrolls_model->MOD_DISP_OTHERTAXABLEINCOME();
      $data['DISP_NON_TAXABLE_INCOME']    = $this->payrolls_model->MOD_DISP_NONTAXABLEINCOME();
      $data['DISP_ADJUSTMENTS']           = $this->payrolls_model->GET_STD_ADJUSTMENTS();
      $data['DISP_PAYROLL_PERIOD']        = $this->input->post('date_period');
      $data['DISP_EMPLOYEE_ID']           = $this->input->get('employee_id');
      $loan_user_all    = $this->payrolls_model->GET_PAYROLL_LOAN_DATA_EMPL($employee);
      // $ca_user_all      = $this->payrolls_model->GET_PAYROLL_CA_DATA_EMPL($employee);
      // $deduct_user_all  = $this->payrolls_model->GET_PAYROLL_DEDUCT_DATA_EMPL($employee);
      $loan_total   = 0;
      $ca_total     = 0;
      $deduct_total = 0;
      if (!empty($loan_user_all)) {
        foreach ($loan_user_all as $loan_user_all_row) {
          $loan_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_LOAN_ID($loan_user_all_row->id);
          $loan_contrib                   = (float)$loan_user_all_row->loan_amount / $loan_user_all_row->loan_terms;
          $loan_user_all_row->contrib     = number_format($loan_contrib, 2);
          $loan_total                     = $loan_total + $loan_contrib;
        }
      }
      // if(!empty($ca_user_all)){
      //   foreach ($ca_user_all as $ca_user_all_row) {
      //     $ca_user_all_row->paid_count    = $this->payrolls_model->GET_COUNT_CA_ID($ca_user_all_row->id);
      //     $ca_contrib                     = 0;
      //     $ca_user_all_row->contrib       = number_format($ca_contrib,2);
      //     $ca_total                       = $ca_total + $ca_contrib;
      //   }
      // }
      // if(!empty($deduct_user_all)){
      //   foreach ($deduct_user_all as $deduct_user_all_row) {
      //     $deduct_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_DEDUCT_ID($deduct_user_all_row->id);
      //     $deduct_contrib                   = 0;
      //     $deduct_user_all_row->contrib     = number_format($deduct_contrib,2);
      //     $deduct_total                     = $deduct_total + $deduct_contrib;
      //   }
      // }
      if ($en_loan == 0) {
        $loan_total = 0;
      }
      $loancadeduct_total                   = $loan_total + $ca_total + $deduct_total;
      $data['DISP_LOAN']                    = $loan_user_all;
      $data['DISP_CA']                      = $ca_user_all;
      $data['DISP_DEDUCT']                  = $deduct_user_all;
      $string_loan = str_replace('"', '@', json_encode($loan_user_all));
      $string_ca = ""; /*str_replace('"', '@', json_encode($ca_user_all));*/
      $string_deduct = ""; /*str_replace('"', '@', json_encode($deduct_user_all));*/
      $data['DISP_LOAN_STRING']             = $string_loan;
      $data['DISP_CA_STRING']               = $string_ca;
      $data['DISP_DEDUCT_STRING']           =  $string_deduct;
      $data['DISP_LOANCADED_TOTAL']         = number_format($loancadeduct_total, 2);
      if ($connected_1 == 0) {
        $gross_income_prev_1 = 0;
      } else {
        $connected_data_previous_1          = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($employee, $connected_1);
        if (empty($connected_data_previous_1)) {
          $gross_income_prev_1  = 0;
          $sss_ee_prev_1        = 0;
          $pagibig_ee_prev_1    = 0;
          $philhealth_ee_prev_1 = 0;
          $sss_er_prev_1        = 0;
          $sss_ec_er_prev_1     = 0;
          $pagibig_er_prev_1    = 0;
          $philhealth_er_prev_1 = 0;
        } else {
          $gross_income_prev_1    = isset($connected_data_previous_1->GROSS_INCOME)             ? $connected_data_previous_1->GROSS_INCOME : 0;
          $sss_ee_prev_1          = isset($connected_data_previous_1->SSS_EE_CURRENT)           ? $connected_data_previous_1->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_1      = isset($connected_data_previous_1->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_1->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_1   = isset($connected_data_previous_1->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_1->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_1          = isset($connected_data_previous_1->SSS_ER_CURRENT)        ? $connected_data_previous_1->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_1       = isset($connected_data_previous_1->SSS_EC_ER_CURRENT)     ? $connected_data_previous_1->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_1      = isset($connected_data_previous_1->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_1->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_1   = isset($connected_data_previous_1->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_1->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_2 == 0) {
        $gross_income_prev_2 = 0;
      } else {
        $connected_data_previous_2 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($employee, $connected_2);
        if (empty($connected_data_previous_2)) {
          $gross_income_prev_2  = 0;
          $sss_ee_prev_2        = 0;
          $pagibig_ee_prev_2    = 0;
          $philhealth_ee_prev_2 = 0;
          $sss_er_prev_2        = 0;
          $sss_ec_er_prev_2     = 0;
          $pagibig_er_prev_2    = 0;
          $philhealth_er_prev_2 = 0;
        } else {
          $gross_income_prev_2    = isset($connected_data_previous_2->GROSS_INCOME)             ? $connected_data_previous_2->GROSS_INCOME : 0;
          $sss_ee_prev_2          = isset($connected_data_previous_2->SSS_EE_CURRENT)           ? $connected_data_previous_2->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_2      = isset($connected_data_previous_2->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_2->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_2   = isset($connected_data_previous_2->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_2->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_2          = isset($connected_data_previous_2->SSS_ER_CURRENT)        ? $connected_data_previous_2->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_2       = isset($connected_data_previous_2->SSS_EC_ER_CURRENT)     ? $connected_data_previous_2->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_2      = isset($connected_data_previous_2->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_2->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_2   = isset($connected_data_previous_2->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_2->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_3 == 0) {
        $gross_income_prev_3 = 0;
      } else {
        $connected_data_previous_3 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($employee, $connected_3);
        if (empty($connected_data_previous_3)) {
          $gross_income_prev_3  = 0;
          $sss_ee_prev_3        = 0;
          $pagibig_ee_prev_3    = 0;
          $philhealth_ee_prev_3 = 0;
          $sss_er_prev_3        = 0;
          $sss_ec_er_prev_3     = 0;
          $pagibig_er_prev_3    = 0;
          $philhealth_er_prev_3 = 0;
        } else {
          $gross_income_prev_3    = isset($connected_data_previous_3->GROSS_INCOME)             ? $connected_data_previous_3->GROSS_INCOME : 0;
          $sss_ee_prev_3          = isset($connected_data_previous_3->SSS_EE_CURRENT)           ? $connected_data_previous_3->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_3      = isset($connected_data_previous_3->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_3->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_3   = isset($connected_data_previous_3->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_3->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_3          = isset($connected_data_previous_3->SSS_ER_CURRENT)        ? $connected_data_previous_3->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_3       = isset($connected_data_previous_3->SSS_EC_ER_CURRENT)     ? $connected_data_previous_3->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_3      = isset($connected_data_previous_3->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_3->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_3   = isset($connected_data_previous_3->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_3->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_4 == 0) {
        $gross_income_prev_4 = 0;
      } else {
        $connected_data_previous_4 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($employee, $connected_4);
        if (empty($connected_data_previous_4)) {
          $gross_income_prev_4  = 0;
          $sss_ee_prev_4        = 0;
          $pagibig_ee_prev_4    = 0;
          $philhealth_ee_prev_4 = 0;
          $sss_er_prev_4        = 0;
          $sss_ec_er_prev_4     = 0;
          $pagibig_er_prev_4    = 0;
          $philhealth_er_prev_4 = 0;
        } else {
          $gross_income_prev_4    = isset($connected_data_previous_4->GROSS_INCOME)             ? $connected_data_previous_4->GROSS_INCOME : 0;
          $sss_ee_prev_4          = isset($connected_data_previous_4->SSS_EE_CURRENT)           ? $connected_data_previous_4->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_4      = isset($connected_data_previous_4->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_4->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_4   = isset($connected_data_previous_4->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_4->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_4          = isset($connected_data_previous_4->SSS_ER_CURRENT)        ? $connected_data_previous_4->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_4       = isset($connected_data_previous_4->SSS_EC_ER_CURRENT)     ? $connected_data_previous_4->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_4      = isset($connected_data_previous_4->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_4->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_4   = isset($connected_data_previous_4->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_4->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      if ($connected_5 == 0) {
        $gross_income_prev_5 = 0;
      } else {
        $connected_data_previous_5 = $this->payrolls_model->GET_CONNECTED_PERIOD_PREVIOUS($employee, $connected_5);
        if (empty($connected_data_previous_5)) {
          $gross_income_prev_5  = 0;
          $sss_ee_prev_5        = 0;
          $pagibig_ee_prev_5    = 0;
          $philhealth_ee_prev_5 = 0;
          $sss_er_prev_5        = 0;
          $sss_ec_er_prev_5     = 0;
          $pagibig_er_prev_5    = 0;
          $philhealth_er_prev_5 = 0;
        } else {
          $gross_income_prev_5    = isset($connected_data_previous_5->GROSS_INCOME)             ? $connected_data_previous_5->GROSS_INCOME : 0;
          $sss_ee_prev_5          = isset($connected_data_previous_5->SSS_EE_CURRENT)           ? $connected_data_previous_5->SSS_EE_CURRENT : 0;
          $pagibig_ee_prev_5      = isset($connected_data_previous_5->PHILHEALTH_EE_CURRENT)    ? $connected_data_previous_5->PHILHEALTH_EE_CURRENT : 0;
          $philhealth_ee_prev_5   = isset($connected_data_previous_5->PAGIBIG_EE_CURRENT)       ? $connected_data_previous_5->PAGIBIG_EE_CURRENT : 0;
          $sss_er_prev_5          = isset($connected_data_previous_5->SSS_ER_CURRENT)        ? $connected_data_previous_5->SSS_ER_CURRENT : 0;
          $sss_ec_er_prev_5       = isset($connected_data_previous_5->SSS_EC_ER_CURRENT)     ? $connected_data_previous_5->SSS_EC_ER_CURRENT : 0;
          $pagibig_er_prev_5      = isset($connected_data_previous_5->PAGIBIG_ER_CURRENT)    ? $connected_data_previous_5->PAGIBIG_ER_CURRENT : 0;
          $philhealth_er_prev_5   = isset($connected_data_previous_5->PHILHEALTH_ER_CURRENT) ? $connected_data_previous_5->PHILHEALTH_ER_CURRENT : 0;
        }
      }
      $DISP_ATTENDANCE_LOCK =  isset(($this->payrolls_model->GET_ATTENDANCE_LOCK($employee, $period))[0]) ? ($this->payrolls_model->GET_ATTENDANCE_LOCK($employee, $period))[0] : 0;
      $ini_empl_cmid        = !empty($employee_specific) ? $employee_specific[0]->col_empl_cmid : 0;
      $ini_empl_name        = !empty($employee_specific) ? $employee_specific[0]->col_last_name . ', ' . $employee_specific[0]->col_last_name : 0;
      $ini_salary_rate      = !empty($employee_specific) ? $employee_specific[0]->salary_rate : 0;
      $ini_salary_type      = !empty($employee_specific) ? $employee_specific[0]->salary_type : 0;
      if ($ini_salary_type == "Daily") {
        $daily_salary       =  $ini_salary_rate;
        $hourly_salary      = $daily_salary / 8;
      } else {
        $payroll_monthly_cons = $this->payrolls_model->GET_PAYROLL_MONTHLY_CONSTANT();
        $daily_salary       =  $ini_salary_rate * 12 / $payroll_monthly_cons;
        $hourly_salary      = $daily_salary / 8;
      }
      $count_present        = isset($DISP_ATTENDANCE_LOCK->present) ? $DISP_ATTENDANCE_LOCK->present : 0;
      $count_absent         = isset($DISP_ATTENDANCE_LOCK->absent) ? $DISP_ATTENDANCE_LOCK->absent : 0;
      $count_tardiness      = isset($DISP_ATTENDANCE_LOCK->tardiness) ? $DISP_ATTENDANCE_LOCK->tardiness : 0;
      $count_undertime      = isset($DISP_ATTENDANCE_LOCK->undertime) ? $DISP_ATTENDANCE_LOCK->undertime : 0;
      $count_paid_leave     = isset($DISP_ATTENDANCE_LOCK->paid_leave) ? $DISP_ATTENDANCE_LOCK->paid_leave : 0;
      $count_reg_hours      = isset($DISP_ATTENDANCE_LOCK->reg_hours) ? $DISP_ATTENDANCE_LOCK->reg_hours : 0;
      $count_reg_ot         = isset($DISP_ATTENDANCE_LOCK->reg_ot) ? $DISP_ATTENDANCE_LOCK->reg_ot : 0;
      $count_reg_nd         = isset($DISP_ATTENDANCE_LOCK->reg_nd) ? $DISP_ATTENDANCE_LOCK->reg_nd : 0;
      $count_reg_ndot       = isset($DISP_ATTENDANCE_LOCK->reg_ndot) ? $DISP_ATTENDANCE_LOCK->reg_ndot : 0;
      $count_rest_hours     = isset($DISP_ATTENDANCE_LOCK->rest_hours) ? $DISP_ATTENDANCE_LOCK->rest_hours : 0;
      $count_rest_ot        = isset($DISP_ATTENDANCE_LOCK->rest_ot) ? $DISP_ATTENDANCE_LOCK->rest_ot : 0;
      $count_rest_nd        = isset($DISP_ATTENDANCE_LOCK->rest_nd) ? $DISP_ATTENDANCE_LOCK->rest_nd : 0;
      $count_rest_ndot      = isset($DISP_ATTENDANCE_LOCK->rest_ndot) ? $DISP_ATTENDANCE_LOCK->rest_ndot : 0;
      $count_leg_hours      = isset($DISP_ATTENDANCE_LOCK->leg_hours) ? $DISP_ATTENDANCE_LOCK->leg_hours : 0;
      $count_leg_ot         = isset($DISP_ATTENDANCE_LOCK->leg_ot) ? $DISP_ATTENDANCE_LOCK->leg_ot : 0;
      $count_leg_nd         = isset($DISP_ATTENDANCE_LOCK->leg_nd) ? $DISP_ATTENDANCE_LOCK->leg_nd : 0;
      $count_leg_ndot       = isset($DISP_ATTENDANCE_LOCK->leg_ndot) ? $DISP_ATTENDANCE_LOCK->leg_ndot : 0;
      $count_legrest_hours  = isset($DISP_ATTENDANCE_LOCK->legrest_hours) ? $DISP_ATTENDANCE_LOCK->legrest_hours : 0;
      $count_legrest_ot     = isset($DISP_ATTENDANCE_LOCK->legrest_ot) ? $DISP_ATTENDANCE_LOCK->legrest_ot : 0;
      $count_legrest_nd     = isset($DISP_ATTENDANCE_LOCK->legrest_nd) ? $DISP_ATTENDANCE_LOCK->legrest_nd : 0;
      $count_legrest_ndot   = isset($DISP_ATTENDANCE_LOCK->legrest_ndot) ? $DISP_ATTENDANCE_LOCK->legrest_ndot : 0;
      $count_spe_hours      = isset($DISP_ATTENDANCE_LOCK->spe_hours) ? $DISP_ATTENDANCE_LOCK->spe_hours : 0;
      $count_spe_ot         = isset($DISP_ATTENDANCE_LOCK->spe_ot) ? $DISP_ATTENDANCE_LOCK->spe_ot : 0;
      $count_spe_nd         = isset($DISP_ATTENDANCE_LOCK->spe_nd) ? $DISP_ATTENDANCE_LOCK->spe_nd : 0;
      $count_spe_ndot       = isset($DISP_ATTENDANCE_LOCK->spe_ndot) ? $DISP_ATTENDANCE_LOCK->spe_ndot : 0;
      $count_sperest_hours  = isset($DISP_ATTENDANCE_LOCK->sperest_hours) ? $DISP_ATTENDANCE_LOCK->sperest_hours : 0;
      $count_sperest_ot     = isset($DISP_ATTENDANCE_LOCK->sperest_ot) ? $DISP_ATTENDANCE_LOCK->sperest_ot : 0;
      $count_sperest_nd     = isset($DISP_ATTENDANCE_LOCK->sperest_nd) ? $DISP_ATTENDANCE_LOCK->sperest_nd : 0;
      $count_sperest_ndot   = isset($DISP_ATTENDANCE_LOCK->sperest_ndot) ? $DISP_ATTENDANCE_LOCK->sperest_ndot : 0;

      //-----------------TAXABLE ALLOWANCES---------------
      // $tax_allowance_list         = $this->payrolls_model->GET_STD_TAX_ALLOWANCE_LIST();
      // $tax_allowance_total        = 0;
      // foreach ($tax_allowance_list as $tax_list_row) {
      //   $tax_allow_id             = $tax_list_row->id;
      //   $tax_allow_type           = $tax_list_row->type;
      //   $tax_list_row->value      = number_format((float)$this->payrolls_model->GET_TAX_ALLOWANCE_EMPL($tax_allow_id, $employee), 2);
      //   if ($tax_allow_type == "Attendance") {
      //     $tax_list_row->count    = $count_present;
      //     $tax_list_row->subtotal = number_format((float)$tax_list_row->value * $tax_list_row->count, 2);
      //   } else {
      //     $tax_list_row->count    = '-';
      //     $tax_list_row->subtotal = number_format((float)$tax_list_row->value, 2);
      //   }
      //   $tax_allowance_total      = $tax_allowance_total + $tax_list_row->subtotal;
      // }
      //-----------------NON-TAXABLE ALLOWANCES---------------
      // $nontax_allowance_list    = $this->payrolls_model->GET_STD_NONTAX_ALLOWANCE_LIST();
      // $nontax_allowance_total   = 0;
      // foreach ($nontax_allowance_list as $nontax_list_row) {
      //   $nontax_allow_id        = $nontax_list_row->id;
      //   $nontax_allow_type      = $nontax_list_row->type;
      //   $nontax_list_row->value = $this->payrolls_model->GET_NONTAX_ALLOWANCE_EMPL($nontax_allow_id, $employee);
      //   if ($nontax_allow_type == "Attendance") {
      //     $nontax_list_row->count     = $count_present;
      //     $nontax_list_row->subtotal  = floatval($nontax_list_row->value) * floatval($nontax_list_row->count);
      //   } else {
      //     $nontax_list_row->count     = '-';
      //     $nontax_list_row->subtotal  = floatval($nontax_list_row->value);
      //   }
      //   $nontax_allowance_total       = $nontax_allowance_total + $nontax_list_row->subtotal;
      // }

      //--------------------------------------------------------
      if ($en_ti == 0) {
        $tax_allowance_total = 0;
      }
      if ($en_nti == 0) {
        $nontax_allowance_total = 0;
      }
      //--------------------------------------------------------
      $mul_present        = 1;
      $mul_absent         = 1;
      $mul_tardiness      = 1;
      $mul_undertime      = 1;
      $mul_paid_leave     = 1;
      $mul_reg_hours      = 1;
      $mul_reg_ot         = 1.25;
      $mul_reg_nd         = 0.1;
      $mul_reg_ndot       = 1.375;
      $mul_rest_hours     = 1.3;
      $mul_rest_ot        = 1.69;
      $mul_rest_nd        = 1.43;
      $mul_rest_ndot      = 1.859;
      $mul_leg_hours      = 1;
      $mul_leg_ot         = 2.6;
      $mul_leg_nd         = 1.2;
      $mul_leg_ndot       = 2.860;
      $mul_legrest_hours  = 2.6;
      $mul_legrest_ot     = 3.38;
      $mul_legrest_nd     = 2.86;
      $mul_legrest_ndot   = 3.718;
      $mul_spe_hours      = 0.3;
      $mul_spe_ot         = 1.69;
      $mul_spe_nd         = 0.43;
      $mul_spe_ndot       = 1.859;
      $mul_sperest_hours  = 1.5;
      $mul_sperest_ot     = 1.95;
      $mul_sperest_nd     = 1.65;
      $mul_sperest_ndot   = 2.145;
      $tot_present        = $ini_salary_rate / 2;
      if ($ini_salary_type == "Daily") {
        $tot_present = 0;
      } else {
        $count_reg_hours = 0;
      }
      $tot_absent         = $hourly_salary * $mul_absent        * $count_absent;
      $tot_tardiness      = $hourly_salary * $mul_tardiness     * $count_tardiness;
      $tot_undertime      = $hourly_salary * $mul_undertime     * $count_undertime;
      $tot_paid_leave     = $hourly_salary * $mul_paid_leave    * $count_paid_leave;
      $tot_reg_hours      = $hourly_salary * $mul_reg_hours     * $count_reg_hours;
      $tot_reg_ot         = $hourly_salary * $mul_reg_ot        * $count_reg_ot;
      $tot_reg_nd         = $hourly_salary * $mul_reg_nd        * $count_reg_nd;
      $tot_reg_ndot       = $hourly_salary * $mul_reg_ndot      * $count_reg_ndot;
      $tot_rest_hours     = $hourly_salary * $mul_rest_hours    * $count_rest_hours;
      $tot_rest_ot        = $hourly_salary * $mul_rest_ot       * $count_rest_ot;
      $tot_rest_nd        = $hourly_salary * $mul_rest_nd       * $count_rest_nd;
      $tot_rest_ndot      = $hourly_salary * $mul_rest_ndot     * $count_rest_ndot;
      $tot_leg_hours      = $hourly_salary * $mul_leg_hours     * $count_leg_hours;
      $tot_leg_ot         = $hourly_salary * $mul_leg_ot        * $count_leg_ot;
      $tot_leg_nd         = $hourly_salary * $mul_leg_nd        * $count_leg_nd;
      $tot_leg_ndot       = $hourly_salary * $mul_leg_ndot      * $count_leg_ndot;
      $tot_legrest_hours  = $hourly_salary * $mul_legrest_hours * $count_legrest_hours;
      $tot_legrest_ot     = $hourly_salary * $mul_legrest_ot    * $count_legrest_ot;
      $tot_legrest_nd     = $hourly_salary * $mul_legrest_nd    * $count_legrest_nd;
      $tot_legrest_ndot   = $hourly_salary * $mul_legrest_ndot  * $count_legrest_ndot;
      $tot_spe_hours      = $hourly_salary * $mul_spe_hours     * $count_spe_hours;
      $tot_spe_ot         = $hourly_salary * $mul_spe_ot        * $count_spe_ot;
      $tot_spe_nd         = $hourly_salary * $mul_spe_nd        * $count_spe_nd;
      $tot_spe_ndot       = $hourly_salary * $mul_spe_ndot      * $count_spe_ndot;
      $tot_sperest_hours  = $hourly_salary * $mul_sperest_hours * $count_sperest_hours;
      $tot_sperest_ot     = $hourly_salary * $mul_sperest_ot    * $count_sperest_ot;
      $tot_sperest_nd     = $hourly_salary * $mul_sperest_nd    * $count_sperest_nd;
      $tot_sperest_ndot   = $hourly_salary * $mul_sperest_ndot  * $count_sperest_ndot;
      if ($en_absut == 0) {
        $tot_tardiness = 0;
      }
      if ($ini_salary_type == "Daily") {
        $payroll_monthly_cons = $this->payrolls_model->GET_PAYROLL_MONTHLY_CONSTANT();
        $basic_income = $daily_salary * $payroll_monthly_cons / 12 / 2;
      } else {
        $basic_income = $tot_present;
      }
      // $basic_income           = $tot_present  + $tot_paid_leave + $tot_reg_hours + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $basic_pay              = $tot_present + $tot_reg_hours + $tot_paid_leave + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $basic_deduction        = $tot_absent + $tot_tardiness + $tot_undertime;
      $gross_income           = $tot_present + $tot_reg_hours + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $gross_income           = $gross_income + $tot_paid_leave;
      $gross_income           = $gross_income - $basic_deduction;
      $gross_income           = $gross_income + $tax_allowance_total + $nontax_allowance_total;
      $gross_income_total     = $gross_income + $gross_income_prev_1 + $gross_income_prev_2 + $gross_income_prev_3 + $gross_income_prev_4 + $gross_income_prev_5;
      $sss_ee_current         = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ee) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ee : 0;
      $sss_er_current         = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->er) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->er : 0;
      $sss_ec_er_current      = isset(($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ec_er) ? ($this->payrolls_model->GET_SSS_VALUE($gross_income_total))[0]->ec_er : 0;
      if ($basic_income >= 5000) {
        $pagibig_ee_current     = 100;
        $pagibig_er_current     = 100;
      } else {
        $pagibig_ee_current     = $basic_income * 0.02;
        $pagibig_er_current     = $basic_income * 0.02;
      }
      $philhealth_data        = isset(($this->payrolls_model->GET_PHILHEALTH_VALUE())[0]) ? ($this->payrolls_model->GET_PHILHEALTH_VALUE())[0] : 0;
      $philhealth_rate        = isset($philhealth_data->rate) ? $philhealth_data->rate : 0;
      $philhealth_min_basic   = isset($philhealth_data->min_basic) ? $philhealth_data->min_basic : 0;
      $philhealth_max_basic   = isset($philhealth_data->max_basic) ? $philhealth_data->max_basic : 0;
      $philhealth_min_premium = isset($philhealth_data->min_premium) ? $philhealth_data->min_premium : 0;
      $philhealth_max_premium = isset($philhealth_data->max_premium) ? $philhealth_data->max_premium : 0;
      if ($basic_income <= $philhealth_min_basic) {
        $philhealth_ee_current = $philhealth_min_premium / 2;
        $philhealth_er_current = $philhealth_min_premium / 2;
      } else if ($basic_income >= $philhealth_max_basic) {
        $philhealth_ee_current = $philhealth_max_premium / 2;
        $philhealth_er_current = $philhealth_max_premium / 2;
      } else {
        $philhealth_ee_current = ($basic_income * ($philhealth_rate / 100)) / 2;
        $philhealth_er_current = ($basic_income * ($philhealth_rate / 100)) / 2;
      }
      $sss_ee_diff = $sss_ee_current - $sss_ee_prev_1 - $sss_ee_prev_2 - $sss_ee_prev_3 - $sss_ee_prev_4 - $sss_ee_prev_5;
      $pagibig_ee_diff = $pagibig_ee_current - $pagibig_ee_prev_1 - $pagibig_ee_prev_2 - $pagibig_ee_prev_3 - $pagibig_ee_prev_4 - $pagibig_ee_prev_5;
      $philhealth_ee_diff = $philhealth_ee_current - $philhealth_ee_prev_1 - $philhealth_ee_prev_2 - $philhealth_ee_prev_3 - $philhealth_ee_prev_4 - $philhealth_ee_prev_5;
      $sss_er_diff = $sss_er_current - $sss_er_prev_1 - $sss_er_prev_2 - $sss_er_prev_3 - $sss_er_prev_4 - $sss_er_prev_5;
      $sss_ec_er_diff = $sss_ec_er_current - $sss_ec_er_prev_1 - $sss_ec_er_prev_2 - $sss_ec_er_prev_3 - $sss_ec_er_prev_4 - $sss_ec_er_prev_5;
      $pagibig_er_diff = $pagibig_er_current - $pagibig_er_prev_1 - $pagibig_er_prev_2 - $pagibig_er_prev_3 - $pagibig_er_prev_4 - $pagibig_er_prev_5;
      $philhealth_er_diff = $philhealth_er_current - $philhealth_er_prev_1 - $philhealth_er_prev_2 - $philhealth_er_prev_3 - $philhealth_er_prev_4 - $philhealth_er_prev_5;
      if ($en_sss == 0) {
        $sss_ee_diff = 0;
        $sss_er_diff = 0;
        $sss_ec_er_diff = 0;
      }
      if ($en_pagibig == 0) {
        $pagibig_ee_diff = 0;
        $pagibig_er_diff = 0;
      }
      if ($en_phil == 0) {
        $philhealth_ee_diff = 0;
        $philhealth_er_diff = 0;
      }
      $taxable_income           = $tot_present + $tot_reg_hours + $tot_reg_ot + $tot_reg_nd + $tot_reg_ndot  + $tot_rest_hours + $tot_rest_ot + $tot_rest_nd + $tot_rest_ndot + $tot_leg_hours + $tot_leg_ot + $tot_leg_nd + $tot_leg_ndot  + $tot_legrest_hours + $tot_legrest_ot + $tot_legrest_nd + $tot_legrest_ndot + $tot_spe_hours + $tot_spe_ot + $tot_spe_nd + $tot_spe_ndot  + $tot_sperest_hours + $tot_sperest_ot + $tot_sperest_nd + $tot_sperest_ndot;
      $taxable_income           = $taxable_income + $tot_paid_leave;
      $taxable_income           = $taxable_income - ($tot_absent + $tot_tardiness + $tot_undertime);
      $taxable_income           = $taxable_income + $tax_allowance_total;
      $taxable_income           = $taxable_income - ($sss_ee_diff + $philhealth_ee_diff + $pagibig_ee_diff);
      $wtax_raw = $this->payrolls_model->GET_TAX_VALUE($taxable_income);
      $wtax_salary_min      = 0;
      $wtax_salary_max      = 0;
      $wtax_salary_fixed    = 0;
      $wtax_salary_clevel   = 0;
      $wtax_salary_cpercent = 0;
      if ($wtax_raw) {
        $wtax_salary_min      = $wtax_raw["salary_min"];
        $wtax_salary_max      = $wtax_raw["salary_max"];
        $wtax_salary_fixed    = $wtax_raw["fixed"];
        $wtax_salary_clevel   = $wtax_raw["c_level"];
        $wtax_salary_cpercent = $wtax_raw["c_percent"];
      }
      $wtax = $wtax_salary_fixed + ($taxable_income - $wtax_salary_clevel) * $wtax_salary_cpercent / 100;
      if ($en_wtax == 0) {
        $wtax = 0;
      }
      $ee_current_total     = $sss_ee_current + $pagibig_ee_current + $philhealth_ee_current;
      $er_current_total     = $sss_er_current + $pagibig_er_current + $philhealth_er_current;
      $ee_previous_total_1  = $sss_ee_prev_1 + $pagibig_ee_prev_1 + $philhealth_ee_prev_1;
      $ee_previous_total_2  = $sss_ee_prev_2 + $pagibig_ee_prev_2 + $philhealth_ee_prev_2;
      $ee_previous_total_3  = $sss_ee_prev_3 + $pagibig_ee_prev_3 + $philhealth_ee_prev_3;
      $ee_previous_total_4  = $sss_ee_prev_4 + $pagibig_ee_prev_4 + $philhealth_ee_prev_4;
      $ee_previous_total_5  = $sss_ee_prev_5 + $pagibig_ee_prev_5 + $philhealth_ee_prev_5;
      $er_previous_total_1  = $sss_er_prev_1 + $pagibig_er_prev_1 + $philhealth_er_prev_1;
      $er_previous_total_2  = $sss_er_prev_2 + $pagibig_er_prev_2 + $philhealth_er_prev_2;
      $er_previous_total_3  = $sss_er_prev_3 + $pagibig_er_prev_3 + $philhealth_er_prev_3;
      $er_previous_total_4  = $sss_er_prev_4 + $pagibig_er_prev_4 + $philhealth_er_prev_4;
      $er_previous_total_5  = $sss_er_prev_5 + $pagibig_er_prev_5 + $philhealth_er_prev_5;
      $ee_difference_total  = $sss_ee_diff + $pagibig_ee_diff + $philhealth_ee_diff;
      $er_difference_total  = $sss_er_diff + $pagibig_er_diff + $philhealth_er_diff;
      $earnings   = $basic_pay + $tax_allowance_total + $nontax_allowance_total;
      $deductions = $basic_deduction + $wtax + $ee_difference_total + $loancadeduct_total;
      $net_income = $earnings - $deductions;
      $data['DISP_EMPLOYEE']                = $employee_list;
      $data['DISP_PERIOD']                  = $payroll_list;
      $data['DISP_CONN_PERIOD_1']           = $connected_1;
      $data['DISP_CONN_PERIOD_2']           = $connected_2;
      $data['DISP_CONN_PERIOD_3']           = $connected_3;
      $data['DISP_CONN_PERIOD_4']           = $connected_4;
      $data['DISP_CONN_PERIOD_5']           = $connected_5;
      $data['DISP_CONN_PERIOD_1_NAME']      = $connected_1_name;
      $data['DISP_CONN_PERIOD_2_NAME']      = $connected_2_name;
      $data['DISP_CONN_PERIOD_3_NAME']      = $connected_3_name;
      $data['DISP_CONN_PERIOD_4_NAME']      = $connected_4_name;
      $data['DISP_CONN_PERIOD_5_NAME']      = $connected_5_name;
      $data['DISP_ATTENDANCE_LOCK']         = $DISP_ATTENDANCE_LOCK;
      $data['DISP_DEDUCTIONS']    = array();
      $data['DISP_ALL_EMPLOYEES'] = array();
      $data['DISP_PAYROLL_SCHED'] = array();
      $data['PAYSLIP_EMPLOYEE_ID']      = $employee;
      $data['PAYSLIP_EMPLOYEE_CMID']    = $ini_empl_cmid;
      $data['PAYSLIP_EMPLOYEE_NAME']    = $ini_empl_name;
      $data['PAYSLIP_SALARY_RATE']      = $ini_salary_rate;
      $data['PAYSLIP_SALARY_TYPE']      = $ini_salary_type;
      $data['PAYSLIP_PERIOD']           = $period;
      $data['INITIAL_SALARY_RATE']  = number_format((float)$ini_salary_rate, 2);
      $data['INITIAL_SALARY_TYPE']  = $ini_salary_type;
      $data['INITIAL_DAILY_RATE']   = number_format((float)$daily_salary, 2);
      $data['INITIAL_HOURLY_RATE']  = number_format((float)$hourly_salary, 2);
      $data["COUNT_PRESENT"]        = $count_present;
      $data["COUNT_ABSENT"]         = $count_absent;
      $data["COUNT_TARDINESS"]      = $count_tardiness;
      $data["COUNT_UNDERTIME"]      = $count_undertime;
      $data["COUNT_PAID_LEAVE"]     = $count_paid_leave;
      $data["COUNT_REG_HOURS"]      = $count_reg_hours;
      $data["COUNT_REG_OT"]         = $count_reg_ot;
      $data["COUNT_REG_ND"]         = $count_reg_nd;
      $data["COUNT_REG_NDOT"]       = $count_reg_ndot;
      $data["COUNT_REST_HOURS"]     = $count_rest_hours;
      $data["COUNT_REST_OT"]        = $count_rest_ot;
      $data["COUNT_REST_ND"]        = $count_rest_nd;
      $data["COUNT_REST_NDOT"]      = $count_rest_ndot;
      $data["COUNT_LEG_HOURS"]      = $count_leg_hours;
      $data["COUNT_LEG_OT"]         = $count_leg_ot;
      $data["COUNT_LEG_ND"]         = $count_leg_nd;
      $data["COUNT_LEG_NDOT"]       = $count_leg_ndot;
      $data["COUNT_LEGREST_HOURS"]  = $count_legrest_hours;
      $data["COUNT_LEGREST_OT"]     = $count_legrest_ot;
      $data["COUNT_LEGREST_ND"]     = $count_legrest_nd;
      $data["COUNT_LEGREST_NDOT"]   = $count_legrest_ndot;
      $data["COUNT_SPE_HOURS"]      = $count_spe_hours;
      $data["COUNT_SPE_OT"]         = $count_spe_ot;
      $data["COUNT_SPE_ND"]         = $count_spe_nd;
      $data["COUNT_SPE_NDOT"]       = $count_spe_ndot;
      $data["COUNT_SPEREST_HOURS"]  = $count_sperest_hours;
      $data["COUNT_SPEREST_OT"]     = $count_sperest_ot;
      $data["COUNT_SPEREST_ND"]     = $count_sperest_nd;
      $data["COUNT_SPEREST_NDOT"]   = $count_sperest_ndot;
      $data["MUL_PRESENT"]          = $mul_present;
      $data["MUL_ABSENT"]           = $mul_absent;
      $data["MUL_TARDINESS"]        = $mul_tardiness;
      $data["MUL_UNDERTIME"]        = $mul_undertime;
      $data["MUL_PAID_LEAVE"]       = $mul_paid_leave;
      $data["MUL_REG_HOURS"]        = $mul_reg_hours;
      $data["MUL_REG_OT"]           = $mul_reg_ot;
      $data["MUL_REG_ND"]           = $mul_reg_nd;
      $data["MUL_REG_NDOT"]         = $mul_reg_ndot;
      $data["MUL_REST_HOURS"]       = $mul_rest_hours;
      $data["MUL_REST_OT"]          = $mul_rest_ot;
      $data["MUL_REST_ND"]          = $mul_rest_nd;
      $data["MUL_REST_NDOT"]        = $mul_rest_ndot;
      $data["MUL_LEG_HOURS"]        = $mul_leg_hours;
      $data["MUL_LEG_OT"]           = $mul_leg_ot;
      $data["MUL_LEG_ND"]           = $mul_leg_nd;
      $data["MUL_LEG_NDOT"]         = $mul_leg_ndot;
      $data["MUL_LEGREST_HOURS"]    = $mul_legrest_hours;
      $data["MUL_LEGREST_OT"]       = $mul_legrest_ot;
      $data["MUL_LEGREST_ND"]       = $mul_legrest_nd;
      $data["MUL_LEGREST_NDOT"]     = $mul_legrest_ndot;
      $data["MUL_SPE_HOURS"]        = $mul_spe_hours;
      $data["MUL_SPE_OT"]           = $mul_spe_ot;
      $data["MUL_SPE_ND"]           = $mul_spe_nd;
      $data["MUL_SPE_NDOT"]         = $mul_spe_ndot;
      $data["MUL_SPEREST_HOURS"]    = $mul_sperest_hours;
      $data["MUL_SPEREST_OT"]       = $mul_sperest_ot;
      $data["MUL_SPEREST_ND"]       = $mul_sperest_nd;
      $data["MUL_SPEREST_NDOT"]     = $mul_sperest_ndot;
      $data["TOT_PRESENT"]          = number_format((float)$tot_present, 2);
      $data["TOT_ABSENT"]           = number_format((float)$tot_absent, 2);
      $data["TOT_TARDINESS"]        = number_format((float)$tot_tardiness, 2);
      $data["TOT_UNDERTIME"]        = number_format((float)$tot_undertime, 2);
      $data["TOT_PAID_LEAVE"]       = number_format((float)$tot_paid_leave, 2);
      $data["TOT_REG_HOURS"]        = number_format((float)$tot_reg_hours, 2);
      $data["TOT_REG_OT"]           = number_format((float)$tot_reg_ot, 2);
      $data["TOT_REG_ND"]           = number_format((float)$tot_reg_nd, 2);
      $data["TOT_REG_NDOT"]         = number_format((float)$tot_reg_ndot, 2);
      $data["TOT_REST_HOURS"]       = number_format((float)$tot_rest_hours, 2);
      $data["TOT_REST_OT"]          = number_format((float)$tot_rest_ot, 2);
      $data["TOT_REST_ND"]          = number_format((float)$tot_rest_nd, 2);
      $data["TOT_REST_NDOT"]        = number_format((float)$tot_rest_ndot, 2);
      $data["TOT_LEG_HOURS"]        = number_format((float)$tot_leg_hours, 2);
      $data["TOT_LEG_OT"]           = number_format((float)$tot_leg_ot, 2);
      $data["TOT_LEG_ND"]           = number_format((float)$tot_leg_nd, 2);
      $data["TOT_LEG_NDOT"]         = number_format((float)$tot_leg_ndot, 2);
      $data["TOT_LEGREST_HOURS"]    = number_format((float)$tot_legrest_hours, 2);
      $data["TOT_LEGREST_OT"]       = number_format((float)$tot_legrest_ot, 2);
      $data["TOT_LEGREST_ND"]       = number_format((float)$tot_legrest_nd, 2);
      $data["TOT_LEGREST_NDOT"]     = number_format((float)$tot_legrest_ndot, 2);
      $data["TOT_SPE_HOURS"]        = number_format((float)$tot_spe_hours, 2);
      $data["TOT_SPE_OT"]           = number_format((float)$tot_spe_ot, 2);
      $data["TOT_SPE_ND"]           = number_format((float)$tot_spe_nd, 2);
      $data["TOT_SPE_NDOT"]         = number_format((float)$tot_spe_ndot, 2);
      $data["TOT_SPEREST_HOURS"]    = number_format((float)$tot_sperest_hours, 2);
      $data["TOT_SPEREST_OT"]       = number_format((float)$tot_sperest_ot, 2);
      $data["TOT_SPEREST_ND"]       = number_format((float)$tot_sperest_nd, 2);
      $data["TOT_SPEREST_NDOT"]     = number_format((float)$tot_sperest_ndot, 2);
      $data["BASIC_INCOME"]         = number_format((float)$basic_income, 2);
      $data["GROSS_INCOME"]         = number_format((float)$gross_income, 2);
      $data["GROSS_INCOME_PREV_1"]  = number_format((float)$gross_income_prev_1, 2);
      $data["GROSS_INCOME_PREV_2"]  = number_format((float)$gross_income_prev_2, 2);
      $data["GROSS_INCOME_PREV_3"]  = number_format((float)$gross_income_prev_3, 2);
      $data["GROSS_INCOME_PREV_4"]  = number_format((float)$gross_income_prev_4, 2);
      $data["GROSS_INCOME_PREV_5"]  = number_format((float)$gross_income_prev_5, 2);
      $data["GROSS_INCOME_TOTAL"]   = number_format((float)$gross_income_total, 2);
      $data["TAXABLE_INCOME"]        = number_format((float)$taxable_income, 2);
      $data["SSS_EE_TOTAL"]          = number_format((float)$sss_ee_current, 2);
      $data["SSS_EE_CURRENT"]        = number_format((float)$sss_ee_diff, 2);
      $data["PAGIBIG_EE_TOTAL"]      = number_format((float)$pagibig_ee_current, 2);
      $data["PAGIBIG_EE_CURRENT"]    = number_format((float)$pagibig_ee_diff, 2);
      $data["PHILHEALTH_EE_TOTAL"]   = number_format((float)$philhealth_ee_current, 2);
      $data["PHILHEALTH_EE_CURRENT"] = number_format((float)$philhealth_ee_diff, 2);
      $data["TOTAL_EE_TOTAL"]        = number_format((float)$ee_current_total, 2);
      $data["TOTAL_EE_CURRENT"]      = number_format((float)$ee_difference_total, 2);
      $data["SSS_ER_TOTAL"]          = number_format((float)$sss_er_current, 2);
      $data["SSS_EC_ER_TOTAL"]       = number_format((float)$sss_ec_er_current, 2);
      $data["SSS_ER_CURRENT"]        = number_format((float)$sss_er_diff, 2);
      $data["SSS_EC_ER_CURRENT"]     = number_format((float)$sss_ec_er_diff, 2);
      //---------------------------
      $data["SSS_EE_PREVIOUS_1"]          = number_format((float)$sss_ee_prev_1, 2);
      $data["PAGIBIG_EE_PREVIOUS_1"]      = number_format((float)$pagibig_ee_prev_1, 2);
      $data["PHILHEALTH_EE_PREVIOUS_1"]   = number_format((float)$philhealth_ee_prev_1, 2);
      $data["TOTAL_EE_PREVIOUS_1"]        = number_format((float)$ee_previous_total_1, 2);
      $data["SSS_EE_PREVIOUS_2"]          = number_format((float)$sss_ee_prev_2, 2);
      $data["PAGIBIG_EE_PREVIOUS_2"]      = number_format((float)$pagibig_ee_prev_2, 2);
      $data["PHILHEALTH_EE_PREVIOUS_2"]   = number_format((float)$philhealth_ee_prev_2, 2);
      $data["TOTAL_EE_PREVIOUS_2"]        = number_format((float)$ee_previous_total_2, 2);
      $data["SSS_EE_PREVIOUS_3"]          = number_format((float)$sss_ee_prev_3, 2);
      $data["PAGIBIG_EE_PREVIOUS_3"]      = number_format((float)$pagibig_ee_prev_3, 2);
      $data["PHILHEALTH_EE_PREVIOUS_3"]   = number_format((float)$philhealth_ee_prev_3, 2);
      $data["TOTAL_EE_PREVIOUS_3"]        = number_format((float)$ee_previous_total_3, 2);
      $data["SSS_EE_PREVIOUS_4"]          = number_format((float)$sss_ee_prev_4, 2);
      $data["PAGIBIG_EE_PREVIOUS_4"]      = number_format((float)$pagibig_ee_prev_4, 2);
      $data["PHILHEALTH_EE_PREVIOUS_4"]   = number_format((float)$philhealth_ee_prev_4, 2);
      $data["TOTAL_EE_PREVIOUS_4"]        = number_format((float)$ee_previous_total_4, 2);
      $data["SSS_EE_PREVIOUS_5"]          = number_format((float)$sss_ee_prev_5, 2);
      $data["PAGIBIG_EE_PREVIOUS_5"]      = number_format((float)$pagibig_ee_prev_5, 2);
      $data["PHILHEALTH_EE_PREVIOUS_5"]   = number_format((float)$philhealth_ee_prev_5, 2);
      $data["TOTAL_EE_PREVIOUS_5"]        = number_format((float)$ee_previous_total_5, 2);
      //----------------------------
      $data["PAGIBIG_ER_TOTAL"]         = number_format((float)$pagibig_er_current, 2);
      $data["PAGIBIG_ER_CURRENT"]       = number_format((float)$pagibig_er_diff, 2);
      $data["PHILHEALTH_ER_TOTAL"]      = number_format((float)$philhealth_er_current, 2);
      $data["PHILHEALTH_ER_CURRENT"]    = number_format((float)$philhealth_er_diff, 2);
      $data["TOTAL_ER_TOTAL"]           = number_format((float)$er_current_total, 2);
      $data["TOTAL_ER_CURRENT"]         = number_format((float)$er_difference_total, 2);
      $data["SSS_ER_PREVIOUS_1"]        = number_format((float)$sss_er_prev_1, 2);
      $data["SSS_EC_ER_PREVIOUS_1"]     = number_format((float)$sss_ec_er_prev_1, 2);
      $data["PAGIBIG_ER_PREVIOUS_1"]    = number_format((float)$pagibig_er_prev_1, 2);
      $data["PHILHEALTH_ER_PREVIOUS_1"] = number_format((float)$philhealth_er_prev_1, 2);
      $data["TOTAL_ER_PREVIOUS_1"]      = number_format((float)$er_previous_total_1, 2);
      $data["SSS_ER_PREVIOUS_2"]        = number_format((float)$sss_er_prev_2, 2);
      $data["SSS_EC_ER_PREVIOUS_2"]     = number_format((float)$sss_ec_er_prev_2, 2);
      $data["PAGIBIG_ER_PREVIOUS_2"]    = number_format((float)$pagibig_er_prev_2, 2);
      $data["PHILHEALTH_ER_PREVIOUS_2"] = number_format((float)$philhealth_er_prev_2, 2);
      $data["TOTAL_ER_PREVIOUS_2"]      = number_format((float)$er_previous_total_2, 2);
      $data["SSS_ER_PREVIOUS_3"]        = number_format((float)$sss_er_prev_3, 2);
      $data["SSS_EC_ER_PREVIOUS_3"]     = number_format((float)$sss_ec_er_prev_3, 2);
      $data["PAGIBIG_ER_PREVIOUS_3"]    = number_format((float)$pagibig_er_prev_3, 2);
      $data["PHILHEALTH_ER_PREVIOUS_3"] = number_format((float)$philhealth_er_prev_3, 2);
      $data["TOTAL_ER_PREVIOUS_3"]      = number_format((float)$er_previous_total_3, 2);
      $data["SSS_ER_PREVIOUS_4"]        = number_format((float)$sss_er_prev_4, 2);
      $data["SSS_EC_ER_PREVIOUS_4"]     = number_format((float)$sss_ec_er_prev_4, 2);
      $data["PAGIBIG_ER_PREVIOUS_4"]    = number_format((float)$pagibig_er_prev_4, 2);
      $data["PHILHEALTH_ER_PREVIOUS_4"] = number_format((float)$philhealth_er_prev_4, 2);
      $data["TOTAL_ER_PREVIOUS_4"]      = number_format((float)$er_previous_total_4, 2);
      $data["SSS_ER_PREVIOUS_5"]        = number_format((float)$sss_er_prev_5, 2);
      $data["SSS_EC_ER_PREVIOUS_5"]     = number_format((float)$sss_ec_er_prev_5, 2);
      $data["PAGIBIG_ER_PREVIOUS_5"]    = number_format((float)$pagibig_er_prev_5, 2);
      $data["PHILHEALTH_ER_PREVIOUS_5"] = number_format((float)$philhealth_er_prev_5, 2);
      $data["TOTAL_ER_PREVIOUS_5"]      = number_format((float)$er_previous_total_5, 2);
      $data["WTAX"]                               = number_format((float)$wtax, 2);
      $data["EARNINGS"]                           = number_format((float)$earnings, 2);
      $data["DEDUCTIONS"]                         = number_format((float)$deductions, 2);
      $data["NET_INCOME"]                         = number_format((float)$net_income, 2);
      $data['DISP_DISTINCT_DEPARTMENT']           = array();
      $data['DISP_DISTINCT_SECTION']              = array();
      $data['DISP_APPROVED_ATTENDANCE_EMPLOYEE']  = array();
      $data['EN_SSS']                     = $en_sss;
      $data['EN_PHIL']                    = $en_phil;
      $data['EN_PAGIBIG']                 = $en_pagibig;
      $data['EN_WTAX']                    = $en_wtax;
      $data['EN_TI']                      = $en_ti;
      $data['EN_NTI']                     = $en_nti;
      $data['EN_TD']                      = $en_td;
      $data['EN_NTD']                     = $en_ntd;
      $data['EN_LOAN']                    = $en_loan;
      $data['EN_ABSUT']                   = $en_absut;
      $data['BASIC_PAY'] = number_format((float)$basic_pay, 2);
      $data['BASIC_DEDUCTION'] = number_format((float)$basic_deduction, 2);
      $data['DISP_TAX_ALLOWANCE']           = $tax_allowance_list;
      $data['DISP_TAX_ALLOWANCE_TOTAL']     = number_format((float)$tax_allowance_total, 2);
      $data['DISP_NONTAX_ALLOWANCE']        = $nontax_allowance_list;
      $data['DISP_NONTAX_ALLOWANCE_TOTAL']  = number_format((float)$nontax_allowance_total, 2);
      $data['ID_SSS']                     = $ID_SSS;
      $data['ID_PAGIBIG']                 = $ID_PAGIBIG;
      $data['ID_PHILHEALTH']              = $ID_PHILHEALTH;
      $data['ID_TIN']                     = $ID_TIN;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/new_payroll_views', $data);
    }
    function get_payment_info($id, $cutoff)
    {
      $data                             = $this->payrolls_model->GET_SPECIFIC_PAYSLIP($id, $cutoff);
      $arr_data                         = array();
      foreach ($data as $key => $value) {
        $arr_data[$key] = $value == null || $value == 0 ? '-' : $value;
      }
      echo json_encode($arr_data);
    }
    function get_employee_not_ready_for_payslip()
    {
      $date               = $this->input->post('payroll_date');
      $payroll_id         = $this->input->post('payroll_id');
      $split_date         = explode(' - ', $date);
      $date1              = $split_date[0];
      $date2              = $split_date[1];
      $start_date         = date('Y-m-d', strtotime($date1));
      $end_date           = date('Y-m-d', strtotime($date2));
      $empl_not_ready_arr = [];
      $empl_ready_arr     = [];
      $empl_payslip_arr   = [];
      $empl_based_on_date = [];
      // get employees ready for payslip
      $empl_ready         = $this->payrolls_model->MOD_GET_EMPL_READY_FOR_PAYSLIP($payroll_id);
      $employees          = $this->payrolls_model->MOD_DISP_EMP_BASED_ON_HIRE_DATE($start_date, $end_date);
      foreach ($empl_ready as $empl_ready_row) {
        array_push($empl_ready_arr, $empl_ready_row->empl_id);
      }
      foreach ($employees as $employee) {
        if (!in_array($employee->id, $empl_ready_arr)) {
          $empl_not_ready_arr[] = $employee;
        }
      }
      // get employees that already has payslip
      $empl_payslip = $this->payrolls_model->MON_DISP_ALL_EMPL_PAYROLL($payroll_id);
      $data['empl_not_ready_for_payslip'] = $empl_not_ready_arr;
      $data['count'] = count($employees) - count($empl_ready);
      echo (json_encode($data));
    }
    function generated_payslip_count()
    {
      $payroll_id   = $this->input->post('payroll_id');
      $payroll_data = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_PER_CUTOFF($payroll_id);
      $data         = count($payroll_data);
      echo (json_encode($data));
    }
    function bir_form2316()
    {
      $data['EMPLOYEES']  = $this->payrolls_model->GET_EMPLOYEE_LIST();
      $data['YEARS']      = array();
      $year               = date("Y");
      for ($i = $year; $i > $year - 10; $i--) {
        array_push($data['YEARS'], $i);
      }
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/bir_form2316_views', $data);
    }
    function getSpecificEmployeeData($empl_id)
    {
      $empl_data        = $this->payrolls_model->GET_EMPLOYEE_INFO_SPECIFIC($empl_id);
      echo (json_encode($empl_data));
    }
    // DISPLAY EMPLOYEE DATA
    function getEmployeeData()
    {
      $employee_id            = $this->input->post('employee_id');
      $data['employee_data']  = $this->payrolls_model->GET_EMPLOYEE_INFO_SPECIFIC($employee_id);
      echo (json_encode($data));
    }
    function get_payslip_data()
    {
      $payroll_id             = $this->input->post('payroll_id');
      $data['payslip_data']   = $this->p080_payroll_mod->MOD_DISP_PAYROLL_DATA($payroll_id);
      $data['cutoff_period']  = $this->p175_payschedule_mod->MOD_GET_PAY_SCHED_DATA($payroll_id);
      echo (json_encode($data));
    }
    function get_payslip_data_based_on_period()
    {
      $payroll_id             = $this->input->post('cutoff_id');
      $data                   = $this->p080_payroll_mod->MOD_DISP_PAYROLL_DATA_BASED_CUTOFF_DATE($payroll_id);
      echo (json_encode($data));
    }
    function get_employees_ready_for_payslip()
    {
      $date                   = $this->input->post('payroll_date'); // cut off period text
      $payroll_id             = $this->input->post('payroll_id'); // date id
      $split_date             = explode(' - ', $date);
      $date1                  = $split_date[0];
      $date2                  = $split_date[1];
      $start_date             = date('Y-m-d', strtotime($date1));
      $end_date               = date('Y-m-d', strtotime($date2));
      $empl_ready_arr         = [];
      $empl_payslip_arr       = [];
      $empl_based_on_date     = [];
      // get employees ready for payslip
      $empl_ready             = $this->payrolls_model->MOD_GET_EMPL_READY_FOR_PAYSLIP($payroll_id); // tbl_attendance_records_lock
      $employees              = $this->payrolls_model->MOD_DISP_EMP_BASED_ON_HIRE_DATE($start_date, $end_date); // tbl_employee_infos
      $empl_payslips          = $this->payrolls_model->MON_DISP_ALL_EMPL_PAYROLL($payroll_id); //tbl_payroll_payslips
      foreach ($empl_payslips as $empl_payslip_row) {
        array_push($empl_payslip_arr, $empl_payslip_row->empl_id);
      }
      foreach ($empl_ready as $empl_ready_row) {
        if (!in_array($empl_ready_row->empl_id, $empl_payslip_arr)) {
          array_push($empl_ready_arr, $empl_ready_row);
        }
      }
      // get employees that already has payslip
      $data['empl_ready_for_payslip'] = $empl_ready_arr;
      $data['count']                  = count($empl_ready_arr);
      echo (json_encode($data));
    }
    function get_all_payroll_data_by_3s()
    {
      $ids = [
        $this->input->post('payroll_id1'),
        $this->input->post('payroll_id2'),
        $this->input->post('payroll_id3'),
      ];
      $payrollData  = $this->p080_payroll_mod->MOD_GET_PAYROLL_DATA_BY_3s($ids);
      if (count($payrollData) == 3) {
        foreach ($payrollData as $dt) {
          $employee = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE($dt->empl_id);
          if ($employee) {
            $dt->employee_cmid            = $employee[0]->col_empl_cmid;
            $dt->employment_type          = $employee[0]->col_empl_type;
            $dt->position                 = $employee[0]->col_empl_posi;
            $dt->empl_sect                = $employee[0]->col_empl_sect;
            $dt->empl_dept                = $employee[0]->col_empl_dept;
            $dt->used_sick_leave          = "0.00";
            $dt->used_vacation_leave      = "0.00";
            $dt->loan_balance_amount      = "-";
            $dt->loan_amount_paid         = "-";
            $dt->vacation_leave_balance   = $employee[0]->col_leave_vacation;
            $dt->sick_leave_balance       = $employee[0]->col_leave_sick;
          }
        }
      }
      $data['data0'] = $payrollData[0];
      $data['data1'] = $payrollData[1];
      $data['data2'] = $payrollData[2];
      echo (json_encode($data));
    }
    function delete_payslip_data()
    {
      $payslip_id       = $this->input->get('payslip_id');
      $empl_cmid        = $this->input->get('empl_cmid');
      $date_period      = $this->input->get('date_period');
      $this->p080_payroll_mod->MOD_DLT_PAYROLL_DATA($payslip_id);
      $this->p080_payroll_mod->MOD_UNPAY_LOAN_PAYABLE($empl_cmid, $date_period);
      $this->session->set_userdata('SESS_SUCC_MSG_DLT_PAYROLL', 'Deleted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted payslip');
      redirect('payrolls/payslip_generator');
    }
    // Insert generated payroll
    function insrt_payroll_data()
    {
      $PAYSLIP_EMPLOYEE_ID        = $this->input->post("PAYSLIP_EMPLOYEE_ID");
      $PAYSLIP_EMPLOYEE_CMID      = $this->input->post("PAYSLIP_EMPLOYEE_CMID");
      $PAYSLIP_EMPLOYEE_NAME      = $this->input->post("PAYSLIP_EMPLOYEE_NAME");
      $PAYSLIP_SALARY_RATE        = $this->input->post("PAYSLIP_SALARY_RATE");
      $PAYSLIP_SALARY_TYPE        = $this->input->post("PAYSLIP_SALARY_TYPE");
      $INITIAL_DAILY_RATE         = (float) str_replace(",", "", $this->input->post("INITIAL_DAILY_RATE"));
      $INITIAL_HOURLY_RATE        = (float) str_replace(",", "", $this->input->post("INITIAL_HOURLY_RATE"));
      $PAYSLIP_PERIOD             = $this->input->post("PAYSLIP_PERIOD");
      $COUNT_PRESENT              = (float) str_replace(",", "", $this->input->post("COUNT_PRESENT"));
      $COUNT_ABSENT               = (float) str_replace(",", "", $this->input->post("COUNT_ABSENT"));
      $COUNT_TARDINESS            = (float) str_replace(",", "", $this->input->post("COUNT_TARDINESS"));
      $COUNT_UNDERTIME            = (float) str_replace(",", "", $this->input->post("COUNT_UNDERTIME"));
      $COUNT_PAID_LEAVE           = (float) str_replace(",", "", $this->input->post("COUNT_PAID_LEAVE"));
      $COUNT_REG_HOURS            = (float) str_replace(",", "", $this->input->post("COUNT_REG_HOURS"));
      $COUNT_REG_OT               = (float) str_replace(",", "", $this->input->post("COUNT_REG_OT"));
      $COUNT_REG_ND               = (float) str_replace(",", "", $this->input->post("COUNT_REG_ND"));
      $COUNT_REG_NDOT             = (float) str_replace(",", "", $this->input->post("COUNT_REG_NDOT"));
      $COUNT_REST_HOURS           = (float) str_replace(",", "", $this->input->post("COUNT_REST_HOURS"));
      $COUNT_REST_OT              = (float) str_replace(",", "", $this->input->post("COUNT_REST_OT"));
      $COUNT_REST_ND              = (float) str_replace(",", "", $this->input->post("COUNT_REST_ND"));
      $COUNT_REST_NDOT            = (float) str_replace(",", "", $this->input->post("COUNT_REST_NDOT"));
      $COUNT_LEG_HOURS            = (float) str_replace(",", "", $this->input->post("COUNT_LEG_HOURS"));
      $COUNT_LEG_OT               = (float) str_replace(",", "", $this->input->post("COUNT_LEG_OT"));
      $COUNT_LEG_ND               = (float) str_replace(",", "", $this->input->post("COUNT_LEG_ND"));
      $COUNT_LEG_NDOT             = (float) str_replace(",", "", $this->input->post("COUNT_LEG_NDOT"));
      $COUNT_LEGREST_HOURS        = (float) str_replace(",", "", $this->input->post("COUNT_LEGREST_HOURS"));
      $COUNT_LEGREST_OT           = (float) str_replace(",", "", $this->input->post("COUNT_LEGREST_OT"));
      $COUNT_LEGREST_ND           = (float) str_replace(",", "", $this->input->post("COUNT_LEGREST_ND"));
      $COUNT_LEGREST_NDOT         = (float) str_replace(",", "", $this->input->post("COUNT_LEGREST_NDOT"));
      $COUNT_SPE_HOURS            = (float) str_replace(",", "", $this->input->post("COUNT_SPE_HOURS"));
      $COUNT_SPE_OT               = (float) str_replace(",", "", $this->input->post("COUNT_SPE_OT"));
      $COUNT_SPE_ND               = (float) str_replace(",", "", $this->input->post("COUNT_SPE_ND"));
      $COUNT_SPE_NDOT             = (float) str_replace(",", "", $this->input->post("COUNT_SPE_NDOT"));
      $COUNT_SPEREST_HOURS        = (float) str_replace(",", "", $this->input->post("COUNT_SPEREST_HOURS"));
      $COUNT_SPEREST_OT           = (float) str_replace(",", "", $this->input->post("COUNT_SPEREST_OT"));
      $COUNT_SPEREST_ND           = (float) str_replace(",", "", $this->input->post("COUNT_SPEREST_ND"));
      $COUNT_SPEREST_NDOT         = (float) str_replace(",", "", $this->input->post("COUNT_SPEREST_NDOT"));
      $MUL_PRESENT                = (float) str_replace(",", "", $this->input->post("MUL_PRESENT"));
      $MUL_ABSENT                 = (float) str_replace(",", "", $this->input->post("MUL_ABSENT"));
      $MUL_TARDINESS              = (float) str_replace(",", "", $this->input->post("MUL_TARDINESS"));
      $MUL_UNDERTIME              = (float) str_replace(",", "", $this->input->post("MUL_UNDERTIME"));
      $MUL_PAID_LEAVE             = (float) str_replace(",", "", $this->input->post("MUL_PAID_LEAVE"));
      $MUL_REG_HOURS              = (float) str_replace(",", "", $this->input->post("MUL_REG_HOURS"));
      $MUL_REG_OT                 = (float) str_replace(",", "", $this->input->post("MUL_REG_OT"));
      $MUL_REG_ND                 = (float) str_replace(",", "", $this->input->post("MUL_REG_ND"));
      $MUL_REG_NDOT               = (float) str_replace(",", "", $this->input->post("MUL_REG_NDOT"));
      $MUL_REST_HOURS             = (float) str_replace(",", "", $this->input->post("MUL_REST_HOURS"));
      $MUL_REST_OT                = (float) str_replace(",", "", $this->input->post("MUL_REST_OT"));
      $MUL_REST_ND                = (float) str_replace(",", "", $this->input->post("MUL_REST_ND"));
      $MUL_REST_NDOT              = (float) str_replace(",", "", $this->input->post("MUL_REST_NDOT"));
      $MUL_LEG_HOURS              = (float) str_replace(",", "", $this->input->post("MUL_LEG_HOURS"));
      $MUL_LEG_OT                 = (float) str_replace(",", "", $this->input->post("MUL_LEG_OT"));
      $MUL_LEG_ND                 = (float) str_replace(",", "", $this->input->post("MUL_LEG_ND"));
      $MUL_LEG_NDOT               = (float) str_replace(",", "", $this->input->post("MUL_LEG_NDOT"));
      $MUL_LEGREST_HOURS          = (float) str_replace(",", "", $this->input->post("MUL_LEGREST_HOURS"));
      $MUL_LEGREST_OT             = (float) str_replace(",", "", $this->input->post("MUL_LEGREST_OT"));
      $MUL_LEGREST_ND             = (float) str_replace(",", "", $this->input->post("MUL_LEGREST_ND"));
      $MUL_LEGREST_NDOT           = (float) str_replace(",", "", $this->input->post("MUL_LEGREST_NDOT"));
      $MUL_SPE_HOURS              = (float) str_replace(",", "", $this->input->post("MUL_SPE_HOURS"));
      $MUL_SPE_OT                 = (float) str_replace(",", "", $this->input->post("MUL_SPE_OT"));
      $MUL_SPE_ND                 = (float) str_replace(",", "", $this->input->post("MUL_SPE_ND"));
      $MUL_SPE_NDOT               = (float) str_replace(",", "", $this->input->post("MUL_SPE_NDOT"));
      $MUL_SPEREST_HOURS          = (float) str_replace(",", "", $this->input->post("MUL_SPEREST_HOURS"));
      $MUL_SPEREST_OT             = (float) str_replace(",", "", $this->input->post("MUL_SPEREST_OT"));
      $MUL_SPEREST_ND             = (float) str_replace(",", "", $this->input->post("MUL_SPEREST_ND"));
      $MUL_SPEREST_NDOT           = (float) str_replace(",", "", $this->input->post("MUL_SPEREST_NDOT"));
      $TOT_PRESENT                = (float) str_replace(",", "", $this->input->post("TOT_PRESENT"));
      $TOT_ABSENT                 = (float) str_replace(",", "", $this->input->post("TOT_ABSENT"));
      $TOT_TARDINESS              = (float) str_replace(",", "", $this->input->post("TOT_TARDINESS"));
      $TOT_UNDERTIME              = (float) str_replace(",", "", $this->input->post("TOT_UNDERTIME"));
      $TOT_PAID_LEAVE             = (float) str_replace(",", "", $this->input->post("TOT_PAID_LEAVE"));
      $TOT_REG_HOURS              = (float) str_replace(",", "", $this->input->post("TOT_REG_HOURS"));
      $TOT_REG_OT                 = (float) str_replace(",", "", $this->input->post("TOT_REG_OT"));
      $TOT_REG_ND                 = (float) str_replace(",", "", $this->input->post("TOT_REG_ND"));
      $TOT_REG_NDOT               = (float) str_replace(",", "", $this->input->post("TOT_REG_NDOT"));
      $TOT_REST_HOURS             = (float) str_replace(",", "", $this->input->post("TOT_REST_HOURS"));
      $TOT_REST_OT                = (float) str_replace(",", "", $this->input->post("TOT_REST_OT"));
      $TOT_REST_ND                = (float) str_replace(",", "", $this->input->post("TOT_REST_ND"));
      $TOT_REST_NDOT              = (float) str_replace(",", "", $this->input->post("TOT_REST_NDOT"));
      $TOT_LEG_HOURS              = (float) str_replace(",", "", $this->input->post("TOT_LEG_HOURS"));
      $TOT_LEG_OT                 = (float) str_replace(",", "", $this->input->post("TOT_LEG_OT"));
      $TOT_LEG_ND                 = (float) str_replace(",", "", $this->input->post("TOT_LEG_ND"));
      $TOT_LEG_NDOT               = (float) str_replace(",", "", $this->input->post("TOT_LEG_NDOT"));
      $TOT_LEGREST_HOURS          = (float) str_replace(",", "", $this->input->post("TOT_LEGREST_HOURS"));
      $TOT_LEGREST_OT             = (float) str_replace(",", "", $this->input->post("TOT_LEGREST_OT"));
      $TOT_LEGREST_ND             = (float) str_replace(",", "", $this->input->post("TOT_LEGREST_ND"));
      $TOT_LEGREST_NDOT           = (float) str_replace(",", "", $this->input->post("TOT_LEGREST_NDOT"));
      $TOT_SPE_HOURS              = (float) str_replace(",", "", $this->input->post("TOT_SPE_HOURS"));
      $TOT_SPE_OT                 = (float) str_replace(",", "", $this->input->post("TOT_SPE_OT"));
      $TOT_SPE_ND                 = (float) str_replace(",", "", $this->input->post("TOT_SPE_ND"));
      $TOT_SPE_NDOT               = (float) str_replace(",", "", $this->input->post("TOT_SPE_NDOT"));
      $TOT_SPEREST_HOURS          = (float) str_replace(",", "", $this->input->post("TOT_SPEREST_HOURS"));
      $TOT_SPEREST_OT             = (float) str_replace(",", "", $this->input->post("TOT_SPEREST_OT"));
      $TOT_SPEREST_ND             = (float) str_replace(",", "", $this->input->post("TOT_SPEREST_ND"));
      $TOT_SPEREST_NDOT           = (float) str_replace(",", "", $this->input->post("TOT_SPEREST_NDOT"));
      $EARNINGS                   = (float) str_replace(",", "", $this->input->post("EARNINGS"));
      $DEDUCTIONS                 = (float) str_replace(",", "", $this->input->post("DEDUCTIONS"));
      $WTAX                       = (float) str_replace(",", "", $this->input->post("WTAX"));
      $NET_INCOME                 = (float) str_replace(",", "", $this->input->post("NET_INCOME"));
      $PAGIBIG_EE_CURRENT         = (float) str_replace(",", "", $this->input->post("PAGIBIG_EE_CURRENT"));
      $PAGIBIG_ER_CURRENT         = (float) str_replace(",", "", $this->input->post("PAGIBIG_ER_CURRENT"));
      $PHILHEALTH_EE_CURRENT      = (float) str_replace(",", "", $this->input->post("PHILHEALTH_EE_CURRENT"));
      $PHILHEALTH_ER_CURRENT      = (float) str_replace(",", "", $this->input->post("PHILHEALTH_ER_CURRENT"));
      $SSS_EC_ER_CURRENT          = (float) str_replace(",", "", $this->input->post("SSS_EC_ER_CURRENT"));
      $SSS_EE_CURRENT             = (float) str_replace(",", "", $this->input->post("SSS_EE_CURRENT"));
      $SSS_ER_CURRENT             = (float) str_replace(",", "", $this->input->post("SSS_ER_CURRENT"));
      $DISP_LOAN_STRING           = $this->input->post("DISP_LOAN_STRING");
      $DISP_CA_STRING             = $this->input->post("DISP_CA_STRING");
      $DISP_DEDUCT_STRING         = $this->input->post("DISP_DEDUCT_STRING");
      $ID_SSS                     = $this->input->post("ID_SSS");
      $ID_PAGIBIG                 = $this->input->post("ID_PAGIBIG");
      $ID_PHILHEALTH              = $this->input->post("ID_PHILHEALTH");
      $ID_TIN                     = $this->input->post("ID_TIN");
      $data = [
        "empl_id" => $PAYSLIP_EMPLOYEE_ID,
        "PAYSLIP_EMPLOYEE_CMID" => $PAYSLIP_EMPLOYEE_CMID,
        "PAYSLIP_EMPLOYEE_NAME" => $PAYSLIP_EMPLOYEE_NAME,
        "PAYSLIP_SALARY_RATE" => $PAYSLIP_SALARY_RATE,
        "PAYSLIP_SALARY_TYPE" => $PAYSLIP_SALARY_TYPE,
        "INITIAL_DAILY_RATE" => $INITIAL_DAILY_RATE,
        "INITIAL_HOURLY_RATE" => $INITIAL_HOURLY_RATE,
        "PAYSLIP_PERIOD" => $PAYSLIP_PERIOD,
        "COUNT_PRESENT" => $COUNT_PRESENT,
        "COUNT_ABSENT" => $COUNT_ABSENT,
        "COUNT_TARDINESS" => $COUNT_TARDINESS,
        "COUNT_UNDERTIME" => $COUNT_UNDERTIME,
        "COUNT_PAID_LEAVE" => $COUNT_PAID_LEAVE,
        "COUNT_REG_HOURS" => $COUNT_REG_HOURS,
        "COUNT_REG_OT" => $COUNT_REG_OT,
        "COUNT_REG_ND" => $COUNT_REG_ND,
        "COUNT_REG_NDOT" => $COUNT_REG_NDOT,
        "COUNT_REST_HOURS" => $COUNT_REST_HOURS,
        "COUNT_REST_OT" => $COUNT_REST_OT,
        "COUNT_REST_ND" => $COUNT_REST_ND,
        "COUNT_REST_NDOT" => $COUNT_REST_NDOT,
        "COUNT_LEG_HOURS" => $COUNT_LEG_HOURS,
        "COUNT_LEG_OT" => $COUNT_LEG_OT,
        "COUNT_LEG_ND" => $COUNT_LEG_ND,
        "COUNT_LEG_NDOT" => $COUNT_LEG_NDOT,
        "COUNT_LEGREST_HOURS" => $COUNT_LEGREST_HOURS,
        "COUNT_LEGREST_OT" => $COUNT_LEGREST_OT,
        "COUNT_LEGREST_ND" => $COUNT_LEGREST_ND,
        "COUNT_LEGREST_NDOT" => $COUNT_LEGREST_NDOT,
        "COUNT_SPE_HOURS" => $COUNT_SPE_HOURS,
        "COUNT_SPE_OT" => $COUNT_SPE_OT,
        "COUNT_SPE_ND" => $COUNT_SPE_ND,
        "COUNT_SPE_NDOT" => $COUNT_SPE_NDOT,
        "COUNT_SPEREST_HOURS" => $COUNT_SPEREST_HOURS,
        "COUNT_SPEREST_OT" => $COUNT_SPEREST_OT,
        "COUNT_SPEREST_ND" => $COUNT_SPEREST_ND,
        "COUNT_SPEREST_NDOT" => $COUNT_SPEREST_NDOT,
        "MUL_PRESENT" => $MUL_PRESENT,
        "MUL_ABSENT" => $MUL_ABSENT,
        "MUL_TARDINESS" => $MUL_TARDINESS,
        "MUL_UNDERTIME" => $MUL_UNDERTIME,
        "MUL_PAID_LEAVE" => $MUL_PAID_LEAVE,
        "MUL_REG_HOURS" => $MUL_REG_HOURS,
        "MUL_REG_OT" => $MUL_REG_OT,
        "MUL_REG_ND" => $MUL_REG_ND,
        "MUL_REG_NDOT" => $MUL_REG_NDOT,
        "MUL_REST_HOURS" => $MUL_REST_HOURS,
        "MUL_REST_OT" => $MUL_REST_OT,
        "MUL_REST_ND" => $MUL_REST_ND,
        "MUL_REST_NDOT" => $MUL_REST_NDOT,
        "MUL_LEG_HOURS" => $MUL_LEG_HOURS,
        "MUL_LEG_OT" => $MUL_LEG_OT,
        "MUL_LEG_ND" => $MUL_LEG_ND,
        "MUL_LEG_NDOT" => $MUL_LEG_NDOT,
        "MUL_LEGREST_HOURS" => $MUL_LEGREST_HOURS,
        "MUL_LEGREST_OT" => $MUL_LEGREST_OT,
        "MUL_LEGREST_ND" => $MUL_LEGREST_ND,
        "MUL_LEGREST_NDOT" => $MUL_LEGREST_NDOT,
        "MUL_SPE_HOURS" => $MUL_SPE_HOURS,
        "MUL_SPE_OT" => $MUL_SPE_OT,
        "MUL_SPE_ND" => $MUL_SPE_ND,
        "MUL_SPE_NDOT" => $MUL_SPE_NDOT,
        "MUL_SPEREST_HOURS" => $MUL_SPEREST_HOURS,
        "MUL_SPEREST_OT" => $MUL_SPEREST_OT,
        "MUL_SPEREST_ND" => $MUL_SPEREST_ND,
        "MUL_SPEREST_NDOT" => $MUL_SPEREST_NDOT,
        "TOT_PRESENT" => $TOT_PRESENT,
        "TOT_ABSENT" => $TOT_ABSENT,
        "TOT_TARDINESS" => $TOT_TARDINESS,
        "TOT_UNDERTIME" => $TOT_UNDERTIME,
        "TOT_PAID_LEAVE" => $TOT_PAID_LEAVE,
        "TOT_REG_HOURS" => $TOT_REG_HOURS,
        "TOT_REG_OT" => $TOT_REG_OT,
        "TOT_REG_ND" => $TOT_REG_ND,
        "TOT_REG_NDOT" => $TOT_REG_NDOT,
        "TOT_REST_HOURS" => $TOT_REST_HOURS,
        "TOT_REST_OT" => $TOT_REST_OT,
        "TOT_REST_ND" => $TOT_REST_ND,
        "TOT_REST_NDOT" => $TOT_REST_NDOT,
        "TOT_LEG_HOURS" => $TOT_LEG_HOURS,
        "TOT_LEG_OT" => $TOT_LEG_OT,
        "TOT_LEG_ND" => $TOT_LEG_ND,
        "TOT_LEG_NDOT" => $TOT_LEG_NDOT,
        "TOT_LEGREST_HOURS" => $TOT_LEGREST_HOURS,
        "TOT_LEGREST_OT" => $TOT_LEGREST_OT,
        "TOT_LEGREST_ND" => $TOT_LEGREST_ND,
        "TOT_LEGREST_NDOT" => $TOT_LEGREST_NDOT,
        "TOT_SPE_HOURS" => $TOT_SPE_HOURS,
        "TOT_SPE_OT" => $TOT_SPE_OT,
        "TOT_SPE_ND" => $TOT_SPE_ND,
        "TOT_SPE_NDOT" => $TOT_SPE_NDOT,
        "TOT_SPEREST_HOURS" => $TOT_SPEREST_HOURS,
        "TOT_SPEREST_OT" => $TOT_SPEREST_OT,
        "TOT_SPEREST_ND" => $TOT_SPEREST_ND,
        "TOT_SPEREST_NDOT" => $TOT_SPEREST_NDOT,
        "EARNINGS" => $EARNINGS,
        "DEDUCTIONS" => $DEDUCTIONS,
        "WTAX" => $WTAX,
        "NET_INCOME" => $NET_INCOME,
        "PAGIBIG_EE_CURRENT" => $PAGIBIG_EE_CURRENT,
        "PAGIBIG_ER_CURRENT" => $PAGIBIG_ER_CURRENT,
        "PHILHEALTH_EE_CURRENT" => $PHILHEALTH_EE_CURRENT,
        "PHILHEALTH_ER_CURRENT" => $PHILHEALTH_ER_CURRENT,
        "SSS_EC_ER_CURRENT" => $SSS_EC_ER_CURRENT,
        "SSS_EE_CURRENT" => $SSS_EE_CURRENT,
        "SSS_ER_CURRENT" => $SSS_ER_CURRENT,
        "LOAN_LIST" => $DISP_LOAN_STRING,
        "CA_LIST" => $DISP_CA_STRING,
        "DEDUCT_LIST" => $DISP_DEDUCT_STRING,
        "ID_SSS" => $ID_SSS,
        "ID_PAGIBIG" => $ID_PAGIBIG,
        "ID_PHILHEALTH" => $ID_PHILHEALTH,
        "ID_TIN" => $ID_TIN
      ];
      $this->payrolls_model->MOD_INSRT_PAYROLL_DATA($data);
      // var_dump($DISP_LOAN_STRING);
      $this->session->set_userdata('SESS_SUCC_MSG_ADD_PAYROLL', 'Payroll Added!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Inserted payroll data');
      redirect('payrolls/payslip_generator');
    }
    // Comapanu contributions
    function company_contributions()
    {
      $dateFilter             = $this->input->get('date_period');
      $payrollSched           = $this->payrolls_model->MOD_DISP_PAY_SCHED();
      $defaultSchedName       = "";
      $startDate              = "";
      $endDate                = "";
      if (!$dateFilter) {
        $defaultSched         = reset($payrollSched);
        $defaultSchedName     = $defaultSched->name;
        $dateFilter           = $defaultSched->id;
        $explode              = explode(" - ", $defaultSchedName);
        $startDate            = date("Y-m-d ", strtotime($explode[0]));
        $endDate              = date("Y-m-d ", strtotime($explode[1]));
      } else {
        foreach ($payrollSched as $sched) {
          if ($sched->id == $dateFilter) {
            $defaultSchedName = $sched->name;
            $explode          = explode(" - ", $defaultSchedName);
            $startDate        = date("Y-m-d ", strtotime($explode[0]));
            $endDate          = date("Y-m-d ", strtotime($explode[1]));
          }
        }
      }
      $employees                    = $this->payrolls_model->MOD_DISP_EMP_BASED_ON_HIRE_DATE($startDate, $endDate);
      $payrollData                  = $this->payrolls_model->MOD_ALL_DISP_PAYROLL_DATA_LIMIT($dateFilter, 10);
      $payrollDatas                 = $this->get_payroll_users($payrollData, $employees, $defaultSchedName);
      $data['DISP_PAYROLL_DATA']    = $payrollDatas;
      $data['DISP_PAYROLL_SCHED']   = $payrollSched;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/company_contribution_views', $data);
    }
    function thirteenth_month_pay()
    {
    }
    // 
    function get_payroll_users($payrollData, $employees, $defaultSchedName)
    {
      $payrollArr = [];
      foreach ($payrollData as $payroll) {
        foreach ($employees as $employee) {
          if ($payroll->empl_id == $employee->id) {
            if (!empty($employee->col_midl_name)) {
              $midl_ini = $employee->col_midl_name . '.';
            } else {
              $midl_ini = '';
            }
            if ($employee->col_imag_path) {
              $payroll->col_imag_path = 'user_images/' . $employee->col_imag_path;
            } else {
              $payroll->col_imag_path = 'user_images/default_profile_img3.png';
            }
            $payroll->employee_name   = $employee->col_last_name . ', ' . $employee->col_frst_name . ' ' . $midl_ini;
            $payroll->col_empl_cmid   = $employee->col_empl_cmid;
            $payroll->col_empl_type   = $employee->col_empl_type;
            $payroll->col_empl_posi   = $employee->col_empl_posi;
            $payroll->col_empl_sssc   = $employee->col_empl_sssc;
            $payroll->payroll_period  = $defaultSchedName;
            $payroll->col_empl_hdmf   = $employee->col_empl_hdmf;
            $payroll->col_empl_phil   = $employee->col_empl_phil;
            array_push($payrollArr, $payroll);
          }
        }
      }
      return $payrollArr;
    }
    // Reimburment page
    function reimbursements()
    {
      //------------------------------------------------------- START OF DYNAMIC PARAMETERS
      $user                     = $this->session->userdata('SESS_USER_ID');
      $data["view_type"]        = $view_type    = ['all', 'edit_user', $user]; //all or user
      $data["module_name"]      = $module       = 'payrolls';
      $data["page_name"]        = $page_name    = 'supports';
      $data["model_name"]       = $model        = "main_table_01_model";
      $data["table_name"]       = $table        = "tbl_hr_supports";
      $data["module"]           = ["https://testhr.technos.app/payrolls", "Payroll", "Reimbursements"];         // Main Menu Path, Module, Page Title
      $data["id_prefix"]        = "WRN";
      $data["excel_output"]     = [true, "reimbursements.xlsx"];                                                       // Enable, File Name
      $data["add_button"]       = [true, "Add Reimbursement"];                                                                 // Enable, Button Name modal_add_enable   = true;
      $data["status_text"]      = ["Active", "Inactive", "", "Pending"];                                                          //Green, Red, Orange, Gray
      $data["C_ROW_DISPLAY"]    = $filter_row = [10, 25, 50, 100];
      $c_data_tab               = array(
        array("All",      "status", "All", 0),
        array("Active",   "status", "Active", 0),
        array("Inactive", "status", "Inactive", 0)
      );
      $data["C_BULK_BUTTON"]    = array(
        array(true, "btn_mark_active",    "far fa-check-circle", "Mark as Active",    "status", "Active"),    //visible,id,icon,Button Name,column,status
        array(true, "btn_mark_inactive",  "far fa-times-circle", "Mark as Inactive",  "status", "Inactive"),    //visible,id,icon,Button Name,column,status
        array(true, "btn_mark_pending",   "fas fa-exchange-alt", "Mark as Pending",   "status", "Pending")
      );
      $data["C_DB_DESIGN"]  =
        array(
          array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
          array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
          array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
          array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
          array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
          array("title", "text", 256, 1, 1, 1, 25, "Title", "none", 1, "0"),
          array("description", "area", 256, 1, 1, 1, 30, "Description", "textarea", 1, "0"),
          array("feedback", "area", 256, 1, 1, 0, 0, "Feedback", "textarea", 1, "0"),
          array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive;Pending"),
          array("attachment", "text", 256, 1, 1, 0, 0, "Attachment", "none", 1, "0")
        );
      //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
      $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
      $data["default_row"]                      = $filter_row[0];
      $data["C_DATA_EMPL_NAME"]                 = $this->$model->get_empl_name();
      $page                                     = $this->input->get('page');
      $row                                      = $this->input->get('row');
      $tab                                      = $this->input->get('tab');
      if ($page == null) {
        $page = 1;
      }
      if ($row == null) {
        $row = $filter_row[0];
      }
      if ($tab == null) {
        $tab = "All";
      }
      $offset = $row * ($page - 1);
      if ($this->input->get('all') == null) {
        $data["C_DATA_TABLE"]                    = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
        $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
      } else {
        $data["C_DATA_TABLE"]                    = $this->$model->get_specific_data($search, $row, $offset, $view_type);
        $data["C_DATA_COUNT"]                    = $this->$model->get_data_count($table, $tab, $view_type);
      }
      $i = 0;
      foreach ($c_data_tab as $c_data_tab_row) {
        $c_data_tab[$i][3]                      = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
        $i++;
      }
      $data["C_DATA_TAB"]                       = $c_data_tab;
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_01', $data);
    }
    // Loans page
    function loans()
    {
      $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
      $employees                          = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
      $loan_types                         = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $tab                                = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                               = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                             = ($page - 1) * $row;
      $data["C_ROW_DISPLAY"]              = [25, 50, 100];
      if ($this->input->get('all') == null) {
        $payroll_loans                    = $this->payrolls_model->GET_PAYROLL_LOAN_DATA($tab, $row, $offset);
        $data_count                       = count($this->payrolls_model->GET_COUNT_PAYROLL_LOAN_DATA($tab));
      } else {
        $payroll_loans                    = $this->payrolls_model->GET_SEARCHED_LOAN_DATA($tab, $search);
        $data_count                       = count($this->payrolls_model->GET_SEARCHED_LOAN_DATA($tab, $search));
      }
      $payroll_data                       = [];
      $data['ACTIVES']                    = count($this->payrolls_model->GET_PAYROLL_LOAN_DATA_COUNT('Active'));
      $data['INACTIVES']                  = count($this->payrolls_model->GET_PAYROLL_LOAN_DATA_COUNT('InActive'));
      $data['PAGE']                       = $page;
      $page_count                         = intval($data_count / $row);
      $excess                             = $data_count % $row;
      $data['PAGES_COUNT']                = $excess > 0 ? $page_count += 1 : $page_count;
      $data['C_DATA_COUNT']               = $data_count;
      $data['ROW']                        = $row;
      $data['TAB']                        = $tab;
      $index = 0;
      if ($payroll_loans) {
        foreach ($payroll_loans as $payroll_loan) {
          $payroll_data[$index]['id']               = $payroll_loan->id;
          $payroll_data[$index]['date']             = date('F j, Y', strtotime($payroll_loan->loan_date));
          $payroll_data[$index]['loan_amount']      = $payroll_loan->loan_amount > 0 ? number_format((float)$payroll_loan->loan_amount, 2) : $payroll_loan->loan_amount;
          $payroll_data[$index]['term_amount']      = $payroll_loan->loan_terms > 0 ?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms, 2) : $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_terms']       = $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_status']      = $payroll_loan->status;
          $payroll_data[$index]['loan_id']          = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
          $payroll_data[$index]['name']             = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
          foreach ($loan_types as $loan_type) {
            if ($loan_type->id == $payroll_loan->loan_type) {
              $payroll_data[$index]['loan_type'] = $loan_type->name;
            }
          }
          $index += 1;
        }
      }
      $data['DISP_PAYROLL_LOAN'] = $payroll_data;
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/loan_views', $data);
      // 
    }
    function insert_loan()
    {
      $employee_cmid            = $this->input->post('employee_cmid');
      $loan_type                = $this->input->post('loan_type');
      $amount                   = $this->input->post('amount');
      $pay_terms                = $this->input->post('pay_terms');
      $cutoff_period            = $this->input->post('cutoff_period');
      $date                     = date('Y-m-d');
      $max_loan_id              = $this->p080_payroll_mod->MOD_GET_MAX_LOAN_PAYABLE_ID();
      $loan_id                  = $max_loan_id[0]->max_count + 1;
      $check_loan_payable       = $this->p080_payroll_mod->MOD_CHK_LOAN_PAYABLE_ALL($loan_type, $amount, $employee_cmid);
      if ($loan_id) {
        $installment            = $amount;
        $installment            = floatval($installment);
        if (count($check_loan_payable) > 0) {
          $new_load_id          = $check_loan_payable[0]->loan_id;
          $this->p080_payroll_mod->MOD_INSRT_LOAN_PAYABLE($new_load_id, $loan_type, $employee_cmid, $date, $installment, $cutoff_period);
          $this->session->set_userdata('SESS_SUCC_INSRT_LOAN', 'New Loan Added!');
          $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added loans');
          redirect('payroll/loans');
        } else {
          $this->p080_payroll_mod->MOD_INSRT_LOAN_PAYABLE($loan_id, $loan_type, $employee_cmid, $date, $installment, $cutoff_period);
          $this->session->set_userdata('SESS_SUCC_INSRT_LOAN', 'New Loan Added!');
          $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added loans');
          redirect('payroll/loans');
        }
      } else {
        $this->session->set_userdata('SESS_ERR_INSRT_LOAN', 'Saving Failed');
        redirect('payroll/loans');
      }
    }
    function bulk_loans()
    {
      $this->load->view('templates/header');
    }
    function edit_loan($id)
    {
      $data['DISP_EMPLOYEES'] = $this->payrolls_model->GET_EMPLOYEE_LIST();
      $data['LOAN_TYPES']     = $this->payrolls_model->GET_LOAN_TYPE_DATA();
      $data['LOAN_INFO']      = $this->payrolls_model->GET_SPEC_LOAN($id);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/edit_loan_views', $data);
    }
    function update_loan($id)
    {
      $inputs = $this->input->post();
      $res_new = $this->payrolls_model->UPDATE_LOAN($inputs, $id);
      if ($res_new) {
        $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Updated loan!');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated loans');
      } else {
        $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to Update loan!');
      }
      redirect('payrolls/loans');
    }
    // pay check sched
    function payroll_schedule()
    {
      //------------------------------------------------------- START OF DYNAMIC PARAMETERS
      $user                     = $this->session->userdata('SESS_USER_ID');
      $data["view_type"]        = $view_type    = ['all', 'employee_id', $user]; //all or user
      $data["module_name"]      = $module       = 'payrolls';
      $data["page_name"]        = $page_name    = 'payroll_schedules';
      $data["model_name"]       = $model        = "main_table_02_model";
      $data["table_name"]       = $table        = "tbl_payroll_period";
      $data["module"]           = [base_url() . $module, "Payroll", "Payroll Schedule"];         // Main Menu Path, Module, Page Title
      $data["id_prefix"]        = "PYS";
      $data["excel_import"]     = [false];
      $data["excel_output"]     = [false, "payroll_schedule.xlsx"];                                                       // Enable, File Name
      $data["add_button"]       = [true, "Add Period"];                                                                 // Enable, Button Name modal_add_enable   = true;
      $data["status_text"]      = ["Active", "Inactive", "", ""];                                                          //Green, Red, Orange, Gray
      $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
      $c_data_tab               = array(
        array("Active",   "status", "Active", 0),
        array("Inactive", "status", "Inactive", 0)
      );
      $data["C_BULK_BUTTON"]    = array(
        array(true, "btn_mark_active",    "far fa-check-circle", "Mark as Active",    "status", "Active"),    //visible,id,icon,Button Name,column,status
        array(true, "btn_mark_inactive",  "far fa-times-circle", "Mark as Inactive",  "status", "Inactive")    //visible,id,icon,Button Name,column,status
      );
      $data["C_DB_DESIGN"]  =
        array(
          array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
          array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
          array("name", "Title", "text-row", "0", 1, 20, 1, 1, 1, 1, 1, 1),
          array("year", "Year", "db-sel", "array2", 1, 10, 1, 1, 1, 1, 1, 1),
          array("date_from", "Start Date", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("date_to", "End Date", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("payout", "Payout Date", "date", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("pay_frequency", "Pay Frequency", "fixed-sel-direct", "Monthly;Semi-Monthly;Weekly;", 1, 10, 1, 1, 1, 1, 1, 1),
          array("connected_period", "Connected&nbsp;Period&nbsp;1", "db-sel", "array1", 1, 10, 1, 0, 1, 1, 1, 1),
          array("connected_period_2", "Connected&nbsp;Period&nbsp;2", "db-sel", "array1", 1, 10, 1, 0, 1, 1, 1, 1),
          array("connected_period_3", "Connected&nbsp;Period&nbsp;3", "db-sel", "array1", 1, 10, 1, 0, 1, 1, 1, 1),
          array("connected_period_4", "Connected&nbsp;Period&nbsp;4", "db-sel", "array1", 1, 10, 1, 0, 1, 1, 1, 1),
          array("connected_period_5", "Connected&nbsp;Period&nbsp;5", "db-sel", "array1", 1, 10, 1, 0, 1, 1, 1, 1),
          array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 10, 1, 1, 1, 1, 1, 1),
        );
      // $column         = $output_design_row[0];
      // $label          = $output_design_row[1];
      // $parameter      = $output_design_row[2];
      // $setting        = $output_design_row[3];
      // $table_display  = $output_design_row[4];
      // $table_width    = $output_design_row[5];
      // $add_display    = $output_design_row[6];
      // $add_required   = $output_design_row[7];
      // $add_enable     = $output_design_row[8];
      // $edit_display   = $output_design_row[9];
      // $edit_enable    = $output_design_row[10];
      // $show_views     = $output_design_row[11];
      $C_ARRAY_TABLE_1 = "tbl_payroll_period";
      $C_ARRAY_TABLE_2 = "tbl_std_years";
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
      if ($this->input->get('all') == null) {
        $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
        $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
      } else {
        $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
        $data["C_DATA_COUNT"]               = count($this->$model->get_specific_data($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
        // $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
      }
      $i = 0;
      foreach ($c_data_tab as $c_data_tab_row) {
        $c_data_tab[$i][3]                  = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
        $i++;
      }
      $data["C_DATA_TAB"]                   = $c_data_tab;
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_02_views', $data);
    }
    function payroll_schedules()
    {
      // $search                                   = str_replace('_', ' ', $this->input->get('search') ?? "");
      // $tab                                        = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      // $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
      // $page                                     = $this->input->get('page');
      // $row                                      = $this->input->get('row');
      // if ($row == null) {
      //   $row = 25;
      // }
      // if ($page  == null) {
      //   $page = 1;
      // }
      // $offset = $row * ($page - 1);
      // $data['TAB']                              = $tab;
      // $data['ACTIVES']                            = count($this->payrolls_model->GET_PAYROLL_SCHED_ACTIVE_COUNT('Active'));
      // $data['INACTIVES']                          = count($this->payrolls_model->GET_PAYROLL_SCHED_INACTIVE_COUNT('InActive'));
      // $years                                    = $this->payrolls_model->GET_YEARS();
      // $payroll_sched_name                       = $this->payrolls_model->GET_PAYROLL_SCHEDULE_NAME();
      // $payroll_sched                            = $this->payrolls_model->GET_PAYROLL_SCHEDULE($tab, $offset, $row);
      // foreach ($payroll_sched as $key => $payroll) {
      //   $payrollYearId = $payroll->year;
      //   $matchingYear = null;
      //   $connected_period_name = null;
      //   $connected_period_name_2 = null;
      //   $connected_period_name_3 = null;
      //   $connected_period_name_4 = null;
      //   $connected_period_name_5 = null;
      //   foreach ($years as $year) {
      //     if ($year->id === $payrollYearId) {
      //       $matchingYear = $year->name; 
      //       break; 
      //     }
      //   }
      //   if ($payroll->connected_period !== null) {
      //     foreach ($payroll_sched_name as $period) {
      //         if ($period->id === $payroll->connected_period) {
      //             $connected_period_name = $period->name;
      //             break; 
      //         }
      //     }
      //   }
      //   if ($payroll->connected_period_2 !== null) {
      //     foreach ($payroll_sched_name as $period) {
      //         if ($period->id === $payroll->connected_period_2) {
      //             $connected_period_name_2 = $period->name;
      //             break; 
      //         }
      //     }
      //   }
      //   if ($payroll->connected_period_3 !== null) {
      //     foreach ($payroll_sched_name as $period) {
      //         if ($period->id === $payroll->connected_period_3) {
      //             $connected_period_name_3 = $period->name;
      //             break; 
      //         }
      //     }
      //   }
      //   if ($payroll->connected_period_4 !== null) {
      //     foreach ($payroll_sched_name as $period) {
      //         if ($period->id === $payroll->connected_period_4) {
      //             $connected_period_name_4 = $period->name;
      //             break; 
      //         }
      //     }
      //   }
      //   if ($payroll->connected_period_5 !== null) {
      //     foreach ($payroll_sched_name as $period) {
      //         if ($period->id === $payroll->connected_period_5) {
      //             $connected_period_name_5 = $period->name;
      //             break; 
      //         }
      //     }
      //   }
      //   $payroll->year = $matchingYear;
      //   $payroll->connected_period = $connected_period_name;
      //   $payroll->connected_period_2 = $connected_period_name_2;
      //   $payroll->connected_period_3 = $connected_period_name_3;
      //   $payroll->connected_period_4 = $connected_period_name_4;
      //   $payroll->connected_period_5 = $connected_period_name_5;
      // }
      // if ($this->input->get('search') == null) {
      //   $data["DISP_PAYROLL_SCHED"]               = $payroll_sched;
      //   $data["C_DATA_COUNT"]                     = count($this->payrolls_model->GET_PAYROLL_SCHEDULE_COUNT($tab));
      // }
      $data['currentYear'] = date('Y');
      $year           =  $this->input->get('year') ? $this->input->get('year') : $data['currentYear'];
      $pay_frequency  =  $this->input->get('pay_frequency') ? $this->input->get('pay_frequency') : 'Semi-Monthly';
      $data['MONTHS'] = array();
      $payroll_sched          = $this->payrolls_model->GET_PAYROLL_SCHED($year, $pay_frequency);
      // Use an array of month names to avoid repetition
      $months = array(
        'JAN' => 'January', 'FEB' => 'February', 'MAR' => 'March',
        'APR' => 'April', 'MAY' => 'May', 'JUN' => 'June', 'JUL' => 'July', 'AUG' => 'August',
        'SEP' => 'September', 'OCT' => 'October', 'NOV' => 'November', 'DEC' => 'December'
      );
      // Loop through the array and assign the filtered payroll schedule to each month
      foreach ($months as $key => $value) {
        $data['MONTHS'][$value] = filter_payroll_sched($value, $payroll_sched);
      }
      $data['C_YEARS']          = $this->payrolls_model->GET_YEARS();
      // echo '<pre>';
      // var_dump($data); die();
      // return;
      // echo "<pre>";
      // echo "data";
      // echo "<br>";
      // print_r($year);
      // echo "<pre>"; die();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_schedules_views', $data);
    }
    function add_payroll_sched()
    {
      for ($i = 1; $i <= 12; $i++) {
        $monthObj   = DateTime::createFromFormat('!m', $i);
        $months[$i] = $monthObj->format('F');
      }
      $data['DISP_MONTHS'] = $months;
      $data['DISP_YEARS']                               = $this->payrolls_model->GET_YEARS();
      $data['PAYROLL_SCHEDULES']                        = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/add_payroll_schedule_views', $data);
    }
    function edit_payroll_sched($id)
    {
      for ($i = 1; $i <= 12; $i++) {
        $monthObj   = DateTime::createFromFormat('!m', $i);
        $months[$i] = $monthObj->format('F');
      }
      $data['DISP_MONTHS'] = $months;
      $data['DISP_YEARS']                               = $this->payrolls_model->GET_YEARS();
      $data['SPECIFIC_PAYROLL_SCHEDULES']               = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($id);
      $data['PAYROLL_SCHEDULES']                        = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/edit_payroll_schedule_views', $data);
    }
    function payroll_sched($id)
    {
      for ($i = 1; $i <= 12; $i++) {
        $monthObj   = DateTime::createFromFormat('!m', $i);
        $months[$i] = $monthObj->format('F');
      }
      $data['DISP_MONTHS'] = $months;
      $data['DISP_YEARS']                               = $this->payrolls_model->GET_YEARS();
      $data['SPECIFIC_PAYROLL_SCHEDULES']               = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($id);
      $data['PAYROLL_SCHEDULES']                        = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payroll_schedule_views', $data);
    }
    function payroll_mark_active()
    {
      $id                                         = $this->input->post('APPROVE_ID');
      $ids                                        = explode(",", $id);
      foreach ($ids as $id) {
        $this->payrolls_model->UPDATE_ACTIVE_PAYROLL_SCHED($id, 'Active');
      }
      $this->session->set_userdata('succ_approved', 'Mark as Active Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Marked payroll active');
      redirect('payrolls/payroll_schedules');
    }
    function payroll_mark_inactive()
    {
      $id                                         = $this->input->post('INACTIVE_ID');
      $ids                                        = explode(",", $id);
      foreach ($ids as $id) {
        $this->payrolls_model->UPDATE_ACTIVE_PAYROLL_SCHED($id, 'Inactive');
      }
      $this->session->set_userdata('succ_approved', 'Mark as Inactive Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Marked payroll inactive');
      redirect('payrolls/payroll_schedules');
    }
    function insert_payroll_sched()
    {
      $title                          = $this->input->post('title');
      $year                           = $this->input->post('year');
      $month                          = $this->input->post('month');
      $start_date                     = $this->input->post('start_date');
      $end_date                       = $this->input->post('end_date');
      $payout_date                    = $this->input->post('payout_date');
      $payslip_schedule_viewing       = $this->input->post('payslip_schedule_viewing');
      $pay_freq                       = $this->input->post('pay_freq');
      $con_period_1                   = $this->input->post('con_period_1');
      $con_period_2                   = $this->input->post('con_period_2');
      $con_period_3                   = $this->input->post('con_period_3');
      $con_period_4                   = $this->input->post('con_period_4');
      $con_period_5                   = $this->input->post('con_period_5');
      $status                         = $this->input->post('status');
      $input_sss                      = $this->input->post('input_sss');
      $input_phil                     = $this->input->post('input_phil');
      $input_pagibig                  = $this->input->post('input_pagibig');
      $input_wtax                     = $this->input->post('input_wtax');
      // $input_ta                       = $this->input->post('input_ta');
      // $input_nta                      = $this->input->post('input_nta');
      $input_tax_allowance            = $this->input->post('input_tax_allowance');
      $input_nontax_allowance         = $this->input->post('input_nontax_allowance');
      $input_loans                    = $this->input->post('input_loans');
      $input_adjustment               = $this->input->post('input_adjustment');
      $input_tard                     = $this->input->post('input_tard');
      $datesError = '';
      if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $start_date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $start_date)) {
        $datesError = 'Invalid Start Date';
      }
      if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $end_date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $end_date)) {
        if (empty($datesError)) {
          $datesError = 'Invalid End Date';
        } else {
          $datesError = $datesError . '. Invalid End Date';
        }
      }
      if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $payout_date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $payout_date)) {
        if (empty($datesError)) {
          $datesError = 'Invalid Payout Date';
        } else {
          $datesError = $datesError . '. Invalid Payout Date';
        }
      }
      if ($datesError) {
        $this->session->set_flashdata('ERR', $datesError);
        redirect('payrolls/add_payroll_sched');
      }
      ($input_sss != null) ? $input_sss = 0 : $input_sss = 1;
      ($input_phil != null) ? $input_phil = 0 : $input_phil = 1;
      ($input_pagibig != null) ? $input_pagibig = 0 : $input_pagibig = 1;
      ($input_wtax != null) ? $input_wtax = 0 : $input_wtax = 1;
      ($input_tax_allowance != null) ? $input_tax_allowance = 0 : $input_tax_allowance = 1;
      ($input_nontax_allowance != null) ? $input_nontax_allowance = 0 : $input_nontax_allowance = 1;
      ($input_loans != null) ? $input_loans = 0 : $input_loans = 1;
      ($input_adjustment != null) ? $input_adjustment = 0 : $input_adjustment = 1;
      ($input_tard != null) ? $input_tard = 0 : $input_tard = 1;
      $res = $this->payrolls_model->INSERT_PAYROLL_SCHEDULE($title, $year, $month, $start_date, $end_date, $payout_date, $payslip_schedule_viewing, $pay_freq, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $status, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard);

      if ($res) {
        $this->session->set_flashdata('SUCC', 'Added Successfully!');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added payroll schedule');
      }

      redirect('payrolls/payroll_schedules');
    }
    function edit_specific_payroll_sched($id)
    {
      $title                          = $this->input->post('title');
      $year                           = $this->input->post('year');
      $month                          = $this->input->post('month');
      $start_date                     = $this->input->post('start_date');
      $end_date                       = $this->input->post('end_date');
      $payout_date                    = $this->input->post('payout_date');
      $payslip_schedule               = $this->input->post('payslip_schedule_viewing');
      $pay_freq                       = $this->input->post('pay_freq');
      $con_period_1                   = $this->input->post('con_period_1');
      $con_period_2                   = $this->input->post('con_period_2');
      $con_period_3                   = $this->input->post('con_period_3');
      $con_period_4                   = $this->input->post('con_period_4');
      $con_period_5                   = $this->input->post('con_period_5');
      $status                         = $this->input->post('status');
      $input_sss                      = $this->input->post('input_sss');
      $input_phil                     = $this->input->post('input_phil');
      $input_pagibig                  = $this->input->post('input_pagibig');
      $input_wtax                     = $this->input->post('input_wtax');
      // $input_ta                       = $this->input->post('input_ta');
      // $input_nta                      = $this->input->post('input_nta');
      $input_tax_allowance            = $this->input->post('input_tax_allowance');
      $input_nontax_allowance         = $this->input->post('input_nontax_allowance');
      $input_loans                    = $this->input->post('input_loans');
      $input_adjustment               = $this->input->post('input_adjustment');
      $input_tard                     = $this->input->post('input_tard');
      ($input_sss != null) ? $input_sss = 0 : $input_sss = 1;
      ($input_phil != null) ? $input_phil = 0 : $input_phil = 1;
      ($input_pagibig != null) ? $input_pagibig = 0 : $input_pagibig = 1;
      ($input_wtax != null) ? $input_wtax = 0 : $input_wtax = 1;
      ($input_tax_allowance != null) ? $input_tax_allowance = 0 : $input_tax_allowance = 1;
      ($input_nontax_allowance != null) ? $input_nontax_allowance = 0 : $input_nontax_allowance = 1;
      ($input_loans != null) ? $input_loans = 0 : $input_loans = 1;
      ($input_adjustment != null) ? $input_adjustment = 0 : $input_adjustment = 1;
      ($input_tard != null) ? $input_tard = 0 : $input_tard = 1;
      $this->payrolls_model->EDIT_PAYROLL_SCHEDULE($title, $year, $month, $start_date, $end_date, $payout_date, $payslip_schedule, $pay_freq, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $status, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard, $id);
      $this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Edited payroll schedule');
      redirect('payrolls/payroll_schedules');
    }

    function contributions(){

      $cb_sss = $this->input->post('cb_sss');
      $cb_phil = $this->input->post('cb_phil');
      $cb_pagibig = $this->input->post('cb_pagibig');
      $input_wtax = $this->input->post('input_wtax');
      $input_ta = $this->input->post('input_ta');
      $input_nta = $this->input->post('input_nta');
      $input_loans = $this->input->post('input_loans');
      $input_adjustment = $this->input->post('input_adjustment');
      $input_tard = $this->input->post('input_tard');
      $period = $this->input->post('cut_off_period');

      ($cb_sss != null)                ? $cb_sss = 0            : $cb_sss = 1;
      ($cb_phil != null)               ? $cb_phil = 0           : $cb_phil = 1;
      ($cb_pagibig != null)            ? $cb_pagibig = 0        : $cb_pagibig = 1;
      ($input_wtax != null)            ? $input_wtax = 0        : $input_wtax = 1;
      ($input_ta != null)              ? $input_ta = 0          : $input_ta = 1;
      ($input_nta != null)             ? $input_nta = 0         : $input_nta = 1;
      ($input_loans != null)           ? $input_loans = 0       : $input_loans = 1;
      ($input_adjustment != null)      ? $input_adjustment = 0  : $input_adjustment = 1;
      ($input_tard != null)            ? $input_tard = 0        : $input_tard = 1;

      $this->payrolls_model->EDIT_PAYROLL_SCHEDULE_CONTRIBUTION($cb_sss, $cb_phil, $cb_pagibig, $input_wtax, $input_ta, $input_nta, $input_loans, $input_adjustment, $input_tard, $period);
      $this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated contribution settings');
      redirect($_SERVER["HTTP_REFERER"]);
    }
    // INSERT POSITION
    function insrt_pay_schedule()
    {
      $date_range             = $this->input->post('date_range');
      $db_date_range          = $this->input->post('PAY_SCHED_INPF_NAME');
      $payout_sched           = $this->input->post('payout_sched');
      $this->p175_payschedule_mod->MOD_INSRT_PAY_SCHED($date_range, $db_date_range, $payout_sched);
      $this->session->set_userdata('SESS_SUCC_MSG_INSRT_PAY_SCHED', 'Added Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added pay schedule');
      redirect('payrolls/payroll_schedules');
    }
    function updt_pay_schedule()
    {
      $updt_date_range        = $this->input->post('updt_date_range');
      $updt_db_date_range     = $this->input->post('UPDT_PAY_SCHED_INPF_NAME');
      $UPDT_PAY_SCHED_INPF_ID = $this->input->post('UPDT_PAY_SCHED_INPF_ID');
      $updt_payout_sched      = $this->input->post('updt_payout_sched');
      $this->p175_payschedule_mod->MOD_UPDT_PAY_SCHED($updt_date_range, $updt_db_date_range, $updt_payout_sched, $UPDT_PAY_SCHED_INPF_ID);
      $this->session->set_userdata('SESS_SUCC_MSG_UPDT_PAY_SCHED', 'Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated pay schedule');
      redirect('payrolls/payroll_schedules');
    }
    // DELETE POSITION
    function dlt_pay_schedule()
    {
      $pay_schedule_id        = $this->input->get('delete_id');
      $this->p175_payschedule_mod->MOD_DLT_PAY_SCHED($pay_schedule_id);
      $this->session->set_userdata('SESS_SUCC_MSG_DLT_PAY_SCHED', 'Deleted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted pay schedule');
      redirect('payrolls/payroll_schedules');
    }
    // sss rates page
    function sss_rates()
    {
      //------------------------------------------------------- START OF DYNAMIC PARAMETERS
      $user                     = $this->session->userdata('SESS_USER_ID');
      $data["view_type"]        = $view_type    = ['all', 'employee_id', $user]; //all or user
      $data["module_name"]      = $module       = 'payrolls';
      $data["page_name"]        = $page_name    = 'sss_rates';
      $data["model_name"]       = $model        = "main_table_02_model";
      $data["table_name"]       = $table        = "tbl_payroll_sss";
      $data["module"]           = [base_url() . $module, "Payroll", "SSS Rates"];         // Main Menu Path, Module, Page Title
      $data["id_prefix"]        = "SSS";
      $data["excel_import"]     = [false];
      $data["excel_output"]     = [false, "sss.xlsx"];                                                       // Enable, File Name
      $data["add_button"]       = [true, "Add Rate"];                                                                 // Enable, Button Name modal_add_enable   = true;
      $data["status_text"]      = ["", "", "", ""];                                                          //Green, Red, Orange, Gray
      $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
      $c_data_tab             = array(
        array(2023, "year", 2023, 0),
        array(2022, "year", 2022, 0),
        array(2021, "year", 2021, 0)
      );
      $data["C_BULK_BUTTON"]  = array();
      $data["C_DB_DESIGN"]  =
        array(
          array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
          array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
          // array("year", "year", "number", "0", 1, 10, 1, 1, 0, 0, 0, 1),
          array("year", "year", "fixed-sel-direct", "2023;2022;2021", 1, 10, 1, 1, 1, 0, 0, 1),
          array("salary_min", "salary_min", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("salary_max", "salary_max", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("msc_rss_ec", "msc_rss_ec", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("msc_mpf", "msc_mpf", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("msc_tot", "msc_tot", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("rss_er", "rss_er", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("rss_ee", "rss_ee", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("rss_tot", "rss_tot", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("ec_er", "ec_er", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("ec_ee", "ec_ee", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("ec_tot", "ec_tot", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("mpf_er", "mpf_er", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("mpf_ee", "mpf_ee", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("mpf_tot", "mpf_tot", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("er", "er", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("ee", "ee", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("tot", "tot", "number", "1", 1, 10, 1, 1, 1, 1, 1, 1),
          array("status", "Status", "text-row", "1", 1, 10, 1, 1, 1, 1, 1, 1),
        );
      $C_ARRAY_TABLE_1 = "";
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
      if ($this->input->get('all') == null) {
        $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
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
      $data["C_DATA_TAB"]                   = $c_data_tab;
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_02_views', $data);
    }
    function philhealth_rates()
    {
      //------------------------------------------------------- START OF DYNAMIC PARAMETERS
      $user                     = $this->session->userdata('SESS_USER_ID');
      $data["view_type"]        = $view_type    = ['all', 'employee_id', $user]; //all or user
      $data["module_name"]      = $module       = 'payrolls';
      $data["page_name"]        = $page_name    = 'philhealth_rates';
      $data["model_name"]       = $model        = "main_table_02_model";
      $data["table_name"]       = $table        = "tbl_payroll_philhealth";
      $data["module"]           = [base_url() . $module, "Payroll", "Philhealth Rates"];         // Main Menu Path, Module, Page Title
      $data["id_prefix"]        = "PHL";
      $data["excel_import"]     = [false];
      $data["excel_output"]     = [false, "philhealth.xlsx"];                                                       // Enable, File Name
      $data["add_button"]       = [true, "Add Rate"];                                                                 // Enable, Button Name modal_add_enable   = true;
      $data["status_text"]      = ["", "", "", ""];                                                          //Green, Red, Orange, Gray
      $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
      $c_data_tab               = array(
        array(2023, "year", 2023, 0),
        array(2022, "year", 2022, 0),
        array(2021, "year", 2021, 0)
      );
      $data["C_BULK_BUTTON"]    = array();
      $data["C_DB_DESIGN"]  =
        array(
          array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
          array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
          // array("year", "Year", "number", "0", 1, 30, 1, 1, 0, 0, 0, 1),
          array("year", "year", "fixed-sel-direct", "2023;2022;2021", 1, 10, 1, 1, 1, 0, 0, 1),
          array("rate", "Rate", "number", "0", 1, 30, 1, 1, 1, 1, 1, 1),
          array("status", "Status", "fixed-sel-direct", "Active;Inactive", 1, 25, 1, 1, 1, 1, 1, 1),
        );
      $C_ARRAY_TABLE_1 = "";
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
      if ($this->input->get('all') == null) {
        $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
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
      $data["C_DATA_TAB"]                   = $c_data_tab;
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_02_views', $data);
    }
    // hdmf_rates page
    function hdmf_rates()
    {
      //------------------------------------------------------- START OF DYNAMIC PARAMETERS
      $user                     = $this->session->userdata('SESS_USER_ID');
      $data["view_type"]        = $view_type    = ['all', 'employee_id', $user]; //all or user
      $data["module_name"]      = $module       = 'payrolls';
      $data["page_name"]        = $page_name    = 'hdmf_rates';
      $data["model_name"]       = $model        = "main_table_02_model";
      $data["table_name"]       = $table        = "tbl_payroll_hdmf";
      $data["module"]           = [base_url() . $module, "Payroll", "HDMF Rates"];         // Main Menu Path, Module, Page Title
      $data["id_prefix"]        = "HDF";
      $data["excel_import"]     = [false];
      $data["excel_output"]     = [false, "hdmf.xlsx"];                                                       // Enable, File Name
      $data["add_button"]       = [true, "Add Rate"];                                                                 // Enable, Button Name modal_add_enable   = true;
      $data["status_text"]      = ["", "", "", ""];                                                          //Green, Red, Orange, Gray
      $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
      $c_data_tab             = array(
        array(2023, "year", 2023, 0),
        array(2022, "year", 2022, 0),
        array(2021, "year", 2021, 0)
      );
      $data["C_BULK_BUTTON"]  = array();
      $data["C_DB_DESIGN"]  =
        array(
          array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
          array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
          // array("year", "Year", "number", "0", 1, 10, 1, 1, 0, 0, 0, 1),
          array("year", "year", "fixed-sel-direct", "2023;2022;2021", 1, 10, 1, 1, 1, 0, 0, 1),
          array("ee", "Employee", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("er", "Employer", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("status", "Status", "fixed-sel-direct", "Active;Inactive", 1, 10, 1, 1, 1, 1, 1, 1),
        );
      $C_ARRAY_TABLE_1 = "";
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
      if ($this->input->get('all') == null) {
        $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
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
      $data["C_DATA_TAB"]                   = $c_data_tab;
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_02_views', $data);
    }
    function tax_rates()
    {
      //------------------------------------------------------- START OF DYNAMIC PARAMETERS
      $user                     = $this->session->userdata('SESS_USER_ID');
      $data["view_type"]        = $view_type    = ['all', 'employee_id', $user]; //all or user
      $data["module_name"]      = $module       = 'payrolls';
      $data["page_name"]        = $page_name    = 'tax_rates';
      $data["model_name"]       = $model        = "main_table_02_model";
      $data["table_name"]       = $table        = "tbl_payroll_tax";
      $data["module"]           = [base_url() . $module, "Payroll", "Withholding Tax"];         // Main Menu Path, Module, Page Title
      $data["id_prefix"]        = "TAX";
      $data["excel_import"]     = [false];
      $data["excel_output"]     = [false, "wtax.xlsx"];                                                       // Enable, File Name
      $data["add_button"]       = [true, "Add Rate"];                                                                 // Enable, Button Name modal_add_enable   = true;
      $data["status_text"]      = ["", "", "", ""];                                                          //Green, Red, Orange, Gray
      $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
      $c_data_tab               = array(
        array(2023, "year", 2023, 0),
        array(2022, "year", 2022, 0),
        array(2021, "year", 2021, 0)
      );
      $data["C_BULK_BUTTON"]    = array();
      $data["C_DB_DESIGN"]  =
        array(
          array("id", "ID", "id", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 0, 0, 1),
          array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 0, 0, 1),
          array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
          array("year", "year", "fixed-sel-direct", "2023;2022;2021", 1, 10, 1, 1, 0, 0, 0, 1),
          array("salary_min", "salary_min", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("salary_max", "salary_max", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("fixed", "fixed", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("c_level", "c_level", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("c_percent", "c_percent", "number", "0", 1, 10, 1, 1, 1, 1, 1, 1),
          array("status", "Status", "fixed-sel-direct", "Active;Inactive", 1, 10, 1, 1, 1, 1, 1, 1),
        );
      $C_ARRAY_TABLE_1 = "";
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
      if ($this->input->get('all') == null) {
        $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
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
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_02_views', $data);
    }
    //-------------------------------------------------------- CRUD FUNCTIONS starts
    function get_data_all_list()
    {
      $model            = $this->input->post('model_name');
      $table            = $this->input->post('table_name');
      $modal_id         = $this->input->post('modal_id');
      $data = $this->$model->get_data_row($table, $modal_id);
      echo (json_encode($data));
    }
    function show_data()
    {
      $data["model_name"]       = $model  = "main_table_01_model";
      $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_show', $data);
    }
    function edit_data()
    {
      $data["model_name"]       = $model  = "main_table_01_model";
      $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_edit', $data);
    }
    function add_data()
    {
      $data["model_name"]       = $model  = "main_table_01_model";
      $this->load->view('templates/header');
      $this->load->view('templates/main_table_add', $data);
    }
    function edit_row()
    {
      $edit_user = $this->session->userdata('SESS_USER_ID');
      $input_data = $this->input->get();
      $set_array = array();
      foreach ($input_data as $key => $value) {
        if ($key == "id") {
          $id = $value;
        } else if ($key == "table") {
          $table = $value;
        } else if ($key == "module") {
          $module_name = $value;
        } else if ($key == "page") {
          $page_name = $value;
        } else {
          $set_array[$key] = $value;
        }
      }
      $set_array['edit_user'] = $edit_user;
      $this->main_table_01_model->edit_table_row($table, $id, $set_array);
      $this->session->set_userdata('success', 'Submitted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Edited payroll data');
      redirect($module_name . "/" . $page_name);
    }
    function add_row()
    {
      $edit_user          = $this->session->userdata('SESS_USER_ID');
      $input_data         = $this->input->get();
      $set_array          = array();
      foreach ($input_data as $key => $value) {
        if ($key == "table") {
          $table = $value;
        } else if ($key == "module") {
          $module_name = $value;
        } else if ($key == "page") {
          $page_name = $value;
        } else {
          $set_array[$key] = $value;
        }
      }
      $set_array['edit_user'] = $edit_user;
      $this->main_table_01_model->add_table_row($table, $set_array);
      $this->session->set_userdata('success', 'Submitted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added payroll data');
      redirect($module_name . "/" . $page_name);
    }
    function delete_row()
    {
      $edit_user    = $this->session->userdata('SESS_USER_ID');
      $id           = $this->input->get('delete_id');
      $table        = $this->input->get('table');
      $module_name  = $this->input->get('module');
      $page_name    = $this->input->get('page');
      $this->main_table_01_model->delete_table_row($id, $table, $edit_user);
      $this->session->set_userdata('delete', 'Deleted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted payroll data');
      redirect($module_name . "/" . $page_name);
    }
    function edit_bulk_status()
    {
      $edit_user            = $this->session->userdata('SESS_USER_ID');
      $status               = $this->input->post('modal_title');
      $ids                  = $this->input->post('list_mark_ids');
      $ids_int              = array_map('intval', explode(',', $ids));
      $module_name          = $this->input->get('module');
      $page_name            = $this->input->get('page_name');
      $table                = $this->input->get('table');
      $page                 = $this->input->get('page');
      $row_url              = '&row=';
      $row                  = $this->input->get('row');
      $tab                  = $this->input->get('tab');
      if ($page == null) {
        $page = 1;
      }
      if ($row == null) {
        $row_url = '';
        $row = '';
      }
      if ($tab == null) {
        $tab = "All";
      }
      // var_dump($status . $ids );
      $this->main_table_01_model->edit_bulk_status($table, $status, $ids_int, $edit_user);
      $this->session->set_userdata('success', 'Submitted Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated bulk payroll status');
      //  var_dump($ids_int);
      redirect($module_name . '/' . $page_name . '?page=' . $page . $row_url . $row . '&tab=' . $tab);
    }
    function payroll_assignment_update($user_id, $value)
    {
      $result                 = $this->payrolls_model->GET_SPECIFIC_PAYROLL_ASSIGNMENT($user_id);
      if ($result > 0) {
        $this->payrolls_model->UPDATE_PAYROLL_ASSIGNMENT($user_id, $value);
      } else {
        $this->payrolls_model->INSERT_PAYROLL_ASSIGNMENT($user_id, $value);
      }
      $this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
      // redirect('payrolls/payroll_assignment');
    }
    function update_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $assignmentMapping = [
        "Rank & File/Managers" => '1',
        "Rank & File" => '0',
      ];
      foreach ($data as &$item) {
        if (isset($item['assignment'])) {
          $assignment = $item['assignment'];
          $item['assignment'] = isset($assignmentMapping[$assignment]) ? $assignmentMapping[$assignment] : '0';
        }
      }
      try {
        foreach ($data as $data_row) {
          $this->payrolls_model->update_assignment_data($data_row);
        }
        $response = array('success_message' => 'Data updated successfully');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated payroll data');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($data);
    }
    function update_custom_contributions()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $year = $data['year'];
      try {
        foreach ($updatedData as $data_row) {
          $this->payrolls_model->update_custom_contribution_data($data_row, $year);
        }
        $response = array('success_message' => 'Data updated successfully');
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated payroll data');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function update_payroll_assignment_bulk()
    {
      $empl_id                 = $this->input->post('UPDATE_ID');
      $value                   = $this->input->post('UPDT_PAYROLL_ASSIGN');
      $empl_ids = explode(",", $empl_id);
      foreach ($empl_ids as $id) {
        $result = $this->payrolls_model->GET_SPECIFIC_PAYROLL_ASSIGNMENT($id);
        if ($result > 0) {
          $this->payrolls_model->UPDATE_PAYROLL_ASSIGNMENT($id, $value);
        } else {
          $this->payrolls_model->INSERT_PAYROLL_ASSIGNMENT($id, $value);
        }
      }
      $this->session->set_userdata('SESS_SUCCESS', 'Bulk Updated Successfully!');
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated payroll assignment (bulk)');
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
      // redirect('payrolls/payroll_assignment');
    }
    function with_payslip($period = null)
    {
      if ($period == "" || $period == null) {
        $period                           = $this->payrolls_model->MOD_DISP_PAY_SCHED_LATEST();
      }
      $data['PAYSLIPS']                      = $this->payrolls_model->GET_EXPORT_PAYROLL_PAYSLIP($period);
      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/with_payslip_views', $data);
    }
    public function export_csv($period = null)
    {
      /* file name */
      if ($period == "" || $period == null) {
        $period                           = $this->payrolls_model->MOD_DISP_PAY_SCHED_LATEST();
      }
      $filename             = 'Payslip_' . date('Y-m-d') . '.csv';
      header("Content-Description: File Transfer");
      header("Content-Disposition: attachment; filename=$filename");
      header("Content-Type: application/csv; ");
      /* get data */
      $payslip              = $this->payrolls_model->GET_EXPORT_PAYROLL_PAYSLIP($period);
      /* file creation */
      $file = fopen('php://output', 'w');
      $header = array(
        "Payslip Id", "Employee Id", "Employee Name", "Salary Rate", "Salary Type", "Daily Rate", "Hourly Rate", "Period", "Present", "Absent", "Tardiness", "Undertime", "Paid Leave", "REG Hours",
        "REG OT", "REG ND", "REG NDOT", "Rest Hours", "Rest OT", "Rest ND", "Rest NDOT", "LEG Hours", "LEG OT", "LEG ND", "LEG NDOT", "Legrest Hours", "Legrest OT", "Legrest ND", "Legrest NDOT",
        "SPE hours", "SPE OT", "SPE ND", "SPE NDOT", "Sperest Hours", "Sperest OT", "Sperest ND", "Sperest NDOT", "Earnings", "Deduction", "WTAX", "Net Income", "Loan Id", "Gross Income",
        "SSS EE Current", "Pagibig EE Current", "PhilHealth EE Current", "SSS ER Current", "SSS EC ER Current", "PagIbig ER Current", "PhilHealth ER Current", "CA Id", "Deduct Id", "Status", "Loan List", "CA List", "Deduct List"
      );
      fputcsv($file, $header);
      foreach ($payslip as $key => $line) {
        $line['id']         = 'PAYSLIP' . str_pad($line['id'], 5, '0', STR_PAD_LEFT);
        fputcsv($file, $line);
      }
      fclose($file);
      exit;
    }
    public function downloadExcel()
    {
      // Define the path to the Excel file
      $excelFilePath = FCPATH . 'assets_system/sample_file/suminac_payroll_template.xlsx';
      // Check if the file exists
      if (file_exists($excelFilePath)) {
        // Set the appropriate headers for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($excelFilePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($excelFilePath));
        // Read and output the file
        readfile($excelFilePath);
        exit;
      } else {
        // Handle the case where the file does not exist
        show_error('The file does not exist.', 404);
      }
    }


    function payslip_setting(){
      $data['EMPL_ID_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_id_x');
      $data['EMPL_ID_Y']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_id_y');
      $data['EMPL_NAME_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_name_x');
      $data['EMPL_NAME_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('employee_name_y');
      $data['DESIGNATION_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('designation_x');
      $data['DESIGNATION_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('designation_y');
      $data['PERIOD_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payroll_period_x');
      $data['PERIOD_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payroll_period_y');
      $data['PAYOUT_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payout_date_x');
      $data['PAYOUT_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('payout_date_y');
      $data['BANK_ACCT_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('bank_account_x');
      $data['BANK_ACCT_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('bank_account_y');
      $data['SALARY_TYPE_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('salary_type_x');
      $data['SALARY_TYPE_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('salary_type_y');
      $data['MONTHLY_SALARY_X']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('monthly_salary_x');
      $data['MONTHLY_SALARY_Y']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('monthly_salary_y');
      $data['DAILY_SALARY_X']                 = $this->payrolls_model->GET_PAYSLIP_COORDINATES('daily_salary_x');
      $data['DAILY_SALARY_Y']                 = $this->payrolls_model->GET_PAYSLIP_COORDINATES('daily_salary_y');
      $data['HDMF_NO_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_no_x');
      $data['HDMF_NO_Y']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_no_y');
      $data['PHILHEALTH_NO_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_no_x');
      $data['PHILHEALTH_NO_Y']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_no_y');
      $data['TIN_NO_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tin_no_x');
      $data['TIN_NO_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tin_no_y');
      $data['SSS_NO_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_no_x');
      $data['SSS_NO_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_no_y');
      $data['WTAX_X']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_x');
      $data['WTAX_Y']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_y');
      $data['SSS_X']                          = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_x');
      $data['SSS_Y']                          = $this->payrolls_model->GET_PAYSLIP_COORDINATES('sss_y');
      $data['PHILHEALTH_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_x');
      $data['PHILHEALTH_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('philhealth_y');
      $data['HDMF_X']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_x');
      $data['HDMF_Y']                         = $this->payrolls_model->GET_PAYSLIP_COORDINATES('hdmf_y');
      $data['REGWRK_HRS_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_hrs_x');
      $data['REGWRK_HRS_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_hrs_y');
      $data['REGWRK_AMT_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_amt_x');
      $data['REGWRK_AMT_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('regwrk_amt_y');
      $data['PDLEAVE_HRS_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_hrs_x');
      $data['PDLEAVE_HRS_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_hrs_y');
      $data['PDLEAVE_AMT_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_amt_x');
      $data['PDLEAVE_AMT_Y']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('pdLeave_amt_y');
      $data['LEGHOL_HRS_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_hrs_x');
      $data['LEGHOL_HRS_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_hrs_y');
      $data['LEGHOL_AMT_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_amt_x');
      $data['LEGHOL_AMT_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('legHol_amt_y');
      $data['ABSENT_HRS_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_hrs_x');
      $data['ABSENT_HRS_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_hrs_y');
      $data['ABSENT_AMT_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_amt_x');
      $data['ABSENT_AMT_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('absent_amt_y');
      $data['TARD_HRS_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_hrs_x');
      $data['TARD_HRS_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_hrs_y');
      $data['TARD_AMT_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_amt_x');
      $data['TARD_AMT_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tard_amt_y');
      $data['UT_HRS_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_hrs_x');
      $data['UT_HRS_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_hrs_y');
      $data['UT_AMT_X']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_amt_x');
      $data['UT_AMT_Y']                       = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ut_amt_y');
      $data['UBRK_HRS_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_hrs_x');
      $data['UBRK_HRS_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_hrs_y');
      $data['UBRK_AMT_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_amt_x');
      $data['UBRK_AMT_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ubrk_amt_y');
      $data['OBRK_HRS_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_hrs_x');
      $data['OBRK_HRS_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_hrs_y');
      $data['OBRK_AMT_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_amt_x');
      $data['OBRK_AMT_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('obrk_amt_y');
      $data['TOTALBP_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('totalbp_x');
      $data['TOTALBP_Y']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('totalbp_y');
      $data['OTPAY_DES_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_des_x');
      $data['OTPAY_HRS_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_hrs_x');
      $data['OTPAY_AMT_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_amt_x');
      $data['OTPAY_Y']                        = $this->payrolls_model->GET_PAYSLIP_COORDINATES('otpay_y');
      $data['NDPAY_DES_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_des_x');
      $data['NDPAY_HRS_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_hrs_x');
      $data['NDPAY_AMT_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_amt_x');
      $data['NDPAY_Y']                        = $this->payrolls_model->GET_PAYSLIP_COORDINATES('ndpay_y');
      $data['TOTAL_OTND_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_otnd_x');
      $data['TOTAL_OTND_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_otnd_y');
      $data['GROSS_TAX_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('gross_tax_x');
      $data['GROSS_TAX_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('gross_tax_y');
      $data['EXCLUSION_X']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('exclusion_x');
      $data['EXCLUSION_Y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('exclusion_y');
      $data['WTAX_YTD_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_ytd_x');
      $data['WTAX_YTD_Y']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('wtax_ytd_y');
      $data['TAXABLE_INCOME_Y']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('taxable_income_y');
      $data['TAX_DESC_X']                     = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tax_description_x');
      $data['TAX_AMT_X']                      = $this->payrolls_model->GET_PAYSLIP_COORDINATES('tax_amount_x');
      $data['TOTAL_OTH_TAX_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_tax_x');
      $data['TOTAL_OTH_TAX_Y']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_tax_y');
      $data['NON_TAXABLE_INCOME_Y']           = $this->payrolls_model->GET_PAYSLIP_COORDINATES('non_taxable_income_y');
      $data['NON_TAX_DESC_X']                 = $this->payrolls_model->GET_PAYSLIP_COORDINATES('non_tax_description_x');
      $data['NON_TAX_AMT_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('non_tax_amount_x');
      $data['TOTAL_OTH_NONTAX_X']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_nontax_x');
      $data['TOTAL_OTH_NONTAX_Y']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_oth_nontax_y');
      $data['LOAN_OTHER_DEDUCTIONS_Y']        = $this->payrolls_model->GET_PAYSLIP_COORDINATES('loan_deductions_y');
      $data['OTHER_CODE_X']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_code_x');
      $data['OTHER_START_X']                  = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_start_x');
      $data['OTHER_PAYABLE_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_payable_x');
      $data['OTHER_DEDUCTED_X']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_deducted_x');
      $data['OTHER_BAL_AMT_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('other_bal_amt_x');
      $data['LEAVE_VAC_USED_X']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_vac_used_x');
      $data['LEAVE_VAC_y']                    = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_vac_y');
      $data['LEAVE_VAC_BAL_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_vac_bal_x');
      $data['LEAVE_SICK_USED_X']              = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_sick_used_x');
      $data['LEAVE_SICK_Y']                   = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_sick_y');
      $data['LEAVE_SICK_BAL_x']               = $this->payrolls_model->GET_PAYSLIP_COORDINATES('leave_sick_bal_x');
      $data['TOTAL_GROSS_PAY_X']              = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_gross_pay_x');
      $data['TOTAL_GROSS_PAY_Y']              = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_gross_pay_y');
      $data['TOTAL_DEDUCTIONS_X']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_deductions_x');
      $data['TOTAL_DEDUCTIONS_Y']             = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_deductions_y');
      $data['TOTAL_NET_PAY_X']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_net_pay_x');
      $data['TOTAL_NET_PAY_Y']                = $this->payrolls_model->GET_PAYSLIP_COORDINATES('total_net_pay_y');

      $data['PAYSLIP_FORM']                   = $this->payrolls_model->GET_PAYSLIP_FORM('1');

      $navbar_val                                 = $this->payrolls_model->get_value_navbar();
      if (file_exists(FCPATH . 'assets_system/images/' . $navbar_val)) {
        $data['DISP_NAV'] = $navbar_val;
      } else if (file_exists(FCPATH . 'assets_system/images/default_logo.png')) {
        $data['DISP_NAV'] = 'default_logo.png';
      } else {
        $data['DISP_NAV'] = null;
      }

      $this->load->view('templates/header');
      $this->load->view('modules/payrolls/payslip_setting_views', $data);
    }

    function payslip_coordinates_setting(){
      $coordinates                   = $this->input->post();
      $this->payrolls_model->UPDATE_COORDINATES($coordinates);
      $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated payroll data');
      redirect($this->input->server('HTTP_REFERER'));
    }

    function payslip_format(){
      $old_image = $this->input->post('old_image');
      $u_image    = $_FILES['update_image']['name'];
          
      // $rand = uniqid();
      // set uploading file config
      $config['upload_path'] = './assets_user/files/payslips/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = '5000';
      $config['file_name'] = $u_image;  //$rand.$u_image;
      $config['overwrite'] = 'TRUE';
      $this->load->library('upload', $config);

      if($_FILES['update_image']['size'] != 0){
          if($this->upload->do_upload('update_image')){
              if(file_exists('./assets_user/files/payslips/'.$old_image)){ // removed old image
                  unlink('./assets_user/files/payslips/'.$old_image); // /assets_system/files/images/
              }
              $data_upload = array('update_image' => $this->upload->data());
              $upload_img = $data_upload['update_image']['file_name'];
              $this->payrolls_model->INSERT_PAYSLIP_IMAGE($old_image, $upload_img); // save new image to the databaes
              $this->session->set_userdata('SESS_SUCCESS', 'Submitted Successfully');
              $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated payroll data');
              // redirect('admin/emp_form');
          }
      }
      redirect($this->input->server('HTTP_REFERER'));
    }


    //-------------------------------------------------------- CRUD FUNCTIONS ends
  }
  function filter_payroll_sched($month, $data)
  {
    $filtered_data = array();
    foreach ($data as $sched) {
      if ($sched->month == $month) {
        $filtered_data[] = $sched;
      }
    }
    return $filtered_data;
  }
  function filter_array($user_modules, $user_access)
  {
    $modules = array();
    foreach ($user_modules as $module) {
      foreach ($user_access as $access) {
        if ($module["title"] == $access) {
          $modules[] = $module;
        }
      }
    }
    $modules = array_unique($modules, SORT_REGULAR);
    return $modules;
  }
