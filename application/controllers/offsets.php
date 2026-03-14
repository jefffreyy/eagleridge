<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class offsets extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('templates/main_nav_model');
		$this->load->model('templates/main_table_02_model');
		$this->load->model('modules/offsets_model');
		$this->load->library('system_functions');
		$this->load->library('logger');

		// auto login starts
		$this->load->model('admin_model');
		$auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
		if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
			$this->session->set_userdata('SESS_USER_ID', 1);
		}
		// auto login ends

		if ($this->session->userdata('SESS_USER_ID') == '') {
			redirect('login/session_expired');
		}

		$maintenance				= $this->login_model->GET_MAINTENANCE();
		$isAdmin 					= $this->session->userdata('SESS_ADMIN');
		if ($maintenance == '1' && $isAdmin != 1) {
			redirect('login/maintenance');
		}
	}

	function index()
	{

		$data["Modules"] =  array(
			array("title" => "Offset Request",        "icon" => "house-person-leave-duotone.svg", 		"url" => "offsets/offset_lists",     "access" => "Leave", "id" => "offset_request"),
			array("title" => "Offset Entitlement",    "icon" => "sliders-duotone.svg",          		"url" => "offsets/entitlements",    "access" => "Leave", "id" => "offset_entitlement"),
		);
		$data["title_page"]							= "Offset Module";
		$user_access_id								= $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
		$data['DISP_USER_ACCESS_PAGE']				= $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
		$array_page									= explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);

		$data['Modules']							= filter_array($data["Modules"], $array_page);
		$data["maiya_theme"]                        = $this->offsets_model->GET_MAYA_THEME();
		$this->load->view('templates/header');
		$this->load->view('templates/main_container', $data);
	}

	function offset_lists()
	{
		$data['OFFSETS']             				= array();
		$status                     				= $this->input->get('status');
		$limit                      				= $this->input->get('row') ? $this->input->get('row')  : 25;
		$page                      					= $this->input->get('page') ? $this->input->get('page') : 1;
		$offset                     				=  $limit * ($page - 1);
		$search                     				= $this->input->get('search');

		$filter_arr                 				= array();
		$filter_arr['company']      				= $this->input->get('company');
		$filter_arr['branch']      					= $this->input->get('branch');
		$filter_arr['dept']         				= $this->input->get('dept');
		$filter_arr['div']          				= $this->input->get('div');
		$filter_arr['section']      				= $this->input->get('section');
		$filter_arr['group']       					= $this->input->get('group');
		$filter_arr['team']        					= $this->input->get('team');
		$filter_arr['line']        					= $this->input->get('line');

		// echo "<pre>";
    // echo "filter_arr";
    // echo "<br>";
    // print_r($filter_arr);
    // echo "<pre>"; die(); 

		$data['STATUS']         					= $status;
		$data['STATUSES'] 							= array('Pending', 'Withdrawed', 'Approved', 'Rejected');
		$data['OFFSETS']         					= $this->offsets_model->GET_OFFSETS($status, $search, $limit, $offset, $filter_arr);
		$total_count 								= $this->offsets_model->GET_OFFSETS_COUNT($search, $status, $filter_arr);
		$excess      								= $total_count % $limit;
		$data['C_DATA_COUNT']   					= $total_count;
		$data['PAGES_COUNT']    					= $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
		$data['PAGE']           					= $page;
		$data['ROW']            					= $limit;
		$data['C_ROW_DISPLAY']  					= array(10, 25, 50);

		$data['DEPARTMENTS']   	    				= $this->offsets_model->GET_STD_DATA('tbl_std_departments');
		$data['COMPANIES']     	    				= $this->offsets_model->GET_STD_DATA('tbl_std_companies');
		$data['BRANCHES']      	    				= $this->offsets_model->GET_STD_DATA('tbl_std_branches');
		$data['DIVISIONS']     	   				 	= $this->offsets_model->GET_STD_DATA('tbl_std_divisions');
		$data['SECTIONS']      	    				= $this->offsets_model->GET_STD_DATA('tbl_std_sections');
		$data['GROUPS']        	    				= $this->offsets_model->GET_STD_DATA('tbl_std_groups');
		$data['TEAMS']         	    				= $this->offsets_model->GET_STD_DATA('tbl_std_teams');
		$data['LINES']         	    				= $this->offsets_model->GET_STD_DATA('tbl_std_lines');

		$data['DISP_VIEW_COMPANY']        			= $this->offsets_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         			= $this->offsets_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DEPARTMENT']     			= $this->offsets_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_DIVISION']       			= $this->offsets_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_SECTION']        			= $this->offsets_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          			= $this->offsets_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_TEAM']           			= $this->offsets_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_LINE']           			= $this->offsets_model->GET_SYSTEM_SETTING("com_line");
		$data['EMPLOYEES']                          = $this->offsets_model->GET_EMPLOYEES();
		$this->load->view('templates/header');
		$this->load->view('modules/offsets/offset_request_views', $data);
	}
	function get_request_offset_by_date(){
		$rawData = file_get_contents('php://input');
		$jsonData = parseJsonData($rawData);
		$offsetDate = $jsonData['offset_date'];
		$empl_id = $jsonData['empl_id'];
		$type = $jsonData['type'];
		$typeName = $jsonData['typeName'];
    if (!$offsetDate) {echo json_encode(['success' => false, 'error' => 'Invalid date received', 'data'=> $jsonData, ]); return;}
		// $payrollPeriod =  $this->offsets_model->get_payroll_period($offsetDate);
		// if (!$payrollPeriod) {
		// 	echo json_encode(['messageError' => 'No Cut Off Period Found', 'data'=> $jsonData, 'payrollPeriod ' =>$payrollPeriod ]); return;
		// }
			$offsetEntitlementValue = 0;
			$offsetEntitlement = 'Auto';
			$year = substr($offsetDate, 0, 4);
			$offsetSetting =  $this->offsets_model->GET_SETUP_SETTING('offset_setting');
			if ($offsetSetting) {
				$offsetEntitlementValue =  $this->offsets_model->GET_SETUP_OFFSET_SETTING(str_replace(' ', '_', $typeName));
				if (!$offsetEntitlementValue) {
					echo json_encode(['messageError' => 'Zero or No Entitlement Found', 'data'=> $jsonData, 'offsetEntitlementValue ' =>$offsetEntitlementValue ]); return;
				}
			} else {
				
				$offsetEntitlement =  $this->offsets_model->get_offset_entitlement($empl_id,$typeName,$year);
				if (!$offsetEntitlement) {
					echo json_encode(['messageError' => 'Zero or No Entitlement Found', 'data'=> $jsonData, 'offsetEntitlement ' =>$offsetEntitlement ]); return;
				}
				$offsetEntitlementValue = $offsetEntitlement['value'];
			}
			$dateStart = date("Y-m-d", strtotime($year . "-01-01"));
			$dateEnd = date("Y-m-d", strtotime($year . "-12-31"));
			$offsetsTotal=  $this->offsets_model->get_leaves_total($empl_id,$type,$dateStart,$dateEnd);
			$balance = $offsetEntitlementValue - $offsetsTotal;
			echo json_encode(['messageSuccess' => 'Entitlement Found', 
			'data'=> $jsonData, 
			'offsetEntitlement' =>$offsetEntitlement, 
			'offsetsTotal ' =>$offsetsTotal, 
			'offsetEntitlementValue' =>$offsetEntitlementValue, 
			'balance' =>$balance, 
			'offsetSetting' =>$offsetSetting, 
			]); return;

  }
	function request_offset()
	{
		$data['OFFSET_TYPES']   						= $this->offsets_model->MOD_DISP_OFFSETTYPES();
		$data['EMPLOYEES']                          = $this->offsets_model->GET_EMPLOYEES();
		$this->load->view('templates/header');
		$this->load->view('modules/offsets/new_offset_request_views', $data);
	}
	function add_new_offset()
	{
	    $isApproversEnable                  = $this->offsets_model->GET_SETUP_SETTING('requireApprovers');
	    $user_id                            = $this->session->userdata('SESS_USER_ID');
        // $attachment                         = $_FILES['attachment']['name'];
        $input_data                         = $this->input->post();
        $input_data['assigned_by']          = $user_id ;
        $input_data['status']               = $isApproversEnable==1?'Pending 1':'Approved' ;
        // $file_info = pathinfo($attachment);
        $input_data['create_date']                        = date('Y-m-d H:i:s');
        $input_data['edit_date']                          = date('Y-m-d H:i:s');
        $employee                                         = $this->offsets_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
        $approvers = $this->offsets_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
        $approver = $approvers->approver_1a ? $approvers->approver_1a : 0;
        if ($approver == 0) {
          $this->session->set_flashdata('ERR', 'No Approver Assign');
          redirect('offsets/request_offset');
          return;
        }
        $is_duplicate                                     = $this->offsets_model->GET_IS_DUPLICATE_DATE($input_data['offset_date']);
    
        if ($is_duplicate > 0) {
          $this->session->set_flashdata('ERR', "Offset submission failed. It looks like you have already submitted a offset request for the same dates.");
          redirect('offsets/request_offset');
          return;
        } else {
        //     if(!empty($attachment)){
        //       $input_data['attachment']       = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d').'.'.$file_info['extension'];
        //       $config['upload_path']          = './assets_user/files/selfservices';
        //       $config['allowed_types']        = '*';
        //       $config['max_size']             = 10000;
        //       $config['file_name']            = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d');
        //       $config['overwrite']            = 'TRUE';
        //       $this->load->library('upload', $config);
    
        //       if ( ! $this->upload->do_upload('attachment'))
        //       {
        //           $error = array('error' => $this->upload->display_errors());
        //           $this->session->set_userdata('ERR', $error['error']);
        //           redirect('leaves/request_leave');
        //           // var_dump($error);
        //           return;
        //       }
        //   }  
          $res                                            = $this->offsets_model->ADD_OFFSET_REQUEST($input_data);
          if ($res) {
            $this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added offset request');
            $this->session->set_flashdata('SUCC', 'Successfully added');
                if($isApproversEnable==0){
                    redirect('offsets/offset_lists');
                    return;
                }
            $requestor      = $this->offsets_model->GET_REQUESTOR('offset', $res);
            $description    = "Offset Application Review for [OFF" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
            $notif_data     = array(
              'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $approvers->approver_1a, 'type' => 'Offset',
              'content_id' => $res, 'location' => 'selfservices/offset_approval', 'description' => $description
            );
            $notif = $this->offsets_model->ADD_NOTIFICATION($notif_data);
          } else {
            $this->session->set_flashdata('ERR', 'Fail to add new data');
            redirect('offsets/request_offset');
            return;
          }
        }
// 		$input_data                 				= $this->input->post();
// 		$attachment                 				= $_FILES['attachment']['name'];
// 		$file_info = pathinfo($attachment);
// 		$input_data['create_date']  				= date('Y-m-d H:i:s');
// 		$input_data['edit_date']    				= date('Y-m-d H:i:s');
// 		$employee                   				= $this->offsets_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
// 		$input_data['attachment']   				= $attachment;

// 		if (!empty($attachment)) {
// 			$input_data['attachment']   			= $employee->col_empl_cmid . '_' . $employee->col_last_name . '_leave_request_' . date('Y-m-d') . '.' . $file_info['extension'];
// 			$config['upload_path']          		= './assets_user/files/leaves';
// 			$config['allowed_types']        		= 'pdf|jpg';
// 			$config['max_size']             		= 10000;
// 			$config['file_name']            		= $employee->col_empl_cmid . '_' . $employee->col_last_name . '_leave_request_' . date('Y-m-d');
// 			$config['overwrite']            		= 'TRUE';
// 			$this->load->library('upload', $config);

// 			if (!$this->upload->do_upload('attachment')) {
// 				$error = array('error' => $this->upload->display_errors());
// 				$this->session->set_flashdata('ERR', $error['error']);
// 				redirect('leaves/request_leave');
// 				return;
// 			}
// 		}
// 		$res = $this->offsets_model->ADD_LEAVE_REQUEST($input_data);
// 		if ($res) {
// 			$this->session->set_flashdata('SUCC', 'Successfully added new request');
// 		} else {
// 			$this->session->set_flashdata('ERR', 'Fail to add new request');
// 			redirect('leaves/request_leave');
// 			return;
// 		}
		redirect('offsets/offset_lists');
	}

	function edit_leaves($id)
	{
		$data['EMPLOYEES']      = $this->offsets_model->GET_EMPLOYEELIST();
		$data['LEAVE']       	= $this->offsets_model->GET_LEAVE($id);
		$data['LEAVE_TYPES']    = $this->offsets_model->MOD_DISP_OFFSETTYPES();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/edit_leave_views', $data);
	}

	function update_leave($id)
	{
		$input_data = $this->input->post();
		$res = $this->offsets_model->UPDATE_LEAVE($input_data, $id);
		if ($res) {
			$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated offset leave');
			$this->session->set_flashdata('SUCC', 'Successfully updated');
		} else {
			$this->session->set_flashdata('ERR', 'Unable to update');
		}
		redirect('leaves/leave_lists');
	}

	function show_leave($id)
	{
		$data['EMPLOYEES']      = $this->offsets_model->GET_EMPLOYEELIST();
		$data['LEAVE']       	= $this->offsets_model->GET_LEAVE($id);
		$data['LEAVE_TYPES']    = $this->offsets_model->MOD_DISP_OFFSETTYPES();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/show_leave_views', $data);
	}

	function get_offset_approval_status($id)
	{
		$data['OFFSET'] = $this->offsets_model->GET_LEAVE_APPROVAL_STATUS($id);
		
		$this->load->view('modules/partials/offset_approval_modal_content', $data); 
	}

	function insrt_assign_leave()
	{
		$checkbox_value 		= $this->input->post('leave_class');
		$url_directory 			= $this->input->post('url_directory');
		$assigned_by 			= $this->session->userdata('SESS_USER_ID');
		if ($url_directory == 'leave_lists') {
			$url_directory = 'leaves/leave_lists';
		} else if ($url_directory == 'assign_leave') {
			$url_directory = 'leave/assign_leave';
		}
		if ($checkbox_value == 'leave_single_day') {
			$employee_id 		= $this->input->post('INSRT_ASSIGN_TO');
			$leave_type 		= $this->input->post('INSRT_LEAVE_TYPE');
			$date 				= $this->input->post('INSRT_LEAVE_DATE');
			$duration 			= $this->input->post('INSRT_LEAVE_DURATION');
			$comment 			= $this->input->post('INSRT_LEAVE_COMMENT');
			$status 			= 'Pending Approval';
			$empl_group 		= 'No Group';
			$empl_name 			= '';
			$empl_info 			= $this->offsets_model->MOD_DISP_EMPLOYEE($employee_id);
			foreach ($empl_info as $empl_info_row) {
				$empl_group 	= $empl_info_row->col_empl_group;
				$empl_name 		= $empl_info_row->col_frst_name . ' ' . $empl_info_row->col_last_name;
			}
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
			$leave_balance 						= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
			if ($leave_balance[$col_leave_type] >= $duration) {
				$approval_route 				= $this->offsets_model->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($employee_id);
				if ((!empty($_FILES['INSRT_LEAVE_FILE']) && ($leave_type == "Sick Leave"))) {
					$get_file_name 				= $_FILES['INSRT_LEAVE_FILE']['name'];
					$config['upload_path'] 		= './assets/files/leave';
					$config['allowed_types'] 	= 'jpg|png|jpeg';
					$config['max_size'] 		= '5000';
					$config['file_name'] 		= $employee_id . $get_file_name;
					$config['overwrite'] 		= 'TRUE';
					$this->load->library('upload', $config);
					if ($_FILES['INSRT_LEAVE_FILE']['size'] != 0) {
						if ($this->upload->do_upload('INSRT_LEAVE_FILE')) {
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
							$leave_balance 			= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
							$total_leave_balance 	= $leave_balance[$col_leave_type];
							$this->offsets_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
							$data_upload 			= array('INSRT_LEAVE_FILE' => $this->upload->data());
							$leave_file 			= $data_upload['INSRT_LEAVE_FILE']['file_name'];
							$leave_insrt_id 		= $this->offsets_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
							foreach ($approval_route as $approval_route_row) {
								$my_user_id 		= $this->session->userdata('SESS_USER_ID');
								if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
									$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR1($status, $leave_insrt_id);
									echo 'approver 1 ' . $leave_insrt_id . ' <br>';
								}
								if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
									$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR2($status, $leave_insrt_id);
									echo 'approver 2 ' . $leave_insrt_id . ' <br>';
								}
								if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
									$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR3($status, $leave_insrt_id);
									echo 'approver 3 ' . $leave_insrt_id . ' <br>';
								}
							}
							$recievers_arr = [];
							$get_group_approver 	= $this->offsets_model->MOD_DISP_GROUP_APPROVERS($empl_group);
							$get_leave_approver 	= $this->offsets_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
							if (count($get_group_approver)) {
								if ($get_group_approver[0]->approver1) {
									array_push($recievers_arr, $get_group_approver[0]->approver1);
								}
								if ($get_group_approver[0]->approver2) {
									array_push($recievers_arr, $get_group_approver[0]->approver2);
								}
							}
							if ($get_leave_approver) {
								if ($get_leave_approver[0]->approver3) {
									array_push($recievers_arr, $get_leave_approver[0]->approver3);
								}
								if ($get_leave_approver[0]->approver4) {
									array_push($recievers_arr, $get_leave_approver[0]->approver4);
								}
								if ($get_leave_approver[0]->approver5) {
									array_push($recievers_arr, $get_leave_approver[0]->approver5);
								}
								if ($get_leave_approver[0]->approver6) {
									array_push($recievers_arr, $get_leave_approver[0]->approver6);
								}
								if ($get_leave_approver[0]->approver7) {
									array_push($recievers_arr, $get_leave_approver[0]->approver7);
								}
							}
							$appr_type 				= 'Leave';
							$reciever 				= implode(",", $recievers_arr);
							$date_created 			= date('Y-m-d H:i:s');
							$message 				= 'Assigned leave to: ';
							$notif_status 			= 0;
							$requested_by 			= $this->session->userdata('SESS_USER_ID');
							$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
							$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
							$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned offset leave');
							$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE', 'Leave application assigned successfully!');
							redirect($url_directory);
						}
					} else {
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
						$leave_balance 			= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
						$total_leave_balance 	= $leave_balance[$col_leave_type];
						$this->offsets_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
						$leave_file = '';
						$leave_insrt_id 		= $this->offsets_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
						foreach ($approval_route as $approval_route_row) {
							$my_user_id		 	= $this->session->userdata('SESS_USER_ID');
							if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
								$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR1($status, $leave_insrt_id);
								echo 'approver 1 ' . $leave_insrt_id . ' <br>';
							}
							if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
								$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR2($status, $leave_insrt_id);
								echo 'approver 2 ' . $leave_insrt_id . ' <br>';
							}
							if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
								$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR3($status, $leave_insrt_id);
								echo 'approver 3 ' . $leave_insrt_id . ' <br>';
							}
						}
						$recievers_arr = [];
						$get_group_approver = $this->offsets_model->MOD_DISP_GROUP_APPROVERS($empl_group);
						$get_leave_approver = $this->offsets_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
						if (count($get_group_approver)) {
							if ($get_group_approver[0]->approver1) {
								array_push($recievers_arr, $get_group_approver[0]->approver1);
							}
							if ($get_group_approver[0]->approver2) {
								array_push($recievers_arr, $get_group_approver[0]->approver2);
							}
						}
						if ($get_leave_approver) {
							if ($get_leave_approver[0]->approver3) {
								array_push($recievers_arr, $get_leave_approver[0]->approver3);
							}
							if ($get_leave_approver[0]->approver4) {
								array_push($recievers_arr, $get_leave_approver[0]->approver4);
							}
							if ($get_leave_approver[0]->approver5) {
								array_push($recievers_arr, $get_leave_approver[0]->approver5);
							}
							if ($get_leave_approver[0]->approver6) {
								array_push($recievers_arr, $get_leave_approver[0]->approver6);
							}
							if ($get_leave_approver[0]->approver7) {
								array_push($recievers_arr, $get_leave_approver[0]->approver7);
							}
						}
						$appr_type 			= 'Leave';
						$reciever 			= implode(",", $recievers_arr);
						$date_created 		= date('Y-m-d H:i:s');
						$message 			= 'Assigned leave to: ';
						$notif_status 		= 0;
						$requested_by 		= $this->session->userdata('SESS_USER_ID');
						$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
						$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
						$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned offset leave');
						$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE', 'Leave application assigned successfully!');
						redirect($url_directory);
					}
				} else {
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
					$leave_balance 			= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
					$total_leave_balance 	= $leave_balance[$col_leave_type];
					$this->offsets_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
					$leave_insrt_id 		= $this->offsets_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $total_leave_balance);
					foreach ($approval_route as $approval_route_row) {
						$my_user_id 		= $this->session->userdata('SESS_USER_ID');
						if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
							$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
						}
						if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
							$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
						}
						if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
							$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
						}
					}
					$recievers_arr 			= [];
					$get_group_approver 	= $this->offsets_model->MOD_DISP_GROUP_APPROVERS($empl_group);
					$get_leave_approver 	= $this->offsets_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
					if (count($get_group_approver)) {
						if ($get_group_approver[0]->approver1) {
							array_push($recievers_arr, $get_group_approver[0]->approver1);
						}
						if ($get_group_approver[0]->approver2) {
							array_push($recievers_arr, $get_group_approver[0]->approver2);
						}
					}
					if ($get_leave_approver) {
						if ($get_leave_approver[0]->approver3) {
							array_push($recievers_arr, $get_leave_approver[0]->approver3);
						}
						if ($get_leave_approver[0]->approver4) {
							array_push($recievers_arr, $get_leave_approver[0]->approver4);
						}
						if ($get_leave_approver[0]->approver5) {
							array_push($recievers_arr, $get_leave_approver[0]->approver5);
						}
						if ($get_leave_approver[0]->approver6) {
							array_push($recievers_arr, $get_leave_approver[0]->approver6);
						}
						if ($get_leave_approver[0]->approver7) {
							array_push($recievers_arr, $get_leave_approver[0]->approver7);
						}
					}
					$appr_type 				= 'Leave';
					$reciever 				= implode(",", $recievers_arr);
					$date_created 			= date('Y-m-d H:i:s');
					$message 				= 'Assigned leave to: ';
					$notif_status 			= 0;
					$requested_by 			= $this->session->userdata('SESS_USER_ID');
					$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
					$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
					$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned offset leave');
					$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE', 'Leave application assigned successfully!');
					redirect($url_directory);
				}
			} else {
				$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE', 'Insufficient Leave Balance');
				redirect($url_directory);
			}
		} else if ($checkbox_value == 'leave_multiple_days') {
			$employee_id 					= $this->input->post('INSRT_ASSIGN_TO_MULTIPLE');
			$leave_type 					= $this->input->post('INSRT_LEAVE_TYPE_MULTIPLE');
			$date_from 						= $this->input->post('INSRT_LEAVE_DATE_FROM');
			$date_to 						= $this->input->post('INSRT_LEAVE_DATE_TO');
			$duration 						= $this->input->post('INSRT_LEAVE_DURATION_MULTIPLE');
			$comment 						= $this->input->post('INSRT_LEAVE_COMMENT');
			$status 						= 'Pending Approval';
			$empl_group 					= 'No Group';
			$empl_name 						= '';
			$empl_info 						= $this->offsets_model->MOD_DISP_EMPLOYEE($employee_id);
			foreach ($empl_info as $empl_info_row) {
				$empl_group = $empl_info_row->col_empl_group;
				$empl_name = $empl_info_row->col_frst_name . ' ' . $empl_info_row->col_last_name;
			}
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
			$leave_balance 						= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
			if ($leave_balance[$col_leave_type] >= $duration) {
				$approval_route 				= $this->offsets_model->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($employee_id);
				if ((!empty($_FILES['INSRT_LEAVE_FILE']) && ($leave_type == "Sick Leave"))) {
					$get_file_name 				= $_FILES['INSRT_LEAVE_FILE']['name'];
					$config['upload_path'] 		= './assets/files/leave';
					$config['allowed_types'] 	= 'jpg|png|jpeg';
					$config['max_size'] 		= '5000';
					$config['file_name'] 		= $employee_id . $get_file_name;
					$config['overwrite'] 		= 'TRUE';
					$this->load->library('upload', $config);
					if ($_FILES['INSRT_LEAVE_FILE']['size'] != 0) {
						if ($this->upload->do_upload('INSRT_LEAVE_FILE')) {
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
							$data_upload 				= array('INSRT_LEAVE_FILE' => $this->upload->data());
							$leave_file 				= $data_upload['INSRT_LEAVE_FILE']['file_name'];
							$leave_balance 				= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
							$total_leave_balance 		= $leave_balance[$col_leave_type];
							$this->offsets_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
							if ($date_from != $date_to) {
								$leave_insrt_id 		= $this->offsets_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
								foreach ($approval_route as $approval_route_row) {
									$my_user_id 		= $this->session->userdata('SESS_USER_ID');
									if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
										$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
										$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
										$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
									}
								}
								$recievers_arr 			= [];
								$get_group_approver 	= $this->offsets_model->MOD_DISP_GROUP_APPROVERS($empl_group);
								$get_leave_approver 	= $this->offsets_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
								if (count($get_group_approver)) {
									if ($get_group_approver[0]->approver1) {
										array_push($recievers_arr, $get_group_approver[0]->approver1);
									}
									if ($get_group_approver[0]->approver2) {
										array_push($recievers_arr, $get_group_approver[0]->approver2);
									}
								}
								if ($get_leave_approver) {
									if ($get_leave_approver[0]->approver3) {
										array_push($recievers_arr, $get_leave_approver[0]->approver3);
									}
									if ($get_leave_approver[0]->approver4) {
										array_push($recievers_arr, $get_leave_approver[0]->approver4);
									}
									if ($get_leave_approver[0]->approver5) {
										array_push($recievers_arr, $get_leave_approver[0]->approver5);
									}
									if ($get_leave_approver[0]->approver6) {
										array_push($recievers_arr, $get_leave_approver[0]->approver6);
									}
									if ($get_leave_approver[0]->approver7) {
										array_push($recievers_arr, $get_leave_approver[0]->approver7);
									}
								}
								$appr_type 				= 'Leave';
								$reciever 				= implode(",", $recievers_arr);
								$date_created 			= date('Y-m-d H:i:s');
								$message 				= 'Assigned leave to: ';
								$notif_status 			= 0;
								$requested_by 			= $this->session->userdata('SESS_USER_ID');
								$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
								$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
								$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned offset leave');
								$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE', 'Leave application assigned successfully!');
								redirect($url_directory);
							} else {
								$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE', "You've entered the same date. Please use single entry.");
								redirect($url_directory);
							}
						}
					} else {
						if ($this->upload->do_upload('INSRT_LEAVE_FILE')) {
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
							$leave_file = '';
							$leave_balance 			= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
							$total_leave_balance = $leave_balance[$col_leave_type];
							$this->offsets_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
							if ($date_from != $date_to) {
								$leave_insrt_id 	= $this->offsets_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
								foreach ($approval_route as $approval_route_row) {
									$my_user_id 	= $this->session->userdata('SESS_USER_ID');
									if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
										$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
										$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
										$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
									}
								}
								$recievers_arr = [];
								$get_group_approver = $this->offsets_model->MOD_DISP_GROUP_APPROVERS($empl_group);
								$get_leave_approver = $this->offsets_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
								if (count($get_group_approver)) {
									if ($get_group_approver[0]->approver1) {
										array_push($recievers_arr, $get_group_approver[0]->approver1);
									}
									if ($get_group_approver[0]->approver2) {
										array_push($recievers_arr, $get_group_approver[0]->approver2);
									}
								}
								if ($get_leave_approver) {
									if ($get_leave_approver[0]->approver3) {
										array_push($recievers_arr, $get_leave_approver[0]->approver3);
									}
									if ($get_leave_approver[0]->approver4) {
										array_push($recievers_arr, $get_leave_approver[0]->approver4);
									}
									if ($get_leave_approver[0]->approver5) {
										array_push($recievers_arr, $get_leave_approver[0]->approver5);
									}
									if ($get_leave_approver[0]->approver6) {
										array_push($recievers_arr, $get_leave_approver[0]->approver6);
									}
									if ($get_leave_approver[0]->approver7) {
										array_push($recievers_arr, $get_leave_approver[0]->approver7);
									}
								}
								$appr_type				= 'Leave';
								$reciever 				= implode(",", $recievers_arr);
								$date_created 			= date('Y-m-d H:i:s');
								$message 				= 'Assigned leave to: ';
								$notif_status 			= 0;
								$requested_by 			= $this->session->userdata('SESS_USER_ID');
								$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
								$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
								$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned offset leave');
								$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE', 'Leave application assigned successfully!');
								redirect($url_directory);
							} else {
								$this->session->set_userdata('SESS_ERR_MSG_INSRT_ASSIGN_LEAVE', "You've entered the same date. Please use single entry.");
								redirect($url_directory);
							}
						}
					}
				} else {
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
					$leave_balance 				= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
					$total_leave_balance 		= $leave_balance[$col_leave_type];
					$this->offsets_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
					if ($date_from != $date_to) {
						$leave_insrt_id 		= $this->offsets_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $total_leave_balance);
						foreach ($approval_route as $approval_route_row) {
							$my_user_id 		= $this->session->userdata('SESS_USER_ID');
							if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
								$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
							}
							if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
								$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
							}
							if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
								$this->offsets_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
							}
						}
						$recievers_arr 			= [];
						$get_group_approver 	= $this->offsets_model->MOD_DISP_GROUP_APPROVERS($empl_group);
						$get_leave_approver 	= $this->offsets_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
						if (count($get_group_approver)) {
							if ($get_group_approver[0]->approver1) {
								array_push($recievers_arr, $get_group_approver[0]->approver1);
							}
							if ($get_group_approver[0]->approver2) {
								array_push($recievers_arr, $get_group_approver[0]->approver2);
							}
						}
						if ($get_leave_approver) {
							if ($get_leave_approver[0]->approver3) {
								array_push($recievers_arr, $get_leave_approver[0]->approver3);
							}
							if ($get_leave_approver[0]->approver4) {
								array_push($recievers_arr, $get_leave_approver[0]->approver4);
							}
							if ($get_leave_approver[0]->approver5) {
								array_push($recievers_arr, $get_leave_approver[0]->approver5);
							}
							if ($get_leave_approver[0]->approver6) {
								array_push($recievers_arr, $get_leave_approver[0]->approver6);
							}
							if ($get_leave_approver[0]->approver7) {
								array_push($recievers_arr, $get_leave_approver[0]->approver7);
							}
						}
						$appr_type 					= 'Leave';
						$reciever 					= implode(",", $recievers_arr);
						$date_created 				= date('Y-m-d H:i:s');
						$message 					= 'Assigned leave to: ';
						$notif_status 				= 0;
						$requested_by 				= $this->session->userdata('SESS_USER_ID');
						$this->notif_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $leave_insrt_id, $requested_by);
						$this->notif_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $leave_insrt_id, $notif_status);
						$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned offset leave');
						$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ASSIGN_LEAVE', 'Leave application submitted successfully!');
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

	function updt_leave_details()
	{

		$date_requested 							= $this->input->post('offset_date_requested');
		$date_leave 								= $this->input->post('leave_on_date');
		$type 										= $this->input->post('leave_type');
		$leave_reason 								= $this->input->post('edit_leave_reason');
		$duration 									= $this->input->post('edit_leave_duration');
		$status 									= $this->input->post('leave_status');
		$row_id 									= $this->input->post('row_id');
		$this->offsets_model->MOD_UPDT_LEAVE_DETAILS($date_requested, $date_leave, $type, $leave_reason, $duration, $status, $row_id);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated offset leave details');
		$this->session->set_userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE', 'Updated Successfully');
		redirect('leaves/leave_lists');
	}

	function entitlements()
	{
		$search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

		if (!isset($_GET["branch"])) {
			$param_branch   = "all";
		} else {
			$param_branch    = $_GET["branch"];
		}
		if (!isset($_GET["dept"])) {
			$param_dept     = "all";
		} else {
			$param_dept      = $_GET["dept"];
		}
		if (!isset($_GET["division"])) {
			$param_division = "all";
		} else {
			$param_division  = $_GET["division"];
		}
		if (!isset($_GET["section"])) {
			$param_section  = "all";
		} else {
			$param_section   = $_GET["section"];
		}
		if (!isset($_GET["group"])) {
			$param_group    = "all";
		} else {
			$param_group     = $_GET["group"];
		}
		if (!isset($_GET["team"])) {
			$param_team     = "all";
		} else {
			$param_team      = $_GET["team"];
		}
		if (!isset($_GET["line"])) {
			$param_line     = "all";
		} else {
			$param_line      = $_GET["line"];
		}
		if (!isset($_GET["status"])) {
			$param_status   = "all";
		} else {
			$param_status    = $_GET["status"];
		}

		if (!isset($_GET["employee"])) {
			$_GET["employee"] = "";
		}


		$data['DISP_YEARS']        		  	= $year_list 			= $this->offsets_model->GET_YEARS();
		$data['VACATION_LEAVE'] 			= $VACATION_LEAVE 		= $this->offsets_model->GET_SYSTEM_SETTING_DATA_NAME('offset_vacation_leave');
		$data['SICK_LEAVE'] 				= $SICK_LEAVE 			= $this->offsets_model->GET_SYSTEM_SETTING_DATA_NAME('offset_sick_leave');
		$data["DISP_OFFSET_TYPES"] 		 	= $DISP_OFFSET_TYPES 	= $this->offsets_model->MOD_DISP_OFFSETTYPES();
        

		if (!isset($_GET["year"])) {
			$year = $year_list[0]->id;
		} else {
			$year = $_GET["year"];
		}
		$data["DISP_ENTITLEMENT"]		    = $DISP_ENTITLEMENT	= $this->offsets_model->GET_ENTITLEMENT_DATA($year);
        // echo '<pre>';
        // var_dump($data["DISP_ENTITLEMENT"]);
        // return;
		$data["C_ROW_DISPLAY"]              =  [25, 50, 100];
		$page 								= $this->input->get('page');
		$row  								= $this->input->get('row');
		if ($row == null) {
			$row = 25;
		}
		if ($page  == null) {
			$page = 1;
		}
		$offset = $row * ($page - 1);

		if ($this->input->get('all') == null) {


			$data['DISP_EMP_LIST']          = $empl_list = $this->offsets_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
			$DISP_EMP_LIST_TABLE            = $this->offsets_model->GET_FILTERED_EMPLOYEELIST_TABLE($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
			$data['C_DATA_COUNT']           = $this->offsets_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);



			foreach ($DISP_EMP_LIST_TABLE as $key => $DISP_EMP_LIST_ROW) {
				$hireDate = ($DISP_EMP_LIST_ROW->col_hire_date != "0000-00-00") ? $DISP_EMP_LIST_ROW->col_hire_date : "";
				$currentDate = date("Y-m-d");

				if ($hireDate) {
					$getYear = new DateTime();

					foreach ($year_list as $DISP_YEARS_ROW) {
						if ($year == $DISP_YEARS_ROW->id) {
							$filteredYear = $DISP_YEARS_ROW->name;
						}
					}

					$firstDayOfYear = $filteredYear . "-01-01";

					$hired_date = new DateTime($hireDate);
					$current_date = new DateTime($currentDate);
					$first_day_of_year = new DateTime($firstDayOfYear);

					$hiredYear = $hired_date->format("Y");

					if ($hiredYear == $filteredYear) {
						$daysBetween = $current_date->diff($hired_date)->days;
					} else {
						$daysBetween = $current_date->diff($first_day_of_year)->days;
					}

					$monthsBetween = $daysBetween / 30.4375;

					$DISP_EMP_LIST_TABLE[$key]->monthsCount = number_format($monthsBetween, 2);

					$monthsBetweenWithoutDecimal = floor($monthsBetween);

					$parts1 = explode("_", $VACATION_LEAVE['setting']);
					$parts2 = explode("_", $SICK_LEAVE['setting']);

					$vacation_result = 0;
					$sick_result = 0;

				// 	foreach ($DISP_OFFSET_TYPES as $DISP_LEAVE_TYPES_ROW) {

				// 		if ($DISP_LEAVE_TYPES_ROW->name == "Vacation" || $DISP_LEAVE_TYPES_ROW->name == "Sick") {

				// 			if (strtolower($DISP_LEAVE_TYPES_ROW->name) == $parts1[0]) {
				// 				$vacation_result = number_format($monthsBetweenWithoutDecimal * ($VACATION_LEAVE['value'] / 12), 2);
				// 			} else if (strtolower($DISP_LEAVE_TYPES_ROW->name) == $parts2[0]) {
				// 				$sick_result = number_format($monthsBetweenWithoutDecimal * ($SICK_LEAVE['value'] / 12), 2);
				// 			}

				// 			$DISP_EMP_LIST_TABLE[$key]->vacation = $vacation_result;
				// 			$DISP_EMP_LIST_TABLE[$key]->sick = $sick_result;
				// 		}
				// 	}
				}
			}


			$data['DISP_EMP_LIST_TABLE'] = $DISP_EMP_LIST_TABLE;
		} else {
			$data['DISP_EMP_LIST']            		= $this->offsets_model->GET_SEARCHED($search);
			$data['C_DATA_COUNT']            		= count($this->offsets_model->GET_SEARCHED($search));
		}

		$data['DISP_PAYROLL_SCHED']       			= $payroll_list = $this->offsets_model->MOD_DISP_PAY_SCHED();

		$data["SYSTEM_LEAVE_SETTING"]               = $this->offsets_model->GET_SYSTEM_OFFSET_SETTING();

		if (!isset($_GET["period"])) {
			$period = $payroll_list[0]->id;
		} else {
			$period = $_GET["period"];
		}
		$data['PERIOD_INITIAL']           			= $period;
		$data['YEAR_INITIAL']           			= $year;
		$res_data                         			= $this->get_employee_data();
		$data['DISP_CUTOFF']              			= $res_data['cutoff_data'];
		$data['DISP_WORK_SHIFT_DATA']     			= $this->offsets_model->GET_WORK_SHIFT_DATA();

		$data['DISP_DISTINCT_BRANCH']     			= $this->offsets_model->MOD_DISP_DISTINCT_BRANCH();
		$data['DISP_DISTINCT_DEPARTMENT'] 			= $this->offsets_model->MOD_DISP_DISTINCT_DEPARTMENT();
		$data['DISP_DISTINCT_DIVISION']   			= $this->offsets_model->MOD_DISP_DISTINCT_DIVISION();
		$data['DISP_DISTINCT_SECTION']    			= $this->offsets_model->MOD_DISP_DISTINCT_SECTION();
		$data['DISP_DISTINCT_GROUP']      			= $this->offsets_model->MOD_DISP_DISTINCT_GROUP();
		$data['DISP_DISTINCT_TEAM']       			= $this->offsets_model->MOD_DISP_DISTINCT_TEAM();
		$data['DISP_DISTINCT_LINE']       			= $this->offsets_model->MOD_DISP_DISTINCT_LINE();

		$data['DISP_VIEW_COMPANY']         			= $this->offsets_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         			= $this->offsets_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DEPARTMENT']     			= $this->offsets_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_DIVISION']       			= $this->offsets_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_SECTION']        			= $this->offsets_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          			= $this->offsets_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_TEAM']           			= $this->offsets_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_LINE']           			= $this->offsets_model->GET_SYSTEM_SETTING("com_line");



		if (!empty($DISP_EMP_LIST)) {
			$data['DISP_USER_ID']             		= $data['DISP_EMP_LIST'][0]->id;
		} else {
			$data['DISP_USER_ID']             		= 0;
		}

		$date_period = $this->offsets_model->get_period_data($period);


		$begin 										= new DateTime($date_period['date_from']);
		$end 										= new DateTime($date_period['date_to']);
		$end 										= $end->modify('+1 day');
		$holidays 									= $this->offsets_model->GET_HOLIDAY();
		$interval 									= new DateInterval('P1D');
		$daterange 									= new DatePeriod($begin, $interval, $end);

		$data['SHIFT_DATA_DATERANGE']     			= $this->offsets_model->GET_SHIFT_DATA_DATERANGE($date_period['date_from'], $date_period['date_to']);
		$data['DATE_FROM']                			= $date_period['date_from'];
		$data['DATE_TO']                  			= $date_period['date_to'];
		$data['SHIFT_DATA']               			= $this->offsets_model->GET_SHIFT_ALL_DATA();
		$data["DATE_RANGE"] 			  			= $this->assign_shift_data($daterange, $holidays);
        $data['EMPLOYEES']                          = $this->offsets_model->GET_EMPLOYEES();
        // echo '<pre>';
        // var_dump($data['DISP_OFFSET_TYPES']);
        // return;
		$this->load->view('templates/header');
		$this->load->view('modules/offsets/offset_entitlement_views', $data);
	}

	function process_assigning($user_id, $entitlement_val, $year)
	{
		$response 							= $this->offsets_model->IS_DUPLICATE($user_id, $year, $type);
        $type                               = $this->input->get('type');

		if ($response == 0) {
		    $this->offsets_model->UPDATE_USER_ENTITLEMENT($user_id, $entitlement_val, $year, $type);
		} else {
		    $this->offsets_model->ADD_USER_ENTITLEMENT($user_id, $entitlement_val, $year, $type);
			
		}

		$this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
		if (isset($_SERVER["HTTP_REFERER"])) {
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}

	function update_offset_entitlement()
	{
		$empl_id 									= $this->input->post('UPDATE_ID');
		$entitlement_val 							= $this->input->post('UPDT_ENTITLEMENT_VAL');
		$type 										= $this->input->post('UPDT_ENTITLEMENT_TYPE');
		$year 										= $this->input->post('YEAR');
		var_dump($empl_id . ' id<br>');
		var_dump($entitlement_val . ' val<br>');
		var_dump($type . ' type<br>');
		var_dump($year . ' year<br>');

		$empl_ids 						= explode(",", $empl_id);

		foreach ($empl_ids as $id) {

			$result 				= $this->offsets_model->IS_DUPLICATE($id, $year, $type);

			if ($result == 0) {
				$this->offsets_model->ADD_USER_ENTITLEMENT($id, $entitlement_val, $year, $type);
			} else {
				$this->offsets_model->UPDATE_USER_ENTITLEMENT($id, $entitlement_val, $year, $type);
			}
		}

		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated offset entitlement');
		$this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
		if (isset($_SERVER["HTTP_REFERER"])) {
			redirect($_SERVER["HTTP_REFERER"]);
		}
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
		$date_period 						= $this->offsets_model->GET_PERIOD_DATA($this->input->get('period'));
		if (empty($date_period)) {
			$data['employee_data'] 			= array();
			$data['cutoff_data'] 			= array();
			return $data;
		}

		$start_date 						= $date_period['date_from'];
		$end_date 							= $date_period['date_to'];
		$data['employee_data'] 				= $this->offsets_model->MOD_DISP_EMPLOYEE($employee_id);
		$data['cutoff_data'] 				= $this->offsets_model->MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id);
		return $data;
	}

	function insrt_entitlement()
	{
		$assigned_by 						= $this->input->post('INSRT_ASSIGNED_BY');
		$employee_id 						= $this->input->post('INSRT_ASSIGN_EMPL');
		$leave_type 						= $this->input->post('INSRT_LEAVE_TYPE');
		$value 								= $this->input->post('INSRT_LEAVE_VALUE');
		$comment 							= $this->input->post('INSRT_LEAVE_COMMENT');
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
		$leave_balance 						= $this->offsets_model->MOD_GET_EMPL_CURRENT_BALANCE($db_leave_type, $employee_id);
		$total_leave_balance 				= $leave_balance[$db_leave_type] + $value;
		$this->offsets_model->MOD_UPDT_LEAVE_BALANCE($db_leave_type, $total_leave_balance, $employee_id);
		$this->offsets_model->MOD_INSRT_ENTITLEMENT($date, $leave_type, $comment, $assigned_by, $employee_id, $value, $total_leave_balance);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added offset entitlement');
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_ENTITLEMENT', 'Leave balance added successfully!');
		redirect('leaves/entitlements');
	}

	function approval_routes()
	{
		$search                             = str_replace('_', ' ', $this->input->get('all') ?? "");
		if (!isset($_GET["branch"])) {
			$param_branch   = "all";
		} else {
			$param_branch    = $_GET["branch"];
		}
		if (!isset($_GET["dept"])) {
			$param_dept     = "all";
		} else {
			$param_dept      = $_GET["dept"];
		}
		if (!isset($_GET["division"])) {
			$param_division = "all";
		} else {
			$param_division  = $_GET["division"];
		}
		if (!isset($_GET["section"])) {
			$param_section  = "all";
		} else {
			$param_section   = $_GET["section"];
		}
		if (!isset($_GET["group"])) {
			$param_group    = "all";
		} else {
			$param_group     = $_GET["group"];
		}
		if (!isset($_GET["team"])) {
			$param_team     = "all";
		} else {
			$param_team      = $_GET["team"];
		}
		if (!isset($_GET["line"])) {
			$param_line     = "all";
		} else {
			$param_line      = $_GET["line"];
		}
		if (!isset($_GET["status"])) {
			$param_status   = "all";
		} else {
			$param_status    = $_GET["status"];
		}

		$data["C_ROW_DISPLAY"]                   	=  [25, 50, 100];
		$page 									 	= $this->input->get('page');
		$row  									 	= $this->input->get('row');
		if ($row == null) {
			$row = 25;
		}
		if ($page  == null) {
			$page = 1;
		}
		$offset = $row * ($page - 1);

		$data['DISP_EMPLOYEES_NONFILTERED']    		= $leave_approvers          = $this->offsets_model->GET_EMPLOYEELIST();
		if ($this->input->get('all') == null) {
			$data['DISP_EMPLOYEES']    				= $leave_approvers          = $this->offsets_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
			$data['C_DATA_COUNT']             		= $this->offsets_model->GET_COUNT_EMPLOYEELIST();
		} else {
			$data['DISP_EMPLOYEES']                 = $leave_approvers = $this->offsets_model->GET_SEARCHED($search);
			$data['C_DATA_COUNT']                   = count($this->offsets_model->GET_SEARCHED($search));
		}

		$C_APPROVERS = array();
		$approval_list                				= $this->offsets_model->MOD_DISP_APPR_ROUT_LIST();

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
				if ($leave_approvers_ROW->id == $approval_list_ROW->empl_id) {
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

		$data['DISP_APPROVER'] 			  =  $C_APPROVERS;

		$data['DISP_DISTINCT_BRANCH']     = $this->offsets_model->MOD_DISP_DISTINCT_BRANCH();
		$data['DISP_DISTINCT_DEPARTMENT'] = $this->offsets_model->MOD_DISP_DISTINCT_DEPARTMENT();
		$data['DISP_DISTINCT_DIVISION']   = $this->offsets_model->MOD_DISP_DISTINCT_DIVISION();
		$data['DISP_DISTINCT_SECTION']    = $this->offsets_model->MOD_DISP_DISTINCT_SECTION();
		$data['DISP_DISTINCT_GROUP']      = $this->offsets_model->MOD_DISP_DISTINCT_GROUP();
		$data['DISP_DISTINCT_TEAM']       = $this->offsets_model->MOD_DISP_DISTINCT_TEAM();
		$data['DISP_DISTINCT_LINE']       = $this->offsets_model->MOD_DISP_DISTINCT_LINE();

		$data['DISP_VIEW_COMPANY']        = $this->offsets_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         = $this->offsets_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DIVISION']       = $this->offsets_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_TEAM']           = $this->offsets_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_DEPARTMENT']     = $this->offsets_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_SECTION']        = $this->offsets_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          = $this->offsets_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_LINE']           = $this->offsets_model->GET_SYSTEM_SETTING("com_line");

		$this->load->view('templates/header');
		$this->load->view('modules/leaves/route_leave_views', $data);
	}

	function request()
	{
		$search                           = str_replace('_', ' ', $this->input->get('all') ?? "");
		$dept                             = $this->input->get('dept');
		$sec                              = $this->input->get('sec');
		$group                            = $this->input->get('group');
		$line                             = $this->input->get('line');
		$status                           = $this->input->get('status');

		if ($this->input->get('all') == null) {
			$employees 						= $this->offsets_model->MOD_DISP_FILTER_EMPLOYEES($dept, $sec, $group, $line, $status);
		} else {
			$employees  					= $this->offsets_model->MOD_GET_SEARCHED($search);
		}

		$requests 							= $this->offsets_model->MOD_DSIP_ALL_REQUEST_FOR_APPROVAL();

		$empl_request = [];
		foreach ($requests as $request) {
			foreach ($employees as $empl) {
				if ($empl->id == $request->employee_id) {
					array_push($empl_request, $request);
				}
			}
		}
		return $empl_request;
	}

	function empl_id_edit($id)
	{
		$data['DISP_EMPLOYEES_ID'] 			= $this->offsets_model->MOD_DISP_EMPLOYEES_ID($id);
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/empl_id_edit_views', $data);
	}

	function update_empl_id()
	{
		$user_id 							= $this->input->post('USER_ID');
		$empl_id 							= $this->input->post('UPDATE_EMPL_ID');
		$this->offsets_model->UPDATE_EMPL_ID($empl_id, $user_id);
		redirect('leaves/approval_routes');
	}

	function assign_approvers_leave()
	{
		$date = date("Y-m-d H:i:s");
		$empl_id 	= $this->input->post('EMPLOYEE_ID');
		$approver1a = $this->input->post('UPDT_APPROVER_1A');
		$approver1b = $this->input->post('UPDT_APPROVER_1B');
		$approver2a = $this->input->post('UPDT_APPROVER_2A');
		$approver2b = $this->input->post('UPDT_APPROVER_2B');
		$approver3a = $this->input->post('UPDT_APPROVER_3A');
		$approver3b = $this->input->post('UPDT_APPROVER_3B');

		$empl_ids = explode(",", $empl_id);

		foreach ($empl_ids as $id) {


			$result = $this->offsets_model->GET_LEAVE_APPROVER($id);

			if ($result) {
				$this->offsets_model->MOD_UPDT_APPROVAL_ROUTE_LEAVE($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
			} else {

				$this->offsets_model->MOD_INSERT_LEAVE_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
			}
		}

		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned offset approvers');
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Updated Successfully!");

		if (isset($_SERVER["HTTP_REFERER"])) {
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}

	function add_approval()
	{
		$data['DISP_EMPLOYEES']              = $this->offsets_model->MOD_DISP_ALL_EMPL();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/add_leave_approval_views', $data);
	}

	function add_approval_data()
	{
		$emp_id 							= $this->input->post('insrt_name');
		$app1a 								= $this->input->post('insrt_approver_1a');
		$app1b 								= $this->input->post('insrt_approver_1b');
		$app2a 								= $this->input->post('insrt_approver_2a');
		$app2b 								= $this->input->post('insrt_approver_2b');
		$app3a 								= $this->input->post('insrt_approver_3a');
		$app3b 								= $this->input->post('insrt_approver_3b');

		$this->offsets_model->MOD_INSERT_APPROVER_DATA($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added offset approval');
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Added Successfully!");
		redirect('leaves/approval_routes');
	}

	function csv_import()
	{
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_approval_csv_import_views');
	}

	function leave_approval_csv_process()
	{
		$handle   							= fopen($_FILES['file']['tmp_name'], "r");
		$headers  							= fgetcsv($handle, 1000, ",");

		if (count($headers) != 7) {
			$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Incomplete Headers");
			redirect('leaves/csv_import');
			return;
		}

		if (
			$headers[0] != 'Employee_id' || $headers[1] != 'approver_1a' || $headers[2] != 'approver_1b' ||
			$headers[3] != 'approver_2a' || $headers[4] != 'approver_2b' || $headers[5] != 'approver_3a' || $headers[6] != 'approver_3b'
		) {

			$this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Wrong Header Name");
			redirect('leaves/csv_import');
			return;
		}

		$emp = $this->offsets_model->GET_ALL_EMP();

		$arr_data     = array();

		function convert_id($array, $data)
		{
			$empl_id = "";
			foreach ($array as $row) {
				if ($row->col_empl_cmid == $data) {
					$empl_id = $row->id;
				}
			}
			return $empl_id;
		}

		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

			$arr_data[$headers[0]] = convert_id($emp, $data[0]);
			$arr_data[$headers[1]] = convert_id($emp, $data[1]);
			$arr_data[$headers[2]] = convert_id($emp, $data[2]);
			$arr_data[$headers[3]] = convert_id($emp, $data[3]);
			$arr_data[$headers[4]] = convert_id($emp, $data[4]);
			$arr_data[$headers[5]] = convert_id($emp, $data[5]);
			$arr_data[$headers[6]] = convert_id($emp, $data[6]);

			$IS_DUPLICATE = $this->offsets_model->GET_LEAVE_APPROVER(convert_id($emp, $data[0]));

			if ($IS_DUPLICATE) {
				$this->offsets_model->UPDATE_APPROVAL_CSV($arr_data);
			} else {
				$this->offsets_model->INSERT_APPROVAL_CSV($arr_data);
			}
		}

		fclose($handle);
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Successfully uploaded data');
		redirect('leaves/approval_routes');
	}

	function types()
	{
		$data['DISP_LEAVETYPES_INFO'] = $this->offsets_model->MOD_DISP_OFFSETTYPES();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_type_views', $data);
	}

	function get_empl_leave_data()
	{
		$empl_id = $this->input->post('empl_id');
		$data = $this->offsets_model->MOD_DISP_EMPL_LEAVE_DATA($empl_id);
		echo (json_encode($data));
	}

	function offset_parameter()
	{
		$data["SYSTEM_OFFSET_SETTING"]       = $this->offsets_model->GET_SYSTEM_OFFSET_SETTING();

		$data['OFFSET_VACATION_LEAVE'] 		    = $this->offsets_model->GET_SYSTEM_SETTING_DATA('offset_vacation_leave');
		$data['OFFSET_SICK_LEAVE'] 				= $this->offsets_model->GET_SYSTEM_SETTING_DATA('offset_sick_leave');
		$this->load->view('templates/header');
		$this->load->view('modules/offsets/offset_parameters_views', $data);
	}

	function update_offset_setting()
	{
		$setting                            = "offset_setting";
		$value                              = $this->input->post('val_setting');
		$checked                            = ($value == '') ? 0 : 1;
		$this->offsets_model->MOD_UPDATE_LEAVE_SETTING($checked, $setting);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated offset settings');
		redirect("offsets/offset_parameter");
	}

	function update_general_settings()
	{
		$OFFSET_VACATION_LEAVE = 		$this->offsets_model->GET_SYSTEM_SETTING_DATA('offset_vacation_leave');
		$OFFSET_SICK_LEAVE = 				$this->offsets_model->GET_SYSTEM_SETTING_DATA('offset_sick_leave');
		$data = array(
			$OFFSET_VACATION_LEAVE['id']   => $this->input->post('update_OFFSET_VACATION_LEAVE'),
			$OFFSET_SICK_LEAVE['id'] => $this->input->post('update_OFFSET_SICK_LEAVE')
		);

		$test = $this->offsets_model->UPDATE_SYSTEM_SETTING($data);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated offset settings');
		$this->session->set_userdata('SESS_SUCC_UPDATE', 'Successfully updated!');
		redirect('offsets/offset_parameter');
	}

	function get_reporting_to_directives()
	{
		$response['errorMessage'] = 'Failed Fetching Data';
		try {
			$json_data = file_get_contents('php://input');
			$data = json_decode($json_data, true);
			$updatedData = $data['employeeId'];
			if (!isset($updatedData) || !$updatedData) {
				$response = array('error_message' => 'Invalid Id');
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
				return;
			}

			$res = $this->selfservices_model->GET_REPORTING_TO_DIRECTS($updatedData);
			if ($res) {
				$response['errorMessage'] = null;
				$response['data'] = $res;
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		} catch (Exception $e) {
			$response['errorMessage'] = 'Error Fetching Data data: ' . $e->getMessage();
			$this->output->set_content_type('application/json')->set_output(json_encode($response));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}

function filter_array($user_modules, $user_access)
{
	$modules = array();
	foreach ($user_modules as $module) {
		foreach ($user_access as $access) {
			if ($module["title"] == $access) {
				$modules[] = $module;
			}
		}
	}
	return $modules;
}

function parseJsonData($rawData) {
  $jsonData = json_decode($rawData, true);
  if (!is_array($jsonData) || json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception('Invalid JSON data');
  }
  return $jsonData;
}

