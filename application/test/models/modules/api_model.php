<?php
class api_model extends CI_Model{
    function GET_ALL_EMPLOYEE_ID($id){
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql,array($id));
        $query->next_result();
        return $query->result();
    }
}