<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class test extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('test_model');
  }

  function header($page_no){
    $page_no_int = intval($page_no);
    $page_info = $this->test_model->GET_PAGE_INFO();
    $start_time = $this->test_model->GET_START_TIME();
    $allocated_time = $this->test_model->GET_ALLOCATED_TIME();
 
    $data_header["start_time"] = $start_time;
    $data_header["allocated_time"] = $allocated_time;

    $data_header["page_status_1"]  = $page_status_1 = $page_info[0]->status;
    $data_header["page_status_2"]  = $page_status_2 = $page_info[1]->status;
    $data_header["page_status_3"]  = $page_status_3 = $page_info[2]->status;
    $data_header["page_status_4"]  = $page_status_4 = $page_info[3]->status;
    $data_header["page_status_5"]  = $page_status_5 = $page_info[4]->status;
    $data_header["page_status_6"]  = $page_status_6 = $page_info[5]->status;
    $data_header["page_status_7"]  = $page_status_7 = $page_info[6]->status;
    $data_header["page_status_8"]  = $page_status_8 = $page_info[7]->status;
    $data_header["page_status_9"]  = $page_status_9 = $page_info[8]->status;
    $data_header["page_status_10"]  = $page_status_10 = $page_info[9]->status;

    $page_id_1 = $page_info[0]->id;
    $page_id_2 = $page_info[1]->id;
    $page_id_3 = $page_info[2]->id;
    $page_id_4 = $page_info[3]->id;
    $page_id_5 = $page_info[4]->id;
    $page_id_6 = $page_info[5]->id;
    $page_id_7 = $page_info[6]->id;
    $page_id_8 = $page_info[7]->id;
    $page_id_9 = $page_info[8]->id;
    $page_id_10 = $page_info[9]->id;

    $color_notyetstarted      = "#FFFFFF";
    $color_ongoing            = "#006eff";
    $color_completed          = "#00B050";
    $color_skipped            = "#FF0000";
    $page_icon                ="fa-solid fa-circle-o fa-beat fa-2xl";

    $text_notyetstarted       = "";
    $text_ongoing             = "Ongoing";
    $text_completed           = "Completed";
    $text_skipped             = "Skipped";

    $data_header["page_pos_1"]       = 180;
    if ($page_status_1 == 0) {
      $data_header["page_color_1"]   = $color_notyetstarted;
      $data_header["page_text_1"]    = $text_notyetstarted;
    } elseif ($page_status_1 == 1) {
      $data_header["page_color_1"]   = $color_ongoing;
      $data_header["page_text_1"]    = $text_ongoing;
    } elseif ($page_status_1 == 2) {
      $data_header["page_color_1"]   = $color_completed;
      $data_header["page_text_1"]    = $text_completed;
    } elseif ($page_status_1 == 3) {
      $data_header["page_color_1"]   = $color_skipped;
      $data_header["page_text_1"]    = $text_skipped;
    }
    if ($page_id_1 == 1) {
      $data_header["page_title_1"]   = $page_info[0]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_2"]       = 343;
    if ($page_status_2 == 0) {
      $data_header["page_color_2"]   = $color_notyetstarted;
      $data_header["page_text_2"]    = $text_notyetstarted;
    } elseif ($page_status_2 == 1) {
      $data_header["page_color_2"]   = $color_ongoing;
      $data_header["page_text_2"]    = $text_ongoing;
    } elseif ($page_status_2 == 2) {
      $data_header["page_color_2"]   = $color_completed;
      $data_header["page_text_2"]    = $text_completed;
    } elseif ($page_status_2 == 3) {
      $data_header["page_color_2"]   = $color_skipped;
      $data_header["page_text_2"]    = $text_skipped;
    }
    if ($page_id_2 == 2) {
      $data_header["page_title_2"]   = $page_info[1]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_3"]       = 504;
    if ($page_status_3 == 0) {
      $data_header["page_color_3"]   = $color_notyetstarted;
      $data_header["page_text_3"]    = $text_notyetstarted;
    } elseif ($page_status_3 == 1) {
      $data_header["page_color_3"]   = $color_ongoing;
      $data_header["page_text_3"]    = $text_ongoing;
    } elseif ($page_status_3 == 2) {
      $data_header["page_color_3"]   = $color_completed;
      $data_header["page_text_3"]    = $text_completed;
    } elseif ($page_status_3 == 3) {
      $data_header["page_color_3"]   = $color_skipped;
      $data_header["page_text_3"]    = $text_skipped;
    }
    if ($page_id_3 == 3) {
      $data_header["page_title_3"]   = $page_info[2]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_4"]       = 666;
    if ($page_status_4 == 0) {
      $data_header["page_color_4"]   = $color_notyetstarted;
      $data_header["page_text_4"]    = $text_notyetstarted;
    } elseif ($page_status_4 == 1) {
      $data_header["page_color_4"]   = $color_ongoing;
      $data_header["page_text_4"]    = $text_ongoing;
    } elseif ($page_status_4 == 2) {
      $data_header["page_color_4"]   = $color_completed;
      $data_header["page_text_4"]    = $text_completed;
    } elseif ($page_status_4 == 3) {
      $data_header["page_color_4"]   = $color_skipped;
      $data_header["page_text_4"]    = $text_skipped;
    }
    if ($page_id_4 == 4) {
      $data_header["page_title_4"]   = $page_info[3]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_5"]       = 829;
    if ($page_status_5 == 0) {
      $data_header["page_color_5"]   = $color_notyetstarted;
      $data_header["page_text_5"]    = $text_notyetstarted;
    } elseif ($page_status_5 == 1) {
      $data_header["page_color_5"]   = $color_ongoing;
      $data_header["page_text_5"]    = $text_ongoing;
    } elseif ($page_status_5 == 2) {
      $data_header["page_color_5"]   = $color_completed;
      $data_header["page_text_5"]    = $text_completed;
    } elseif ($page_status_5 == 3) {
      $data_header["page_color_5"]   = $color_skipped;
      $data_header["page_text_5"]    = $text_skipped;
    }
    if ($page_id_5 == 5) {
      $data_header["page_title_5"]   = $page_info[4]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_6"]       = 992;
    if ($page_status_6 == 0) {
      $data_header["page_color_6"]   = $color_notyetstarted;
      $data_header["page_text_6"]    = $text_notyetstarted;
    } elseif ($page_status_6 == 1) {
      $data_header["page_color_6"]   = $color_ongoing;
      $data_header["page_text_6"]    = $text_ongoing;
    } elseif ($page_status_6 == 2) {
      $data_header["page_color_6"]   = $color_completed;
      $data_header["page_text_6"]    = $text_completed;
    } elseif ($page_status_6 == 3) {
      $data_header["page_color_6"]   = $color_skipped;
      $data_header["page_text_6"]    = $text_skipped;
    }
    if ($page_id_6 == 6) {
      $data_header["page_title_6"]   = $page_info[5]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_7"]       = 1153;
    if ($page_status_7 == 0) {
      $data_header["page_color_7"]   = $color_notyetstarted;
      $data_header["page_text_7"]    = $text_notyetstarted;
    } elseif ($page_status_7 == 1) {
      $data_header["page_color_7"]   = $color_ongoing;
      $data_header["page_text_7"]    = $text_ongoing;
    } elseif ($page_status_7 == 2) {
      $data_header["page_color_7"]   = $color_completed;
      $data_header["page_text_7"]    = $text_completed;
    } elseif ($page_status_7 == 3) {
      $data_header["page_color_7"]   = $color_skipped;
      $data_header["page_text_7"]    = $text_skipped;
    }
    if ($page_id_7 == 7) {
      $data_header["page_title_7"]   = $page_info[6]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_8"]       = 1315;
    if ($page_status_8 == 0) {
      $data_header["page_color_8"]   = $color_notyetstarted;
      $data_header["page_text_8"]    = $text_notyetstarted;
    } elseif ($page_status_8 == 1) {
      $data_header["page_color_8"]   = $color_ongoing;
      $data_header["page_text_8"]    = $text_ongoing;
    } elseif ($page_status_8 == 2) {
      $data_header["page_color_8"]   = $color_completed;
      $data_header["page_text_8"]    = $text_completed;
    } elseif ($page_status_8 == 3) {
      $data_header["page_color_8"]   = $color_skipped;
      $data_header["page_text_8"]    = $text_skipped;
    }
    if ($page_id_8 == 8) {
      $data_header["page_title_8"]   = $page_info[7]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_9"]       = 1477;
    if ($page_status_9 == 0) {
      $data_header["page_color_9"]   = $color_notyetstarted;
      $data_header["page_text_9"]    = $text_notyetstarted;
    } elseif ($page_status_9 == 1) {
      $data_header["page_color_9"]   = $color_ongoing;
      $data_header["page_text_9"]    = $text_ongoing;
    } elseif ($page_status_9 == 2) {
      $data_header["page_color_9"]   = $color_completed;
      $data_header["page_text_9"]    = $text_completed;
    } elseif ($page_status_9 == 3) {
      $data_header["page_color_9"]   = $color_skipped;
      $data_header["page_text_9"]    = $text_skipped;
    }
    if ($page_id_9 == 9) {
      $data_header["page_title_9"]   = $page_info[8]->title;
    }
    // ----------------------------------------------

    $data_header["page_pos_10"]       = 1639;
    if ($page_status_10 == 0) {
      $data_header["page_color_10"]   = $color_notyetstarted;
      $data_header["page_text_10"]    = $text_notyetstarted;
    } elseif ($page_status_10 == 1) {
      $data_header["page_color_10"]   = $color_ongoing;
      $data_header["page_text_10"]    = $text_ongoing;
    } elseif ($page_status_10 == 2) {
      $data_header["page_color_10"]   = $color_completed;
      $data_header["page_text_10"]    = $text_completed;
    } elseif ($page_status_10 == 3) {
      $data_header["page_color_10"]   = $color_skipped;
      $data_header["page_text_10"]    = $text_skipped;
    }
    if ($page_id_10 == 10) {
      $data_header["page_title_10"]   = $page_info[9]->title;
    }

    // ------------------------------------
    // ------------------------------------
    $data_header["page_posi_1"]       = 178.25;
    if ($page_status_1 == 0) {
      $data_header["page_color_1"]   = $color_notyetstarted;
      $data_header["page_text_1"]    = $text_notyetstarted;
      $data_header["page_icon_1"]      =$page_icon;
    } elseif ($page_status_1 == 1) {
      $data_header["page_color_1"]   = $color_ongoing;
      $data_header["page_text_1"]    = $text_ongoing;
      $data_header["page_icon_1"]      =$page_icon;
    } elseif ($page_status_1 == 2) {
      $data_header["page_color_1"]   = $color_completed;
      $data_header["page_text_1"]    = $text_completed;
      $data_header["page_icon_1"]      =$page_icon;
    } elseif ($page_status_1 == 3) {
      $data_header["page_color_1"]   = $color_skipped;
      $data_header["page_text_1"]    = $text_skipped;
      $data_header["page_icon_1"]      =$page_icon;
    }
    // ------------------------------------
    $data_header["page_posi_2"]       = 340.36;
    if ($page_status_2 == 0) {
      $data_header["page_color_2"]   = $color_notyetstarted;
      $data_header["page_text_2"]    = $text_notyetstarted;
    } elseif ($page_status_2 == 1) {
      $data_header["page_color_2"]   = $color_ongoing;
      $data_header["page_text_2"]    = $text_ongoing;
    } elseif ($page_status_2 == 2) {
      $data_header["page_color_2"]   = $color_completed;
      $data_header["page_text_2"]    = $text_completed;
    } elseif ($page_status_2 == 3) {
      $data_header["page_color_2"]   = $color_skipped;
      $data_header["page_text_2"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_3"]       = 502.47;
    if ($page_status_3 == 0) {
      $data_header["page_color_3"]   = $color_notyetstarted;
      $data_header["page_text_3"]    = $text_notyetstarted;
    } elseif ($page_status_3 == 1) {
      $data_header["page_color_3"]   = $color_ongoing;
      $data_header["page_text_3"]    = $text_ongoing;
    } elseif ($page_status_3 == 2) {
      $data_header["page_color_3"]   = $color_completed;
      $data_header["page_text_3"]    = $text_completed;
    } elseif ($page_status_3 == 3) {
      $data_header["page_color_3"]   = $color_skipped;
      $data_header["page_text_3"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_4"]       = 664.58;
    if ($page_status_4 == 0) {
      $data_header["page_color_4"]   = $color_notyetstarted;
      $data_header["page_text_4"]    = $text_notyetstarted;
    } elseif ($page_status_4 == 1) {
      $data_header["page_color_4"]   = $color_ongoing;
      $data_header["page_text_4"]    = $text_ongoing;
    } elseif ($page_status_4 == 2) {
      $data_header["page_color_4"]   = $color_completed;
      $data_header["page_text_4"]    = $text_completed;
    } elseif ($page_status_4 == 3) {
      $data_header["page_color_4"]   = $color_skipped;
      $data_header["page_text_4"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_5"]       = 826.69;
    if ($page_status_5 == 0) {
      $data_header["page_color_5"]   = $color_notyetstarted;
      $data_header["page_text_5"]    = $text_notyetstarted;
    } elseif ($page_status_5 == 1) {
      $data_header["page_color_5"]   = $color_ongoing;
      $data_header["page_text_5"]    = $text_ongoing;
    } elseif ($page_status_5 == 2) {
      $data_header["page_color_5"]   = $color_completed;
      $data_header["page_text_5"]    = $text_completed;
    } elseif ($page_status_5 == 3) {
      $data_header["page_color_5"]   = $color_skipped;
      $data_header["page_text_5"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_6"]       = 988.8;
    if ($page_status_6 == 0) {
      $data_header["page_color_6"]   = $color_notyetstarted;
      $data_header["page_text_6"]    = $text_notyetstarted;
    } elseif ($page_status_6 == 1) {
      $data_header["page_color_6"]   = $color_ongoing;
      $data_header["page_text_6"]    = $text_ongoing;
    } elseif ($page_status_6 == 2) {
      $data_header["page_color_6"]   = $color_completed;
      $data_header["page_text_6"]    = $text_completed;
    } elseif ($page_status_6 == 3) {
      $data_header["page_color_6"]   = $color_skipped;
      $data_header["page_text_6"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_7"]       = 1150.91;
    if ($page_status_7 == 0) {
      $data_header["page_color_7"]   = $color_notyetstarted;
      $data_header["page_text_7"]    = $text_notyetstarted;
    } elseif ($page_status_7 == 1) {
      $data_header["page_color_7"]   = $color_ongoing;
      $data_header["page_text_7"]    = $text_ongoing;
    } elseif ($page_status_7 == 2) {
      $data_header["page_color_7"]   = $color_completed;
      $data_header["page_text_7"]    = $text_completed;
    } elseif ($page_status_7 == 3) {
      $data_header["page_color_7"]   = $color_skipped;
      $data_header["page_text_7"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_8"]       = 1313.02;
    if ($page_status_8 == 0) {
      $data_header["page_color_8"]   = $color_notyetstarted;
      $data_header["page_text_8"]    = $text_notyetstarted;
    } elseif ($page_status_8 == 1) {
      $data_header["page_color_8"]   = $color_ongoing;
      $data_header["page_text_8"]    = $text_ongoing;
    } elseif ($page_status_8 == 2) {
      $data_header["page_color_8"]   = $color_completed;
      $data_header["page_text_8"]    = $text_completed;
    } elseif ($page_status_8 == 3) {
      $data_header["page_color_8"]   = $color_skipped;
      $data_header["page_text_8"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_9"]       = 1475.13;
    if ($page_status_9 == 0) {
      $data_header["page_color_9"]   = $color_notyetstarted;
      $data_header["page_text_9"]    = $text_notyetstarted;
    } elseif ($page_status_9 == 1) {
      $data_header["page_color_9"]   = $color_ongoing;
      $data_header["page_text_9"]    = $text_ongoing;
    } elseif ($page_status_9 == 2) {
      $data_header["page_color_9"]   = $color_completed;
      $data_header["page_text_9"]    = $text_completed;
    } elseif ($page_status_9 == 3) {
      $data_header["page_color_9"]   = $color_skipped;
      $data_header["page_text_9"]    = $text_skipped;
    }
    // ------------------------------------
    $data_header["page_posi_10"]       = 1637.24;
    if ($page_status_10 == 0) {
      $data_header["page_color_10"]   = $color_notyetstarted;
      $data_header["page_text_10"]    = $text_notyetstarted;
    } elseif ($page_status_10 == 1) {
      $data_header["page_color_10"]   = $color_ongoing;
      $data_header["page_text_10"]    = $text_ongoing;
    } elseif ($page_status_10 == 2) {
      $data_header["page_color_10"]   = $color_completed;
      $data_header["page_text_10"]    = $text_completed;
    } elseif ($page_status_10 == 3) {
      $data_header["page_color_10"]   = $color_skipped;
      $data_header["page_text_10"]    = $text_skipped;
    }


    return $data_header;
  }

  function header_report(){
   
    $start_time = $this->test_model->GET_START_TIME();
    $allocated_time = $this->test_model->GET_ALLOCATED_TIME();
 
    $data_header["start_time"] = $start_time;
    $data_header["allocated_time"] = $allocated_time;


  
    return $data_header;
  }




  function test_guide($page_no)
  {
    $page_no_int = intval($page_no);
    
    if($page_no_int == 1){  
      $this->test_model->UPDATE_PAGE_STATUS_CLEAR(); 
    }
    $this->test_model->UPDATE_PAGE_STATUS(1,$page_no);

    $data_header = $this->header($page_no);


    $page_info = $this->test_model->GET_PAGE_INFO();

    $data["page_title"]             = $page_info[$page_no_int - 1]->title;
    $data["page_number"]            = $page_info[$page_no_int - 1]->id;
    $data["page_instruction"]       = $page_info[$page_no_int - 1]->instruction;
    $data["page_enable_manual"]     = $page_info[$page_no_int - 1]->enable_manual;


    $this->load->view('test/test_header_views', $data_header);

    if($page_no == 1){
      $this->load->view('test/test_1_guide_views', $data);
    }
    elseif($page_no == 2){
      $this->load->view('test/test_2_guide_views', $data);
    }
    elseif($page_no == 3){
      $this->load->view('test/test_3_guide_views', $data);
    }
    elseif($page_no == 4){
      $this->load->view('test/test_4_guide_views', $data);
    }
    elseif($page_no == 5){
      $this->load->view('test/test_5_guide_views', $data);
    }
    elseif($page_no == 6){
      $this->load->view('test/test_6_guide_views', $data);
    }
    elseif($page_no == 7){
      $this->load->view('test/test_7_guide_views', $data);
    }
    elseif($page_no == 8){
      $this->load->view('test/test_8_guide_views', $data);
    }
    elseif($page_no == 9){
      $this->load->view('test/test_9_guide_views', $data);
    }
    elseif($page_no == 10){
      $this->load->view('test/test_10_guide_views', $data);
    }

    
  }
  function test_report()
  {
    $data_header = $this->header_report();

    $this->load->view('test/test_header_report_views', $data_header);
    $this->load->view('test/test_report_views');
  }

  function test_manual($page_no,$location)
  {
    $page_no_int = intval($page_no);
    $data["page_location"] = $location;
    $data_header = $this->header_report($page_no);

    if($page_no_int == 1){  
      $this->test_model->UPDATE_PAGE_STATUS_CLEAR(); 
    }

    $this->test_model->UPDATE_PAGE_STATUS(1,$page_no);
    $page_info = $this->test_model->GET_PAGE_INFO();

    $data["page_title"]             = $page_info[$page_no_int - 1]->title;
    $data["page_number"]            = $page_info[$page_no_int - 1]->id;
    $data["page_instruction"]       = $page_info[$page_no_int - 1]->instruction;
    $data["page_enable_manual"]     = $page_info[$page_no_int - 1]->enable_manual;


    $this->load->view('test/test_header_report_views', $data_header);




    if($location == '1'){
      if($page_no == 1){
        $this->load->view('test/test_1_result_views', $data);
      }
      elseif($page_no == 2){
        $this->load->view('test/test_2_result_views', $data);
      }
      elseif($page_no == 3){
        $this->load->view('test/test_3_result_views', $data);
      }
      elseif($page_no == 4){
        $this->load->view('test/test_4_result_views', $data);
      }
      elseif($page_no == 5){
        $this->load->view('test/test_5_result_views', $data);
      }
      elseif($page_no == 6){
        $this->load->view('test/test_6_result_views', $data);
      }
      elseif($page_no == 7){
        $this->load->view('test/test_7_result_views', $data);
      }
      elseif($page_no == 8){
        $this->load->view('test/test_8_result_views', $data);
      }
      elseif($page_no == 9){
        $this->load->view('test/test_9_result_views', $data);
      }
      elseif($page_no == 10){
        $this->load->view('test/test_10_result_views', $data);
      }
    }
    else{
      if($page_no == 1){
        $this->load->view('test/test_1_guide_views', $data);
      }
      elseif($page_no == 2){
        $this->load->view('test/test_2_guide_views', $data);
      }
      elseif($page_no == 3){
        $this->load->view('test/test_3_guide_views', $data);
      }
      elseif($page_no == 4){
        $this->load->view('test/test_4_guide_views', $data);
      }
      elseif($page_no == 5){
       
        $this->load->view('test/test_5_guide_views', $data);
      }
      elseif($page_no == 6){
        $this->load->view('test/test_6_guide_views', $data);
      }
      elseif($page_no == 7){
        $this->load->view('test/test_7_guide_views', $data);
      }
      elseif($page_no == 8){
        $this->load->view('test/test_8_guide_views', $data);
      }
      elseif($page_no == 9){
        $this->load->view('test/test_9_guide_views', $data);
      }
      elseif($page_no == 10){
        $this->load->view('test/test_10_guide_views', $data);
      }
    }


    if($page_no == 1){
      $this->load->view('test/test_1_manual_views');
    }
    elseif($page_no == 2){
        $this->load->view('test/test_2_manual_views');
    }
    elseif($page_no == 3){
        $this->load->view('test/test_3_manual_views');
    }
    elseif($page_no == 4){
        $this->load->view('test/test_4_manual_views');
    }
    elseif($page_no == 5){
     
        $this->load->view('test/test_5_manual_views');
    }
    elseif($page_no == 6){
        $this->load->view('test/test_6_manual_views');
    }
    elseif($page_no == 7){
        $this->load->view('test/test_7_manual_views');
    }
    elseif($page_no == 8){
        $this->load->view('test/test_8_manual_views');
    }
    elseif($page_no == 9){
        $this->load->view('test/test_9_manual_views');
    }
    elseif($page_no == 10){
        $this->load->view('test/test_10_manual_views');
    }

  }

  function test_skip($page_no)
  {
    $page_no_int = intval($page_no);
    
    $data_header = $this->header($page_no);

    if($page_no_int == 1){  
      $this->test_model->UPDATE_PAGE_STATUS_CLEAR(); 
    }

    $this->test_model->UPDATE_PAGE_STATUS(1,$page_no);
    $page_info = $this->test_model->GET_PAGE_INFO();
  


    $data["page_title"]             = $page_info[$page_no_int - 1]->title;
    $data["page_number"]            = $page_info[$page_no_int - 1]->id;
    $data["page_instruction"]       = $page_info[$page_no_int - 1]->instruction;
    $data["page_enable_manual"]     = $page_info[$page_no_int - 1]->enable_manual;
 

    $this->load->view('test/test_header_views', $data_header);

    if($page_no == 1){
      $this->load->view('test/test_1_guide_views', $data);
    }
    elseif($page_no == 2){
      $this->load->view('test/test_2_guide_views', $data);
    }
    elseif($page_no == 3){
      $this->load->view('test/test_3_guide_views', $data);
    }
    elseif($page_no == 4){
      $this->load->view('test/test_4_guide_views', $data);
    }
    elseif($page_no == 5){
      $this->load->view('test/test_5_guide_views', $data);
    }
    elseif($page_no == 6){
      $this->load->view('test/test_6_guide_views', $data);
    }
    elseif($page_no == 7){
      $this->load->view('test/test_7_guide_views', $data);
    }
    elseif($page_no == 8){
      $this->load->view('test/test_8_guide_views', $data);
    }
    elseif($page_no == 9){
      $this->load->view('test/test_9_guide_views', $data);
    }
    elseif($page_no == 10){
      $this->load->view('test/test_10_guide_views', $data);
    }
    $this->load->view('test/test_skip_views');
  }

  function test_skip_insert($page_no)
  {
    $this->test_model->UPDATE_PAGE_STATUS(3,$page_no);
    $this->test_model->UPDATE_PAGE_STATUS(1,$page_no + 1);

    redirect('test/test_guide/'.$page_no + 1);
  }
  function test_measuring($page_no,$location)
  {
    $page_no_int = intval($page_no);
    


    $this->test_model->UPDATE_PAGE_STATUS(1,$page_no);

    $data_header = $this->header($page_no);

    $page_info = $this->test_model->GET_PAGE_INFO();

    $data["page_title"]             = $page_info[$page_no_int - 1]->title;
    $data["page_number"]            = $page_info[$page_no_int - 1]->id;
    $data["page_instruction"]       = $page_info[$page_no_int - 1]->instruction;
    $data["page_enable_manual"]     = $page_info[$page_no_int - 1]->enable_manual;


    $this->load->view('test/test_header_views', $data_header);

     if($location == '1'){
      if($page_no == 1){
        $this->load->view('test/test_1_result_views', $data);
      }
      elseif($page_no == 2){
        $this->load->view('test/test_2_result_views', $data);
      }
      elseif($page_no == 3){
        $this->load->view('test/test_3_result_views', $data);
      }
      elseif($page_no == 4){
        $this->load->view('test/test_4_result_views', $data);
      }
      elseif($page_no == 5){
        $this->load->view('test/test_5_result_views', $data);
      }
      elseif($page_no == 6){
        $this->load->view('test/test_6_result_views', $data);
      }
      elseif($page_no == 7){
        $this->load->view('test/test_7_result_views', $data);
      }
      elseif($page_no == 8){
        $this->load->view('test/test_8_result_views', $data);
      }
      elseif($page_no == 9){
        $this->load->view('test/test_9_result_views', $data);
      }
      elseif($page_no == 10){
        $this->load->view('test/test_10_result_views', $data);
      }
    }
    else{
      if($page_no == 1){
        $this->load->view('test/test_1_guide_views', $data);
      }
      elseif($page_no == 2){
        $this->load->view('test/test_2_guide_views', $data);
      }
      elseif($page_no == 3){
        $this->load->view('test/test_3_guide_views', $data);
      }
      elseif($page_no == 4){
        $this->load->view('test/test_4_guide_views', $data);
      }
      elseif($page_no == 5){
        $this->load->view('test/test_5_guide_views', $data);
      }
      elseif($page_no == 6){
        $this->load->view('test/test_6_guide_views', $data);
      }
      elseif($page_no == 7){
        $this->load->view('test/test_7_guide_views', $data);
      }
      elseif($page_no == 8){
        $this->load->view('test/test_8_guide_views', $data);
      }
      elseif($page_no == 9){
        $this->load->view('test/test_9_guide_views', $data);
      }
      elseif($page_no == 10){
        $this->load->view('test/test_10_guide_views', $data);
      }
    }
    
    if($page_no == 1){
      $this->load->view('test/test_1_measuring_views', $data);
    }
    elseif($page_no == 2){
      $this->load->view('test/test_2_measuring_views', $data);
    }
    elseif($page_no == 3){
      $this->load->view('test/test_3_measuring_views', $data);
    }
    elseif($page_no == 4){
      $this->load->view('test/test_4_measuring_views', $data);
    }
    elseif($page_no == 5){
      $this->test_model->UPDATE_PAGE_STATUS_5_ON();
      $this->load->view('test/test_5_measuring_views', $data);
    }
    elseif($page_no == 6){
      $this->load->view('test/test_6_measuring_views', $data);
    }
    elseif($page_no == 7){
      $this->load->view('test/test_7_measuring_views', $data);
    }
    elseif($page_no == 8){
      $this->load->view('test/test_8_measuring_views', $data);
    }
    elseif($page_no == 9){
      $this->load->view('test/test_9_measuring_views', $data);
    }
    elseif($page_no == 10){
      $this->load->view('test/test_10_measuring_views', $data);
    }
  
  }

  function test_result($page_no, $id)
  {


    $data['waist_hip_ration']       = $this->test_model->GET_WAIST_HIP_RATIO($id);

    $height_val                     = $this->input->post('height_value');
    $weight_val                     = $this->input->post('weight_value');
    
  
    $page_no_int = intval($page_no);
   
    $this->test_model->UPDATE_PAGE_STATUS(2,$page_no);

    $data_header = $this->header($page_no);

    $page_info = $this->test_model->GET_PAGE_INFO();

    $data["page_title"]             = $page_info[$page_no_int - 1]->title;
    $data["page_number"]            = $page_info[$page_no_int - 1]->id;
    $data["page_instruction"]       = $page_info[$page_no_int - 1]->instruction;
    $data["page_enable_manual"]     = $page_info[$page_no_int - 1]->enable_manual;

    $bp_results = $this->test_model->GET_BP_RESULTS();
    $temp_result = $this->test_model->GET_TEMP_RESULTS();
    $oxy_results = $this->test_model->GET_OXY_RESULTS();

    $data["bp_systolic"]       = $bp_results["bp_systolic"];
    $data["bp_diastolic"]     =  $bp_results["bp_diastolic"];
    $data["bp_pulse"]     =  $bp_results["bp_pulse"];
    $data["temp_result"]     =  $temp_result;
    $data["oxy_bloodoxygen"]     =  $oxy_results["oxy_bloodoxygen"];
    $data["oxy_pulse"]     =  $oxy_results["oxy_pulse"];
    $this->load->view('test/test_header_views', $data_header);

    if($page_no == 1){
      $this->load->view('test/test_1_result_views', $data);
    }
    elseif($page_no == 2){
      $this->load->view('test/test_2_result_views', $data);
    }
    elseif($page_no == 3){
      $this->load->view('test/test_3_result_views', $data);
    }
    elseif($page_no == 4){
      $this->load->view('test/test_4_result_views', $data);
    }
    elseif($page_no == 5){
      $oxy_results = $this->test_model->GET_OXY_RESULTS();
      $data["oxy_bloodoxygen"]     =  $oxy_results["oxy_bloodoxygen"];
      $data["oxy_pulse"]     =  $oxy_results["oxy_pulse"];
      $this->load->view('test/test_5_result_views', $data);
    }
    elseif($page_no == 6){
      $this->load->view('test/test_6_result_views', $data);
    }
    elseif($page_no == 7){
      $this->load->view('test/test_7_result_views', $data);
    }
    elseif($page_no == 8){
      $this->load->view('test/test_8_result_views', $data);
    }
    elseif($page_no == 9){
      $this->load->view('test/test_9_result_views', $data);
    }
    elseif($page_no == 10){
      $this->load->view('test/test_10_result_views', $data);
    }

  }

  function insert_waist_hip(){
    
    $page_number                    = $this->input->post('page_number');
    $waist_val                      = $this->input->post('waist_value');
    $hip_val                        = $this->input->post('hip_value');
    $waist_hip_ratio                = $waist_val/$hip_val;
  
    $result_id                      = $this->test_model->INSERT_WAIST_HIP($waist_val, $hip_val, $waist_hip_ratio);

    redirect('test/test_result/'.$page_number.'/'.$result_id);
  }

  function insert_height_weight(){
    $page_number                    = $this->input->post('page_number');
    $height_val                     = $this->input->post('height_value');
    $weight_val                     = $this->input->post('weight_value');

    $height_m_val = $height_cm_val * 0.01; // cm to meter

    $height_weigth_result           = $weight_val/$height_m_val;
  
    $result_id                      = $this->test_model->UPDATE_HEIGht_WEIGHT($height_val, $weight_val, $height_weigth_result);

    redirect('test/test_result/'.$page_number.'/'.$result_id);
  }


  function get_bp_data()
  {
    
    $bp_results = $this->test_model->GET_BP_RESULTS();
    echo json_encode($bp_results);
   
  }

  
  function get_temp_data()
  {
    
    $temp_result = $this->test_model->GET_TEMP_RESULTS();
    echo json_encode($temp_result);
   
  }

  function get_oxy_data()
  {
    
    $oxy_results = $this->test_model->GET_OXY_RESULTS();
    echo json_encode($oxy_results);
   
  }
}
