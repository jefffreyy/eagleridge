<?php defined('BASEPATH') or exit('No direct script access allowed');
  ob_start();
  class handsontable_test extends CI_Controller
  {
    function __construct()
    {
      parent::__construct();
      $this->load->model('modules/handsontable_model');
    }

    function handsontable(){
        $data['DISP_EMPLOYEELIST']                          = $this->handsontable_model->GET_EMPLOYEELIST();

        $this->load->view('templates/header');
        $this->load->view('handsontable/add_data_views', $data);
    }


    function update_data(){
        $data = json_decode(file_get_contents('php://input'), true);

        $updatedData = $data['updatedData'];
 
        try {
          foreach ($updatedData as $data_row) {
            $this->handsontable_model->UPDATE_DATA($data_row);
          }
          $response = array('success_message' => 'Data updated successfully');
        } catch (Exception $e) {
          $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
        }
        echo json_encode($response);
    }

    function delete_data()
    {
      $data = json_decode(file_get_contents('php://input'), true);
      try {
        
        foreach ($data as $data_row) {
            $this->handsontable_model->DELETE_DATA($data_row);
        }

        $response = array('success_message' => 'Data deleted successfully');
        
      } catch (Exception $e) {
        $response = array('warning_message' => 'Data deletion error: ' . $e->getMessage());
      }
      echo json_encode($response);
    }

}