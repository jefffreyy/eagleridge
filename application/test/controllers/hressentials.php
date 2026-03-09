<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class hressentials extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/hressentials_model');
    if ($this->session->userdata('SESS_USER_ID') == '') {
        redirect('login/session_expired');
      }
  
      $maintenance         = $this->login_model->GET_MAINTENANCE();
      $isAdmin             = $this->session->userdata('SESS_ADMIN');
      if ($maintenance == '1' && $isAdmin != 1) {
        redirect('login/maintenance');
      }
  }
  function index(){
    $data["Modules"]=  array(   
      array("title"=>"HR Dashboard",        "value"=>"HR Dashboard",         "icon"=>"fa-duotone fa-chart-line-up-down",     "url"=>"hressentials/hrdashboard",      "access"=>"HR Essentials" ,   "id"=>"hr_dashboard"),
      array("title"=>"Announcements",       "value"=>"HR Announcements",     "icon"=>"fa-duotone fa-bullhorn",               "url"=>"hressentials/announcements",    "access"=>"HR Essentials" ,   "id"=>"announcements"),
      array("title"=>"Warnings",            "value"=>"HR Warnings",          "icon"=>"fa-duotone fa-triangle-exclamation",   "url"=>"hressentials/warnings",         "access"=>"HR Essentials" ,   "id"=>"warnings"),
      array("title"=>"Support",             "value"=>"HR Support",           "icon"=>"fa-duotone fa-messages-question",      "url"=>"hressentials/supports",         "access"=>"HR Essentials" ,   "id"=>"support"),
      array("title"=>"Forms",               "value"=>"HR Forms",             "icon"=>"fa-duotone fa-messages-question",      "url"=>"hressentials/forms",            "access"=>"HR Essentials" ,   "id"=>"forms"),
      array("title"=>"Complaint",           "value"=>"HR Complaint" ,        "icon"=>"fa-duotone fa-person-sign",            "url"=>"hressentials/complaints",       "access"=>"HR Essentials" ,   "id"=>"complaint"),
      array("title"=>"Survey",              "value"=>"HR Survey",            "icon"=>"fa-duotone fa-square-poll-vertical",   "url"=>"hressentials/surveys",          "access"=>"HR Essentials" ,   "id"=>"survey"),
      // array("title"=>"Knowledge Base",      "value"=>"HR Knowledge Base",    "icon"=>"fa-duotone fa-head-side-brain",                 "url"=>"hressentials/knowledge_bases",  "access"=>"HR Essentials" ,   "id"=>"knowledge_base"),
      array("title"=>"Events",              "value"=>"HR Events" ,           "icon"=>"fas fa-calendar-check",                "url"=>"hressentials/events",           "access"=>"HR Essentials" ,   "id"=>"events"),
      array("title"=>"Reports",             "value"=>"HR Reports" ,          "icon"=>"fab fa-readme",                        "url"=>"hressentials/reports",          "access"=>"HR Essentials" ,   "id"=>"reports"),
      array("title"=>"Policies",            "value"=>"HR Policies" ,         "icon"=>"fa-duotone fa-scale-balanced",         "url"=>"hressentials/policies",         "access"=>"HR Essentials" ,   "id"=>"policies"),
      array("title"=>"About the Company",   "value"=>"HR About the Company", "icon"=>"fa-duotone fa-buildings",              "url"=>"hressentials/about_the_company","access"=>"HR Essentials" ,   "id"=>"about_the_company"),
      array("title"=>"Welcome Messages",    "value"=>"HR Welcome Messages",  "icon"=>"fas fa-scroll",                        "url"=>"hressentials/welcome_messages", "access"=>"HR Essentials" ,   "id"=>"welcome_messages"),
      array("title"=>"Starter Guide",       "value"=>"HR Starter Guide",     "icon"=>"fas fa-universal-access",              "url"=>"hressentials/starter_guide",    "access"=>"HR Essentials" ,   "id"=>"starter_guide"),
    );
    $data["title_page"]             = "HR Essentials";
    $user_access_id                 = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']  = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                     = explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                = filter_array($data["Modules"],$array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_nav',$data);
    
  }

  function hrdashboard(){
    // if(!isset($_GET["month"])){
    //     $_GET["month"]=date("n");
    // }

    // $data['C_YEARS']            =$this->hressentials_model->GET_YEARS();
    // if(!isset($_GET["year"])){
    //   $year = $data['C_YEARS'][0]->name;
    // }else{
    //   $year = $_GET["year"];
    // }

    (($this->input->get('year')) ? $year   = $this->input->get('year') : $year = date('Y'));
    (($this->input->get('month')) ? $month = $this->input->get('month') :$month = date("n"));

    $data["C_TOTAL_EMPL"]                  = $this->hressentials_model->GET_TOTAL_EMPLOYEE();
    $data["C_THIS_MONTH_HIRE"]             = $this->hressentials_model->GET_JOINERS($year,$month);
    $data["C_LEAVERS"]                     = $this->hressentials_model->GET_LEAVERS($year,$month);
    $employees                             = $this->hressentials_model->GET_EMPLOYEES();
    $skill_data                            = $this->hressentials_model->GET_SKILL_DATA();
    $education_data                        = $this->hressentials_model->GET_EDUCATION_DATA();
    $dependent_data                        = $this->hressentials_model->GET_DEPENDENTS_DATA();
    // $data["C_NO_SKILLS"]        = $data["C_TOTAL_EMPL"] - count(array_intersect($employees,$skill_data));
    // $data["C_NO_EDUC"]          = $data["C_TOTAL_EMPL"] - count(array_intersect($employees,$education_data));
    // $data["C_NO_DEPENDENT"]     = $data["C_TOTAL_EMPL"] - count(array_intersect($employees,$dependent_data));

    $data["C_NO_SKILLS"]                   = count(array_intersect($employees,$skill_data));
    $data["C_NO_EDUC"]                     = count(array_intersect($employees,$education_data));
    $data["C_NO_DEPENDENT"]                = count(array_intersect($employees,$dependent_data));


    $data["C_AVG_AGE"]                     = $this->hressentials_model->GET_AGE_AVG();
    $data["C_AVG_SALARY"]                  = $this->hressentials_model->GET_SALARY_AVG();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/dashboard_views',$data);
    
  }


  function hrdashboard_print(){
    // if(!isset($_GET["month"])){
    //     $_GET["month"]=date("n");
    // }

    (($this->input->get('year')) ? $year   = $this->input->get('year') : $year = date('Y'));
    (($this->input->get('month')) ? $month = $this->input->get('month') :$month = date("n"));

    $data["C_TOTAL_EMPL"]       = $this->hressentials_model->GET_TOTAL_EMPLOYEE();
    $data['C_TOTAL_RES']        = $this->hressentials_model->GET_TOTAL_RESIGNED();
    $data['C_TOTAL_AWOL']       = $this->hressentials_model->GET_TOTAL_AWOL();
    $data['C_TOTAL_END_CON']    = $this->hressentials_model->GET_TOTAL_END_CONTRACT();
    $data['C_TOTAL_TERMINATED'] = $this->hressentials_model->GET_TOTAL_TERMINATED();
    $data["C_THIS_MONTH_HIRE"]  = $this->hressentials_model->GET_JOINERS($year,$month);
    $data["C_LEAVERS"]          = $this->hressentials_model->GET_LEAVERS($year,$month);
    $employees                  = $this->hressentials_model->GET_EMPLOYEES();
    $skill_data                 = $this->hressentials_model->GET_SKILL_DATA();
    $education_data             = $this->hressentials_model->GET_EDUCATION_DATA();
    $dependent_data             = $this->hressentials_model->GET_DEPENDENTS_DATA();
    $data["C_NO_SKILLS"]        = $data["C_TOTAL_EMPL"] - count(array_intersect($employees,$skill_data));
    $data["C_NO_EDUC"]          = $data["C_TOTAL_EMPL"] - count(array_intersect($employees,$education_data));
    $data["C_NO_DEPENDENT"]     = $data["C_TOTAL_EMPL"] - count(array_intersect($employees,$dependent_data));
    $data["C_AVG_AGE"]          = $this->hressentials_model->GET_AGE_AVG();
    $data["C_AVG_SALARY"]       = $this->hressentials_model->GET_SALARY_AVG();

    $data['C_REGULAR']          = $this->hressentials_model->GET_REGULAR_COUNT();
    $data['C_PROBATIONARY']     = $this->hressentials_model->GET_PROBATIONARY_COUNT();
    $data['C_PROJ_BASE']        = $this->hressentials_model->GET_PROJ_BASE_COUNT();
    $data['C_MALE']             = $this->hressentials_model->GET_MALE_COUNT();
    $data['C_FEMALE']           = $this->hressentials_model->GET_FEMALE_COUNT();
    $data['C_DAILY']            = $this->hressentials_model->GET_DAILY_COUNT();
    $data['C_MONTHLY']          = $this->hressentials_model->GET_MONTHLY_COUNT();
    $data['C_PRODUCTION']       = $this->hressentials_model->GET_PRODUCTION_COUNT();
    $data['C_MANUFACTURING']    = $this->hressentials_model->GET_MANU_COUNT();
    $data['C_ADMINISTRATION']   = $this->hressentials_model->GET_ADMIN_COUNT();
    $data['C_SALES']            = $this->hressentials_model->GET_SALES_COUNT();
    $data['C_ACCOUNTING']       = $this->hressentials_model->GET_ACCOUNTING_COUNT();

    $this->load->view('modules/hressentials/dashboard_print_views',$data);

  }

  function get_termination_data(){
    $termination_count          = $this->hressentials_model->GET_TERMINATION_COUNT();
    $termination_type           = $this->hressentials_model->GET_TERMINATION_TYPE();

    $result = [];
    foreach($termination_type as $type){
        foreach($termination_count as $count){
            if($type->id == $count->type){
                $result['labels'][] = $type->name;
                $result['data'][]   = $count->termination_count;
            } 
        }
    }

    echo json_encode($result);
  }


    function get_employee_status(){
        $data        = $this->hressentials_model->GET_EMPLOYEE_BY_TYPES();
        echo json_encode($data);
    }
    function get_data_department(){
        $data        = $this->hressentials_model->GET_BY_DEPARTMENT_DATA();
        echo json_encode($data);
    }
    function get_by_gender_employee(){
        $genders     = $this->hressentials_model-> GET_ALL_GENDER();
        $gender_data = $this->hressentials_model->GET_BY_GENDER_EMPLOYEE();
        $arr_array   = array();
        $index=0;
        foreach($genders as $gender){
            $arr_array["labels"][]      = $gender->name;
            $arr_array["data"][$index]  = 0;
            foreach($gender_data as $empl){
                if($empl->col_empl_gend==$gender->id){
                    $arr_array["data"][$index]=$empl->total_employee;
                    break;
                }
            }
            $index+=1;
        }
        echo json_encode($arr_array);
    }
    
    function get_line_graph_data(){
        for ($i = 5; $i>=0; $i--){
            $months[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
        }
        $hired_employee               = $this->hressentials_model->GET_HIRED_DATA();
        $terminated_employee          = $this->hressentials_model->GET_TERMINATED_EMPL_DATA();
        $arr_data                     = array();
        $index                        = 0;
        foreach($months as $month){
            $arr_data["graph_date"][]            = date_format(date_create($month),"F d");
            $arr_data["labels"][]                = date_format(date_create($month),"M");
            $arr_data["data_hired"][$index]      = 0;
            $arr_data["data_terminated"][$index] = 0;
            foreach($hired_employee as $empl){
                if($month==$empl->month){
                    $arr_data["data_hired"][$index]=$empl->total_employee;
                }
            }
            foreach($terminated_employee as $empl){
                if($month==$empl->month){
                    $arr_data["data_terminated"][$index]=$empl->total_employee;
                }
            }
            $index+=1;
        }
        echo json_encode($arr_data);
    }
    
    function get_pie_ages(){
        $age_data=$this->hressentials_model->GET_DATA_AGE_IN_RANGE();
        echo json_encode($age_data);
    }
    function get_pie_salary(){
        $salary_data=$this->hressentials_model->GET_DATA_SALARY_IN_RANGE();
        echo json_encode($salary_data);
    }
    function get_pie_salary_type(){
        $salary_type_data=$this->hressentials_model->GET_DATA_SALARY_TYPE();
        echo json_encode($salary_type_data);
    }
  function announcements(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'announcements';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_announcements"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Announcements"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "ANN";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"announcements.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Announcements"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
      $c_data_tab             = array(
                                array("Active","status","Active",0),
                                array("Inactive","status","Inactive",0)
                            );
    $data["C_BULK_BUTTON"]    = array(
                                array(true, "btn_mark_active","far fa-check-circle","Mark as Active","status","Active"),    //visible,id,icon,Button Name,column,status
                                array(true, "btn_mark_inactive","far fa-times-circle","Mark as Inactive","status","Inactive")    //visible,id,icon,Button Name,column,status
                            );
    $data["C_DB_DESIGN"]  =	
    array(
      array("id","ID","id","0",1,5,0,0,0,1,0,1),
      array("create_date","Create Date","datetime","0",1,10,0,0,0,1,0,1),
      array("edit_date","Edit Date","datetime","0",0,0,0,0,0,1,0,1),
      array("edit_user","Last Edited By","user","self",0,0,0,0,0,1,0,1),
      array("is_deleted","Is Deleted","hidden","0",0,0,0,0,0,0,0,0),
      array("title","Title","text-row","0",1,20,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,35,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,0,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
      
                  
        );
        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                             = str_replace('_', ' ', $this->input->get('all')?? "");
	$data["default_row"]                = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
    $data["C_BUTTON_ADD"]             = array('title'=>'Add Announcement','path'=>base_url('hressentials/add_announcement'));
	$page                               = $this->input->get('page');
	$row                                = $this->input->get('row');
	$tab                                = $this->input->get('tab');
   $tab_filter                        = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]             =$this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]             =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
    $data["C_DATA_TABLE"]              = $this->$model->get_specific_data($tab,$tab_filter, $table, $search, $row, $offset, $view_type);
    $data["C_DATA_COUNT"]              = count($this->$model->get_specific_data($tab,$tab_filter, $table, $search, $row, $offset, $view_type));
    //  $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                 = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]                  = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
  function add_announcement(){
    $this->load->view('templates/header');
	$this->load->view('modules/hressentials/add_announcement_views'); 
  }
    function add_new_announcement(){
        $input_data                   = $this->input->post();
        $attachment                   = $_FILES['attachment']['name'];
        $file_info                    = pathinfo($attachment);
        $input_data['create_date']    = date('Y-m-d H:i:s');
        $input_data['edit_date']      = date('Y-m-d H:i:s');
        $input_data['edit_user']      = $this->session->userdata('SESS_USER_ID');
        $input_data['attachment']     = $attachment ;
        
        // echo '<pre>';
        // var_dump( $input_data);
        // return;
        if(!empty($attachment)){
            $res=$this->upload_file('./assets_user/files/hressentials/');
            if(!$res){
               redirect('hressentials/add_announcement');
               return;
            }
        }
        $res=$this->hressentials_model->ADD_DATA('tbl_hr_announcements',$input_data);
        if($res){
            $this->session->set_flashdata('SUCC', 'Successfully added');
        }
        else{
            $this->session->set_flashdata('ERR', 'Fail to add new data');
            redirect('hressentials/add_announcement');
            return;
        }
        redirect('hressentials/announcements');
    }
     function upload_file($path){
        $config['upload_path']          = $path;
        $config['max_size']             = 10000;
        $config['allowed_types']        = '*';
        $config['overwrite']            = 'TRUE';
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('attachment'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('ERR', $error['error']);
            
            // var_dump($error);
            return false;
        }
        return true;
  }
  function warnings(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'warnings';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_warnings"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Warnings"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WRN";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"warnings.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Warnings"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
      
        );

        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
	$data["default_row"]                  = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]             = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
    $data["C_BUTTON_ADD"]               = array('title'=>'Add Warning','path'=>base_url('hressentials/add_warning'));
	$page                                 = $this->input->get('page');
	$row                                  = $this->input->get('row');
	$tab                                  = $this->input->get('tab');
   $tab_filter                          = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
     $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type); 
     $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type)); 
    //  $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]                   = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
    function add_warning(){
        $data['C_EMPLOYEES']            = $this->hressentials_model->GET_ALL_EMPLOYEES();
        $this->load->view('templates/header');
	    $this->load->view('modules/hressentials/add_warning_views',$data);
    }
        function add_new_warning(){
            $input_data                 = $this->input->post();
            $attachment                 = $_FILES['attachment']['name'];
            $file_info                  = pathinfo($attachment);
            $input_data['create_date']  = date('Y-m-d H:i:s');
            $input_data['edit_date']    = date('Y-m-d H:i:s');
            $input_data['attachment']   = $attachment ;
            
            // echo '<pre>';
            // var_dump( $input_data);
            // return;
            if(!empty($attachment)){
                $res=$this->upload_file('./assets_user/files/hressentials/');
                if(!$res){
                   redirect('hressentials/add_warning');
                   return;
                }
            }
            $res=$this->hressentials_model->ADD_DATA('tbl_hr_warnings',$input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new data');
                redirect('hressentials/add_warning');
                return;
            }
            redirect('hressentials/warnings');
        }

  function supports(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'supports';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_supports"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Supports"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "SUP";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"supports.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Supports"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        
        
                    
        );

        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                             = str_replace('_', ' ', $this->input->get('all')?? "");
	$data["default_row"]                = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]           = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                  = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
	$data["C_BUTTON_ADD"]               = array('title'=>'Add Support','path'=>base_url('hressentials/add_support'));

	$page                               = $this->input->get('page');
	$row                                = $this->input->get('row');
	$tab                                = $this->input->get('tab');
   $tab_filter                        = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
     $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type); 
     $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type)); 
    //  $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]                   = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
    function add_support(){
        $data['C_EMPLOYEES']    =$this->hressentials_model->GET_ALL_EMPLOYEES();
        $this->load->view('templates/header');
	    $this->load->view('modules/hressentials/add_support_views',$data);
    }
        function add_new_support(){
            $input_data                 = $this->input->post();
            $attachment                 = $_FILES['attachment']['name'];
            $file_info                  = pathinfo($attachment);
            $input_data['create_date']  = date('Y-m-d H:i:s');
            $input_data['edit_date']    = date('Y-m-d H:i:s');
            $input_data['attachment']   = $attachment ;
            
            // echo '<pre>';
            // var_dump( $input_data);
            // return;
            if(!empty($attachment)){
                $res=$this->upload_file('./assets_user/files/hressentials/');
                if(!$res){
                   redirect('hressentials/add_support');
                   return;
                }
            }
            $res=$this->hressentials_model->ADD_DATA('tbl_hr_supports',$input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new data');
                redirect('hressentials/add_support');
                return;
            }
            redirect('hressentials/supports');
        }
  function forms(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'forms';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Forms"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "FRM";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"forms.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Forms"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        
        
                    
        );
        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
	$data["default_row"]                  = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]             = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

	$page                                 = $this->input->get('page');
	$row                                  = $this->input->get('row');
	$tab                                  = $this->input->get('tab');
   $tab_filter                          = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
     $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table,$search,$row,$offset,$view_type); 
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]    = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
  function complaints(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'complaints';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_complaints"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Complaints"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "CMP";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"complaints.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Complaints"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        
        
                    
        );

        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                                 = str_replace('_', ' ', $this->input->get('all') ?? "");
	$data["default_row"]                    = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]               = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

	$page                                   = $this->input->get('page');
	$row                                    = $this->input->get('row');
	$tab                                    = $this->input->get('tab');
   $tab_filter                            = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]                = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]                = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{ 
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
    //  $data["C_DATA_COUNT"]               =$this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                    = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]                     = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
  function surveys(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'surveys';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_surveys"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Surveys"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "SRV";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"surveys.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Surveys"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
      $c_data_tab             = array(
                                array("Active","status","Active",0),
                                array("Inactive","status","Inactive",0)
                            );
    $data["C_BULK_BUTTON"]    = array(
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        );
        $C_ARRAY_TABLE_1 = "";
        $C_ARRAY_TABLE_2 = "";
        $C_ARRAY_TABLE_3 = "";
        $C_ARRAY_TABLE_4 = "";
        $C_ARRAY_TABLE_5 = "";
    
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                  = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]             = $this->$model->GET_EMPL_NAME();
        $data["C_ARRAY_1"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
        $data["C_ARRAY_2"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
        $data["C_ARRAY_3"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
        $data["C_ARRAY_4"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
        $data["C_ARRAY_5"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
        $data["C_BUTTON_ADD"]                 = array('title'=>'Add Survey','path'=>base_url('hressentials/add_survey'));
    
        $page                                 = $this->input->get('page');
        $row                                  = $this->input->get('row');
        $tab                                  = $this->input->get('tab');
        $tab_filter                           = $this->input->get('tab_filter');
     
        if($row == null){ $row = $filter_row[0]; }
        if($tab == null){ $tab = $c_data_tab[0][0]; }
        if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }
     
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if($this->input->get('all') == null){
          $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
          $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }else{
          $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
          $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
        }
        $i=0;
        foreach($c_data_tab as $c_data_tab_row){
            $c_data_tab[$i][3]                = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                   = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_02_views', $data);
    }
        function add_survey(){
            $data['C_EMPLOYEES']              = $this->hressentials_model->GET_ALL_EMPLOYEES();
            $this->load->view('templates/header');    
            $this->load->view('modules/hressentials/add_survey_views',$data);
        }
            function add_new_survey(){
                $input_data                   = $this->input->post();
                $attachment                   = $_FILES['attachment']['name'];
                $file_info = pathinfo($attachment);
                $input_data['create_date']    = date('Y-m-d H:i:s');
                $input_data['edit_date']      = date('Y-m-d H:i:s');
                $input_data['attachment']     = $attachment ;
                
                // echo '<pre>';
                // var_dump( $input_data);
                // return;
                if(!empty($attachment)){
                    $res=$this->upload_file('./assets_user/files/hressentials/');
                    if(!$res){
                       redirect('hressentials/add_survey');
                       return;
                    }
                }
                $res=$this->hressentials_model->ADD_DATA('tbl_hr_surveys',$input_data);
                if($res){
                    $this->session->set_flashdata('SUCC', 'Successfully added');
                }
                else{
                    $this->session->set_flashdata('ERR', 'Fail to add new data');
                    redirect('hressentials/add_survey');
                    return;
                }
                redirect('hressentials/surveys');
            }

  function knowledge_bases(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'knowledge_bases';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_knowledgebases"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Knowledge Bases"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "KNB";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"knowledge_bases.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Knowledge Bases"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
      array("employee_id","Employee","user","0",1,15,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("image","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        
        
                    
        );

        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                                 = str_replace('_', ' ', $this->input->get('all') ?? "");
	$data["default_row"]                    = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]               = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

	$page                                   = $this->input->get('page');
	$row                                    = $this->input->get('row');
	$tab                                    = $this->input->get('tab');
   $tab_filter                            = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]                = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]                = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type);
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type));
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                    = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]                     = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
  function events(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'events';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Events"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "EVT";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"events.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Events"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
      $c_data_tab             = array(
                                array("Active","status","Active",0),
                                array("Inactive","status","Inactive",0)
                            );
    $data["C_BULK_BUTTON"]    = array(
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
                    
        );

        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                                 = str_replace('_', ' ', $this->input->get('all') ?? "");
	$data["default_row"]                    = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]               = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

	$page                                   = $this->input->get('page');
	$row                                    = $this->input->get('row');
	$tab                                    = $this->input->get('tab');
   $tab_filter                            = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter   = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
     $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($table,$search,$row,$offset,$view_type); 
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                   = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]                    = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
  function reports(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'reports';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Reports"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "REP";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"reports.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Reports"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
      $c_data_tab             = array(
                                array("Active","status","Active",0),
                                array("Inactive","status","Inactive",0)
                            );
    $data["C_BULK_BUTTON"]    = array(
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        
        
                    
        );$C_ARRAY_TABLE_1 = "";
        $C_ARRAY_TABLE_2 = "";
        $C_ARRAY_TABLE_3 = "";
        $C_ARRAY_TABLE_4 = "";
        $C_ARRAY_TABLE_5 = "";
    
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                 = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                    = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]               = $this->$model->GET_EMPL_NAME();
        $data["C_ARRAY_1"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
        $data["C_ARRAY_2"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
        $data["C_ARRAY_3"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
        $data["C_ARRAY_4"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
        $data["C_ARRAY_5"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
    
        $page                                   = $this->input->get('page');
        $row                                    = $this->input->get('row');
        $tab                                    = $this->input->get('tab');
        $tab_filter                             = $this->input->get('tab_filter');
     
        if($row == null){ $row = $filter_row[0]; }
        if($tab == null){ $tab = $c_data_tab[0][0]; }
        if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }
     
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if($this->input->get('all') == null){
          $data["C_DATA_TABLE"]                 = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
          $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }else{
          $data["C_DATA_TABLE"]                 = $this->$model->get_specific_data($table,$search,$row,$offset,$view_type); 
          $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }
        $i=0;
        foreach($c_data_tab as $c_data_tab_row){
            $c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                     = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_02_views', $data);
        
      }
  function policies(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'policies';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_policies"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Policies"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "POL";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"policies.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Policies"];                                                                 // Enable, Button Name modal_add_enable   = true;
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),

        );$C_ARRAY_TABLE_1 = "";
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
        $data["C_BUTTON_ADD"]               = array('title'=>'Add Policies','path'=>base_url('hressentials/add_policies'));
    
        $page                               = $this->input->get('page');
        $row                                = $this->input->get('row');
        $tab                                = $this->input->get('tab');
   $tab_filter                              = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]                = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]                = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
      $data["C_DATA_TABLE"]               = $this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type); 
      $data["C_DATA_COUNT"]               = count($this->$model->get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type)); 
   }
   $i=0;
  foreach($c_data_tab as $c_data_tab_row){
      $c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
      $i++;
  }
  $data["C_DATA_TAB"]    = $c_data_tab;
  $this->load->view('templates/header');
  $this->load->view('templates/main_table_02_views', $data);
  
}
    function add_policies(){
        $data['C_EMPLOYEES']              = $this->hressentials_model->GET_ALL_EMPLOYEES();
        $this->load->view('templates/header');    
        $this->load->view('modules/hressentials/add_policy_views',$data);
    }
        function add_new_policy(){
            $input_data                   = $this->input->post();
            $attachment                   = $_FILES['attachment']['name'];
            $file_info                    = pathinfo($attachment);
            $input_data['create_date']    = date('Y-m-d H:i:s');
            $input_data['edit_date']      = date('Y-m-d H:i:s');
            $input_data['attachment']     = $attachment ;
            
            // echo '<pre>';
            // var_dump( $input_data);
            // return;
            if(!empty($attachment)){
                $res=$this->upload_file('./assets_user/files/hressentials/');
                if(!$res){
                   redirect('hressentials/add_policies');
                   return;
                }
            }
            $res=$this->hressentials_model->ADD_DATA('tbl_hr_policies',$input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new data');
                redirect('hressentials/add_policies');
                return;
            }
            redirect('hressentials/policies');
        }
    
  function about_the_company(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $about_result             = $this->hressentials_model->HR_ABOUTCOMPANY();
    if($about_result > 0){
      $aboutcompany           = false;
    }else{
      $aboutcompany = "Add About the Companys";
    }
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'about_the_company';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_aboutcompany"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "About the Company"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "ABT";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"about_the_company.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,$aboutcompany];                                                                 // Enable, Button Name modal_add_enable   = true;
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
      array("about_cmp","About","text-area","0",1,15,1,1,1,1,1,1),
      array("mission","Mission","text-area","0",1,15,1,1,1,1,1,1),
      array("vision","Vision","text-area","0",1,15,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        
        );
        $C_ARRAY_TABLE_1 = "";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                               = str_replace('_', ' ', $this->input->get('all') ?? "");
	$data["default_row"]                  = $filter_row[0];
	$data["C_DATA_EMPL_NAME"]             = $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                    = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

	$page                                 = $this->input->get('page');
	$row                                  = $this->input->get('row');
	$tab                                  = $this->input->get('tab');
   $tab_filter                          = $this->input->get('tab_filter');

   if($row == null){ $row = $filter_row[0]; }
   if($tab == null){ $tab = $c_data_tab[0][0]; }
   if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }

   $offset = $row * ($page - 1);
   $data["C_TAB_SELECT"] = $tab;
   if($this->input->get('all') == null){
     $data["C_DATA_TABLE"]               = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }else{
     $data["C_DATA_TABLE"]               = $this->$model->get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type); 
     $data["C_DATA_COUNT"]               = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
   }
   $i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]                   = $c_data_tab;
	$this->load->view('templates/header');
	$this->load->view('templates/main_table_02_views', $data);
	
  }
  function welcome_messages(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'welcome_messages';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_welcomemessages"; 
    $data["module"]           = [base_url().$module,"HR Essentials", "Welcome Messages"];         // Main Menu Path, Module, Page Title
    $data["id_prefix"]        = "WEL";
    $data["excel_import"]     = [false]; 
    $data["excel_output"]     = [true,"welcome_messages.xlsx"];                                                       // Enable, File Name
    $data["add_button"]       = [true,"Add Welcome Messages"];                                                                 // Enable, Button Name modal_add_enable   = true;
    $data["status_text"]      = ["Active","Inactive","",""];                                                          //Green, Red, Orange, Gray
    $data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
      $c_data_tab             = array(
                                array("Active","status","Active",0),
                                array("Inactive","status","Inactive",0)
                            );
    $data["C_BULK_BUTTON"]    = array(
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
      array("employee_id","Employee","user","0",1,10,1,1,1,1,1,1),
      array("title","Title","text-row","0",1,15,1,1,1,1,1,1),
      array("description","Description","text-area","0",1,15,1,1,1,1,1,1),
      array("feedback","Feedback","text-area","0",1,15,1,1,1,1,1,1),
      array("attachment","Attachment","attachment","0",0,0,1,1,1,1,1,1),
      array("status","Status","fixed-sel-direct","Active; Inactive",1,15,1,1,1,1,1,1),
        
        
                    
        );$C_ARRAY_TABLE_1 = "";
        $C_ARRAY_TABLE_2 = "";
        $C_ARRAY_TABLE_3 = "";
        $C_ARRAY_TABLE_4 = "";
        $C_ARRAY_TABLE_5 = "";
    
        //---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
        $search                                 = str_replace('_', ' ', $this->input->get('all') ?? "");
        $data["default_row"]                    = $filter_row[0];
        $data["C_DATA_EMPL_NAME"]               = $this->$model->GET_EMPL_NAME();
        $data["C_ARRAY_1"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
        $data["C_ARRAY_2"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
        $data["C_ARRAY_3"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
        $data["C_ARRAY_4"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
        $data["C_ARRAY_5"]                      = $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);
    
        $page                                   = $this->input->get('page');
        $row                                    = $this->input->get('row');
        $tab                                    = $this->input->get('tab');
        $tab_filter                             = $this->input->get('tab_filter');
     
        if($row == null){ $row = $filter_row[0]; }
        if($tab == null){ $tab = $c_data_tab[0][0]; }
        if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }
     
        $offset = $row * ($page - 1);
        $data["C_TAB_SELECT"] = $tab;
        if($this->input->get('all') == null){
          $data["C_DATA_TABLE"]                 = $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
          $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }else{
          $data["C_DATA_TABLE"]                 = $this->$model->get_specific_data($table,$search,$row,$offset,$view_type); 
          $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
        }
        $i=0;
        foreach($c_data_tab as $c_data_tab_row){
            $c_data_tab[$i][3]                  = $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
            $i++;
        }
        $data["C_DATA_TAB"]                     = $c_data_tab;
        $this->load->view('templates/header');
        $this->load->view('templates/main_table_02_views', $data);
        
      }
  function starter_guide()
  {
      $guide                = $this->input->get('guide');
      if($guide == null){ 
        $check              = $this->hressentials_model->GET_STARTER_CHECKBOX();
        $guide              = $check[0]->value;
      }
      else{
        $this->hressentials_model->UPDATE_STARTER_CHECKBOX($guide);
      }
      $data['check_value'] = $guide;
      $this->load->view('templates/header');
      $this->load->view('modules/hressentials/starter_guide_views',$data);
      
  }


}
function filter_array($user_modules,$user_access){
  $modules=array();
  foreach($user_modules as $module){
    foreach($user_access as $access){
    if($module["value"]== $access){
        $modules[]=$module;
    }
    }
  }
  return $modules;
} 