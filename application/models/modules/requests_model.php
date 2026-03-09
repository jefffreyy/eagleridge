<?php
class requests_model extends CI_Model
{

    function GET_EMPL_CHANGESHIFT($userId, $status, $limit, $offset)
    {

        $this->db->select('tb_change.create_date,tb_change.id,date_shift,current_shift,request_shift, date_shift_to, current_shift_to, request_shift_to, reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        // $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_changeshift as tb_change');
        return $query->result();
    }

    function GET_SPECIFIC_ATTENDANCE_SHIFT($id)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    function CHANGESHIFT_WITHDRAW($id)
    {
        // First, get the required data
        $sql_select = "SELECT empl_id, date_shift, current_shift 
                    FROM tbl_attendance_changeshift 
                    WHERE id = $id";
        $query = $this->db->query($sql_select);
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $empl_id = $row->empl_id;
            $date_shift = $row->date_shift;
            
            // Update shift assignment to original shift
            $sql_update_shift = "UPDATE tbl_attendance_shiftassign 
                                SET shift_id = orig_shift_id 
                                WHERE empl_id = '$empl_id' 
                                AND date = '$date_shift'";
            
            $this->db->query($sql_update_shift);
            
            // Update the changeshift status to withdrawn
            $sql_update_status = "UPDATE tbl_attendance_changeshift 
                                SET status = 'Withdrawn' 
                                WHERE id = $id";
            
            $this->db->query($sql_update_status);
            
            return true;
        } else {
            // Record not found
            return false;
        }
    }

    function CHANGEOFF_WITHDRAW($id)
    {
        // First, get the required data using prepared statement
        $sql_select = "SELECT empl_id, date_shift, current_shift, date_shift_to, current_shift_to 
                    FROM tbl_attendance_changeoff 
                    WHERE id = ?";
        $query = $this->db->query($sql_select, array($id));
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $empl_id = $row->empl_id;
            $date_shift = $row->date_shift;
            $date_shift_to = $row->date_shift_to;
            
            // Update shift assignments for first date
            $sql_update_shift1 = "UPDATE tbl_attendance_shiftassign 
                                SET shift_id = orig_shift_id 
                                WHERE empl_id = ? 
                                AND date = ?";
            $this->db->query($sql_update_shift1, array($empl_id, $date_shift));
            
            // Check if date_shift_to exists and is different from date_shift
            if (!empty($date_shift_to) && $date_shift_to != $date_shift) {
                $sql_update_shift2 = "UPDATE tbl_attendance_shiftassign 
                                    SET shift_id = orig_shift_id 
                                    WHERE empl_id = ? 
                                    AND date = ?";
                $this->db->query($sql_update_shift2, array($empl_id, $date_shift_to));
            }
            
            // Update the changeoff status to withdrawn
            $sql_update_status = "UPDATE tbl_attendance_changeoff 
                                SET status = 'Withdrawn' 
                                WHERE id = ?";
            $this->db->query($sql_update_status, array($id));
            
            return true;
        } else {
            // Record not found
            return false;
        }
    }

    function UNDERTIME_WITHDRAW($id)
    {
        $sql = "UPDATE tbl_attendance_undertime SET status ='Withdrawn' WHERE id=$id";
        $this->db->query($sql);
    }

    function ADD_OVERTIME_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        $this->db->insert('tbl_overtimes', $data);
        return $this->db->insert_id();
    }

    function GET_EMPL_CHANGESHIFT_COUNT($userId, $status)
    {

        $this->db->select('tb_change.id,date_shift,current_shift,request_shift,reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        // $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }

        $query = $this->db->get('tbl_attendance_changeshift as tb_change');
        return $query->num_rows();
    }

    function GET_SYSTEM_SETTINGS($setting)
    {
        $is_exist = $this->db->select("value")->where('setting', $setting)->get("tbl_system_setup")->row();
        if ($is_exist) {
            return $is_exist->value;
        } else {
            $this->db->insert("tbl_system_setup", array('setting' => $setting, 'value' => '0'));
            return 0;
        }
    }

    function GET_EMPL_CHANGEOFF($userId, $status, $limit, $offset)
    {

        $this->db->select('tb_change.create_date,tb_change.id,date_shift,current_shift,request_shift, date_shift_to, current_shift_to, request_shift_to, reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        // $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_changeoff as tb_change');
        return $query->result();
    }

    function GET_EMPL_CHANGEOFF_COUNT($userId, $status)
    {

        $this->db->select('tb_change.create_date,tb_change.id,date_shift,current_shift,request_shift, date_shift_to, current_shift_to, request_shift_to, reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        // $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }

        $query = $this->db->get('tbl_attendance_changeoff as tb_change');
        return $query->num_rows();
    }


    function GET_EMPL_UNDERTIME($userId, $status, $limit, $offset)
    {

        $this->db->select('tb_change.create_date,tb_change.id,date_undertime,current_shift,request_time_in, request_time_out, reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        // $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_undertime as tb_change');
        return $query->result();
    }

    function GET_EMPL_UNDERTIME_COUNT($userId, $status)
    {

        $this->db->select('tb_change.id,current_shift,reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        // $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }

        $query = $this->db->get('tbl_attendance_undertime as tb_change');
        return $query->num_rows();
    }

    function GET_STD_DATA($table)
    {
        $this->db->select('id,name')
            ->from($table)
            ->where(array('status' => 'active'));
        $query = $this->db->get();
        return $query->result();
    }

    function GET_SYSTEM_SETTING($setting)
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }

    function GET_OFFSETS($status, $search, $limit, $offset, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,offset_date, offset_type,time_range,duration,tb1.status,remarks,reason')
            ->select("
                CONCAT_WS(
                    '', 
                    COALESCE(tb3.col_last_name, ''), 
                    CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
                    COALESCE(tb3.col_frst_name, ''), 
                    CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
                ) AS assigned_by
                ", false)
            ->select("
                CONCAT_WS(
                    '', 
                    CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END,
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb2.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee
                ", false)

            ->from('tbl_attendance_offsets as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            // ->join('tbl_std_leavetypes as tb4', 'tb1.type = tb4.id', 'left')
            ->join('tbl_approvers_shift  as tb5', 'tb1.empl_id = tb5.empl_id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        // $this->db->where('tb2.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_OFFSET_COUNT($search, $status, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id')
            ->select("
                CONCAT_WS(
                    '', 
                    CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END,
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb2.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee
                ", false)

            ->from('tbl_attendance_offsets as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_approvers_shift  as tb5', 'tb1.empl_id = tb5.empl_id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        // $this->db->where('tb2.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function MOD_DISP_ALL_EMPLOYEES($user_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND reporting_to=? ORDER BY  col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEES()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_last_name', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }

    function GET_EMPLOYEES_MEMBERS($user_id)
    {
        $sql = "SELECT tb_empl.id,tb_empl.col_suffix,tb_empl.col_empl_cmid,tb_empl.col_last_name,tb_empl.col_midl_name,tb_empl.col_frst_name,
            CONCAT_WS(
                '', 
                CONCAT(col_empl_cmid, '-', col_last_name), 
                CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ', col_suffix) ELSE '' END,
                CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ', col_frst_name) ELSE '' END, 
                CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ', UPPER(LEFT(col_midl_name, 1)), '.') ELSE '' END
            ) AS fullname
        FROM 
            tbl_employee_infos as tb_empl
        LEFT JOIN tbl_approvers_shift  AS tb_shift ON tb_empl.id = tb_shift.empl_id
        WHERE 
            disabled = 0 
            AND (termination_date IS NULL OR termination_date = '0000-00-00')
            -- AND tb_shift.prepared_by = ?
        ORDER BY 
            tb_empl.col_last_name + 0 ASC";

        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }

    function GET_DATE_SETTING($setting)
    {
        $is_exist = $this->db->select("value")->where('setting', $setting)->get("tbl_system_setup")->row();
        if ($is_exist) {
            return $is_exist->value;
        } else {
            $this->db->insert("tbl_system_setup", array('setting' => $setting, 'value' => '0'));
            return 0;
        }
    }

    function GET_USER_DEPARMENT($user_id)
    {
        $sql = "SELECT col_empl_dept FROM tbl_employee_infos WHERE id = $user_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["col_empl_dept"];
    }

    function GET_ALL_SHIFTS()
    {
        $this->db->select('name,id,time_regular_start,time_regular_end');
        $this->db->from('tbl_attendance_shifts');
        $this->db->where('is_deleted', '0');
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result();
    }

    function MOD_DISP_HOLIDAY_BASED_DATE($date)
    {
        $query = $this->db
            ->select('col_holi_type')
            ->where('col_holi_date', $date)
            ->get('tbl_std_holidays');

        return $query->result();
    }

    function GET_USERS_APPROVERS($id, $table)
    {
        $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.approver_4a,tb1.approver_5a,tb1.id,approver_1b,approver_2b,approver_3b,tb1.approver_4b,tb1.approver_5b,tb1.empl_id');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
        $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
        $this->db->select("CONCAT(tb6.col_last_name,',',tb6.col_frst_name,' ',RPAD(LEFT(tb6.col_midl_name,1),2,'.')) as approver_4", false);
        $this->db->select("CONCAT(tb7.col_last_name,',',tb7.col_frst_name,' ',RPAD(LEFT(tb7.col_midl_name,1),2,'.')) as approver_5", false);
        $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from($table . ' as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver_4a=tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.approver_5a=tb7.id', 'left');
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function getApprovalsAutoApproveEnabled($empl_id)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->where('empl_id', $empl_id);
        $this->db->where('auto_approve', 'Enabled');
        $query = $this->db->get('tbl_approvers');
        $result = $query->row();
        if ($result) {
            return $result->count;
        } else {
            return 0;
        }
    }

    function ADD_CHANGESHIFT_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $this->db->insert('tbl_attendance_changeshift', $data);
        return $this->db->insert_id();
    }

    function GET_REQUESTORS($type, $id)
    {
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as requestor", false);
        if ($type == 'leave') {
            $this->db->from('tbl_leaves_assign as tb1');
        } else if ($type == 'overtime') {
            $this->db->from('tbl_overtimes as tb1');
        } else if ($type == 'holiday work') {
            $this->db->from('tbl_holidaywork as tb1');
        } else if ($type == 'time adjustment') {
            $this->db->from('tbl_attendance_adjustments as tb1');
        } else if ($type == 'offsets') {
            $this->db->from('tbl_attendance_offsets as tb1');
        } else if ($type == 'shift') {
            $this->db->from('tbl_attendance_shiftassign as tb1');
        } else if ($type == 'shiftrequest') {
            $this->db->from('tbl_attendance_changeshift as tb1');
        } else if ($type == 'changeOff') {
            $this->db->from('tbl_attendance_changeoff as tb1');
        } else if ($type == 'undertimeRequest') {
            $this->db->from('tbl_attendance_undertime as tb1');
        }

        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result->requestor;
    }

    function ADD_NOTIFICATIONS($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }

    function ADD_CHANGEOFF_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $this->db->insert('tbl_attendance_changeoff', $data);
        return $this->db->insert_id();
    }

    function ADD_UNDERTIME_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $this->db->insert('tbl_attendance_undertime', $data);
        return $this->db->insert_id();
    }

    function GET_TOTAL_REDEEMED_OFFSET($empl_id)
    {
        $sql = "SELECT SUM(duration) AS total_redeemed_offset FROM `tbl_attendance_offsets` WHERE empl_id = ? AND offset_type = 'Redeem' AND (status = 'Approved' OR status LIKE 'Pending%') ";
        $query = $this->db->query($sql, array($empl_id));
        return $query->row();
    }

    function GET_TOTAL_ACQUIRED_OFFSET($empl_id)
    {
        $sql = "
            SELECT 
                SUM(duration) AS total_acquired_offset,
                SUM(CASE WHEN DATE_ADD(offset_date, INTERVAL 2 MONTH) < CURDATE() THEN duration ELSE 0 END) AS expired_acquired_offset
            FROM `tbl_attendance_offsets` 
            WHERE empl_id = ? AND offset_type = 'Acquire' AND status = 'Approved'
        ";
        $query = $this->db->query($sql, array($empl_id));
        return $query->row();
    }

    function GET_EMPLOYEE_SPECIFIC_ROW($employee_id)
    {
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->row();
    }

    function GET_USER_APPROVERS($id, $table)
    {
        $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.approver_4a,tb1.approver_5a,tb1.id,approver_1b,approver_2b,approver_3b,tb1.approver_4b,tb1.approver_5b,tb1.empl_id');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
        $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
        $this->db->select("CONCAT(tb6.col_last_name,',',tb6.col_frst_name,' ',RPAD(LEFT(tb6.col_midl_name,1),2,'.')) as approver_4", false);
        $this->db->select("CONCAT(tb7.col_last_name,',',tb7.col_frst_name,' ',RPAD(LEFT(tb7.col_midl_name,1),2,'.')) as approver_5", false);
        $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from($table . ' as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver_4a=tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.approver_5a=tb7.id', 'left');
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_OFFSETS_IS_DUPLICATE_DATE_EMPL_ID($type, $date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_offsets WHERE offset_type=? AND offset_date=? AND empl_id=? AND status != 'Withdrawn'";
        $query = $this->db->query($sql, array($type, $date, $empl_id));
        return $query->num_rows();
    }

    function ADD_OFFSET_REQUEST($data)
    {
        $this->db->insert('tbl_attendance_offsets', $data);
        return $this->db->insert_id();
    }








    


} // END OF REQUESTS CLASS