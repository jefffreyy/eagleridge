<?php 

class project_model extends CI_Model
{
    function MOD_INSRT_APPLY_REQUEST_SINGLE($project_name, $progress, $status, $code, $type, $budget, $description, $max_member, $start_date, $end_date)

    {

        $sql = "INSERT INTO tbl_projects (project_name, project_progress, status, code, start_date, end_date, type, budget, description, max_members) VALUES (?,?,?,?,?,?,?,?,?,?)";

        $query = $this->db->query($sql, array($project_name, $progress, $status, $code, $start_date, $end_date, $type, $budget, $description, $max_member));

        return $this->db->insert_id();

    }

    // Update

    function MOD_UPDATE($progress, $status, $budget, $description)

    {

        $sql = "UPDATE tbl_projects SET project_progress = ?, status = ?, budget = ?, description = ? WHERE id = ?";

        $query = $this->db->query($sql, array($progress, $status, $budget, $description));

    }


    // Display all data

    function MOD_DISP_ALL_REQUEST()

    {

        $sql = "SELECT * 
                FROM tbl_projects
                LEFT JOIN tbl_project_assign ON tbl_projects.id = tbl_project_assign.project_id
                ORDER BY tbl_projects.id DESC LIMIT 10";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();

    }

    // Display employee
    function MOD_DISP_ALL_EMPLOYEES()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        // $sql = "SELECT * FROM tbl_empl_info WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY col_empl_cmid DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

}











?>