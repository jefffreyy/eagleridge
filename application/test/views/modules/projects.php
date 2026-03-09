<?php defined('BASEPATH') OR exit('No direct script access allowed');

ob_start();

class projects extends CI_Controller

{

    function __construct()

    {

      parent::__construct();

      $this->load->model('modules/project/project_model');  

      $this->load->model('modules/project_assign/project_assign_model');  

      $this->load->model('settings/p220_leavetyp_mod');

      $this->load->model('main/p020_emplist_mod');

      $this->load->model('main/notif_model');

      if($this->session->userdata('SESS_USER_ID')==''){

        redirect('login');

      }

    }

    /* ================================================= LANDING PAGE ================================================== */

    function index(){

      
       $data['DISP_ALL_EMPLOYEES'] = $this->p020_emplist_mod->MOD_DISP_ALL_EMPLOYEES();

       $data['DISP_ALL_DATA'] = $this->project_model->MOD_DISP_ALL_REQUEST();
       $data['DISP_PROJECT_ASSIGN'] = $this->project_assign_model->MOD_DISP_ALL_REQUEST();

      var_dump($data['DISP_PROJECT_ASSIGN']);

        $this->load->view('templates/header');

        $this->load->view('modules/project/project_views', $data);

        $this->load->view('templates/footer');

    }

    function insert_all_data()
    {


      $project_name = $this->input->post('project_name');
   
      $progress = $this->input->post('progress');
      $status = $this->input->post('status');
      $code = $this->input->post('code');
      $type = $this->input->post('type');
      $budget = $this->input->post('budget');
      $description = $this->input->post('description');
      $max_member = $this->input->post('max-member');
      $start_date = $this->input->post('start_date');
      $end_date = $this->input->post('end_date');
      

      $this->project_model->MOD_INSRT_APPLY_REQUEST_SINGLE($project_name, $progress, $status,$code, $type, $budget, $description, $max_member, $start_date, $end_date);
      $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY','  Submitted Successfully!');

            redirect('projects');
    }

    function add_members()
    {
      $employees = $this->input->post('member');
      $project_id = $this->input->post('project');
      $role= $this->input->post('role');
      $join_date = $this->input->post('join_date');
      $member_start_date = $this->input->post('member_start_date');
      $member_end_date = $this->input->post('member_end_date');
        $this->project_assign_model->MOD_INSRT_APPLY_REQUEST_SINGLE($employees, $project_id, $role, $join_date, $member_start_date, $member_end_date);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPLY','  Submitted Successfully!');
        
 

        redirect('projects');

      
    }

    function update_project()
    {
      $progress = $this->input->post('update_progress');
      $status = $this->input->post('update_status');
      $budget = $this->input->post('update_budget');
      $description = $this->input->post('update_description');
      $employees = $this->input->post('update_member');

      // var_dump($this->input->post);

      $this->project_model->MOD_UPDATE($progress, $status, $budget, $description);
      $this->project_assign_model->MOD_UPDATE($employees);

      redirect('projects');

      // return;
      
    }

  

 

}

?>