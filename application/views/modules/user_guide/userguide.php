<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class userguide extends CI_Controller
{
    public function index()
    {
        $this->load->model('modules/userguide_model');

        $employee_id = $this->session->userdata('SESS_USER_ID');
       
        $moduleData = $this->userguide_model->getUserAccessInfo($employee_id);
        $admin_guide = (stripos($moduleData['user_page'], 'admin_userguide') !== false);



        // echo '<pre>';
        // var_dump($moduleData);
        // die();
        // $filterValues = ['general_userguide', 'hr_userguide', 'admin_userguide'];

       
        // $filteredData = $this->filterUserPage($moduleData, $filterValues);

        // $data['moduleData'] = $filteredData;

        $data['admin_guide'] =  $admin_guide;

        $this->load->view('templates/header');
        $this->load->view('modules/user_guide/user_guide_views', $data);
    }

    
}



