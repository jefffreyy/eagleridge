<?php
class reports_model extends CI_Model{
    function GET_CUT_OFF_LIST(){
        $this->db->select('id, name,date_from,date_to');
        $this->db->where('status','Active');
        $this->db->order_by('date_to','DESC');
        $query = $this->db->get('tbl_payroll_period');
        return $query->result_object();
    }
    function isUserPageFound($page, $userId){
        $query = $this->db->query
        ("SELECT COUNT(*) AS count 
        FROM tbl_system_useraccess AS ua 
        JOIN tbl_employee_infos ON tbl_employee_infos.col_user_access = ua.id 
        WHERE FIND_IN_SET(?, ua.user_page) 
        AND tbl_employee_infos.id = ?", array($page, $userId));
        $result = $query->row();
        return $result->count;
    }
    
    
    function getCustomGroupActive(){
        $this->db->select('id, name');
        $this->db->where('status','Active');
        $query = $this->db->get('tbl_std_custom_groups');
        return $query->result();
    }
    function GET_CUT_OFF($id){
        $this->db->select('id, name,date_from,date_to');
        $this->db->where('status','Active');
        $this->db->where('id',$id);
        $query = $this->db->get('tbl_payroll_period');
        return $query->row();
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function GET_EMPLOYEE_LISTS($limit,$offset){
        $this->db->select("id,col_empl_cmid",false);
        $this->db->select("CONCAT_WS('',
                IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
                IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',LEFT(col_midl_name,1),'.'))
        ) AS fullname",false);
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        $this->db->limit($limit,$offset);
        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query=$this->db->get('tbl_employee_infos');
        return $query->result();
        
    }
    function GET_EMPLOYEE_LISTS_COUNT(){
        $this->db->select("id,col_empl_cmid",false);
        $this->db->select("CONCAT_WS('',
                IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
                IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',LEFT(col_midl_name,1),'.'))
        ) AS fullname",false);
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query=$this->db->get('tbl_employee_infos');
        return $query->num_rows();
    }
    function GET_EMPLOYEE($ids){ 
        $this->db->select("id,col_curr_addr,salary_rate,col_home_addr,col_mobl_numb,col_empl_cmid,col_empl_emai,col_empl_btin,col_birt_date",false);
        $this->db->select("DATE_FORMAT(col_birt_date,'%m%d%Y') as birth_date",false);
        // $this->db->select("CONCAT_WS('',
        //         IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
        //         IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',col_midl_name,'.'))
        // ) AS fullname",false);
        $this->db->select("CONCAT_WS(' ',col_last_name,col_suffix,col_frst_name,col_midl_name) as fullname",false);
        $this->db->where_in('id',$ids);
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        
        $this->db->order_by('col_empl_cmid + 0','asc');
        $query=$this->db->get('tbl_employee_infos');
        return $query->result();
    }
    function GET_ALL_EMPLOYEE(){
        $this->db->select("tb1.id,col_last_name,col_frst_name,left(col_midl_name,1) as col_midl_name,col_curr_addr,col_empl_sssc,col_empl_sssc,resignation_date,tb2.name as position,
        CAST(salary_rate as DECIMAL(65,2)) as salary_rate,col_home_addr,col_mobl_numb,col_empl_cmid,col_empl_emai,col_empl_btin,DATE_FORMAT(col_hire_date, '%m%d%Y') as date_hire,
        DATE_FORMAT(col_hire_date, '%m/%d/%Y') as hire_date,DATE_FORMAT(col_birt_date, '%m%d%Y') as birth_date,DATE_FORMAT(resignation_date, '%m%d%Y') as sep_date",false);
        $this->db->select("CONCAT_WS('',
                IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
                IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',LEFT(col_midl_name,1),'.'))
        ) AS formated_fullname",false);
        $this->db->select("CONCAT_WS(' ',col_last_name,col_frst_name,col_midl_name,col_suffix) as fullname",false);
        $this->db->from('tbl_employee_infos as tb1');
        $this->db->join('tbl_std_positions as tb2','tb1.col_empl_posi=tb2.id','left');
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        
        $this->db->order_by('col_empl_cmid + 0','asc');
        $query=$this->db->get();
        return $query->result();
    }
    function GET_EMPLOYEES_ALL()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }
     function GET_TARDINESS_SEARCH($date_from, $date_to, $empl_id)
    {
        $params = [$date_from, $date_to, $date_from, $date_to];
        if (!empty($empl_id)) $params[] = $empl_id;

        $query = $this->db->query("
        SELECT 
            ei.id,
            ei.col_empl_cmid,
            final.date,
            TIME_FORMAT(final.time_in, '%H:%i:%s') AS time_in,
            final.time_out,
            final.time_regular_start,
            final.time_regular_end,
            TIMESTAMPDIFF(MINUTE, final.time_regular_start, final.time_in) AS late_minutes,
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, final.time_regular_start, final.time_in) <= 15 THEN 0.25
                WHEN TIMESTAMPDIFF(MINUTE, final.time_regular_start, final.time_in) <= 30 THEN 0.50
                WHEN TIMESTAMPDIFF(MINUTE, final.time_regular_start, final.time_in) <= 45 THEN 0.75
                ELSE ROUND(TIMESTAMPDIFF(MINUTE, final.time_regular_start, final.time_in) / 60, 2)
            END AS late_duration,
            CONCAT_WS('',
                CASE WHEN ei.col_last_name IS NOT NULL AND ei.col_last_name != '' THEN ei.col_last_name ELSE '' END,
                CASE WHEN ei.col_suffix IS NOT NULL AND ei.col_suffix != '' THEN CONCAT(' ', ei.col_suffix) ELSE '' END,
                CASE WHEN ei.col_frst_name IS NOT NULL AND ei.col_frst_name != '' THEN CONCAT(', ', ei.col_frst_name) ELSE '' END,
                CASE WHEN ei.col_midl_name IS NOT NULL AND ei.col_midl_name != '' THEN CONCAT(' ', LEFT(ei.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
        FROM tbl_employee_infos ei
        LEFT JOIN (
            -- ZKTeco first
            SELECT 
                zc.empl_id,
                DATE(z.punch_time) AS date,
                MIN(CASE WHEN z.punch_state = 0 THEN TIME(z.punch_time) END) AS time_in,
                MAX(CASE WHEN z.punch_state = 1 THEN TIME(z.punch_time) END) AS time_out,
                s.time_regular_start,
                s.time_regular_end
            FROM tbl_zkteco_code zc
            JOIN tbl_zkteco z ON z.emp_code = zc.empl_code
            JOIN tbl_attendance_shiftassign sa ON sa.empl_id = zc.empl_id AND sa.date = DATE(z.punch_time)
            JOIN tbl_attendance_shifts s ON s.id = sa.shift_id
            WHERE DATE(z.punch_time) BETWEEN ? AND ?
            GROUP BY zc.empl_id, DATE(z.punch_time)

            UNION

            -- Fallback to attendance records
            SELECT 
                ar.empl_id,
                ar.date,
                ar.time_in,
                ar.time_out,
                s.time_regular_start,
                s.time_regular_end
            FROM tbl_attendance_records ar
            JOIN tbl_attendance_shiftassign sa ON sa.empl_id = ar.empl_id AND sa.date = ar.date
            JOIN tbl_attendance_shifts s ON s.id = sa.shift_id
            WHERE ar.date BETWEEN ? AND ?
            AND NOT EXISTS (
                SELECT 1
                FROM tbl_zkteco_code zc
                JOIN tbl_zkteco z ON z.emp_code = zc.empl_code
                WHERE zc.empl_id = ar.empl_id AND DATE(z.punch_time) = ar.date
            )
        ) AS final ON final.empl_id = ei.id
        WHERE final.date IS NOT NULL 
            AND final.time_in > final.time_regular_start
            AND NOT (final.time_regular_start = '00:00:00' AND final.time_regular_end = '00:00:00')
            " . (!empty($empl_id) ? "AND ei.id = ?" : "") . "
        ORDER BY ei.col_empl_cmid + 0 ASC
    ", $params);

        return $query->result();
    }
    function GET_LEAVES_SEARCH($date_from, $date_to, $employee_id)
    {
    $this->db->select('tb1.id, tb2.col_empl_cmid, tb1.leave_date, tb3.name as type, tb1.duration');
    $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
    ) AS fullname", false);
    
    $this->db->from('tbl_leaves_assign as tb1');
    $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
    $this->db->join('tbl_std_leavetypes as tb3', 'tb1.type = tb3.id', 'left');
    
    // Filters
    $this->db->where('tb1.empl_id', $employee_id);
    $this->db->where("tb1.leave_date BETWEEN '$date_from' AND '$date_to'");
    $this->db->where('tb1.status', 'Approved');
    
    $this->db->order_by('tb1.leave_date', 'ASC');
    
    $query = $this->db->get();
    return $query->result_object();
    }
    function GET_UNDERTIME_SEARCH($date_from, $date_to, $empl_id)
    {
        $params = [$date_from, $date_to, $date_from, $date_to];
        if (!empty($empl_id)) $params[] = $empl_id;

        $query = $this->db->query("
        SELECT 
            ei.id,
            ei.col_empl_cmid,
            final.date,
            TIME_FORMAT(final.time_in, '%H:%i:%s') AS time_in,
            TIME_FORMAT(final.time_out, '%H:%i:%s') AS time_out,
            final.time_regular_start,
            final.time_regular_end,
            TIMESTAMPDIFF(MINUTE, final.time_out, final.time_regular_end) AS undertime_minutes,
            CASE 
                WHEN TIMESTAMPDIFF(MINUTE, final.time_out, final.time_regular_end) <= 15 THEN 0.25
                WHEN TIMESTAMPDIFF(MINUTE, final.time_out, final.time_regular_end) <= 30 THEN 0.50
                WHEN TIMESTAMPDIFF(MINUTE, final.time_out, final.time_regular_end) <= 45 THEN 0.75
                ELSE ROUND(TIMESTAMPDIFF(MINUTE, final.time_out, final.time_regular_end) / 60, 2)
            END AS duration,
            CONCAT_WS('',
                CASE WHEN ei.col_last_name IS NOT NULL AND ei.col_last_name != '' THEN ei.col_last_name ELSE '' END,
                CASE WHEN ei.col_suffix IS NOT NULL AND ei.col_suffix != '' THEN CONCAT(' ', ei.col_suffix) ELSE '' END,
                CASE WHEN ei.col_frst_name IS NOT NULL AND ei.col_frst_name != '' THEN CONCAT(', ', ei.col_frst_name) ELSE '' END,
                CASE WHEN ei.col_midl_name IS NOT NULL AND ei.col_midl_name != '' THEN CONCAT(' ', LEFT(ei.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
        FROM tbl_employee_infos ei
        LEFT JOIN (
            -- Biometric first
            SELECT 
                zc.empl_id,
                DATE(z.punch_time) AS date,
                MIN(CASE WHEN z.punch_state = 0 THEN TIME(z.punch_time) END) AS time_in,
                MAX(CASE WHEN z.punch_state = 1 THEN TIME(z.punch_time) END) AS time_out,
                s.time_regular_start,
                s.time_regular_end
            FROM tbl_zkteco_code zc
            JOIN tbl_zkteco z ON z.emp_code = zc.empl_code
            JOIN tbl_attendance_shiftassign sa ON sa.empl_id = zc.empl_id AND sa.date = DATE(z.punch_time)
            JOIN tbl_attendance_shifts s ON s.id = sa.shift_id
            WHERE DATE(z.punch_time) BETWEEN ? AND ?
            GROUP BY zc.empl_id, DATE(z.punch_time)

            UNION

            -- Fallback to attendance records
            SELECT 
                ar.empl_id,
                ar.date,
                ar.time_in,
                ar.time_out,
                s.time_regular_start,
                s.time_regular_end
            FROM tbl_attendance_records ar
            JOIN tbl_attendance_shiftassign sa ON sa.empl_id = ar.empl_id AND sa.date = ar.date
            JOIN tbl_attendance_shifts s ON s.id = sa.shift_id
            WHERE ar.date BETWEEN ? AND ?
            AND NOT EXISTS (
                SELECT 1
                FROM tbl_zkteco_code zc
                JOIN tbl_zkteco z ON z.emp_code = zc.empl_code
                WHERE zc.empl_id = ar.empl_id AND DATE(z.punch_time) = ar.date
            )
        ) AS final ON final.empl_id = ei.id
        WHERE final.date IS NOT NULL 
            AND final.time_out < final.time_regular_end
            AND NOT (final.time_regular_start = '00:00:00' AND final.time_regular_end = '00:00:00')
            " . (!empty($empl_id) ? "AND ei.id = ?" : "") . "
        ORDER BY ei.col_empl_cmid + 0 ASC
    ", $params);

        return $query->result();
    }

    function GET_LEAVES($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid,tb1.leave_date, tb3.name as type, tb1.duration');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb3', 'tb1.type = tb3.id', 'left');

        $this->db->where("tb1.leave_date between '$date_from' AND '$date_to' ");
        $this->db->where('tb1.status', 'Approved');
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_LEAVES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb2.col_frst_name, tb2.col_midl_name, tb2.col_last_name, tb1.leave_date, tb3.name as type, tb1.duration');
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb3', 'tb1.type = tb3.id', 'left');
        if(empty($date_data)){
            $this->db->where('tb1.leave_date >=', $date_from);
            $this->db->where('tb1.leave_date <=', $date_to);
        }else{
            $this->db->like('tb1.leave_date', $date_data);
        }
        $this->db->where('tb1.status', 'Approved');
        return $this->db->count_all_results();
        
    }
    function GET_PAYSLIP_LOANS($period_id){
        $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.LOAN_TOTAL,DEDUCTIONS,
            CONCAT_WS('',
            CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
            CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
            CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
            CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
                FROM tbl_employee_infos as tb1
                LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id AND tb2.status='Published' AND tb2.PAYSLIP_PERIOD=?
                ORDER BY tb1.col_empl_cmid + 0 ASC
            ";
        $query=$this->db->query($sql,array($period_id));
        return $query->result();
    }
    
    function GET_PAYSLIP_BENIFITS($period_id){
        $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.SSS_EE_CURRENT,tb2.PAGIBIG_EE_CURRENT,tb2.PHILHEALTH_EE_CURRENT,
            CONCAT_WS('',
            CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
            CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
            CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
            CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
                FROM tbl_employee_infos as tb1
                LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id AND tb2.status='Published' AND tb2.PAYSLIP_PERIOD=?
                ORDER BY tb1.col_empl_cmid + 0 ASC
            ";
        $query=$this->db->query($sql,array($period_id));
        return $query->result();
    }
    function GET_PAYSLIP_REMITTANCES($period_id){
        $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.NET_INCOME,
            CONCAT_WS('',
            CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
            CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
            CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
            CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
                FROM tbl_employee_infos as tb1
                LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id AND tb2.status='Published' AND tb2.PAYSLIP_PERIOD=?
                ORDER BY tb1.col_empl_cmid + 0 ASC
            ";
        $query=$this->db->query($sql,array($period_id));
        return $query->result();
    }
    function GET_TARDINESS($date_from,$date_to){
        $this->db->select("tb1.id,tb4.col_empl_cmid,tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start,
        tb3.time_regular_end,HOUR(TIMEDIFF(tb1.time_in, tb3.time_regular_start))+FLOOR(MINUTE(TIMEDIFF(tb1.time_in, tb3.time_regular_start))/15)*0.25 AS late_duration",false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_in>tb3.time_regular_start");
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();

    }
    function GET_TARDINESS_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end, tb4.col_last_name, tb4.col_frst_name, tb4.col_midl_name');
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_in>tb3.time_regular_start");
        }else{
            $this->db->where("tb1.date",$date_data);
            // $this->db->where("tb1.time_in",">","tb3.time_regular_start");
            
        }
        return $this->db->count_all_results();

    }
    function GET_UNDERTIME($date_from,$date_to){
        $this->db->select('tb1.id,tb4.col_empl_cmid, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end');
        $this->db->select("HOUR(TIMEDIFF(tb1.time_out,  tb3.time_regular_end))+FLOOR(MINUTE(TIMEDIFF(tb1.time_out, tb3.time_regular_end))/15)*0.25 AS duration",false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_out<tb3.time_regular_end");
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_UNDERTIME_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end, tb4.col_last_name, tb4.col_frst_name, tb4.col_midl_name');
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_out<tb3.time_regular_end");
        }else{
           $this->db->where("tb1.date = '$date_data' and tb1.time_out<tb3.time_regular_end");
        }
        return $this->db->count_all_results();
    }
    function GET_NEW_EMPLOYEES($date_from,$date_to){
        $this->db->select('id,col_hire_date,col_empl_cmid');
        $this->db->select("CONCAT_WS('',
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT(col_last_name) ELSE '' END,  
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_infos');
        $this->db->where("col_hire_date between '$date_from'  and '$date_to' and termination_date IS NULL");
        $this->db->order_by('col_empl_cmid + 0','ASC');
        
        $query = $this->db->get();
        return $query->result_object();

    }
    function GET_NEW_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('id,col_frst_name,col_midl_name,col_last_name,col_hire_date,col_empl_cmid');
        $this->db->from('tbl_employee_infos');
        if(empty($date_data)){
            $this->db->where("col_hire_date between '$date_from'  and '$date_to' and termination_date IS NULL");
        }else{
            $this->db->where("col_hire_date = '$date_data' and termination_date IS NULL");
        }
        return $this->db->count_all_results();

    }
    function GET_PROBI_EMPLOYEES($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid, tb1.log_date, col_empl_cmid, tb1.from_val, tb1.to_val');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Probationary");
        $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'", NULL, FALSE);
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();

    }
    function GET_PROBI_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, col_frst_name, col_midl_name, col_last_name, tb1.log_date, col_empl_cmid, tb1.from_val, tb1.to_val');
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Probationary");
        if(empty($date_data)){
            $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'", NULL, FALSE);
        }else{
            $this->db->where("DATE(tb1.log_date)",$date_data);
        }
        $query = $this->db->get();
        return $query->num_rows();

    }
    function GET_CONTRACTUAL_EMPLOYEES($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid, tb1.log_date, col_empl_cmid, tb1.from_val, tb1.to_val');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Project Based");
        $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'");
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
        
    }
    function GET_CONTRACTUAL_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, col_frst_name, col_midl_name, col_last_name, tb1.log_date, col_empl_cmid, tb1.from_val, tb1.to_val');
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Project Based");
        if(empty($date_data)){
            $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'", NULL, FALSE);
        }else{
            $this->db->where("DATE(tb1.log_date)",$date_data);
        }
        $query = $this->db->get();
        return $query->num_rows();

    }
    function GET_RESIGNED_EMPLOYEES($date_from,$date_to){
        $this->db->select('id,col_suffix,col_frst_name,col_midl_name,col_last_name,termination_date,col_empl_cmid');
        $this->db->select("CONCAT_WS('',
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT(col_last_name) ELSE '' END,  
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_infos');
        $this->db->where("termination_date between '$date_from' and '$date_to'");
        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_RESIGNED_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('id,col_frst_name,col_midl_name,col_last_name,termination_date,col_empl_cmid');
        $this->db->from('tbl_employee_infos');
        if(empty($date_data)){
            $this->db->where("termination_date between '$date_from' and '$date_to'");
        }else{
            $this->db->where("termination_date",$date_data);
        }
        return $this->db->count_all_results();
    }
    function GET_ACTIVE_EMPLOYEES($date_from,$date_to){
        $this->db->select('tb1.id,col_hire_date,
        tb2.name as empl_position,
        col_empl_cmid');
        $this->db->select("CONCAT_WS('->',tb3.name,tb4.name,tb5.name,tb6.name,tb7.name,tb9.name,tb8.name  ) AS designation", false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_infos as tb1');
        $this->db->join('tbl_std_positions as tb2','tb1.col_empl_posi=tb2.id','left');
        $this->db->join('tbl_std_branches as tb3', 'tb1.col_empl_branch=tb3.id','left');
        $this->db->join('tbl_std_departments as tb4','tb1.col_empl_dept=tb4.id','left');
        $this->db->join('tbl_std_divisions as tb5','tb1.col_empl_divi=tb5.id','left');
        $this->db->join('tbl_std_sections as tb6','tb1.col_empl_sect=tb6.id','left');
        $this->db->join('tbl_std_groups as tb7','tb1.col_empl_group=tb7.id','left');
        $this->db->join('tbl_std_lines as tb8','tb1.col_empl_line=tb8.id','left');
        $this->db->join('tbl_std_teams as tb9','tb1.col_empl_team=tb9.id','left');
        $this->db->where("col_hire_date <= '$date_to'  AND tb1.disabled=0 AND tb1.termination_date IS NULL");

        $this->db->order_by('tb1.col_empl_cmid + 0','ASC');
        // $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_object();
    }
     function GET_ACTIVE_EMPLOYEES_COUNT($date_from,$date_to){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,col_hire_date,
        tb2.name as empl_position,
        tb3.name as empl_branch,
        tb4.name as empl_department,
        tb5.name as empl_division,
        tb6.name as empl_section,
        tb7.name as empl_group,
        tb8.name as empl_line,
        tb9.name as empl_team,
        col_empl_cmid');
        $this->db->from('tbl_employee_infos as tb1');
        $this->db->join('tbl_std_positions as tb2','tb1.col_empl_posi=tb2.id','left');
        $this->db->join('tbl_std_branches as tb3', 'tb1.col_empl_branch=tb3.id','left');
        $this->db->join('tbl_std_departments as tb4','tb1.col_empl_dept=tb4.id','left');
        $this->db->join('tbl_std_divisions as tb5','tb1.col_empl_divi=tb5.id','left');
        $this->db->join('tbl_std_sections as tb6','tb1.col_empl_sect=tb6.id','left');
        $this->db->join('tbl_std_groups as tb7','tb1.col_empl_group=tb7.id','left');
        $this->db->join('tbl_std_lines as tb8','tb1.col_empl_line=tb8.id','left');
        $this->db->join('tbl_std_teams as tb9','tb1.col_empl_team=tb9.id','left');
        $this->db->where("tb1.disabled = 0 AND tb1.termination_date IS NULL");
        $this->db->where("col_hire_date between '$date_from' AND '$date_to' ");
        // if(empty($date_data)){
        //     $this->db->where("col_hire_date  <= '$date_to' AND tb1.disabled=0 AND termination_date='0000-00-00'");
        // }else{
        //     $this->db->where("col_hire_date  <= '$date_data' AND tb1.disabled=0 AND termination_date='0000-00-00'");
        // }
        return $this->db->count_all_results();
    }
    // function GET_OVERTIME($date_from,$date_to){
    //     $this->db->select('tb1.id, tb1.type, tb2.col_empl_cmid,date_ot,time_out,hours');
    //     $this->db->select("CONCAT_WS('',
    //     CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END,
    //     CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
    //     CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
    //     CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
    //     CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
    //     ) AS fullname", false);
    //     $this->db->from('tbl_overtimes as tb1');
    //     $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
    //     $this->db->where("date_ot between '$date_from' and '$date_to' AND status='Approved'");
    //     $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
    //     $query = $this->db->get();
    //     return $query->result_object();
    // }

    function GET_OVERTIME($date_from, $date_to) {
        $sql = "SELECT tb1.id, tb1.type, tb2.col_empl_cmid, tb2.col_last_name, tb2.col_suffix, tb2.col_frst_name, tb2.col_midl_name, 
                CONCAT_WS('', 
                    CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END, 
                    CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, 
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END 
                ) AS fullname,
                tb1.date_ot, tb1.time_out, tb1.hours, tb3.shift_id, tb4.code, tb4.time_regular_end
                FROM tbl_overtimes AS tb1
                LEFT JOIN tbl_employee_infos AS tb2 ON tb1.empl_id = tb2.id
                LEFT JOIN tbl_attendance_shiftassign AS tb3 ON tb1.empl_id = tb3.empl_id AND tb1.date_ot = tb3.date -- connect to tbl_overtimes empl_id and date_ot
                LEFT JOIN tbl_attendance_shifts AS tb4 ON tb3.shift_id = tb4.id -- connect to tbl_attendance_shiftassign shift_id  
                WHERE tb1.date_ot BETWEEN ? AND ? AND tb1.status = 'Approved'
                ORDER BY tb2.col_empl_cmid + 0 ASC";
    
        $query = $this->db->query($sql, array($date_from, $date_to));
        return $query->result_object();
    }
    function GET_OVERTIME_SEARCH($date_from, $date_to, $employee_id)
    {  
    $sql = "SELECT 
                tb1.id, tb1.type, tb2.col_empl_cmid, tb2.col_last_name, tb2.col_suffix, 
                tb2.col_frst_name, tb2.col_midl_name,
                CONCAT_WS('', 
                    CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END, 
                    CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, 
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END 
                ) AS fullname,
                tb1.date_ot, tb1.time_out, tb1.hours, tb3.shift_id, tb4.code, tb4.time_regular_end
            FROM tbl_overtimes AS tb1
            LEFT JOIN tbl_employee_infos AS tb2 ON tb1.empl_id = tb2.id
            LEFT JOIN tbl_attendance_shiftassign AS tb3 
                ON tb1.empl_id = tb3.empl_id AND tb1.date_ot = tb3.date
            LEFT JOIN tbl_attendance_shifts AS tb4 
                ON tb3.shift_id = tb4.id
            WHERE tb1.date_ot BETWEEN ? AND ?
              AND tb1.status = 'Approved'";

    $params = [$date_from, $date_to];

    if (!empty($employee_id)) {
        $sql .= " AND tb1.empl_id = ?";
        $params[] = $employee_id;
    }

    $sql .= " ORDER BY tb2.col_empl_cmid + 0 ASC";

    $query = $this->db->query($sql, $params);
    return $query->result_object();
    }

    function GET_OVERTIME_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,date_ot,time_out,hours');
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        if(empty($date_data)){
            $this->db->where("date_ot between '$date_from' and '$date_to' AND status='Approved'");
        }else{
            $this->db->where("date_ot = '$date_data'  AND status='Approved'");
        }
        return $this->db->count_all_results();
    }
    function GET_TIME_ADJS($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid,date_adjustment,time_out_1,time_out_2,time_in_1,time_in_2');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("date_adjustment between '$date_from' and '$date_to' AND status='Approved'");
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_TIME_ADJS_SEARCH($date_from, $date_to, $employee_id)
    {
    $this->db->select('tb1.id, tb2.col_empl_cmid, date_adjustment, time_out_1, time_out_2, time_in_1, time_in_2');
    $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
    ) AS fullname", false);

    $this->db->from('tbl_attendance_adjustments as tb1');
    $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
    $this->db->where("date_adjustment BETWEEN '$date_from' AND '$date_to' AND status='Approved'");
    $this->db->where('tb1.empl_id', $employee_id);
    $this->db->order_by('tb2.col_empl_cmid + 0', 'ASC');

    $query = $this->db->get();
    return $query->result();
    }
    function GET_TIME_ADJS_COUNT($date_from,$date_to){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,date_adjustment,time_out_1,time_out_2,time_in_1,time_in_2');
        
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        if(empty($date_data)){
            $this->db->where("date_adjustment between '$date_from' and '$date_to' AND status='Approved'");
        }else{
            $this->db->where("date_adjustment = '$date_data' AND status='Approved'");
        }
        return $this->db->count_all_results();
    }
    function GET_HOLI_WORKS($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid,date,hours');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' AND tb1.status='Approved'");
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_HOLI_WORKS_SEARCH($date_from, $date_to, $employee_id)
    {
    $this->db->select('tb1.id, tb2.col_empl_cmid, date, hours');
    $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
    ) AS fullname", false);

    $this->db->from('tbl_holidaywork as tb1');
    $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
    $this->db->where("tb1.date BETWEEN '$date_from' AND '$date_to' AND tb1.status='Approved'");
    $this->db->where('tb1.empl_id', $employee_id);
    $this->db->order_by('tb2.col_empl_cmid + 0', 'ASC');

    $query = $this->db->get();
    return $query->result();
    }   
    function GET_HOLI_WORKS_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,date,hours');
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' AND tb1.status='Approved'");
        }else{
            $this->db->where("tb1.date = '$date_data' AND tb1.status='Approved'");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_AWOL_EMP($date_from,$date_to,$selectedCustomGroups){
        $sql="SELECT tb1.id, tb1.date,tb5.col_empl_cmid, tb7.id as cg_id,
        CONCAT_WS('',
        CASE WHEN tb5.col_last_name IS NOT NULL AND tb5.col_last_name != '' THEN CONCAT(tb5.col_last_name) ELSE '' END,  
        CASE WHEN tb5.col_suffix IS NOT NULL AND tb5.col_suffix != '' THEN CONCAT(' ', tb5.col_suffix) ELSE '' END,
        CASE WHEN tb5.col_frst_name IS NOT NULL AND tb5.col_frst_name != '' THEN CONCAT(', ', tb5.col_frst_name) ELSE '' END,
        CASE WHEN tb5.col_midl_name IS NOT NULL AND tb5.col_midl_name != '' THEN CONCAT(' ', LEFT(tb5.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname
        FROM tbl_attendance_shiftassign as tb1  
                left join tbl_attendance_shifts as tb4 on tb1.shift_id=tb4.id
                left join tbl_employee_infos as tb5 on tb1.empl_id=tb5.id
                left join tbl_custom_group_assignments as tb6 on tb6.empl_id=tb5.id and tb6.is_checked='1'
                left join tbl_std_custom_groups as tb7 on tb7.id=tb6.custom_group_id
                where (tb1.date between ? and ? ) and not exists (SELECT date FROM tbl_attendance_records as tb2 
                WHERE tb1.date=tb2.date and tb1.empl_id=tb2.empl_id and (tb2.time_in='00:00:00'||tb2.time_out='00:00:00'))
                and not exists (SELECT leave_date from tbl_leaves_assign as tb3 where tb1.date=tb3.leave_date and tb3.status='Approved')
                and  tb4.name!='REST' and tb5.disabled=0 and tb5.termination_date IS NULL";

                if(isset($selectedCustomGroups) && !empty($selectedCustomGroups)) {
                    $sql .= " AND tb7.id IN ($selectedCustomGroups)";
                }
                // $sql .= " GROUP BY tb1.date,fullname, tb7.id";
                $sql .= " GROUP BY fullname, tb1.date";
                $sql .= " ORDER BY tb5.col_empl_cmid + 0 ASC";
         $query = $this->db->query($sql, array($date_from,$date_to));
        return $query->result_object();
    }
    function GET_AWOL_EMP_COUNT($date_from,$date_to,$date_data){
        if(!empty($date_data)){
            $sql="SELECT tb1.date,tb5.col_empl_cmid,tb5.col_last_name,tb5.col_frst_name,tb5.col_midl_name FROM tbl_attendance_shiftassign as tb1  
                left join tbl_attendance_shifts as tb4 on tb1.shift_id=tb4.id
                left join tbl_employee_infos as tb5 on tb1.empl_id=tb5.id
                where (tb1.date = ? ) and not exists (SELECT date FROM tbl_attendance_records as tb2 
                WHERE tb1.date=tb2.date and tb1.empl_id=tb2.empl_id and (tb2.time_in='00:00:00'||tb2.time_out='00:00:00'))
                and not exists (SELECT leave_date from tbl_leaves_assign as tb3 where tb1.date=tb3.leave_date and tb3.status='Approved')
                and  tb4.name!='REST' ";
             $query = $this->db->query($sql, array($date_data));
        }else{
            $sql="SELECT tb1.date,tb5.col_empl_cmid,tb5.col_last_name,tb5.col_frst_name,tb5.col_midl_name FROM tbl_attendance_shiftassign as tb1  
                left join tbl_attendance_shifts as tb4 on tb1.shift_id=tb4.id
                left join tbl_employee_infos as tb5 on tb1.empl_id=tb5.id
                where (tb1.date between ? and ? ) and not exists (SELECT date FROM tbl_attendance_records as tb2 
                WHERE tb1.date=tb2.date and tb1.empl_id=tb2.empl_id and (tb2.time_in='00:00:00'||tb2.time_out='00:00:00'))
                and not exists (SELECT leave_date from tbl_leaves_assign as tb3 where tb1.date=tb3.leave_date and tb3.status='Approved')
                and  tb4.name!='REST' ";
         $query = $this->db->query($sql, array($date_from,$date_to));
        }
            return $query->num_rows();
    }
    function GET_SLIDERS($date_from,$date_to){
        $this->db->select('tb1.id, tb1.date, tb4.col_empl_cmid,tb1.time_in, tb1.time_out, tb3.time_regular_start,
        tb3.time_regular_end');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' AND (tb1.time_in BETWEEN DATE_SUB(tb3.time_regular_start, INTERVAL 4 MINUTE) AND tb3.time_regular_start)");
        }else{
            $this->db->where("tb1.date = '$date_data' AND (tb1.time_in BETWEEN DATE_SUB(tb3.time_regular_start, INTERVAL 4 MINUTE) AND tb3.time_regular_start)");
        }
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_SLIDERS_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start,
        tb3.time_regular_end, tb4.col_last_name, tb4.col_frst_name, tb4.col_midl_name');
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' AND (tb1.time_in BETWEEN DATE_SUB(tb3.time_regular_start, INTERVAL 4 MINUTE) AND tb3.time_regular_start)");
        }else{
            $this->db->where("tb1.date = '$date_data' AND (tb1.time_in BETWEEN DATE_SUB(tb3.time_regular_start, INTERVAL 4 MINUTE) AND tb3.time_regular_start)");
        }
        return $this->db->count_all_results();
    }
    function GET_PROMOTED_EMP($date_from,$date_to){
        $this->db->select('tb1.id, tb2.col_empl_cmid,tb1.log_date,tb1.from_val,tb1.to_val');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        $this->db->where('category', 'Position');
        $this->db->where("log_date between '$date_from' AND '$date_to' ");
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_PROMOTED_EMP_COUNT($date_from,$date_to){
        $this->db->select('tb1.id,tb1.log_date,tb1.from_val,tb1.to_val,tb2.col_last_name,tb2.col_frst_name,tb2.col_midl_name');
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        $this->db->where('category', 'Position');
        $this->db->where("log_date between '$date_from' AND '$date_to' ");
        // if(empty($date_data)){
        //     $this->db->where('log_date >=', $date_from);
        //     $this->db->where('log_date <=', $date_to);
        // }
        // else{
        //      $this->db->like('log_date', $date_data);
        // }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function SYSTEM_SETTINGS($setting){
        $this->db->select('value');
        $this->db->where('setting',$setting);
        $query=$this->db->get('tbl_system_setup');
        $result=$query->row();
        return $result->value;
    }
    function UPDATE_FORM_SETTING($data){
        
        return $this->db->update_batch('tbl_system_setup', $data, 'setting');
    }
    
}
