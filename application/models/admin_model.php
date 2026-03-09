<?php
class admin_model extends CI_Model
{
    function new_user($reated_at,$name_first,$name_middle,$name_last,$name_suffix,$birthdate,$gender,$mobile,$email,$password)
    {
        $sql = "INSERT INTO tbl_users (created_at,name_first,name_middle,name_last,name_suffix,birthdate,gender,mobile,email,password) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($reated_at,$name_first,$name_middle,$name_last,$name_suffix,$birthdate,$gender,$mobile,$email,$password));
    }
    
    function get_system_setup_by_setting2($setting, $value) {
        $query_select = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        if (!$result) {
            $query_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, ?)";
            $this->db->query($query_insert, array($setting,$value));
            $query_select_new = "SELECT * FROM tbl_system_setup WHERE setting=?";
            $result = $this->db->query($query_select_new, array($setting))->row_array();
        }
        return $result ? $result['value'] : null;
    }
    
}
?>