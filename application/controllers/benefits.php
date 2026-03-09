 <?php defined('BASEPATH') or exit('No direct script access allowed');
  ob_start();
  class benefits extends CI_Controller
  {
    function __construct()
    {
      parent::__construct();
      $this->load->model('templates/main_nav_model');
      $this->load->model('templates/main_table_01_model');
      $this->load->model('templates/main_table_02_model');
      $this->load->model('modules/benefits_model');
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
      $maintenance                                        = $this->login_model->GET_MAINTENANCE();
      $isAdmin                                            = $this->session->userdata('SESS_ADMIN');
      if ($maintenance == '1' && $isAdmin != 1) {
        redirect('login/maintenance');
      }
    }
    function index()
    {
      $data["Modules"] =  array(
        // array("title" => "Dynamic Benefits",            "value" => "Dynamic Benefits",          icon" => "fa-kit fa-fixeddynamic",                   "url" => "benefits/dynamic",              "access" => "Benefits",  "id" => "dynamic"),
        array("title" => "Taxable Allowances",          "value" => "Taxable Allowances",        "icon" => "fixedbenefits.svg",                   "info" => "Lets you view various elements beyond the base salary, such as allowances, bonuses, incentives, and other monetary components.",     "url" => "benefits/taxable",                        "access" => "Benefits",  "id" => "taxable"),
        array("title" => "Non-Taxable Allowances",      "value" => "Non-Taxable Allowances",    "icon" => "fixedbenefits.svg",                   "info" => "Lets you view various elements beyond the base salary, such as allowances, bonuses, incentives, and other monetary components.",     "url" => "benefits/nontaxable",                     "access" => "Benefits",  "id" => "nontaxable"),
        // array("title" => "Deductions",                  "value" => "Other Deductions",          "icon" => "hand-holding-dollar-solid.svg",       "info" => "Miscellaneous deductions from an employee's salary or compensation package. ",                                                       "url" => "benefits/fixed?income_type=Deductions",   "access" => "Benefits",  "id" => "other_deductions"),
        array("title" => "Deductions",                  "value" => "Deductions",                "icon" => "hand-holding-dollar-solid.svg",       "info" => "Miscellaneous deductions from an employee's salary or compensation package. ",                                                       "url" => "benefits/other_deductions",               "access" => "Benefits",  "id" => "other_deductions"),
        array("title" => "Union Dues",                  "value" => "Union Dues",                "icon" => "hand-holding-dollar-solid.svg",       "info" => "Miscellaneous union dues deduction from an employee's salary or compensation package. ",                                                       "url" => "benefits/union_dues",               "access" => "Benefits",  "id" => "union_dues"),
        array("title" => "Loans",                       "value" => "Loans Benefits",            "icon" => "loans.svg",                           "info" => "Lets you view and track the status of benefits loans, including details such as the outstanding loan balance.",                      "url" => "benefits/loans",                          "access" => "Benefits",  "id" => "loans"),
        array("title" => "Adjustment",                  "value" => "Adjustments Benefits",      "icon" => "scale-balanced-duotone.svg",   "info" => "Effective dates, and any actions required on the part of the employees.",                                                            "url" => "benefits/adjustment",                     "access" => "Benefits",  "id" => "adjustment"),
        array("title" => "Reimbursement",               "value" => "Reimbursement",             "icon" => "square-sliders-vertical-solid.svg",    "info" => "Allowing employees to submit reimbursement requests.",                                                                                                                                   "url" => "benefits/reimbursement",                  "access" => "Benefits",  "id" => "reimbursement"),
        array("title" => "Cash Advances",               "value" => "Cash Advances",             "icon" => "money-bill-1-wave-duotone.svg",    "info" => "Facilitates requests, enabling employees to apply for cash advances. ",                                                                                                                                   "url" => "benefits/cashadvance",                    "access" => "Benefits",  "id" => "cashadvances"),
      );
      $data['settings']                                   = "benefits/setting_general";
      $data["title_page"]                                 = "Earnings/Deductions/Loans Management";
      $data["title_description"]                          = "Allows HR to manage and administer employee benefits, deductions, and loans";
      $data["maiya_theme"]                                = $this->benefits_model->GET_MAYA_THEME();
      $user_access_id                                     = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
      $data['DISP_USER_ACCESS_PAGE']                      = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
      $array_page                                         = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
      $data['Modules']                                    = filter_array($data["Modules"], $array_page);
      $this->load->view('templates/header');
      $this->load->view('templates/main_container', $data);
    }

    function setting_general()
    {
      $data['allowance_meal_enable']                     = $this->benefits_model->get_system_setup_by_setting('allowance_meal_enable', '0');
      $data['allowance_meal_shift']                      = $this->benefits_model->get_system_setup_by_setting('allowance_meal_shift', 'All');
      $data['allowance_meal_value']                      = $this->benefits_model->get_system_setup_by_setting('allowance_meal_value', '0');

      $data['allowance_meal_by_hour_enable']                     = $this->benefits_model->get_system_setup_by_setting('allowance_meal_by_hour_enable', '0');
      $data['allowance_meal_by_hour']                     = $this->benefits_model->get_system_setup_by_setting('allowance_meal_by_hour', '0');
      $data['allowance_meal_by_hour_value']                     = $this->benefits_model->get_system_setup_by_setting('allowance_meal_by_hour_value', '0');

      $data['allowance_ricesub_enable']                  = $this->benefits_model->get_system_setup_by_setting('allowance_ricesub_enable', '0');
      $data['allowance_ricesub_value']                   = $this->benefits_model->get_system_setup_by_setting('allowance_ricesub_value', '0');
      $data['allowance_ricesub_minhours']                = $this->benefits_model->get_system_setup_by_setting('allowance_ricesub_minhours', '0');
      $data['allowance_rice_enable']                     = $this->benefits_model->get_system_setup_by_setting('allowance_rice_enable', '0');
      $data['allowance_rice_value']                      = $this->benefits_model->get_system_setup_by_setting('allowance_rice_value', '0');
      $data['allowance_rice_minhours']                   = $this->benefits_model->get_system_setup_by_setting('allowance_rice_minhours', '0');
      $data['allowance_otmeal_enable']                   = $this->benefits_model->get_system_setup_by_setting('allowance_otmeal_enable', '0');
      $data['allowance_otmeal_value']                    = $this->benefits_model->get_system_setup_by_setting('allowance_otmeal_value', '0');
      $data['allowance_otmeal_minhours']                 = $this->benefits_model->get_system_setup_by_setting('allowance_otmeal_minhours', '0');
      $data['tax_nontax_allowance']                      = $this->benefits_model->get_system_setup_by_setting('tax_nontax_allowance', '0');
      $data['allowance_transportaion_enable']            = $this->benefits_model->get_system_setup_by_setting('allowance_transportaion_enable', '0');

      // var_dump($data['allowance_otmeal_minhours']); die();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/setting_general_views', $data);
    }

    function update_setting_general()
    {
      $input_data = $this->input->post();
      $validKeys = [
        'tax_nontax_allowance',
        'allowance_meal_enable',
        'allowance_meal_shift',
        'allowance_meal_value',
        'allowance_meal_by_hour_enable',
        'allowance_meal_by_hour',
        'allowance_meal_by_hour_value',
        'allowance_ricesub_enable',
        'allowance_ricesub_value',
        'allowance_ricesub_minhours',
        'allowance_rice_enable',
        'allowance_rice_value',
        'allowance_rice_minhours',
        'allowance_otmeal_enable',
        'allowance_otmeal_value',
        'allowance_otmeal_minhours',
        'allowance_transportaion_enable',
      ];
      $input_data             = array_intersect_key($input_data, array_flip($validKeys));
      // echo '<pre>';
      // var_dump($input_data);
      // return;
      // $settings= array_keys($input_data);
      $res = $this->benefits_model->update_system_setup($input_data);
      // var_dump($res);die();
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Benefits Settings Successfully updated');
      } else {
        $this->session->set_flashdata('ERR', 'Benefits Settings Unable to update');
      }
      redirect($this->input->server('HTTP_REFERER'));
    }

    function setting_allowance(){
      $data['DISP_NIGHTSHIFT_ALLOWANCE'] = $this->benefits_model->GET_SYSTEM_SETUP_SETTING('night_shift_allowance_tax');
      $data['DISP_NIGHTSHIFT_ALLOWANCE_NONTAX'] = $this->benefits_model->GET_SYSTEM_SETUP_SETTING('night_shift_allowance_nontax');

      $this->load->view('templates/header');
      $this->load->view('modules/benefits/setting_allowance_views',$data);
      
    }

    function update_setting_allowance(){
      $data = $this->input->post();

      foreach ($data as $key => $value) {
        $res = $this->benefits_model->UPDATE_ADJUSTMENT_VALUE_TYPE($value, $key);
      }

      if ($res){
        $this->session->set_userdata('SESS_SUCCESS', 'Successfully Updated!');
      }else{
        $this->session->set_userdata('SESS_FAILED', 'Successfully Updated!');
      }
      redirect($this->input->server('HTTP_REFERER'));

    }

    function setting_loan_types()
    {
      $selectColumns = [
        // ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
        ['selectStatement' => 'id,name,status'],
      ];
      $filter = [
        // ['year' => $tab],
      ];
      $table = 'tbl_std_loantypes';
      $dataTable               = $this->benefits_model->get_settings_table($table, $filter, $selectColumns);
      $dataTable               = json_encode($dataTable);
      $data["C_DATA_TABLE"]    = $dataTable;
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/setting_loan_types_views', $data);
    }

    function update_loan_types()
    {
      $data                 = json_decode(file_get_contents('php://input'), true);
      // $response           = array('data' => $data ); 
      try {
        $updatedData          = $data['updatedData'];
        $keysToKeep = ['id', 'name', 'status'];
        $table = 'tbl_std_loantypes';
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
          $res = $this->benefits_model->update_setting_tables($table, $data, $edit_user);
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

    function setting_reimbursement_types(){
      $selectColumns = [
        // ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
        ['selectStatement' => 'id,name,status'],
      ];
      $filter = [
        // ['year' => $tab],
      ];
      $table = 'tbl_std_reimbursementtypes';
      $dataTable               = $this->benefits_model->get_settings_table($table, $filter, $selectColumns);
      $dataTable               = json_encode($dataTable);
      $data["C_DATA_TABLE"]    = $dataTable;
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/setting_reimbursement_types_views', $data);
    }

    function setting_cashadvance_types(){
      $selectColumns = [
        // ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
        ['selectStatement' => 'id,name,status'],
      ];
      $filter = [
        // ['year' => $tab],
      ];
      $table = 'tbl_std_cashadvancetypes';
      $dataTable               = $this->benefits_model->get_settings_table($table, $filter, $selectColumns);
      $dataTable               = json_encode($dataTable);
      $data["C_DATA_TABLE"]    = $dataTable;
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/setting_cashadvance_types_views', $data);
    }

    function update_cashadvance_types()  {
      $data                 = json_decode(file_get_contents('php://input'), true);
      // $response           = array('data' => $data ); 
      try {
        $updatedData          = $data['updatedData'];
        $keysToKeep = ['id', 'name', 'status'];
        $table = 'tbl_std_cashadvancetypes';
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
          $res = $this->benefits_model->update_setting_tables($table, $data, $edit_user); 
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

    function update_reimbursement_types()  {
      $data                 = json_decode(file_get_contents('php://input'), true);
      // $response           = array('data' => $data ); 
      try {
        $updatedData          = $data['updatedData'];
        $keysToKeep = ['id', 'name', 'status'];
        $table = 'tbl_std_reimbursementtypes';
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
          $res = $this->benefits_model->update_setting_tables($table, $data, $edit_user); 
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

    function dynamic()
    {
      $data['CUTOFF_PERIODS']                             = $this->benefits_model->GET_CUTOFF_LIST();
      $data['DYNAMIC_TYPE_LIST']                          = $dynamic_typelist = $this->benefits_model->GET_DYNAMIC_TYPE_LIST();
      $type = $this->input->get('type');
      if ($type == null) {
        if ($dynamic_typelist) {
          $type = $dynamic_typelist[0]->id;
        }
      }
      $data['TYPE'] = $type;
      $data['PERIOD']                                     = $this->input->get('period');
      $dynamic_std                                        = $this->benefits_model->GET_BENEFITS_DYNAMIC_STD($type);
      $data['DISP_DYNAMIC_ASSIGN']                        = $this->benefits_model->GET_BENEFITS_DYNAMIC_ASSIGN($type);
      $period                                             = ($data['PERIOD']) ?  $data['PERIOD'] : $data['CUTOFF_PERIODS'][0]->id;
      $employee_assign          = $this->benefits_model->GET_EMPLOYEELIST_ASSIGN();
      foreach ($employee_assign as $assign) {
        foreach ($dynamic_std as $standard) {
          if ($assign->category == $standard->id) {
            $assign->category = $standard->name;
          }
        }
      }
      $data['DISP_DYNAMIC_STD'] = $dynamic_std;
      $data['DISP_EMPLOYEELIST_ASSIGN']                   = $employee_assign;
      $data['DISP_BENEFITS_DYNAMIC']                      = $this->benefits_model->GET_BENEFITS_DYNAMIC_COUNT($period, $type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/dynamic_views', $data);
    }

    function taxable()
    {
      $type                                               = $this->input->get('type');

      $data['CUTOFF_PERIODS']                             = $this->benefits_model->GET_CUTOFF_LIST();
      $data['FIXED_TYPE_LIST']                            = $fixed_typelist = $this->benefits_model->GET_FIXED_TYPE_LIST();

      if ($type == null && $fixed_typelist) {
        $type = $fixed_typelist[0]->id;
      }

      $data['TYPE']                                       = $type;
      $data['PERIOD']                                     = $this->input->get('period');
      $period                                             = ($data['PERIOD']) ?  $data['PERIOD'] : $data['CUTOFF_PERIODS'][0]->id;
      $data['DISP_EMPLOYEELIST']                          = $this->benefits_model->GET_EMPLOYEELIST();
      $data['DISP_TRANSPORTATION_ALLOWANCE']              = $nightshift_allo = $this->benefits_model->GET_TRANSPORTATION_ALLOWANCE($type);
      $data['DISP_BENEFITS_FIXED']                        = $benefits_assign = $this->benefits_model->GET_BENEFITS_FIXED_ASSIGN($type);

      foreach ($benefits_assign as $benefits){
        $benefits->category = $this->benefits_model->convert_category_id_to_name($benefits->category);
      }

      foreach ($nightshift_allo as $allowance){
        $allowance->nightshift_category = $this->benefits_model->convert_nighshif_category_id_to_name($allowance->nightshift_category);
      }

      $data['DISP_CATEGORIES']                            = $this->benefits_model->GET_ALL_BENEFITS_DYNAMIC_STD($type);
      $data['DISP_NIGHTSHIFT_CATEGORIES']                 = $this->benefits_model->GET_SPECIFIC_BENEFITS_NIGHTSHIFT_CATEGORY_TAX($type);
      
      $data['tax_nontax_allowance']                       = $this->benefits_model->GET_SYSTEM_SETUP_SETTING('tax_nontax_allowance');
      $data['NIGHTSHIFT_ALLOWANCE_TAX']                   = $this->benefits_model->GET_SYSTEM_SETUP_SETTING('night_shift_allowance_tax');
      
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/fixed_views', $data);
    }

    function nontaxable(){

      $type                                               = $this->input->get('type');
      $data['CUTOFF_PERIODS']                             = $this->benefits_model->GET_CUTOFF_LIST();
      $data['NONTAXABLE_TYPE_LIST']                            = $fixed_typelist = $this->benefits_model->GET_NONTAXABLE_TYPE_LIST();

      if ($type == null && $fixed_typelist) {
        $type = $fixed_typelist[0]->id;
      }
      
      $data['TYPE']                                       = $type;
      $data['PERIOD']                                     = $this->input->get('period');
      $period                                             = ($data['PERIOD']) ?  $data['PERIOD'] : $data['CUTOFF_PERIODS'][0]->id;
      $data['DISP_EMPLOYEELIST']                          = $this->benefits_model->GET_EMPLOYEELIST();
      $data['DISP_TRANSPORTATION_ALLOWANCE_NONTAX']       = $nightshift_allo  = $this->benefits_model->GET_TRANSPORTATION_ALLOWANCE_NONTAX($type);
      $data['DISP_BENEFITS_NONTAXABLE_ASSIGN']            = $benefits_nontax_assign = $this->benefits_model->GET_BENEFITS_NONTAXABLE_ASSIGN($period, $type);
      
      foreach ($benefits_nontax_assign as $benefits){
        $benefits->category = $this->benefits_model->convert_nontax_category_id_to_name($benefits->category);
      }

      foreach ($nightshift_allo as $allowance){
        $allowance->nightshift_category = $this->benefits_model->convert_nontax_nighshif_category_id_to_name($allowance->nightshift_category);
      }

      $data['DISP_NONTAXABLE_CATEGORIES']                 = $this->benefits_model->GET_ALL_BENEFITS_NONTAXABLE_STD($type);
      $data['DISP_NIGHTSHIFT_CATEGORIES_NONTAX']          = $this->benefits_model->GET_SPECIFIC_BENEFITS_NIGHTSHIFT_CATEGORY_NONTAX($type);

      $data['tax_nontax_allowance']                       = $this->benefits_model->GET_SYSTEM_SETUP_SETTING('tax_nontax_allowance');
      $data['NIGHTSHIFT_ALLOWANCE_NONTAX']                = $this->benefits_model->GET_SYSTEM_SETUP_SETTING('night_shift_allowance_nontax');

      $this->load->view('templates/header');
      $this->load->view('modules/benefits/nontaxable_fixed_views', $data);

    }

    function other_deductions()
    {

      $type                                               = $this->input->get('type');

      $data['OTHER_DEDUCTIONS_TYPE_LIST']                 = $other_deductions_type_list = $this->benefits_model->GET_OTHER_DEDUCTIONS_TYPE_LIST();

      if ($type == null && $other_deductions_type_list) {
        $type = $other_deductions_type_list[0]->id;
      }

      $data['TYPE']                                       = $type;
      $data['CUTOFF_PERIODS']                             = $this->benefits_model->GET_CUTOFF_LIST();
      $data['PERIOD']                                     = $this->input->get('period');
      $period                                             = ($data['PERIOD']) ?  $data['PERIOD'] : $data['CUTOFF_PERIODS'][0]->id;
      $data['DISP_EMPLOYEELIST']                          = $this->benefits_model->GET_EMPLOYEELIST();
      $data['DISP_BENEFITS_FIXED']                        = $this->benefits_model->GET_OTHER_DEDUCTIONS_ASSIGN($period, $type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/other_deductions_views', $data);
    }

    function union_dues()
    {

      $type                                               = $this->input->get('type');

      $data['UNION_DUES_TYPE_LIST']                 = $union_dues_type_list = $this->benefits_model->GET_UNION_DUES_TYPE_LIST();

      if ($type == null && $union_dues_type_list) {
        $type = $union_dues_type_list[0]->id;
      }

      $data['TYPE']                                       = $type;
      $data['CUTOFF_PERIODS']                             = $this->benefits_model->GET_CUTOFF_LIST();
      $data['PERIOD']                                     = $this->input->get('period');
      $period                                             = ($data['PERIOD']) ?  $data['PERIOD'] : $data['CUTOFF_PERIODS'][0]->id;
      $data['DISP_EMPLOYEELIST']                          = $this->benefits_model->GET_EMPLOYEELIST();
      $data['DISP_BENEFITS_FIXED']                        = $this->benefits_model->GET_UNION_DUES_ASSIGN($period, $type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/union_dues_views', $data);
    }

    function adjustment()
    {
      $data['CUTOFF_PERIODS']                            = $this->benefits_model->GET_CUTOFF_LIST();
      $data['ADJUSTMENT_TYPE_LIST']                      = $fixed_typelist = $this->benefits_model->GET_ADJUSTMENT_TYPE_LIST();
      $type = $this->input->get('type');
      if ($type == null) {
        if ($fixed_typelist) {
          $type = $fixed_typelist[0]->id;
        }
      }
      $data["C_ROW_DISPLAY"]                            = [25, 50, 100];
      $data['TYPE'] = $type;
      $data['PERIOD']                                   = $this->input->get('period');
      $period                                           = ($data['PERIOD']) ?  $data['PERIOD'] : $data['CUTOFF_PERIODS'][0]->id;

      $adjustment_type   = $this->benefits_model->GET_ADJUSTMENT_VALUE_TYPE('adjustment_value_type');

      if($adjustment_type == null){
        $data['DISP_ADJ_VALUE_TYPE'] = "currency";
      }else{
        $data['DISP_ADJ_VALUE_TYPE'] = $adjustment_type;
      }

      $data['DISP_EMPLOYEELIST']                        = $this->benefits_model->GET_EMPLOYEELIST();
      $data['DISP_BENEFITS_ADJUSTMENT']                 = $this->benefits_model->GET_BENEFITS_ADJUSTMENT_ASSIGN($period, $type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/adjustment_views', $data);
    }
    function add_reimbursement_action(){
      $user_id                            = $this->session->userdata('SESS_USER_ID');
      $input_data                         = $this->input->post();
      $input_data['edit_user']          = $user_id;
      $input_data['requested_by']       = $user_id;
      $input_data['status']             = "Pending";
      $input_data['create_date']                        = date('Y-m-d H:i:s');
      $input_data['edit_date']                          = date('Y-m-d H:i:s');
  
      // unset($input_data['dates']);
      $table = 'tbl_benefits_reimbursement';
      $res  = $this->benefits_model->add_table_data($table, $input_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added');
        redirect('benefits/reimbursement');
      } else {
        $this->session->set_flashdata('ERR', 'Unable to add');
        redirect('benefits/add_reimbursement');
      }
    }

    function add_cashadvance_action(){
      $user_id                            = $this->session->userdata('SESS_USER_ID');
      $input_data                         = $this->input->post();
      $input_data['edit_user']          = $user_id;
      $input_data['requested_by']       = $user_id;
      $input_data['status']             = "Pending";
      $input_data['create_date']                        = date('Y-m-d H:i:s');
      $input_data['edit_date']                          = date('Y-m-d H:i:s');
  
      // unset($input_data['dates']);
      $table = 'tbl_benefits_cashadvance';
      $res  = $this->benefits_model->add_table_data($table, $input_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added');
        redirect('benefits/cashadvance');
      } else {
        $this->session->set_flashdata('ERR', 'Unable to add');
        redirect('benefits/add_cashadvance');
      }
    }

    function add_reimbursement(){
      $data['EMPLOYEES']                          = $this->benefits_model->GET_EMPLOYEES();
      $data['types']                          = $this->benefits_model->get_reimbursement_types();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_reimbursement_views', $data);
    }

    function add_cashadvance(){ 
      $data['EMPLOYEES']                          = $this->benefits_model->GET_EMPLOYEES();
      $data['types']                          = $this->benefits_model->get_table_types('tbl_std_cashadvancetypes');
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_cashadvance_views', $data);
    }

    function reimbursement_approval_action(){
      $user_id                            = $this->session->userdata('SESS_USER_ID');
      $input_data['remarks']   = $this->input->post('remarks');
      $input_data['status'] = $this->input->post('status');
      $input_data['edit_user']          = $user_id;
      $input_data['edit_date']                          = date('Y-m-d H:i:s');
      $input_data['approver']          = $user_id;
      $input_data['approver_date']                          = date('Y-m-d H:i:s');
      $id = $this->input->post('id');
      $table = 'tbl_benefits_reimbursement';
      $res  = $this->benefits_model->update_table_data($table, $input_data,$id);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully updated');
        redirect('benefits/reimbursement');
      } else {
        $this->session->set_flashdata('ERR', 'Update Failed');
        redirect('benefits/approval_reimbursement');
      }
    }

    function cashadvance_approval_action(){
      $user_id                            = $this->session->userdata('SESS_USER_ID');
      $input_data['remarks']   = $this->input->post('remarks');
      $input_data['status'] = $this->input->post('status');
      $input_data['edit_user']          = $user_id;
      $input_data['edit_date']                          = date('Y-m-d H:i:s');
      $input_data['approver']          = $user_id;
      $input_data['approver_date']                          = date('Y-m-d H:i:s');
      $id = $this->input->post('id');
      $table = 'tbl_benefits_cashadvance';
      $res  = $this->benefits_model->update_table_data($table, $input_data,$id);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully updated');
        redirect('benefits/cashadvance');
      } else {
        $this->session->set_flashdata('ERR', 'Update Failed');
        redirect('benefits/approval_cashadvance');
      }
    }

    function edit_reimbursement_form(){
      $user_id                            = $this->session->userdata('SESS_USER_ID');
      $input_data                         = $this->input->post();
      $input_data['edit_user']          = $user_id;
      $input_data['create_date']                        = date('Y-m-d H:i:s');
      $input_data['edit_date']                          = date('Y-m-d H:i:s');
  
      $id = $input_data['id'];
      unset($input_data['id']);
      $table = 'tbl_benefits_reimbursement';
      $res  = $this->benefits_model->update_table_data($table, $input_data,$id);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added');
        redirect('benefits/reimbursement');
      } else {
        $this->session->set_flashdata('ERR', 'Unable to add');
        redirect('benefits/add_reimbursement');
      }
    }
    function edit_reimbursement($id){
      $data['reimbursement']                        = $this->benefits_model->get_reimbursement_id($id);
      // var_dump($data['reimbursement']); 
      // var_dump($data['reimbursement']['id'] ); 
      // var_dump($data['reimbursement'][0]); 
      // die();
      $data['EMPLOYEES']                          = $this->benefits_model->GET_EMPLOYEES();
      $data['types']                          = $this->benefits_model->get_reimbursement_types();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/edit_reimbursement_views', $data);
    }

    function approval_reimbursement($id){
      $data['reimbursement']                        = $this->benefits_model->get_reimbursement_id_approval($id);
      $data['DATE_FORMAT']                          = $this->benefits_model->GET_SYSTEM_SETTING("date_format");
      // var_dump($data['reimbursement']); 
      // var_dump($data['reimbursement']['id'] ); 
      // var_dump($data['reimbursement'][0]); 
      // die();
      // $data['EMPLOYEES']                          = $this->benefits_model->GET_EMPLOYEES();
      // $data['types']                          = $this->benefits_model->get_reimbursement_types();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/approval_reimbursement_views', $data);
    }

    function approval_cashadvance($id){
      $data['data']                                  = $this->benefits_model->get_cashadvance_id_approval($id);
      $data['DATE_FORMAT']                           = $this->benefits_model->GET_SYSTEM_SETTING("date_format");
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/approval_cashadvance_views', $data);
    }

    function reimbursement()  {
      $search                                           = str_replace('_', ' ', $this->input->get('all') ?? "");
      $loan_types                                       = $this->benefits_model->GET_LOAN_TYPE_DATA();
      $tab                                              = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                              = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                                             = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                                           = ($page - 1) * $row;
      $data["C_ROW_DISPLAY"]              =              [25, 50, 100];

      $reimbursement                                  = $this->benefits_model->get_reimbursement($row, $offset, $search);
      $data_count                                     = $this->benefits_model->get_reimbursement_count($row, $offset, $search);

      // $data['ACTIVES']                                  = count($this->benefits_model->GET_PAYROLL_LOAN_DATA_COUNT('Active'));
      // $data['INACTIVES']                                = count($this->benefits_model->GET_PAYROLL_LOAN_DATA_COUNT('InActive'));
      $data['PAGE']                                     = $page;
      $page_count                                       = intval($data_count / $row);
      $excess                                           = $data_count % $row;
      $data['PAGES_COUNT']                              = $excess > 0 ? $page_count += 1 : $page_count;
      $data['C_DATA_COUNT']                             = $data_count;
      $data['ROW']                                      = $row;

      $data['tableData']                        = $reimbursement;
      $data['EMPLOYEES']                          = $this->benefits_model->GET_EMPLOYEES();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/reimbursement_views', $data);
    }

    function cashadvance()  {
      $search                                           = str_replace('_', ' ', $this->input->get('all') ?? "");
      $tab                                              = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                              = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                                             = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                                           = ($page - 1) * $row;
      $data["C_ROW_DISPLAY"]              =              [25, 50, 100];

      $tableData                                      = $this->benefits_model->get_cashadvance($row, $offset, $search);
      $data_count                                     = $this->benefits_model->get_cashadvance_count($row, $offset, $search);

      $data['PAGE']                                     = $page;
      $page_count                                       = intval($data_count / $row);
      $excess                                           = $data_count % $row;
      $data['PAGES_COUNT']                              = $excess > 0 ? $page_count += 1 : $page_count;
      $data['C_DATA_COUNT']                             = $data_count;
      $data['ROW']                                      = $row;

      $data['tableData']                          = $tableData;
      $data['EMPLOYEES']                          = $this->benefits_model->GET_EMPLOYEES();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/cashadvance_views', $data);
    }

    function loans()
    {
      $search                                           = str_replace('_', ' ', $this->input->get('all') ?? "");
      $loan_types                                       = $this->benefits_model->GET_LOAN_TYPE_DATA();
      $tab                                              = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                              = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                                             = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                                           = ($page - 1) * $row;
      $data["C_ROW_DISPLAY"]              =              [25, 50, 100];
      // if ($this->input->get('all') == null) {
      if (true) {
        // $payroll_loans                                  = $this->benefits_model->GET_PAYROLL_LOAN_DATA($tab, $row, $offset,$search);
        $payroll_loans                                  = $this->benefits_model->GET_PAYROLL_LOAN_DATA_NEW($tab, $row, $offset, $search);
        // echo '<pre>'; var_dump($payroll_loans);die();
        // $data_count                                     = count($this->benefits_model->GET_COUNT_PAYROLL_LOAN_DATA($tab));
        $data_count                                     = count($this->benefits_model->GET_COUNT_PAYROLL_LOAN_DATA_NEW($tab, $search));
      } else {
        $payroll_loans                                  = $this->benefits_model->GET_SEARCHED_LOAN_DATA($tab, $search);
        $data_count                                     = count($this->benefits_model->GET_SEARCHED_LOAN_DATA($tab, $search));
      }




      $payroll_data                                     = [];
      $data['DATE_FORMAT']                              = $this->benefits_model->GET_SYSTEM_SETTING("date_format");
      $data['ACTIVES']                                  = $this->benefits_model->GET_PAYROLL_LOAN_DATA_COUNT('Active');
      $data['INACTIVES']                                = $this->benefits_model->GET_PAYROLL_LOAN_DATA_COUNT('InActive');
      $data['PAGE']                                     = $page;
      $page_count                                       = intval($data_count / $row);
      $excess                                           = $data_count % $row;
      $data['PAGES_COUNT']                              = $excess > 0 ? $page_count += 1 : $page_count;
      $data['C_DATA_COUNT']                             = $data_count;
      $data['ROW']                                      = $row;
      $data['TAB']                                      = $tab;
      $index = 0;
      if ($payroll_loans) {
        foreach ($payroll_loans as $payroll_loan) {
          $payroll_data[$index]['id']                   = $payroll_loan->id;
          $payroll_data[$index]['date']                 = date('F j, Y', strtotime($payroll_loan->loan_date));
          $payroll_data[$index]['loan_amount']          = $payroll_loan->loan_amount > 0 ? number_format((float)$payroll_loan->loan_amount, 2) : $payroll_loan->loan_amount;
          $payroll_data[$index]['term_amount']          = $payroll_loan->loan_terms > 0 ?  number_format((float)$payroll_loan->loan_amount / $payroll_loan->loan_terms, 2) : $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_terms']           = $payroll_loan->loan_terms;
          $payroll_data[$index]['loan_status']          = $payroll_loan->status;
          $payroll_data[$index]['initial_paid']         = $payroll_loan->initial_paid;
          $payroll_data[$index]['loan_paid']            = $payroll_loan->initial_paid + $this->benefits_model->GET_LOANS($payroll_loan->id);
          $remaining_terms                              = $payroll_loan->loan_terms - ($payroll_loan->initial_paid + $this->benefits_model->GET_LOANS($payroll_loan->id));
          $payroll_data[$index]['loan_balance']         = number_format((float)$payroll_loan->loan_amount * $remaining_terms, 2) ;
          $payroll_data[$index]['loan_id']              = $this->benefits_model->GET_COUNT_LOAN_ID($payroll_loan->id);
          $payroll_data[$index]['name']                 = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name;
          if (!empty($payroll_loan->col_suffix)) $payroll_data[$index]['name'] = $payroll_data[$index]['name'] . ' ' . $payroll_loan->col_suffix;
          if (!empty($payroll_loan->col_frst_name)) $payroll_data[$index]['name'] = $payroll_data[$index]['name'] . ', ' . $payroll_loan->col_frst_name;
          if (!empty($payroll_loan->col_midl_name)) $payroll_data[$index]['name'] = $payroll_data[$index]['name'] . ' ' . $payroll_loan->col_midl_name[0] . '.';
          // $payroll_data[$index]['name']                 = $payroll_loan->col_empl_cmid . ' - ' . $payroll_loan->col_last_name . ', ' . $payroll_loan->col_frst_name . ' ' . strtoupper(substr($payroll_loan->col_midl_name, 0, 1)) . '.';
          foreach ($loan_types as $loan_type) {
            if ($loan_type->id == $payroll_loan->loan_type) {
              $payroll_data[$index]['loan_type'] = $loan_type->name;
            }
          }
          $index += 1;
        }
      }
      $data['DISP_PAYROLL_LOAN'] = $payroll_data;
      $data['EMPLOYEES']                          = $this->benefits_model->GET_EMPLOYEES();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/loan_views', $data);
    }

    function bulk_activate()
    {
      $loan_ids                                  = explode(',', $this->input->post('active'));
      $table                                     = $this->input->post('table');
      $data = array();
      foreach ($loan_ids as $id) {
        $data[] = array('id' => $id, 'status' => 'Active');
      }
      $res                                        = $this->benefits_model->UPDATE_BULK_ACTIVATE($data, $table);
      $this->session->set_userdata('SESS_SUCCESS', 'Successfully Updated!');
      if ($table == 'tbl_payroll_deductions') {
        redirect('benefits/deductions');
      }
      if ($table == 'tbl_benefits_loan') {
        redirect('benefits/loans');
      }
      if ($table == 'tbl_payroll_cashadvance') {
        redirect('benefits/cash_advances');
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
      $res                                           = $this->benefits_model->UPDATE_BULK_ACTIVATE($data, $table);
      $this->session->set_userdata('SESS_SUCCESS', 'Successfully Updated!');
      
      if ($table == 'tbl_payroll_deductions') {
        redirect('benefits/deductions');
      }
      if ($table == 'tbl_benefits_loan') {
        redirect('benefits/loans');
      }
      if ($table == 'tbl_payroll_cashadvance') {
        redirect('benefits/cash_advances');
      }
    }


    function dynamic_assignment()
    {
      $data['CUTOFF_PERIODS']                           = $this->benefits_model->GET_CUTOFF_LIST();
      $data['DYNAMIC_TYPE_LIST']                        = $dynamic_typelist = $this->benefits_model->GET_DYNAMIC_TYPE_LIST();
      $type = $this->input->get('type');
      if ($type == null || $type == "") {
        $type = $dynamic_typelist[0]->id;
      }
      $data['TYPE'] = $type;
      $data['PERIOD']                                   = $period = $this->input->get('period');
      $data['DISP_EMPLOYEE_LIST']                       = $this->benefits_model->GET_EMPLOYEELIST();
      $data['DISP_DYNAMIC_ASSIGN']                      = $this->benefits_model->GET_BENEFITS_DYNAMIC_ASSIGN($type);
      $data['DISP_DYNAMIC_STD']                         = $this->benefits_model->GET_BENEFITS_DYNAMIC_STD($type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/dynamic_assignment_views', $data);
    }
    function dynamic_standard()
    {
      $data['CUTOFF_PERIODS']                           = $this->benefits_model->GET_CUTOFF_LIST();
      $data['DYNAMIC_TYPE_LIST']                        = $dynamic_typelist = $this->benefits_model->GET_DYNAMIC_TYPE_LIST();
      $type = $this->input->get('type');
      if ($type == null) {
        if ($dynamic_typelist) {
          $type = $dynamic_typelist[0]->id;
        }
      }
      $data['TYPE'] = $type;
      $data['DISP_DYNAMIC_STD']                         = $this->benefits_model->GET_BENEFITS_DYNAMIC_STD($type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/dynamic_standard_views', $data);
    }
    function dynamic_type()
    {
      $data['CUTOFF_PERIODS']                           = $this->benefits_model->GET_CUTOFF_LIST();
      $data['PERIOD']                                   = $period = $this->input->get('period');
      $data['DYNAMIC_TYPE_LIST']                        = $this->benefits_model->GET_DYNAMIC_TYPE_LIST();
      $data['DISP_DYNAMIC_TYPE']                        = $this->benefits_model->GET_BENEFITS_DYNAMIC_TYPE();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/dynamic_type_views', $data);
    }
    function taxable_type()
    {
      $data['DISP_FIXED_TYPE']                          = $this->benefits_model->GET_BENEFITS_FIXED_TYPE();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/fixed_type_views', $data);
    }

    function nontaxable_type(){
      $data['DISP_NONTAXABLE_TYPE']                          = $this->benefits_model->GET_BENEFITS_NONTAXABLE_TYPE();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/nontaxable_type_views', $data);
    }

    function add_taxable_type(){
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_taxable_type_views');
    }

    function add_nontaxable_type(){
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_nontaxable_type_views');
    }

    function edit_taxable_type($id){
      $data['DISP_TAXABLE_TYPES']                       = $this->benefits_model->GET_TAXABLE_TYPES($id);
      
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/edit_taxable_type_views', $data);

    }

    function edit_nontaxable_type($id){
      $data['DISP_NONTAXABLE_TYPES']                       = $this->benefits_model->GET_NONTAXABLE_TYPES($id);
      
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/edit_nontaxable_type_views', $data);

    }

    function insert_taxable_types(){
      $name             = $this->input->post('name');
      $type             = $this->input->post('type');

      $this->benefits_model->INSERT_TAXABLE_TYPES($name, $type);
      $this->session->set_flashdata('SUCC', 'Successfully added');
      redirect('benefits/taxable_type');
    }

    function insert_nontaxable_types(){
      $name             = $this->input->post('name');
      $type             = $this->input->post('type');

      $this->benefits_model->INSERT_NONTAXABLE_TYPES($name, $type);
      $this->session->set_userdata('SUCCESS', 'Non-Taxable Added Successfully!');
      redirect('benefits/nontaxable_type');
    }

    function update_taxable_types(){
      $type_id          = $this->input->post('type_id');
      $name             = $this->input->post('name');
      $type             = $this->input->post('type');

      $this->benefits_model->UPDATE_TAXABLE_TYPES($name, $type, $type_id);
      $this->session->set_userdata('SUCCESS', 'Taxable type updated successfully!');
      redirect('benefits/taxable_type');
      
    }


    function update_nontaxable_types(){
      $type_id          = $this->input->post('type_id');
      $name             = $this->input->post('name');
      $type             = $this->input->post('type');

      $this->benefits_model->UPDATE_NONTAXABLE_TYPES($name, $type, $type_id);
      $this->session->set_userdata('SUCCESS', 'Non-Taxable type updated successfully!');
      redirect('benefits/nontaxable_type');
      
    }

    function add_category()
    {
      $type                                             = $this->input->get('type');
    
      $data['DISP_FIXED_TYPE']                          = $fixed_type = $this->benefits_model->GET_BENEFITS_FIXED_TYPE();

      if($type == null){
        $type = $fixed_type[0]->id;
      }

      $data['TYPE']                                     = $type;
      $data['DISP_CATEGORIES']                          = $this->benefits_model->GET_SPECIFIC_BENEFITS_DYNAMIC_STD($type);
    
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_category_views', $data);
    }

    function add_nightshift_category()
    {
      $type                                             = $this->input->get('type');

      $data['DISP_FIXED_TYPE']                          = $fixed_type = $this->benefits_model->GET_BENEFITS_FIXED_TYPE();

      if($type == null){
        $type = $fixed_type[0]->id;
      }

      $data['TYPE']                                     = $type;
      $data['DISP_CATEGORIES']                          = $this->benefits_model->GET_SPECIFIC_BENEFITS_NIGHTSHIFT_CATEGORY_TAX($type);
    
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_nightshift_category_views', $data);
    }


    function add_nontaxable_category(){
      $type                                             = $this->input->get('type');

      $data['DISP_NONTAXABLE_TYPE']                     = $nontax_type = $this->benefits_model->GET_BENEFITS_NONTAXABLE_TYPE();

      if($type == null && !empty($nontax_type)){
        $type = $nontax_type[0]->id;
      }

      $data['TYPE']                                     = $type;

      $data['DISP_CATEGORIES']                          = $this->benefits_model->GET_SPECIFIC_BENEFITS_NONTAXABLE_STD($type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_nontaxable_category_views', $data);

    }


    function add_nightshift_category_nontax(){
      $type                                             = $this->input->get('type');
    
      $data['DISP_NONTAXABLE_TYPE']                     = $nontax_type = $this->benefits_model->GET_BENEFITS_NONTAXABLE_TYPE();

      if($type == null && !empty($nontax_type)){
        $type = $nontax_type[0]->id;
      }

      $data['TYPE']                                     = $type;
      
      $data['DISP_CATEGORIES']                          = $this->benefits_model->GET_SPECIFIC_BENEFITS_NIGHTSHIFT_CATEGORY_NONTAX($type);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_nightshift_category_nontax_views', $data);

    }

    function other_deductions_type()
    {
      $data['DISP_FIXED_TYPE']                          = $this->benefits_model->GET_OTHER_DEDUCTIONS_TYPE();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/other_deductions_type_views', $data);
    }

    function union_dues_type()
    {
      $data['DISP_FIXED_TYPE']                          = $this->benefits_model->GET_UNION_DUES_TYPE();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/union_dues_type_views', $data);
    }

    function adjustment_type()
    {
      $data['DISP_ADJUSTMENT_TYPE']                     = $this->benefits_model->GET_BENEFITS_ADJUSTMENT_TYPE();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/adjustment_type_views', $data);
    }
    function add_loans()
    {
      $data['DISP_EMPLOYEE_LIST']                       = $this->benefits_model->GET_EMPLOYEELIST();
      $data['LOAN_TYPES']                               = $this->benefits_model->GET_LOAN_TYPE_DATA();
      $data['PAYROLL_PERIOD']                           = $this->benefits_model->GET_CUTOFF_LIST();
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/add_loans_views', $data);
    }
    function edit_loans()
    {

      $tab                                              = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
      $row                                              = $this->input->get('row') ? $this->input->get('row') : 25;
      $page                                             = $this->input->get('page') ? $this->input->get('page') : 1;
      $offset                                           = ($page - 1) * $row;
      $data["C_ROW_DISPLAY"]                            = [25, 50, 100];

      $data['DISP_EMPLOYEE_LIST']                       = $this->benefits_model->GET_EMPLOYEELIST();
      $data['LOAN_TYPES']                               = $this->benefits_model->GET_LOAN_TYPE_DATA();

      $loans                                            = $this->benefits_model->GET_ALL_BENEFITS_LOAN($tab, $row, $offset);
      $data['PAYROLL_PERIOD']                           = $payroll_periods = $this->benefits_model->GET_CUTOFF_LIST();

      foreach ($loans as $loan) {
          if ($loan->start_period != null) {
            $loan->start_period                         = $this->benefits_model->CONVERT_ID_TO_NAME_PERIOD($loan->start_period);
          }
      } 

      $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
      $row = 10; 
      $offset = ($current_page - 1) * $row;
      $total_loans_count = count($loans);
      $low_limit = $offset + 1;
      $high_limit = min($offset + $row, $total_loans_count);

      $data['low_limit'] = $low_limit;
      $data['high_limit'] = $high_limit;
      $data['C_DATA_COUNT'] = $total_loans_count;

      $data['DISP_LOANS']                               = $loans;
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/edit_loans_views', $data);
    }


    function edit_loan($id)
    {
      $data['DISP_EMPLOYEES'] = $this->benefits_model->GET_EMPLOYEE_LIST();
      $data['LOAN_TYPES']     = $this->benefits_model->GET_LOAN_TYPE_DATA();
      $data['LOAN_INFO']      = $this->benefits_model->GET_SPEC_LOAN($id);
      $this->load->view('templates/header');
      $this->load->view('modules/benefits/edit_loan_views', $data);
    }

    function delete_loan($id)
    {
      try {
        $res = $this->benefits_model->delete_loan($id);
        if ($res) {
          $this->session->set_flashdata('SUCC','Data deleted successfully');
          $response = array('success_message' => 'Data deleted successfully');

        } else {
         
          $response = array('warning_message' => 'No data found to delete');
        }
      } catch (Exception $e) {
        log_message('error', 'Error updating data: ' . $e->getMessage());
       
        $response = array('error_message' => 'An unexpected error occurred while deleting data. Please try again later.');
      }
      echo json_encode($response);
    }

    function insert_loans()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->INSERT_LOANS_DATA($data_row);
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }


    function update_benefits_loan()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->UPDATE_BENEFITS_LOAN($data_row);
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function update_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $selectedValue = $data['selectedValue'];
      $dynamic_std                       = $this->benefits_model->GET_BENEFITS_DYNAMIC_STD($selectedValue);
      foreach ($updatedData as &$row) {
        if ($row[3] != "") {
          foreach ($dynamic_std as $row_std) {
            if ($row_std->name == $row[3]) {
              $row[3] = $row_std->id;
            }
          }
        }
      }
      try {
        foreach ($updatedData as $data_row) {
          $this->benefits_model->UPDATE_DATA($data_row, $selectedValue);
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($updatedData);
    }
    function delete_count_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $idsToDelete = $data['idsToDelete'];
      $periodValue = $data['periodValue'];
      $typeValue = $data['typeValue'];
      // $dynamic_std                       = $this->benefits_model->GET_BENEFITS_DYNAMIC_STD($typeValue);
      // foreach ($updatedData as &$row) {
      //   if ($row[2] != "") {
      //     foreach ($dynamic_std as $row_std) {
      //       if ($row_std->name == $row[2]) {
      //         $row[2] = $row_std->id;
      //       }
      //     }
      //   }
      // }
      try {
        foreach ($idsToDelete as $data_row) {
          $this->benefits_model->DELETE_COUNT_DATA($data_row, $periodValue, $typeValue, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function update_count_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $periodValue = $data['periodValue'];
      $typeValue = $data['typeValue'];
      $dynamic_std                       = $this->benefits_model->GET_BENEFITS_DYNAMIC_STD($typeValue);
      foreach ($updatedData as &$row) {
        if ($row[2] != "") {
          foreach ($dynamic_std as $row_std) {
            if ($row_std->name == $row[2]) {
              $row[2] = $row_std->id;
            }
          }
        }
      }
      try {
        foreach ($updatedData as $data_row) {
          $this->benefits_model->UPDATE_COUNT_DATA($data_row, $periodValue, $typeValue, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function update_fixed_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $periodValue = $data['periodValue'];
      $typeValue = $data['typeValue'];
      $employees                       = $this->benefits_model->GET_EMPLOYEELIST();

      // foreach ($updatedData as &$row) {
      //   $matchFound = false;
      //   if ($row[1] != "") {
      //     foreach ($employees as $row_std) {
      //       if ($row_std->col_empl_cmid == $row[1]) {
      //         $row[1] = $row_std->id;
      //         $matchFound = true;
      //         break;
      //       }
      //     }
      //   }
      //   if (!$matchFound) {
      //     $row[1] = "";
      //   }
      // }

      try {
        foreach ($updatedData as $data_row) {
          $test = $this->benefits_model->UPDATE_FIXED_DATA($data_row, $periodValue, $typeValue, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function update_nontaxable_data(){
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $periodValue = $data['periodValue'];
      $typeValue = $data['typeValue'];
      $employees                       = $this->benefits_model->GET_EMPLOYEELIST();

      try {
        foreach ($updatedData as $data_row) {
          $test = $this->benefits_model->UPDATE_NONTAXABLE_DATA($data_row, $periodValue, $typeValue, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function update_other_deductions_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $periodValue = $data['periodValue'];
      $typeValue = $data['typeValue'];
      $employees                       = $this->benefits_model->GET_EMPLOYEELIST();
      foreach ($updatedData as &$row) {
        $matchFound = false;
        if ($row[1] != "") {
          foreach ($employees as $row_std) {
            if ($row_std->col_empl_cmid == $row[1]) {
              $row[1] = $row_std->id;
              $matchFound = true;
              break;
            }
          }
        }
        if (!$matchFound) {
          $row[1] = "";
        }
      }
      try {
        foreach ($updatedData as $data_row) {
          $test = $this->benefits_model->UPDATE_OTHER_DEDUCTION_DATA($data_row, $periodValue, $typeValue, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      // echo json_encode($updatedData);
      echo json_encode($response);
    }

    function update_union_dues_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $periodValue = $data['periodValue'];
      $typeValue = $data['typeValue'];
      $employees                       = $this->benefits_model->GET_EMPLOYEELIST_DATA();

      foreach ($updatedData as &$row) {
        $matchFound = false;
        if ($row[1] != "") {
          foreach ($employees as $row_std) {
            if ($row_std->col_empl_cmid == $row[1]) {
              $row[1] = $row_std->id;
              $matchFound = true;
              break;
            }
          }
        }
        if (!$matchFound) {
          $row[1] = "";
        }
      }

      try {
        foreach ($updatedData as $data_row) {
          $test = $this->benefits_model->UPDATE_UNION_DUES_DATA($data_row, $periodValue, $typeValue, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      // echo json_encode($updatedData);
      echo json_encode($response);
    }

    function delete_fixed_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->DELETE_FIXED_DATA($data_row);
        }
        $response = array('success_message' => 'Data deleted successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Data deletion error: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function udpate_adjustment_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $periodValue = $data['periodValue'];
      $typeValue = $data['typeValue'];
      $employees                       = $this->benefits_model->GET_EMPLOYEELIST();
      foreach ($updatedData as &$row) {
        $matchFound = false;
        if ($row[1] != "") {
          foreach ($employees as $row_std) {
            if ($row_std->col_empl_cmid == $row[1]) {
              $row[1] = $row_std->id;
              $matchFound = true;
              break;
            }
          }
        }
        if (!$matchFound) {
          $row[1] = "";
        }
      }
      try {
        foreach ($updatedData as $data_row) {
          $this->benefits_model->UPDATE_ADJUSTMENT_DATA($data_row, $periodValue, $typeValue);
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function convert_adjustment_data(){
      $data = json_decode(file_get_contents('php://input'), true);
      $result = $this->benefits_model->UPDATE_ADJUSTMENT_VALUE_TYPE($data, 'adjustment_value_type');
      if ($result){
        $response = array('success_message' => 'Data converted successfully');
      }else{
        $response = array('warning_message' => 'Error updating data: ');
      }
      
      echo json_encode($response);
    }
    
    function delete_adjustment_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->DELETE_ADJUSTMENT_DATA($data_row);
        }
        $response = array('success_message' => 'Data deleted successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Data deletion error: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function update_dynamic_std($type)
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->UPDATE_DYNAMIC_STD($data_row, $type, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function update_dynamic_type()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->UPDATE_DYNAMIC_TYPE($data_row, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function delete_fixed_type()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        $response = array('success_message' => 'Data deleted successfully');
        $idFailedToDelete = [];
        foreach ($data as $data_row) {
          $update = $this->benefits_model->delete_fixed_type($data_row, $this->session->userdata('SESS_USER_ID'));
          if (!$update) $idFailedToDelete[] = $data_row;
        }
        if (count($idFailedToDelete)) {
          $commaSeparatedString = implode(', ', $idFailedToDelete);
          $response = array('warning_message' => 'Failed to update id:  ' . $commaSeparatedString);
        }
      } catch (Exception $e) {
        $response = array('warning_message' => 'Data deletion error: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function delete_dynamic_std()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        $response = array('success_message' => 'Data deleted successfully');
        $idFailedToDelete = [];
        foreach ($data as $data_row) {
          $update = $this->benefits_model->delete_dynamic_std($data_row, $this->session->userdata('SESS_USER_ID'));
          if (!$update) $idFailedToDelete[] = $data_row;
        }
        if (count($idFailedToDelete)) {
          $commaSeparatedString = implode(', ', $idFailedToDelete);
          $response = array('warning_message' => 'Failed to update id:  ' . $commaSeparatedString);
        }
      } catch (Exception $e) {
        $response = array('warning_message' => 'Data deletion error: ' . $e->getMessage());
      }
      echo json_encode($response);
    }
    function delete_dynamic_type()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        $response = array('success_message' => 'Data deleted successfully');
        $idFailedToDelete = [];
        foreach ($data as $data_row) {
          $update = $this->benefits_model->delete_dynamic_type($data_row, $this->session->userdata('SESS_USER_ID'));
          if (!$update) $idFailedToDelete[] = $data_row;
        }
        if (count($idFailedToDelete)) {
          $commaSeparatedString = implode(', ', $idFailedToDelete);
          $response = array('warning_message' => 'Failed to update id:  ' . $commaSeparatedString);
        }
      } catch (Exception $e) {
        $response = array('warning_message' => 'Data deletion error: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function update_fixed_type()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->UPDATE_FIXED_TYPE($data_row, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function insert_category()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $type = $data['type'];
      try {
        foreach ($updatedData as $data_row) {
          $this->benefits_model->INSERT_CATEGORY($data_row, $type, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function insert_nightshift_category(){
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $type = $data['type'];
      try {
        foreach ($updatedData as $data_row) {
          $this->benefits_model->INSERT_NIGHTSHIFT_CATEGORY($data_row, $type, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($data);
    }

    function insert_nightshift_category_nontax(){
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $type = $data['type'];
      try {
        foreach ($updatedData as $data_row) {
          $this->benefits_model->INSERT_NIGHTSHIFT_CATEGORY_NONTAX($data_row, $type, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function insert_nontax_category(){
      $data = json_decode(file_get_contents('php://input'), true);
      $updatedData = $data['updatedData'];
      $type = $data['type'];
      try {
        foreach ($updatedData as $data_row) {
          $this->benefits_model->INSERT_NONTAX_CATEGORY($data_row, $type, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }



    function update_other_deductions_type()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->UPDATE_OTHER_DEDUCTIONS_TYPE($data_row, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

    function update_union_dues_type()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->UPDATE_UNION_DUES_TYPE($data_row, $this->session->userdata('SESS_USER_ID'));
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
    }


    function update_adjustment_type()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        foreach ($data as $data_row) {
          $this->benefits_model->UPDATE_ADJUSTMENT_TYPE($data_row);
        }
        $response = array('success_message' => 'Data updated successfully');
      } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
      }
      echo json_encode($response);
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
