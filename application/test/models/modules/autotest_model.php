<?php
class autotest_model extends CI_Model
{

    function INSERT_RESULT($date,$site,$id,$title,$result,$time,$group_id){
        $sql = "INSERT INTO tbl_autotestlog (test_date, test_site, test_id, test_title, test_result,test_time,group_id) VALUES (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($date,$site,$id,$title,$result,$time,$group_id));
    }

    function GET_AUTOTEST_RESULT(){
        $sql = "SELECT test_date, test_site, group_id,
                       SUM(CASE WHEN test_result = 'Success' THEN 1 ELSE 0 END) AS success_count,
                       SUM(CASE WHEN test_result = 'Failed' THEN 1 ELSE 0 END) AS failed_count
                FROM tbl_autotestlog
                GROUP BY group_id
                ORDER BY test_date";
        $query = $this->db->query($sql);
        $query->next_result();
        $results = $query->result();
        return $results;
    }

    function is_record_exists($id){
    // Assuming you have established a database connection
    
    // Escape the ID to prevent SQL injection
         $escapedId = $this->db->escape($id);
    
    // Query to check if the record exists
        $query = "SELECT COUNT(*) AS count FROM tbl_autotestlog WHERE test_id = $escapedId";
        $result = $this->db->query($query);
    
    // Retrieve the count value from the result
        $row = $result->row();
        $count = $row->count;
    
    // Return true if count is greater than 0, indicating that the record exists
        return $count > 0;
    }
    function UPDATE_RESULT($id, $result, $time){
    // Assuming you have established a database connection
    
    // Escape the values to prevent SQL injection
    $escapedId = $this->db->escape($id);
    $escapedResult = $this->db->escape($result);
    $escapedTime = $this->db->escape($time);

    // SQL query to update the record
    $query = "UPDATE tbl_autotestlog SET test_result = $escapedResult, test_time = $escapedTime WHERE test_id = $escapedId";
    
    // Execute the update query
    $this->db->query($query);
    }

    function GET_AUTOTEST_RESULT_SUCCESS($group_id){
        $sql = "SELECT * FROM tbl_autotestlog WHERE test_result='Success'AND group_id=? ORDER BY test_date DESC";
        $query = $this->db->query($sql, array($group_id));
        $query->next_result();
        return $query->result();
    }

    function GET_AUTOTEST_RESULT_FAILED($group_id){
        $sql = "SELECT * FROM tbl_autotestlog WHERE test_result='Failed'AND group_id=? ORDER BY test_date DESC";
        $query = $this->db->query($sql, array($group_id));
        $query->next_result();
        return $query->result();
    }

}