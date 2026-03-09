<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class userguide extends CI_Controller
{
    public function index()
    {
        $this->load->model('modules/userguide_model');
        // auto login starts
        $this->load->model('admin_model');
        $auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
        if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
            $this->session->set_userdata('SESS_USER_ID', 1);
        }
        // auto login ends

        $employee_id = $this->session->userdata('SESS_USER_ID');

        $moduleData = $this->userguide_model->getUserAccessInfo($employee_id);
        $admin_guide = (stripos($moduleData['user_modules'], 'admin_modules') !== false);
        $hr_guide = (stripos($moduleData['user_modules'], 'hr_guide_modules') !== false);
        $general_guide = (stripos($moduleData['user_modules'], 'general_userguide_modules') !== false);

        //general user videos
        $login_guide = (stripos($moduleData['user_page'], 'userguide_login_account') !== false);
        $change_pass = (stripos($moduleData['user_page'], 'userguide_change_pass') !== false);
        $userguide_ot_req = (stripos($moduleData['user_page'], 'userguide_ot_req') !== false);
        $userguide_leave_req = (stripos($moduleData['user_page'], 'userguide_leave_req') !== false);
        $userguide_holiday_req = (stripos($moduleData['user_page'], 'userguide_holiday_req') !== false);
        $userguide_time_adj = (stripos($moduleData['user_page'], 'userguide_time_adj') !== false);

        $data['login_guide']                = $login_guide;
        $data['change_pass']                = $change_pass;
        $data['userguide_ot_req']           = $userguide_ot_req;
        $data['userguide_ot_req']           = $userguide_ot_req;
        $data['userguide_leave_req']        = $userguide_leave_req;
        $data['userguide_holiday_req']      = $userguide_holiday_req;             
        $data['userguide_time_adj']         = $userguide_time_adj;             

        // admin user videos
        $userguide_active_inactive          = (stripos($moduleData['user_page'], 'userguide_active_inactive') !== false);
        $userguide_reset_pass               = (stripos($moduleData['user_page'], 'userguide_reset_pass') !== false);
        $userguide_useraccess               = (stripos($moduleData['user_page'], 'userguide_useraccess') !== false);
        $userguide_ip_whitelist             = (stripos($moduleData['user_page'], 'userguide_ip_whitelist') !== false);
        $userguide_set_home                 = (stripos($moduleData['user_page'], 'userguide_set_home') !== false);
        $userguide_set_company              = (stripos($moduleData['user_page'], 'userguide_set_company') !== false);
        $userguide_set_useraccess           = (stripos($moduleData['user_page'], 'userguide_set_useraccess') !== false);

        $data['userguide_active_inactive']  = $userguide_active_inactive;
        $data['userguide_reset_pass']       = $userguide_reset_pass;
        $data['userguide_useraccess']       = $userguide_useraccess;
        $data['userguide_ip_whitelist']     = $userguide_ip_whitelist;
        $data['userguide_set_home']         = $userguide_set_home;
        $data['userguide_set_company']      = $userguide_set_company;
        $data['userguide_set_useraccess']   = $userguide_set_useraccess;

        // hr user videos
        $userguide_add_edit                 = (stripos($moduleData['user_page'], 'userguide_add_edit') !== false);
        $userguide_hr_active_inactive       = (stripos($moduleData['user_page'], 'userguide_hr_active_inactive') !== false);
        $userguide_add_edit_workshift       = (stripos($moduleData['user_page'], 'userguide_add_edit_workshift') !== false);
        $userguide_benefits                 = (stripos($moduleData['user_page'], 'userguide_benefits') !== false);
        $userguide_shift_assign             = (stripos($moduleData['user_page'], 'userguide_shift_assign') !== false);
        $userguide_leave_approval           = (stripos($moduleData['user_page'], 'userguide_leave_approval') !== false);
        $userguide_ot_approval              = (stripos($moduleData['user_page'], 'userguide_ot_approval') !== false);
        $userguide_announcement             = (stripos($moduleData['user_page'], 'userguide_announcement') !== false); 
        $userguide_edit_company             = (stripos($moduleData['user_page'], 'userguide_edit_company') !== false); 
        $userguide_add_policy               = (stripos($moduleData['user_page'], 'userguide_add_policy') !== false); 

        $data['userguide_add_edit']             = $userguide_add_edit;
        $data['userguide_hr_active_inactive']   = $userguide_hr_active_inactive;
        $data['userguide_add_edit_workshift']   = $userguide_add_edit_workshift;
        $data['userguide_shift_assign']         = $userguide_shift_assign;
        $data['userguide_leave_approval']       = $userguide_leave_approval;
        $data['userguide_ot_approval']          = $userguide_ot_approval;
        $data['userguide_announcement']         = $userguide_announcement;
        $data['userguide_edit_company']         = $userguide_edit_company;
        $data['userguide_add_policy']           = $userguide_add_policy;
        $data['userguide_benefits']             = $userguide_benefits;
    
        // Section
        $data['admin_guide'] =  $admin_guide;
        $data['hr_guide'] =   $hr_guide;
        $data['general_guide'] =  $general_guide;

        $this->load->view('templates/header');
        $this->load->view('modules/user_guide/user_guide_views', $data);
    }
}
