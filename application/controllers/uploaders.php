<?php defined('BASEPATH') or exit('No direct script access allowed');

ob_start();



class uploaders extends CI_Controller{

    function __construct(){

        parent::__construct();

        $this->load->model('modules/uploaders_model');

        $this->load->library('pagination');
        $this->load->library('logger');

    // auto login starts
    $this->load->model('admin_model');
    $auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
    if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
        $this->session->set_userdata('SESS_USER_ID', 1);
    }
    // auto login ends

    }

    function index(){

        $this->load->view('templates/header');

        $this->load->view('test_uploader_view');

    }

    function upload_file(){

        $file                           = $_FILES['raw_file'];
        
        $file_location                  = $this->input->post('file_location');
        $config['upload_path']          = './'.$file_location;
        $config['allowed_types']        = '*';
        $config['encrypt_name']         = TRUE;
        $this->load->library('upload', $config);

        $user_id=$this->session->userdata('SESS_USER_ID');

        if ($this->upload->do_upload('raw_file'))

        {

            $response =  $this->upload->data();

            $data['create_date']        = date('Y-m-d H:i:s');

            $data['edit_date']          = date('Y-m-d H:i:s');

            $data['file_name']          = $file_location.'/'.$response['file_name'];

            $data['file_original_name'] = $response['raw_name'];

            $data['file_size']          = $response['file_size'];

            $data['extension']          = trim($response['file_ext'], ".");

            $data['type']               = $response['is_image']? 'image':trim($response['file_ext'], ".");

            $data['empl_id']            = $user_id;             

            $res=$this->uploaders_model->ADD_DATA_FILE($data);
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Uploaded file');

            echo json_encode($response);

        }

    }


    function delete_files(){
        $user_id    = $this->session->userdata('SESS_USER_ID');
        $input_data = $this->input->post();
        $files      = $input_data['files'];
        
        foreach ($files as $file) {
            // Check if the file exists before attempting deletion
            echo $file;
            if (file_exists('./'.$file)) {
                // Attempt to delete the file
                if (unlink($file)) {
                    $res=$this->uploaders_model->DELET_DATA_FILE($file,$user_id);
                    $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Deleted file');
                    echo 1;
                } else {
                    echo 'Not deleted';
                }
            } else {
                echo 'file not found';
            }
        }
    }
    function get_all_files($offset = 0){

        

        $user_id                    = $this->session->userdata('SESS_USER_ID');

        $type                       = $this->input->get('type');

        $location                   = location_locator($type);

        

        $config['base_url']         = base_url() . 'uploaders/get_all_files';

        $config['total_rows']       = $this->uploaders_model->GET_FILES_COUNT($user_id,$location);

        $config['per_page']         = 25;

        $config['uri_segment']      = 3;

        $config['use_page_numbers'] = FALSE;

        $this->pagination->initialize($config);

        $data['data']= $this->uploaders_model->GET_ALL_UPLOADS($config['per_page'], $offset,$user_id,$location);

        $data['prev_url']= $offset > 0 ? base_url('uploaders/get_all_files/'.$offset-$config['per_page'].'?type='.$type) : '' ;

        $data['next_url']= $offset >= 0 && $offset<=($config['total_rows']-$config['per_page']*2)? base_url('uploaders/get_all_files/'.$offset+$config['per_page'].'?type='.$type): '' ;

        

        echo json_encode($data);

    }

    function search_file(){

        $user_id                    = $this->session->userdata('SESS_USER_ID');

        $query                  = $this->input->get('query');

        $type                   = $this->input->get('type');

        $location               = location_locator($type);

        $data['data']           = $this->uploaders_model->SEARCH_FILES($query,$location,$user_id );

        $data['prev_url']       = '';

         $data['prev_url']      = '';

        echo json_encode($data);

    }

}

function location_locator($type){

    switch($type){

        case 'profile_image' :

            return 'assets_user/user_profile';

            break;

        case 'leave':

            return 'assets_user/files/leaves';

            break;
        case 'offset':

            return 'assets_user/files/offsets';

            break;

        case 'self_services':
            return 'assets_user/files/selfservices';
            break;
        case 'hressentials':
            return 'assets_user/files/hressentials';
            break;

        case 'benefits':
            return 'assets_user/files/benefits';
            break;
        default:

            return 'assets_system/uploads/all';

            

    }

}