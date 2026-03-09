<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class attendances extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('templates/main_table_01_model');
    $this->load->model('templates/main_table_02_model');
    $this->load->model('modules/attendance_model');
    $this->load->model('modules/selfservices_model');
    $this->load->model('modules/payrolls_model');
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
    $maintenance = $this->login_model->GET_MAINTENANCE();
    $isAdmin = $this->session->userdata('SESS_ADMIN');
    if ($maintenance == '1' && $isAdmin != 1) {
      redirect('login/maintenance');
    }
  }

  function index()
  {
    $data["Modules"] = array(
      array("title" => "Attendance Records", "value" => "Attendance Records", "info" => "Views detailed employees in/out and attendance record", "icon" => "calendar-clock-duotone-att.svg", "url" => "attendances/attendance_records", "access" => "Attendance", "id" => "attendance_records"),
      array("title" => "Attendance Summary", "value" => "Attendance Summary", "info" => "Views summarized attendance record of all employees. HR can export and endorse the list to payroll.", "icon" => "table-list-duotone-att.svg", "url" => "attendances/attendance_summary", "access" => "Attendance", "id" => "attendance_summary"),
      array("title" => "Daily Attendance", "value" => "Daily Attendance", "info" => "Views daily summarized attendance record of all employees.", "icon" => "sun-duotone-att.svg", "url" => "attendances/daily_attendances", "access" => "Attendance", "id" => "daily_attendance"),
      array("title" => "Shift Assignment", "value" => "Shift Assignment", "info" => "Assign specific work shifts or schedules to individual employees or groups of employees within an organization.", "icon" => "chart-gantt-duotone-att.svg", "url" => "attendances/shift_assignment", "access" => "Attendance", "id" => "shift_assignment"),
      array("title" => "Work Shifts", "value" => "Work Shifts", "info" => "Define, configure, and manage the work shifts or schedules for employees within an organization.", "icon" => "moon-over-sun-duotone-att.svg", "url" => "attendances/work_shifts", "access" => "Attendance", "id" => "work_shifts"),
      array("title" => "Holidays", "value" => "Holidays", "info" => "Define and manage the list of official holidays for an organization", "icon" => "person-hiking-duotone_dark.svg", "url" => "attendances/holidays", "access" => "Attendance", "id" => "holidays"),
      array("title" => "Time Adjustment List", "value" => "Time Adjustment List", "info" => "Review, manage, and process time adjustments made by employees.", "icon" => "reply-clock-duotone_ss.svg", "url" => "attendances/time_adjustment_lists", "access" => "Attendance", "id" => "time_adjustment_list"),
      array("title" => "Offset List", "value" => "Offset Request", "info" => "Review, manage, and process offsets to correct discrepancies", "icon" => "file-chart-column-duotone.svg", "url" => "attendances/offset_lists", "access" => "Attendance", "id" => "offset_lists"),
      array("title" => "Biometric Records", "value" => "Zkteco Attendance", "info" => "Views attendance data from Biometric devices", "icon" => "fingerprint-duotone-att.svg", "url" => "attendances/zkteco_attendance", "access" => "Attendance", "id" => "zkteco_attendance"),
      array("title" => "Biometric User ID", "value" => "Zkteco Code", "info" => "Configure and synchronize Employee ID and Biometrics ID", "icon" => "user-group-simple-duotone-att.svg", "url" => "attendances/zkteco_code", "access" => "Attendance", "id" => "zkteco_code"),
      array("title" => "Time Records", "value" => "Time Records", "info" => "Views essential information for each employee, status, designation.", "icon" => "file-import-duotone-att.svg", "url" => "attendances/edit_attendance_summary", "access" => "Attendance", "id" => "import_attendance"),
      array("title" => "Advance Filing of Time Records", "value" => "Advance Attendance", "info" => " Allows employees to submit their time records ahead of schedule, streamlining the process and providing flexibility.", "icon" => "file-invoice-duotone.svg", "url" => "attendances/update_attendance_summary_advance", "access" => "Attendance", "id" => "advance_attendance"),
      array("title" => "Exempt Undertime", "value" => "Attendance Undertime", "info" => "Enhances transparency and efficiency by facilitating the tracking of exempt undertime instances and ensuring clear communication of undertime policies to employees.", "icon" => "clock-nine-duotone.svg", "url" => "attendances/undertime", "access" => "Attendance", "id" => "undertime"),
      array("title" => "Payroll Schedule", "value" => "Payroll Schedule", "info" => "Generate specific payroll date for employees.", "icon" => "calendar-check-duotone.svg", "url" => "attendances/payroll_schedules", "access" => "Attendance", "id" => "payrolls"),
      array("title" => "Converter", "value" => "Converter", "info" => "", "icon" => "calendar-check-duotone.svg", "url" => "attendances/converter", "access" => "Attendance", "id" => "converter"),
    );
    // $data['settings']                   = "attendances/setting_holidays";
    $data['settings'] = "attendances/setting_general";
    $data["title_page"] = "Time and Attendance Management";
    $data["title_description"] = "Focuses on tracking and managing employee work hours, attendance, and related data";
    $data["maiya_theme"] = $this->attendance_model->GET_MAYA_THEME();
    $user_access_id = $this->main_nav_model->get_user_access_id($this->session->userdata('SESS_USER_ID'));
    $data['DISP_USER_ACCESS_PAGE'] = $this->main_nav_model->get_user_access_page($user_access_id['col_user_access']);
    $array_page = explode(", ", $data['DISP_USER_ACCESS_PAGE']["user_page"]);
    // var_dump($array_page); die();
    $data['Modules'] = filter_array($data["Modules"], $array_page);
    $this->load->view('templates/header');
    $this->load->view('templates/main_container', $data);
  }

  function edit_specific_payroll_sched($id)
  {
    $title = $this->input->post('title');
    $year = $this->input->post('year');
    $month = $this->input->post('month');
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $payout_date = $this->input->post('payout_date');
    $payslip_schedule = $this->input->post('payslip_schedule_viewing');
    $pay_freq = $this->input->post('pay_freq');
    $con_period_1 = $this->input->post('con_period_1');
    $con_period_2 = $this->input->post('con_period_2');
    $con_period_3 = $this->input->post('con_period_3');
    $con_period_4 = $this->input->post('con_period_4');
    $con_period_5 = $this->input->post('con_period_5');
    $status = $this->input->post('status');
    $input_sss = $this->input->post('input_sss');
    $input_phil = $this->input->post('input_phil');
    $input_pagibig = $this->input->post('input_pagibig');
    $input_wtax = $this->input->post('input_wtax');
    // $input_ta                       = $this->input->post('input_ta');
    // $input_nta                      = $this->input->post('input_nta');
    $input_tax_allowance = $this->input->post('input_tax_allowance');
    $input_nontax_allowance = $this->input->post('input_nontax_allowance');
    $input_loans = $this->input->post('input_loans');
    $input_adjustment = $this->input->post('input_adjustment');
    $input_tard = $this->input->post('input_tard');
    ($input_sss != null) ? $input_sss = 0 : $input_sss = 1;
    ($input_phil != null) ? $input_phil = 0 : $input_phil = 1;
    ($input_pagibig != null) ? $input_pagibig = 0 : $input_pagibig = 1;
    ($input_wtax != null) ? $input_wtax = 0 : $input_wtax = 1;
    ($input_tax_allowance != null) ? $input_tax_allowance = 0 : $input_tax_allowance = 1;
    ($input_nontax_allowance != null) ? $input_nontax_allowance = 0 : $input_nontax_allowance = 1;
    ($input_loans != null) ? $input_loans = 0 : $input_loans = 1;
    ($input_adjustment != null) ? $input_adjustment = 0 : $input_adjustment = 1;
    ($input_tard != null) ? $input_tard = 0 : $input_tard = 1;
    $this->payrolls_model->EDIT_PAYROLL_SCHEDULE($title, $year, $month, $start_date, $end_date, $payout_date, $payslip_schedule, $pay_freq, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $status, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard, $id);
    $this->session->set_userdata('SESS_SUCCESS', 'Updated Successfully!');
    redirect('attendances/payroll_schedules');
  }

  function edit_payroll_sched($id)
  {
    for ($i = 1; $i <= 12; $i++) {
      $monthObj = DateTime::createFromFormat('!m', $i);
      $months[$i] = $monthObj->format('F');
    }
    $data['DISP_MONTHS'] = $months;
    $data['DISP_YEARS'] = $this->payrolls_model->GET_YEARS();
    $data['SPECIFIC_PAYROLL_SCHEDULES'] = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($id);
    $data['PAYROLL_SCHEDULES'] = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/edit_payroll_schedule_views', $data);
  }

  function published()
  {
    $period = $this->input->get('period');
    $status = $this->input->get('status');
    $tab = $this->input->get('tab');
    $data['CUTOFF_PERIODS'] = $this->payrolls_model->GET_CUTOFF_LIST();
    $payroll_list = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
    if ($period == null && !empty($payroll_list)) {
      $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

      if ($result) {
        $period = $payroll_list[0]->period;
      } else {
        $period = $cuttoff_periods[0]->id;
      }
    } elseif ($period == null && empty($payroll_list)) {
      $period = $cuttoff_periods[0]->id;
    }
    if ($tab == null || $tab == '') {
      $tab = 'published';
    }
    $data['TAB'] = $tab;
    $data['PERIOD'] = $period;
    $data['PAYROLL_PAYSLIP_GENERATED_LIST'] = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
    $data['GENERATED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
    $data['PAYROLL_PAYSLIP_PUBLISHED_LIST'] = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);

    $negative_data_count = 0;
    foreach ($payslip_published_list as $list) {
      if ($list->NET_INCOME < 0) {
        $negative_data_count++;
      }
    }
    $data['PAYROLL_PAYSLIP_PUBLISHED_LIST_NEGATIVE_COUNT'] = $negative_data_count;

    $data['PUBLISHED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
    $generated_sum_net_income = 0;
    $published_sum_net_income = 0;
    foreach ($payslip_generated_list as $generated_list) {
      $generated_sum_net_income += $generated_list->NET_INCOME;
    }
    foreach ($payslip_published_list as $published_list) {
      $published_sum_net_income += $published_list->NET_INCOME;
    }
    $pasyslip_list = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
    $attendance_record_lock = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
    $employees_type = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
    $employees_positions = $this->payrolls_model->GET_ALL_POSITION();
    $employees = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
    foreach ($employees as $employee) {
      foreach ($employees_type as $type) {
        if ($employee->col_empl_type == $type->id) {
          $employee->col_empl_type = $type->name;
        }
      }
      foreach ($employees_positions as $position) {
        if ($employee->col_empl_posi == $position->id) {
          $employee->col_empl_posi = $position->name;
        }
      }
    }
    $pasyslipEmplIds = array_map(function ($item) {
      if ($item->status == "Generated" || $item->status == "Published") {
        return $item->empl_id;
      }
    }, $pasyslip_list);
    $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
      return !in_array($employee->id, $pasyslipEmplIds);
    });
    $attendanceRecordLockIds = array_map(function ($item) {
      return $item->empl_id;
    }, $attendance_record_lock);
    $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
      return !in_array($employee->id, $attendanceRecordLockIds);
    });
    $attendanceRecordLockFilteredIds = array_map(function ($item) {
      return $item->id;
    }, $attendanceRecordLockFiltered);
    $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
      return !in_array($employee->id, $attendanceRecordLockFilteredIds);
    });
    $data['DISP_GENERATED_SUM_NET_INCOME'] = $generated_sum_net_income;
    $data['DISP_PUBLISHED_SUM_NET_INCOME'] = $published_sum_net_income;
    $data['DISP_EMP_LIST'] = $filteredEmployees2;
    $data['DISP_EMP_LIST_COUNT'] = count($filteredEmployees2);
    $data['DISP_PENDING'] = $attendanceRecordLockFiltered;
    $data['DISP_PENDING_COUNT'] = count($attendanceRecordLockFiltered);

    $navbar_val = $this->payrolls_model->get_value_navbar();
    if (file_exists(FCPATH . 'assets_system/images/' . $navbar_val)) {
      $data['DISP_NAV'] = $navbar_val;
    } else if (file_exists(FCPATH . 'assets_system/images/default_logo.png')) {
      $data['DISP_NAV'] = 'default_logo.png';
    } else {
      $data['DISP_NAV'] = null;
    }

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/payroll_published_views', $data);
  }

  function payroll_schedules()
  {
    $data['currentYear'] = date('Y');
    $year = $this->input->get('year') ? $this->input->get('year') : $data['currentYear'];
    $pay_frequency = $this->input->get('pay_frequency') ? $this->input->get('pay_frequency') : 'Semi-Monthly';
    $data['MONTHS'] = array();
    $payroll_sched = $this->payrolls_model->GET_PAYROLL_SCHED($year, $pay_frequency);
    // Use an array of month names to avoid repetition
    $months = array(
      'JAN' => 'January',
      'FEB' => 'February',
      'MAR' => 'March',
      'APR' => 'April',
      'MAY' => 'May',
      'JUN' => 'June',
      'JUL' => 'July',
      'AUG' => 'August',
      'SEP' => 'September',
      'OCT' => 'October',
      'NOV' => 'November',
      'DEC' => 'December'
    );
    // Loop through the array and assign the filtered payroll schedule to each month
    foreach ($months as $key => $value) {
      $data['MONTHS'][$value] = filter_payroll_sched($value, $payroll_sched);
    }
    $data['C_YEARS'] = $this->payrolls_model->GET_YEARS();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/payroll_schedules_views', $data);
  }

  function generated()
  {
    $period = $this->input->get('period');
    $status = $this->input->get('status');
    $tab = $this->input->get('tab');
    $data['CUTOFF_PERIODS'] = $cuttoff_periods = $this->payrolls_model->GET_CUTOFF_LIST();
    $payroll_list = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
    if ($period == null && !empty($payroll_list)) {
      $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

      if ($result) {
        $period = $payroll_list[0]->period;
      } else {
        $period = $cuttoff_periods[0]->id;
      }
    } elseif ($period == null && empty($payroll_list)) {
      $period = $cuttoff_periods[0]->id;
    }
    if ($tab == null || $tab == '') {
      $tab = 'generated';
    }
    $data['TAB'] = $tab;
    $data['PERIOD'] = $period;
    $data['PAYROLL_PAYSLIP_GENERATED_LIST'] = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);

    $negative_data_count = 0;
    foreach ($payslip_generated_list as $list) {
      if ($list->NET_INCOME < 0) {
        $negative_data_count++;
      }
    }

    $data['PAYROLL_PAYSLIP_GENERATED_LIST_NEGATIVE_COUNT'] = $negative_data_count;
    $data['GENERATED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
    $data['PAYROLL_PAYSLIP_PUBLISHED_LIST'] = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
    $data['PUBLISHED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
    $generated_sum_net_income = 0;
    $published_sum_net_income = 0;
    foreach ($payslip_generated_list as $generated_list) {
      $generated_sum_net_income += $generated_list->NET_INCOME;
    }
    foreach ($payslip_published_list as $published_list) {
      $published_sum_net_income += $published_list->NET_INCOME;
    }
    $pasyslip_list = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
    $attendance_record_lock = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
    $employees_type = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
    $employees_positions = $this->payrolls_model->GET_ALL_POSITION();
    $employees = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
    foreach ($employees as $employee) {
      foreach ($employees_type as $type) {
        if ($employee->col_empl_type == $type->id) {
          $employee->col_empl_type = $type->name;
        }
      }
      foreach ($employees_positions as $position) {
        if ($employee->col_empl_posi == $position->id) {
          $employee->col_empl_posi = $position->name;
        }
      }
    }
    $pasyslipEmplIds = array_map(function ($item) {
      if ($item->status == "Generated" || $item->status == "Published") {
        return $item->empl_id;
      }
    }, $pasyslip_list);
    $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
      return !in_array($employee->id, $pasyslipEmplIds);
    });
    $attendanceRecordLockIds = array_map(function ($item) {
      return $item->empl_id;
    }, $attendance_record_lock);
    $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
      return !in_array($employee->id, $attendanceRecordLockIds);
    });
    $attendanceRecordLockFilteredIds = array_map(function ($item) {
      return $item->id;
    }, $attendanceRecordLockFiltered);
    $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
      return !in_array($employee->id, $attendanceRecordLockFilteredIds);
    });
    $data['DISP_GENERATED_SUM_NET_INCOME'] = $generated_sum_net_income;
    $data['DISP_PUBLISHED_SUM_NET_INCOME'] = $published_sum_net_income;
    $data['DISP_EMP_LIST'] = $filteredEmployees2;
    $data['DISP_EMP_LIST_COUNT'] = count($filteredEmployees2);
    $data['DISP_PENDING'] = $attendanceRecordLockFiltered;
    $data['DISP_PENDING_COUNT'] = count($attendanceRecordLockFiltered);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/payroll_generated_views', $data);
  }

  function ready()
  {
    $period = $this->input->get('period');
    $status = $this->input->get('status');
    $tab = $this->input->get('tab');
    $data['CUTOFF_PERIODS'] = $cuttoff_periods = $this->payrolls_model->GET_CUTOFF_LIST();
    $payroll_list = $this->payrolls_model->GET_PERIOD_LIST_LOCK();

    if ($period == null && !empty($payroll_list)) {
      $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

      if ($result) {
        $period = $payroll_list[0]->period;
      } else {
        $period = $cuttoff_periods[0]->id;
      }
    } elseif ($period == null && empty($payroll_list)) {
      $period = $cuttoff_periods[0]->id;
    }

    if ($tab == null || $tab == '') {
      $tab = 'ready';
    }
    $data['TAB'] = $tab;
    $data['PERIOD'] = $period;
    $data['PAYROLL_PAYSLIP_GENERATED_LIST'] = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
    $data['GENERATED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
    $data['PAYROLL_PAYSLIP_PUBLISHED_LIST'] = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
    $data['PUBLISHED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
    $generated_sum_net_income = 0;
    $published_sum_net_income = 0;
    foreach ($payslip_generated_list as $generated_list) {
      $generated_sum_net_income += $generated_list->NET_INCOME;
    }
    foreach ($payslip_published_list as $published_list) {
      $published_sum_net_income += $published_list->NET_INCOME;
    }
    $pasyslip_list = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
    $attendance_record_lock = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
    $employees_type = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
    $employees_positions = $this->payrolls_model->GET_ALL_POSITION();
    $employees = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
    foreach ($employees as $employee) {
      foreach ($employees_type as $type) {
        if ($employee->col_empl_type == $type->id) {
          $employee->col_empl_type = $type->name;
        }
      }
      foreach ($employees_positions as $position) {
        if ($employee->col_empl_posi == $position->id) {
          $employee->col_empl_posi = $position->name;
        }
      }
    }
    $pasyslipEmplIds = array_map(function ($item) {
      if ($item->status == "Generated" || $item->status == "Published") {
        return $item->empl_id;
      }
    }, $pasyslip_list);
    $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
      return !in_array($employee->id, $pasyslipEmplIds);
    });
    $attendanceRecordLockIds = array_map(function ($item) {
      return $item->empl_id;
    }, $attendance_record_lock);
    $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
      return !in_array($employee->id, $attendanceRecordLockIds);
    });
    $attendanceRecordLockFilteredIds = array_map(function ($item) {
      return $item->id;
    }, $attendanceRecordLockFiltered);
    $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
      return !in_array($employee->id, $attendanceRecordLockFilteredIds);
    });
    $data['DISP_GENERATED_SUM_NET_INCOME'] = $generated_sum_net_income;
    $data['DISP_PUBLISHED_SUM_NET_INCOME'] = $published_sum_net_income;
    $data['DISP_EMP_LIST'] = $filteredEmployees2;
    $data['DISP_EMP_LIST_COUNT'] = count($filteredEmployees2);
    $data['DISP_PENDING'] = $attendanceRecordLockFiltered;
    $data['DISP_PENDING_COUNT'] = count($attendanceRecordLockFiltered);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/payroll_ready_views', $data);
  }

  function round_night_diff($nd_hours)
  {

      $base = 1.00;
      $excess = $nd_hours - 1;

      // Count FULL 30-minute blocks only
      $half_blocks = floor($excess / 0.50);

      return number_format($base + ($half_blocks * 0.50), 2, '.', '');
  }



  function pending()
  {
    $period = $this->input->get('period');
    $status = $this->input->get('status');
    $tab = $this->input->get('tab');
    $data['CUTOFF_PERIODS'] = $cuttoff_periods = $this->payrolls_model->GET_CUTOFF_LIST();
    $payroll_list = $this->payrolls_model->GET_PERIOD_LIST_LOCK();

    if ($period == null && !empty($payroll_list)) {
      $result = $this->payrolls_model->GET_SPECIFIC_CUTOFF($payroll_list[0]->period);

      if ($result) {
        $period = $payroll_list[0]->period;
      } else {
        $period = $cuttoff_periods[0]->id;
      }
    } elseif ($period == null && empty($payroll_list)) {
      $period = $cuttoff_periods[0]->id;
    }

    if ($tab == null || $tab == '') {
      $tab = 'pending';
    }
    $data['TAB'] = $tab;
    $data['PERIOD'] = $period;
    $data['PAYROLL_PAYSLIP_GENERATED_LIST'] = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
    $data['GENERATED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
    $data['PAYROLL_PAYSLIP_PUBLISHED_LIST'] = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
    $data['PUBLISHED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
    $generated_sum_net_income = 0;
    $published_sum_net_income = 0;
    foreach ($payslip_generated_list as $generated_list) {
      $generated_sum_net_income += $generated_list->NET_INCOME;
    }
    foreach ($payslip_published_list as $published_list) {
      $published_sum_net_income += $published_list->NET_INCOME;
    }
    $pasyslip_list = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
    $attendance_record_lock = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
    $employees_type = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
    $employees_positions = $this->payrolls_model->GET_ALL_POSITION();
    $employees = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
    foreach ($employees as $employee) {
      foreach ($employees_type as $type) {
        if ($employee->col_empl_type == $type->id) {
          $employee->col_empl_type = $type->name;
        }
      }
      foreach ($employees_positions as $position) {
        if ($employee->col_empl_posi == $position->id) {
          $employee->col_empl_posi = $position->name;
        }
      }
    }
    $pasyslipEmplIds = array_map(function ($item) {
      if ($item->status == "Generated" || $item->status == "Published") {
        return $item->empl_id;
      }
    }, $pasyslip_list);
    $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
      return !in_array($employee->id, $pasyslipEmplIds);
    });
    $attendanceRecordLockIds = array_map(function ($item) {
      return $item->empl_id;
    }, $attendance_record_lock);
    $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
      return !in_array($employee->id, $attendanceRecordLockIds);
    });
    $attendanceRecordLockFilteredIds = array_map(function ($item) {
      return $item->id;
    }, $attendanceRecordLockFiltered);
    $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
      return !in_array($employee->id, $attendanceRecordLockFilteredIds);
    });
    $data['DISP_GENERATED_SUM_NET_INCOME'] = $generated_sum_net_income;
    $data['DISP_PUBLISHED_SUM_NET_INCOME'] = $published_sum_net_income;
    $data['DISP_EMP_LIST'] = $filteredEmployees2;
    $data['DISP_EMP_LIST_COUNT'] = count($filteredEmployees2);
    $data['DISP_PENDING'] = $attendanceRecordLockFiltered;
    $data['DISP_PENDING_COUNT'] = count($attendanceRecordLockFiltered);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/payroll_pending_views', $data);
  }

  function payroll_status()
  {
    $period = $this->input->get('period');
    $status = $this->input->get('status');
    $tab = $this->input->get('tab');
    $data['CUTOFF_PERIODS'] = $this->payrolls_model->GET_CUTOFF_LIST();
    $payroll_list = $this->payrolls_model->GET_PERIOD_LIST_LOCK();
    if ($period == null && !empty($payroll_list)) {
      $period = $payroll_list[0]->period;
    }
    if ($tab == null || $tab == '') {
      $tab = 'pending';
    }
    $data['TAB'] = $tab;
    $data['PERIOD'] = $period;
    $data['PAYROLL_PAYSLIP_GENERATED_LIST'] = $payslip_generated_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period);
    $data['GENERATED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_GENERATED($period));
    $data['PAYROLL_PAYSLIP_PUBLISHED_LIST'] = $payslip_published_list = $this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period);
    $data['PUBLISHED_LIST_COUNT'] = count($this->payrolls_model->GET_PAYROLL_PAYSLIPS_PUBLISHED($period));
    $generated_sum_net_income = 0;
    $published_sum_net_income = 0;
    foreach ($payslip_generated_list as $generated_list) {
      $generated_sum_net_income += $generated_list->NET_INCOME;
    }
    foreach ($payslip_published_list as $published_list) {
      $published_sum_net_income += $published_list->NET_INCOME;
    }
    $pasyslip_list = $this->payrolls_model->GET_ALL_PAYROLL_PAYSLIPS($period);
    $attendance_record_lock = $this->payrolls_model->GET_ALL_ATTENDACE_RECORD_LOCK($period);
    $employees_type = $this->payrolls_model->GET_ALL_EMPLOYEE_TYPE();
    $employees_positions = $this->payrolls_model->GET_ALL_POSITION();
    $employees = $this->payrolls_model->GET_EMPLOYEELIST_DATA();
    foreach ($employees as $employee) {
      foreach ($employees_type as $type) {
        if ($employee->col_empl_type == $type->id) {
          $employee->col_empl_type = $type->name;
        }
      }
      foreach ($employees_positions as $position) {
        if ($employee->col_empl_posi == $position->id) {
          $employee->col_empl_posi = $position->name;
        }
      }
    }
    $pasyslipEmplIds = array_map(function ($item) {
      if ($item->status == "Generated" || $item->status == "Published") {
        return $item->empl_id;
      }
    }, $pasyslip_list);
    $filteredEmployees = array_filter($employees, function ($employee) use ($pasyslipEmplIds) {
      return !in_array($employee->id, $pasyslipEmplIds);
    });
    $attendanceRecordLockIds = array_map(function ($item) {
      return $item->empl_id;
    }, $attendance_record_lock);
    $attendanceRecordLockFiltered = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockIds) {
      return !in_array($employee->id, $attendanceRecordLockIds);
    });
    $attendanceRecordLockFilteredIds = array_map(function ($item) {
      return $item->id;
    }, $attendanceRecordLockFiltered);
    $filteredEmployees2 = array_filter($filteredEmployees, function ($employee) use ($attendanceRecordLockFilteredIds) {
      return !in_array($employee->id, $attendanceRecordLockFilteredIds);
    });
    $data['DISP_GENERATED_SUM_NET_INCOME'] = $generated_sum_net_income;
    $data['DISP_PUBLISHED_SUM_NET_INCOME'] = $published_sum_net_income;
    $data['DISP_EMP_LIST'] = $filteredEmployees2;
    $data['DISP_EMP_LIST_COUNT'] = count($filteredEmployees2);
    $data['DISP_PENDING'] = $attendanceRecordLockFiltered;
    $data['DISP_PENDING_COUNT'] = count($attendanceRecordLockFiltered);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/payroll_summary_status_views', $data);
  }

  function payroll_sched($id)
  {
    for ($i = 1; $i <= 12; $i++) {
      $monthObj = DateTime::createFromFormat('!m', $i);
      $months[$i] = $monthObj->format('F');
    }
    $data['DISP_MONTHS'] = $months;
    $data['DISP_YEARS'] = $this->payrolls_model->GET_YEARS();
    $data['SPECIFIC_PAYROLL_SCHEDULES'] = $this->payrolls_model->GET_SPECIFIC_PAYROLL_SCHEDULE($id);
    $data['PAYROLL_SCHEDULES'] = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/payroll_schedule_views', $data);
  }

  function add_payroll_sched()
  {
    for ($i = 1; $i <= 12; $i++) {
      $monthObj = DateTime::createFromFormat('!m', $i);
      $months[$i] = $monthObj->format('F');
    }
    $data['DISP_MONTHS'] = $months;
    $data['DISP_YEARS'] = $this->payrolls_model->GET_YEARS();
    $data['PAYROLL_SCHEDULES'] = $this->payrolls_model->GET_ALL_PAYROLL_SCHEDULE();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_payroll_schedule_views', $data);
  }
  function insert_payroll_sched()
  {
    $title = $this->input->post('title');
    $year = $this->input->post('year');
    $month = $this->input->post('month');
    $start_date = $this->input->post('start_date');
    $end_date = $this->input->post('end_date');
    $payout_date = $this->input->post('payout_date');
    $payslip_schedule_viewing = $this->input->post('payslip_schedule_viewing');
    $pay_freq = $this->input->post('pay_freq');
    $con_period_1 = $this->input->post('con_period_1');
    $con_period_2 = $this->input->post('con_period_2');
    $con_period_3 = $this->input->post('con_period_3');
    $con_period_4 = $this->input->post('con_period_4');
    $con_period_5 = $this->input->post('con_period_5');
    $status = $this->input->post('status');
    $input_sss = $this->input->post('input_sss');
    $input_phil = $this->input->post('input_phil');
    $input_pagibig = $this->input->post('input_pagibig');
    $input_wtax = $this->input->post('input_wtax');
    // $input_ta                       = $this->input->post('input_ta');
    // $input_nta                      = $this->input->post('input_nta');
    $input_tax_allowance = $this->input->post('input_tax_allowance');
    $input_nontax_allowance = $this->input->post('input_nontax_allowance');
    $input_loans = $this->input->post('input_loans');
    $input_adjustment = $this->input->post('input_adjustment');
    $input_tard = $this->input->post('input_tard');
    $datesError = '';
    if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $start_date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $start_date)) {
      $datesError = 'Invalid Start Date';
    }
    if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $end_date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $end_date)) {
      if (empty($datesError)) {
        $datesError = 'Invalid End Date';
      } else {
        $datesError = $datesError . '. Invalid End Date';
      }
    }
    if (preg_match('/^\d{1,3}-\d{2}-\d{2}$/', $payout_date) || preg_match('/^\d{5,}-\d{2}-\d{2}$/', $payout_date)) {
      if (empty($datesError)) {
        $datesError = 'Invalid Payout Date';
      } else {
        $datesError = $datesError . '. Invalid Payout Date';
      }
    }
    if ($datesError) {
      $this->session->set_flashdata('ERR', $datesError);
      redirect('attendances/add_payroll_sched');
    }
    ($input_sss != null) ? $input_sss = 0 : $input_sss = 1;
    ($input_phil != null) ? $input_phil = 0 : $input_phil = 1;
    ($input_pagibig != null) ? $input_pagibig = 0 : $input_pagibig = 1;
    ($input_wtax != null) ? $input_wtax = 0 : $input_wtax = 1;
    ($input_tax_allowance != null) ? $input_tax_allowance = 0 : $input_tax_allowance = 1;
    ($input_nontax_allowance != null) ? $input_nontax_allowance = 0 : $input_nontax_allowance = 1;
    ($input_loans != null) ? $input_loans = 0 : $input_loans = 1;
    ($input_adjustment != null) ? $input_adjustment = 0 : $input_adjustment = 1;
    ($input_tard != null) ? $input_tard = 0 : $input_tard = 1;
    $res = $this->payrolls_model->INSERT_PAYROLL_SCHEDULE($title, $year, $month, $start_date, $end_date, $payout_date, $payslip_schedule_viewing, $pay_freq, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $status, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard);

    if ($res) {
      $this->session->set_flashdata('SUCC', 'Added Successfully!');
    }

    redirect('attendances/payroll_schedules');
  }

  function general_settings()
  {
    // $data['DATA_LIST'] = json_encode($this->employees_model->GET_SHIRT_SIZES());
    $data['DATA_LIST'] = 'test';
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/general_settings_views', $data);
  }

  function setting_general()
  {
    // balik
    $data['timekeeping_graceperiod']                                  = $this->attendance_model->get_system_setup_by_setting('timekeeping_graceperiod');
    $data['timekeeping_lateunder_deduction_perminute']                = $this->attendance_model->get_system_setup_by_setting('timekeeping_lateunder_deduction_perminute');
    $data['timekeeping_late_deduction_perminute']                     = $this->attendance_model->get_system_setup_by_setting('timekeeping_late_deduction_perminute');
    $data['timekeeping_undertime_deduction_perminute']                = $this->attendance_model->get_system_setup_by_setting('timekeeping_undertime_deduction_perminute');
    $data['min_hours_present']                                        = $this->attendance_model->get_system_setup_by_setting('min_hours_present');
    $data['isBreakEnabled']                                           = $this->attendance_model->get_system_setup_by_setting2('isBreakEnabled', '1');
    $data['NDMinimum']                                                = $this->attendance_model->get_system_setup_by_setting2('NDMinimum', '0');

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/setting_general_views', $data);
  }
  function setting_absent_lwop_awol()
  {
    $data['DISP_ABSENT']    = $this->attendance_model->GET_ABSENT_LWOP_AWOL('absent_lwop_awol');
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/setting_absent_lwop_awol_views', $data);
  }

  function update_setting_absences()
  {
    $input_data = $this->input->post('absent_lwop_awol');
    if ($input_data == "") {
      $input_data = '0';
    }

    $res = $this->attendance_model->UPDATE_ABSENT_SETTINGS('absent_lwop_awol', $input_data);
    if ($res) {
      $this->session->set_userdata('SESS_SUCCESS', "Attendance Settings Successfully updated");
    } else {
      $this->session->set_userdata('SESS_FAILED', "Error, Something went wrong!");
    }

    redirect('attendances/setting_absent_lwop_awol');
  }
  function update_setting_general()
  {
    $input_data = $this->input->post();
    $validKeys = [
      'timekeeping_graceperiod',
      'timekeeping_lateunder_deduction_perminute',
      'timekeeping_late_deduction_perminute',
      'timekeeping_undertime_deduction_perminute',
      'min_hours_present',
      'NDMinimum',
      'isBreakEnabled',
    ];
    $input_data = array_intersect_key($input_data, array_flip($validKeys));
    // echo '<pre>';
    // var_dump($input_data);
    // return;
    // $settings= array_keys($input_data);
    $res = $this->attendance_model->UPDATE_HOME_SETTINGS($input_data);
    // var_dump($res);die();
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Attendance Settings Successfully updated');
    } else {
      $this->session->set_flashdata('ERR', 'Attendance Settings Unable to update');
    }
    redirect($this->input->server('HTTP_REFERER'));
  }
  function setting_geo_fences()
  {
    $data['TABLE_DATA'] = $this->attendance_model->GET_LIST_DATA('tbl_fence_areas');
    $data['geo_fencing'] = $this->attendance_model->get_system_setup_by_setting('geo_fencing');
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/setting_geo_fence_views', $data);
  }
  function update_setting_geo_fence()
  {
    $input_data = $this->input->post();
    $validKeys = [
      'geo_fencing',
    ];
    $input_data = array_intersect_key($input_data, array_flip($validKeys));
    // echo '<pre>';
    // var_dump($input_data);
    // return;
    // $settings= array_keys($input_data);
    $res = $this->attendance_model->UPDATE_HOME_SETTINGS($input_data);
    // var_dump($res);die();
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Settings Successfully updated');
    } else {
      $this->session->set_flashdata('ERR', 'Settings Unable to update');
    }
    redirect($this->input->server('HTTP_REFERER'));
  }
  function add_new_fence()
  {
    $input_data = $this->input->post();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('area', 'Area', 'required');
    $this->form_validation->set_error_delimiters('', '');
    $validKeys = [
      'name',
      'area'
    ];
    $input_data = array_intersect_key($input_data, array_flip($validKeys));
    if ($this->form_validation->run() == FALSE) {
      $str_errors = form_error('name');
      $str_errors .= form_error('area');
      $this->session->set_flashdata('ERR', $str_errors);
    } else {
      $input_data['create_date'] = date('Y-m-d H:i:s');
      $input_data['edit_date'] = date('Y-m-d H:i:s');
      $res = $this->attendance_model->ADD_DATA('tbl_fence_areas', $input_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added new fence area');
      }
    }
    redirect('attendances/setting_geo_fences');
  }
  function update_fence()
  {
    $input_data = $this->input->post();
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('area', 'Area', 'required');
    $this->form_validation->set_error_delimiters('', '');
    $validKeys = [
      'name',
      'area',
      'id'
    ];
    $input_data = array_intersect_key($input_data, array_flip($validKeys));
    if ($this->form_validation->run() == FALSE) {
      $str_errors = form_error('name');
      $str_errors .= form_error('area');
      $this->session->set_flashdata('ERR', $str_errors);
    } else {
      $input_data['edit_date'] = date('Y-m-d H:i:s');
      $res = $this->attendance_model->UPDATE_ROW_DATA('tbl_fence_areas', $input_data, 'id', $input_data['id']);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully updated fence area');
      }
    }
    redirect('attendances/setting_geo_fences');
  }
  function setting_holidays()
  {
    $data["DISP_YEARS"] = $years = $this->attendance_model->GET_YEARS();
    $keyNamesArray = array();
    foreach ($years as $year) {
      $keyNamesArray[] = $year->name;
    }
    $data["yearNames"] = json_encode($keyNamesArray);
    $tab = $this->input->get('tab');
    if ($tab == null) {
      $tab = date("Y");
    }
    $data["C_TAB_SELECT"] = $tab;
    $selectColumns = [
      // ['selectStatement' => '*, DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
      ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
      ['selectStatement' => 'id,name,col_holi_type,status'],
    ];
    $filter = [
      ['year' => $tab],
    ];
    $table = 'tbl_std_holidays';
    $dataTable = $this->attendance_model->get_settings_table2($table, $filter, $selectColumns, 'col_holi_date', 'ASC');
    $dataTable = json_encode($dataTable);
    $data["C_DATA_TABLE"] = $dataTable;
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/setting_holidays_views', $data);
  }
  function update_setting_holidays()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    // $response           = array('data' => $data ); 
    try {
      $updatedData = $data['updatedData'];
      $keysToKeep = ['id', 'col_holi_date', 'name', 'col_holi_type', 'year', 'status'];
      $table = 'tbl_std_holidays';
      $filteredData = array_map(function ($obj) use ($keysToKeep) {
        return array_intersect_key($obj, array_flip($keysToKeep));
      }, $updatedData);
      $edit_user = $this->session->userdata('SESS_USER_ID');
      $failedInsert = 0;
      $inserted = 0;
      $failedUpdate = 0;
      $updated = 0;
      $unexpted = 0;
      foreach ($filteredData as $data) {
        $res = $this->attendance_model->update_setting_tables($table, $data, $edit_user);
        if ($res == 'failedInsert') {
          $failedInsert++;
        } else if ($res == 'inserted') {
          $inserted++;
        } else if ($res == 'failedUpdate') {
          $failedUpdate++;
        } else if ($res == 'updated') {
          $updated++;
        } else {
          $unexpted++;
        }
      }
      $response = array(
        'success_message' => 'Data updated successfully',
        'failedInsert' => $failedInsert,
        'inserted' => $inserted,
        'failedUpdate' => $failedUpdate,
        'updated' => $updated,
        'unexpted' => $unexpted,
        'res' => $res,
      );
      // $this->session->set_flashdata('SUCC','Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage(), 'filteredData', $filteredData);
      // $this->session->set_flashdata('ERR', 'Fail to add new data');
    }
    // $response = array('reload'=> true);
    echo json_encode($response);
  }
  function setting_years()
  {
    $selectColumns = [
      // ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
      ['selectStatement' => 'id,name,status'],
    ];
    $filter = [
      // ['year' => $tab],
    ];
    $table = 'tbl_std_years';
    $dataTable = $this->attendance_model->get_settings_table($table, $filter, $selectColumns);
    $dataTable = json_encode($dataTable);
    $data["C_DATA_TABLE"] = $dataTable;
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/setting_years_views', $data);
  }
  function update_setting_years()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    // $response           = array('data' => $data ); 
    try {
      $updatedData = $data['updatedData'];
      $keysToKeep = ['id', 'name', 'status'];
      $table = 'tbl_std_years';
      $filteredData = array_map(function ($obj) use ($keysToKeep) {
        return array_intersect_key($obj, array_flip($keysToKeep));
      }, $updatedData);
      $edit_user = $this->session->userdata('SESS_USER_ID');
      $failedInsert = 0;
      $inserted = 0;
      $failedUpdate = 0;
      $updated = 0;
      $unexpted = 0;
      foreach ($filteredData as $data) {
        $res = $this->attendance_model->update_setting_tables($table, $data, $edit_user);
        if ($res == 'failedInsert') {
          $failedInsert++;
        } else if ($res == 'inserted') {
          $inserted++;
        } else if ($res == 'failedUpdate') {
          $failedUpdate++;
        } else if ($res == 'updated') {
          $updated++;
        } else {
          $unexpted++;
        }
      }
      $response = array(
        'success_message' => 'Data updated successfully',
        'failedInsert' => $failedInsert,
        'inserted' => $inserted,
        'failedUpdate' => $failedUpdate,
        'updated' => $updated,
        'unexpted' => $unexpted,
        'res' => $res,
      );
      // $this->session->set_flashdata('SUCC','Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage(), 'filteredData', $filteredData);
      // $this->session->set_flashdata('ERR', 'Fail to add new data');
    }
    // $response = array('reload'=> true);
    echo json_encode($response);
  }
  function setting_remote_in_out()
  {
    $data['remoteCamera'] = $this->attendance_model->get_system_setup_by_setting('remoteCamera');
    $data['remoteGPS'] = $this->attendance_model->get_system_setup_by_setting('remoteGPS');
    $data['requireApprovers'] = $this->attendance_model->get_system_setup_by_setting('requireApprovers');
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/setting_remote_in_out_views', $data);
  }
  function update_setting_remote_in_out()
  {
    $input_data = $this->input->post();
    $validKeys = [
      'remoteGPS',
      'remoteCamera',
      'requireApprovers',
    ];
    $input_data = array_intersect_key($input_data, array_flip($validKeys));
    // echo '<pre>';
    // var_dump($input_data);
    // return;
    // $settings= array_keys($input_data);
    $res = $this->attendance_model->UPDATE_HOME_SETTINGS($input_data);
    // var_dump($res);die();
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Settings Successfully updated');
    } else {
      $this->session->set_flashdata('ERR', 'Settings Unable to update');
    }
    redirect($this->input->server('HTTP_REFERER'));
  }

  function setting_biometrics()
  {
    $selectColumns = [
      // ['selectStatement' => 'DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', 'useRaw' => false],
      ['selectStatement' => 'id,terminal_sn,name,status'],
    ];
    $filter = [
      // ['year' => $tab],
    ];
    $table = 'tbl_biometrics';
    $dataTable = $this->attendance_model->get_settings_table($table, $filter, $selectColumns);
    $dataTable = json_encode($dataTable);
    $data["C_DATA_TABLE"] = $dataTable;
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/setting_biometrics_views', $data);
  }
  function update_setting_biometrics()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    // $response           = array('data' => $data ); 
    try {
      $updatedData = $data['updatedData'];
      $keysToKeep = ['id', 'terminal_sn', 'name', 'status'];
      $table = 'tbl_biometrics';
      $filteredData = array_map(function ($obj) use ($keysToKeep) {
        return array_intersect_key($obj, array_flip($keysToKeep));
      }, $updatedData);
      $edit_user = $this->session->userdata('SESS_USER_ID');
      $failedInsert = 0;
      $inserted = 0;
      $failedUpdate = 0;
      $updated = 0;
      $unexpted = 0;
      foreach ($filteredData as $data) {
        $res = $this->attendance_model->update_setting_tables($table, $data, $edit_user);
        if ($res == 'failedInsert') {
          $failedInsert++;
        } else if ($res == 'inserted') {
          $inserted++;
        } else if ($res == 'failedUpdate') {
          $failedUpdate++;
        } else if ($res == 'updated') {
          $updated++;
        } else {
          $unexpted++;
        }
      }
      $response = array(
        'success_message' => 'Data updated successfully',
        'failedInsert' => $failedInsert,
        'inserted' => $inserted,
        'failedUpdate' => $failedUpdate,
        'updated' => $updated,
        'unexpted' => $unexpted,
        'res' => $res,
      );
      // $this->session->set_flashdata('SUCC','Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage(), 'filteredData', $filteredData);
      // $this->session->set_flashdata('ERR', 'Fail to add new data');
    }
    // $response = array('reload'=> true);
    echo json_encode($response);
  }
  function settings()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_setting_views');
  }
  function suminac_timekeep()
  {
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"] = $view_type = ['all', 'edit_user', $user];
    $data["module_name"] = $module = 'attendances';
    $data["page_name"] = $page_name = 'suminac_timekeep';
    $data["model_name"] = $model = "main_table_02_model";
    $data["table_name"] = $table = "tbl_attendance_suminac";
    $data["module"] = [base_url() . $module, "Attendances", "Suminac Assignment"];
    $data["id_prefix"] = "SUM";
    $data["excel_output"] = [true, "suminac_timekeep.xlsx"];
    $data["add_button"] = [true, "Add Entry  "];
    $data["status_text"] = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"] = $filter_row = [25, 50, 100];
    $c_data_tab = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"] = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"] =
      array(
        array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
        array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
        array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
        array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
        array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
        array("username", "text", 256, 1, 1, 1, 20, "Employee Name", "user", 1, "0"),
        array("name", "text", 256, 1, 1, 1, 15, "Allowance", "array1", 1, "0"),
        array("values", "text", 256, 1, 1, 1, 15, "Amount", "none", 1, "0"),
        array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
      );
    $search = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"] = $filter_row[0];
    $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    $data["C_ARRAY_1"] = $this->$model->get_allowance_name();
    $data["C_ARRAY_2"] = [];
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    $tab = $this->input->get('tab');
    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    if ($this->input->get('all') == null) {
      $data["C_DATA_TABLE"] = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
      $data["C_DATA_COUNT"] = $this->$model->get_data_count($table, $tab, $view_type);
    } else {
      $data["C_DATA_TABLE"] = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"] = $this->$model->get_data_count($table, $tab, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3] = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"] = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }
  function undertime()
  {
    $data['UNDERTIME'] = array();
    $data['DATE_FORMAT']                = $this->attendance_model->GET_SYSTEM_SETTING("date_format");
    $periods = $this->attendance_model->GET_PAYROLL_PERIOD();
    $period = null;
    $cut_off = $this->input->get('cut_off') ? $this->input->get('cut_off') : '';
    $date_from = null;
    $date_to = null;
    // Get the current date
    $currentDate = date('Y-m-d');
    // Get the first date of the current month
    $firstDateOfMonth = date('Y-m-01', strtotime($currentDate));
    // Get the last date of the current month
    $lastDateOfMonth = date('Y-m-t', strtotime($currentDate));
    if ($cut_off) {
      $period = $this->attendance_model->GET_SPE_PAYROLL_PERIOD($cut_off);
      $date_from = isset($period->date_from) ? $period->date_from : $firstDateOfMonth;
      $date_to = isset($period->date_to) ? $period->date_to : $lastDateOfMonth;
    }
    if (!$cut_off && !$periods) {
      $date_from = $firstDateOfMonth;
      $date_to = $lastDateOfMonth;
    }
    if (!$cut_off && $periods) {
      $date_from = $periods[0]->date_from;
      $date_to = $periods[0]->date_to;
    }
    $data['UNDERTIME'] = $this->attendance_model->GET_UNDERTIME($date_from, $date_to);
    $data['CUT_OFF_PERIOD'] = $periods;
    $data['CUT_OFF'] = $cut_off;
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/exempt_undertime_views', $data);
  }
  function exempt_undertime()
  {
    $input_data = $this->input->post();
    $attendance = $this->attendance_model->GET_ATTENDANCE($input_data['attendance_id']);
    //   echo '<pre>';
    //   var_dump($input_data);
    //   var_dump($attendace);
    //   return;
    $res = $this->attendance_model->UPDATE_EXEMPT_ATTENDANCE($input_data['attendance_id']);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Exempted Undertime Updated Succesfully!');
      $logdata['create_date'] = date('Y-m-d H:i:s');
      $logdata['type'] = 'exempt_undertime';
      $logdata['empl_id'] = $attendance->empl_id;
      $logdata['description'] = " Undertime attendance of " . $attendance->fullname . " on '22/01/2024' was exempted.<br>
                                  Reason: " . $input_data['description'];
      $this->attendance_model->ADD_DATA('tbl_activity_logs', $logdata);

      // Redirect with cut-off period
      $cut_off = $input_data['cut_off'];
      redirect('attendances/undertime?cut_off=' . $cut_off);
    }
  }

  function deduction_assign()
  {
    $user = $this->session->userdata('SESS_USER_ID');
    $data["view_type"] = $view_type = ['all', 'edit_user', $user];
    $data["module_name"] = $module = 'employees';
    $data["page_name"] = $page_name = 'deduction_assign';
    $data["model_name"] = $model = "main_table_02_model";
    $data["table_name"] = $table = "tbl_employee_deductionassign";
    $data["module"] = [base_url() . $module, "Employees", "Deduction Assignment"];
    $data["id_prefix"] = "DDA";
    $data["excel_output"] = [true, "deduction_assign.xlsx"];
    $data["add_button"] = [true, "Add Assignment"];
    $data["status_text"] = ["Active", "Inactive", "", ""];
    $data["C_ROW_DISPLAY"] = $filter_row = [25, 50, 100];
    $c_data_tab = array(
      array("Active", "status", "Active", 0),
      array("Inactive", "status", "Inactive", 0)
    );
    $data["C_BULK_BUTTON"] = array(
      array(true, "btn_mark_active", "far fa-check-circle", "Mark as Active", "status", "Active"),
      array(true, "btn_mark_inactive", "far fa-times-circle", "Mark as Inactive", "status", "Inactive")
    );
    $data["C_DB_DESIGN"] =
      array(
        array("id", "text", 0, 0, 0, 1, 5, "ID", "id", 1, "0"),
        array("create_date", "datetime-local", 0, 0, 0, 1, 10, "Create Date", "date", 1, "0"),
        array("edit_date", "datetime-local", 0, 0, 0, 0, 0, "Edit Date", "date", 1, "0"),
        array("edit_user", "text", 0, 0, 0, 0, 0, "Last Edited By", "user", 1, "0"),
        array("is_deleted", "text", 0, 0, 0, 0, 0, "Is Deleted", "none", 0, "0"),
        array("username", "text", 256, 1, 1, 1, 20, "Employee Name", "user", 1, "0"),
        array("name", "text", 256, 1, 1, 1, 15, "Deduction", "array1", 1, "0"),
        array("values", "text", 256, 1, 1, 1, 15, "Amount", "none", 1, "0"),
        array("status", "sel", 256, 1, 1, 1, 15, "Status", "status", 1, "Active;Inactive")
      );
    $search = str_replace('_', ' ', $this->input->get('all') ?? "");
    $data["default_row"] = $filter_row[0];
    $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    $data["C_ARRAY_1"] = $this->$model->get_deduction_name();
    $data["C_ARRAY_2"] = [];
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    $tab = $this->input->get('tab');
    if ($row == null) {
      $row = $filter_row[0];
    }
    if ($tab == null) {
      $tab = $c_data_tab[0][0];
    }
    $offset = $row * ($page - 1);
    $data["C_TAB_SELECT"] = $tab;
    if ($this->input->get('all') == null) {
      $data["C_DATA_TABLE"] = $this->$model->get_data_list($table, $offset, $row, $tab, $view_type);
      $data["C_DATA_COUNT"] = $this->$model->get_data_count($table, $tab, $view_type);
    } else {
      $data["C_DATA_TABLE"] = $this->$model->get_specific_data($table, $search, $row, $offset, $view_type);
      $data["C_DATA_COUNT"] = $this->$model->get_data_count($table, $tab, $view_type);
    }
    $i = 0;
    foreach ($c_data_tab as $c_data_tab_row) {
      $c_data_tab[$i][3] = $this->$model->get_display_count($table, $c_data_tab_row[1], $c_data_tab_row[2], $view_type);
      $i++;
    }
    $data["C_DATA_TAB"] = $c_data_tab;
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_02_views', $data);
  }
  function get_searched_employee()
  {
    $search = $this->input->post('search');
    $data = $this->attendance_model->MOD_GET_SEARCHED_DATA($search);
    echo (json_encode($data));
  }
  function attendance_lock()
  {
    $data["EMPL_ID"] = $user_id = $this->input->post('EMPL_ID');
    $data["PAYROLL_SCHED"] = $period = $this->input->post('PAYROLL_SCHED');
    if ($this->input->post('SUM_PRESENT') == "") {
      $data["SUM_PRESENT"] = 0;
    } else {
      $data["SUM_PRESENT"] = $this->input->post('SUM_PRESENT');
    }
    if ($this->input->post('SUM_ABSENT') == "") {
      $data["SUM_ABSENT"] = 0;
    } else {
      $data["SUM_ABSENT"] = $this->input->post('SUM_ABSENT');
    }
    if ($this->input->post('SUM_TARDINESS') == "") {
      $data["SUM_TARDINESS"] = 0;
    } else {
      $data["SUM_TARDINESS"] = $this->input->post('SUM_TARDINESS');
    }
    if ($this->input->post('SUM_UNDERTIME') == "") {
      $data["SUM_UNDERTIME"] = 0;
    } else {
      $data["SUM_UNDERTIME"] = $this->input->post('SUM_UNDERTIME');
    }
    if ($this->input->post('SUM_PAID_LEAVE') == "") {
      $data["SUM_PAID_LEAVE"] = 0;
    } else {
      $data["SUM_PAID_LEAVE"] = $this->input->post('SUM_PAID_LEAVE');
    }
    if ($this->input->post('SUM_EARLYBREAK') == "") {
      $data["SUM_EARLYBREAK"] = 0;
    } else {
      $data["SUM_EARLYBREAK"] = $this->input->post('SUM_EARLYBREAK');
    }
    if ($this->input->post('SUM_OVERBREAK') == "") {
      $data["SUM_OVERBREAK"] = 0;
    } else {
      $data["SUM_OVERBREAK"] = $this->input->post('SUM_OVERBREAK');
    }
    if ($this->input->post('SUM_REG_HOURS') == "") {
      $data["SUM_REG_HOURS"] = 0;
    } else {
      $data["SUM_REG_HOURS"] = $this->input->post('SUM_REG_HOURS');
    }
    if ($this->input->post('SUM_REG_OT') == "") {
      $data["SUM_REG_OT"] = 0;
    } else {
      $data["SUM_REG_OT"] = $this->input->post('SUM_REG_OT');
    }
    if ($this->input->post('SUM_REG_ND') == "") {
      $data["SUM_REG_ND"] = 0;
    } else {
      $data["SUM_REG_ND"] = $this->input->post('SUM_REG_ND');
    }
    if ($this->input->post('SUM_REG_NDOT') == "") {
      $data["SUM_REG_NDOT"] = 0;
    } else {
      $data["SUM_REG_NDOT"] = $this->input->post('SUM_REG_NDOT');
    }
    if ($this->input->post('SUM_REST_HOURS') == "") {
      $data["SUM_REST_HOURS"] = 0;
    } else {
      $data["SUM_REST_HOURS"] = $this->input->post('SUM_REST_HOURS');
    }
    if ($this->input->post('SUM_REST_OT') == "") {
      $data["SUM_REST_OT"] = 0;
    } else {
      $data["SUM_REST_OT"] = $this->input->post('SUM_REST_OT');
    }
    if ($this->input->post('SUM_REST_ND') == "") {
      $data["SUM_REST_ND"] = 0;
    } else {
      $data["SUM_REST_ND"] = $this->input->post('SUM_REST_ND');
    }
    if ($this->input->post('SUM_REST_NDOT') == "") {
      $data["SUM_REST_NDOT"] = 0;
    } else {
      $data["SUM_REST_NDOT"] = $this->input->post('SUM_REST_NDOT');
    }
    if ($this->input->post('SUM_LEG_HOURS') == "") {
      $data["SUM_LEG_HOURS"] = 0;
    } else {
      $data["SUM_LEG_HOURS"] = $this->input->post('SUM_LEG_HOURS');
    }
    if ($this->input->post('SUM_LEG_OT') == "") {
      $data["SUM_LEG_OT"] = 0;
    } else {
      $data["SUM_LEG_OT"] = $this->input->post('SUM_LEG_OT');
    }
    if ($this->input->post('SUM_LEG_ND') == "") {
      $data["SUM_LEG_ND"] = 0;
    } else {
      $data["SUM_LEG_ND"] = $this->input->post('SUM_LEG_ND');
    }
    if ($this->input->post('SUM_LEG_NDOT') == "") {
      $data["SUM_LEG_NDOT"] = 0;
    } else {
      $data["SUM_LEG_NDOT"] = $this->input->post('SUM_LEG_NDOT');
    }
    if ($this->input->post('SUM_LEGREST_HOURS') == "") {
      $data["SUM_LEGREST_HOURS"] = 0;
    } else {
      $data["SUM_LEGREST_HOURS"] = $this->input->post('SUM_LEGREST_HOURS');
    }
    if ($this->input->post('SUM_LEGREST_OT') == "") {
      $data["SUM_LEGREST_OT"] = 0;
    } else {
      $data["SUM_LEGREST_OT"] = $this->input->post('SUM_LEGREST_OT');
    }
    if ($this->input->post('SUM_LEGREST_ND') == "") {
      $data["SUM_LEGREST_ND"] = 0;
    } else {
      $data["SUM_LEGREST_ND"] = $this->input->post('SUM_LEGREST_ND');
    }
    if ($this->input->post('SUM_LEGREST_NDOT') == "") {
      $data["SUM_LEGREST_NDOT"] = 0;
    } else {
      $data["SUM_LEGREST_NDOT"] = $this->input->post('SUM_LEGREST_NDOT');
    }
    if ($this->input->post('SUM_SPE_HOURS') == "") {
      $data["SUM_SPE_HOURS"] = 0;
    } else {
      $data["SUM_SPE_HOURS"] = $this->input->post('SUM_SPE_HOURS');
    }
    if ($this->input->post('SUM_SPE_OT') == "") {
      $data["SUM_SPE_OT"] = 0;
    } else {
      $data["SUM_SPE_OT"] = $this->input->post('SUM_SPE_OT');
    }
    if ($this->input->post('SUM_SPE_ND') == "") {
      $data["SUM_SPE_ND"] = 0;
    } else {
      $data["SUM_SPE_ND"] = $this->input->post('SUM_SPE_ND');
    }
    if ($this->input->post('SUM_SPE_NDOT') == "") {
      $data["SUM_SPE_NDOT"] = 0;
    } else {
      $data["SUM_SPE_NDOT"] = $this->input->post('SUM_SPE_NDOT');
    }
    if ($this->input->post('SUM_SPEREST_HOURS') == "") {
      $data["SUM_SPEREST_HOURS"] = 0;
    } else {
      $data["SUM_SPEREST_HOURS"] = $this->input->post('SUM_SPEREST_HOURS');
    }
    if ($this->input->post('SUM_SPEREST_OT') == "") {
      $data["SUM_SPEREST_OT"] = 0;
    } else {
      $data["SUM_SPEREST_OT"] = $this->input->post('SUM_SPEREST_OT');
    }
    if ($this->input->post('SUM_SPEREST_ND') == "") {
      $data["SUM_SPEREST_ND"] = 0;
    } else {
      $data["SUM_SPEREST_ND"] = $this->input->post('SUM_SPEREST_ND');
    }
    if ($this->input->post('SUM_SPEREST_NDOT') == "") {
      $data["SUM_SPEREST_NDOT"] = 0;
    } else {
      $data["SUM_SPEREST_NDOT"] = $this->input->post('SUM_SPEREST_NDOT');
    }
    $response = $this->attendance_model->IS_DUPLICATE_LOCK($user_id, $period);
    $response;
    if ($response == 0) {
      $this->attendance_model->INSERT_ATTENDANCE_LOCK($data);
    } else {
      $this->attendance_model->UPDATE_ATTENDANCE_LOCK($data);
    }
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  function attendance_records()
  {
    //------------------- GET GLOBAL URI VARIABLES ----------------------------------
    $company        = $this->input->get("company");
    $branch         = $this->input->get("branch");
    $dept           = $this->input->get("dept");
    $division       = $this->input->get("division");
    $section        = $this->input->get("section");
    $group          = $this->input->get("group");
    $team           = $this->input->get("team");
    $line           = $this->input->get("line");
    $status         = $this->input->get("status");
    $period         = $this->input->get("period");
    $employee       = $this->input->get("employee");

    if ($company == null || $company == 'undefined') {
      $company = '';
    }
    if ($branch == null || $branch == 'undefined') {
      $branch = '';
    }
    if ($dept == null || $dept == 'undefined') {
      $dept = '';
    }
    if ($division == null || $division == 'undefined') {
      $division = '';
    }
    if ($section == null || $section == 'undefined') {
      $section = '';
    }
    if ($group == null || $group == 'undefined') {
      $group = '';
    }
    if ($team == null || $team == 'undefined') {
      $team = '';
    }
    if ($line == null || $line == 'undefined') {
      $line = '';
    }
    if ($status == null || $status == 'undefined') {
      $status = '';
    }

    $eagleridge_attendance_record = $this->attendance_model->GET_EAGLE_RIDGE_SETTING('eagleridge_attendace_record');

    //------------------- GET FILTERED LIST OF EMPLOYEES LIST FOR FRONTEND ----------------------------------
    $employee_list = $this->attendance_model->FILTER_ATTENDANCE_RECORDS($dept, $company, $section, $group, $division, $branch, $team);
    if (!empty($employee_list)) {
      if ($employee == null || $employee == 'undefined') {
        $employee_id = $employee_list[0]->id;
      } else {
        $employee_id = $employee;
      }
    }
    if (empty($employee_list)) {
      $employee_id = '';
    }
    //------------------- GET PAYROLL PERIOD LIST FOR FRONTEND----------------------------------
    $payroll_list = $this->attendance_model->MOD_DISP_PAY_SCHED();
    if ($period == null) {
      $period = $payroll_list[0]->id;
    }
    //------------------- GET EMPLOYEE INFORMATION ----------------------------------
    $date_period = $this->attendance_model->GET_PERIOD_DATA($period);
    $date_from = $date_period['date_from'];
    $date_to = $date_period['date_to'];
    $cutoff_data = $this->attendance_model->MON_DISP_CUTOFF_PERIOD($date_from, $date_to, $employee_id);
    $disp_lock_data = 0;
    $disp_payslip_data = 0;
    $disp_leave_data = 0;
    $disp_time_data = 0;
    $disp_overtime_data = 0;
    $disp_holiday_data = 0;
    if ($employee_id) {
      $response = $this->attendance_model->IS_DUPLICATE_LOCK($employee_id, $period);
      if ($response == 0) {
        $disp_lock_data = 0;
      } else {
        $disp_lock_data = 1;
      }
      $response = $this->attendance_model->IS_PAYSLIP($employee_id, $period);
      if ($response == 0) {
        $disp_payslip_data = 0;
      } else {
        $disp_payslip_data = 1;
      }
      $response = $this->attendance_model->IS_LEAVE($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_leave_data = 0;
      } else {
        $disp_leave_data = 1;
      }
      $response = $this->attendance_model->IS_TIME($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_time_data = 0;
      } else {
        $disp_time_data = 1;
      }
      $response = $this->attendance_model->IS_OVERTIME($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_overtime_data = 0;
      } else {
        $disp_overtime_data = 1;
      }
      $response = $this->attendance_model->IS_HOLIDAY($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_holiday_data = 0;
      } else {
        $disp_holiday_data = 1;
      }
    }

    $unpaid_ot = $this->attendance_model->GET_APPROVED_UNPAID_OT($employee_id);
    // $total_ot = $this->attendance_model->GET_TOTAL_OT($employee_id);


    $time_data                                  = $this->attendance_model->GET_ATTENDANCE_RECORD($employee_id);
    $salary_type                                = $this->attendance_model->GET_SALARY_TYPE($employee_id);
    $salary_rate                                = $this->attendance_model->GET_SALARY_RATE($employee_id);
    $work_days                                  = $this->attendance_model->GET_WORK_DAYS($employee_id);
    $approved_leaves                            = $this->attendance_model->GET_APPROVED_LEAVES($employee_id, $date_from, $date_to);
    $approved_change_shift                      = $this->attendance_model->GET_APPROVED_CHANGE_SHIFT($employee_id, $date_from, $date_to);
    $approved_changeoff_shift                   = $this->attendance_model->GET_APPROVED_CHANGEOFF_SHIFT($employee_id);
    $approved_offsets                           = $this->attendance_model->GET_APPROVED_OFFSET($employee_id, $date_from, $date_to);
    $leave_typelist                             = $this->attendance_model->GET_LEAVE_NAMES();
    $approved_ot                                = $this->attendance_model->GET_APPROVED_OT($employee_id, $date_from, $date_to);
    $shift_assignment                           = $this->attendance_model->GET_SHIFT_ASSIGN_SPECIFIC($employee_id);
    $shift_data                                 = $this->attendance_model->GET_WORK_SHIFT_DATA();
    $min_hrs_present                            = $this->attendance_model->GET_MIN_HOURS_PRESENT();
    $chk_lateundertime_deductiontype            = $this->attendance_model->GET_LATEUNDERTIME_DEDUCTIONTYPE();
    $chk_late_deduction_perminute               = $this->attendance_model->GET_SETTING_VALUE('timekeeping_late_deduction_perminute');
    $chk_undertime_deduction_perminute          = $this->attendance_model->GET_SETTING_VALUE('timekeeping_undertime_deduction_perminute');
    $approved_undertime                         = $this->attendance_model->GET_APPROVED_UNDERTIME($employee_id, $date_from, $date_to);
    $approved_undertime_exempt                  = $this->attendance_model->GET_APPROVED_UNDERTIME_EXEMPT($employee_id, $date_from, $date_to);

    $chk_graceperiod                            = $this->attendance_model->GET_GRACEPERIOD();
    $zkteco_time_data                           = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD($employee_id);

    $begin                              = new DateTime($date_from);
    $end                                = new DateTime($date_to);
    $end                                = $end->modify('+1 day');
    $holidays                           = $this->attendance_model->GET_HOLIDAY();
    $interval                           = new DateInterval('P1D');
    $daterange                          = new DatePeriod($begin, $interval, $end);
    $data_arr                           = array();
    $index                              = 0;
    $error_shift_assign                 = 0;
    $sum_present                        = 0;
    $sum_absent                         = 0;
    $sum_absent_col                     = 0;
    $sum_tardiness                      = 0;
    $sum_undertime                      = 0;
    $sum_slider                         = 0;
    $sum_earlybreak                     = 0;
    $sum_overbreak                      = 0;
    // $total_ot                           = 0;
    $sum_paid_leave                     = 0;
    $sum_lwop                           = 0;
    $sum_awol                           = 0;
    $slider                             = 0;
    $sum_reg_hours                      = 0;
    $sum_reg_regot                      = 0;
    $sum_reg_nd                         = 0;
    $sum_reg_ndot                       = 0;
    $sum_rest_hours                     = 0;
    $sum_rest_regot                     = 0;
    $sum_rest_nd                        = 0;
    $sum_rest_ndot                      = 0;
    $sum_leg_hours                      = 0;
    $sum_leg_spe_hours                  = 0;
    $sum_leg_regot                      = 0;
    $sum_leg_nd                         = 0;
    $sum_leg_ndot                       = 0;
    $sum_legrest_hours                  = 0;
    $sum_legrest_regot                  = 0;
    $sum_legrest_nd                     = 0;
    $sum_legrest_ndot                   = 0;
    $sum_spe_hours                      = 0;
    $sum_spe_regot                      = 0;
    $sum_spe_nd                         = 0;
    $sum_spe_ndot                       = 0;
    $sum_sperest_hours                  = 0;
    $sum_sperest_regot                  = 0;
    $sum_sperest_nd                     = 0;
    $sum_sperest_ndot                   = 0;

    $additional_reg_hrs                 = 0;
    $additional_reg_hrs_count           = 0;




    $is_work1      =  0;
    $is_work2      =  0;
    $is_work3      =  0;

    $is_paidleave1      =  0;
    $is_paidleave2      =  0;
    $is_paidleave3      =  0;


    $is_work         = 0;
    $is_paidleave    = 0;
    //-*********************** PROCESS ATTENDANCE PER DAY  ******************************
    foreach ($daterange as $date) {

      $current_date = $date->format("Y-m-d");

      // var_dump($current_date);

      $date_name = $date->format("d/m/Y (D)");
      $date_pdf = $date->format("Y/m/d D");
      $shift_name = '-';
      $shift_regular_start = '00:00';
      $shift_regular_end = '00:00';
      $shift_regular_end_date = '0000-00-00 00:00';
      $shift_break_start = '00:00';
      $shift_break_end = '00:00';
      $shift_overtime_start = '00:00';
      $shift_overtime_end = '00:00';
      $shift_regular_enable = 0;
      $shift_regular_reg = 0;
      $shift_nd_hours = 0;
      $shift_break_enable = 0;
      $shift_break_hours = 0;
      $shift_overtime_enable = 0;
      $shift_overtime_ot = 0;
      $shift_overtime_nd = 0;
      $shift_pdf = '-';
      $shift_color = '#555555';
      $hol_code = "REGULAR";
      $zkteco_time_in = "00:00";
      $zkteco_time_out = "00:00";
      $zkteco_break_in = "00:00";
      $zkteco_break_out = "00:00";
      $remote_time_in = "00:00";
      $remote_time_out = "00:00";
      $remote_break_in = "00:00";
      $remote_break_out = "00:00";
      $raw_time_in = '00:00';
      $raw_time_out = '00:00';
      $raw_break_in = '00:00';
      $raw_break_out = '00:00';
      $raw_shift_time_regular_start = '00:00';
      $raw_shift_time_regular_end = '00:00';
      $raw_shift_break_time_in = '00:00';
      $raw_shift_break_time_out = '00:00';
      $shift_break_hours = 0;
      $reg_hrs = 0;
      $lwop = 0;
      $awol = 0;
      $calculate_work_duration = 0;
      $tardiness = 0;
      $undertime = 0;
      $exempt_undertime = 0;
      $work_hours = 0;
      $absent = 0;
      $remarks = '-';
      $paid_leave = 0;
      $paid_leave_type = '-';
      $early_ot = 0;
      $reg_ot = 0;
      $nd_ot = 0;
      $holiday_ot = 0;
      $nd = 0;
      $leave_type = 0;
      $leave_typename = '-';
      $earlybreak = 0;
      $overbreak = 0;

      $flag_legal_rest_daily_notpresent  = 0;
      $request_undertime_out = '00:00';
      $approved_offset = 0;
      //------------------- GET SHIFT DATA  ----------------------------------
      foreach ($shift_assignment as $shift_assignment_row) {
        if ($shift_assignment_row->date == $current_date) {
          foreach ($shift_data as $shift_data_row) {
            if ($shift_assignment_row->shift_id == $shift_data_row->id) {
              // var_dump($shift_data_row->time_regular_end);
              $shift_name = $shift_data_row->code;
              $shift_regular_enable = $shift_data_row->time_regular_enable;
              $shift_regular_start = date("H:i", strtotime($shift_data_row->time_regular_start));
              $shift_regular_end = date("H:i", strtotime($shift_data_row->time_regular_end));
              $shift_regular_end_date = date("Y-m-d H:i", strtotime($current_date . ' ' . $shift_data_row->time_regular_end));
              $shift_regular_reg = $shift_data_row->time_regular_reg;
              $shift_nd_hours = $shift_data_row->time_regular_nd;
              $shift_break_enable = $shift_data_row->time_break_enable;
              $shift_break_start = date("H:i", strtotime($shift_data_row->time_break_start));
              $shift_break_end = date("H:i", strtotime($shift_data_row->time_break_end));
              $shift_break_hours = $shift_data_row->time_break_hours;
              $shift_overtime_enable = $shift_data_row->time_overtime_enable;
              $shift_overtime_start = date("H:i", strtotime($shift_data_row->time_overtime_start));
              $shift_overtime_end = date("H:i", strtotime($shift_data_row->time_overtime_end));
              $shift_overtime_ot = $shift_data_row->time_overtime_ot;
              $shift_overtime_nd = $shift_data_row->time_overtime_nd;
              if ($shift_data_row->code == "REST") {
                $shift_name = "REST";
              }
              $shift_color = $shift_data_row->color;
              $raw_shift_time_regular_start = $shift_data_row->time_regular_start;
              $raw_shift_time_regular_end = $shift_data_row->time_regular_end;
              $raw_shift_break_time_in = $shift_data_row->time_break_start;
              $raw_shift_break_time_out = $shift_data_row->time_break_end;
              $shift_pdf = $shift_data_row->code;
              break;
            }
          }
          break;
        }
      }




      //------------------- GET HOLIDAY DATA  ----------------------------------
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $current_date) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $hol_code = "LEGAL";
          } else {
            $hol_code = "SPECIAL";
          }
          break;
        }
      }
      $time_in_array = [];
      $time_out_array = [];
      $break_in_array = [];
      $break_out_array = [];




      if ($hol_code == "LEGAL") {
        $previousDate1 = (new DateTime($current_date))->modify("-1 day")->format('Y-m-d');
        $previousDate2 = (new DateTime($current_date))->modify("-2 days")->format('Y-m-d');
        $previousDate3 = (new DateTime($current_date))->modify("-3 days")->format('Y-m-d');


        if ($index >= 3) {
          $shift_day1 =  $data_arr[$index - 1]["shift"];
          $shift_day2 =  $data_arr[$index - 2]["shift"];
          $shift_day3 =  $data_arr[$index - 3]["shift"];

          $is_work1      =  $data_arr[$index - 1]['reg_hrs'] >= 4 ? 1 : 0;
          $is_work2      =  $data_arr[$index - 2]['reg_hrs'] >= 4 ? 1 : 0;
          $is_work3      =  $data_arr[$index - 3]['reg_hrs'] >= 4 ? 1 : 0;

          $is_paidleave1      =  $data_arr[$index - 1]['paid_leave'] >= 4 ? 1 : 0;
          $is_paidleave2      =  $data_arr[$index - 2]['paid_leave'] >= 4 ? 1 : 0;
          $is_paidleave3      =  $data_arr[$index - 3]['paid_leave'] >= 4 ? 1 : 0;
        } else {
          $shift_day1 = $shift_day2 = $shift_day3 = null;
          $is_work1 = $is_work2 = $is_work3 = 0;
          $is_paidleave1 = $is_paidleave2 = $is_paidleave3 = 0;
        }


        $is_work         = 0;
        $is_paidleave    = 0;

        if ($shift_day1 == "REST") {
          if ($shift_day2 == "REST") {
            if ($shift_day3 == "REST") {
              $is_work  = 1;
              $is_paidleave  = 1;
            } else {
              $is_work = $is_work3;
              $is_paidleave  = $is_paidleave3;
            }
          } else {
            $is_work = $is_work2;
            $is_paidleave  = $is_paidleave2;
          }
        } else {
          $is_work = $is_work1;
          $is_paidleave  = $is_paidleave1;
        }
      }

      $eligibleforholidayleave = ($is_work || $is_paidleave) ? 1 : 0;


      //------------------- GET BIOMETRICS TIMEKEEPING DATA  ----------------------------------


      foreach ($zkteco_time_data as $zkteco_time_data_row) {
        if (date("Y-m-d", strtotime($zkteco_time_data_row->punch_time)) == $current_date) {
          if ($zkteco_time_data_row->punch_state == 0) {
            array_push($time_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } elseif ($zkteco_time_data_row->punch_state == 4) {
            array_push($break_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } elseif ($zkteco_time_data_row->punch_state == 5) {
            array_push($break_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } else {
            array_push($time_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          }
        }
      }
      if ($time_in_array) {
        $oldest_in_time = min(array_map('strtotime', $time_in_array));
        $zkteco_time_in = date("H:i", $oldest_in_time);
      }
      if ($time_out_array) {
        $latest_time_out = max(array_map('strtotime', $time_out_array));
        $zkteco_time_out = date("H:i", $latest_time_out);
      }
      if ($break_in_array) {
        $oldest_in_break = min(array_map('strtotime', $break_in_array));
        $zkteco_break_in = date("H:i", $oldest_in_break);
      }
      if ($break_out_array) {
        $latest_break_out = min(array_map('strtotime', $break_out_array));
        $zkteco_break_out = date("H:i", $latest_break_out);
      }
      $snapshot_in = null;
      $snapshot_out = null;
      $time_in_address = null;
      $time_out_address = null;
      $break_in_snapshot = null;
      $break_in_address = null;
      $break_out_snapshot = null;
      $break_out_address = null;

      //------------------- GET REMOTE TIMEKEEPING DATA  ----------------------------------
      foreach ($time_data as $time_data_row) {
        if ($time_data_row->date == $current_date) {
          if (!is_null($time_data_row->time_in)) {
            $remote_time_in = date("H:i", strtotime($time_data_row->time_in));
          } else {
            $remote_time_in = "00:00";
          }
          if (!is_null($time_data_row->time_out)) {
            $remote_time_out = date("H:i", strtotime($time_data_row->time_out));
          } else {
            $remote_time_out = "00:00";
          }
          if (!is_null($time_data_row->break_in)) {
            $remote_break_in = date("H:i", strtotime($time_data_row->break_in));
          } else {
            $remote_break_in = "00:00";
          }
          if (!is_null($time_data_row->break_out)) {
            $remote_break_out = date("H:i", strtotime($time_data_row->break_out));
          } else {
            $remote_break_out = "00:00";
          }
          $snapshot_in = $time_data_row->snapshot_in;
          $snapshot_out = $time_data_row->snapshot_out;
          $time_in_address = $time_data_row->time_in_address;
          $time_out_address = $time_data_row->time_out_address;
          $break_in_snapshot = $time_data_row->break_in_snapshot;
          $break_in_address = $time_data_row->break_in_address;
          $break_out_snapshot = $time_data_row->break_out_snapshot;
          $break_out_address = $time_data_row->break_out_address;
          break;
        }
      }
      if ($zkteco_time_in != "00:00" && $remote_time_in != "00:00") {
        $raw_time_in = min($remote_time_in, $zkteco_time_in);
      } else if ($zkteco_time_in != "00:00" && $remote_time_in == "00:00") {
        $raw_time_in = $zkteco_time_in;
      } else {
        $raw_time_in = $remote_time_in;
      }
      if ($zkteco_time_out != "00:00" && $remote_time_out != "00:00") {
        $raw_time_out = max($remote_time_out, $zkteco_time_out);
      } else if ($zkteco_time_out != "00:00" && $remote_time_out == "00:00") {
        $raw_time_out = $zkteco_time_out;
      } else {
        $raw_time_out = $remote_time_out;
      }
      if ($zkteco_break_in != "00:00" && $remote_break_in != "00:00") {
        $raw_break_in = min($remote_break_in, $zkteco_break_in);
      } else if ($zkteco_break_in != "00:00" && $remote_break_in == "00:00") {
        $raw_break_in = $zkteco_break_in;
      } else {
        $raw_break_in = $remote_break_in;
      }
      if ($zkteco_break_out != "00:00" && $remote_break_out != "00:00") {
        $raw_break_out = max($remote_break_out, $zkteco_break_out);
      } else if ($zkteco_break_out != "00:00" && $remote_break_out == "00:00") {
        $raw_break_out = $zkteco_break_out;
      } else {
        $raw_break_out = $remote_break_out;
      }


      //------------------- GET APPROVED LEAVES  ----------------------------------   
      foreach ($approved_leaves as $approved_leaves_row) {

        if ($approved_leaves_row->leave_date == $current_date) {

          $leave_type_name = $this->attendance_model->GET_SPECIFIC_LEAVE_NAME($approved_leaves_row->type);


          if ($leave_type_name != "Leave without Pay (LWOP)") {
            $paid_leave = $approved_leaves_row->duration;

            $leave_type = $approved_leaves_row->type;
            foreach ($leave_typelist as $leave_typelist_row) {
              if ($leave_type == $leave_typelist_row->id) {
                $leave_typename = $leave_typelist_row->name;
              }
            }
            break;
          } else {
            $lwop = $approved_leaves_row->duration;
            break;
          }
        }
      }
      
      //------------------- GET APPROVED CHANGE SHIFT  ---------------------------------- 
      foreach ($approved_change_shift as $approved_change_row) {
        if ($approved_change_row->date_shift == $current_date) {
          $this->attendance_model->UPDATE_CHANGESHIFT($approved_change_row->empl_id, $approved_change_row->date_shift, $approved_change_row->request_shift);
        }
      }

      //------------------- GET APPROVED CHANGE SHIFT  ---------------------------------- 
      foreach ($approved_changeoff_shift as $approved_changeoff_row) {
        if ($approved_changeoff_row->date_shift == $current_date) {
          $this->attendance_model->UPDATE_CHANGESHIFT($approved_changeoff_row->empl_id, $approved_changeoff_row->date_shift, $approved_changeoff_row->request_shift);
          $this->attendance_model->UPDATE_CHANGESHIFT($approved_changeoff_row->empl_id, $approved_changeoff_row->date_shift_to, $approved_changeoff_row->request_shift_to); 
        } 
      }

      


      
      //------------------- GET APPROVED OFFSET  ----------------------------------  
      foreach ($approved_offsets as $offset) {

        if ($offset->offset_date == $current_date) {
          $approved_offset = $offset->duration;
          break;
        }
      }


 
      //--------------------------------- GET APPROVED UNDERTIME ------------------------------------
      foreach ($approved_undertime as $row_undertime) {
        if ($row_undertime->date_undertime == $current_date){
          $request_undertime_out = $row_undertime->request_time_out;
        }
      }

      //--------------------------------- GET APPROVED EXEMPT UNDERTIME ------------------------------------
      foreach ($approved_undertime_exempt as $row_undertime) {
        if ($row_undertime->date_undertime == $current_date){
          $exempt_undertime = 1;
          $remarks = "Clear Club";
        }
      }

      //------------------- GET APPROVED OT  ----------------------------------   
      foreach ($approved_ot as $approved_ot_row) {
        if ($approved_ot_row->date_ot == $current_date) {

          if ($approved_ot_row->type == "Regular" || $approved_ot_row->type == "Regular Day") {
            if($approved_ot_row->early_ot){
              $early_ot = $approved_ot_row->early_ot;
            }
            $reg_ot = $approved_ot_row->hours;
          } 
          // else {

          //   $nd_ot = $approved_ot_row->hours; //$nd_ot = $approved_ot_row->hours;
          // }

          $nd_ot = $approved_ot_row->ndot;
          break;
        }
      }
      // var_dump($early_ot);
      $early_overtime = 0;
      $overtime = 0;
      $night_start = strtotime('22:00:00'); // Night starts at 22:00 (10:00 PM)
      $night_end = strtotime('06:00:00'); // Night ends at 06:00 (6:00 AM) the next day

      $time_regular_start = strtotime($raw_shift_time_regular_start);
      $time_regular_end = strtotime($raw_shift_time_regular_end);
      $actual_time_in = strtotime($raw_time_in);
      $actual_time_out = strtotime($raw_time_out);

      // Adjust time_out for next day if it's earlier than time_in
      if ($actual_time_out <= $actual_time_in) {
        $actual_time_out = strtotime('+1 day', $actual_time_out);
      }

      // Check for early overtime (early arrival)
      if ($actual_time_in < $time_regular_start) {
          if ($early_ot >= 1) {
              $early_overtime = ($time_regular_start - $actual_time_in) / 3600; // Convert seconds to hours
              
              // Round early overtime to nearest 0.5 (30 minutes)
              $early_overtime = floor($early_overtime * 2) / 2;
          }
      }

      if ($early_ot < 1) {
          if ($early_overtime < 1) {
              $early_overtime = 0;
          } else {
              // Even if early_ot < 1, if there's early overtime, round it
              $early_overtime = floor($early_overtime * 2) / 2;
          }
      }
    
      // Calculate Overtime
      if ($actual_time_out > $time_regular_end) {
          if ($reg_ot >= 1) {
              if ($actual_time_out > $night_start) {
                  $overtime = ($night_start - $time_regular_end) / 3600;
              } else {
                  $overtime = ($actual_time_out - $time_regular_end) / 3600; // Convert seconds to hours
              }
              
              // Round overtime to nearest 0.5 (30 minutes)
              $overtime = floor($overtime * 2) / 2;
              
              if ($raw_shift_time_regular_end == "00:00:00" && $raw_shift_time_regular_start == "00:00:00") {
                  $total_worked_hours = ($actual_time_out - $actual_time_in) / 3600;
                  if ($total_worked_hours >= 8) {
                      $total_worked_hours -= 1;
                  }
                  
                  // Round total worked hours to nearest 0.5 for overtime calculation
                  $overtime = floor($total_worked_hours * 2) / 2;
              }
          }
      }
      
      if($reg_ot < 1){
        if($overtime < 1){
          $overtime = 0;
        }
      }

      if($reg_ot > $overtime){
        $reg_ot = $overtime;
      }

      if($early_ot > $early_overtime){
        $early_ot = $early_overtime;
      }
    
      
      $reg_ot += $early_ot;
      // var_dump($overtime);
      // var_dump($reg_ot);

      if ($paid_leave != 0) {
        if ($hol_code == "REGULAR") {
          $remarks = "Approved Leave";
          $shift_color = "#D6ECD7";
        } else if ($hol_code == "LEGAL") {
          $remarks = "ERR:LV on HOL";
          $paid_leave = 0;
        } else if ($hol_code == "SPECIAL") {
          $remarks = "ERR:LV on HOL";
        }
      }

      //-------- MONTHLY  
      if ($salary_type == "Monthly") {
        //--- A. CHECK IF LEAVE TYPE IS HOURLY/DAILY
        $is_leave_hours = $this->attendance_model->get_leaves_settings_by_setting('isLeaveHours', '1');  // 0 = Day, 1 = Hours(Default)

        //--- B. IF LEAVE TYPES IS DAYS, WHOLEDAY IS EQUIVALENT TO SHIFT REGULAR HOURS
        if ($is_leave_hours == 0) { // <---  0 = DAYS (EAGLERIDGE), 1 = HOURS
          if ($paid_leave == 8) {
            $paid_leave = $shift_regular_reg;
          }
        }

        //--- C. WORKING DAYS
        if ($shift_name != '-' && $shift_name != 'REST') {
          if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {

            //---------------- ACTUAL TIME IN - SHIFT IN  MINUTES-------------------
            $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
            if ($in_min < 0) {
              $in_min = 0;
            }

            //---------------- TARDINESS CALCULATION -------------------
            // Compare if the tardiness is within the Grace Period
            // Check the Deduction Type; 0 = by 0.5 deduction, 1 = by minutes deduction
            // $chk_lateundertime_deductiontype = 1;

            if (!function_exists('truncate')) {
              function truncate($value, $decimals)
              {
                $factor = pow(10, $decimals);
                return floor($value * $factor) / $factor;
              }
            }

            if ($chk_graceperiod < $in_min) {
              if ($chk_late_deduction_perminute == 1) {     //1 = PER MINUTE, +0.5 = EVERY 30 MINS
                $tardiness = $in_min / 60;
                // Truncate to two decimal places
                $tardiness = truncate($tardiness, 2);
              } else {
                $tardiness = ceil($in_min / 30) / 2;
              }
            } else {
              $tardiness = 0;
            }

            //-------------------------------------- SHIFT TIME OUT - ACTUAL OUT MINUTES --------------------------------------- 
            $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');

            if ($out_min < 0) {
              $out_min = 0;
            }

            // ---------------------------------------- NIGHT DIFFERENTIAL Attendance Record------------------------------------------------------

            $night_start = strtotime('22:00:00'); // Night starts at 22:00 (10:00 PM)
            $night_end = strtotime('06:00:00');   // Night ends at 06:00 (6:00 AM)
            $shift_regular_with_grace_period = date("H:i",strtotime($shift_regular_start . " +10 minutes"));
            
            if ($raw_time_in <= $shift_regular_with_grace_period) {
              $raw_time_in_nd = $shift_regular_start;
            } else {
              $raw_time_in_nd = $raw_time_in;
            }
              
            $raw_time_out_2 = $raw_time_out;
            if (strtotime($raw_time_out) < strtotime($raw_time_in_nd)) {
              $raw_time_out_2 = strtotime('+1 day', strtotime($raw_time_out));
            }
      
            // Initialize the night differential hours
            $night_diff_hours = 0;
  
            // Case 1: Calculate overlap of time_in within the night differential (04:00 to 06:00)
            if ($raw_time_in_nd <= $night_end) {
                // Calculate the overlap until 06:00 AM or the time_out, whichever comes first
                $nd += min($night_end, strtotime($raw_time_out_2)) - strtotime($raw_time_in_nd);
            }
        
            // Case 2: Calculate overlap of time_out within the night differential (22:00 to 23:00 or further)
            if($raw_time_out_2 > strtotime($shift_regular_end)){
              $raw_time_out_2 = strtotime($shift_regular_end);
            }
            if ($raw_time_out_2 > $night_start) {
                // Calculate the overlap starting from 22:00 PM until time_out or max overlap with time_in
                $nd += strtotime($raw_time_out_2) - max($night_start, strtotime($raw_time_in_nd));
            }
        
            // Convert seconds to hours
            $nd = $nd / 3600;
        
            // Ensure that the night differential is within the shift time
            if ($nd > 0) {
                $shift_duration = (strtotime($shift_regular_end) - strtotime($shift_regular_start)) / 3600; // Total shift duration in hours
                $nd = min($nd, $shift_duration); // Night differential should not exceed shift hours
            }

            if ($nd <= 0 ) {
              $nd = 0;
            }

            $nd = $this->round_night_diff($nd);

            // if (date('H', strtotime($raw_time_out)) > date('H', $night_start)) {

            //   $start          = strtotime('22:00:00');
            //   $end            = strtotime($raw_time_out);
            //   $shift_end      = strtotime($shift_regular_end);

            //   // Check if raw_time_out is greater than shift_regular_end
            //   if ($shift_end > $start) {

            //     // Calculate the difference in seconds
            //     $diffSeconds = $end - $start;

            //     // Convert seconds to hours
            //     $totalHours = $diffSeconds / 3600;
            //     // Increment night hours
            //     $nd += $totalHours;
            //   }
            // }

            // if (date('H', strtotime($raw_time_out))  <= date('H', $night_end)) {
            //   $start          = strtotime('22:00:00');
            //   $end            = strtotime($raw_time_out);
            //   $shift_end      = strtotime($shift_regular_end);

            //   // Check if raw_time_out is greater than shift_regular_end
            //   if ($end > $shift_end) {
            //     $end = $shift_end; // Set end time to shift_regular_end
            //   }

            //   // If the end time is before the start time, it means it crosses midnight
            //   if ($end < $start) {
            //     $end += 24 * 3600; // Add 24 hours in seconds
            //   }

            //   // Calculate the difference in seconds
            //   $diffSeconds = $end - $start;

            //   // Convert seconds to hours
            //   $totalHours = $diffSeconds / 3600;
            //   // Increment night hours
            //   $nd += $totalHours;
            // }

            // if (date('H', strtotime('01:00:00')) < date('H', strtotime($raw_time_in)) && date('H', $night_end) > date('H', strtotime($raw_time_in))) {

            //   $time_in_start      = strtotime($raw_time_in);
            //   $shift_end          = strtotime($shift_regular_start);

            //   if ($time_in_start < $shift_end) {
            //     $time_in_start =  $shift_end;
            //   }

            //   $diffSeconds = $night_end - $time_in_start;

            //   $totalHours = $diffSeconds / 3600;
            //   // Increment night hours
            //   $nd += $totalHours;
            // }


            //---------------- UNDERTIME  CALCULATION -------------------
            // Check the Deduction Type; 0 = by 0.5 deduction, 1 = by minutes deduction
            // $chk_lateundertime_deductiontype = 0;
            if ($chk_undertime_deduction_perminute == 1) {
              $undertime = $out_min / 60;
            } else {
              $undertime = (ceil($out_min / 30) / 2);
            }

            // EAGLERIDGE RULES MINIMUM OF 30 MINS TARDINESS
            if ($undertime <= 0.5 && $undertime > 0) {
              $undertime = 0.5;
            }

            if ($exempt_undertime) {
              $undertime = 0;
            }

            //---------------- EARLY BREAK CALCULATION -------------------
            $earlybreak = 0;
            if ($raw_break_in != "00:00") {
              $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
              if ($break_in_min < 0) {
                $break_in_min = 0;
              }
              if ($chk_late_deduction_perminute == 1) {
                $earlybreak = $break_in_min / 60;
              } else {
                $earlybreak = (ceil($break_in_min / 30) / 2);
              }
            }

            //---------------- OVER BREAK CALCULATION -------------------
            $overbreak = 0;
            if ($raw_break_in != "00:00") {
              $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
              if ($break_out_min < 0) {
                $break_out_min = 0;
              }
              if ($chk_late_deduction_perminute == 1) {
                $overbreak = $overbreak / 60;
              } else {
                $overbreak = (ceil($overbreak / 30) / 2);
              }
            }

            //-------------------------------------- CALCULATION ---------------------------------------
            // FOR SCENARIO THAT LEAVE IS GREATER THAN WORKING HOURS

            if ($paid_leave >= $shift_regular_reg) {
              $paid_leave = $shift_regular_reg;
            }

            if ($paid_leave > 0) {
              $tardiness = 0;
              $undertime = 0;
            }


            // HOURS NEEDED TO BE RENDERED BY THE USER
            if ($paid_leave == 0 && $shift_regular_reg >= 9.5) {
              $additional_reg_hrs_count += 1;
            }

            if ($tardiness >= 5) {
              $tardiness -= 1;
            }
            if ($undertime >= 5) {
              $undertime -= 1;
            }
   

            $reg_hrs = $shift_regular_reg - $paid_leave - $lwop;
       
          //============================ Offset request =============================
            if ($approved_offset > 0) {
              $tardiness -= $approved_offset;
              $undertime -= $approved_offset;
              $remarks = "Offset";
              $reg_hrs += $approved_offset;

              if($undertime < 0){
                $undertime = 0;
              }
              if($tardiness < 0){
                $tardiness = 0;
              }
            }

           //============================ undertime request =============================
            if($request_undertime_out != '00:00'){
              $out_min = $this->convert_time_to_float($raw_time_out, 'minute');
              $undertime_out_min = $this->convert_time_to_float($request_undertime_out, 'minute');
              
              $total_undertime =  $undertime_out_min - $out_min;
              $undertime =  $total_undertime / 60;
              if($undertime < 0){
                $undertime = 0;
              }
              $remarks = "Clear Club";
            }
  
            if ($reg_hrs < 0) {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $earlybreak = 0;
              $overbreak = 0;

              $awol = $shift_regular_reg - $paid_leave - $lwop;
              $absent = $awol + $lwop;
              $remarks = "Invalid IN/OUT, Absent";
            }

          } else {
            $reg_hrs = 0;
            $tardiness = 0;
            $undertime = 0;
            $awol = $shift_regular_reg - $paid_leave - $lwop;
            $absent = $awol + $lwop;
            if ($awol < 0) {
              $awol = 0;
            }

            if ($awol > 0 && $paid_leave != 0) {
              $remarks = "Partially Absent, Approved Leave";
            } elseif ($awol == 0 && ($paid_leave != 0 || $lwop != 0)) {
              $remarks = "Approved Leave";
            } elseif ($awol > 0) {
              $remarks = "NO IN/OUT, Absent";
            }

            if ($approved_offset > 0) {
              $remarks = "Offset";
              $reg_hrs += $approved_offset;
            }

          }

          $slider += $this->slider($raw_time_in, $shift_regular_start);
          $raw_time_in;
          $raw_time_out;
          $raw_shift_time_regular_start;
          $raw_shift_time_regular_end;
          $work_hours;
          $calculate_work_duration;
        } else if ($shift_name == 'REST') { // if the employee worked in his/her rest day this code makes the count to zero so I removed it.

          $in_min = $this->convert_time_to_float($raw_time_in, 'minute');
          $out_min = $this->convert_time_to_float($raw_time_out, 'minute');

          $leg_rest_hours = ($out_min - $in_min) / 60;
          if ($leg_rest_hours > 8) {
            $leg_rest_hours = $leg_rest_hours - 1;
          }
          $reg_hrs = $leg_rest_hours;
          // $reg_ot = 0;
          // $nd = 0;
          // $nd_ot = 0;
        } else {
          $reg_ot = 0;
          $nd = 0;
          $nd_ot = 0;
          $remarks = "No Shift";
          $error_shift_assign = 1;
        }

        foreach ($approved_changeoff_shift as $approved_changeoff_row) {
        if ($approved_changeoff_row->date_shift_to == $current_date) {
            $remarks = "Change off to ". $approved_changeoff_row->date_shift;
        }
        if ($approved_changeoff_row->date_shift == $current_date) {
            $remarks = "Change off to ". $approved_changeoff_row->date_shift_to;
        }
      }

      

       foreach ($approved_change_shift  as $approved_change_row) {
        if ($approved_change_row->date_shift == $current_date) {
            $shift_name = $this->attendance_model->GET_WORK_SHIFT_NAME($approved_change_row->request_shift);
            $remarks = "Change shift from ". $approved_change_row->current_shift;
        }
      }
      if ($lwop > 0) {
        $remarks = "Approved LWOP";
      }

        
      } elseif ($salary_type == "Daily") {

        if ($shift_name != '-' && !($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {
          $work_hours = $shift_regular_reg - $paid_leave;
   
          if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {
            $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
            if ($in_min < 0) {
              $in_min = 0;
            }

            //---------------- TARDINESS CALCULATION -------------------
            // Compare if the tardiness is within the Grace Period
            // Check the Deduction Type; 0 = by 0.5 deduction, 1 = by minutes deduction
            // $chk_lateundertime_deductiontype = 1;
            if (!function_exists('truncate')) {
              function truncate($value, $decimals)
              {
                $factor = pow(10, $decimals);
                return floor($value * $factor) / $factor;
              }
            }

            if ($chk_graceperiod < $in_min) {
              if ($chk_late_deduction_perminute == 1) {     //1 = PER MINUTE, +0.5 = EVERY 30 MINS
                $tardiness = $in_min / 60;
                $tardiness = round($tardiness, 2);

                // Truncate to two decimal places
                $tardiness = truncate($tardiness, 2);
              } else {
                $tardiness = ceil($in_min / 30) / 2;
              }
            } else {
              $tardiness = 0;
            }

            $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');
            if ($out_min < 0) {
              $out_min = 0;
            }
            // ---------------------------------------- NIGHT DIFFERENTIAL Attendance Record------------------------------------------------------

            $night_start = strtotime('22:00:00'); // Night starts at 22:00 (10:00 PM)
            $night_end = strtotime('06:00:00');   // Night ends at 06:00 (6:00 AM)
            $shift_regular_with_grace_period = date("H:i",strtotime($shift_regular_start . " +10 minutes"));
            
            if ($raw_time_in <= $shift_regular_with_grace_period) {
              $raw_time_in_nd = $shift_regular_start;
            } else {
              $raw_time_in_nd = $raw_time_in;
            }
              
            $raw_time_out_2 = $raw_time_out;
            if (strtotime($raw_time_out) < strtotime($raw_time_in_nd)) {
              $raw_time_out_2 = strtotime('+1 day', strtotime($raw_time_out));
            }
      
            // Initialize the night differential hours
            $night_diff_hours = 0;
  
            // Case 1: Calculate overlap of time_in within the night differential (04:00 to 06:00)
            if ($raw_time_in_nd <= $night_end) {
                // Calculate the overlap until 06:00 AM or the time_out, whichever comes first
                $nd += min($night_end, strtotime($raw_time_out_2)) - strtotime($raw_time_in_nd);
            }
        
            // Case 2: Calculate overlap of time_out within the night differential (22:00 to 23:00 or further)
            if($raw_time_out_2 > strtotime($shift_regular_end)){
              $raw_time_out_2 = strtotime($shift_regular_end);
            }
            if ($raw_time_out_2 > $night_start) {
                // Calculate the overlap starting from 22:00 PM until time_out or max overlap with time_in
                $nd += strtotime($raw_time_out_2) - max($night_start, strtotime($raw_time_in_nd));
            }
        
            // Convert seconds to hours
            $nd = $nd / 3600;
        
            // Ensure that the night differential is within the shift time
            if ($nd > 0) {
                $shift_duration = (strtotime($shift_regular_end) - strtotime($shift_regular_start)) / 3600; // Total shift duration in hours
                $nd = min($nd, $shift_duration); // Night differential should not exceed shift hours
            }

            if ($nd <= 0 ) {
              $nd = 0;
            }

            $nd = $this->round_night_diff($nd);

            // if (date('H', strtotime($raw_time_out)) > date('H', $night_start)) {
            //   $start          = strtotime('22:00:00');
            //   $end            = strtotime($raw_time_out);
            //   $shift_end      = strtotime($shift_regular_end);
            //   // Check if raw_time_out is greater than shift_regular_end
            //   if ($shift_end > $start) {
            //     // Calculate the difference in seconds
            //     $diffSeconds = $end - $start;
            //     // Convert seconds to hours
            //     $totalHours = $diffSeconds / 3600;
            //     // Increment night hours
            //     $nd += $totalHours;
            //   }
            // }
            // var_dump($raw_time_out);

            // if (date('H', strtotime($raw_time_out))  <= date('H', $night_end)) {

            //   $start          = strtotime('22:00:00');
            //   $end            = strtotime($raw_time_out);
            //   $shift_end      = strtotime($shift_regular_end);
            //   // Check if raw_time_out is greater than shift_regular_end
            //   if ($end > $shift_end) {
            //     $end = $shift_end; // Set end time to shift_regular_end
            //   }
            //   // If the end time is before the start time, it means it crosses midnight
            //   if ($end < $start) {
            //     $end += 24 * 3600; // Add 24 hours in seconds
            //   }
            //   // Calculate the difference in seconds
            //   $diffSeconds = $end - $start;
            //   // Convert seconds to hours
            //   $totalHours = $diffSeconds / 3600;
            //   // Increment night hours
            //   $nd += $totalHours; //5
            // }


            // if (date('H', strtotime('01:00:00')) < date('H', strtotime($raw_time_in)) && date('H', $night_end) > date('H', strtotime($raw_time_in))) {
            //   $time_in_start      = strtotime($raw_time_in);
            //   $shift_end          = strtotime($shift_regular_start);
            //   if ($time_in_start < $shift_end) {
            //     $time_in_start =  $shift_end;
            //   }
            //   $diffSeconds = $night_end - $time_in_start;
            //   $totalHours = $diffSeconds / 3600;
            //   // Increment night hours
            //   $nd += $totalHours; //2
            // }



            //---------------- UNDERTIME  -------------------
            // Check the Deduction Type; 0 = by 0.5 deduction, 1 = by minutes deduction
            // $chk_lateundertime_deductiontype = 0;
            if ($chk_undertime_deduction_perminute == 1) {
              $undertime = $out_min / 60;
            } else {
              $undertime = ceil($out_min / 30) / 2;
            }
            //EAGLERIDGE RULES MINIMUM OF 30 MINS TARDINESS
            if ($undertime < 0.5 && $undertime > 0) {
              $undertime = 0.5;
            }

            if ($exempt_undertime) {
              $undertime = 0;
            }

            //---------------- EARLY BREAK CALCULATION -------------------
            $earlybreak = 0;
            if ($raw_break_in != "00:00") {
              $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
              if ($break_in_min < 0) {
                $break_in_min = 0;
              }
              $earlybreak = ceil($break_in_min / 30) / 2;
            }
            //---------------- OVER BREAK CALCULATION -------------------
            $overbreak = 0;
            if ($raw_break_in != "00:00") {
              $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
              if ($break_out_min < 0) {
                $break_out_min = 0;
              }
              $overbreak = ceil($break_out_min / 30) / 2;
            }

            $awol = $absent - $lwop;

            //-------------------------------------- CALCULATION ---------------------------------------
            // FOR SCENARIO THAT LEAVE IS GREATER THAN WORKING HOURS

            if ($paid_leave >= $shift_regular_reg) {
              $paid_leave = $shift_regular_reg;
            }

            if ($paid_leave > 0) {
              $tardiness = 0;
              $undertime = 0;
            }

            // HOURS NEEDED TO BE RENDERED BY THE USER
            if ($paid_leave == 0 && $shift_regular_reg >= 9.5) {
              $additional_reg_hrs_count += 1;
            }

            if ($tardiness >= 5) {
              $tardiness -= 1;
            }
            if ($undertime >= 5) {
              $undertime -= 1;
            }

            $reg_hrs = $work_hours - $awol - $lwop;


            //============================ Offset request =============================
            if ($approved_offset > 0) {
              $tardiness -= $approved_offset;
              $undertime -= $approved_offset;
              $remarks = "Offset";
              $reg_hrs += $approved_offset;

              if($undertime < 0){
                $undertime = 0;
              }
              if($tardiness < 0){
                $tardiness = 0;
              }
            }

                      
            //============================ undertime request =============================
            if($request_undertime_out != '00:00'){
              $out_min = $this->convert_time_to_float($raw_time_out, 'minute');
              $undertime_out_min = $this->convert_time_to_float($request_undertime_out, 'minute');
              
              $total_undertime =  $undertime_out_min - $out_min;
              $undertime =  $total_undertime / 60;
              if($undertime < 0){
                $undertime = 0;
              }
              $remarks = "Approved Undertime";
             }


            if ($eligibleforholidayleave == 0 && $hol_code == "LEGAL") {
              $reg_hrs = 0;
            }



            if ($reg_hrs < 0) {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = 0;
              $earlybreak = 0;
              $overbreak = 0;
              
            }

          } elseif ($raw_time_in == "00:00" && $raw_time_out == "00:00") {
            $reg_hrs = 0;
            $tardiness = 0;
            $undertime = 0;
            $awol = 0;
            $earlybreak = 0;
            $overbreak = 0;


            if ($paid_leave == 0) {
              $remarks = "Did not report";
            }

            if ($approved_offset > 0) {
              $remarks = "Offset";
              $reg_hrs += $approved_offset;
            }


          } else {
            $reg_hrs = 0;
            $tardiness = 0;
            $undertime = 0;
            $awol = 0;
            $earlybreak = 0;
            $overbreak = 0;
            $remarks = "Incomplete Time Record";
          }
          $slider += $this->slider($raw_time_in, $shift_regular_start);
          $raw_time_in;
          $raw_time_out;
          $raw_shift_time_regular_start;
          $raw_shift_time_regular_end;
          $work_hours;
          $calculate_work_duration;
        } else if ($shift_name == 'REST') {
          // $reg_ot = 0; // if the employee worked in his/her rest day this code makes the count to zero so I removed it.

          // ====================================== raw time in calculation =================================
          // Split the time string by colon (:)
          $time_in_parts = explode(':', $raw_time_in);

          // Access the minutes part (index 1 after splitting)
          $hours = (int) $time_in_parts[0];
          $minutes = (int) $time_in_parts[1]; // Convert to integer if needed

          if ($minutes <= 30 && $minutes > 0) {
            $minutes = 30;
          } elseif ($minutes > 30 && $minutes <= 59) {
            $minutes = 0;
            $hours += 1;
          }
          $rest_hour_time_in = sprintf('%02d:%02d', $hours, $minutes);

          // ===================================== raw time out calculation ===============================

          // Split the time string by colon (:)
          $time_out_parts = explode(':', $raw_time_out);

          // Access the minutes part (index 1 after splitting)
          $hours_out = (int) $time_out_parts[0];
          $minutes_out = (int) $time_out_parts[1]; // Convert to integer if needed

          if ($minutes_out >= 30 && $minutes_out <= 59) {
            $minutes_out = 30;
          } elseif ($minutes_out >= 0 && $minutes_out < 30) {
            $minutes_out = 0;
          }
          $rest_hour_time_out = sprintf('%02d:%02d', $hours_out, $minutes_out);

          // ======================================== actual rest time calculation =============================
          $in_min = $this->convert_time_to_float($rest_hour_time_in, 'minute');
          $out_min = $this->convert_time_to_float($rest_hour_time_out, 'minute');

          $leg_rest_hours = ($out_min - $in_min) / 60;

          if ($leg_rest_hours > 8) {
            $leg_rest_hours = $leg_rest_hours - 1;
          }

          $reg_hrs = $leg_rest_hours;

          // $nd = 0;
          // $nd_ot = 0;

          // if ($hol_code == "LEGAL" && $reg_hrs == 0) {
          //   $reg_hrs = 8;
          //   $flag_legal_rest_daily_notpresent = 1;
          // }
        } else if ($shift_name == "HOLIDAY LEAVE" || $shift_name == 'HOLIDAY OFF') {

          $reg_ot = 0;
          $nd = 0;
          $nd_ot = 0;

          // if ($hol_code == "LEGAL" && $reg_hrs == 0) {
          //   $reg_hrs = 8;
          //   $flag_legal_rest_daily_notpresent = 1;
          // }
        } else {
          $reg_ot = 0;
          $nd = 0;
          $nd_ot = 0;
          $remarks = "No Shift";
          $error_shift_assign = 1;
        }
        // $tardiness = 0;
        // $undertime = 0;
        // $absent = 0;
        // $awol = 0;
        // $lwop = 0;
        // $earlybreak = 0;
        // $overbreak = 0;
        //------------------- GET APPROVED CHANGE SHIFT THEN ADD REMARKS---------------------------------- 
      foreach ($approved_changeoff_shift as $approved_changeoff_row) {
        if ($approved_changeoff_row->date_shift_to == $current_date) {
            $remarks = "Change off to ". $approved_changeoff_row->date_shift;
        }
        if ($approved_changeoff_row->date_shift == $current_date) {
            $remarks = "Change off to ". $approved_changeoff_row->date_shift_to;
        }
      }
      
        if ($lwop > 0) {
        $remarks = "Approved LWOP";
      }
      }

      if ($hol_code != "REGULAR") {
        $calculate_work_duration = 0;
        $work_hours = 0;

        $absent = 0;
        $awol = 0;
        // $lwop = 0;
        $earlybreak = 0;
        $overbreak = 0;
      }
    

      
      



      // if ($eagleridge_attendance_record == 1 && $reg_hrs > 0) {
      //   $sum_present += $reg_hrs;
      // }


      if ($reg_hrs >= $min_hrs_present) {

        if ($hol_code == "LEGAL" &&  ($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {
        } else {
          $sum_present += 1;
        }
      }

      $yesterday = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));



      if ($lwop >= 0) {
        $sum_lwop += $lwop;
      }
      if ($awol >= 0) {
        $sum_awol += $awol;
      }
      if (($absent >= 0) && (strtotime($yesterday) >= strtotime($current_date))) {
        $sum_absent     += $absent;
      }
      if (($lwop >= 0 || $awol >= 0) && (strtotime($yesterday) >= strtotime($current_date))) {
        $sum_absent_col = $lwop + $awol;
      }

      if ($tardiness >= 0) {
        $sum_tardiness += $tardiness;
      }
      if ($undertime >= 0) {
        $sum_undertime += $undertime;
      }
      if ($paid_leave >= 0) {
        $sum_paid_leave += $paid_leave;
      }
      if ($earlybreak >= 0) {
        $sum_earlybreak += $earlybreak;
      }
      if ($overbreak >= 0) {
        $sum_overbreak += $overbreak;
      }
      // if ($reg_ot >= 0) {
      //   $total_ot += $reg_ot;  // total overtime
      // }
      //back

      // night differential should be greater than 1
      if ($nd < 1) {
        $nd = 0;
      }

      if ($hol_code == "REGULAR" &&  !($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {
        if ($reg_hrs > 0) {
          $sum_reg_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_reg_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_reg_ndot += $nd_ot;
        }
        // var_dump($sum_reg_ndot);
        if ($nd > 0) {
          $sum_reg_nd += $nd;
        }
      } elseif ($hol_code == "REGULAR" &&  ($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {
        // var_dump($reg_ot);
        if ($reg_hrs > 0) {
          $sum_rest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_rest_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_rest_ndot += $nd_ot;
        }
        if ($nd > 0) {
          $sum_rest_nd += $nd;
        }
      } elseif ($hol_code == "LEGAL" && !($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {
        if ($salary_type == "Monthly") {
          $sum_leg_hours += 8;
        } elseif ($salary_type == "Daily") {
          if ($reg_hrs > 0) {
            $sum_leg_hours += 8;
          }
        }

        if ($reg_hrs > 0) {
          $sum_reg_hours += $reg_hrs;
        }
        if ($reg_ot > 0) { //holiday_ot
          $sum_leg_regot += $reg_ot; //holiday_ot
        }
        if ($nd_ot > 0) {
          $sum_leg_ndot += $nd_ot;
        }
        if ($nd > 0) {
          $sum_leg_nd += $nd;
        }
      } elseif ($hol_code == "LEGAL" && ($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {

        if ($salary_type == "Monthly") {
          $sum_legrest_hours += $reg_hrs;
        } elseif ($salary_type == "Daily") {
          if ($reg_hrs > 0) {
            $sum_legrest_hours += $reg_hrs;
          }
        }

        // if ($flag_legal_rest_daily_notpresent == 1) {
        //   $sum_leg_hours += 8;
        // } else {

        if ($reg_hrs > 0) {
          $sum_reg_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_legrest_regot += $reg_ot; //holiday_ot
        }
        if ($nd_ot > 0) {
          $sum_legrest_ndot += $nd_ot;
        }
        if ($nd > 0) {
          $sum_legrest_nd += $nd;
        }

        // }
      } elseif ($hol_code == "SPECIAL" && !($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {
        if ($reg_hrs > 0) {
          $sum_reg_hours += $reg_hrs;
          $sum_spe_hours += 8;
        }
        if ($reg_ot > 0) {
          $sum_spe_regot += $reg_ot; //$holiday_ot
        }
        if ($nd_ot > 0) {
          $sum_spe_ndot += $nd_ot;
        }
        if ($nd > 0) {
          $sum_spe_nd += $nd;
        }
      } elseif ($hol_code == "SPECIAL" && ($shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {
        if ($reg_hrs > 0) {
          $sum_sperest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_sperest_regot += $reg_ot; //$holiday_ot
        }
        if ($nd_ot > 0) {
          $sum_sperest_ndot += $nd_ot;
        }
        if ($nd > 0) {
          $sum_sperest_nd += $nd;
        }
      }


      if (($hol_code == "LEGAL" || $hol_code == "SPECIAL") && ($shift_name == 'CHANGE OFF' || $shift_name == 'REST' || $shift_name == 'HOLIDAY LEAVE' || $shift_name == 'HOLIDAY OFF')) {

        if ($reg_hrs <= 0) {
          $sum_leg_spe_hours = 8;
          $sum_leg_hours += 8;
          $sum_sperest_hours += 8;
        }
      } else {
        $sum_leg_spe_hours = 0;
      }


      if ($sum_leg_spe_hours == 0) {
        $sum_leg_hours_disp = '';
      } else {
        $sum_leg_hours_disp = number_format($sum_leg_spe_hours, 2);
      }

      if ($reg_hrs == 0) {
        $reg_hrs_disp = '';
      } else {
        $reg_hrs_disp = number_format($reg_hrs, 2);
      }
      if ($absent == 0) {
        $absent_disp = '';
      } else {
        $absent_disp = number_format($absent, 2);
      }

      if ($lwop == 0) {
        $lwop_disp = '';
      } elseif ($yesterday >= $current_date) {
        $lwop_disp = number_format($lwop, 2);
      }

      if ($lwop == 0) {
        $lwop_disp = '';
      } else {
        $lwop_disp = number_format($lwop, 2);
      }

      $sum_absent_disp = '';
      if ($sum_absent_col == 0) {
        $sum_absent_disp = '';
      } elseif ($sum_absent_col && $yesterday >= $current_date) {
        $sum_absent_disp = number_format($sum_absent_col, 2);
        // var_dump($sum_absent_col && $yesterday >= $current_date);
      }

      $awol_disp      = '';
      if ($awol == 0) {
        $awol_disp = '';
      } elseif ($awol && $yesterday >= $current_date) {
        $awol_disp      = number_format($awol, 2);
      }

      if ($tardiness == 0) {
        $tardiness_disp = '';
      } else {
        $tardiness_disp = number_format($tardiness, 2);
      }
      if ($undertime == 0) {
        $undertime_disp = '';
      } else {
        $undertime_disp = number_format($undertime, 2);
      }
      if ($paid_leave == 0) {
        $paid_leave_disp = '';
      } else {
        $paid_leave_disp = number_format($paid_leave, 2);
      }
      if ($reg_ot == 0) {
        $reg_ot_disp = '';
      } else {
        $reg_ot_disp = number_format($reg_ot, 2);
      }

      if ($nd_ot == 0) {
        $nd_ot_disp = '';
      } else {
        $nd_ot_disp = number_format($nd_ot, 2);
      }
      if ($nd == 0) {
        $nd_disp = '';
      } else {
        $nd_disp = number_format($nd, 2);
      }
      if ($raw_time_in == "00:00") {
        $raw_time_in = '';
      }
      if ($raw_time_out == "00:00") {
        $raw_time_out = '';
      }
      if ($raw_break_in == "00:00") {
        $raw_break_in = '';
      }
      if ($raw_break_out == "00:00") {
        $raw_break_out = '';
      }
      if ($shift_regular_start == "00:00") {
        $shift_regular_start = '';
      }
      if ($shift_regular_end == "00:00") {
        $shift_regular_end = '';
      }
      if ($shift_name == "REST") {
        $shift_regular_start = '';
        $shift_regular_end = '';
      }
      if ($shift_break_start == "00:00") {
        $shift_break_start = '';
      }
      if ($shift_break_end == "00:00") {
        $shift_break_end = '';
      }
      if ($shift_overtime_start == "00:00") {
        $shift_overtime_start = '';
      }
      if ($shift_overtime_end == "00:00") {
        $shift_overtime_end = '';
      }
      if ($earlybreak == 0) {
        $earlybreak_disp = '';
      } else {
        $earlybreak_disp = number_format($earlybreak, 2);
      }
      if ($overbreak == 0) {
        $overbreak_disp = '';
      } else {
        $overbreak_disp = number_format($overbreak, 2);
      }
      $data_arr[$index]["Date"]                     = $date_name;
      $data_arr[$index]["Date_PDF"]                 = $date_pdf;
      $data_arr[$index]["holi_type"]                = $hol_code;
      $data_arr[$index]["shift"]                    = $shift_name;
      $data_arr[$index]["shift_regular_start"]      = $shift_regular_start;
      $data_arr[$index]["shift_regular_end"]        = $shift_regular_end;
      $data_arr[$index]["shift_break_start"]        = $shift_break_start;
      $data_arr[$index]["shift_break_end"]          = $shift_break_end;
      $data_arr[$index]["shift_overtime_start"]     = $shift_overtime_start;
      $data_arr[$index]["shift_overtime_end"]       = $shift_overtime_end;
      $data_arr[$index]["earlybreak"]               = $earlybreak_disp;
      $data_arr[$index]["overbreak"]                = $overbreak_disp;
      $data_arr[$index]["shift_PDF"]                = $shift_pdf;
      $data_arr[$index]["shift_color"]              = $shift_color;
      $data_arr[$index]['time_in']                  = $raw_time_in;
      $data_arr[$index]['time_out']                 = $raw_time_out;
      $data_arr[$index]['break_in']                 = $raw_break_in;
      $data_arr[$index]['break_out']                = $raw_break_out;
      $data_arr[$index]['reg_hrs']                  = $reg_hrs_disp;
      $data_arr[$index]['leg_spe']                  = $sum_leg_hours_disp;
      $data_arr[$index]['absent']                   = $sum_absent_disp;
      $data_arr[$index]['lwop']                     = $lwop_disp;
      $data_arr[$index]['awol']                     = $awol_disp;
      $data_arr[$index]['tardiness']                = $tardiness_disp;
      $data_arr[$index]['undertime']                = $undertime_disp;
      $data_arr[$index]['paid_leave']               = $paid_leave_disp;
      $data_arr[$index]['nd']                       = $nd_disp;
      $data_arr[$index]['shift_reg_ot']             = "";
      $data_arr[$index]['shift_nd_ot']              = "";
      $data_arr[$index]['reg_ot']                   = $reg_ot_disp;
      $data_arr[$index]['nd_ot']                    = $nd_ot_disp;
      $data_arr[$index]['remarks']                  = $remarks;
      $data_arr[$index]["snapshot_in"]             = $snapshot_in;
      $data_arr[$index]["snapshot_out"]            = $snapshot_out;
      $data_arr[$index]["time_in_address"]         = $time_in_address;
      $data_arr[$index]["time_out_address"]        = $time_out_address;
      $data_arr[$index]["break_in_snapshot"]       = $break_in_snapshot;
      $data_arr[$index]["break_in_address"]        = $break_in_address;
      $data_arr[$index]["break_out_snapshot"]      = $break_out_snapshot;
      $data_arr[$index]["break_out_address"]       = $break_out_address;
      $index += 1;
    }

    if ($additional_reg_hrs_count >= 10) {
      $additional_reg_hrs = 1;
    } else if ($additional_reg_hrs_count >= 5 && $additional_reg_hrs_count < 10) {
      $additional_reg_hrs = 0.5;
    }
    $sum_reg_hours += $additional_reg_hrs;
    //------------------- FORMAT SUM  ----------------------------------

    if ($sum_present == 0) {
      $sum_present = '';
    } elseif ($eagleridge_attendance_record == 1 && $sum_present != 0) { // if eagleridge is enable
      $sum_present = number_format($sum_present / 8, 2);
    } elseif ($eagleridge_attendance_record == 0 && $sum_present != 0) {
      $sum_present = number_format($sum_present, 2);
    }

    if ($sum_tardiness == 0) {
      $sum_tardiness = '';
    } else {
      $sum_tardiness = number_format($sum_tardiness, 2);
    }
    if ($sum_undertime == 0) {
      $sum_undertime = '';
    } else {
      $sum_undertime = number_format($sum_undertime, 2);
    }
    if ($sum_earlybreak == 0) {
      $sum_earlybreak = '';
    } else {
      $sum_earlybreak = number_format($sum_earlybreak, 2);
    }
    if ($sum_overbreak == 0) {
      $sum_overbreak = '';
    } else {
      $sum_overbreak = number_format($sum_overbreak, 2);
    }
    // if ($total_ot == 0) {
    //   $total_ot = '';
    // } else {
    //   $total_ot = number_format($total_ot, 2);
    // }
    if ($sum_slider == 0) {
      $sum_slider = '';
    } else {
      $sum_slider = number_format($sum_slider, 2);
    }
    if ($sum_paid_leave == 0) {
      $sum_paid_leave = '';
    } else {
      $sum_paid_leave = number_format($sum_paid_leave, 2);
    }
    if ($sum_absent == 0) {
      $sum_absent = '';
    } else {
      $sum_absent = number_format($sum_absent, 2);
    }
    if ($sum_lwop == 0) {
      $sum_lwop = '';
    } else {
      $sum_lwop = number_format($sum_lwop, 2);
    }
    if ($sum_awol == 0) {
      $sum_awol = '';
    } else {
      $sum_awol = number_format($sum_awol, 2);
    }
    if ($sum_reg_hours == 0) {
      $sum_reg_hours = '';
    } else {
      $sum_reg_hours = number_format($sum_reg_hours, 2);
    }
    if ($sum_reg_regot == 0) {
      $sum_reg_regot = '';
    } else {
      $sum_reg_regot = number_format($sum_reg_regot, 2);
    }
    if ($sum_reg_nd == 0) {
      $sum_reg_nd = '';
    } else {
      $sum_reg_nd = number_format($sum_reg_nd, 2);
    }
    if ($sum_reg_ndot == 0) {
      $sum_reg_ndot = '';
    } else {
      $sum_reg_ndot = number_format($sum_reg_ndot, 2);
    }
    if ($sum_rest_hours == 0) {
      $sum_rest_hours = '';
    } else {
      $sum_rest_hours = number_format($sum_rest_hours, 2);
    }
    if ($sum_rest_regot == 0) {
      $sum_rest_regot = '';
    } else {
      $sum_rest_regot = number_format($sum_rest_regot, 2);
    }
    if ($sum_rest_nd == 0) {
      $sum_rest_nd = '';
    } else {
      $sum_rest_nd = number_format($sum_rest_nd, 2);
    }
    if ($sum_rest_ndot == 0) {
      $sum_rest_ndot = '';
    } else {
      $sum_rest_ndot = number_format($sum_rest_ndot, 2);
    }
    if ($sum_leg_hours == 0) {
      $sum_leg_hours = '';
    } else {
      $sum_leg_hours = number_format($sum_leg_hours, 2);
    }
    if ($sum_leg_regot == 0) {
      $sum_leg_regot = '';
    } else {
      $sum_leg_regot = number_format($sum_leg_regot, 2);
    }
    if ($sum_leg_nd == 0) {
      $sum_leg_nd = '';
    } else {
      $sum_leg_nd = number_format($sum_leg_nd, 2);
    }
    if ($sum_leg_ndot == 0) {
      $sum_leg_ndot = '';
    } else {
      $sum_leg_ndot = number_format($sum_leg_ndot, 2);
    }
    if ($sum_legrest_hours == 0) {
      $sum_legrest_hours = '';
    } else {
      $sum_legrest_hours = number_format($sum_legrest_hours, 2);
    }
    if ($sum_legrest_regot == 0) {
      $sum_legrest_regot = '';
    } else {
      $sum_legrest_regot = number_format($sum_legrest_regot, 2);
    }
    if ($sum_legrest_nd == 0) {
      $sum_legrest_nd = '';
    } else {
      $sum_legrest_nd = number_format($sum_legrest_nd, 2);
    }
    if ($sum_legrest_ndot == 0) {
      $sum_legrest_ndot = '';
    } else {
      $sum_legrest_ndot = number_format($sum_legrest_ndot, 2);
    }
    if ($sum_spe_hours == 0) {
      $sum_spe_hours = '';
    } else {
      $sum_spe_hours = number_format($sum_spe_hours, 2);
    }
    if ($sum_spe_regot == 0) {
      $sum_spe_regot = '';
    } else {
      $sum_spe_regot = number_format($sum_spe_regot, 2);
    }
    if ($sum_spe_nd == 0) {
      $sum_spe_nd = '';
    } else {
      $sum_spe_nd = number_format($sum_spe_nd, 2);
    }
    if ($sum_spe_ndot == 0) {
      $sum_spe_ndot = '';
    } else {
      $sum_spe_ndot = number_format($sum_spe_ndot, 2);
    }
    if ($sum_sperest_hours == 0) {
      $sum_sperest_hours = '';
    } else {
      $sum_sperest_hours = number_format($sum_sperest_hours, 2);
    }
    if ($sum_sperest_regot == 0) {
      $sum_sperest_regot = '';
    } else {
      $sum_sperest_regot = number_format($sum_sperest_regot, 2);
    }
    if ($sum_sperest_nd == 0) {
      $sum_sperest_nd = '';
    } else {
      $sum_sperest_nd = number_format($sum_sperest_nd, 2);
    }
    if ($sum_sperest_ndot == 0) {
      $sum_sperest_ndot = '';
    } else {
      $sum_sperest_ndot = number_format($sum_sperest_ndot, 2);
    }

    $data["UNPAID_OT"]                 = $unpaid_ot;
    // $data["TOTAL_OT"]                  = $total_ot;
    $data["DATE_RANGE"]                 = $data_arr;
    $data["ERROR_SHIFT_ASSIGN"]         = $error_shift_assign;
    $data["SLIDER"]                     = ($slider == 0) ? null : $slider;
    $data["SUM_PRESENT"]                = $sum_present;
    $data["SUM_ABSENT"]                 = $sum_absent;
    $data["SUM_TARDINESS"]              = $sum_tardiness;
    $data["SUM_UNDERTIME"]              = $sum_undertime;
    $data["SUM_EARLYBREAK"]             = $sum_earlybreak;
    $data["SUM_OVERBREAK"]              = $sum_overbreak;
    $data["SUM_SLIDER"]                 = $sum_slider;
    $data["SUM_PAID_LEAVE"]             = $sum_paid_leave;
    $data["SUM_LWOP"]                   = $sum_lwop;
    $data["SUM_AWOL"]                   = $sum_awol;
    $data["SUM_REG_HOURS"]              = $sum_reg_hours;
    $data["SUM_REG_OT"]                 = $sum_reg_regot;
    $data["SUM_REG_ND"]                 = $sum_reg_nd;
    $data["SUM_REG_NDOT"]               = $sum_reg_ndot;
    $data["SUM_REST_HOURS"]             = $sum_rest_hours;
    $data["SUM_REST_OT"]                = $sum_rest_regot;
    $data["SUM_REST_ND"]                = $sum_rest_nd;
    $data["SUM_REST_NDOT"]              = $sum_rest_ndot;
    $data["SUM_LEG_HOURS"]              = $sum_leg_hours;
    $data["SUM_LEG_OT"]                 = $sum_leg_regot;
    $data["SUM_LEG_ND"]                 = $sum_leg_nd;
    $data["SUM_LEG_NDOT"]               = $sum_leg_ndot;
    $data["SUM_LEGREST_HOURS"]          = $sum_legrest_hours;
    $data["SUM_LEGREST_OT"]             = $sum_legrest_regot;
    $data["SUM_LEGREST_ND"]             = $sum_legrest_nd;
    $data["SUM_LEGREST_NDOT"]           = $sum_legrest_ndot;
    $data["SUM_SPE_HOURS"]              = $sum_spe_hours;
    $data["SUM_SPE_OT"]                 = $sum_spe_regot;
    $data["SUM_SPE_ND"]                 = $sum_spe_nd;
    $data["SUM_SPE_NDOT"]               = $sum_spe_ndot;
    $data["SUM_SPEREST_HOURS"]          = $sum_sperest_hours;
    $data["SUM_SPEREST_OT"]             = $sum_sperest_regot;
    $data["SUM_SPEREST_ND"]             = $sum_sperest_nd;
    $data["SUM_SPEREST_NDOT"]           = $sum_sperest_ndot;
    $data['DISP_EMP_LIST']              = $employee_list;
    $data['DISP_PAYROLL_SCHED']         = $payroll_list;
    $data['DISP_INOUT_TYPE']            = $this->attendance_model->GET_IN_OUT_TYPE();
    $data['DISP_CUTOFF']                = $cutoff_data;
    $data['DISP_READY_PAYSLIP']         = $this->attendance_model->GET_READY_PAYSLIP($period);
    $data['DISP_NOT_READY_PAYSLIP']     = $this->attendance_model->GET_NOT_READY_PAYSLIP($period);
    $data['INI_EMPL']                   = $employee_id;
    $data['INI_PAYROLL']                = $period;
    $data['SALARY_TYPE']                = $salary_type;
    $data['DISP_DISTINCT_COMPANY']      = $this->attendance_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH']       = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DIVISION']     = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_TEAM']         = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_DEPARTMENT']   = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_SECTION']      = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_GROUP']                 = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_LINE']                  = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    $data['DISP_VIEW_COMPANY']          = $this->attendance_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH']           = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT']       = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION']         = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION']          = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP']            = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM']             = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE']             = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    $data['DISP_LOCK_DATA']             = $disp_lock_data;
    $data['DISP_PAYSLIP_DATA']          = $disp_payslip_data;
    $data['DISP_LEAVE_DATA']            = $disp_leave_data;
    $data['DISP_TIME_DATA']             = $disp_time_data;
    $data['DISP_OVERTIME_DATA']         = $disp_overtime_data;
    $data['DISP_HOLIDAY_DATA']          = $disp_holiday_data;

    $data['DISP_ABSENT']    = $this->attendance_model->GET_ABSENT_LWOP_AWOL('absent_lwop_awol');

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_record_views', $data);
  }

  function attendance_records_test()
  {
    //------------------- GET GLOBAL URI VARIABLES ----------------------------------
    $company = $this->input->get("company");
    $branch = $this->input->get("branch");
    $dept = $this->input->get("dept");
    $division = $this->input->get("division");
    $section = $this->input->get("section");
    $group = $this->input->get("group");
    $team = $this->input->get("team");
    $line = $this->input->get("line");
    $status = $this->input->get("status");
    $period = $this->input->get("period");
    $employee = $this->input->get("employee");
    if ($company == null || $company == 'undefined') {
      $company = '';
    }
    if ($branch == null || $branch == 'undefined') {
      $branch = '';
    }
    if ($dept == null || $dept == 'undefined') {
      $dept = '';
    }
    if ($division == null || $division == 'undefined') {
      $division = '';
    }
    if ($section == null || $section == 'undefined') {
      $section = '';
    }
    if ($group == null || $group == 'undefined') {
      $group = '';
    }
    if ($team == null || $team == 'undefined') {
      $team = '';
    }
    if ($line == null || $line == 'undefined') {
      $line = '';
    }
    if ($status == null || $status == 'undefined') {
      $status = '';
    }

    $eagleridge_attendance_record = $this->attendance_model->GET_EAGLE_RIDGE_SETTING('eagleridge_attendace_record');

    //------------------- GET FILTERED LIST OF EMPLOYEES LIST FOR FRONTEND ----------------------------------
    $employee_list = $this->attendance_model->FILTER_ATTENDANCE_RECORDS($dept, $company, $section, $group, $division, $branch, $team);
    if (!empty($employee_list)) {
      if ($employee == null || $employee == 'undefined') {
        $employee_id = $employee_list[0]->id;
      } else {
        $employee_id = $employee;
      }
    }
    if (empty($employee_list)) {
      $employee_id = '';
    }
    //------------------- GET PAYROLL PERIOD LIST FOR FRONTEND----------------------------------
    $payroll_list = $this->attendance_model->MOD_DISP_PAY_SCHED();
    if ($period == null) {
      $period = $payroll_list[0]->id;
    }
    //------------------- GET EMPLOYEE INFORMATION ----------------------------------
    $date_period = $this->attendance_model->GET_PERIOD_DATA($period);
    $date_from = $date_period['date_from'];
    $date_to = $date_period['date_to'];
    $cutoff_data = $this->attendance_model->MON_DISP_CUTOFF_PERIOD($date_from, $date_to, $employee_id);
    $disp_lock_data = 0;
    $disp_payslip_data = 0;
    $disp_leave_data = 0;
    $disp_time_data = 0;
    $disp_overtime_data = 0;
    $disp_holiday_data = 0;
    if ($employee_id) {
      $response = $this->attendance_model->IS_DUPLICATE_LOCK($employee_id, $period);
      if ($response == 0) {
        $disp_lock_data = 0;
      } else {
        $disp_lock_data = 1;
      }
      $response = $this->attendance_model->IS_PAYSLIP($employee_id, $period);
      if ($response == 0) {
        $disp_payslip_data = 0;
      } else {
        $disp_payslip_data = 1;
      }
      $response = $this->attendance_model->IS_LEAVE($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_leave_data = 0;
      } else {
        $disp_leave_data = 1;
      }
      $response = $this->attendance_model->IS_TIME($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_time_data = 0;
      } else {
        $disp_time_data = 1;
      }
      $response = $this->attendance_model->IS_OVERTIME($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_overtime_data = 0;
      } else {
        $disp_overtime_data = 1;
      }
      $response = $this->attendance_model->IS_HOLIDAY($employee_id, $date_from, $date_to);
      if ($response == 0) {
        $disp_holiday_data = 0;
      } else {
        $disp_holiday_data = 1;
      }
    }
    $time_data = $this->attendance_model->GET_ATTENDANCE_RECORD($employee_id);
    $salary_type = $this->attendance_model->GET_SALARY_TYPE($employee_id);
    $approved_leaves = $this->attendance_model->GET_APPROVED_LEAVES($employee_id, $date_from, $date_to);
    $approved_change_shift = $this->attendance_model->GET_APPROVED_CHANGE_SHIFT($employee_id, $date_from, $date_to);
    $leave_typelist = $this->attendance_model->GET_LEAVE_NAMES();
    $approved_ot = $this->attendance_model->GET_APPROVED_OT($employee_id, $date_from, $date_to);
    $shift_assignment = $this->attendance_model->GET_SHIFT_ASSIGN_SPECIFIC($employee_id);
    $shift_data = $this->attendance_model->GET_WORK_SHIFT_DATA();
    $min_hrs_present = $this->attendance_model->GET_MIN_HOURS_PRESENT();
    $chk_lateundertime_deductiontype = $this->attendance_model->GET_LATEUNDERTIME_DEDUCTIONTYPE();
    $chk_graceperiod = $this->attendance_model->GET_GRACEPERIOD();
    $zkteco_time_data = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD($employee_id);

    $begin = new DateTime($date_from);
    $end = new DateTime($date_to);
    $end = $end->modify('+1 day');
    $holidays = $this->attendance_model->GET_HOLIDAY();
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);
    $data_arr = array();
    $index = 0;
    $error_shift_assign = 0;
    $sum_present = 0;
    $sum_absent = 0;
    $sum_tardiness = 0;
    $sum_undertime = 0;
    $sum_slider = 0;
    $sum_earlybreak = 0;
    $sum_overbreak = 0;
    $sum_paid_leave = 0;
    $sum_lwop = 0;
    $sum_awol = 0;
    $slider = 0;
    $sum_reg_hours = 0;
    $sum_reg_regot = 0;
    $sum_reg_nd = 0;
    $sum_reg_ndot = 0;
    $sum_rest_hours = 0;
    $sum_rest_regot = 0;
    $sum_rest_nd = 0;
    $sum_rest_ndot = 0;
    $sum_leg_hours = 0;
    $sum_leg_regot = 0;
    $sum_leg_nd = 0;
    $sum_leg_ndot = 0;
    $sum_legrest_hours = 0;
    $sum_legrest_regot = 0;
    $sum_legrest_nd = 0;
    $sum_legrest_ndot = 0;
    $sum_spe_hours = 0;
    $sum_spe_regot = 0;
    $sum_spe_nd = 0;
    $sum_spe_ndot = 0;
    $sum_sperest_hours = 0;
    $sum_sperest_regot = 0;
    $sum_sperest_nd = 0;
    $sum_sperest_ndot = 0;


    function employee_attendance($time_in, $time_out, $break_in, $break_out, $actual_in, $actual_out)
    {
      $regular_hrs = 0;
      echo '<br> Time in = ' . $time_in . '<br> Time out = ' . $time_out . '<br> Break in = ' . $break_in . '<br> Break out = ' . $break_out . '<br> Actual in = ' . $actual_in . '<br> Actual out = ' . $actual_out . '<br> Reg = </br></br>';
      // Define the two times
      $actual_time_in = new DateTime($actual_in);
      $actual_time_out = new DateTime($actual_out);
      $shift_in = new DateTime($time_in);
      $shift_out = new DateTime($time_out);
      $break_time_in = new DateTime($break_in);
      $break_time_out = new DateTime($break_out);

      // // Calculate the difference between the two times
      // $difference = $actual_time_in->diff($actual_time_out);
      // // Add up the total time
      // $total_hours = $difference->h + ($difference->days * 24); // Convert days to hours
      // $total_minutes = $difference->i;
      // $regular = $total_hours . ':' . $total_minutes;

      // if ($actual_time_in && $actual_time_out && $shift_in && $shift_out) {

      //   if ($shift_in <= $break_time_in && $actual_time_out <= $break_time_in) {
      //     echo 'actual_time_out = ' . $actual_out;
      //   }

      //   if ($actual_time_out > $break_time_in) {
      //     echo 'Time out = ' . $break_in;
      //   }
      // }
      // else{
      //   return $regular_hrs;
      // }

      if ($actual_time_in >= $shift_in && $actual_time_out >= $shift_out) {

        $difference = $actual_time_in->diff($shift_out);
        $total_hours = $difference->h + ($difference->days * 24);
        $total_minutes = $difference->i;
        $regular = $total_hours . ':' . $total_minutes;

        if ($total_hours < 4) {
          $regular = 0;
        }

        echo "Actual in/out within the shift in, shift out. " . $regular;
      } else {
        $difference = $actual_time_in->diff($actual_time_out);
        $total_hours = $difference->h + ($difference->days * 24);
        echo "Actual in and out are outside the shift in and out .";
      }

      return;
    }

    //-*********************** PROCESS ATTENDANCE PER DAY  ******************************
    foreach ($daterange as $date) {

      $current_date = $date->format("Y-m-d");
      $date_name = $date->format("d/m/Y (D)");
      $date_pdf = $date->format("Y/m/d D");
      $shift_name = '-';
      $shift_regular_start = '00:00';
      $shift_regular_end = '00:00';
      $shift_break_start = '00:00';
      $shift_break_end = '00:00';
      $shift_overtime_start = '00:00';
      $shift_overtime_end = '00:00';
      $shift_regular_enable = 0;
      $shift_regular_reg = 0;
      $shift_nd_hours = 0;
      $shift_break_enable = 0;
      $shift_break_hours = 0;
      $shift_overtime_enable = 0;
      $shift_overtime_ot = 0;
      $shift_overtime_nd = 0;
      $shift_pdf = '-';
      $shift_color = '#555555';
      $hol_code = "REGULAR";
      $zkteco_time_in = "00:00";
      $zkteco_time_out = "00:00";
      $zkteco_break_in = "00:00";
      $zkteco_break_out = "00:00";
      $remote_time_in = "00:00";
      $remote_time_out = "00:00";
      $remote_break_in = "00:00";
      $remote_break_out = "00:00";
      $raw_time_in = '00:00';
      $raw_time_out = '00:00';
      $raw_break_in = '00:00';
      $raw_break_out = '00:00';
      $raw_shift_time_regular_start = '00:00';
      $raw_shift_time_regular_end = '00:00';
      $raw_shift_break_time_in = '00:00';
      $raw_shift_break_time_out = '00:00';
      $shift_break_hours = 0;
      $reg_hrs = 0;
      $lwop = 0;
      $awol = 0;
      $calculate_work_duration = 0;
      $tardiness = 0;
      $undertime = 0;
      $work_hours = 0;
      $absent = 0;
      $remarks = '-';
      $paid_leave = 0;
      $paid_leave_type = '-';
      $reg_ot = 0;
      $nd_ot = 0;
      $nd = 0;
      $leave_type = 0;
      $leave_typename = '-';
      $earlybreak = 0;
      $overbreak = 0;



      //------------------- GET SHIFT DATA  ----------------------------------
      foreach ($shift_assignment as $shift_assignment_row) {
        if ($shift_assignment_row->date == $current_date) {
          foreach ($shift_data as $shift_data_row) {
            if ($shift_assignment_row->shift_id == $shift_data_row->id) {
              $shift_name = $shift_data_row->code;
              $shift_regular_enable = $shift_data_row->time_regular_enable;
              $shift_regular_start = date("H:i", strtotime($shift_data_row->time_regular_start));
              $shift_regular_end = date("H:i", strtotime($shift_data_row->time_regular_end));
              $shift_regular_reg = $shift_data_row->time_regular_reg;
              $shift_nd_hours = $shift_data_row->time_regular_nd;
              $shift_break_enable = $shift_data_row->time_break_enable;
              $shift_break_start = date("H:i", strtotime($shift_data_row->time_break_start));
              $shift_break_end = date("H:i", strtotime($shift_data_row->time_break_end));
              $shift_break_hours = $shift_data_row->time_break_hours;
              $shift_overtime_enable = $shift_data_row->time_overtime_enable;
              $shift_overtime_start = date("H:i", strtotime($shift_data_row->time_overtime_start));
              $shift_overtime_end = date("H:i", strtotime($shift_data_row->time_overtime_end));
              $shift_overtime_ot = $shift_data_row->time_overtime_ot;
              $shift_overtime_nd = $shift_data_row->time_overtime_nd;
              if ($shift_data_row->code == "REST") {
                $shift_name = "REST";
              }
              $shift_color = $shift_data_row->color;
              $raw_shift_time_regular_start = $shift_data_row->time_regular_start;
              $raw_shift_time_regular_end = $shift_data_row->time_regular_end;
              $raw_shift_break_time_in = $shift_data_row->time_break_start;
              $raw_shift_break_time_out = $shift_data_row->time_break_end;
              $shift_pdf = $shift_data_row->code;
              break;
            }
          }
          break;
        }
      }

      //------------------- GET HOLIDAY DATA  ----------------------------------
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $current_date) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $hol_code = "LEGAL";
          } else {
            $hol_code = "SPECIAL";
          }
          break;
        }
      }
      $time_in_array = [];
      $time_out_array = [];
      $break_in_array = [];
      $break_out_array = [];

      //------------------- GET BIOMETRICS TIMEKEEPING DATA  ----------------------------------


      foreach ($zkteco_time_data as $zkteco_time_data_row) {
        if (date("Y-m-d", strtotime($zkteco_time_data_row->punch_time)) == $current_date) {
          if ($zkteco_time_data_row->punch_state == 0) {
            array_push($time_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } elseif ($zkteco_time_data_row->punch_state == 4) {
            array_push($break_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } elseif ($zkteco_time_data_row->punch_state == 5) {
            array_push($break_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          } else {
            array_push($time_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
          }
        }
      }
      if ($time_in_array) {
        $oldest_in_time = min(array_map('strtotime', $time_in_array));
        $zkteco_time_in = date("H:i", $oldest_in_time);
      }
      if ($time_out_array) {
        $latest_time_out = max(array_map('strtotime', $time_out_array));
        $zkteco_time_out = date("H:i", $latest_time_out);
      }
      if ($break_in_array) {
        $oldest_in_break = min(array_map('strtotime', $break_in_array));
        $zkteco_break_in = date("H:i", $oldest_in_break);
      }
      if ($break_out_array) {
        $latest_break_out = min(array_map('strtotime', $break_out_array));
        $zkteco_break_out = date("H:i", $latest_break_out);
      }
      $snapshot_in = null;
      $snapshot_out = null;
      $time_in_address = null;
      $time_out_address = null;
      $break_in_snapshot = null;
      $break_in_address = null;
      $break_out_snapshot = null;
      $break_out_address = null;

      //------------------- GET REMOTE TIMEKEEPING DATA  ----------------------------------
      foreach ($time_data as $time_data_row) {
        if ($time_data_row->date == $current_date) {
          if (!is_null($time_data_row->time_in)) {
            $remote_time_in = date("H:i", strtotime($time_data_row->time_in));
          } else {
            $remote_time_in = "00:00";
          }
          if (!is_null($time_data_row->time_out)) {
            $remote_time_out = date("H:i", strtotime($time_data_row->time_out));
          } else {
            $remote_time_out = "00:00";
          }
          if (!is_null($time_data_row->break_in)) {
            $remote_break_in = date("H:i", strtotime($time_data_row->break_in));
          } else {
            $remote_break_in = "00:00";
          }
          if (!is_null($time_data_row->break_out)) {
            $remote_break_out = date("H:i", strtotime($time_data_row->break_out));
          } else {
            $remote_break_out = "00:00";
          }
          $snapshot_in = $time_data_row->snapshot_in;
          $snapshot_out = $time_data_row->snapshot_out;
          $time_in_address = $time_data_row->time_in_address;
          $time_out_address = $time_data_row->time_out_address;
          $break_in_snapshot = $time_data_row->break_in_snapshot;
          $break_in_address = $time_data_row->break_in_address;
          $break_out_snapshot = $time_data_row->break_out_snapshot;
          $break_out_address = $time_data_row->break_out_address;
          break;
        }
      }
      if ($zkteco_time_in != "00:00" && $remote_time_in != "00:00") {
        $raw_time_in = min($remote_time_in, $zkteco_time_in);
      } else if ($zkteco_time_in != "00:00" && $remote_time_in == "00:00") {
        $raw_time_in = $zkteco_time_in;
      } else {
        $raw_time_in = $remote_time_in;
      }
      if ($zkteco_time_out != "00:00" && $remote_time_out != "00:00") {
        $raw_time_out = max($remote_time_out, $zkteco_time_out);
      } else if ($zkteco_time_out != "00:00" && $remote_time_out == "00:00") {
        $raw_time_out = $zkteco_time_out;
      } else {
        $raw_time_out = $remote_time_out;
      }
      if ($zkteco_break_in != "00:00" && $remote_break_in != "00:00") {
        $raw_break_in = min($remote_break_in, $zkteco_break_in);
      } else if ($zkteco_break_in != "00:00" && $remote_break_in == "00:00") {
        $raw_break_in = $zkteco_break_in;
      } else {
        $raw_break_in = $remote_break_in;
      }
      if ($zkteco_break_out != "00:00" && $remote_break_out != "00:00") {
        $raw_break_out = max($remote_break_out, $zkteco_break_out);
      } else if ($zkteco_break_out != "00:00" && $remote_break_out == "00:00") {
        $raw_break_out = $zkteco_break_out;
      } else {
        $raw_break_out = $remote_break_out;
      }


      //------------------- GET APPROVED LEAVES  ----------------------------------   
      foreach ($approved_leaves as $approved_leaves_row) {
        if ($approved_leaves_row->leave_date == $current_date) {
          $leave_type_name = $this->attendance_model->GET_SPECIFIC_LEAVE_NAME($approved_leaves_row->type);
          if ($leave_type_name != "Leave without Pay (LWOP)") {
            $paid_leave = $approved_leaves_row->duration;
            $leave_type = $approved_leaves_row->type;
            foreach ($leave_typelist as $leave_typelist_row) {
              if ($leave_type == $leave_typelist_row->id) {
                $leave_typename = $leave_typelist_row->name;
              }
            }
            break;
          } else {
            $lwop = $approved_leaves_row->duration;
            break;
          }
        }
      }

      //------------------- GET APPROVED CHANGE SHIFT  ---------------------------------- 
      foreach ($approved_change_shift as $approved_change_row) {
        if ($approved_change_row->date_shift == $current_date) {
          $this->attendance_model->UPDATE_CHANGESHIFT($approved_change_row->empl_id, $approved_change_row->date_shift, $approved_change_row->request_shift);
        }
      }

      //------------------- GET APPROVED OT  ----------------------------------   
      foreach ($approved_ot as $approved_ot_row) {
        if ($approved_ot_row->date_ot == $current_date) {
          if ($approved_ot_row->type == "Regular") {
            $reg_ot = $approved_ot_row->hours;
          } else {
            $nd_ot = $approved_ot_row->hours;
          }
          break;
        }
      }
      if ($paid_leave != 0) {
        if ($hol_code == "REGULAR") {
          $remarks = "Approved Leave";
          $shift_color = "#D6ECD7";
        } else if ($hol_code == "LEGAL") {
          $remarks = "ERR:LV on HOL";
          $paid_leave = 0;
        } else if ($hol_code == "SPECIAL") {
          $remarks = "ERR:LV on HOL";
          $paid_leave = 0;
        }
      }

      //-------- MONTHLY  
      if ($salary_type == "Monthly") {
        //--- A. CHECK IF LEAVE TYPE IS HOURLY/DAILY
        $is_leave_hours = $this->attendance_model->get_leaves_settings_by_setting('isLeaveHours', '1');  // 0 = Day, 1 = Hours(Default)

        //--- B. IF LEAVE TYPES IS DAYS, WHOLEDAY IS EQUIVALENT TO SHIFT REGULAR HOURS
        if ($is_leave_hours == 0) { // <---  0 = DAYS (EAGLERIDGE), 1 = HOURS
          if ($paid_leave == 8) {
            $paid_leave = $shift_regular_reg;
          }
        }

        //--- C. WORKING DAYS
        if ($shift_name != '-' && $shift_name != 'REST') {
          if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {

            //---------------- ACTUAL TIME IN - SHIFT IN  MINUTES-------------------
            $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
            if ($in_min < 0) {
              $in_min = 0;
            }

            //---------------- TARDINESS CALCULATION -------------------
            // Compare if the tardiness is within the Grace Period
            // Check the Deduction Type; 0 = by 0.5 deduction, 1 = by minutes deduction

            if ($chk_graceperiod < $in_min) {
              if ($chk_lateundertime_deductiontype == 1) {     //1 = PER MINUTE, +0.5 = EVERY 30 MINS
                $tardiness = $in_min / 60;
                $tardiness = round($tardiness, 2);
              } else {
                $tardiness = ceil($in_min / 30) / 2;
              }
            } else {
              $tardiness = 0;
            }

            //-------------------------------------- SHIFT TIME OUT - ACTUAL OUT MINUTES --------------------------------------- 
            $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');

            if ($out_min < 0) {
              $out_min = 0;
            }

            //---------------- UNDERTIME  CALCULATION -------------------
            // Check the Deduction Type; 0 = by 0.5 deduction, 1 = by minutes deduction

            if ($chk_lateundertime_deductiontype == 1) {
              $undertime = $out_min / 60;
            } else {
              $undertime = (ceil($out_min / 30) / 2);
            }

            //---------------- EARLY BREAK CALCULATION -------------------
            $earlybreak = 0;
            if ($raw_break_in != "00:00") {
              $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
              if ($break_in_min < 0) {
                $break_in_min = 0;
              }
              if ($chk_lateundertime_deductiontype == 1) {
                $earlybreak = $break_in_min / 60;
              } else {
                $earlybreak = (ceil($break_in_min / 30) / 2);
              }
            }

            //---------------- OVER BREAK CALCULATION -------------------
            $overbreak = 0;
            if ($raw_break_in != "00:00") {
              $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
              if ($break_out_min < 0) {
                $break_out_min = 0;
              }
              if ($chk_lateundertime_deductiontype == 1) {
                $overbreak = $overbreak / 60;
              } else {
                $overbreak = (ceil($overbreak / 30) / 2);
              }
            }
            // var_dump($current_date);
            if ($current_date == '2024-05-23') {
              echo employee_attendance($shift_regular_start, $shift_regular_end, $shift_break_start, $shift_break_end, $raw_time_in, $raw_time_out);
            }

            //-------------------------------------- CALCULATION ---------------------------------------
            // FOR SCENARIO THAT LEAVE IS GREATER THAN WORKING HOURS
            if ($paid_leave >= $shift_regular_reg) {
              $paid_leave = $shift_regular_reg;
            }

            if ($paid_leave > 0) {
              $tardiness = 0;
              $undertime = 0;
            }
            // HOURS NEEDED TO BE RENDERED BY THE USER
            $reg_hrs = $shift_regular_reg - $paid_leave - $lwop;

            if ($reg_hrs < 0) {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $earlybreak = 0;
              $overbreak = 0;

              $awol = $shift_regular_reg - $paid_leave - $lwop;
              $absent = $awol + $lwop;
              $remarks = "Invalid IN/OUT, Absent";
            }
          } else {
            $reg_hrs = 0;
            $tardiness = 0;
            $undertime = 0;
            $awol = $shift_regular_reg - $paid_leave - $lwop;
            $absent = $awol + $lwop;
            if ($awol < 0) {
              $awol = 0;
            }

            if ($awol > 0 && $paid_leave != 0) {
              $remarks = "Partially Absent, Approved Leave";
            } elseif ($awol == 0 && ($paid_leave != 0 || $lwop != 0)) {
              $remarks = "Approved Leave";
            } elseif ($awol > 0) {
              $remarks = "NO IN/OUT, Absent";
            }
          }

          $slider += $this->slider($raw_time_in, $shift_regular_start);
          $raw_time_in;
          $raw_time_out;
          $raw_shift_time_regular_start;
          $raw_shift_time_regular_end;
          $work_hours;
          $calculate_work_duration;
        } else if ($shift_name == 'REST') {
          $reg_ot = 0;
          $nd = 0;
          $nd_ot = 0;
        } else {
          $reg_ot = 0;
          $nd = 0;
          $nd_ot = 0;
          $remarks = "No Shift";
          $error_shift_assign = 1;
        }
      } elseif ($salary_type == "Daily") {
        if ($shift_name != '-' && $shift_name != 'REST') {
          $work_hours = $shift_regular_reg - $paid_leave;
          if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {
            $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
            if ($in_min < 0) {
              $in_min = 0;
            }
            if ($chk_graceperiod < $in_min) {
              if ($chk_lateundertime_deductiontype == 1) {
                $tardiness = $in_min / 60;
                $tardiness = round($tardiness, 2);
              } else {
                $tardiness = ceil($in_min / 30) / 2;
              }
            } else {
              $tardiness = 0;
            }
            $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');
            if ($out_min < 0) {
              $out_min = 0;
            }
            if ($chk_lateundertime_deductiontype == 1) {
              $undertime = $out_min / 60;
            } else {
              $undertime = ceil($out_min / 30) / 2;
            }
            $earlybreak = 0;
            if ($raw_break_in != "00:00") {
              $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
              if ($break_in_min < 0) {
                $break_in_min = 0;
              }
              $earlybreak = ceil($break_in_min / 30) / 2;
            }
            $overbreak = 0;
            if ($raw_break_in != "00:00") {
              $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
              if ($break_out_min < 0) {
                $break_out_min = 0;
              }
              $overbreak = ceil($break_out_min / 30) / 2;
            }
            $awol = $absent - $lwop;
            $reg_hrs = $work_hours - $awol - $lwop;
            if ($reg_hrs < 0) {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = 0;
              $earlybreak = 0;
              $overbreak = 0;
              $remarks = "";
            }
          } elseif ($raw_time_in == "00:00" && $raw_time_out == "00:00") {
            $reg_hrs = 0;
            $tardiness = 0;
            $undertime = 0;
            $awol = 0;
            $earlybreak = 0;
            $overbreak = 0;
            $remarks = "Did not report";
          } else {
            $reg_hrs = 0;
            $tardiness = 0;
            $undertime = 0;
            $awol = 0;
            $earlybreak = 0;
            $overbreak = 0;
            $remarks = "Incomplete Time Record";
          }
          $slider += $this->slider($raw_time_in, $shift_regular_start);
          $raw_time_in;
          $raw_time_out;
          $raw_shift_time_regular_start;
          $raw_shift_time_regular_end;
          $work_hours;
          $calculate_work_duration;
        } else if ($shift_name == 'REST') {
          $reg_ot = 0;
          $nd = 0;
          $nd_ot = 0;

          $reg_hrs = 8;
        } else {
          $reg_ot = 0;
          $nd = 0;
          $nd_ot = 0;
          $remarks = "No Shift";
          $error_shift_assign = 1;
        }
        $tardiness = 0;
        $undertime = 0;
        $absent = 0;
        $awol = 0;
        $lwop = 0;
        $earlybreak = 0;
        $overbreak = 0;
      }
      if ($hol_code != "REGULAR") {
        $calculate_work_duration = 0;
        $work_hours = 0;
        $tardiness = 0;
        $absent = 0;
        $awol = 0;
        $lwop = 0;
        $earlybreak = 0;
        $overbreak = 0;
      }

      if ($eagleridge_attendance_record == 1 && $reg_hrs > 0) {
        $sum_present += $reg_hrs;
      }

      if ($reg_hrs >= $min_hrs_present && $eagleridge_attendance_record == 0) {
        $sum_present += 1;
      }

      if ($lwop >= 0) {
        $sum_lwop += $lwop;
      }
      if ($awol >= 0) {
        $sum_awol += $awol;
      }
      if ($absent >= 0) {
        $sum_absent += $absent;
      }
      if ($tardiness >= 0) {
        $sum_tardiness += $tardiness;
      }
      if ($undertime >= 0) {
        $sum_undertime += $undertime;
      }
      if ($paid_leave >= 0) {
        $sum_paid_leave += $paid_leave;
      }
      if ($earlybreak >= 0) {
        $sum_earlybreak += $earlybreak;
      }
      if ($overbreak >= 0) {
        $sum_overbreak += $overbreak;
      }
      if ($hol_code == "REGULAR" && $shift_name != "REST") {
        if ($reg_hrs > 0) {
          $sum_reg_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_reg_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_reg_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_reg_ndot += $nd;
        }
      } elseif ($hol_code == "REGULAR" && $shift_name == "REST") {
        if ($reg_hrs > 0) {
          $sum_rest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_rest_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_rest_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_rest_ndot += $nd;
        }
      } elseif ($hol_code == "LEGAL" && $shift_name != "REST") {
        if ($reg_hrs > 0) {
          $sum_leg_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_leg_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_leg_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_leg_ndot += $nd;
        }
      } elseif ($hol_code == "LEGAL" && $shift_name == "REST") {
        if ($reg_hrs > 0) {
          $sum_legrest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_legrest_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_legrest_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_legrest_ndot += $nd;
        }
      } elseif ($hol_code == "SPECIAL" && $shift_name != "REST") {
        if ($reg_hrs > 0) {
          $sum_spe_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_spe_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_spe_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_spe_ndot += $nd;
        }
      } elseif ($hol_code == "SPECIAL" && $shift_name == "REST") {
        if ($reg_hrs > 0) {
          $sum_sperest_hours += $reg_hrs;
        }
        if ($reg_ot > 0) {
          $sum_sperest_regot += $reg_ot;
        }
        if ($nd_ot > 0) {
          $sum_sperest_nd += $nd_ot;
        }
        if ($nd > 0) {
          $sum_sperest_ndot += $nd;
        }
      }
      if ($reg_hrs == 0) {
        $reg_hrs_disp = '';
      } else {
        $reg_hrs_disp = number_format($reg_hrs, 2);
      }
      if ($absent == 0) {
        $absent_disp = '';
      } else {
        $absent_disp = number_format($absent, 2);
      }
      if ($lwop == 0) {
        $lwop_disp = '';
      } else {
        $lwop_disp = number_format($lwop, 2);
      }
      if ($awol == 0) {
        $awol_disp = '';
      } else {
        $awol_disp = number_format($awol, 2);
      }
      if ($tardiness == 0) {
        $tardiness_disp = '';
      } else {
        $tardiness_disp = number_format($tardiness, 2);
      }
      if ($undertime == 0) {
        $undertime_disp = '';
      } else {
        $undertime_disp = number_format($undertime, 2);
      }
      if ($paid_leave == 0) {
        $paid_leave_disp = '';
      } else {
        $paid_leave_disp = number_format($paid_leave, 2);
      }
      if ($reg_ot == 0) {
        $reg_ot_disp = '';
      } else {
        $reg_ot_disp = number_format($reg_ot, 2);
      }
      if ($nd_ot == 0) {
        $nd_ot_disp = '';
      } else {
        $nd_ot_disp = number_format($nd_ot, 2);
      }
      if ($nd == 0) {
        $nd_disp = '';
      } else {
        $nd_disp = number_format($nd, 2);
      }
      if ($raw_time_in == "00:00") {
        $raw_time_in = '';
      }
      if ($raw_time_out == "00:00") {
        $raw_time_out = '';
      }
      if ($raw_break_in == "00:00") {
        $raw_break_in = '';
      }
      if ($raw_break_out == "00:00") {
        $raw_break_out = '';
      }
      if ($shift_regular_start == "00:00") {
        $shift_regular_start = '';
      }
      if ($shift_regular_end == "00:00") {
        $shift_regular_end = '';
      }
      if ($shift_name == "REST") {
        $shift_regular_start = '';
        $shift_regular_end = '';
      }
      if ($shift_break_start == "00:00") {
        $shift_break_start = '';
      }
      if ($shift_break_end == "00:00") {
        $shift_break_end = '';
      }
      if ($shift_overtime_start == "00:00") {
        $shift_overtime_start = '';
      }
      if ($shift_overtime_end == "00:00") {
        $shift_overtime_end = '';
      }
      if ($earlybreak == 0) {
        $earlybreak_disp = '';
      } else {
        $earlybreak_disp = number_format($earlybreak, 2);
      }
      if ($overbreak == 0) {
        $overbreak_disp = '';
      } else {
        $overbreak_disp = number_format($overbreak, 2);
      }
      $data_arr[$index]["Date"] = $date_name;
      $data_arr[$index]["Date_PDF"] = $date_pdf;
      $data_arr[$index]["holi_type"] = $hol_code;
      $data_arr[$index]["shift"] = $shift_name;
      $data_arr[$index]["shift_regular_start"] = $shift_regular_start;
      $data_arr[$index]["shift_regular_end"] = $shift_regular_end;
      $data_arr[$index]["shift_break_start"] = $shift_break_start;
      $data_arr[$index]["shift_break_end"] = $shift_break_end;
      $data_arr[$index]["shift_overtime_start"] = $shift_overtime_start;
      $data_arr[$index]["shift_overtime_end"] = $shift_overtime_end;
      $data_arr[$index]["earlybreak"] = $earlybreak_disp;
      $data_arr[$index]["overbreak"] = $overbreak_disp;
      $data_arr[$index]["shift_PDF"] = $shift_pdf;
      $data_arr[$index]["shift_color"] = $shift_color;
      $data_arr[$index]['time_in'] = $raw_time_in;
      $data_arr[$index]['time_out'] = $raw_time_out;
      $data_arr[$index]['break_in'] = $raw_break_in;
      $data_arr[$index]['break_out'] = $raw_break_out;
      $data_arr[$index]['reg_hrs'] = $reg_hrs_disp;
      $data_arr[$index]['lwop'] = $lwop_disp;
      $data_arr[$index]['awol'] = $awol_disp;
      $data_arr[$index]['tardiness'] = $tardiness_disp;
      $data_arr[$index]['undertime'] = $undertime_disp;
      $data_arr[$index]['paid_leave'] = $paid_leave_disp;
      $data_arr[$index]['nd'] = $nd_disp;
      $data_arr[$index]['shift_reg_ot'] = "";
      $data_arr[$index]['shift_nd_ot'] = "";
      $data_arr[$index]['reg_ot'] = $reg_ot_disp;
      $data_arr[$index]['nd_ot'] = $nd_ot_disp;
      $data_arr[$index]['remarks'] = $remarks;
      $data_arr[$index]["snapshot_in"] = $snapshot_in;
      $data_arr[$index]["snapshot_out"] = $snapshot_out;
      $data_arr[$index]["time_in_address"] = $time_in_address;
      $data_arr[$index]["time_out_address"] = $time_out_address;
      $data_arr[$index]["break_in_snapshot"] = $break_in_snapshot;
      $data_arr[$index]["break_in_address"] = $break_in_address;
      $data_arr[$index]["break_out_snapshot"] = $break_out_snapshot;
      $data_arr[$index]["break_out_address"] = $break_out_address;
      $index += 1;
    }

    //------------------- FORMAT SUM  ----------------------------------

    if ($sum_present == 0) {
      $sum_present = '';
    } elseif ($eagleridge_attendance_record == 1 && $sum_present != 0) { // if eagleridge is enable
      $sum_present = number_format($sum_present / 8, 2);
    } elseif ($eagleridge_attendance_record == 0 && $sum_present != 0) {
      $sum_present = number_format($sum_present, 2);
    }

    if ($sum_tardiness == 0) {
      $sum_tardiness = '';
    } else {
      $sum_tardiness = number_format($sum_tardiness, 2);
    }
    if ($sum_undertime == 0) {
      $sum_undertime = '';
    } else {
      $sum_undertime = number_format($sum_undertime, 2);
    }
    if ($sum_earlybreak == 0) {
      $sum_earlybreak = '';
    } else {
      $sum_earlybreak = number_format($sum_earlybreak, 2);
    }
    if ($sum_overbreak == 0) {
      $sum_overbreak = '';
    } else {
      $sum_overbreak = number_format($sum_overbreak, 2);
    }
    if ($sum_slider == 0) {
      $sum_slider = '';
    } else {
      $sum_slider = number_format($sum_slider, 2);
    }
    if ($sum_paid_leave == 0) {
      $sum_paid_leave = '';
    } else {
      $sum_paid_leave = number_format($sum_paid_leave, 2);
    }
    if ($sum_absent == 0) {
      $sum_absent = '';
    } else {
      $sum_absent = number_format($sum_absent, 2);
    }
    if ($sum_lwop == 0) {
      $sum_lwop = '';
    } else {
      $sum_lwop = number_format($sum_lwop, 2);
    }
    if ($sum_awol == 0) {
      $sum_awol = '';
    } else {
      $sum_awol = number_format($sum_awol, 2);
    }
    if ($sum_reg_hours == 0) {
      $sum_reg_hours = '';
    } else {
      $sum_reg_hours = number_format($sum_reg_hours, 2);
    }
    if ($sum_reg_regot == 0) {
      $sum_reg_regot = '';
    } else {
      $sum_reg_regot = number_format($sum_reg_regot, 2);
    }
    if ($sum_reg_nd == 0) {
      $sum_reg_nd = '';
    } else {
      $sum_reg_nd = number_format($sum_reg_nd, 2);
    }
    if ($sum_reg_ndot == 0) {
      $sum_reg_ndot = '';
    } else {
      $sum_reg_ndot = number_format($sum_reg_ndot, 2);
    }
    if ($sum_rest_hours == 0) {
      $sum_rest_hours = '';
    } else {
      $sum_rest_hours = number_format($sum_rest_hours, 2);
    }
    if ($sum_rest_regot == 0) {
      $sum_rest_regot = '';
    } else {
      $sum_rest_regot = number_format($sum_rest_regot, 2);
    }
    if ($sum_rest_nd == 0) {
      $sum_rest_nd = '';
    } else {
      $sum_rest_nd = number_format($sum_rest_nd, 2);
    }
    if ($sum_rest_ndot == 0) {
      $sum_rest_ndot = '';
    } else {
      $sum_rest_ndot = number_format($sum_rest_ndot, 2);
    }
    if ($sum_leg_hours == 0) {
      $sum_leg_hours = '';
    } else {
      $sum_leg_hours = number_format($sum_leg_hours, 2);
    }
    if ($sum_leg_regot == 0) {
      $sum_leg_regot = '';
    } else {
      $sum_leg_regot = number_format($sum_leg_regot, 2);
    }
    if ($sum_leg_nd == 0) {
      $sum_leg_nd = '';
    } else {
      $sum_leg_nd = number_format($sum_leg_nd, 2);
    }
    if ($sum_leg_ndot == 0) {
      $sum_leg_ndot = '';
    } else {
      $sum_leg_ndot = number_format($sum_leg_ndot, 2);
    }
    if ($sum_legrest_hours == 0) {
      $sum_legrest_hours = '';
    } else {
      $sum_legrest_hours = number_format($sum_legrest_hours, 2);
    }
    if ($sum_legrest_regot == 0) {
      $sum_legrest_regot = '';
    } else {
      $sum_legrest_regot = number_format($sum_legrest_regot, 2);
    }
    if ($sum_legrest_nd == 0) {
      $sum_legrest_nd = '';
    } else {
      $sum_legrest_nd = number_format($sum_legrest_nd, 2);
    }
    if ($sum_legrest_ndot == 0) {
      $sum_legrest_ndot = '';
    } else {
      $sum_legrest_ndot = number_format($sum_legrest_ndot, 2);
    }
    if ($sum_spe_hours == 0) {
      $sum_spe_hours = '';
    } else {
      $sum_spe_hours = number_format($sum_spe_hours, 2);
    }
    if ($sum_spe_regot == 0) {
      $sum_spe_regot = '';
    } else {
      $sum_spe_regot = number_format($sum_spe_regot, 2);
    }
    if ($sum_spe_nd == 0) {
      $sum_spe_nd = '';
    } else {
      $sum_spe_nd = number_format($sum_spe_nd, 2);
    }
    if ($sum_spe_ndot == 0) {
      $sum_spe_ndot = '';
    } else {
      $sum_spe_ndot = number_format($sum_spe_ndot, 2);
    }
    if ($sum_sperest_hours == 0) {
      $sum_sperest_hours = '';
    } else {
      $sum_sperest_hours = number_format($sum_sperest_hours, 2);
    }
    if ($sum_sperest_regot == 0) {
      $sum_sperest_regot = '';
    } else {
      $sum_sperest_regot = number_format($sum_sperest_regot, 2);
    }
    if ($sum_sperest_nd == 0) {
      $sum_sperest_nd = '';
    } else {
      $sum_sperest_nd = number_format($sum_sperest_nd, 2);
    }
    if ($sum_sperest_ndot == 0) {
      $sum_sperest_ndot = '';
    } else {
      $sum_sperest_ndot = number_format($sum_sperest_ndot, 2);
    }
    $data["DATE_RANGE"] = $data_arr;
    $data["ERROR_SHIFT_ASSIGN"] = $error_shift_assign;
    $data["SLIDER"] = $slider;
    $data["SUM_PRESENT"] = $sum_present;
    $data["SUM_ABSENT"] = $sum_absent;
    $data["SUM_TARDINESS"] = $sum_tardiness;
    $data["SUM_UNDERTIME"] = $sum_undertime;
    $data["SUM_EARLYBREAK"] = $sum_earlybreak;
    $data["SUM_OVERBREAK"] = $sum_overbreak;
    $data["SUM_SLIDER"] = $sum_slider;
    $data["SUM_PAID_LEAVE"] = $sum_paid_leave;
    $data["SUM_LWOP"] = $sum_lwop;
    $data["SUM_AWOL"] = $sum_awol;
    $data["SUM_REG_HOURS"] = $sum_reg_hours;
    $data["SUM_REG_OT"] = $sum_reg_regot;
    $data["SUM_REG_ND"] = $sum_reg_nd;
    $data["SUM_REG_NDOT"] = $sum_reg_ndot;
    $data["SUM_REST_HOURS"] = $sum_rest_hours;
    $data["SUM_REST_OT"] = $sum_rest_regot;
    $data["SUM_REST_ND"] = $sum_rest_nd;
    $data["SUM_REST_NDOT"] = $sum_rest_ndot;
    $data["SUM_LEG_HOURS"] = $sum_leg_hours;
    $data["SUM_LEG_OT"] = $sum_leg_regot;
    $data["SUM_LEG_ND"] = $sum_leg_nd;
    $data["SUM_LEG_NDOT"] = $sum_leg_ndot;
    $data["SUM_LEGREST_HOURS"] = $sum_legrest_hours;
    $data["SUM_LEGREST_OT"] = $sum_legrest_regot;
    $data["SUM_LEGREST_ND"] = $sum_legrest_nd;
    $data["SUM_LEGREST_NDOT"] = $sum_legrest_ndot;
    $data["SUM_SPE_HOURS"] = $sum_spe_hours;
    $data["SUM_SPE_OT"] = $sum_spe_regot;
    $data["SUM_SPE_ND"] = $sum_spe_nd;
    $data["SUM_SPE_NDOT"] = $sum_spe_ndot;
    $data["SUM_SPEREST_HOURS"] = $sum_sperest_hours;
    $data["SUM_SPEREST_OT"] = $sum_sperest_regot;
    $data["SUM_SPEREST_ND"] = $sum_sperest_nd;
    $data["SUM_SPEREST_NDOT"] = $sum_sperest_ndot;
    $data['DISP_EMP_LIST'] = $employee_list;
    $data['DISP_PAYROLL_SCHED'] = $payroll_list;
    $data['DISP_INOUT_TYPE'] = $this->attendance_model->GET_IN_OUT_TYPE();
    $data['DISP_CUTOFF'] = $cutoff_data;
    $data['DISP_READY_PAYSLIP'] = $this->attendance_model->GET_READY_PAYSLIP($period);
    $data['DISP_NOT_READY_PAYSLIP'] = $this->attendance_model->GET_NOT_READY_PAYSLIP($period);
    $data['INI_EMPL'] = $employee_id;
    $data['INI_PAYROLL'] = $period;
    $data['SALARY_TYPE'] = $salary_type;
    $data['DISP_DISTINCT_COMPANY'] = $this->attendance_model->MOD_DISP_DISTINCT_COMPANY();
    $data['DISP_DISTINCT_BRANCH'] = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DIVISION'] = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_TEAM'] = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_DEPARTMENT'] = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_SECTION'] = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_GROUP'] = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_LINE'] = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    $data['DISP_VIEW_COMPANY'] = $this->attendance_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH'] = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT'] = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP'] = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM'] = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    $data['DISP_LOCK_DATA'] = $disp_lock_data;
    $data['DISP_PAYSLIP_DATA'] = $disp_payslip_data;
    $data['DISP_LEAVE_DATA'] = $disp_leave_data;
    $data['DISP_TIME_DATA'] = $disp_time_data;
    $data['DISP_OVERTIME_DATA'] = $disp_overtime_data;
    $data['DISP_HOLIDAY_DATA'] = $disp_holiday_data;
    // $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_record_test_views', $data);
  }

  function attendance_quick_view()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_rec_quick_views');
  }
  function attendance_rec_csv()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_rec_csv_views');
  }
  function attendance_summary()
  {
    //------------------- GET GLOBAL URI VARIABLES ----------------------------------

    $assume_day_from    = $this->input->post('start_date');
    $assume_day_to      = $this->input->post('end_date');

    $period = $this->input->get('period');
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    //------------------- GET PAYROLL PERIOD LIST FOR FRONTEND----------------------------------
    $data['CUTOFF_PERIODS'] = $this->attendance_model->GET_CUTOFF_LIST();
    //------------------- GET ROW LIST FOR FRONTEND----------------------------------
    $data["C_ROW_DISPLAY"] = [25, 50, 100, 500];
    //------------------- CUT OFF PERIOD FILTER----------------------------------
    if (isset($period)) {
      $date_period = $this->attendance_model->GET_CUTOFF($period);
    } else {
      $date_period = $this->attendance_model->GET_CUTOFF($data['CUTOFF_PERIODS'][0]->id);
    }
    
    // Get only the 'id'
    $period_id = isset($date_period['id']) ? $date_period['id'] : null;
    $data['CUTOFF_PERIOD_ASSUME'] = $period_id;


    $assume_day_from    = "";
    $assume_day_to      = "";

    $DISP_ASSUME_DATES = $this->attendance_model->GET_ASSUME_DATES($period_id);

    if($DISP_ASSUME_DATES && $DISP_ASSUME_DATES->end_date && $DISP_ASSUME_DATES->start_date){
      $assume_day_from    = $DISP_ASSUME_DATES->start_date;
      $assume_day_to      = $DISP_ASSUME_DATES->end_date;
    }
    
    $data['DISP_ASSUME_DATES'] = $DISP_ASSUME_DATES;

    //-------------------OTHER EARNING, DEDUCTIONS, LOANS, ADJUSTMENTS----------------------------------
    $data['DISP_BENEFITS_FIXED_ASSIGN'] = $benefits_fixed_assign = $this->attendance_model->GET_BENEFITS_FIXED_ASSIGN($date_period['id']);
    $data['DISP_BENEFITS_ADJUSTMENT_ASSIGN'] = $benefits_adjustment_assign = $this->attendance_model->GET_BENEFITS_ADJUSTMENT_ASSIGN($date_period['id']);
    $data['DISP_BENEFITS_DYNAMIC'] = $this->attendance_model->GET_BENEFITS_DYNAMIC_COUNT($date_period['id']);
    $dynamic_std = $this->attendance_model->GET_BENEFITS_DYNAMIC_STD();
    $employee_assign = $this->attendance_model->GET_EMPLOYEELIST_ASSIGN();
    foreach ($employee_assign as $assign) {
      foreach ($dynamic_std as $standard) {
        if ($assign->category == $standard->id) {
          $assign->category = $standard->name;
        }
      }
    }
    $data['DISP_EMPLOYEELIST_ASSIGN'] = $employee_assign;
    $data['DISP_DYNAMIC_STD'] = $dynamic_std;
    //-------------------OTHER EARNING, DEDUCTIONS, LOANS, ADJUSTMENTS----------------------------------
    $date_from = $date_period["date_from"];
    $date_to = $date_period["date_to"];
    $data['PERIOD'] = $period;
    $data['CUTOFF_PERIOD'] = $date_period;
    $data['DISP_ALL_APPROVED_OT'] = $overtime_data = $this->attendance_model->GET_ALL_APPROVED_OT($date_from, $date_to);
    $data['DISP_EMPLOYEES'] = $employees = $this->attendance_model->GET_EMPLOYEELIST_SUMMARY($offset, $row);
    $data['DISP_EMPLOYEES_ATTENDANCE_LOG'] = $attendance_records = $this->attendance_model->GET_ATTENDANCE_LOG_IN_OUT($date_from, $date_to);
    $data['DISP_EMPLOYEES_SHIFT'] = $employee_shifts = $this->attendance_model->GET_ATTENDANCE_EMPLOYEES_SHIFT($date_from, $date_to);
    $data['DISP_BENEFITS_BENEFITS_TYPE'] = $benefits_type = $this->attendance_model->GET_BENEFITS_FIXED_TYPE();
    $data['DISP_BENEFITS_ADJUSTMENT_TYPE'] = $adjustment_type = $this->attendance_model->GET_BENEFITS_ADJUSTMENT_TYPE();
    foreach ($benefits_fixed_assign as &$assign) {
      foreach ($benefits_type as $benefit) {
        if ($assign->type == $benefit->id) {
          $assign->type = $benefit->name;
        }
      }
    }
    foreach ($benefits_adjustment_assign as &$adjustment_assign) {
      foreach ($adjustment_type as $adjustment) {
        if ($adjustment_assign->type == $adjustment->id) {
          $adjustment_assign->type = $adjustment->name;
        }
      }
    }
    $data['LEAVE_ASSIGNS'] = $leaves_data = $this->attendance_model->GET_SPECIFIC_LEAVE_ASSIGN($date_from, $date_to);
    $data['DISP_HOLIDAYS'] = $holidays = $this->attendance_model->GET_HOLIDAY();
    $data['C_DATA_COUNT'] = $this->attendance_model->GET_EMPLOYEELIST_SUMMARY_COUNT();
    $data['shift_data'] = $this->attendance_model->GET_WORK_SHIFT_DATA();
    $data['DISP_LEAVE_NAMES'] = $this->attendance_model->GET_LEAVE_NAMES();
    $zkteco_attendance = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD_DATA($date_from, $date_to);


    $employeeAttendance = [];
    $begin = new DateTime($date_from);
    $end = new DateTime($date_to);
    $end = $end->modify('+1 day');
    $holidays = $this->attendance_model->GET_HOLIDAY();
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);

    $prev_attendance_date = '';

    if ($begin->format('d') == '16') {
      $first_date_attendance = $begin->format('Y-m-d');
      $prev_attendance_date = date('Y-m-d', strtotime("$first_date_attendance -1 day"));
    }

    if ($begin->format('d') == '31') {
      $first_date_attendance = $begin->format('Y-m-d');
      $prev_attendance_date = date('Y-m-d', strtotime("$first_date_attendance -1 day"));
    }
     if ($begin->format('d') == '11') {
      $first_date_attendance = $begin->format('Y-m-d');
      $prev_attendance_date = date('Y-m-d', strtotime("$first_date_attendance -1 day"));
    }

    if ($begin->format('d') == '26') {
      $first_date_attendance = $begin->format('Y-m-d');
      $prev_attendance_date = date('Y-m-d', strtotime("$first_date_attendance -1 day"));
    }

    $prev_period_id                 = $this->attendance_model->GET_PREV_CUTOFF_PERIOD($prev_attendance_date, 'Active');

    $prev_cutoff_assume_date        = $this->attendance_model->GET_PAYROLL_PERIOD_PREVIOUS($prev_period_id);

    $prev_daterange = "";

    if ($prev_cutoff_assume_date) {
      $prev_begin     = new DateTime($prev_cutoff_assume_date->start_date);
      $prev_end       = new DateTime($prev_cutoff_assume_date->end_date);

      $prev_end = $prev_end->modify('+1 day');
      $prev_interval = new DateInterval('P1D');
      $prev_daterange = new DatePeriod($prev_begin, $prev_interval, $prev_end);
    }


    foreach ($employees as $employee) {

      $employee_id    = $employee->id;
      $employeeName   = $employee->fullname;
      $position       = $employee->position;
      $LOG_empl_id    = $employee_id;
      $current_date   = '';
      $employeeObject = new stdClass();
      $employeeObject->id = $employee_id;
      $employeeObject->fullname = $employeeName;
      $employeeObject->position = $position;
      $employeeObject->reg_hrs = [];
      $employeeObject->paid_leaves = [];
      $employeeObject->overtime = [];
      $employeeObject->sum_reg_hours = [];
      $employeeObject->sum_leg_hours = [];
      $employeeObject->earning_deduction = [];
      $employeeObject->adjustment_benefits = [];

      $time_data                                  = $this->attendance_model->GET_ATTENDANCE_RECORD($employee_id);
      $salary_type                                = $this->attendance_model->GET_SALARY_TYPE($employee_id);
      $approved_leaves                            = $this->attendance_model->GET_APPROVED_LEAVES($employee_id, $date_from, $date_to);
      $leave_typelist                             = $this->attendance_model->GET_LEAVE_NAMES();
      $approved_ot                                = $this->attendance_model->GET_APPROVED_OT($employee_id, $date_from, $date_to);
      $approved_undertime_exempt                  = $this->attendance_model->GET_APPROVED_UNDERTIME_EXEMPT($employee_id, $date_from, $date_to);
      $shift_assignment                           = $this->attendance_model->GET_SHIFT_ASSIGN_SPECIFIC($employee_id);
      $shift_data                                 = $this->attendance_model->GET_WORK_SHIFT_DATA();
      $min_hrs_present                            = $this->attendance_model->GET_MIN_HOURS_PRESENT();
      $chk_lateundertime_deductiontype            = $this->attendance_model->GET_LATEUNDERTIME_DEDUCTIONTYPE();
      $chk_late_deduction_perminute               = $this->attendance_model->GET_SETTING_VALUE('timekeeping_late_deduction_perminute');
      $chk_undertime_deduction_perminute          = $this->attendance_model->GET_SETTING_VALUE('timekeeping_undertime_deduction_perminute');
      $chk_graceperiod                            = $this->attendance_model->GET_GRACEPERIOD();

      // $assume_day_from    = "2024-11-12";
      // $assume_day_to      = "2024-11-15";
      $assume_present = 0;
      $assume_dates = [];
      $assume_dates_and_hours = [];
      
      // if($employee_id == 2){
        $shift_for_assume                           = $this->attendance_model->GET_SHIFT_ASSIGN_FOR_ASSUME($employee_id, $assume_day_from, $assume_day_to);
       
        foreach($shift_for_assume as $shift){
          $schd = $this->attendance_model->GET_WORK_SHIFT_CODE($shift->shift_id);

          if($schd->code != 'REST'){
            $assume_present += 1;
            $assume_dates[] = $shift->date;

            $assume_dates_and_hours[] = [
              'date' => $shift->date, 
              'hours' => $schd->time_regular_reg,
            ];
          }
        }
      // }

      $string_assume_day = json_encode($assume_dates);



      // Earnings / Deductions
      if (!empty($benefits_fixed_assign)) {
        foreach ($benefits_fixed_assign as $fixed_assign) {
          if ($fixed_assign->user_id == $employee_id) {
            $employeeObject->earning_deduction[] = $fixed_assign;
          }
        }
      }
      // Adjustment benefits
      if (!empty($benefits_adjustment_assign)) {
        foreach ($benefits_adjustment_assign as $adjustment_assign) {
          if ($adjustment_assign->user_id == $employee_id) {
            $employeeObject->adjustment_benefits[] = $adjustment_assign;
          }
        }
      }
      $data_arr = array();
      $index = 0;
      $error_shift_assign = 0;
      $sum_present = 0;
      $sum_absent = 0;
      $sum_tardiness = 0;
      $sum_undertime = 0;
      $sum_slider = 0;
      $sum_earlybreak = 0;
      $sum_overbreak = 0;
      $sum_paid_leave = 0;
      $sum_lwop = 0;
      $sum_awol = 0;
      $slider = 0;
      $sum_reg_hours = 0;
      $sum_reg_regot = 0;
      $sum_reg_nd = 0;
      $sum_reg_ndot = 0;
      $sum_rest_hours = 0;
      $sum_rest_regot = 0;
      $sum_rest_nd = 0;
      $sum_rest_ndot = 0;
      $sum_leg_hours = 0;
      $sum_leg_regot = 0;
      $sum_leg_nd = 0;
      $sum_leg_ndot = 0;
      $sum_legrest_hours = 0;
      $sum_legrest_regot = 0;
      $sum_legrest_nd = 0;
      $sum_legrest_ndot = 0;
      $sum_spe_hours = 0;
      $sum_spe_regot = 0;
      $sum_spe_nd = 0;
      $sum_spe_ndot = 0;
      $sum_sperest_hours = 0;
      $sum_sperest_regot = 0;
      $sum_sperest_nd = 0;
      $sum_sperest_ndot = 0;

      $additional_reg_hrs                 = 0;
      $additional_reg_hrs_count           = 0;

      $total_meal_allowance = 0;

      $zkteco_time_data = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD($employee_id);

       // check previous assume date attendance

      $prev_assume_absent = 0;
      $prev_assume_absent_dates = [];
      $prev_assume_absent_dates_and_hours = [];
      $prev_assume_tardiness = 0;

      if ($prev_daterange) {
        foreach ($prev_daterange as $prev_date) {

      //check previous assume tardiness
      $prev_date_str = $prev_date->format('Y-m-d');

      // 🔹 Get attendance record for this employee and date
      $attendance = $this->attendance_model->GET_ATTENDANCE_BY_DATE($employee_id, $prev_date_str);

      // 🔹 Get shift assignment for that day
      $shift_assign = $this->attendance_model->GET_SHIFT_ASSIGN_BY_DATE($employee_id, $prev_date_str);

      if ($attendance && $shift_assign) {
        $shift_info = $this->attendance_model->GET_WORK_SHIFT_CODE($shift_assign->shift_id);

        // Skip rest days
        if ($shift_info && $shift_info->code != 'REST') {

          $regular_start = strtotime($shift_info->time_regular_start); // scheduled in
          $actual_in = strtotime($attendance->time_in);

            // ✅ Check kung late siya (actual in > regular start)
            if (!empty($attendance->time_in) && $actual_in > $regular_start) {
              $late_minutes = ($actual_in - $regular_start) / 60;
              $late_hours = round($late_minutes / 60, 2);
              $prev_assume_tardiness += $late_hours;
            }
        }
      }

          $prev_zkteco_time_in        = "00:00";
          $prev_zkteco_time_out       = "00:00";
          $prev_zkteco_break_in       = "00:00";
          $prev_zkteco_break_out      = "00:00";

          $prev_remote_time_in        = "00:00";
          $prev_remote_time_out       = "00:00";
          $prev_remote_break_in       = "00:00";
          $prev_remote_break_out      = "00:00";

          $prev_raw_time_in           = '00:00';
          $prev_raw_time_out          = '00:00';
          $prev_raw_break_in          = '00:00';
          $prev_raw_break_out         = '00:00';

          $prev_attendance_date = $prev_date->format("Y-m-d");

          $prev_time_in_array         = [];
          $prev_time_out_array        = [];
          $prev_break_in_array        = [];
          $prev_break_out_array       = [];

          

          foreach ($zkteco_time_data as $zkteco_time_data_row) {
            if (date("Y-m-d", strtotime($zkteco_time_data_row->punch_time)) == $prev_attendance_date) {
              if ($zkteco_time_data_row->punch_state == 0) {
                array_push($prev_time_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
              } elseif ($zkteco_time_data_row->punch_state == 4) {
                array_push($prev_break_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
              } elseif ($zkteco_time_data_row->punch_state == 5) {
                array_push($prev_break_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
              } else {
                array_push($prev_time_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
              }
            }
          }


          if ($prev_time_in_array) {
            $prev_oldest_in_time = min(array_map('strtotime', $prev_time_in_array));
            $prev_zkteco_time_in = date("H:i", $prev_oldest_in_time);
          }
          if ($prev_time_out_array) {
            $prev_latest_time_out = max(array_map('strtotime', $prev_time_out_array));
            $prev_zkteco_time_out = date("H:i", $prev_latest_time_out);
          }
          if ($prev_break_in_array) {
            $prev_oldest_in_break = min(array_map('strtotime', $prev_break_in_array));
            $prev_zkteco_break_in = date("H:i", $prev_oldest_in_break);
          }
          if ($prev_break_out_array) {
            $prev_latest_break_out = min(array_map('strtotime', $prev_break_out_array));
            $prev_zkteco_break_out = date("H:i", $prev_latest_break_out);
          }

          foreach ($time_data as $time_data_row) {
            if ($time_data_row->date == $prev_attendance_date) {
              if (!is_null($time_data_row->time_in)) {
                $prev_remote_time_in = date("H:i", strtotime($time_data_row->time_in));
              } else {
                $prev_remote_time_in = "00:00";
              }
              if (!is_null($time_data_row->time_out)) {
                $prev_remote_time_out = date("H:i", strtotime($time_data_row->time_out));
              } else {
                $prev_remote_time_out = "00:00";
              }
              if (!is_null($time_data_row->break_in)) {
                $prev_remote_break_in = date("H:i", strtotime($time_data_row->break_in));
              } else {
                $prev_remote_break_in = "00:00";
              }
              if (!is_null($time_data_row->break_out)) {
                $prev_remote_break_out = date("H:i", strtotime($time_data_row->break_out));
              } else {
                $prev_remote_break_out = "00:00";
              }

              break;
            }
          }

          if ($prev_zkteco_time_in != "00:00" && $prev_remote_time_in != "00:00") {
            $prev_raw_time_in = min($prev_remote_time_in, $prev_zkteco_time_in);
          } else if ($prev_zkteco_time_in != "00:00" && $prev_remote_time_in == "00:00") {
            $prev_raw_time_in = $prev_zkteco_time_in;
          } else {
            $prev_raw_time_in = $prev_remote_time_in;
          }
          if ($prev_zkteco_time_out != "00:00" && $prev_remote_time_out != "00:00") {
            $prev_raw_time_out = max($prev_remote_time_out, $prev_zkteco_time_out);
          } else if ($prev_zkteco_time_out != "00:00" && $prev_remote_time_out == "00:00") {
            $prev_raw_time_out = $prev_zkteco_time_out;
          } else {
            $prev_raw_time_out = $prev_remote_time_out;
          }
          if ($prev_zkteco_break_in != "00:00" && $prev_remote_break_in != "00:00") {
            $prev_raw_break_in = min($prev_remote_break_in, $prev_zkteco_break_in);
          } else if ($prev_zkteco_break_in != "00:00" && $prev_remote_break_in == "00:00") {
            $prev_raw_break_in = $prev_zkteco_break_in;
          } else {
            $prev_raw_break_in = $prev_remote_break_in;
          }
          if ($prev_zkteco_break_out != "00:00" && $prev_remote_break_out != "00:00") {
            $prev_raw_break_out = max($prev_remote_break_out, $prev_zkteco_break_out);
          } else if ($prev_zkteco_break_out != "00:00" && $prev_remote_break_out == "00:00") {
            $prev_raw_break_out = $prev_zkteco_break_out;
          } else {
            $prev_raw_break_out = $prev_remote_break_out;
          }


          if ($prev_raw_time_in == "00:00" || $prev_raw_time_out == "00:00") {

            $shift_for_prev_assume = $this->attendance_model->GET_SHIFT_ASSIGN_FOR_PREV_ASSUME($employee_id, $prev_attendance_date);

            if ($shift_for_prev_assume) {
              foreach ($shift_for_prev_assume as $prev_shift) {
                $prev_schd = $this->attendance_model->GET_WORK_SHIFT_CODE($prev_shift->shift_id);

                if ($prev_schd->code != 'REST') {
                  $prev_assume_absent += 1;
                  $prev_assume_absent_dates[] = $prev_shift->date;

                  $prev_assume_absent_dates_and_hours[] = [
                    'date' => $prev_shift->date,
                    'hours' => $prev_schd->time_regular_reg,
                  ];
                }
              }
            }
          }
        }
      }

      $string_prev_assume_absent_dates = json_encode($prev_assume_absent_dates);


      foreach ($daterange as $date) {
        $current_date = $date->format("Y-m-d");
        $date_name = $date->format("M d, Y (D)");
        $date_pdf = $date->format("Y/m/d D");
        $shift_name = '-';
        $shift_regular_start = '00:00';
        $shift_regular_end = '00:00';
        $shift_break_start = '00:00';
        $shift_break_end = '00:00';
        $shift_overtime_start = '00:00';
        $shift_overtime_end = '00:00';
        $shift_regular_enable = 0;
        $shift_regular_reg = 0;
        $shift_nd_hours = 0;
        $shift_break_enable = 0;
        $shift_break_hours = 0;
        $shift_overtime_enable = 0;
        $shift_overtime_ot = 0;
        $shift_overtime_nd = 0;
        $shift_pdf = '-';
        $shift_color = '#555555';
        $hol_code = "REGULAR";
        $zkteco_time_in = "00:00";
        $zkteco_time_out = "00:00";
        $zkteco_break_in = "00:00";
        $zkteco_break_out = "00:00";
        $remote_time_in = "00:00";
        $remote_time_out = "00:00";
        $remote_break_in = "00:00";
        $remote_break_out = "00:00";
        $raw_time_in = '00:00';
        $raw_time_out = '00:00';
        $raw_break_in = '00:00';
        $raw_break_out = '00:00';
        $raw_shift_time_regular_start = '00:00';
        $raw_shift_time_regular_end = '00:00';
        $raw_shift_break_time_in = '00:00';
        $raw_shift_break_time_out = '00:00';
        $shift_break_hours = 0;
        $reg_hrs = 0;
        $assume_regular_reg = 0;
        $lwop = 0;
        $awol = 0;
        $calculate_work_duration = 0;
        $tardiness = 0;
        $current_assume_tardiness = 0;
        $undertime = 0;
        $work_hours = 0;
        $absent = 0;
        $exempt_undertime = 0;
        $remarks = '-';
        $paid_leave = 0;
        $paid_leave_type = '-';
        $reg_ot = 0;
        $nd_ot = 0;
        $early_ot = 0;
        $nd = 0;
        $leave_type = 0;
        $leave_typename = '-';
        $earlybreak = 0;
        $overbreak = 0;
        $attendance_color = '';
        $flag_legal_rest_daily_notpresent  = 0;

        $zkteco_time_data = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD($employee_id);
        foreach ($shift_assignment as $shift_assignment_row) {

          if ($shift_assignment_row->date == $current_date) {
            foreach ($shift_data as $shift_data_row) {
              if ($shift_assignment_row->shift_id == $shift_data_row->id) {
                $shift_name = $shift_data_row->code;
                $shift_regular_enable = $shift_data_row->time_regular_enable;
                $shift_regular_start = date("H:i", strtotime($shift_data_row->time_regular_start));
                $shift_regular_end = date("H:i", strtotime($shift_data_row->time_regular_end));
                $shift_regular_reg = $shift_data_row->time_regular_reg;
                $shift_nd_hours = $shift_data_row->time_regular_nd;
                $shift_break_enable = $shift_data_row->time_break_enable;
                $shift_break_start = date("H:i", strtotime($shift_data_row->time_break_start));
                $shift_break_end = date("H:i", strtotime($shift_data_row->time_break_end));
                $shift_break_hours = $shift_data_row->time_break_hours;
                $shift_overtime_enable = $shift_data_row->time_overtime_enable;
                $shift_overtime_start = date("H:i", strtotime($shift_data_row->time_overtime_start));
                $shift_overtime_end = date("H:i", strtotime($shift_data_row->time_overtime_end));
                $shift_overtime_ot = $shift_data_row->time_overtime_ot;
                $shift_overtime_nd = $shift_data_row->time_overtime_nd;
                if ($shift_data_row->code == "REST") {
                  $shift_name = "REST";
                }
                $shift_color = $shift_data_row->color;
                $raw_shift_time_regular_start = $shift_data_row->time_regular_start;
                $raw_shift_time_regular_end = $shift_data_row->time_regular_end;
                $raw_shift_break_time_in = $shift_data_row->time_break_start;
                $raw_shift_break_time_out = $shift_data_row->time_break_end;
                $shift_pdf = $shift_data_row->code;
                break;
              }
            }
            break;
          }
        }


        foreach ($shift_for_assume as $shift_for_assume_row){
          if($shift_for_assume_row->date == $current_date ){
          
            foreach ($shift_data as $shift_data_row) {
              if ($shift_for_assume_row->shift_id == $shift_data_row->id) {

                $assume_regular_reg = $shift_data_row->time_regular_reg;
                break;
              }
            }
            break;

          }
        }

        foreach ($holidays as $holiday) {
          if ($holiday->col_holi_date == $current_date) {
            if ($holiday->col_holi_type == "Regular Holiday") {
              $hol_code = "LEGAL";
            } else {
              $hol_code = "SPECIAL";
            }
            break;
          }
        }
        $time_in_array = [];
        $time_out_array = [];
        $break_in_array = [];
        $break_out_array = [];
        foreach ($zkteco_time_data as $zkteco_time_data_row) {
          if (date("Y-m-d", strtotime($zkteco_time_data_row->punch_time)) == $current_date) {
            if ($zkteco_time_data_row->punch_state == 0) {
              array_push($time_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            } elseif ($zkteco_time_data_row->punch_state == 4) {
              array_push($break_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            } elseif ($zkteco_time_data_row->punch_state == 5) {
              array_push($break_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            } else {
              array_push($time_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            }
          }
        }
        if ($time_in_array) {
          $oldest_in_time = min(array_map('strtotime', $time_in_array));
          $zkteco_time_in = date("H:i", $oldest_in_time);
        }
        if ($time_out_array) {
          $latest_time_out = max(array_map('strtotime', $time_out_array));
          $zkteco_time_out = date("H:i", $latest_time_out);
        }
        if ($break_in_array) {
          $oldest_in_break = min(array_map('strtotime', $break_in_array));
          $zkteco_break_in = date("H:i", $oldest_in_break);
        }
        if ($break_out_array) {
          $latest_break_out = min(array_map('strtotime', $break_out_array));
          $zkteco_break_out = date("H:i", $latest_break_out);
        }
        $snapshot_in = null;
        $snapshot_out = null;
        $time_in_address = null;
        $time_out_address = null;
        $break_in_snapshot = null;
        $break_in_address = null;
        $break_out_snapshot = null;
        $break_out_address = null;
        foreach ($time_data as $time_data_row) {
          if ($time_data_row->date == $current_date) {
            if (!is_null($time_data_row->time_in)) {
              $remote_time_in = date("H:i", strtotime($time_data_row->time_in));
            } else {
              $remote_time_in = "00:00";
            }
            if (!is_null($time_data_row->time_out)) {
              $remote_time_out = date("H:i", strtotime($time_data_row->time_out));
            } else {
              $remote_time_out = "00:00";
            }
            if (!is_null($time_data_row->break_in)) {
              $remote_break_in = date("H:i", strtotime($time_data_row->break_in));
            } else {
              $remote_break_in = "00:00";
            }
            if (!is_null($time_data_row->break_out)) {
              $remote_break_out = date("H:i", strtotime($time_data_row->break_out));
            } else {
              $remote_break_out = "00:00";
            }
            $snapshot_in = $time_data_row->snapshot_in;
            $snapshot_out = $time_data_row->snapshot_out;
            $time_in_address = $time_data_row->time_in_address;
            $time_out_address = $time_data_row->time_out_address;
            $break_in_snapshot = $time_data_row->break_in_snapshot;
            $break_in_address = $time_data_row->break_in_address;
            $break_out_snapshot = $time_data_row->break_out_snapshot;
            $break_out_address = $time_data_row->break_out_address;
            break;
          }
        }
        if ($zkteco_time_in != "00:00" && $remote_time_in != "00:00") {
          $raw_time_in = min($remote_time_in, $zkteco_time_in);
        } else if ($zkteco_time_in != "00:00" && $remote_time_in == "00:00") {
          $raw_time_in = $zkteco_time_in;
        } else {
          $raw_time_in = $remote_time_in;
        }
        if ($zkteco_time_out != "00:00" && $remote_time_out != "00:00") {
          $raw_time_out = max($remote_time_out, $zkteco_time_out);
        } else if ($zkteco_time_out != "00:00" && $remote_time_out == "00:00") {
          $raw_time_out = $zkteco_time_out;
        } else {
          $raw_time_out = $remote_time_out;
        }
        if ($zkteco_break_in != "00:00" && $remote_break_in != "00:00") {
          $raw_break_in = min($remote_break_in, $zkteco_break_in);
        } else if ($zkteco_break_in != "00:00" && $remote_break_in == "00:00") {
          $raw_break_in = $zkteco_break_in;
        } else {
          $raw_break_in = $remote_break_in;
        }
        if ($zkteco_break_out != "00:00" && $remote_break_out != "00:00") {
          $raw_break_out = max($remote_break_out, $zkteco_break_out);
        } else if ($zkteco_break_out != "00:00" && $remote_break_out == "00:00") {
          $raw_break_out = $zkteco_break_out;
        } else {
          $raw_break_out = $remote_break_out;
        }
        foreach ($approved_leaves as $approved_leaves_row) {
          if ($approved_leaves_row->leave_date == $current_date) {

            $leave_type_name = '';
            if ($approved_leaves_row->type > 0) {
              $leave_type_name = $this->attendance_model->GET_SPECIFIC_LEAVE_NAME($approved_leaves_row->type);
            }

            if ($leave_type_name != "Leave without Pay (LWOP)") {
              $paid_leave = $approved_leaves_row->duration;
              $leave_type = $approved_leaves_row->type;
              foreach ($leave_typelist as $leave_typelist_row) {
                if ($leave_type == $leave_typelist_row->id) {
                  $leave_typename = $leave_typelist_row->name;
                }
              }
              break;
            } else {
              $lwop = $approved_leaves_row->duration;
              break;
            }
          }
        }

        //--------------------------------- GET APPROVED EXEMPT UNDERTIME ------------------------------------
        foreach ($approved_undertime_exempt as $row_undertime) {
          if ($row_undertime->date_undertime == $current_date){
            $exempt_undertime = 1;
            $remarks = "Clear Club";
          }
        }

        // var_dump($raw_time_out);
        foreach ($approved_ot as $approved_ot_row) {
          if ($approved_ot_row->date_ot == $current_date) {
            if ($approved_ot_row->type == "Regular" || $approved_ot_row->type == "Regular Day") {
              if($approved_ot_row->early_ot){
              $early_ot = $approved_ot_row->early_ot;
            }
              $reg_ot = $approved_ot_row->hours;
            } else {
              $nd_ot = $approved_ot_row->hours;
            }
            break;
          }
        }

        $early_overtime = 0;
      $overtime = 0;
      $night_start = strtotime('22:00:00'); // Night starts at 22:00 (10:00 PM)
      $night_end = strtotime('06:00:00'); // Night ends at 06:00 (6:00 AM) the next day

      $time_regular_start = strtotime($raw_shift_time_regular_start);
      $time_regular_end = strtotime($raw_shift_time_regular_end);
      $actual_time_in = strtotime($raw_time_in);
      $actual_time_out = strtotime($raw_time_out);

      // Adjust time_out for next day if it's earlier than time_in
      if ($actual_time_out <= $actual_time_in) {
        $actual_time_out = strtotime('+1 day', $actual_time_out);
      }

      // Check for early overtime (early arrival)
      if ($actual_time_in < $time_regular_start) {
          if ($early_ot >= 1) {
              $early_overtime = ($time_regular_start - $actual_time_in) / 3600; // Convert seconds to hours
              
              // Round early overtime to nearest 0.5 (30 minutes)
              $early_overtime = floor($early_overtime * 2) / 2;
          }
      }

      if ($early_ot < 1) {
          if ($early_overtime < 1) {
              $early_overtime = 0;
          } else {
              // Even if early_ot < 1, if there's early overtime, round it
              $early_overtime = floor($early_overtime * 2) / 2;
          }
      }
    
      // // Calculate Overtime
      if ($actual_time_out > $time_regular_end) {
          if ($reg_ot >= 1) {
              if ($actual_time_out > $night_start) {
                  $overtime = ($night_start - $time_regular_end) / 3600;
              } else {
                  $overtime = ($actual_time_out - $time_regular_end) / 3600; // Convert seconds to hours
              }
              
              // Round overtime to nearest 0.5 (30 minutes)
              $overtime = floor($overtime * 2) / 2;
              
              if ($raw_shift_time_regular_end == "00:00:00" && $raw_shift_time_regular_start == "00:00:00") {
                  $total_worked_hours = ($actual_time_out - $actual_time_in) / 3600;
                  if ($total_worked_hours >= 8) {
                      $total_worked_hours -= 1;
                  }
                  
                  // Round total worked hours to nearest 0.5 for overtime calculation
                  $overtime = floor($total_worked_hours * 2) / 2;
              }
          }
      }
      
      if($reg_ot < 1){
        if($overtime < 1){
          $overtime = 0;
        }
      }

      if($reg_ot > $overtime){
        $reg_ot = $overtime;
      }

      if($early_ot > $early_overtime){
        $early_ot = $early_overtime;
      }
    
      
      $reg_ot += $early_ot;



        if ($paid_leave != 0) {
          if ($hol_code == "REGULAR") {
            $remarks = "Approved Leave";
            $shift_color = "#D6ECD7";
          } else if ($hol_code == "LEGAL") {
            $remarks = "ERR:LV on HOL";
            $paid_leave = 0;
          } else if ($hol_code == "SPECIAL") {
            $remarks = "ERR:LV on HOL";
            $paid_leave = 0;
          }
        }

        if ($salary_type == "Monthly") {

          if ($shift_name != '-' && $shift_name != 'REST') {
            $work_hours = $shift_regular_reg - $paid_leave;
            if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {
              $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
              if ($in_min < 0) {
                $in_min = 0;
              }


              // $chk_lateundertime_deductiontype = 1;
              if ($chk_graceperiod < $in_min) {
                if ($chk_late_deduction_perminute == 1) {
                  $tardiness = $in_min / 60;
                  $tardiness = round($tardiness, 2);
                } else {
                  $tardiness = ceil($in_min / 30) / 2;
                }
              } else {
                $tardiness = 0;
              }
          
              $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');
              if ($out_min < 0) {
                $out_min = 0;
              }



            // ---------------------------------------- NIGHT DIFFERENTIAL Attendance Record------------------------------------------------------

            $night_start = strtotime('22:00:00'); // Night starts at 22:00 (10:00 PM)
            $night_end = strtotime('06:00:00');   // Night ends at 06:00 (6:00 AM)
            $shift_regular_with_grace_period = date("H:i",strtotime($shift_regular_start . " +10 minutes"));
            
            if ($raw_time_in <= $shift_regular_with_grace_period) {
              $raw_time_in_nd = $shift_regular_start;
            } else {
              $raw_time_in_nd = $raw_time_in;
            }
              
            $raw_time_out_2 = $raw_time_out;
            if (strtotime($raw_time_out) < strtotime($raw_time_in_nd)) {
              $raw_time_out_2 = strtotime('+1 day', strtotime($raw_time_out));
            }
      
            // Initialize the night differential hours
            $night_diff_hours = 0;
  
            // Case 1: Calculate overlap of time_in within the night differential (04:00 to 06:00)
            if ($raw_time_in_nd <= $night_end) {
                // Calculate the overlap until 06:00 AM or the time_out, whichever comes first
                $nd += min($night_end, strtotime($raw_time_out_2)) - strtotime($raw_time_in_nd);
            }
        
            // Case 2: Calculate overlap of time_out within the night differential (22:00 to 23:00 or further)
            if($raw_time_out_2 > strtotime($shift_regular_end)){
              $raw_time_out_2 = strtotime($shift_regular_end);
            }
            if ($raw_time_out_2 > $night_start) {
                // Calculate the overlap starting from 22:00 PM until time_out or max overlap with time_in
                $nd += strtotime($raw_time_out_2) - max($night_start, strtotime($raw_time_in_nd));
            }
        
            // Convert seconds to hours
            $nd = $nd / 3600;
        
            // Ensure that the night differential is within the shift time
            if ($nd > 0) {
                $shift_duration = (strtotime($shift_regular_end) - strtotime($shift_regular_start)) / 3600; // Total shift duration in hours
                $nd = min($nd, $shift_duration); // Night differential should not exceed shift hours
            }

            if ($nd <= 0 ) {
              $nd = 0;
            }

            $nd = $this->round_night_diff($nd);

              // $chk_lateundertime_deductiontype = 0;
              if ($chk_undertime_deduction_perminute == 1) {
                $undertime = $out_min / 60;
              } else {
                $undertime = ceil($out_min / 30) / 2;
              }

              if ($exempt_undertime) {
                $undertime = 0;
              }

              $earlybreak = 0;
              if ($raw_break_in != "00:00") {
                $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
                if ($break_in_min < 0) {
                  $break_in_min = 0;
                }
                $earlybreak = ceil($break_in_min / 30) / 2;
              }
              $overbreak = 0;
              if ($raw_break_in != "00:00") {
                $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
                if ($break_out_min < 0) {
                  $break_out_min = 0;
                }
                $overbreak = ceil($break_out_min / 30) / 2;
              }
              $awol = $absent - $lwop;
              $reg_hrs = $work_hours - $awol - $lwop;
              
              $absent = $awol + $lwop;
              if ($reg_hrs < 0) {
                $reg_hrs = 0;
                $tardiness = 0;
                $undertime = 0;
                $awol = $work_hours - $lwop;
                $absent = $awol + $lwop;
                $remarks = "Invalid IN/OUT, Absent";
              }
            } else {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = $work_hours - $lwop;
              $absent = $awol + $lwop;
              if ($awol < 0) {
                $awol = 0;
              }
              if ($awol > 0 && $paid_leave != 0) {
                $remarks = "Partially Absent, Approved Leave";
              } elseif ($awol == 0 && ($paid_leave != 0 || $lwop != 0)) {
                $remarks = "Approved Leave";
              } elseif ($awol > 0) {
                $remarks = "NO IN/OUT, Absent";
              }
              // else {
              //   $remarks     = "NO IN/OUT, Absent";
              // }
            }

            if ($reg_hrs > 0 && $work_hours > 0 && ($awol > 0 || $lwop > 0 || $tardiness > 0 || $undertime > 0 || $earlybreak > 0 || $overbreak > 0)) {
              $attendance_color = '#ffeccc';
            } elseif ($reg_hrs > 0 && $work_hours > 0 && $awol <= 0 && $lwop <= 0 && $tardiness <= 0 && $undertime <= 0 && $earlybreak <= 0 && $overbreak <= 0) {
              $attendance_color = '#CCFFCC';
            }
            $slider += $this->slider($raw_time_in, $shift_regular_start);
            $raw_time_in;
            $raw_time_out;
            $raw_shift_time_regular_start;
            $raw_shift_time_regular_end;
            $work_hours;
            $calculate_work_duration;

      
          } else if ($shift_name == 'REST') {
            // $reg_ot = 0;
            // $nd = 0;
            // $nd_ot = 0;
            $attendance_color = '#EAEAEA';
          } else {
            $reg_ot = 0;
            $nd = 0;
            $nd_ot = 0;
            $remarks = "No Shift";
            $error_shift_assign = 1;
          }
          if ($awol < 0) {
                $awol = 0;
              }

          // if($assume_regular_reg){
          //   $reg_hrs += $assume_regular_reg;
          // }

          // HOURS NEEDED TO BE RENDERED BY THE USER
            if ($paid_leave == 0 && $shift_regular_reg >= 9.5) {
              $additional_reg_hrs_count += 1;
            }

        } elseif ($salary_type == "Daily") {
          if ($shift_name != '-' && $shift_name != 'REST') {
            $work_hours = $shift_regular_reg - $paid_leave;
            if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {
              $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
              if ($in_min < 0) {
                $in_min = 0;
              }

              // $chk_lateundertime_deductiontype = 1;
              if ($chk_graceperiod < $in_min) {
                if ($chk_late_deduction_perminute == 1) {
                  $tardiness = $in_min / 60;
                  $tardiness = round($tardiness, 2);
                } else {
                  $tardiness = ceil($in_min / 30) / 2;
                }
              } else {
                $tardiness = 0;
              }
              
              $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');
              if ($out_min < 0) {
                $out_min = 0;
              }

            // ---------------------------------------- NIGHT DIFFERENTIAL Attendance Record------------------------------------------------------

            $night_start = strtotime('22:00:00'); // Night starts at 22:00 (10:00 PM)
            $night_end = strtotime('06:00:00');   // Night ends at 06:00 (6:00 AM)
            $shift_regular_with_grace_period = date("H:i",strtotime($shift_regular_start . " +10 minutes"));
            
            if ($raw_time_in <= $shift_regular_with_grace_period) {
              $raw_time_in_nd = $shift_regular_start;
            } else {
              $raw_time_in_nd = $raw_time_in;
            }
              
            $raw_time_out_2 = $raw_time_out;
            if (strtotime($raw_time_out) < strtotime($raw_time_in_nd)) {
              $raw_time_out_2 = strtotime('+1 day', strtotime($raw_time_out));
            }
      
            // Initialize the night differential hours
            $night_diff_hours = 0;
  
            // Case 1: Calculate overlap of time_in within the night differential (04:00 to 06:00)
            if ($raw_time_in_nd <= $night_end) {
                // Calculate the overlap until 06:00 AM or the time_out, whichever comes first
                $nd += min($night_end, strtotime($raw_time_out_2)) - strtotime($raw_time_in_nd);
            }
        
            // Case 2: Calculate overlap of time_out within the night differential (22:00 to 23:00 or further)
            if($raw_time_out_2 > strtotime($shift_regular_end)){
              $raw_time_out_2 = strtotime($shift_regular_end);
            }
            if ($raw_time_out_2 > $night_start) {
                // Calculate the overlap starting from 22:00 PM until time_out or max overlap with time_in
                $nd += strtotime($raw_time_out_2) - max($night_start, strtotime($raw_time_in_nd));
            }
        
            // Convert seconds to hours
            $nd = $nd / 3600;
        
            // Ensure that the night differential is within the shift time
            if ($nd > 0) {
                $shift_duration = (strtotime($shift_regular_end) - strtotime($shift_regular_start)) / 3600; // Total shift duration in hours
                $nd = min($nd, $shift_duration); // Night differential should not exceed shift hours
            }

            if ($nd <= 0 ) {
              $nd = 0;
            }

            $nd = $this->round_night_diff($nd);


              // $chk_lateundertime_deductiontype = 0;
              if ($chk_undertime_deduction_perminute == 1) {
                $undertime = $out_min / 60;
              } else {
                $undertime = ceil($out_min / 30) / 2;
              }
              if ($exempt_undertime) {
                $undertime = 0;
              }
              $earlybreak = 0;
              if ($raw_break_in != "00:00") {
                $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
                if ($break_in_min < 0) {
                  $break_in_min = 0;
                }
                $earlybreak = ceil($break_in_min / 30) / 2;
              }
              $overbreak = 0;
              if ($raw_break_in != "00:00") {
                $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
                if ($break_out_min < 0) {
                  $break_out_min = 0;
                }
                $overbreak = ceil($break_out_min / 30) / 2;
              }
              $awol = $absent - $lwop;
              
              $reg_hrs = $work_hours - $awol - $lwop;
              if($assume_regular_reg){
              $reg_hrs = $assume_regular_reg;
              $tardiness = 0;
              }
              if ($reg_hrs < 0) {
                $reg_hrs = 0;
                $tardiness = 0;
                $undertime = 0;
                $awol = 0;
                $earlybreak = 0;
                $overbreak = 0;
                $remarks = "";
              }
            } elseif ($raw_time_in == "00:00" && $raw_time_out == "00:00") {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = 0;
              $earlybreak = 0;
              $overbreak = 0;
              $remarks = "Did not report";
            } else {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = 0;
              $earlybreak = 0;
              $overbreak = 0;
              $remarks = "Incomplete Time Record";
            }
            if ($reg_hrs > 0 && $work_hours > 0 && ($awol > 0 || $lwop > 0 || $tardiness > 0 || $undertime > 0 || $earlybreak > 0 || $overbreak > 0)) {
              $attendance_color = '#ffeccc';
            } elseif ($reg_hrs > 0 && $work_hours > 0 && $awol <= 0 && $lwop <= 0 && $tardiness <= 0 && $undertime <= 0 && $earlybreak <= 0 && $overbreak <= 0) {
              $attendance_color = '#CCFFCC';
            }


            $slider += $this->slider($raw_time_in, $shift_regular_start);
            $raw_time_in;
            $raw_time_out;
            $raw_shift_time_regular_start;
            $raw_shift_time_regular_end;
            $work_hours;
            $calculate_work_duration;
          } else if ($shift_name == 'REST') {
            // $reg_ot = 0;
            // $nd = 0;
            // $nd_ot = 0;
            $attendance_color = '#EAEAEA';
            if ($hol_code == "LEGAL" && $reg_hrs == 0) {
              $reg_hrs = 8;
              $flag_legal_rest_daily_notpresent = 1;
            }
          } else {
            $reg_ot = 0;
            $nd = 0;
            $nd_ot = 0;
            $remarks = "No Shift";
            $error_shift_assign = 1;
          }

          // $tardiness = 0;
          // $undertime = 0;
          // $absent = 0;
          // $awol = 0;
          // $lwop = 0;
          // $earlybreak = 0;
          // $overbreak = 0;

          // if($assume_regular_reg){
          //   $reg_hrs += $assume_regular_reg;
          // }
          // HOURS NEEDED TO BE RENDERED BY THE USER
            if ($paid_leave == 0 && $shift_regular_reg >= 9.5) {
              $additional_reg_hrs_count += 1;
            }
        
          
        }
        // var_dump($nd);
        if ($hol_code != "REGULAR") {
          $calculate_work_duration = 0;
          $work_hours = 0;
          // $tardiness = 0;
          $absent = 0;
          $awol = 0;
          $lwop = 0;
          // $earlybreak = 0;
          // $overbreak = 0;
        }
        // var_dump($tardiness);
        
        if ($reg_hrs >= $min_hrs_present) {
              $sum_present += 1;
            }

            
        $yesterday = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));

        if ($lwop >= 0  && (strtotime($yesterday) >= strtotime($current_date))) {
          $sum_lwop += $lwop;
        }
        if ($awol >= 0  && (strtotime($yesterday) >= strtotime($current_date))) {
          $sum_awol += $awol;
        }
        
        // remove awol if there is assume date
        foreach($assume_dates_and_hours as $date){
          if($awol > 0 && $date['date'] == $current_date){
            $sum_awol -= $date['hours'];
          }
          if ($date['date'] == $current_date){
             if ($reg_hrs >= $min_hrs_present) {
              $sum_present -= 1;
            }
          }
        }

        //check current_assume_tardiness
    foreach ($assume_dates as $assume_date) {
    // 🔹 Kunin attendance record ng employee sa date na iyon
    $attendance1 = $this->attendance_model->GET_ATTENDANCE_BY_DATE($employee_id, $assume_date);

    // 🔹 Kunin shift assignment ng araw na iyon
    $shift_assign = $this->attendance_model->GET_SHIFT_ASSIGN_BY_DATE($employee_id, $assume_date);

    if ($shift_assign) {
        // 🔹 Kunin shift info sa tbl_attendance_shifts
        $shift_info = $this->attendance_model->GET_WORK_SHIFT_CODE($shift_assign->shift_id);

        if ($attendance1 && $shift_info) {
            $regular_start = strtotime($shift_info->time_regular_start); // e.g. "08:00"
            $actual_in     = strtotime($attendance1->time_in);

            // ✅ Check kung may pasok talaga (may in/out)
            if ($attendance1->time_in != null && $attendance1->time_out != null) {

                // ✅ Check kung late sya (actual_in > regular_start)
                if ($actual_in > $regular_start) {
                    $late_minutes = ($actual_in - $regular_start) / 60; // convert to minutes
                    $tardiness_hours = round($late_minutes / 60, 2);    // convert to hours
                    $current_assume_tardiness += $tardiness_hours;
                    
                }

               
            }
        }
    }
    }

        // if ($absent >= 0) {
        //   $sum_absent += $absent;
        // }

      

        

        if ($sum_awol < 0) {
          $sum_awol = 0;
        }

        if ($tardiness >= 0) {
          $sum_tardiness += $tardiness;
        }
        if ($undertime >= 0) {
          $sum_undertime += $undertime;
        }
        if ($paid_leave >= 0) {
          $sum_paid_leave += $paid_leave;
        }
        if ($earlybreak >= 0) {
          $sum_earlybreak += $earlybreak;
        }
        if ($overbreak >= 0) {
          $sum_overbreak += $overbreak;
        }
        // var_dump($reg_ot );
        if ($hol_code == "REGULAR" && $shift_name != "REST") {
          if($assume_regular_reg > 0){ // assume hours
            $sum_reg_hours += $assume_regular_reg;
          }
          if ($reg_hrs > 0) {
            $sum_reg_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_reg_regot += $reg_ot;
          }
          if ($nd > 0) {
            $sum_reg_nd += $nd;
          }
          if ($nd_ot > 0) {
            $sum_reg_ndot += $nd_ot;
          }
        } elseif ($hol_code == "REGULAR" && $shift_name == "REST") {

          if ($reg_hrs > 0) {
            $sum_rest_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_rest_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_rest_ndot += $nd_ot;
          }
          if ($nd > 0) {
            $sum_rest_nd += $nd;
          }
        } elseif ($hol_code == "LEGAL" && $shift_name != "REST") {
          if ($assume_regular_reg > 0) { // assume hours
            $sum_leg_hours += $assume_regular_reg;
            $sum_leg_hours += 8;
          }
          if ($reg_hrs > 0) {
            $sum_reg_hours += $reg_hrs;
            $sum_leg_hours += 8;
          }
          if ($reg_ot > 0) {
            $sum_leg_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_leg_ndot += $nd_ot;
          }
          if ($nd > 0) {
            $sum_leg_nd += $nd;
          }
        } elseif ($hol_code == "LEGAL" && $shift_name == "REST") {
          
          if ($flag_legal_rest_daily_notpresent == 1) {
            $sum_leg_hours += 8;
          } else {
            if ($reg_hrs > 0) {
              $sum_legrest_hours += $reg_hrs;
            }
            if ($reg_ot > 0) {
              $sum_legrest_regot += $reg_ot;
            }
            if ($nd_ot > 0) {
              $sum_legrest_ndot += $nd_ot;
            }
            if ($nd > 0) {
              $sum_legrest_nd += $nd;
            }
          }
        } elseif ($hol_code == "SPECIAL" && $shift_name != "REST") {
          if ($assume_regular_reg > 0) { // assume hours
            $sum_reg_hours += $assume_regular_reg;
            $sum_spe_hours += 8;
          }

          if ($reg_hrs > 0) {
            $sum_reg_hours += $reg_hrs;
            $sum_spe_hours += 8;
          }
          if ($reg_ot > 0) {
            $sum_spe_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_spe_ndot += $nd_ot;
          }
          if ($nd > 0) {
            $sum_spe_nd += $nd;
          }
        } elseif ($hol_code == "SPECIAL" && $shift_name == "REST") {
          if ($reg_hrs > 0) {
            $sum_sperest_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_sperest_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_sperest_ndot += $nd_ot;
          }
          if ($nd > 0) {
            $sum_sperest_nd += $nd;
          }
        }

        


        // var_dump($sum_reg_nd);
        $meal_allowance_value             = $this->attendance_model->GET_SETTING_VALUE('allowance_meal_by_hour_value');
        $allowance_meal_by_hour           = $this->attendance_model->GET_SETTING_VALUE('allowance_meal_by_hour');
        $allowance_meal_by_hour_enable    = $this->attendance_model->GET_SETTING_VALUE('allowance_meal_by_hour_enable');

        if ($allowance_meal_by_hour_enable != '0' && $reg_hrs >= $allowance_meal_by_hour) {
          $total_meal_allowance += $meal_allowance_value;
        }

        if ($reg_hrs == 0) {
          $reg_hrs_disp = '';
        } else {
          $reg_hrs_disp = number_format($reg_hrs, 2);
        }
        if ($absent == 0) {
          $absent_disp = '';
        } else {
          $absent_disp = number_format($absent, 2);
        }
        if ($lwop == 0) {
          $lwop_disp = '';
        } elseif ($yesterday >= $current_date) {
          $lwop_disp = number_format($lwop, 2);
        }

        if ($awol < 0) {
                $awol = 0;
              }

        if ($awol == 0) {
          $awol_disp = '';
        } else {
          $awol_disp = number_format($awol, 2);
        }
        if ($tardiness == 0) {
          $tardiness_disp = '';
        } else {
          $tardiness_disp = number_format($tardiness, 2);
        }
        if ($undertime == 0) {
          $undertime_disp = '';
        } else {
          $undertime_disp = number_format($undertime, 2);
        }
        if ($paid_leave == 0) {
          $paid_leave_disp = '';
        } else {
          $paid_leave_disp = number_format($paid_leave, 2);
        }
        if ($reg_ot == 0) {
          $reg_ot_disp = '';
        } else {
          $reg_ot_disp = number_format($reg_ot, 2);
        }
        if ($nd_ot == 0) {
          $nd_ot_disp = '';
        } else {
          $nd_ot_disp = number_format($nd_ot, 2);
        }
        if ($nd == 0) {
          $nd_disp = '';
        } else {
          $nd_disp = number_format($nd, 2);
        }
        if ($raw_time_in == "00:00") {
          $raw_time_in = '';
        }
        if ($raw_time_out == "00:00") {
          $raw_time_out = '';
        }
        if ($raw_break_in == "00:00") {
          $raw_break_in = '';
        }
        if ($raw_break_out == "00:00") {
          $raw_break_out = '';
        }
        if ($shift_regular_start == "00:00") {
          $shift_regular_start = '';
        }
        if ($shift_regular_end == "00:00") {
          $shift_regular_end = '';
        }
        if ($shift_name == "REST") {
          $shift_regular_start = '';
          $shift_regular_end = '';
        }
        if ($shift_break_start == "00:00") {
          $shift_break_start = '';
        }
        if ($shift_break_end == "00:00") {
          $shift_break_end = '';
        }
        if ($shift_overtime_start == "00:00") {
          $shift_overtime_start = '';
        }
        if ($shift_overtime_end == "00:00") {
          $shift_overtime_end = '';
        }
        if ($earlybreak == 0) {
          $earlybreak_disp = '';
        } else {
          $earlybreak_disp = number_format($earlybreak, 2);
        }
        if ($overbreak == 0) {
          $overbreak_disp = '';
        } else {
          $overbreak_disp = number_format($overbreak, 2);
        }
        



        $index += 1;
        $employeeObject->reg_hrs[] = $reg_hrs;
        $employeeObject->paid_leaves[] = $paid_leave;
        $employeeObject->overtime[] = $reg_ot;
        $employeeObject->attendance_color[] = $attendance_color;
        $employeeObject->raw_time_out[] = $raw_time_out;
      }
      $sum_tardiness = round($sum_tardiness - $current_assume_tardiness, 2);
      if ($sum_tardiness <= 0) {
        $sum_tardiness = 0;
      }

      // COMPRESSED SCHEDULE LOGIC
        if ($additional_reg_hrs_count >= 10) {
          $additional_reg_hrs = 1;
        } else if ($additional_reg_hrs_count >= 5 && $additional_reg_hrs_count < 10) {
          $additional_reg_hrs = 0.5;
        }
        $sum_reg_hours += $additional_reg_hrs;

      // var_dump($reg_ot_disp);
      $unpaid_ot                          = $this->attendance_model->GET_APPROVED_UNPAID_OT($employee_id);
      $employeeObject->unpaid_ot          = $unpaid_ot;
      $employeeObject->sum_present        = $sum_present;
      $employeeObject->assume_present     = $assume_present;
      $employeeObject->assume_dates       = $assume_dates;
      $employeeObject->string_assume_days = $string_assume_day;

      $employeeObject->prev_assume_absent              = $prev_assume_absent;
      $employeeObject->prev_assume_absent_dates        = $prev_assume_absent_dates;
      $employeeObject->prev_string_assume_absent_dates = $prev_assume_absent_dates_and_hours;
      $employeeObject->prev_assume_tardiness              = $prev_assume_tardiness;

      $employeeObject->slider             = $slider;
      $employeeObject->sum_paid_leave     = $sum_paid_leave;
      $employeeObject->sum_earlybreak     = $sum_earlybreak;
      $employeeObject->sum_overbreak      = $sum_overbreak;
      $employeeObject->sum_tardiness      = $sum_tardiness;
      $employeeObject->sum_undertime      = $sum_undertime;
      $employeeObject->sum_awol           = $sum_awol;
      $employeeObject->sum_lwop           = $sum_lwop;

      $employeeObject->sum_reg_hours      = $sum_reg_hours;
      $employeeObject->sum_reg_regot      = $sum_reg_regot;
      $employeeObject->sum_reg_nd         = $sum_reg_nd;
      $employeeObject->sum_reg_ndot       = $sum_reg_ndot;

      $employeeObject->sum_rest_hours     = $sum_rest_hours;
      $employeeObject->sum_rest_regot     = $sum_rest_regot;
      $employeeObject->sum_rest_nd        = $sum_rest_nd;
      $employeeObject->sum_rest_ndot      = $sum_rest_ndot;

      $employeeObject->sum_leg_hours      = $sum_leg_hours;
      $employeeObject->sum_leg_regot      = $sum_leg_regot;
      $employeeObject->sum_leg_ndot       = $sum_leg_ndot;
      $employeeObject->sum_leg_nd         = $sum_leg_nd;

      $employeeObject->sum_legrest_hours  = $sum_legrest_hours;
      $employeeObject->sum_legrest_regot  = $sum_legrest_regot;
      $employeeObject->sum_legrest_ndot   = $sum_legrest_ndot;
      $employeeObject->sum_legrest_nd     = $sum_legrest_nd;

      $employeeObject->sum_spe_hours      = $sum_spe_hours;
      $employeeObject->sum_spe_regot      = $sum_spe_regot;
      $employeeObject->sum_spe_nd         = $sum_spe_nd;
      $employeeObject->sum_spe_ndot       = $sum_spe_ndot;

      $employeeObject->sum_sperest_hours  = $sum_sperest_hours;
      $employeeObject->sum_sperest_regot  = $sum_sperest_regot;
      $employeeObject->sum_sperest_ndot   = $sum_sperest_ndot;
      $employeeObject->sum_sperest_nd     = $sum_sperest_nd;

      $employeeObject->total_meal_allowance = $total_meal_allowance;
      $employeeAttendance[] = $employeeObject;
    }

    $data['DISP_ZKTECO_ATTENDANCE_DATA'] = $employeeAttendance;

    $data['RICE_SUB']       = $this->attendance_model->GET_SETTING_VALUE('allowance_ricesub_enable');
    $data['RICE_ALO']       = $this->attendance_model->GET_SETTING_VALUE('allowance_rice_enable');
    $data['OVM_ALO']        = $this->attendance_model->GET_SETTING_VALUE('allowance_otmeal_enable');
    $data['TRANSPO_ALO']    = $this->attendance_model->GET_SETTING_VALUE('allowance_transportaion_enable');
    $data['MEAL_ALO']       = $this->attendance_model->GET_SETTING_VALUE('allowance_meal_by_hour_enable');

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/attendance_summary_views', $data);
  }
  function attendance_basic_view()
  {
    //------------------- GET GLOBAL URI VARIABLES ----------------------------------
    $period = $this->input->get('period');
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    //------------------- GET PAYROLL PERIOD LIST FOR FRONTEND----------------------------------
    $data['CUTOFF_PERIODS'] = $this->attendance_model->GET_CUTOFF_LIST();
    //------------------- GET ROW LIST FOR FRONTEND----------------------------------
    $data["C_ROW_DISPLAY"] = [25, 50, 100, 500];
    //------------------- CUT OFF PERIOD FILTER----------------------------------
    if (isset($period)) {
      $date_period = $this->attendance_model->GET_CUTOFF($period);
    } else {
      $date_period = $this->attendance_model->GET_CUTOFF($data['CUTOFF_PERIODS'][0]->id);
    }
    //-------------------OTHER EARNING, DEDUCTIONS, LOANS, ADJUSTMENTS----------------------------------
    $data['DISP_BENEFITS_FIXED_ASSIGN'] = $benefits_fixed_assign = $this->attendance_model->GET_BENEFITS_FIXED_ASSIGN($date_period['id']);
    $data['DISP_BENEFITS_ADJUSTMENT_ASSIGN'] = $benefits_adjustment_assign = $this->attendance_model->GET_BENEFITS_ADJUSTMENT_ASSIGN($date_period['id']);
    $data['DISP_BENEFITS_DYNAMIC'] = $this->attendance_model->GET_BENEFITS_DYNAMIC_COUNT($date_period['id']);
    $dynamic_std = $this->attendance_model->GET_BENEFITS_DYNAMIC_STD();
    $employee_assign = $this->attendance_model->GET_EMPLOYEELIST_ASSIGN();
    foreach ($employee_assign as $assign) {
      foreach ($dynamic_std as $standard) {
        if ($assign->category == $standard->id) {
          $assign->category = $standard->name;
        }
      }
    }
    $data['DISP_EMPLOYEELIST_ASSIGN'] = $employee_assign;
    $data['DISP_DYNAMIC_STD'] = $dynamic_std;
    //-------------------OTHER EARNING, DEDUCTIONS, LOANS, ADJUSTMENTS----------------------------------
    $date_from = $date_period["date_from"];
    $date_to = $date_period["date_to"];
    $data['PERIOD'] = $period;
    $data['CUTOFF_PERIOD'] = $date_period;
    $data['DISP_ALL_APPROVED_OT'] = $overtime_data = $this->attendance_model->GET_ALL_APPROVED_OT($date_from, $date_to);
    $data['DISP_EMPLOYEES'] = $employees = $this->attendance_model->GET_EMPLOYEELIST_SUMMARY($offset, $row);
    $data['DISP_EMPLOYEES_ATTENDANCE_LOG'] = $attendance_records = $this->attendance_model->GET_ATTENDANCE_LOG_IN_OUT($date_from, $date_to);
    $data['DISP_EMPLOYEES_SHIFT'] = $employee_shifts = $this->attendance_model->GET_ATTENDANCE_EMPLOYEES_SHIFT($date_from, $date_to);
    $data['DISP_BENEFITS_BENEFITS_TYPE'] = $benefits_type = $this->attendance_model->GET_BENEFITS_FIXED_TYPE();
    $data['DISP_BENEFITS_ADJUSTMENT_TYPE'] = $adjustment_type = $this->attendance_model->GET_BENEFITS_ADJUSTMENT_TYPE();
    foreach ($benefits_fixed_assign as &$assign) {
      foreach ($benefits_type as $benefit) {
        if ($assign->type == $benefit->id) {
          $assign->type = $benefit->name;
        }
      }
    }
    foreach ($benefits_adjustment_assign as &$adjustment_assign) {
      foreach ($adjustment_type as $adjustment) {
        if ($adjustment_assign->type == $adjustment->id) {
          $adjustment_assign->type = $adjustment->name;
        }
      }
    }
    $data['LEAVE_ASSIGNS'] = $leaves_data = $this->attendance_model->GET_SPECIFIC_LEAVE_ASSIGN($date_from, $date_to);
    $data['DISP_HOLIDAYS'] = $holidays = $this->attendance_model->GET_HOLIDAY();
    $data['C_DATA_COUNT'] = $this->attendance_model->GET_EMPLOYEELIST_SUMMARY_COUNT();
    $data['shift_data'] = $this->attendance_model->GET_WORK_SHIFT_DATA();
    $data['DISP_LEAVE_NAMES'] = $this->attendance_model->GET_LEAVE_NAMES();
    $zkteco_attendance = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD_DATA($date_from, $date_to);
    $employeeAttendance = [];
    $begin = new DateTime($date_from);
    $end = new DateTime($date_to);
    $end = $end->modify('+1 day');
    $holidays = $this->attendance_model->GET_HOLIDAY();
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);
    foreach ($employees as $employee) {
      $employee_id = $employee->id;
      $employeeName = $employee->fullname;
      $LOG_empl_id = $employee_id;
      $current_date = '';
      $employeeObject = new stdClass();
      $employeeObject->id = $employee_id;
      $employeeObject->fullname = $employeeName;
      $employeeObject->reg_hrs = [];
      $employeeObject->paid_leaves = [];
      $employeeObject->overtime = [];
      $employeeObject->sum_reg_hours = [];
      $employeeObject->sum_leg_hours = [];
      $employeeObject->earning_deduction = [];
      $employeeObject->adjustment_benefits = [];
      $time_data = $this->attendance_model->GET_ATTENDANCE_RECORD($employee_id);
      $salary_type = $this->attendance_model->GET_SALARY_TYPE($employee_id);
      $approved_leaves = $this->attendance_model->GET_APPROVED_LEAVES($employee_id, $date_from, $date_to);
      $leave_typelist = $this->attendance_model->GET_LEAVE_NAMES();
      $approved_ot = $this->attendance_model->GET_APPROVED_OT($employee_id, $date_from, $date_to);
      $shift_assignment = $this->attendance_model->GET_SHIFT_ASSIGN_SPECIFIC($employee_id);
      $shift_data = $this->attendance_model->GET_WORK_SHIFT_DATA();
      $min_hrs_present = $this->attendance_model->GET_MIN_HOURS_PRESENT();
      $chk_lateundertime_deductiontype = $this->attendance_model->GET_LATEUNDERTIME_DEDUCTIONTYPE();

      $chk_late_deduction_perminute               = $this->attendance_model->GET_SETTING_VALUE('timekeeping_late_deduction_perminute');
      $chk_undertime_deduction_perminute          = $this->attendance_model->GET_SETTING_VALUE('timekeeping_undertime_deduction_perminute');

      $chk_graceperiod = $this->attendance_model->GET_GRACEPERIOD();
      // Earnings / Deductions
      if (!empty($benefits_fixed_assign)) {
        foreach ($benefits_fixed_assign as $fixed_assign) {
          if ($fixed_assign->user_id == $employee_id) {
            $employeeObject->earning_deduction[] = $fixed_assign;
          }
        }
      }
      // Adjustment benefits
      if (!empty($benefits_adjustment_assign)) {
        foreach ($benefits_adjustment_assign as $adjustment_assign) {
          if ($adjustment_assign->user_id == $employee_id) {
            $employeeObject->adjustment_benefits[] = $adjustment_assign;
          }
        }
      }
      $data_arr = array();
      $index = 0;
      $error_shift_assign = 0;
      $sum_present = 0;
      $sum_absent = 0;
      $sum_tardiness = 0;
      $sum_undertime = 0;
      $sum_slider = 0;
      $sum_earlybreak = 0;
      $sum_overbreak = 0;
      $sum_paid_leave = 0;
      $sum_lwop = 0;
      $sum_awol = 0;
      $slider = 0;
      $sum_reg_hours = 0;
      $sum_reg_regot = 0;
      $sum_reg_nd = 0;
      $sum_reg_ndot = 0;
      $sum_rest_hours = 0;
      $sum_rest_regot = 0;
      $sum_rest_nd = 0;
      $sum_rest_ndot = 0;
      $sum_leg_hours = 0;
      $sum_leg_regot = 0;
      $sum_leg_nd = 0;
      $sum_leg_ndot = 0;
      $sum_legrest_hours = 0;
      $sum_legrest_regot = 0;
      $sum_legrest_nd = 0;
      $sum_legrest_ndot = 0;
      $sum_spe_hours = 0;
      $sum_spe_regot = 0;
      $sum_spe_nd = 0;
      $sum_spe_ndot = 0;
      $sum_sperest_hours = 0;
      $sum_sperest_regot = 0;
      $sum_sperest_nd = 0;
      $sum_sperest_ndot = 0;
      foreach ($daterange as $date) {
        $current_date = $date->format("Y-m-d");
        $date_name = $date->format("M d, Y (D)");
        $date_pdf = $date->format("Y/m/d D");
        $shift_name = '-';
        $shift_regular_start = '00:00';
        $shift_regular_end = '00:00';
        $shift_break_start = '00:00';
        $shift_break_end = '00:00';
        $shift_overtime_start = '00:00';
        $shift_overtime_end = '00:00';
        $shift_regular_enable = 0;
        $shift_regular_reg = 0;
        $shift_nd_hours = 0;
        $shift_break_enable = 0;
        $shift_break_hours = 0;
        $shift_overtime_enable = 0;
        $shift_overtime_ot = 0;
        $shift_overtime_nd = 0;
        $shift_pdf = '-';
        $shift_color = '#555555';
        $hol_code = "REGULAR";
        $zkteco_time_in = "00:00";
        $zkteco_time_out = "00:00";
        $zkteco_break_in = "00:00";
        $zkteco_break_out = "00:00";
        $remote_time_in = "00:00";
        $remote_time_out = "00:00";
        $remote_break_in = "00:00";
        $remote_break_out = "00:00";
        $raw_time_in = '00:00';
        $raw_time_out = '00:00';
        $raw_break_in = '00:00';
        $raw_break_out = '00:00';
        $raw_shift_time_regular_start = '00:00';
        $raw_shift_time_regular_end = '00:00';
        $raw_shift_break_time_in = '00:00';
        $raw_shift_break_time_out = '00:00';
        $shift_break_hours = 0;
        $reg_hrs = 0;
        $lwop = 0;
        $awol = 0;
        $calculate_work_duration = 0;
        $tardiness = 0;
        $undertime = 0;
        $work_hours = 0;
        $absent = 0;
        $remarks = '-';
        $paid_leave = 0;
        $paid_leave_type = '-';
        $reg_ot = 0;
        $nd_ot = 0;
        $nd = 0;
        $leave_type = 0;
        $leave_typename = '-';
        $earlybreak = 0;
        $overbreak = 0;
        $attendance_color = '';
        $zkteco_time_data = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD($employee_id);
        foreach ($shift_assignment as $shift_assignment_row) {
          if ($shift_assignment_row->date == $current_date) {
            foreach ($shift_data as $shift_data_row) {
              if ($shift_assignment_row->shift_id == $shift_data_row->id) {
                $shift_name = $shift_data_row->code;
                $shift_regular_enable = $shift_data_row->time_regular_enable;
                $shift_regular_start = date("H:i", strtotime($shift_data_row->time_regular_start));
                $shift_regular_end = date("H:i", strtotime($shift_data_row->time_regular_end));
                $shift_regular_reg = $shift_data_row->time_regular_reg;
                $shift_nd_hours = $shift_data_row->time_regular_nd;
                $shift_break_enable = $shift_data_row->time_break_enable;
                $shift_break_start = date("H:i", strtotime($shift_data_row->time_break_start));
                $shift_break_end = date("H:i", strtotime($shift_data_row->time_break_end));
                $shift_break_hours = $shift_data_row->time_break_hours;
                $shift_overtime_enable = $shift_data_row->time_overtime_enable;
                $shift_overtime_start = date("H:i", strtotime($shift_data_row->time_overtime_start));
                $shift_overtime_end = date("H:i", strtotime($shift_data_row->time_overtime_end));
                $shift_overtime_ot = $shift_data_row->time_overtime_ot;
                $shift_overtime_nd = $shift_data_row->time_overtime_nd;
                if ($shift_data_row->code == "REST") {
                  $shift_name = "REST";
                }
                $shift_color = $shift_data_row->color;
                $raw_shift_time_regular_start = $shift_data_row->time_regular_start;
                $raw_shift_time_regular_end = $shift_data_row->time_regular_end;
                $raw_shift_break_time_in = $shift_data_row->time_break_start;
                $raw_shift_break_time_out = $shift_data_row->time_break_end;
                $shift_pdf = $shift_data_row->code;
                break;
              }
            }
            break;
          }
        }
        foreach ($holidays as $holiday) {
          if ($holiday->col_holi_date == $current_date) {
            if ($holiday->col_holi_type == "Regular Holiday") {
              $hol_code = "LEGAL";
            } else {
              $hol_code = "SPECIAL";
            }
            break;
          }
        }
        $time_in_array = [];
        $time_out_array = [];
        $break_in_array = [];
        $break_out_array = [];
        foreach ($zkteco_time_data as $zkteco_time_data_row) {
          if (date("Y-m-d", strtotime($zkteco_time_data_row->punch_time)) == $current_date) {
            if ($zkteco_time_data_row->punch_state == 0) {
              array_push($time_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            } elseif ($zkteco_time_data_row->punch_state == 4) {
              array_push($break_in_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            } elseif ($zkteco_time_data_row->punch_state == 5) {
              array_push($break_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            } else {
              array_push($time_out_array, date("H:i", strtotime($zkteco_time_data_row->punch_time)));
            }
          }
        }
        if ($time_in_array) {
          $oldest_in_time = min(array_map('strtotime', $time_in_array));
          $zkteco_time_in = date("H:i", $oldest_in_time);
        }
        if ($time_out_array) {
          $latest_time_out = max(array_map('strtotime', $time_out_array));
          $zkteco_time_out = date("H:i", $latest_time_out);
        }
        if ($break_in_array) {
          $oldest_in_break = min(array_map('strtotime', $break_in_array));
          $zkteco_break_in = date("H:i", $oldest_in_break);
        }
        if ($break_out_array) {
          $latest_break_out = min(array_map('strtotime', $break_out_array));
          $zkteco_break_out = date("H:i", $latest_break_out);
        }
        $snapshot_in = null;
        $snapshot_out = null;
        $time_in_address = null;
        $time_out_address = null;
        $break_in_snapshot = null;
        $break_in_address = null;
        $break_out_snapshot = null;
        $break_out_address = null;
        foreach ($time_data as $time_data_row) {
          if ($time_data_row->date == $current_date) {
            if (!is_null($time_data_row->time_in)) {
              $remote_time_in = date("H:i", strtotime($time_data_row->time_in));
            } else {
              $remote_time_in = "00:00";
            }
            if (!is_null($time_data_row->time_out)) {
              $remote_time_out = date("H:i", strtotime($time_data_row->time_out));
            } else {
              $remote_time_out = "00:00";
            }
            if (!is_null($time_data_row->break_in)) {
              $remote_break_in = date("H:i", strtotime($time_data_row->break_in));
            } else {
              $remote_break_in = "00:00";
            }
            if (!is_null($time_data_row->break_out)) {
              $remote_break_out = date("H:i", strtotime($time_data_row->break_out));
            } else {
              $remote_break_out = "00:00";
            }
            $snapshot_in = $time_data_row->snapshot_in;
            $snapshot_out = $time_data_row->snapshot_out;
            $time_in_address = $time_data_row->time_in_address;
            $time_out_address = $time_data_row->time_out_address;
            $break_in_snapshot = $time_data_row->break_in_snapshot;
            $break_in_address = $time_data_row->break_in_address;
            $break_out_snapshot = $time_data_row->break_out_snapshot;
            $break_out_address = $time_data_row->break_out_address;
            break;
          }
        }
        if ($zkteco_time_in != "00:00" && $remote_time_in != "00:00") {
          $raw_time_in = min($remote_time_in, $zkteco_time_in);
        } else if ($zkteco_time_in != "00:00" && $remote_time_in == "00:00") {
          $raw_time_in = $zkteco_time_in;
        } else {
          $raw_time_in = $remote_time_in;
        }
        if ($zkteco_time_out != "00:00" && $remote_time_out != "00:00") {
          $raw_time_out = max($remote_time_out, $zkteco_time_out);
        } else if ($zkteco_time_out != "00:00" && $remote_time_out == "00:00") {
          $raw_time_out = $zkteco_time_out;
        } else {
          $raw_time_out = $remote_time_out;
        }
        if ($zkteco_break_in != "00:00" && $remote_break_in != "00:00") {
          $raw_break_in = min($remote_break_in, $zkteco_break_in);
        } else if ($zkteco_break_in != "00:00" && $remote_break_in == "00:00") {
          $raw_break_in = $zkteco_break_in;
        } else {
          $raw_break_in = $remote_break_in;
        }
        if ($zkteco_break_out != "00:00" && $remote_break_out != "00:00") {
          $raw_break_out = max($remote_break_out, $zkteco_break_out);
        } else if ($zkteco_break_out != "00:00" && $remote_break_out == "00:00") {
          $raw_break_out = $zkteco_break_out;
        } else {
          $raw_break_out = $remote_break_out;
        }
        foreach ($approved_leaves as $approved_leaves_row) {
          if ($approved_leaves_row->leave_date == $current_date) {

            $leave_type_name = '';
            if ($approved_leaves_row->type > 0) {
              $leave_type_name = $this->attendance_model->GET_SPECIFIC_LEAVE_NAME($approved_leaves_row->type);
            }

            if ($leave_type_name != "Leave without Pay (LWOP)") {
              $paid_leave = $approved_leaves_row->duration;
              $leave_type = $approved_leaves_row->type;
              foreach ($leave_typelist as $leave_typelist_row) {
                if ($leave_type == $leave_typelist_row->id) {
                  $leave_typename = $leave_typelist_row->name;
                }
              }
              break;
            } else {
              $lwop = $approved_leaves_row->duration;
              break;
            }
          }
        }
        foreach ($approved_ot as $approved_ot_row) {
          if ($approved_ot_row->date_ot == $current_date) {
            if ($approved_ot_row->type == "Regular") {
              $reg_ot = $approved_ot_row->hours;
            } else {
              $nd_ot = $approved_ot_row->hours;
            }
            break;
          }
        }
        if ($paid_leave != 0) {
          if ($hol_code == "REGULAR") {
            $remarks = "Approved Leave";
            $shift_color = "#D6ECD7";
          } else if ($hol_code == "LEGAL") {
            $remarks = "ERR:LV on HOL";
            $paid_leave = 0;
          } else if ($hol_code == "SPECIAL") {
            $remarks = "ERR:LV on HOL";
            $paid_leave = 0;
          }
        }

        if ($salary_type == "Monthly") {
          if ($shift_name != '-' && $shift_name != 'REST') {
            $work_hours = $shift_regular_reg - $paid_leave;
            if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {
              $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
              if ($in_min < 0) {
                $in_min = 0;
              }



              if ($chk_graceperiod < $in_min) {
                if ($chk_late_deduction_perminute == 1) {
                  $tardiness = $in_min / 60;
                } else {
                  $tardiness = ceil($in_min / 30) / 2;
                }
              } else {
                $tardiness = 0;
              }
              $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');
              if ($out_min < 0) {
                $out_min = 0;
              }

              if ($chk_undertime_deduction_perminute == 1) {
                $undertime = $out_min / 60;
              } else {
                $undertime = ceil($out_min / 30) / 2;
              }
              $earlybreak = 0;
              if ($raw_break_in != "00:00") {
                $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
                if ($break_in_min < 0) {
                  $break_in_min = 0;
                }
                $earlybreak = ceil($break_in_min / 30) / 2;
              }
              $overbreak = 0;
              if ($raw_break_in != "00:00") {
                $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
                if ($break_out_min < 0) {
                  $break_out_min = 0;
                }
                $overbreak = ceil($break_out_min / 30) / 2;
              }
              $awol = $absent - $lwop;
              $reg_hrs = $work_hours - $awol - $lwop - $tardiness - $undertime - $earlybreak - $overbreak;

              $absent = $awol + $lwop;
              if ($reg_hrs < 0) {
                $reg_hrs = 0;
                $tardiness = 0;
                $undertime = 0;
                $awol = $work_hours - $lwop;
                $absent = $awol + $lwop;
                $remarks = "Invalid IN/OUT, Absent";
              }
            } else {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = $work_hours - $lwop;
              $absent = $awol + $lwop;
              if ($awol < 0) {
                $awol = 0;
              }
              if ($awol > 0 && $paid_leave != 0) {
                $remarks = "Partially Absent, Approved Leave";
              } elseif ($awol == 0 && ($paid_leave != 0 || $lwop != 0)) {
                $remarks = "Approved Leave";
              } elseif ($awol > 0) {
                $remarks = "NO IN/OUT, Absent";
              }
              // else {
              //   $remarks     = "NO IN/OUT, Absent";
              // }
            }

            if ($reg_hrs > 0 && $work_hours > 0 && ($awol > 0 || $lwop > 0 || $tardiness > 0 || $undertime > 0 || $earlybreak > 0 || $overbreak > 0)) {
              $attendance_color = '#ffeccc';
            } elseif ($reg_hrs > 0 && $work_hours > 0 && $awol <= 0 && $lwop <= 0 && $tardiness <= 0 && $undertime <= 0 && $earlybreak <= 0 && $overbreak <= 0) {
              $attendance_color = '#CCFFCC';
            }
            $slider += $this->slider($raw_time_in, $shift_regular_start);
            $raw_time_in;
            $raw_time_out;
            $raw_shift_time_regular_start;
            $raw_shift_time_regular_end;
            $work_hours;
            $calculate_work_duration;
          } else if ($shift_name == 'REST') { // if the employee worked in his/her rest day this code makes the count to zero so I removed it.
            // $reg_ot = 0;
            // $nd = 0;
            // $nd_ot = 0;
            $attendance_color = '#EAEAEA';
          } else {
            $reg_ot = 0;
            $nd = 0;
            $nd_ot = 0;
            $remarks = "No Shift";
            $error_shift_assign = 1;
          }
        } elseif ($salary_type == "Daily") {
          if ($shift_name != '-' && $shift_name != 'REST') {
            $work_hours = $shift_regular_reg - $paid_leave;
            if ($raw_time_in != "00:00" && $raw_time_out != "00:00") {
              $in_min = $this->convert_time_to_float($raw_time_in, 'minute') - $this->convert_time_to_float($shift_regular_start, 'minute');
              if ($in_min < 0) {
                $in_min = 0;
              }


              if ($chk_graceperiod < $in_min) {
                if ($chk_late_deduction_perminute == 1) {
                  $tardiness = $in_min / 60;
                } else {
                  $tardiness = ceil($in_min / 30) / 2;
                }
              } else {
                $tardiness = 0;
              }
              $out_min = $this->convert_time_to_float($shift_regular_end, 'minute') - $this->convert_time_to_float($raw_time_out, 'minute');
              if ($out_min < 0) {
                $out_min = 0;
              }
              if ($chk_undertime_deduction_perminute == 1) {
                $undertime = $out_min / 60;
              } else {
                $undertime = ceil($out_min / 30) / 2;
              }
              $earlybreak = 0;
              if ($raw_break_in != "00:00") {
                $break_in_min = $this->convert_time_to_float($shift_break_start, 'minute') - $this->convert_time_to_float($raw_break_in, 'minute');
                if ($break_in_min < 0) {
                  $break_in_min = 0;
                }
                $earlybreak = ceil($break_in_min / 30) / 2;
              }
              $overbreak = 0;
              if ($raw_break_in != "00:00") {
                $break_out_min = $this->convert_time_to_float($raw_break_out, 'minute') - $this->convert_time_to_float($shift_break_end, 'minute');
                if ($break_out_min < 0) {
                  $break_out_min = 0;
                }
                $overbreak = ceil($break_out_min / 30) / 2;
              }
              $awol = $absent - $lwop;
              $reg_hrs = $work_hours - $awol - $lwop - $tardiness - $undertime - $earlybreak - $overbreak;

              if ($reg_hrs < 0) {
                $reg_hrs = 0;
                $tardiness = 0;
                $undertime = 0;
                $awol = 0;
                $earlybreak = 0;
                $overbreak = 0;
                $remarks = "";
              }
            } elseif ($raw_time_in == "00:00" && $raw_time_out == "00:00") {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = 0;
              $earlybreak = 0;
              $overbreak = 0;
              $remarks = "Did not report";
            } else {
              $reg_hrs = 0;
              $tardiness = 0;
              $undertime = 0;
              $awol = 0;
              $earlybreak = 0;
              $overbreak = 0;
              $remarks = "Incomplete Time Record";
            }
            if ($reg_hrs > 0 && $work_hours > 0 && ($awol > 0 || $lwop > 0 || $tardiness > 0 || $undertime > 0 || $earlybreak > 0 || $overbreak > 0)) {
              $attendance_color = '#ffeccc';
            } elseif ($reg_hrs > 0 && $work_hours > 0 && $awol <= 0 && $lwop <= 0 && $tardiness <= 0 && $undertime <= 0 && $earlybreak <= 0 && $overbreak <= 0) {
              $attendance_color = '#CCFFCC';
            }


            $slider += $this->slider($raw_time_in, $shift_regular_start);
            $raw_time_in;
            $raw_time_out;
            $raw_shift_time_regular_start;
            $raw_shift_time_regular_end;
            $work_hours;
            $calculate_work_duration;
          } else if ($shift_name == 'REST') { // if the employee worked in his/her rest day this code makes the count to zero so I removed it.
            // $reg_ot = 0;
            // $nd = 0;
            // $nd_ot = 0;
            $attendance_color = '#EAEAEA';
          } else {
            $reg_ot = 0;
            $nd = 0;
            $nd_ot = 0;
            $remarks = "No Shift";
            $error_shift_assign = 1;
          }
          $tardiness = 0;
          $undertime = 0;
          $absent = 0;
          $awol = 0;
          $lwop = 0;
          $earlybreak = 0;
          $overbreak = 0;
        }
        if ($hol_code != "REGULAR") {
          $calculate_work_duration = 0;
          $work_hours = 0;
          $tardiness = 0;
          $absent = 0;
          $awol = 0;
          $lwop = 0;
          $earlybreak = 0;
          $overbreak = 0;
        }
        if ($reg_hrs >= $min_hrs_present) {
          $sum_present += 1;
        }
        if ($lwop >= 0) {
          $sum_lwop += $lwop;
        }
        if ($awol >= 0) {
          $sum_awol += $awol;
        }
        if ($absent >= 0) {
          $sum_absent += $absent;
        }
        if ($tardiness >= 0) {
          $sum_tardiness += $tardiness;
        }
        if ($undertime >= 0) {
          $sum_undertime += $undertime;
        }
        if ($paid_leave >= 0) {
          $sum_paid_leave += $paid_leave;
        }
        if ($earlybreak >= 0) {
          $sum_earlybreak += $earlybreak;
        }
        if ($overbreak >= 0) {
          $sum_overbreak += $overbreak;
        }
        if ($hol_code == "REGULAR" && $shift_name != "REST") {
          if ($reg_hrs > 0) {
            $sum_reg_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_reg_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_reg_nd += $nd_ot;
          }
          if ($nd > 0) {
            $sum_reg_ndot += $nd;
          }
        } elseif ($hol_code == "REGULAR" && $shift_name == "REST") {
          if ($reg_hrs > 0) {
            $sum_rest_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_rest_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_rest_ndot += $nd_ot;
          }
          if ($nd > 0) {
            $sum_rest_nd += $nd;
          }
        } elseif ($hol_code == "LEGAL" && $shift_name != "REST") {
          if ($reg_hrs > 0) {
            $sum_leg_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_leg_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_leg_nd += $nd_ot;
          }
          if ($nd > 0) {
            $sum_leg_ndot += $nd;
          }
        } elseif ($hol_code == "LEGAL" && $shift_name == "REST") {
          if ($reg_hrs > 0) {
            $sum_legrest_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_legrest_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_legrest_nd += $nd_ot;
          }
          if ($nd > 0) {
            $sum_legrest_ndot += $nd;
          }
        } elseif ($hol_code == "SPECIAL" && $shift_name != "REST") {
          if ($reg_hrs > 0) {
            $sum_spe_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_spe_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_spe_nd += $nd_ot;
          }
          if ($nd > 0) {
            $sum_spe_ndot += $nd;
          }
        } elseif ($hol_code == "SPECIAL" && $shift_name == "REST") {
          if ($reg_hrs > 0) {
            $sum_sperest_hours += $reg_hrs;
          }
          if ($reg_ot > 0) {
            $sum_sperest_regot += $reg_ot;
          }
          if ($nd_ot > 0) {
            $sum_sperest_nd += $nd_ot;
          }
          if ($nd > 0) {
            $sum_sperest_ndot += $nd;
          }
        }
        if ($reg_hrs == 0) {
          $reg_hrs_disp = '';
        } else {
          $reg_hrs_disp = number_format($reg_hrs, 2);
        }
        if ($absent == 0) {
          $absent_disp = '';
        } else {
          $absent_disp = number_format($absent, 2);
        }
        if ($lwop == 0) {
          $lwop_disp = '';
        } else {
          $lwop_disp = number_format($lwop, 2);
        }
        if ($awol == 0) {
          $awol_disp = '';
        } else {
          $awol_disp = number_format($awol, 2);
        }
        if ($tardiness == 0) {
          $tardiness_disp = '';
        } else {
          $tardiness_disp = number_format($tardiness, 2);
        }
        if ($undertime == 0) {
          $undertime_disp = '';
        } else {
          $undertime_disp = number_format($undertime, 2);
        }
        if ($paid_leave == 0) {
          $paid_leave_disp = '';
        } else {
          $paid_leave_disp = number_format($paid_leave, 2);
        }
        if ($reg_ot == 0) {
          $reg_ot_disp = '';
        } else {
          $reg_ot_disp = number_format($reg_ot, 2);
        }
        if ($nd_ot == 0) {
          $nd_ot_disp = '';
        } else {
          $nd_ot_disp = number_format($nd_ot, 2);
        }
        if ($nd == 0) {
          $nd_disp = '';
        } else {
          $nd_disp = number_format($nd, 2);
        }
        if ($raw_time_in == "00:00") {
          $raw_time_in = '';
        }
        if ($raw_time_out == "00:00") {
          $raw_time_out = '';
        }
        if ($raw_break_in == "00:00") {
          $raw_break_in = '';
        }
        if ($raw_break_out == "00:00") {
          $raw_break_out = '';
        }
        if ($shift_regular_start == "00:00") {
          $shift_regular_start = '';
        }
        if ($shift_regular_end == "00:00") {
          $shift_regular_end = '';
        }
        if ($shift_name == "REST") {
          $shift_regular_start = '';
          $shift_regular_end = '';
        }
        if ($shift_break_start == "00:00") {
          $shift_break_start = '';
        }
        if ($shift_break_end == "00:00") {
          $shift_break_end = '';
        }
        if ($shift_overtime_start == "00:00") {
          $shift_overtime_start = '';
        }
        if ($shift_overtime_end == "00:00") {
          $shift_overtime_end = '';
        }
        if ($earlybreak == 0) {
          $earlybreak_disp = '';
        } else {
          $earlybreak_disp = number_format($earlybreak, 2);
        }
        if ($overbreak == 0) {
          $overbreak_disp = '';
        } else {
          $overbreak_disp = number_format($overbreak, 2);
        }

        $index += 1;
        $employeeObject->reg_hrs[] = $reg_hrs;
        $employeeObject->paid_leaves[] = $paid_leave;
        $employeeObject->overtime[] = $reg_ot;
        $employeeObject->attendance_color[] = $attendance_color;
      }
      $employeeObject->sum_present = $sum_present;
      $employeeObject->slider = $slider;
      $employeeObject->sum_paid_leave = $sum_paid_leave;
      $employeeObject->sum_earlybreak = $sum_earlybreak;
      $employeeObject->sum_overbreak = $sum_overbreak;
      $employeeObject->sum_tardiness = $sum_tardiness;
      $employeeObject->sum_undertime = $sum_undertime;
      $employeeObject->sum_awol = $sum_awol;
      $employeeObject->sum_lwop = $sum_lwop;
      $employeeObject->sum_reg_hours = $sum_reg_hours;
      $employeeObject->sum_leg_hours = $sum_leg_hours;
      $employeeObject->sum_legrest_hours = $sum_legrest_hours;
      $employeeObject->sum_spe_hours = $sum_spe_hours;
      $employeeObject->sum_sperest_hours = $sum_sperest_hours;

      $employeeObject->sum_rest_hours     = $sum_rest_hours;
      $employeeObject->sum_rest_regot     = $sum_rest_regot;
      $employeeObject->sum_rest_nd        = $sum_rest_nd;
      $employeeObject->sum_rest_ndot      = $sum_rest_ndot;

      $employeeAttendance[] = $employeeObject;
    }
    $data['DISP_ZKTECO_ATTENDANCE_DATA'] = $employeeAttendance;

    $data['RICE_SUB'] = $this->attendance_model->GET_SETTING_VALUE('allowance_ricesub_enable');
    $data['RICE_ALO'] = $this->attendance_model->GET_SETTING_VALUE('allowance_rice_enable');
    $data['OVM_ALO'] = $this->attendance_model->GET_SETTING_VALUE('allowance_otmeal_enable');

    // echo '<pre>';
    // print_r($data);

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_attendance_summary_basic_views', $data);
  }
  function insert_data()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $updatedData = $data['updatedData'];
    $combinedData = $data['combinedData'];
    $cutOffVal = $data['cutOffVal'];
    $benefitsColumns = $data['benefitsColumns'];
    $columnNames = array_map('array_keys', $combinedData);
    $test_array = array();
    try {
      foreach ($combinedData as $index => $data_row) {
        $id = $data_row['id'];
        $value = $updatedData[$index][0];
        $selected = $updatedData[$index][1];
        if ($id == $value && $selected == true) {
          $attendance_lock_id = $this->attendance_model->upload_data($data_row, $cutOffVal);
          foreach ($data_row as $key => $columnValue) {
            if (in_array($key, $benefitsColumns)) {
              $benefits_val = array(
                'att_lock_id' => $attendance_lock_id,
                'type' => $key,
                'value' => $columnValue
              );
              $this->attendance_model->insert_benefits_column($benefits_val);
            }
          }
        }
      }
      $response = array('success_message' => 'Employee successfully endorsed!');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }
  function add_attendance_summary()
  {
    $data['DISP_EMPLOYEE_LIST']                       = $this->attendance_model->GET_EMPLOYEELIST_DATA();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_attendance_summary_views', $data);
  }

  function attendance_summary_assumedate(){

    $period     = $this->input->post('cut_off_period');
    $start      = $this->input->post('start_date');
    $end        = $this->input->post('end_date');

    $res = $this->attendance_model->INSERT_ASSUME_DATES($period, $start, $end);

    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
    }
    redirect($_SERVER["HTTP_REFERER"]);
  }

  function delete_assume_dates($period){

    $res = $this->attendance_model->DELETE_ASSUME_DATES($period);

    if ($res) {
      $response = array('success_message' => 'Data deleted successfully');
      // $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $response = array('warning_message' => 'An unexpected error occurred while deleting data.');
      // $this->session->set_flashdata('ERR', 'Fail to add new data');
    }
    echo json_encode($response);
    // redirect($_SERVER["HTTP_REFERER"]);

  }

  function edit_attendance_summary()
  {
    $data['DISP_EMPLOYEES'] = $employee_list = $this->attendance_model->GET_EMPLOYEELIST_SUMMARY_EDIT();
    if ($this->input->get('employee')) {
      $empl_id = $this->input->get('employee');
    } else {
      $empl_id = $employee_list[0]->id;
    }
    if ($this->input->get('start_date')) {
      $date_period = $this->input->get('start_date');
    } else {
      $date_period = date('Y-m-d');
    }
    if ($this->input->get('end_date')) {
      $end_date_period = $this->input->get('end_date');
    } else {
      $end_date_period = date('Y-m-d');
    }
    $data['DATE_PERIOD'] = $date_period;
    $data['END_DATE_PERIOD'] = $end_date_period;
    $data['EMPL_ID'] = $empl_id;
    $data['DISP_ATTENDANCE_RECORDS'] = $this->attendance_model->GET_ALL_ATTENDANCE_RECORD($empl_id, $date_period, $end_date_period);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/edit_attendance_summary_views', $data);
  }
  function edit_attendance_summary_advance()
  {
    $data['DISP_EMPLOYEES'] = $employee_list = $this->attendance_model->GET_EMPLOYEELIST_SUMMARY_EDIT();
    if ($this->input->get('employee')) {
      $empl_id = $this->input->get('employee');
    } else {
      $empl_id = $employee_list[0]->id;
    }
    if ($this->input->get('start_date')) {
      $date_period = $this->input->get('start_date');
    } else {
      $date_period = date('Y-m-d');
    }
    if ($this->input->get('end_date')) {
      $end_date_period = $this->input->get('end_date');
    } else {
      $end_date_period = date('Y-m-d');
    }
    $data['DATE_PERIOD'] = $date_period;
    $data['END_DATE_PERIOD'] = $end_date_period;
    $data['EMPL_ID'] = $empl_id;
    $data['DISP_ATTENDANCE_RECORDS'] = $this->attendance_model->GET_ALL_ATTENDANCE_RECORD_ADVANCE($empl_id, $date_period, $end_date_period);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/edit_attendance_summary_advance_views', $data);
  }
  function update_attendance_summary_advance()
  {
    $data['DISP_EMPLOYEES'] = $employee_list = $this->attendance_model->GET_EMPLOYEELIST_SUMMARY_EDIT();
    if ($this->input->get('employee')) {
      $empl_id = $this->input->get('employee');
    } else {
      $empl_id = $employee_list[0]->id;
    }
    if ($this->input->get('start_date')) {
      $date_period = $this->input->get('start_date');
    } else {
      $date_period = date('Y-m-d');
    }
    if ($this->input->get('end_date')) {
      $end_date_period = $this->input->get('end_date');
    } else {
      $end_date_period = date('Y-m-d');
    }
    $data['DATE_PERIOD'] = $date_period;
    $data['END_DATE_PERIOD'] = $end_date_period;
    $data['EMPL_ID'] = $empl_id;
    $data['DISP_ATTENDANCE_RECORDS'] = $this->attendance_model->GET_FOR_ADD_ATTENDANCE_RECORD_ADVANCE($empl_id, $date_period, $end_date_period);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/update_attendance_summary_advance_views', $data);
  }
  function update_attendance_record_advance()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    // $messageError = '';
    $filteredData = $data['filteredData'];
    $empl_id = $data['empl_id'];
    try {
      foreach ($filteredData as $data_row) {
        $this->attendance_model->UPDATE_ATTENDANCE_RECORD_ADVANCE($data_row, $empl_id);
      }
      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }
  function add_attendance_record()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    try {
      foreach ($data as $data_row) {
        $this->attendance_model->ADD_ATTENDANCE_RECORD($data_row);
      }
      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }
  function update_converter()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    try {
      foreach ($data as $data_row) {
        $this->attendance_model->UPDATE_CONVERTER($data_row);
      }
      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }
  function edit_attendance_record_advance()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    try {
      $updateCounter = 0;
      foreach ($data as $data_row) {
        $res = $this->attendance_model->edit_attendance_record_advance($data_row);
        if ($res) {
          $updateCounter = $updateCounter + $res;
        }
      }
      $response = array('success_message' => 'Data on ' . $updateCounter . ' dates updated successfully');
      if ($updateCounter) {
        $response = array('success_message' => 'Data on ' . $updateCounter . ' dates updated successfully');
      } else {
        $response = array('warning_message' => 'No data updated on any dates. ');
      }
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }
  function edit_attendance_record()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    try {
      $updateCounter = 0;
      foreach ($data as $data_row) {
        $res = $this->attendance_model->EDIT_ATTENDANCE_RECORD($data_row);
        if ($res) {
          $updateCounter = $updateCounter + $res;
        }
      }
      $response = array('success_message' => 'Data on ' . $updateCounter . ' dates updated successfully');
      if ($updateCounter) {
        $response = array('success_message' => 'Data on ' . $updateCounter . ' dates updated successfully');
      } else {
        $response = array('warning_message' => 'No data updated on any dates. ');
      }
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }
  function getEmployee($id)
  {
    $empl_info = $this->attendance_model->GET_EMPLOYEE_INFO($id);
    echo json_encode($empl_info);
  }
  function attendance_rec_csv_process()
  {
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $headers = fgetcsv($handle, 1000, ",");
    if (count($headers) != 6) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Incomplete Headers");
      redirect('attendances/attendance_rec_csv');
      return;
    }
    if (
      $headers[0] != 'date' || $headers[1] != 'Employee_id' || $headers[2] != 'time_in1' || $headers[3] != 'time_out1' ||
      $headers[4] != 'time_in2' || $headers[5] != 'time_out2'
    ) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Wrong Header Name");
      redirect('attendances/attendance_rec_csv');
      return;
    }
    $emp = $this->attendance_model->GET_ALL_EMP();
    $arr_data = array();
    function convert_id($array, $data)
    {
      $empl_id = "";
      foreach ($array as $row) {
        if ($row->col_empl_cmid == $data) {
          $empl_id = $row->id;
        }
      }
      return $empl_id;
    }
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $date_raw = date("Y-m-d", strtotime($data[0]));
      $user_raw = convert_id($emp, $data[1]);
      $response = $this->attendance_model->IS_DUPLICATE_CSV($date_raw, $user_raw);
      if ($response == 0) {
        $arr_data[$headers[0]] = date("Y-m-d", strtotime($data[0]));
        $arr_data[$headers[1]] = convert_id($emp, $data[1]);
        $arr_data[$headers[2]] = $data[2];
        $arr_data[$headers[3]] = $data[3];
        $this->attendance_model->INSERT_ATTENDANCE_REC_CSV($arr_data);
      } else {
        if ($data[2] == '') {
          $data_2 = '00:00:00';
        } else {
          $data_2 = $data[2];
        }
        if ($data[3] == '') {
          $data_3 = '00:00:00';
        } else {
          $data_3 = $data[3];
        }
        if ($data[4] == '') {
          $data_4 = '00:00:00';
        } else {
          $data_4 = $data[4];
        }
        if ($data[5] == '') {
          $data_5 = '00:00:00';
        } else {
          $data_5 = $data[5];
        }
        $arr_data[$headers[0]] = $data_2;
        $arr_data[$headers[1]] = $data_3;
        $arr_data[$headers[4]] = date("Y-m-d", strtotime($data[0]));
        $arr_data[$headers[5]] = convert_id($emp, $data[1]);
        $this->attendance_model->UPDATE_ATTENDANCE_REC_CSV($arr_data);
        $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Successfully uploaded data');
      }
    }
    fclose($handle);
    redirect('attendances/attendance_rec_csv');
  }
  function csv_uploads()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/csv_upload_views');
  }
  function approval_csv_process()
  {
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $headers = fgetcsv($handle, 1000, ",");
    if (count($headers) != 7) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Incomplete Headers");
      redirect('attendances/csv_import');
      return;
    }
    if (
      $headers[0] != 'Employee_id' || $headers[1] != 'approver_1a' || $headers[2] != 'approver_1b' ||
      $headers[3] != 'approver_2a' || $headers[4] != 'approver_2b' || $headers[5] != 'approver_3a' || $headers[6] != 'approver_3b'
    ) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Wrong Header Name");
      redirect('attendances/csv_import');
      return;
    }
    $emp = $this->attendance_model->GET_ALL_EMP();
    $arr_data = array();
    function convert_id($array, $data)
    {
      $empl_id = "";
      foreach ($array as $row) {
        if ($row->col_empl_cmid == $data) {
          $empl_id = $row->id;
        }
      }
      return $empl_id;
    }
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $arr_data[$headers[0]] = convert_id($emp, $data[0]);
      $arr_data[$headers[1]] = convert_id($emp, $data[1]);
      $arr_data[$headers[2]] = convert_id($emp, $data[2]);
      $arr_data[$headers[3]] = convert_id($emp, $data[3]);
      $arr_data[$headers[4]] = convert_id($emp, $data[4]);
      $arr_data[$headers[5]] = convert_id($emp, $data[5]);
      $arr_data[$headers[6]] = convert_id($emp, $data[6]);
      $this->attendance_model->INSERT_APPROVAL_CSV($arr_data);
    }
    fclose($handle);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Approval Updated Successfully!');
    redirect('attendances/approval_routes');
  }
  function csv_process()
  {
    $handle = fopen($_FILES['file']['tmp_name'], "r");
    $headers = fgetcsv($handle, 1000, ",");
    if (count($headers) != 34) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Incomplete Headers");
      redirect('attendances/csv_uploads');
      return;
    }
    if (
      $headers[0] != 'empl_id' || $headers[1] != 'cut_off' || $headers[2] != 'reg_hrs' ||
      $headers[3] != 'swap' || $headers[4] != 'rest_day_ot' || $headers[5] != 'legal_w' ||
      $headers[6] != 'legal_wo' || $headers[7] != 'spe_hol' || $headers[8] != 'reg_ot' ||
      $headers[9] != 'free_lunch' || $headers[10] != 'excess_ot_hol' || $headers[11] != 'excess_ot_spe' ||
      $headers[12] != 'excess_ot_reg' || $headers[13] != 'allo_meal_ot' || $headers[14] != 'nd' ||
      $headers[15] != 'nd_ot' || $headers[16] != 'absent' || $headers[17] != 'tardiness' ||
      $headers[18] != 'undertime' || $headers[19] != 'allo_rice' || $headers[20] != 'allo_ctpa' || $headers[21] != 'allo_sea' ||
      $headers[22] != 'allo_transpo' || $headers[23] != 'allo_swc' || $headers[24] != 'loan_rcbc' || $headers[25] != 'vac' ||
      $headers[26] != 'adj_medical' || $headers[27] != 'adj_rice' || $headers[28] != 'adj_nightdiff' || $headers[29] != 'adj_restot' ||
      $headers[30] != 'adj_shot' || $headers[31] != 'adj_lhot' || $headers[32] != 'adj_allo_transpo' || $headers[33] != 'adj_regot'
    ) {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_CSV', "Wrong Header Name");
      redirect('attendances/csv_uploads');
      return;
    }
    $arr_data = array();
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      $user_id = $this->attendance_model->GET_SPECIFIC_USER_ID($data[0])->id;
      if (empty($user_id)) {
        continue;
      }
      $arr_data[$headers[0]] = $user_id;
      $arr_data[$headers[1]] = $data[1];
      $arr_data[$headers[2]] = $data[2];
      $arr_data[$headers[3]] = $data[3];
      $arr_data[$headers[4]] = $data[4];
      $arr_data[$headers[5]] = $data[5];
      $arr_data[$headers[6]] = $data[6];
      $arr_data[$headers[7]] = $data[7];
      $arr_data[$headers[8]] = $data[8];
      $arr_data[$headers[9]] = $data[9];
      $arr_data[$headers[10]] = $data[10];
      $arr_data[$headers[11]] = $data[11];
      $arr_data[$headers[12]] = $data[12];
      $arr_data[$headers[13]] = $data[13];
      $arr_data[$headers[14]] = $data[14];
      $arr_data[$headers[15]] = $data[15];
      $arr_data[$headers[16]] = $data[16];
      $arr_data[$headers[17]] = $data[17];
      $arr_data[$headers[18]] = $data[18];
      $arr_data[$headers[19]] = $data[19];
      $arr_data[$headers[20]] = $data[20];
      $arr_data[$headers[21]] = $data[21];
      $arr_data[$headers[22]] = $data[22];
      $arr_data[$headers[23]] = $data[23];
      $arr_data[$headers[24]] = $data[24];
      $arr_data[$headers[25]] = $data[25];
      $arr_data[$headers[26]] = $data[26];
      $arr_data[$headers[27]] = $data[27];
      $arr_data[$headers[28]] = $data[28];
      $arr_data[$headers[29]] = $data[29];
      $arr_data[$headers[30]] = $data[30];
      $arr_data[$headers[31]] = $data[31];
      $arr_data[$headers[32]] = $data[32];
      $arr_data[$headers[33]] = $data[33];
      $this->attendance_model->INSERT_CSV($arr_data);
    }
    fclose($handle);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_CSV', 'Successfully uploaded data');
    redirect('attendances/csv_uploads');
  }
  function early_break($time, $shift)
  {
    $shift_min = $this->convert_time_to_float($shift, 'minute');
    $time_min = $this->convert_time_to_float($time, 'minute');
    $min = $shift_min - $time_min;
    $ded = 0.0;
    if (($min > 0) && ($min <= 15)) {
      $ded = 0.25;
    } else if (($min > 15) && ($min <= 30)) {
      $ded = 0.5;
    } else if (($min > 30) && ($min <= 45)) {
      $ded = 0.75;
    } else if ($min > 45) {
      $ded = 1.00;
    }
    return $ded;
  }
  function over_break($time, $shift)
  {
    $shift_min = $this->convert_time_to_float($shift, 'minute');
    $time_min = $this->convert_time_to_float($time, 'minute');
    $min = $shift_min - $time_min;
    $ded = 0;
    if (($min > 0) && ($min <= 15)) {
      $ded = 0.25;
    } else if (($min > 15) && ($min <= 30)) {
      $ded = 0.5;
    } else if (($min > 30) && ($min <= 45)) {
      $ded = 0.75;
    } else if ($min > 45) {
      $ded = 1;
    }
    return $ded;
  }
  function slider($time_in, $shift_in)
  {
    $shift_in_min = $this->convert_time_to_float($shift_in, 'minute');
    $time_in_min = $this->convert_time_to_float($time_in, 'minute');
    $in_min = $shift_in_min - $time_in_min;
    $shift_in_min;
    $time_in_min;
    $in_min;
    $in_slider = 0;
    if (($in_min > 0) && ($in_min <= 4)) {
      $in_slider = 1;
    }
    return $in_slider;
  }
  function convert_time_to_float($time, $type)
  {
    $split_time_in = explode(":", $time);
    if ($type == 'minute') {
      $converted_time = ((float) $split_time_in[0] * 60) + (float) $split_time_in[1];
    } else {
      $converted_time = (float) $split_time_in[0] + ((float) $split_time_in[1] / 60);
    }
    return (float) $converted_time;
  }

  function calculate_night_differential($time_in, $time_out, $shift_time_in, $shift_time_out)
  {
    $shift_in_min = $this->convert_time_to_float($shift_time_in, 'minute');
    $shift_out_min = $this->convert_time_to_float($shift_time_out, 'minute');
    $time_in_min = $this->convert_time_to_float($time_in, 'minute');
    $time_out_min = $this->convert_time_to_float($time_out, 'minute');
    $work_duration = 0;
    $work_duration_1 = 0;
    $work_duration_2 = 0;
    if ($shift_out_min < $shift_in_min || $shift_out_min > 1320) {
      if ($time_out_min < $time_in_min) {
        $work_duration_1 = 1440 - $time_in_min;
        $work_duration_2 = $time_out_min;
        if ($work_duration_1 > 120) {
          $work_duration_1 = 120;
        }
        if ($work_duration_2 > 360) {
          $work_duration_2 = 360;
        }
        $work_duration = ($work_duration_1 + $work_duration_2) / 60;
      } else {
        $work_duration_1 = $time_out_min - 1320;
        if ($time_in_min > 1320) {
          $work_duration = ($work_duration_1 - ($time_in_min - 1320)) / 60;
        } else {
          $work_duration = ($work_duration_1) / 60;
        }
      }
    }
    return (float) $work_duration;
  }
  function calculate_shift_duration($hasNextDay, $shift_time_in, $shift_time_out)
  {
    $shift_in_min = $this->convert_time_to_float($shift_time_in, 'minute');
    $shift_out_min = $this->convert_time_to_float($shift_time_out, 'minute');
    if ($shift_out_min >= $shift_in_min) {
      $work_duration = ($shift_out_min - $shift_in_min) / 60;
    } else {
      $work_duration = ($shift_out_min + (1440 - $shift_in_min)) / 60;
    }
    return (float) $work_duration;
  }
  function get_employee_data()
  {
    $employee_id = $this->input->get('employee');
    $date_period = $this->attendance_model->GET_PERIOD_DATA($this->input->get('period'));
    if (empty($date_period)) {
      $data['employee_data'] = array();
      $data['cutoff_data'] = array();
      return $data;
    }
    $start_date = $date_period['date_from'];
    $end_date = $date_period['date_to'];
    $data['employee_data'] = $this->attendance_model->MOD_DISP_EMPLOYEE($employee_id);
    $data['cutoff_data'] = $this->attendance_model->MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id);
    return $data;
  }
  function shift_assignment()
  {
    if (!isset($_GET["branch"]) || $_GET["branch"] === "undefined") {
      $param_branch = "all";
    } else {
      $param_branch = $_GET["branch"];
    }
    if (!isset($_GET["dept"]) || $_GET["dept"] === "undefined") {
      $param_dept = "all";
    } else {
      $param_dept = $_GET["dept"];
    }
    if (!isset($_GET["division"]) || $_GET["division"] === "undefined") {
      $param_division = "all";
    } else {
      $param_division = $_GET["division"];
    }
    if (!isset($_GET["clubhouse"]) || $_GET["clubhouse"] === "undefined") {
      $param_clubhouse = "all";
    } else {
      $param_clubhouse = $_GET["clubhouse"];
    }
    if (!isset($_GET["section"]) || $_GET["section"] === "undefined") {
      $param_section = "all";
    } else {
      $param_section = $_GET["section"];
    }
    if (!isset($_GET["group"]) || $_GET["group"] === "undefined") {
      $param_group = "all";
    } else {
      $param_group = $_GET["group"];
    }
    if (!isset($_GET["team"]) || $_GET["team"] === "undefined") {
      $param_team = "all";
    } else {
      $param_team = $_GET["team"];
    }
    if (!isset($_GET["line"]) || $_GET["line"] === "undefined") {
      $param_line = "all";
    } else {
      $param_line = $_GET["line"];
    }
    if (!isset($_GET["status"]) || $_GET["status"] === "undefined") {
      $param_status = "all";
    } else {
      $param_status = $_GET["status"];
    }
    if (!isset($_GET["employee"])) {
      $_GET["employee"] = "";
    }

    $showorignal = $_GET["show"] ?? "";
    var_dump($showorignal);
    // $search                                   = str_replace('_', ' ', $this->input->get('all') ?? "");
    $search = str_replace('_', ' ', $this->input->get('search') ?? "");
    $data["C_ROW_DISPLAY"] = [50];
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 50;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    if ($this->input->get('search') == null) {
      $data['DISP_EMP_LIST'] = $empl_list = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_2($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
      $data['DISP_EMP_LIST_DATA'] = $empl_list = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_DATA($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT'] = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
    } else {
      $data['DISP_EMP_LIST'] = $this->attendance_model->GET_SEARCHED($search);
      $data['DISP_EMP_LIST_DATA'] = $this->attendance_model->GET_SEARCHED_EMPL($search);
      $data['C_DATA_COUNT'] = count($this->attendance_model->GET_SEARCHED($search));
    }
    $data['DISP_ALL_EMP_LIST_DATA'] = $this->attendance_model->GET_SEARCHED_ALL_EMPL();
    $data['DISP_PAYROLL_SCHED'] = $payroll_list = $this->attendance_model->MOD_DISP_PAY_SCHED();
    if (!isset($_GET["period"])) {
      $period = $payroll_list[0]->id;
    } else {
      $period = $_GET["period"];
    }
    $data['PERIOD_INITIAL'] = $period;
    $res_data = $this->get_employee_data();
    $data['DISP_CUTOFF'] = $res_data['cutoff_data'];
    $data['DISP_WORK_SHIFT_DATA'] = $this->attendance_model->GET_WORK_SHIFT_DATA();
    $data['DISP_DISTINCT_BRANCH'] = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT'] = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION'] = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE'] = $this->attendance_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION'] = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP'] = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM'] = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE'] = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    $data['DISP_VIEW_BRANCH'] = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT'] = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP'] = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM'] = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    if (!empty($DISP_EMP_LIST)) {
      $data['DISP_USER_ID'] = $data['DISP_EMP_LIST'][0]->id;
    } else {
      $data['DISP_USER_ID'] = 0;
    }
    $date_period = $this->attendance_model->GET_PERIOD_DATA($period);
    if (isset($_GET['yearmonth_from'])) {
      $yearmonth_from = $_GET['yearmonth_from'];
    } else {
      $yearmonth_from = date('Y-m-01');
    }
    if (isset($_GET['yearmonth_to'])) {
      $yearmonth_to = $_GET['yearmonth_to'];
    } else {
      $yearmonth_to = date('Y-m-t');
    }
    $date = new DateTime();
    $current_date = $date->format("Y-m-d");
    $firstDay = date('Y-m-d', strtotime($yearmonth_from));
    $lastDay = date('Y-m-d', strtotime($yearmonth_to));
    $begin = new DateTime($firstDay);
    $end = new DateTime($lastDay);
    $end = $end->modify('+1 day');
    $holidays = $this->attendance_model->GET_HOLIDAY();
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);
    if ($showorignal) {
        $data['SHIFT_DATA_DATERANGE'] = $this->attendance_model->GET_SHIFT_DATA_DATERANGE_ORIG($firstDay, $lastDay);
    } else {
      $data['SHIFT_DATA_DATERANGE'] = $this->attendance_model->GET_SHIFT_DATA_DATERANGE($firstDay, $lastDay);
    }

    $approved_change_shift                      = $this->attendance_model->GET_ALL_APPROVED_CHANGE_SHIFT($firstDay, $lastDay);
    $approved_changeoff_shift                   = $this->attendance_model->GET_ALL_APPROVED_CHANGEOFF_SHIFT($firstDay, $lastDay);
    

    //------------------- GET APPROVED CHANGE SHIFT  ---------------------------------- 
    foreach ($approved_change_shift as $approved_change_row) {
      if ($approved_change_row->date_shift == $current_date) {
        $this->attendance_model->UPDATE_CHANGESHIFT($approved_change_row->empl_id, $approved_change_row->date_shift, $approved_change_row->request_shift);
       }
    }

    //------------------- GET APPROVED CHANGE SHIFT  ---------------------------------- 
    foreach ($approved_changeoff_shift as $approved_changeoff_row) {
      if ($approved_changeoff_row->date_shift == $current_date) {
        $this->attendance_model->UPDATE_CHANGESHIFT($approved_changeoff_row->empl_id, $approved_changeoff_row->date_shift, $approved_changeoff_row->request_shift);
        $this->attendance_model->UPDATE_CHANGESHIFT($approved_changeoff_row->empl_id, $approved_changeoff_row->date_shift_to, $approved_changeoff_row->request_shift_to);
          
      }
    }
    
    $data['DATE_FROM'] = $firstDay;
    $data['DATE_TO'] = $lastDay;
    $data['SHIFT_DATA'] = $this->attendance_model->GET_SHIFT_ALL_DATA();
    $data["DATE_RANGE"] = $this->assign_shift_data($daterange, $holidays);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/shift_assignment_views', $data);
  }

  function bulk_import()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/bulk_import_views');
  }
  function assign_shift_data($dates, $holidays)
  {
    $data_arr = array();
    $index = 0;
    foreach ($dates as $date) {
      $data_arr[$index]["Date"] = $date;
      $is_found = FALSE;
      $is_match = FALSE;
      $current_date = $date->format("Y-m-d");
      foreach ($holidays as $holiday) {
        if ($holiday->col_holi_date == $current_date) {
          if ($holiday->col_holi_type == "Regular Holiday") {
            $data_arr[$index]["holi_type"] = "LEGAL";
          } else {
            $data_arr[$index]["holi_type"] = "SPECIAL";
          }
          $is_found = TRUE;
          break;
        }
      }
      if (!$is_found) {
        $data_arr[$index]["holi_type"] = "REGULAR";
      }
      $index += 1;
    }
    return $data_arr;
  }
  function process_assigning($user_id, $shift_id, $date)
  {
    $response = $this->attendance_model->IS_DUPLICATE($user_id, $date);
    $response;
    if ($response == 0) {
      $res_insrt = $this->attendance_model->ADD_USER_WORK_SHIFT($user_id, $shift_id, $date);
    } else {
      $res_insrt = $this->attendance_model->UPDATE_USER_WORK_SHIFT($user_id, $shift_id, $date);
    }
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  public function update_data()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $updatedData = $data['updatedData'];
    $employeeData = $data['employeeData'];
    $extractedData = [];
    for ($i = 0; $i < count($updatedData); $i++) {
      $id = $updatedData[$i][0];
      for ($j = 3; $j < count($updatedData[$i]); $j++) {
        $shift = $updatedData[$i][$j];
        $date = $employeeData[$i][$j];
        if ($shift !== '') {
          array_push($extractedData, [$id, $shift, $date]);
        }
      }
    }
    try {
      foreach ($extractedData as $data_row) {
        $this->attendance_model->update_shift_data($data_row, $this->session->userdata('SESS_USER_ID'));
      }
      $response = array('success_message' => 'Data updated successfully');
    } catch (Exception $e) {
      $response = array('warning_message' => 'Error updating data: ' . $e->getMessage());
    }
    echo json_encode($response);
  }
  function update_shift()
  {
    $date_from = $this->input->post('DATE_FROM');
    $date_to = $this->input->post('DATE_TO');
    $mark_id = $this->input->post('UPDATE_ID');
    $shift_date = $this->input->post('UPDT_SHIFT_DATE');
    $data_arr = array();
    $ids_int = array_map('intval', explode(',', $mark_id));
    $begin = new DateTime($date_from);
    $end = new DateTime($date_to);
    $end = $end->modify('+1 day');
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end);
    $i = 0;
    $parts = [];
    for ($i = 0; $i < 7; $i++) {
      $shift_id[$i] = $this->input->post('UPDT_SHIFT_' . ($i + 1));
      $parts[$i] = explode(",", $shift_id[$i]);
    }
    $dayToShiftId = [
      $parts[0][1] => $parts[0][0],
      $parts[1][1] => $parts[1][0],
      $parts[2][1] => $parts[2][0],
      $parts[3][1] => $parts[3][0],
      $parts[4][1] => $parts[4][0],
      $parts[5][1] => $parts[5][0],
      $parts[6][1] => $parts[6][0],
    ];
    foreach ($ids_int as $ids_int_row) {
      foreach ($daterange as $dt) {
        $date = $dt->format("Y-m-d");
        $dayOfWeek = date("l", strtotime($date));
        $user_id = $ids_int_row;
        $response = $this->attendance_model->IS_DUPLICATE($user_id, $date);
        if (isset($dayToShiftId[$dayOfWeek])) {
          $shift_id = $dayToShiftId[$dayOfWeek];
          if ($response == 0) {
            $res_insrt = $this->attendance_model->ADD_USER_WORK_SHIFT($user_id, $shift_id, $date);
          } else {
            $res_insrt = $this->attendance_model->UPDATE_USER_WORK_SHIFT($user_id, $shift_id, $date);
          }
        }
      }
    }
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  function daily_attendances()
  {
    if (!isset($_GET["branch"]) || $_GET["branch"] === "undefined") {
      $param_branch = "all";
    } else {
      $param_branch = $_GET["branch"];
    }
    if (!isset($_GET["company"]) || $_GET["company"] === "undefined") {
      $param_company = "all";
    } else {
      $param_company = $_GET["company"];
    }
    if (!isset($_GET["dept"]) || $_GET["dept"] === "undefined") {
      $param_dept = "all";
    } else {
      $param_dept = $_GET["dept"];
    }
    if (!isset($_GET["division"]) || $_GET["division"] === "undefined") {
      $param_division = "all";
    } else {
      $param_division = $_GET["division"];
    }
    if (!isset($_GET["clubhouse"]) || $_GET["clubhouse"] === "undefined") {
      $param_clubhouse = "all";
    } else {
      $param_clubhouse = $_GET["clubhouse"];
    }
    if (!isset($_GET["section"]) || $_GET["section"] === "undefined") {
      $param_section = "all";
    } else {
      $param_section = $_GET["section"];
    }
    if (!isset($_GET["group"]) || $_GET["group"] === "undefined") {
      $param_group = "all";
    } else {
      $param_group = $_GET["group"];
    }
    if (!isset($_GET["team"]) || $_GET["team"] === "undefined") {
      $param_team = "all";
    } else {
      $param_team = $_GET["team"];
    }
    if (!isset($_GET["line"]) || $_GET["line"] === "undefined") {
      $param_line = "all";
    } else {
      $param_line = $_GET["line"];
    }
    if (!isset($_GET["employementtype"]) || $_GET["employementtype"] === "undefined") {
      $param_type = "all";
    } else {
      $param_type = $_GET["employementtype"];
    }
    if (isset($_GET['date'])) {
      $dateToday = $_GET['date'];
    } else {
      $dateToday = date('Y-m-d');
    }
    if (!isset($_GET["attendance_filter"])) {
      $param_attendance_filter = "";
    } else {
      $param_attendance_filter = $_GET["attendance_filter"];
    }
    $employees = $this->attendance_model->GET_EMPLOYEELIST_DAILY_ALL($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company, $param_type);
    $data['C_DATA_COUNT'] = $this->attendance_model->GET_EMPLOYEELIST_DAILY_COUNT($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line, $param_company, $param_type);
    $employee_count = $this->attendance_model->GET_EMPLOYEELIST_COUNT();
    $with_shift_data = $this->attendance_model->GET_WITH_SHIFT($dateToday);
    // var_dump($with_shift_data);
    // var_dump("awwwwwwwwww");
    $with_shift_count = $this->attendance_model->GET_WITH_SHIFT_COUNT($dateToday);
    // var_dump($with_shift_count);
    // var_dump("awwwwwwwwww");
    // $emplIdsWithShiftData = array_map(function ($shiftRecord) {
    //     return $shiftRecord->empl_id;
    // }, $with_shift_data);
    // $employeesWithShiftData = [];
    // $employeesWithoutShiftData = [];
    // foreach ($employees as $employee) {
    //     if (in_array($employee->id, $emplIdsWithShiftData)) {
    //         $employeesWithShiftData[] = $employee;
    //     } else {
    //         $employeesWithoutShiftData[] = $employee;
    //     }
    // }
    // if($param_attendance_filter != "" && $param_attendance_filter == "unassigned_shift"){
    //   $employees            =  $employeesWithoutShiftData;
    // }
    $leaves_data = $this->attendance_model->GET_SPECIFIC_LEAVE_ASSIGN_TODAY($dateToday);
    $shift_today = $this->attendance_model->GET_ATTENDANCE_EMPLOYEES_SHIFT_TODAY($dateToday);
    $attendance_remote = $this->attendance_model->GET_ATTENDANCE_REMOTE_TODAY_DATA($dateToday);
    $attendance_zkteco = $this->attendance_model->GET_ZKTECO_ATTENDANCE_RECORD_TODAY_DATA($dateToday);
    $chk_lateundertime_deductiontype = $this->attendance_model->GET_LATEUNDERTIME_DEDUCTIONTYPE();

    $chk_late_deduction_perminute               = $this->attendance_model->GET_SETTING_VALUE('timekeeping_late_deduction_perminute');
    $chk_undertime_deduction_perminute          = $this->attendance_model->GET_SETTING_VALUE('timekeeping_undertime_deduction_perminute');

    $chk_graceperiod = $this->attendance_model->GET_GRACEPERIOD();
    $empl_in = [];
    $empl_out = [];
    $remote_count = 0;
    $employee_leave_count = 0;
    $tardiness_count = 0;
    $undertime_count = 0;
    // foreach ($attendance_remote as $record) {
    //   if ($record->date === $dateToday) {
    //     $emplId = $record->empl_id;
    //     if ((isset($record->time_in) && $record->time_in != "00:00:00") || (isset($record->time_out) && $record->time_out != "00:00:00")) {
    //       if (!isset($empl_in[$emplId])) {
    //       }
    //     }
    //   }
    // }
    foreach ($attendance_remote as $record) {
      if ($record->date === $dateToday && isset($record->time_in) && $record->time_in != "00:00:00") {
        $emplId = $record->empl_id;
        if (!isset($empl_in[$emplId])) {
          $empl_in[$emplId] = true;
        }
      }
    }
    foreach ($attendance_zkteco as $record) {
      if ($record->punch_state === "0" && substr($record->punch_time, 0, 10) === $dateToday) {
        $emplId = $record->empl_id;
        if (!isset($empl_in[$emplId])) {
          $empl_in[$emplId] = true;
        }
      }
    }
    foreach ($attendance_remote as $record) {
      if ($record->date === $dateToday && isset($record->time_out) && $record->time_out != "00:00:00") {
        $emplId = $record->empl_id;
        if (!isset($empl_out[$emplId])) {
          $empl_out[$emplId] = true;
        }
      }
    }
    foreach ($attendance_zkteco as $record) {
      if ($record->punch_state === "1" && substr($record->punch_time, 0, 10) === $dateToday) {
        $emplId = $record->empl_id;
        if (!isset($empl_out[$emplId]) || $record->punch_time > $empl_out[$emplId]) {
          $empl_out[$emplId] = $record->punch_time;
        }
      }
    }
    $employeeAttendanceToday = [];
    $no_in = 0;
    $no_out = 0;
    $rest_count = 0;
    foreach ($employees as $employee) {
      $employeeId = $employee->id;
      $employeeCmid = $employee->col_empl_cmid;
      $employeeName = $employee->fullname;
      $employeeObject = new stdClass();
      $employeeObject->id = $employeeId;
      $employeeObject->cmid = $employeeCmid;
      $employeeObject->fullname = $employeeName;
      $employeeObject->shiftCode = [];
      $employeeObject->actIn = [];
      $employeeObject->actOut = [];
      $employeeObject->shiftBreakIn = [];
      $employeeObject->shiftBreakOut = [];
      $today_shift_code = '';
      $today_shift_in = '';
      $today_shift_out = '';
      $today_shift_reg_hrs = 0;
      $today_leave = 0;
      $tardiness = 0;
      $undertime = 0;
      foreach ($shift_today as $shift) {
        if ($shift->empl_id == $employeeId && $shift->date == $dateToday) {
          $today_shift_code = $shift->code;
          $today_shift_reg_hrs = $shift->time_regular_reg;
          $today_shift_in = $shift->time_regular_start;
          $today_shift_out = $shift->time_regular_end;
        }
      }
      foreach ($leaves_data as $leaveData) {
        if ($leaveData->empl_id == $employeeId && $leaveData->leave_date == $dateToday) {
          $today_leave = $leaveData->duration;
          $employee_leave_count++;
        }
      }
      $LOG_zkt_act_in = '';
      $LOG_zkt_act_out = '';
      $LOG_zkt_act_in_prev = '';
      $LOG_zkt_act_out_prev = '';
      $LOG_zkt_act_break_in = '';
      $LOG_zkt_act_break_out = '';
      $LOG_zkt_act_break_in_prev = '';
      $LOG_zkt_act_break_out_prev = '';
      $LOG_rem_act_in = '';
      $LOG_rem_act_in_add = '';
      $LOG_rem_act_in_img = '';
      $LOG_rem_act_out = '';
      $LOG_rem_act_out_add = '';
      $LOG_rem_act_out_img = '';
      $LOG_rem_act_break_in = '';
      $LOG_rem_act_break_in_add = '';
      $LOG_rem_act_break_in_img = '';
      $LOG_rem_act_break_out = '';
      $LOG_rem_act_break_out_add = '';
      $LOG_rem_act_break_out_img = '';
      $LOG_act_in = '';
      $LOG_act_out = '';
      $LOG_remote_act_in = '';
      $LOG_remote_act_out = '';
      $LOG_act_break_in = '';
      $LOG_act_break_out = '';
      // 

      foreach ($attendance_zkteco as $ZKT_attendance) {
        $punch_time = new DateTime($ZKT_attendance->punch_time);
        $punch_date = $punch_time->format('Y-m-d');
        $punch_state = $ZKT_attendance->punch_state;
        if ($ZKT_attendance->empl_id == $employeeId && $punch_date == $dateToday) {
          if ($punch_state == '0') {
            $LOG_zkt_act_in = $punch_time->format('H:i:s');
            if ($LOG_zkt_act_in_prev != '') {
              $timestamp1 = strtotime($LOG_zkt_act_in);
              $timestamp2 = strtotime($LOG_zkt_act_in_prev);
              if ($timestamp1 > $timestamp2) {
                $LOG_zkt_act_in = $LOG_zkt_act_in_prev;
              }
            }
            $LOG_zkt_act_in_prev = $LOG_zkt_act_in;
          } elseif ($punch_state == '1') {
            $LOG_zkt_act_out = $punch_time->format('H:i:s');
            if ($LOG_zkt_act_in_prev != '') {
              $timestamp1 = strtotime($LOG_zkt_act_out);
              $timestamp2 = strtotime($LOG_zkt_act_out_prev);
              if ($timestamp1 < $timestamp2) {
                $LOG_zkt_act_out = $LOG_zkt_act_out_prev;
              }
            }
            $LOG_zkt_act_out_prev = $LOG_zkt_act_out;
          } elseif ($punch_state == '4') {
            $LOG_zkt_act_break_in = $punch_time->format('H:i:s');
            if ($LOG_zkt_act_break_in_prev != '') {
              $timestamp1 = strtotime($LOG_zkt_act_break_in);
              $timestamp2 = strtotime($LOG_zkt_act_break_in_prev);
              if ($timestamp1 > $timestamp2) {
                $LOG_zkt_act_break_in = $LOG_zkt_act_break_in_prev;
              }
            }
            $LOG_zkt_act_break_in_prev = $LOG_zkt_act_break_in;
          } elseif ($punch_state == '5') {
            $LOG_zkt_act_break_out = $punch_time->format('H:i:s');
            if ($LOG_zkt_act_break_in_prev != '') {
              $timestamp1 = strtotime($LOG_zkt_act_break_out);
              $timestamp2 = strtotime($LOG_zkt_act_break_out_prev);
              if ($timestamp1 < $timestamp2) {
                $LOG_zkt_act_break_out = $LOG_zkt_act_break_out_prev;
              }
            }
            $LOG_zkt_act_break_out_prev = $LOG_zkt_act_break_out;
          }
        }
      }
      foreach ($attendance_remote as $REM_attendance) {
        if ($REM_attendance->empl_id == $employeeId && $REM_attendance->date == $dateToday) {
          $LOG_rem_act_in = ($REM_attendance->time_in != "00:00:00") ? $REM_attendance->time_in : "";
          $LOG_rem_act_in_add = ($REM_attendance->time_in_address != "") ? $REM_attendance->time_in_address : "";
          $LOG_rem_act_in_img = ($REM_attendance->snapshot_in != "") ? $REM_attendance->snapshot_in : "";

          $LOG_rem_act_out = ($REM_attendance->time_out != "00:00:00") ? $REM_attendance->time_out : "";
          $LOG_rem_act_out_add = ($REM_attendance->time_out_address != "") ? $REM_attendance->time_out_address : "";
          $LOG_rem_act_out_img = ($REM_attendance->snapshot_out != "") ? $REM_attendance->snapshot_out : "";

          $LOG_rem_act_break_in = $REM_attendance->break_in;
          $LOG_rem_act_break_in_add = $REM_attendance->break_in_address;
          $LOG_rem_act_break_in_img = $REM_attendance->break_in_snapshot;

          $LOG_rem_act_break_out = $REM_attendance->break_out;
          $LOG_rem_act_break_out_add = $REM_attendance->break_out_address;
          $LOG_rem_act_break_out_img = $REM_attendance->break_out_snapshot;
        }
      }
      if ($LOG_zkt_act_in == '' && $LOG_rem_act_in != '') {
        $LOG_act_in = $LOG_rem_act_in;
        $LOG_remote_act_in = $LOG_rem_act_in;
      } else if ($LOG_zkt_act_in != '' && $LOG_rem_act_in == '') {
        $LOG_act_in = $LOG_zkt_act_in;
      } else if ($LOG_zkt_act_in != '' && $LOG_rem_act_in != '') {
        $timestamp1 = strtotime($LOG_zkt_act_in);
        $timestamp2 = strtotime($LOG_rem_act_in);
        if ($timestamp1 > $timestamp2) {
          $LOG_act_in = $LOG_rem_act_in;
          $LOG_remote_act_in = $LOG_rem_act_in;
        } else {
          $LOG_act_in = $LOG_zkt_act_in;
        }
      }
      if ($LOG_zkt_act_out == '' && $LOG_rem_act_out != '') {
        $LOG_act_out = $LOG_rem_act_out;
        $LOG_remote_act_out = $LOG_rem_act_out;
      } else if ($LOG_zkt_act_out != '' && $LOG_rem_act_out == '') {
        $LOG_act_out = $LOG_zkt_act_out;
      } else if ($LOG_zkt_act_out != '' && $LOG_rem_act_out != '') {
        $timestamp1 = strtotime($LOG_zkt_act_out);
        $timestamp2 = strtotime($LOG_rem_act_out);
        if ($timestamp1 < $timestamp2) {
          $LOG_act_out = $LOG_rem_act_out;
          $LOG_remote_act_out = $LOG_rem_act_out;
        } else {
          $LOG_act_out = $LOG_zkt_act_out;
        }
      }
      if ($today_shift_code != '' && $today_shift_code != 'REST') {
        if ($LOG_act_in != '' && $LOG_act_out != '') {
          $in_min = $this->convert_time_to_float($LOG_act_in, 'minute') - $this->convert_time_to_float($today_shift_in, 'minute');
          if ($in_min < 0) {
            $in_min = 0;
          }

          if ($chk_graceperiod < $in_min) {
            if ($chk_late_deduction_perminute == 1) {
              $tardiness = $in_min / 60;
            } else {
              $tardiness = ceil($in_min / 30) / 2;
            }
          } else {
            $tardiness = 0;
          }
          if ($tardiness > 0) {
            $tardiness_count++;
          }
          $out_min = $this->convert_time_to_float($today_shift_out, 'minute') - $this->convert_time_to_float($LOG_act_out, 'minute');
          if ($out_min < 0) {
            $out_min = 0;
          }
          if ($chk_undertime_deduction_perminute == 1) {
            $undertime = $out_min / 60;
          } else {
            $undertime = ceil($out_min / 30) / 2;
          }
          if ($undertime > 0) {
            $undertime_count++;
          }
        }
        if (!$LOG_act_in) {
          $no_in++;
        }
        if (!$LOG_act_out) {
          $no_out++;
        }
      } elseif ($today_shift_code != '' && $today_shift_code == 'REST') {
        $rest_count++;
      }
      if ($LOG_remote_act_in != "" || $LOG_remote_act_out != "") {
        $remote_count++;
      }
      $employeeObject->shiftCode = $today_shift_code;
      $employeeObject->shiftIn = $today_shift_in ? date("H:i", strtotime($today_shift_in)) : "";
      $employeeObject->shiftOut = $today_shift_out ? date("H:i", strtotime($today_shift_out)) : "";
      $employeeObject->shiftBreakIn = $LOG_rem_act_break_in ? date("H:i", strtotime($LOG_rem_act_break_in)) : "";
      $employeeObject->shiftBreakOut = $LOG_rem_act_break_out ? date("H:i", strtotime($LOG_rem_act_break_out)) : "";
      $employeeObject->actIn = $LOG_act_in ? date("H:i", strtotime($LOG_act_in)) : "";
      $employeeObject->actOut = $LOG_act_out ? date("H:i", strtotime($LOG_act_out)) : "";
      $employeeObject->undertime = $undertime != 0 ? $undertime : "";
      $employeeObject->tardiness = $tardiness != 0 ? $tardiness : "";
      $employeeObject->onLeave = $today_leave != 0 ? $today_leave : "";
      $employeeObject->RemoteActIn = $LOG_remote_act_in;
      $employeeObject->RemoteActOut = $LOG_remote_act_out;
      $employeeObject->time_in_add = $LOG_rem_act_in_add;
      $employeeObject->time_in_img = $LOG_rem_act_in_img;
      $employeeObject->time_out_add = $LOG_rem_act_out_add;
      $employeeObject->time_out_img = $LOG_rem_act_out_img;
      $employeeObject->break_in_add = $LOG_rem_act_break_in_add;
      $employeeObject->break_in_img = $LOG_rem_act_break_in_img;
      $employeeObject->break_out_add = $LOG_rem_act_break_out_add;
      $employeeObject->break_out_img = $LOG_rem_act_break_out_img;
      $employeeAttendanceToday[] = $employeeObject;
    }
    $noShiftCodeCount = 0;
    foreach ($employeeAttendanceToday as $employee) {
      if (empty($employee->shiftCode)) {
        $noShiftCodeCount++;
      }
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "unassigned_shift") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (empty($employee->shiftCode)) {
          $filteredEmployeeAttendance[] = $employee;
          // var_dump($employee->cmid);
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "rest_count") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (!empty($employee->shiftCode) && $employee->shiftCode == "REST") {
          $filteredEmployeeAttendance[] = $employee;
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "on_leave") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (!empty($employee->onLeave)) {
          $filteredEmployeeAttendance[] = $employee;
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "remote_count") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (!empty($employee->RemoteActIn) || !empty($employee->RemoteActOut)) {
          $filteredEmployeeAttendance[] = $employee;
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "no_in") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (empty($employee->actIn) && $employee->shiftCode != "REST" && $employee->shiftCode != "") {
          $filteredEmployeeAttendance[] = $employee;
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "no_out") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (empty($employee->actOut) && $employee->shiftCode != "REST" && $employee->shiftCode != "") {
          $filteredEmployeeAttendance[] = $employee;
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "with_undertime") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (!empty($employee->undertime)) {
          $filteredEmployeeAttendance[] = $employee;
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    if ($param_attendance_filter != "" && $param_attendance_filter == "with_tardiness") {
      $filteredEmployeeAttendance = [];
      foreach ($employeeAttendanceToday as $employee) {
        if (!empty($employee->tardiness)) {
          $filteredEmployeeAttendance[] = $employee;
        }
      }
      $employeeAttendanceToday = $filteredEmployeeAttendance;
    }
    $data['DISP_ATTENDANCE_TODAY'] = $employeeAttendanceToday;
    $current_in_shift = $no_in;
    $data['DISP_ALL_EMPLOYEE_COUNT'] = $employee_count;
    // $data['DISP_UNASSIGNED_SHIFT_COUNT']        = $employee_count - $with_shift_count;
    $data['DISP_UNASSIGNED_SHIFT_COUNT'] = $noShiftCodeCount;
    $data['DISP_WITH_SHIFT_COUNT'] = $with_shift_count;
    $data['DISP_IN_SHIFT_COUNT'] = $current_in_shift;
    $data['DISP_OUT_SHIFT_COUNT'] = $no_out;
    $data['DISP_REMOTE_COUNT'] = $remote_count;
    $data['DISP_REST_COUNT'] = $rest_count;
    $data['DISP_LEAVE_COUNT'] = $employee_leave_count;
    $data['DISP_TARDINESS_COUNT'] = $tardiness_count;
    $data['DISP_UNDERTIME_COUNT'] = $undertime_count;
    $data['DISP_VIEW_COMPANY'] = $this->attendance_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH'] = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DIVISION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_TEAM'] = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_DEPARTMENT'] = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_SECTION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP'] = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_LINE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    $data["C_COM_STRUCTURE"] = $this->attendance_model->GET_COMP_STRUCTURE();
    $data['C_TYPE'] = $this->attendance_model->GET_TYPE();
    $data['C_COMPANIES'] = $this->attendance_model->GET_COMPANIES();
    $data['C_POSITIONS'] = $this->attendance_model->GET_POSITION();
    $data['C_DEPARTMENTS'] = $this->attendance_model->GET_DEPARTMENTS();
    $data['C_SECTIONS'] = $this->attendance_model->GET_SECTIONS();
    $data['C_GROUPS'] = $this->attendance_model->GET_GROUPS();
    $data['C_LINES'] = $this->attendance_model->GET_LINES();
    $data['C_EMPLOYMENT_TYPES'] = $this->attendance_model->GET_EMPLOYEMENT_TYPES();
    $data['C_TEAMS'] = $this->attendance_model->GET_TEAMS();
    $data['C_BRANCH'] = $this->attendance_model->GET_BRANCHES();
    $data['C_DIVISIONS'] = $this->attendance_model->GET_DIVISIONS();
    $data['C_CLUBHOUSE'] = $this->attendance_model->GET_CLUBHOUSE();

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/daily_attendance_views', $data);
  }
  function work_shifts()
  {
    $search = str_replace('_', ' ', $this->input->get('all') ?? "");
    $tab = $this->input->get('tab') ? $this->input->get('tab') : 'Active';
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    $data["C_ROW_DISPLAY"] = [25, 50, 100];
    $data['PAGE'] = $page;
    $data['ROW'] = $row;
    $data['TAB'] = $tab;
    $data['ACTIVES'] = count($this->attendance_model->GET_WORK_SHIFT_ACTIVE_COUNT('Active'));
    $data['INACTIVES'] = count($this->attendance_model->GET_WORK_SHIFT_INACTIVE_COUNT('InActive'));
    if ($this->input->get('all') == null) {
      $data['DISP_WRK_SHFT_INFO'] = $this->attendance_model->MOD_DISP_WRK_SHFT($tab, $row, $offset);
      $data['C_DATA_COUNT'] = $data_count = count($this->attendance_model->MOD_DISP_WRK_SHFT_COUNT($tab));
    } else {
      $data['DISP_WRK_SHFT_INFO'] = $this->attendance_model->MOD_DISP_SEARCH_WRK_SHFT($tab, $search);
      $data['C_DATA_COUNT'] = $data_count = count($this->attendance_model->MOD_DISP_SEARCH_WRK_SHFT($tab, $search));
    }
    $page_count = intval($data_count / $row);
    $excess = $data_count % $row;
    $data['PAGES_COUNT'] = $excess > 0 ? $page_count += 1 : $page_count;
    $data['DISP_INOUT_TYPE'] = $this->attendance_model->GET_IN_OUT_TYPE();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/work_shift_views', $data);
  }
  function workshift_mark_active()
  {
    $id = $this->input->post('APPROVE_ID');
    $ids = explode(",", $id);
    foreach ($ids as $id) {
      $this->attendance_model->UPDATE_WORKSHIFT($id, 'Active');
    }
    $this->session->set_userdata('succ_approved', 'Mark as Active Successfully!');
    redirect('attendances/work_shifts');
  }
  function workshift_mark_active_inactive()
  {
    $status = $this->input->post('work_shift_status');
    $id = $this->input->post('list_mark_ids');
    $ids = explode(",", $id);
    foreach ($ids as $id) {
      $this->attendance_model->UPDATE_WORKSHIFT($id, $status);
    }
    $this->session->set_userdata('succ_approved', 'Marked as ' . $status . ' Successfully!');
    redirect('attendances/work_shifts');
  }
  function workshift_mark_inactive()
  {
    $id = $this->input->post('WORKSHIFT_ID');
    $ids = explode(",", $id);
    foreach ($ids as $id) {
      $this->attendance_model->UPDATE_WORKSHIFT($id, 'Inactive');
    }
    $this->session->set_userdata('succ_approved', 'Mark as Inactive Successfully!');
    redirect('attendances/work_shifts');
  }
  function insrt_work_shift()
  {
    $input_data = $this->input->post();

    $code = $input_data['code'];
    $codeExist = $this->attendance_model->code_exist_by_code($code, $id);
    if ($codeExist > 0) {
      $this->session->set_flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT', 'Shift Code already in use');
      redirect('attendances/work_shifts');
    }
    $input_data['time_regular_start'] = empty($input_data['time_regular_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_start']));
    $input_data['time_regular_end'] = empty($input_data['time_regular_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_end']));
    $input_data['time_break_start'] = empty($input_data['time_break_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_start']));
    $input_data['time_break_end'] = empty($input_data['time_break_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_end']));
    $input_data['time_overtime_start'] = empty($input_data['time_overtime_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_start']));
    $input_data['time_overtime_end'] = empty($input_data['time_overtime_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_end']));
    $input_data['status'] = 'Active';
    $input_data['disregard_undertime'] = isset($input_data['disregard_undertime']) ? 1 : 0;
    $response = $this->attendance_model->ADD_WORK_SHIFT($input_data);
    // $this->session->set_userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT', 'New work shift added successfully!');
    // redirect('attendances/work_shifts');
    if ($response) {
      $this->session->set_flashdata('SESS_SUCC_MSG_UPDT_WRK_SHFT', 'New work shift added successfully!');
    } else {
      $this->session->set_flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT', 'Failed adding new work shift');
    }
    redirect('attendances/work_shifts');
  }
  function edit_work_shift($id)
  {
    $shift_data = $this->attendance_model->MOD_GET_WRK_SHFT_DATA($id);
    echo json_encode($shift_data);
  }
  function updt_work_shift()
  {
    $input_data = $this->input->post();
    $code = $input_data['code'];
    $id = $input_data['id'];
    $codeExist = $this->attendance_model->code_exist_by_code_id($code, $id);
    if ($codeExist > 0) {
      $this->session->set_flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT', 'Shift Code already in use');
      redirect('attendances/work_shifts');
    }
    $input_data['time_regular_start'] = empty($input_data['time_regular_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_start']));
    $input_data['time_regular_end'] = empty($input_data['time_regular_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_regular_end']));
    $input_data['time_break_start'] = empty($input_data['time_break_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_start']));
    $input_data['time_break_end'] = empty($input_data['time_break_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_break_end']));
    $input_data['time_overtime_start'] = empty($input_data['time_overtime_start']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_start']));
    $input_data['time_overtime_end'] = empty($input_data['time_overtime_end']) ? '00:00:00' : date("H:i", strtotime($input_data['time_overtime_end']));
    $input_data['status'] = 'Active';
    $input_data['disregard_undertime'] = isset($input_data['disregard_undertime']) ? 1 : 0;
    $response = $this->attendance_model->UPDATE_SPE_WORKSHIFT($input_data['id'], $input_data);
    if ($response) {
      $this->session->set_flashdata('SESS_SUCC_MSG_UPDT_WRK_SHFT', 'Work shift updated successfully!');
    } else {
      $this->session->set_flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT', 'Fail!');
    }
    redirect('attendances/work_shifts');
  }
  function dlt_work_shift()
  {
    $work_shift_id = $this->input->get('delete_id');
    $this->attendance_model->MOD_DLT_WRK_SHFT($work_shift_id);
    $this->session->set_flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT', 'Deleted Successfully!');
    redirect('attendances/work_shifts');
  }
  function shift_templates()
  {
    $data['DISP_SHIFTTEMPLATE_INFO'] = $this->attendance_model->MOD_DISP_SHIFTTEMPLATE();
    $data['DISP_WORK_SHIFT'] = $this->attendance_model->MOD_DISP_WRK_SHFT();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/shift_template_views', $data);
  }
  function insrt_ShiftTemplate()
  {
    $code = $this->input->post('SHIFTTEMPLATE_INPF_CODE');
    $name = $this->input->post('SHIFTTEMPLATE_INPF_NAME');
    $monday = $this->input->post('SHIFTTEMPLATE_INPF_MONDAY');
    $tuesday = $this->input->post('SHIFTTEMPLATE_INPF_TUESDAY');
    $wednesday = $this->input->post('SHIFTTEMPLATE_INPF_WEDNESDAY');
    $thursday = $this->input->post('SHIFTTEMPLATE_INPF_THURSDAY');
    $friday = $this->input->post('SHIFTTEMPLATE_INPF_FRIDAY');
    $saturday = $this->input->post('SHIFTTEMPLATE_INPF_SATURDAY');
    $sunday = $this->input->post('SHIFTTEMPLATE_INPF_SUNDAY');
    $this->attendance_model->MOD_INSRT_SHIFTTEMPLATE($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_SHIFTTEMPLATE', 'Added Successfully!');
    redirect('attendances/shift_templates');
  }
  function updt_ShiftTemplate()
  {
    $id = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_ID');
    $code = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_CODE');
    $name = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_NAME');
    $monday = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_MONDAY');
    $tuesday = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_TUESDAY');
    $wednesday = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_WEDNESDAY');
    $thursday = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_THURSDAY');
    $friday = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_FRIDAY');
    $saturday = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_SATURDAY');
    $sunday = $this->input->post('UPDT_SHIFTTEMPLATE_INPF_SUNDAY');
    $this->attendance_model->MOD_UPDT_SHIFTTEMPLATE($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $id);
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_SHIFTTEMPLATE', 'Updated Successfully!');
    redirect('attendances/shift_templates');
  }
  function dlt_ShiftTemplate()
  {
    $ShiftTemplate_id = $this->input->get('delete_id');
    $this->attendance_model->MOD_DLT_SHIFTTEMPLATE($ShiftTemplate_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_SHIFTTEMPLATE', 'Deleted Successfully!');
    redirect('attendances/shift_templates');
  }
  function holidays()
  {

    $current_year = date('Y');
    $data['HOLIDAYS'] = array();
    $data['DATE_FORMAT']                = $this->attendance_model->GET_SYSTEM_SETTING("date_format");
    $year = $this->input->get('tab') ? $this->input->get('tab') : $current_year;
    $data['TAB'] = $year;

    $data['HOLIDAYS'] = $this->attendance_model->GET_ALL_HOLIDAYS($year);
    $data['TAB_YEARS'] = array();
    $index = 0;

    $years = $this->attendance_model->GET_YEARS();

    foreach ($years as $year) {
      $data['TAB_YEARS'][$index]['year'] = $year->name;
      $data['TAB_YEARS'][$index]['count'] = count($this->attendance_model->GET_ALL_HOLIDAYS($year->name));
      $index++;
    }



    $data['years'] = $years;

    // var_dump($data['years']);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_holiday_views', $data);
  }

  // function holiday_select_api()
  // {
  //   $year = json_decode(file_get_contents('php://input'), true);

  //   try {
  //     if (!empty($year)) {
  //       $res = $this->attendance_model->GET_ATTENDANCE_HOLIDAY($year);
  //       if ($res) {
  //         $response = array('success_message' => 'Update Successful!');
  //       } else {
  //         $response = array('warning_message' => 'Updating Failed!');
  //       }
  //     } else {
  //       $response = array('warning_message' => 'Year not provided!');
  //     }
  //   } catch (PDOException $e) {
  //     $response = array('warning_message' => 'Database Error', 'Error' => $e->getMessage());
  //   } catch (Exception $e) {
  //     $response = array('warning_message' => 'Updating Failed!', 'Error' => $e->getMessage());
  //   }
  //   echo json_encode($response);
  // }


  function insrt_holiday()
  {
    $HOLIDAY_INPF_NAME = $this->input->post('HOLIDAY_INPF_NAME');
    $HOLIDAY_INPF_DATE = $this->input->post('HOLIDAY_INPF_DATE');
    $HOLIDAY_INPF_TYPE = $this->input->post('HOLIDAY_INPF_TYPE');
    $this->attendance_model->MOD_INSRT_HOLIDAY($HOLIDAY_INPF_NAME, $HOLIDAY_INPF_DATE, $HOLIDAY_INPF_TYPE);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_HOLIDAY', 'Added Successfully!');
    redirect('attendances/holidays');
  }
  function updt_holiday()
  {
    $UPDT_HOLIDAY_INPF_ID = $this->input->post('UPDT_HOLIDAY_INPF_ID');
    $UPDT_HOLIDAY_INPF_NAME = $this->input->post('UPDT_HOLIDAY_INPF_NAME');
    $UPDT_HOLIDAY_INPF_DATE = $this->input->post('UPDT_HOLIDAY_INPF_DATE');
    $UPDT_HOLIDAY_INPF_TYPE = $this->input->post('UPDT_HOLIDAY_INPF_TYPE');
    $this->attendance_model->MOD_UPDT_HOLIDAY($UPDT_HOLIDAY_INPF_NAME, $UPDT_HOLIDAY_INPF_DATE, $UPDT_HOLIDAY_INPF_TYPE, $UPDT_HOLIDAY_INPF_ID);
    $this->session->set_userdata('SESS_SUCC_MSG_UPDT_HOLIDAY', 'Updated Successfully!');
    redirect('attendances/holidays');
  }
  function dlt_holiday()
  {
    $holiday_id = $this->input->get('delete_id');
    $this->attendance_model->MOD_DLT_HOLIDAY($holiday_id);
    $this->session->set_userdata('SESS_SUCC_MSG_DLT_HOLIDAY', 'Deleted Successfully!');
    redirect('attendances/holidays');
  }
  function overtimes()
  {
    $data['TABLE_DATA'] = array();
    $status = $this->input->get('status');
    $limit = $this->input->get('row') ? $this->input->get('row') : 25;
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset = $limit * ($page - 1);
    $search = $this->input->get('search');
    $filter_arr = array();
    $filter_arr['company'] = $this->input->get('company');
    $filter_arr['branch'] = $this->input->get('branch');
    $filter_arr['dept'] = $this->input->get('dept');
    $filter_arr['div'] = $this->input->get('div');
    $filter_arr['section'] = $this->input->get('section');
    $filter_arr['group'] = $this->input->get('group');
    $filter_arr['team'] = $this->input->get('team');
    $filter_arr['line'] = $this->input->get('line');
    $data['STATUS'] = $status;
    $data['STATUSES'] = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA'] = $this->attendance_model->GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr);
    $total_count = $this->attendance_model->GET_OVERTIMES_COUNT($status, $search, $filter_arr);
    $excess = $total_count % $limit;
    $data['C_DATA_COUNT'] = $total_count;
    $data['PAGES_COUNT'] = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE'] = $page;
    $data['ROW'] = $limit;
    $data['C_ROW_DISPLAY'] = array(10, 25, 50);
    $data['DEPARTMENTS'] = $this->attendance_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES'] = $this->attendance_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES'] = $this->attendance_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_divisions');
    $data['SECTIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS'] = $this->attendance_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS'] = $this->attendance_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES'] = $this->attendance_model->GET_STD_DATA('tbl_std_lines');
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_overtime_views', $data);
  }
  function request_overtime()
  {
    $data['C_EMPLOYEES'] = $this->attendance_model->GET_EMPLOYEELIST();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_overtime_views', $data);
  }
  function add_overtime()
  {
    $input_data = $this->input->post();
    $input_data['create_date'] = date('Y-m-d H:i:s');
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $res = $this->attendance_model->ADD_DATA('tbl_overtimes', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('attendances/add_overtime');
      return;
    }
    redirect('attendances/overtimes');
  }
  function edit_overtime($id)
  {
    $data['OVERTIME'] = $this->attendance_model->GET_OVERTIME($id);
    $data['TYPES'] = array('Regular', 'Night Shift', 'Rest', 'Special', 'Legal', 'Rest + Special', 'Rest + Legal');
    $status = $data['OVERTIME']->status;
    if ($status != "Pending 1" && $status != "Pending 2" && $status != "Pending 3") {
      redirect('selfservices/my_overtimes');
      return;
    }
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_edit_overtime_views', $data);
  }
  function update_overtime()
  {
    $input_data = $this->input->post();
    $id = $input_data['id'];
    $res = $this->attendance_model->UPDATE_OVERTIME($id, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully Updated');
    }
    redirect('attendances/overtimes');
  }
  function holiday_work()
  {
    $data['TABLE_DATA'] = array();
    $status = $this->input->get('status');
    $limit = $this->input->get('row') ? $this->input->get('row') : 25;
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset = $limit * ($page - 1);
    $search = $this->input->get('search');
    $filter_arr = array();
    $filter_arr['company'] = $this->input->get('company');
    $filter_arr['branch'] = $this->input->get('branch');
    $filter_arr['dept'] = $this->input->get('dept');
    $filter_arr['div'] = $this->input->get('div');
    $filter_arr['section'] = $this->input->get('section');
    $filter_arr['group'] = $this->input->get('group');
    $filter_arr['team'] = $this->input->get('team');
    $filter_arr['line'] = $this->input->get('line');
    $data['STATUS'] = $status;
    $data['STATUSES'] = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA'] = $this->attendance_model->GET_HOLIDAY_WORKS($status, $search, $limit, $offset, $filter_arr);
    $total_count = $this->attendance_model->GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr);
    $excess = $total_count % $limit;
    $data['C_DATA_COUNT'] = $total_count;
    $data['PAGES_COUNT'] = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE'] = $page;
    $data['ROW'] = $limit;
    $data['C_ROW_DISPLAY'] = array(10, 25, 50);
    $data['DEPARTMENTS'] = $this->attendance_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES'] = $this->attendance_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES'] = $this->attendance_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_divisions');
    $data['SECTIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS'] = $this->attendance_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS'] = $this->attendance_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES'] = $this->attendance_model->GET_STD_DATA('tbl_std_lines');
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_holiday_work_views', $data);
  }
  function request_holiday_work()
  {
    $data['C_EMPLOYEES'] = $this->attendance_model->GET_EMPLOYEELIST();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_holiday_work_views', $data);
  }
  function add_new_holiday_work()
  {
    $input_data = $this->input->post();
    $input_data['create_date'] = date('Y-m-d H:i:s');
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $res = $this->attendance_model->ADD_DATA('tbl_holidaywork', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('attendances/add_holiday_work');
      return;
    }
    redirect('attendances/holiday_work');
  }
  function edit_holiday_work($id)
  {
    $data['HOLIDAY_WORK'] = $this->attendance_model->GET_HOLIDAY_WORK($id);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_edit_holiday_work_views', $data);
  }
  function update_holiday_work()
  {
    $input_data = $this->input->post();
    $id = $input_data['id'];
    $res = $this->attendance_model->UPDATE_HOLIDAY_WORK($id, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully updated');
    }
    redirect('attendances/holiday_work');
  }
  function insrt_assign_overtime()
  {
    $employee_id = $this->input->post('EMPLOYEE_ID');
    $assigned_by = $this->session->userdata('SESS_USER_ID');
    $url_directory = $this->input->post('url_directory');
    if ($url_directory == 'assign_overtime') {
      $url_directory = 'attendance/assign_overtime';
    } else if ($url_directory == 'overtimes') {
      $url_directory = 'attendances/overtimes';
    }
    $overtime_date = $this->input->post('overtime_date');
    $time_out = $this->input->post('time_out');
    $type = 'Regular OT';
    $num_hours = $this->input->post('num_hours');
    $reason = $this->input->post('reason');
    $status = 'Pending';
    $approval_route = $this->attendance_model->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();
    $empl_group = 'No Group';
    $empl_name = '';
    $empl_info = $this->attendance_model->MOD_DISP_EMPLOYEE($employee_id);
    foreach ($empl_info as $empl_info_row) {
      $empl_group = $empl_info_row->col_empl_group;
      $empl_name = $empl_info_row->col_frst_name . ' ' . $empl_info_row->col_last_name;
    }
    $ot_id = $this->attendance_model->MOD_INSRT_OVERTIME($overtime_date, $type, $time_out, $num_hours, $reason, $status, $assigned_by, $employee_id);
    if ($ot_id) {
      foreach ($approval_route as $approval_route_row) {
        $my_user_id = $this->session->userdata('SESS_USER_ID');
        if (($approval_route_row->approver1 == $my_user_id) || ($approval_route_row->approver2 == $my_user_id) || ($approval_route_row->approver3 == $my_user_id)) {
          $this->attendance_model->MOD_UPDT_OT_STATUS_APPR1('Pending', $ot_id);
        }
        if (($approval_route_row->approver4 == $my_user_id) || ($approval_route_row->approver5 == $my_user_id)) {
          $this->attendance_model->MOD_UPDT_OT_STATUS_APPR2('Pending', $ot_id);
        }
      }
      $recievers_arr = [];
      $get_ot_approver = $this->attendance_model->MOD_DISP_ALL_APPR_ROUTE_OT_ADJ();
      if ($get_ot_approver) {
        if ($get_ot_approver[0]->approver1) {
          array_push($recievers_arr, $get_ot_approver[0]->approver1);
        }
        if ($get_ot_approver[0]->approver2) {
          array_push($recievers_arr, $get_ot_approver[0]->approver2);
        }
        if ($get_ot_approver[0]->approver3) {
          array_push($recievers_arr, $get_ot_approver[0]->approver3);
        }
        if ($get_ot_approver[0]->approver4) {
          array_push($recievers_arr, $get_ot_approver[0]->approver4);
        }
        if ($get_ot_approver[0]->approver5) {
          array_push($recievers_arr, $get_ot_approver[0]->approver5);
        }
      }
      $appr_type = 'Overtime';
      $reciever = implode(",", $recievers_arr);
      $date_created = date('Y-m-d H:i:s');
      $message = 'Assigned Overtime to: ';
      $notif_status = 0;
      $requested_by = $assigned_by;
      $this->attendance_model->MOD_INSRT_NOTIF_LOGS($employee_id, $empl_group, $appr_type, $reciever, $date_created, $message, $notif_status, $ot_id, $requested_by);
      $this->attendance_model->MOD_INSRT_APPLICATION_NOTIF_LOGS($requested_by, $message, $appr_type, $date_created, $ot_id, $notif_status);
      $this->session->set_userdata('SESS_SUCC_MSG_INSRT_OVERTIME', 'Over-Time application submitted!');
    } else {
      $this->session->set_userdata('SESS_ERR_MSG_INSRT_OVERTIME', 'Submission Failed!');
    }
    redirect($url_directory);
  }
  function updt_overtime_application()
  {
    $overtime_id = $this->input->post('appl_overtime_id');
    $actual_ot_duration = $this->input->post('actual_ot_duration');
    $appl_overtime_date = $this->input->post('appl_overtime_date');
    $appl_overtime_empl_id = $this->input->post('appl_overtime_empl_id');
    $appl_type = $this->input->post('appl_type');
    $empl_id = $this->input->post('appl_overtime_empl_id');
    $this->attendance_model->MOD_UPDT_OVERTIME_APPLICATION($actual_ot_duration, $overtime_id);
    if ($appl_type == 'Regular OT') {
      $this->attendance_model->MOD_UPDT_ATT_REG_OT($actual_ot_duration, $appl_overtime_date, $empl_id);
    } else if ($appl_type == 'Night Shift OT') {
      $this->attendance_model->MOD_UPDT_ATT_ND_OT($actual_ot_duration, $appl_overtime_date, $empl_id);
    } else if ($appl_type == 'Rest OT') {
      $this->attendance_model->MOD_UPDT_ATT_REST_OT($actual_ot_duration, $appl_overtime_date, $empl_id);
    }
    $this->session->set_userdata('success', 'Overtime Application Updated');
    redirect('attendances/overtime');
  }
  function offset_lists()
  {
    $data['OFFSETS'] = array();
    $data['DATE_FORMAT']                = $this->attendance_model->GET_SYSTEM_SETTING("date_format");
    $status = $this->input->get('status');
    $limit = $this->input->get('row') ? $this->input->get('row') : 25;
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset = $limit * ($page - 1);
    $search = $this->input->get('search');
    $filter_arr = array();
    $filter_arr['company'] = $this->input->get('company');
    $filter_arr['branch'] = $this->input->get('branch');
    $filter_arr['dept'] = $this->input->get('dept');
    $filter_arr['div'] = $this->input->get('div');
    $filter_arr['clubhouse'] = $this->input->get('clubhouse');
    $filter_arr['section'] = $this->input->get('section');
    $filter_arr['group'] = $this->input->get('group');
    $filter_arr['team'] = $this->input->get('team');
    $filter_arr['line'] = $this->input->get('line');
    // echo "<pre>";
    // echo "filter_arr";
    // echo "<br>";
    // print_r($filter_arr);
    // echo "<pre>"; die(); 
    $data['STATUS'] = $status;
    $data['STATUSES'] = array('Pending', 'Withdrawed', 'Approved', 'Rejected');
    $data['OFFSETS'] = $this->attendance_model->GET_OFFSETS($status, $search, $limit, $offset, $filter_arr);
    $total_count = $this->attendance_model->GET_OFFSETS_COUNT($search, $status, $filter_arr);
    $excess = $total_count % $limit;
    $data['C_DATA_COUNT'] = $total_count;
    $data['PAGES_COUNT'] = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE'] = $page;
    $data['ROW'] = $limit;
    $data['C_ROW_DISPLAY'] = array(10, 25, 50);
    $data['DEPARTMENTS'] = $this->attendance_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES'] = $this->attendance_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES'] = $this->attendance_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_divisions');
    $data['CLUBHOUSE'] = $this->attendance_model->GET_STD_DATA('tbl_std_clubhouse');
    $data['SECTIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS'] = $this->attendance_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS'] = $this->attendance_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES'] = $this->attendance_model->GET_STD_DATA('tbl_std_lines');
    $data['DISP_VIEW_COMPANY'] = $this->attendance_model->GET_SYSTEM_SETTING("com_company");
    $data['DISP_VIEW_BRANCH'] = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT'] = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP'] = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM'] = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    $data['EMPLOYEES'] = $this->attendance_model->GET_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_offset_views', $data);
  }
  function edit_offset($id)
  {
    $data['EMPLOYEES'] = $this->attendance_model->GET_EMPLOYEELIST();
    $data['OFFSET'] = $this->attendance_model->GET_OFFSET($id);
    // $data['LEAVE_TYPES']    = $this->attendance_model->MOD_DISP_LEAVETYPES();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/edit_offset_views', $data);
  }
  function update_offset($id)
  {
    $input_data = $this->input->post();
    $res = $this->attendance_model->UPDATE_OFFSET($input_data, $id);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully updated');
    } else {
      $this->session->set_flashdata('ERR', 'Unable to update');
    }
    redirect('attendances/offset_lists');
  }
  function add_new_offset()
  {
    $isApproversEnable = $this->attendance_model->GET_SETUP_SETTING('requireApprovers');
    $user_id = $this->session->userdata('SESS_USER_ID');
    // $attachment                         = $_FILES['attachment']['name'];
    $input_data = $this->input->post();
    $input_data['assigned_by'] = $user_id;
    $input_data['status'] = $isApproversEnable == 1 ? 'Pending 1' : 'Approved';
    // $file_info = pathinfo($attachment);
    $input_data['create_date'] = date('Y-m-d H:i:s');
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $employee = $this->attendance_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    $approvers = $this->attendance_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    $approver = $approvers->approver_1a ? $approvers->approver_1a : 0;
    if ($approver == 0) {
      $this->session->set_flashdata('ERR', 'No Approver Assign');
      redirect('attendances/request_offset');
      return;
    }
    $is_duplicate = $this->attendance_model->GET_IS_DUPLICATE_DATE($input_data['offset_date']);
    if ($is_duplicate > 0) {
      $this->session->set_flashdata('ERR', "Offset submission failed. It looks like you have already submitted a offset request for the same dates.");
      redirect('attendances/request_offset');
      return;
    } else {
      //     if(!empty($attachment)){
      //       $input_data['attachment']       = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d').'.'.$file_info['extension'];
      //       $config['upload_path']          = './assets_user/files/selfservices';
      //       $config['allowed_types']        = '*';
      //       $config['max_size']             = 10000;
      //       $config['file_name']            = $employee->col_empl_cmid.'_'.$employee->col_last_name.'_leave_request_'.date('Y-m-d');
      //       $config['overwrite']            = 'TRUE';
      //       $this->load->library('upload', $config);
      //       if ( ! $this->upload->do_upload('attachment'))
      //       {
      //           $error = array('error' => $this->upload->display_errors());
      //           $this->session->set_userdata('ERR', $error['error']);
      //           redirect('leaves/request_leave');
      //           // var_dump($error);
      //           return;
      //       }
      //   }  
      $res = $this->attendance_model->ADD_OFFSET_REQUEST($input_data);
      if ($res) {
        $this->session->set_flashdata('SUCC', 'Successfully added');
        if ($isApproversEnable == 0) {
          redirect('attendances/offset_lists');
          return;
        }
        $requestor = $this->attendance_model->GET_REQUESTOR('leave', $res);
        $description = "Offset Application Review for [OFF" . str_pad($res, 5, '0', STR_PAD_LEFT) . "] by " . $requestor . " has been requested";
        $notif_data = array(
          'create_date' => date('Y-m-d H:i:s'),
          'empl_id' => $approvers->approver_1a,
          'type' => 'offset',
          'content_id' => $res,
          'location' => 'selfservices/offset_approval',
          'description' => $description
        );
        $notif = $this->attendance_model->ADD_NOTIFICATION($notif_data);
      } else {
        $this->session->set_flashdata('ERR', 'Fail to add new data');
        redirect('attendances/request_offset');
        return;
      }
    }
    // 		$input_data                 				= $this->input->post();
    // 		$attachment                 				= $_FILES['attachment']['name'];
    // 		$file_info = pathinfo($attachment);
    // 		$input_data['create_date']  				= date('Y-m-d H:i:s');
    // 		$input_data['edit_date']    				= date('Y-m-d H:i:s');
    // 		$employee                   				= $this->attendance_model->GET_EMPLOYEE_SPECIFIC_ROW($input_data['empl_id']);
    // 		$input_data['attachment']   				= $attachment;
    // 		if (!empty($attachment)) {
    // 			$input_data['attachment']   			= $employee->col_empl_cmid . '_' . $employee->col_last_name . '_leave_request_' . date('Y-m-d') . '.' . $file_info['extension'];
    // 			$config['upload_path']          		= './assets_user/files/leaves';
    // 			$config['allowed_types']        		= 'pdf|jpg';
    // 			$config['max_size']             		= 10000;
    // 			$config['file_name']            		= $employee->col_empl_cmid . '_' . $employee->col_last_name . '_leave_request_' . date('Y-m-d');
    // 			$config['overwrite']            		= 'TRUE';
    // 			$this->load->library('upload', $config);
    // 			if (!$this->upload->do_upload('attachment')) {
    // 				$error = array('error' => $this->upload->display_errors());
    // 				$this->session->set_flashdata('ERR', $error['error']);
    // 				redirect('leaves/request_leave');
    // 				return;
    // 			}
    // 		}
    // 		$res = $this->attendance_model->ADD_LEAVE_REQUEST($input_data);
    // 		if ($res) {
    // 			$this->session->set_flashdata('SUCC', 'Successfully added new request');
    // 		} else {
    // 			$this->session->set_flashdata('ERR', 'Fail to add new request');
    // 			redirect('leaves/request_leave');
    // 			return;
    // 		}
    redirect('attendances/offset_lists');
  }
  function request_offset()
  {
    // $data['LEAVE_TYPES']   						= $this->attendance_model->MOD_DISP_LEAVETYPES();
    $data['EMPLOYEES'] = $this->attendance_model->GET_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/new_offset_request_views', $data);
  }
  function get_offset_status($id)
  {
    $data['OFFSET'] = $this->attendance_model->GET_OFFSET_STATUS($id);
    $data['DATE_FORMAT']                   = $this->attendance_model->GET_SYSTEM_SETTINGS("date_format");
    $this->load->view('modules/partials/_offset_modal_content', $data);
  }
  function time_adjustment_lists()
  {
    $data['TABLE_DATA'] = array();
    $status = $this->input->get('status');
    $limit = $this->input->get('row') ? $this->input->get('row') : 25;
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $offset = $limit * ($page - 1);
    $search = $this->input->get('search');
    $filter_arr = array();
    $filter_arr['company'] = $this->input->get('company');
    $filter_arr['branch'] = $this->input->get('branch');
    $filter_arr['dept'] = $this->input->get('dept');
    $filter_arr['div'] = $this->input->get('div');
    $filter_arr['section'] = $this->input->get('section');
    $filter_arr['group'] = $this->input->get('group');
    $filter_arr['team'] = $this->input->get('team');
    $filter_arr['line'] = $this->input->get('line');
    $data['STATUS'] = $status;
    $data['STATUSES'] = array('Pending', 'Approved', 'Rejected');
    $data['TABLE_DATA'] = $this->attendance_model->GET_TIME_ADJ($status, $search, $limit, $offset, $filter_arr);
    $total_count = $this->attendance_model->GET_TIME_ADJ_COUNT($search, $status, $filter_arr);
    $excess = $total_count % $limit;
    $data['C_DATA_COUNT'] = $total_count;
    $data['PAGES_COUNT'] = $excess > 0 ? intval($total_count / $limit) + 1 : intval($total_count / $limit);
    $data['PAGE'] = $page;
    $data['ROW'] = $limit;
    $data['C_ROW_DISPLAY'] = array(10, 25, 50);
    $data['DISP_ALL_EMP_LIST_DATA'] = $this->attendance_model->GET_SEARCHED_ALL_EMPL();
    $data['DEPARTMENTS'] = $this->attendance_model->GET_STD_DATA('tbl_std_departments');
    $data['COMPANIES'] = $this->attendance_model->GET_STD_DATA('tbl_std_companies');
    $data['BRANCHES'] = $this->attendance_model->GET_STD_DATA('tbl_std_branches');
    $data['DIVISIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_divisions');
    $data['SECTIONS'] = $this->attendance_model->GET_STD_DATA('tbl_std_sections');
    $data['GROUPS'] = $this->attendance_model->GET_STD_DATA('tbl_std_groups');
    $data['TEAMS'] = $this->attendance_model->GET_STD_DATA('tbl_std_teams');
    $data['LINES'] = $this->attendance_model->GET_STD_DATA('tbl_std_lines');
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_time_adjustment_views', $data);
  }
  function request_time_adjustment()
  {
    $data['C_EMPLOYEES'] = $this->attendance_model->GET_EMPLOYEELIST();
    $data['C_SHIFT_TYPES'] = $this->attendance_model->GET_SHIFT_ALL_DATA();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_time_adjustment_views', $data);
  }
  function add_new_time_adjustments()
  {
    $input_data = $this->input->post();
    $attachment = $_FILES['attachment']['name'];
    $file_info = pathinfo($attachment);
    $input_data['create_date'] = date('Y-m-d H:i:s');
    $input_data['edit_date'] = date('Y-m-d H:i:s');
    $input_data['attachment'] = $attachment;
    if (!empty($attachment)) {
      $res = $this->upload_file('./assets_user/files/attendances/');
      if (!$res) {
        redirect('attendances/add_time_adjustment');
        return;
      }
    }
    $approvers = $this->attendance_model->GET_USER_APPROVERS($input_data['empl_id'], 'tbl_approvers');
    $approver = $approvers && $approvers->approver_1a ? $approvers->approver_1a : 0;
    $autoApprovedEnabled = $this->attendance_model->getApprovalAutoApproveEnabled($input_data['empl_id']);

    if (
      !$autoApprovedEnabled
      && (!$approvers || ($approvers && ($approvers->approver_1a == 0 && $approvers->approver_2a == 0 && $approvers->approver_3a == 0)))
    ) {
      $this->session->set_flashdata("ERR", "No Approver. Please add approver first then try again");
      redirect('attendances/request_time_adjustment');
    }
    if (
      $autoApprovedEnabled ||
      ((!$approvers || $approvers->approver_1a == 0) && (!$approvers || $approvers->approver_2a == 0)
        && (!$approvers || $approvers->approver_3a == 0) && (!$approvers || $approvers->approver_4a == 0)
        && (!$approvers || $approvers->approver_5a == 0))
    ) {
      $input_data['status'] = 'Approved';
    }

    $res = $this->attendance_model->ADD_DATA('tbl_attendance_adjustments', $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully added');
    } else {
      $this->session->set_flashdata('ERR', 'Fail to add new data');
      redirect('attendances/add_time_adjustment');
      return;
    }
    redirect('attendances/time_adjustment_lists');
  }
  function edit_time_adjustment($id)
  {
    $data['TIME_ADJ'] = $this->attendance_model->GET_TIME_ADJ_SPE($id);
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/att_edit_time_adjustment_views', $data);
  }
  function update_time_adjustment()
  {
    $input_data = $this->input->post();
    $id = $input_data['id'];
    $res = $this->attendance_model->UPDATE_TIME_ADJ($id, $input_data);
    if ($res) {
      $this->session->set_flashdata('SUCC', 'Successfully updated');
    }
    redirect('attendances/time_adjustment_lists');
  }
  function upload_file($path)
  {
    $config['upload_path'] = $path;
    $config['max_size'] = 10000;
    $config['allowed_types'] = '*';
    $config['overwrite'] = 'TRUE';
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('attachment')) {
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('ERR', $error['error']);
      return false;
    }
    return true;
  }
  function table_record()
  {
    $cut_off_period = $this->input->get('cut_off');
    $data['C_SUMINAC_REC'] = $this->attendance_model->GET_ATTE_SUMINAC_REC($cut_off_period);
    $data['C_EMP_NAME'] = $this->attendance_model->GET_EMPLOYEE_NAME();
    $data['C_PAY_SCHED'] = $this->attendance_model->GET_PAY_SCHED();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/table_record_views', $data);
  }
  function approval_routes()
  {
    $search = str_replace('_', ' ', $this->input->get('all') ?? "");
    if (!isset($_GET["branch"])) {
      $param_branch = "all";
    } else {
      $param_branch = $_GET["branch"];
    }
    if (!isset($_GET["dept"])) {
      $param_dept = "all";
    } else {
      $param_dept = $_GET["dept"];
    }
    if (!isset($_GET["division"])) {
      $param_division = "all";
    } else {
      $param_division = $_GET["division"];
    }
    if (!isset($_GET["section"])) {
      $param_section = "all";
    } else {
      $param_section = $_GET["section"];
    }
    if (!isset($_GET["group"])) {
      $param_group = "all";
    } else {
      $param_group = $_GET["group"];
    }
    if (!isset($_GET["team"])) {
      $param_team = "all";
    } else {
      $param_team = $_GET["team"];
    }
    if (!isset($_GET["line"])) {
      $param_line = "all";
    } else {
      $param_line = $_GET["line"];
    }
    if (!isset($_GET["status"])) {
      $param_status = "all";
    } else {
      $param_status = $_GET["status"];
    }
    $data["C_ROW_DISPLAY"] = [25, 50, 100];
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    $data['DISP_EMPLOYEES_NONFILTERED'] = $leave_approvers = $this->attendance_model->GET_EMPLOYEELIST();
    if ($this->input->get('all') == null) {
      $data['DISP_EMPLOYEES'] = $leave_approvers = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_2($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT'] = $this->attendance_model->GET_COUNT_EMPLOYEELIST();
    } else {
      $data['DISP_EMPLOYEES'] = $leave_approvers = $this->attendance_model->GET_SEARCHED($search);
      $data['C_DATA_COUNT'] = count($this->attendance_model->GET_SEARCHED($search));
    }
    $C_APPROVERS = array();
    $approval_list = $this->attendance_model->MOD_DISP_APPR_ROUT_LIST();
    $i = 0;
    foreach ($leave_approvers as $leave_approvers_ROW) {
      $C_APPROVERS[$i]["id"] = $leave_approvers_ROW->id;
      $C_APPROVERS[$i]["approver1A"] = "N/A";
      $C_APPROVERS[$i]["approver1B"] = "N/A";
      $C_APPROVERS[$i]["approver2A"] = "N/A";
      $C_APPROVERS[$i]["approver2B"] = "N/A";
      $C_APPROVERS[$i]["approver3A"] = "N/A";
      $C_APPROVERS[$i]["approver3B"] = "N/A";
      foreach ($approval_list as $approval_list_ROW) {
        if ($leave_approvers_ROW->id == $approval_list_ROW->empl_id) {
          $C_APPROVERS[$i]["approver1A"] = $approval_list_ROW->approver_1a;
          $C_APPROVERS[$i]["approver1B"] = $approval_list_ROW->approver_1b;
          $C_APPROVERS[$i]["approver2A"] = $approval_list_ROW->approver_2a;
          $C_APPROVERS[$i]["approver2B"] = $approval_list_ROW->approver_2b;
          $C_APPROVERS[$i]["approver3A"] = $approval_list_ROW->approver_3a;
          $C_APPROVERS[$i]["approver3B"] = $approval_list_ROW->approver_3b;
        }
      }
      $i++;
    }
    $data['DISP_APPROVER'] = $C_APPROVERS;
    $data['DISP_DISTINCT_BRANCH'] = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_DEPARTMENT'] = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION'] = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION'] = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_GROUP'] = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM'] = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE'] = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    $data['DISP_VIEW_BRANCH'] = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_DEPARTMENT'] = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_GROUP'] = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM'] = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/approval_route_views', $data);
  }
  function zkteco_attendance()
  {
    $search = str_replace('_', ' ', $this->input->get('search') ?? "");
    $data["C_ROW_DISPLAY"] = [25, 50, 100];
    $user_id = null;
    if ($search && $search != 'all')
      $user_id = $search;
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    $data['C_DATA_COUNT'] = $this->attendance_model->GET_COUNT_ZKTECO_RECORDS($user_id);
    $attendance = $this->attendance_model->GET_ZKTECO_RECORDS($offset, $row, $user_id);
    $employees = $this->attendance_model->GET_ALL_EMPLOYEES();
    $result = [];
    $employee_zkteco = [];
    $employee_zkteco_index = 0;
    $index = 0;
    $employeeLoops = 0;
    foreach ($attendance as $attendance_row) {
      $result[$index]["id"] = $attendance_row->id;
      $result[$index]["empl_id"] = $attendance_row->emp_code;
      $result[$index]["punch_time"] = $attendance_row->punch_time;
      $result[$index]["punch_state"] = $attendance_row->punch_state;
      $result[$index]["terminal_sn"] = $this->attendance_model->GET_ALL_BIOMETRICS($attendance_row->terminal_sn);
      foreach ($employees as $employee_row) {
        $code_id = $this->attendance_model->GET_ZKTECO_CODE($attendance_row->emp_code);
        if ($code_id == $employee_row->id) {
          // $result[$index]["employee_name"]        = $employee_row->col_last_name . ', ' . $employee_row->col_frst_name . ' ' . $employee_row->col_midl_name;
          $result[$index]['employee_name'] = $employee_row->col_empl_cmid . '-' . $employee_row->col_last_name;
          if (!empty($employee_row->col_suffix))
            $result[$index]['employee_name'] = $result[$index]['employee_name'] . ' ' . $employee_row->col_suffix;
          if ($employee_row->col_frst_name)
            $result[$index]['employee_name'] = $result[$index]['employee_name'] . ', ' . $employee_row->col_frst_name;
          if ($employee_row->col_midl_name)
            $result[$index]['employee_name'] = $result[$index]['employee_name'] . ' ' . $employee_row->col_midl_name;
        }
      }
      $index++;
      if ($employeeLoops == 0) {
      }
      $employeeLoops++;
    }
    foreach ($employees as $employee_row) {
      $zkteco_code = $this->attendance_model->GET_ZKTECO_EMPL_CODE_BY_EMPL_ID($employee_row->id);
      if ($zkteco_code) {
        // $employee_zkteco[$employee_zkteco_index]['name'] = $employee_row->col_empl_cmid . '-' . $employee_row->col_last_name . ', ' . $employee_row->col_frst_name . ' ' . $employee_row->col_midl_name;
        $employee_zkteco[$employee_zkteco_index]['name'] = $employee_row->col_empl_cmid . '-' . $employee_row->col_last_name;
        if (!empty($employee_row->col_suffix))
          $employee_zkteco[$employee_zkteco_index]['name'] = $employee_zkteco[$employee_zkteco_index]['name'] . ' ' . $employee_row->col_suffix;
        if ($employee_row->col_frst_name)
          $employee_zkteco[$employee_zkteco_index]['name'] = $employee_zkteco[$employee_zkteco_index]['name'] . ', ' . $employee_row->col_frst_name;
        if ($employee_row->col_midl_name)
          $employee_zkteco[$employee_zkteco_index]['name'] = $employee_zkteco[$employee_zkteco_index]['name'] . ' ' . $employee_row->col_midl_name;
        $employee_zkteco[$employee_zkteco_index]['zkteco_code'] = $zkteco_code;
        $employee_zkteco_index++;
      }
    }
    $data['DISP_EMP_LIST'] = $employee_zkteco;
    $data['DISP_ATTENDANCE'] = $result;
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/zkteco_attendance_views', $data);
  }
  function zkteco_code()
  {
    $search = str_replace('_', ' ', $this->input->get('search') ?? "");
    if (!isset($_GET["branch"])) {
      $param_branch = "all";
    } else {
      $param_branch = $_GET["branch"];
    }
    if (!isset($_GET["dept"])) {
      $param_dept = "all";
    } else {
      $param_dept = $_GET["dept"];
    }
    if (!isset($_GET["division"])) {
      $param_division = "all";
    } else {
      $param_division = $_GET["division"];
    }
    if (!isset($_GET["clubhouse"])) {
      $param_clubhouse = "all";
    } else {
      $param_clubhouse = $_GET["clubhouse"];
    }
    if (!isset($_GET["section"])) {
      $param_section = "all";
    } else {
      $param_section = $_GET["section"];
    }
    if (!isset($_GET["group"])) {
      $param_group = "all";
    } else {
      $param_group = $_GET["group"];
    }
    if (!isset($_GET["team"])) {
      $param_team = "all";
    } else {
      $param_team = $_GET["team"];
    }
    if (!isset($_GET["line"])) {
      $param_line = "all";
    } else {
      $param_line = $_GET["line"];
    }
    if (!isset($_GET["status"])) {
      $param_status = "all";
    } else {
      $param_status = $_GET["status"];
    }
    $data["C_ROW_DISPLAY"] = [50];
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 50;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    if ($this->input->get('search') == null) {
      $data['DISP_EMP_LIST'] = $empl_list = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_3($offset, $row, $param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT'] = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_clubhouse, $param_section, $param_group, $param_team, $param_line);
    } else {
      $data['DISP_EMP_LIST'] = $this->attendance_model->GET_SEARCHED_3($search);
      $data['C_DATA_COUNT'] = count($this->attendance_model->GET_SEARCHED_3($search));
    }
    $data['DISP_ALL_EMP_LIST_DATA'] = $this->attendance_model->GET_SEARCHED_ALL_EMPL();
    $data['DISP_DISTINCT_DEPARTMENT'] = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION'] = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_CLUBHOUSE'] = $this->attendance_model->MOD_DISP_DISTINCT_CLUBHOUSE();
    $data['DISP_DISTINCT_SECTION'] = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_BRANCH'] = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_GROUP'] = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM'] = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE'] = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    $data['DISP_VIEW_DEPARTMENT'] = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_CLUBHOUSE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_clubhouse");
    $data['DISP_VIEW_SECTION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_BRANCH'] = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_GROUP'] = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM'] = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/zkteco_code_views', $data);
  }



  function update_zkteco_code()
  {
    $userId = $this->session->userdata('SESS_USER_ID');
    $response = array('success_message' => 'Update Successful');
    try {
      $json_data = file_get_contents('php://input');
      $data = json_decode($json_data, true);
      $updatedData = $data['updatedData'];
      if (!isset($updatedData) || !is_array($updatedData) || empty($updatedData)) {
        $response = array('error_message' => 'Failed to update. No data.');
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        return;
      }
      $emptyCount = [];
      $lastKey = '';
      $message = '';
      foreach ($updatedData as $key1 => $array1) {
        $value1 = $array1[5];
        if (empty($value1)) {
          $emptyCount[] = $key1 + 1;
        }
        if (!empty($value1)) {
          $foundIndexes = [];
          foreach ($updatedData as $key2 => $array2) {
            if ($key1 !== $key2 && $value1 === $array2[5]) {
              $foundIndexes[] = $key2 + 1;
            }
          }
          if (!empty($foundIndexes)) {
            $lastkey = $key1 + 1;
            $message = "Duplicate Error. Value '$value1' found in rows: " . implode(", ", $foundIndexes) . " and $lastkey.\n";
          }
        }
      }
      if (!empty($emptyCount)) {
        $message = $message . "Blank Error. Blank found in rows: " . implode(", ", $emptyCount) . ".";
      }
      if (!empty($message)) {
        $response = array('error_message' => $message);
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        return;
      }
      $duplicateCode = [];
      foreach ($updatedData as $data_row) {
        $check = $this->attendance_model->check_zkteco_code($data_row, $userId);
        if ($check < 1) {
          $res = $this->attendance_model->update_zkteco_code($data_row, $userId);
          if ($res < 1) {
            $res2 = $this->attendance_model->insert_zkteco_code($data_row, $userId);
          } else {
          }
        } else {
          $duplicateCode[] = $data_row[5];
        }
      }
      if (!empty($duplicateCode)) {
        $message = "Updated Successfully except the code with value : " . implode(", ", $duplicateCode) . " already found in database\n";
        $response = array('error_message' => $message);
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
        return;
      }
      $this->output->set_content_type('application/json')->set_output(json_encode($response));
    } catch (Exception $e) {
      $response = array('error_message' => 'Error updating data: ' . $e->getMessage());
      $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
  }
  function zkteco_code_old()
  {
    $search = str_replace('_', ' ', $this->input->get('all') ?? "");
    if (!isset($_GET["branch"])) {
      $param_branch = "all";
    } else {
      $param_branch = $_GET["branch"];
    }
    if (!isset($_GET["dept"])) {
      $param_dept = "all";
    } else {
      $param_dept = $_GET["dept"];
    }
    if (!isset($_GET["division"])) {
      $param_division = "all";
    } else {
      $param_division = $_GET["division"];
    }
    if (!isset($_GET["section"])) {
      $param_section = "all";
    } else {
      $param_section = $_GET["section"];
    }
    if (!isset($_GET["group"])) {
      $param_group = "all";
    } else {
      $param_group = $_GET["group"];
    }
    if (!isset($_GET["team"])) {
      $param_team = "all";
    } else {
      $param_team = $_GET["team"];
    }
    if (!isset($_GET["line"])) {
      $param_line = "all";
    } else {
      $param_line = $_GET["line"];
    }
    if (!isset($_GET["status"])) {
      $param_status = "all";
    } else {
      $param_status = $_GET["status"];
    }
    $data["C_ROW_DISPLAY"] = [25, 50, 100];
    $page = $this->input->get('page');
    $row = $this->input->get('row');
    if ($row == null) {
      $row = 25;
    }
    if ($page == null) {
      $page = 1;
    }
    $offset = $row * ($page - 1);
    if ($this->input->get('all') == null) {
      $data['DISP_EMP_LIST'] = $empl_list = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_3($offset, $row, $param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
      $data['C_DATA_COUNT'] = $this->attendance_model->GET_FILTERED_EMPLOYEELIST_COUNT($param_branch, $param_dept, $param_division, $param_section, $param_group, $param_team, $param_line);
    } else {
      $data['DISP_EMP_LIST'] = $this->attendance_model->GET_SEARCHED_3($search);
      $data['C_DATA_COUNT'] = count($this->attendance_model->GET_SEARCHED_3($search));
    }
    $data['DISP_DISTINCT_DEPARTMENT'] = $this->attendance_model->MOD_DISP_DISTINCT_DEPARTMENT();
    $data['DISP_DISTINCT_DIVISION'] = $this->attendance_model->MOD_DISP_DISTINCT_DIVISION();
    $data['DISP_DISTINCT_SECTION'] = $this->attendance_model->MOD_DISP_DISTINCT_SECTION();
    $data['DISP_DISTINCT_BRANCH'] = $this->attendance_model->MOD_DISP_DISTINCT_BRANCH();
    $data['DISP_DISTINCT_GROUP'] = $this->attendance_model->MOD_DISP_DISTINCT_GROUP();
    $data['DISP_DISTINCT_TEAM'] = $this->attendance_model->MOD_DISP_DISTINCT_TEAM();
    $data['DISP_DISTINCT_LINE'] = $this->attendance_model->MOD_DISP_DISTINCT_LINE();
    $data['DISP_VIEW_DEPARTMENT'] = $this->attendance_model->GET_SYSTEM_SETTING("com_Department");
    $data['DISP_VIEW_DIVISION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_division");
    $data['DISP_VIEW_SECTION'] = $this->attendance_model->GET_SYSTEM_SETTING("com_section");
    $data['DISP_VIEW_BRANCH'] = $this->attendance_model->GET_SYSTEM_SETTING("com_branch");
    $data['DISP_VIEW_GROUP'] = $this->attendance_model->GET_SYSTEM_SETTING("com_group");
    $data['DISP_VIEW_TEAM'] = $this->attendance_model->GET_SYSTEM_SETTING("com_team");
    $data['DISP_VIEW_LINE'] = $this->attendance_model->GET_SYSTEM_SETTING("com_line");
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/zkteco_code_views', $data);
  }

  function converter()
  {
    // $data['DISP_EMPLOYEE_LIST']                       = $this->attendance_model->GET_EMPLOYEELIST_DATA();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/converter_views');
  }

  function converted()
  {

    $this->load->view('templates/header');
    $this->load->view('modules/attendances/converted_views');
  }

  function convertion()
  {
    $input_data = $this->input->post();
    //DELETE tbl_timerecord_raw

    $decodedData = json_decode($input_data['updatedData']);
    //INSERT time



    // if(!$data){
    //   redirect('attendances/converter');
    // }
    // else{
    //   $this->load->view('templates/header');
    //   $this->load->view('modules/attendances/converted_views', $data);
    // }


  }

  // $data = json_decode(file_get_contents('php://input'), true);
  // $empl_id = $data['empl_id'];
  // $adjustmentDate = $data['adjustmentDate'];
  // $empl_id = $this->attendance_model->GET_ATTENDACE_SHIFT_ASSIGN($empl_id, $adjustmentDate);
  // $result = $this->attendance_model->GET_ATTENDANCE_SHIFT($empl_id);
  // echo json_encode($result);

  function save_data()
  {
    $postData = $this->input->post('updatedData');
    $data = json_decode($postData, true);

    $result = $this->attendance_model->save_sorted_data($data);

    if ($result) {
      echo json_encode(['status' => 'success', 'message' => 'Data saved successfully!']);
    } else {
      echo json_encode(['status' => 'error', 'message' => 'Failed to save data.']);
    }
  }

  function process_code_update($id, $empl_id, $code)
  {
    if ($code == 'null' || $code == null) {
      $this->session->set_userdata("SESS_EMPTY_MSG", "Employee code is required!");
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
      return;
    }
    $empl_response = $this->attendance_model->IS_DUPLICATE_CMID($empl_id);
    $code_response = $this->attendance_model->IS_DUPLICATE_CODE($code);
    if ($code_response > 0) {
      $this->session->set_userdata('SESS_ERROR_MSG', "Employee code already exists!");
      if (isset($_SERVER["HTTP_REFERER"])) {
        redirect($_SERVER["HTTP_REFERER"]);
      }
      return;
    }
    if ($empl_response > 0) {
      $this->attendance_model->UPDATE_EMPL_CODE($id, $empl_id, $code);
    } else {
      $this->attendance_model->INSERT_EMPL_CODE($id, $empl_id, $code);
    }
    $this->session->set_userdata('SESS_SUCCESS_MSG', "Employee code is updated successfully!");
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  function zkteco_attendance_data($offset, $row)
  {
    return $result;
  }
  function csv_import()
  {
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/approval_csv_import_views');
  }
  function add_approval()
  {
    $data['DISP_EMPLOYEES'] = $this->attendance_model->MOD_DISP_ALL_EMPLOYEES();
    $this->load->view('templates/header');
    $this->load->view('modules/attendances/add_approval_views', $data);
  }
  function add_approval_data()
  {
    $emp_id = $this->input->post('insrt_name');
    $app1a = $this->input->post('insrt_approver_1a');
    $app1b = $this->input->post('insrt_approver_1b');
    $app2a = $this->input->post('insrt_approver_2a');
    $app2b = $this->input->post('insrt_approver_2b');
    $app3a = $this->input->post('insrt_approver_3a');
    $app3b = $this->input->post('insrt_approver_3b');
    $this->attendance_model->MOD_INSERT_APPROVER_DATA($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b);
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Added Successfully!");
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  function get_approval_route_ot_adj()
  {
    $approval_id = $this->input->post('approval_id');
    $data = $this->attendance_model->MOD_DISP_APPR_ROUTE_OT_ADJ($approval_id);
    echo (json_encode($data));
  }
  function assign_approvers_ot_adj()
  {
    $date = date("Y-m-d H:i:s");
    $empl_id = $this->input->post('APPROVAL_ID');
    $approver1a = $this->input->post('UPDT_APPROVER1a');
    $approver1b = $this->input->post('UPDT_APPROVER1b');
    $approver2a = $this->input->post('UPDT_APPROVER2a');
    $approver2b = $this->input->post('UPDT_APPROVER2b');
    $approver3a = $this->input->post('UPDT_APPROVER3a');
    $approver3b = $this->input->post('UPDT_APPROVER3b');
    $empl_ids = explode(",", $empl_id);
    foreach ($empl_ids as $id) {
      $result = $this->attendance_model->GET_OVERTIME_APPROVER($id);
      if ($result) {
        $this->attendance_model->MOD_UPDT_OVERTIME_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
      } else {
        $this->attendance_model->MOD_INSERT_OVERTIME_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id);
      }
    }
    $this->session->set_userdata('SESS_SUCC_MSG_INSRT_APPROVER', "Approval Route Updated Successfully!");
    if (isset($_SERVER["HTTP_REFERER"])) {
      redirect($_SERVER["HTTP_REFERER"]);
    }
  }
  function get_employee_all_ampl_data()
  {
    $sample_var = $this->input->post('empl_cmid');
    $data = $this->attendance_model->MOD_DISP_EMPL_INFO_BIOM();
    echo (json_encode($data));
  }
  function get_data_all_list()
  {
    $model = $this->input->post('model_name');
    $table = $this->input->post('table_name');
    $modal_id = $this->input->post('modal_id');
    $data = $this->$model->get_data_row($table, $modal_id);
    echo (json_encode($data));
  }
  function show_data()
  {
    $data["model_name"] = $model = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_show', $data);
  }
  function edit_data()
  {
    $data["model_name"] = $model = "main_table_01_model";
    $data["C_DATA_EMPL_NAME"] = $this->$model->get_empl_name();
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_edit', $data);
  }
  function ADD_DATA()
  {
    $data["model_name"] = $model = "main_table_01_model";
    $this->load->view('templates/header');
    $this->load->view('templates/main_table_add', $data);
  }
  function edit_row()
  {
    $edit_user = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->get();
    $set_array = array();
    foreach ($input_data as $key => $value) {
      if ($key == "id") {
        $id = $value;
      } else if ($key == "table") {
        $table = $value;
      } else if ($key == "module") {
        $module_name = $value;
      } else if ($key == "page") {
        $page_name = $value;
      } else {
        $set_array[$key] = $value;
      }
    }
    $set_array['edit_user'] = $edit_user;
    $this->main_table_01_model->edit_table_row($table, $id, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function add_row()
  {
    $edit_user = $this->session->userdata('SESS_USER_ID');
    $input_data = $this->input->get();
    $set_array = array();
    foreach ($input_data as $key => $value) {
      if ($key == "table") {
        $table = $value;
      } else if ($key == "module") {
        $module_name = $value;
      } else if ($key == "page") {
        $page_name = $value;
      } else {
        $set_array[$key] = $value;
      }
    }
    $set_array['edit_user'] = $edit_user;
    $this->main_table_01_model->add_table_row($table, $set_array);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function delete_row()
  {
    $edit_user = $this->session->userdata('SESS_USER_ID');
    $id = $this->input->get('delete_id');
    $table = $this->input->get('table');
    $module_name = $this->input->get('module');
    $page_name = $this->input->get('page');
    $this->main_table_01_model->delete_table_row($id, $table, $edit_user);
    $this->session->set_userdata('delete', 'Deleted Successfully!');
    redirect($module_name . "/" . $page_name);
  }
  function edit_bulk_status()
  {
    $edit_user = $this->session->userdata('SESS_USER_ID');
    $status = $this->input->post('modal_title');
    $ids = $this->input->post('list_mark_ids');
    $ids_int = array_map('intval', explode(',', $ids));
    $module_name = $this->input->get('module');
    $page_name = $this->input->get('page_name');
    $table = $this->input->get('table');
    $page = $this->input->get('page');
    $row_url = '&row=';
    $row = $this->input->get('row');
    $tab = $this->input->get('tab');
    if ($page == null) {
      $page = 1;
    }
    if ($row == null) {
      $row_url = '';
      $row = '';
    }
    if ($tab == null) {
      $tab = "all";
    }
    $this->main_table_01_model->edit_bulk_status($table, $status, $ids_int, $edit_user);
    $this->session->set_userdata('success', 'Submitted Successfully!');
    redirect($module_name . '/' . $page_name . '?page=' . $page . $row_url . $row . '&tab=' . $tab);
  }



  function GET_SHIFT_ASSIGN()
  {

    $data = json_decode(file_get_contents('php://input'), true);
    $empl_id = $data['empl_id'];
    $adjustmentDate = $data['adjustmentDate'];
    $empl_id = $this->attendance_model->GET_ATTENDACE_SHIFT_ASSIGN($empl_id, $adjustmentDate);
    $result = $this->attendance_model->GET_ATTENDANCE_SHIFT($empl_id);
    echo json_encode($result);
  }
} // class attendances extends CI_Controller ENDS HERE =======================================


function filter_payroll_sched($month, $data)
{
  $filtered_data = array();
  foreach ($data as $sched) {
    if ($sched->month == $month) {
      $filtered_data[] = $sched;
    }
  }
  return $filtered_data;
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
  $modules = array_unique($modules, SORT_REGULAR);
  return $modules;
}
