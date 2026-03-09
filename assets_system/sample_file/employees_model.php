<?php
class employees_model extends CI_Model
{
    // Display Employees
    function GET_EMPLOYEE_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_DEPENDENTS_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_dependents WHERE col_depe_empid=? AND is_deleted='0' ORDER BY col_depe_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_DEPENDENTS()
    {
        $sql = "SELECT * FROM tbl_employee_dependents";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMERGENCY()
    {
        $sql = "SELECT * FROM tbl_employee_emergency ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DOCUMENTS()
    {
        $sql = "SELECT * FROM tbl_employee_documents";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMERGENCY_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_emergency WHERE empid=? and is_deleted=0 ORDER BY name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
        function GET_EMERGENCY_SPECIFIC_BY_ID($id)
        {
            $sql = "SELECT * FROM tbl_employee_emergency WHERE id=? ORDER BY name";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        function ADD_EMERGENCY_CONTACT($empl_id,$relation,$contact_name,$mobile_num,$work_phone_number,$home_phone_number,$current_address){
            $sql="INSERT INTO tbl_employee_emergency(empid,name,relationship,mobile_number,work_phone,home_phone,current_address) VALUE(?,?,?,?,?,?,?)";
            return  $this->db->query($sql, array($empl_id,$contact_name,$relation,$mobile_num,$work_phone_number,$home_phone_number,$current_address));
        }
        function UPDATE_EMERGENCY_CONTACT($id,$empl_id,$relation,$contact_name,$mobile_num,$work_phone_number,$home_phone_number,$current_address){
            $sql="UPDATE tbl_employee_emergency 
                SET empid=?,name=?,relationship=?,mobile_number=?,work_phone=?,home_phone=?,current_address=? WHERE id=?";
            return  $this->db->query($sql, array($empl_id,$contact_name,$relation,$mobile_num,$work_phone_number,$home_phone_number,$current_address,$id));
        }
        function DELETE_EMERGENCY_CONTACT($id){
            $sql="UPDATE tbl_employee_emergency 
                SET is_deleted=1 WHERE id=?";
            return  $this->db->query($sql, array($id));
        }

    function GET_DOCUMENTS_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_documents WHERE col_empl_id=? AND is_deleted=0";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
        function ADD_EMPL_DOCUMENT($file,$file_name,$empl_id){
            $sql="INSERT INTO tbl_employee_documents(edit_user,col_doc_file,col_doc_name,col_empl_id)
                VALUE(?,?,?,?)
            ";
            return $this->db->query($sql, array($empl_id,$file,$file_name,$empl_id));
        }
        function DELETE_EMPL_DOCUMENT($id){
            $sql="UPDATE tbl_employee_documents SET is_deleted=1 WHERE id=?";
            return $this->db->query($sql, array($id));
        }
    function GET_TYPE()
    {
        $sql = "SELECT id,name FROM tbl_std_employeetypes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BRANCHES()
    {
        $sql = "SELECT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_POSITION()
    {
        $sql = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_DEPARTMENTS()
    {
        $sql = "SELECT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_DIVISIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SECTIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_GROUPS()
    {
        $sql = "SELECT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_LINES()
    {
        $sql = "SELECT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_TEAMS()
    {
        $sql = "SELECT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_GENDERS()
    {
        $sql = "SELECT id,name FROM tbl_std_genders";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_HMO()
    {
        $sql = "SELECT id,name FROM tbl_std_hmos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SHIRT_SIZE()
    {
        $sql = "SELECT id,name FROM tbl_std_shirtsizes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_MARITAL()
    {
        $sql = "SELECT id,name FROM tbl_std_maritalstatuses";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_NATIONALITY()
    {
        $sql = "SELECT id,name FROM tbl_std_nationalities";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_EDUCATION_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_education WHERE col_empl_id = ? AND is_deleted=0";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
        function DELETE_EDUCATION($id){
            $sql="UPDATE tbl_employee_education SET is_deleted=1 WHERE id=?";
            return $this->db->query($sql, array($id));
        }

    function GET_EDUCATION_SPECIFIC2($id)
    {
        $sql = "SELECT * FROM tbl_employee_education WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }



    function GET_SKILL_MATRIX_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_skillassign WHERE username = $employee_id AND status = 'Active' AND is_deleted=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
        function DELETE_EMPL_SKILL($id){
            $sql="UPDATE tbl_employee_skillassign SET is_deleted=1 WHERE id=?";
            return $this->db->query($sql, array($id));
        }


    function GET_SKILL_MATRIX_SPECIFIC2($id)
    {
        $sql = "SELECT * FROM tbl_employee_skillassign WHERE id=? AND status = 'Active'";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function GET_SKILL_NAME()
    {
        $sql = "SELECT id,name FROM tbl_std_skillnames";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SKILL_LEVEL()
    {
        $sql = "SELECT id,name FROM tbl_std_skilllevels";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_TEAM(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

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

    // Display DISTINCT line
    function MOD_DISP_DISTINCT_LINE(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_COMP_STRUCTURE(){
        $sql = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    
    function update_personal_det($first_name,$middlename,$lastname,$marital_status,$mobile_number,$birthdate,$gender,$nationality,$shirt_size,$email,$home_address,$current_address,$user_id){
        $sql = "UPDATE tbl_employee_infos SET col_last_name=?,col_midl_name=?,col_frst_name=?,col_mart_stat=?,col_home_addr=?,col_curr_addr=?,col_birt_date=?,col_empl_gend=?,col_empl_nati=?,col_shir_size=?,col_empl_emai=?,col_mobl_numb=? WHERE id=?";
        $query = $this->db->query($sql, array($lastname,$middlename,$first_name,$marital_status,$home_address,$current_address,$birthdate,$gender,$nationality,$shirt_size,$email,$mobile_number,$user_id));
    }

    function update_employment_det($hired_date,$reg_date,$resign_Date,$end_date,$emp_type,$position,$branch,$dept,$division,$sec,$group,$line,$team,$com_num,$com_email,$hmo_prov,$hmo_num,$user_id){
        $sql = "UPDATE tbl_employee_infos SET date_regular=?,col_hire_date=?,col_endd_date=?,resignation_date=?,col_empl_type=?,col_empl_posi=?,col_empl_branch=?,col_empl_dept=?,col_empl_divi=?,col_empl_sect=?,col_empl_group=?,col_empl_line=?,col_empl_team=?,col_comp_emai=?,col_comp_numb=?,col_empl_hmoo=?,col_empl_hmon=? WHERE id=?";
        $query = $this->db->query($sql, array($reg_date,$hired_date,$end_date,$resign_Date,$emp_type,$position,$branch,$dept,$division,$sec,$group,$line,$team,$com_email,$com_num,$hmo_prov,$hmo_num,$user_id));
    }

    function update_id_det($sss,$hdmf,$philhealth,$tin,$driver_lic,$nat_id,$passport,$user_id){
        $sql = "UPDATE tbl_employee_infos SET col_empl_sssc=?,col_empl_hdmf=?,col_empl_phil=?,col_empl_btin=?,col_empl_driv=?,col_empl_naid=?,col_empl_pass=? WHERE id=?";
        $query = $this->db->query($sql, array($sss,$hdmf,$philhealth,$tin,$driver_lic,$nat_id,$passport,$user_id));
    }

    function update_comp_det($salary_type,$salary_rate,$bank,$branch,$acc_type,$payment_type,$acc_num,$user_id){
        $sql = "UPDATE tbl_employee_infos SET salary_rate=?,salary_type=?,bank_name=?,branch_name=?,account_number=?,account_type=?,payment_type=? WHERE id=?";
        $query = $this->db->query($sql, array($salary_rate,$salary_type,$bank,$branch,$acc_num,$acc_type,$payment_type,$user_id));
    }

    function update_educ_det($degree,$school,$address,$from_yr,$to_yr,$completion,$educ_id,$user_id,$grade,$level){
        $sql = "UPDATE tbl_employee_education SET col_educ_degree=?, col_educ_school=?, col_educ_from_yr=?, col_educ_to_yr=?,address=?,completion=?,col_educ_grade=?,col_educ_level=? WHERE id=?";
        return $this->db->query($sql, array($degree,$school,$from_yr,$to_yr,$address,$completion,$grade,$level,$educ_id));
    }
    function add_new_educ($degree,$school,$address,$from_yr,$to_yr,$completion,$user_id,$grade,$level){
        $sql="INSERT INTO tbl_employee_education(col_empl_id, col_educ_degree, col_educ_school, col_educ_from_yr, col_educ_to_yr, col_educ_grade, address, completion, col_educ_level)
            VALUE(?,?,?,?,?,?,?,?,?)
        ";
        return $this->db->query($sql, array($user_id,$degree,$school,$from_yr,$to_yr,$grade,$address,$completion,$level));
    }
    function update_skill_det($title,$level,$skill_id){
        $sql = "UPDATE tbl_employee_skillassign SET name=?, value=?  WHERE id=?";
        return $this->db->query($sql, array($title, $level, $skill_id));
    }
    function add_new_skill($user_id,$level,$skill){
        $sql="INSERT INTO tbl_employee_skillassign(username,name,value,status) VALUE(?,?,?,?)";
        return  $this->db->query($sql, array($user_id, $skill, $level,'Active'));
    }
    function add_new_dependent($user_id,$full_name,$b_day,$gender,$relationship){
        $sql="INSERT INTO tbl_employee_dependents(col_depe_empid, col_depe_name, col_depe_bday, col_depe_gndr, col_depe_rela) VALUE(?,?,?,?,?)";
        return  $this->db->query($sql, array($user_id,$full_name,$b_day,$gender,$relationship));
    }
    function get_specific_dependent($id){
        $sql="SELECT * FROM tbl_employee_dependents WHERE id=? LIMIT 1";
        return $this->db->query($sql, array($id))->row_array();
    }
    function update_specific_dependent($id,$full_name,$b_day,$gender,$relationship){
        $sql="UPDATE tbl_employee_dependents SET col_depe_name=?, col_depe_bday=?, col_depe_gndr=?, col_depe_rela=? WHERE id=?";
        return  $this->db->query($sql, array($full_name,$b_day,$gender,$relationship,$id));
    }
    function delete_dependent($id){
        $sql ="UPDATE tbl_employee_dependents SET is_deleted=? WHERE id=?";
        return $this->db->query($sql, array(1,$id));
    }
    //========================================================== CSV =======================================================

    function updtRecord($filedata)
    {
        if(count($filedata) > 0)
        {
            $newdate = str_replace('/', '-', $filedata[7]);
			$birthday = date("Y-m-d", strtotime($newdate));
            $newdate_2 = str_replace('/', '-', $filedata[15]);
			$hired_on = date("Y-m-d", strtotime($newdate_2));
            if((substr(strval($filedata[13]), 0, 1) == '9') || (substr(strval($filedata[13]), 0, 1) == 9))
            {
                $mobile_number = '0'.strval($filedata[13]);
            } else {
                $mobile_number = ($filedata[13]);
            }
            if((substr(strval($filedata[14]), 0, 1) == '9') || (substr(strval($filedata[14]), 0, 1) == 9))
            {
                $work_phone_number = '0'.strval($filedata[14]);
            } else {
                $work_phone_number = ($filedata[14]);
            }
            $employee_cmid = strval($filedata[0]);
            $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE_BASED_CMID($filedata[0]);
            $username = str_pad($employee_cmid,5,"0",STR_PAD_LEFT);
            // $db_reporting_to = $this->P020_EMPLIST_MOD->MOD_DISP_EMPL_KEY($filedata[19]);
            // $reporting_to = $db_reporting_to['id'];
            $sql = "UPDATE tbl_employee_infos SET col_user_name=? ,col_last_name = ?,col_midl_name = ?,col_frst_name = ?,col_mart_stat = ?,col_home_addr = ?,col_curr_addr = ?,col_birt_date = ?,col_empl_gend = ?,col_empl_nati = ?,col_shir_size = ?,col_empl_emai = ?,col_comp_emai = ?,col_mobl_numb = ?,col_comp_numb = ?,col_hire_date = ?,col_empl_type = ?,col_empl_posi = ?,col_empl_group = ?,col_empl_line = ?,col_empl_dept = ?,col_empl_sect = ?,col_imag_path = ?,col_empl_sssc = ?,col_empl_hdmf = ?,col_empl_phil = ?,col_empl_btin = ?,col_empl_driv = ?,col_empl_naid = ?,col_empl_pass = ?,col_empl_hmoo = ?,col_empl_hmon = ?,salary_rate = ?,salary_type = ?,pioneer_allowance = ?,load_allowance = ?,skill_allowance = ?,group_leader_allowance = ?,transpo_allowance = ?,sch1_name=?,sch1_deg=?,sch1_from=?,sch1_to=?,sch1_gwa=?,sch2_name=?,sch2_deg=?,sch2_from=?,sch2_to=?,sch2_gwa=?,sch3_name=?,sch3_deg=?,sch3_from=?,sch3_to=?,sch3_gwa=?,skill_name1=?,skill_lvl1=?,skill_name2=?,skill_lvl2=?,emer_cont_name=?,emer_cont_rel=?,emer_cont_num=?,emer_cont_workphone=?,emer_cont_homephone=?,emer_cont_add=?,dep_name1=?,dep_birth1=?,dep_gend1=?,dep_rel1=?,dep_name2=?,dep_birth2=?,dep_gend2=?,dep_rel2=?,dep_name3=?,dep_birth3=?,dep_gend3=?,dep_rel3=?,dep_name4=?,dep_birth4=?,dep_gend4=?,dep_rel4=? WHERE col_empl_cmid=?";
            $this->db->query($sql,array($username, $filedata[1], $filedata[2], $filedata[3], $filedata[4], $filedata[5], $filedata[6], $birthday, $filedata[8], $filedata[9], $filedata[10], $filedata[11], $filedata[12], $mobile_number, $work_phone_number,$hired_on, $filedata[16], $filedata[17], $filedata[18], $filedata[19], $filedata[20], $filedata[21], $filedata[22], $filedata[23], $filedata[24], $filedata[25], $filedata[26], $filedata[27], $filedata[28], $filedata[29], $filedata[30], $filedata[31], $filedata[32], $filedata[33], $filedata[34], $filedata[35], $filedata[36], $filedata[37], $filedata[38], $filedata[39], $filedata[40], $filedata[41], $filedata[42], $filedata[43], $filedata[44], $filedata[45], $filedata[46], $filedata[47], $filedata[48], $filedata[49], $filedata[50], $filedata[51], $filedata[52], $filedata[53], $filedata[54], $filedata[55], $filedata[56], $filedata[57], $filedata[58], $filedata[59], $filedata[60], $filedata[61], $filedata[62], $filedata[63], $filedata[64], $filedata[65], $filedata[66], $filedata[67], $filedata[68], $filedata[69], $filedata[70], $filedata[71], $filedata[72], $filedata[73], $filedata[74], $filedata[75], $filedata[76], $filedata[77], $filedata[78], $filedata[79], $employee_cmid));
        }
    }

    function checkDuplicateEmplId($employee_id){
        $sql = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE col_empl_cmid = ?";
        $query = $this->db->query($sql,array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES_LIMIT($offset, $row, $dept, $sec, $group, $line,$branch,$division,$team, $status)
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
        else if($branch){
            $filter_q = " AND col_empl_branch=".$branch;
        }
        else if($division){
            $filter_q = " AND col_empl_divi=".$division;
        }
        else if($team){
            $filter_q = " AND col_empl_team=".$team;
        }
        else if($status){
            $filter_q = " AND disabled=".$status;
        }else{
            $filter_q = "";
        }
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00'" .$filter_q. " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid  LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_SEARCH_EMPLOYEES($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos
        LEFT JOIN tbl_std_departments ON tbl_std_departments.id = tbl_employee_infos.col_empl_dept
        LEFT JOIN tbl_std_employeetypes ON tbl_std_employeetypes.id = tbl_employee_infos.col_empl_type
        LEFT JOIN tbl_std_positions ON tbl_std_positions.id = tbl_employee_infos.col_empl_posi
        LEFT JOIN tbl_std_sections ON tbl_std_sections.id = tbl_employee_infos.col_empl_sect
        LEFT JOIN tbl_std_groups ON tbl_std_groups.id = tbl_employee_infos.col_empl_group
        LEFT JOIN tbl_std_lines ON tbl_std_lines.id = tbl_employee_infos.col_empl_line
        WHERE tbl_employee_infos.id LIKE '%$search%'
        OR tbl_employee_infos.col_last_name LIKE '%$search%'
        OR tbl_employee_infos.col_frst_name LIKE '%$search%'
        OR tbl_employee_infos.col_midl_name LIKE '%$search%'
        OR tbl_std_departments.name LIKE '%$search%'
        OR tbl_std_employeetypes.name LIKE '%$search%'
        OR tbl_std_positions.name LIKE '%$search%'
        OR tbl_std_sections.name LIKE '%$search%'
        OR tbl_std_groups.name LIKE '%$search%'
        OR tbl_std_lines.name LIKE '%$search%'
        ORDER BY tbl_employee_infos.id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_SEARCHED_DATA($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_frst_name LIKE '$search%' OR col_last_name LIKE '$search%' OR col_midl_name LIKE '$search%' OR col_empl_emai LIKE '$search%' OR col_mobl_numb LIKE '$search%' AND isSuperAdmin != 1 AND termination_type=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function SET_ACTIVATION_EMPLOYEE($id,$is_active){
        $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
        $query = $this->db->query($sql, array($is_active, $id));
    }
    function MOD_INSRT_EMPLOYEE($empl_cmid, $last_name, $middle_name, $first_name, $email, $birthday, $gender, $mobile_num, $hired_on, $empl_type, $position, $department, $section, $group, $line, $home_address, $current_address, $marital_status, $nationality, $shirt_size, $salary_rate, $salary_type)
    {
        $salt=bin2hex(openssl_random_pseudo_bytes(22));
        $password= ucfirst($last_name.'.'.date_format(date_create($birthday),"Y"));
        $encrypted_password = md5($password.''.$salt);
        $empl_username = str_pad($empl_cmid, 5, "0", STR_PAD_LEFT);
        $sql = "INSERT INTO tbl_employee_infos(col_empl_cmid,col_user_date,col_user_name,col_user_pass,col_salt_key,col_last_name,col_midl_name,col_frst_name,col_empl_emai,col_birt_date,col_empl_gend,col_mobl_numb,col_hire_date,col_empl_type,col_empl_posi,col_empl_dept,col_empl_sect,col_empl_group,col_empl_line,col_home_addr,col_curr_addr,col_mart_stat,col_empl_nati,col_shir_size,salary_rate,salary_type,col_user_access) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($empl_cmid, date('Y-m-d H:i:s'), $empl_username, $encrypted_password,$salt, $last_name, $middle_name, $first_name, $email, $birthday, $gender, $mobile_num, $hired_on, $empl_type, $position, $department, $section, $group, $line, $home_address, $current_address, $marital_status, $nationality, $shirt_size, $salary_rate, $salary_type,$empl_type));
        return $this->db->insert_id();
    }

    function test($first_name,$birthdate){
        $salt=bin2hex(openssl_random_pseudo_bytes(22));
        $clean_password= ucfirst($last_name.'@'.date_format(date_create($birthdate),"mdY"));
        $encrypted_password = md5($clean_password.''.$salt);
        echo $salt;
        echo "<br>";
        echo "Encrpted password ".$encrypted_password;
        $decrypted_password = md5($clean_password.''.$salt);
        echo "<br>";
        echo "Decripted Password ".$decrypted_password;

    }
    function insert_employee_image($user_img, $userID)
    {
        $sql = "UPDATE tbl_employee_infos SET col_imag_path=? WHERE id=?";
        $query = $this->db->query($sql, array($user_img, $userID));
    }

    function MOD_GET_FILTER_DATA($department, $line, $group, $section, $status)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_DEPARTMENT($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_dept FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_SECTION($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_sect FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_GROUP($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_group FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_LINE($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_line FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        // $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY col_empl_cmid DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES_PAGINATION($num_start, $num_limit)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid LIMIT ?,?";
        // $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY col_empl_cmid DESC";
        $query = $this->db->query($sql, array($num_start, $num_limit));
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


    function get_empl_cmid($empl_cmid)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_empl_cmid=? ";
        $query = $this->db->query($sql, array($empl_cmid));
        return $query->num_rows();
    }

    function GET_SYSTEM_SETTING($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
        
    }

    function GET_ALLOWANCE_TYPES(){
        $sql = "SELECT * FROM tbl_std_allowances ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_TAXABLE_ALLOWANCE_TYPES(){
        $sql = "SELECT * FROM tbl_std_allowances_tax ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_NON_TAXABLE_ALLOWANCE_TYPES(){
        $sql = "SELECT * FROM tbl_std_allowances_nontax ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_TAXABLE_DEDUCTION_TYPES(){
        $sql = "SELECT * FROM tbl_std_deductions_tax ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_NON_TAXABLE_DEDUCTION_TYPES(){
        $sql = "SELECT * FROM tbl_std_deductions_nontax ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos WHERE termination_date = '0000-00-00'
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY id ASC, col_empl_cmid
        LIMIT ".$offset.", ".$row." ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_EMPLOYEELIST(){
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00'";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }

    function GET_YEARS()
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassign WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_NON_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassignnontax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DEDUCTION_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DEDUCTION_NON_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassignnontax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    

    function is_duplicate($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_allowanceassign WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function is_duplicate_allowance_tax($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_allowanceassigntax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function is_duplicate_allowance_nontax($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_allowanceassignnontax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function is_duplicate_deduction_tax($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_deductionassigntax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function is_duplicate_deduction_nontax($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_deductionassignnontax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function add_user_allowance($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassign (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function update_user_allowance($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassign SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function add_user_allowance_tax($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassigntax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function update_user_allowance_tax($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassigntax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function add_user_allowance_nontax($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassignnontax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function update_user_allowance_nontax($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassignnontax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function add_user_deduction_tax($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_deductionassigntax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function update_user_deduction_tax($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_deductionassigntax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function add_user_deduction_nontax($user_id,$val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_deductionassignnontax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$val, $year));
    }

    function update_user_deduction_nontax($user_id,$val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_deductionassignnontax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$val,$user_id,$year,$type));
    }


    function UPDATE_SALARY_DETAILS($user_id,$value){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_rate=? WHERE id=?";
        return $this->db->query($sql,array($edit_date,$value,$user_id));
    }

    function UPDATE_SALARY_TYPE_DETAILS($user_id,$value){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_type=? WHERE id=?";
        return $this->db->query($sql,array($edit_date,$value,$user_id));
    }

    function UPDATE_SALARY_BULK($id, $salary_amount ,$salary_type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_rate=?, salary_type=? WHERE id=? ";
        return $this->db->query($sql,array($edit_date, $salary_amount, $salary_type, $id));
    }

    function UPDATE_EMPLOYEE_DISABLED($empl_id, $value){
        $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
        $query = $this->db->query($sql, array($value, $empl_id));
    }

}