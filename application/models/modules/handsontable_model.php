<?php
class handsontable_model extends CI_Model
{
  function GET_EMPLOYEELIST()
    {
        $sql = "SELECT id, col_empl_cmid, col_last_name ,col_frst_name FROM tbl_handsontable_data ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function UPDATE_DATA($data){
        $id                     = $data[0];
        $empl_id                = $data[1];
        $firstname              = $data[2];
        $lastname               = $data[3];
        
        if ($id != null) {
            $sql = " UPDATE tbl_handsontable_data SET col_empl_cmid=?, col_last_name=?, col_frst_name=? WHERE id=? ";
            $this->db->query($sql, array($empl_id, $lastname, $firstname, $id));
        } else {
            $sql = "INSERT INTO tbl_handsontable_data (col_empl_cmid, col_last_name, col_frst_name) VALUES(?,?,?)";
            $this->db->query($sql, array($empl_id, $lastname, $firstname));
        }
    }

    function DELETE_DATA($data)
    {
        $id = $data;
        $sql = "DELETE FROM tbl_handsontable_data WHERE id = ?";
        $result = $this->db->query($sql, array($id));

        if ($result) {
            return true;
        } else {
            return false;
        }

    }

} 