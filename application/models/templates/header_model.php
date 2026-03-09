<?php
    class header_model extends CI_Model
    {
        function get_user_notifications($user_id){
            $this->db->select('*')
            ->where('empl_id',$user_id)
            ->where('is_read','0');
            $query=$this->db->get('tbl_notifications');
            return $query->num_rows();
        }
        function get_unseen_messages($userId){
            $this->db->distinct();
            $this->db->select("t1.group_id");
            $this->db->where("t1.empl_id", $userId);
            $this->db->from('tbl_message_group_members as t1');
            $query = $this->db->get();
            $first_query_result = $query->result();
            $ids = array();
            foreach ($first_query_result as $row) {
                $ids[] = $row->group_id;
            }
    
            $sql = "SELECT t1.id, t3.seen_by, t2.group_id
            FROM tbl_employee_infos AS t1
            LEFT JOIN tbl_message_group_members AS t2 ON t2.empl_id = t1.id 
            JOIN tbl_messages AS t3 ON t3.group_id = t2.group_id 
            WHERE t2.group_id IN ('" . implode("','", $ids) . "')
            AND FIND_IN_SET(?, t3.seen_by) = 0
            GROUP BY t2.group_id";
            $query = $this->db->query($sql, array($userId));
            return $query->num_rows();
        }
        function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE id = 69";
        return $this->db->query($query)->row_array();
    }

    function GET_END_TRIAL(){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting='end_trial' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        if($result){
            return $result->value;
        }else{
            return null;
        }
    }

    function CHECK_ADMIN()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'system_administrator'";
        return $this->db->query($query)->row_array();
    }
        function get_header_content()
        {
            $query = "SELECT value FROM tbl_system_setup WHERE id= '24'";
            return $this->db->query($query)->row_array();
        }
        function get_logo(){
            $query = "SELECT value FROM tbl_system_setup WHERE setting = 'loginLogo'";
            return $this->db->query($query)->row_array();
        }

        function get_navbar(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 3";
            return $this->db->query($query)->row_array();
        }

        function get_header(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 4";
            return $this->db->query($query)->row_array();
        }
        function get_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'Self-Service'";
            return $this->db->query($query)->row_array();
        }
        function get_company_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'company'";
            return $this->db->query($query)->row_array();
        }
        function get_employee_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'employee'";
            return $this->db->query($query)->row_array();
        }
        function get_hr_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'hr'";
            return $this->db->query($query)->row_array();
        }
        function get_attendance_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'attendance'";
            return $this->db->query($query)->row_array();
        }
        function get_leave_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'leave'";
            return $this->db->query($query)->row_array();
        }
        function get_offset_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'offset'";
            return $this->db->query($query)->row_array();
        }
        function get_payroll_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'payroll'";
            return $this->db->query($query)->row_array();
        }
        function get_rec_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'recruitment'";
            return $this->db->query($query)->row_array();
        }
        function get_learn_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'learn&develop'";
            return $this->db->query($query)->row_array();
        }
        function get_teams_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'teams'";
            return $this->db->query($query)->row_array();
        }
        function get_records_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'reports'";
            return $this->db->query($query)->row_array();
        }
        function get_benefits_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'benefits'";
            return $this->db->query($query)->row_array();
        }
        
        function get_performance_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'performance'";
            return $this->db->query($query)->row_array();
        }
        function get_rewards_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'rewards'";
            return $this->db->query($query)->row_array();
        }
        function get_exit_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'exitManagement'";
            return $this->db->query($query)->row_array();
        }
        function get_asset_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'asset'";
            return $this->db->query($query)->row_array();
        }
        function get_proj_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'projectManagement'";
            return $this->db->query($query)->row_array();
        }
        function get_admin_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'administrator'";
            return $this->db->query($query)->row_array();
        }
        function get_messaging_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'messaging'";
            return $this->db->query($query)->row_array();
        }
        function get_overtime_status(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'overtimes'";
            return $this->db->query($query)->row_array();
        }

        function get_sadmin_status($id){
            $sql = "SELECT * FROM tbl_employee_infos WHERE id = ?";
            $query = $this->db->query($sql,array($id));
            $query->next_result();
            return $query->result();
        }
        //==================================================== USER ACCESS ===========================================================
        function get_user_access_id($id){
            $sql="SELECT col_user_access FROM tbl_employee_infos WHERE id=? LIMIT 1";
            return $this->db->query($sql,array($id))->row_array();
        }
        function get_user_access_modules($id){
            $sql = "SELECT user_modules FROM tbl_system_useraccess WHERE id=?";
            return $this->db->query($sql,array($id))->row_array();
        }
    }
