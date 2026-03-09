<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class administrator extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // $this->load->model('admin_model');
  }

  function index()
    {
 
        $this->load->view('admin/admin_views');
    }
}