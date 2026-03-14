<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class leaves extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('templates/main_nav_model');
		$this->load->model('templates/main_table_02_model');
		$this->load->model('modules/leaves_model');
		$this->load->model('modules/selfservices_model');
		$this->load->library('system_functions');
		$this->load->library('technos_encryption');
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
			//array("title" => "Leave Request",        "icon" => "house-person-leave-duotone.svg", 		"info" => "Lets you view the leave requests and initiate the leave request process by submitting a formal request for time off.",		"url" => "leaves/leave_lists",     "access" => "Leave", "id" => "leave_request"),
			array("title" => "Leave Entitlement",    "icon" => "sliders-duotone.svg",          			"info" => "Lets you set initial allocation of a specific number of leave days or hours to each employee.",		"url" => "leaves/entitlements",    "access" => "Leave", "id" => "leave_entitlement"),
		);


		$data["title_page"]							= "Leave Management";
		$data['settings']                   		= "leaves/settings_leavepolicies";
		$data["title_description"]      			= "Allows you to oversee and administer leave policies, monitor employee absences, and ensure compliance with company regulations";

		$data['leave_request_pending_count']		= $this->leaves_model->GET_PENDING_LEAVE_COUNT();
		$data['leave_entitlement_count']			= $this->leaves_model->GET_PENDING_LEAVE_ENTITLEMENT_COUNT();
		$user_access_id								= $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
		$data['DISP_USER_ACCESS_PAGE']				= $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
		$array_page									= explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);

		$data['Modules']							= filter_array($data["Modules"], $array_page);
		$data["maiya_theme"]                        = $this->leaves_model->GET_MAYA_THEME();

		$this->load->view('templates/header');
		$this->load->view('templates/main_container', $data);
	}

	function update_entitlement_api(){
		$json_data = file_get_contents('php://input');
		$data = json_decode($json_data);
		$changes = $data->changes;
		$yearId = $data->yearId;
		$inserted = 0;
		$updated = 0;
		$failed = 0;
		foreach ($changes as $change) {
			$res = $this->leaves_model->update_entitlement_api($change, $yearId);
			if ($res == 'inserted') {
				$inserted++;
			} else if($res == 'updated') {
				$updated++;
			} else if($res == 'failed') {
				$failed++;
			}
		}
		if (($inserted > 0 || $updated > 0) && $failed < 1) {
			$this->session->set_flashdata('SUCC','Updated Successfully');
			$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave entitlement');
			$response = array(
					'messageSuccess' => 'Updated Successfully',
					'inserted' => $inserted,
					'updated' => $updated,
					'failed' => $failed,
			);


		} else if (($inserted > 0 || $updated > 0) && $failed > 0){
			$this->session->set_flashdata('ERR','Some are not Updated.');
			$response = array(
					'messageError' => 'Some are not Updated.',
					'inserted' => $inserted,
					'updated' => $updated,
					'failed' => $failed,
			);
			
		}else{
			$this->session->set_flashdata('ERR','Updating Failed');
			$response = array(
				'messageError' => 'Updating Failed',
				'inserted' => $inserted,
				'updated' => $updated,
				'failed' => $failed,
			);
		}
		$this->output->set_content_type('application/json');
		echo json_encode($response);
		// echo json_encode($changes[0]->empl_id);
	}

	function update_leaves_type(){
		$data                 = json_decode(file_get_contents('php://input'), true);


		try {
			$updatedData          = $data['updatedData'];
			$edit_user 						= $this->session->userdata('SESS_USER_ID');
			$failedInsert = 0;
			$inserted = 0;
			$failedUpdate = 0;
			$updated = 0;
			$unexpted = 0;
			foreach ($updatedData as $updatedData_row) {
				$res = $this->leaves_model->update_leaves_type($updatedData_row, $edit_user);
				if ($res == 'failedInsert') {
					$failedInsert++;
				} else if ($res == 'inserted') {
					$inserted++;
				} else if ($res == 'failedUpdate') {
					$failedUpdate++;
				} else if ($res == 'updated') {
					$updated++;
				} else {
					$unexpted++;
				}
			}
			$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave type');
			$response           = array(
				'success_message' => 'Data updated successfully',
				'failedInsert' => $failedInsert,
				'inserted' => $inserted,
				'failedUpdate' => $failedUpdate,
				'updated' => $updated,
				'unexpted' => $unexpted,
			);
		} catch (Exception $e) {
			$response           = array('warning_message' => 'Error updating data: ' . $e->getMessage());
		}
		echo json_encode($response);
	}

	function settings_leavetypes(){
		$data['DATA_LIST'] = json_encode($this->leaves_model->GET_DATA_LIST_LEAVETYPES());

		$this->load->view('templates/header');
		$this->load->view('modules/leaves/setting_leavetypes_views', $data);
	}
	function settings_leavepolicies()
	{
		$data['LEAVE_SETTINGS']     = $this->leaves_model->GET_ALL_LEAVE_SETTING();
		$data['isLeaveHours']   = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');

		$this->load->view('templates/header');
		$this->load->view('modules/leaves/setting_leavepolicies_views', $data);
	}
	function update_setting()
	{
		$input_data = $this->input->post();

		$validKeys      = ['nurse_approver', 'isLeaveHours','policy_autoapprove', 'policy_notif_onapp', 'policy_notif_email', 'policy_notif_sms', 'lwop_enable', 'lwop_reason', 'lwop_attachment', 'offset_enable', 'offset_reason', 'offset_attachment', 'sil_enable', 'sil_credit', 'sil_reason', 'sil_attachment', 'vacation_enable', 'vacation_credit', 'vacation_reason', 'vacation_attachment', 'sick_enable', 'sick_credit', 'sick_reason', 'sick_attachment', 'bereav_enable', 'bereav_credit', 'bereav_reason', 'bereav_attachment', 'maternity_enable', 'maternitycredit', 'maternityreason', 'maternityattachment', 'paternity_enable', 'paternity_credit', 'paternity_reason', 'paternity_attachment', 'soloparent_enable', 'soloparent_credit', 'soloparent_reason', 'soloparent_attachment', 'marriage_enable', 'marriage_credit', 'marriage_reason', 'marriage_attachment', 'emergency_enable', 'emergency_credit', 'emergency_reason', 'emergency_attachment', 'other_enable', 'other_credit', 'other_reason', 'other_attachment'];

		$input_data    = array_intersect_key($input_data, array_flip($validKeys));


		$res = $this->leaves_model->UPDATE_LEAVE_SETTINGS($input_data);
		if ($res) {
			$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave settings');
			$this->session->set_flashdata('SUCC', 'Leave Settings Successfully updated');
		} else {
			$this->session->set_flashdata('ERR', 'Leave Settings Unable to update');
		}
		redirect('leaves/settings_leavepolicies');
	}

	function leave_lists()
	{
		$data['LEAVES']             				= array();
		$status                     				= $this->input->get('status');
		$limit                      				= $this->input->get('row') ? $this->input->get('row')  : 50;
		$page                      					= $this->input->get('page') ? $this->input->get('page') : 1;
		$offset                     				=  $limit * ($page - 1);
		$search                     				= $this->input->get('search');

		$filter_arr                 				= array();
		$filter_arr['company']      				= $this->input->get('company');
		$filter_arr['branch']      					= $this->input->get('branch');
		$filter_arr['dept']         				= $this->input->get('dept');
		$filter_arr['div']          				= $this->input->get('div');
		$filter_arr['clubhouse']          				= $this->input->get('clubhouse');
		$filter_arr['section']      				= $this->input->get('section');
		$filter_arr['group']       					= $this->input->get('group');
		$filter_arr['team']        					= $this->input->get('team');
		$filter_arr['line']        					= $this->input->get('line');

		$data['STATUS']         					= $status;
		$data['STATUSES']                               = array('Pending', 'Approved', 'Rejected', 'Withdrawed');

		$total_count 								= $this->leaves_model->GET_LEAVES_COUNT($search, $status, $filter_arr);
		$excess      								= $total_count % $limit;
		$data['C_DATA_COUNT']   					= $total_count;
		$data['PAGES_COUNT']    					= $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
		$data['PAGE']           					= $page;
		$data['ROW']            					= $limit;
		$data['C_ROW_DISPLAY']  					= array(50);

		$data['DEPARTMENTS']   	    				= $this->leaves_model->GET_STD_DATA('tbl_std_departments');
		$data['COMPANIES']     	    				= $this->leaves_model->GET_STD_DATA('tbl_std_companies');
		$data['BRANCHES']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_branches');
		$data['DIVISIONS']     	   				 	= $this->leaves_model->GET_STD_DATA('tbl_std_divisions');
		$data['CLUBHOUSE']     	   				 	= $this->leaves_model->GET_STD_DATA('tbl_std_clubhouse');
		$data['SECTIONS']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_sections');
		$data['GROUPS']        	    				= $this->leaves_model->GET_STD_DATA('tbl_std_groups');
		$data['TEAMS']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_teams');
		$data['LINES']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_lines');

		$data['DISP_VIEW_COMPANY']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DEPARTMENT']     			= $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_DIVISION']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_CLUBHOUSE']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_clubhouse");
		$data['DISP_VIEW_SECTION']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          			= $this->leaves_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_TEAM']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_LINE']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_line");

		$data['DATE_FORMAT']           			= $this->leaves_model->GET_SYSTEM_SETTING("date_format");
		// $data['DATE_FORMAT']           			= $this->leaves_model->AUTO_INSERT_SETTINGS("date_format",);
		
		$data['LEAVES']         					= $this->leaves_model->GET_LEAVES($status, $search, $limit, $offset, $filter_arr);
		$data['DISP_EMPLOYEES_NONFILTERED']     = $this->leaves_model->MOD_DISP_ALL_EMPLOYEES();

		$data['EMPLOYEES']                          = $this->leaves_model->GET_EMPLOYEES();

		$data['multiple_request']                     = $this->leaves_model->get_system_setup_by_setting('multiple_request','0'); 

		// echo '<pre>';
		// var_dump($data['DISP_VIEW_REQUIREDAPPROVERS']);die(); 
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_request_views', $data);
	}

	function edit_leave_request($request_id){

		$data['LEAVE'] = $this->leaves_model->GET_REQUEST_LEAVE($request_id);
		$data['CHILD_LEAVES'] = $this->leaves_model->GET_REQUEST_CHILD_LEAVE($request_id);
		$data['LEAVE_TYPES']    = $this->leaves_model->MOD_DISP_LEAVETYPES();
		$data['isLeaveHours']   = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');

		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Edited leave request');
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/edit_leave_request_views', $data);
	}

	function leave_recommendation(){
        $data['TABLE_DATA']                                = array();
        $cutoff                                            = $this->input->get('cutoff');
        $limit                                             = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                                              = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                                            = $limit * ($page - 1);
        $cut_off_data                                      = $this->leaves_model->GET_CUTOFF();
        $date_from                                         = '';
        $date_to                                           = '';
        $data['CUTOFF_ID']                                 = 0;
        if(!$cutoff && $cut_off_data){
            $date_from  = $cut_off_data[0]->date_from;
            $date_to    = $cut_off_data[0]->date_to;
        }
        if($cutoff){
            $cutoff_data_row    = $this->leaves_model->GET_DATA_ROW('tbl_payroll_period','id',$cutoff);
            $data['CUTOFF_ID']  = $cutoff_data_row->id; 
            if($cutoff_data_row){
                $date_from  = $cutoff_data_row->date_from;
                $date_to    = $cutoff_data_row->date_to;
            }
        }
        $data['STATUSES']                                  = array('Pending', 'Approved', 'Rejected');
        $data['TABLE_DATA']                                = $this->leaves_model->GET_ATT_RECORDS($limit,$offset,$date_from,$date_to);
        $total_count                                       = $this->leaves_model->GET_ATT_RECORDS_COUNT($date_from,$date_to);
        $excess                                            = $total_count % $limit;
        $data['C_DATA_COUNT']                              = $total_count;
        $data['PAGES_COUNT']                               = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']                                      = $page;
        $data['ROW']                                       = $limit;
        $data['C_ROW_DISPLAY']                             = array(10, 25, 50);
        $data['CUTOFF']                                    = $cut_off_data;
        $data['LEAVE_TYPES']                               = $this->leaves_model->MOD_DISP_LEAVETYPES();
        $data['LEAVE_SETTINGS']     				       = $this->leaves_model->GET_ALL_LEAVE_SETTING();
        $data['EMPLOYEES']                                  = $this->leaves_model->GET_EMPLOYEES();
        
	    $this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_recommendation_views',$data);
	}
	function leave_lists_multi()
	{
		$data['LEAVES']             				= array();
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
		$filter_arr['clubhouse']          			= $this->input->get('clubhouse');

		$filter_arr['section']      				= $this->input->get('section');
		$filter_arr['group']       					= $this->input->get('group');
		$filter_arr['team']        					= $this->input->get('team');
		$filter_arr['line']        					= $this->input->get('line');

		$data['STATUS']         					= $status;
		$data['STATUSES'] 							= array('Pending', 'Withdrawed', 'Approved', 'Rejected');

		$total_count 								= $this->leaves_model->GET_LEAVES_COUNT($search, $status, $filter_arr);
		$excess      								= $total_count % $limit;
		$data['C_DATA_COUNT']   					= $total_count;
		$data['PAGES_COUNT']    					= $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
		$data['PAGE']           					= $page;
		$data['ROW']            					= $limit;
		$data['C_ROW_DISPLAY']  					= array(10, 25, 50);

		$data['DEPARTMENTS']   	    				= $this->leaves_model->GET_STD_DATA('tbl_std_departments');
		$data['COMPANIES']     	    				= $this->leaves_model->GET_STD_DATA('tbl_std_companies');
		$data['BRANCHES']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_branches');
		$data['DIVISIONS']     	   				 	= $this->leaves_model->GET_STD_DATA('tbl_std_divisions');
		$data['SECTIONS']      	    				= $this->leaves_model->GET_STD_DATA('tbl_std_sections');
		$data['GROUPS']        	    				= $this->leaves_model->GET_STD_DATA('tbl_std_groups');
		$data['TEAMS']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_teams');
		$data['LINES']         	    				= $this->leaves_model->GET_STD_DATA('tbl_std_lines');

		$data['DISP_VIEW_COMPANY']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DEPARTMENT']     			= $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_DIVISION']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_SECTION']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          			= $this->leaves_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_TEAM']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_LINE']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_line");
		$data['DISP_VIEW_REQUIREDAPPROVERS']    = $this->leaves_model->GET_SYSTEM_SETTING("requireApprovers");
		
		$data['LEAVES']         					= $this->leaves_model->GET_LEAVES2($status, $search, $limit, $offset, $filter_arr);

		$data['DISP_EMPLOYEES_NONFILTERED']     = $this->leaves_model->MOD_DISP_ALL_EMPLOYEES_NAME();
		$data['leaveTypes']     								= $this->leaves_model->leaveTypesNames();

		$data['EMPLOYEES']                          = $this->leaves_model->GET_EMPLOYEES();
		// echo '<pre>';
		// var_dump($data['DISP_VIEW_REQUIREDAPPROVERS']);die();
		$data['isLeaveHours']  = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_request_multi_views', $data);
	}

	function new_request_leave_direct()
	{
		$data['DISP_EMPLOYEES_NONFILTERED']     = $this->leaves_model->MOD_DISP_ALL_EMPLOYEES_NAME();
		$data['leaveTypes']     				= $this->leaves_model->leaveTypesNames();
		$data['isLeaveHours']  = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/new_leave_request_direct_views', $data);
	}

	// function get_request_leave_by_date()
	// {
	// 	$rawData = file_get_contents('php://input');
	// 	$jsonData = parseJsonData($rawData);
	// 	$leaveDate = $jsonData['leave_date'];
	// 	$empl_id = $jsonData['empl_id'];
	// 	$type = $jsonData['type'];
	// 	$typeName = $jsonData['typeName'];
	// 	$display_attachment = $this->selfservices_model->SHOW_HIDE_ATTACHMENT($type);
	// 	$display_reason = $this->selfservices_model->SHOW_HIDE_REASON($type);

	// 	if (!$leaveDate) {
	// 		echo json_encode(['success' => false, 'error' => 'Invalid date received', 'data' => $jsonData,]);
	// 		return;
	// 	}
	// 	// $payrollPeriod =  $this->leaves_model->get_payroll_period($leaveDate);
	// 	// if (!$payrollPeriod) {
	// 	// 	echo json_encode(['messageError' => 'No Cut Off Period Found', 'data'=> $jsonData, 'payrollPeriod ' =>$payrollPeriod ]); return;
	// 	// }
	// 	$leaveEntitlementValue = 0;
	// 	$leaveEntitlement = 'Auto';
	// 	$year = substr($leaveDate, 0, 4);
	// 	$leaveSetting =  $this->leaves_model->GET_SETUP_SETTING('leave_setting');
	// 	if ($leaveSetting) {
	// 		$leaveEntitlementValue =  $this->leaves_model->GET_SETUP_LEAVE_SETTING(str_replace(' ', '_', $typeName));
	// 		if (!$leaveEntitlementValue) {
	// 			echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlementValue ' => $leaveEntitlementValue]);
	// 			return;
	// 		}
	// 	} else {

	// 		$leaveEntitlement =  $this->leaves_model->get_leave_entitlement($empl_id, $typeName, $year);
	// 		if (!$leaveEntitlement) {
	// 			echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlement ' => $leaveEntitlement]);
	// 			return;
	// 		}
	// 		$leaveEntitlementValue = $leaveEntitlement['value'];
	// 	}
	// 	$leaveCreditSetting  = ['sil_credit' => $this->leaves_model->GET_LEAVE_SETTING('sil_credit'),];

	// 	$dateStart = date("Y-m-d", strtotime($year . "-01-01"));
	// 	$dateEnd = date("Y-m-d", strtotime($year . "-12-31"));
	// 	$leavesTotal =  $this->leaves_model->get_leaves_total($empl_id, $type, $dateStart, $dateEnd);
	// 	$balance = $leaveEntitlementValue - $leavesTotal;
	// 	echo json_encode([
	// 		'messageSuccess' => 'Entitlement Found',
	// 		'data' => $jsonData,
	// 		'leaveEntitlement' => $leaveEntitlement,
	// 		'leavesTotal ' => $leavesTotal,
	// 		'leaveEntitlementValue' => $leaveEntitlementValue,
	// 		'balance' => $balance,
	// 		'leaveSetting' => $leaveSetting,
	// 		'leaveCredit' => $leaveCreditSetting
	// 	]);
	// 	return;
	// }

	function get_request_leave_by_date()
	{
		$rawData = file_get_contents('php://input');
		$jsonData = parseJsonData($rawData);
		$leaveDate = $jsonData['leave_date'];
		$empl_id = $jsonData['empl_id'];
		$type = $jsonData['type'];
		$year = substr($leaveDate, 0, 4);
		$dateStart = date("Y-m-d", strtotime($year . "-01-01"));
		$dateEnd = date("Y-m-d", strtotime($year . "-12-31"));
		$leavesTotal =  $this->selfservices_model->get_leaves_total($empl_id, $type, $dateStart, $dateEnd);
		$leaveEntitlementValue = 0;
		$leaveEntitlement = 'Auto';

		$display_attachment = $this->selfservices_model->SHOW_HIDE_ATTACHMENT($type);
		$display_reason = $this->selfservices_model->SHOW_HIDE_REASON($type);

		if (!$leaveDate) {
			echo json_encode(['success' => false, 'error' => 'Invalid date received', 'data' => $jsonData,]);
			return;
		}

		$typeName = $jsonData['typeName'];
		if ($typeName == "Offset") {
			$leaveEntitlement =  $this->selfservices_model->get_offset_approve_count($empl_id);
			// $leaveEntitlement = array('value' => 10);
			if (!$leaveEntitlement) {
				ob_start();
				echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlement ' => $leaveEntitlement]);
				ob_end_flush();
				return;
			}
			$leaveEntitlementValue = $leaveEntitlement['value'];


			$balance = $leaveEntitlementValue - $leavesTotal;
			echo json_encode([
				'messageSuccess' => 'Entitlement Found',
				'data' => $jsonData,
				'leaveEntitlement' => $leaveEntitlement,
				'leavesTotal ' => $leavesTotal,
				'leaveEntitlementValue' => $leaveEntitlementValue,
				'balance' => $balance,
				// 'leaveSetting' => $leaveSetting,
				'display_credit' => 1,
				'display_attachment' => $display_attachment,
				'display_reason' => $display_reason,

			]);
		} else if ($typeName == 'Leave without Pay (LWOP)') {
			echo json_encode([
				'messageSuccess' => 'Entitlement Found',
				'data' => $jsonData,
				'leaveEntitlement' => null,
				'leavesTotal ' => null,
				'leaveEntitlementValue' => null,
				'balance' => null,
				// 'leaveSetting' => $leaveSetting,
				'display_credit' => null,
				'display_attachment' => $display_attachment,
				'display_reason' => $display_reason,

			]);
		} else {
			$display_credit = $this->selfservices_model->SHOW_HIDE_CREDITS($type);

			$leaveSetting =  $this->selfservices_model->GET_SETUP_SETTING('leave_setting');
			if ($leaveSetting) {
				$leaveEntitlementValue =  $this->selfservices_model->GET_SETUP_LEAVE_SETTING(str_replace(' ', '_', $typeName));
				if (!$leaveEntitlementValue) {
					// echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlementValue ' => $leaveEntitlementValue]);
					// return;
					$leaveEntitlementValue = 0;
				}
			} else {

				$leaveEntitlement =  $this->selfservices_model->get_leave_entitlement_by_id_typeName_year($empl_id, $typeName, $year);
				if (!$leaveEntitlement) {
					// ob_start();
					// echo json_encode(['messageError' => '0', 'data' => $jsonData, 'leaveEntitlement ' => $leaveEntitlement]);
					// ob_end_flush();
					// return;
					$leaveEntitlementValue = 0;
				}
				$leaveEntitlementValue = isset($leaveEntitlement['value']) ? $leaveEntitlement['value'] : 0;
			}

			$balance = $leaveEntitlementValue - $leavesTotal;
			echo json_encode([
				'messageSuccess' => true,
				'data' => $jsonData,
				'leaveEntitlement' => $leaveEntitlement,
				'leavesTotal ' => $leavesTotal,
				'leaveEntitlementValue' => $leaveEntitlementValue,
				'balance' => $balance,
				'leaveSetting' => $leaveSetting,
				'display_credit' => $display_credit,
				'display_attachment' => $display_attachment,
				'display_reason' => $display_reason,

			]);
		}
	}

	function update_leaves(){
		$user_id 				= $this->session->userdata('SESS_USER_ID');
		$input_data 			= $this->input->post(); 
	
		$ids 					= $input_data['id']; 
		$type 					= $input_data['type'];
	
		$this->leaves_model->UPDATE_REQUEST_LEAVE($input_data);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leaves');
		$this->session->set_flashdata('SUCC', 'Leave Successfully updated');
		redirect('requests/leave_lists');
	}
	

	function add_leaves_api()
	{
		ob_start();
		ini_set('display_errors', 0);
    	error_reporting(0);
		$user_id                                    = $this->session->userdata('SESS_USER_ID');
		$input_data                                 = $this->input->post();
		$messageError = '';
		$empl_id                                    = $input_data['empl_id'];
		$type                                       = $input_data['type'];
		$dates                                      = $this->input->post('dates');
		$hours                                      = $this->input->post('hours');
		$leave_range                                = $this->input->post('leave_range');
		$current_shift 								= $this->input->post('current_shift');

        $typeName = $this->selfservices_model->get_leave_type_name_by_id($type);
		if (
			$typeName == 'Service Incentive Leave (SIL)' || $typeName == 'Vacation Leave' || $typeName == 'Sick Leave' || $typeName == 'Bereavement Leave'
			|| $typeName == 'Maternity Leave' || $typeName == 'Paternity Leave' || $typeName == 'Solo-Parent Leave' || $typeName == 'Marriage Leave' || $typeName == 'Wedding Leave'
			|| $typeName == 'Emergency Leave' || $typeName == 'Leave without Pay (LWOP)' || $typeName == 'Offset'
		) {
			$display_attachment = $this->selfservices_model->SHOW_HIDE_ATTACHMENT($type);
			$display_reason = $this->selfservices_model->SHOW_HIDE_REASON($type);
		} else {
			$display_attachment = $this->selfservices_model->get_leave_setting2('other_attachment');
			$display_reason = $this->selfservices_model->get_leave_setting2('other_reason');
		}

		if (!$input_data['reason'] && $display_reason == 1) {
			echo json_encode(array('messageError' =>  'Reason is required.'));
			return;
		}

		if (!$input_data['attachment'] && $display_attachment == 1) {
			echo json_encode(array('messageError' => 'Attachment is required.'));
			return;
		}

		unset($input_data['dates']);
		unset($input_data['hours']);
		unset($input_data['leave_range']);
		if (!(!empty($dates) && !empty($hours) && count($dates) == count($hours))) {
			echo json_encode(array('messageError' => 'Missing Dates and or Hours. Please refresh and try again'));
			return;
		}

		$firstDate = $dates[0];
		$firstDateParts = explode('-', $firstDate);
		$firstYear = $firstDateParts[0];
		$totalHours = 0;

		for ($i = 0; $i < count($dates); $i++) {
			if ($i > 0) {
				$dateParts = explode('-', $dates[$i]);
				if ($firstYear != $dateParts[0]) {
					$messageError = "Found year: " . $firstYear . " and " . $dateParts[0] . "." . " You can only apply leaves in the same year";
					echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
					return;
				}
			}
			$isLeaveHours  = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');
			$input_data['leave_date']   = $dates[$i];
			$is_duplicate = $this->leaves_model->GET_IS_DUPLICATE_DATE($input_data['empl_id'],$input_data['leave_date']);
			if ($is_duplicate < 0) {
				if (empty($messageError)) {
					$messageError = 'Already applied for date/s: ' . $dates[$i];
				} else {
					$messageError = $messageError . ', ' . $dates[$i];
				}
			}
			
			if ($isLeaveHours) {
				$totalHours = $totalHours + $hours[$i];
			}else{
				$totalHours = $totalHours + ($hours[$i] * 8);
			}
		}

		$dateStart = date("Y-m-d", strtotime($firstYear . "-01-01"));
		$dateEnd = date("Y-m-d", strtotime($firstYear . "-12-31"));
		$leavesTotal =  $this->selfservices_model->get_leaves_total($empl_id, $type, $dateStart, $dateEnd);
		$leaveEntitlementValue = 0;
		$leaveEntitlement = 'Auto';
	
		$display_attachment = $this->selfservices_model->SHOW_HIDE_ATTACHMENT($type);

		if (!$typeName) {
			echo json_encode(array('messageError' => 'Unexpected Error. Leave Type not found'));
			return;
		}

		$display_credit = $this->selfservices_model->SHOW_HIDE_CREDITS($type);
		if ($typeName == "Offset") {
			$leaveEntitlement =  $this->selfservices_model->get_offset_approve_count($empl_id);
			if ($leaveEntitlement) {
				$leaveEntitlementValue = $leaveEntitlement['value'];
			}
			$balance = $leaveEntitlementValue - $leavesTotal;
			if (!($balance >= $totalHours)) {
				if ($isLeaveHours != 0) {
					$projectedHours = $balance - $totalHours;
					echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total hours applying is: " . $totalHours . " which equal to " . $projectedHours . " projected hours"));
					return;
				}else{
					if ($balance < 8) {
						$dividedValue = $balance >= 4 ? 0.5 : 0;
					} else {
							$dividedValue = floor($balance / 8);
							if ($balance % 8 >= 4) {
									$dividedValue += 0.5;
							}
					}
					$balance = $dividedValue;

					if ($totalHours < 8) {
						$dividedHours = $totalHours >= 4 ? 0.5 : 0;
					} else {
							$dividedHours = floor($totalHours / 8);
							if ($totalHours % 8 >= 4) {
									$dividedHours += 0.5;
							}
					}
					$totalHours = $dividedHours;
					$projectedHours = $balance - $totalHours;
					echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total days applying is: " . $totalHours . " which equal to " . $projectedHours . " projected days"));
					return;
				}

			}
		} else if ($typeName != 'Leave without Pay (LWOP)' && $display_credit == 1) {
			$leaveSetting =  $this->selfservices_model->GET_SETUP_SETTING('leave_setting');
			if ($leaveSetting) {
				$leaveEntitlementValue =  $this->selfservices_model->GET_SETUP_LEAVE_SETTING(str_replace(' ', '_', $typeName));
				if (!$leaveEntitlementValue) {
					$leaveEntitlementValue = 0;
				}
			} else {
				$leaveEntitlement =  $this->selfservices_model->get_leave_entitlement_by_id_typeName_year($empl_id, $typeName, $firstYear);
				if (!$leaveEntitlement) {
					$leaveEntitlementValue = 0;
				}else{
					$leaveEntitlementValue = $leaveEntitlement['value'];
				}
			}
			$balance = $leaveEntitlementValue - $leavesTotal;
			if (!($balance >= $totalHours)) {
				
				if ($isLeaveHours != 0) {
					$projectedHours = $balance - $totalHours;
					echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total hours applying is: " . $totalHours . " which equal to " . $projectedHours . " projected hours"));
					return;
				}else{
					if ($balance < 8) {
						$dividedValue = $balance >= 4 ? 0.5 : 0;
					} else {
							$dividedValue = floor($balance / 8);
							if ($balance % 8 >= 4) {
									$dividedValue += 0.5;
							}
					}
					$balance = $dividedValue;

					if ($totalHours < 8) {
						$dividedHours = $totalHours >= 4 ? 0.5 : 0;
					} else {
							$dividedHours = floor($totalHours / 8);
							if ($totalHours % 8 >= 4) {
									$dividedHours += 0.5;
							}
					}
					$totalHours = $dividedHours;


					$projectedHours = $balance - $totalHours;
					echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total days applying is: " . $totalHours . " which equal to " . $projectedHours . " projected days"));
					return;
				}
				// echo json_encode(array('messageError' => "Insufficient Balance. Your balance is: " . $balance . " and your total hours applying is: " . $totalHours . " which equal to " . $projectedHours . " projected hours"));
				// return;
			}
		}


		if (!empty($messageError)) {
			echo json_encode(array('messageError' => $messageError . ' . Please fix and try again'));
			return;
		}
		$input_data['create_date']  = date('Y-m-d H:i:s');
		$input_data['edit_date']    = date('Y-m-d H:i:s');

		$enable_nurseapproval = $this->leaves_model->get_leave_setting2('nurse_approver'); // 1
		if ($input_data['type'] == '5') {
		  if ($enable_nurseapproval) {
			$input_data['status']       = 'Nurse';
		  } else {
			$input_data['status']       = 'Pending 1';
		  }
		} else {
		  $input_data['status']       = 'Pending 1';
		}

		// $input_data['status']       = 'Pending 1';
		$input_data['assigned_by']  = $user_id;
		$input_data['parent_id']    = null;
		// $approvers = $this->teams_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
		$approvers = $this->leaves_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
		$is_auto_approve  = $this->leaves_model->GET_LEAVE_SETTING('policy_autoapprove');
		$autoApprovedEnabled  = $this->leaves_model->getApprovalAutoApproveEnabled($input_data['empl_id']);
		if($is_auto_approve != 1 && !$autoApprovedEnabled
		&& (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
		){
			echo json_encode(array('messageError' => "No Approver. Please add approver first then try again"));
			return;
		}
		if (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)) 
		    || $is_auto_approve == 1 || !$approvers || $autoApprovedEnabled ) {
			$input_data['status'] = 'Approved';
		}

		$dateCount = count($dates);
		$parent_id = 0;
		for ($i = 0; $i < $dateCount; $i++) {
			if ($dateCount > 1 && $i == 0) {
				$input_data['parent_id'] = 0;
			}
			$input_data['leave_date']   = $dates[$i];

			if (!$isLeaveHours) {
				$hours[$i]= $hours[$i] * 8;
			}
			$input_data['duration']  = $hours[$i];
			$input_data['current_shift']  = $current_shift[$i];
			$input_data['leave_range']  = $leave_range[$i];
			// $input_data['approver1']      = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0 ;
            // $input_data['approver2']      = $approvers && $approvers->approver_2a ? $approvers->approver_2a : 0 ;
            // $input_data['approver3']      = $approvers && $approvers->approver_3a ? $approvers->approver_3a : 0 ;
            // $input_data['approver4']      = $approvers && $approvers->approver_4a ? $approvers->approver_4a : 0 ;
            // $input_data['approver5']      = $approvers && $approvers->approver_5a ? $approvers->approver_5a : 0 ;

			$input_data['approver1'] = $approvers || $approvers->approver_1a ? $approvers->approver_1a : 0;
			$input_data['approver2'] = $approvers || $approvers->approver_2a ? $approvers->approver_2a : 0;
			$input_data['approver3'] = $approvers || $approvers->approver_3a ? $approvers->approver_3a : 0;
			$input_data['approver4'] = $approvers || $approvers->approver_4a ? $approvers->approver_4a : 0;
			$input_data['approver5'] = $approvers || $approvers->approver_5a ? $approvers->approver_5a : 0;
		
			$input_data['approver1_b'] = $approvers || $approvers->approver_1b ? $approvers->approver_1b : 0;
			$input_data['approver2_b'] = $approvers || $approvers->approver_2b ? $approvers->approver_2b : 0;
			$input_data['approver3_b'] = $approvers || $approvers->approver_3b ? $approvers->approver_3b : 0;
			$input_data['approver4_b'] = $approvers || $approvers->approver_4b ? $approvers->approver_4b : 0;
			$input_data['approver5_b'] = $approvers || $approvers->approver_5b ? $approvers->approver_5b : 0;
            
			// $res  = $this->teams_model->ADD_LEAVE_REQUEST($input_data);
			$res  = $this->leaves_model->ADD_LEAVE_REQUEST($input_data);
			if ($res) {
				if ($input_data['status'] != 'Approved' && ($input_data['parent_id'] == null || $input_data['parent_id'] == 0)) {
					// $requestor      = $this->teams_model->GET_REQUESTOR('leave', $res);

					$this->create_notification = function ($approver, $res, $input_data) {

						$requestor      = $this->leaves_model->GET_REQUESTOR('leave', $res);
						$description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
						
						$token['type']          = 'approval';
						$token['table']         = 'tbl_leaves_assign';
						$token['expiration']    = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +6 days'));

						// $token['approver']              = 'approver1';
						// $token['approver_id']           = $input_data['approver1'];
						// $token['approver_date_col']     = 'approver1_date';
						// $token['id']                    = $res;

						$token = array(
							'approver' => $approver,
							'approver_id' => $approver,
							'approver_date_col' => $approver . '_date',
							'id' => $res
						);

						$json_token                     =  json_encode($token);
						$encrypted_token                = $this->technos_encryption->encryptData(json_encode($json_token));
						$notif_data     = array(
						'create_date' => date('Y-m-d H:i:s'), 
						'empl_id' => $approver, 
						'type' => 'leave_approval',
						'content_id' => $res, 
						'location' => 'selfservices/leave_approval', 
						'description' => $description,
						'approve'=>'approvals/approve_request?token='.urlencode($encrypted_token),
						'reject'=>'approvals/reject_request?token='.urlencode($encrypted_token)
						);
						$notif = $this->leaves_model->ADD_NOTIFICATION($notif_data);

					};
					
					$approvers_list = array(
						$input_data['approver1'], $input_data['approver1_b']
					);
		  
					foreach ($approvers_list as $approver) {
						if ($approver) {
							call_user_func($this->create_notification, $approver, $res, $input_data);
						}
					}
				}
				// $input_data['parent_id'] = $res;

				if($parent_id == 0){
					$parent_id = $res;
				}
		  
				$input_data['parent_id'] = $parent_id;

			} else {
				if (empty($messageError)) {
					// $messageError ='Failed to date/s: '.$dates[$i];
					$messageError = 'Failed to date/s: ' . date('d/m/Y', strtotime($dates[$i]));
				} else {
					// $messageError = $messageError.', '.$dates[$i];
					$messageError = $messageError . ', ' . date('d/m/Y', strtotime($dates[$i]));
				}
			}
		}
		if (!empty($messageError)) {
			echo json_encode(array('messageError' => $messageError . ' . Please reload page and try again'));
			return;
		}
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added leave via API');
		$this->session->set_flashdata('SUCC', 'Successfully Added');
		echo json_encode(array('messageSuccess' => 'Successfully Submitted'));
	}

	function request_leave()
	{
		//    $this->mailers->sendMail('aldrinlobis1@gmail.com','Aldrin');
		//    redirect('emails');
		// $validKeys = ['lwop_enable', 'offset_enable', 'sil_enable', 'vacation_enable', 'sick_enable', 'bereav_enable', 'maternity_enable', 'paternity_enable', 'soloparent_enable', 'marriage_enable', 'emergency_enable', 'other_enable'];

		// $credits = ['sil_credit', 'vacation_credit', 'sick_credit', 'bereav_credit', 'maternitycredit', 'paternity_credit', 'soloparent_credit', 'marriage_credit', 'emergency_credit', 'other_credit'];

		$data['LEAVE_SETTINGS']     				= $this->leaves_model->GET_ALL_LEAVE_SETTING();

		// $data['LEAVE_TYPE']   						= $this->leaves_model->MOD_DISP_LEAVETYPES();
		$data['LEAVE_TYPES']   						= $this->leaves_model->GET_LEAVE_TYPES_ACTIVE();

		// $data['settings']							= $this->leaves_model->MOD_DISP_LEAVE_TYPE_AND_SETTINGS();

		$data['EMPLOYEES']                          = $this->leaves_model->GET_EMPLOYEES();
		$data['isLeaveHours']   = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');

		// var_dump($data['settings']);

		$this->load->view('templates/header');
		$this->load->view('modules/leaves/new_leave_request_views', $data);
	}

	function insert_leaves_direct()
	{
		$json_data = file_get_contents('php://input');
		$data = json_decode($json_data, true);

		$updatedLeaves = [];
		$notUpdatedLeaves = [];
		$is_duplicate = null;
		// $resArray = [];
		// $data_rowArray = [];
		foreach ($data as $data_row) {
			$modified_data_row = $data_row;

			$modified_data_row['empl_id'] = $this->leaves_model->GET_EMPLOYEE_TABLE_ID($data_row['employee']);

			if ($modified_data_row['empl_id'] === null) {
				$notUpdatedLeaves[] = $data_row['employee'] . ' with Date ' . $data_row['leave_date'] . '(ID Not Found)';
				continue;
			}
			$date = $modified_data_row['leave_date'];
			$empl_id = $modified_data_row['empl_id'];
			$is_duplicate = $this->leaves_model->GET_LEAVE_IS_DUPLICATE_DATE($date, $empl_id);
			if ($is_duplicate < 0) {
				$notUpdatedLeaves[] = $data_row['employee'] . ' with Date ' . $data_row['leave_date'] . '(Duplicate Employee and Date)';
				continue;
			}

			$modified_data_row['create_date'] = date('Y-m-d H:i:s');
			$modified_data_row['edit_date'] = date('Y-m-d H:i:s');
			$modified_data_row['status'] = 'Approved';
			unset($modified_data_row['id']);
			unset($modified_data_row['employee']);
			unset($modified_data_row['c_id']);
			$res = $this->leaves_model->ADD_LEAVE_REQUEST($modified_data_row);
			$resArray[] = $res;

			if ($res) {
				$updatedLeaves[] = $data_row['employee'] . ' with Date ' . $data_row['leave_date'];
			} else {
				$notUpdatedLeaves[] = $data_row['employee'] . ' with Date ' . $data_row['leave_date'];
			}
			// $data_rowArray[] = $modified_data_row;
		}
		$joinedupdatedLeaves = '';
		$joinednotUpdatedLeaves = '';
		if (count($updatedLeaves) > 0 && count($notUpdatedLeaves) < 1) {
			$joinedupdatedLeaves = implode(', ', $updatedLeaves);
			$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Inserted leave directly');
			$this->session->set_flashdata('SUCC', 'Successfully added: ' . $joinedupdatedLeaves);
		} else {
			$joinednotUpdatedLeaves = implode(', ', $notUpdatedLeaves);
			$joinedupdatedLeaves = implode(', ', $updatedLeaves);
			if ($joinedupdatedLeaves) {
				$this->session->set_flashdata('ERR', 'Successfully added: ' . $joinedupdatedLeaves . '. But failed to add: ' . $joinednotUpdatedLeaves);
			} else {
				$this->session->set_flashdata('ERR', 'Unable to add: ' . $joinednotUpdatedLeaves);
			}
		}
		$response = array(
			'reload' => true,
			'joinedupdatedLeaves' => $joinedupdatedLeaves,
			'joinednotUpdatedLeaves' => $joinednotUpdatedLeaves,
			// 'resArray' => $resArray,
			// 'data_rowArray' => $data_rowArray,
			'date' => $date,
			'empl_id' => $empl_id,
			'$is_duplicate' => $is_duplicate,
		);

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	function update_leaves_direct()
	{
		$json_data = file_get_contents('php://input');
		$data = json_decode($json_data, true);
		// $res = $this->employees_model->UPDATE_WORK_HISTORY_ALL($data_row,$this->session->userdata('SESS_USER_ID'));

		$updatedLeaves = [];
		$notUpdatedLeaves = [];
		$is_duplicate = null;
		// $resArray = [];
		// $data_rowArray = [];
		foreach ($data as $data_row) {
			$modified_data_row = $data_row;

			$modified_data_row['edit_date'] = date('Y-m-d H:i:s');
			$modified_data_row['empl_id'] = $this->leaves_model->GET_EMPLOYEE_TABLE_ID($data_row['employee']);

			if ($modified_data_row['empl_id'] === null) {
				$notUpdatedLeaves[] = $data_row['c_id'] . '(ID Not Found)';
				continue;
			}
			$date = $modified_data_row['leave_date'];
			$empl_id = $modified_data_row['empl_id'];
			$id = $modified_data_row['id'];

			$is_duplicate = $this->leaves_model->GET_LEAVE_IS_DUPLICATE_DATE_BY_ID($date, $empl_id, $id);
			if ($is_duplicate < 0) {
				$notUpdatedLeaves[] = $data_row['c_id'] . '(Duplicate Employee and Date)';
				continue;
			}

			unset($modified_data_row['id']);
			unset($modified_data_row['employee']);
			unset($modified_data_row['employee_table_id']);
			unset($modified_data_row['assigned_table_id']);

			$res = $this->leaves_model->UPDATE_LEAVE($modified_data_row, $id);
			$resArray[] = $res;

			if ($res) {
				$updatedLeaves[] = $data_row['c_id'];
			} else {
				$notUpdatedLeaves[] = $data_row['c_id'];
			}
			// $data_rowArray[] = $modified_data_row;
		}
		$joinedupdatedLeaves = '';
		$joinednotUpdatedLeaves = '';

		// if (count($updatedLeaves) > 0) {
		// 		$joinedupdatedLeaves = implode(', ', $updatedLeaves);
		// 		$this->session->set_flashdata('SUCC', 'Successfully updated: ' . $joinedupdatedLeaves);
		// } else {
		// 	$joinednotUpdatedLeaves = implode(', ', $notUpdatedLeaves);
		// 	$this->session->set_flashdata('ERR', 'Unable to update'. $joinednotUpdatedLeaves);
		// }
		if (count($updatedLeaves) > 0 && count($notUpdatedLeaves) < 1) {
			$joinedupdatedLeaves = implode(', ', $updatedLeaves);
			$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave directly');
			$this->session->set_flashdata('SUCC', 'Successfully updated: ' . $joinedupdatedLeaves);
		} else {
			$joinednotUpdatedLeaves = implode(', ', $notUpdatedLeaves);
			$joinedupdatedLeaves = implode(', ', $updatedLeaves);
			if ($joinedupdatedLeaves) {
				$this->session->set_flashdata('ERR', 'Successfully updated: ' . $joinedupdatedLeaves . '. But failed to update: ' . $joinednotUpdatedLeaves);
			} else {
				$this->session->set_flashdata('ERR', 'Unable to update: ' . $joinednotUpdatedLeaves);
			}
		}
		$response = array(
			'reload' => true,
			'joinedupdatedLeaves' => $joinedupdatedLeaves,
			'joinednotUpdatedLeaves' => $joinednotUpdatedLeaves,
			// 'resArray' => $resArray,
			// 'data_rowArray' => $data_rowArray,
			'date' => $date,
			'empl_id' => $empl_id,
			'id' => $id,
			'$is_duplicate' => $is_duplicate,
		);

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	function add_new_leave_old()
	{
		$isApproversEnable                  = $this->leaves_model->GET_SETUP_SETTING('requireApprovers');
		$user_id                            = $this->session->userdata('SESS_USER_ID');
		// $attachment                         = $_FILES['attachment']['name'];
		$input_data                         = $this->input->post();
		$input_data['assigned_by']          = $user_id;
		$input_data['status']               = $isApproversEnable == 1 ? 'Pending 1' : 'Approved';
		// $file_info = pathinfo($attachment);
		$input_data['create_date']                        = date('Y-m-d H:i:s');
		$input_data['edit_date']                          = date('Y-m-d H:i:s');
		$employee                                         = $this->leaves_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
		$approvers = $this->leaves_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
		$approver = $approvers->approver_1a ? $approvers->approver_1a : 0;
		if ($approver == 0) {
			$this->session->set_flashdata('ERR', 'No Approver Assign');
			redirect('leaves/request_leave');
			return;
		}
		$is_duplicate                                     = $this->leaves_model->GET_IS_DUPLICATE_DATE($input_data['leave_date']);

		if ($is_duplicate > 0) {
			$this->session->set_flashdata('ERR', "Leave submission failed. It looks like you have already submitted a leave request for the same dates.");
			redirect('leaves/request_leave');
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
			$res                                            = $this->leaves_model->ADD_LEAVE_REQUEST($input_data);
			if ($res) {
				$this->session->set_flashdata('SUCC', 'Successfully added');
				if ($isApproversEnable == 0) {
					redirect('leaves/leave_lists');
					return;
				}
				$requestor      = $this->leaves_model->GET_REQUESTOR('leave', $res);
				$description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
				$notif_data     = array(
					'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $approvers->approver_1a, 'type' => 'leave',
					'content_id' => $res, 'location' => 'selfservices/leave_approval', 'description' => $description
				);
				$notif = $this->leaves_model->ADD_NOTIFICATION($notif_data);
			} else {
				$this->session->set_flashdata('ERR', 'Fail to add new data');
				redirect('leaves/request_leave');
				return;
			}
		}
		// 		$input_data                 				= $this->input->post();
		// 		$attachment                 				= $_FILES['attachment']['name'];
		// 		$file_info = pathinfo($attachment);
		// 		$input_data['create_date']  				= date('Y-m-d H:i:s');
		// 		$input_data['edit_date']    				= date('Y-m-d H:i:s');
		// 		$employee                   				= $this->leaves_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
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
		// 		$res = $this->leaves_model->ADD_LEAVE_REQUEST($input_data);
		// 		if ($res) {
		// 			$this->session->set_flashdata('SUCC', 'Successfully added new request');
		// 		} else {
		// 			$this->session->set_flashdata('ERR', 'Fail to add new request');
		// 			redirect('leaves/request_leave');
		// 			return;
		// 		}
		redirect('leaves/leave_lists');
	}

	function add_new_leave()
	{
		$isApproversEnable                  = $this->leaves_model->GET_SYSTEM_SETTING('requireApprovers');
		$user_id                            = $this->session->userdata('SESS_USER_ID');
		$is_auto_approved                   = $this->leaves_model->GET_LEAVE_SETTING('policy_autoapprove');
		// $attachment                         = $_FILES['attachment']['name'];
		$input_data                         = $this->input->post();
		$input_data['assigned_by']          = $user_id;
		$input_data['status']               = 'Pending 1';
		// $file_info = pathinfo($attachment);
		$input_data['create_date']                        = date('Y-m-d H:i:s');
		$input_data['edit_date']                          = date('Y-m-d H:i:s');
		$employee                                         = $this->leaves_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
		$approvers = $this->leaves_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
		$approver = $approvers->approver_1a ? $approvers->approver_1a : 0;
		// 		if ($approver == 0) {
		// 			$this->session->set_flashdata('ERR', 'No Approver Assign');
		// 			redirect('leaves/request_leave');
		// 			return;
		// 		}
		if (($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0) || $is_auto_approved->value == 1) {
			$input_data['status'] = 'Approved';
		}
		// echo '<pre>';
		// var_dump($approvers);
		// return;
		$dates = $this->input->post('dates');
		$hours = $this->input->post('hours');
		$leave_range = $this->input->post('leave_range');

		unset($input_data['dates']);
		unset($input_data['hours']);
		unset($input_data['leave_range']);

		if (!empty($dates) && !empty($hours) && count($dates) == count($hours)) {
			$added = [];
			$notAdded = [];
			for ($i = 0; $i < count($dates); $i++) {
				$input_data['leave_date']   = $dates[$i];
				$input_data['duration']  = $hours[$i];
				$input_data['leave_range']  = $leave_range[$i];
				$is_duplicate = $this->leaves_model->GET_IS_DUPLICATE_DATE($input_data['empl_id'], $input_data['leave_date']);
				if ($is_duplicate > 0) {
					$notAdded[] = 'Date: ' . $dates[$i] . '(Duplicate)';
					continue;
				}
				$res  = $this->leaves_model->ADD_LEAVE_REQUEST($input_data);

				if ($res && $input_data['status'] != 'Approved') {
					$requestor      = $this->leaves_model->GET_REQUESTOR('leave', $res);
					$description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
					$notif_data     = array(
						'create_date' => date('Y-m-d H:i:s'), 
						'empl_id' => $approvers->approver_1a, 
						'type' => 'leave',
						'content_id' => $res, 
						'location' => 'selfservices/leave_approval',
						'description' => $description
					);
					$notif = $this->leaves_model->ADD_NOTIFICATION($notif_data);
				}

				if ($res) {
					$added[] = 'Date: ' . $dates[$i];
				} else {
					$notAdded[] = 'Date: ' . $dates[$i];
				}
			}

			$joinedAdded = '';
			$joinedNotAdded = '';
			if (count($added) > 0 && count($notAdded) < 1) {
				$joinedAdded = implode(', ', $added);
				$this->session->set_flashdata('SUCC', 'Successfully added: ' . $joinedAdded);
				redirect('leaves/leave_lists');
			} else {
				$joinedNotAdded = implode(', ', $notAdded);
				$joinedAdded = implode(', ', $added);
				if ($joinedAdded) {
					$this->session->set_flashdata('ERR', 'Successfully added: ' . $joinedAdded . '. But failed to add: ' . $joinedNotAdded);
				} else {
					$this->session->set_flashdata('ERR', 'Unable to add: ' . $joinedNotAdded);
				}
				redirect('leaves/request_leave');
			}
		} else {
			$this->session->set_flashdata('ERR', 'Unable to add: No Dates Submitted');
			redirect('leaves/request_leave');
		}

		// $is_duplicate                                     = $this->teams_model->GET_IS_DUPLICATE_DATE($input_data['empl_id'], $input_data['leave_date']);
		// echo '<pre>';
		// var_dump($is_duplicate);
		// return;

		// if ($is_duplicate > 0) {
		//   $this->session->set_flashdata('ERR', "Leave submission failed. It looks like you have already submitted a leave request for the same dates.");
		//   redirect('teams/request_leave');
		//   return;
		// } else {
		//   $res                                            = $this->teams_model->ADD_LEAVE_REQUEST($input_data);
		//   if ($res) {
		//     $this->session->set_flashdata('SUCC', 'Successfully added');
		//     if ($isApproversEnable == 0) {
		//       redirect('teams/apply_leaves');
		//       return;
		//     }
		//     $requestor      = $this->teams_model->GET_REQUESTOR('leave', $res);
		//     $description    = "Leave Application Review for [LEA" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
		//     $notif_data     = array(
		//       'create_date' => date('Y-m-d H:i:s'), 'empl_id' => $approvers->approver_1a, 'type' => 'leave',
		//       'content_id' => $res, 'location' => 'selfservices/leave_approval', 'description' => $description
		//     );
		//     $notif = $this->teams_model->ADD_NOTIFICATION($notif_data);
		//   } else {
		//     $this->session->set_flashdata('ERR', 'Fail to add new data');
		//     redirect('teams/request_leave');
		//     return;
		//   }
		// }
		// redirect('teams/apply_leaves');
		redirect('leaves/leave_lists');
	}

	function edit_leaves($id)
	{
		$data['EMPLOYEES']      = $this->leaves_model->GET_EMPLOYEELIST();
		$data['LEAVE']       	= $this->leaves_model->GET_LEAVE($id);
		$data['LEAVE_TYPES']    = $this->leaves_model->MOD_DISP_LEAVETYPES();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/edit_leave_views', $data);
	}

	function update_leave($id)
	{
		$input_data = $this->input->post();
		$res = $this->leaves_model->UPDATE_LEAVE($input_data, $id);
		if ($res) {
			$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave');
			$this->session->set_flashdata('SUCC', 'Successfully updated');
		} else {
			$this->session->set_flashdata('ERR', 'Unable to update');
		}
		redirect('leaves/leave_lists');
	}

	function show_leave($id)
	{
		$data['EMPLOYEES']      = $this->leaves_model->GET_EMPLOYEELIST();
		$data['LEAVE']       	= $this->leaves_model->GET_LEAVE($id);
		$data['LEAVE_TYPES']    = $this->leaves_model->MOD_DISP_LEAVETYPES();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/show_leave_views', $data);
	}

	function withdraw_leave()
	{
		$id = $this->input->post('rowId');
		$status = "Withdrawed";
		$res = $this->leaves_model->MOD_UPDATE_LEAVE_STATUS($id, $status);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Withdrew leave request');
		echo $res;
		// $this->session->set_userdata('SUCC', 'Withdraw Leave Updated Successfully!');
		// redirect('selfservices/my_leaves');
	}

	function get_leave_approval_status($id)
	{
		$data['LEAVE'] = $this->leaves_model->GET_LEAVE_APPROVAL_STATUS($id);
		$data['tableData'] = $this->leaves_model->GET_LEAVE_APPROVAL_TABLE_DATA($id);
		$data['hours'] = $this->leaves_model->GET_LEAVE_APPROVAL_HOURS($id);
		$data['days'] = count($data['tableData']);
		$this->load->view('modules/partials/_approval_modal_content', $data);
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
			$empl_info 			= $this->leaves_model->MOD_DISP_EMPLOYEE($employee_id);
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
			$leave_balance 						= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
			if ($leave_balance[$col_leave_type] >= $duration) {
				$approval_route 				= $this->leaves_model->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($employee_id);
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
							$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
							$total_leave_balance 	= $leave_balance[$col_leave_type];
							$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
							$data_upload 			= array('INSRT_LEAVE_FILE' => $this->upload->data());
							$leave_file 			= $data_upload['INSRT_LEAVE_FILE']['file_name'];
							$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
							foreach ($approval_route as $approval_route_row) {
								$my_user_id 		= $this->session->userdata('SESS_USER_ID');
								if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1($status, $leave_insrt_id);
									echo 'approver 1 ' . $leave_insrt_id . ' <br>';
								}
								if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2($status, $leave_insrt_id);
									echo 'approver 2 ' . $leave_insrt_id . ' <br>';
								}
								if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
									$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3($status, $leave_insrt_id);
									echo 'approver 3 ' . $leave_insrt_id . ' <br>';
								}
							}
							$recievers_arr = [];
							$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
							$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
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
							$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned leave');
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
						$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
						$total_leave_balance 	= $leave_balance[$col_leave_type];
						$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
						$leave_file = '';
						$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
						foreach ($approval_route as $approval_route_row) {
							$my_user_id		 	= $this->session->userdata('SESS_USER_ID');
							if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1($status, $leave_insrt_id);
								echo 'approver 1 ' . $leave_insrt_id . ' <br>';
							}
							if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2($status, $leave_insrt_id);
								echo 'approver 2 ' . $leave_insrt_id . ' <br>';
							}
							if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3($status, $leave_insrt_id);
								echo 'approver 3 ' . $leave_insrt_id . ' <br>';
							}
						}
						$recievers_arr = [];
						$get_group_approver = $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
						$get_leave_approver = $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
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
						$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned leave');
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
					$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
					$total_leave_balance 	= $leave_balance[$col_leave_type];
					$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
					$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_SINGLE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $total_leave_balance);
					foreach ($approval_route as $approval_route_row) {
						$my_user_id 		= $this->session->userdata('SESS_USER_ID');
						if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
						}
						if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
						}
						if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
							$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
						}
					}
					$recievers_arr 			= [];
					$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
					$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
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
					$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned leave');
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
			$empl_info 						= $this->leaves_model->MOD_DISP_EMPLOYEE($employee_id);
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
			$leave_balance 						= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
			if ($leave_balance[$col_leave_type] >= $duration) {
				$approval_route 				= $this->leaves_model->MOD_DISP_SPECIFIC_APPROVAL_ROUTE($employee_id);
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
							$leave_balance 				= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
							$total_leave_balance 		= $leave_balance[$col_leave_type];
							$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
							if ($date_from != $date_to) {
								$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
								foreach ($approval_route as $approval_route_row) {
									$my_user_id 		= $this->session->userdata('SESS_USER_ID');
									if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
										$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
										$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
										$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
									}
								}
								$recievers_arr 			= [];
								$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
								$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
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
								$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned leave');
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
							$leave_balance 			= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
							$total_leave_balance = $leave_balance[$col_leave_type];
							$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
							if ($date_from != $date_to) {
								$leave_insrt_id 	= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $total_leave_balance);
								foreach ($approval_route as $approval_route_row) {
									$my_user_id 	= $this->session->userdata('SESS_USER_ID');
									if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
										$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
										$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
									}
									if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
										$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
									}
								}
								$recievers_arr = [];
								$get_group_approver = $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
								$get_leave_approver = $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
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
								$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned leave');
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
					$leave_balance 				= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($col_leave_type, $employee_id);
					$total_leave_balance 		= $leave_balance[$col_leave_type];
					$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($col_leave_type, $total_leave_balance, $employee_id);
					if ($date_from != $date_to) {
						$leave_insrt_id 		= $this->leaves_model->MOD_INSRT_ASSIGN_LEAVE_MULTIPLE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $total_leave_balance);
						foreach ($approval_route as $approval_route_row) {
							$my_user_id 		= $this->session->userdata('SESS_USER_ID');
							if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id)) {
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR1('Pending Approval', $leave_insrt_id);
							}
							if (($approval_route_row->approver3 == $my_user_id) || ($approval_route_row->approver4 == $my_user_id)) {
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR2('Pending Approval', $leave_insrt_id);
							}
							if (($approval_route_row->approver5 == $my_user_id) || ($approval_route_row->approver6 == $my_user_id)) {
								$this->leaves_model->MOD_UPDT_LEAVE_STATUS_APPR3('Pending Approval', $leave_insrt_id);
							}
						}
						$recievers_arr 			= [];
						$get_group_approver 	= $this->leaves_model->MOD_DISP_GROUP_APPROVERS($empl_group);
						$get_leave_approver 	= $this->leaves_model->MOD_DISP_ALL_APPR_ROUTE_LEAVE();
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
						$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned leave');
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

		$date_requested 							= $this->input->post('leave_date_requested');
		$date_leave 								= $this->input->post('leave_on_date');
		$type 										= $this->input->post('leave_type');
		$leave_reason 								= $this->input->post('edit_leave_reason');
		$duration 									= $this->input->post('edit_leave_duration');
		$status 									= $this->input->post('leave_status');
		$row_id 									= $this->input->post('row_id');
		$this->leaves_model->MOD_UPDT_LEAVE_DETAILS($date_requested, $date_leave, $type, $leave_reason, $duration, $status, $row_id);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave details');
		$this->session->set_userdata('SESS_SUCC_MSG_UPDT_APPLY_LEAVE', 'Updated Successfully');
		redirect('leaves/leave_lists');
	}

	// function entitlements2(){
	// 	$search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

	// 	if (!isset($_GET["branch"]) || $_GET["branch"] === "undefined") {
	// 		$param_branch   = "all";
	// 	} else {
	// 		$param_branch    = $_GET["branch"];
	// 	}
	// 	if (!isset($_GET["dept"]) || $_GET["dept"] === "undefined") {
	// 		$param_dept     = "all";
	// 	} else {
	// 		$param_dept      = $_GET["dept"];
	// 	}
	// 	if (!isset($_GET["division"]) || $_GET["division"] === "undefined") {
	// 		$param_division = "all";
	// 	} else {
	// 		$param_division  = $_GET["division"];
	// 	}
	// 	if (!isset($_GET["section"]) || $_GET["section"] === "undefined") {
	// 		$param_section  = "all";
	// 	} else {
	// 		$param_section   = $_GET["section"];
	// 	}
	// 	if (!isset($_GET["group"]) || $_GET["group"] === "undefined") {
	// 		$param_group    = "all";
	// 	} else {
	// 		$param_group     = $_GET["group"];
	// 	}
	// 	if (!isset($_GET["team"]) || $_GET["team"] === "undefined") {
	// 		$param_team     = "all";
	// 	} else {
	// 		$param_team      = $_GET["team"];
	// 	}
	// 	if (!isset($_GET["line"]) || $_GET["line"] === "undefined") {
	// 		$param_line     = "all";
	// 	} else {
	// 		$param_line      = $_GET["line"];
	// 	}
	// 	if (!isset($_GET["status"]) || $_GET["status"] === "undefined") {
	// 		$param_status   = "all";
	// 	} else {
	// 		$param_status    = $_GET["status"];
	// 	}

	// 	if (!isset($_GET["employee"])) {
	// 		$_GET["employee"] = "";
	// 	}
	// 	$data['CURRENT_YEAR'] = date('Y');

	// 	$data['DISP_YEARS']        		  	= $year_list 			= $this->leaves_model->GET_YEARS();
	// 	$data['VACATION_LEAVE'] 			= $VACATION_LEAVE 		= $this->leaves_model->GET_SYSTEM_SETTING_DATA_NAME('vacation_leave');
	// 	$data['SICK_LEAVE'] 				= $SICK_LEAVE 			= $this->leaves_model->GET_SYSTEM_SETTING_DATA_NAME('sick_leave');
	// 	$data["DISP_LEAVE_TYPES"] 		 	= $DISP_LEAVE_TYPES 	= $this->leaves_model->MOD_DISP_LEAVETYPES_ENTITLEMENT_NAMES();
	// 	$year = 0;
	// 	if (!isset($_GET["year"])) {
	// 		foreach ($year_list as $object) {
	// 				if (property_exists($object, 'name') && $object->name === date("Y")) {
	// 						$year = $object->id;
	// 						break;
	// 				// }else if( $year_list[0]->id){
	// 				}else if (isset($year_list) && is_array($year_list) && !empty($year_list)) {
	// 					$year = $year_list[0]->id;
	// 				}
	// 		}
	// 	} else {
	// 		$year = $_GET["year"];
	// 	}
	// 	// echo '<pre>';
	// 	// var_dump($year_list);die();
	// 	$data["DISP_ENTITLEMENT"]		    = $DISP_ENTITLEMENT	= $this->leaves_model->GET_ENTITLEMENT_DATA($year);

	// 	$data["C_ROW_DISPLAY"]              =  [25, 50, 100];
	// 	$page 								= $this->input->get('page');
	// 	$row  								= $this->input->get('row');
	// 	if ($row == null) {
	// 		$row = 25;
	// 	}
	// 	if ($page  == null) {
	// 		$page = 1;
	// 	}
	// 	$offset = $row * ($page - 1);

	// 	if ($this->input->get('all') == null) {
	// 		$data['DISP_EMP_LIST']          = $empl_list = $this->leaves_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
	// 		$DISP_EMP_LIST_TABLE            = $this->leaves_model->GET_FILTERED_EMPLOYEELIST_TABLE($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
	// 		$data['C_DATA_COUNT']           = $this->leaves_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);

	// 		foreach ($DISP_EMP_LIST_TABLE as $key => $DISP_EMP_LIST_ROW) {
	// 			$hireDate = ($DISP_EMP_LIST_ROW->col_hire_date != "0000-00-00") ? $DISP_EMP_LIST_ROW->col_hire_date : "";
	// 			$currentDate = date("Y-m-d");

	// 			if ($hireDate) {
	// 				$getYear = new DateTime();

	// 				foreach ($year_list as $DISP_YEARS_ROW) {
	// 					if ($year == $DISP_YEARS_ROW->id) {
	// 						$filteredYear = $DISP_YEARS_ROW->name;
	// 					}
	// 				}

	// 				$firstDayOfYear = $filteredYear . "-01-01";

	// 				$hired_date = new DateTime($hireDate);
	// 				$current_date = new DateTime($currentDate);
	// 				$first_day_of_year = new DateTime($firstDayOfYear);

	// 				$hiredYear = $hired_date->format("Y");

	// 				if ($hiredYear == $filteredYear) {
	// 					$daysBetween = $current_date->diff($hired_date)->days;
	// 				} else {
	// 					$daysBetween = $current_date->diff($first_day_of_year)->days;
	// 				}

	// 				$monthsBetween = $daysBetween / 30.4375;

	// 				$DISP_EMP_LIST_TABLE[$key]->monthsCount = number_format($monthsBetween, 2);

	// 				$monthsBetweenWithoutDecimal = floor($monthsBetween);

	// 				$parts1 = explode("_", $VACATION_LEAVE['setting']);
	// 				$parts2 = explode("_", $SICK_LEAVE['setting']);

	// 				$vacation_result = 0;
	// 				$sick_result = 0;

	// 				// 	foreach ($DISP_LEAVE_TYPES as $DISP_LEAVE_TYPES_ROW) {

	// 				// 		if ($DISP_LEAVE_TYPES_ROW->name == "Vacation" || $DISP_LEAVE_TYPES_ROW->name == "Sick") {

	// 				// 			if (strtolower($DISP_LEAVE_TYPES_ROW->name) == $parts1[0]) {
	// 				// 				$vacation_result = number_format($monthsBetweenWithoutDecimal * ($VACATION_LEAVE['value'] / 12), 2);
	// 				// 			} else if (strtolower($DISP_LEAVE_TYPES_ROW->name) == $parts2[0]) {
	// 				// 				$sick_result = number_format($monthsBetweenWithoutDecimal * ($SICK_LEAVE['value'] / 12), 2);
	// 				// 			}

	// 				// 			$DISP_EMP_LIST_TABLE[$key]->vacation = $vacation_result;
	// 				// 			$DISP_EMP_LIST_TABLE[$key]->sick = $sick_result;
	// 				// 		}
	// 				// 	}
	// 			}
	// 		}


	// 		$data['DISP_EMP_LIST_TABLE'] = $DISP_EMP_LIST_TABLE;
	// 	} else {
	// 		$data['DISP_EMP_LIST']            		= $this->leaves_model->GET_SEARCHED($search);
	// 		$data['C_DATA_COUNT']            		= count($this->leaves_model->GET_SEARCHED($search));
	// 	}

	// 	$data['DISP_PAYROLL_SCHED']       			= $payroll_list = $this->leaves_model->MOD_DISP_PAY_SCHED();

	// 	$data["SYSTEM_LEAVE_SETTING"]               = $this->leaves_model->GET_SYSTEM_LEAVE_SETTING();

	// 	if (!isset($_GET["period"])) {
	// 		$period = $payroll_list[0]->id;
	// 	} else {
	// 		$period = $_GET["period"];
	// 	}
	// 	$data['PERIOD_INITIAL']           			= $period;
	// 	$data['YEAR_INITIAL']           			= $year;
	// 	$res_data                         			= $this->get_employee_data();
	// 	$data['DISP_CUTOFF']              			= $res_data['cutoff_data'];
	// 	$data['DISP_WORK_SHIFT_DATA']     			= $this->leaves_model->GET_WORK_SHIFT_DATA();

	// 	$data['DISP_DISTINCT_BRANCH']     			= $this->leaves_model->MOD_DISP_DISTINCT_BRANCH();
	// 	$data['DISP_DISTINCT_DEPARTMENT'] 			= $this->leaves_model->MOD_DISP_DISTINCT_DEPARTMENT();
	// 	$data['DISP_DISTINCT_DIVISION']   			= $this->leaves_model->MOD_DISP_DISTINCT_DIVISION();
	// 	$data['DISP_DISTINCT_SECTION']    			= $this->leaves_model->MOD_DISP_DISTINCT_SECTION();
	// 	$data['DISP_DISTINCT_GROUP']      			= $this->leaves_model->MOD_DISP_DISTINCT_GROUP();
	// 	$data['DISP_DISTINCT_TEAM']       			= $this->leaves_model->MOD_DISP_DISTINCT_TEAM();
	// 	$data['DISP_DISTINCT_LINE']       			= $this->leaves_model->MOD_DISP_DISTINCT_LINE();

	// 	$data['DISP_VIEW_COMPANY']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_company");
	// 	$data['DISP_VIEW_BRANCH']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
	// 	$data['DISP_VIEW_DEPARTMENT']     			= $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
	// 	$data['DISP_VIEW_DIVISION']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_division");
	// 	$data['DISP_VIEW_SECTION']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_section");
	// 	$data['DISP_VIEW_GROUP']          			= $this->leaves_model->GET_SYSTEM_SETTING("com_group");
	// 	$data['DISP_VIEW_TEAM']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_team");
	// 	$data['DISP_VIEW_LINE']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_line");



	// 	if (!empty($DISP_EMP_LIST)) {
	// 		$data['DISP_USER_ID']             		= $data['DISP_EMP_LIST'][0]->id;
	// 	} else {
	// 		$data['DISP_USER_ID']             		= 0;
	// 	}

	// 	$date_period = $this->leaves_model->get_period_data($period);

	// 	$begin 										= new DateTime($date_period['date_from']);
	// 	$end 										= new DateTime($date_period['date_to']);
	// 	$end 										= $end->modify('+1 day');
	// 	$holidays 									= $this->leaves_model->GET_HOLIDAY();
	// 	$interval 									= new DateInterval('P1D');
	// 	$daterange 									= new DatePeriod($begin, $interval, $end);

	// 	$data['SHIFT_DATA_DATERANGE']     			= $this->leaves_model->GET_SHIFT_DATA_DATERANGE($date_period['date_from'], $date_period['date_to']);
	// 	$data['DATE_FROM']                			= $date_period['date_from'];
	// 	$data['DATE_TO']                  			= $date_period['date_to'];
	// 	$data['SHIFT_DATA']               			= $this->leaves_model->GET_SHIFT_ALL_DATA();
	// 	$data["DATE_RANGE"] 			  			= $this->assign_shift_data($daterange, $holidays);
	// 	$data['EMPLOYEES']                          = $this->leaves_model->GET_EMPLOYEES();
	// 	// echo '<pre>';
	// 	// var_dump($data['DISP_LEAVE_TYPES']);
	// 	// return;
	// 	$this->load->view('templates/header');
	// 	$this->load->view('modules/leaves/leave_entitlement_views2', $data);
	// }
	
	function entitlements()
	{
		$search                             = str_replace('_', ' ', $this->input->get('all') ?? "");

		if (!isset($_GET["branch"]) || $_GET["branch"] === "undefined") {
			$param_branch   = "all";
		} else {
			$param_branch    = $_GET["branch"];
		}
		if (!isset($_GET["dept"]) || $_GET["dept"] === "undefined") {
			$param_dept     = "all";
		} else {
			$param_dept      = $_GET["dept"];
		}
		if (!isset($_GET["division"]) || $_GET["division"] === "undefined") {
			$param_division = "all";
		} else {
			$param_division  = $_GET["division"];
		}
		if (!isset($_GET["clubhouse"]) || $_GET["clubhouse"] === "undefined") {
			$param_clubhouse = "all";
		} else {
			$param_clubhouse  = $_GET["clubhouse"];
		}
		if (!isset($_GET["section"]) || $_GET["section"] === "undefined") {
			$param_section  = "all";
		} else {
			$param_section   = $_GET["section"];
		}
		if (!isset($_GET["group"]) || $_GET["group"] === "undefined") {
			$param_group    = "all";
		} else {
			$param_group     = $_GET["group"];
		}
		if (!isset($_GET["team"]) || $_GET["team"] === "undefined") {
			$param_team     = "all";
		} else {
			$param_team      = $_GET["team"];
		}
		if (!isset($_GET["line"]) || $_GET["line"] === "undefined") {
			$param_line     = "all";
		} else {
			$param_line      = $_GET["line"];
		}
		if (!isset($_GET["status"]) || $_GET["status"] === "undefined") {
			$param_status   = "all";
		} else {
			$param_status    = $_GET["status"];
		}

		if (!isset($_GET["employee"])) {
			$_GET["employee"] = "";
		}
		$data['CURRENT_YEAR'] = date('Y');

		$data['DISP_YEARS']        		  	= $year_list 			= $this->leaves_model->GET_YEARS();
		$data['VACATION_LEAVE'] 			= $VACATION_LEAVE 		= $this->leaves_model->GET_SYSTEM_SETTING_DATA_NAME('vacation_leave');
		$data['SICK_LEAVE'] 				= $SICK_LEAVE 			= $this->leaves_model->GET_SYSTEM_SETTING_DATA_NAME('sick_leave');
		$data["DISP_LEAVE_TYPES"] 		 	= $DISP_LEAVE_TYPES 	= $this->leaves_model->GET_LEAVE_ENTITLEMENT_TYPES_ACTIVE();
		$year = 0;
		if (!isset($_GET["year"])) {
			foreach ($year_list as $object) {
					if (property_exists($object, 'name') && $object->name === date("Y")) {
							$year = $object->id;
							break;
					// }else if( $year_list[0]->id){
					}else if (isset($year_list) && is_array($year_list) && !empty($year_list)) {
						$year = $year_list[0]->id;
					}
			}
		} else {
			$year = $_GET["year"];
		}
		// echo '<pre>';
		// var_dump($year_list);die();
		$data["DISP_ENTITLEMENT"]		    = $DISP_ENTITLEMENT	= $this->leaves_model->GET_ENTITLEMENT_DATA($year);

		$data["C_ROW_DISPLAY"]              =  [50];
		$page 								= $this->input->get('page');
		$row  								= $this->input->get('row');
		if ($row == null) {
			$row = 50;
		}
		if ($page  == null) {
			$page = 1;
		}
		$offset = $row * ($page - 1);

		if ($this->input->get('all') == null) {
			$data['DISP_EMP_LIST']          = $empl_list = $this->leaves_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
			$DISP_EMP_LIST_TABLE            = $this->leaves_model->GET_FILTERED_EMPLOYEELIST_TABLE($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
			$data['C_DATA_COUNT']           = $this->leaves_model->GET_COUNT_FILTERED_EMPLOYEE($param_branch, $param_dept, $param_division,  $param_clubhouse, $param_section, $param_group, $param_team, $param_line);

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

					// 	foreach ($DISP_LEAVE_TYPES as $DISP_LEAVE_TYPES_ROW) {

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
			$DISP_EMP_LIST_TABLE            = $this->leaves_model->GET_FILTERED_EMPLOYEELIST_TABLE_ID($search);
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
				}
			}

			$data['DISP_EMP_LIST_TABLE'] = $DISP_EMP_LIST_TABLE;
			$data['DISP_EMP_LIST']            		= $this->leaves_model->GET_SEARCHED($search);
			$data['C_DATA_COUNT']            		= count($this->leaves_model->GET_SEARCHED($search));
		}

		$data['DISP_PAYROLL_SCHED']       			= $payroll_list = $this->leaves_model->MOD_DISP_PAY_SCHED();

		$data["SYSTEM_LEAVE_SETTING"]               = $this->leaves_model->GET_SYSTEM_LEAVE_SETTING();

		if (!isset($_GET["period"])) {
			$period = $payroll_list[0]->id;
		} else {
			$period = $_GET["period"];
		}
		$data['PERIOD_INITIAL']           			= $period;
		$data['YEAR_INITIAL']           			= $year;
		$res_data                         			= $this->get_employee_data();
		$data['DISP_CUTOFF']              			= $res_data['cutoff_data'];
		$data['DISP_WORK_SHIFT_DATA']     			= $this->leaves_model->GET_WORK_SHIFT_DATA();

		$data['DISP_DISTINCT_BRANCH']     			= $this->leaves_model->MOD_DISP_DISTINCT_BRANCH();
		$data['DISP_DISTINCT_DEPARTMENT'] 			= $this->leaves_model->MOD_DISP_DISTINCT_DEPARTMENT();
		$data['DISP_DISTINCT_DIVISION']   			= $this->leaves_model->MOD_DISP_DISTINCT_DIVISION();
		$data['DISP_DISTINCT_CLUBHOUSE']   			= $this->leaves_model->MOD_DISP_DISTINCT_CLUBHOUSE();
		$data['DISP_DISTINCT_SECTION']    			= $this->leaves_model->MOD_DISP_DISTINCT_SECTION();
		$data['DISP_DISTINCT_GROUP']      			= $this->leaves_model->MOD_DISP_DISTINCT_GROUP();
		$data['DISP_DISTINCT_TEAM']       			= $this->leaves_model->MOD_DISP_DISTINCT_TEAM();
		$data['DISP_DISTINCT_LINE']       			= $this->leaves_model->MOD_DISP_DISTINCT_LINE();

		$data['DISP_VIEW_COMPANY']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         			= $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DEPARTMENT']     			= $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_DIVISION']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_CLUBHOUSE']       			= $this->leaves_model->GET_SYSTEM_SETTING("com_clubhouse");
		$data['DISP_VIEW_SECTION']        			= $this->leaves_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          			= $this->leaves_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_TEAM']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_LINE']           			= $this->leaves_model->GET_SYSTEM_SETTING("com_line");



		if (!empty($DISP_EMP_LIST)) {
			$data['DISP_USER_ID']             		= $data['DISP_EMP_LIST'][0]->id;
		} else {
			$data['DISP_USER_ID']             		= 0;
		}

		$date_period = $this->leaves_model->get_period_data($period);

		$begin 										= new DateTime($date_period['date_from']);
		$end 										= new DateTime($date_period['date_to']);
		$end 										= $end->modify('+1 day');
		$holidays 									= $this->leaves_model->GET_HOLIDAY();
		$interval 									= new DateInterval('P1D');
		$daterange 									= new DatePeriod($begin, $interval, $end);

		$data['SHIFT_DATA_DATERANGE']     			= $this->leaves_model->GET_SHIFT_DATA_DATERANGE($date_period['date_from'], $date_period['date_to']);
		$data['DATE_FROM']                			= $date_period['date_from'];
		$data['DATE_TO']                  			= $date_period['date_to'];
		$data['SHIFT_DATA']               			= $this->leaves_model->GET_SHIFT_ALL_DATA();
		$data["DATE_RANGE"] 			  			= $this->assign_shift_data($daterange, $holidays);
		$data['EMPLOYEES']                          = $this->leaves_model->GET_EMPLOYEES();
		// echo '<pre>';
		// var_dump($data['DISP_LEAVE_TYPES']);
		// return; 
		$data['isLeaveHours']   = $this->leaves_model->get_leaves_settings_by_setting('isLeaveHours','1');
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_entitlement_views', $data);
	}

	function process_assigning($user_id, $entitlement_val, $year)
	{

		$type                               = $this->input->get('type');
		$response 							= $this->leaves_model->IS_DUPLICATE($user_id, $year, $type);

		if ($response == 0) {
			$this->leaves_model->ADD_USER_ENTITLEMENT($user_id, $entitlement_val, $year, $type);
		} else {
			$this->leaves_model->UPDATE_USER_ENTITLEMENT($user_id, $entitlement_val, $year, $type);
		}

		$this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
		if (isset($_SERVER["HTTP_REFERER"])) {
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}

	function update_leave_entitlement()
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

			$result 				= $this->leaves_model->IS_DUPLICATE($id, $year, $type);

			if ($result == 0) {
				$this->leaves_model->ADD_USER_ENTITLEMENT($id, $entitlement_val, $year, $type);
			} else {
				$this->leaves_model->UPDATE_USER_ENTITLEMENT($id, $entitlement_val, $year, $type);
			}
		}

		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave entitlement');
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
		$date_period 						= $this->leaves_model->GET_PERIOD_DATA($this->input->get('period'));
		if (empty($date_period)) {
			$data['employee_data'] 			= array();
			$data['cutoff_data'] 			= array();
			return $data;
		}

		$start_date 						= $date_period['date_from'];
		$end_date 							= $date_period['date_to'];
		$data['employee_data'] 				= $this->leaves_model->MOD_DISP_EMPLOYEE($employee_id);
		$data['cutoff_data'] 				= $this->leaves_model->MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id);
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
		$leave_balance 						= $this->leaves_model->MOD_GET_EMPL_CURRENT_BALANCE($db_leave_type, $employee_id);
		$total_leave_balance 				= $leave_balance[$db_leave_type] + $value;
		$this->leaves_model->MOD_UPDT_LEAVE_BALANCE($db_leave_type, $total_leave_balance, $employee_id);
		$this->leaves_model->MOD_INSRT_ENTITLEMENT($date, $leave_type, $comment, $assigned_by, $employee_id, $value, $total_leave_balance);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Inserted leave entitlement');
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

		$data['DISP_EMPLOYEES_NONFILTERED']    		= $leave_approvers          = $this->leaves_model->GET_EMPLOYEELIST();
		if ($this->input->get('all') == null) {
			$data['DISP_EMPLOYEES']    				= $leave_approvers          = $this->leaves_model->GET_FILTERED_EMPLOYEELIST($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
			$data['C_DATA_COUNT']             		= $this->leaves_model->GET_COUNT_EMPLOYEELIST();
		} else {
			$data['DISP_EMPLOYEES']                 = $leave_approvers = $this->leaves_model->GET_SEARCHED($search);
			$data['C_DATA_COUNT']                   = count($this->leaves_model->GET_SEARCHED($search));
		}

		$C_APPROVERS = array();
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

		$data['DISP_DISTINCT_BRANCH']     = $this->leaves_model->MOD_DISP_DISTINCT_BRANCH();
		$data['DISP_DISTINCT_DEPARTMENT'] = $this->leaves_model->MOD_DISP_DISTINCT_DEPARTMENT();
		$data['DISP_DISTINCT_DIVISION']   = $this->leaves_model->MOD_DISP_DISTINCT_DIVISION();
		$data['DISP_DISTINCT_SECTION']    = $this->leaves_model->MOD_DISP_DISTINCT_SECTION();
		$data['DISP_DISTINCT_GROUP']      = $this->leaves_model->MOD_DISP_DISTINCT_GROUP();
		$data['DISP_DISTINCT_TEAM']       = $this->leaves_model->MOD_DISP_DISTINCT_TEAM();
		$data['DISP_DISTINCT_LINE']       = $this->leaves_model->MOD_DISP_DISTINCT_LINE();

		$data['DISP_VIEW_COMPANY']        = $this->leaves_model->GET_SYSTEM_SETTING("com_company");
		$data['DISP_VIEW_BRANCH']         = $this->leaves_model->GET_SYSTEM_SETTING("com_branch");
		$data['DISP_VIEW_DIVISION']       = $this->leaves_model->GET_SYSTEM_SETTING("com_division");
		$data['DISP_VIEW_TEAM']           = $this->leaves_model->GET_SYSTEM_SETTING("com_team");
		$data['DISP_VIEW_DEPARTMENT']     = $this->leaves_model->GET_SYSTEM_SETTING("com_Department");
		$data['DISP_VIEW_SECTION']        = $this->leaves_model->GET_SYSTEM_SETTING("com_section");
		$data['DISP_VIEW_GROUP']          = $this->leaves_model->GET_SYSTEM_SETTING("com_group");
		$data['DISP_VIEW_LINE']           = $this->leaves_model->GET_SYSTEM_SETTING("com_line");

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
			$employees 						= $this->leaves_model->MOD_DISP_FILTER_EMPLOYEES($dept, $sec, $group, $line, $status);
		} else {
			$employees  					= $this->leaves_model->MOD_GET_SEARCHED($search);
		}

		$requests 							= $this->leaves_model->MOD_DSIP_ALL_REQUEST_FOR_APPROVAL();

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
		$data['DISP_EMPLOYEES_ID'] 			= $this->leaves_model->MOD_DISP_EMPLOYEES_ID($id);
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/empl_id_edit_views', $data);
	}

	function update_empl_id()
	{
		$user_id 							= $this->input->post('USER_ID');
		$empl_id 							= $this->input->post('UPDATE_EMPL_ID');
		$this->leaves_model->UPDATE_EMPL_ID($empl_id, $user_id);
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


			$result = $this->leaves_model->GET_LEAVE_APPROVER($id);

			if ($result) {
				$this->leaves_model->MOD_UPDT_APPROVAL_ROUTE_LEAVE($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
			} else {

				$this->leaves_model->MOD_INSERT_LEAVE_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
			}
		}

		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Assigned leave approvers');
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Updated Successfully!");

		if (isset($_SERVER["HTTP_REFERER"])) {
			redirect($_SERVER["HTTP_REFERER"]);
		}
	}

	function add_approval()
	{
		$data['DISP_EMPLOYEES']              = $this->leaves_model->MOD_DISP_ALL_EMPL();
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

		$this->leaves_model->MOD_INSERT_APPROVER_DATA($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Added leave approval');
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

		$emp = $this->leaves_model->GET_ALL_EMP();

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

			$IS_DUPLICATE = $this->leaves_model->GET_LEAVE_APPROVER(convert_id($emp, $data[0]));

			if ($IS_DUPLICATE) {
				$this->leaves_model->UPDATE_APPROVAL_CSV($arr_data);
			} else {
				$this->leaves_model->INSERT_APPROVAL_CSV($arr_data);
			}
		}

		fclose($handle);
		$this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Successfully uploaded data');
		redirect('leaves/approval_routes');
	}

	function types()
	{
		$data['DISP_LEAVETYPES_INFO'] = $this->leaves_model->MOD_DISP_LEAVETYPES();
		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_type_views', $data);
	}

	function get_empl_leave_data()
	{
		$empl_id = $this->input->post('empl_id');
		$data = $this->leaves_model->MOD_DISP_EMPL_LEAVE_DATA($empl_id);
		echo (json_encode($data));
	}

	function leave_parameter()
	{

		$data["SYSTEM_LEAVE_SETTING"]       = $this->leaves_model->GET_SYSTEM_LEAVE_SETTING();

		$data['VACATION_LEAVE'] 		    = $this->leaves_model->GET_SYSTEM_SETTING_DATA('vacation_leave');
		$data['SICK_LEAVE'] 				= $this->leaves_model->GET_SYSTEM_SETTING_DATA('sick_leave');

		$this->load->view('templates/header');
		$this->load->view('modules/leaves/leave_parameters_views', $data);
	}

	function update_leave_setting()
	{
		$setting                            = "leave_setting";
		$value                              = $this->input->post('val_setting');
		$checked                            = ($value == '') ? 0 : 1;
		$this->leaves_model->MOD_UPDATE_LEAVE_SETTING($checked, $setting);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave setting');
		redirect("leaves/leave_parameter");
	}

	function update_general_settings()
	{
		$data = array(
			60   => $this->input->post('update_vacation_leave'),
			61  => $this->input->post('update_sick_leave')
		);

		$this->leaves_model->UPDATE_SYSTEM_SETTING($data);
		$this->logger->log_activity($this->session->userdata('SESS_USER_ID'), 'Updated leave general settings');
		$this->session->set_userdata('SESS_SUCC_UPDATE', 'Successfully updated!');
		redirect('leaves/leave_parameter');
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

function parseJsonData($rawData)
{
	$jsonData = json_decode($rawData, true);
	if (!is_array($jsonData) || json_last_error() !== JSON_ERROR_NONE) {
		throw new Exception('Invalid JSON data');
	}
	return $jsonData;
}
