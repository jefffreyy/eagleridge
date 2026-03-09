<?php
class handsontable_model extends CI_Model
{

    function GET_ALL_EMPLOYEES()
    {
        $sql = "SELECT * FROM tbl_employee_infos  ORDER BY id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TABLEPLUS()
    {
        $sql = "SELECT col_empl_cmid,col_last_name,	col_midl_name, col_frst_name,col_mart_stat,col_home_addr,col_curr_addr,col_birt_date,col_empl_gend,
        col_empl_nati,col_shir_size,col_empl_emai,col_mobl_numb,col_hire_date,col_empl_type,col_empl_posi,col_empl_divi,col_empl_group,col_empl_line,
        col_empl_dept,col_empl_sect,col_imag_path,	col_empl_sssc,col_empl_hdmf,col_empl_phil,col_empl_btin,col_empl_driv,col_empl_naid,col_empl_pass,
        col_empl_hmoo,col_empl_hmon,salary_rate,salary_type 
        FROM tbl_tableplus  ORDER BY id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function is_duplicate($data_row){
        $sql = "SELECT col_empl_cmid FROM tbl_tableplus WHERE col_empl_cmid = ?";
        $query = $this->db->query($sql, $data_row[0]);
        return $query->num_rows();
    }

    function GET_SPECIFIC_POSITION($data_row)
    {
        $sql = "SELECT * FROM tbl_std_positions WHERE name = ?";
        $query = $this->db->query($sql, $data_row[16]);
        return $query->num_rows();
    }





    function insert_data($data){

        $C_BRANCH                   = $this->GET_BRANCHES();
        $C_SECTIONS                 = $this->GET_SECTIONS();
        $C_DEPARTMENTS              = $this->GET_DEPARTMENTS();
        $C_POSITIONS                = $this->GET_POSITION();
        $C_TYPE                     = $this->GET_TYPE();
        $C_SHIRT_SIZE               = $this->GET_SHIRT_SIZE();
        $C_GENDERS                  = $this->GET_GENDERS();
        $C_MARITAL                  = $this->GET_MARITAL();
        $C_NATIONALITY              = $this->GET_NATIONALITY();
        $C_GROUPS                   = $this->GET_GROUPS();
        $C_LINES                    = $this->GET_LINES();
        $C_DIVISIONS                = $this->GET_DIVISIONS();
        $C_HMOS                     = $this->GET_HMO();
        $C_USER_ACCESS              = $this->GET_USER_ACCESS();

        $data_1                         =  $this->convert_user_access_id($C_USER_ACCESS, $data[1]);
        $data_5                         =  $this->convert_name2id($C_MARITAL, $data[5]);
        $data_9                         =  $this->convert_name2id($C_GENDERS, $data[9]);
        $data_10                        =  $this->convert_name2id($C_NATIONALITY, $data[10]);
        $data_11                        =  $this->convert_name2id($C_SHIRT_SIZE, $data[11]);
        $data_15                        =  $this->convert_name2id($C_TYPE, $data[15]);
        $data_16                        =  $this->convert_name2id($C_POSITIONS, $data[16]);
        $data_17                        =  $this->convert_name2id($C_DIVISIONS, $data[17]);
        $data_18                        =  $this->convert_name2id($C_GROUPS, $data[18]);
        $data_19                        =  $this->convert_name2id($C_LINES, $data[19]);
        $data_20                        =  $this->convert_name2id($C_DEPARTMENTS, $data[20]);
        $data_21                        =  $this->convert_name2id($C_SECTIONS, $data[21]);
        $data_30                        =  $this->convert_name2id($C_HMOS, $data[30]);

        $current_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_tableplus (create_date, edit_date, col_empl_cmid, col_user_access, col_last_name, col_midl_name, col_frst_name, col_mart_stat, col_home_addr, col_curr_addr, col_birt_date, col_empl_gend, col_empl_nati, col_shir_size, col_empl_emai, col_mobl_numb, col_hire_date, col_empl_type, col_empl_posi, col_empl_divi, col_empl_group, col_empl_line, col_empl_dept, col_empl_sect, col_imag_path, col_empl_sssc, col_empl_hdmf, col_empl_phil, col_empl_btin, col_empl_driv, col_empl_naid, col_empl_pass, col_empl_hmoo, col_empl_hmon, salary_rate, salary_type) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $this->db->query($sql,array($current_date, $current_date, $data[0], $data_1, $data[2], $data[3], $data[4], $data_5, $data[6], $data[7], $data[8], $data_9, $data_10, $data_11, $data[12], $data[13], $data[14], $data_15, $data_16, $data_17, $data_18, $data_19, $data_20, $data_21, $data[22], $data[23], $data[24], $data[25], $data[26], $data[27], $data[28], $data[29], $data_30, $data[31], $data[32], $data[33]));
    }



    function update_data($data) {
        $C_BRANCH                   = $this->GET_BRANCHES();
        $C_SECTIONS                 = $this->GET_SECTIONS();
        $C_DEPARTMENTS              = $this->GET_DEPARTMENTS();
        $C_POSITIONS                = $this->GET_POSITION();
        $C_TYPE                     = $this->GET_TYPE();
        $C_SHIRT_SIZE               = $this->GET_SHIRT_SIZE();
        $C_GENDERS                  = $this->GET_GENDERS();
        $C_MARITAL                  = $this->GET_MARITAL();
        $C_NATIONALITY              = $this->GET_NATIONALITY();
        $C_GROUPS                   = $this->GET_GROUPS();
        $C_LINES                    = $this->GET_LINES();
        $C_DIVISIONS                = $this->GET_DIVISIONS();
        $C_HMOS                     = $this->GET_HMO();

        $data_4                         =  $this->convert_name2id($C_MARITAL, $data[4]);
        $data_8                         =  $this->convert_name2id($C_GENDERS, $data[8]);
        $data_9                        =  $this->convert_name2id($C_NATIONALITY, $data[9]);
        $data_10                        =  $this->convert_name2id($C_SHIRT_SIZE, $data[10]);
        $data_14                        =  $this->convert_name2id($C_TYPE, $data[14]);
        $data_15                        =  $this->convert_name2id($C_POSITIONS, $data[15]);
        $data_16                        =  $this->convert_name2id($C_DIVISIONS, $data[16]);
        $data_17                        =  $this->convert_name2id($C_GROUPS, $data[17]);
        $data_18                        =  $this->convert_name2id($C_LINES, $data[18]);
        $data_19                        =  $this->convert_name2id($C_DEPARTMENTS, $data[19]);
        $data_20                        =  $this->convert_name2id($C_SECTIONS, $data[20]);
        $data_29                        =  $this->convert_name2id($C_HMOS, $data[29]);

        $sql = " UPDATE tbl_tableplus SET col_last_name=?, col_midl_name=?, col_frst_name=?, col_mart_stat=?, col_home_addr=?, col_curr_addr=?, col_birt_date=?, col_empl_gend=?, col_empl_nati=?, col_shir_size=?, 
        col_empl_emai=?, col_mobl_numb=?, col_hire_date=?, col_empl_type=?, col_empl_posi=?, col_empl_divi=?, col_empl_group=?, col_empl_line=?, col_empl_dept=?, col_empl_sect=?, col_imag_path=?, col_empl_sssc=?, 
        col_empl_hdmf=?, col_empl_phil=?, col_empl_btin=?, col_empl_driv=?, col_empl_naid=?, col_empl_pass=?, col_empl_hmoo=?, col_empl_hmon=?, salary_rate=?, salary_type=? 
        WHERE col_empl_cmid=?";
        $this->db->query($sql,array($data[1],$data[2],$data[3],$data_4,$data[5],$data[6],$data[7],$data_8,$data_9,$data_10,$data[11],$data[12],$data[13],$data_14,$data_15,$data_16,$data_17,$data_18,$data_19,$data_20,$data[21],$data[22],$data[23],$data[24],$data[25],$data[26],$data[27],$data[28],$data_29,$data[30],$data[31],$data[32],$data[0]));
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
    
    function convert_user_access_id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $userAccessLower = strtolower($e->user_access);
            if ($userAccessLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
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

    function GET_USER_ACCESS()
    {
        $sql = "SELECT id,user_access FROM tbl_system_useraccess";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


}