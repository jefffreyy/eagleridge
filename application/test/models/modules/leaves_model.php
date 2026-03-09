<?php
class leaves_model extends CI_Model
{
    function GET_EMPL_INFO()                        //JERENZ: NO GET EMPL INFO FOUND IN THE LEAVES CONTROLLER
    {
        $sql = "SELECT id,name FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SECTIONS()                         //JERENZ: DISABLED IN THE LEAVES CONTROLLER
    {
        $sql = "SELECT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_YEARS()
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
   function MOD_UPDT_LEAVE_DETAILS($date_requested, $date_leave, $type, $leave_reason, $duration, $status, $row_id){
        $sql = "UPDATE tbl_leaves_assign SET col_date_created=?, col_leave_from=?, col_leave_type=?, col_leave_comments=?, col_leave_duration=?, col_leave_status1=? WHERE id = ?";
        $query = $this->db->query($sql,array($date_requested, $date_leave, $type, $leave_reason, $duration, $status, $row_id));
    }
    // Display all leave
    function MOD_DISP_ASSIGNED_LEAVE(){             //JERENZ: NO MOD DISP ASSIGNED LEAVE FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_leaves_assign ORDER BY col_date_created DESC";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    // Assign Leave
    function MOD_INSRT_ASSIGN_LEAVE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance){
        $sql = "INSERT INTO tbl_leaves_assign (col_date_created,col_leave_type,col_leave_from,col_leave_duration,col_leave_comments,col_leave_status1,col_assigned_by,col_empl_id,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array(date('Y-m-d'),$leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance));
        return;
    }
    function MOD_INSRT_ASSIGN_LEAVE_SINGLE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance){
        $sql = "INSERT INTO tbl_leaves_assign (col_date_created,col_leave_type,col_leave_from,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array(date('Y-m-d'),$leave_type, $date, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $new_leave_balance));
        return $this->db->insert_id();
    }
    function MOD_UPDT_LEAVE_STATUS_APPR1($status,$leave_insrt_id){
        $sql = "UPDATE tbl_leaves_assign SET col_leave_status1=? WHERE id = ?";
        $query = $this->db->query($sql,array($status,$leave_insrt_id));
    }
    function MOD_UPDT_LEAVE_STATUS_APPR2($status,$leave_insrt_id){
        $sql = "UPDATE tbl_leaves_assign SET col_leave_status2=? WHERE id = ?";
        $query = $this->db->query($sql,array($status,$leave_insrt_id));
    }
    function MOD_UPDT_LEAVE_STATUS_APPR3($status,$leave_insrt_id){
        $sql = "UPDATE tbl_leaves_assign SET col_leave_status3=? WHERE id = ?";
        $query = $this->db->query($sql,array($status,$leave_insrt_id));
    }
    function MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $new_leave_balance){
        $sql = "INSERT INTO tbl_leaves_assign (col_date_created,col_leave_type,col_leave_from,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_image,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array(date('Y-m-d'),$leave_type, $date, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $leave_file, $new_leave_balance));
        return $this->db->insert_id();
    }
    function MOD_INSRT_ASSIGN_LEAVE_MULTIPLE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance){
        $sql = "INSERT INTO tbl_leaves_assign (col_date_created,col_leave_type,col_leave_from,col_leave_to,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array(date('Y-m-d'),$leave_type, $date_from, $date_to, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $new_leave_balance));
        return $this->db->insert_id();
    }
    function MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $new_leave_balance){
        $sql = "INSERT INTO tbl_leaves_assign (col_date_created,col_leave_type,col_leave_from,col_leave_to,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_image,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array(date('Y-m-d'),$leave_type, $date_from, $date_to, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $leave_file, $new_leave_balance));
        return $this->db->insert_id();
    }
    
    // leave balance of the employee table
    function MOD_UPDT_LEAVE_BALANCE($leave_type, $total_leave_balance,$employee_id){
        $sql = "UPDATE tbl_employee_infos SET ".$leave_type."=? WHERE id = ?";
        $query = $this->db->query($sql,array($total_leave_balance,$employee_id));
    }
    
    function MOD_INSRT_ENTITLEMENT($date, $leave_type, $comment, $assigned_by, $employee_id, $value, $total_leave_balance){
        $sql = "INSERT INTO tbl_leave_entitlements (col_date_created,col_leave_type,col_leave_comments,col_assigned_by,col_empl_id,col_leave_value,col_leave_balance) VALUES (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($date, $leave_type, $comment, $assigned_by, $employee_id, $value, $total_leave_balance));
        return;
    }
    function MOD_GET_EMPL_CURRENT_BALANCE($leave_type,$user_id){
        $sql = "SELECT ".$leave_type." FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql,array($user_id));
        $row = $query->row_array();
        return $row;
    }
    
    // =========================================================== ENTITLEMENT LIST =============================================================
    function MOD_DISP_ENTITLEMENT(){                                        //JERENZ: NO MOD DISP ENTITLEMENT FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_leave_entitlements ORDER BY id desc";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ENTITLEMENT_LIMIT(){                                  //JERENZ: NO MOD DISP ENTITLEMENT LIMIT FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_leave_entitlements ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    
    function MOD_DISP_SPECIFIC_APPROVAL_ROUTE($empl_id){
        $sql = "SELECT * FROM tbl_leave_approvers WHERE employee=? ORDER BY id ASC";
        $query = $this->db->query($sql,array($empl_id));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_USED_LEAVE($empl_id, $start_date, $end_date){         //JERENZ: NO MOD DISP USED LEAVE FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_leaves_assign WHERE col_empl_id=? AND col_date_created>=? AND col_date_created<=? AND col_leave_status1='Approved' AND col_leave_status2='Approved' AND col_leave_status3='Approved'";
        $query = $this->db->query($sql,array($empl_id, $start_date, $end_date));
        $query->next_result();
        return $query->result();
    }
    // ============================================ AJAX ======================================================
    function MOD_DISP_EMPL_LEAVE_DATA($empl_id){
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql,array($empl_id));
        $query->next_result();
        return $query->result();
    }
    // ==================== FILTER ======================== //
    function MOD_GET_APPLICATION_INFO($empl_id, $start_date, $end_date){     //JERENZ: NO GET APPLICATION INFO FOUND IN THE LEAVES CONTROLLER           
        $sql = "SELECT * FROM tbl_leaves_assign WHERE col_leave_from >= ? AND col_leave_from <= ? AND col_empl_id=? ORDER BY col_date_created DESC";
        $query = $this->db->query($sql,array($start_date, $end_date, $empl_id));
        $query->next_result();
        return $query->result();
    }
    function MOD_GET_APPLICATION_DATE($start_date, $end_date){                 //JERENZ: NO MOD GET APPLICATION DATE FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_leaves_assign WHERE col_leave_from >= ? AND col_leave_from <= ? ORDER BY col_date_created DESC";
        $query = $this->db->query($sql,array($start_date, $end_date));
        $query->next_result();
        return $query->result();
    }   
    function MOD_GET_APPLICATION_EMPL($empl_id){                                //JERENZ: NO MOD GET APPLICATION EMPL FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_leaves_assign WHERE col_empl_id=? ORDER BY col_date_created DESC";
        $query = $this->db->query($sql,array($empl_id));
        $query->next_result();
        return $query->result();
    }
    //Approval route
    // ======================================= APPROVAL ROUTE LEAVE ====================================
    function MOD_DISP_ALL_APPR_ROUTE_LEAVE(){
        $sql = "SELECT * FROM tbl_leave_approvers ORDER BY tbl_leave_approvers.id ASC";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UPDT_APPROVAL_ROUTE_LEAVE($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b,$empl_id){
        $sql = "UPDATE tbl_leave_approvers SET edit_date=?, approver_1a=?,approver_1b=?,approver_2a=?,approver_2b=?,approver_3a=?,approver_3b=?  WHERE empl_id IN (" . $empl_id . ")";
        $query = $this->db->query($sql,array($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b));
    }
    function MOD_INSERT_LEAVE_APPROVER($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b,$empl_id){
        $sql ="INSERT INTO tbl_leave_approvers (create_date, edit_date, empl_id, approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($date,$date,$empl_id,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b));
        return;
    }

    function GET_LEAVE_APPROVER($empl_id){
        $sql = "SELECT * FROM tbl_leave_approvers WHERE empl_id=?";
        $query = $this->db->query($sql,array($empl_id));
        return $query->num_rows();
    }

    function MOD_DISP_ALL_APPR_ROUTE(){
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE termination_date = '0000-00-00' ORDER BY id ASC";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_APPR_ROUT_LIST(){
        $sql = "SELECT * FROM tbl_leave_approvers";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    
    function GET_EMPLOYEELIST(){

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,
        col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,
        col_empl_team,col_empl_line FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0
        ORDER BY col_empl_cmid ASC, col_empl_cmid";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    // function MOD_DSIP_ALL_REQUEST_FOR_APPROVAL(){
    //     $sql = "SELECT *, tbl_leaves_assign.id as id, tbl_leaves_assign.empl_id as employee_id FROM tbl_leaves_assign
    //      LEFT JOIN tbl_leave_approvers ON tbl_leave_approvers.row_id = tbl_leaves_assign.id
    //      WHERE status = 'Pending 1' || status = 'Pending 2' || status = 'Pending 3'";
    //     $query = $this->db->query($sql,array());
    //     $query->next_result();
    //     return $query->result();
    // }


    function GET_FILTERED_EMPLOYEELIST($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){
        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC, col_empl_cmid
        LIMIT ".$offset.", ".$row." ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_FILTERED_EMPLOYEE($branch,$dept,$division,$section,$group,$team,$line){
        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC";

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function GET_SEARCHED($search){
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_EMPLOYEELIST(){
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }
    function GET_EMPLOYEE_SPECIFIC_ROW($employee_id)
    {
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->row();
    }
    function ADD_LEAVE_REQUEST($data){
        return $this->db->insert('tbl_leaves_assign', $data);
    }
    function MOD_DISP_GROUP_APPROVERS($group_name){

        $sql = "SELECT * FROM tbl_approval_groups WHERE group_name=?";

        $query = $this->db->query($sql,array($group_name));

        $query->next_result();

        return $query->result();

    }
    function IS_DUPLICATE($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_leave_entitlements WHERE empl_id=? AND year=? AND type=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }
    function ADD_USER_ENTITLEMENT($user_id,$entitlement_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_leave_entitlements (create_date,edit_date,empl_id,value,year,type) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$entitlement_val, $year,$type));
    }
    function UPDATE_USER_ENTITLEMENT($user_id,$entitlement_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_leave_entitlements SET edit_date=?,value=? WHERE empl_id=? AND year=? AND type=?";
        return $this->db->query($sql,array($edit_date,$entitlement_val,$user_id,$year,$type));
    }
   

    function MOD_DISP_LEAVETYPES(){
        $sql = "SELECT * FROM tbl_std_leavetypes ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    
    function MOD_DISP_ALL_EMPLOYEES(){                          //JERENZ: NO MOD DISP ALL EMPLOYEES FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

    }

    function GET_ENTITLEMENT_DATA($year){
        $sql = "SELECT year,empl_id,type,SUM(value) as value FROM tbl_leave_entitlements WHERE year = $year GROUP BY type,year,empl_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

    }

    function MOD_DISP_FILTER_EMPLOYEES($dept,$sec,$group,$line,$status){

        if($dept){
            $filter_q = " AND col_empl_dept=".$dept;
        }else if($sec){
            $filter_q = " AND col_empl_sect=".$sec;
        }else if($group){
            $filter_q = " AND col_empl_group=".$group;
        }
        else if($line){
            $filter_q = " AND col_empl_line=".$line;
        }
        else if($status){
            $filter_q = " AND disabled=".$status;
        }else{
            $filter_q = "";
        }

        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 " .$filter_q. " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

    }

    function MOD_DISP_ALL_EMPL(){
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

    }
    function MOD_DISP_EMPLOYEE($employee_id){
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
    
    function MOD_DISP_PAY_SCHED(){

        $sql = "SELECT id,name FROM tbl_payroll_period WHERE status='active' ORDER BY id desc";
        
        $query = $this->db->query($sql,array());
        
        $query->next_result();
        
        return $query->result();
        
    }
    function MOD_DISP_DISTICT_Group(){                      //JERENZ: NO MOD DISP DISTICT GROUP FOUND IN THE LEAVES CONTROLLER

        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
    
        $query = $this->db->query($sql,array());
    
        $query->next_result();
    
        return $query->result();
    
    }
    function MOD_CHK_GROUP_APPROVERS_EXIST($group_name){        //JERENZ: NO MOD CHK GROUP APPROVERS EXIST FOUND IN THE LEAVES CONTROLLER

        $sql = "SELECT * FROM tbl_approval_groups WHERE group_name=?";

        $query = $this->db->query($sql,array($group_name));

        $query->next_result();

        return $query->result();

    }

    function UPDATE_EMPL_ID($empl_id, $user_id){
        $sql = "UPDATE tbl_employee_infos SET col_empl_cmid=? WHERE id=?";
        $this->db->query($sql, array($empl_id, $user_id));
    }

    function MOD_DISP_EMPLOYEES_ID($id){
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function MOD_INSERT_APPROVER_DATA($emp_id,$app1a,$app1b,$app2a,$app2b,$app3a,$app3b){
        $sql ="INSERT INTO tbl_leave_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUE (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($emp_id,$app1a,$app1b,$app2a,$app2b,$app3a,$app3b));
        return;
    }

    function GET_ALL_EMP(){
        $sql = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function APPROVER_IS_DUPLICATE($id){                        //JERENZ: NO APPROVER IS DUPLICATE FOUND IN THE LEAVES CONTROLLER
        $sql = "SELECT * FROM tbl_leave_approvers WHERE empl_id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->row_num();
    }

    function INSERT_APPROVAL_CSV($arr_data){
        $arr_data['create_date'] = date('Y-m-d H:i:s');
        $arr_data['edit_date'] = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_leave_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b,create_date,edit_date) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,$arr_data);
        return;
    }

    function UPDATE_APPROVAL_CSV($arr_data){
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_leave_approvers SET edit_date=?, approver_1a=?,approver_1b=?,approver_2a=?,approver_2b=?,approver_3a=?,approver_3b=?  WHERE empl_id = ?";
        $query = $this->db->query($sql,array($date,$arr_data['approver_1a'],$arr_data['approver_1b'],$arr_data['approver_2a'],$arr_data['approver_2b'],$arr_data['approver_3a'],$arr_data['approver_3b'],$arr_data['Employee_id']));
    }


    function MOD_GET_SEARCHED($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos 
        WHERE col_frst_name LIKE '$search%' OR 
        col_last_name LIKE '$search%' OR 
        col_midl_name LIKE '$search%' OR
        col_empl_group LIKE '$search%' OR
        col_empl_cmid LIKE '%$search%' ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    function GET_DEPARTMENTS()                      //JERENZ: DISABLED IN THE LEAVES CONTROLLER
    {
        $sql = "SELECT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_GROUPS()                            //JERENZ: DISABLED IN THE LEAVES CONTROLLER
    {
        $sql = "SELECT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_LINES()                             //JERENZ: DISABLED IN THE LEAVES CONTROLLER
    {
        $sql = "SELECT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
   
    function GET_SYSTEM_SETTING($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_BRANCH(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DEPARTMENT(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DIVISION(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT SECTION
    function MOD_DISP_DISTINCT_SECTION(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT Group
    function MOD_DISP_DISTINCT_GROUP(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT Group
    function MOD_DISP_DISTINCT_TEAM(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT line
    function MOD_DISP_DISTINCT_LINE(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }


}