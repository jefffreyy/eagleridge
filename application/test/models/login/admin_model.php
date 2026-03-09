<?php

class admin_model extends CI_Model

{
	function GET_ALL_USERS(){
		$sql="SELECT id,col_last_name,col_frst_name,col_midl_name,col_empl_posi,disabled FROM tbl_employee_infos";
		$query = $this->db->query($sql,array());
		$query->next_result();
		return $query->result();
	}

	function GET_ALL_POSITIONS(){
		$sql="SELECT id,name FROM tbl_std_positions";
		$query = $this->db->query($sql,array());
		$query->next_result();
		return $query->result();
	}

	function LOGIN_ADMIN($username,$password){
		$sql="SELECT id FROM tbl_system_user_admin WHERE username = ? AND password = ?";
		$query = $this->db->query($sql,array($username,$password));
		$query->next_result();
		return $query->result();
	}
	
	function GET_USER_DISABLED($user_id){
		$sql="SELECT id,disabled,termination_type FROM tbl_employee_infos WHERE id=?";
		$query = $this->db->query($sql,array($user_id));
		$result = $query->result_array();
		return $result[0];
	}

	function GET_NAME(){
        $query = "SELECT * FROM tbl_system_setup WHERE id = 1";
        return $this->db->query($query)->row_array();
    }

}

?>