<?php
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class reports extends CI_Controller
{
    private $period;
    private $limit;
    private $page;
    private $offset;
    private $date_period;
    private $date_from;
    private $date_to;
    function __construct()
    {
        parent::__construct();
        $this->load->model('templates/main_nav_model');
        $this->load->model('modules/reports_model');
        $this->load->library('system_functions');

        // auto login starts
        $this->load->model('admin_model');
        $auto_login = $this->admin_model->get_system_setup_by_setting2('auto_login', '0');
        if ($auto_login == '1' && empty($this->session->userdata('SESS_USER_ID'))) {
            $this->session->set_userdata('SESS_USER_ID', 1);
        }
        // auto login ends

        if ($this->session->userdata('SESS_USER_ID') == '') {
            redirect('login/session_expired');
        }
        $maintenance                         = $this->login_model->GET_MAINTENANCE();
        $isAdmin                             = $this->session->userdata('SESS_ADMIN');
        if ($maintenance == '1' && $isAdmin != 1) {
            redirect('login/maintenance');
        }
        $this->period                        = $this->input->get('period');
        $this->limit                         = $this->input->get('row') ? $this->input->get('row')  : 25;
        $this->page                          = $this->input->get('page') ? $this->input->get('page') : 1;
        $this->offset                        =  $this->limit * ($this->page - 1);
        $this->date_period                   = $this->input->get('date');
        $this->date_from                     = $this->input->get('date_from');
        $this->date_to                      = $this->input->get('date_to');
    }

    function index()
    {
        $data["Modules"]  =  array(
            array("title" => "Employee Information Reports", "info" => "Comprehensive documents that summarizing key details about individuals within an organization, encompassing personal and professional data.", "value" => "Employee Information Reports", "icon" => "chart-line-up-down-duotone.svg", "url" => "reports/employee_informations",  "access" => "Reports",   "id" => "employee_informations"),
            array("title" => "Employee Record Reports", "info" => "Comprehensive documents that summarizing key details about individuals within an organization, encompassing personal and professional data.", "value" => "Employee Record Reports", "icon" => "chart-line-up-down-duotone.svg", "url" => "reports/employee_records",  "access" => "Reports",   "id" => "employee_records"),
            array("title" => "Timekeeping/Attendance Reports",  "info" => "Summaries of employees working hours, providing crucial insights into attendance patterns, facilitating payroll processing, and aiding in workforce management.",    "value" => "Timekeeping/Attendance Reports",      "icon" => "file-chart-column-duotone.svg", "url" => "reports/attendances",     "access" => "Reports",  "id" => "attendance_reports"),
            array("title" => "Payroll Reports",   "info" => "Creating and producing documents summarizing various aspects of HR data, enabling effective analysis, decision-making, and communication within an organization.",   "value" => "Report Generation",      "icon" => "file-chart-column-duotone.svg", "url" => "reports/payslip_generations",     "access" => "Report Generation",  "id" => "payslip_generations"),
            array("title" => "Government Remittance Forms",   "info" => "Report and submit mandatory contributions, such as taxes and social security payments, to government agencies, ensuring compliance with legal and regulatory requirements.",   "value" => "Government Remittance Forms",      "icon" => "file-chart-column-duotone.svg", "url" => "reports/goverment_forms",     "access" => "Government Remittance Forms",  "id" => "goverment_forms"),
            );
        $data["title_page"]                   = "Reports";
        $data["title_description"]            = "An audit trail of report generation activities for accountability and transparency.";
        $user_access_id                       = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
        $data['DISP_USER_ACCESS_PAGE']        = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
        $array_page                           = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
        $data["maiya_theme"]                        = $this->reports_model->GET_MAYA_THEME();
        $data['Modules']                      = filter_array($data["Modules"], $array_page);
        $this->load->view('templates/header');
        $this->load->view('templates/main_container', $data);
    }
    function employee_informations(){
        $this->load->view('templates/header');
        $this->load->view('modules/reports/employee_information_views');
    }
    function employee_records(){
        $this->load->view('templates/header');
        $this->load->view('modules/reports/employee_record_views');
    }
    function attendances(){
        $this->load->view('templates/header');
        $this->load->view('modules/reports/report_attendance_views');
    }
    function payslip_generations(){
        $this->load->view('templates/header');
        $this->load->view('modules/reports/payslip_generation_views');
    }
    function goverment_forms(){
        $this->load->view('templates/header');
        $this->load->view('modules/reports/goverment_form_views');
    }
    function leaves()
    {
        $search_data = $this->input->get('search');
        $period                             = $this->input->get('period');
        $cutoff_periods                     = $this->reports_model->GET_CUT_OFF_LIST();

        if ($cutoff_periods && !$period) {
            $period_id = $cutoff_periods[0]->id;
        }
        if ($period) {
            $period_id = $period;
        }

        $data['LEAVES']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }

        if ($period) {
            $cutoff_periods_date                  = $this->reports_model->GET_CUT_OFF($period);
            $this->date_from  = $cutoff_periods_date->date_from;
            $this->date_to    = $cutoff_periods_date->date_to;
        }

        if ($search_data) {
            $leaves = $this->reports_model->GET_LEAVES_SEARCH($this->date_from, $this->date_to, $search_data);
        } else {
            $leaves = $this->reports_model->GET_LEAVES($this->date_from, $this->date_to);
        }
       
        if( $leaves){
            foreach ($leaves as  $time) {
                if (!empty($time->leave_date)) {
                    $timestamp = strtotime($time->leave_date);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $time->newdate = $formattedDate;
                }
            }
        }
        $data['LEAVES']          = $leaves;
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');

        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['period_param']       = $period;
        $data['EMPLOYEES']          = $this->reports_model->GET_EMPLOYEES_ALL();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/leave_report_views', $data);
    }
    function export_tardiness()
{
    $start_date = $this->input->get('start_date');
    $end_date   = $this->input->get('end_date');
    $employee_id = $this->input->get('employee_id'); // optional filter

    if (strpos($start_date, '/') !== false) {
    $parts = explode('/', $start_date);
    $start_date = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
    }

    if (strpos($end_date, '/') !== false) {
    $parts = explode('/', $end_date);
    $end_date = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
    }
    
    if ($employee_id){
        $records = $this->reports_model->GET_TARDINESS_SEARCH($start_date, $end_date, $employee_id);
    } else {
        $records = $this->reports_model->GET_TARDINESS($start_date, $end_date);
    }
    
   

    if (empty($records)) {
        echo "No data available for this range.";
        return;
    }

    // --- Compute lateness per record and totals per employee ---
    $grouped = [];
    $currentName = '';
    $totalMinutes = 0;

    foreach ($records as $i => $row) {
        $start = !empty($row->time_regular_start) ? strtotime($row->time_regular_start) : null;
        $actual = !empty($row->time_in) ? strtotime($row->time_in) : null;
        $diffMinutes = 0;

        if ($start && $actual && $actual > $start) {
            $diffMinutes = round(($actual - $start) / 60);
        }

        $row->late_duration = $diffMinutes;

        // Detect new employee group
        if ($currentName !== $row->fullname) {
            // Push previous total row
            if ($currentName !== '') {
                $total = new stdClass();
                $total->id = '';
                $total->newdate = '';
                $total->col_empl_cmid = '';
                $total->fullname = $currentName . ' TOTAL';
                $total->time_regular_start = '';
                $total->time_in = '';
                $total->late_duration = $totalMinutes;
                $grouped[] = $total;
            }
            $currentName = $row->fullname;
            $totalMinutes = 0;
        }

        $grouped[] = $row;
        $totalMinutes += $diffMinutes;

        // Add final total row
        if ($i === array_key_last($records)) {
            $total = new stdClass();
            $total->id = '';
            $total->newdate = '';
            $total->col_empl_cmid = '';
            $total->fullname = $currentName . ' TOTAL';
            $total->time_regular_start = '';
            $total->time_in = '';
            $total->late_duration = $totalMinutes;
            $grouped[] = $total;
        }
    }

    // ✅ Create Spreadsheet
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Tardiness Report');

    // Headers
    $headers = ['ID', 'Date', 'Employee ID', 'Employee Name', 'Shift Time In', 'Time In', 'Late Duration (mins)'];
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $sheet->getStyle($col . '1')->getFont()->setBold(true);
        $sheet->getColumnDimension($col)->setAutoSize(true);
        $col++;
    }

    // --- Fill data rows ---
    $rowNumber = 2;
    foreach ($grouped as $row) {
        $sheet->setCellValue('A' . $rowNumber, $row->id);
        $sheet->setCellValue('B' . $rowNumber, $row->newdate);
        $sheet->setCellValue('C' . $rowNumber, $row->col_empl_cmid);
        $sheet->setCellValue('D' . $rowNumber, $row->fullname);
        $sheet->setCellValue('E' . $rowNumber, $row->time_regular_start);
        $sheet->setCellValue('F' . $rowNumber, $row->time_in);
        $sheet->setCellValue('G' . $rowNumber, $row->late_duration);

        // --- Highlight TOTAL rows ---
        if (strpos($row->fullname, 'TOTAL') !== false) {
            $sheet->getStyle("A{$rowNumber}:G{$rowNumber}")->getFont()->setBold(true);
            $sheet->getStyle("A{$rowNumber}:G{$rowNumber}")->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFF5F5F5');
        }

        // --- Highlight red for >= 55 mins late ---
        if ($row->late_duration >= 55) {
            $sheet->getStyle("A{$rowNumber}:G{$rowNumber}")
              ->getFont()->getColor()->setARGB('FFFF0000');
        }

        $rowNumber++;
    }
    if (ob_get_length()) ob_end_clean();
    // ✅ Output Excel
    $filename = "Tardiness_Report_{$start_date}_to_{$end_date}.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=\"{$filename}\"");
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

    function get_leave_data()
    {
        $data['LEAVES']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['LEAVES']             = $this->reports_model->GET_LEAVES($this->date_from, $this->date_to);
        echo json_encode($data['LEAVES']);
    }

     function tardiness()
    {
        $search_data = $this->input->get('search');
        $period                             = $this->input->get('period');
        $cutoff_periods                     = $this->reports_model->GET_CUT_OFF_LIST();

        if ($cutoff_periods && !$period) {
            $period_id = $cutoff_periods[0]->id;
        }
        if ($period) {
            $period_id = $period;
        }

        $data['TARDINESS']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));

        if (!$this->date_from || !$this->date_to) {
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }

        if ($period) {
            $cutoff_periods_date                  = $this->reports_model->GET_CUT_OFF($period);
            $this->date_from  = $cutoff_periods_date->date_from;
            $this->date_to    = $cutoff_periods_date->date_to;
        }

        if ($search_data) {
            $tardiness        = $this->reports_model->GET_TARDINESS_SEARCH($this->date_from, $this->date_to, $search_data);
        } else {
            $tardiness        = $this->reports_model->GET_TARDINESS($this->date_from, $this->date_to);
        }

        if ($tardiness) {
            foreach ($tardiness as  $time) {
                if (!empty($time->date)) {
                    $timestamp = strtotime($time->date);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $time->newdate = $formattedDate;
                }
            }
        }

        $data['TARDINESS']          = $tardiness;
        $data['START_DATE']         = date_format(date_create($this->date_from), 'd/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to), 'd/m/Y');

        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['period_param']       = $period;
        $data['EMPLOYEES']          = $this->reports_model->GET_EMPLOYEES_ALL();

        $this->load->view('templates/header');
        $this->load->view('modules/reports/tardiness_report_views', $data);
    }

    function get_tardiness_data()
    {
        $data['TARDINESS']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['TARDINESS']         = $this->reports_model->GET_TARDINESS($this->date_from, $this->date_to);
        echo json_encode($data['TARDINESS']);
    }

    function undertime()
    {
        $search_data = $this->input->get('search');
        $period                             = $this->input->get('period');
        $cutoff_periods                     = $this->reports_model->GET_CUT_OFF_LIST();

        if ($cutoff_periods && !$period) {
            $period_id = $cutoff_periods[0]->id;
        }
        if ($period) {
            $period_id = $period;
        }


        $data['UNDERTIME']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));

        if (!$this->date_from || !$this->date_to) {
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }

        if ($period) {
            $cutoff_periods_date                  = $this->reports_model->GET_CUT_OFF($period);
            $this->date_from  = $cutoff_periods_date->date_from;
            $this->date_to    = $cutoff_periods_date->date_to;
        }

        if ($search_data) {
            $undertime              = $this->reports_model->GET_UNDERTIME_SEARCH($this->date_from, $this->date_to, $search_data);
        } else {
            $undertime              = $this->reports_model->GET_UNDERTIME($this->date_from, $this->date_to);
        }

        if ($undertime) {
            foreach ($undertime as  $time) {
                if (!empty($time->date)) {
                    $timestamp = strtotime($time->date);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $time->newdate = $formattedDate;
                }
            }
        }

        $data['UNDERTIME']          = $undertime;
        $data['START_DATE']         = date_format(date_create($this->date_from), 'd/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to), 'd/m/Y');

        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['period_param']       = $period;
        $data['EMPLOYEES']          = $this->reports_model->GET_EMPLOYEES_ALL();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/undertime_report_views', $data);
    }

    function get_undertime_data()
    {
        $data['UNDERTIME']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['UNDERTIME']          = $this->reports_model->GET_UNDERTIME($this->date_from, $this->date_to);
        echo json_encode($data['UNDERTIME']);
    }

    function new_employees()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $employees = $this->reports_model->GET_NEW_EMPLOYEES($this->date_from, $this->date_to);
        
        if( $employees){
            foreach ($employees as  $employee) {
                if (!empty($employee->col_hire_date)) {
                    $employee->formatted_date = date("d/m/Y", strtotime($employee->col_hire_date));
                }
            }
        }

        $data['START_DATE']         = date_format(date_create($this->date_from),'m/d/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'m/d/Y');
        $this->load->view('templates/header');
        $this->load->view('modules/reports/new_employee_report_views', $data);
    }

    function get_new_employees_data()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_NEW_EMPLOYEES($this->date_from, $this->date_to);
        echo json_encode($data['EMPLOYEES']);
    }

    function probationary_employees()
    {
 
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $employees = $this->reports_model->GET_PROBI_EMPLOYEES($this->date_from, $this->date_to);
        if( $employees){
            foreach ($employees as  $employee) {
                if (!empty($employee->log_date)) {
                    $employee->formatted_date = date("d/m/Y", strtotime($employee->log_date));
                }
            }
        }

        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');

        $this->load->view('templates/header');
        $this->load->view('modules/reports/probationary_employee_report_views', $data);
    }

    function get_probi_employees_data()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_PROBI_EMPLOYEES($this->date_from, $this->date_to);

        echo json_encode($data['EMPLOYEES']);
    }

    function contractual_employees()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $employees = $this->reports_model->GET_CONTRACTUAL_EMPLOYEES($this->date_from, $this->date_to);
        
        if( $employees){
            foreach ($employees as  $employee) {
                if (!empty($employee->log_date)) {
                    $employee->formatted_date = date("d/m/Y", strtotime($employee->log_date));
                }
            }
        }
   
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        $this->load->view('templates/header');
        $this->load->view('modules/reports/contractual_employee_report_views', $data);
    }

    function get_contractual_data()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_CONTRACTUAL_EMPLOYEES($this->date_from, $this->date_to);
        echo json_encode($data['EMPLOYEES']);
    }

    function resigned_employees()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $employees = $this->reports_model->GET_RESIGNED_EMPLOYEES($this->date_from, $this->date_to);
        
        if( $employees){
            foreach ($employees as  $employee) {
                if (!empty($employee->termination_date)) {
                    $employee->formatted_date = date("d/m/Y", strtotime($employee->termination_date));
                }
            }
        }

        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        $this->load->view('templates/header');
        $this->load->view('modules/reports/resigned_employee_report_views', $data);
    }

    function get_resigned_employees_data()
    {
        $data['CUTOFF_PERIODS']     = $this->reports_model->GET_CUT_OFF_LIST();
        $data['EMPLOYESS']          = array();
        $period                     = $this->input->get('period');
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     =  $limit * ($page - 1);
        $date_period                = $this->input->get('date');
        $data['PERIOD']             = $period;
        if (count($data['CUTOFF_PERIODS']) > 0 && !$period) {
            $date                   = $data['CUTOFF_PERIODS'][0];
            $data['EMPLOYEES']      = $this->reports_model->GET_RESIGNED_EMPLOYEES($date->date_from, $date->date_to, $limit, $offset, $date_period);
        }
        if ($period) {
            $date                   = $this->reports_model->GET_CUT_OFF($period);
            if ($date) {
                $data['EMPLOYEES']  = $this->reports_model->GET_RESIGNED_EMPLOYEES($date->date_from, $date->date_to, $limit, $offset, $date_period);
            }
        }
        echo json_encode($data['EMPLOYEES']);
    }

    function overtimes()
    {
        $search_data = $this->input->get('search');
        $period                             = $this->input->get('period');
        $cutoff_periods                     = $this->reports_model->GET_CUT_OFF_LIST();

        if ($cutoff_periods && !$period) {
            $period_id = $cutoff_periods[0]->id;
        }
        if ($period) {
            $period_id = $period;
        }

        $data['OVERTIMES']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }

         if ($period) {
            $cutoff_periods_date                  = $this->reports_model->GET_CUT_OFF($period);
            $this->date_from  = $cutoff_periods_date->date_from;
            $this->date_to    = $cutoff_periods_date->date_to;
        }

        if ($search_data) {
            $overtimes = $this->reports_model->GET_OVERTIME_SEARCH($this->date_from, $this->date_to, $search_data);
        } else {
            $overtimes          = $this->reports_model->GET_OVERTIME($this->date_from, $this->date_to);
        }

        if( $overtimes){
            foreach ($overtimes as  $time) {
                if (!empty($time->date_adjustment)) {
                    $timestamp = strtotime($time->date_adjustment);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $time->newdate = $formattedDate;
                }
            }
        }
        $data['OVERTIMES']          = $overtimes;
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        
        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['period_param']       = $period;
        $data['EMPLOYEES']          = $this->reports_model->GET_EMPLOYEES_ALL();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/overtime_report_views', $data);
    }

    function get_overtime_data()
    {
        $data['OVERTIMES']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['OVERTIMES']          = $this->reports_model->GET_OVERTIME($this->date_from, $this->date_to);
        echo json_encode($data['OVERTIMES']);
    }

    function time_adjustments()
    {
        $search_data = $this->input->get('search');
        $period                             = $this->input->get('period');
        $cutoff_periods                     = $this->reports_model->GET_CUT_OFF_LIST();

        if ($cutoff_periods && !$period) {
            $period_id = $cutoff_periods[0]->id;
        }
        if ($period) {
            $period_id = $period;
        }

        $data['TIME_ADJS']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }

        if ($period) {
            $cutoff_periods_date                  = $this->reports_model->GET_CUT_OFF($period);
            $this->date_from  = $cutoff_periods_date->date_from;
            $this->date_to    = $cutoff_periods_date->date_to;
        }

        if ($search_data) {
            $time_adjs     = $this->reports_model->GET_TIME_ADJS_SEARCH($this->date_from, $this->date_to, $search_data);
        } else {
            $time_adjs               = $this->reports_model->GET_TIME_ADJS($this->date_from, $this->date_to);
        }
        
        
        if( $time_adjs){
            foreach ($time_adjs as  $time) {
                if (!empty($time->date_adjustment)) {
                    $timestamp = strtotime($time->date_adjustment);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $time->newdate = $formattedDate;
                }
            }
        }
        $data['TIME_ADJS']          = $time_adjs;
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        
        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['period_param']       = $period;
        $data['EMPLOYEES']          = $this->reports_model->GET_EMPLOYEES_ALL();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/time_adjustments_report_views', $data);
    }

    function get_time_adjustments_data()
    {
        $data['TIME_ADJS']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['TIME_ADJS']          = $this->reports_model->GET_TIME_ADJS($this->date_from, $this->date_to);
        echo json_encode($data['TIME_ADJS']);
    }

    function holiday_works()
    {
        $search_data = $this->input->get('search');
        $period                             = $this->input->get('period');
        $cutoff_periods                     = $this->reports_model->GET_CUT_OFF_LIST();

        if ($cutoff_periods && !$period) {
            $period_id = $cutoff_periods[0]->id;
        }
        if ($period) {
            $period_id = $period;
        }

        $data['HOLI_WORKS']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }

        if ($period) {
            $cutoff_periods_date                  = $this->reports_model->GET_CUT_OFF($period);
            $this->date_from  = $cutoff_periods_date->date_from;
            $this->date_to    = $cutoff_periods_date->date_to;
        }

        if ($search_data) {
             $holiday_work           = $this->reports_model->GET_HOLI_WORKS_SEARCH($this->date_from, $this->date_to, $search_data);
        
        } else {
             $holiday_work           = $this->reports_model->GET_HOLI_WORKS($this->date_from, $this->date_to);
        
        }
       
        if( $holiday_work){
            foreach ($holiday_work as  $time) {
                if (!empty($time->date)) {
                    $timestamp = strtotime($time->date);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $time->newdate = $formattedDate;
                }
            }
        }

        $data['HOLI_WORKS']          = $holiday_work;
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        
        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['period_param']       = $period;
        $data['EMPLOYEES']          = $this->reports_model->GET_EMPLOYEES_ALL();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/holiday_works_report_views', $data);
    }

    function get_holi_works_data()
    {
        $data['HOLI_WORKS']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['HOLI_WORKS']         = $this->reports_model->GET_HOLI_WORKS($this->date_from, $this->date_to);
        echo json_encode($data['HOLI_WORKS']);
    }
    function bir_2316(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months;
        $userId                                          = $this->session->userdata('SESS_USER_ID');
        $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                                          =  $limit * ($page - 1);
        $data['EMPLOYEES']                               = $this->reports_model->GET_EMPLOYEE_LISTS($limit, $offset);
        $total_count                                     = $this->reports_model->GET_EMPLOYEE_LISTS_COUNT();
        $excess                                          = $total_count % $limit;
        $data['C_DATA_COUNT']                            = $total_count;
        $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']                                    = $page;
        $data['ROW']                                     = $limit;
        $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
        // echo '<pre>';
        // var_dump($months);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/reports/bir2316_form_views', $data);
    }
    function active_employees()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_ACTIVE_EMPLOYEES($this->date_from, $this->date_to);
        $total_count                = count($data['EMPLOYEES']);
        $data['START_DATE']         = date_format(date_create($this->date_from),'m/d/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'m/d/Y');

        $this->load->view('templates/header');
        $this->load->view('modules/reports/active_employees_report_views', $data);
    }

    function get_active_employees_data()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_ACTIVE_EMPLOYEES($this->date_from, $this->date_to);
        // echo '<pre>';
        // var_dump($data['EMPLOYEES']);
        echo json_encode($data['EMPLOYEES']);
    }

    function sliders()
    {
        $selectedCustomGroups = $this->input->get('custom_groups');
        $data['selectedCustomGroups'] = $selectedCustomGroups;
        $data['customGroups']       = $this->reports_model->getCustomGroupActive();
        $data['isCustomGroupEnabled'] = $this->reports_model->isUserPageFound(' Custom Group Assignment',$this->session->userdata('SESS_USER_ID'));

        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $employees            = $this->reports_model->GET_SLIDERS($this->date_from, $this->date_to);

        if( $employees){
            foreach ($employees as  $employee) {
                if (!empty($employee->date)) {
                    $timestamp = strtotime($employee->date);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $employee->newdate = $formattedDate;
                }
            }
        }

        $data['EMPLOYEES']          = $employees;

        $total_count                = count($data['EMPLOYEES']);
        $data['START_DATE']         = date_format(date_create($this->date_from),'m/d/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'m/d/Y');

        $this->load->view('templates/header');
        $this->load->view('modules/reports/slider_report_views', $data);
    }

    function get_slider_data()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_SLIDERS($this->date_from, $this->date_to);
        echo json_encode($data['EMPLOYEES']);
    }

    function awol()
    {
        // $data['CUTOFF_PERIODS']     = $this->reports_model->GET_CUT_OFF_LIST();
        // $data['LEAVES']             = array();
        // $period                     = $this->input->get('period');
        // $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        // $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        // $offset                     =  $limit * ($page - 1);
        // $date_period                = $this->input->get('date');
        // $data['PERIOD']             = $period;
        // if ($date_period) {
        //     $data['PERIOD']         = $date_period;
        // }
        // if (count($data['CUTOFF_PERIODS']) > 0 && !$period) {
        //     $date                   = $data['CUTOFF_PERIODS'][0];
        //     $data['EMPLOYEES']      = $this->reports_model->GET_AWOL_EMP($date->date_from, $date->date_to, $limit, $offset, $date_period);
        // }
        // if ($period) {
        //     $date                   = $this->reports_model->GET_CUT_OFF($period);
        //     if ($date) {
        //         $data['EMPLOYEES']  = $this->reports_model->GET_AWOL_EMP($date->date_from, $date->date_to, $limit, $offset, $date_period);
        //     }
        // }

        // $total_count                = $this->reports_model->GET_AWOL_EMP_COUNT($date->date_from, $date->date_to, $date_period);
        // $excess                     = $total_count % $limit;
        // $data['C_DATA_COUNT']       = $total_count;
        // $data['PAGES_COUNT']        = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        // $data['PAGE']               = $page;
        // $data['ROW']                = $limit;
        // $data['C_ROW_DISPLAY']      = array(10, 25, 50);
        // $data['sub_url']            = 'period';
        // if ($date_period) {
        //     $data['sub_url']        = 'date';
        // }

        $selectedCustomGroups = $this->input->get('custom_groups');
        $data['selectedCustomGroups'] = $selectedCustomGroups;
        // echo '<pre>';
        // print_r($selectedCustomGroups );

        $data['EMPLOYEES']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $employees = $this->reports_model->GET_AWOL_EMP($this->date_from, $this->date_to,$selectedCustomGroups);


        if( $employees){
            foreach ($employees as  $employee) {
                if (!empty($employee->date)) {
                    $timestamp = strtotime($employee->date);
                    $formattedDate = date("d/m/Y", $timestamp);
                    $employee->newdate = $formattedDate;
                }
            }
        }

        $data['EMPLOYEES']          = $employees;

        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        $data['customGroups']       = $this->reports_model->getCustomGroupActive();
        $data['isCustomGroupEnabled'] = $this->reports_model->isUserPageFound(' Custom Group Assignment',$this->session->userdata('SESS_USER_ID'));
        // echo '<pre>';
        // print_r(array('isCustomGroupEnabled'=>$data['isCustomGroupEnabled'], 'from'=>$this->date_from, 'to'=>$this->date_to) );
        // die();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/awol_report_views', $data);
    }

    function get_awol_data()
    {
        $data['EMPLOYEES']          = array();
        // Get the current date
        $currentDate        = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth   = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth    = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_AWOL_EMP($this->date_from, $this->date_to);
        echo json_encode($data['EMPLOYEES']);
    }

    function promoted_employees()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $employees          = $this->reports_model->GET_PROMOTED_EMP($this->date_from, $this->date_to);

        if( $employees){
            foreach ($employees as  $employee) {
                if (!empty($employee->log_date)) {
                    $employee->formatted_date = date("d/m/Y", strtotime($employee->log_date));
                }
            }
        }

        $data['EMPLOYEES']          = $employees;
        $total_count                = count($data['EMPLOYEES']);
        $data['START_DATE']         = date_format(date_create($this->date_from),'m/d/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'m/d/Y');
        $this->load->view('templates/header');
        $this->load->view('modules/reports/promoted_employee_report_views', $data);
    }

    function get_promoted_data()
    {
        $data['EMPLOYESS']          = array();
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        $data['EMPLOYEES']          = $this->reports_model->GET_PROMOTED_EMP($this->date_from, $this->date_to);
        echo json_encode($data['EMPLOYEES']);
    }
    function bir_1601_c(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months;
        $userId                                          = $this->session->userdata('SESS_USER_ID');
        $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                                          =  $limit * ($page - 1);
        $data['EMPLOYEES']                               = $this->reports_model->GET_EMPLOYEE_LISTS($limit, $offset);
        $total_count                                     = $this->reports_model->GET_EMPLOYEE_LISTS_COUNT();
        $excess                                          = $total_count % $limit;
        $data['C_DATA_COUNT']                            = $total_count;
        $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']                                    = $page;
        $data['ROW']                                     = $limit;
        $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
        // echo '<pre>';
        // var_dump($months);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/reports/bir_1601_views', $data);
    }
    function bir_alpha_list(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months;
        $userId                                          = $this->session->userdata('SESS_USER_ID');
        $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                                          =  $limit * ($page - 1);
        $data['EMPLOYEES']                               = $this->reports_model->GET_EMPLOYEE_LISTS($limit, $offset);
        $total_count                                     = $this->reports_model->GET_EMPLOYEE_LISTS_COUNT();
        $excess                                          = $total_count % $limit;
        $data['C_DATA_COUNT']                            = $total_count;
        $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']                                    = $page;
        $data['ROW']                                     = $limit;
        $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
        // echo '<pre>';
        // var_dump($months);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/reports/bir_alpha_list_views', $data);
    }
    function bir_alpha_list_dat(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months;
        $userId                                          = $this->session->userdata('SESS_USER_ID');
        $limit                                           = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                                            = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                                          =  $limit * ($page - 1);
        $data['EMPLOYEES']                               = $this->reports_model->GET_EMPLOYEE_LISTS($limit, $offset);
        $total_count                                     = $this->reports_model->GET_EMPLOYEE_LISTS_COUNT();
        $excess                                          = $total_count % $limit;
        $data['C_DATA_COUNT']                            = $total_count;
        $data['PAGES_COUNT']                             = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
        $data['PAGE']                                    = $page;
        $data['ROW']                                     = $limit;
        $data['C_ROW_DISPLAY']                           = array(10, 25, 50);
        $this->load->view('templates/header');
        $this->load->view('modules/reports/bir_alpha_list_dat_views', $data);
    }
    function sss_employees_report(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months; 
        $data['EMPLOYEES']  =$this->reports_model->GET_ALL_EMPLOYEE();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/sss_employees_report_views',$data);
    }
    function sss_employer_return(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months; 
        $data['EMPLOYEES']  =$this->reports_model->GET_ALL_EMPLOYEE();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/sss_employer_return_views',$data);
    }
    function sss_collection_lists(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months; 
        $data['EMPLOYEES']  =$this->reports_model->GET_ALL_EMPLOYEE();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/sss_collection_list_views',$data);
    }
    function phil_health_member_report(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months; 
        $data['EMPLOYEES']  =$this->reports_model->GET_ALL_EMPLOYEE();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/phil_health_member_report_views',$data);
    }
    function pag_ibig_contribution_remitance(){
        $data['YEAR']       = date('Y');
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthObj   = DateTime::createFromFormat('!m', $i);
            $months[$i] = $monthObj->format('F');
        }
        $data['MONTHS'] =$months; 
        $data['EMPLOYEES']  =$this->reports_model->GET_ALL_EMPLOYEE();
        $this->load->view('templates/header');
        $this->load->view('modules/reports/pag_ibig_contribution_remitance_views',$data);
        
    }
    function payslips_loan_deductions(){
        // variable declaration
        $data['CUTOFF_PERIODS']     = array();
        $data['LOANS']              = array();
        $data['PERIOD']             = '';
        $period                     = $this->input->get('period');
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     =  $limit * ($page - 1);
        $period_id                  = 0;
        $sum_total_loan             = 0;
        $sum_total_deduction        = 0;
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        
        $cutoff_periods            = $this->reports_model->GET_CUT_OFF_LIST();
        if($cutoff_periods && !$period){
            $period_id=$cutoff_periods[0]->id;
        }
        if($period){
            $period_id=$period;
        }
        
        $data['LOANS']              = $this->reports_model->GET_PAYSLIP_LOANS($period_id);
        foreach($data['LOANS'] as $loan){
            if($loan->LOAN_TOTAL){
                $sum_total_loan =  $sum_total_loan+$loan->LOAN_TOTAL;
            }
            if($loan->DEDUCTIONS){
                $sum_total_deduction=$sum_total_deduction+$loan->DEDUCTIONS;
            }
        }
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        $data['TOTAL_LOANS']        = $sum_total_loan;
        $data['TOTAL_DEDUCTIONS']   = $sum_total_deduction;
        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['PAGE']               = $page;
        // echo '<pre>';
        // var_dump($data['TOTAL'] );
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/reports/payslips_loan_deduction_views',$data);
    }
    function payslip_benifits(){
        $data['CUTOFF_PERIODS']     = array();
        $data['BENIFITS']           = array();
        $data['PERIOD']             = '';
        $period                     = $this->input->get('period');
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     =  $limit * ($page - 1);
        $period_id                  = 0;
        $sum_sss_total              = 0;
        $sum_phil_h_total           = 0;
        $sum_pag_ibig_total         = 0;
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        
        $cutoff_periods            = $this->reports_model->GET_CUT_OFF_LIST();
        if($cutoff_periods && !$period){
            $period_id=$cutoff_periods[0]->id;
        }
        if($period){
            $period_id=$period;
        }
        
        $data['BENIFITS']              = $this->reports_model->GET_PAYSLIP_BENIFITS($period_id);
        foreach($data['BENIFITS'] as $benifit){
            if($benifit->SSS_EE_CURRENT){
                $sum_sss_total =  $sum_sss_total+$benifit->SSS_EE_CURRENT;
            }
            if($benifit->PAGIBIG_EE_CURRENT){
                $sum_pag_ibig_total =  $sum_pag_ibig_total+$benifit->PAGIBIG_EE_CURRENT;
            }
            if($benifit->PHILHEALTH_EE_CURRENT){
                $sum_phil_h_total =  $sum_phil_h_total+$benifit->PHILHEALTH_EE_CURRENT;
            }
            
        }
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        $data['SSS_TOTAL']          = $sum_sss_total;
        $data['PAG_IBIG_TOTAL']     = $sum_pag_ibig_total;
        $data['PHIL_H_TOTAL']       = $sum_phil_h_total;
        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['PAGE']               = $page;
        // echo '<pre>';
        // var_dump($data['BENIFITS']);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/reports/payslips_benifit_views',$data);
    }
    function payslip_remittances(){
        $data['CUTOFF_PERIODS']     = array();
        $data['REMITTANCES']        = array();
        $data['PERIOD']             = '';
        $period                     = $this->input->get('period');
        $limit                      = $this->input->get('row') ? $this->input->get('row')  : 25;
        $page                       = $this->input->get('page') ? $this->input->get('page') : 1;
        $offset                     =  $limit * ($page - 1);
        $period_id                  = 0;
        $sum_total                  = 0;
        // Get the current date
        $currentDate = date('Y-m-d');
        // Get the first date of the current month
        $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
        // Get the last date of the current month
        $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
        
        if(!$this->date_from || !$this->date_to){
            $this->date_from  = $firstDateOfMonth;
            $this->date_to    = $lastDateOfMonth;
        }
        
        $cutoff_periods            = $this->reports_model->GET_CUT_OFF_LIST();
        if($cutoff_periods && !$period){
            $period_id=$cutoff_periods[0]->id;
        }
        if($period){
            $period_id=$period;
        }
        
        $data['REMITTANCES']              = $this->reports_model->GET_PAYSLIP_REMITTANCES($period_id);
        foreach($data['REMITTANCES'] as $loan){
            if($loan->NET_INCOME){
                $sum_total =  $sum_total+$loan->NET_INCOME;
            }
        }
        $data['START_DATE']         = date_format(date_create($this->date_from),'d/m/Y');
        $data['END_DATE']           = date_format(date_create($this->date_to),'d/m/Y');
        $data['TOTAL']              = $sum_total;
        $data['CUTOFF_PERIODS']     = $cutoff_periods;
        $data['PAGE']               = $page;
        // echo '<pre>';
        // var_dump($data['REMITTANCES']);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/reports/payslips_remittance_views',$data);
    }
    // end of routes
    function get_employee_info(){
        $input_data= $this->input->post();
        if(!$input_data){
            redirect('reports');
        }
        $data['employers']                      =    array();
        $data['employers']['name']              =    $this->reports_model->SYSTEM_SETTINGS('employers');
        $data['employers']['tin']               =    $this->reports_model->SYSTEM_SETTINGS('company_tin');
        $data['employers']['address']           =    $this->reports_model->SYSTEM_SETTINGS('employers_add');
        $data['employers']['email']             =    $this->reports_model->SYSTEM_SETTINGS('employers_email');
        $data['employers']['rdo_code']          =    $this->reports_model->SYSTEM_SETTINGS('rdo_code');
        $data['employers']['zip_code']          =    $this->reports_model->SYSTEM_SETTINGS('employers_zip_code');
        $data['employers']['web_site']          =    $this->reports_model->SYSTEM_SETTINGS('company_website');
        $data['employers']['sss_id']            =    $this->reports_model->SYSTEM_SETTINGS('employers_sss');
        $data['employers']['telephone']         =    $this->reports_model->SYSTEM_SETTINGS('employers_tel_num');
        $data['employers']['mobile_number']     =    $this->reports_model->SYSTEM_SETTINGS('employers_mob_num');
        
        $data['employees']                      = $this->reports_model->GET_EMPLOYEE($input_data['ids']);
        echo json_encode($data);
    }
    function get_all_employee_info(){
        // $input_data= $this->input->post();
        // if(!$input_data){
        //     redirect('reports');
        // }
        $data['employers']                      =    array();
        $data['employers']['name']              =    $this->reports_model->SYSTEM_SETTINGS('employers');
        $data['employers']['tin']               =    $this->reports_model->SYSTEM_SETTINGS('company_tin');
        $data['employers']['address']           =    $this->reports_model->SYSTEM_SETTINGS('employers_add');
        $data['employers']['email']             =    $this->reports_model->SYSTEM_SETTINGS('employers_email');
        $data['employers']['rdo_code']          =    $this->reports_model->SYSTEM_SETTINGS('rdo_code');
        $data['employers']['zip_code']          =    $this->reports_model->SYSTEM_SETTINGS('employers_zip_code');
        $data['employers']['web_site']          =    $this->reports_model->SYSTEM_SETTINGS('company_website');
        $data['employers']['sss_id']            =    $this->reports_model->SYSTEM_SETTINGS('employers_sss');
        $data['employers']['telephone']         =    $this->reports_model->SYSTEM_SETTINGS('employers_tel_num');
        $data['employers']['mobile_number']     =    $this->reports_model->SYSTEM_SETTINGS('employers_mob_num');
        $data['employees']                      =    $this->reports_model->GET_ALL_EMPLOYEE(); 
        echo json_encode($data);
    }
    function form_settings(){
        $data['EMPLOYERS_NAME']     =    $this->reports_model->SYSTEM_SETTINGS('employers');
        $data['EMPLOYERS_TIN']      =    $this->reports_model->SYSTEM_SETTINGS('company_tin');
        $data['EMPLOYERS_ADD']      =    $this->reports_model->SYSTEM_SETTINGS('employers_add');
        $data['EMPLOYERS_EMAIL']    =    $this->reports_model->SYSTEM_SETTINGS('employers_email');
        $data['RDO_CODE']           =    $this->reports_model->SYSTEM_SETTINGS('rdo_code');
        $data['ZIP_CODE']           =    $this->reports_model->SYSTEM_SETTINGS('employers_zip_code');
        $data['COMPANY_WEB']        =    $this->reports_model->SYSTEM_SETTINGS('company_website');
        $data['SSS_ID']             =    $this->reports_model->SYSTEM_SETTINGS('employers_sss');
        $data['TELEPHONE']          =    $this->reports_model->SYSTEM_SETTINGS('employers_tel_num');
        $data['MOBILE_NUMBER']      =    $this->reports_model->SYSTEM_SETTINGS('employers_mob_num');
        // echo '<pre>';
        // var_dump($data);
        // return;
        $this->load->view('templates/header');
        $this->load->view('modules/reports/form_setting_views',$data);
    }
    function update_form_setting(){
        $input_data = $this->input->post();
        $data       = array();
        foreach($input_data as $key=>$value){
            $data[]=array('setting'=>$key,'value'=>$value);
        }
        $res= $this->reports_model->UPDATE_FORM_SETTING($data);
        if ($res) {
            $this->session->set_flashdata('SUCC', 'Successfully added new request');
          } else {
            $this->session->set_flashdata('ERR', 'Fail to add new request');
            redirect('reports/form_settings');
            return;
          }
          redirect('reports/goverment_forms');
        }
}

function filter_array($user_modules, $user_access)
{
    $modules = array();
    foreach ($user_modules as $module) {
        foreach ($user_access as $access) {
            if ($module["value"] == $access) {
                $modules[] = $module;
            }
        }
    }
    return $modules;
}

function generateDesignation($items)
{
    if (empty($items)) {
        return '';
    }

    $currentItem = array_shift($items);

    if (empty($items)) {
        return $currentItem;
    } else {
        if (!empty($currentItem)) {
            return $currentItem . ' > ' . generateDesignation($items);
        }
        return generateDesignation($items);
    }
}
