<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class companies extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/companies_model');

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

    $maintenance = $this->login_model->GET_MAINTENANCE();
    $isAdmin = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }
  function index()
  {
    $data["Modules"] =  array(
      array("title" => "About the Company",    "value" => "Company-About the Company", "icon" => "buildings-duotone.svg",      "info"=>"Access information about the company's mission, values, history.",       "url" => "companies/about_the_company",    "access" => "Company", "id" => "about_the_company"),
      array("title" => "Announcements",        "value" => "Company-Announcements",     "icon" => "bullhorn-duotone.svg",        "info"=>"Stay informed about important company news, events, and updates",      "url" => "companies/announcements",        "access" => "Company", "id" => "announcements"),
      array("title" => "Policies",             "value" => "Company-Policies",          "icon" => "scale-balanced-duotone.svg",  "info"=>"View and understand company policies on various matters, like conduct, leave, benefits, and safety.",      "url" => "companies/policies",             "access" => "Company", "id" => "policies"),
      array("title" => "Organizational Chart", "value" => "Company-Organizational Chart",      "icon" => "sitemap-duotone.svg",          "info"=>"See the company's structure and who reports to whom.",     "url" => "companies/organizational_chart", "access" => "Company", "id" => "organizational_chart"),
      array("title" => "Holidays",             "value" => "Company-Holidays",          "icon" => "person-hiking-duotone_dark.svg",    "info"=>"Review the official company holiday calendar and schedule.",     "url" => "companies/holidays",             "access" => "Company", "id" => "holidays"),
      array("title" => "Knowledge Base",       "value" => "Company-Knowledge Base",    "icon" => "head-side-brain-duotone.svg",  "info"=>"Access self-service guides, tutorials, and resources on policies, benefits, and processes.",     "url" => "companies/knowledges_bases",     "access" => "Company", "id" => "knowlegde_base"),
    );
    $data["title_page"]                                = "Company Module";

    $data["title_description"]                 = "Up-to-date details about the organization, its structure, and other essential information";
    $data["maiya_theme"]                               = $this->companies_model->GET_MAYA_THEME();
    $user_access_id                                    = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE']                     = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page                                        = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    $data['Modules']                                   = filter_array($data["Modules"], $array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_container', $data);
  }
  function about_the_company()
  {

    $data = $this->companies_model->GET_ABOUT_THE_COMPANY();
    $this->load->view('templates/header');
    $this->load->view('modules/companies/about_us_views', $data);
  }

  function about_the_companyOld()
  {
    $data['DISP_ALL_DATA']                             = $this->companies_model->MOD_DISP_ALL_REQUEST();
    $data['DISP_ROW_COUNT']                            = $this->companies_model->MOD_DISP_ALL_DATA_COUNT();
    $this->load->view('templates/header');
    $this->load->view('modules/companies/about_us_views', $data);
  }

  function edit_about()
  {
    $data['DISP_ALL_DATA']                            = $this->companies_model->MOD_DISP_ALL_REQUEST();
    $this->load->view('templates/header');
    $this->load->view('modules/companies/edit_about_us_views', $data);
  }

  function edit_about_us_data()
  {
    $about            = $this->input->post('about');
    $mission          = $this->input->post('mission');
    $vision           = $this->input->post('vision');

    $this->companies_model->EDIT_ABOUT_ALL($about, $mission, $vision);
    $this->session->set_userdata('MSG_EDIT_ABOUT_US', 'About the company updated successfully!');
    redirect('companies/about_the_company');
  }

  function announcements()
  {
    $data['ANNOUNCEMENTS']          = $this->companies_model->GET_ALL_ANNOUNCEMENTS();
    $data['DATE_FORMAT']       = $this->companies_model->GET_SYSTEM_SETTING("date_format");
    $this->load->view('templates/header');
    $this->load->view('modules/companies/company_announcement_views', $data);
  }

  function announcement($id)
  {
    $data['ANNOUNCEMENT'] = $this->companies_model->GET_ANNOUNCEMENT($id);
    $this->load->view('templates/header');
    $this->load->view('modules/hressentials/announcement_views', $data);
  }

  function edit_announcement($id)
  {
    $data['ANNOUNCEMENT'] = $this->companies_model->GET_ANNOUNCEMENT($id);
    $this->load->view('templates/header');
    $this->load->view('modules/companies/edit_announcement_views', $data);
  }

  function update_announcement()
  {
    $userId = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->post();
    $input_data['edit_user'] = $userId;
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $input_file = $_FILES['attachment'];
    if (!empty($input_file['name'])) {
      $input_data['attachment'] = $input_file['name'];
      $res = $this->upload_file();
      if (isset($res['upload_data'])) {
        $res = $this->companies_model->UPDATE_ANNOUNCEMENT($input_data['id'], $input_data);
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
      }
      if (isset($res['error'])) {
        echo $res['error'];
        $this->session->set_flashdata('ERR', $res['error']);
        redirect('companies/edit_announcement/' . $input_data['id']);
        return;
      }
    }
    $res = $this->companies_model->UPDATE_ANNOUNCEMENT($input_data['id'], $input_data);
    $this->session->set_flashdata('SUCC', 'Successfully Updated');
    redirect('companies/announcements');
  }

  function upload_file()
  {
    $config['upload_path']          = './assets_user/files/companies/';
    $config['allowed_types']        = 'png|jpg|jpeg';

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('attachment')) {
      $data = array('upload_data' => $this->upload->data());
      return true;
    } else {

      $error = array('error' => $this->upload->display_errors());
      return $error;
    }
  }

  function activate()
  {
    $input_data   = $this->input->post();
    $table        = $input_data['table'];
    $ids          = explode(' ', $input_data['list_mark_ids']);
    $res          = $this->companies_model->BULK_ACTIVATE($table, 'Active', $ids);
    redirect($this->input->server('HTTP_REFERER'));
  }

  function deactivate()
  {
    $input_data   = $this->input->post();
    $table        = $input_data['table'];
    $ids          = explode(' ', $input_data['list_mark_ids']);
    $res          = $this->companies_model->BULK_ACTIVATE($table, 'Inactive', $ids);
    redirect($this->input->server('HTTP_REFERER'));
  }

  function policies()
  {
    $this->load->library('system_functions');
    $data['POLICIES']   = $this->companies_model->GET_ALL_POLICIES();
    $this->load->view('templates/header');
    $this->load->view('modules/companies/company_policies_views', $data);
  }

  function organizational_chart()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/companies/organizational_chart_views');
  }

  function knowledges_bases()
  {
    $data['KNOWLEDGE_BASES']    = array();
    $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
    $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset                     = $limit * ($page - 1);
    $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
    $data['KNOWLEDGE_BASES']    = $this->companies_model->GET_KNOWLEDGE_BASES($limit, $offset, $status);
    $data['ACTIVES']            = count($this->companies_model->GET_KNOWLEDGE_BASES($limit, $offset, 'Active'));
    $data['INACTIVES']          = count($this->companies_model->GET_KNOWLEDGE_BASES($limit, $offset, 'Inactive'));
    $total_count                = $this->companies_model->GET_KNOWLEDGE_BASES_COUNT($status);
    $excess                     = $total_count % $limit;
    $data['C_DATA_COUNT']       = $total_count;
    $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE']               = $page;
    $data['ROW']                = $limit;
    $data['C_ROW_DISPLAY']      = array(10, 25, 50);
    $data['TAB']                = $status;
    // echo '<pre>';
    // var_dump($data['KNOWLEDGE_BASES']);
    // return;
    $this->load->view('templates/header');
    $this->load->view('modules/companies/knowledges_bases_views', $data);
  }
  function add_knowledge_base(){
    $data['EMPLOYEES']= $this->companies_model->GET_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/companies/add_knowledge_base_views',$data);
  }
  function add_new_knowledge_base(){
        $input_data=$this->input->post();
        $validKeys = ['status','description','employee_id','title','feedback','attachment'];
        $input_data             = array_intersect_key($input_data, array_flip($validKeys));
        $input_data['create_date']=date('Y-m-d H:i:s');
        $input_data['edit_date']=date('Y-m-d H:i:s');
        $input_data['edit_user']=$this->session->userdata('SESS_USER_ID');
        $res=$this->companies_model->ADD_DATA('tbl_hr_knowledgebases',$input_data);
        if($res>0){
            redirect('companies/knowledges_bases');
        }
  }
  function edit_knowledge_base($id){
    $data['EMPLOYEES']      = $this->companies_model->GET_ALL_EMPLOYEES();
    $data['KNOWLEDGE_BASE'] = $this->companies_model->GET_KNOWLEDGE_BASE($id);
    $this->load->view('templates/header');
    $this->load->view('modules/companies/edit_knowledge_base_views',$data);
  }
  function update_knowledge_base($id){
        $input_data             = $this->input->post();
        $validKeys              = ['status','description','employee_id','title','feedback','attachment'];
        $input_data             = array_intersect_key($input_data, array_flip($validKeys));
        $input_data['edit_date']= date('Y-m-d H:i:s');
        $input_data['edit_user']= $this->session->userdata('SESS_USER_ID');
        $res=$this->companies_model->UPDATE_DATA('tbl_hr_knowledgebases',$input_data,$id);
        if($res>0){
            redirect('companies/knowledges_bases');
        }
        
  }
  function knowledge_base($id){
    $data['KNOWLEDGE_BASE'] = $this->companies_model->GET_KNOWLEDGE_BASE($id);
   
    $this->load->view('templates/header');
    $this->load->view('modules/companies/view_knowledge_base',$data);
  }
  function holidays()
  {
    $current_year               = date('Y');
    $data['HOLIDAYS']           = array();
    $year                       = $this->input->get('tab') ? $this->input->get('tab') : $current_year;
    $data['TAB'] = $year;
    
    $data['HOLIDAYS']           = $this->companies_model->GET_ALL_HOLIDAYS($year);
    $data['TAB_YEARS']          = array();
    $index = 0;

    $years                    = $this->companies_model->GET_YEARS();

    foreach ($years as $year){
      $data['TAB_YEARS'][$index]['year']    = $year->name;
      $data['TAB_YEARS'][$index]['count']   = count($this->companies_model->GET_ALL_HOLIDAYS($year->name));
      $index++;
    }
    
    // for ($i = $current_year+1; $i >= $current_year - 2; $i--) {
    //   var_dump($i);
    //   $data['TAB_YEARS'][$index]['year']    = $i;
    //   $data['TAB_YEARS'][$index]['count']   = count($this->companies_model->GET_ALL_HOLIDAYS($i));
    //   $index++;
    // }
    $data['DATE_FORMAT']       = $this->companies_model->GET_SYSTEM_SETTING("date_format");

    
    $this->load->view('templates/header');
    $this->load->view('modules/companies/holiday_views', $data);
  }
  function get_organizational_chart()
  {
    $empl_name                            = $this->companies_model->GET_POSITION();
    $res                                  = $this->companies_model->GET_ORGANIZATION_CHART();
    foreach ($res as &$res_row) {
      foreach ($empl_name as &$empl_name_row) {
        if ($res_row["position"] == $empl_name_row->id) {
          $res_row["position"]            = $empl_name_row->name;
        }
        if ($res_row["superior_position"] == $empl_name_row->id) {
          $res_row["superior_position"]   = $empl_name_row->name;
        }
      }
    }
    echo json_encode($res);
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

function set_profile($file_name)
{
  if (file_exists(FCPATH . 'assets_user/user_profile/' . $file_name) && !empty($file_name)) {
    return base_url() . 'assets_user/user_profile/' . $file_name;
  } else {
    return base_url() . 'assets_system/images/default_user.jpg';
  }
}
