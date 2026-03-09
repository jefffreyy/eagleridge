<?php
    class header_model extends CI_Model
    {
        function get_header_content()
        {
            $query = "SELECT value FROM tbl_system_setup WHERE id= '24'";
            return $this->db->query($query)->row_array();
        }
        function get_logo(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 2";
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
