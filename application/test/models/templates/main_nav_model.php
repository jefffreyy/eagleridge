<?php
class main_nav_model extends CI_Model{
    function get_user_access_page($id){
        $query = $this->db
         ->select('user_page')
         ->where('id', $id)
         ->get('tbl_system_useraccess');
        return $query->row_array(); 
    }
    function get_user_access_id($id){
        $query = $this->db
        ->select('col_user_access')
        ->where('id', $id)
        ->get('tbl_employee_infos');
       return $query->row_array(); 
    }
}