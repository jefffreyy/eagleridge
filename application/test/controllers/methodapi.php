<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class methodapi extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('templates/main_nav_model');
        $this->load->model('templates/main_table_01_model');
        $this->load->model('templates/main_table_02_model');
        $this->load->model('modules/hressentials_model');
        $this->load->model('modules/api_model');
       
    }
    function index(){
        $this->load->view('modules/api/sample_page');
    }
    function get_employee_info(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        if(!isset($_GET["id"]) || empty($_GET["id"]) ){
            return header("Status: 400 Bad Request");
        }
        $data=$this->api_model->GET_ALL_EMPLOYEE_ID($_GET["id"]);
        echo json_encode($data);
    }
    function get_pie_ages(){
        $age_data=$this->hressentials_model->GET_DATA_AGE_IN_RANGE();
        echo json_encode($age_data);
    }
}