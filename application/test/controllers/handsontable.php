<?php defined('BASEPATH') OR exit('No direct script access allowed');
define('PUBPATH',str_replace(SELF,'',FCPATH)); // added
ob_start();
class handsontable extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('modules/handsontable_model');
        $this->load->model('templates/main_nav_model');

        $this->load->library('logger');
        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
        }

    }

    function index(){
        
        $this->load->view('modules/handsontable_views');
    }

    function tableplus(){
        $data['C_POSITIONS']                           = $this->handsontable_model->GET_POSITION();
        $data['C_USER_ACCESS']                         = $this->handsontable_model->GET_USER_ACCESS();
        $data['C_SECTIONS']                            = $this->handsontable_model->GET_SECTIONS();
        $data['C_DEPARTMENTS']                         = $this->handsontable_model->GET_DEPARTMENTS();
        $data['C_TYPE']                                = $this->handsontable_model->GET_TYPE();
        $data['C_SHIRT_SIZE']                          = $this->handsontable_model->GET_SHIRT_SIZE();
        $data['C_GENDERS']                             = $this->handsontable_model->GET_GENDERS();
        $data['C_MARITAL']                             = $this->handsontable_model->GET_MARITAL();
        $data['C_NATIONALITY']                         = $this->handsontable_model->GET_NATIONALITY();
        $data['C_GROUPS']                              = $this->handsontable_model->GET_GROUPS();
        $data['C_LINES']                               = $this->handsontable_model->GET_LINES();
        $data['C_DIVISIONS']                           = $this->handsontable_model->GET_DIVISIONS();
        $data['C_HMO']                                 = $this->handsontable_model->GET_HMO();
        

        $this->load->view('modules/tableplus_views', $data);
    }


    function get_all_employees(){
        
        $data                           = $this->handsontable_model->GET_ALL_EMPLOYEES();


        echo(json_encode($data));
    }




    function get_tableplus_data(){
        
        $result = array();
        $index = 0;
        $data                           = $this->handsontable_model->GET_TABLEPLUS();

        $position                           = $this->handsontable_model->GET_POSITION();
        $section                            = $this->handsontable_model->GET_SECTIONS();
        $department                         = $this->handsontable_model->GET_DEPARTMENTS();
        $type                               = $this->handsontable_model->GET_TYPE();
        $shirt_size                         = $this->handsontable_model->GET_SHIRT_SIZE();
        $gender                             = $this->handsontable_model->GET_GENDERS();
        $marital                            = $this->handsontable_model->GET_MARITAL();
        $nationality                        = $this->handsontable_model->GET_NATIONALITY();
        $groups                             = $this->handsontable_model->GET_GROUPS();
        $lines                              = $this->handsontable_model->GET_LINES();
        $division                           = $this->handsontable_model->GET_DIVISIONS();
        $hmo                                = $this->handsontable_model->GET_HMO();

        foreach ($data as $row) {
            $result[] = [
                'col_empl_cmid' => $row->col_empl_cmid,
                'col_last_name' => $row->col_last_name,
                'col_midl_name' => $row->col_midl_name,
                'col_frst_name' => $row->col_frst_name,
                'col_mart_stat' => $this->convert_id2name($marital, $row->col_mart_stat),
                'col_home_addr' => $row->col_home_addr,
                'col_curr_addr' => $row->col_curr_addr,
                'col_birt_date' => $row->col_birt_date,
                'col_empl_gend' => $this->convert_id2name($gender, $row->col_empl_gend),
                'col_empl_nati' => $this->convert_id2name($nationality, $row->col_empl_nati),
                'col_shir_size' => $this->convert_id2name($shirt_size,$row->col_shir_size),
                'col_empl_emai' => $row->col_empl_emai,
                'col_mobl_numb' => $row->col_mobl_numb,
                'col_hire_date' => $row->col_hire_date,
                'col_empl_type' => $this->convert_id2name($type ,$row->col_empl_type),
                'col_empl_posi' => $this->convert_id2name($position ,$row->col_empl_posi),
                'col_empl_divi' => $this->convert_id2name($division ,$row->col_empl_divi),
                'col_empl_group' => $this->convert_id2name($groups ,$row->col_empl_group),
                'col_empl_line' => $this->convert_id2name($lines ,$row->col_empl_line),
                'col_empl_dept' => $this->convert_id2name($department ,$row->col_empl_dept),
                'col_empl_sect' => $this->convert_id2name($section ,$row->col_empl_sect),
                'col_imag_path' => $row->col_imag_path,
                'col_empl_sssc' => $row->col_empl_sssc,
                'col_empl_hdmf' => $row->col_empl_hdmf,
                'col_empl_phil' => $row->col_empl_phil,
                'col_empl_btin' => $row->col_empl_btin,
                'col_empl_driv' => $row->col_empl_driv,
                'col_empl_naid' => $row->col_empl_naid,
                'col_empl_pass' => $row->col_empl_pass,
                'col_empl_hmoo' => $this->convert_id2name($hmo ,$row->col_empl_hmoo),
                'col_empl_hmon' => $row->col_empl_hmon,
                'salary_rate' => $row->salary_rate,
                'salary_type' => $row->salary_type,
            ];
        }

        echo(json_encode($result));
    }

    
    function convert_id2name($array, $id)
    {
        $name = "";
        foreach ($array as $e) {
            if ($id == $e->id) {
                $name = $e->name;
                return $name;
            }
        }
        return 0;
    }



    function insert_data(){
        $data = json_decode(file_get_contents('php://input'), true);

        try {

            foreach($data as $data_row){

                $is_duplicate = $this->handsontable_model->is_duplicate($data_row);
                

                if($is_duplicate > 0){
                    // $this->handsontable_model->update_data($data_row);
                    $response = array('warning_message' => 'Please avoid providing empty or duplicate information.');
                }else{
        
                    $this->handsontable_model->insert_data($data_row);
                    $response = array('success_message' => 'Data inserted successfully');
                    
                }
            }
            // $response = array('success_message' => 'Data inserted successfully');

        } catch (Exception $e) {
            $response = array('message' => 'Error updating data: '.$e->getMessage());
        }

        echo json_encode($response);
    }


    function update_data() {

        $data = json_decode(file_get_contents('php://input'), true);
  

        try {
            foreach($data as $data_row){
                $this->handsontable_model->update_data($data_row);
            }
            $response = array('message' => 'Data updated successfully');
        } catch (Exception $e) {
            $response = array('message' => 'Error updating data: '.$e->getMessage());
        }
        
        // echo json_encode($response);
        echo json_encode($data);
    }



    

}