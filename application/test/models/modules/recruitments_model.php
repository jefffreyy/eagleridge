<?php

class recruitments_model extends CI_Model

{

    // =========================================================== APPLY  =============================================================

    function MOD_INSRT_APPLY_REQUEST_SINGLE($employee_id, $title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience)                  //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "INSERT INTO tbl_recruitment_jobposting (employee_id, title, description, feedback, status, responsibilities, qualifications, job_type, location, job_family, industry, experience_level) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

        $query = $this->db->query($sql, array($employee_id, $title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience));

        return $this->db->insert_id();

    }

    function MOD_UPDATE($id, $title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience )                          //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "UPDATE tbl_recruitment_jobposting SET title = ?, description = ?, feedback = ?,  status = ?, responsibilities = ?, qualifications = ?, job_type = ?, location = ?, job_family = ?, industry = ?, experience_level = ? WHERE id = ?";

        $query = $this->db->query($sql, array( $title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience, $id));
        return $query;
    }

    // =========================================================== MY DETAILS =============================================================

    // Display DETAILS

    function MOD_DISP_MY_REQUEST($user_id)

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting WHERE employee_id=? ORDER BY id DESC LIMIT 10";

        $query = $this->db->query($sql, array($user_id));

        $query->next_result();

        return $query->result();

    }

    // Display specific Request

    function MOD_DISP_SPECIFIC_REQUEST($id)                     //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting WHERE id=? ";

        $query = $this->db->query($sql, array($id));

        $query->next_result();

        return $query->result();

    }

    /// ===========================

    function MOD_DISP_ML_DATA_COUNT($user_id)

    {

        $sql = "SELECT COUNT(id) as ml_count FROM tbl_recruitment_jobposting WHERE employee_id=?";

        $query = $this->db->query($sql, array($user_id));

        $query->next_result();

        return $query->result();

    }

    function MOD_DISP_ML_DATA_LIMIT($user_id, $num_start, $numlimit)                        //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting WHERE employee_id=? ORDER BY id DESC LIMIT ?,? ";

        $query = $this->db->query($sql, array($user_id, $num_start, $numlimit));

        $query->next_result();

        return $query->result();

    }

    function MOD_DISP_ALL_REQUEST()                         //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting ORDER BY id DESC LIMIT 10";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();

    }

    // Display all leave

    function MOD_DISP_ALL_DATA($num_start, $numlimit)                           //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting ORDER BY id DESC LIMIT ?,? ";

        $query = $this->db->query($sql, array($num_start, $numlimit));

        $query->next_result();

        return $query->result();

    }

    function MOD_DISP_ALL_DATA_COUNT()

    {

        $sql = "SELECT COUNT(id) as count FROM tbl_recruitment_jobposting";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();

    }

    function MOD_DELETE($complaint_id)                          //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "DELETE FROM tbl_recruitment_jobposting WHERE id = ?";

        $query = $this->db->query($sql, array($complaint_id));

    }

    function MOD_DISP_ALL($num_start, $numlimit)                //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting ORDER BY id DESC LIMIT ?,? ";

        $query = $this->db->query($sql, array($num_start, $numlimit));

        $query->next_result();

        return $query->result();

    }

    function MOD_DISP_SINGLE_ROW($id)                           //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT id, title, description, status, qualifications, responsibilities, job_type, location, job_family, industry, experience_level FROM tbl_recruitment_jobposting WHERE id=? ";
        // $this->db->select('id, title, description, feedback, status');
        // $query = $this->db->get('tbl_job_post', ['id' => $id]);
        $query = $this->db->query($sql, array($id));

        return $query->row_array();

    }

    // Applicant Tracking

    function MOD_INSRT_APPLY_SINGLE($employee_id, $title, $description, $status)                                //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "INSERT INTO tbl_recruitment_entries (employee_id, title, description, feedback, status) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($employee_id, $title, $description, $feedback, $status));
        return $this->db->insert_id();
    }
  
    // =========================================================== MY DETAILS =============================================================
    // Display DETAILS
    function MOD_DISP_APPLICANT($user_id)                                   //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries WHERE employee_id=? ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }
    // Display specific Request
    function MOD_DISP_SPECIFIC_APPLICANT($id)                               //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }
    /// ===========================
    function MOD_DISP_ML_DATA_COUNT_APPLICANT($user_id)                     //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT COUNT(id) as ml_count FROM tbl_recruitment_entries WHERE employee_id=?";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ML_DATA_LIMIT_APPLICANT($user_id, $num_start, $numlimit)                          //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries WHERE employee_id=? ORDER BY id DESC LIMIT ?,? ";
        $query = $this->db->query($sql, array($user_id, $num_start, $numlimit));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_REQUEST_APPLICANT()
    {
        $sql = "SELECT * FROM tbl_recruitment_entries ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
   // Display all leave
    function MOD_DISP_ALL_DATA_APPLICANT($num_start, $numlimit)                         //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries ORDER BY id DESC LIMIT ?,? ";
        $query = $this->db->query($sql, array($num_start, $numlimit));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_JOB_COUNT()                                                   //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT COUNT(id) as count FROM tbl_job_apply";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DELETE_ENTRY($complaint_id)                                            //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "DELETE FROM tbl_recruitment_entries WHERE id = ?";
        $query = $this->db->query($sql, array($complaint_id));
    }
    function MOD_DISP_ALL_ENTRY($num_start, $numlimit)                                  //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries ORDER BY id DESC LIMIT ?,? ";
        $query = $this->db->query($sql, array($num_start, $numlimit));
        $query->next_result();
        return $query->result();
    }

    public function download($id)                                                       //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_job_apply WHERE id=?";

         $query = $this->db->query($sql,array($id));

         $query->next_result();

        return $query->row_array();
    }

    // Former P220
    function MOD_DISP_LEAVETYPES(){

        $sql = "SELECT * FROM tbl_leav_type ORDER BY name";
        
        $query = $this->db->query($sql,array());
        
        $query->next_result();
        
        return $query->result();
        
        }

        function MOD_DISP_NOTIF_APPLICATION($empl_id){

            $sql = "SELECT * FROM notif_application WHERE empl_id=? ORDER BY id DESC";
    
            $query = $this->db->query($sql,array($empl_id));
    
            $query->next_result();
    
            return $query->result();
    
        }

        function MOD_UPDT_APPLICATION_NOTIF_STATUS($notif_status, $empl_id, $notif_id){

            $sql = "UPDATE notif_application SET notif_status=? WHERE empl_id=? AND id=?";
    
            $query = $this->db->query($sql,array($notif_status, $empl_id, $notif_id));
    
        }

       

}

?>