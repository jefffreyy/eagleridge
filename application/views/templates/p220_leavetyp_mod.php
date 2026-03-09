<?php
p220_leavetyp_mod


class p220_leavetyp_mod extends CI_Model

{

// Display LEAVETYPES

function MOD_DISP_LEAVETYPES(){

$sql = "SELECT * FROM tbl_leav_type ORDER BY name";

$query = $this->db->query($sql,array());

$query->next_result();

return $query->result();

}



// Add LEAVETYPES

function MOD_INSRT_LEAVETYPES($leave_type, $from_date, $to_date, $comment, $status, $employee_id){

$sql = "INSERT INTO tbl_leav_type (col_leave_type,col_leave_from,col_leave_to,col_leave_comments,col_leave_status) VALUES (?,?,?,?,?)";

$query = $this->db->query($sql,array($leave_type, $from_date, $to_date, $comment, $status, $employee_id));

return;

}



// Display LEAVETYPES in Modal

function MOD_GET_LEAVETYPES_DATA($leavetypes_id){

$sql = "SELECT * FROM tbl_leav_type WHERE id=?";

$query = $this->db->query($sql,array($leavetypes_id));

$query->next_result();

return $query->result();

}



// Update LEAVETYPES

function MOD_UPDT_LEAVETYPES($UPDT_LEAVETYPES_INPF_NAME,$UPDT_LEAVETYPES_INPF_ID){

$sql = "UPDATE tbl_leav_type SET name=? WHERE id=?";

$query = $this->db->query($sql,array($UPDT_LEAVETYPES_INPF_NAME,$UPDT_LEAVETYPES_INPF_ID));

}



// Delete LEAVETYPES

function MOD_DLT_LEAVETYPES($leavetypes_id){

$sql = "DELETE FROM tbl_leav_type WHERE id = ?";

$query = $this->db->query($sql,array($leavetypes_id));

}



}

