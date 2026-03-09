<?php
class payrolls_model extends CI_Model
{
    function GET_USER_ACCESS_PAGE($id)
    {
        $query = $this->db
            ->select('user_page')
            ->where('id', $id)
            ->get('tbl_system_useraccess');
        return $query->row_array();
    }
    // New Funtcion
    function GET_PAYROLL_DATA()
    {
        $date = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";
        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function DELETE_PAYSLIP_DATA($ids){
        $this->db->where_in('id', $ids);
        return $this->db->delete('tbl_payroll_payslips');
    }
    function UPDATE_BULK_ACTIVATE($loan_data,$table_name){
        return $this->db->update_batch($table_name,$loan_data, 'id');
    }
    function GET_PAYSLIP_RECORDS($period){
        $this->db->select('col_empl_cmid,col_last_name,col_frst_name,col_midl_name,col_empl_posi,col_empl_type,tbl_payroll_payslips.id as id');
        $this->db->from('tbl_payroll_payslips');
        $this->db->join('tbl_employee_infos', 'tbl_payroll_payslips.empl_id = tbl_employee_infos.id');
        $this->db->where('PAYSLIP_PERIOD',$period);
        $query = $this->db->get();
        return $query->result_array();
    }
    function GET_COMPANY_NAME(){
        $this->db->select('value');
        $this->db->from('tbl_system_setup');
        $this->db->where('id', 1);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_OTHERDEDUCTIONS_DATA($payroll_id)
    {
  
        $sql = "SELECT * FROM tbl_payroll_otherdeductions WHERE payroll_period = $payroll_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_OTHERDEDUCTIONS_EMPL_DATA()
    {
        
       

        $sql = "SELECT id,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function UPDATE_OTHERDEDUCTIONS_DATA($data, $payroll_id) {
        // $C_BRANCH                   = $this->GET_BRANCHES();
        // $C_SECTIONS                 = $this->GET_SECTIONS();
        // $C_DEPARTMENTS              = $this->GET_DEPARTMENTS();
        // $C_POSITIONS                = $this->GET_POSITION();
        // $C_TYPE                     = $this->GET_TYPE();
        // $C_SHIRT_SIZE               = $this->GET_SHIRT_SIZE();
        // $C_GENDERS                  = $this->GET_GENDERS();
        // $C_MARITAL                  = $this->GET_MARITAL();
        // $C_NATIONALITY              = $this->GET_NATIONALITY();
        // $C_GROUPS                   = $this->GET_GROUPS();
        // $C_LINES                    = $this->GET_LINES();
        // $C_DIVISIONS                = $this->GET_DIVISIONS();
        // $C_HMOS                     = $this->GET_HMO();
        $id                             = $data[0];
        $empl_id                        = $data[1];
        $payroll_period                 = $payroll_id;     
        $coop                           = $data[3];
        $vaccine                        = $data[4];
        $vac                            = $data[5];
        $funeral                        = $data[6];
        $cmcl                           = $data[7];
        $rcbc                           = $data[8];
        $canteen                        = $data[9];

        // $data_4                         =  $this->convert_name2id($C_MARITAL, $data[4]);
        // $data_8                         =  $this->convert_name2id($C_GENDERS, $data[8]);
        // $data_9                        =  $this->convert_name2id($C_NATIONALITY, $data[9]);
        // $data_10                        =  $this->convert_name2id($C_SHIRT_SIZE, $data[10]);
        // $data_14                        =  $this->convert_name2id($C_TYPE, $data[14]);
        // $data_15                        =  $this->convert_name2id($C_POSITIONS, $data[15]);
        // $data_16                        =  $this->convert_name2id($C_DIVISIONS, $data[16]);
        // $data_17                        =  $this->convert_name2id($C_GROUPS, $data[17]);
        // $data_18                        =  $this->convert_name2id($C_LINES, $data[18]);
        // $data_19                        =  $this->convert_name2id($C_DEPARTMENTS, $data[19]);
        // $data_20                        =  $this->convert_name2id($C_SECTIONS, $data[20]);
        // $data_29                        =  $this->convert_name2id($C_HMOS, $data[29]);

        $sql = " UPDATE tbl_payroll_otherdeductions SET empl_id=?, payroll_period=?, coop=?, vaccine=?, vac=?, funeral=?, cmcl=?, rcbc=?, canteen=? WHERE id = ?";
        $this->db->query($sql,array($empl_id,$payroll_period,$coop,$vaccine,$vac,$funeral,$cmcl,$rcbc,$canteen,$id));
  
        // $sql = " UPDATE tbl_employee_infos SET col_last_name=?, col_midl_name=?, col_frst_name=?, col_mart_stat=?, col_home_addr=?, col_curr_addr=?, col_birt_date=?, col_empl_gend=?, col_empl_nati=?, col_shir_size=?, 
        // col_empl_emai=?, col_mobl_numb=?, col_hire_date=?, col_empl_type=?, col_empl_posi=?, col_empl_divi=?, col_empl_group=?, col_empl_line=?, col_empl_dept=?, col_empl_sect=?, col_imag_path=?, col_empl_sssc=?, 
        // col_empl_hdmf=?, col_empl_phil=?, col_empl_btin=?, col_empl_driv=?, col_empl_naid=?, col_empl_pass=?, col_empl_hmoo=?, col_empl_hmon=?, salary_rate=?, salary_type=? 
        // WHERE col_empl_cmid=?";
        // $this->db->query($sql,array($data[1],$data[2],$data[3],$data_4,$data[5],$data[6],$data[7],$data_8,$data_9,$data_10,$data[11],$data[12],$data[13],$data_14,$data_15,$data_16,$data_17,$data_18,$data_19,$data_20,$data[21],$data[22],$data[23],$data[24],$data[25],$data[26],$data[27],$data[28],$data_29,$data[30],$data[31],$data[32],$data[0]));
    }

    function INSERT_OTHERDEDUCTIONS_DATA($data, $payroll_id) {
        // $C_BRANCH                   = $this->GET_BRANCHES();
        // $C_SECTIONS                 = $this->GET_SECTIONS();
        // $C_DEPARTMENTS              = $this->GET_DEPARTMENTS();
        // $C_POSITIONS                = $this->GET_POSITION();
        // $C_TYPE                     = $this->GET_TYPE();
        // $C_SHIRT_SIZE               = $this->GET_SHIRT_SIZE();
        // $C_GENDERS                  = $this->GET_GENDERS();
        // $C_MARITAL                  = $this->GET_MARITAL();
        // $C_NATIONALITY              = $this->GET_NATIONALITY();
        // $C_GROUPS                   = $this->GET_GROUPS();
        // $C_LINES                    = $this->GET_LINES();
        // $C_DIVISIONS                = $this->GET_DIVISIONS();
        // $C_HMOS                     = $this->GET_HMO();
        $id                             = $data[0];
        $empl_id                        = $data[1];
        $payroll_period                 = $payroll_id;     
        $coop                           = $data[3];
        $vaccine                        = $data[4];
        $vac                            = $data[5];
        $funeral                        = $data[6];
        $cmcl                           = $data[7];
        $rcbc                           = $data[8];
        $canteen                        = $data[9];

        // $data_4                         =  $this->convert_name2id($C_MARITAL, $data[4]);
        // $data_8                         =  $this->convert_name2id($C_GENDERS, $data[8]);
        // $data_9                        =  $this->convert_name2id($C_NATIONALITY, $data[9]);
        // $data_10                        =  $this->convert_name2id($C_SHIRT_SIZE, $data[10]);
        // $data_14                        =  $this->convert_name2id($C_TYPE, $data[14]);
        // $data_15                        =  $this->convert_name2id($C_POSITIONS, $data[15]);
        // $data_16                        =  $this->convert_name2id($C_DIVISIONS, $data[16]);
        // $data_17                        =  $this->convert_name2id($C_GROUPS, $data[17]);
        // $data_18                        =  $this->convert_name2id($C_LINES, $data[18]);
        // $data_19                        =  $this->convert_name2id($C_DEPARTMENTS, $data[19]);
        // $data_20                        =  $this->convert_name2id($C_SECTIONS, $data[20]);
        // $data_29                        =  $this->convert_name2id($C_HMOS, $data[29]);

        $sql = "INSERT INTO tbl_payroll_otherdeductions (empl_id, payroll_period, coop, vaccine, vac, funeral, cmcl, rcbc, canteen) VALUES (?,?,?,?,?,?,?,?,?)";
        $this->db->query($sql,array($empl_id,$payroll_period,$coop,$vaccine,$vac,$funeral,$cmcl,$rcbc,$canteen));
  
        // $sql = " UPDATE tbl_employee_infos SET col_last_name=?, col_midl_name=?, col_frst_name=?, col_mart_stat=?, col_home_addr=?, col_curr_addr=?, col_birt_date=?, col_empl_gend=?, col_empl_nati=?, col_shir_size=?, 
        // col_empl_emai=?, col_mobl_numb=?, col_hire_date=?, col_empl_type=?, col_empl_posi=?, col_empl_divi=?, col_empl_group=?, col_empl_line=?, col_empl_dept=?, col_empl_sect=?, col_imag_path=?, col_empl_sssc=?, 
        // col_empl_hdmf=?, col_empl_phil=?, col_empl_btin=?, col_empl_driv=?, col_empl_naid=?, col_empl_pass=?, col_empl_hmoo=?, col_empl_hmon=?, salary_rate=?, salary_type=? 
        // WHERE col_empl_cmid=?";
        // $this->db->query($sql,array($data[1],$data[2],$data[3],$data_4,$data[5],$data[6],$data[7],$data_8,$data_9,$data_10,$data[11],$data[12],$data[13],$data_14,$data_15,$data_16,$data_17,$data_18,$data_19,$data_20,$data[21],$data[22],$data[23],$data[24],$data[25],$data[26],$data[27],$data[28],$data_29,$data[30],$data[31],$data[32],$data[0]));
    }

    function GET_PAYSLIP_DATA($id){
        $this->db->select('col_empl_cmid,col_last_name,col_frst_name,col_midl_name,col_empl_posi,col_empl_type,tbl_payroll_payslips.id as id,tbl_employee_infos.salary_type as salary_type,tbl_employee_infos.salary_rate as salary_rate,tbl_payroll_payslips.*,tbl_std_positions.name as position,tbl_std_departments.name as department,tbl_std_sections.name as section,tbl_payroll_period.name as PAYSLIP_PERIOD');
        $this->db->from('tbl_payroll_payslips');
        $this->db->join('tbl_employee_infos', 'tbl_payroll_payslips.empl_id = tbl_employee_infos.id', 'left');
        $this->db->join('tbl_std_positions', 'tbl_std_positions.id = tbl_employee_infos.col_empl_posi', 'left');
        $this->db->join('tbl_std_departments', 'tbl_std_departments.id = tbl_employee_infos.col_empl_dept', 'left');
        $this->db->join('tbl_std_sections', 'tbl_std_sections.id = tbl_employee_infos.col_empl_sect', 'left');
         $this->db->join('tbl_payroll_period', 'tbl_payroll_period.id = tbl_payroll_payslips.PAYSLIP_PERIOD', 'left');
        $this->db->where('tbl_payroll_payslips.id', $id);
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_PAYROLL_DATA_FILTER($period){
        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_LIST()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled = '0' ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_INFO()
    {
        $sql = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_INFO_SPECIFIC($empl_id)
    {
        if (!$empl_id||$empl_id=='undefined'){
            return false;
        }
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date='0000-00-00' AND
        disabled=0
        AND id = $empl_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_PERIOD_LIST()                  //JERENZ: NO GET PERIOD LIST FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_payroll_period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $period)
    {
        $sql = "SELECT GROSS_INCOME,SSS_EE_CURRENT,PAGIBIG_EE_CURRENT,PHILHEALTH_EE_CURRENT,SSS_ER_CURRENT,SSS_EC_ER_CURRENT,PAGIBIG_ER_CURRENT,PHILHEALTH_ER_CURRENT FROM tbl_payroll_payslips WHERE empl_id = '$empl_id' AND PAYSLIP_PERIOD = '$period'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }


    function GET_PERIOD_INFO()
    {
        $sql = "SELECT * FROM tbl_payroll_period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_CONN_PERIOD_INFO_SPECIFIC($id)             //JERENZ: NO GET CONN PERIOD INFO SPECIFIC FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT connected_period FROM tbl_payroll_period WHERE id = $id";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->connected_period;
    }

    function GET_CONVERT_PERIOD2NAME($id)                 //JERENZ: NO GET CONVERT PERIOD2NAME FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT name as names FROM tbl_payroll_period WHERE id = $id";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->names;
    }


    function GET_PERIOD_LIST_LOCK()
    {
        $sql = "SELECT DISTINCT period FROM tbl_attendance_records_lock WHERE status = 0 ORDER BY period DESC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_NOT_READY_PAYSLIP($peroid){
        $sql=  "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,
                col_empl_posi,col_empl_type from tbl_employee_infos
                WHERE termination_date='0000-00-00' AND
                disabled=0
                AND NOT EXISTS(
                SELECT empl_id from tbl_attendance_records_lock
                WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$peroid
                )
                AND 
                NOT EXISTS (
                SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                tbl_payroll_payslips.PAYSLIP_PERIOD = $peroid)";
        $query = $this->db->query($sql);
        $query->next_result(); 
        return $query->result_array();
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
                tbl_payroll_payslips.PAYSLIP_PERIOD= $period )";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result_array();
    }
    function GET_EMPLOYEE_LIST_LOCK($period)
    {
       if($period=='undefined'||empty($period)){
           return [];
       }
        $sql="SELECT tbl_employee_infos.id as empl_id from tbl_employee_infos 
        WHERE termination_date='0000-00-00' AND disabled=0 
        AND EXISTS(
        SELECT empl_id from tbl_attendance_records_lock
        WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$period
        )
        AND 
        NOT EXISTS (
        SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
        tbl_payroll_payslips.PAYSLIP_PERIOD=$period
        )";
        // $sql = "SELECT DISTINCT empl_id FROM tbl_attendance_records_lock WHERE period = $period AND status = 0;";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function ADD_LOAN($loan_info){
        $date = date('Y-m-d H:i:s');
        $data = array(
        'create_date'   => $date,
        'edit_date'     => $date,
        'loan_name'     => $loan_info['insrt_loan_name'],
        'loan_type'     => $loan_info['insrt_loan_type'],
        'loan_date'     => $loan_info['insrt_loan_date'],
        'loan_amount'   => $loan_info['insrt_loan_amount'],
        'loan_terms'    => $loan_info['insrt_loan_terms'],
        'empl_id'       => $loan_info['insrt_employee'],
        'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        return $this->db->insert('tbl_payroll_loan', $data);
    }
    function UPDATE_LOAN($loan_info,$id){
        $date = date('Y-m-d H:i:s');
        $data = array(
        'edit_date'     => $date,
        'loan_name'     => $loan_info['insrt_loan_name'],
        'loan_type'     => $loan_info['insrt_loan_type'],
        'loan_date'     => $loan_info['insrt_loan_date'],
        'loan_amount'   => $loan_info['insrt_loan_amount'],
        'loan_terms'    => $loan_info['insrt_loan_terms'],
        'empl_id'       => $loan_info['insrt_employee'],
        'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        $this->db->where('id', $id);
        return $this->db->update('tbl_payroll_loan', $data);
    }
    function ADD_DEDUCTION($loan_info){
        $date = date('Y-m-d H:i:s');
        $data = array(
        'create_date'   => $date,
        'edit_date'     => $date,
        'loan_name'     => $loan_info['insrt_name'],
        'loan_date'     => $loan_info['insrt_date'],
        'loan_amount'   => $loan_info['insrt_amount'],
        'loan_terms'    => $loan_info['insrt_terms'],
        'empl_id'       => $loan_info['insrt_employee'],
        'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        return $this->db->insert('tbl_payroll_deductions', $data);
    }
    function UPDATE_DEDUCTION($loan_info,$id){
        $data = array(
        'loan_name'     => $loan_info['insrt_name'],
        'loan_date'     => $loan_info['insrt_date'],
        'loan_amount'   => $loan_info['insrt_amount'],
        'loan_terms'    => $loan_info['insrt_terms'],
        'empl_id'       => $loan_info['insrt_employee'],
        'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        $this->db->where('id', $id);
        return $this->db->update('tbl_payroll_deductions', $data);
    }
    // Cash advance
    function ADD_CASH_ADV($loan_info){
        $date = date('Y-m-d H:i:s');
        $data = array(
        'create_date'   => $date,
        'edit_date'     => $date,
        'loan_name'     => $loan_info['insrt_name'],
        'loan_date'     => $loan_info['insrt_date'],
        'loan_amount'   => $loan_info['insrt_amount'],
        'loan_terms'    => $loan_info['insrt_terms'],
        'empl_id'       => $loan_info['insrt_employee'],
        'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        return $this->db->insert('tbl_payroll_cashadvance', $data);
    }
    function UPDATE_CASH_ADV($loan_info,$id){
        $data = array(
        'loan_name'     => $loan_info['insrt_name'],
        'loan_date'     => $loan_info['insrt_date'],
        'loan_amount'   => $loan_info['insrt_amount'],
        'loan_terms'    => $loan_info['insrt_terms'],
        'empl_id'       => $loan_info['insrt_employee'],
        'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        $this->db->where('id', $id);
        return $this->db->update('tbl_payroll_cashadvance', $data);
    }
    function GET_SPEC_LOAN($id){
        $query = $this->db
            ->select('*')
            ->where('id', $id)
            ->get('tbl_payroll_loan');
        return $query->row();
    }
     function GET_SPEC_DEDUCTION($id){
        $query = $this->db
            ->select('*')
            ->where('id', $id)
            ->get('tbl_payroll_deductions');
        return $query->row();
    }
     function GET_SPEC_CASH_ADV($id){
        $query = $this->db
            ->select('*')
            ->where('id', $id)
            ->get('tbl_payroll_cashadvance');
        return $query->row();
    }

    function GET_ATTENDANCE_LOCK($empl_id, $period)
    {
        if($empl_id=='undefined'|| $period=='undefined'|| !$empl_id||!$period){
            return false;
        }
        $sql = "SELECT * FROM tbl_attendance_records_lock WHERE empl_id = $empl_id AND period = $period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_EMPLOYEE($id)                //JERENZ: NO GET SPECIFIC EMPLOYEE FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT col_last_name,col_frst_name,col_empl_sect,col_empl_dept,col_empl_type,col_empl_posi,col_empl_cmid FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_EMPLOYEE_TYPE($id)
    {
        $sql = "SELECT name FROM tbl_std_employeetypes WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }

    function GET_STD_ADJUSTMENTS()
    {
        $sql = "SELECT * FROM tbl_std_adjustments WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_STD_TAX_ALLOWANCE_LIST()
    {
        $sql = "SELECT id,name,type FROM tbl_std_allowances_tax WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_TAX_ALLOWANCE_EMPL($tax_id,$employee){
        if($employee=='undefined'||!$employee){
            return false;
        }
        $sql = "SELECT value as val FROM tbl_employee_allowanceassigntax WHERE name = $tax_id AND username = $employee";
        $query = $this->db->query($sql);

        $query->next_result();
        $result = $query->result_array();
   
        if(empty($result)){
            return 0;
        }
        else{
            return $result[0]["val"];
        }
    }

    function GET_STD_TAX_DEDUCTION_LIST()           //JERENZ: NO GET STD TAX DEDUCTION LIST FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT id,name,type FROM tbl_std_deductions_tax WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_TAX_DEDUCTION_EMPL($tax_id,$employee){                 //JERENZ: NO GET TAX DEDUCTION EMPL FOUND IN THE PAYROLLS CONTROLLER
        if($employee=='undefined'||!$employee){
            return false;
        }
        $sql = "SELECT value as val FROM tbl_employee_deductionassigntax WHERE name = $tax_id AND username = $employee";
        $query = $this->db->query($sql);

        $query->next_result();
        $result = $query->result_array();
   
        if(empty($result)){
            return 0;
        }
        else{
            return $result[0]["val"];
        }
    }

    function GET_STD_NONTAX_ALLOWANCE_LIST()
    {
        $sql = "SELECT id,name,type FROM tbl_std_allowances_nontax WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_NONTAX_ALLOWANCE_EMPL($tax_id,$employee){
        if($employee=='undefined'||!$employee){
            return false;
        }
        $sql = "SELECT value as val FROM tbl_employee_allowanceassignnontax WHERE name = $tax_id AND username = $employee";
        // echo $sql;
        $query = $this->db->query($sql);

        $query->next_result();
        $result = $query->result_array();
   
        if(empty($result)){
            return 0;
        }
        else{
            return $result[0]["val"];
        }
    }

    function GET_STD_NONTAX_DEDUCTION_LIST()                    //JERENZ: NO GET STD NONTAX DEDUCTION LIST FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT id,name,type FROM tbl_std_deductions_nontax WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_NONTAX_DEDUCTION_EMPL($tax_id,$employee){      //JERENZ: NO GET NONTAX DEDUCTION EMPL FOUND IN THE PAYROLLS CONTROLLER
        if($employee=='undefined'||!$employee){
            return false;
        }
        $sql = "SELECT value as val FROM tbl_employee_deductionassignnontax WHERE name = $tax_id AND username = $employee";
        $query = $this->db->query($sql);

        $query->next_result();
        $result = $query->result_array();
   
        if(empty($result)){
            return 0;
        }
        else{
            return $result[0]["val"];
        }
    }

    function GET_SPECIFIC_POSITION($id)
    {
        $sql = "SELECT name FROM tbl_std_positions WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_DEPT($id)                             //JERENZ: NO GET SPECIFIC DEPT FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT name FROM tbl_std_departments WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_SECT($id)                             //JERENZ: NO GET SPECIFIC SECT FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT name FROM tbl_std_sections WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_PAYSLIP($id, $cutoff)
    {
        $sql = "SELECT * FROM tbl_attendance_suminac WHERE user_id=? AND cut_off=? LIMIT 1";
        $query = $this->db->query($sql, array($id, $cutoff));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_PAY_SCHED_DATA($pay_schedule_id)          //JERENZ: NO GET SPECIFIC PAY SCHED DATA FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($pay_schedule_id));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_USED_LEAVE($empl_id, $start_date, $end_date)              //JERENZ: NO GET SPECIFIC USED LEAVE FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE empl_id=? AND create_date>=? AND create_date<=? AND status='Approved' ";
        $query = $this->db->query($sql, array($empl_id, $start_date, $end_date));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_PAID_LOAN_BASED_EMPL_AND_CUTOFF($cutoff_period, $empl_cmid)           //JERENZ: NO GET SPECIFIC PAID LOAN BASED EMPL AND CUTOFF FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_loan_payable WHERE cutoff_period=? AND empl_cmid=?";
        $query = $this->db->query($sql, array($cutoff_period, $empl_cmid));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIC_LOAN_SSS_BALANCE($empl_cmid)            //JERENZ: NO GET SPECIC LOAN SSS BALANCE FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_loan_payable WHERE (loan_type='SSS Salary Loan' OR loan_type='SSS Calamity Loan') AND empl_cmid=? AND status!='Paid'";
        $query = $this->db->query($sql, array($empl_cmid));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_LOAN_PAGIBIG_BALANCE($empl_cmid)      //JERENZ: NO GET SPECIFIC LOAN PAGIBIG BALANCE FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_loan_payable WHERE (loan_type='Pag-ibig Salary Loan' OR loan_type='Pag-ibig Calamity Loan') AND empl_cmid=? AND status!='Paid'";
        $query = $this->db->query($sql, array($empl_cmid));
        $query->next_result();
        return $query->result();
    }
    // 
    // Display PAY_SCHED
    function MOD_DISP_PAY_SCHED()
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE status='active' ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    // Add PAY_SCHED
    function MOD_INSRT_PAY_SCHED($date_range, $db_date_range, $payout_sched)
    {
        $sql = "INSERT INTO tbl_payroll_period (name,db_name,payout,status) VALUES (?,?,?,'active')";
        $query = $this->db->query($sql, array($date_range, $db_date_range, $payout_sched));
        return;
    }

    function MOD_DISP_OTHERTAXABLEINCOME()
    {
        return array();
        $sql = "SELECT * FROM tbl_payr_othe ORDER BY id";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }


    function MOD_DISP_NONTAXABLEINCOME()
    {
        return;
        $sql = "SELECT * FROM tbl_payr_nont ORDER BY id";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    function MOD_DISP_PAYROLL()
    {
        $sql = "SELECT * FROM tbl_payroll_payslips ";
        $query = $this->db->query($sql, array());
        $query->next_result();

        return $query->result();
    }

    function GET_PERIOD_CONNECTED($period)
    {
        if(empty($period)||$period=='undefined'){
            return [];
        }
        $sql = "SELECT connected_period,connected_period_2,connected_period_3,connected_period_4,connected_period_5 FROM tbl_payroll_period WHERE id = $period";
        $query = $this->db->query($sql, array());
        $query->next_result();

        return $query->result();
    }

    function GET_PERIOD_NAME($period)
    {
        if(!$period||$period=='undefined'){
            return false;
        }
        $sql = "SELECT name FROM tbl_payroll_period WHERE id = $period";
        $query = $this->db->query($sql, array());
        $result = $query->result_array();
        return $result[0]["name"];
    }

    function GET_PERIOD_YEAR($id)
    {
        // echo $id;
        if(empty($id)||$id=='undefined'){
            return false;
        }
        $sql = "SELECT year as years FROM tbl_payroll_period WHERE id = $id";
        $query = $this->db->query($sql, array());
        $result = $query->row();
        return $result;
    }
    function GET_PERIOD_FREQUENCY($id)
    {
        if(empty($id)||$id=='undefined'){
            return false;
        }
        $sql = "SELECT pay_frequency FROM tbl_payroll_period WHERE id = $id";
        $query = $this->db->query($sql, array());
        $result = $query->row();
        return $result;
        // return $result->pay_frequency;
    }
    // Display PAY_SCHED in Modal
    function MOD_GET_PAY_SCHED_DATA($pay_schedule_id)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($pay_schedule_id));
        $query->next_result();
        return $query->result();
    }
    // Update PAY_SCHED
    function MOD_UPDT_PAY_SCHED($updt_date_range, $updt_db_date_range, $updt_payout_sched, $UPDT_PAY_SCHED_INPF_ID)
    {
        $sql = "UPDATE tbl_payroll_period SET name=?,db_name=?,payout=? WHERE id=?";
        $query = $this->db->query($sql, array($updt_date_range, $updt_db_date_range, $updt_payout_sched, $UPDT_PAY_SCHED_INPF_ID));
    }
    // Delete PAY_SCHED
    function MOD_DLT_PAY_SCHED($pay_schedule_id)
    {
        $sql = "UPDATE tbl_payroll_period SET status='archive' WHERE id=?";
        $query = $this->db->query($sql, array($pay_schedule_id));
    }
    // funtion for empoyee
    function MOD_DISP_ALL_EMPLOYEES()
    {
        // $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        // $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY col_empl_cmid DESC";
        $sql = "SELECT * FROM tbl_employee_infos ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMP_BASED_ON_HIRE_DATE($startDate, $endDate)
    {
        $query = $this->db->select('*')->from('tbl_employee_infos')
            // ->where('DATE(col_hire_date) <', $endDate)
            // ->where('DATE(col_endd_date) =', "0000-00-00")
            ->where('DATE(termination_date) > ', $startDate)
            ->or_where('DATE(termination_date)', '0000-00-00')
            ->where("disabled =", 0)
            ->get();
        return $query->result();
    }
    // from p080_payroll_mod
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2($limitData)
    {

        $date = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";

        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ORDER BY empl_id + 0";

        $query = $this->db->query($sql, array($date));

        $query->next_result();

        return $query->result();
    }
    // Display payroll list

    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_COUNT()
    {

        $date = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";

        $sql = "SELECT PAYSLIP_PERIOD FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ?";

        $query = $this->db->query($sql, array($date));

        $query->next_result();

        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL()
    {

        $date = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";

        $sql = "SELECT SUM(NET_INCOME) as NET_INCOME FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ?";

        $query = $this->db->query($sql, array($date));

        $query->next_result();

        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT($date, $limitData)
    {

        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ORDER BY empl_id + 0";

        $query = $this->db->query($sql, array($date));

        $query->next_result();

        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_COUNT($date)
    {

        $sql = "SELECT PAYSLIP_PERIOD FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ";

        $query = $this->db->query($sql, array($date));

        $query->next_result();

        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL2($date)
    {

        $sql = "SELECT SUM(REPLACE(NET_INCOME, ',', '')) as NET_INCOME FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ?";

        $query = $this->db->query($sql, array($date));

        $query->next_result();

        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED($date, $limitData)
    {

        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ORDER BY empl_id + 0";

        $query = $this->db->query($sql, array($date));

        $query->next_result();

        return $query->result();
    }
    function MON_DISP_EMPL_NO_PAYSLIP()
    {

        $sql = "SELECT empl_id FROM (SELECT DISTINCT empl_id FROM tbl_payroll_payslips)result ORDER BY empl_id + 0";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    function MOD_DISP_DISTINCT_LOAN_PAYABLE()                   //JERENZ: NO MOD DISP DISTINCT LOAN PAYABLE FOUND IN THE PAYROLLS CONTROLLER
    {

        $sql = "SELECT DISTINCT loan_id FROM tbl_loan_payable ORDER BY id DESC";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    function MOD_DISP_LOAN_LIMIT_COUNT()                        //JERENZ: NO MOD DISP LOAN LIMIT COUNT FOUND IN THE PAYROLLS CONTROLLER
    {

        $sql = "SELECT DISTINCT loan_id FROM tbl_loan_payable ORDER BY id DESC";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    // from reimbursement model
    function MOD_DISP_ALL_REQUEST()                             //JERENZ: NO MOD DISP ALL REQUEST FOUND IN THE PAYROLLS CONTROLLER
    {

        $sql = "SELECT * FROM tbl_payroll_reimbursement ORDER BY id DESC LIMIT 10";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    function MOD_DISP_ALL_DATA_COUNT()                        //JERENZ: NO MOD DISP ALL DATA COUNT FOUND IN THE PAYROLLS CONTROLLER
    {

        $sql = "SELECT COUNT(id) as count FROM tbl_payroll_reimbursement";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    // from p164_department_mod
    function MOD_DISP_DISTINCT_DEPARTMENT()
    {

        // $sql = "SELECT DISTINCT col_empl_dept FROM tbl_employee_infos WHERE isSuperAdmin != 1";
        $sql = "SELECT DISTINCT col_empl_dept FROM tbl_employee_infos ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    // from 165_section_mod
    function MOD_DISP_DISTINCT_SECTION()
    {
        $sql = "SELECT DISTINCT col_empl_sect FROM tbl_employee_infos WHERE isSuperAdmin != 1";
        $sql = "SELECT DISTINCT col_empl_sect FROM tbl_employee_infos ";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }

    // from p180_sss_model
    function MOD_DISP_SSS()                                     //JERENZ: NO MOD DISP SSS FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_payroll_sss ORDER BY year DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // from p180_sss_model
    function GET_SSS_VALUE($income)
    {
        // if(!$income||!$year||$year=='undefined'||$income=='undefined'){
        //     return false;
        // }
        $sql = "SELECT * FROM tbl_payroll_sss WHERE salary_min <= $income AND salary_max > $income";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // from p180_sss_model
    function GET_PHILHEALTH_VALUE()
    {
        // if(!$year||$year=='undefined'){
        //     return false;
        // }
        $sql = "SELECT * FROM tbl_payroll_philhealth";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TAX_VALUE($income)
    {
        $sql = "SELECT * FROM tbl_payroll_tax WHERE salary_min <= $income AND salary_max > $income";
        $query = $this->db->query($sql);;
        return $query->row_array();
    }

    function MOD_DISP_DATA_COUNT()                  //JERENZ: NO MOD DISP DATA COUNT FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT COUNT(id) as anc_count FROM tbl_payroll_sss";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE()                           //JERENZ: NO MOD UNIQUE FOUND IN THE PAYROLLS CONTROLLER
    {

        $sql = "SELECT DISTINCT year FROM tbl_payroll_sss ORDER BY year DESC";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    // p181_philhealth_mod
    function MOD_DISP_PHILHEALTH()                  //JERENZ: NO MOD DISP PHILHEALTH FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_contribution_philhealth ORDER BY year DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DATA_COUNT_PHIL_HEALTH()      //JERENZ: NO MOD DISP DATA COUNT PHIL HEALTH FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT COUNT(id) as anc_count FROM tbl_contribution_philhealth";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE_PHIL_HEALTH()               //JERENZ: NO MOD UNIQUE PHIL HEALTH FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT DISTINCT year FROM tbl_contribution_philhealth ORDER BY year DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    // p182_hdmf_mod
    function MOD_DISP_HDMF()                        //JERENZ: NO MOD DISP HDMF FOUND IN THE PAYROLLS CONTROLLER
    {

        $sql = "SELECT * FROM tbl_payroll_hdmf ORDER BY year DESC LIMIT 20";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }
    function MOD_DISP_DATA_COUNT_HDMF()             //JERENZ: NO MOD DISP DATA COUNT HDMF FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT COUNT(id) as anc_count FROM tbl_payroll_hdmf";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE_HDMF()                     //JERENZ: NO MOD UNIQUE HDMF FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT DISTINCT year FROM tbl_payroll_hdmf ORDER BY year DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    // p183_witholdtax_mod
    function MOD_DISP_WTH_TAX()                     //JERENZ: NO MOD DISP WTH TAX FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT * FROM tbl_payroll_tax ORDER BY year DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DATA_COUNT_WITH_TAX()                 //JERENZ: NO MOD DISP DATA COUNT WITH TAX FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT COUNT(id) as anc_count FROM tbl_payroll_tax";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE_WITH_TAX()                      //JERENZ: NO MOD UNIQUE WITH TAX IN THE PAYROLLS CONTROLLER
    {
        $sql = "SELECT DISTINCT year FROM tbl_payroll_tax ORDER BY year DESC";
        $query = $this->db->query($sql, array());
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

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC, col_empl_cmid
        LIMIT ".$offset.", ".$row." ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_FILTERED_EMPLOYEE($branch,$dept,$division,$section,$group,$team,$line){
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
        ORDER BY col_empl_cmid ASC";

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function GET_SEARCHED_DATA($tab,$search,$table){
        $sql = "SELECT $table.*,col_empl_cmid,col_last_name,col_frst_name,col_midl_name FROM $table 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = $table.empl_id
        WHERE termination_date = '0000-00-00' AND disabled=0 AND $table.status=?
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR $table.id LIKE '%$search%'
        OR $table.loan_name LIKE '%$search%'
        OR $table.loan_date LIKE '%$search%'
        OR $table.loan_amount LIKE '%$search%'
        OR $table.loan_terms LIKE '%$search%'
        OR $table.status LIKE '%$search%') 
        ORDER BY $table.id ASC";
        $query = $this->db->query($sql,array($tab));
        $query->next_result();
        return $query->result();
    }


    function GET_SEARCHED($search){
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_YEARS()
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CUSTOM_CONTRIBUTION_TYPES(){                           //JERENZ: NO GET CUSTOM CONTRIBUTION TYPES FOUND IN THE PAYROLLS CONTROLLER
        $sql = "SELECT * FROM tbl_std_custom_contribution ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_EMPLOYEELIST(){
        $sql = "SELECT * FROM tbl_employee_infos ";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }

    function GET_CUSTOM_CONTRIBUTION_DATA($year){                      //JERENZ: NO GET CUSTOM CONTRIBUTION DATA FOUND IN THE PAYROLLS CONTROLLER
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_payroll_custom_contribution WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CUSTOM_SSS_CONTRIBUTION_DATA($year){
        $sql = "SELECT * FROM tbl_custom_sss_contribution WHERE year = $year GROUP BY employee_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CUSTOM_PAGIBIG_CONTRIBUTION_DATA($year){
        $sql = "SELECT * FROM tbl_custom_pagibig_contribution WHERE year = $year GROUP BY employee_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CUSTOM_PHILHEALTH_CONTRIBUTION_DATA($year){
        $sql = "SELECT * FROM tbl_custom_philhealth_contribution WHERE year = $year GROUP BY employee_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    

     // Display distinct department already being assigned to employees
     function MOD_DISP_DISTINCT_DEPARTMENT_2(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DIVISION_2(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

     // Display DISTINCT SECTION
     function MOD_DISP_DISTINCT_SECTION_2(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_BRANCH_2(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT Group
    function MOD_DISP_DISTINCT_GROUP_2(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_TEAM_2(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT line
    function MOD_DISP_DISTINCT_LINE_2(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_SYSTEM_SETTING($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
        
    }

    function IS_DUPLICATE_CUSTOM_CONTRIBUTION($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_payroll_custom_contribution WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function ADD_USER_CUSTOM_CONTRIBUTION($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_payroll_custom_contribution (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function UPDATE_USER_CUSTOM_CONTRIBUTION($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_payroll_custom_contribution SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }


    // Custom SSS Contribution
    function IS_DUPLICATE_CUSTOM_SSS_CONTRIBUTION($user_id,$year){
        $sql = "SELECT id FROM tbl_custom_sss_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql,array($user_id,$year));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function ADD_USER_CUSTOM_SSS_CONTRIBUTION($user_id,$val, $year){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_custom_sss_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$val, $year));
    }

    function UPDATE_USER_CUSTOM_SSS_CONTRIBUTION($user_id, $val, $year){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_custom_sss_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
        return $this->db->query($sql,array($edit_date,$val,$user_id,$year));
    }


    // Custom PAG-IBIG Contribution
    function IS_DUPLICATE_CUSTOM_PAGIBIG_CONTRIBUTION($user_id,$year){
        $sql = "SELECT id FROM  tbl_custom_pagibig_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql,array($user_id,$year));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function ADD_USER_CUSTOM_PAGIBIG_CONTRIBUTION($user_id,$val, $year){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO  tbl_custom_pagibig_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$val, $year));
    }

    function UPDATE_USER_CUSTOM_PAGIBIG_CONTRIBUTION($user_id, $val, $year){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE  tbl_custom_pagibig_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
        return $this->db->query($sql,array($edit_date,$val,$user_id,$year));
    }


    // Custom PhilHealth Contribution
    function IS_DUPLICATE_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id,$year){
        $sql = "SELECT id FROM tbl_custom_philhealth_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql,array($user_id,$year));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function ADD_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id,$val, $year){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO  tbl_custom_philhealth_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$val, $year));
    }

    function UPDATE_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id, $val, $year){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE  tbl_custom_philhealth_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
        return $this->db->query($sql,array($edit_date,$val,$user_id,$year));
    }


    function GET_ATTENDANCE_RECORD_LOCK($cutoff,$offset,$row){
        if($cutoff){
            $q_find = 'WHERE period = '.$cutoff;
        }else{
            $q_find = "";
        }
        
        $sql = "SELECT * FROM tbl_attendance_records_lock ".$q_find." ORDER BY id DESC LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql , array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_ATTENDANCE_RECORD($cutoff){
        if($cutoff){
            $q_find = 'WHERE period = '.$cutoff;
        }else{
            $q_find = "";
        }
        $sql = "SELECT * FROM tbl_attendance_records_lock ".$q_find." ORDER BY id DESC ";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }

    function GET_TOTAL_COUNT_ATTENDANCE_RECORD(){
        $sql = "SELECT * FROM tbl_attendance_records_lock ";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }

    function GET_PAYROLL_PAYSLIP($cutoff,$offset,$row){
        if($cutoff){
            $q_find = 'WHERE PAYSLIP_PERIOD = '.$cutoff;
        }else{
            $q_find = "";
        }
        
        $sql = "SELECT * FROM tbl_payroll_payslips ".$q_find." ORDER BY id DESC LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql , array());
        $query->next_result();
        return $query->result();
    }


    function GET_COUNT_PAYROLL_PAYSLIP($cutoff,$offset,$row){
        if($cutoff){
            $q_find = 'WHERE PAYSLIP_PERIOD = '.$cutoff;
        }else{
            $q_find = "";
        }
        $sql = "SELECT * FROM tbl_payroll_payslips ".$q_find." ORDER BY id DESC LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }




    function GET_CUTOFF()
    {
        $sql = "SELECT id,name FROM tbl_payroll_period ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    // Insert payroll data
    function MOD_INSRT_PAYROLL_DATA($data)
    {
        $this->db->insert("tbl_payroll_payslips", $data);
        return true;
       
    }
    

    function MOD_PAY_LOAN_PAYABLE($amount, $empl_cmid, $cutoff_period, $loan_type)                      //JERENZ: NO MOD PAY LOAN PAYABLE FOUND IN THE PAYROLLS CONTROLLER
    {
        $sql = "UPDATE tbl_loan_payable SET status='', amount_paid=? WHERE empl_cmid=? AND cutoff_period=? AND loan_type=?";
        $query = $this->db->query($sql, array($amount, $empl_cmid, $cutoff_period, $loan_type));
    }

    // Display all payroll data based on cutoff period
    function MOD_ALL_DISP_PAYROLL_DATA_PER_CUTOFF($payroll_id)
    {
        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($payroll_id));
        $query->next_result();
        return $query->result();
    }

 
     // get employee ready for payslip
     function MOD_GET_EMPL_READY_FOR_PAYSLIP($period_id)
     {
         $sql = "SELECT * FROM tbl_attendance_records_lock WHERE period=?";
         $query = $this->db->query($sql, array($period_id));
         $query->next_result();
         return $query->result();
     }

     function MON_DISP_ALL_EMPL_PAYROLL($payroll_id)
     {
         $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
         $query = $this->db->query($sql, array($payroll_id));
         $query->next_result();
         return $query->result();
     }

     function GET_DEDUCTION_TAX_DATA($year){                        //JERENZ: NO GET DEDUCTION TAX DATA FOUND IN THE PAYROLLS CONTROLLER
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function UPDATE_PAYROLL_ASSIGNMENT($user_id,$value){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_payroll_assignment SET edit_date=?, value=? WHERE empl_id=?";
        return $this->db->query($sql,array($edit_date,$value,$user_id));
    }

    function INSERT_PAYROLL_ASSIGNMENT($user_id, $value){
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_payroll_assignment (create_date,edit_date,empl_id,value) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($date, $date, $user_id, $value));
        return;
    }

    function GET_ALL_PAYROLL_ASSIGNMENT()
     {
         $sql = "SELECT * FROM tbl_payroll_assignment ";
         $query = $this->db->query($sql, array());
         $query->next_result();
         return $query->result();
     }


     function GET_SPECIFIC_PAYROLL_ASSIGNMENT($empl_id)
     {
         $sql = "SELECT * FROM tbl_payroll_assignment WHERE empl_id = ?";
         $query = $this->db->query($sql, array($empl_id));
         return $query->num_rows();
     }

    function GET_PAYROLL_LOAN_DATA($tab,$row,$offset){
        $sql = "SELECT *,tbl_payroll_loan.id as id FROM tbl_payroll_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_payroll_loan.empl_id
        WHERE termination_date = '0000-00-00' AND disabled=0 AND tbl_payroll_loan.status=? LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_PAYROLL_LOAN_DATA($tab){
        $sql = "SELECT *,tbl_payroll_loan.id as id FROM tbl_payroll_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_payroll_loan.empl_id
        WHERE termination_date = '0000-00-00' AND disabled=0 AND tbl_payroll_loan.status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }

    function GET_SEARCHED_LOAN_DATA($tab,$search){
        $sql = "SELECT tbl_payroll_loan.*,col_empl_cmid,col_last_name,col_frst_name,col_midl_name FROM tbl_payroll_loan
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_payroll_loan.empl_id
        WHERE termination_date = '0000-00-00' AND disabled=0 AND tbl_payroll_loan.status=?
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR tbl_payroll_loan.id LIKE '%$search%'
        OR tbl_payroll_loan.loan_name LIKE '%$search%'
        OR tbl_payroll_loan.loan_date LIKE '%$search%'
        OR tbl_payroll_loan.loan_amount LIKE '%$search%'
        OR tbl_payroll_loan.loan_terms LIKE '%$search%'
        OR tbl_payroll_loan.status LIKE '%$search%') 
        ORDER BY tbl_payroll_loan.id ASC";
        $query = $this->db->query($sql,array($tab));
        $query->next_result();
        return $query->result();
    }


    function GET_DATA($tab,$row,$offset,$table_name){
        $sql = "SELECT *,$table_name.id as id FROM $table_name 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = $table_name.empl_id
        WHERE termination_date = '0000-00-00' AND disabled=0 AND 
        status=? ORDER BY $table_name.id DESC  LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }

    function GET_DATA_COUNT($tab,$table_name){
        $sql = "SELECT * FROM $table_name 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = $table_name.empl_id
        WHERE termination_date = '0000-00-00' AND disabled=0 AND
        status=? ";
        $query = $this->db->query($sql, array($tab));
        // $query->next_result();
        return $query->num_rows();
    }
        function GET_PAYROLL_LOAN_DATA_COUNT($tab){
            $sql = "SELECT * FROM tbl_payroll_loan
            LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_payroll_loan.empl_id
            WHERE termination_date = '0000-00-00' AND disabled=0 AND status=? ";
            $query = $this->db->query($sql, array($tab));
            $query->next_result();
        return $query->result();
        }

    function GET_LOAN_TYPE_DATA(){
        $sql = "SELECT * FROM tbl_std_loantypes ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_LOAN_ID($id){
        $sql = "SELECT id FROM tbl_payroll_payslips WHERE LOAN_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }
    function GET_COUNT_CA_ID($id){
        $sql = "SELECT id FROM tbl_payroll_payslips WHERE CA_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }
    function GET_COUNT_DEDUCT_ID($id){
        $sql = "SELECT id FROM tbl_payroll_payslips WHERE DEDUCT_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }
    function GET_PAYROLL_LOAN_DATA_EMPL($user_id){
        if(empty($user_id)||$user_id==null){
            return [];
        }
        $sql = "SELECT * FROM tbl_payroll_loan WHERE empl_id = $user_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_PAYROLL_CA_DATA_EMPL($user_id){
        if(empty($user_id)||$user_id==null){
            return [];
        }
        $sql = "SELECT * FROM tbl_payroll_cashadvance WHERE empl_id = $user_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_PAYROLL_DEDUCT_DATA_EMPL($user_id){
        if(empty($user_id)||$user_id==null){
            return [];
        }
        $sql = "SELECT * FROM tbl_payroll_deductions WHERE empl_id = $user_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_PAY_SCHED_LATEST()
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE status='active' ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();

        $result = $query->result();

        // Check if there are any rows in the result
        if (!empty($result)) {
            $latestId = $result[0]->id; // Get the ID of the first row (which is the latest)
            return $latestId;
        } else {
            return null; // Return null if no rows are found
        }
    }



    function GET_EXPORT_PAYROLL_PAYSLIP($period){
        $response = array();
        $this->db->select('id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, PAYSLIP_SALARY_RATE, PAYSLIP_SALARY_TYPE, INITIAL_DAILY_RATE, INITIAL_HOURLY_RATE, PAYSLIP_PERIOD,
        TOT_PRESENT, TOT_ABSENT, TOT_TARDINESS, TOT_UNDERTIME, TOT_PAID_LEAVE, TOT_REG_HOURS, TOT_REG_OT, TOT_REG_ND, TOT_REG_NDOT, TOT_REST_HOURS, TOT_REST_OT, TOT_REST_ND,
        TOT_REST_NDOT, TOT_LEG_HOURS, TOT_LEG_OT, TOT_LEG_ND, TOT_LEG_NDOT, TOT_LEGREST_HOURS, TOT_LEGREST_OT, TOT_LEGREST_ND, TOT_LEGREST_NDOT, TOT_SPE_HOURS, TOT_SPE_OT,
        TOT_SPE_ND, TOT_SPE_NDOT, TOT_SPEREST_HOURS, TOT_SPEREST_OT, TOT_SPEREST_ND, TOT_SPEREST_NDOT, EARNINGS, DEDUCTIONS, WTAX, NET_INCOME, LOAN_ID, GROSS_INCOME, 
        SSS_EE_CURRENT, PAGIBIG_EE_CURRENT, PHILHEALTH_EE_CURRENT, SSS_ER_CURRENT, SSS_EC_ER_CURRENT, PAGIBIG_ER_CURRENT, PHILHEALTH_ER_CURRENT, CA_ID, DEDUCT_ID, 
        status, LOAN_LIST, CA_LIST, DEDUCT_LIST');
        $this->db->where('PAYSLIP_PERIOD', $period);
        $sql = $this->db->get('tbl_payroll_payslips');
        $response = $sql->result_array();
        return $response;
    }
   
    


}
