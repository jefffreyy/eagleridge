<?php
class hressentials_model extends CI_Model
{
    // Display Employees

    function GET_STARTER_CHECKBOX()
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'starter_guide'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_EMPLOYEES(){
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,LEFT(col_midl_name,1) as col_midl_name ,col_frst_name',false)
        ->where('disabled',0)
        ->where("termination_date is NULL OR termination_date='0000-00-00'");
        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();

    }
    function GET_FORMATTED_ALL_EMPLOYEES(){
        $this->db->select("id, CONCAT_WS('',COALESCE(col_last_name, ''),
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS employee",false);
        $this->db->from('tbl_employee_infos');
        $this->db->where("(termination_date is null OR termination_date='0000-00-00') AND disabled=0");
        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query=$this->db->get();
        return $query->result();
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function GET_SUPPORT_LIST($tab, $limit, $offset,$employee){
        $this->db->select("tb1.*,
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-', COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee
        ",false);
        $this->db->from('tbl_hr_supports as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.employee_id=tb2.id','left');
        $this->db->where('tb1.status',$tab);
        if($employee){
            $this->db->where('tb1.employee_id',$employee);
        }
        $this->db->limit($limit,$offset);
        $query=$this->db->get();
        return $query->result();
    }
    function GET_SUPPORT_LIST_COUNT($tab,$employee){
        $this->db->where('status',$tab);
        if($employee){
            $this->db->where('employee_id',$employee);
        }
        $query=$this->db->get('tbl_hr_supports');
        return $query->num_rows();
    }
    function GET_COMPLAINT_LIST($tab, $limit, $offset,$employee){
        $this->db->select("tb1.*,
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-', COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee
        ",false);
        $this->db->from('tbl_hr_complaints as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.employee_id=tb2.id','left');
        $this->db->where('tb1.status',$tab);
        if($employee){
            $this->db->where('tb1.employee_id',$employee);
        }
        $this->db->limit($limit,$offset);
        $query=$this->db->get();
        return $query->result();
    }
    function GET_COMPLAINT_LIST_COUNT($tab,$employee){
        $this->db->where('status',$tab);
        if($employee){
            $this->db->where('employee_id',$employee);
        }
        $query=$this->db->get('tbl_hr_complaints');
        return $query->num_rows();
    }
    function GET_COMPLAINT($id){
        $this->db->select("tb1.*,
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-', COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS last_editor
        ",false);
        $this->db->from('tbl_hr_complaints as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.edit_user=tb2.id','left');
        $this->db->where('tb1.id',$id);
        
        $query=$this->db->get();
        return $query->row();
    } 
    function GET_SURVEY_LIST($tab, $limit, $offset,$employee){
        $this->db->select("tb1.*,
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-', COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee
        ",false);
        $this->db->from('tbl_hr_surveys as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.employee_id=tb2.id','left');
        $this->db->where('tb1.status',$tab);
        if($employee){
            $this->db->where('tb1.employee_id',$employee);
        }
        $this->db->limit($limit,$offset);
        $query=$this->db->get();
        return $query->result();
    }
    function GET_SURVEY_LIST_COUNT($tab,$employee){
        $this->db->where('status',$tab);
        if($employee){
            $this->db->where('employee_id',$employee);
        }
        $query=$this->db->get('tbl_hr_surveys');
        return $query->num_rows();
    }
     function GET_SURVEY($id){
        $this->db->select("tb1.*,
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-', COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS last_editor
        ",false);
        $this->db->from('tbl_hr_surveys as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.edit_user=tb2.id','left');
        $this->db->where('tb1.id',$id);
        
        $query=$this->db->get();
        return $query->row();
    }
    function GET_SUPPORT($id){
        $this->db->select("tb1.*,
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-', COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS last_editor
        ",false);
        $this->db->from('tbl_hr_supports as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.edit_user=tb2.id','left');
        $this->db->where('tb1.id',$id);
        
        $query=$this->db->get();
        return $query->row();
    }
    function GET_EMPLOYEES(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0";
        $query = $this->db->query($sql);
        $temp=$query->result_array();
        $results=array();
        foreach($temp as $result){
            $results[]=$result["id"];
        }
        return $results;
    }
    function UPDATE_STARTER_CHECKBOX($guide)
    {
        $sql = "UPDATE tbl_system_setup SET value = $guide WHERE setting = 'starter_guide'";
        $query = $this->db->query($sql);
  
    }
    
    function USER_EVENT_CALENDAR()                              //JERENZ: NO USER EVENT CALENDAR FOUND IN THE HRESSENTIALS CONTROLLER
    {
        $sql = "SELECT * FROM test_calendar_event";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_TYPE($id){                            //JERENZ: NO GET SPECIFIC TYPE FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT name FROM tbl_std_employeetypes WHERE id =?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_All_EMPLOYEE_TYPES(){                          //JERENZ: NO GET ALL EMPLOYEE TYPES FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT id,name FROM tbl_std_employeetypes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->row();
    }
    function GET_EMPLOYEE_BY_TYPES(){
        $sql = "SELECT  col_empl_type,count(col_empl_type) as amount  FROM tbl_employee_infos Where termination_type=0 group by col_empl_type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        $data=$query->result();
        $new_data=array();
        $index=0;
        foreach($data as $empl){
            $res=$this->GET_SPECIFIC_TYPE($empl->col_empl_type);
            if(!isset($res->name)){
                continue;
            }
            $new_data["label"][]=$res->name.' Employee';
            $new_data["amount"][]=$empl->amount;
            $new_data["colors"][]='rgb('.rand(54,255).','.rand(54,255).','.rand(54,255).')';
        }
        return $new_data;
    }
    function GET_LEAVERS($hire_year,$date_num){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type!=0 AND DATE_FORMAT(col_hire_date, '%Y')=? AND DATE_FORMAT(termination_date, '%c')=?";
        $query = $this->db->query($sql, array($hire_year,$date_num));
        $query->next_result();
        return $query->num_rows();
    }
    function GET_DEPARTMENTS(){                          //JERENZ: NO GET DEPARTMENTS FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
        
    }
    function GET_EMPLOYEE_BY_DEPARTMENT(){               //JERENZ: NO GET EMPLOYEE BY DEPARTMENT FOUND IN THE HRESSENTIALS CONTROLLER
        
        $sql = "SELECT col_empl_dept,count(col_empl_dept) as total_employee FROM tbl_employee_infos Where termination_type=0 group by col_empl_dept";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_HIRED_DATA(){
        $sql = "SELECT date_format(col_hire_date,'%Y-%m') as month,count(col_hire_date) as total_employee FROM tbl_employee_infos  where col_hire_date > DATE_SUB(now(), INTERVAL 6 MONTH) AND termination_type=0 group by date_format(col_hire_date,'%Y-%m')";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SKILL_DATA(){
        $sql="SELECT distinct username FROM tbl_employee_skillassign";
        $query = $this->db->query($sql, array());
        $temp_result=$query->result_array();
        $results=array();
        foreach($temp_result as $result){
            $results[]=$result["username"];
        }
        return $results;
    }
    function GET_JOINERS($hire_year,$hire_date){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND DATE_FORMAT(col_hire_date, '%Y')=? AND DATE_FORMAT(col_hire_date, '%c')=?";
        $query = $this->db->query($sql, array($hire_year,$hire_date));
        $query->next_result();
        return $query->num_rows();
    }
    function GET_EDUCATION_DATA(){
        $sql="SELECT distinct col_empl_id FROM tbl_employee_education";
        $query = $this->db->query($sql, array());
        $temp_result=$query->result_array();
        $results=array();
        foreach($temp_result as $result){
            $results[]=$result["col_empl_id"];
        }
        return $results;
    }
    function GET_DEPENDENTS_DATA(){
        $sql="SELECT distinct col_depe_empid FROM tbl_employee_dependents";
        $query = $this->db->query($sql, array());
        $temp_result=$query->result_array();
        $results=array();
        foreach($temp_result as $result){
            $results[]=$result["col_depe_empid"];
        }
        return $results;
    }
    function GET_ALL_GENDER(){
        $sql = "SELECT id,name FROM tbl_std_genders WHERE status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_TOTAL_EMPLOYEE(){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->num_rows();
    }

    function GET_TOTAL_RESIGNED(){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type=2";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->num_rows();
    }

    function GET_TOTAL_AWOL(){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type=1";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->num_rows();
    }

    function GET_TOTAL_END_CONTRACT(){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type=3";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->num_rows();
    }

    function GET_TOTAL_TERMINATED(){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type=4";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->num_rows();
    }
    

    function GET_DATA_AGE_IN_RANGE(){
        $sql="SELECT 
        SUM(IF(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), col_birt_date)), '%Y') + 1 BETWEEN 18 and 25,1,0)) as '18 - 25',
        SUM(IF(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), col_birt_date)), '%Y') + 1 BETWEEN 26 and 35,1,0)) as '26 - 35',
        SUM(IF(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), col_birt_date)), '%Y') + 1 BETWEEN 36 and 45,1,0)) as '36 - 45',
        SUM(IF(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), col_birt_date)), '%Y') + 1 BETWEEN 46 and 55,1,0)) as '46 - 55',
        SUM(IF(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), col_birt_date)), '%Y') + 1 BETWEEN 56 and 150,1,0)) as '55 - 65+'
        FROM tbl_employee_infos WHERE termination_type=0";
        $query = $this->db->query($sql, array());
        $temp_results= $query->row_array();
        $results=array();
        $results["labels"]=array();
        $results["data"]=array();
        foreach($temp_results as $key => $value){
            $results["labels"][]=$key;
            $results["data"][]=(int)$value;
        }
        return $results;
    }
    function GET_DATA_SALARY_IN_RANGE(){
        $sql="SELECT 
        SUM(IF( salary_rate=0 ,1,0)) as 'No salary',
        SUM(IF( salary_rate BETWEEN 1 and 19999,1,0)) as '-20K',
        SUM(IF( salary_rate BETWEEN 20000 and 34999,1,0)) as '25k-35k',
        SUM(IF( salary_rate BETWEEN 35000 and 49999,1,0)) as '35k-50k',
        SUM(IF( salary_rate BETWEEN 50000 and 65000,1,0)) as '50K-65k'
        FROM tbl_employee_infos WHERE termination_type=0";
        $query = $this->db->query($sql, array());
        $temp_results= $query->row_array();
        $results=array();
        $results["labels"]=array();
        $results["data"]=array();
        foreach($temp_results as $key => $value){
            $results["labels"][]=$key;
            $results["data"][]=(int)$value;
        }
        return $results;
    }
    function GET_AGE_AVG(){
        $sql="SELECT AVG(DATE_FORMAT(FROM_DAYS(DATEDIFF(NOW(), col_birt_date)), '%Y') + 1) as average_Age FROM tbl_employee_infos WHERE termination_type=0";
        $query = $this->db->query($sql, array());
        return $query->row_array()["average_Age"];
    }
    function GET_SALARY_AVG(){
        $sql="SELECT AVG(salary_rate) as average_Salary FROM tbl_employee_infos WHERE termination_type=0";
        $query = $this->db->query($sql, array());
        return $query->row_array()["average_Salary"];
    }
    function GET_DATA_SALARY_TYPE(){
        $sql="SELECT concat(salary_type,'allowance') as salary_type,count(salary_type) as total
        FROM tbl_employee_infos WHERE termination_type=0 group by salary_type";
        $query = $this->db->query($sql, array());
        $temp_data=$query->result_array();
        $results=array();
        $results["labels"]=array();
        $results["data"]=array();
        foreach($temp_data as $obj){
            foreach($obj as $key => $value){
               if($key=="salary_type"){
                $results["labels"][]=$value;
               }else{
                $results["data"][]=$value;
               }
            }
        }
        return $results;
    
    }
    function GET_BY_GENDER_EMPLOYEE(){
        $sql = "SELECT col_empl_gend,count(col_empl_gend) as total_employee FROM tbl_employee_infos WHERE termination_type=0 group by col_empl_gend";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ACTIVITIES($limit,$offset){
        $this->db->limit($limit,$offset);
        $this->db->order_by("id","Desc");
        $query=$this->db->get("tbl_activities");
        return $query->result();
    }
    function GET_ACTIVITIES_COUNT(){
        $query=$this->db->get("tbl_activities");
        return $query->num_rows();
    }
    function GET_ACTIVITY_PARTICIPANTS($activity_id,$limit,$offset){
        $this->db->select("tb1.*,tb2.col_empl_cmid,
        CONCAT_WS('',COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee
        ",false);
        $this->db->from("tbl_participants as tb1");
        $this->db->join("tbl_employee_infos as tb2","tb1.empl_id=tb2.id","left");
        $this->db->where("tb1.activity_id",$activity_id);
        $this->db->limit($limit,$offset);
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query=$this->db->get();
        return $query->result();
    }
    function GET_ACTIVITY_PARTICIPANTS_COUNT($activity_id){
        $this->db->where("activity_id",$activity_id);
        $query=$this->db->get("tbl_participants");
        return $query->num_rows();
    }
    function ADD_DATA($table_name,$data){
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }
    function ADD_BATCH_DATA($table_name,$data){
        return $this->db->insert_batch($table_name, $data);
    }
    function UPDATE_PARTICIPANTS($activity_id,$data){
        $this->db->where('activity_id',$activity_id)
        ->delete("tbl_participants");
        return $this->db->insert_batch("tbl_participants",$data);
    }
    function GET_TERMINATED_EMPL_DATA(){
        $sql = "SELECT date_format(col_hire_date,'%Y-%m') as month,count(col_hire_date) as total_employee FROM tbl_employee_infos  where col_hire_date > DATE_SUB(now(), INTERVAL 6 MONTH) AND termination_type!=0 group by date_format(col_hire_date,'%Y-%m')";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_BY_DEPARTMENT_DATA(){
        $departments=$this->GET_DEPARTMENTS();
        $employee_by_department=$this->GET_EMPLOYEE_BY_DEPARTMENT();
        $index=0;
        $arr_data=array();
        foreach($departments as $department){
            $arr_data["labels"][]=$department->name;
            $arr_data["amount"][$index]=0;
            foreach($employee_by_department as $empl){
                if($empl->col_empl_dept==$department->id){
                    $arr_data["amount"][$index]=$empl->total_employee;
                }
            }
            $index+=1;
        }
      
            // var_dump($employee_by_department);
        return $arr_data;
    }

    function GET_TERMINATION_COUNT(){
        $sql = "SELECT termination_type AS type, COUNT(termination_type) AS termination_count FROM tbl_employee_infos WHERE termination_type != 0 GROUP BY termination_type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TERMINATION_TYPE(){
        $sql = "SELECT id, name FROM tbl_std_terminationtypes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_REGULAR_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type = 0 AND col_empl_type = 1 ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_PROBATIONARY_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type = 0 AND col_empl_type = 2 ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_PROJ_BASE_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type = 0 AND col_empl_type = 3 ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }


    function GET_MALE_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type = 0 AND col_empl_gend = 1 ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_FEMALE_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type = 0 AND col_empl_gend = 2 ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }


    function GET_MONTHLY_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND salary_type ='Monthly'";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_DAILY_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND salary_type ='Daily'";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }


    function GET_PRODUCTION_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND col_empl_dept=1";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_MANU_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND col_empl_dept=2";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_ADMIN_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND col_empl_dept=3";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_SALES_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND col_empl_dept=4";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_ACCOUNTING_COUNT(){
        $sql = "SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND col_empl_dept=5";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function MOD_DISP_DISTINCT_TEAM(){                      //JERENZ: NO MOD DISP DISTINCT TEAM FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_BRANCH(){                    //JERENZ: NO MOD DISP DISTINCT BRANCH FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DEPARTMENT(){                //JERENZ: NO MOD DISP DISTINCT DEPARTMENT FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DIVISION(){                  //JERENZ: NO MOD DISP DISTINCT DIVISION FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT SECTION
    function MOD_DISP_DISTINCT_SECTION(){                   //JERENZ: NO MOD DISP DISTINCT SECTION FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

     // Display DISTINCT Group
     function MOD_DISP_DISTINCT_GROUP(){                    //JERENZ: NO MOD DISP DISTINCT GROUP FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT line
    function MOD_DISP_DISTINCT_LINE(){                      //JERENZ: NO MOD DISP DISTINCT LINE FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_SYSTEM_SETTING($setting){                  //JERENZ: NO GET SYSTEM SETTING FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
        
    }

    function GET_DEDUCTION_TAX_DATA($year){                //JERENZ: NO GET DEDUCTION TAX DATA FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_EMPLOYEELIST(){                     //JERENZ: NO GET COUNT EMPLOYEELIST FOUND IN THE HRESSENTIALS CONTROLLER
        $sql = "SELECT * FROM tbl_employee_infos ";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }


    function GET_FILTERED_EMPLOYEELIST($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){               //JERENZ: NO GET FILTERED EMPLOYEELIST FOUND IN THE HRESSENTIALS CONTROLLER

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line, salary_rate, salary_type FROM tbl_employee_infos 
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0       
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

    function GET_YEARS()                                //JERENZ: DISABLED IN THE HRESSENTIALS CONTROLLER
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    function HR_ABOUTCOMPANY(){
        $sql = "SELECT * FROM tbl_hr_aboutcompany";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function UPDATE_MESSAGE($htmlContent){
        $tableName = 'tbl_hr_welcomemessage';
        $columnName = 'html_content';
        $idToUpdate = 1;
        $editDate = date('Y-m-d H:i:s');
        $query = $this->db->get($tableName);
        if ($query->num_rows() > 0) {
            $update_data = array(
                $columnName => $htmlContent,
                'edit_date' => $editDate
            );
            $this->db->where('id', $idToUpdate);
            $this->db->update($tableName, $update_data);
            if ($this->db->affected_rows() > 0) {
                return array('messageSuccess' => 'Welcome Message Saved Successfully');
            } else {
                return array('messageError' => 'Error Saving Welcome Message');
            }

        } else {
            $update_data = array(
                $columnName => $htmlContent,
                'edit_date' => $editDate
            );
            $this->db->insert($tableName, $update_data);
            return array('messageSuccess' => 'Welcome Message Saved Successfully');
            // return array('messageError' => 'Record with ID $idToUpdate does not exist.');
        }
    }

    function GET_WELCOME_MESSAGE(){
        $tableName = 'tbl_hr_welcomemessage';
        $columnName = 'html_content';
        $idToRetrieve = 1;
        $query = $this->db->select($columnName)->from($tableName)->where('id', $idToRetrieve)->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            $htmlContent = $result->$columnName;
            $data = array('htmlContent' => $htmlContent);
            return $data;
        } else {
            return null;
        }
    }
    function UPDATE_ABOUT_THE_COMPANY($htmlContent){
        $tableName = 'tbl_hr_aboutcompany';
        $columnName = 'html_content';
        $idToUpdate = 1;
        $editDate = date('Y-m-d H:i:s');
        $query = $this->db->get($tableName);
        if ($query->num_rows() > 0) {
            $update_data = array(
                $columnName => $htmlContent,
                'edit_date' => $editDate
            );
            $this->db->where('id', $idToUpdate);
            $this->db->update($tableName, $update_data);
            if ($this->db->affected_rows() > 0) {
                return array('messageSuccess' => 'About The Company Saved Successfully');
            } else {
                return array('messageError' => 'Error Saving About The Company');
            }
        } 
        else {
            // return array('messageError' => 'Record with ID $idToUpdate does not exist.');
            $update_data = array(
                $columnName => $htmlContent,
                'edit_date' => $editDate
            );
            $this->db->insert($tableName, $update_data);
            return array('messageSuccess' => 'About The Company Saved Successfully');

        }
    }
    function GET_ABOUT_THE_COMPANY(){
        $tableName = 'tbl_hr_aboutcompany';
        $columnName = 'html_content';
        $idToRetrieve = 1;
        $query = $this->db->select($columnName)->from($tableName)->where('id', $idToRetrieve)->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            $htmlContent = $result->$columnName;
            $data = array('htmlContent' => $htmlContent);
            return $data;
        } else {
            return null;
        }
    }
    function GET_WARNINGS($limit,$offset,$status){
        $this->db->select("CONCAT('WRN',LPAD(tb1.id,5,'0')) as format_id,tb1.id,tb1.title,tb1.description,tb1.feedback,tb1.status",false);
        $this->db->select("
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''),
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT('-', tb2.col_last_name) ELSE '' END,
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname
        ",false);
        $this->db->from('tbl_hr_warnings as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.employee_id=tb2.id','left')
        ->where('tb1.status',$status)
        ->order_by('tb1.id','desc')
        ->limit($limit,$offset);
        $query=$this->db->get();
        return $query->result();
    }
    function GET_WARNINGS_COUNT($status){
        $this->db->select('*');
        $this->db->from('tbl_hr_warnings as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.employee_id=tb2.id','left')
        ->where('tb1.status',$status);
        $query=$this->db->get();
        return $query->num_rows();
        
    }
    function GET_WARNING($id){
        $this->db->select('tb1.*,tb2.id as empl_id');
        $this->db->select("
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-',COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS editor
        ",false);
        $this->db->from('tbl_hr_warnings as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.edit_user=tb2.id','left');
        $this->db->where('tb1.id',$id);
        
        $query=$this->db->get();
        return $query->row();
    }
    function GET_ANNOUNCEMENTS($limit,$offset,$status){
        $this->db->select('id,title,description,attachment,status')
        ->where('status',$status)
        ->limit($limit,$offset);
        $query=$this->db->get('tbl_hr_announcements');
        return $query->result();
    }
    function GET_ANNOUNCEMENTS_COUNT($status){
        $this->db->select('id,title,description,attachment')
        ->where('status',$status);
        $query=$this->db->get('tbl_hr_announcements');
        return $query->num_rows();
    }
    function GET_ANNOUNCEMENT($id){
        $this->db->select('tb1.*,tb2.col_suffix,tb2.col_frst_name,tb2.col_last_name,tb2.col_midl_name,tb2.col_empl_cmid');
        $this->db->from('tbl_hr_announcements as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.edit_user=tb2.id','left');
        $this->db->where('tb1.id',$id);
        
        $query=$this->db->get();
        return $query->row();
    }
    function UPDATE_ANNOUNCEMENT($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbl_hr_announcements',$data);
    }
    function BULK_ACTIVATE($table,$status,$ids){
        $this->db->set('status',$status);
        $this->db->where_in('id',$ids);
        // $this->db->update($table);
        if ($this->db->update($table)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function GET_POLICIES($limit,$offset,$status){
        $this->db->select('id,title,description,attachment,status')
        ->where('status',$status)
        ->limit($limit,$offset);
        $query=$this->db->get('tbl_hr_policies');
        return $query->result();
    }
    function GET_POLICIES_COUNT($status){
        $this->db->select('id,title,description,attachment')
        ->where('status',$status);
        $query=$this->db->get('tbl_hr_policies');
        return $query->num_rows();
    }
    function GET_POLICY($id){
        $this->db->select("tb1.*,
        CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), '-', COALESCE(tb2.col_last_name, ''),
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS last_editor
        ",false);
        $this->db->from('tbl_hr_policies as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.edit_user=tb2.id','left');
        $this->db->where('tb1.id',$id);
        
        $query=$this->db->get();
        return $query->row();
    }
    function UPDATE_POLICY($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbl_hr_policies',$data);
    }
    function UPDATE_DATA($table,$data,$id){
        $this->db->where('id',$id);
        return $this->db->update($table,$data);
    }
    function GET_DATA_ROW($table,$row,$value,$columns="*"){
        $this->db->select($columns);
        $this->db->where($row,$value);
        $query=$this->db->get($table);
        return $query->row();
    }
    function UPDATE_WARNING($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbl_hr_warnings',$data);
    }
    
}


