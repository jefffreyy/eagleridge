<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class payrolls extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('modules/payrolls_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->library('pagination');
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
      array("title" => "Payslip Generator",     "value" => "Payslip Generator",     "icon" => "fa-duotone fa-print",                                "url" => "payrolls/payslip_generator",       "access" => "Payroll", "id" => "payslip_generator"),
      array("title" => "Company Contributions", "value" => "Company Contributions", "icon" => "fa-duotone fa-buildings",                            "url" => "payrolls/company_contributions",   "access" => "Payroll", "id" => "company_contributions"),
      array("title" => "13th Month Pay",        "value" => "13th Month Pay",        "icon" => "fas fa-hand-holding-usd",                            "url" => "payrolls/thitteenthmonthpay",      "access" => "Payroll", "id" => "13th_month_pay"),
      array("title" => "Reimbursement",         "value" => "Reimbursement",         "icon" => "fa-duotone fa-duotone fa-money-bill-trend-up",       "url" => "payrolls/reimbursements",          "access" => "Payroll", "id" => "reimbursement"),
      array("title" => "Loans",                 "value" => "Loans",                 "icon" => "fa-duotone fa-landmark",                             "url" => "payrolls/loans",                   "access" => "Payroll", "id" => "loans"),
      array("title" => "Payroll Schedule",      "value" => "Payroll Schedule",      "icon" => "fa-duotone fa-calendar-check",                       "url" => "payrolls/payroll_schedules",       "access" => "Payroll", "id" => "payrolls"),
      // array("title" => "SSS Rates",          "value" => "SSS Rates",             "icon" => "fa-duotone fa-shield-keyhole",                       "url" => "payrolls/sss_rates",               "access" => "Payroll", "id" => "sss_rates"),
      // array("title" => "Philhealth Rates",   "value" => "Philhealth Rates",      "icon" => "fa-duotone fa-suitcase-medical",                     "url" => "payrolls/philhealth_rates",        "access" => "Payroll", "id" => "philhealth_rates"),
      // array("title" => "HDMF Rates",         "value" => "HDMF Rates",            "icon" => "fa-duotone fa-house-turret",                         "url" => "payrolls/hdmf_rates",              "access" => "Payroll", "id" => "hdmf_rates"),
      // array("title" => "Withholding Tax",    "value" => "Withholding Tax",       "icon" => "fa-duotone fa-building-flag",                        "url" => "payrolls/tax_rates",               "access" => "Payroll", "id" => "withholding_tax"),
      array("title" => "Custom Contributions",  "value" => "Custom Contributions",  "icon" => "fa-duotone fa-piggy-bank",                           "url" => "payrolls/custom_contributions",    "access" => "Payroll", "id" => "custom_contributions"),
      array("title" => "Deductions",            "value" => "Deductions",            "icon" => "fa-duotone fa-xmark-to-slot",                        "url" => "payrolls/deductions",              "access" => "Payroll", "id" => "deductions"),
      array("title" => "Other Deductions",      "value" => "Other Deductions",      "icon" => "fa-duotone fa-layer-minus",                        "url" => "payrolls/other_deductions",              "access" => "Payroll", "id" => "deductions"),
      array("title" => "Cash Advance",          "value" => "Cash Advance",          "icon" => "fa-duotone fa-share-from-square",                    "url" => "payrolls/cash_advances",           "access" => "Payroll", "id" => "cash_advance"),
      // array("title" => "Custom SSS Contribution",         "value" => "Custom SSS Contribution",         "icon" => "fas fa-user-minus",           "url" => "payrolls/sss_contributions",        "access" => "Payroll" ,"id"=>"sss_contributions"),
      // array("title" => "Custom Pagibig Contribution",     "value" => "Custom Pagibig Contibution",      "icon" => "fas fa-user-minus",           "url" => "payrolls/pagibig_contributions",    "access" => "Payroll" ,"id"=>"pagibig_contributions"),
      // array("title" => "Custom Philhealth Contribution",  "value" => "Custom Philhealth Contribution",  "icon" => "fas fa-user-minus",           "url" => "payrolls/philhealth_contributions", "access" => "Payroll" ,"id"=>"philhealth_contributions"),
    //   array("title" => "Attendance Records Lock",         "value" => "Attendance Records Lock",         "icon" => "fa-duotone fa-file-lock",     "url" => "payrolls/attendance_records_lock",  "access" => "Payroll", "id" => "attendance_records_lock"),
      // array("title" => "Payroll Payslips",                "value" => "Payroll Payslips",                "icon" => "fa-duotone fa-rectangle-history-circle-user",  "url" => "payrolls/payroll_payslips",         "access" => "Payroll", "id" => "payroll_payslips"),
      array("title" => "BIR 2316 Form",         "value" => "Payroll BIR2316",        "icon" => "fa-duotone fa-list-ol",                             "url" => "payrolls/bir_form2316",             "access" => "BRI_2316", "id" => "payroll_bri2316"),
      array("title" => "Payroll Assignment",    "value" => "Payroll Assignment",     "icon" => "fa-duotone fa-object-ungroup",                      "url" => "payrolls/payroll_assignment",       "access" => "Payroll", "id" => "payroll_assignment"),
    );
    $data["title_page"]                     = "Payroll Module";
    $user_access_id                         = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']          = $this->main_nav_model->GET_USER_ACCESS_PAGE($user_access_id['col_user_access']);
    $array_page                             = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                        = filter_array($data["Modules"], $array_page);
    array_push($data['Modules'], array(
      "title" => "BIR 2316 Form", "value" => "Payroll BIR2316",
      "icon" => "fa-duotone fa-file-spreadsheet", "url" => "payrolls/bir_form2316", "access" => "BRI_2316", "id" => "payroll_bri2316"
    ));
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav', $data);
    
  }
  // Payslip generator functions actions
  function payslip_generator()
  {
    $dateFilter                             = $this->input->get('date');
    $payrollSched                           = $this->payrolls_model->MOD_DISP_PAY_SCHED();
    if($dateFilter==null){
        $dateFilter=$payrollSched[0]->id;
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
    foreach($data['DISP_PAYROLL_DATA_TOTAL'] as $netpay){
        if($netpay->NET_INCOME){
          $total_gen +=$netpay->NET_INCOME;
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
        for($i=0;$i<count($data['PAY_SLIPS_NOT_READY']);$i++){
            $position                               = $this->payrolls_model->GET_SPECIFIC_POSITION($data['PAY_SLIPS_NOT_READY'][$i]['col_empl_posi']);
            $employee_type                          = $this->payrolls_model->GET_SPECIFIC_EMPLOYEE_TYPE($data['PAY_SLIPS_NOT_READY'][$i]['col_empl_type']);
             if(!empty($position)){
                $data['PAY_SLIPS_NOT_READY'][$i]['position']=$position->name;
            }else{
                $data['PAY_SLIPS_NOT_READY'][$i]['position']='';
            }
            if(!empty($employee_type)){
                $data['PAY_SLIPS_NOT_READY'][$i]['employee_type']=$employee_type->name;
            }else{
                $data['PAY_SLIPS_NOT_READY'][$i]['employee_type']='';
            }
        }
        for($i=0;$i<count($data['PAY_SLIPS_READY']);$i++){ 
            $position=$this->payrolls_model->GET_SPECIFIC_POSITION($data['PAY_SLIPS_READY'][$i]['col_empl_posi']);
            $employee_type=$this->payrolls_model->GET_SPECIFIC_EMPLOYEE_TYPE($data['PAY_SLIPS_READY'][$i]['col_empl_type']);
            if(!empty($position)){
                $data['PAY_SLIPS_READY'][$i]['position']=$position->name;
            }else{
                $data['PAY_SLIPS_READY'][$i]['position']='';
            }
            if(!empty($employee_type)){
                $data['PAY_SLIPS_READY'][$i]['employee_type']=$employee_type->name;
            }else{
                $data['PAY_SLIPS_READY'][$i]['employee_type']='';
            }
        }
        for($i=0;$i<count($data['PAYSLIPS']);$i++){
            $position       =$this->payrolls_model->GET_SPECIFIC_POSITION($data['PAYSLIPS'][$i]['col_empl_posi']);
            $employee_type  =$this->payrolls_model->GET_SPECIFIC_EMPLOYEE_TYPE($data['PAYSLIPS'][$i]['col_empl_type']);
            if(!empty($position)){
                $data['PAYSLIPS'][$i]['position']=$position->name;
            }else{
                $data['PAYSLIPS'][$i]['position']='';
            }
            if(!empty($employee_type)){
                $data['PAYSLIPS'][$i]['employee_type']=$employee_type->name;
            }else{
                $data['PAYSLIPS'][$i]['employee_type']='';
            }
        }
    $this->load->view('templates/header');
    $this->load->view('modules/payrolls/payslip_generator_views', $data);
    
  }
    function getPayslipData($id){
        $payslip=$this->payrolls_model->GET_PAYSLIP_DATA($id);
        echo json_encode($payslip);
    }
    function delete_payslip(){
        $payslip_ids  = $this->input->post('payslip_ids');
        $array_id     = explode(",", $payslip_ids);
        // var_dump($array_id);
        // echo $id;
        $res          = $this->payrolls_model->DELETE_PAYSLIP_DATA($array_id);
        $this->session->set_userdata('SESS_SUCC_MSG_DLT_PAYROLL', 'Deleted Successfully!');
        redirect('payrolls/payslip_generator');
    }
  function deductions(){
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
    $employees                                = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
    $loan_types                               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
    $tab                                      = $this->input->get('tab')?$this->input->get('tab') : 'Active';
    $row                                      = $this->input->get('row')?$this->input->get('row') : 25;
    $page                                     = $this->input->get('page')?$this->input->get('page') : 1;
    $offset                                   = ($page-1)*$row;

    if($this->input->get('all') == null){
      $payroll_loans                          = $this->payrolls_model->GET_DATA($tab,$row,$offset,'tbl_payroll_deductions');
      $data_count                             = $this->payrolls_model->GET_DATA_COUNT($tab,'tbl_payroll_deductions');
    }else{
      $payroll_loans                          = $this->payrolls_model->GET_SEARCHED_DATA($tab,$search,'tbl_payroll_deductions');
      $data_count                             = count($this->payrolls_model->GET_SEARCHED_DATA($tab,$search,'tbl_payroll_deductions'));
    }

    $payroll_data                             = [];
    $data['ACTIVES']                          = $this->payrolls_model->GET_DATA_COUNT('Active','tbl_payroll_deductions');
    $data['INACTIVES']                        = $this->payrolls_model->GET_DATA_COUNT('InActive','tbl_payroll_deductions');
    $data['PAGE']                             = $page;
    
    $page_count                               = intval($data_count/$row);
    $excess                                   = $data_count%$row;
    $data['PAGES_COUNT']                      = $excess>0 ? $page_count+=1: $page_count;
    $data['C_DATA_COUNT']                     = $data_count;
    $data['ROW']                              = $row;
    $data['TAB']                              = $tab;

    $index = 0;
    if ($payroll_loans) {
      foreach ($payroll_loans as $payroll_loan) {
        $payroll_data[$index]['id']           = $payroll_loan->id;
        $payroll_data[$index]['date']         = date('F j, Y', strtotime($payroll_loan->loan_date));
        $payroll_data[$index]['loan_amount']  = $payroll_loan->loan_amount>0? number_format((float)$payroll_loan->loan_amount,2):$payroll_loan->loan_amount;
        $payroll_data[$index]['term_amount']  = $payroll_loan->loan_terms>0?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms,2):$payroll_loan->loan_terms;
        $payroll_data[$index]['loan_terms']   = $payroll_loan->loan_terms;
        $payroll_data[$index]['loan_status']  = $payroll_loan->status;
        $payroll_data[$index]['loan_id']      = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
        $payroll_data[$index]['name']         = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
        $index+=1;
      }
    }
    
    $data['DISP_PAYROLL_LOAN'] = $payroll_data;

    $this->load->view('templates/header');
    $this->load->view('modules/payrolls/payroll_deduction_views', $data);
    
  }

    function add_deduction(){
        $data['DISP_EMPLOYEES']           = $this->payrolls_model->GET_EMPLOYEE_LIST();
        $data['LOAN_TYPES']               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
        $this->load->view('templates/header');
        $this->load->view('modules/payrolls/add_deduction_views',$data);
        
  }
    function insert_new_deduction(){
        $inputs                           = $this->input->post();
        $res_new                          = $this->payrolls_model->ADD_DEDUCTION($inputs);
        if($res_new){
            $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully added!');
        }else{
            $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to add new data!');
        }
        redirect('payrolls/deductions');
    }
     function edit_deduction($id){
        $data['DISP_EMPLOYEES']           = $this->payrolls_model->GET_EMPLOYEE_LIST();
        $data['LOAN_TYPES']               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
        $data['LOAN_INFO']                = $this->payrolls_model->GET_SPEC_DEDUCTION($id);
        $this->load->view('templates/header');
        $this->load->view('modules/payrolls/edit_deduction_views',$data);
        
  }

  function other_deductions(){
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["C_ROW_DISPLAY"]                    =  [25, 50, 100];
    $employees                                = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
    $loan_types                               = $this->payrolls_model->GET_LOAN_TYPE_DATA();
    $tab                                      = $this->input->get('tab')?$this->input->get('tab') : 'Active';
    $row                                      = $this->input->get('row')?$this->input->get('row') : 25;
    $page                                     = $this->input->get('page')?$this->input->get('page') : 1;
    $offset                                   = ($page-1)*$row;

    if($this->input->get('all') == null){
      $payroll_loans                          = $this->payrolls_model->GET_DATA($tab,$row,$offset,'tbl_payroll_deductions');
      $data_count                             = $this->payrolls_model->GET_DATA_COUNT($tab,'tbl_payroll_deductions');
    }else{
      $payroll_loans                          = $this->payrolls_model->GET_SEARCHED_DATA($tab,$search,'tbl_payroll_deductions');
      $data_count                             = count($this->payrolls_model->GET_SEARCHED_DATA($tab,$search,'tbl_payroll_deductions'));
    }

    $payroll_data                             = [];
    $data['ACTIVES']                          = $this->payrolls_model->GET_DATA_COUNT('Active','tbl_payroll_deductions');
    $data['INACTIVES']                        = $this->payrolls_model->GET_DATA_COUNT('InActive','tbl_payroll_deductions');
    $data['PAGE']                             = $page;
    
    $page_count                               = intval($data_count/$row);
    $excess                                   = $data_count%$row;
    $data['PAGES_COUNT']                      = $excess>0 ? $page_count+=1: $page_count;
    $data['C_DATA_COUNT']                     = $data_count;
    $data['ROW']                              = $row;
    $data['TAB']                              = $tab;

    $index = 0;
    if ($payroll_loans) {
      foreach ($payroll_loans as $payroll_loan) {
        $payroll_data[$index]['id']           = $payroll_loan->id;
        $payroll_data[$index]['date']         = date('F j, Y', strtotime($payroll_loan->loan_date));
        $payroll_data[$index]['loan_amount']  = $payroll_loan->loan_amount>0? number_format((float)$payroll_loan->loan_amount,2):$payroll_loan->loan_amount;
        $payroll_data[$index]['term_amount']  = $payroll_loan->loan_terms>0?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms,2):$payroll_loan->loan_terms;
        $payroll_data[$index]['loan_terms']   = $payroll_loan->loan_terms;
        $payroll_data[$index]['loan_status']  = $payroll_loan->status;
        $payroll_data[$index]['loan_id']      = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
        $payroll_data[$index]['name']         = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
        $index+=1;
      }
    }

    $payrollSched                           = $this->payrolls_model->MOD_DISP_PAY_SCHED();
    $data['DISP_PAYROLL_SCHED'] = $payrollSched;
    $data['DISP_PAYROLL_LOAN'] = $payroll_data;

    $this->load->view('templates/header');
    $this->load->view('modules/payrolls/other_deduction_views', $data);
    
  }

  function get_otherdeductions_data($payroll_id){
        
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
      if($empl_list_row->col_empl_cmid == $row->empl_id){
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

     echo(json_encode($result));
}

function update_otherdeductions_data($payroll_id){
  $data = json_decode(file_get_contents('php://input'), true);


        try {
            foreach($data as $data_row){
                $id = $data_row[0];

                if($id){
                  $this->payrolls_model->UPDATE_OTHERDEDUCTIONS_DATA($data_row, $payroll_id);
                }
                else{
                  $this->payrolls_model->INSERT_OTHERDEDUCTIONS_DATA($data_row, $payroll_id);
                }
                
            }
            $response = array('success_message' => 'Data updated successfully');
        } catch (Exception $e) {
            $response = array('warning_message' => 'Error updating data: '.$e->getMessage());
        }
        
        // echo json_encode($response);
        echo json_encode($response);
}




  function update_deduction($id){
        $inputs                           = $this->input->post();
        $res_new                          = $this->payrolls_model->UPDATE_DEDUCTION($inputs,$id);
        if($res_new){
            $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Updated!');
        }else{
            $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to Update!');
        }
        redirect('payrolls/deductions');
  }
//   Cash Deductions
  function cash_advances(){
    $search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
    
    $data["C_ROW_DISPLAY"]                =  [25, 50, 100];
    $employees                            = $this->payrolls_model->MOD_DISP_ALL_EMPLOYEES();
    $loan_types                           = $this->payrolls_model->GET_LOAN_TYPE_DATA();
    $tab                                  = $this->input->get('tab')?$this->input->get('tab') : 'Active';
    $row                                  = $this->input->get('row')?$this->input->get('row') : 25;
    $page                                 = $this->input->get('page')?$this->input->get('page') : 1;
    $offset                               = ($page-1)*$row;

    if($this->input->get('all') == null){
      $payroll_loans                      = $this->payrolls_model->GET_DATA($tab,$row,$offset,'tbl_payroll_cashadvance');
      $data_count                         = $this->payrolls_model->GET_DATA_COUNT($tab,'tbl_payroll_cashadvance');
    }else{
      $payroll_loans                      = $this->payrolls_model->GET_SEARCHED_DATA($tab,$search,'tbl_payroll_cashadvance');
      $data_count                         = count($this->payrolls_model->GET_SEARCHED_DATA($tab,$search,'tbl_payroll_cashadvance'));
    }

    $payroll_data                         = [];
    $data['ACTIVES']                      = $this->payrolls_model->GET_DATA_COUNT('Active','tbl_payroll_cashadvance');
    $data['INACTIVES']                    = $this->payrolls_model->GET_DATA_COUNT('InActive','tbl_payroll_cashadvance');
    $data['PAGE']                         = $page;
    
    $page_count                           = intval($data_count/$row);
    $excess                               = $data_count%$row;
    $data['PAGES_COUNT']                  = $excess>0 ? $page_count+=1: $page_count;
    $data['C_DATA_COUNT']                 = $data_count;
    $data['ROW']                          = $row;
    $data['TAB']                          = $tab;
    $index = 0;
    if ($payroll_loans) {
      foreach ($payroll_loans as $payroll_loan) {
        $payroll_data[$index]['id']                     = $payroll_loan->id;
        $payroll_data[$index]['date']                   = date('F j, Y', strtotime($payroll_loan->loan_date));
        $payroll_data[$index]['loan_amount']            = $payroll_loan->loan_amount>0? number_format((float)$payroll_loan->loan_amount,2):$payroll_loan->loan_amount;
        $payroll_data[$index]['term_amount']            = $payroll_loan->loan_terms>0?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms,2):$payroll_loan->loan_terms;
        $payroll_data[$index]['loan_terms']             = $payroll_loan->loan_terms;
        $payroll_data[$index]['loan_status']            = $payroll_loan->status;
        $payroll_data[$index]['loan_id']                = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
        $payroll_data[$index]['name']                   = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
        $index+=1;
      }
    }
    $data['DISP_PAYROLL_LOAN'] = $payroll_data;
    $this->load->view('templates/header');
    $this->load->view('modules/payrolls/payroll_cash_advance_views', $data);
    
  }
     function add_cash_advance(){
        $data['DISP_EMPLOYEES']                       = $this->payrolls_model->GET_EMPLOYEE_LIST();
        $data['LOAN_TYPES']                           = $this->payrolls_model->GET_LOAN_TYPE_DATA();
        $this->load->view('templates/header');
        $this->load->view('modules/payrolls/add_cash_advance_views',$data);
        
  }
    function insert_new_cash_advance(){
        $inputs                                       = $this->input->post();
        $res_new                                      = $this->payrolls_model->ADD_CASH_ADV($inputs);
        if($res_new){
            $this->session->set_userdata('SESS_SUCCESS', 'Successfully added!');
        }else{
            $this->session->set_userdata('SESS_ERROR', 'Fail to add new data!');
        }
        redirect('payrolls/cash_advances');
    }
     function edit_cash_advance($id){
        $data['DISP_EMPLOYEES']                       = $this->payrolls_model->GET_EMPLOYEE_LIST();
        $data['LOAN_TYPES']                           = $this->payrolls_model->GET_LOAN_TYPE_DATA();
        $data['LOAN_INFO']                            = $this->payrolls_model->GET_SPEC_CASH_ADV($id);
        $this->load->view('templates/header');
        $this->load->view('modules/payrolls/edit_cash_advance_views',$data);
        
  }
  function update_cash_advance($id){
        $inputs                                       = $this->input->post();
        $res_new                                      = $this->payrolls_model->UPDATE_CASH_ADV($inputs,$id);
        if($res_new){
            $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Updated!');
        }else{
            $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to Update!');
        }
        redirect('payrolls/cash_advances');
  }
//   
  function bulk_activate(){
         $loan_ids                                  = explode(',',$this->input->post('active'));
         $table                                     = $this->input->post('table');
         $data=array();
         foreach($loan_ids as $id){
             $data[]=array('id'=>$id,'status'=>'Active');
         }
        $res                                        = $this->payrolls_model->UPDATE_BULK_ACTIVATE($data,$table);
 
        $this->session->set_userdata('SESS_SUCCESS', 'Successfully Updated!');
        if($table=='tbl_payroll_deductions'){
            redirect('payrolls/deductions');
        }
         if($table=='tbl_payroll_loan'){
            redirect('payrolls/loans');
        }
        if($table=='tbl_payroll_cashadvance'){
            redirect('payrolls/cash_advances');
        }
  }
   function bulk_inactivate(){
     $loan_ids                                      = explode(',',$this->input->post('inactive'));
     $table                                         = $this->input->post('table');
     $data=array();
     foreach($loan_ids as $id){
         $data[]=array('id'=>$id,'status'=>'Inactive');
     }
     $res                                           = $this->payrolls_model->UPDATE_BULK_ACTIVATE($data,$table);
     
     $this->session->set_userdata('SESS_SUCCESS', 'Successfully Updated!');
     if($table=='tbl_payroll_deductions'){
            redirect('payrolls/deductions');
        }
     if($table=='tbl_payroll_loan'){
        redirect('payrolls/loans');
    }
    if($table=='tbl_payroll_cashadvance'){
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
  function payroll_assignment()
  {
    $search                                       = str_replace('_', ' ', $this->input->get('all') ?? "");
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
    if($this->input->get('all') == null){
      $data['DISP_EMP_LIST']                    = $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT']                     = $this->payrolls_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
    }else{
      $data['DISP_EMP_LIST']                    = $this->payrolls_model->GET_SEARCHED($search);
      $data['C_DATA_COUNT']                     = count($this->payrolls_model->GET_SEARCHED($search));
    }
    

    $data['DISP_YEARS']                         = $year_list = $this->payrolls_model->GET_YEARS();
    
    (!isset($_GET["year"])) ? $year             = $year_list[0]->id : $year = $_GET["year"];
    $data["DISP_PAYROLL_ASSIGN"]                = $this->payrolls_model->GET_ALL_PAYROLL_ASSIGNMENT();
    $data['DISP_DISTINCT_DEPARTMENT']           = $this->payrolls_model->MOD_DISP_DISTINCT_DEPARTMENT_2();
    $data['DISP_DISTINCT_DIVISION']             = $this->payrolls_model->MOD_DISP_DISTINCT_DIVISION_2();
    $data['DISP_DISTINCT_SECTION']              = $this->payrolls_model->MOD_DISP_DISTINCT_SECTION_2();
    $data['DISP_DISTINCT_BRANCH']               = $this->payrolls_model->MOD_DISP_DISTINCT_BRANCH_2();
    $data['DISP_DISTINCT_GROUP']                = $this->payrolls_model->MOD_DISP_DISTINCT_GROUP_2();
    $data['DISP_DISTINCT_TEAM']                 = $this->payrolls_model->MOD_DISP_DISTINCT_TEAM_2();
    $data['DISP_DISTINCT_LINE']                 = $this->payrolls_model->MOD_DISP_DISTINCT_LINE_2();
    $data['DISP_VIEW_DEPARTMENT']               = $this->payrolls_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']                 = $this->payrolls_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']                  = $this->payrolls_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_BRANCH']                   = $this->payrolls_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_GROUP']                    = $this->payrolls_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']                     = $this->payrolls_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']                     = $this->payrolls_model->GET_SYSTEM_SETTING("com_line");
    $this->load->view('templates/header');
    $this->load->view('modules/payrolls/payroll_assignment_views', $data);
    
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
    $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["C_ROW_DISPLAY"]                    =  [10, 25, 50, 100];
    $page                                     = $this->input->get('page');
    $row                                      = $this->input->get('row');
    if ($row == null) {
      $row = 10;
    }
    if ($page  == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    if($this->input->get('all') == null){
      $data['DISP_EMP_LIST']                  = $empl_list = $this->payrolls_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT']                   = $this->payrolls_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
    }else{
      $data['DISP_EMP_LIST']                  = $this->payrolls_model->GET_SEARCHED($search);
      $data['C_DATA_COUNT']                   = count($this->payrolls_model->GET_SEARCHED($search));
    }
    $data['DISP_YEARS']                       = $year_list = $this->payrolls_model->GET_YEARS();
    
    (!isset($_GET["year"])) ? $year           = $year_list[0]->id : $year = $_GET["year"];
    $data['YEAR_INITIAL']                     = $year;
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
    $this->load->view('modules/payrolls/custom_contributions_views', $data);
    
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
  function add_loans(){
        $data['DISP_EMPLOYEES']             = $this->payrolls_model->GET_EMPLOYEE_LIST();
        $data['LOAN_TYPES']                 = $this->payrolls_model->GET_LOAN_TYPE_DATA();
        $this->load->view('templates/header');
        $this->load->view('modules/payrolls/add_loans_views',$data);
        
  }
    function insert_new_loans(){
        $inputs                             = $this->input->post();
        $res_new                            = $this->payrolls_model->ADD_LOAN($inputs);
        if($res_new){
            $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully added new loan!');
        }else{
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
    if ($en_sss == null) {      $en_sss = 1;  }
    if ($en_phil == null) {     $en_phil = 1;  }
    if ($en_pagibig == null) {  $en_pagibig = 1;  }
    if ($en_wtax == null) {     $en_wtax = 1;  }
    if ($en_ti == null) {       $en_ti = 1;  }
    if ($en_nti == null) {      $en_nti = 1;  }
    if ($en_td == null) {       $en_td = 1;  }
    if ($en_ntd == null) {      $en_ntd = 1;  }
    if ($en_loan == null) {     $en_loan = 1;  }
    if ($en_absut == null) {     $en_absut = 1;  }

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

    if(!$period_year){
        $period_year=0;
    }else{
        $period_year=$period_year->years;
    }

        if($pay_frequency){
        $pay_frequency=$pay_frequency->pay_frequency;
    }
    else{
        $pay_frequency=0;
    }

    //---------------------------- CONNECTED PAYROLLS ---------------------------------------------
    $period_connected                       = $this->payrolls_model->GET_PERIOD_CONNECTED($period);
    $connected_1 = 0;
    $connected_2 = 0;
    $connected_3 = 0;
    $connected_4 = 0;
    $connected_5 = 0;
    if(count($period_connected)>0){
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
    $ca_user_all      = $this->payrolls_model->GET_PAYROLL_CA_DATA_EMPL($employee);
    $deduct_user_all  = $this->payrolls_model->GET_PAYROLL_DEDUCT_DATA_EMPL($employee);

    $loan_total   = 0;
    $ca_total     = 0;
    $deduct_total = 0;
    if(!empty($loan_user_all)){
      foreach ($loan_user_all as $loan_user_all_row) {
        $loan_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_LOAN_ID($loan_user_all_row->id);
        $loan_contrib                   =(float)$loan_user_all_row->loan_amount/$loan_user_all_row->loan_terms;
        $loan_user_all_row->contrib     = number_format($loan_contrib,2);
        $loan_total                     = $loan_total + $loan_contrib;
      }
    }
    if(!empty($ca_user_all)){
      foreach ($ca_user_all as $ca_user_all_row) {
        $ca_user_all_row->paid_count    = $this->payrolls_model->GET_COUNT_CA_ID($ca_user_all_row->id);
        $ca_contrib                     = 0;
        $ca_user_all_row->contrib       = number_format($ca_contrib,2);
        $ca_total                       = $ca_total + $ca_contrib;
      }
    }
    if(!empty($deduct_user_all)){
      foreach ($deduct_user_all as $deduct_user_all_row) {
        $deduct_user_all_row->paid_count  = $this->payrolls_model->GET_COUNT_DEDUCT_ID($deduct_user_all_row->id);
        $deduct_contrib                   = 0;
        $deduct_user_all_row->contrib     = number_format($deduct_contrib,2);
        $deduct_total                     = $deduct_total + $deduct_contrib;
      }
    }
    if($en_loan == 0){
      $loan_total = 0;
    }
    $loancadeduct_total                   = $loan_total + $ca_total + $deduct_total;
    $data['DISP_LOAN']                    = $loan_user_all;
    $data['DISP_CA']                      = $ca_user_all;
    $data['DISP_DEDUCT']                  = $deduct_user_all;
    $string_loan = str_replace('"', '@', json_encode($loan_user_all));
    $string_ca = str_replace('"', '@', json_encode($ca_user_all));
    $string_deduct = str_replace('"', '@', json_encode($deduct_user_all));
    
    $data['DISP_LOAN_STRING']             = $string_loan;
    $data['DISP_CA_STRING']               = $string_ca;
    $data['DISP_DEDUCT_STRING']           =  $string_deduct;
    $data['DISP_LOANCADED_TOTAL']         = number_format($loancadeduct_total,2);
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

    $ini_empl_cmid        = !empty($employee_specific)?$employee_specific[0]->col_empl_cmid:0;
    $ini_empl_name        = !empty($employee_specific)?$employee_specific[0]->col_last_name .', '. $employee_specific[0]->col_last_name:0;
    $ini_salary_rate      = !empty($employee_specific)?$employee_specific[0]->salary_rate:0;
    $ini_salary_type      = !empty($employee_specific)?$employee_specific[0]->salary_type:0;

    if ($ini_salary_type == "Daily") {
      $daily_salary       =  $ini_salary_rate;
      $hourly_salary      = $daily_salary / 8;
    } else {
      $daily_salary       =  $ini_salary_rate * 12 / 313;
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
    $tax_allowance_list         = $this->payrolls_model->GET_STD_TAX_ALLOWANCE_LIST();
    $tax_allowance_total        = 0;
    foreach ($tax_allowance_list as $tax_list_row) {
      $tax_allow_id             = $tax_list_row->id;
      $tax_allow_type           = $tax_list_row->type;
      $tax_list_row->value      = number_format((float)$this->payrolls_model->GET_TAX_ALLOWANCE_EMPL($tax_allow_id, $employee), 2);
      if ($tax_allow_type == "Attendance") {
        $tax_list_row->count    = $count_present;
        $tax_list_row->subtotal = number_format((float)$tax_list_row->value * $tax_list_row->count, 2);
      } else {
        $tax_list_row->count    = '-';
        $tax_list_row->subtotal = number_format((float)$tax_list_row->value, 2);
      }
      $tax_allowance_total      = $tax_allowance_total + $tax_list_row->subtotal;
    }
   
    //-----------------NON-TAXABLE ALLOWANCES---------------
    $nontax_allowance_list    = $this->payrolls_model->GET_STD_NONTAX_ALLOWANCE_LIST();

    $nontax_allowance_total   = 0;
    foreach ($nontax_allowance_list as $nontax_list_row) {
      $nontax_allow_id        = $nontax_list_row->id;
      $nontax_allow_type      = $nontax_list_row->type;
      $nontax_list_row->value = $this->payrolls_model->GET_NONTAX_ALLOWANCE_EMPL($nontax_allow_id, $employee);

      if ($nontax_allow_type == "Attendance") {
        $nontax_list_row->count     = $count_present;
        $nontax_list_row->subtotal  = floatval($nontax_list_row->value) * floatval($nontax_list_row->count);
      } else {
        $nontax_list_row->count     = '-';
        $nontax_list_row->subtotal  = floatval($nontax_list_row->value);
      }

      $nontax_allowance_total       = $nontax_allowance_total + $nontax_list_row->subtotal;
    }
    
    //--------------------------------------------------------
    if($en_ti == 0){
      $tax_allowance_total = 0;
    }
  
     if($en_nti == 0){
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
    $tot_present        = $ini_salary_rate/2;

    if ($ini_salary_type == "Daily") {
      $tot_present = 0;
    }
    else{
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

    if($en_absut == 0){
      $tot_tardiness = 0;
    }
    
    if ($ini_salary_type == "Daily") {
      $basic_income = $daily_salary * 313 / 12 / 2;
    }
    else{
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

    if($basic_income >= 5000){
      $pagibig_ee_current     = 100;
      $pagibig_er_current     = 100;
    }
    else{
      $pagibig_ee_current     = $basic_income*0.02;
      $pagibig_er_current     = $basic_income*0.02;
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
    if($en_sss == 0){
      $sss_ee_diff = 0;
      $sss_er_diff = 0;
      $sss_ec_er_diff = 0;
    }
    if($en_pagibig == 0){
      $pagibig_ee_diff = 0;
      $pagibig_er_diff = 0;
    }
    if($en_phil == 0){
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
    if($wtax_raw){
        $wtax_salary_min      = $wtax_raw["salary_min"];
        $wtax_salary_max      = $wtax_raw["salary_max"]; 
        $wtax_salary_fixed    = $wtax_raw["fixed"];
        $wtax_salary_clevel   = $wtax_raw["c_level"];
        $wtax_salary_cpercent = $wtax_raw["c_percent"];
    }
    $wtax = $wtax_salary_fixed + ($taxable_income - $wtax_salary_clevel) * $wtax_salary_cpercent / 100;
    if($en_wtax == 0){
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

    $data["TAXABLE_INCOME"]        = number_format((float)$taxable_income,2);
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
    $INITIAL_DAILY_RATE         = $this->input->post("INITIAL_DAILY_RATE");
    $INITIAL_HOURLY_RATE        = $this->input->post("INITIAL_HOURLY_RATE");
    $PAYSLIP_PERIOD             = $this->input->post("PAYSLIP_PERIOD");
    $COUNT_PRESENT              = $this->input->post("COUNT_PRESENT");
    $COUNT_ABSENT               = $this->input->post("COUNT_ABSENT");
    $COUNT_TARDINESS            = $this->input->post("COUNT_TARDINESS");
    $COUNT_UNDERTIME            = $this->input->post("COUNT_UNDERTIME");
    $COUNT_PAID_LEAVE           = $this->input->post("COUNT_PAID_LEAVE");
    $COUNT_REG_HOURS            = $this->input->post("COUNT_REG_HOURS");
    $COUNT_REG_OT               = $this->input->post("COUNT_REG_OT");
    $COUNT_REG_ND               = $this->input->post("COUNT_REG_ND");
    $COUNT_REG_NDOT             = $this->input->post("COUNT_REG_NDOT");
    $COUNT_REST_HOURS           = $this->input->post("COUNT_REST_HOURS");
    $COUNT_REST_OT              = $this->input->post("COUNT_REST_OT");
    $COUNT_REST_ND              = $this->input->post("COUNT_REST_ND");
    $COUNT_REST_NDOT            = $this->input->post("COUNT_REST_NDOT");
    $COUNT_LEG_HOURS            = $this->input->post("COUNT_LEG_HOURS");
    $COUNT_LEG_OT               = $this->input->post("COUNT_LEG_OT");
    $COUNT_LEG_ND               = $this->input->post("COUNT_LEG_ND");
    $COUNT_LEG_NDOT             = $this->input->post("COUNT_LEG_NDOT");
    $COUNT_LEGREST_HOURS        = $this->input->post("COUNT_LEGREST_HOURS");
    $COUNT_LEGREST_OT           = $this->input->post("COUNT_LEGREST_OT");
    $COUNT_LEGREST_ND           = $this->input->post("COUNT_LEGREST_ND");
    $COUNT_LEGREST_NDOT         = $this->input->post("COUNT_LEGREST_NDOT");
    $COUNT_SPE_HOURS            = $this->input->post("COUNT_SPE_HOURS");
    $COUNT_SPE_OT               = $this->input->post("COUNT_SPE_OT");
    $COUNT_SPE_ND               = $this->input->post("COUNT_SPE_ND");
    $COUNT_SPE_NDOT             = $this->input->post("COUNT_SPE_NDOT");
    $COUNT_SPEREST_HOURS        = $this->input->post("COUNT_SPEREST_HOURS");
    $COUNT_SPEREST_OT           = $this->input->post("COUNT_SPEREST_OT");
    $COUNT_SPEREST_ND           = $this->input->post("COUNT_SPEREST_ND");
    $COUNT_SPEREST_NDOT         = $this->input->post("COUNT_SPEREST_NDOT");
    $MUL_PRESENT                = $this->input->post("MUL_PRESENT");
    $MUL_ABSENT                 = $this->input->post("MUL_ABSENT");
    $MUL_TARDINESS              = $this->input->post("MUL_TARDINESS");
    $MUL_UNDERTIME              = $this->input->post("MUL_UNDERTIME");
    $MUL_PAID_LEAVE             = $this->input->post("MUL_PAID_LEAVE");
    $MUL_REG_HOURS              = $this->input->post("MUL_REG_HOURS");
    $MUL_REG_OT                 = $this->input->post("MUL_REG_OT");
    $MUL_REG_ND                 = $this->input->post("MUL_REG_ND");
    $MUL_REG_NDOT               = $this->input->post("MUL_REG_NDOT");
    $MUL_REST_HOURS             = $this->input->post("MUL_REST_HOURS");
    $MUL_REST_OT                = $this->input->post("MUL_REST_OT");
    $MUL_REST_ND                = $this->input->post("MUL_REST_ND");
    $MUL_REST_NDOT              = $this->input->post("MUL_REST_NDOT");
    $MUL_LEG_HOURS              = $this->input->post("MUL_LEG_HOURS");
    $MUL_LEG_OT                 = $this->input->post("MUL_LEG_OT");
    $MUL_LEG_ND                 = $this->input->post("MUL_LEG_ND");
    $MUL_LEG_NDOT               = $this->input->post("MUL_LEG_NDOT");
    $MUL_LEGREST_HOURS          = $this->input->post("MUL_LEGREST_HOURS");
    $MUL_LEGREST_OT             = $this->input->post("MUL_LEGREST_OT");
    $MUL_LEGREST_ND             = $this->input->post("MUL_LEGREST_ND");
    $MUL_LEGREST_NDOT           = $this->input->post("MUL_LEGREST_NDOT");
    $MUL_SPE_HOURS              = $this->input->post("MUL_SPE_HOURS");
    $MUL_SPE_OT                 = $this->input->post("MUL_SPE_OT");
    $MUL_SPE_ND                 = $this->input->post("MUL_SPE_ND");
    $MUL_SPE_NDOT               = $this->input->post("MUL_SPE_NDOT");
    $MUL_SPEREST_HOURS          = $this->input->post("MUL_SPEREST_HOURS");
    $MUL_SPEREST_OT             = $this->input->post("MUL_SPEREST_OT");
    $MUL_SPEREST_ND             = $this->input->post("MUL_SPEREST_ND");
    $MUL_SPEREST_NDOT           = $this->input->post("MUL_SPEREST_NDOT");
    $TOT_PRESENT                = $this->input->post("TOT_PRESENT");
    $TOT_ABSENT                 = $this->input->post("TOT_ABSENT");
    $TOT_TARDINESS              = $this->input->post("TOT_TARDINESS");
    $TOT_UNDERTIME              = $this->input->post("TOT_UNDERTIME");
    $TOT_PAID_LEAVE             = $this->input->post("TOT_PAID_LEAVE");
    $TOT_REG_HOURS              = $this->input->post("TOT_REG_HOURS");
    $TOT_REG_OT                 = $this->input->post("TOT_REG_OT");
    $TOT_REG_ND                 = $this->input->post("TOT_REG_ND");
    $TOT_REG_NDOT               = $this->input->post("TOT_REG_NDOT");
    $TOT_REST_HOURS             = $this->input->post("TOT_REST_HOURS");
    $TOT_REST_OT                = $this->input->post("TOT_REST_OT");
    $TOT_REST_ND                = $this->input->post("TOT_REST_ND");
    $TOT_REST_NDOT              = $this->input->post("TOT_REST_NDOT");
    $TOT_LEG_HOURS              = $this->input->post("TOT_LEG_HOURS");
    $TOT_LEG_OT                 = $this->input->post("TOT_LEG_OT");
    $TOT_LEG_ND                 = $this->input->post("TOT_LEG_ND");
    $TOT_LEG_NDOT               = $this->input->post("TOT_LEG_NDOT");
    $TOT_LEGREST_HOURS          = $this->input->post("TOT_LEGREST_HOURS");
    $TOT_LEGREST_OT             = $this->input->post("TOT_LEGREST_OT");
    $TOT_LEGREST_ND             = $this->input->post("TOT_LEGREST_ND");
    $TOT_LEGREST_NDOT           = $this->input->post("TOT_LEGREST_NDOT");
    $TOT_SPE_HOURS              = $this->input->post("TOT_SPE_HOURS");
    $TOT_SPE_OT                 = $this->input->post("TOT_SPE_OT");
    $TOT_SPE_ND                 = $this->input->post("TOT_SPE_ND");
    $TOT_SPE_NDOT               = $this->input->post("TOT_SPE_NDOT");
    $TOT_SPEREST_HOURS          = $this->input->post("TOT_SPEREST_HOURS");
    $TOT_SPEREST_OT             = $this->input->post("TOT_SPEREST_OT");
    $TOT_SPEREST_ND             = $this->input->post("TOT_SPEREST_ND");
    $TOT_SPEREST_NDOT           = $this->input->post("TOT_SPEREST_NDOT");
    $EARNINGS                   = $this->input->post("EARNINGS");
    $DEDUCTIONS                 = $this->input->post("DEDUCTIONS");
    $WTAX                       = $this->input->post("WTAX");
    $NET_INCOME                 = $this->input->post("NET_INCOME");
    $PAGIBIG_EE_CURRENT         = $this->input->post("PAGIBIG_EE_CURRENT");
    $PAGIBIG_ER_CURRENT         = $this->input->post("PAGIBIG_ER_CURRENT");
    $PHILHEALTH_EE_CURRENT      = $this->input->post("PHILHEALTH_EE_CURRENT");
    $PHILHEALTH_ER_CURRENT      = $this->input->post("PHILHEALTH_ER_CURRENT");
    $SSS_EC_ER_CURRENT          = $this->input->post("SSS_EC_ER_CURRENT");
    $SSS_EE_CURRENT             = $this->input->post("SSS_EE_CURRENT");
    $SSS_ER_CURRENT             = $this->input->post("SSS_ER_CURRENT");
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
    $tab                                = $this->input->get('tab')?$this->input->get('tab') : 'Active';
    $row                                = $this->input->get('row')?$this->input->get('row') : 25;
    $page                               = $this->input->get('page')?$this->input->get('page') : 1;
    $offset                             = ($page-1)*$row;
    
    $data["C_ROW_DISPLAY"]              = [25, 50, 100];

    if($this->input->get('all') == null){
      $payroll_loans                    = $this->payrolls_model->GET_PAYROLL_LOAN_DATA($tab,$row,$offset);
      $data_count                       = count($this->payrolls_model->GET_COUNT_PAYROLL_LOAN_DATA($tab));
    }else{
      $payroll_loans                    = $this->payrolls_model->GET_SEARCHED_LOAN_DATA($tab,$search);
      $data_count                       = count($this->payrolls_model->GET_SEARCHED_LOAN_DATA($tab,$search));
    }
    

    $payroll_data                       = [];
    $data['ACTIVES']                    = count($this->payrolls_model->GET_PAYROLL_LOAN_DATA_COUNT('Active'));
    $data['INACTIVES']                  = count($this->payrolls_model->GET_PAYROLL_LOAN_DATA_COUNT('InActive'));
    $data['PAGE']                       = $page;
    
    $page_count                         = intval($data_count/$row);
    $excess                             = $data_count%$row;
    $data['PAGES_COUNT']                = $excess>0 ? $page_count+=1: $page_count;
    $data['C_DATA_COUNT']               = $data_count;
    $data['ROW']                        = $row;
    $data['TAB']                        = $tab;
    $index = 0;
    if ($payroll_loans) {
      foreach ($payroll_loans as $payroll_loan) {
        $payroll_data[$index]['id']               = $payroll_loan->id;
        $payroll_data[$index]['date']             = date('F j, Y', strtotime($payroll_loan->loan_date));
        $payroll_data[$index]['loan_amount']      = $payroll_loan->loan_amount>0? number_format((float)$payroll_loan->loan_amount,2):$payroll_loan->loan_amount;
        $payroll_data[$index]['term_amount']      = $payroll_loan->loan_terms>0?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms,2):$payroll_loan->loan_terms;
        $payroll_data[$index]['loan_terms']       = $payroll_loan->loan_terms;
        $payroll_data[$index]['loan_status']      = $payroll_loan->status;
        $payroll_data[$index]['loan_id']          = $this->payrolls_model->GET_COUNT_LOAN_ID($payroll_loan->id);
        $payroll_data[$index]['name']             = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
    
        foreach ($loan_types as $loan_type) {
          if ($loan_type->id == $payroll_loan->loan_type) {
            $payroll_data[$index]['loan_type'] = $loan_type->name;
          }
        }
        $index+=1;
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
        redirect('payroll/loans');
      } else {
        $this->p080_payroll_mod->MOD_INSRT_LOAN_PAYABLE($loan_id, $loan_type, $employee_cmid, $date, $installment, $cutoff_period);
        $this->session->set_userdata('SESS_SUCC_INSRT_LOAN', 'New Loan Added!');
        redirect('payroll/loans');
      }
    } else {
      $this->session->set_userdata('SESS_ERR_INSRT_LOAN', 'Saving Failed');
      redirect('payroll/loans');
    }
  }
  function bulk_loans(){
    $this->load->view('templates/header');
    
  }
  function edit_loan($id){
        $data['DISP_EMPLOYEES'] = $this->payrolls_model->GET_EMPLOYEE_LIST();
        $data['LOAN_TYPES']     = $this->payrolls_model->GET_LOAN_TYPE_DATA();
        $data['LOAN_INFO']      = $this->payrolls_model->GET_SPEC_LOAN($id);
        $this->load->view('templates/header');
        $this->load->view('modules/payrolls/edit_loan_views',$data);
        
  }
  function update_loan($id){
        $inputs=$this->input->post();
        $res_new=$this->payrolls_model->UPDATE_LOAN($inputs,$id);
        if($res_new){
            $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Updated loan!');
        }else{
            $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to Update loan!');
        }
        redirect('payrolls/loans');
  }
  // pay check sched
  function payroll_schedules()
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
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
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
  // INSERT POSITION
  function insrt_pay_schedule()
  {
    $date_range             = $this->input->post('date_range');
    $db_date_range          = $this->input->post('PAY_SCHED_INPF_NAME');
    $payout_sched           = $this->input->post('payout_sched');
    $this->p175_payschedule_mod->MOD_INSRT_PAY_SCHED($date_range, $db_date_range, $payout_sched);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_PAY_SCHED', 'Added Successfully!');
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
    redirect('payrolls/payroll_schedules');
  }
  // DELETE POSITION
  function dlt_pay_schedule()
  {
    $pay_schedule_id        = $this->input->get('delete_id');
    $this->p175_payschedule_mod->MOD_DLT_PAY_SCHED($pay_schedule_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_PAY_SCHED', 'Deleted Successfully!');
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
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
    // redirect('payrolls/payroll_assignment');
  }



  public function export_csv($period=null){ 
		/* file name */
    
    if($period == "" || $period == null){
      $period                           = $this->payrolls_model->MOD_DISP_PAY_SCHED_LATEST();
    }

		$filename             = 'Payslip_'.date('Y-m-d').'.csv'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/csv; ");
	   /* get data */
		$payslip              = $this->payrolls_model->GET_EXPORT_PAYROLL_PAYSLIP($period);
		/* file creation */
		$file = fopen('php://output', 'w');
		$header = array("Payslip Id", "Employee Id","Employee Name","Salary Rate","Salary Type", "Daily Rate", "Hourly Rate", "Period", "Present", "Absent", "Tardiness", "Undertime", "Paid Leave", "REG Hours", 
    "REG OT", "REG ND", "REG NDOT", "Rest Hours", "Rest OT", "Rest ND", "Rest NDOT", "LEG Hours", "LEG OT", "LEG ND", "LEG NDOT", "Legrest Hours", "Legrest OT", "Legrest ND", "Legrest NDOT", 
    "SPE hours", "SPE OT", "SPE ND", "SPE NDOT", "Sperest Hours", "Sperest OT", "Sperest ND", "Sperest NDOT", "Earnings", "Deduction", "WTAX", "Net Income", "Loan Id", "Gross Income", 
    "SSS EE Current", "Pagibig EE Current", "PhilHealth EE Current", "SSS ER Current", "SSS EC ER Current", "PagIbig ER Current", "PhilHealth ER Current", "CA Id", "Deduct Id", "Status", "Loan List", "CA List", "Deduct List"); 
		fputcsv($file, $header);
		foreach ($payslip as $key=>$line){ 
      $line['id']         = 'PAYSLIP'.str_pad($line['id'], 5, '0', STR_PAD_LEFT);
			fputcsv($file,$line); 
		}
		fclose($file); 
		exit; 
	}


  //-------------------------------------------------------- CRUD FUNCTIONS ends
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
