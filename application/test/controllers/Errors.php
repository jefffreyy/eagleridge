<?php defined('BASEPATH') or exit('No direct script access allowed');

ob_start();



class Errors extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function custom_404() {
        $this->output->set_status_header('404');
        $this->load->view('modules/404/error_404');
    }

}

