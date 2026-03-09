<?php
class companies_model extends CI_Model
{
    function GET_ORGANIZATION_CHART()
    {
        $sql = 'SELECT 
        a.id,a.col_frst_name AS name,
        a.col_imag_path AS image,
        a.col_empl_posi AS position,
        b.col_frst_name AS reporting_to,
        b.col_imag_path as superior_image,
        b.col_empl_posi AS superior_position
        FROM tbl_employee_infos a
        LEFT JOIN tbl_employee_infos b 
        ON b.id=a.reporting_to  
        WHERE a.reporting_to';
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function GET_POSITION()
    {
        $sql = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ANNOUNCEMENTS(){                      //JERENZ: NO MOD_DISP_ANNOUNCEMENTS FOUND IN THE COMPANIES CONTROLLER
        $sql = "SELECT * FROM tbl_hr_announcements ORDER BY id DESC LIMIT 20";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ANC_DATA_COUNT(){                     //JERENZ: NO MOD_DISP_ANC_DATA_COUNT FOUND IN THE COMPANIES CONTROLLER
        $sql = "SELECT COUNT(id) as anc_count FROM tbl_hr_announcements";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    //======================================================== ABOUT US =============================================================

    function MOD_DISP_ALL_REQUEST()
    {
        $sql = "SELECT * FROM tbl_hr_aboutcompany where status='Active' ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_DATA_COUNT()
    {
        $sql = "SELECT COUNT(id) as count FROM tbl_hr_complaints";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function EDIT_ABOUT_ALL($about,$mission,$vision){
        $sql = "UPDATE tbl_hr_aboutcompany set about_cmp=?, mission=?, vision=? where id=1";
        $query= $this->db->query($sql, array($about,$mission,$vision));
    }
    function GET_ALL_EMPLOYEES(){
        $this->db->select('id,reporting_to,col_empl_cmid,
        col_last_name,col_midl_name,col_frst_name')
        ->where('termination_date','0000-00-00')
        ->where('disabled',0);
        $query = $this->db->get('tbl_employee_infos');
        return $query->result_object();
    }
    function GET_FILTERED_EMPLOYEELIST($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,reporting_to,col_empl_cmid,
        col_last_name,col_imag_path,col_midl_name,col_frst_name
        FROM tbl_employee_infos 
        WHERE termination_date = '0000-00-00' AND disabled = 0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC
        LIMIT ".$offset.", ".$row." ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function UPDATE_ORGANIZATION($ids,$reporting_to){
        $data = array(
               'reporting_to' => $reporting_to
            );
        $this->db->where_in('id', $ids);
        
        return $this->db->update('tbl_employee_infos', $data);
    }
}