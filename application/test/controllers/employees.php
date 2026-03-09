    <?php defined('BASEPATH') OR exit('No direct script access allowed');
define('PUBPATH',str_replace(SELF,'',FCPATH)); // added
ob_start();
class employees extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('templates/main_nav_model');
        $this->load->model('templates/main_table_02_model');
        $this->load->model('templates/employee_module_model');
        $this->load->model('modules/employees_model');
        $this->load->library('logger');

        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
        }

        $maintenance              = $this->login_model->GET_MAINTENANCE();
        $isAdmin                  = $this->session->userdata('SESS_ADMIN');
        if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
        }
    }
    function index()
        {
        $data["Modules"]=  array( 
            array("title"=>"Employee Directory",            "icon"=>"fa-duotone fa-users-gear",             "url"=>"employees/directories",                   "access"=>"Employee" , "id"=>"employee_directory"),
            // array("title"=>"Allowance Assignment",       "icon"=>"fas fa-money-bill-wave",               "url"=>"employees/allowance_assign",              "access"=>"Employee" , "id"=>"allowance_assignment"),
            array("title"=>"Taxable Allowance",             "icon"=>"fa-duotone fa-up-to-line",             "url"=>"employees/taxable_allowance_assign",      "access"=>"Employee" , "id"=>"taxable_allowance"),
            array("title"=>"Non-Taxable Allowance",         "icon"=>"fa-duotone fa-up-to-dotted-line",      "url"=>"employees/non_taxable_allowance_assign",  "access"=>"Employee" , "id"=>"non-taxable_allowance"),
            // array("title"=>"Deduction Assignment",       "icon"=>"fas fa-money-bill-wave",               "url"=>"employees/deduction_assign",              "access"=>"Employee" ,"id"=>"deduction_assignment"),
            // array("title"=>"Taxable Deduction",             "icon"=>"fa-duotone fa-down-to-line",        "url"=>"employees/taxable_deduction_assign",      "access"=>"Employee" ,"id"=>"taxable_deduction"),
            // array("title"=>"Non-Taxable Deduction",         "icon"=>"fa-duotone fa-down-to-dotted-line", "url"=>"employees/non_taxable_deduction_assign",  "access"=>"Employee" ,"id"=>"non-taxable_deduction"),
            // array("title"=>"Skill Assignment",              "icon"=>"fa-duotone fa-dial-med-low",        "url"=>"employees/skill_assign",                  "access"=>"Employee" ,"id"=>"skill_assignment"),
            array("title"=>"Salary Details",                "icon"=>"fa-duotone fa-money-bill-1-wave",      "url"=>"employees/salary_details",                "access"=>"Employee" , "id"=>"salary_details"),
        );

        $data["title_page"]                 = "Employee Module";
        $user_access_id                     = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
        $data['DISP_USER_ACCESS_PAGE']      = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
        $array_page                         = explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
        $data['Modules']                    = filter_array($data["Modules"],$array_page);
        $this->load->view('templates/header');
        $this->load->view('templates/main_nav',$data);
        
}
    function directories(){
        $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
        $dept                               = $this->input->get('dept');
        $sec                                = $this->input->get('sec');
        $group                              = $this->input->get('group');
        $line                               = $this->input->get('line');
        $branch                             = $this->input->get('branch');
        $division                           = $this->input->get('division');
        $team                               = $this->input->get('team');
        $status                             = $this->input->get('status');

        $data["C_ROW_DISPLAY"]              = [25, 50, 100];

        $page                               = $this->input->get('page');
        $row                                = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);
        if($status==null){
            $status=0;
        }
        $data['C_DATA_COUNT']               = count($this->employees_model->FILTER_EMPLOYEE_COUNT($dept, $sec, $group, $line,$branch,$division,$team, $status));
        if($this->input->get('all') == null){
            $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_ALL_EMPLOYEES_LIMIT($offset, $row, $dept, $sec, $group, $line,$branch,$division,$team, $status);
            $data['C_DATA_COUNT']           = count($this->employees_model->FILTER_EMPLOYEE_COUNT($dept, $sec, $group, $line,$branch,$division,$team, $status));
        }
        else{
            $data['DISP_EMP_LIST']          = $this->employees_model->MOD_DISP_SEARCH_EMPLOYEES($search,$status);
            $data['C_DATA_COUNT']           = count($this->employees_model->MOD_DISP_SEARCH_EMPLOYEES($search,$status));
        } 
        
        $data['DISP_ROW_COUNT']             = count($this->employees_model->MOD_DISP_ALL_EMPLOYEES());
        $data['DISP_ROW_ACTIVE_COUNT']      = $this->employees_model->MOD_DISP_ALL_ACTIVE_COUNT();
        
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

        $this->load->view('templates/header');
        $this->load->view('modules/employees/employee_list_views',$data);
        
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
                array("id","text",0,0,0,1,5,"ID","id",1,"0"),
                array("create_date","datetime-local",0,0,0,1,10,"Create Date","date",1,"0"),
                array("edit_date","datetime-local",0,0,0,0,0,"Edit Date","date",1,"0"),
                array("edit_user","text",0,0,0,0,0,"Last Edited By","user",1,"0"),
                array("is_deleted","text",0,0,0,0,0,"Is Deleted","none",0,"0"),
                array("col_empl_id","text",256,0,0,1,15,"Employee Name","user",1,"0"),
                array("col_educ_degree","text",256,1,1,1,10,"Degree","none",1,"0"),
                array("col_educ_school","text",256,1,1,1,10,"School","none",1,"0"),
                array("col_educ_from_yr","text",256,1,1,1,10,"From (Year)","none",1,"0"),
                array("col_educ_to_yr","text",256,1,1,1,10,"To (Year)","none",1,"0"),
                array("col_educ_grade","text",256,1,1,0,0,"Grade","none",1,"0"),
                array("address","text",256,0,0,0,0,"Address","textarea",1,"0"),
                array("completion","sel",256,1,1,1,10,"Completion","status",1,"Incomplete;Completed"),
                array("col_educ_level","text",256,1,1,1,10,"Completion","status",1,"Primary;Secondary;Tertiary;Vocational"),
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

    function allowance_assign(){

        if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}

        $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        $data['DISP_YEARS']        		        = $year_list = $this->employees_model->GET_YEARS();
        $data["DISP_ALLOWANCE_TYPES"] 		    = $this->employees_model->GET_ALLOWANCE_TYPES();
        

        (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];

     
        $data['YEAR_INITIAL']             = $year;
        $data["DISP_ALLOWANCE"]		      = $this->employees_model->GET_ALLOWANCE_DATA($year);

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

    function taxable_allowance_assign(){
        $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

        if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}

        $data["C_ROW_DISPLAY"]                      =  [25,50,100];
        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);

        if($this->input->get('all') == null){
            $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
            $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        }else{
            $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED($search);
			$data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED($search));
        }
        
        $data['DISP_YEARS']        		            = $year_list = $this->employees_model->GET_YEARS();
        $data["DISP_ALLOWANCE_TYPES"] 		        = $this->employees_model->GET_TAXABLE_ALLOWANCE_TYPES();
        // $data['C_DATA_COUNT']                   = $this->employees_model->GET_COUNT_EMPLOYEELIST();
        
        (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];
     
        $data['YEAR_INITIAL']                   = $year;
        $data["DISP_ALLOWANCE"]		            = $this->employees_model->GET_ALLOWANCE_TAX_DATA($year);

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


    function non_taxable_allowance_assign(){
        $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

        if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}
        $data["C_ROW_DISPLAY"]                      =  [25,50,100];

        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);

        if($this->input->get('all') == null){
            $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
            $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        }else{
            $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED($search);
            $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED($search));
        }

        $data['DISP_YEARS']        		            = $year_list = $this->employees_model->GET_YEARS();
        $data["DISP_ALLOWANCE_TYPES"] 		        = $this->employees_model->GET_NON_TAXABLE_ALLOWANCE_TYPES();
        

        (!isset($_GET["year"])) ? $year             = $year_list[0]->id : $year = $_GET["year"];
     
        $data['YEAR_INITIAL']                       = $year;
        $data["DISP_ALLOWANCE"]		                = $this->employees_model->GET_ALLOWANCE_NON_TAX_DATA($year);

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

    function taxable_deduction_assign(){

        if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}
        
        $data["C_ROW_DISPLAY"]                      =  [25,50,100];

        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);

        $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        $data['DISP_YEARS']        		        = $year_list = $this->employees_model->GET_YEARS();
        $data["DISP_DEDUCTION_TYPES"] 		    = $this->employees_model->GET_TAXABLE_DEDUCTION_TYPES();
        $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);

        (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];
     
        $data['YEAR_INITIAL']                   = $year;
        $data["DISP_DEDUCTION"]		            = $this->employees_model->GET_DEDUCTION_TAX_DATA($year);

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

    function non_taxable_deduction_assign(){

        if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}

        $data["C_ROW_DISPLAY"]                  =  [25,50,100];

        $page                                   = $this->input->get('page');
        $row                                    = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);

        $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        $data['DISP_YEARS']        		        = $year_list = $this->employees_model->GET_YEARS();
        $data["DISP_DEDUCTION_TYPES"] 		    = $this->employees_model->GET_NON_TAXABLE_DEDUCTION_TYPES();
        $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);

        (!isset($_GET["year"])) ? $year         = $year_list[0]->id : $year = $_GET["year"];
     
        $data['YEAR_INITIAL']                   = $year;
        $data["DISP_DEDUCTION"]		            = $this->employees_model->GET_DEDUCTION_NON_TAX_DATA($year);

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
    

    function process_assigning($user_id, $allowance_val, $year,$type){

        $response                               = $this->employees_model->is_duplicate($user_id, $year,$type);

        if ($response == 0) {
            $res_insrt                          = $this->employees_model->ADD_USER_ALLOWANCE($user_id, $allowance_val, $year,$type);
        } else {
            $res_insrt                          = $this->employees_model->UPDATE_USER_ALLOWANCE($user_id, $allowance_val, $year,$type);
        }

        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
          }
    }

    function process_allowance_assigning_tax($user_id, $allowance_val, $year,$type){

        $response                               = $this->employees_model->IS_DUPLICATE_ALLOWANCE_TAX($user_id, $year,$type);

        if ($response == 0) {
            $res_insrt                          = $this->employees_model->ADD_USER_ALLOWANCE_TAX($user_id, $allowance_val, $year,$type);
        } else {
            $res_insrt                          = $this->employees_model->UPDATE_USER_ALLOWANCE_TAX($user_id, $allowance_val, $year,$type);
        }
        
        $this->session->set_userdata('SESS_SUCCESS', 'Taxable Allowance Updated Successfully!');
        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
        }
  
        // redirect('employees/taxable_allowance_assign');
    }

    function process_allowance_assigning_nontax($user_id, $allowance_val, $year,$type){

        $response                               = $this->employees_model->IS_DUPLICATE_ALLOWANCE_NONTAX($user_id, $year,$type);

        if ($response == 0) {
            $res_insrt                          = $this->employees_model->ADD_USER_ALLOWANCE_NONTAX($user_id, $allowance_val, $year,$type);
        } else {
            $res_insrt                          = $this->employees_model->UPDATE_USER_ALLOWANCE_NONTAX($user_id, $allowance_val, $year,$type);
        }

        $this->session->set_userdata('SESS_SUCCESS', 'Non-Taxable Allowance Updated Successfully!');
        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
          }
    }


    function process_deduction_assigning_tax($user_id, $allowance_val, $year,$type){

        $response                               = $this->employees_model->IS_DUPLICATE_DEDUCTION_TAX($user_id, $year,$type);

        if ($response == 0) {
            $res_insrt                          = $this->employees_model->ADD_USER_DEDUCTION_TAX($user_id, $allowance_val, $year,$type);
        } else {
            $res_insrt                          = $this->employees_model->UPDATE_USER_DEDUCTION_TAX($user_id, $allowance_val, $year,$type);
        }

        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
          }
    }

    function process_deduction_assigning_nontax($user_id, $val, $year,$type){

        $response                               = $this->employees_model->IS_DUPLICATE_DEDUCTION_NONTAX($user_id, $year,$type);

        if ($response == 0) {
            $res_insrt                          = $this->employees_model->ADD_USER_DEDUCTION_NONTAX($user_id, $val, $year,$type);
        } else {
            $res_insrt                          = $this->employees_model->UPDATE_USER_DEDUCTION_NONTAX($user_id, $val, $year,$type);
        }

        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
          }
    }

    function update_allowance(){
        $empl_id 					= $this->input->post('UPDATE_ID');
        $allowance_val 		    	= $this->input->post('UPDT_ALLOWANCE_VAL');
        $type 						= $this->input->post('UPDT_ALLOWANCE_TYPE');
        $year 						= $this->input->post('YEAR');

        $empl_ids = explode(",",$empl_id);

		foreach($empl_ids as $id){
			
			$result                 = $this->employees_model->IS_DUPLICATE($id, $year, $type);
			
			if($result == 0){
				$this->employees_model->ADD_USER_ALLOWANCE($id, $allowance_val, $year,$type);
			}else{
				$this->employees_model->update_user_allowance($id, $allowance_val, $year,$type);
			}
		}
	    redirect('employees/allowance_assign');

    }


    function update_allowance_tax(){
        $empl_id 					= $this->input->post('UPDATE_ID');
        $allowance_val 		    	= $this->input->post('UPDT_ALLOWANCE_VAL');
        $type 						= $this->input->post('UPDT_ALLOWANCE_TYPE');
        $year 						= $this->input->post('YEAR');

        $empl_ids                   = explode(",",$empl_id);

		foreach($empl_ids as $id){
			
			$result                 = $this->employees_model->IS_DUPLICATE_ALLOWANCE_TAX($id, $year, $type);
			
			if($result == 0){
				$this->employees_model->ADD_USER_ALLOWANCE_TAX($id, $allowance_val, $year,$type);
			}else{
				$this->employees_model->UPDATE_USER_ALLOWANCE_TAX($id, $allowance_val, $year,$type);
			}
		}
        $this->session->set_userdata('SESS_SUCCESS', 'Taxable Allowance Updated Successfully!');
        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
        }

	    // redirect('employees/taxable_allowance_assign');

    }

    function update_allowance_nontax(){
        $empl_id 					= $this->input->post('UPDATE_ID');
        $allowance_val 		    	= $this->input->post('UPDT_ALLOWANCE_VAL');
        $type 						= $this->input->post('UPDT_ALLOWANCE_TYPE');
        $year 						= $this->input->post('YEAR');

        $empl_ids                   = explode(",",$empl_id);

		foreach($empl_ids as $id){
			
			$result                 = $this->employees_model->IS_DUPLICATE_ALLOWANCE_NONTAX($id, $year, $type);
			
			if($result == 0){
				$this->employees_model->ADD_USER_ALLOWANCE_NONTAX($id, $allowance_val, $year,$type);
			}else{
				$this->employees_model->UPDATE_USER_ALLOWANCE_NONTAX($id, $allowance_val, $year,$type);
			}
		}

        $this->session->set_userdata('SESS_SUCCESS', 'Non-Taxable Allowance Updated Successfully!');
        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
          }
	    // redirect('employees/non_taxable_allowance_assign');

    }

    function update_deduction_tax(){
        $empl_id 					= $this->input->post('UPDATE_ID');
        $val 		    	        = $this->input->post('UPDT_DEDUCTION_VAL');
        $type 						= $this->input->post('UPDT_DEDUCTION_TYPE');
        $year 						= $this->input->post('YEAR');

        $empl_ids                   = explode(",",$empl_id);

		foreach($empl_ids as $id){
			
			$result                 = $this->employees_model->IS_DUPLICATE_DEDUCTION_TAX($id, $year, $type);
			
			if($result == 0){
				$this->employees_model->ADD_USER_DEDUCTION_TAX($id, $val, $year,$type);
			}else{
				$this->employees_model->UPDATE_USER_DEDUCTION_TAX($id, $val, $year,$type);
			}
		}
	    redirect('employees/taxable_deduction_assign');

    }

    function update_deduction_non_tax(){
        $empl_id 					= $this->input->post('UPDATE_ID');
        $val 		    	        = $this->input->post('UPDT_DEDUCTION_VAL');
        $type 						= $this->input->post('UPDT_DEDUCTION_TYPE');
        $year 						= $this->input->post('YEAR');

        $empl_ids                   = explode(",",$empl_id);

		foreach($empl_ids as $id){
			
			$result                 = $this->employees_model->IS_DUPLICATE_DEDUCTION_NONTAX($id, $year, $type);
			
			if($result == 0){
				$this->employees_model->ADD_USER_DEDUCTION_NONTAX($id, $val, $year,$type);
			}else{
				$this->employees_model->UPDATE_USER_DEDUCTION_NONTAX($id, $val, $year,$type);
			}
		}
	    redirect('employees/non_taxable_deduction_assign');

    }

  
    function allowance_assign_old(){
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
        $data["module_name"]      = $module       = 'employees';
        $data["page_name"]        = $page_name    = 'allowance_assign';
        $data["model_name"]       = $model        = "employee_module_model";
        $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
        $data["module"]           = [base_url().$module,"Employees", "Allowances Assignment"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "ALA";
        $data["excel_import"]     = [true];  
        $data["excel_output"]     = [true,"allowance_assign.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true,"Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
        $c_data_tab             = array(
                                    array("Active","status","Active",0),
                                    array("Inactive","status","Inactive",0)
                                );
        $data["C_BULK_BUTTON"]  = array(
                                    array(true, "btn_mark_active","far fa-check-circle","Mark as Active","status","Active"),    //visible,id,icon,Button Name,column,status
                                    array(true, "btn_mark_inactive","far fa-times-circle","Mark as Inactive","status","Inactive")    //visible,id,icon,Button Name,column,status
                                );
        $data["C_DB_DESIGN"]  =	
        array(
            array("id","ID","id","0",1,5,0,0,0,1,0,1),
            array("create_date","Create Date","datetime","0",0,0,0,0,0,1,0,1),
            array("edit_date","Edit Date","datetime","0",0,0,0,0,0,1,0,1),
            array("edit_user","Last Edited By","user","self",0,0,0,0,0,1,0,1),
            array("is_deleted","Is Deleted","hidden","0",0,0,0,0,0,0,0,0),
            array("username","Employee","user","self",1,20,1,0,0,0,0,1),
            array("name","Allowance","db-sel","array1",1,20,1,1,1,1,1,1),
            array("values","Value","number","0",1,15,1,1,1,1,1,1),
            array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
             
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

        if($row == null){ $row = $filter_row[0]; }
        if($tab == null){ $tab = $c_data_tab[0][0]; }
        if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

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

        if($this->input->get('all') == null){
            $data["C_DATA_TABLE"]               =$this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type,$dept,$sec,$group,$line,$branch,$division,$team,$status);
            $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }else{
            $data["C_DATA_TABLE"]               =$this->$model->get_specific_data($table,$search,$row,$offset,$view_type); 
            $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }
        $i=0;
        foreach($c_data_tab as $c_data_tab_row){
            $c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
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
        
        
        function deduction_assign(){
            //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
        $data["module_name"]      = $module       = 'employees';
        $data["page_name"]        = $page_name    = 'deduction_assign';
        $data["model_name"]       = $model        = "employee_module_model";
        $data["table_name"]       = $table        = "tbl_employee_deductionassign";
        $data["module"]           = [base_url().$module,"Employees", "Deduction Assignment"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "DDA";
        $data["excel_import"]     = [true]; 
        $data["excel_output"]     = [true,"deduction_assign.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true,"Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
        $c_data_tab             = array(
                                    array("Active","status","Active",0),
                                    array("Inactive","status","Inactive",0)
                                );
        $data["C_BULK_BUTTON"]  = array(
                                    array(true, "btn_mark_active","far fa-check-circle","Mark as Active","status","Active"),    //visible,id,icon,Button Name,column,status
                                    array(true, "btn_mark_inactive","far fa-times-circle","Mark as Inactive","status","Inactive")    //visible,id,icon,Button Name,column,status
                                );
        $data["C_DB_DESIGN"]  =	
        array(
            array("id","ID","id","0",1,5,0,0,0,1,0,1),
            array("create_date","Create Date","datetime","0",0,0,0,0,0,1,0,1),
            array("edit_date","Edit Date","datetime","0",0,0,0,0,0,1,0,1),
            array("edit_user","Last Edited By","user","self",0,0,0,0,0,1,0,1),
            array("is_deleted","Is Deleted","hidden","0",0,0,0,0,0,0,0,0),
            array("username","Employee","user","self",1,20,1,0,0,0,0,1),
            array("name","Allowance","db-sel","array1",1,20,1,1,1,1,1,1),
            array("values","Value","number","0",1,15,1,1,1,1,1,1),
            array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
            
            
                       
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
     
        if($row == null){ $row = $filter_row[0]; }
        if($tab == null){ $tab = $c_data_tab[0][0]; }
        if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }
     
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

        if($this->input->get('all') == null){
          $data["C_DATA_TABLE"]               =$this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type,$dept,$sec,$group,$line,$branch,$division,$team,$status);
          $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }else{
          $data["C_DATA_TABLE"]               =$this->$model->get_specific_data($table,$search,$row,$offset,$view_type); 
          $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }
        $i=0;
        foreach($c_data_tab as $c_data_tab_row){
            $c_data_tab[$i][3] = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
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



    function skill_assign(){
        //------------------------------------------------------- START OF DYNAMIC PARAMETERS
        $user = $this->session->userdata('SESS_USER_ID');
        $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
        $data["module_name"]      = $module       = 'employees';
        $data["page_name"]        = $page_name    = 'skill_assign';
        $data["model_name"]       = $model        = "employee_module_model";
        $data["table_name"]       = $table        = "tbl_employee_skillassign";
        $data["module"]           = [base_url().$module,"Employees", "Skill Assignment"];         // Main Menu Path, Module, Page Title
        $data["id_prefix"]        = "SKA";
        $data["excel_import"]     = [false]; 
        $data["excel_output"]     = [false,"skill_assign.xlsx"];                                                       // Enable, File Name
        $data["add_button"]       = [true,"Add Assignment"];                                                                 // Enable, Button Name modal_add_enable   = true;
        $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
        $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
        $c_data_tab             = array(
                                    array("Active","status","Active",0),
                                    array("Inactive","status","Inactive",0)
                                );
        $data["C_BULK_BUTTON"]  = array(
                                    array(true, "btn_mark_active","far fa-check-circle","Mark as Active","status","Active"),    //visible,id,icon,Button Name,column,status
                                    array(true, "btn_mark_inactive","far fa-times-circle","Mark as Inactive","status","Inactive")    //visible,id,icon,Button Name,column,status
                                );
        $data["C_DB_DESIGN"]  =	
        array(
            array("id","ID","id","0",1,5,0,0,0,1,0,1),
            array("create_date","Create Date","datetime","0",0,0,0,0,0,0,0,1),
            array("edit_date","Edit Date","datetime","0",0,0,0,0,0,0,0,1),
            array("edit_user","Last Edited By","user","self",0,0,0,0,0,0,0,1),
            array("is_deleted","Is Deleted","hidden","0",0,0,0,0,0,0,0,0),
            array("username","Employee","user","self",1,15,1,1,0,0,0,1),
            array("name","Skill Name","db-sel","array1",1,15,1,1,1,1,1,1),
            array("value","Skill Level","db-sel","array2",1,15,1,1,1,1,1,1),
            array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
                     
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

        if($row == null){ $row = $filter_row[0]; }
        if($tab == null){ $tab = $c_data_tab[0][0]; }
        if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

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

        if($this->input->get('all') == null){
            $data["C_DATA_TABLE"]               =$this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type,$dept,$sec,$group,$line,$branch,$division,$team,$status);
            $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }else{
            $data["C_DATA_TABLE"]               =$this->$model->get_specific_data($table,$search,$row,$offset,$view_type); 
            $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }
        $i=0;
        foreach($c_data_tab as $c_data_tab_row){
            $c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
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


    function salary_details(){
        $search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
        
        if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
        if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
        if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
        if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
        if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
        if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
        if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
        if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}
        $data["C_ROW_DISPLAY"]                   =  [25,50,100];

        $page                                       = $this->input->get('page');
        $row                                        = $this->input->get('row');
        if ($row == null) {
        $row = 25;
        }
        if($page  == null){
        $page = 1;
        }
        $offset = $row * ($page - 1);

        if($this->input->get('all') == null){
            $data['DISP_EMP_LIST']                  = $empl_list = $this->employees_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
            $data['C_DATA_COUNT']                   = $this->employees_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
        }else{
            $data['DISP_EMP_LIST']                  = $this->employees_model->GET_SEARCHED($search);
            $data['C_DATA_COUNT']                   = count($this->employees_model->GET_SEARCHED($search));
        }

        $data['DISP_YEARS']        		            = $year_list = $this->employees_model->GET_YEARS();
        // $data["DISP_DEDUCTION_TYPES"] 		    = $this->employees_model->GET_TAXABLE_DEDUCTION_TYPES();
        

        (!isset($_GET["year"])) ? $year = $year_list[0]->id : $year = $_GET["year"];
     
        $data["DISP_DEDUCTION"]		            = $this->employees_model->GET_DEDUCTION_TAX_DATA($year);

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
        $this->load->view('modules/employees/salary_detail_views', $data);
        
    }

    
            
            
// =========================================================== NEW EMPLOYEE =====================================================================

    function get_searched_employee(){
        $search                         = $this->input->post('search');
        $data                           = $this->employees_model->MOD_GET_SEARCHED_DATA($search);
        echo(json_encode($data));
    }
    
    function new_employee(){
        // $data['DISP_EMP_REPORTING_TO'] = $this->employees_model->MOD_DISP_REPORTING_TO();
        $data['DISP_EMP_GENDER']          = $this->employees_model->GET_GENDERS();
        $data['DISP_EMP_LOCATION']        = $this->employees_model->GET_BRANCHES();
        $data['DISP_EMP_DIVISION']        = $this->employees_model->GET_DIVISIONS();
        $data['DISP_EMP_DEPARTMENT']      = $this->employees_model->GET_DEPARTMENTS();
        $data['DISP_EMP_SECTION']         = $this->employees_model->GET_SECTIONS();
        $data['DISP_EMP_POSITION']        = $this->employees_model->GET_POSITION();
        $data['DISP_EMP_EMPTYPES']        = $this->employees_model->GET_POSITION();//
        $data['DISP_EMP_ONBOARDING']      = $this->employees_model->GET_POSITION();//
        $data['DISP_EMP_TEAMS']           = $this->employees_model->GET_POSITION();//
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
        $this->load->view('modules/employees/new_employee_views',$data);
        
    }
    function add_new_employee(){
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
        
        if($check_cmid > 0){
            $this->session->set_userdata('SESS_ERROR_INSRT', 'Employee number already exists!');
            redirect('employees/directories');
            return;
        }

        $get_image_name                 = $_FILES['employee_image']['name'];
        $userID                         = $this->employees_model->MOD_INSRT_EMPLOYEE($empl_cmid,$last_name,$middle_name,$first_name,$email,$birthday,$gender,$mobile_num,$hired_on,$empl_type,$position,$department,$section,$group,$line,$home_address,$current_address,$marital_status,$nationality,$shirt_size,$salary_rate,$salary_type);
        // set uploading file config
        
        
        $config['upload_path']      = './assets_user/user_profile';
        $config['allowed_types']    = 'gif|jpg|png|jpeg';
        $config['max_size']         = '5000';
        $config['file_name']        = $userID.$get_image_name;
        $config['overwrite']        = 'TRUE';
        $this->load->library('upload', $config);

        if($_FILES['employee_image']['size'] != 0){
            if ($this->upload->do_upload('employee_image'))
            {
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

                
                $this->session->set_userdata('SESS_SUCC_INSRT', 'New Employee was added successfully!');
                redirect('employees/directories');
            }
        } 
        
        // else {
        //     $this->session->set_userdata('SESS_ERR_IMAGE', 'No employee photo was selected');
        //     redirect('employees/directories');
        // }

        if($userID){
            $this->session->set_userdata('SESS_SUCC_INSRT', 'New Employee was added successfully!');
            redirect('employees/directories');
        }
    }
    function edit_image(){
        $get_image_name             = $_FILES['employee_image']['name'];
        $userID                     = $this->input->post('INSRT_EMPL_ID');
        $url_directory              = $this->input->post('URL_DIRECTORY');
        // set uploading file config
        $config['upload_path']      = './assets_user/user_profile';
        $config['allowed_types']    = 'jpg|png|jpeg';
        $config['max_size']         = '5000';
        $config['file_name']        = $userID;
        $config['overwrite']        = 'TRUE';
        $this->load->library('upload', $config);
        if($_FILES['employee_image']['size'] != 0){
            if ($this->upload->do_upload('employee_image'))
            {
                $data_upload        = array('employee_image' => $this->upload->data());
                $user_img           = $data_upload['employee_image']['file_name'];
                $this->employees_model->INSERT_EMPLOYEE_IMAGE($user_img, $userID);
                $this->session->set_userdata('SESS_SUCC_UPDT_IMG', 'Profile Updated!');
                echo "<script>window.location.href='".base_url()."employees/".$url_directory."?id=".$userID."'</script>";
            }
        } else {
            $this->session->set_userdata('SESS_ERR_IMAGE', 'No employee photo was selected');
            echo "<script>window.location.href='".base_url()."employees/".$url_directory."?id=".$userID."'</script>";
        }
    }
    function get_filter_data(){
        $department = '';
        $section    = '';
        $group      = '';
        $line       = '';
        $status     = '';
        if($this->input->post('department') != ''){
            $department = "col_empl_dept='".$this->input->post('department')."'";
        } else {
            $department = '1=1';
        }
        if($this->input->post('section') != ''){
            $section    = "col_empl_sect='".$this->input->post('section')."'";
        } else {
            $section    = '1=1';
        }
        if($this->input->post('group') != ''){
            $group      = "col_empl_group='".$this->input->post('group')."'";
        } else {
            $group      = '1=1';
        }
        if($this->input->post('line') != ''){
            $line       = "col_empl_line='".$this->input->post('line')."'";
        } else {
            $line       = '1=1';
        }
        $status         = "disabled=".$this->input->post('status');
        $data           = $this->employees_model->MOD_GET_FILTER_DATA($department,$line,$group,$section,$status);
        echo(json_encode($data));
    }
    function get_filter_data_department(){
        $department     = '';
        $section        = '';
        $group          = '';
        $line           = '';
        $status         = '';
        if($this->input->post('department') != ''){
            $department = "col_empl_dept='".$this->input->post('department')."'";
        } else {
            $department = '1=1';
        }
        if($this->input->post('section') != ''){
            $section    = "col_empl_sect='".$this->input->post('section')."'";
        } else {
            $section    = '1=1';
        }
        if($this->input->post('group') != ''){
            $group      = "col_empl_group='".$this->input->post('group')."'";
        } else {
            $group      = '1=1';
        }
        if($this->input->post('line') != ''){
            $line       = "col_empl_line='".$this->input->post('line')."'";
        } else {
            $line       = '1=1';
        }
        $status         = "disabled=".$this->input->post('status');
        $data           = $this->employees_model->MOD_GET_FILTER_DATA_DEPARTMENT($department,$line,$group,$section,$status);
        echo(json_encode($data));
    }
    function get_filter_data_section(){
        $department     = '';
        $section        = '';
        $group          = '';
        $line           = '';
        $status         = '';
        if($this->input->post('department') != ''){
            $department = "col_empl_dept='".$this->input->post('department')."'";
        } else {
            $department = '1=1';
        }
        if($this->input->post('section') != ''){
            $section    = "col_empl_sect='".$this->input->post('section')."'";
        } else {
            $section    = '1=1';
        }
        if($this->input->post('group') != ''){
            $group      = "col_empl_group='".$this->input->post('group')."'";
        } else {
            $group      = '1=1';
        }
        if($this->input->post('line') != ''){
            $line       = "col_empl_line='".$this->input->post('line')."'";
        } else {
            $line       = '1=1';
        }
        $status         = "disabled=".$this->input->post('status');
        $data           = $this->employees_model->MOD_GET_FILTER_DATA_SECTION($department,$line,$group,$section,$status);
        echo(json_encode($data));
    }
    function get_filter_data_group(){
        $department     = '';
        $section        = '';
        $group          = '';
        $line           = '';
        $status         = '';
        if($this->input->post('department') != ''){
            $department = "col_empl_dept='".$this->input->post('department')."'";
        } else {
            $department = '1=1';
        }
        if($this->input->post('section') != ''){
            $section    = "col_empl_sect='".$this->input->post('section')."'";
        } else {
            $section    = '1=1';
        }
        if($this->input->post('group') != ''){
            $group      = "col_empl_group='".$this->input->post('group')."'";
        } else {
            $group      = '1=1';
        }
        if($this->input->post('line') != ''){
            $line       = "col_empl_line='".$this->input->post('line')."'";
        } else {
            $line       = '1=1';
        }
        $status         = "disabled=".$this->input->post('status');
        $data           = $this->employees_model->MOD_GET_FILTER_DATA_GROUP($department,$line,$group,$section,$status);
        echo(json_encode($data));
    }
    function get_filter_data_line(){
        $department     = '';
        $section        = '';
        $group          = '';
        $line           = '';
        $status         = '';
        if($this->input->post('department') != ''){
            $department = "col_empl_dept='".$this->input->post('department')."'";
        } else {
            $department = '1=1';
        }
        if($this->input->post('section') != ''){
            $section    = "col_empl_sect='".$this->input->post('section')."'";
        } else {
            $section    = '1=1';
        }
        if($this->input->post('group') != ''){
            $group      = "col_empl_group='".$this->input->post('group')."'";
        } else {
            $group      = '1=1';
        }
        if($this->input->post('line') != ''){
            $line       = "col_empl_line='".$this->input->post('line')."'";
        } else {
            $line       = '1=1';
        }
        $status         = "disabled=".$this->input->post('status');
        $data           = $this->employees_model->MOD_GET_FILTER_DATA_LINE($department,$line,$group,$section,$status);
        echo(json_encode($data));
    }
    function get_all_filter_data(){
        $data['DISP_DISTINCT_DEPARTMENT']       = $this->p164_department_mod->MOD_DISP_DISTINCT_DEPARTMENT();
        $data['DISP_DISTINCT_SECTION']          = $this->p165_section_mod->MOD_DISP_DISTINCT_SECTION();
        $data['DISP_Group']                     = $this->p162_group_mod->MOD_DISP_DISTICT_Group();
        $data['DISP_Line']                      = $this->p160_line_views->MOD_DISP_DISTINCT_line();
        echo(json_encode($data));
    }
   
    // ========================================== PERSONAL TAB =============================================
    function personal(){
        $employee_id                        = $this->input->get('id');

        $data["C_COM_STRUCTURE"]            = $this->employees_model->GET_COMP_STRUCTURE();

        $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
        $data['C_POSITIONS']                = $this->employees_model->GET_POSITION();
        $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
        $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
        $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
        $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
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
        $data['C_SKILLS_NAME']              = $this->employees_model->GET_SKILL_NAME();
        $data['C_SKILLS_LEVEL']             = $this->employees_model->GET_SKILL_LEVEL();
        
        $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);
        $data['C_DEPENDENTS']               = $this->employees_model->GET_DEPENDENTS_SPECIFIC($employee_id);
        $data['C_EMERGENCY']                = $this->employees_model->GET_EMERGENCY_SPECIFIC($employee_id);
        $data['C_DOCUMENTS']                = $this->employees_model->GET_DOCUMENTS_SPECIFIC($employee_id);

        // echo "<pre>";
        //     var_dump($data['C_EMP_INFO']);
        // echo "</pre>";
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/employees/employee_personal_views',$data);
        
    }

    // ========================================== UPDATE PERSONAL DETAIL =============================================

    function edit_personal_detail($employee_id){

        $data['C_SHIRT_SIZE']               = $this->employees_model->GET_SHIRT_SIZE();
        $data['C_GENDERS']                  = $this->employees_model->GET_GENDERS();
        $data['C_MARITAL']                  = $this->employees_model->GET_MARITAL();
        $data['C_NATIONALITY']              = $this->employees_model->GET_NATIONALITY();
        $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);

        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_personal_detail_views', $data);
        
    }
    

    function update_personal_detail(){
        
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

        $this->employees_model->UPDATE_PERSONAL_DET($first_name,$middlename,$lastname,$marital_status,$mobile_number,$birthdate,$gender,$nationality,$shirt_size,$email,$home_address,$current_address,$user_id);
    
        $this->session->set_userdata('SESS_SUCC_MSG', 'Personal details updated successfully!');
       redirect('employees/edit_personal_detail/'.$user_id);
    }

    // ========================================== UPDATE EMPLOYMENT DETAL =============================================

    function edit_employment_detail($employee_id){
        $data['C_TYPE']                     = $this->employees_model->GET_TYPE();
        $data['C_POSITIONS']                = $this->employees_model->GET_POSITION();
        $data['C_BRANCH']                   = $this->employees_model->GET_BRANCHES();
        $data['C_DEPARTMENTS']              = $this->employees_model->GET_DEPARTMENTS();
        $data['C_DIVISIONS']                = $this->employees_model->GET_DIVISIONS();
        $data['C_SECTIONS']                 = $this->employees_model->GET_SECTIONS();
        $data['C_GROUPS']                   = $this->employees_model->GET_GROUPS();
        $data['C_LINES']                    = $this->employees_model->GET_LINES();
        $data['C_TEAMS']                    = $this->employees_model->GET_TEAMS();
        $data['C_HMO']                      = $this->employees_model->GET_HMO();
        $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);
        
        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_employment_detail_views', $data);
        
    }

    function update_employment_detail(){
        
        $user_id                            = $this->input->post('user_id');
        $hired_date                         = $this->input->post('UPDATE_HIRED_DATE');
        $reg_date                           = $this->input->post('UPDATE_REGULAR_DATE');
        $resign_Date                        = $this->input->post('UPDATE_RESIGN_DATE');
        $end_date                           = $this->input->post('UPDATE_END');
        $emp_type                           = $this->input->post('UPDATE_EMP_TYPE');
        $position                           = $this->input->post('UPDATE_POSITION');
        $branch                             = $this->input->post('UPDATE_BRANCH');
        $dept                               = $this->input->post('UPDATE_DEPARTMENT');
        $division                           = $this->input->post('UPDATE_DIVISION');
        $sec                                = $this->input->post('UPDATE_SECTION');
        $group                              = $this->input->post('UPDATE_GROUPS');
        $line                               = $this->input->post('UPDATE_LINE');
        $team                               = $this->input->post('UPDATE_TEAM');
        $com_num                            = $this->input->post('UPDATE_COMP_NUM');
        $com_email                          = $this->input->post('UPDATE_COMP_EMAIL');
        $hmo_prov                           = $this->input->post('UPDATE_HMO_PROV');
        $hmo_num                            = $this->input->post('UPDATE_HMO_NUM');

        $this->employees_model->UPDATE_EMPLOYMENT_DET($hired_date,$reg_date,$resign_Date,$end_date,$emp_type,$position,$branch,$dept,$division,$sec,$group,$line,$team,$com_num,$com_email,$hmo_prov,$hmo_num,$user_id);
        
        $this->session->set_userdata('SESS_SUCC_MSG', 'Employment details updated successfully!');
        redirect('employees/personal?id='.$user_id);
    }


    // ========================================== UPDATE ID DETAL =============================================

    function edit_id_detail($employee_id){
        
        $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);
        
        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_id_detail_views', $data);
        
    }

    function update_id_detail(){
        $user_id                            = $this->input->post('user_id');
        $sss                                = $this->input->post('UPDATE_SSS');
        $hdmf                               = $this->input->post('UPDATE_HDMF');
        $philhealth                         = $this->input->post('UPDATE_PHILHEALTH');
        $tin                                = $this->input->post('UPDATE_TIN');
        $driver_lic                         = $this->input->post('UPDATE_DRIVER_LIC');
        $nat_id                             = $this->input->post('UPDATE_NAT_ID');
        $passport                           = $this->input->post('UPDATE_PASSPORT');

        $this->employees_model->UPDATE_ID_DET($sss,$hdmf,$philhealth,$tin,$driver_lic,$nat_id,$passport,$user_id);
    
        $this->session->set_userdata('SESS_SUCC_MSG', 'ID details updated successfully!');
        redirect('employees/edit_id_detail/'.$user_id);
    }

    function user_activation($user_id,$is_disabled){
        $this->employees_model->SET_ACTIVATION_EMPLOYEE($user_id,$is_disabled);
        redirect("employees/personal?id=$user_id");
    }
    // ========================================== UPDATE COMPENSATION DETAL =============================================

    function edit_compensation_detail($employee_id){
    
        $data['C_EMP_INFO']                 = $this->employees_model->GET_EMPLOYEE_SPECIFIC($employee_id);
        
        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_compen_detail_views', $data);
        
    }

    function update_comp_detail(){
        $user_id                            = $this->input->post('user_id');
        $salary_type                        = $this->input->post('UPDATE_SAL_TYPE');
        $salary_rate                        = $this->input->post('UPDATE_SAL_RATE');
        $bank                               = $this->input->post('UPDATE_BANK');
        $branch                             = $this->input->post('UPDATE_BRANCH');
        $acc_type                           = $this->input->post('UPDATE_ACC_TYPE');
        $payment_type                       = $this->input->post('UPDATE_PAY_TYPE');
        $acc_num                            = $this->input->post('UPDATE_ACC_NUMBER');

        $this->employees_model->UPDATE_COMP_DET($salary_type,$salary_rate,$bank,$branch,$acc_type,$payment_type,$acc_num,$user_id);
    
        redirect('employees/edit_compensation_detail/'.$user_id);
    }

    // ========================================== UPDATE EDUCATION DETAL =============================================
    function add_education($user_id){
        $data['C_EMP_ID']                   = $user_id;
        $data['C_EDUCATION']                = array();
        $data["C_CURRENT_PAGE"]             = "Add Education";
        $data['C_FUNCTION']                 ='save_new_education';

        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_educ_detail_views', $data);
        
    }
    function save_new_education(){
        
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

        $res                                =$this->employees_model->ADD_NEW_EDUC($degree,$school,$address,$from_yr,$to_yr,$completion,$user_id,$grade,$level);
        $isAdmin                            = $this->session->userdata('SESS_ADMIN');
        $log_mgs                            = $isAdmin==1 ?'Added education(Admin)':'Added education';

        if($res){

            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
            $this->session->set_flashdata('SESS_SUCC_ADD', "Education details successfully added!");

        }else{

            $log_mgs= $isAdmin==1 ?'Fail to add education(Admin)':'Fail to add education';
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
            $this->session->set_flashdata('SESS_ERR_ADD', 'Fail to Add!');

        }

        redirect('employees/personal?id='.$user_id);
    }

    function edit_educ_detail($id,$user_id){
        $data['C_EMP_ID']                   = $user_id;
        $data['C_EDUCATION']                = $this->employees_model->GET_EDUCATION_SPECIFIC2($id);
        $data["C_CURRENT_PAGE"]             = "Edit Education Details";
        $data['C_FUNCTION']='update_educ_detail';
        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_educ_detail_views', $data);
        
    }

        function update_educ_detail(){
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
            
            $res=$this->employees_model->UPDATE_EDUC_DET($degree,$school,$address,$from_yr,$to_yr,$completion,$educ_id,$user_id,$grade,$level);

            $isAdmin = $this->session->userdata('SESS_ADMIN');
            $log_mgs= $isAdmin==1 ?'Updated education(Admin)':'Updated education';
            if($res){
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                $this->session->set_flashdata('SESS_SUCC_UPDT', "Education details successfully updated!");
            }else{
                $log_mgs= $isAdmin==1 ?'Fail to  update education(Admin)':'Fail to  update education';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SESS_ERR_UPDT', 'Fail to Update!');
            }
            redirect('employees/personal?id='.$user_id);
        }
    function delete_empl_education($id){
        $res=$this->employees_model->DELETE_EDUCATION($id);
        echo $res;
    }


     // ========================================== UPDATE SKILL DETAL =============================================
    function add_skills($user_id){
        $data['C_SKILLS_NAME']              = $this->employees_model->GET_SKILL_NAME();
        $data['C_SKILLS_LEVEL']             = $this->employees_model->GET_SKILL_LEVEL();
        $data['C_FUNCTION']                 = "save_new_skill";
        $data['C_SKILLS_MATRIX']            = array();
        $data['C_EMP_ID']                   = $user_id;
        $data['C_current_page']             = 'Add New Skill';
        $data['C_FUNCTION']                 = "save_new_skill/".$user_id;
        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_skill_detail_views', $data);
        
    }
        function save_new_skill($user_id){
            $skill                          = $this->input->post('TITLE');
            $level                          = $this->input->post('LEVEL');
            $res                            = $this->employees_model->ADD_NEW_SKILL($user_id,$level,$skill);
            $isAdmin                        = $this->session->userdata('SESS_ADMIN');
            $log_mgs                        = $isAdmin==1 ?'Added new skill(Admin)':'Added new skill';
            if($res){
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                $this->session->set_flashdata('SESS_SUCC_ADD', "New Skill successfully added");
            }else{
                $log_mgs                    = $isAdmin==1 ?'Fail to add new skill(Admin)':'Fail to add new skill Skill';
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
                $this->session->set_flashdata('SESS_ERR_ADD', 'Fail to Delete!');
            }
            redirect('employees/personal?id='.$user_id);
        }
    function edit_skill_detail($id,$user_id){
        $data['C_EMP_ID']                   = $user_id;
        $data['C_SKILLS_MATRIX']            = $this->employees_model->GET_SKILL_MATRIX_SPECIFIC2($id);
        $data['C_SKILLS_NAME']              = $this->employees_model->GET_SKILL_NAME();
        $data['C_SKILLS_LEVEL']             = $this->employees_model->GET_SKILL_LEVEL();
        $data['C_current_page']             = 'Update Skill';
        $data['C_FUNCTION']                 = "update_skill_detail/".$user_id;
        
        $this->load->view('templates/header');
        $this->load->view('modules/employees/edit_skill_detail_views', $data);
        
    }
    function delete_empl_skill($id){
        $res=$this->employees_model->DELETE_EMPL_SKILL($id);
        $isAdmin                            = $this->session->userdata('SESS_ADMIN');
        $log_mgs                            = $isAdmin==1 ?'Deleted Skill(Admin)':'Deleted Skill';
        if($res){
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
        }else{
            $log_mgs                        = $isAdmin==1 ?'Fail to Deleted Skill(Admin)':'Fail to Deleted Skill';
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
        }
        echo $res;
    }
    function update_skill_detail($user_id){
        
        $skill_id                           = $this->input->post('skill_id');
        $title                              = $this->input->post('TITLE');
        $level                              = $this->input->post('LEVEL');

        $res=$this->employees_model->UPDATE_SKILL_DET($title,$level,$skill_id);
        $isAdmin                            = $this->session->userdata('SESS_ADMIN');
        $log_mgs                            = $isAdmin==1 ?'Updated Skill(Admin)':'Updated Skill';
        if($res){
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
            $this->session->set_flashdata('SESS_SUCC_UPDT', "Skill updated successfully");
        }else{
            $log_mgs                        = $isAdmin==1 ?'Fail to Update Skill(Admin)':'Fail to Updated Skill';
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
            $this->session->set_flashdata('SESS_ERR_UPDT', 'Fail to Update!');
        }

        redirect('employees/personal?id='.$user_id);

    }
   
    function add_documents($id){
        $data["C_USER_ID"]                              = $id;
        $this->load->view('templates/header');
        $this->load->view('modules/employees/add_document_views',$data);
        
    }
        function save_document(){
            
            $id=$this->input->post("user_id");
            $file_data                                  = $_FILES["document"];
            $file_name                                  = $id.'_'.$file_data["name"];
            $config['upload_path']                      = './assets_user/documents';
            $config['allowed_types']                    = '*';
            $config['file_name']                        =  $id.'_'.$file_data["name"];
          
            $this->load->library('upload', $config);
            if($file_data['size'] != 0)
            {
                if ($this->upload->do_upload('document'))
                {
                    $arr_filename                       =  explode(".",$file_data["name"]);
                    $upload_data                        = $this->upload->data();
                
                    $res                                = $this->employees_model->ADD_EMPL_DOCUMENT($upload_data['file_name'] ,$upload_data['raw_name'] ,$id);
                    $isAdmin                            = $this->session->userdata('SESS_ADMIN');
                    $log_mgs                            = $isAdmin==1 ?'Added new document(Admin)':'Added new document';
                    if($res){
                        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                        $this->session->set_flashdata('SESS_SUCC_ADD', "Added Successfully");
                    }else{
                        $log_mgs                        = $isAdmin==1 ?'Fail to add new document(Admin)':'Fail to add new document';
                        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                        $this->session->set_flashdata('SESS_ERR_ADD', 'Fail to Add!');
                    }
                }

                $this->session->set_flashdata('SESS_SUCC_DOC', 'Added successfully new document');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Added successfully new document");
            } else {
                $this->session->set_flashdata('SESS_ERR_DOC', 'No logo was selected');
                // redirect('employees/add_documents/'.$id);
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Fail to add new document");
            }
            redirect('employees/personal?id='.$id);
        }
        function delete_documents($id){
            $res                                        = $this->employees_model->DELETE_EMPL_DOCUMENT($id);
            if($res){
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Successfully deleted document");
            }
            else{
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Fail to delete document");
            }
            echo $res;
        }
        function download_document(){
            $isAdmin                                    = $this->session->userdata('SESS_ADMIN');
            $log_mgs                                    = $isAdmin==1 ?'Downloaded document(Admin)':'Downloaded document';
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), $log_mgs);
        }
        

    function ADD_EMERGENCY_CONTACT($id){
        $data["C_USER_ID"]      = $id;
        $data["current_page"]   ="Add Emergency Contact";
        $data["C_function"]     ="save_emergency_contact";
        $data["C_emergency_contact"]=array();
        $this->load->view('templates/header');
        $this->load->view('modules/employees/emergency_contact_views',$data);
        
    }
    function save_emergency_contact(){
        $empl_id                    = $this->input->post("user_id");
        $relation                   = $this->input->post("relation");
        $contact_name               = $this->input->post("fullname");
        $mobile_num                 = $this->input->post("mobile_number");
        $work_phone_number          = $this->input->post("work_phone");
        $home_phone_number          = $this->input->post("home_phone");
        $current_address            = $this->input->post("current_add");
        $res                        = $this->employees_model->ADD_EMERGENCY_CONTACT($empl_id,$relation,$contact_name,$mobile_num,$work_phone_number,$home_phone_number,$current_address);
        $isAdmin                    = $this->session->userdata('SESS_ADMIN');
        $log_mgs                    = $isAdmin==1 ?'Added new emergency contact(Admin)':'Added new emergency contact';
        if($res){
            $this->session->set_flashdata('SESS_SUCC_ADD', 'Emergency details added successfully!');
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
        }
        else{
            $log_mgs                = $isAdmin==1 ?'Fail to add new emergency contact(Admin)':'Fail to add new emergency contact';
            $this->session->set_flashdata('SESS_ERR_ADD', 'Fail to add!');
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Fail to Add new emergency contact");
        }

        redirect('employees/personal?id='.$empl_id);
    }
    function edit_emergency_contact($id,$user_id){
        $data["C_USER_ID"]=$user_id;
        $data["C_ID"]=$id;
        $data["current_page"]="Edit Emergency Contact";
        $data["C_function"]="update_emergency_contact/".$id;
        $data["C_emergency_contact"]=$this->employees_model->GET_EMERGENCY_SPECIFIC_BY_ID($id);
        // echo "<pre>";
        // var_dump($data["C_emergency_contact"]);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/employees/emergency_contact_views',$data);
        
    }
        function update_emergency_contact($id){
            $empl_id                = $this->input->post("user_id");
            $relation               = $this->input->post("relation");
            $contact_name           = $this->input->post("fullname");
            $mobile_num             = $this->input->post("mobile_number");
            $work_phone_number      = $this->input->post("work_phone");
            $home_phone_number      = $this->input->post("home_phone");
            $current_address        = $this->input->post("current_add");
            $res                    = $this->employees_model->UPDATE_EMERGENCY_CONTACT($id,$empl_id,$relation,$contact_name,$mobile_num,$work_phone_number,$home_phone_number,$current_address);
            $isAdmin                = $this->session->userdata('SESS_ADMIN');
            $log_mgs                = $isAdmin==1 ?'Updated emergency contact(Admin)':'Updated emergency contact';
            if($res){
                $this->session->set_flashdata('SESS_SUCC_UPDT', 'Emergency details updated successfully!');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
            }
            else{
                $log_mgs            = $isAdmin==1 ?'Fail to update emergency contact(Admin)':'Fail to update emergency contact';
                $this->session->set_flashdata('SESS_ERR_UPDT', 'Fail to update!');
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),"Fail to update emergency contact");
            }

            redirect('employees/personal?id='.$empl_id);
        }
    function delete_emergency_contact($id,$user_id){
        $res                        = $this->employees_model->DELETE_EMERGENCY_CONTACT($id);
        $isAdmin                    = $this->session->userdata('SESS_ADMIN');
        $log_mgs                    = $isAdmin==1 ?'Deleted emergency contact(Admin)':'Deleted emergency contact';
        if($res){
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
            echo 1;
        }
        else{
            $log_mgs                = $isAdmin==1 ?'Fail to delete emergency contact(Admin)':'Fail to delete emergency contact';
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
            echo 0;
        }
    }
        
    // Dependents
        function add_dependents($user_id){
            $data["C_EMP_ID"]=$user_id;
            $data["C_FUNCTION"]="save_new_dependent/".$user_id;
            $data["C_DEPENT_DATA"]=array();
            $this->load->view('templates/header');
            $this->load->view('modules/employees/dependents_views',$data);
            
        }    
            function save_new_dependent($user_id){

                $full_name          = $this->input->post("full_name");
                $b_day              = $this->input->post("b_day");
                $gender             = $this->input->post("gender");
                $relationship       = $this->input->post("relationship");
                $res                = $this->employees_model->ADD_NEW_DEPENDENT($user_id,$full_name,$b_day,$gender,$relationship);
                $isAdmin            = $this->session->userdata('SESS_ADMIN');
                $log_mgs            = $isAdmin==1 ?'Added new dependent(Admin)':'Added new dependent';
                if($res){
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                    $this->session->set_flashdata('SESS_SUCC_ADD', "New dependent added successfully");
                }else{
                    $log_mgs        = $isAdmin==1 ?'Fail to add new dependent(Admin)':'Fail to add new dependent';
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                    $this->session->set_flashdata('SESS_ERR_ADD', 'Fail to Add!');
                }

                redirect('employees/personal?id='.$user_id);

            }
        function edit_dependent($id,$user_id){
            $data["C_EMP_ID"]=$user_id;
            $data["C_FUNCTION"]="update_dependent/".$id.'/'.$user_id;
            $data["C_DEPENT_DATA"]=$this->employees_model->GET_SPECIFIC_DEPENDENT($id);
           
            $this->load->view('templates/header');
            $this->load->view('modules/employees/dependents_views',$data);
            
        }
            function update_dependent($id,$user_id){
                $full_name          = $this->input->post("full_name");
                $b_day              = $this->input->post("b_day");
                $gender             = $this->input->post("gender");
                $relationship       = $this->input->post("relationship");
                $res                = $this->employees_model->UPDATE_SPECIFIC_DEPENDENT($id,$full_name,$b_day,$gender,$relationship);
                $isAdmin            = $this->session->userdata('SESS_ADMIN');
                $log_mgs            = $isAdmin==1 ?'Updated dependent(Admin)':'Updated dependent';
                if($res){
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                    $this->session->set_flashdata('SESS_SUCC_UPDT', "Dependent updated successfully");
                }else{
                    $log_mgs        = $isAdmin==1 ?'Fail to updated dependent(Admin)':'Fail to update dependent';
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
                    $this->session->set_flashdata('SESS_ERR_UPDT', 'Fail to Update!');
                }

                redirect('employees/personal?id='.$user_id);
            }
        function DELETE_DEPENDENT($id){
            $res                    = $this->employees_model->DELETE_DEPENDENT($id);
            $isAdmin                = $this->session->userdata('SESS_ADMIN');
            $log_mgs                = $isAdmin==1 ?'Deleted dependent(Admin)':'Deleted dependent';
            if($res){
                $this->logger->log_activity($this->session->userdata('SESS_USER_ID'),$log_mgs);
            }else{
                $log_mgs            = $isAdmin==1 ?'Fail to delete dependent(Admin)':'Fail to update dependent';
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
        $data['C_HMOS']                     = $this->employees_model->GET_HMO();
        $data['C_USER_ACCESS']              = $this->employees_model->GET_USER_ACCESS();

		$data['DISP_ALL_EMPLOYEES'] = $this->employees_model->MOD_DISP_ALL_EMPLOYEES();
		$this->load->view('templates/header');
		$this->load->view('modules/employees/csv_upload_views',$data);
		
    }

    function new_employee_upload(){

        $data['C_BRANCH']                               = $this->employees_model->GET_BRANCHES();

        $data['C_POSITIONS']                           = $this->employees_model->GET_POSITION();
        $data['C_USER_ACCESS']                         = $this->employees_model->GET_USER_ACCESS();
        $data['C_SECTIONS']                            = $this->employees_model->GET_SECTIONS();
        $data['C_DEPARTMENTS']                         = $this->employees_model->GET_DEPARTMENTS();
        $data['C_TYPE']                                = $this->employees_model->GET_TYPE();
        $data['C_SHIRT_SIZE']                          = $this->employees_model->GET_SHIRT_SIZE();
        $data['C_GENDERS']                             = $this->employees_model->GET_GENDERS();
        $data['C_MARITAL']                             = $this->employees_model->GET_MARITAL();
        $data['C_NATIONALITY']                         = $this->employees_model->GET_NATIONALITY();
        $data['C_GROUPS']                              = $this->employees_model->GET_GROUPS();
        $data['C_LINES']                               = $this->employees_model->GET_LINES();
        $data['C_DIVISIONS']                           = $this->employees_model->GET_DIVISIONS();
        $data['C_HMO']                                 = $this->employees_model->GET_HMO();


        $this->load->view('templates/header');
		$this->load->view('modules/employees/new_employee_upload_views',$data);

    }

    function employee_update(){

        $data['C_BRANCH']                               = $this->employees_model->GET_BRANCHES();

        $data['C_POSITIONS']                           = $this->employees_model->GET_POSITION();
        $data['C_USER_ACCESS']                         = $this->employees_model->GET_USER_ACCESS();
        $data['C_SECTIONS']                            = $this->employees_model->GET_SECTIONS();
        $data['C_DEPARTMENTS']                         = $this->employees_model->GET_DEPARTMENTS();
        $data['C_TYPE']                                = $this->employees_model->GET_TYPE();
        $data['C_SHIRT_SIZE']                          = $this->employees_model->GET_SHIRT_SIZE();
        $data['C_GENDERS']                             = $this->employees_model->GET_GENDERS();
        $data['C_MARITAL']                             = $this->employees_model->GET_MARITAL();
        $data['C_NATIONALITY']                         = $this->employees_model->GET_NATIONALITY();
        $data['C_GROUPS']                              = $this->employees_model->GET_GROUPS();
        $data['C_LINES']                               = $this->employees_model->GET_LINES();
        $data['C_DIVISIONS']                           = $this->employees_model->GET_DIVISIONS();
        $data['C_HMO']                                 = $this->employees_model->GET_HMO();

        $this->load->view('templates/header');
		$this->load->view('modules/employees/employee_bulk_update_views',$data);

    }
    function get_tableplus_data(){
        
        $result = array();
        $index = 0;
        $data                           = $this->employees_model->GET_TABLEPLUS();

        $position                           = $this->employees_model->GET_POSITION();
        $section                            = $this->employees_model->GET_SECTIONS();
        $department                         = $this->employees_model->GET_DEPARTMENTS();
        $type                               = $this->employees_model->GET_TYPE();
        $shirt_size                         = $this->employees_model->GET_SHIRT_SIZE();
        $gender                             = $this->employees_model->GET_GENDERS();
        $marital                            = $this->employees_model->GET_MARITAL();
        $nationality                        = $this->employees_model->GET_NATIONALITY();
        $groups                             = $this->employees_model->GET_GROUPS();
        $lines                              = $this->employees_model->GET_LINES();
        $division                           = $this->employees_model->GET_DIVISIONS();
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
                'col_birt_date' => $row->col_birt_date,
                'col_empl_gend' => $this->convert_id2name($gender, $row->col_empl_gend),
                'col_empl_nati' => $this->convert_id2name($nationality, $row->col_empl_nati),
                'col_shir_size' => $this->convert_id2name($shirt_size,$row->col_shir_size),
                'col_empl_emai' => $row->col_empl_emai,
                'col_mobl_numb' => $row->col_mobl_numb,
                'col_hire_date' => $row->col_hire_date,
                'col_empl_type' => $this->convert_id2name($type ,$row->col_empl_type),
                'col_empl_posi' => $this->convert_id2name($position ,$row->col_empl_posi),
                'col_empl_divi' => $this->convert_id2name($division ,$row->col_empl_divi),
                'col_empl_group' => $this->convert_id2name($groups ,$row->col_empl_group),
                'col_empl_line' => $this->convert_id2name($lines ,$row->col_empl_line),
                'col_empl_dept' => $this->convert_id2name($department ,$row->col_empl_dept),
                'col_empl_sect' => $this->convert_id2name($section ,$row->col_empl_sect),
                'col_imag_path' => $row->col_imag_path,
                'col_empl_sssc' => $row->col_empl_sssc,
                'col_empl_hdmf' => $row->col_empl_hdmf,
                'col_empl_phil' => $row->col_empl_phil,
                'col_empl_btin' => $row->col_empl_btin,
                'col_empl_driv' => $row->col_empl_driv,
                'col_empl_naid' => $row->col_empl_naid,
                'col_empl_pass' => $row->col_empl_pass,
                'col_empl_hmoo' => $this->convert_id2name($hmo ,$row->col_empl_hmoo),
                'col_empl_hmon' => $row->col_empl_hmon,
                'salary_rate' => $row->salary_rate,
                'salary_type' => $row->salary_type,
            ];
        }

        echo(json_encode($result));
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



    function insert_data(){
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            foreach($data as $data_row){
                $is_duplicate = $this->employees_model->is_duplicate_data($data_row);
                if($is_duplicate > 0){
                    // $this->employees_model->update_data($data_row);
                    $response = array('warning_message' => 'Please avoid providing duplicate information.');
                }else{
        
                    $this->employees_model->insert_data($data_row);
                    $response = array('success_message' => 'Data inserted successfully');
                }
            }
            // $response = array('success_message' => 'Data inserted successfully');

        } catch (Exception $e) {
            $response = array('message' => 'Error updating data: '.$e->getMessage());
        }
        echo json_encode($response);
    }


    function update_data() {

        $data = json_decode(file_get_contents('php://input'), true);
  

        try {
            foreach($data as $data_row){
                $this->employees_model->update_data($data_row);
            }
            $response = array('success_message' => 'Data updated successfully');
        } catch (Exception $e) {
            $response = array('warning_message' => 'Error updating data: '.$e->getMessage());
        }
        
        // echo json_encode($response);
        echo json_encode($response);
    }




    function upload_employee_photo(){
		$this->load->view('templates/header');
		$this->load->view('modules/employees/bulk_image_upload_views');
		
	}

    function upload_csv_update_employees()
	{
		$curdate                    = date('Y-m-d h:i:s');
		$rundate                    = substr($curdate,5,2).substr($curdate,8,2).substr($curdate,2,2)."_".substr($curdate,11,2).substr($curdate,14,2).substr($curdate,17,2);
		$file_name                  = 'Employee_'.$rundate;
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
        $data['C_HMOS']                     = $this->employees_model->GET_HMO();
        $data['C_USER_ACCESS']              = $this->employees_model->GET_USER_ACCESS();


		if($this->upload->do_upload('file')) 
		{
			$name           = $_FILES["file"]["name"];
			$ext1           = explode(".", $name);
			$ext            = end($ext1);
			$file           = fopen(($path.$file_name.'.'.$ext),"r");
			$ctr            = 0;
			$x[$ctr]        = (fgetcsv($file));
	
            if(!isset($x[0][0]) || !isset($x[0][1]) || !isset($x[0][2]) || !isset($x[0][3]) || !isset($x[0][4]) || !isset($x[0][5]) || !isset($x[0][6]) || !isset($x[0][7]) || !isset($x[0][8]) || !isset($x[0][9]) || !isset($x[0][10]) || !isset($x[0][11]) || !isset($x[0][12]) || !isset($x[0][13]) || !isset($x[0][14]) || !isset($x[0][15]) || !isset($x[0][16]) || !isset($x[0][17]) || !isset($x[0][18]) || !isset($x[0][19]) || !isset($x[0][20]) || !isset($x[0][21]) || !isset($x[0][22]) || !isset($x[0][23]) || !isset($x[0][24]) || !isset($x[0][25]) || !isset($x[0][26]) || !isset($x[0][27]) || !isset($x[0][28]) || !isset($x[0][29]) || !isset($x[0][30]) || !isset($x[0][31]) || !isset($x[0][32]) || !isset($x[0][33]))
			{
				$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing column.');
				redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
				return;
			}
			else if (($x[0][0] != "Employee ID") || ($x[0][1] != "User Access") || ($x[0][2] != "Last Name") || ($x[0][3] != "Middle Name") || ($x[0][4] != "First Name") || ($x[0][5] != "Marital Status") || ($x[0][6] != "Home Address") || ($x[0][7] != "Current Address") || ($x[0][8] != "Birthday") || ($x[0][9] != "Gender") || ($x[0][10] != "Nationality") || ($x[0][11] != "Shirt Size") || ($x[0][12] != "Email Address") || ($x[0][13] != "Mobile Number") || ($x[0][14] != "Hired On") || ($x[0][15] != "Employment Type") || ($x[0][16] != "Position") || ($x[0][17] != "Division") || ($x[0][18] != "Group")  || ($x[0][19] != "Line") || ($x[0][20] != "Department") || ($x[0][21] != "Section") || ($x[0][22] != "Image File") || ($x[0][23] != "SSS Number") || ($x[0][24] != "Pagibig") || ($x[0][25] != "Philhealth") || ($x[0][26] != "TIN") || ($x[0][27] != "Drivers License") || ($x[0][28] != "National ID") || ($x[0][29] != "Passport") || ($x[0][30] != "HMO") || ($x[0][31] != "HMO Number") || ($x[0][32] != "Salary Rate") || ($x[0][33] != "Salary Type"))
			{
				$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing or incorrect column labels.');
				redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
				return;
			}
			else
			{
                $succ_inserted      = [];
				$data_arr           = [];
				while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
					// $this->employees_model->UPDTRECORD($filedata);
                    // $this->db->update_batch('tbl_employee_infos', $filedata);
                    if(count($filedata) > 0)
                    {
                        $newdate                            = str_replace('/', '-', $filedata[8]);
                        $birthday                           = date("Y-m-d", strtotime($newdate));
                        $newdate_2                          = str_replace('/', '-', $filedata[14]);
                        $hired_on                           = date("Y-m-d", strtotime($newdate_2));

                        $user_acess                         = convert_user_access_id($data['C_USER_ACCESS'], $filedata[1]);
                        if($user_acess <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ''.$filedata[2].' '.$filedata[4].' User access is invalid.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }
                        
                        $mari_stat_id                       = convert_name2id($data['C_MARITAL'],$filedata[5]);
                        if($mari_stat_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ''.$filedata[2].' '.$filedata[4].' Marital status is invalid.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }

                        $nationality_id                     = convert_name2id($data['C_NATIONALITY'], $filedata[10]);
                        $gender_id                          = convert_name2id($data['C_GENDERS'],  $filedata[9]);
                        $shirt_size_id                      = convert_name2id($data['C_SHIRT_SIZE'],  $filedata[11]);

                        $empl_type_id                       = convert_name2id($data['C_TYPE'],  $filedata[15]);
                        if($empl_type_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Employee type for '.$filedata[2].' '.$filedata[4].'.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }

                        $position_id                        = convert_name2id($data['C_POSITIONS'],  $filedata[16]);
                        if($position_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid position for '.$filedata[2].' '.$filedata[4].'.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }
                        
                        $division_id                        = convert_name2id($data['C_DIVISIONS'],  $filedata[17]);
                        if($division_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid division for '.$filedata[2].' '.$filedata[4].'.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }

                        $group_id                           = convert_name2id($data['C_GROUPS'],  $filedata[18]);
                        if($group_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid group for '.$filedata[2].' '.$filedata[4].'.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }

                        $line_id                            = convert_name2id($data['C_LINES'],  $filedata[19]);
                        if($line_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Line for '.$filedata[2].' '.$filedata[4].'.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }

                        $department_id                      = convert_name2id($data['C_DEPARTMENTS'], $filedata[20]);
                        if($department_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid department for '.$filedata[2].' '.$filedata[4].'.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }
                        $section_id                         = convert_name2id($data['C_SECTIONS'],  $filedata[21]);
                        if($section_id <= 0){
                            $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid section for '.$filedata[2].' '.$filedata[4].'.');
                            redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                            return;
                        }
                        
                        $hmo_id                             = convert_name2id($data['C_HMOS'],  $filedata[30]);

                        if((substr(strval($filedata[13]), 0, 1) == '9') || (substr(strval($filedata[13]), 0, 1) == 9))
                        {
                            $mobile_number = '0'.strval($filedata[13]);
                        }
                        else 
                        {
                            $mobile_number = ($filedata[13]);
                        }
                        $employee_id = strval($filedata[0]);
                        $empl_username = str_pad($employee_id,5,"0",STR_PAD_LEFT);
                        $salt=bin2hex(openssl_random_pseudo_bytes(22));
                        $password= ucfirst($filedata[2].'.'.date_format(date_create($birthday),"Y"));
                        $encrypted_password = md5($password.''.$salt);
                        
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
                            'col_empl_gend' => $gender_id ,
                            'col_empl_nati' => $nationality_id,
                            'col_shir_size' => $shirt_size_id,
                            'col_empl_emai' => $filedata[12],
                            'col_mobl_numb' => $mobile_number,
                            'col_hire_date' => $hired_on,
                            'col_empl_divi' => $division_id,
                            'col_empl_type' => $empl_type_id,
                            'col_empl_posi' => $position_id,
                            'col_empl_group' => $group_id ,
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
                    array_push($succ_inserted,'true');
                   
				}

                if((count($data_arr) > 0)){
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
                        $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ' Duplicate of employee id found: '. implode(', ', $duplicates));
                        redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                        return;
                    } else {
                        $this->db->update_batch('tbl_employee_infos', $data_arr,'col_empl_cmid' );
                    }
				}

				$this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'CSV File Successfully Uploaded!');
				redirect('employees/directories','refresh'); 
			}
		}
		else # else for not successful upload            
		{
			$error =  $this->upload->display_errors();#displaying of the error   
			//echo ("<script language='javascript'> alert('".$error."'); windows.history.back();</script>");
			$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', $error);
			redirect('employees/directories','refresh'); 
		}
	}
    
    function upload_csv_new_employees()
	{
		$curdate                        = date('Y-m-d h:i:s');
		$rundate                        = substr($curdate,5,2).substr($curdate,8,2).substr($curdate,2,2)."_".substr($curdate,11,2).substr($curdate,14,2).substr($curdate,17,2);
		$file_name                      = 'Employee_'.$rundate;
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


		if($this->upload->do_upload('file'))
		{
			$name       = $_FILES["file"]["name"];
			$ext1       = explode(".", $name);
			$ext        = end($ext1);
			$file       = fopen(($path.$file_name.'.'.$ext),"r");
			$ctr        = 0;
			$x[$ctr]    = (fgetcsv($file));


			if(!isset($x[0][0]) || !isset($x[0][1]) || !isset($x[0][2]) || !isset($x[0][3]) || !isset($x[0][4]) || !isset($x[0][5]) || !isset($x[0][6]) || !isset($x[0][7]) || !isset($x[0][8]) || !isset($x[0][9]) || !isset($x[0][10]) || !isset($x[0][11]) || !isset($x[0][12]) || !isset($x[0][13]) || !isset($x[0][14]) || !isset($x[0][15]) || !isset($x[0][16]) || !isset($x[0][17]) || !isset($x[0][18]) || !isset($x[0][19]) || !isset($x[0][20]) || !isset($x[0][21]) || !isset($x[0][22]) || !isset($x[0][23]) || !isset($x[0][24]) || !isset($x[0][25]) || !isset($x[0][26]) || !isset($x[0][27]) || !isset($x[0][28]) || !isset($x[0][29]) || !isset($x[0][30]) || !isset($x[0][31]) || !isset($x[0][32]) || !isset($x[0][33]))
			{
				$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing, incomplete, or incorrect field or column labels.');
				redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
				return;
			}
			else if (($x[0][0] != "Employee ID") || ($x[0][1] != "User Access") || ($x[0][2] != "Last Name") || ($x[0][3] != "Middle Name") || ($x[0][4] != "First Name") || ($x[0][5] != "Marital Status") || ($x[0][6] != "Home Address") || ($x[0][7] != "Current Address") || ($x[0][8] != "Birthday") || ($x[0][9] != "Gender") || ($x[0][10] != "Nationality") || ($x[0][11] != "Shirt Size") || ($x[0][12] != "Email Address") || ($x[0][13] != "Mobile Number") || ($x[0][14] != "Hired On") || ($x[0][15] != "Employment Type") || ($x[0][16] != "Position") || ($x[0][17] != "Division") || ($x[0][18] != "Group")  || ($x[0][19] != "Line") || ($x[0][20] != "Department") || ($x[0][21] != "Section") || ($x[0][22] != "Image File") || ($x[0][23] != "SSS Number") || ($x[0][24] != "Pagibig") || ($x[0][25] != "Philhealth") || ($x[0][26] != "TIN") || ($x[0][27] != "Drivers License") || ($x[0][28] != "National ID") || ($x[0][29] != "Passport") || ($x[0][30] != "HMO") || ($x[0][31] != "HMO Number") || ($x[0][32] != "Salary Rate") || ($x[0][33] != "Salary Type"))
			{
				$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing, incomplete, or incorrect field or column labels.');
				redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
				return;
			}
			else
			{
				$err_duplication    = [];
				$succ_inserted      = [];
				$data_arr           = [];
				while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
					$isDuplicated = $this->employees_model->CHECKDUPLICATEEMPLID($filedata[0]);
					if($isDuplicated){
						if($isDuplicated[0]->col_empl_cmid){
							array_push($err_duplication,$isDuplicated[0]->col_empl_cmid);
						}
					} else {
						// $this->employee_csv_model->insertRecord($filedata);

						if(count($filedata) > 0)
						{
							$newdate                            = str_replace('/', '-', $filedata[8]);
							$birthday                           = date("Y-m-d", strtotime($newdate));
							$newdate_2                          = str_replace('/', '-', $filedata[14]);
							$hired_on                           = date("Y-m-d", strtotime($newdate_2));

                            $user_acess                         = convert_user_access_id($data['C_USER_ACCESS'], $filedata[1]);
                            if($user_acess <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ''.$filedata[2].' '.$filedata[4].' User access is invalid.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }
                            
                            $mari_stat_id                       = convert_name2id($data['C_MARITAL'],$filedata[5]);
                            if($mari_stat_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ''.$filedata[2].' '.$filedata[4].' Marital status is invalid.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $nationality_id                     = convert_name2id($data['C_NATIONALITY'], $filedata[10]);
                            $gender_id                          = convert_name2id($data['C_GENDERS'],  $filedata[9]);
                            $shirt_size_id                      = convert_name2id($data['C_SHIRT_SIZE'],  $filedata[11]);

                            $empl_type_id                       = convert_name2id($data['C_TYPE'],  $filedata[15]);
                            if($empl_type_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Employee type for '.$filedata[2].' '.$filedata[4].'.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $position_id                        = convert_name2id($data['C_POSITIONS'],  $filedata[16]);
                            if($position_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid position for '.$filedata[2].' '.$filedata[4].'.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }
                            
                            $division_id                        = convert_name2id($data['C_DIVISIONS'],  $filedata[17]);
                            if($division_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid division for '.$filedata[2].' '.$filedata[4].'.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $group_id                           = convert_name2id($data['C_GROUPS'],  $filedata[18]);
                            if($group_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid group for '.$filedata[2].' '.$filedata[4].'.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $line_id                            = convert_name2id($data['C_LINES'],  $filedata[19]);
                            if($line_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid Line for '.$filedata[2].' '.$filedata[4].'.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }

                            $department_id                      = convert_name2id($data['C_DEPARTMENTS'], $filedata[20]);
                            if($department_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid department for '.$filedata[2].' '.$filedata[4].'.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }
                            $section_id                         = convert_name2id($data['C_SECTIONS'],  $filedata[21]);
                            if($section_id <= 0){
                                $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'Please Enter a valid section for '.$filedata[2].' '.$filedata[4].'.');
                                redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                                return;
                            }
                            
                            $hmo_id                             = convert_name2id($data['C_HMOS'],  $filedata[30]);

							if((substr(strval($filedata[13]), 0, 1) == '9') || (substr(strval($filedata[13]), 0, 1) == 9))
							{
								$mobile_number = '0'.strval($filedata[13]);
							}
							else 
							{
								$mobile_number = ($filedata[13]);
							}
							$employee_id = strval($filedata[0]);
							$empl_username = str_pad($employee_id,5,"0",STR_PAD_LEFT);
                            $salt=bin2hex(openssl_random_pseudo_bytes(22));
                            $password= ucfirst($filedata[2].'.'.date_format(date_create($birthday),"Y"));
                            $encrypted_password = md5($password.''.$salt);
                            
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
								'col_empl_gend' => $gender_id ,
								'col_empl_nati' => $nationality_id,
								'col_shir_size' => $shirt_size_id,
								'col_empl_emai' => $filedata[12],
								'col_mobl_numb' => $mobile_number,
								'col_hire_date' => $hired_on,
								'col_empl_divi' => $division_id,
								'col_empl_type' => $empl_type_id,
								'col_empl_posi' => $position_id,
								'col_empl_group' => $group_id ,
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
						array_push($succ_inserted,'true');
					}
				}
                // 	echo '<pre>';
                // 	var_dump($data_arr);
                //    return;
       
                
                if((count($data_arr) > 0)){
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
                        $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', ' Duplicate of employee id found: '. implode(', ', $duplicates));
                        redirect('employees/csv_upload','refresh'); //redirect('csv/index','refresh');
                        return;
                    } else {
                        $this->db->insert_batch('tbl_employee_infos', $data_arr);
                    }
				}

				if((count($err_duplication) > 0) && (count($succ_inserted) == 0)){
					$duplicated_ids = '';
					foreach($err_duplication as $err_duplication_row){
						$duplicated_ids .= $err_duplication_row.' <br>';
					}
					$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', count($err_duplication).' Duplicated Employee ids detected. <br>');
				} else if ((count($succ_inserted) > 0) && (count($err_duplication) == 0)) {
					$this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'CSV File Successfully Uploaded!');
				} else if ((count($succ_inserted) > 0) && (count($err_duplication) > 0)){
					$duplicated_ids = '';
					foreach($err_duplication as $err_duplication_row){
						$duplicated_ids .= $err_duplication_row.' <br>';
					}
					$this->session->set_userdata('SESS_WARN_MSG_INSRT_CSV', count($err_duplication). 'Duplicated Employee id/s detected. <br>');
				}
				
				// redirect('employees','refresh');
				redirect('employees/directories','refresh'); //redirect('attendance/generate_rows');
			}
		}
		else # else for not successful upload            
		{
			$error =  $this->upload->display_errors();#displaying of the error   
			//echo ("<script language='javascript'> alert('".$error."'); windows.history.back();</script>");
			$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', $error);
			redirect('employees/directories','refresh'); 
		}
	}
    // =========================================== ASYNC REQUESTS =======================================
    function get_all_employee(){
        $page_num                   = $this->input->post('page_num');
        $num_limit                  = 20;
        if($page_num <= 1){
            $num_start = 0;
        } else {
            $num_start = 20 * ($page_num-1);
        }
        $data                       = $this->employees_model->MOD_DISP_ALL_EMPLOYEES_PAGINATION($num_start, $num_limit);
        echo(json_encode($data));
    }
    function get_all_employee_data(){
        $data                       = $this->employees_model->MOD_DISP_ALL_EMPLOYEES();
        echo(json_encode($data));
    }
    function get_empl_data(){
        $empl_id                    = $this->input->post('empl_id');
        $data                       = $this->employees_model->MOD_DISP_EMPLOYEE($empl_id);
        echo(json_encode($data));
    }

    function process_salary_update($user_id, $value){

        $this->employees_model->UPDATE_SALARY_DETAILS($user_id, $value);

        $this->session->set_userdata('SESS_SUCCESS', 'Salary Details Updated Successfully!');
        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
        }
        // redirect('employees/salary_details');
      }
    
    function process_salary_type_update($user_id, $value){
        $this->employees_model->UPDATE_SALARY_TYPE_DETAILS($user_id, $value);

        $this->session->set_userdata('SESS_SUCCESS', 'Salary Details Updated Successfully!');
        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
        }
        // redirect('employees/salary_details');
      }


    function update_salary_detail_bulk(){
        $empl_id 					        = $this->input->post('UPDATE_ID');
        $salary_amount 		    	        = $this->input->post('UPDT_SALARY_AMOUNT');
        $salary_type 						= $this->input->post('UPDT_SALARY_TYPE');
    
        $empl_ids                           = explode(",",$empl_id);
    
        foreach($empl_ids as $id){
    
          $this->employees_model->UPDATE_SALARY_BULK($id, $salary_amount ,$salary_type);
        }

        $this->session->set_userdata('SESS_SUCCESS', 'Salary Details Updated Successfully!');
        if (isset($_SERVER["HTTP_REFERER"])) {
            redirect($_SERVER["HTTP_REFERER"]);
        }
    
        // redirect('employees/salary_details');
    
      }


      function employee_bulk_activate(){
        $empl_id 					      = $this->input->post('EMPLOYEE_ID');
        $value 					          = $this->input->post('ACTIVATE');

        $empl_ids                         = explode(",",$empl_id);
      
        foreach($empl_ids as $id){

            $this->employees_model->UPDATE_EMPLOYEE_DISABLED($id, $value);
        }

        redirect('employees/directories');
      }

      function employee_bulk_deactivate(){
        $empl_id 					      = $this->input->post('EMPLOYEE_DEACTIVATE_ID');
        $value 					          = $this->input->post('ACTIVATE');

        $empl_ids                         = explode(",",$empl_id);
      
        foreach($empl_ids as $id){

            $this->employees_model->UPDATE_EMPLOYEE_DISABLED($id, $value);
        }

        redirect('employees/directories');
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




function filter_array($user_modules,$user_access){
    $modules=array();
    foreach($user_modules as $module){
      foreach($user_access as $access){
        if(isset($module["value"])){
          if($module["value"]== $access){
              $modules[]=$module;
          }
        }else{
          if($module["title"]== $access){
              $modules[]=$module;
          }
        }
      }
    }
    return $modules;
  }
