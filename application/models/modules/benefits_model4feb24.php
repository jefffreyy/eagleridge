<?php
class benefits_model extends CI_Model
{
    function get_settings_table($table, $filter, $selectColumns) {
        $query = $this->db
        ->where('is_deleted', 0)
        ->order_by('id', 'DESC');
        foreach ($selectColumns as $column) {
            // if ($column['useRaw']) {
            if (array_key_exists('useRaw', $column)) {
                $query->select($column['selectStatement'], false);
            } else {
                $query->select($column['selectStatement']);
            }
        }
        foreach ($filter as $conditions) {
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }
        $query = $query->get($table);
        return $query->result();
    }
    function get_reimbursement_count($row, $offset, $id){
        $sql = "SELECT t1.id,t1.description,t1.amount,t1.remarks,t1.attachment,
        CONCAT_WS('',COALESCE(t2.col_empl_cmid, ''), 
        CASE WHEN t2.col_last_name  IS NOT NULL AND t2.col_last_name != '' THEN CONCAT('-', t2.col_last_name ) ELSE '' END,
        CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
        CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
        CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee,
        t3.name as type
        
        FROM tbl_benefits_reimbursement as t1
        LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
        LEFT JOIN tbl_std_reimbursementtypes as t3 ON t3.id = t1.type
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND t1.is_deleted=0 ";
   
        if ($id) {
            $sql .= "AND t2.id = ? ORDER BY t1.id DESC LIMIT $row OFFSET $offset";
            $array = [ $id];
        } else {
            $sql .= "ORDER BY t1.id DESC ";
            $sql .= "LIMIT $row OFFSET $offset";
            $array = [];
        }

        $query = $this->db->query($sql, $array);
        return  $query->num_rows();
    }
    function get_reimbursement($row, $offset, $id){
        $sql = "SELECT t1.id,t1.description,t1.amount,t1.remarks,t1.attachment,
        CONCAT_WS('',COALESCE(t2.col_empl_cmid, ''), 
        CASE WHEN t2.col_last_name  IS NOT NULL AND t2.col_last_name != '' THEN CONCAT('-', t2.col_last_name ) ELSE '' END,
        CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
        CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
        CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee,
        t3.name as type
        
        FROM tbl_benefits_reimbursement as t1
        LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
        LEFT JOIN tbl_std_reimbursementtypes as t3 ON t3.id = t1.type
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND t1.is_deleted=0 ";
   
        if ($id) {
            $sql .= "AND t2.id = ? ORDER BY t1.id DESC LIMIT $row OFFSET $offset";
            $array = [ $id];
        } else {
            $sql .= "ORDER BY t1.id DESC ";
            $sql .= "LIMIT $row OFFSET $offset";
            $array = [];
        }

        $query = $this->db->query($sql, $array);
        $query->next_result();
        return $query->result();
    }

    function get_loan_payments_api($loanId){
        $this->db->select('tb1.payslip_id,tb1.deducted, tb3.name as period');
        $this->db->from('tbl_payroll_payslip_loan as tb1');
        $this->db->join('tbl_payroll_payslips as tb2', 'tb1.payslip_id=tb2.id', 'left');
        $this->db->join('tbl_payroll_period as tb3', 'tb2.PAYSLIP_PERIOD=tb3.id', 'left');
        $this->db->where('tb1.loan_id', $loanId);
        $this->db->order_by('tb1.id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function get_system_setup_by_setting($setting, $value) {
        $query_select = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        if (!$result) {
            $query_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, ?)";
            $this->db->query($query_insert, array($setting,$value));
            $query_select_new = "SELECT * FROM tbl_system_setup WHERE setting=?";
            $result = $this->db->query($query_select_new, array($setting))->row_array();
        }
        return $result ? $result['value'] : null;
    }
    function update_system_setup($settings){
        try {
            foreach ($settings as $key => $value) {
                $this->db->set('value',$value);
                $this->db->where('setting', $key); 
                $this->db->update('tbl_system_setup');
            }
            return true; 
        } catch (Exception $e) {
            return false;
        }
    }

    

    function update_setting_tables($table, $data, $edit_user) {
        $date = date('Y-m-d H:i:s');
        $id = !empty($data['id']) ? $data['id'] : 0;
        $columns = array();
        $values = array();
        $params = array();
        if ($id == 0) {
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $columns[] = $key;
                    $values[] = $value;
                    $params[] = '?';
                }
            }
            $columns = implode(', ', $columns);
            $params = implode(', ', $params);
            $arrayValues = array_merge([$date, $date, $edit_user], $values);
            $sql = "INSERT INTO $table (create_date, edit_date, edit_user, $columns) VALUES (?, ?, ?, $params)";
            $query = $this->db->query($sql, $arrayValues);
            if ($query) {
                return "inserted";
            } else {
                return "failedInsert";
            }
        } else {
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $columns[] = $key . '= ?';
                    $values[] = $value;
                    $params[] = '?';
                }
            }
            $columns = implode(', ', $columns);
            $params = implode(', ', $params);
            $sql = "UPDATE $table SET edit_date=?, edit_user=?, $columns WHERE id=?";
            $values[] = $id;
            $query = $this->db->query($sql, array_merge([$date, $edit_user], $values));
            if ($query) {
                return "updated";
            } else {
                return "failedUpdate";
            }
        }
    }

    function GET_LOANS($loan_id)
    {
        $sql = "SELECT COUNT(*) AS row_count FROM tbl_payroll_payslip_loan WHERE loan_id = $loan_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["row_count"];
    }

    function delete_loan($id) {
        $sql = "UPDATE tbl_benefits_loan SET is_deleted = 1 WHERE id = ?";
        $this->db->query($sql, array($id));

        $rows_affected = $this->db->affected_rows();
        return ($rows_affected > 0);
    }
    

    function GET_DYNAMIC_TYPE_LIST()
    {
        $sql = "SELECT * FROM tbl_benefits_dynamic_type WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_FIXED_TYPE_LIST($taxable)
    {
        $sql = "SELECT * FROM tbl_benefits_fixed_type WHERE taxable = ?";
        $query = $this->db->query($sql, array($taxable));
        $query->next_result();
        return $query->result();
    }
    function GET_OTHER_DEDUCTIONS_TYPE_LIST($income_type)
    {
        $sql = "SELECT * FROM tbl_other_deductions_type WHERE income_type=?";
        $query = $this->db->query($sql, array($income_type));
        $query->next_result();
        return $query->result();
    }
    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function GET_ADJUSTMENT_TYPE_LIST()
    {
        $sql = "SELECT * FROM tbl_benefits_adjustment_type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_DYNAMIC_TYPE()
    {
        $sql = "SELECT id,name,incentive_type,taxable FROM tbl_benefits_dynamic_type WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_FIXED_TYPE()
    {
        $sql = "SELECT id,name,value,taxable,incentive_type,income_type FROM tbl_benefits_fixed_type WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_BENEFITS_DYNAMIC_STD()
    {
        $sql = "SELECT id,name,value,type FROM tbl_benefits_dynamic_std WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    

    function GET_SPECIFIC_BENEFITS_DYNAMIC_STD($type)
    {
        $sql = "SELECT id,name,value,type FROM tbl_benefits_dynamic_std WHERE type=? AND is_deleted=0";
        $query = $this->db->query($sql, array($type));
        $query->next_result();
        return $query->result();
    }

    function CONVERT_ID_TO_NAME_BENEFITS_TYPE($id){
        $sql = "SELECT name FROM tbl_benefits_fixed_type WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        $result = $query->result_array();
        if (empty($result)) {
            return "";
        } else {
            return $result[0]["name"];
        }
        
    }

    function GET_OTHER_DEDUCTIONS_TYPE()
    {
        $sql = "SELECT id,name,value,taxable,incentive_type,income_type FROM tbl_other_deductions_type WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_ADJUSTMENT_TYPE()
    {
        $sql = "SELECT id,name FROM tbl_benefits_adjustment_type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function UPDATE_DYNAMIC_TYPE($data, $editUser)
    {
        $id             = $data['id'];
        $name           = $data['name'];
        $taxable        = (isset($data['taxable']) && !empty($data['taxable']) && $data['taxable'] === 'Non-Taxable') ? 'Non-Taxable' : 'Taxable';
        $incentive_type = (isset($data['incentive_type']) && !empty($data['incentive_type']) && $data['incentive_type'] === 'Attendance') ? 'Attendance' : 'Manual';
        $datetime       = date('Y-m-d H:i:s');
        if ($id != null) {
            $sql = " UPDATE tbl_benefits_dynamic_type SET edit_date=?,edit_user=?,name=?,taxable=?,incentive_type=?  WHERE id=? ";
            $this->db->query($sql, array($datetime, $editUser, $name, $taxable, $incentive_type, $id));
        } else {
            $sql = "INSERT INTO tbl_benefits_dynamic_type (create_date, edit_date,edit_user,is_deleted, name,taxable,incentive_type) VALUES(?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $name, $taxable, $incentive_type));
        }
    }

    function UPDATE_FIXED_TYPE($data, $editUser)
    {
        $id                 = $data[0];
        $income_type        = $data[1];
        $name               = $data[2];
        $taxable            = $data[3];
        $incentive_type     = $data[4];
        $value              = $data[5];
        
        $datetime           = date('Y-m-d H:i:s');
        if ($id != null) {
            $sql = " UPDATE tbl_benefits_fixed_type SET edit_date=?, edit_user=?, name=?, value=?,taxable=?, incentive_type=?, income_type=? WHERE id=? ";
            $this->db->query($sql, array($datetime, $editUser, $name, $value, $taxable, $incentive_type, $income_type, $id));
        } else {
            $sql = "INSERT INTO tbl_benefits_fixed_type (create_date, edit_date,edit_user,is_deleted, name, value, taxable, incentive_type, income_type) VALUES(?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $name, $value, $taxable, $incentive_type, $income_type));
        }
    }

    function INSERT_CATEGORY($data, $editUser){
        $id                 = $data[0];
        $name               = $data[1];
        $type               = $data[2];
        $value              = $data[3];
        
        $datetime           = date('Y-m-d H:i:s');
        if ($id != null) {
            $sql = " UPDATE tbl_benefits_dynamic_std SET edit_date=?, edit_user=?, name=?, value=?,type=? WHERE id=? ";
            $this->db->query($sql, array($datetime, $editUser, $name, $value, $type, $id));
        } else {
            $sql = "INSERT INTO tbl_benefits_dynamic_std (create_date, edit_date,edit_user,is_deleted, name, value, type) VALUES(?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $name, $value, $type));
        }
    }

    function UPDATE_OTHER_DEDUCTIONS_TYPE($data, $editUser)
    {
        $id                 = $data[0];
        $name               = $data[1];
        $incentive_type     = $data[2];
        $value              = $data[3];
        $taxable            = $data[4];
        $income_type        = $data[5];
        $datetime           = date('Y-m-d H:i:s');
        if ($id != null) {
            $sql = " UPDATE tbl_other_deductions_type SET edit_date=?, edit_user=?, name=?, value=?,taxable=?, incentive_type=?, income_type=? WHERE id=? ";
            $this->db->query($sql, array($datetime, $editUser, $name, $value, $taxable, $incentive_type, $income_type, $id));
        } else {
            $sql = "INSERT INTO tbl_other_deductions_type (create_date, edit_date,edit_user,is_deleted, name, value, taxable, incentive_type, income_type) VALUES(?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $name, $value, $taxable, $incentive_type, $income_type));
        }
    }

    function UPDATE_ADJUSTMENT_TYPE($data)
    {
        $id             = $data[0];
        $name           = $data[1];
        $datetime       = date('Y-m-d H:i:s');
        if ($id != null) {
            $sql = " UPDATE tbl_benefits_adjustment_type SET edit_date=?, name=? WHERE id=? ";
            $this->db->query($sql, array($datetime, $name, $id));
        } else {
            $sql = "INSERT INTO tbl_benefits_adjustment_type (create_date, edit_date, name) VALUES(?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $name));
        }
    }
    function GET_CUTOFF_LIST()
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE status = 'Active' ORDER BY date_to DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function CONVERT_ID_TO_NAME_PERIOD($id){
        $sql = "SELECT name FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        $result = $query->result_array();
        if (empty($result)) {
            return "";
        } else {
            return $result[0]["name"];
        }
        
    }
    function GET_BENEFITS_DYNAMIC_COUNT($period, $type)
    {
        $sql = "SELECT id,user_id, category, count FROM tbl_benefits_dynamic_count WHERE is_deleted=0 AND period=? AND type = ?";
        $query = $this->db->query($sql, array($period, $type));
        $query->next_result();
        return $query->result();
    }
    // function GET_BENEFITS_FIXED_ASSIGN($period, $type){
    //     $sql = "SELECT id,user_id,value FROM tbl_benefits_fixed_assign WHERE is_deleted=0 AND period=? AND type = ?";
    //     $query = $this->db->query($sql, array($period, $type));
    //     $query->next_result(); 
    //     return $query->result();
    // }

    
    function GET_BENEFITS_FIXED_ASSIGN($period, $type)
    {
        $params = [];
        $sql = 'SELECT id,user_id,category,start_date,end_date FROM tbl_benefits_fixed_assign WHERE is_deleted=0';
        if (isset($period) && !empty($period) && $period !== '') {
            $sql .= ' AND period = ?';
            $params[] = $period;
        }
        if (isset($type) && !empty($type) && $type !== '') {
            $sql .= ' AND type = ?';
            $params[] = $type;
        }

        $sql .= ' ORDER BY id ';
        $query = $this->db->query($sql, $params);
        $query = $this->db->query($sql, array($period, $type));
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_BENEFITS_DYNAMIC_TYPE(){
        $sql = "SELECT name FROM tbl_benefits_dynamic_std WHERE is_deleted=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result(); 
        return $query->result();
    }
    function GET_OTHER_DEDUCTIONS_ASSIGN($period, $type)
    {
        $params = [];
        $sql = 'SELECT id,user_id,value FROM tbl_other_deductions_assign WHERE is_deleted=0';
        if (isset($period) && !empty($period) && $period !== '') {
            $sql .= ' AND period = ?';
            $params[] = $period;
        }
        if (isset($type) && !empty($type) && $type !== '') {
            $sql .= ' AND type = ?';
            $params[] = $type;
        }
        $query = $this->db->query($sql, $params);
        $query = $this->db->query($sql, array($period, $type));
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_ADJUSTMENT_ASSIGN($period, $type)
    {
        $sql = "SELECT id,user_id,value FROM tbl_benefits_adjustment_assign WHERE is_deleted=0 AND period=? AND type = ?";
        $query = $this->db->query($sql, array($period, $type));
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEELIST()
    {
        $sql = "SELECT id, col_empl_cmid, CONCAT(col_last_name,', ',col_frst_name) as fullname FROM tbl_employee_infos WHERE termination_date IS NULL AND disabled=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_LIST()
    {
        $sql   = "SELECT * FROM tbl_employee_infos WHERE disabled = '0' ORDER BY col_empl_cmid +0 ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEELIST_ASSIGN()
    {
        $sql = "SELECT tb1.id, tb1.col_empl_cmid, CONCAT(tb1.col_last_name,', ',tb1.col_frst_name) as fullname, 
        tb2.category as category 
        FROM tbl_employee_infos AS tb1 
        INNER JOIN tbl_benefits_dynamic_assign AS tb2 ON tb2.user = tb1.id 
        WHERE tb2.category > 0 ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_DYNAMIC_ASSIGN($type)
    {
        if (empty($type) || $type == NULL) {
            return [];
        }
        $sql = "SELECT user,category FROM tbl_benefits_dynamic_assign WHERE type = $type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_DYNAMIC_STD($type)
    {
        if (empty($type) || $type == NULL) {
            return [];
        }
        $sql = "SELECT id,name,value FROM tbl_benefits_dynamic_std WHERE is_deleted=0 AND type = $type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function is_duplicate_data($user_id)
    {
        $sql = "SELECT id FROM tbl_benefits_dynamic_assign WHERE user=?";
        $query = $this->db->query($sql, array($user_id));
        return $query->num_rows();
    }
    function UPDATE_DATA($data_row, $type)
    {
        $datetime               = date('Y-m-d H:i:s');
        $user_id                = $data_row[0];
        $category               = $data_row[3];
        $is_duplicate = $this->is_duplicate_data($user_id);
        if ($is_duplicate > 0) {
            $sql = " UPDATE tbl_benefits_dynamic_assign SET edit_date=?, category=?, type=? WHERE user=? ";
            $this->db->query($sql, array($datetime, $category, $type, $user_id));
        } else {
            $sql = "INSERT INTO tbl_benefits_dynamic_assign (create_date, edit_date, user, category, type) VALUES(?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $user_id, $category, $type));
        }
    }
    function GET_EMPLOYEE_CMID($cmid)
    {
        $sql = "SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=? AND termination_date IS NULL AND disabled=0";
        $query = $this->db->query($sql, array($cmid));
        $result = $query->row();
        return $result->id;
    }
    function DELETE_COUNT_DATA($data_row, $period, $type, $editUser)
    {
        $datetime                   = date('Y-m-d H:i:s');
        $user_id                    = $data_row[0];
        // if($user_id == null){
        //     $user_id = $this->GET_EMPLOYEE_CMID($data_row[1]);
        // }
        // $category                   = $data_row[2];
        // $count                      = $data_row[3];
        $is_duplicate               = $this->is_duplicate_cound_data($user_id, $period);
        if ($is_duplicate > 0) {
            $sql = " UPDATE tbl_benefits_dynamic_count SET edit_date=?,edit_user=?, is_deleted=1 WHERE user_id=? ";
            $this->db->query($sql, array($datetime, $editUser, $user_id));
        }
    }
    function UPDATE_COUNT_DATA($data_row, $period, $type, $editUser)
    {
        $datetime                   = date('Y-m-d H:i:s');
        $user_id                    = $data_row[0];
        if ($user_id == null) {
            $user_id = $this->GET_EMPLOYEE_CMID($data_row[1]);
        }
        $category                   = $data_row[2];
        // $count                      = ($data_row[3]);
        $count                      = isset($data_row[3]) && is_numeric($data_row[3]) ? $data_row[3] : null;
        $is_duplicate               = $this->is_duplicate_cound_data($user_id, $period);
        if ($is_duplicate > 0) {
            $sql = " UPDATE tbl_benefits_dynamic_count SET edit_date=?,edit_user=?, count=?, period=?, category=?, type=? WHERE user_id=? ";
            $this->db->query($sql, array($datetime, $editUser, $count, $period, $category, $type, $user_id));
        } else {
            $sql = "INSERT INTO tbl_benefits_dynamic_count (create_date, edit_date,is_deleted, edit_user, period, user_id, count, category, type) VALUES(?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, 0, $editUser, $period, $user_id, $count, $category, $type));
        }
    }
    function is_duplicate_cound_data($user_id, $period)
    {
        $sql = "SELECT id FROM tbl_benefits_dynamic_count WHERE is_deleted=0 AND user_id=? AND period=?";
        $query = $this->db->query($sql, array($user_id, $period));
        return $query->num_rows();
    }
    function UPDATE_DYNAMIC_STD($data, $type, $editUser)
    {
        // $id             = $data[0];
        // $name           = $data[1];
        // $value          = $data[2];
        $id             = $data['id'];
        $name           = $data['name'];
        $value          = $data['value'];
        $datetime               = date('Y-m-d H:i:s');
        if ($id != null) {
            $sql = " UPDATE tbl_benefits_dynamic_std SET edit_date=?,edit_user=?, name=?, value=?, type = ? WHERE id=? ";
            $this->db->query($sql, array($datetime, $editUser, $name, $value, $type, $id));
        } else {
            $sql = "INSERT INTO tbl_benefits_dynamic_std (create_date, edit_date,edit_user,is_deleted, name, value, type) VALUES(?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $name, $value, $type));
        }
    }
    function is_fixed_duplicate_data($user_id, $period, $type)
    {
        $sql = "SELECT id FROM tbl_benefits_fixed_assign WHERE user_id=? AND period=? AND type=?";
        $query = $this->db->query($sql, array($user_id, $period, $type));
        return $query->num_rows();
    }

    function UPDATE_FIXED_DATA($data, $period, $type, $editUser)
    {
        $user_id                        = $data[0];
        $category                       = $this->convert_categoryName_to_id($data[3]);
        
        $start_date                     = ($data[4]) ? DateTime::createFromFormat('d/m/Y', $data[4])->format('Y-m-d') : "";
        $end_date                       = ($data[5]) ? DateTime::createFromFormat('d/m/Y', $data[5])->format('Y-m-d') : "";
        $datetime                       = date('Y-m-d H:i:s');
        
        if ($user_id != "") {
            $result = $this->is_fixed_duplicate_data($user_id, $period, $type);
            if ($result > 0) {
                $sql = " UPDATE tbl_benefits_fixed_assign SET edit_date=?, edit_user=?, category=?, start_date=?, end_date=? WHERE user_id=? AND period=?  AND type=?";
                $this->db->query($sql, array($datetime, $editUser, $category, $start_date, $end_date, $user_id, $period, $type));
            } else {
                $sql = "INSERT INTO tbl_benefits_fixed_assign (create_date, edit_date, edit_user, user_id, period, type, category, start_date, end_date, is_deleted) VALUES(?,?,?,?,?,?,?,?,?,?)";
                $this->db->query($sql, array($datetime, $datetime, $editUser, $user_id, $period, $type, $category, $start_date, $end_date, 0));
            }
        }
    }

    function convert_categoryName_to_id($name){
        $sql = "SELECT id FROM tbl_benefits_dynamic_std WHERE name=?";
        $query = $this->db->query($sql, array($name));
        $result = $query->result_array();

        if(!empty($result)){
            return $result[0]["id"];
        }else{
            return "";
        }
    }

    function convert_category_id_to_name($id){
        $sql = "SELECT name FROM tbl_benefits_dynamic_std WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->result_array();

        if(!empty($result)){
            return $result[0]["name"];
        }else{
            return "";
        }
    }

    function is_other_deduction_duplicate_data($user_id, $period, $type)
    {
        $sql = "SELECT id FROM tbl_other_deductions_assign WHERE user_id=? AND period=? AND type=?";
        $query = $this->db->query($sql, array($user_id, $period, $type));
        return $query->num_rows();
    }

    function UPDATE_OTHER_DEDUCTION_DATA($data, $period, $type, $editUser)
    {
        $user_id                = $data[1];
        $value                  = $data[2];
        $datetime               = date('Y-m-d H:i:s');
        if ($user_id != "") {
            $result = $this->is_other_deduction_duplicate_data($user_id, $period, $type);
            if ($result > 0) {
                $sql = " UPDATE tbl_other_deductions_assign SET edit_date=?, edit_user=?, value=? WHERE user_id=? AND period=?  AND type=?";
                $this->db->query($sql, array($datetime, $editUser, $value, $user_id, $period, $type));
            } else {
                $sql = "INSERT INTO tbl_other_deductions_assign (create_date, edit_date,edit_user, user_id, period, type, value, is_deleted) VALUES(?,?,?,?,?,?,?,?)";
                $this->db->query($sql, array($datetime, $datetime, $editUser, $user_id, $period, $type, $value, 0));
            }
        }
    }

    function DELETE_FIXED_DATA($data)
    {
        $id                 = $data['id'];
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_benefits_fixed_assign SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }
    function delete_fixed_type($data, $editUser)
    {
        $id                 = $data;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_benefits_fixed_type SET edit_date=?,edit_user=?, is_deleted=? WHERE id=?";
        $result = $this->db->query($sql, array($datetime, $editUser, $delete, $id));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function delete_dynamic_std($data, $editUser)
    {
        $id                 = $data;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_benefits_dynamic_std SET edit_date=?,edit_user=?, is_deleted=? WHERE id=?";
        $result = $this->db->query($sql, array($datetime, $editUser, $delete, $id));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }



    function delete_dynamic_type($data, $editUser)
    {
        $id                 = $data;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_benefits_dynamic_type SET edit_date=?,edit_user=?, is_deleted=? WHERE id=?";
        $result = $this->db->query($sql, array($datetime, $editUser, $delete, $id));
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function is_adjustment_duplicate_data($user_id, $period)
    {
        $sql = "SELECT id FROM tbl_benefits_adjustment_assign WHERE user_id=? AND period=?";
        $query = $this->db->query($sql, array($user_id, $period));
        return $query->num_rows();
    }
    function UPDATE_ADJUSTMENT_DATA($data, $period, $type)
    {
        $user_id                = $data[1];
        $value                  = $data[2];
        $datetime               = date('Y-m-d H:i:s');
        if ($user_id != "") {
            $result = $this->is_adjustment_duplicate_data($user_id, $period);
            if ($result > 0) {
                $sql = " UPDATE tbl_benefits_adjustment_assign SET edit_date=?, value=?, type=? WHERE user_id=? AND period=?";
                $this->db->query($sql, array($datetime, $value, $type, $user_id, $period));
            } else {
                $sql = "INSERT INTO tbl_benefits_adjustment_assign (create_date, edit_date, user_id, period, type, value) VALUES(?,?,?,?,?,?)";
                $this->db->query($sql, array($datetime, $datetime, $user_id, $period, $type, $value));
            }
        }
    }
    function DELETE_ADJUSTMENT_DATA($data)
    {
        $id                 = $data['id'];
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_benefits_adjustment_assign SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }
    function GET_LOAN_TYPE_DATA()
    {
        $sql = "SELECT * FROM tbl_std_loantypes ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SPEC_LOAN($id)
    {
        $query = $this->db
            ->select('*')
            ->where('id', $id)
            ->get('tbl_benefits_loan');
        return $query->row();
    }
    function GET_PAYROLL_LOAN_DATA($tab, $row, $offset)
    {
        $sql = "SELECT *,tbl_benefits_loan.id as id FROM tbl_benefits_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        WHERE termination_date IS NULL AND disabled=0 AND tbl_benefits_loan.status=? LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_PAYROLL_LOAN_DATA_NEW($tab, $row, $offset, $id)
    {
        $sql = "SELECT *,tbl_benefits_loan.id as id FROM tbl_benefits_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND tbl_benefits_loan.is_deleted=0 AND tbl_benefits_loan.status=?";
   
        if ($id) {
            $sql .= "AND tbl_employee_infos.id = ? ORDER BY tbl_benefits_loan.id DESC LIMIT $row OFFSET $offset";
            $array = [$tab, $id];
        } else {
            $sql .= "ORDER BY tbl_benefits_loan.id DESC ";
            $sql .= "LIMIT $row OFFSET $offset";
            $array = [$tab];
        }

        $query = $this->db->query($sql, $array);
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_PAYROLL_LOAN_DATA_NEW($tab, $id)
    {
        $sql = "SELECT *,tbl_benefits_loan.id as id FROM tbl_benefits_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND tbl_benefits_loan.is_deleted=0 AND tbl_benefits_loan.status=? ";
        if ($id) {
            $sql .= "AND tbl_employee_infos.id = ?";
            $array = [$tab, $id];
        } else {
            //   $sql .= "LIMIT $row OFFSET $offset";
            $array = [$tab];
        }
        $query = $this->db->query($sql, $array);
        $query->next_result();
        return $query->result();
        // $sql = "SELECT *,tbl_benefits_loan.id as id FROM tbl_benefits_loan 
        // LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        // WHERE termination_date = '0000-00-00' AND disabled=0 AND tbl_benefits_loan.status=?";
        // $query = $this->db->query($sql, array($tab));
        // $query->next_result();
        // return $query->result();
    }
    function GET_COUNT_PAYROLL_LOAN_DATA($tab)
    {
        $sql = "SELECT *,tbl_benefits_loan.id as id FROM tbl_benefits_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        WHERE termination_date = '0000-00-00' AND disabled=0 AND tbl_benefits_loan.status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_LOAN_DATA($tab, $search)
    {
        $sql = "SELECT tbl_benefits_loan.*,col_empl_cmid,col_last_name,col_frst_name,col_midl_name FROM tbl_benefits_loan
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        WHERE termination_date IS NULL AND disabled=0 AND tbl_benefits_loan.is_deleted=0 AND tbl_benefits_loan.status=?
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR tbl_benefits_loan.id LIKE '%$search%'
        OR tbl_benefits_loan.loan_name LIKE '%$search%'
        OR tbl_benefits_loan.loan_date LIKE '%$search%'
        OR tbl_benefits_loan.loan_amount LIKE '%$search%'
        OR tbl_benefits_loan.loan_terms LIKE '%$search%'
        OR tbl_benefits_loan.status LIKE '%$search%') 
        ORDER BY tbl_benefits_loan.id DESC";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_LOAN_ID($id)
    {
        $sql = "SELECT id FROM tbl_payroll_payslips WHERE LOAN_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }
    function GET_PAYROLL_LOAN_DATA_COUNT($tab)
    {
        $sql = "SELECT * FROM tbl_benefits_loan
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        WHERE termination_date IS NULL AND disabled=0 AND status=? ";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function INSERT_LOANS_DATA($data)
    {
        $loans = $this->GET_LOAN_TYPE_DATA();
        $empl_id                = $data[0];
        
        // $loan_date              = date('Y-m-d', strtotime($data[3]));
        $dateTime = DateTime::createFromFormat('d/m/Y', $data[3]);
        $loan_date = $dateTime->format('Y-m-d');

        $loan_type              = $this->convert_name2id($loans, $data[4]);
        $loan_amount            = $data[5];
        $loan_terms             = $data[6];
        $initial_paid           = $data[8];
        $payroll_period         = $this->GET_SPECIFIC_PAYROLL_PERIOD($data[11]);
        $status                 = "Active";
        $datetime               = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_benefits_loan (create_date, edit_date, loan_type, loan_date, loan_amount, loan_terms, empl_id, status, initial_paid, start_period) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $this->db->query($sql, array($datetime, $datetime, $loan_type, $loan_date, $loan_amount, $loan_terms, $empl_id, $status, $initial_paid, $payroll_period));
    }

    function GET_SPECIFIC_PAYROLL_PERIOD($period){
        $sql = "SELECT id FROM tbl_payroll_period WHERE name = ?";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        $result = $query->result_array();
        if (empty($result)) {
            return 0;
        } else {
            return $result[0]["id"];
        }
    }
    function UPDATE_BENEFITS_LOAN($data)
    {
        $loans = $this->GET_LOAN_TYPE_DATA();
        $id                     = $data[0];
        // $loan_date              = date('Y-m-d', strtotime($data[3]));
        $dateTime = DateTime::createFromFormat('d/m/Y', $data[3]);
        $loan_date = $dateTime->format('Y-m-d');

        $loan_type              = $this->convert_name2id($loans, $data[4]);
        $loan_amount            = $data[5];
        $loan_terms             = $data[6];
        $initial_paid           = $data[7];
        $payroll_period_id      = $this->GET_SPECIFIC_PAYROLL_PERIOD($data[8]);
        $datetime               = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_benefits_loan SET edit_date=?, loan_type=?, loan_date=?, loan_amount=?, loan_terms=?, initial_paid=?, start_period=? WHERE id=?";
        $this->db->query($sql, array($datetime, $loan_type, $loan_date, $loan_amount, $loan_terms, $initial_paid, $payroll_period_id, $id));
    }


    function convert_name2id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $nameLower = strtolower($e->name);
            if ($nameLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
    }
    function GET_ALL_BENEFITS_LOAN()
    {
        $sql = "SELECT tbl_benefits_loan.id, loan_name, 
        CONCAT_WS('',COALESCE(col_last_name, ''), 
                CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
                CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
                CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
            ) AS fullname,
        loan_type, loan_date, loan_amount, loan_terms, status, initial_paid, start_period FROM tbl_benefits_loan LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
        WHERE termination_date IS NULL AND disabled=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function get_reimbursement_types()
    {
        $this->db->select("id, name", false);
        $this->db->where("disabled = 0 AND status='Active' ");
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('tbl_std_reimbursementtypes');
        return $query->result();
    }
} // CI_Model Ends here
