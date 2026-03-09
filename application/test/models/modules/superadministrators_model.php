<?php
    class superadministrators_model extends CI_Model{
        function GET_NAME(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 1";
            return $this->db->query($query)->row_array();
        }
        function GET_LOGO(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 2";
            return $this->db->query($query)->row_array();
        }
        function GET_NAVBAR(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 3";
            return $this->db->query($query)->row_array();
        }
        function GET_HEADER(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 4";
            return $this->db->query($query)->row_array();
        }
        function GET_MOBILE_BANNER(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 5";
            return $this->db->query($query)->row_array();
        }
        function GET_DESKTOP_BANNER(){
            $query = "SELECT * FROM tbl_system_setup WHERE id = 6";
            return $this->db->query($query)->row_array();
        }
        function GET_HEADER_CONTENT(){
            $query = "SELECT value FROM tbl_system_setup WHERE id= '24'";
            return $this->db->query($query)->row_array();
        }
        function GET_FOOTER_CONTENT(){
            $query = "SELECT value FROM tbl_system_setup WHERE id= '23'";
            return $this->db->query($query)->row_array();
        }
        //======================================= UPDATE DATA ============================================
        function MOD_UPDATE_NAME($value)
        {
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='1'";
            $query = $this->db->query($sql, array($value));
        }
        function UPDATE_HEADER_CONTENT($value){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='24'";
            $query = $this->db->query($sql, array($value));
        }
        function UPDATE_FOOTER_CONTENT($value){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='23'";
            $query = $this->db->query($sql, array($value));
        }
         function GET_SET_UP_VARIABLES(){
            $query = $this->db
              ->select('*')
              ->from('tbl_system_setup')
              ->get();
            return $query->result();
        }
        function UPDATE_SETUP_VARIABLES($data){
            
            return $this->db->update_batch('tbl_system_setup', $data, 'id');
        }
        //====================================== UPDATE IMAGE LOGO =======================================
        function INSERT_LOGO($img){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='2'";
            $query = $this->db->query($sql, $img);
        }
        function INSERT_NAVBAR($img){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='3'";
            $query = $this->db->query($sql, $img);
        }
        function INSERT_HEADER($img){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='4'";
            $query = $this->db->query($sql, $img);
        }
        function UPDATE_MOBILE_BANNER($img){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='5'";
            $query = $this->db->query($sql, $img);
        }
        function UPDATE_DESKTOP_BANNER($img){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id='6'";
            $query = $this->db->query($sql, $img);
        }
        //================================================= SUPER ADMINISTRATOR STATUS ====================================
        function GET_SADMIN_STATUS1($id){
            $sql = "SELECT * FROM tbl_employee_infos WHERE id = $id";
            return $this->db->query($sql)->row_array();
        }
        function get_sadmin_status($id){                                        //JERENZ: NO GET SADMIN STATUS FOUND IN THE SUPER ADMINISTRATOR CONTROLLER
            $sql = "SELECT * FROM tbl_employee_infos WHERE id = ?";
            $query = $this->db->query($sql,array($id));
            $query->next_result();
            return $query->result();
        }
        function GET_ALL_TABLES(){
            $tables = $this->db->list_tables();
            return $tables;
        }
        function DB_RESET($db_name){
            return $this->db->truncate($db_name);
        }
        //================================================= MODULE ACTIVATION ====================================
        function GET_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'Self-Service'";
            return $this->db->query($query)->row_array();
        }
        function GET_COMPANY_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'company'";
            return $this->db->query($query)->row_array();
        }
        function GET_EMPLOYEE_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'employee'";
            return $this->db->query($query)->row_array();
        }
        function GET_HR_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'hr'";
            return $this->db->query($query)->row_array();
        }
        function GET_ATTENDANCE_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'attendance'";
            return $this->db->query($query)->row_array();
        }
        function GET_LEAVE_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'leave'";
            return $this->db->query($query)->row_array();
        }
        function GET_PAYROLL_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'payroll'";
            return $this->db->query($query)->row_array();
        }
        function GET_REC_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'recruitment'";
            return $this->db->query($query)->row_array();
        }
        function GET_LEARN_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'learn&develop'";
            return $this->db->query($query)->row_array();
        }
        function GET_PERFORMANCE_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'performance'";
            return $this->db->query($query)->row_array();
        }
        function GET_REWARDS_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'rewards'";
            return $this->db->query($query)->row_array();
        }
        function GET_EXIT_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'exitManagement'";
            return $this->db->query($query)->row_array();
        }
        function GET_ASSET_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'asset'";
            return $this->db->query($query)->row_array();
        }
        function GET_PROJ_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'projectManagement'";
            return $this->db->query($query)->row_array();
        }
        function GET_ADMIN_STATUS(){
            $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'administrator'";
            return $this->db->query($query)->row_array();
        }
        function MOD_UPDATE_STATUS($stat, $id){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
            $query = $this->db->query($sql, array($stat, $id));
        }

        function GET_MAINTENANCE(){
            $sql = "SELECT * FROM tbl_system_setup";
            $query = $this->db->query($sql);
            $query->next_result();
            return $query->result();
        }
        function GET_TIME_OUT(){
            $sql = "SELECT id,value FROM tbl_system_setup WHERE setting='time_out'";
            $query = $this->db->query($sql);
            $query->next_result();
            return $query->row();
        }
            function MOD_UPDATE_TIME_OUT($id,$value){
                $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
                $query = $this->db->query($sql, array($value, $id));
            }

        function MOD_INSRT_ANNOUNCEMENTS($attachment){
            $sql = "INSERT INTO tbl_test (attachment) VALUES (?)";
            $query = $this->db->query($sql,array($attachment));
            return $query;
        }


        function TRUNCATE_DATABASE_TABLE($table_name){
            // return $this->db->truncate($table_name);
            return $this->db->query('TRUNCATE TABLE '. $table_name);
        }
    }