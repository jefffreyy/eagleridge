<?php
class administrators_model extends CI_Model
{
    function GET_USERS($limit,$offset,$is_active){
        $sql = "SELECT * FROM tbl_employee_infos 
        WHERE disabled=?
        ORDER BY col_empl_cmid ASC LIMIT $limit OFFSET $offset ";
        $query = $this->db->query($sql, array($is_active));
        $query->next_result();
        return $query->result();
    }
    function GET_INACTIVE_USER_COUNT(){
        $this->db->from('tbl_employee_infos');
        $this->db->where('disabled',1);
        $count = $this->db->count_all_results();
        return $count;
    }
    function GET_ACTIVE_USER_COUNT(){
        $this->db->from('tbl_employee_infos');
        $this->db->where('disabled',0);
        $count = $this->db->count_all_results();
        return $count;
    }
    function GET_SEARCH_USER_COUNT($search,$is_active){
        $sql="SELECT COUNT(*) as count FROM tbl_employee_infos
                Where tbl_employee_infos.disabled=? AND (  col_last_name Like '%$search%'
                OR col_midl_name LIKE '%$search%'
                OR col_midl_name LIKE '%$search%'
                OR col_empl_cmid LIKE '%$search%'
                OR exists (SELECT name from tbl_std_positions
                WHERE tbl_std_positions.id=tbl_employee_infos.col_empl_posi AND name like '%$search%')
                OR exists 
                (SELECT user_access FROM tbl_system_useraccess 	
                WHERE tbl_system_useraccess.id=tbl_employee_infos.col_user_access AND user_access like '%$search%'))
                ";
        $query = $this->db->query($sql, array($is_active));
        $row = $query->row();
        return $row->count;
    }
    function GET_SEARCHED_USERS($limit,$offset,$search,$is_active){
        $sql="SELECT * FROM tbl_employee_infos
                Where tbl_employee_infos.disabled=? AND ( col_last_name Like '%$search%'
                OR col_midl_name LIKE '%$search%'
                OR col_frst_name LIKE '%$search%'
                OR col_empl_cmid LIKE '%$search%'
                OR exists (SELECT name from tbl_std_positions
                WHERE tbl_std_positions.id=tbl_employee_infos.col_empl_posi AND name like '%$search%')
                OR exists 
                (SELECT user_access FROM tbl_system_useraccess 	
                WHERE tbl_system_useraccess.id=tbl_employee_infos.col_user_access AND user_access like '%$search%'))
                 ORDER BY col_empl_cmid ASC LIMIT $limit OFFSET $offset
                ";
        $query = $this->db->query($sql, array($is_active));
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCH_IS_ACTIVE_COUNT($search,$is_active){
        $sql="SELECT * FROM tbl_employee_infos
                Where tbl_employee_infos.disabled=? AND ( col_last_name Like '%$search%'
                OR col_midl_name LIKE '%$search%'
                OR col_frst_name LIKE '%$search%'
                OR col_empl_cmid LIKE '%$search%'
                OR exists (SELECT name from tbl_std_positions
                WHERE tbl_std_positions.id=tbl_employee_infos.col_empl_posi AND name like '%$search%')
                OR exists 
                (SELECT user_access FROM tbl_system_useraccess 	
                WHERE tbl_system_useraccess.id=tbl_employee_infos.col_user_access AND user_access like '%$search%'))
                 ORDER BY col_empl_cmid ASC
                ";
        $query = $this->db->query($sql, array($is_active));
        return $query->num_rows();
    }
    
    function GET_POSITIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_USER_ACCESS()
    {
        $sql = "SELECT id,user_access FROM tbl_system_useraccess";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_USER_COUNT($is_active){
        $this->db->from('tbl_employee_infos');
        $this->db->where('disabled',$is_active);
        $count = $this->db->count_all_results();
        return $count;
    }
    function GET_ACTIVITY_LOGS(){
        $sql="SELECT * FROM tbl_activity_logs  ORDER BY create_date DESC";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }
    function GET_EMPLOYEE_IDS(){
        $sql="SELECT id,col_empl_cmid FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }
    function SET_ACTIVATION_EMPLOYEE($id,$is_active){
        $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
        $query = $this->db->query($sql, array($is_active, $id));
    }
    //===================================================== USER ACCESS ====================================================
    function get_module_access(){
        $sql="SELECT setting,value FROM tbl_system_setup where id>=7 AND id<=40";
        $res=$this->db->query($sql)->result_array();
        $new_data=array();
        foreach($res as $res_data){
            $new_data[$res_data["setting"]]=$res_data["value"];
        }
        return $new_data;
    }
    function get_all_user_access(){
        $sql = "SELECT * FROM tbl_system_useraccess";
        return $this->db->query($sql)->result_array();
    }
    //===================================================== HOME SETTING ===================================================
    function get_home_announcement(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_announcement'";
        return $this->db->query($query)->row_array();
    }
    function get_home_celebration(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_celebration'";
        return $this->db->query($query)->row_array();
    }
    function get_home_date(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_date'";
        return $this->db->query($query)->row_array();
    }
    function get_home_leave(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_leave_info'";
        return $this->db->query($query)->row_array();
    }
    function get_home_whos_out(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_whos_out'";
        return $this->db->query($query)->row_array();
    }
    function get_home_start_guide(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_start_guide'";
        return $this->db->query($query)->row_array();
    }
    function get_home_new_member(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_new_member'";
        return $this->db->query($query)->row_array();
    }
    function GET_COMP_STRUCTURE(){
        $sql = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SYSTEM_IP_ADDRESS(){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'ip_address'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];
    }
    //===================================================== USER ACCESS ===================================================
    function add_user_access($user,$data,$modules){
        $date = date('Y-m-d H:i:s');
        if(empty($user)){
            return;
        }
        $sql = "INSERT INTO tbl_system_useraccess (create_date,edit_date,user_access,user_page,user_modules) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($date,$date,$user,$data,$modules));
        return $this->db->insert_id();
    }
    function get_user_access_by_id($id){
        $sql = "SELECT user_page FROM tbl_system_useraccess WHERE id=?";
        return $this->db->query($sql,array($id))->result_array();
    }
    function update_user_access($id,$data,$modules){
        $sql = "UPDATE tbl_system_useraccess SET user_page=?,user_modules=? WHERE id=?";
        return $this->db->query($sql,array($data,$modules,$id));
    }

    function update_user_access_data($id,$name,$data,$modules){
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_system_useraccess SET edit_date=?, user_access=?, user_page=?,user_modules=? WHERE id=?";
        return $this->db->query($sql,array($date,$name,$data,$modules,$id));
    }

    function mod_reset_user_password($empl_id, $reset_pass)
    {
        $salt=bin2hex(openssl_random_pseudo_bytes(22));
        $password= ucfirst($reset_pass);
        $encrypted_password = md5($password.''.$salt);
        
        $sql = "UPDATE tbl_employee_infos SET col_user_pass=?,col_salt_key=?,password_attempt=0, real_pass=0 WHERE id=?";
        $query = $this->db->query($sql, array($encrypted_password,$salt,$empl_id));
        if($query){
            return true;
        }
        return false;
    }

    // ===================================================== ADMINISTRATOR ==================================================
    function mod_updt_user_access($user_access, $remote_attendance,$disable, $empl_id)
    {
        $sql = "UPDATE tbl_employee_infos SET disabled=?, col_user_access=?, remote_att=? WHERE id=?";
        $query = $this->db->query($sql, array($disable,$user_access, $remote_attendance, $empl_id));
        return 'User Access Updated!';
    }

    function MOD_UPDATE_STATUS($stat, $id){
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql, array($stat, $id));
    }

    function MOD_UPDATE_IP_ADDRESS($val, $setting){
        $sql = "UPDATE tbl_system_setup SET value=? WHERE setting=?";
        $query = $this->db->query($sql, array($val, $setting));
    }

    

    function mod_insert_ip($create_date, $ip_add,$remarks, $status){
        $sql = "INSERT INTO tbl_system_whitelist (create_date, edit_date, ip_address, remarks, status) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($create_date,$create_date, $ip_add,$remarks, $status));
        return;
    }

    function get_ip_address($offset,$row){
        $sql = "SELECT * FROM tbl_system_whitelist WHERE is_deleted=0 LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function get_count_ip_address($offset,$row){
        $sql = "SELECT * FROM tbl_system_whitelist WHERE is_deleted=0 ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function get_search_ip_address($search){
        $sql = "SELECT * FROM tbl_system_whitelist WHERE is_deleted=0 
        AND (tbl_system_whitelist.ip_address LIKE '%$search%'
        OR tbl_system_whitelist.remarks LIKE '%$search%')
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function mod_delete_ip_address($id){
        $sql = "UPDATE tbl_system_whitelist SET is_deleted=1 WHERE id=?";
        $query = $this->db->query($sql, array($id));
    }

    function get_company_name(){
        $query = "SELECT * FROM tbl_system_setup WHERE id = 1";
        return $this->db->query($query)->row_array();
    }

    function get_navbar(){
        $query = "SELECT * FROM tbl_system_setup WHERE id = 3";
        return $this->db->query($query)->row_array();
    }

    function get_login_logo(){
        $query = "SELECT * FROM tbl_system_setup WHERE id = 2";
        return $this->db->query($query)->row_array();
    }

    function get_header(){
        $query = "SELECT * FROM tbl_system_setup WHERE id = 4";
        return $this->db->query($query)->row_array();
    }

    function get_header_content(){
        $query = "SELECT value FROM tbl_system_setup WHERE id= '24'";
        return $this->db->query($query)->row_array();
    }

    function update_general_setting($data){
        foreach ($data as $id => $newdata) {
            $sql = "UPDATE tbl_system_setup SET value='".$newdata."' WHERE id= '".$id."'";
            $query = $this->db->query($sql);
        }
    }

    function update_nav_logo($upload_img, $id){
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql,array($upload_img, $id));
    }

    function update_login_logo($upload_img, $id){
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql,array($upload_img, $id));
    }

    function get_old_logo($id){
        $sql = "SELECT value FROM tbl_system_setup WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row();
        return $row->value;
        
    }

    
}