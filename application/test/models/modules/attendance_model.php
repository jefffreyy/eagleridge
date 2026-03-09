<?php
class attendance_model extends CI_Model{

    function FILTER_ATTENDANCE_RECORDS($dept,$sect,$group, $division, $branch, $team){
        $where_query        ="WHERE disabled=0 AND termination_date='0000-00-00'";
        $query_dept         = empty($this->input->get('dept')) || $this->input->get('dept')=='all' ? $where_query: $where_query.=' AND col_empl_dept=?';
        $query_section      = empty($this->input->get('section')) || $this->input->get('section')=='all' ? $where_query: $where_query.=' AND col_empl_sect=?';
        $query_group        = empty($this->input->get('group')) || $this->input->get('group')=='all' ? $where_query: $where_query.=' AND col_empl_group=?';

        $query_division     = empty($this->input->get('division')) || $this->input->get('division')=='all' ? $where_query: $where_query.=' AND col_empl_divi=?';
        $query_branch       = empty($this->input->get('branch')) || $this->input->get('branch')=='all' ? $where_query: $where_query.=' AND col_empl_branch=?';
        $query_team         = empty($this->input->get('team')) || $this->input->get('team')=='all' ? $where_query: $where_query.=' AND col_empl_team=?';

        $sql = "SELECT id,col_empl_posi,col_empl_group,col_empl_cmid,col_last_name,col_frst_name,col_midl_name FROM tbl_employee_infos $where_query";

        $arr_val=array();
        if(!empty($dept)&&$dept!='all'){
            $arr_val[]=$dept;
        }
        if(!empty($sect)&&$sect!='all'){
            $arr_val[]=$sect;
        }
        if(!empty($group)&&$group!='all'){
            $arr_val[]=$group;
        }

        if(!empty($division)&&$division!='all'){
            $arr_val[]=$division;
        }
        if(!empty($branch)&&$branch!='all'){
            $arr_val[]=$branch;
        }
        if(!empty($team)&&$team!='all'){
            $arr_val[]=$team;
        }

        $query = $this->db->query($sql,$arr_val);
        $query->next_result();
        return $query->result();
    }
    function ADD_DATA($table,$data){
        return $this->db->insert($table, $data);
    }
    function GET_EMPLOYEE_INFO($id){
        $this->db->select('tbl_employee_infos.id as id,salary_type,col_last_name as lastname,col_frst_name as firstname,col_midl_name as middlename,
        tbl_std_groups.name as empl_group,
        tbl_std_positions.name as position,
        tbl_projects.project_name as project_name,
        tbl_std_departments.name as department');
        $this->db->from('tbl_employee_infos');
        $this->db->join('tbl_std_groups', 'tbl_employee_infos.col_empl_group=tbl_std_groups.id', 'left');
        $this->db->join('tbl_std_positions', 'tbl_employee_infos.col_empl_posi=tbl_std_positions.id', 'left');
        $this->db->join('tbl_std_departments', 'tbl_employee_infos.col_empl_dept=tbl_std_departments.id', 'left');
        $this->db->join('tbl_projects','tbl_employee_infos.col_project=tbl_projects.id','left');
        $this->db->where('tbl_employee_infos.id',$id);
        $query = $this->db->get();
        return $query->result();

    }
    function GET_EMPLOYEELIST(){

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,
        col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,
        col_empl_team,col_empl_line FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0
        ORDER BY col_empl_cmid ASC";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST_3($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT tbl_employee_infos.id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type, empl_cmid, empl_code FROM tbl_employee_infos 
        LEFT JOIN tbl_zkteco_code ON tbl_employee_infos.col_empl_cmid = tbl_zkteco_code.empl_cmid
        WHERE termination_date = '0000-00-00' AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        AND disabled = '0'
        ORDER BY col_empl_cmid ASC
        LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SEARCHED_3($search){
        $sql = "SELECT *, empl_cmid, empl_code FROM tbl_employee_infos 
        LEFT JOIN tbl_zkteco_code ON tbl_employee_infos.col_empl_cmid = tbl_zkteco_code.empl_cmid
        WHERE termination_date = '0000-00-00' AND disabled=0 
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR empl_code LIKE '%$search%') 
        ORDER BY tbl_employee_infos.id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_FILTERED_EMPLOYEELIST_DATA($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_cmid, CONCAT(col_last_name, ' ', col_frst_name) AS full_name FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        AND disabled = '0'
        ORDER BY col_empl_cmid ASC
        LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    
    

    function GET_FILTERED_EMPLOYEELIST_2($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        AND disabled = '0'
        ORDER BY col_empl_cmid ASC
        LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SEARCHED($search){
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    
    
   


    function GET_COUNT_EMPLOYEELIST(){
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }



    function GET_FILTERED_EMPLOYEELIST_COUNT($branch,$dept,$division,$section,$group,$team,$line){
        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line FROM tbl_employee_infos WHERE termination_date = '0000-00-00'
         AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid
        ";
        
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_PERIOD_DATA($sched_id){
        $sql = "SELECT date_from,date_to FROM tbl_payroll_period WHERE id=? AND status=?  ORDER BY id desc";
        $query = $this->db->query($sql,array($sched_id,'active'));
        $data=$query->row_array();

        return $data;
    }
    function GET_SHIFT_ASSIGN_SPECIFIC($user_id){
        $sql = "SELECT date,shift_id FROM tbl_attendance_shiftassign WHERE empl_id = ?";
        $query = $this->db->query($sql,array($user_id));
        $query->next_result();
        return $query->result();
    }

    function GET_SHIFT_DATA_DATERANGE($begin,$end){
        $sql = "SELECT empl_id,date,shift_id FROM tbl_attendance_shiftassign WHERE date >= '$begin' AND date <= '$end'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SHIFT_ALL_DATA(){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SYSTEM_SETTING($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
        
        
    }

    function GET_LEAVE_NAMES(){
        $sql = "SELECT id,name FROM tbl_std_leavetypes";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function INSERT_ATTENDANCE_LOCK($data){
        $EMPL_ID = $data["EMPL_ID"];
        $PAYROLL_SCHED = $data["PAYROLL_SCHED"];
        $SUM_PRESENT = $data["SUM_PRESENT"];
        $SUM_ABSENT = $data["SUM_ABSENT"];
        $SUM_TARDINESS = $data["SUM_TARDINESS"];
        $SUM_UNDERTIME = $data["SUM_UNDERTIME"];
        $SUM_PAID_LEAVE = $data["SUM_PAID_LEAVE"];
        $SUM_REG_HOURS = $data["SUM_REG_HOURS"];
        $SUM_REG_OT = $data["SUM_REG_OT"];
        $SUM_REG_ND = $data["SUM_REG_ND"];
        $SUM_REG_NDOT = $data["SUM_REG_NDOT"];
        $SUM_REST_HOURS = $data["SUM_REST_HOURS"];
        $SUM_REST_OT = $data["SUM_REST_OT"];
        $SUM_REST_ND = $data["SUM_REST_ND"];
        $SUM_REST_NDOT = $data["SUM_REST_NDOT"];
        $SUM_LEG_HOURS = $data["SUM_LEG_HOURS"];
        $SUM_LEG_OT = $data["SUM_LEG_OT"];
        $SUM_LEG_ND = $data["SUM_LEG_ND"];
        $SUM_LEG_NDOT = $data["SUM_LEG_NDOT"];
        $SUM_LEGREST_HOURS = $data["SUM_LEGREST_HOURS"];
        $SUM_LEGREST_OT = $data["SUM_LEGREST_OT"];
        $SUM_LEGREST_ND = $data["SUM_LEGREST_ND"];
        $SUM_LEGREST_NDOT = $data["SUM_LEGREST_NDOT"];
        $SUM_SPE_HOURS = $data["SUM_SPE_HOURS"];
        $SUM_SPE_OT = $data["SUM_SPE_OT"];
        $SUM_SPE_ND = $data["SUM_SPE_ND"];
        $SUM_SPE_NDOT = $data["SUM_SPE_NDOT"];
        $SUM_SPEREST_HOURS = $data["SUM_SPEREST_HOURS"];
        $SUM_SPEREST_OT = $data["SUM_SPEREST_OT"];
        $SUM_SPEREST_ND = $data["SUM_SPEREST_ND"];
        $SUM_SPEREST_NDOT = $data["SUM_SPEREST_NDOT"];
        

        $sql = "INSERT INTO tbl_attendance_records_lock (status,empl_id,period,present,absent,tardiness,undertime,paid_leave,reg_hours,reg_ot,reg_nd,reg_ndot,rest_hours,rest_ot,rest_nd,rest_ndot,leg_hours,leg_ot,leg_nd,leg_ndot,legrest_hours,legrest_ot,legrest_nd,legrest_ndot,spe_hours,spe_ot,spe_nd,spe_ndot,sperest_hours,sperest_ot,sperest_nd,sperest_ndot)
        VALUES ('0',$EMPL_ID,$PAYROLL_SCHED,$SUM_PRESENT,$SUM_ABSENT,$SUM_TARDINESS,$SUM_UNDERTIME,$SUM_PAID_LEAVE,$SUM_REG_HOURS,$SUM_REG_OT,$SUM_REG_ND,$SUM_REG_NDOT,$SUM_REST_HOURS,$SUM_REST_OT,$SUM_REST_ND,$SUM_REST_NDOT,$SUM_LEG_HOURS,$SUM_LEG_OT,$SUM_LEG_ND,$SUM_LEG_NDOT,$SUM_LEGREST_HOURS,$SUM_LEGREST_OT,$SUM_LEGREST_ND,$SUM_LEGREST_NDOT,$SUM_SPE_HOURS,$SUM_SPE_OT,$SUM_SPE_ND,$SUM_SPE_NDOT,$SUM_SPEREST_HOURS,$SUM_SPEREST_OT,$SUM_SPEREST_ND,$SUM_SPEREST_NDOT)";
        $query = $this->db->query($sql);
   
    }

    function UPDATE_ATTENDANCE_LOCK($data){
        $EMPL_ID = $data["EMPL_ID"];
        $PAYROLL_SCHED = $data["PAYROLL_SCHED"];
        $SUM_PRESENT = $data["SUM_PRESENT"];
        if($data["SUM_ABSENT"] == ""){$SUM_ABSENT = 0;}else{$SUM_ABSENT = $data["SUM_ABSENT"];}
        if($data["SUM_TARDINESS"] == ""){$SUM_TARDINESS= 0;}else{$SUM_TARDINESS=$data["SUM_TARDINESS"];}
        if($data["SUM_UNDERTIME"] == ""){$SUM_UNDERTIME= 0;}else{$SUM_UNDERTIME=$data["SUM_UNDERTIME"];}
        if($data["SUM_PAID_LEAVE"] == ""){$SUM_PAID_LEAVE= 0;}else{$SUM_PAID_LEAVE=$data["SUM_PAID_LEAVE"];}
        if($data["SUM_REG_HOURS"] == ""){$SUM_REG_HOURS= 0;}else{$SUM_REG_HOURS=$data["SUM_REG_HOURS"];}
        if($data["SUM_REG_OT"] == ""){$SUM_REG_OT= 0;}else{$SUM_REG_OT=$data["SUM_REG_OT"];}
        if($data["SUM_REG_ND"] == ""){$SUM_REG_ND= 0;}else{$SUM_REG_ND=$data["SUM_REG_ND"];}
        if($data["SUM_REG_NDOT"] == ""){$SUM_REG_NDOT= 0;}else{$SUM_REG_NDOT=$data["SUM_REG_NDOT"];}
        if($data["SUM_REST_HOURS"] == ""){$SUM_REST_HOURS= 0;}else{$SUM_REST_HOURS=$data["SUM_REST_HOURS"];}
        if($data["SUM_REST_OT"] == ""){$SUM_REST_OT= 0;}else{$SUM_REST_OT=$data["SUM_REST_OT"];}
        if($data["SUM_REST_ND"] == ""){$SUM_REST_ND= 0;}else{$SUM_REST_ND=$data["SUM_REST_ND"];}
        if($data["SUM_REST_NDOT"] == ""){$SUM_REST_NDOT= 0;}else{$SUM_REST_NDOT=$data["SUM_REST_NDOT"];}
        if($data["SUM_LEG_HOURS"] == ""){$SUM_LEG_HOURS= 0;}else{$SUM_LEG_HOURS=$data["SUM_LEG_HOURS"];}
        if($data["SUM_LEG_OT"] == ""){$SUM_LEG_OT= 0;}else{$SUM_LEG_OT=$data["SUM_LEG_OT"];}
        if($data["SUM_LEG_ND"] == ""){$SUM_LEG_ND= 0;}else{$SUM_LEG_ND=$data["SUM_LEG_ND"];}
        if($data["SUM_LEG_NDOT"] == ""){$SUM_LEG_NDOT= 0;}else{$SUM_LEG_NDOT=$data["SUM_LEG_NDOT"];}
        if($data["SUM_LEGREST_HOURS"] == ""){$SUM_LEGREST_HOURS= 0;}else{$SUM_LEGREST_HOURS=$data["SUM_LEGREST_HOURS"];}
        if($data["SUM_LEGREST_OT"] == ""){$SUM_LEGREST_OT= 0;}else{$SUM_LEGREST_OT=$data["SUM_LEGREST_OT"];}
        if($data["SUM_LEGREST_ND"] == ""){$SUM_LEGREST_ND= 0;}else{$SUM_LEGREST_ND=$data["SUM_LEGREST_ND"];}
        if($data["SUM_LEGREST_NDOT"] == ""){$SUM_LEGREST_NDOT= 0;}else{$SUM_LEGREST_NDOT=$data["SUM_LEGREST_NDOT"];}
        if($data["SUM_SPE_HOURS"] == ""){$SUM_SPE_HOURS= 0;}else{$SUM_SPE_HOURS=$data["SUM_SPE_HOURS"];}
        if($data["SUM_SPE_OT"] == ""){$SUM_SPE_OT= 0;}else{$SUM_SPE_OT=$data["SUM_SPE_OT"];}
        if($data["SUM_SPE_ND"] == ""){$SUM_SPE_ND= 0;}else{$SUM_SPE_ND=$data["SUM_SPE_ND"];}
        if($data["SUM_SPE_NDOT"] == ""){$SUM_SPE_NDOT= 0;}else{$SUM_SPE_NDOT=$data["SUM_SPE_NDOT"];}
        if($data["SUM_SPEREST_HOURS"] == ""){$SUM_SPEREST_HOURS= 0;}else{$SUM_SPEREST_HOURS=$data["SUM_SPEREST_HOURS"];}
        if($data["SUM_SPEREST_OT"] == ""){$SUM_SPEREST_OT= 0;}else{$SUM_SPEREST_OT=$data["SUM_SPEREST_OT"];}
        if($data["SUM_SPEREST_ND"] == ""){$SUM_SPEREST_ND= 0;}else{$SUM_SPEREST_ND=$data["SUM_SPEREST_ND"];}
        if($data["SUM_SPEREST_NDOT"] == ""){$SUM_SPEREST_NDOT= 0;}else{$SUM_SPEREST_NDOT=$data["SUM_SPEREST_NDOT"];}
        
        

        $sql = "UPDATE tbl_attendance_records_lock SET status = '0',present = $SUM_PRESENT,absent = $SUM_ABSENT,tardiness = $SUM_TARDINESS,undertime = $SUM_UNDERTIME,paid_leave = $SUM_PAID_LEAVE,reg_hours = $SUM_REG_HOURS,reg_ot = $SUM_REG_OT,reg_nd = $SUM_REG_ND,reg_ndot = $SUM_REG_NDOT,rest_hours = $SUM_REST_HOURS,rest_ot = $SUM_REST_OT,rest_nd = $SUM_REST_ND,rest_ndot = $SUM_REST_NDOT,leg_hours = $SUM_LEG_HOURS,leg_ot = $SUM_LEG_OT,leg_nd = $SUM_LEG_ND,leg_ndot = $SUM_LEG_NDOT,legrest_hours = $SUM_LEGREST_HOURS,legrest_ot = $SUM_LEGREST_OT,legrest_nd = $SUM_LEGREST_ND,legrest_ndot = $SUM_LEGREST_NDOT,spe_hours = $SUM_SPE_HOURS,spe_ot = $SUM_SPE_OT,spe_nd = $SUM_SPE_ND,spe_ndot = $SUM_SPE_NDOT,sperest_hours = $SUM_SPEREST_HOURS,sperest_ot = $SUM_SPEREST_OT,sperest_nd = $SUM_SPEREST_ND,sperest_ndot = $SUM_SPEREST_NDOT
        WHERE empl_id = $EMPL_ID AND period = $PAYROLL_SCHED";
      $query = $this->db->query($sql);
   
    }
    function GET_APPROVED_LEAVES($employee_id,$date_from,$date_to){
        $sql = "SELECT * FROM tbl_leaves_assign WHERE status = 'Approved' AND empl_id = ? AND leave_date >= ? AND leave_date <= ?";
        $query = $this->db->query($sql,array($employee_id,$date_from,$date_to));
        $query->next_result();
        return $query->result();
    }

    function GET_APPROVED_OT($employee_id,$date_from,$date_to){
        $sql = "SELECT * FROM tbl_overtimes WHERE status = 'Approved' AND empl_id = ? AND date_ot >= ? AND date_ot <= ?";
        $query = $this->db->query($sql, array($employee_id,$date_from,$date_to));
        $query->next_result();
        return $query->result();
    }
    function GET_SALARY_TYPE($user_id){
        if(empty($user_id)){
            return '';
        }
        $sql = "SELECT salary_type FROM tbl_employee_infos WHERE id = ?";
        $query = $this->db->query($sql, array($user_id));
        $result = $query->result_array();
        return $result[0]["salary_type"];    
    }
    function GET_IN_OUT_TYPE(){
 
        $sql = "SELECT value FROM tbl_system_setup WHERE id = 56";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];    
    }

    function INSERT_APPROVAL_CSV($arr_data){
        $sql = "INSERT INTO tbl_overtime_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) 
                VALUES (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,$arr_data);
    }

    function INSERT_CSV($arr_data){
        $sql="INSERT INTO tbl_attendance_suminac(user_id,cut_off,reg_hrs,swap,rest_day_ot,legal_w,legal_wo,spe_hol,
        reg_ot,free_lunch,excess_ot_hol,excess_ot_spe,excess_ot_reg,allo_meal_ot,nd,nd_ot,absent,tardiness,
        undertime,allo_rice,allo_ctpa,allo_sea,allo_transpo,allo_swc,loan_rcbc,vac,adj_medical,adj_rice,
        adj_nightdiff,adj_restot,adj_shot,adj_lhot,adj_allo_transpo,adj_regot) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query(  $sql,$arr_data);
    }
    function IS_DUPLICATE_CSV($date ,$user){
        $sql = "SELECT id FROM tbl_attendance_records WHERE empl_id='$user' AND date='$date'";
        $query = $this->db->query($sql,array());
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }
    function IS_DUPLICATE($user_id,$date){
        $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql,array($user_id,$date));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_DUPLICATE_LOCK($user_id,$period){
        $sql = "SELECT id FROM tbl_attendance_records_lock WHERE empl_id=? AND period=?";
        $query = $this->db->query($sql,array($user_id,$period));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_PAYSLIP($user_id,$period){
        $sql = "SELECT id FROM tbl_payroll_payslips WHERE empl_id=? AND PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql,array($user_id,$period));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_LEAVE($user_id,$date_from,$date_to){
        $sql = "SELECT id FROM tbl_leaves_assign WHERE empl_id=$user_id AND leave_date >= '$date_from' AND  leave_date <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_TIME($user_id,$date_from,$date_to){
        $sql = "SELECT id FROM tbl_attendance_adjustments WHERE empl_id=$user_id AND date_adjustment >= '$date_from' AND  date_adjustment <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_OVERTIME($user_id,$date_from,$date_to){
        $sql = "SELECT id FROM tbl_overtimes WHERE empl_id=$user_id AND date_ot >= '$date_from' AND  date_ot <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_HOLIDAY($user_id,$date_from,$date_to){
        $sql = "SELECT id FROM tbl_holidaywork WHERE empl_id=$user_id AND date >= '$date_from' AND  date <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function MOD_GET_WRK_SHFT_DATA($work_shift_id){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE id=? LIMIT 1";
        $query = $this->db->query($sql,array($work_shift_id));
        $query->next_result();
        return $query->row();
    }
    function ADD_USER_WORK_SHIFT($user_id,$shift_id,$date){
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_attendance_shiftassign (create_date,edit_date,empl_id,date,shift_id) VALUES(?,?,?,?,?)";
        return $this->db->query($sql,array($datetime,$datetime,$user_id,$date,$shift_id));
    }
    function UPDATE_USER_WORK_SHIFT($user_id,$shift_id,$date){
        $datetime = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_attendance_shiftassign SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
        return $this->db->query($sql,array($datetime,$shift_id,$user_id,$date));
    }

  
    function GET_HOLIDAY(){
        $sql = "SELECT col_holi_date,col_holi_type FROM tbl_std_holidays";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    function GET_ATTENDANCE_RECORD($user_id){
        $sql = "SELECT date,time_in,time_out FROM tbl_attendance_records WHERE empl_id=?";
        $query = $this->db->query($sql,array($user_id));
        $query->next_result();
        return $query->result();
    }

    // function GET_ZKTECO_ATTENDANCE_RECORD($emp_code){
    //     $sql = "SELECT * FROM tbl_zkteco INNER JOIN tbl_employee_infos ON tbl_zkteco.emp_code=tbl_employee_infos.col_empl_cmid WHERE tbl_employee_infos.id=?";
    //     $query = $this->db->query($sql,array($emp_code));
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_ZKTECO_ATTENDANCE_RECORD($employee_id){
        $sql = "SELECT * FROM tbl_zkteco 
        LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code=tbl_zkteco_code.empl_code WHERE tbl_zkteco_code.empl_id=?";
        $query = $this->db->query($sql,array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_WORK_SHIFT_DATA(){
        $sql="SELECT * FROM tbl_attendance_shifts where is_deleted=0 AND status='Active'";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_DEPT(){
        $sql = 'SELECT id,name,status FROM tbl_std_departments WHERE status="Active"';
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_SECT(){
        $sql = 'SELECT id,name,status FROM tbl_std_sections WHERE status="Active"';
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_GROUP(){
        $sql = 'SELECT id,name,status FROM tbl_std_groups WHERE status="Active"';
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_LINE(){
        $sql = 'SELECT id,name,status FROM tbl_std_lines WHERE status="Active"';
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_USER_ID($cmid){
        $sql="SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=?";
        $query = $this->db->query($sql,array($cmid));
        $query->next_result();
        return $query->row_result();
    }
    function GET_ATTE_SUMINAC_REC($cut_off_period){
        $filter = "";
        if($cut_off_period){
            $filter = "WHERE cut_off=$cut_off_period";
        }
        $sql="SELECT * FROM tbl_attendance_suminac ".$filter;
        $query = $this->db->query($sql,array($cut_off_period));
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_NAME()
    {
        $sql = "SELECT *,CONCAT(col_frst_name,' ',col_last_name) AS name FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PAY_SCHED()
    {
        $sql = "SELECT * FROM tbl_payroll_period";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_SEARCHED_DATA($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_frst_name LIKE '$search%' OR col_last_name LIKE '$search%' OR col_midl_name LIKE '$search%' OR col_empl_emai LIKE '$search%' OR col_mobl_numb LIKE '$search%' AND isSuperAdmin != 1";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
  

    function MOD_DISP_EMPLOYEE($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES($dept,$sec,$group,$line,$status)      //JERENZ:  ATTENDANCE MODEL HAVE ARGUMENTS, CONTROLLER DON'T HAVE ARGUMENTS
    {
        if($dept){
            $filter_q = " AND col_empl_dept=".$dept;
        }else if($sec){
            $filter_q = " AND col_empl_sect=".$sec;
        }else if($group){
            $filter_q = " AND col_empl_group=".$group;
        }
        else if($line){
            $filter_q = " AND col_empl_line=".$line;
        }
        else if($status){
            $filter_q = " AND disabled=".$status;
        }else{
            $filter_q = "";
        }

        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 " .$filter_q. " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_INFO_BIOM()
    {
        $sql = "SELECT id,col_empl_cmid,col_empl_dept,col_empl_sect,col_empl_posi,col_frst_name,col_last_name FROM tbl_employee_infos";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_NOT_YET_IN_OFFICE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in1=? AND time_out1=? AND id!=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '00:00:00', '00:00:00', '6'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_ALREADY_IN_OFFICE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in1!=? AND time_out1=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_OUT_OF_OFFICE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in1!=? AND time_out1!=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_ON_REST()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND id=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '6'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ON_LEAVE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? ";
        $query = $this->db->query($sql, array(date('Y-m-d')));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_NOT_YET_IN_OFFICE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in1=? AND time_out1=?";
        $query = $this->db->query($sql, array($attendance_date, '00:00:00', '00:00:00', '6'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_ALREADY_IN_OFFICE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in1!=? AND time_out1=?";
        $query = $this->db->query($sql, array($attendance_date, '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_OUT_OF_OFFICE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in1!=? AND time_out1!=?";
        $query = $this->db->query($sql, array($attendance_date, '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPL_ON_REST_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? ";
        $query = $this->db->query($sql, array($attendance_date, '6'));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ON_LEAVE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE  status='Approved'";
        $query = $this->db->query($sql, array($attendance_date));
        $query->next_result();
        return $query->result();
    }

    function MOD_INSRT_OVERTIME($overtime_date, $type, $time_out, $num_hours, $reason, $status, $assigned_by, $employee_id)
    {
        $sql = "INSERT INTO tbl_overtimes (date_created,date_ot,type,time_out,hours,reason,status1,status2,assigned_by,empl_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array(date('Y-m-d'), $overtime_date, $type, $time_out, $num_hours, $reason, $status, $status, $assigned_by, $employee_id));
        return $this->db->insert_id();
    }

    function MOD_UPDT_OT_STATUS_APPR1($status, $ot_insrt_id)
    {
        $sql = "UPDATE tbl_overtimes SET status1=? WHERE id = ?";
        $query = $this->db->query($sql, array($status, $ot_insrt_id));
    }

    function MOD_UPDT_OT_STATUS_APPR2($status, $ot_insrt_id)
    {
        $sql = "UPDATE tbl_overtimes SET status2=? WHERE id = ?";
        $query = $this->db->query($sql, array($status, $ot_insrt_id));
    }

    function MOD_UPDT_OVERTIME_APPLICATION($actual_ot_duration, $overtime_id)
    {
        $sql = "UPDATE tbl_overtimes SET hours=? WHERE id = ?";
        $query = $this->db->query($sql, array($actual_ot_duration, $overtime_id));
    }

    function MOD_UPDT_ATT_REG_OT($ot_hours, $ot_date, $empl_id)
    {
        $sql = "UPDATE tbl_attendance_records SET appr_reg_ot=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($ot_hours, $ot_date, $empl_id));
    }

    function MOD_UPDT_ATT_ND_OT($ot_hours, $ot_date, $empl_id)
    {
        $sql = "UPDATE tbl_attendance_records SET appr_ns_ot=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($ot_hours, $ot_date, $empl_id));
    }

    function MOD_UPDT_ATT_REST_OT($ot_hours, $ot_date, $empl_id)
    {
        $sql = "UPDATE tbl_attendance_records SET bp_sp_hol=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($ot_hours, $ot_date, $empl_id));
    }

    function MON_DISP_CUTOFF_PERIOD($start_date,$end_date,$employee_id){
        $sql = "SELECT * FROM tbl_attendance_records WHERE date >= ? AND date <= ? AND empl_id=?";
        $query = $this->db->query($sql,array($start_date,$end_date,$employee_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_APPR_ROUTE_OT_ADJ(){
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE termination_date = '0000-00-00' ORDER BY id ASC";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_APPR_ROUT_LIST(){
        $sql = "SELECT * FROM tbl_overtime_approvers";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }


    function MOD_DISP_APPR_ROUTE_OT_ADJ($id){
        $sql = "SELECT * FROM tbl_overtime_approvers WHERE id=?";
        $query = $this->db->query($sql,array($id));
        $query->next_result();
        return $query->result();
    }

 
    function MOD_INSRT_NOTIF_LOGS($empl_id,$empl_group, $appr_type, $reciever, $date_created, $message, $status, $application_id, $requested_by){
        $sql = "INSERT INTO notif_approvals (empl_id, empl_group, appr_type, reciever, date_created, message, status, application_id, requested_by) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($empl_id,$empl_group, $appr_type, $reciever, $date_created, $message, $status, $application_id, $requested_by));
        return;
    }

     // And application notif
     function MOD_INSRT_APPLICATION_NOTIF_LOGS($empl_id,$message, $type, $date_created, $application_id, $notif_status){
        $sql = "INSERT INTO notif_application (empl_id, message, type, date_created, application_id, notif_status) VALUES (?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($empl_id,$message, $type, $date_created, $application_id, $notif_status));
        return;
    }

    function MOD_DISP_PAY_SCHED(){
        $sql = "SELECT id,name FROM tbl_payroll_period WHERE status='active' ORDER BY id desc";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_SHIFTTEMPLATE(){
        $sql = "SELECT * FROM tbl_attendance_shifttemplates ORDER BY name";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Add SHIFTTEMPLATE
    function MOD_INSRT_SHIFTTEMPLATE($code,$name,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday){
        $sql = "INSERT INTO tbl_attendance_shifttemplates (code,name,monday,tuesday,wednesday,thursday,friday,saturday,sunday) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($code,$name,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday));
        return;
    }

    // Update SHIFTTEMPLATE
    function MOD_UPDT_SHIFTTEMPLATE($code,$name,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday,$id){
        $sql = "UPDATE tbl_attendance_shifttemplates SET code=?,name=?,monday=?,tuesday=?,wednesday=?,thursday=?,friday=?,saturday=?,sunday=? WHERE id=?";
        $query = $this->db->query($sql,array($code,$name,$monday,$tuesday,$wednesday,$thursday,$friday,$saturday,$sunday,$id));
    }

    function MOD_DLT_SHIFTTEMPLATE($ShiftTemplate_id){
        $sql = "DELETE FROM tbl_attendance_shifttemplates WHERE id = ?";
        $query = $this->db->query($sql,array($ShiftTemplate_id));
    }

    // function MOD_DISP_WRK_SHFT(){
    //     $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status='Active' ORDER BY id ASC";
    //     $query = $this->db->query($sql,array());
    //     $query->next_result();
    //     return $query->result();
    // }

    function MOD_DISP_WRK_SHFT($tab,$row,$offset){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=? ORDER BY id ASC LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql,array($tab));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_WRK_SHFT_COUNT($tab){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql,array($tab));
        $query->next_result();
        return $query->result();
    }

    function GET_WORK_SHIFT_ACTIVE_COUNT($tab){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql,array($tab));
        $query->next_result();
        return $query->result();
    }

    function GET_WORK_SHIFT_INACTIVE_COUNT($tab){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql,array($tab));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_SEARCH_WRK_SHFT($tab,$search){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted='0' AND status=?
        AND (tbl_attendance_shifts.id LIKE '%$search%'
        OR tbl_attendance_shifts.code LIKE '%$search%'
        OR tbl_attendance_shifts.name LIKE '%$search%'
        OR tbl_attendance_shifts.color LIKE '%$search%')
        ORDER BY id ASC";
        $query = $this->db->query($sql,array($tab));
        $query->next_result();
        return $query->result();
    }

    function UPDATE_WORKSHIFT($id,$status){
        $sql = "UPDATE tbl_attendance_shifts SET status=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$id));
    }
    function ADD_WORK_SHIFT($data){
        return $this->db->insert('tbl_attendance_shifts', $data);
    }
    function UPDATE_SPE_WORKSHIFT($id,$data){
        $this->db->where('id', $id);
        return $this->db->update('tbl_attendance_shifts', $data);
    }
    function MOD_INSRT_WRK_SHFT($code,$shift_name,$time_in,$time_out,$time_in_2,$time_out_2,$time_out_w_ot,$has_next_day,$color,$status,$lunch_break_start, $lunch_break_end){
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_attendance_shifts (create_date,edit_date,code,name,time_in,time_out,time_in_2,time_out_2,time_out_ot,next_day,color,status,lunch_break_start,lunch_break_end) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($datetime,$datetime,$code,$shift_name,$time_in,$time_out,$time_in_2,$time_out_2,$time_out_w_ot,$has_next_day,$color,$status,$lunch_break_start, $lunch_break_end));
        return;
    }

    // Update WRK_SHFT
    function MOD_UPDT_WRK_SHFT($code,$shift_name,$time_in,$time_out,$time_in_2,$time_out_2,$time_out_w_ot,$has_next_day,$color,$id,$lunch_break_start, $lunch_break_end){
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_shifts SET edit_date=?, code=?,name=?,time_in=?,time_out=?,time_in_2=?,time_out_2=?,time_out_ot=?,next_day=?,color=?,lunch_break_start=?,lunch_break_end=? WHERE id=?";
        return $this->db->query($sql,array($datetime,$code,$shift_name,$time_in,$time_out,$time_in_2,$time_out_2,$time_out_w_ot,$has_next_day,$color,$lunch_break_start, $lunch_break_end,$id));
    }

    // Delete WRK_SHFT
    function MOD_DLT_WRK_SHFT($work_shift_id){
        $sql = "UPDATE tbl_attendance_shifts SET is_deleted=1 WHERE id = ?";
        $query = $this->db->query($sql,array($work_shift_id));
    }

    function MOD_INSRT_HOLIDAY($HOLIDAY_INPF_NAME,$HOLIDAY_INPF_DATE,$HOLIDAY_INPF_TYPE){
        $sql = "INSERT INTO tbl_std_holidays (name,col_holi_date,col_holi_type) VALUES (?,?,?)";
        $query = $this->db->query($sql,array($HOLIDAY_INPF_NAME,$HOLIDAY_INPF_DATE,$HOLIDAY_INPF_TYPE));
        return;
    }

    // Update HOLIDAY
    function MOD_UPDT_HOLIDAY($UPDT_HOLIDAY_INPF_NAME,$UPDT_HOLIDAY_INPF_DATE,$UPDT_HOLIDAY_INPF_TYPE,$UPDT_HOLIDAY_INPF_ID){
        $sql = "UPDATE tbl_std_holidays SET name=?,col_holi_date=?,col_holi_type=? WHERE id=?";
        $query = $this->db->query($sql,array($UPDT_HOLIDAY_INPF_NAME,$UPDT_HOLIDAY_INPF_DATE,$UPDT_HOLIDAY_INPF_TYPE,$UPDT_HOLIDAY_INPF_ID));
    }

    // Delete HOLIDAY
    function MOD_DLT_HOLIDAY($holiday_id){
        $sql = "DELETE FROM tbl_std_holidays WHERE id = ?";
        $query = $this->db->query($sql,array($holiday_id));
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_BRANCH(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DEPARTMENT(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DIVISION(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT SECTION
    function MOD_DISP_DISTINCT_SECTION(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT Group
    function MOD_DISP_DISTINCT_GROUP(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT Group
    function MOD_DISP_DISTINCT_TEAM(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT line
    function MOD_DISP_DISTINCT_LINE(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_EMP(){
        $sql = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_INSERT_APPROVER_DATA($emp_id,$app1a,$app1b,$app2a,$app2b,$app3a,$app3b){
        $sql ="INSERT INTO tbl_overtime_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUE (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($emp_id,$app1a,$app1b,$app2a,$app2b,$app3a,$app3b));
        return;
    }

    function INSERT_ATTENDANCE_REC_CSV($arr_data){
        $sql ="INSERT INTO tbl_attendance_records (date,empl_id,time_in,time_out) VALUE (?,?,?,?)";
        $query = $this->db->query($sql, $arr_data);
        return;
    }

    function UPDATE_ATTENDANCE_REC_CSV($arr_data){
        $sql ="UPDATE tbl_attendance_records SET time_in = ?,time_out = ? WHERE date = ? and empl_id = ?";
        $query = $this->db->query($sql, $arr_data);
        return;
    }

   
    function GET_OVERTIME_APPROVER($empl_id){
        $sql = "SELECT * FROM tbl_overtime_approvers WHERE empl_id=?";
        $query = $this->db->query($sql,array($empl_id));
        return $query->num_rows();
    }

    function MOD_UPDT_OVERTIME_APPROVER($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b,$id){
        $sql = "UPDATE tbl_overtime_approvers SET edit_date=?,approver_1a=?,approver_1b=?,approver_2a=?,approver_2b=?,approver_3a=?,approver_3b=?  WHERE empl_id IN (" . $id . ")";
        $query = $this->db->query($sql,array($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b));
    }

    function MOD_INSERT_OVERTIME_APPROVER($date,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b,$empl_id){
        $sql ="INSERT INTO tbl_overtime_approvers (create_date, edit_date,empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($date,$date,$empl_id,$approver1a,$approver1b,$approver2a,$approver2b,$approver3a,$approver3b));
        return;
    }

    function GET_ZKTECO_RECORDS($offset,$row){
        $sql = "SELECT * FROM tbl_zkteco ORDER BY id DESC LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql , array());
        $query->next_result();
        return $query->result();
    }

    function GET_ZKTECO_CODE($id){
        $sql = "SELECT empl_id FROM tbl_zkteco_code WHERE empl_code = $id";
        $query = $this->db->query($sql, array());
        $result = $query->result(); 
        if($result){
            return $result[0]->empl_id;
        }
           else{
            return "";
           }
 
      
    }

    function GET_COUNT_ZKTECO_RECORDS(){
        $sql = "SELECT * FROM tbl_zkteco ";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }

    function GET_ALL_EMPLOYEES(){
        $sql = "SELECT * FROM tbl_employee_infos ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_BIOMETRICS(){
        $sql = "SELECT * FROM tbl_biometrics ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    } 


    function GET_READY_PAYSLIP($period){
        $sql=  "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,
                col_empl_posi,col_empl_type FROM tbl_employee_infos
                WHERE termination_date='0000-00-00' AND
                disabled=0
                AND EXISTS(
                SELECT empl_id from tbl_attendance_records_lock
                WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$period
                )
                AND 
                NOT EXISTS (
                SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                tbl_payroll_payslips.PAYSLIP_PERIOD = $period)";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_NOT_READY_PAYSLIP($period){
        $sql=  "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,
                col_empl_posi,col_empl_type from tbl_employee_infos
                WHERE termination_date='0000-00-00' AND
                disabled=0
                AND NOT EXISTS(
                SELECT empl_id from tbl_attendance_records_lock
                WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$period
                )
                AND 
                NOT EXISTS (
                SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                tbl_payroll_payslips.PAYSLIP_PERIOD = $period)";
        $query = $this->db->query($sql);
        $query->next_result(); 
        return $query->result();
    }

 
    function IS_DUPLICATE_CMID($empl_id){
        $sql = "SELECT * FROM tbl_zkteco_code WHERE empl_cmid=?";
        $query = $this->db->query($sql , array($empl_id));
        return $query->num_rows();
    }

    function IS_DUPLICATE_CODE($code){
        $sql = "SELECT * FROM tbl_zkteco_code WHERE empl_code=?";
        $query = $this->db->query($sql , array($code));
        return $query->num_rows();
    }

    function UPDATE_EMPL_CODE($id, $empl_id, $code){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_zkteco_code SET edit_date=?, empl_id=?, empl_code=? WHERE empl_cmid=?";
        return $this->db->query($sql,array($edit_date,$id,$code,$empl_id));
    }

    function INSERT_EMPL_CODE($id, $empl_id, $code){
        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_zkteco_code (create_date, edit_date, empl_id, empl_cmid, empl_code) VALUES(?,?,?,?,?)";
        return $this->db->query($sql,array($create_date, $create_date, $id, $empl_id, $code));
    }


    

}