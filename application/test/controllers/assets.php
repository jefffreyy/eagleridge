<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class assets extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('templates/main_nav_model');
        $this->load->model('templates/main_table_01_model');
        $this->load->model('login/login_model');
        $this->load->model('main/p020_emplist_mod');
        $this->load->model('main/p120_assets_mod');
        $this->load->model('settings/p161_location_mod');
        $this->load->model('settings/p205_assetcateg_mod');
        $this->load->model('settings/p177_stockroom_mod');
        $this->load->model('main/p120_assets_mod');
        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
          }
      
          $maintenance                       = $this->login_model->GET_MAINTENANCE();
          $isAdmin                           = $this->session->userdata('SESS_ADMIN');
          if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
          }
    }
    function index()
    {
        $data["Modules"] =  array(  
            array("title"=>"Assets",            "value"=>"Assets",           "icon"=>"fas fa-hand-holding-usd",         "url"=>"assets/assetslist",      "access"=>"Assets"),
            array("title"=>"Stock Rooms",       "value"=>"Stock Rooms",      "icon"=>"fas fa-person-booth",             "url"=>"assets/stockroom",       "access"=>"Assets"),
            array("title"=>"Location",          "value"=>"Location",         "icon"=>"fas fa-map-marker-alt",           "url"=>"assets/location",        "access"=>"Assets"),
            array("title"=>"Asset Categories",  "value"=>"Asset Categories", "icon"=>"fas fa-list-ol",                  "url"=>"assets/assetcategories", "access"=>"Assets"),
          );
        $data["title_page"] = "Assets Module";
        $user_access_id=$this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
        $data['DISP_USER_ACCESS_PAGE']=$this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
        $array_page=explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
        $data['Modules']=filter_array($data["Modules"],$array_page);
        $this->load->view('templates/header');
        $this->load->view('templates/main_nav',$data);
        
    }
    function assetslist(){
        $data['DISP_ASSETS_INFO']               = $this->p120_assets_mod->MOD_DISP_ASSETS();
        $data['DISP_LOCATION_INFO']             = $this->p161_location_mod->MOD_DISP_LOCATION();
        $data['DISP_ASSET_CATEGORY']            = $this->p205_assetcateg_mod->MOD_DISP_ASSETS();
        $data['DISP_ROW_COUNT']                 = $this->p120_assets_mod->MOD_DISP_AST_DATA_COUNT();
        $this->load->view('templates/header');
        $this->load->view('modules/assets/asset_list_views',$data);
        
    }
    function location(){
        $data['DISP_LOCATION_INFO']             = $this->p161_location_mod->MOD_DISP_LOCATION();
        $this->load->view('templates/header');
        $this->load->view('modules/assets/location_views',$data);
        
    }
    function stockroom(){
        $data['DISP_STOCKROOM_INFO']            = $this->p177_stockroom_mod->MOD_DISP_STOCKROOM();
        $this->load->view('templates/header');
        $this->load->view('modules/assets/stock_room_views',$data);
        
    }
    function assetcategories(){
        $data['DISP_ASSETS_INFO']               = $this->p205_assetcateg_mod->MOD_DISP_ASSETS();
        $this->load->view('templates/header');
        $this->load->view('modules/assets/asset_category_views',$data);
        
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