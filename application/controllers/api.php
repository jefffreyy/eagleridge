<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class api extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('api_model');
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->library('session');
  }

  function index()
  {
    $this->session->unset_userdata('SESS_USER_ID');
    $this->session->unset_userdata('SESS_ADMIN');
    $data["maiya_theme"]                        = $this->api_model->GET_MAYA_THEME();
    delete_cookie('username');
    delete_cookie('password');
    delete_cookie('cookie_search');
    $this->load->view('login/login_views',$data);
  }

  function test()
  {
    header('Content-Type: application/json');

    // Check if the request method is GET
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Return a JSON response with the value "1"

        $data["data"]       = $this->api_model->GET_PENDING_MESSAGES();
        $data["hrms"]       = "Eyebox HRMS";
        $data["url"]        = "https://dev-env2.eyebox.app/";
        $this->api_model->UPDATE_SENT_MESSAGES();
        echo json_encode($data);
    } else {
        // If the request method is not GET, return a 405 Method Not Allowed response
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
    }
  }
 
}
