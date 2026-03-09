<?php defined('BASEPATH') OR exit('No direct script access allowed');
define('PUBPATH',str_replace(SELF,'',FCPATH)); // added
ob_start();
class autotest extends CI_Controller
{
    function __construct()
    {
      parent::__construct();
      $this->load->model('modules/autotest_model');
    }
    function index()
    {
        $data['DISP_RESULT']                                   = $this->autotest_model->GET_AUTOTEST_RESULT();
      //  $this->load->view('templates/header');
        $this->load->view('modules/autotest_views', $data);
      //  
    }
    function success_details()
    {
        $group_id                                             = $this->input->get('group_id');

        $data['DISP_RESULT_SUCCESS']                          = $this->autotest_model->GET_AUTOTEST_RESULT_SUCCESS($group_id);
      //  $this->load->view('templates/header');
        $this->load->view('modules/autotest_views_01', $data);
      //  
    }
    function failed_details()
    {
        $group_id                                             = $this->input->get('group_id');

        $data['DISP_RESULT_FAILED']                           = $this->autotest_model->GET_AUTOTEST_RESULT_FAILED($group_id);
      //  $this->load->view('templates/header');
        $this->load->view('modules/autotest_views_01', $data);
      //  
    }
    function INSERT_RESULT(){
      $date       = date("Y-m-d H:i:s");
      $site       = $this->input->get('site');
      $title      = $this->input->get('test_title');
      $time       = $this->input->get('time');
      $id         = $this->input->get('id');
      $result     = $this->input->get('result');
      $group_id   = $this->input->get('group_id');

      $isExists   = $this->autotest_model->IS_RECORD_EXISTS($id);

      if ($isExists) {
        // Record exists, perform the update
        $this->autotest_model->UPDATE_RESULT($id, $result, $time);
      } else {
        // Record does not exist, perform the insert
        $this->autotest_model->INSERT_RESULT($date, $site, $id, $title, $result, $time, $group_id);
      }

    // redirect('autotest');
}
}