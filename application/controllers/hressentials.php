<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class hressentials extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/hressentials_model');
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

    $maintenance         = $this->login_model->GET_MAINTENANCE();
    $isAdmin             = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }

  function index()
  {
    $data["Modules"] =  array(
      array("title" => "About the Company",   "value" => "HR About the Company", "info"=>"Access information about the company's mission, values and history.", "icon" => "buildings-duotone_hr.svg",               "url" => "hressentials/about_the_company", "access" => "HR Essentials",   "id" => "about_the_company"),
      array("title" => "Announcements",       "value" => "HR Announcements",     "info"=>"Stay informed about important company news, events and updates.","icon" => "bullhorn-duotone_hr.svg",               "url" => "hressentials/announcements",    "access" => "HR Essentials",   "id" => "announcements"),
      array("title" => "Welcome Message",    "value" => "HR Welcome Messages",  "info"=>"Creates initial greetings and provides introduction to employees. ","icon" => "scroll-duotone.svg",                        "url" => "hressentials/welcome_messages", "access" => "HR Essentials",   "id" => "welcome_messages"),
      array("title" => "Warnings",            "value" => "HR Warnings",          "info"=>"Record and address employee performance, behavior, policy issues, ensuring consistent communication and legal compliance while supporting employee development.","icon" => "triangle-exclamation-duotone.svg",   "url" => "hressentials/warnings",         "access" => "HR Essentials",   "id" => "warnings"),
      array("title" => "Support",             "value" => "HR Support",           "info"=>"Provision of assistance to employees and administrators, also addressing any issues or inquiries that may arise. ","icon" => "messages-question-duotone.svg",      "url" => "hressentials/supports",         "access" => "HR Essentials",   "id" => "support"),
    //   array("title" => "Forms",               "value" => "HR Forms",             "icon" => "fa-duotone fa-messages-question",      "url" => "hressentials/forms",            "access" => "HR Essentials",   "id" => "forms"),
      array("title" => "Complaint",           "value" => "HR Complaint",        "info"=>"Addressing and resolving concerns by employees, ensuring a systematic process for reporting, investigation, and resolution to maintain a positive and fair workplace environment.","icon" => "person-sign-duotone_hr.svg",            "url" => "hressentials/complaints",       "access" => "HR Essentials",   "id" => "complaint"),
      array("title" => "Survey",              "value" => "HR Survey",            "info"=>"Collects feedback from employees, evaluating satisfaction, engagement, and identifying areas for improvement within the workplace.", "icon" => "square-poll-vertical-duotone.svg",   "url" => "hressentials/surveys",          "access" => "HR Essentials",   "id" => "survey"),
    //   array("title" => "Events",              "value" => "HR Events",           "icon" => "fas fa-calendar-check",                "url" => "hressentials/events",           "access" => "HR Essentials",   "id" => "events"),
      array("title" => "Policies",            "value" => "HR Policies",         "info"=>"View and understand company policies on various matters, like conduct, leave, benefits and safety.","icon" => "scale-balanced-duotone_hr.svg",         "url" => "hressentials/policies",         "access" => "HR Essentials",   "id" => "policies"),
      array("title" => "Activities",            "value" => "HR Activities",         "info"=>"Assign activities to employees.","icon" => "universal-access-duotone.svg",         "url" => "hressentials/activities",         "access" => "HR Essentials",   "id" => "hr_activities"),
    );
    $data["title_page"]             = "HR Essentials";
    $data["title_description"]      = "Includes fundamental and core functionalities essential for HR management";
    $user_access_id                 = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']  = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                     = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                = filter_array($data["Modules"], $array_page);
    $data["maiya_theme"]                        = $this->hressentials_model->GET_MAYA_THEME();
    $this->load->view('templates/header');
    $this->load->view('templates/main_container', $data);
  }
  function activities(){
    $data['TABLE_DATA']                                = array();
    $data['DATE_FORMAT']                               = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                            = $limit * ($page - 1);
    $date_from                                         = '';
    $date_to                                           = '';
    $data['TABLE_DATA']                                = $this->hressentials_model->GET_ACTIVITIES($limit,$offset);
    $total_count                                       = $this->hressentials_model->GET_ACTIVITIES_COUNT();
    $excess                                            = $total_count % $limit;
    $data['C_DATA_COUNT']                              = $total_count;
    $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                      = $page;
    $data['ROW']                                       = $limit;
    $data['C_ROW_DISPLAY']                             = array(10, 25, 50);
    $data['EMPLOYEES']                                 = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_activity_views', $data);
  }
  function add_activity(){
    $data['EMPLOYEES']                                 = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $data['DATE_FORMAT']                               = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_new_activity_views', $data);
  }
  function save_activity(){
    $input_data=$this->input->post();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]');
    $this->form_validation->set_rules('duration', 'Duration', 'required|callback__validate_datetime');
    $this->form_validation->set_rules('location', 'Location', 'required');
    $this->form_validation->set_rules('description', 'Description', 'required');
    $this->form_validation->set_rules('participants', 'Participants', 'required');
    $this->form_validation->set_rules('status', 'Status', "required|callback__validate_activity_status");
    
    if ($this->form_validation->run() == FALSE){
      // $errors = $this->form_validation->error_string();
      // echo str_replace('<\/p>',',',$errors);
      $errors[] = form_error('title');
      $errors[] = form_error('duration');
      $errors[] = form_error('location');
      $errors[] = form_error('description');
      $errors[] = form_error('participants');
      $errors[] = form_error('status');
      $this->session->set_flashdata('ERR',join("",$errors));
      redirect('hressentials/add_activity');
    }
    else{
      $valid_data['create_date']  = date('Y-m-d');
      $valid_data['edit_date']    = date('Y-m-d');
      $valid_data['title']        = $input_data['title'];
      $valid_data['duration']     = $input_data['duration'];
      $valid_data['description']  = $input_data['description'];
      $valid_data['location']     = $input_data['location'];
      $valid_data['participants'] = json_encode($input_data['participants']);
      $date_range=explode(" - ",$input_data['duration']);
      $valid_data['start_date']   = date_format(date_create($date_range[0]),'Y-m-d H:i:s');
      $valid_data['end_date']     = date_format(date_create($date_range[1]),'Y-m-d H:i:s');
      $valid_data['status']       = $input_data['status'];
      $res= $this->hressentials_model->ADD_DATA('tbl_activities',$valid_data);
      
      if($res){
        $participant_data=array();
        foreach($input_data['participants'] as $participant){
          $temp_data=array();
          $temp_data['create_date']=date('Y-m-d');
          $temp_data['edit_date']=date('Y-m-d');
          $temp_data['activity_id'] = $res;
          $temp_data['empl_id']     = $participant;
          $participant_data[]= $temp_data;
        }
        $res=$this->hressentials_model->ADD_BATCH_DATA('tbl_participants',$participant_data);
        if($res){
          $this->session->set_flashdata('SUCC',"Successfully added new activity");
        }
      }
      
      redirect('hressentials/activities');
    }
  }
  function edit_activity($id){
    $data['EMPLOYEES']         = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $data['ACTIVITY']          = $this->hressentials_model->GET_DATA_ROW("tbl_activities","id",$id);
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_edit_activity_views', $data);
  }
  function update_activity($id){
    $input_data=$this->input->post();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_error_delimiters('', '');
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]');
    $this->form_validation->set_rules('duration', 'Duration', 'required|callback__validate_datetime');
    $this->form_validation->set_rules('location', 'Location', 'required');
    $this->form_validation->set_rules('description', 'Description', 'required');
    $this->form_validation->set_rules('participants', 'Participants', 'required');
    $this->form_validation->set_rules('status', 'Status', "required|callback__validate_activity_status");
    
    
    if ($this->form_validation->run() == FALSE){
      $errors[] = form_error('title');
      $errors[] = form_error('duration');
      $errors[] = form_error('location');
      $errors[] = form_error('description');
      $errors[] = form_error('participants');
      $errors[] = form_error('status');
      $this->session->set_flashdata('ERR',join("",$errors));
      redirect('hressentials/edit_activity/'.$id);
    }
    else{
      $valid_data['edit_date']    = date('Y-m-d');
      $valid_data['title']        = $input_data['title'];
      $valid_data['duration']     = $input_data['duration'];
      $valid_data['description']  = $input_data['description'];
      $valid_data['location']     = $input_data['location'];
      $valid_data['status']       = $input_data['status'];
      $valid_data['participants'] = json_encode($input_data['participants']);
      $date_range=explode(" - ",$input_data['duration']);
      $valid_data['start_date']   = date_format(date_create($date_range[0]),'Y-m-d H:i:s');
      $valid_data['end_date']     = date_format(date_create($date_range[1]),'Y-m-d H:i:s');
      $res= $this->hressentials_model->UPDATE_DATA('tbl_activities',$valid_data,$id);
      
      if($res){
        $participant_data = array();
        foreach($input_data['participants'] as $participant){
          $temp_data                = array();
          $temp_data['create_date'] = date('Y-m-d');
          $temp_data['edit_date']   = date('Y-m-d');
          $temp_data['activity_id'] = $id;
          $temp_data['empl_id']     = $participant;
          $participant_data[]       = $temp_data;
        }
        $res=$this->hressentials_model->UPDATE_PARTICIPANTS($id,$participant_data);
        
        if($res){
          $this->session->set_flashdata('SUCC',"Successfully updated activity");
        }
      }
      
      redirect('hressentials/activities');
    }
  }
  function get_activity_participants($id){
    $data['TABLE_DATA']                                = array();
    $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                                            = $limit * ($page - 1);
    $date_from                                         = '';
    $date_to                                           = '';
    $data['TABLE_DATA']                                = $this->hressentials_model->GET_ACTIVITY_PARTICIPANTS($id,$limit,$offset);
    $total_count                                       = $this->hressentials_model->GET_ACTIVITY_PARTICIPANTS_COUNT($id);
    $excess                                            = $total_count % $limit;
    $data['C_DATA_COUNT']                              = $total_count;
    $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                      = $page;
    $data['ROW']                                       = $limit;
    $data['C_ROW_DISPLAY']                             = array(10, 25, 50);
    $data['ACTIVITY']                                  = $this->hressentials_model->GET_DATA_ROW("tbl_activities","id",$id);
    $this->load->view('templates/partials/_activity_participants', $data);
  }
  // Callback for validation in activities
  public function _validate_datetime($text) {
    // Define the regular expression pattern
    $pattern = '/^\d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2} - \d{2}\/\d{2}\/\d{4} \d{2}:\d{2}:\d{2}$/';

    // Perform the regular expression match
    if (!preg_match($pattern, $text)) {
        $this->form_validation->set_message('_validate_datetime', 'The %s field does not match the required date-time format.');
        return FALSE;
    } else {
        return TRUE;
    }
  }
  public function _validate_activity_status($status){
    $valid_status=array('Upcoming','Ongoing','Cancelled','Ended');
    if(!in_array($status,$valid_status)){
      $this->form_validation->set_message('_validate_activity_status', 'The %s field does not match the required value.'.$status.' is not a valid value.');
      return FALSE;
    } 
    return TRUE;
  }
  // end call back validation
  function hrdashboard()
  {
    (($this->input->get('year')) ? $year   = $this->input->get('year') : $year = date('Y'));
    (($this->input->get('month')) ? $month = $this->input->get('month') : $month = date('n'));

    $data["C_TOTAL_EMPL"]                  = $this->hressentials_model->GET_TOTAL_EMPLOYEE();
    $data["C_THIS_MONTH_HIRE"]             = $this->hressentials_model->GET_JOINERS($year, $month);
    $data["C_LEAVERS"]                     = $this->hressentials_model->GET_LEAVERS($year, $month);
    $employees                             = $this->hressentials_model->GET_EMPLOYEES();
    $skill_data                            = $this->hressentials_model->GET_SKILL_DATA();
    $education_data                        = $this->hressentials_model->GET_EDUCATION_DATA();
    $dependent_data                        = $this->hressentials_model->GET_DEPENDENTS_DATA();

    $data["C_NO_SKILLS"]                   = count(array_intersect($employees, $skill_data));
    $data["C_NO_EDUC"]                     = count(array_intersect($employees, $education_data));
    $data["C_NO_DEPENDENT"]                = count(array_intersect($employees, $dependent_data));

    $data["C_AVG_AGE"]                     = $this->hressentials_model->GET_AGE_AVG();
    $data["C_AVG_SALARY"]                  = $this->hressentials_model->GET_SALARY_AVG();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/dashboard_views', $data);
  }

  function hrdashboard_print()
  {
    (($this->input->get('year')) ? $year   = $this->input->get('year') : $year = date('Y'));
    (($this->input->get('month')) ? $month = $this->input->get('month') : $month = date("n"));

    $data["C_TOTAL_EMPL"]                  = $this->hressentials_model->GET_TOTAL_EMPLOYEE();
    $data['C_TOTAL_RES']                   = $this->hressentials_model->GET_TOTAL_RESIGNED();
    $data['C_TOTAL_AWOL']                  = $this->hressentials_model->GET_TOTAL_AWOL();
    $data['C_TOTAL_END_CON']               = $this->hressentials_model->GET_TOTAL_END_CONTRACT();
    $data['C_TOTAL_TERMINATED']            = $this->hressentials_model->GET_TOTAL_TERMINATED();
    $data["C_THIS_MONTH_HIRE"]             = $this->hressentials_model->GET_JOINERS($year, $month);
    $data["C_LEAVERS"]                     = $this->hressentials_model->GET_LEAVERS($year, $month);
    $employees                             = $this->hressentials_model->GET_EMPLOYEES();
    $skill_data                            = $this->hressentials_model->GET_SKILL_DATA();
    $education_data                        = $this->hressentials_model->GET_EDUCATION_DATA();
    $dependent_data                        = $this->hressentials_model->GET_DEPENDENTS_DATA();
    $data["C_NO_SKILLS"]                   = $data["C_TOTAL_EMPL"] - count(array_intersect($employees, $skill_data));
    $data["C_NO_EDUC"]                     = $data["C_TOTAL_EMPL"] - count(array_intersect($employees, $education_data));
    $data["C_NO_DEPENDENT"]                = $data["C_TOTAL_EMPL"] - count(array_intersect($employees, $dependent_data));
    $data["C_AVG_AGE"]                     = $this->hressentials_model->GET_AGE_AVG();
    $data["C_AVG_SALARY"]                  = $this->hressentials_model->GET_SALARY_AVG();

    $data['C_REGULAR']                     = $this->hressentials_model->GET_REGULAR_COUNT();
    $data['C_PROBATIONARY']                = $this->hressentials_model->GET_PROBATIONARY_COUNT();
    $data['C_PROJ_BASE']                   = $this->hressentials_model->GET_PROJ_BASE_COUNT();
    $data['C_MALE']                        = $this->hressentials_model->GET_MALE_COUNT();
    $data['C_FEMALE']                      = $this->hressentials_model->GET_FEMALE_COUNT();
    $data['C_DAILY']                       = $this->hressentials_model->GET_DAILY_COUNT();
    $data['C_MONTHLY']                     = $this->hressentials_model->GET_MONTHLY_COUNT();
    $data['C_PRODUCTION']                  = $this->hressentials_model->GET_PRODUCTION_COUNT();
    $data['C_MANUFACTURING']               = $this->hressentials_model->GET_MANU_COUNT();
    $data['C_ADMINISTRATION']              = $this->hressentials_model->GET_ADMIN_COUNT();
    $data['C_SALES']                       = $this->hressentials_model->GET_SALES_COUNT();
    $data['C_ACCOUNTING']                  = $this->hressentials_model->GET_ACCOUNTING_COUNT();

    $this->load->view('modules/hressentials/dashboard_print_views', $data);
  }

  function get_termination_data()
  {
    $termination_count                     = $this->hressentials_model->GET_TERMINATION_COUNT();
    $termination_type                      = $this->hressentials_model->GET_TERMINATION_TYPE();

    $result = [];
    foreach ($termination_type as $type) {
      foreach ($termination_count as $count) {
        if ($type->id == $count->type) {
          $result['labels'][] = $type->name;
          $result['data'][]   = $count->termination_count;
        }
      }
    }

    echo json_encode($result);
  }

  function get_employee_status()
  {
    $data        = $this->hressentials_model->GET_EMPLOYEE_BY_TYPES();
    echo json_encode($data);
  }

  function get_data_department()
  {
    $data        = $this->hressentials_model->GET_BY_DEPARTMENT_DATA();
    echo json_encode($data);
  }

  function get_by_gender_employee()
  {
    $genders     = $this->hressentials_model->GET_ALL_GENDER();
    $gender_data = $this->hressentials_model->GET_BY_GENDER_EMPLOYEE();
    $arr_array   = array();
    $index = 0;
    foreach ($genders as $gender) {
      $arr_array["labels"][]      = $gender->name;
      $arr_array["data"][$index]  = 0;
      foreach ($gender_data as $empl) {
        if ($empl->col_empl_gend == $gender->id) {
          $arr_array["data"][$index] = $empl->total_employee;
          break;
        }
      }
      $index += 1;
    }
    echo json_encode($arr_array);
  }

  function get_line_graph_data()
  {
    for ($i = 5; $i >= 0; $i--) {
      $months[] = date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
    }
    $hired_employee                        = $this->hressentials_model->GET_HIRED_DATA();
    $terminated_employee                   = $this->hressentials_model->GET_TERMINATED_EMPL_DATA();
    $arr_data                              = array();
    $index                                 = 0;
    foreach ($months as $month) {
      $arr_data["graph_date"][]            = date_format(date_create($month), "F d");
      $arr_data["labels"][]                = date_format(date_create($month), "M");
      $arr_data["data_hired"][$index]      = 0;
      $arr_data["data_terminated"][$index] = 0;
      foreach ($hired_employee as $empl) {
        if ($month == $empl->month) {
          $arr_data["data_hired"][$index] = $empl->total_employee;
        }
      }
      foreach ($terminated_employee as $empl) {
        if ($month == $empl->month) {
          $arr_data["data_terminated"][$index] = $empl->total_employee;
        }
      }
      $index += 1;
    }
    echo json_encode($arr_data);
  }

  function get_pie_ages()
  {
    $age_data = $this->hressentials_model->GET_DATA_AGE_IN_RANGE();
    echo json_encode($age_data);
  }

  function get_pie_salary()
  {
    $salary_data = $this->hressentials_model->GET_DATA_SALARY_IN_RANGE();
    echo json_encode($salary_data);
  }

  function get_pie_salary_type()
  {
    $salary_type_data = $this->hressentials_model->GET_DATA_SALARY_TYPE();
    echo json_encode($salary_type_data);
  }

  function announcements()
  {
    $data['ANNOUNCEMENTS']          = array();
    $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                     = $limit * ($page - 1);
    $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
    $data['ANNOUNCEMENTS']      = $this->hressentials_model->GET_ANNOUNCEMENTS($limit, $offset, $status);
    $data['ACTIVES']            = count($this->hressentials_model->GET_ANNOUNCEMENTS($limit, $offset, 'Active'));
    $data['INACTIVES']          = count($this->hressentials_model->GET_ANNOUNCEMENTS($limit, $offset, 'Inactive'));
    $total_count                = $this->hressentials_model->GET_ANNOUNCEMENTS_COUNT($status);
    $excess                     = $total_count % $limit;
    $data['C_DATA_COUNT']       = $total_count;
    $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']               = $page;
    $data['ROW']                = $limit;
    $data['C_ROW_DISPLAY']      = array(10, 25, 50);
    $data['TAB']                = $status;
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_announcement_views', $data);
  }

  function announcement($id)
  {
    $data['ANNOUNCEMENT']   = $this->hressentials_model->GET_ANNOUNCEMENT($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/announcement_views', $data);
  }

  function edit_announcement($id)
  {
    $data['ANNOUNCEMENT']   = $this->hressentials_model->GET_ANNOUNCEMENT($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $current_uri = uri_string();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/edit_announcement_views', $data);
  }

  function update_announcement()
  {
    $userId = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->post();
    $input_data['edit_user'] = $userId;
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $res = $this->hressentials_model->UPDATE_ANNOUNCEMENT($input_data['id'], $input_data);
    $this->session->set_flashdata('SUCC', 'Successfully Updated');
    redirect('hressentials/announcements');
  }

  function add_announcement()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/add_announcement_views');
  }

  function add_new_announcement()
  {
    $input_data                   = $this->input->post();
    // echo '<pre>';
    // var_dump($input_data );
    // return;
    // $attachment                   = $_FILES['attachment']['name'];
    $file_info                    = pathinfo($attachment);
    $input_data['create_date']    = date('Y-m-d H:i:s');
    $input_data['edit_date']      = date('Y-m-d H:i:s');
    $input_data['edit_user']      = $this->session->userdata('SESS_USER_ID');
    $res = $this->hressentials_model->ADD_DATA('tbl_hr_announcements', $input_data);
    if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
        $this->session->set_flashdata('ERR', 'Fail to add new data');
        redirect('hressentials/add_announcement');
    return;
    }

    redirect('hressentials/announcements');
  }

  function upload_file($path, $file_type = 'png|jpg|jpeg')
  {
    $config['upload_path']          = $path;
    $config['max_size']             = 10000;
    $config['allowed_types']        = $file_type;
    $config['overwrite']            = 'TRUE';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('attachment')) {
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('ERR', $error['error']);

      return false;
    }
    return true;
  }

  function activate()
  {
    $input_data   = $this->input->post();
    $table        = $input_data['table'];
    $ids          = explode(' ', $input_data['list_mark_ids']);
    $res          = $this->hressentials_model->BULK_ACTIVATE($table, 'Active', $ids);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully Deactivated');
      redirect('hressentials/' . $input_data['sub_url']);
    } else {
      $this->session->set_flashdata('ERR', 'Fail to Deactivated');
      redirect('hressentials/' . $input_data['sub_url']);
    }
  }

  function deactivate()
  {
    $input_data   = $this->input->post();
    $table        = $input_data['table'];
    $ids          = explode(' ', $input_data['list_mark_ids']);
    $res          = $this->hressentials_model->BULK_ACTIVATE($table, 'Inactive', $ids);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully Deactivated');
      redirect('hressentials/' . $input_data['sub_url']);
    } else {
      $this->session->set_flashdata('ERR', 'Fail to Deactivated');
      redirect('hressentials/' . $input_data['sub_url']);
    }
  }

  function warnings()
  {
    $data['WARNINGS']          = array();
    $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                     = $limit * ($page - 1);
    $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
    $data['WARNINGS']           = $this->hressentials_model->GET_WARNINGS($limit, $offset, $status);
    $data['ACTIVES']            = count($this->hressentials_model->GET_WARNINGS($limit, $offset, 'Active'));
    $data['INACTIVES']          = count($this->hressentials_model->GET_WARNINGS($limit, $offset, 'Inactive'));
    $total_count                = $this->hressentials_model->GET_WARNINGS_COUNT($status);
    $excess                     = $total_count % $limit;
    $data['C_DATA_COUNT']       = $total_count;
    $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']               = $page;
    $data['ROW']                = $limit;
    $data['C_ROW_DISPLAY']      = array(10, 25, 50);
    $data['TAB']                = $status;

    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_warnings_views', $data);
  }
  function add_warning()
  {
    $data['C_EMPLOYEES']            = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/add_warning_views', $data);
  }

  function add_new_warning()
  {
    $input_data                 = $this->input->post();
    $input_data['create_date']  = date('Y-m-d H:i:s');
    $input_data['edit_date']    = date('Y-m-d H:i:s');
    $input_data['edit_user']    = $this->session->userdata('SESS_USER_ID');
    $res = $this->hressentials_model->ADD_DATA('tbl_hr_warnings', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('hressentials/add_warning');
      return;
    }
    redirect('hressentials/warnings');
  }
  function warning($id){
    $data['WARNING']        = $this->hressentials_model->GET_WARNING($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $data['C_EMPLOYEES']    = $this->hressentials_model->GET_ALL_EMPLOYEES();
    // $current_uri = uri_string();
    // echo '<pre>';
    // var_dump($data['WARNING']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/warning_views', $data);
  }
  function edit_warning($id){
    $data['WARNING']        = $this->hressentials_model->GET_WARNING($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $data['C_EMPLOYEES']    = $this->hressentials_model->GET_ALL_EMPLOYEES();
    // $current_uri = uri_string();
    // echo '<pre>';
    // var_dump($data['WARNING']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/edit_warning_views', $data);
  }
  function update_warning($id){
     
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');
        $res = $this->hressentials_model->UPDATE_WARNING($id, $input_data);
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('hressentials/warnings');
  }

  function supports()
  {
    
    $tab                                            = $this->input->get('tab')? $this->input->get('tab') : 'Active';
    $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
    $employee                                       = $this->input->get('all') ? $this->input->get('all') : '';
    // echo $employee;
    // return;
    $offset                                         =  $limit * ($page - 1);
    $data['TABLE_DATA']                             = $this->hressentials_model->GET_SUPPORT_LIST($tab, $limit, $offset,$employee);
    $data['ACTIVES']                                = count($this->hressentials_model->GET_SUPPORT_LIST('Active', $limit, $offset,$employee));
    $data['INACTIVES']                              = count($this->hressentials_model->GET_SUPPORT_LIST('Inactive', $limit, $offset,$employee));
    $total_count                                    = $this->hressentials_model->GET_SUPPORT_LIST_COUNT($tab,$employee);
    $excess                                         = $total_count % $limit;
    $data['C_DATA_COUNT']                           = $total_count;
    $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                   = $page;
    $data['ROW']                                    = $limit;
    $data['C_ROW_DISPLAY']                          = array(10, 25, 50);
    $data['TAB']                                    = $tab;
    $data['EMPLOYEE_LIST']                          = $this->hressentials_model->GET_FORMATTED_ALL_EMPLOYEES();
    $data['EMPLOYEE']                               = $employee;
    // echo '<pre>';
    // var_dump($data['TABLE_DATA']);
    // return;
    $this->load->view('templates/header');
    // $this->load->view('templates/main_table_02_views', $data);
    $this->load->view('modules/hressentials/hr_support_views', $data);
  }
    function show_support($id){
        $data['SUPPORT']    = $this->hressentials_model->GET_SUPPORT($id);
        $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
        $data['EMPLOYEES']  = $this->hressentials_model->GET_ALL_EMPLOYEES();
        $this->load->view('templates/header');
        $this->load->view('modules/hressentials/show_support_views', $data);
    }
  function add_support()
  {
    $data['C_EMPLOYEES']    = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/add_support_views', $data);
  }

  function add_new_support()
  {
    $input_data                 = $this->input->post();
    $file_info                  = pathinfo($attachment);
    $input_data['create_date']  = date('Y-m-d H:i:s');
    $input_data['edit_date']    = date('Y-m-d H:i:s');
    $input_data['edit_user']    = $this->session->userdata('SESS_USER_ID');
    $res = $this->hressentials_model->ADD_DATA('tbl_hr_supports', $input_data);
    
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('hressentials/add_support');
      return;
    }
    redirect('hressentials/supports');
  }
function edit_support($id){
    $data['SUPPORT'] = $this->hressentials_model->GET_SUPPORT($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $data['EMPLOYEES']  = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/edit_support_views', $data);
}
function update_support(){
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');
        $res = $this->hressentials_model->UPDATE_DATA('tbl_hr_supports',$input_data,$input_data['id']);
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('hressentials/supports');
}
  function forms()
  {
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'forms';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
    $data["module"]           = [base_url() . $module, "HR Essentials", "Forms"];
    $data["id_prefix"]        = "FRM";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "forms.xlsx"];
    $data["add_button"]       = [true, "Add Forms"];
    $data["status_text"]      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab             = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]  = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("title", "Title", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("description", "Description", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("feedback", "Feedback", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),
      );
    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

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
    $tab_filter                           = $this->input->get('tab_filter');

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

  function complaints()
  {
    $tab                                            = $this->input->get('tab')? $this->input->get('tab') : 'Active';
    $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
    $employee                                       = $this->input->get('all') ? $this->input->get('all') : '';
    // echo $employee;
    // return;
    $offset                                         =  $limit * ($page - 1);
    $data['TABLE_DATA']                             = $this->hressentials_model->GET_COMPLAINT_LIST($tab, $limit, $offset,$employee);
    $data['ACTIVES']                                = count($this->hressentials_model->GET_COMPLAINT_LIST('Active', $limit, $offset,$employee));
    $data['INACTIVES']                              = count($this->hressentials_model->GET_COMPLAINT_LIST('Inactive', $limit, $offset,$employee));
    $total_count                                    = $this->hressentials_model->GET_COMPLAINT_LIST_COUNT($tab,$employee);
    $excess                                         = $total_count % $limit;
    $data['C_DATA_COUNT']                           = $total_count;
    $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                   = $page;
    $data['ROW']                                    = $limit;
    $data['C_ROW_DISPLAY']                          = array(10, 25, 50);
    $data['TAB']                                    = $tab;
    $data['EMPLOYEE_LIST']                          = $this->hressentials_model->GET_FORMATTED_ALL_EMPLOYEES();
    $data['EMPLOYEE']                               = $employee;
    // echo '<pre>';
    // var_dump($data['TABLE_DATA']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_complaint_views', $data);
  }
  function add_complaint(){
    $data['C_EMPLOYEES']    = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/add_complaint_views', $data);
  }
  function save_complaint(){
    $input_data                 = $this->input->post();
    $validKeys = [
                'employee_id',
                'title','description',
                'feedback','status','attachment'
                ];
    $input_data                 = array_intersect_key($input_data, array_flip($validKeys));
    
    $input_data['create_date']  = date('Y-m-d H:i:s');
    $input_data['edit_date']    = date('Y-m-d H:i:s');
    $input_data['edit_user']    = $this->session->userdata('SESS_USER_ID');
    $res = $this->hressentials_model->ADD_DATA('tbl_hr_complaints', $input_data);
    
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('hressentials/add_complaint');
      return;
    }
    redirect('hressentials/complaints');
  }
  function edit_complaint($id){
    $data['COMPLAINT'] = $this->hressentials_model->GET_COMPLAINT($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $data['EMPLOYEES']  = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/edit_complaint_views', $data);
  }
  function update_complaint(){
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();
        $validKeys = [
                'id',
                'employee_id',
                'title','description',
                'feedback','status','attachment'
                ];
        $input_data                 = array_intersect_key($input_data, array_flip($validKeys));
        
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');
        $res = $this->hressentials_model->UPDATE_DATA('tbl_hr_complaints',$input_data,$input_data['id']);
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('hressentials/complaints');
  }
  function show_complaint($id){
    $data['COMPLAINT'] = $this->hressentials_model->GET_COMPLAINT($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $data['EMPLOYEES']  = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/show_complaint_views', $data);
  }
  function surveys() {
    $tab                                            = $this->input->get('tab')? $this->input->get('tab') : 'Active';
    $limit                                          = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                                           = $this->input->get('page') ? $this->input->get('page') : 1;
    $employee                                       = $this->input->get('all') ? $this->input->get('all') : '';
    $offset                                         =  $limit * ($page - 1);
    $data['TABLE_DATA']                             = $this->hressentials_model->GET_SURVEY_LIST($tab, $limit, $offset,$employee);
    $data['ACTIVES']                                = count($this->hressentials_model->GET_SURVEY_LIST('Active', $limit, $offset,$employee));
    $data['INACTIVES']                              = count($this->hressentials_model->GET_SURVEY_LIST('Inactive', $limit, $offset,$employee));
    $total_count                                    = $this->hressentials_model->GET_SURVEY_LIST_COUNT($tab,$employee);
    $excess                                         = $total_count % $limit;
    $data['C_DATA_COUNT']                           = $total_count;
    $data['PAGES_COUNT']                            = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']                                   = $page;
    $data['ROW']                                    = $limit;
    $data['C_ROW_DISPLAY']                          = array(10, 25, 50);
    $data['TAB']                                    = $tab;
    $data['EMPLOYEE_LIST']                          = $this->hressentials_model->GET_FORMATTED_ALL_EMPLOYEES();
    $data['EMPLOYEE']                               = $employee;
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_survey_views', $data);
  }

  function add_survey()
  {
    $data['C_EMPLOYEES']                 = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/add_survey_views', $data);
  }

  function save_survey()
  {
    $input_data                   = $this->input->post();
    $validKeys = [
                'employee_id',
                'title','description',
                'feedback','status','attachment'
                ];
    $input_data                 = array_intersect_key($input_data, array_flip($validKeys));
    $input_data['create_date']    = date('Y-m-d H:i:s');
    $input_data['edit_date']      = date('Y-m-d H:i:s');
    $input_data['edit_user']    = $this->session->userdata('SESS_USER_ID');
    $res = $this->hressentials_model->ADD_DATA('tbl_hr_surveys', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('hressentials/add_survey');
      return;
    }
    redirect('hressentials/surveys');
  }
    function edit_survey($id){
        $data['SURVEY']         = $this->hressentials_model->GET_SURVEY($id);
        $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
        $data['EMPLOYEES']      = $this->hressentials_model->GET_ALL_EMPLOYEES();
        $this->load->view('templates/header');
        $this->load->view('modules/hressentials/edit_survey_views', $data);
        
    }
    function update_survey(){
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();
        $validKeys = [
                'id',
                'employee_id',
                'title','description',
                'feedback','status','attachment'
                ];
        $input_data                 = array_intersect_key($input_data, array_flip($validKeys));
        
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');
        $res = $this->hressentials_model->UPDATE_DATA('tbl_hr_surveys',$input_data,$input_data['id']);
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('hressentials/surveys');
    }
    function show_survey($id){
        $data['SURVEY']         = $this->hressentials_model->GET_SURVEY($id);
        $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
        $data['EMPLOYEES']      = $this->hressentials_model->GET_ALL_EMPLOYEES();
        $this->load->view('templates/header');
        $this->load->view('modules/hressentials/show_survey_views', $data);
    }
  function knowledge_bases()
  {
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'knowledge_bases';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_knowledgebases";
    $data["module"]           = [base_url() . $module, "HR Essentials", "Knowledge Bases"];
    $data["id_prefix"]        = "KNB";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "knowledge_bases.xlsx"];
    $data["add_button"]       = [true, "Add Knowledge Bases"];
    $data["status_text"]      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]  = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("title", "Title", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("description", "Description", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("image", "Attachment", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

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
      $data["C_DATA_TABLE"]                = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                = $this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                = count($this->$model->get_specific_with_empl_data_2($tab, $tab_filter, $table, $search, $row, $offset, $view_type));
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                    = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                     = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }

  function events()
  {
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'events';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
    $data["module"]           = [base_url() . $module, "HR Essentials", "Events"];
    $data["id_prefix"]        = "EVT";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "events.xlsx"];
    $data["add_button"]       = [true, "Add Events"];
    $data["status_text"]      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab             = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("title", "Title", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("description", "Description", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("feedback", "Feedback", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),

      );

    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

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

    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    if ($tab_filter == null) {
      $tab_filter   = $c_data_tab[0][1];
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

  function reports()
  {
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'reports';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_employee_allowanceassign";
    $data["module"]           = [base_url() . $module, "HR Essentials", "Reports"];
    $data["id_prefix"]        = "REP";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "reports.xlsx"];
    $data["add_button"]       = [true, "Add Reports"];
    $data["status_text"]      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("title", "Title", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("description", "Description", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("feedback", "Feedback", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),



      );
    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

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
      $data["C_DATA_TABLE"]                 = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                 = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                    = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                     = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }

  function policies()
  {
    $data['POLICIES']      = array();
    $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                     = $limit * ($page - 1);
    $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
    $data['POLICIES']      = $this->hressentials_model->GET_POLICIES($limit, $offset, $status);
    $data['ACTIVES']            = count($this->hressentials_model->GET_POLICIES($limit, $offset, 'Active'));
    $data['INACTIVES']          = count($this->hressentials_model->GET_POLICIES($limit, $offset, 'Inactive'));
    $total_count                = $this->hressentials_model->GET_POLICIES_COUNT($status);
    $excess                     = $total_count % $limit;
    $data['C_DATA_COUNT']       = $total_count;
    $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']               = $page;
    $data['ROW']                = $limit;
    $data['C_ROW_DISPLAY']      = array(10, 25, 50);
    $data['TAB']                = $status;
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/hr_policy_views', $data);
  }

  function add_policies()
  {
    $data['C_EMPLOYEES']         = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/add_policy_views', $data);
  }

  function add_new_policy()
  {
    $input_data                   = $this->input->post();
    $attachment                   = $_FILES['attachment']['name'];
    $file_info                    = pathinfo($attachment);
    $input_data['create_date']    = date('Y-m-d H:i:s');
    $input_data['edit_date']      = date('Y-m-d H:i:s');
    $input_data['attachment']     = $attachment;

    if (!empty($attachment)) {
      $res = $this->upload_file('./assets_user/files/hressentials/', 'pdf');
      if (!$res) {
        redirect('hressentials/add_policies');
        return;
      }
    }
    $res = $this->hressentials_model->ADD_DATA('tbl_hr_policies', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('hressentials/add_policies');
      return;
    }
    redirect('hressentials/policies');
  }

  function policy($id)
  {
    $this->load->library('system_functions');
    $data['POLICY']     = $this->hressentials_model->GET_POLICY($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $data['EMPLOYEES']  = $this->hressentials_model->GET_ALL_EMPLOYEES();

    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/policy_views', $data);
  }

  function edit_policy($id)
  {
    $this->load->library('system_functions');
    $data['POLICY']     = $this->hressentials_model->GET_POLICY($id);
    $data['DATE_FORMAT']    = $this->hressentials_model->GET_SYSTEM_SETTING("date_format");
    $data['EMPLOYEES']  = $this->hressentials_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/edit_policy_views', $data);
  }

  function update_policy()
  {
    $userId = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->post();
    $input_data['edit_user'] = $userId;
    $input_data['edit_date'] = date('Y-m-d H:i:s');

    $input_file = $_FILES['attachment'];
    if (!empty($input_file['name'])) {
      $input_data['attachment'] = $input_file['name'];
      $res = $this->upload_file('./assets_user/files/hressentials/', 'pdf|jpg|png|jpeg|xlsx|xls');
      if ($res) {
        $res = $this->hressentials_model->UPDATE_POLICY($input_data['id'], $input_data);
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
      } else {
        redirect('hressentials/edit_policy/' . $input_data['id']);
        return;
      }
    }
    $res = $this->hressentials_model->UPDATE_POLICY($input_data['id'], $input_data);
    $this->session->set_flashdata('SUCC', 'Successfully Updated');
    redirect('hressentials/policies');
  }

  function about_the_company()
  {
    $data = $this->hressentials_model->GET_ABOUT_THE_COMPANY();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/about_the_company_view', $data);
  }

  function about_the_company_save()
  {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data);
    $htmlContent = $data->htmlContent;
    if ($htmlContent) {
      try {
        $response = $this->hressentials_model->UPDATE_ABOUT_THE_COMPANY($htmlContent);
      } catch (Exception $e) {
        $response = array('messageError' => 'Error Saving Welcome Message: ' . $e->getMessage());
      }
      echo json_encode($response);
    } else {
      redirect('login/session_expired');
    }
  }

  function about_the_companyold()
  {
    $about_result             = $this->hressentials_model->HR_ABOUTCOMPANY();
    if ($about_result > 0) {
      $aboutcompany           = false;
    } else {
      $aboutcompany = "Add About the Companys";
    }
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'about_the_company';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_aboutcompany";
    $data["module"]           = [base_url() . $module, "HR Essentials", "About the Company"];
    $data["id_prefix"]        = "ABT";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "about_the_company.xlsx"];
    $data["add_button"]       = [true, $aboutcompany];
    $data["status_text"]      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab             = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]  = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("about_cmp", "About", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("mission", "Mission", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("vision", "Vision", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),

      );
    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

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
    $tab_filter                           = $this->input->get('tab_filter');

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
  function welcome_messages()
  {
    $data = $this->hressentials_model->GET_WELCOME_MESSAGE();
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/welcome_message_views', $data);
  }

  function welcome_messages_save()
  {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data);
    $htmlContent = $data->htmlContent;
    if ($htmlContent) {
      try {
        $response = $this->hressentials_model->UPDATE_MESSAGE($htmlContent);
      } catch (Exception $e) {
        $response = array('messageError' => 'Error Saving Welcome Message: ' . $e->getMessage());
      }
      echo json_encode($response);
    } else {
      redirect('login/session_expired');
    }
  }

  function welcome_messagesOld()
  {
    $user                     = $this->session->userdata('SESS_USER_ID');
    $data["view_type"]        = $view_type    = ['all', 'edit_user', $user];
    $data["module_name"]      = $module       = 'hressentials';
    $data["page_name"]        = $page_name    = 'welcome_messages';
    $data["model_name"]       = $model        = "main_table_02_model";
    $data["table_name"]       = $table        = "tbl_hr_welcomemessages";
    $data["module"]           = [base_url() . $module, "HR Essentials", "Welcome Messages"];
    $data["id_prefix"]        = "WEL";
    $data["excel_import"]     = [false];
    $data["excel_output"]     = [true, "welcome_messages.xlsx"];
    $data["add_button"]       = [true, "Add Welcome Messages"];
    $data["status_text"]      = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"]    = $filter_row = [25, 50, 100];
    $c_data_tab               = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"]    = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"]  =
      array(
        array("id", "ID", "id", "0", 1, 5, 0, 0, 0, 1, 0, 1),
        array("create_date", "Create Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_date", "Edit Date", "datetime", "0", 0, 0, 0, 0, 0, 1, 0, 1),
        array("edit_user", "Last Edited By", "user", "self", 0, 0, 0, 0, 0, 1, 0, 1),
        array("is_deleted", "Is Deleted", "hidden", "0", 0, 0, 0, 0, 0, 0, 0, 0),
        array("employee_id", "Employee", "user", "0", 1, 10, 1, 1, 1, 1, 1, 1),
        array("title", "Title", "text-row", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("description", "Description", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("feedback", "Feedback", "text-area", "0", 1, 15, 1, 1, 1, 1, 1, 1),
        array("attachment", "Attachment", "attachment", "0", 0, 0, 1, 1, 1, 1, 1, 1),
        array("status", "Status", "fixed-sel-direct", "Active; Inactive", 1, 15, 1, 1, 1, 1, 1, 1),

      );
    $C_ARRAY_TABLE_1 = "";
    $C_ARRAY_TABLE_2 = "";
    $C_ARRAY_TABLE_3 = "";
    $C_ARRAY_TABLE_4 = "";
    $C_ARRAY_TABLE_5 = "";

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
      $data["C_DATA_TABLE"]                 = $this->$model->get_data_list($table, $offset, $row, $tab, $tab_filter, $view_type);
      $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    } else {
      $data["C_DATA_TABLE"]                 = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"]                 = $this->$model->get_data_count($table, $tab, $tab_filter, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3]                    = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"]                     = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }

  function starter_guide()
  {
    $guide                = $this->input->get('guide');
    if ($guide == null) {
      $check              = $this->hressentials_model->GET_STARTER_CHECKBOX();
      $guide              = $check[0]->value;
    } else {
      $this->hressentials_model->UPDATE_STARTER_CHECKBOX($guide);
    }
    $data['check_value'] = $guide;
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/starter_guide_views', $data);
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
