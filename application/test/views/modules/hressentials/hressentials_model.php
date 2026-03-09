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
    
    function USER_EVENT_CALENDAR()
    {
        $sql = "SELECT * FROM test_calendar_event";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_TYPE($id){
        $sql = "SELECT name FROM tbl_std_employeetypes WHERE id =?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_All_EMPLOYEE_TYPES(){
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
    function GET_LEAVERS($date_num){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type!=0 AND DATE_FORMAT(termination_date, '%c')=?";
        $query = $this->db->query($sql, array($date_num));
        $query->next_result();
        return $query->num_rows();
    }
    function GET_DEPARTMENTS(){
        $sql = "SELECT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
        
    }
    function GET_EMPLOYEE_BY_DEPARTMENT(){
        
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
    function GET_JOINERS($hire_date){
        $sql="SELECT id FROM tbl_employee_infos WHERE termination_type=0 AND DATE_FORMAT(col_hire_date, '%c')=?";
        $query = $this->db->query($sql, array($hire_date));
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

    function GET_EMPL_TYPE_COUNT(){
        $sql = "SELECT col_empl_type, COUNT(col_empl_type) AS empl_count FROM tbl_employee_infos WHERE termination_type != 0 GROUP BY col_empl_type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMPL_TYPE(){
        $sql = "SELECT id, name FROM tbl_std_employeetypes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
}


