<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class main_table_01 extends CI_Controller{
  
  function __construct(){
    parent::__construct();
    $this->load->model('templates/main_table_01_model');
    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance                            = $this->login_model->GET_MAINTENANCE();
    $isAdmin                                = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }
  function index(){
  }
  //-------------------------------------------------------- CRUD FUNCTIONS
  function get_data_all_list(){
    $model                                  = $this->input->post('model_name');
    $table                                  = $this->input->post('table_name');
    $modal_id                               = $this->input->post('modal_id');
    $data                                   = $this->$model->GET_DATA_ROW($table,$modal_id);
    echo (json_encode($data));
  }
  function show_data(){
    $data["model_name"]                     = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]               = $this->$model->GET_EMPL_NAME();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01_show_views', $data);
    
  }
  function edit_data(){
    $data["model_name"]                     = $model  = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"]               = $this->$model->GET_EMPL_NAME();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01_edit_views', $data);
    
  }
  function add_data(){
    $data["model_name"]                     = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01_add_views', $data);
    
  }
  function edit_row(){
    $data["model_name"]                     = $model  = "main_table_01_model";
    $edit_user                              = $this->session->userdata('SESS_USER_ID');
    $input_data                             = $this->input->get();
    $set_array                              = array();
    foreach($input_data as $key => $value){
      if($key == "id"){
        $id = $value;
      }
      else if($key == "table"){
        $table                    = $value;
      }
      else if($key == "module"){
        $module_name              = $value;
      }
      else if($key == "page"){
        $page_name                = $value;
      }
      else{
        $set_array[$key]          = $value;
      }
    }
    $set_array['edit_user']               = $edit_user;
    $set_array['edit_date']               = date("Y-m-d H:i:s");
    $this->$model->EDIT_TABLE_ROW($table,$id,$set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row(){
    $data["model_name"]                   = $model  = "main_table_01_model";
    $edit_user                            = $this->session->userdata('SESS_USER_ID');
    $input_data                           = $this->input->get();
    $set_array                            = array();
    foreach($input_data as $key => $value){
      if($key == "table"){
        $table = $value;
      }
      else if($key == "module"){
        $module_name              = $value;
      }
      else if($key == "page"){
        $page_name                = $value;
      }
      else{
        $set_array[$key] = $value;
      }
    }

    if($input_data['name'] == "" ){
      $this->session->set_userdata('error', 'Please fill out the required fields.');
      redirect($module_name . "/" . $page_name);
    }

    if($table == "tbl_std_holidays"){
      if($input_data['col_holi_date'] == ""){
        $this->session->set_userdata('error', 'Please fill out the required fields.');
        redirect($module_name . "/" . $page_name);
      }
    }

    $isDuplicate                  = $this->$model->CHECK_DUPLICATE($table, $input_data['name']);
    if($isDuplicate > 0){
      $this->session->set_userdata('error', $input_data['name'].' is already exist!');
      redirect($module_name . "/" . $page_name);
    }


    $set_array['edit_user']       = $edit_user;
    $set_array['create_date']     = date("Y-m-d H:i:s");
    $set_array['edit_date']       = date("Y-m-d H:i:s");
    $this->$model->ADD_TABLE_ROW($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row(){
    $data["model_name"]           = $model  = "main_table_01_model";
    $edit_user                    = $this->session->userdata('SESS_USER_ID');
    $id                           = $this->input->get('delete_id');
    $table                        = $this->input->get('table');
    $module_name                  = $this->input->get('module');
    $page_name                    = $this->input->get('page');
    $this->$model->DELETE_TABLE_ROW($id,$table,$edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status(){
    $data["model_name"]           = $model  = "main_table_01_model";
    $edit_user                    = $this->session->userdata('SESS_USER_ID');
    $status                       = $this->input->post('modal_title');
    $ids                          = $this->input->post('list_mark_ids');
    $ids_int                      = array_map('intval', explode(',', $ids));
    $module_name                  = $this->input->get('module');
    $page_name                    = $this->input->get('page_name');
    $table                        = $this->input->get('table');
    $page                         = $this->input->get('page');
    $row_url                      = '&row=';
    $row                          = $this->input->get('row');
    $tab                          = $this->input->get('tab');
    if($page == null){ $page = 1; }
    if($row == null){ $row_url = ''; $row='';}
    if($tab == null){ $tab = "All"; }
    // var_dump($status . $ids );
    $this->$model->EDIT_BULK_STATUS($table,$status,$ids_int,$edit_user);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    //  var_dump($ids_int);
    redirect($module_name.'/'.$page_name.'?page='.$page.$row_url.$row.'&tab='.$tab);
  }
  function csv_import(){
    $data["model_name"]           = $model  = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_01_csv_views', $data);
    
  }
  function excel_import(){
    $data["model_name"]           = $model  = "main_table_01_model";
    $raw_input = basename("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    $raw_input_2 = str_replace("excel_import?", "", $raw_input);
    $raw_encrypted = str_replace("&", "/", $raw_input_2);
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $decryption_iv = '6234564891013126';
    $decryption_key = "Technos";
    $decryption = openssl_decrypt(
        $raw_encrypted,
        $ciphering,
        $decryption_key,
        $options,
        $decryption_iv
    );
    $data['data_list'] = list($table_name, $module_name, $page_name, $module_title, $page_title) = explode('-', $decryption);
    $data['STANDARD_DATA'] = json_encode($this->$model->get_standard_data($data['data_list'][0]));

    $this->load->view('templates/header');
    $this->load->view('templates/main_table_excel_views', $data);
    
  }

  function update_data(){
    $data = json_decode(file_get_contents('php://input'), true);

    $updatedData = $data['updatedData'];
    $tableName = $data['tableName'];

    try {
        foreach($updatedData as $updatedData_row){
            $this->main_table_01_model->update_data($tableName, $updatedData_row);
        }
        $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
        $response = array('warning_message' => 'Error updating data: '.$e->getMessage());
    }
    echo json_encode($response);
  }

  function csv_import_file()
	{
		$file_name                    = 'csv_import_temp';
    $edit_user                    = $this->session->userdata('SESS_USER_ID');
    $table_name                   = $this->input->get('table');
    $module_name                  = $this->input->get('module');
    $page_name                    = $this->input->get('page');
		$path                         = "assets_user/csv_import_temp/";
		$config['file_name']          = $file_name;
		$config['upload_path']        = "./assets_user/csv_import_temp/";
		$config['allowed_types']      = '*';
		$config['max_size']           = '10000';
		$config['overwrite']          = TRUE;
		$this->load->library('upload', $config);
		if($this->upload->do_upload('file')) 
		{
			$name                       = $_FILES["file"]["name"];
			$ext1                       = explode(".", $name);
			$ext                        = end($ext1);
			$file                       = fopen(($path.$file_name.'.'.$ext),"r");
			$ctr                        = 0;
			$x[$ctr]                    = (fgetcsv($file));
			if(!isset($x[0][0]))
			{
				$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing, incomplete, or incorrect field or column labels.');
				redirect($module_name.'/'.$page_name);
				return;
			}
			else if ($x[0][0] != "Name")
			{
				$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', 'The template you uploaded have missing, incomplete, or incorrect field or column labels.');
				redirect($module_name.'/'.$page_name);
				return;
			}
			else
			{
				while (($filedata = fgetcsv($file, 10000, ",")) !== FALSE) {
					$myData[] = $filedata;
					for ($i = 0; $i < count($myData); $i++) {
						$missingColumn = "";
						if ($myData[$i][0] == '') {
							$missingColumn = "Name";
						}
						$name    = $myData[$i][0];
						if ($missingColumn == "") {
							$queryArr = [
							  "name" => $name
							];
							$isDuplicate = $this->main_table_01_model->MOD_CHECK_IF_DUPLICATE($queryArr,$table_name);
							if ($isDuplicate == 0) {
								$this->main_table_01_model->MOD_INSERT_POSITIONS($name,$edit_user,$table_name, 'Active');
							}
						}
					}
				}
				$this->session->set_userdata('success', 'Submitted Successfully!');
				redirect($module_name.'/'.$page_name);
			}
		}
		else # else for not successful upload            
		{
			$error =  $this->upload->display_errors();
			$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', $error);
			redirect($module_name.'/'.$page_name); 
		}
	}
}
