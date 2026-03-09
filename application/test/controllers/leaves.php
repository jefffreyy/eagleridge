<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class leaves extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('templates/main_nav_model');
		$this->load->model('modules/attendance_model');
		$this->load->model('templates/main_table_02_model');
		$this->load->model('modules/leaves_model');
		if ($this->session->userdata('SESS_USER_ID') == '') {
			redirect('login/session_expired');
		}
		$maintenance				= $this->login_model->GET_MAINTENANCE();
		$isAdmin 					= $this->session->userdata('SESS_ADMIN');
		if ($maintenance == '1' && $isAdmin != 1) {
		redirect('login/maintenance');
		}
	}

	function index(){
		$data["Modules"]=  array( 
		array("title"=>"Leave Request",        "icon"=>"fa-duotone fa-house-person-leave", 		"url"=>"leaves/leave_lists",     "access"=>"Leave" ,"id"=>"leave_request"),
		array("title"=>"Leave Entitlement",    "icon"=>"fa-duotone fa-sliders",          		"url"=>"leaves/entitlements",    "access"=>"Leave" ,"id"=>"leave_entitlement"),
		array("title"=>"Leave Approval Route", "icon"=>"fa-duotone fa-plane-circle-check",   	"url"=>"leaves/approval_routes", "access"=>"Leave" ,"id"=>"leave_approval_route"),
		//   array("title"=>"Leave Types",          "icon"=>"fas fa-list-ul",          "url"=>"leaves/types",           "access"=>"Leave" ,"id"=>"leave_types"),
		);
		$data["title_page"]							="Leave Module";
		$user_access_id								= $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
		$data['DISP_USER_ACCESS_PAGE']				= $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
		$array_page									= explode(", ",$data['DISP_USER_ACCESS_PAGE']["user_page"]);
		$data['Modules']							= filter_array($data["Modules"],$array_page);
		$this->load->view('templates/header');
		$this->load->view('templates/main_nav',$data);
	}
// Leave list function actions
  function leave_lists(){
    //------------------------------------------------------- START OF DYNAMIC PARAMETERS
	$user 					  = $this->session->userdata('SESS_USER_ID');
	$data["view_type"]        = $view_type    = ['all','edit_user',$user]; //all or user
	$data["module_name"]      = $module       = 'leaves';
	$data["page_name"]        = $page_name    = 'leave_lists';
	$data["model_name"]       = $model        = "main_table_02_model";
	$data["table_name"]       = $table        = "tbl_leaves_assign";
	$data["module"]           = [base_url().$module,"Leaves", "Leave Requests"];         // Main Menu Path, Module, Page Title
	$data["id_prefix"]        = "LEA";
	$data["excel_import"]     = [false];  
	$data["excel_output"]     = [true,"leave_lists.xlsx"];                                                       // Enable, File Name
	$data["add_button"]       = [true,"Add Request"];                                                                 // Enable, Button Name modal_add_enable   = true;
	$data["status_text"]      = ["Approved","Rejected","Pending 1",""];                                                          //Green, Red, Orange, Gray
	$data["C_ROW_DISPLAY"]    = $filter_row = [25,50,100];
	$c_data_tab               = array(
								array("Pending 1","status","Pending 1",0),
								array("Pending 2","status","Pending 2",0),
								array("Pending 3","status","Pending 3",0),
								array("Approved","status","Approved",0),
								array("Rejected","status","Rejected",0)
							);
	$data["C_BULK_BUTTON"]    = array();

							// array(true, "btn_mark_approve","far fa-check-circle","Mark as Approved","status","Approved"),    //visible,id,icon,Button Name,column,status
							// array(true, "btn_mark_rejected","far fa-times-circle","Mark as Rejected","status","Rejected")    //visible,id,icon,Button Name,column,status	
	$data["C_DB_DESIGN"]  =	
	array(
		array("id","Leave ID","id","0",1,5,0,0,0,0,0,1),
		array("create_date","Create Date","datetime","0",0,0,0,0,0,0,0,1),
		array("edit_date","Edit Date","datetime","0",0,0,0,0,0,0,0,1),
		array("edit_user","Last Edited By","user","0",0,0,0,0,0,0,0,1),
		array("is_deleted","Is Deleted","hidden","0",0,0,0,0,0,0,0,0),
		array("assigned_by","Assigned by","user","0",1,10,1,0,0,1,1,1),
		array("empl_id","Employee","user","0",1,10,1,1,0,1,1,1),
		array("type","Type","db-sel","array1",1,15,1,1,1,1,1,1),
		array("leave_date","Leave Date","date","0",1,15,1,1,1,1,1,1),
		array("duration","Leave Duration (Hours)","number","2",1,10,1,1,1,1,1,1),
		array("status","Status","fixed-sel-direct","Pending 1;Pending 2;Pending 3;Approved;Rejected",1,15,1,0,0,1,0,1),
		array("remarks","Remarks","text-area","0",1,0,1,0,1,1,1,1),
		array("attachment","Attachment","attachment","jpg;png;pdf",0,0,1,0,1,1,1,1),

		);

	$C_ARRAY_TABLE_1 = "tbl_std_leavetypes";
	$C_ARRAY_TABLE_2 = "";
	$C_ARRAY_TABLE_3 = "";
	$C_ARRAY_TABLE_4 = "";
	$C_ARRAY_TABLE_5 = "";

	//---------------------------------------------------------- END OF DYNAMIC PARAMETERS - DO NOT EDIT AFTERWARDS
	$search                             		= str_replace('_', ' ', $this->input->get('all') ?? "");
	$data["default_row"]                		= $filter_row[0];
	$data["C_DATA_EMPL_NAME"]           		= $this->$model->GET_EMPL_NAME();
	$data["C_ARRAY_1"]                  		= $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_1);
	$data["C_ARRAY_2"]                 	 		= $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_2);
	$data["C_ARRAY_3"]                  		= $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_3);
	$data["C_ARRAY_4"]                  		= $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_4);
	$data["C_ARRAY_5"]                  		= $this->$model->GET_STD_ID_NAME($C_ARRAY_TABLE_5);

	$page                               		= $this->input->get('page');
	$row                                		= $this->input->get('row');
	$tab                                		= $this->input->get('tab');
	$tab_filter                         		= $this->input->get('tab_filter');

	if($row == null){ $row = $filter_row[0]; }
	if($tab == null){ $tab = $c_data_tab[0][0]; }
	if($tab_filter == null){ $tab_filter = $c_data_tab[0][1]; }
 
	$offset = $row * ($page - 1);
	$data["C_TAB_SELECT"] = $tab;
	
	if($this->input->get('all') == null){
	  $data["C_DATA_TABLE"]               		= $this->$model->get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type);
	  $data["C_DATA_COUNT"]               		= $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
	}else{
	  $data["C_DATA_TABLE"]               		= $this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type); 
	  $data["C_DATA_COUNT"]               		= count($this->$model->get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type)); 
	//   $data["C_DATA_COUNT"]               	= $this->$model->get_data_count($table,$tab,$tab_filter,$view_type);
	}
	$i=0;
	foreach($c_data_tab as $c_data_tab_row){
		$c_data_tab[$i][3]                  	= $this->$model->get_display_count($table,$c_data_tab_row[1],$c_data_tab_row[2],$view_type);
		$i++;
	}
	$data["C_DATA_TAB"]    						= $c_data_tab;
	$this->load->view('templates/header');
// 	$this->load->view('templates/main_table_02_views', $data);
    $this->load->view('modules/leaves/leave_request_views',$data);
	
  }
    function request_leave(){
        $data['LEAVE_TYPES']   					= $this->leaves_model->MOD_DISP_LEAVETYPES();
        $this->load->view('templates/header');
        $this->load->view('modules/leaves/new_leave_request_views',$data);
    }
        function add_new_leave(){
           $input_data                 			= $this->input->post();
            $attachment                 		= $_FILES['attachment']['name'];
            $file_info = pathinfo($attachment);
            $input_data['create_date']  		= date('Y-m-d H:i:s');
            $input_data['edit_date']    		= date('Y-m-d H:i:s');
            $employee                   		= $this->leaves_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
            $input_data['attachment']   		= $attachment ;
        
            if(!empty($attachment)){
                $input_data['attachment']   	= $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d').'.'.$file_info['extension'];
                $config['upload_path']          = './assets_user/files/leaves';
                $config['allowed_types']        = 'pdf|jpg';
                $config['max_size']             = 10000;
                $config['file_name']            = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d');
                $config['overwrite']            = 'TRUE';
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('attachment'))
                {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('ERR', $error['error']);
                    redirect('leaves/request_leave');
                    // var_dump($error);
                    return;
                }
            }
            $res=$this->leaves_model->ADD_LEAVE_REQUEST($input_data);
            if($res){
                $this->session->set_flashdata('SUCC', 'Successfully added new request');
            }
            else{
                $this->session->set_flashdata('ERR', 'Fail to add new request');
                redirect('leaves/request_leave');
                return;
            }
            redirect('leaves/leave_lists');
        }
  
  function insrt_assign_leave(){
	$checkbox_value 		= $this->input->post('leave_class');
	$url_directory 			= $this->input->post('url_directory');
	$assigned_by 			= $this->session->userdata('SESS_USER_ID');
	if($url_directory == 'leave_lists'){
		$url_directory = 'leaves/leave_lists';
	} else if ($url_directory == 'assign_leave'){
		$url_directory = 'leave/assign_leave';
	}
	if($checkbox_value == 'leave_single_day'){
		$employee_id 		= $this->input->post('INSRT_ASSIGN_TO');
		$leave_type 		= $this->input->post('INSRT_LEAVE_TYPE');
		$date 				= $this->input->post('INSRT_LEAVE_DATE');
		$duration 			= $this->input->post('INSRT_LEAVE_DURATION');
		$comment 			= $this->input->post('INSRT_LEAVE_COMMENT');
		$status 			= 'Pending Approval';
		$empl_group 		= 'No Group';
		$empl_name 			= '';
		$empl_info 			= $this->leaves_model->MOD_DISP_EMPLOYEE($employee_id);
		foreach($empl_info as $empl_info_row){
			$empl_group 	= $empl_info_row->col_empl_group;
			$empl_name 		= $empl_info_row->col_frst_name.' '.$empl_info_row->col_last_name;
		}
		// check what leave_type is chosen 
		switch ($leave_type) {
			case 'Vacation Leave':
				$col_leave_type = 'col_leave_vacation';
				break;
			case 'Sick Leave':
				$col_leave_type = 'col_leave_sick';
				break;
			case 'Maternity Leave':
				$col_leave_type = 'col_leave_maternity';
				break;
			case 'Parental Leave':
				$col_leave_type = 'col_leave_parental';
				break;
			case 'Paternity Leave':
				$col_leave_type = 'col_leave_paternal';
				break;
			case 'Service Incentive Leave':
				$col_leave_type = 'col_leave_service_incentive';
				break;
			case 'Solo Incentive Leave':
				$col_leave_type = 'col_leave_solo_incentive';
				break;
			default:
			$col_leave_type = '';
		}
		$leave_balance 						= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
		if($leave_balance[$col_leave_type] >= $duration){
			$approval_route 				= $this->leaves_model->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($employee_id);
			if((!empty($_FILES['INSRT_LEAVE_FILE']) && ($leave_type == "Sick Leave"))){
				// get the attached file
				$get_file_name 				= $_FILES['INSRT_LEAVE_FILE']['name'];
				// set uploading file config
				$config['upload_path'] 		= './assets/files/leave';
				$config['allowed_types'] 	= 'jpg|png|jpeg';
				$config['max_size'] 		= '5000';
				$config['file_name'] 		= $employee_id.$get_file_name;
				$config['overwrite'] 		= 'TRUE';
				$this->load->library('upload', $config);
				if($_FILES['INSRT_LEAVE_FILE']['size'] != 0){
					if ($this->upload->do_upload('INSRT_LEAVE_FILE'))
					{
						// check what leave_type is chosen 
						switch ($leave_type) {
							case 'Vacation Leave':
								$col_leave_type = 'col_leave_vacation';
								break;
							case 'Sick Leave':
								$col_leave_type = 'col_leave_sick';
								break;
							case 'Maternity Leave':
								$col_leave_type = 'col_leave_maternity';
								break;
							case 'Parental Leave':
								$col_leave_type = 'col_leave_parental';
								break;
							case 'Paternity Leave':
								$col_leave_type = 'col_leave_paternal';
								break;
							case 'Service Incentive Leave':
								$col_leave_type = 'col_leave_service_incentive';
								break;
							case 'Solo Incentive Leave':
								$col_leave_type = 'col_leave_solo_incentive';
								break;
							default:
							$col_leave_type = '';
						}
						$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
						// $total_leave_balance = $leave_balance[$col_leave_type] - $duration;
						$total_leave_balance 	= $leave_balance[$col_leave_type];
						$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance,$employee_id);
						//upload the file to the specified path
						$data_upload 			= array('INSRT_LEAVE_FILE' => $this->upload->data());
						$leave_file 			= $data_upload['INSRT_LEAVE_FILE']['file_name'];
						//save the filename of the uploaded file to db
						$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
						foreach($approval_route as $approval_route_row){
							$my_user_id 		= $this->session->userdata('SESS_USER_ID');
							if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)){
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1($status,$leave_insrt_id);
								echo 'approver 1 '.$leave_insrt_id.' <br>';
							}
							if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2($status,$leave_insrt_id);
								echo 'approver 2 '.$leave_insrt_id.' <br>';
							}
							if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)){
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3($status,$leave_insrt_id);
								echo 'approver 3 '.$leave_insrt_id.' <br>';
							}
						}
						$recievers_arr = [];
						$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
						$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
						if(count($get_group_approver)){
							if($get_group_approver[0]->approver1){array_push($recievers_arr,$get_group_approver[0]->approver1);}
							if($get_group_approver[0]->approver2){array_push($recievers_arr,$get_group_approver[0]->approver2);}
						}
						if($get_leave_approver){
							if($get_leave_approver[0]->approver3){array_push($recievers_arr,$get_leave_approver[0]->approver3);}
							if($get_leave_approver[0]->approver4){array_push($recievers_arr,$get_leave_approver[0]->approver4);}
							if($get_leave_approver[0]->approver5){array_push($recievers_arr,$get_leave_approver[0]->approver5);}
							if($get_leave_approver[0]->approver6){array_push($recievers_arr,$get_leave_approver[0]->approver6);}
							if($get_leave_approver[0]->approver7){array_push($recievers_arr,$get_leave_approver[0]->approver7);}
						}
						$appr_type 		= 'Leave';
						$reciever 		= implode(",",$recievers_arr);
						$date_created 	= date('Y-m-d H:i:s');
						$message 		= 'Assigned leave to: ';
						$notif_status 	= 0;
						$requested_by 	= $this->session->userdata('SESS_USER_ID');
						$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id,$empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
						$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by,$message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
						$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE','Leave application assigned successfully!');
						redirect($url_directory);
					}
				} else {
					// check what leave_type is chosen 
					switch ($leave_type) {
						case 'Vacation Leave':
							$col_leave_type = 'col_leave_vacation';
							break;
						case 'Sick Leave':
							$col_leave_type = 'col_leave_sick';
							break;
						case 'Maternity Leave':
							$col_leave_type = 'col_leave_maternity';
							break;
						case 'Parental Leave':
							$col_leave_type = 'col_leave_parental';
							break;
						case 'Paternity Leave':
							$col_leave_type = 'col_leave_paternal';
							break;
						case 'Service Incentive Leave':
							$col_leave_type = 'col_leave_service_incentive';
							break;
						case 'Solo Incentive Leave':
							$col_leave_type = 'col_leave_solo_incentive';
							break;
						default:
						$col_leave_type = '';
					}
					$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
					// $total_leave_balance = $leave_balance[$col_leave_type] - $duration;
					$total_leave_balance 	= $leave_balance[$col_leave_type];
					$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance,$employee_id);
					//upload the file to the specified path
					$leave_file = '';
					//save the filename of the uploaded file to db
					$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
					foreach($approval_route as $approval_route_row){
						$my_user_id		 	= $this->session->userdata('SESS_USER_ID');
						if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)){
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1($status,$leave_insrt_id);
							echo 'approver 1 '.$leave_insrt_id.' <br>';
						}
						if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2($status,$leave_insrt_id);
							echo 'approver 2 '.$leave_insrt_id.' <br>';
						}
						if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)){
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3($status,$leave_insrt_id);
							echo 'approver 3 '.$leave_insrt_id.' <br>';
						}
					}
					$recievers_arr = [];
					$get_group_approver = $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
					$get_leave_approver = $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
					if(count($get_group_approver)){
						if($get_group_approver[0]->approver1){array_push($recievers_arr,$get_group_approver[0]->approver1);}
						if($get_group_approver[0]->approver2){array_push($recievers_arr,$get_group_approver[0]->approver2);}
					}
					if($get_leave_approver){
						if($get_leave_approver[0]->approver3){array_push($recievers_arr,$get_leave_approver[0]->approver3);}
						if($get_leave_approver[0]->approver4){array_push($recievers_arr,$get_leave_approver[0]->approver4);}
						if($get_leave_approver[0]->approver5){array_push($recievers_arr,$get_leave_approver[0]->approver5);}
						if($get_leave_approver[0]->approver6){array_push($recievers_arr,$get_leave_approver[0]->approver6);}
						if($get_leave_approver[0]->approver7){array_push($recievers_arr,$get_leave_approver[0]->approver7);}
					}
					$appr_type 			= 'Leave';
					$reciever 			= implode(",",$recievers_arr);
					$date_created 		= date('Y-m-d H:i:s');
					$message 			= 'Assigned leave to: ';
					$notif_status 		= 0;
					$requested_by 		= $this->session->userdata('SESS_USER_ID');
					$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id,$empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
					$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by,$message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
					$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE','Leave application assigned successfully!');
					redirect($url_directory);
				}
			}else {
				// check what leave_type is chosen 
				switch ($leave_type) {
					case 'Vacation Leave':
						$col_leave_type = 'col_leave_vacation';
						break;
					case 'Sick Leave':
						$col_leave_type = 'col_leave_sick';
						break;
					case 'Maternity Leave':
						$col_leave_type = 'col_leave_maternity';
						break;
					case 'Parental Leave':
						$col_leave_type = 'col_leave_parental';
						break;
					case 'Paternity Leave':
						$col_leave_type = 'col_leave_paternal';
						break;
					case 'Service Incentive Leave':
						$col_leave_type = 'col_leave_service_incentive';
						break;
					case 'Solo Incentive Leave':
						$col_leave_type = 'col_leave_solo_incentive';
						break;
					default:
					$col_leave_type = '';
				}
				$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
				// $total_leave_balance = $leave_balance[$col_leave_type] - $duration;
				$total_leave_balance 	= $leave_balance[$col_leave_type];
				$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance,$employee_id);
				//save the filename of the uploaded file to db
				$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $total_leave_balance);
				foreach($approval_route as $approval_route_row){
					$my_user_id 		= $this->session->userdata('SESS_USER_ID');
					if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)){
						$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval',$leave_insrt_id);
					}
					if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
						$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval',$leave_insrt_id);
					}
					if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)){
						$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval',$leave_insrt_id);
					}
				}
				$recievers_arr 			= [];
				$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
				$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
				if(count($get_group_approver)){
					if($get_group_approver[0]->approver1){array_push($recievers_arr,$get_group_approver[0]->approver1);}
					if($get_group_approver[0]->approver2){array_push($recievers_arr,$get_group_approver[0]->approver2);}
				}
				if($get_leave_approver){
					if($get_leave_approver[0]->approver3){array_push($recievers_arr,$get_leave_approver[0]->approver3);}
					if($get_leave_approver[0]->approver4){array_push($recievers_arr,$get_leave_approver[0]->approver4);}
					if($get_leave_approver[0]->approver5){array_push($recievers_arr,$get_leave_approver[0]->approver5);}
					if($get_leave_approver[0]->approver6){array_push($recievers_arr,$get_leave_approver[0]->approver6);}
					if($get_leave_approver[0]->approver7){array_push($recievers_arr,$get_leave_approver[0]->approver7);}
				}
				$appr_type 				= 'Leave';
				$reciever 				= implode(",",$recievers_arr);
				$date_created 			= date('Y-m-d H:i:s');
				$message 				= 'Assigned leave to: ';
				$notif_status 			= 0;
				$requested_by 			= $this->session->userdata('SESS_USER_ID');
				$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id,$empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
				$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by,$message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
				$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE','Leave application assigned successfully!');
				redirect($url_directory);
			}
		} else {
			$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE', 'Insufficient Leave Balance');
			redirect($url_directory);
		}
	} else if ($checkbox_value == 'leave_multiple_days'){
		$employee_id 					= $this->input->post('INSRT_ASSIGN_TO_MULTIPLE');
		$leave_type 					= $this->input->post('INSRT_LEAVE_TYPE_MULTIPLE');
		$date_from 						= $this->input->post('INSRT_LEAVE_DATE_FROM');
		$date_to 						= $this->input->post('INSRT_LEAVE_DATE_TO');
		$duration 						= $this->input->post('INSRT_LEAVE_DURATION_MULTIPLE');
		$comment 						= $this->input->post('INSRT_LEAVE_COMMENT');
		$status 						= 'Pending Approval';
		$empl_group 					= 'No Group';
		$empl_name 						= '';
		$empl_info 						= $this->leaves_model->MOD_DISP_EMPLOYEE($employee_id);
		foreach($empl_info as $empl_info_row){
			$empl_group = $empl_info_row->col_empl_group;
			$empl_name = $empl_info_row->col_frst_name.' '.$empl_info_row->col_last_name;
		}
		// check what leave_type is chosen 
		switch ($leave_type) {
			case 'Vacation Leave':
				$col_leave_type = 'col_leave_vacation';
				break;
			case 'Sick Leave':
				$col_leave_type = 'col_leave_sick';
				break;
			case 'Maternity Leave':
				$col_leave_type = 'col_leave_maternity';
				break;
			case 'Parental Leave':
				$col_leave_type = 'col_leave_parental';
				break;
			case 'Paternity Leave':
				$col_leave_type = 'col_leave_paternal';
				break;
			case 'Service Incentive Leave':
				$col_leave_type = 'col_leave_service_incentive';
				break;
			case 'Solo Incentive Leave':
				$col_leave_type = 'col_leave_solo_incentive';
				break;
			default:
			$col_leave_type = '';
		}
		$leave_balance 						= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
		if($leave_balance[$col_leave_type] >= $duration){
			$approval_route 				= $this->leaves_model->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($employee_id);
			if((!empty($_FILES['INSRT_LEAVE_FILE']) && ($leave_type == "Sick Leave"))){
				// get the attached file
				$get_file_name 				= $_FILES['INSRT_LEAVE_FILE']['name'];
				// set uploading file config
				$config['upload_path'] 		= './assets/files/leave';
				$config['allowed_types'] 	= 'jpg|png|jpeg';
				$config['max_size'] 		= '5000';
				$config['file_name'] 		= $employee_id.$get_file_name;
				$config['overwrite'] 		= 'TRUE';
				$this->load->library('upload', $config);
				if($_FILES['INSRT_LEAVE_FILE']['size'] != 0){
					if ($this->upload->do_upload('INSRT_LEAVE_FILE'))
					{
						// check what leave_type is chosen 
						switch ($leave_type) {
							case 'Vacation Leave':
								$col_leave_type = 'col_leave_vacation';
								break;
							case 'Sick Leave':
								$col_leave_type = 'col_leave_sick';
								break;
							case 'Maternity Leave':
								$col_leave_type = 'col_leave_maternity';
								break;
							case 'Parental Leave':
								$col_leave_type = 'col_leave_parental';
								break;
							case 'Paternity Leave':
								$col_leave_type = 'col_leave_paternal';
								break;
							case 'Service Incentive Leave':
								$col_leave_type = 'col_leave_service_incentive';
								break;
							case 'Solo Incentive Leave':
								$col_leave_type = 'col_leave_solo_incentive';
								break;
							default:
							$col_leave_type = '';
						}
						//upload the file to the specified path
						$data_upload 				= array('INSRT_LEAVE_FILE' => $this->upload->data());
						$leave_file 				= $data_upload['INSRT_LEAVE_FILE']['file_name'];
						$leave_balance 				= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
						// $total_leave_balance = $leave_balance[$col_leave_type] - $duration;
						$total_leave_balance 		= $leave_balance[$col_leave_type];
						$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance,$employee_id);
						if($date_from != $date_to){
							//save the filename of the uploaded file to db
							$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
							foreach($approval_route as $approval_route_row){
								$my_user_id 		= $this->session->userdata('SESS_USER_ID');
								if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)){
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval',$leave_insrt_id);
								}
								if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval',$leave_insrt_id);
								}
								if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)){
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval',$leave_insrt_id);
								}
							}
							$recievers_arr 			= [];
							$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
							$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
							if(count($get_group_approver)){
								if($get_group_approver[0]->approver1){array_push($recievers_arr,$get_group_approver[0]->approver1);}
								if($get_group_approver[0]->approver2){array_push($recievers_arr,$get_group_approver[0]->approver2);}
							}
							if($get_leave_approver){
								if($get_leave_approver[0]->approver3){array_push($recievers_arr,$get_leave_approver[0]->approver3);}
								if($get_leave_approver[0]->approver4){array_push($recievers_arr,$get_leave_approver[0]->approver4);}
								if($get_leave_approver[0]->approver5){array_push($recievers_arr,$get_leave_approver[0]->approver5);}
								if($get_leave_approver[0]->approver6){array_push($recievers_arr,$get_leave_approver[0]->approver6);}
								if($get_leave_approver[0]->approver7){array_push($recievers_arr,$get_leave_approver[0]->approver7);}
							}
							$appr_type 				= 'Leave';
							$reciever 				= implode(",",$recievers_arr);
							$date_created 			= date('Y-m-d H:i:s');
							$message 				= 'Assigned leave to: ';
							$notif_status 			= 0;
							$requested_by 			= $this->session->userdata('SESS_USER_ID');
							$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id,$empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
							$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by,$message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
							$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE','Leave application assigned successfully!');
							redirect($url_directory);
						} else {
							$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE',"You've entered the same date. Please use single entry.");
							redirect($url_directory);
						}
					}
				} else {
					if ($this->upload->do_upload('INSRT_LEAVE_FILE'))
					{
						// check what leave_type is chosen 
						switch ($leave_type) {
							case 'Vacation Leave':
								$col_leave_type = 'col_leave_vacation';
								break;
							case 'Sick Leave':
								$col_leave_type = 'col_leave_sick';
								break;
							case 'Maternity Leave':
								$col_leave_type = 'col_leave_maternity';
								break;
							case 'Parental Leave':
								$col_leave_type = 'col_leave_parental';
								break;
							case 'Paternity Leave':
								$col_leave_type = 'col_leave_paternal';
								break;
							case 'Service Incentive Leave':
								$col_leave_type = 'col_leave_service_incentive';
								break;
							case 'Solo Incentive Leave':
								$col_leave_type = 'col_leave_solo_incentive';
								break;
							default:
							$col_leave_type = '';
						}
						//upload the file to the specified path
						$leave_file = '';
						$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
						// $total_leave_balance = $leave_balance[$col_leave_type] - $duration;
						$total_leave_balance = $leave_balance[$col_leave_type];
						$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance,$employee_id);
						if($date_from != $date_to){
							//save the filename of the uploaded file to db
							$leave_insrt_id 	= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
							foreach($approval_route as $approval_route_row){
								$my_user_id 	= $this->session->userdata('SESS_USER_ID');
								if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)){
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval',$leave_insrt_id);
								}
								if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval',$leave_insrt_id);
								}
								if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)){
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval',$leave_insrt_id);
								}
							}
							$recievers_arr = [];
							$get_group_approver = $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
							$get_leave_approver = $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
							if(count($get_group_approver)){
								if($get_group_approver[0]->approver1){array_push($recievers_arr,$get_group_approver[0]->approver1);}
								if($get_group_approver[0]->approver2){array_push($recievers_arr,$get_group_approver[0]->approver2);}
							}
							if($get_leave_approver){
								if($get_leave_approver[0]->approver3){array_push($recievers_arr,$get_leave_approver[0]->approver3);}
								if($get_leave_approver[0]->approver4){array_push($recievers_arr,$get_leave_approver[0]->approver4);}
								if($get_leave_approver[0]->approver5){array_push($recievers_arr,$get_leave_approver[0]->approver5);}
								if($get_leave_approver[0]->approver6){array_push($recievers_arr,$get_leave_approver[0]->approver6);}
								if($get_leave_approver[0]->approver7){array_push($recievers_arr,$get_leave_approver[0]->approver7);}
							}
							$appr_type				= 'Leave';
							$reciever 				= implode(",",$recievers_arr);
							$date_created 			= date('Y-m-d H:i:s');
							$message 				= 'Assigned leave to: ';
							$notif_status 			= 0;
							$requested_by 			= $this->session->userdata('SESS_USER_ID');
							$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id,$empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
							$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by,$message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
							$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE','Leave application assigned successfully!');
							redirect($url_directory);
						} else {
							$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE',"You've entered the same date. Please use single entry.");
							redirect($url_directory);
						}
					}
				}
			}else {
				// check what leave_type is chosen 
				switch ($leave_type) {
					case 'Vacation Leave':
						$col_leave_type = 'col_leave_vacation';
						break;
					case 'Sick Leave':
						$col_leave_type = 'col_leave_sick';
						break;
					case 'Maternity Leave':
						$col_leave_type = 'col_leave_maternity';
						break;
					case 'Parental Leave':
						$col_leave_type = 'col_leave_parental';
						break;
					case 'Paternity Leave':
						$col_leave_type = 'col_leave_paternal';
						break;
					case 'Service Incentive Leave':
						$col_leave_type = 'col_leave_service_incentive';
						break;
					case 'Solo Incentive Leave':
						$col_leave_type = 'col_leave_solo_incentive';
						break;
					default:
					$col_leave_type = '';
				}
				$leave_balance 				= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type,$employee_id);
				// $total_leave_balance = $leave_balance[$col_leave_type] - $duration;
				$total_leave_balance 		= $leave_balance[$col_leave_type];
				$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance,$employee_id);
				if($date_from != $date_to){
					//save the filename of the uploaded file to db
					$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $total_leave_balance);
					foreach($approval_route as $approval_route_row){
						$my_user_id 		= $this->session->userdata('SESS_USER_ID');
						if(($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)){
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval',$leave_insrt_id);
						}
						if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)){
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval',$leave_insrt_id);
						}
						if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)){
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval',$leave_insrt_id);
						}
					}
					$recievers_arr 			= [];
					$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
					$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
					if(count($get_group_approver)){
						if($get_group_approver[0]->approver1){array_push($recievers_arr,$get_group_approver[0]->approver1);}
						if($get_group_approver[0]->approver2){array_push($recievers_arr,$get_group_approver[0]->approver2);}
					}
					if($get_leave_approver){
						if($get_leave_approver[0]->approver3){array_push($recievers_arr,$get_leave_approver[0]->approver3);}
						if($get_leave_approver[0]->approver4){array_push($recievers_arr,$get_leave_approver[0]->approver4);}
						if($get_leave_approver[0]->approver5){array_push($recievers_arr,$get_leave_approver[0]->approver5);}
						if($get_leave_approver[0]->approver6){array_push($recievers_arr,$get_leave_approver[0]->approver6);}
						if($get_leave_approver[0]->approver7){array_push($recievers_arr,$get_leave_approver[0]->approver7);}
					}
					$appr_type 					= 'Leave';
					$reciever 					= implode(",",$recievers_arr);
					$date_created 				= date('Y-m-d H:i:s');
					$message 					= 'Assigned leave to: ';
					$notif_status 				= 0;
					$requested_by 				= $this->session->userdata('SESS_USER_ID');
					$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id,$empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
					$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by,$message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
					$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE','Leave application submitted successfully!');
					redirect($url_directory);
				} else {
					$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE', "You've entered the same date. Please use single entry.");
					redirect($url_directory);
				}
			}
		} else {
			$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE', 'Insufficient Leave Balance');
			redirect($url_directory);
		}
	}
	}
	function updt_leave_details(){
		// $old_leave_reason = $this->input->post('input_leave_reason');
		// $old_leave_duration = $this->input->post('input_leave_duration');
		// $leave_reason = $this->input->post('leave_reason');
		// $leave_duration = $this->input->post('leave_duration');
		$date_requested 			= $this->input->post('leave_date_requested');
		$date_leave 				= $this->input->post('leave_on_date');
		$type 						= $this->input->post('leave_type');
		$leave_reason 				= $this->input->post('edit_leave_reason');
		$duration 					= $this->input->post('edit_leave_duration');
		$status 					= $this->input->post('leave_status');
		$row_id 					= $this->input->post('row_id');
		$this->leaves_model->MOD_UPDT_LEAVE_DETAILS($date_requested, $date_leave, $type, $leave_reason, $duration, $status, $row_id);
		$this->session->set_userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE', 'Updated Successfully');
		redirect('leaves/leave_lists');
	}
// entitlement functions actions
function entitlements(){
	$search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

 	if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
    if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
    if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
    if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
    if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
    if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
    if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
    if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}

    if (!isset($_GET["employee"])) {
      $_GET["employee"] = "";
      
    }
	$data["C_ROW_DISPLAY"]                   	=  [25,50,100];
	$page 										= $this->input->get('page');
    $row  										= $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if($page  == null){
      $page = 1;
    }
    $offset = $row * ($page - 1);

	if($this->input->get('all') == null){
		$data['DISP_EMP_LIST']            		= $empl_list = $this->leaves_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
		$data['C_DATA_COUNT']             		= $this->leaves_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
	}else{
		$data['DISP_EMP_LIST']            		= $this->leaves_model->GET_SEARCHED($search);
		$data['C_DATA_COUNT']            		= count($this->leaves_model->GET_SEARCHED($search));
	}
    



    $data['DISP_PAYROLL_SCHED']       			= $payroll_list = $this->attendance_model->MOD_DISP_PAY_SCHED();
	$data['DISP_YEARS']        		  			= $year_list = $this->leaves_model->GET_YEARS();
	

	if (!isset($_GET["year"])) {
		$year = $year_list[0]->id;
	} else {
		$year = $_GET["year"];
	}


    if (!isset($_GET["period"])) {
      $period = $payroll_list[0]->id;
    } else {	
      $period = $_GET["period"];
    }
    // $data['EMPL_INITIAL']             = $empl_list[0];
    $data['PERIOD_INITIAL']           			= $period;
	$data['YEAR_INITIAL']           			= $year;
    $res_data                         			= $this->get_employee_data();
    $data['DISP_CUTOFF']              			= $res_data['cutoff_data'];
    $data['DISP_WORK_SHIFT_DATA']     			= $this->attendance_model->get_work_shift_data();

    $data['DISP_DISTINCT_BRANCH']     			= $this->leaves_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT'] 			= $this->leaves_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION']   			= $this->leaves_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION']    			= $this->leaves_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP']      			= $this->leaves_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM']       			= $this->leaves_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE']       			= $this->leaves_model->MOD_DISP_DISTINCT_LINE();    

    $data['DISP_VIEW_BRANCH']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']     			= $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']          			= $this->leaves_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_line");
    

    // $work_shifts                      = $this->attendance_model->get_work_shift_assign($data['DISP_EMP_LIST'][0]->id);
    if(!empty($DISP_EMP_LIST)){
      $data['DISP_USER_ID']             		= $data['DISP_EMP_LIST'][0]->id;
    }
    else{
      $data['DISP_USER_ID']             		= 0;
    }

    $date_period = $this->attendance_model->get_period_data($period);

    // if (!empty($_GET["employee"])) {
    //   $work_shifts = $this->attendance_model->get_work_shift_assign($this->input->get('employee'));
    //   $data['DISP_USER_ID'] = $this->input->get('employee');
    // }

    $begin 								= new DateTime($date_period['date_from']);
    $end 								= new DateTime($date_period['date_to']);
    $end 								= $end->modify('+1 day');
    $holidays 							= $this->attendance_model->get_holiday();
    $interval 							= new DateInterval('P1D');
    $daterange 							= new DatePeriod($begin, $interval, $end);
    
    $data['SHIFT_DATA_DATERANGE']     	= $this->attendance_model->GET_SHIFT_DATA_DATERANGE($date_period['date_from'],$date_period['date_to']);
    $data['DATE_FROM']                	= $date_period['date_from'];
    $data['DATE_TO']                  	= $date_period['date_to'];
    $data['SHIFT_DATA']               	= $this->attendance_model->GET_SHIFT_ALL_DATA();
    // var_dump($data['SHIFT_DATA_DATERANGE'] );
    $data["DATE_RANGE"] 			  	= $this->assign_shift_data($daterange, $holidays);
	$data["DISP_LEAVE_TYPES"] 		  	= $this->leaves_model->MOD_DISP_LEAVETYPES();

	$data["DISP_ENTITLEMENT"]		  	= $this->leaves_model->GET_ENTITLEMENT_DATA($year);

    $this->load->view('templates/header');
    $this->load->view('modules/leaves/leave_entitlement_views', $data);
    
}

function process_assigning($user_id, $entitlement_val, $year,$type)
{
  $response 							= $this->leaves_model->IS_DUPLICATE($user_id, $year,$type);

  if ($response == 0) {
	$this->leaves_model->ADD_USER_ENTITLEMENT($user_id, $entitlement_val, $year,$type);
	
  } else {
	$this->leaves_model->UPDATE_USER_ENTITLEMENT($user_id, $entitlement_val, $year,$type);

  }

  $this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
  if (isset($_SERVER["HTTP_REFERER"])) {
	redirect($_SERVER["HTTP_REFERER"]);
  }

}

function update_leave_entitlement(){
	$empl_id 						= $this->input->post('UPDATE_ID');
    $entitlement_val 				= $this->input->post('UPDT_ENTITLEMENT_VAL');
	$type 							= $this->input->post('UPDT_ENTITLEMENT_TYPE');
	$year 							= $this->input->post('YEAR');
	var_dump($empl_id.' id<br>');
	var_dump($entitlement_val.' val<br>');
	var_dump($type.' type<br>');
	var_dump($year.' year<br>');

	$empl_ids 						= explode(",",$empl_id);

		foreach($empl_ids as $id){
			
			$result 				= $this->leaves_model->IS_DUPLICATE($id, $year, $type);
			
			if($result == 0){
				$this->leaves_model->ADD_USER_ENTITLEMENT($id, $entitlement_val, $year,$type);
			}else{
				$this->leaves_model->UPDATE_USER_ENTITLEMENT($id, $entitlement_val, $year,$type);
			}
		
		}

	$this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
	if (isset($_SERVER["HTTP_REFERER"])) {
		redirect($_SERVER["HTTP_REFERER"]);
	}
		
	// redirect('leaves/entitlements');
}


function assign_shift_data($dates, $holidays)
  {
    $data_arr 				= array();
    $index 					= 0;
    foreach ($dates as $date) {
      $data_arr[$index]["Date"] = $date;
      $is_found 			= FALSE;
      $is_match 			= FALSE;
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $date->format("Y-m-d")) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $data_arr[$index]["holi_type"] = "LEGAL";
          } else {
            $data_arr[$index]["holi_type"] = "SPECIAL";
          }
          $is_found 		= TRUE;
          break;
        }
      }
      // foreach ($shifts as $shift) {
      //   if ($shift->date == $date->format("Y-m-d")) {
      //     $data_arr[$index]["shift"] = $shift->shift_id;
      //     $is_match = TRUE;
      //     break;
      //   }
      // }
      // if (!$is_match) {
      //   $data_arr[$index]["shift"] = "";
      // }
      if (!$is_found) {
        $data_arr[$index]["holi_type"] = "REGULAR";
      }
      $index += 1;
    }
    return $data_arr;
  }
function get_employee_data()
{
  $employee_id 						= $this->input->get('employee');
  $date_period 						= $this->attendance_model->get_period_data($this->input->get('period')); // $this->input->get('period');
  if (empty($date_period)) {
	$data['employee_data'] 			= array();
	$data['cutoff_data'] 			= array();
	return $data;
  }
  // $split_date = explode(" - ", $date_period);
  // $date1 = $split_date[0];
  // $date2 = $split_date[1];
  $start_date 						= $date_period['date_from'];
  $end_date 						=  $date_period['date_to'];
  $data['employee_data'] 			= $this->attendance_model->MOD_DISP_EMPLOYEE($employee_id);
  $data['cutoff_data'] 				= $this->attendance_model->MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id);
  return $data;
}

	function insrt_entitlement(){
		$assigned_by 					= $this->input->post('INSRT_ASSIGNED_BY');
		$employee_id 					= $this->input->post('INSRT_ASSIGN_EMPL');
		$leave_type 					= $this->input->post('INSRT_LEAVE_TYPE');
		$value 							= $this->input->post('INSRT_LEAVE_VALUE');
		$comment 						= $this->input->post('INSRT_LEAVE_COMMENT');
		$date = date('Y-m-d');
		switch ($leave_type) {
			case 'Vacation Leave':
				$db_leave_type = 'col_leave_vacation';
				break;
			case 'Sick Leave':
				$db_leave_type = 'col_leave_sick';
				break;
			case 'Maternity Leave':
				$db_leave_type = 'col_leave_maternity';
				break;
			case 'Parental Leave':
				$db_leave_type = 'col_leave_parental';
				break;
			case 'Paternity Leave':
				$db_leave_type = 'col_leave_paternal';
				break;
			case 'Service Incentive Leave':
				$db_leave_type = 'col_leave_service_incentive';
				break;
			case 'Solo Incentive Leave':
				$db_leave_type = 'col_leave_solo_incentive';
				break;
			default:
			$db_leave_type = '';
		}
		$leave_balance 					= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($db_leave_type,$employee_id);
		$total_leave_balance 			= $leave_balance[$db_leave_type] + $value;
		$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($db_leave_type, $total_leave_balance, $employee_id);
		$this->leaves_model->MOD_INSRT_ENTITLEMENT($date, $leave_type, $comment, $assigned_by, $employee_id, $value, $total_leave_balance);
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ENTITLEMENT','Leave balance added successfully!');
		redirect('leaves/entitlements');
	}
//   approcal routes function actions
	function approval_routes(){
		$search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
		if (!isset($_GET["branch"]))    { $param_branch   = "all"; }  else{$param_branch    = $_GET["branch"];}
		if (!isset($_GET["dept"]))      { $param_dept     = "all"; }  else{$param_dept      = $_GET["dept"];}
		if (!isset($_GET["division"]))  { $param_division = "all"; }  else{$param_division  = $_GET["division"];}
		if (!isset($_GET["section"]))   { $param_section  = "all"; }  else{$param_section   = $_GET["section"];}
		if (!isset($_GET["group"]))     { $param_group    = "all"; }  else{$param_group     = $_GET["group"];}
		if (!isset($_GET["team"]))      { $param_team     = "all"; }  else{$param_team      = $_GET["team"];}
		if (!isset($_GET["line"]))      { $param_line     = "all"; }  else{$param_line      = $_GET["line"];}
		if (!isset($_GET["status"]))    { $param_status   = "all"; }  else{$param_status    = $_GET["status"];}

		$data["C_ROW_DISPLAY"]                   =  [25,50,100];
		$page 									 = $this->input->get('page');
		$row  									 = $this->input->get('row');
		if ($row == null) {
		$row = 25;
		}
		if($page  == null){
		$page = 1;
		}
		$offset = $row * ($page - 1);

		// if($this->input->get('all') == null){
		// 	$data['DISP_EMPLOYEES'] 		= $this->leaves_model->MOD_DISP_FILTER_EMPLOYEES($dept,$sec,$group,$line,$status);
		// }else{
		// 	$data['DISP_EMPLOYEES'] 		= $this->leaves_model->MOD_GET_SEARCHED($search);
		// }
		// $data['DISP_REQUEST']			= $this->request();

		$data['DISP_EMPLOYEES_NONFILTERED']    		= $leave_approvers          = $this->leaves_model->GET_EMPLOYEELIST();
		if($this->input->get('all') == null){
			$data['DISP_EMPLOYEES']    				= $leave_approvers           = $this->leaves_model->GET_FILTERED_EMPLOYEELIST($offset,$row,$param_branch,$param_dept,$param_division,$param_section,$param_group,$param_team,$param_line);
			$data['C_DATA_COUNT']             		= $this->leaves_model->GET_COUNT_EMPLOYEELIST();
		}else{
			$data['DISP_EMPLOYEES']                 = $leave_approvers = $this->leaves_model->GET_SEARCHED($search);
			$data['C_DATA_COUNT']                   = count($this->leaves_model->GET_SEARCHED($search));
		}

		$C_APPROVERS = array();
		// $leave_approvers              	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE();
    	$approval_list                				= $this->leaves_model->MOD_DISP_APPR_ROUT_LIST();

		$i = 0;
    	foreach ($leave_approvers as $leave_approvers_ROW) { 
			$C_APPROVERS[$i]["id"]         = $leave_approvers_ROW->id;
			$C_APPROVERS[$i]["approver1A"] = "N/A";
			$C_APPROVERS[$i]["approver1B"] = "N/A";
			$C_APPROVERS[$i]["approver2A"] = "N/A";
			$C_APPROVERS[$i]["approver2B"] = "N/A";
			$C_APPROVERS[$i]["approver3A"] = "N/A";
			$C_APPROVERS[$i]["approver3B"] = "N/A";

			foreach ($approval_list as $approval_list_ROW) { 
				if($leave_approvers_ROW->id == $approval_list_ROW->empl_id){
				$C_APPROVERS[$i]["approver1A"] = $approval_list_ROW->approver_1a;
				$C_APPROVERS[$i]["approver1B"] = $approval_list_ROW->approver_1b;
				$C_APPROVERS[$i]["approver2A"] = $approval_list_ROW->approver_2a;
				$C_APPROVERS[$i]["approver2B"] = $approval_list_ROW->approver_2b;
				$C_APPROVERS[$i]["approver3A"] = $approval_list_ROW->approver_3a;
				$C_APPROVERS[$i]["approver3B"] = $approval_list_ROW->approver_3b;
				}
			}
			$i++;
    	}


		$data['DISP_APPROVER'] 				=  $C_APPROVERS;
		// $data['DISP_ALL_EMPL'] 			   = $this->leaves_model->MOD_DISP_ALL_EMPL();
		// $data['C_DEPARTMENTS']              = $this->leaves_model->GET_DEPARTMENTS();
		// $data['C_SECTIONS']                 = $this->leaves_model->GET_SECTIONS();
		// $data['C_GROUPS']                   = $this->leaves_model->GET_GROUPS();
        // $data['C_LINES']                    = $this->leaves_model->GET_LINES();
        // echo "<pre>";
        //  var_dump($data['DISP_APPROVER']);
        // return;
		$data['DISP_DISTINCT_BRANCH']     = $this->leaves_model->MOD_DISP_DISTINCT_BRANCH();
		$data['DISP_DISTINCT_DEPARTMENT'] = $this->leaves_model->MOD_DISP_DISTINCT_DEPARTMENT();
		$data['DISP_DISTINCT_DIVISION']   = $this->leaves_model->MOD_DISP_DISTINCT_DIVISION();
		$data['DISP_DISTINCT_SECTION']    = $this->leaves_model->MOD_DISP_DISTINCT_SECTION();
		$data['DISP_DISTINCT_GROUP']      = $this->leaves_model->MOD_DISP_DISTINCT_GROUP();
		$data['DISP_DISTINCT_TEAM']       = $this->leaves_model->MOD_DISP_DISTINCT_TEAM();
		$data['DISP_DISTINCT_LINE']       = $this->leaves_model->MOD_DISP_DISTINCT_LINE();  

		$data['DISP_VIEW_BRANCH']         = $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DIVISION']       = $this->leaves_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_TEAM']           = $this->leaves_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_DEPARTMENT']     = $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_SECTION']        = $this->leaves_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          = $this->leaves_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_LINE']           = $this->leaves_model->GET_SYSTEM_SETTING("com_line");

		$this->load->view('templates/header');
		$this->load->view('modules/leaves/route_leave_views',$data);
		
	}

	function request(){
		$search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
		$dept                               = $this->input->get('dept');
        $sec                                = $this->input->get('sec');
        $group                              = $this->input->get('group');
        $line                               = $this->input->get('line');
        $status                             = $this->input->get('status');

		if($this->input->get('all') == null){
			$employees 						= $this->leaves_model->MOD_DISP_FILTER_EMPLOYEES($dept,$sec,$group,$line,$status);
		}else{
			$employees  					= $this->leaves_model->MOD_GET_SEARCHED($search);
		}
		
		$requests 							= $this->leaves_model->MOD_DSIP_ALL_REQUEST_FOR_APPROVAL();

		$empl_request = [];
		foreach($requests as $request){
			foreach($employees as $empl){
				if($empl->id == $request->employee_id){
					array_push($empl_request, $request);
				}
			}
		}
		return $empl_request;
	}

	function empl_id_edit($id){
		$data['DISP_EMPLOYEES_ID'] 		= $this->leaves_model->MOD_DISP_EMPLOYEES_ID($id);
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/empl_id_edit_views',$data);
		
	}
	function update_empl_id(){
		$user_id 						= $this->input->post('USER_ID');
		$empl_id 						= $this->input->post('UPDATE_EMPL_ID');
		$this->leaves_model->UPDATE_EMPL_ID($empl_id, $user_id);
		redirect('leaves/approval_routes');
	}

	function assign_approvers_leave(){
		$date = date("Y-m-d H:i:s");
		$empl_id 	= $this->input->post('EMPLOYEE_ID');
		$approver1a = $this->input->post('UPDT_APPROVER_1A');
		$approver1b = $this->input->post('UPDT_APPROVER_1B');
		$approver2a = $this->input->post('UPDT_APPROVER_2A');
		$approver2b = $this->input->post('UPDT_APPROVER_2B');
		$approver3a = $this->input->post('UPDT_APPROVER_3A');
		$approver3b = $this->input->post('UPDT_APPROVER_3B');

		$empl_ids = explode(",",$empl_id);

		foreach($empl_ids as $id){
			
	
			$result = $this->leaves_model->GET_LEAVE_APPROVER($id);
			
			if($result){
				$this->leaves_model->MOD_UPDT_APPROVAL_ROUTE_LEAVE($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b,$id);
			}else{
				
				$this->leaves_model->MOD_INSERT_LEAVE_APPROVER($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b,$id);
			}
		
		}
	
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Updated Successfully!");

		if (isset($_SERVER["HTTP_REFERER"])) {
			redirect($_SERVER["HTTP_REFERER"]);
		}
		// redirect('leaves/approval_routes');
	}

	function add_approval(){
		$data['DISP_EMPLOYEES']              = $this->leaves_model->MOD_DISP_ALL_EMPL();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/add_leave_approval_views',$data);
		
	}
	  
	function add_approval_data(){
        $emp_id 							= $this->input->post('insrt_name');
        $app1a 								= $this->input->post('insrt_approver_1a');
        $app1b 								= $this->input->post('insrt_approver_1b');
        $app2a 								= $this->input->post('insrt_approver_2a');
        $app2b 								= $this->input->post('insrt_approver_2b');
        $app3a 								= $this->input->post('insrt_approver_3a');
        $app3b 								= $this->input->post('insrt_approver_3b');

        $this->leaves_model->MOD_INSERT_APPROVER_DATA($emp_id,$app1a,$app1b,$app2a,$app2b,$app3a,$app3b);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Added Successfully!");
        redirect('leaves/approval_routes');
    }

	function csv_import(){
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_approval_csv_import_views');
		
	}

	function leave_approval_csv_process(){
		$handle   							= fopen($_FILES['file']['tmp_name'], "r");
    	$headers  							= fgetcsv($handle, 1000, ",");

		if(count($headers)!=7){
		$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV',"Incomplete Headers");
		redirect('leaves/csv_import');
		return;
		}
    
		if($headers[0]!='Employee_id'||$headers[1]!='approver_1a'||$headers[2]!='approver_1b'|| 
		$headers[3]!='approver_2a'||$headers[4]!='approver_2b'||$headers[5]!='approver_3a'||$headers[6]!='approver_3b'){

			$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV',"Wrong Header Name");
			redirect('leaves/csv_import');
			return;
		}

    	$emp = $this->leaves_model->GET_ALL_EMP();

		$arr_data     = array();

		function convert_id($array ,$data){
		$empl_id = "";
		foreach($array as $row){
			if($row->col_empl_cmid == $data ){
			$empl_id = $row->id;
			}
		}
		return $empl_id;
		}

		

		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
			
			$arr_data[$headers[0]] = convert_id($emp,$data[0]);
			$arr_data[$headers[1]] = convert_id($emp,$data[1]);
			$arr_data[$headers[2]] = convert_id($emp,$data[2]);
			$arr_data[$headers[3]] = convert_id($emp,$data[3]);
			$arr_data[$headers[4]] = convert_id($emp,$data[4]);
			$arr_data[$headers[5]] = convert_id($emp,$data[5]);
			$arr_data[$headers[6]] = convert_id($emp,$data[6]);

			$IS_DUPLICATE = $this->leaves_model->GET_LEAVE_APPROVER(convert_id($emp,$data[0]));

			if($IS_DUPLICATE){
				$this->leaves_model->UPDATE_APPROVAL_CSV($arr_data);
			}else{
				$this->leaves_model->INSERT_APPROVAL_CSV($arr_data);
			}
		  
		}
		
		fclose($handle);
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV','Successfully uploaded data');
		redirect('leaves/approval_routes');
	}

// Types function actions
function types(){
	$data['DISP_LEAVETYPES_INFO'] = $this->leaves_model->MOD_DISP_LEAVETYPES();
	$this->load->view('templates/header');
	$this->load->view('modules/leaves/leave_type_views',$data);
	
}
// Other functions
// GET LEAVE BALANCE
function get_empl_leave_data(){
	$empl_id = $this->input->post('empl_id');
	$data = $this->leaves_model->MOD_DISP_EMPL_LEAVE_DATA($empl_id);
	echo(json_encode($data));
}
 
}
function filter_array($user_modules,$user_access){
  $modules=array();
  foreach($user_modules as $module){
    foreach($user_access as $access){
      if($module["title"]== $access){
          $modules[]=$module;
      }
    }
  }
  return $modules;
}