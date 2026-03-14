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
        $this->load->model('templates/main_nav_model');
        $this->load->model('modules/benefits_model');
        $this->load->model('modules/assets_model');
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

        $maintenance                       = $this->login_model->GET_MAINTENANCE();
        $isAdmin                           = $this->session->userdata('SESS_ADMIN');
        if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
        }
    }

    function index()
    {
        $data["Modules"] =  array(
            array("title" => "Assets",            "value" => "Assets",       'info' => '',     "icon" => "hands-holding-dollar-duotone.svg",         "url" => "assets/assetslists",      "access" => "Assets", "id" => "assetslist"),
            array("title" => "Stock Rooms",       "value" => "Stock Rooms",    'info' => '',    "icon" => "person-to-door-duotone.svg",             "url" => "assets/stockrooms",       "access" => "Assets", "id" => "stockroom"),
            array("title" => "Location",          "value" => "Location",      'info' => '',     "icon" => "map-location-duotone.svg",           "url" => "assets/locations",        "access" => "Assets", "id" => "location"),
            array("title" => "Asset Categories",  "value" => "Asset Categories", 'info' => '',  "icon" => "hands-holding-dollar-duotone.svg",                  "url" => "assets/assetcategories", "access" => "Assets", "id" => "assetcategories"),
        );

        $data["title_page"]                                 = "Assets";
        $data["title_description"]                          = "It allows organizations to monitor the status, location, and condition of  assets.";
        $data["maiya_theme"]                                = $this->benefits_model->GET_MAYA_THEME();
        $user_access_id                                     = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
        $data['DISP_USER_ACCESS_PAGE']                      = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
        $array_page                                         = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
        $data['Modules']                                    = filter_array($data["Modules"], $array_page);
        $this->load->view('templates/header');
        $this->load->view('templates/main_container', $data);
    }

    function assetslists()
    {
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     = $limit * ($page - 1);
        $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';

        $search_query               = $this->input->get('all');
        $row                        = $this->input->get('row');

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
        
        $data['DISP_ASSETS_INFO']   = $this->assets_model->MOD_DISP_ASSETS($limit, $offset, $status, $search_query, $row);
        $data['ACTIVES']            = count($this->assets_model->MOD_DISP_ASSETS($limit, $offset, 'Active', $search_query, $row));
        $data['INACTIVES']          = count($this->assets_model->MOD_DISP_ASSETS($limit, $offset, 'Inactive', $search_query, $row));
        $total_count                = $this->assets_model->GET_ASSETS_COUNT($status, $search_query);
        $excess                     = $total_count % $limit;
        $data['C_DATA_COUNT']       = $total_count;
        $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']               = $page;
        $data['ROW']                = $limit;
        $data['C_ROW_DISPLAY']      = array(10, 25, 50);
      
        $data['TAB']                = $status;


        $data['DISP_EMPLOYEES']      =   $this->assets_model->get_employees();
        $data['DISP_ASSET_CATEGORY'] =   $this->assets_model->MOD_DISP_AST_CATEGORIES();
        $data['DISP_LOCATION_INFO']  =   $this->assets_model->MOD_DISP_LOCATIONS();
        $data['DISP_ASSET_INFO']     =   $this->assets_model->get_all_assets_info($limit, $offset, $status,$search_query, $row);
        $data['DATE_FORMAT']         = $this->assets_model->GET_SYSTEM_SETTING("date_format"); 

        $this->load->view('templates/header');
        $this->load->view('modules/assets/asset_list_views', $data);
    }

    function edit_asset($id)
    {
        $data['DISP_ASSET_CATEGORY'] =   $this->assets_model->MOD_DISP_AST_CATEGORIES();
        $data['DATE_FORMAT']         = $this->assets_model->GET_SYSTEM_SETTING("date_format"); 
        $data['DISP_LOCATION_INFO'] =   $this->assets_model->MOD_DISP_LOCATIONS();
        $data['DISP_EMPLOYEES'] =   $this->assets_model->get_employees();
        $data['DISP_ASSET'] = $this->assets_model->MOD_DISP_ASSET($id);
        $this->load->view('templates/header');
        $this->load->view('modules/assets/edit_assetlist_views', $data);
    }

    function insert_asset()
    {
        $data['DISP_ASSET_CATEGORY'] =   $this->assets_model->MOD_DISP_AST_CATEGORIES();
        $data['DISP_LOCATION_INFO'] =   $this->assets_model->MOD_DISP_LOCATIONS();
        $data['DISP_EMPLOYEES'] =   $this->assets_model->get_employees();
        $this->load->view('templates/header');
        $this->load->view('modules/assets/add_assetlist_views', $data);
    }

    public function search() {
        $this->load->model('asset_assign_model');
        $search = $this->input->get('search');
        $search_results = $this->assets_model->search_assets($search);
        $data['search_results'] = $search_results;

        $this->load->view('asset_list_views', $data);
    }


    function add_asset()
    {
        $input_data         = $this->input->post();
        $input_data['status']    = 'Active';
        $input_data['create_date']    = date('Y-m-d H:i:s');
        $input_data['edit_date']      = date('Y-m-d H:i:s');
        $input_data['edit_user']      = $this->session->userdata('SESS_USER_ID');

        $res = $this->assets_model->ADD_DATA('tbl_asset_assign', $input_data);
        if ($res) {
            $this->session->set_flashdata('SUCC', 'Successfully added');
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added new asset');
        } else {
            $this->session->set_flashdata('ERR', 'Fail to add new data');
            redirect('assets/edit_asset');
            return;
        }
        redirect('assets/assetslists');
    }

    function update_asset()
    {
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();
        $table = 'tbl_asset_assign';
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');
        $res = $this->assets_model->UPDATE_ASSET($input_data['id'], $table, $input_data);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated asset');
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('assets/assetslists');
    }




    function view_asset($id)
    {
        $data['DISP_ASSET'] = $this->assets_model->MOD_DISP_ASSET($id);
        $data['DATE_FORMAT']         = $this->assets_model->GET_SYSTEM_SETTING("date_format"); 
        $this->load->view('templates/header');
        $this->load->view('modules/assets/assetlist_show.php', $data);
    }

    function locations()
    {
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     = $limit * ($page - 1);
        $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
        $search_query               = $this->input->get('all');

        $data['DISP_LOCATION_INFO']      = $this->assets_model->MOD_DISP_LOCATION($limit, $offset, $status, $search_query);
        $data['ACTIVES']            = count($this->assets_model->MOD_DISP_LOCATION($limit, $offset, 'Active', $search_query));
        $data['INACTIVES']          = count($this->assets_model->MOD_DISP_LOCATION($limit, $offset, 'Inactive', $search_query));
        $total_count                = $this->assets_model->MOD_DISP_LOCATION_COUNT($status);
        $excess                     = $total_count % $limit;
        $data['C_DATA_COUNT']       = $total_count;
        $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']               = $page;
        $data['ROW']                = $limit;
        $data['C_ROW_DISPLAY']      = array(10, 25, 50);
        $data['TAB']                = $status;


        $this->load->view('templates/header');
        $this->load->view('modules/assets/location_views', $data);
    }

    function add_location()
    {

        $this->load->view('templates/header');
        $this->load->view('modules/assets/add_location_views');
    }


    function insert_location()
    {
        $input_data                 = $this->input->post();
        $input_data['status']       = 'Active';

        $res = $this->assets_model->ADD_DATA('tbl_std_companylocations', $input_data);
        if ($res) {
            $this->session->set_flashdata('SUCC', 'Successfully added');
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added location');
        } else {
            $this->session->set_flashdata('ERR', 'Fail to add new data');
            redirect('assets/add_location');
            return;
        }
        redirect('assets/locations');
    }

    function edit_location($id)
    {

        $data['LOCATION_INFO'] =   $this->assets_model->MOD_DISP_LOCATIONS_BY_ID($id);

        $this->load->view('templates/header');
        $this->load->view('modules/assets/edit_location_views', $data);
    }

    function update_location()
    {
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();

        $table = 'tbl_std_companylocations';
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');

        $res = $this->assets_model->UPDATE_ASSET($input_data['id'], $table, $input_data);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated location');
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('assets/locations');
    }



    function stockrooms()
    {
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     = $limit * ($page - 1);
        $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
        $search_query               = $this->input->get('all');
        $data['DISP_STOCKROOM_INFO']      = $this->assets_model->MOD_DISP_STOCKROOM($limit, $offset, $status, $search_query);
        $data['ACTIVES']            = count($this->assets_model->MOD_DISP_STOCKROOM($limit, $offset, 'Active', $search_query));
        $data['INACTIVES']          = count($this->assets_model->MOD_DISP_STOCKROOM($limit, $offset, 'Inactive', $search_query));
        $total_count                = $this->assets_model->GET_STOCKROOM_ASSETS_COUNT($status);
        $excess                     = $total_count % $limit;
        $data['C_DATA_COUNT']       = $total_count;
        $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']               = $page;
        $data['ROW']                = $limit;
        $data['C_ROW_DISPLAY']      = array(10, 25, 50);
        $data['TAB']                = $status;


        $this->load->view('templates/header');
        $this->load->view('modules/assets/stock_room_views', $data);
    }

    function add_stockroom()
    {
        $this->load->view('templates/header');
        $this->load->view('modules/assets/add_stockroom_views');
        // $this->load->view('templates/header');
        // $this->load->view('modules/assets/add_stockroom_views', $data);
    }

    function insert_stockroom()
    {
        $input_data                 = $this->input->post();
        $input_data['status']       = 'Active';

        $res = $this->assets_model->ADD_DATA('tbl_std_stockrooms', $input_data);
        if ($res) {
            $this->session->set_flashdata('SUCC', 'Successfully added');
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added stockroom');
        } else {
            $this->session->set_flashdata('ERR', 'Fail to add new data');
            redirect('assets/add_stockroom');
            return;
        }
        redirect('assets/stockrooms');
    }

    function edit_stockroom($id)
    {
        $data['DISP_STOCKROOM'] = $this->assets_model->MOD_DISP_STOCKROOM_BY_ID($id);
        $this->load->view('templates/header');
        $this->load->view('modules/assets/edit_stockroom_views', $data);
        // $data['DISP_STOCKROOM'] = $this->assets_model->MOD_DISP_STOCKROOM_BY_ID($id);
        // var_dump($data['DISP_STOCKROOM']);

        // $this->load->view('templates/header');
        // $this->load->view('modules/assets/edit_stockroom_views', $data);
    }

    function update_stockroom()
    {
        // $userId = $this->session->userdata('SESS_USER_ID');
        // $input_data = $this->input->post();

        // $table = 'tbl_std_stockrooms';
        // $input_data['edit_user'] = $userId;
        // $input_data['edit_date'] = date('Y-m-d H:i:s');

        // $res = $this->assets_model->UPDATE_ASSET($input_data['id'], $table, $input_data);
        // $this->session->set_flashdata('SUCC', 'Successfully Updated');
        // redirect('assets/stockrooms');
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();

        $table = 'tbl_std_stockrooms';
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');

        $res = $this->assets_model->UPDATE_ASSET($input_data['id'], $table, $input_data);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated stockroom');
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('assets/stockrooms');

        $this->load->view('templates/header');
        $this->load->view('modules/assets/stock_room_views');
    }

    function assetcategories()
    {
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     = $limit * ($page - 1);
        $status                     = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
        $search_query               = $this->input->get('all');

        $data['DISP_ASSETS_INFO']      = $this->assets_model->MOD_DISP_AST_CAT($limit, $offset, $status,$search_query );
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
        $this->load->view('modules/assets/asset_category_views', $data);
    }

    function add_asset_category()
    {
        $input_data                 = $this->input->post();
        $input_data['status']       = 'Active';

        $res = $this->assets_model->ADD_DATA('tbl_std_assetcategories', $input_data);
        if ($res) {
            $this->session->set_flashdata('SUCC', 'Successfully added');
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added asset category');
        } else {
            $this->session->set_flashdata('ERR', 'Fail to add new data');
            redirect('assets/add_asset_category');
            return;
        }
        redirect('assets/assetcategories');
    }

    function add_category()
    {

        $this->load->view('templates/header');
        $this->load->view('modules/assets/add_assetcategory_views');
    }

    function edit_assetcategory($id)
    {
        $data['DISP_CATEGORY'] = $this->assets_model->MOD_DISP_CATEGORY_BY_ID($id);

        $this->load->view('templates/header');
        $this->load->view('modules/assets/edit_category_views', $data);
    }

    function update_category()
    {
        $userId = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();

        $table = 'tbl_std_assetcategories';
        $input_data['edit_user'] = $userId;
        $input_data['edit_date'] = date('Y-m-d H:i:s');

        $res = $this->assets_model->UPDATE_ASSET($input_data['id'], $table, $input_data);
        $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated asset category');
        $this->session->set_flashdata('SUCC', 'Successfully Updated');
        redirect('assets/assetcategories');
    }

    function activate()
    {
        $input_data   = $this->input->post();
        $table        = $input_data['table'];
        $ids          = explode(' ', $input_data['list_mark_ids']);
        $res          = $this->assets_model->BULK_ACTIVATE($table, 'Active', $ids);
        // $is_activated = $this->assets_model->CHECK_STATUS($table);
        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Activated asset');
            $this->session->set_flashdata('SUCC', 'Successfully Activated');
        } else {
            $this->session->set_flashdata('ERR', 'Fail to Activated');
        }
        redirect('assets/' . $input_data['sub_url']);
    }

    function deactivate()
    {
        $input_data   = $this->input->post();
        $table        = $input_data['table'];
        $ids          = explode(' ', $input_data['list_mark_ids']);
        $res          = $this->assets_model->BULK_ACTIVATE($table, 'Inactive', $ids);
        if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deactivated asset');
            $this->session->set_flashdata('SUCC', 'Successfully Deactivated');
            redirect('assets/' . $input_data['sub_url']);
        } else {
            $this->session->set_flashdata('ERR', 'Fail to Deactivated');
            redirect('assets/' . $input_data['sub_url']);
        }
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
