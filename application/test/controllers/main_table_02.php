<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class main_table_02 extends CI_Controller{
  
  function __construct(){
    parent::__construct();
    $this->load->model('templates/main_table_02_model');
    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

    $maintenance            = $this->login_model->GET_MAINTENANCE();
    $isAdmin                = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }


  }
  function index(){
  }
  //-------------------------------------------------------- CRUD FUNCTIONS
  function get_data_all_list(){
    $model                      = $this->input->post('model_name');
    $table                      = $this->input->post('table_name');
    $modal_id                   = $this->input->post('modal_id');
    $data                       = $this->$model->GET_DATA_ROW($table,$modal_id);
    echo (json_encode($data));
  }
  function show_data(){
    $data["model_name"]         = $model  = "main_table_02_model";
    $data['encrypted_data']     = $this->input->post('show_encrypted_data');

    // $data["C_DATA_EMPL_NAME"] =$this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_show_views', $data);
    
  }
  function edit_data(){
    $data['encrypted_data']     = $this->input->post('edit_encrypted_data');
    $data["model_name"]         = $model  = "main_table_02_model";
    
    // $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    

    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_edit_views', $data);
    
  }

  function edit_data_test(){
    $data                     = $this->input->post('edit_encrypted_data');
    $id_data                  = $this->input->post('edit_id_data');
    
    var_dump($data);
    echo "====<br>";
    var_dump($id_data);
  }


  function add_data(){
    $this->load->library('session');
    $this->load->library('input');
    $data['encrypted_data']   = $this->input->post('add_encrypted_data');
    $data["model_name"]       = $model  = "main_table_02_model";

    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_add_views', $data);
    
  }
  
  function edit_row(){
    $data["model_name"]       = $model  = "main_table_02_model";
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    
    $input_data               = $this->input->get();
    $set_array                = array();
    foreach($input_data as $key => $value){
      if($key == "id"){
        $id                   = $value;
      }
      else if($key == "table"){
        $table                = $value;
      }
      else if($key == "module"){
        $module_name          = $value;
      }
      else if($key == "page"){
        $page_name            = $value;
      }
      else{
        $set_array[$key]      = $value;
      }
    }
    $set_array['edit_user']   = $edit_user;
    $set_array['edit_date']   = date('Y-m-d H:i:s');

    // var_dump($set_array);
    $this->$model->EDIT_TABLE_ROW($table,$id,$set_array);
    $this->session->set_userdata('success', 'Updated Successfully!');
    redirect($module_name . "/" . $page_name);
  }

  
  function add_row(){
    $this->load->helper(array('form', 'url'));
    $data["model_name"]       = $model  = "main_table_02_model";
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    $input_data               = $this->input->get();
    $set_array                = array();
    $file_name                = '';
    foreach($input_data as $key => $value){
      if($key == "table"){
        $table                = $value;
      }
      else if($key == "module"){
        $module_name          = $value;
      }
      else if($key == "page"){
        $page_name            = $value;
      }
      else if($key == "attachment"){
        if($value != ""){
          $file_name          = $edit_user."_".date("Ymdhms")."_".str_replace("C:fakepath","",stripslashes($value));
          $set_array[$key]    = $file_name;
        }
      
        
      }
      else{
        $set_array[$key]      = $value;
      }

      
    }
    $set_array['edit_user']   = $edit_user;
    $set_array['create_date'] = date('Y-m-d H:i:s');
    $set_array['edit_date']   = date('Y-m-d H:i:s');


    $this->$model->ADD_TABLE_ROW($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');

    // $new_file_name = $edit_user."_".date("YmdHis")."_".$_FILES["file"]['name'];
    if(isset($_FILES['file'])){
      $config['upload_path']          = './assets_user/files/'.$module_name."/";
      $config['allowed_types']        = '*';
      $config['file_name']            = $file_name;
      $this->load->library('upload', $config);
      if ( ! $this->upload->do_upload('file'))
      {
              $error = array('error' => $this->upload->display_errors());

              // $this->load->view('upload_form', $error);
              echo FALSE;
      }
      else
      {
              $data = array('upload_data' => $this->upload->data());

              // $this->load->view('upload_success', $data);
              echo TRUE;
      }
    }
    
    redirect($module_name . "/" . $page_name);
  }
  function delete_row(){
    $data["model_name"]       = $model  = "main_table_02_model";
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    $id                       = $this->input->get('delete_id');
    $table                    = $this->input->get('table');
    $module_name              = $this->input->get('module');
    $page_name                = $this->input->get('page');
    
    $edit_date                = date('Y-m-d H:i:s');
    $this->$model->DELETE_TABLE_ROW($id,$table,$edit_user,$edit_date);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status(){
    $data["model_name"]       = $model  = "main_table_02_model";
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    $status                   = $this->input->post('modal_title');
    $ids                      = $this->input->post('list_mark_ids');
    $ids_int                  = array_map('intval', explode(',', $ids));
    $module_name              = $this->input->get('module');
    $page_name                = $this->input->get('page_name');
    $table                    = $this->input->get('table');
    $page                     = $this->input->get('page');
    $row_url                  = '&row=';
    $row                      = $this->input->get('row');
    $tab                      = $this->input->get('tab');
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
    $data["model_name"]       = $model  = "main_table_02_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_csv_views', $data);
    
  }
  function csv_import_file()
	{
		$file_name                = 'csv_import_temp';
    $edit_user                = $this->session->userdata('SESS_USER_ID');
    $table_name               = $this->input->get('table');
    $module_name              = $this->input->get('module');
    $page_name                = $this->input->get('page');
		$path = "assets_user/csv_import_temp/";
		$config['file_name']      = $file_name;
		$config['upload_path']    = "./assets_user/csv_import_temp/";
		$config['allowed_types']  = '*';
		$config['max_size']       = '10000';
		$config['overwrite']      = TRUE;
		$this->load->library('upload', $config);
		if($this->upload->do_upload('file')) 
		{
			$name                   = $_FILES["file"]["name"];
			$ext1                   = explode(".", $name);
			$ext                    = end($ext1);
			$file                   = fopen(($path.$file_name.'.'.$ext),"r");
			$ctr                    = 0;
			$x[$ctr]                = (fgetcsv($file));
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
				while (($filedata     = fgetcsv($file, 10000, ",")) !== FALSE) {
					$myData[]           = $filedata;
					for ($i = 0; $i < count($myData); $i++) {
						$missingColumn    = "";
						if ($myData[$i][0] == '') {
							$missingColumn = "Name";
						}
						$name    = $myData[$i][0];
						if ($missingColumn == "") {
							$queryArr = [
							  "name" => $name
							];
							$isDuplicate      = $this->main_table_02_model->MOD_CHECK_IF_DUPLICATE($queryArr,$table_name);
							if ($isDuplicate == 0) {
								$this->main_table_02_model->MOD_INSERT_POSITIONS($name,$edit_user,$table_name, 'Active');
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
			$error                    =  $this->upload->display_errors();
			$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', $error);
			redirect($module_name.'/'.$page_name); 
		}
	}
}
