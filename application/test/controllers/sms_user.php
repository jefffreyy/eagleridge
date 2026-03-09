<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class sms_user extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('templates/main_nav_model');
    $this->load->model('modules/payrolls_model');
    $this->load->model('modules/message_model');

    if ($this->session->userdata('SESS_USER_ID') == '') {
      redirect('login/session_expired');
    }

 
  }

  function index()
  {

    $row                    = $this->input->get('row')?$this->input->get('row')     : 25;
    $page                   = $this->input->get('page')?$this->input->get('page')   : 1;
    $tab                    = $this->input->get('tab')?$this->input->get('tab')     : 'Active';
    $search                 = $this->input->get('all');
    $offset                 = ($page-1)*$row;
    $data['MESSAGES']       = $this->message_model->GET_MESSAGES($row,$offset,$tab);
    $data['ACTIVES']        = $this->message_model->GET_COUNT_MESSAGES('Active');
    $data['INACTIVES']      = $this->message_model->GET_COUNT_MESSAGES('Inactive');
    $data['PAGE']           = $page;
    $data_count             = $this->message_model->GET_COUNT_MESSAGES($tab);
    $page_count             = intval($data_count/$row);
    $excess                 = $data_count%$row;
    $data['PAGES_COUNT']    = $excess>0 ? $page_count+=1: $page_count;
    $data['C_DATA_COUNT']   = $data_count;
    $data['ROW']            = $row;
    $data['TAB']            = $tab;
    
    if($search && $search!=''){
        $data['MESSAGES']       = $this->message_model->GET_MESSAGES_INFO_SEARCH($row,$offset,$tab,$search);
        $data['ACTIVES']        = $this->message_model->GET_COUNT_MESSAGES_SEARCH('Active',$search);
        $data['INACTIVES']      = $this->message_model->GET_COUNT_MESSAGES_SEARCH('Inactive',$search);
    }
 
    $this->load->view('templates/header_sms');
    $this->load->view('modules/messages/sms_message_views',$data);
    
  }

  function view_message($id){
    $res=$this->message_model->GET_SPE_MESSAGE($id);
    if(!$res){
         $this->session->set_flashdata('SESS_ERROR', 'No data found!');
        redirect('sms_user');
        return;
    }
    $data['MESSAGE']=$res;
    $string         = $data['MESSAGE']->message;
    $char_count     = 0;
    for ($i = 0; $i < strlen($string); $i++) {
        if (preg_match('/[a-zA-Z0-9]/', $string[$i])) {
            $char_count++;
        } else {
            $char_count += 2;
        }
    }
    $page_count             = ceil($char_count / 160);
    $max_char               = $page_count * 160;
    $data['PAGE_COUNT']     = $page_count;
    $data['CHAR_COUNT']     = $char_count;
    $data['MAX_CHAR']       = $max_char; 
    $this->load->view('templates/header_sms');
    $this->load->view('modules/messages/view_sms_message_views',$data);
    
  }
  function bulk_activate(){
    $loan_ids               = explode(',',$this->input->post('active'));
    $data=array();
    foreach($loan_ids as $id){
        $data[]=array('id'=>$id,'status'=>'Active');
    }
   $res=$this->message_model->UPDATE_BULK_ACTIVATE($data,$table);
   $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Activate!');
   redirect('messages/sms_messages');
}
function bulk_inactivate(){
$loan_ids                   = explode(',',$this->input->post('inactive'));
  $data=array();
    foreach($loan_ids as $id){
        $data[]=array('id'=>$id,'status'=>'Inactive');
    }
   $res=$this->message_model->UPDATE_BULK_ACTIVATE($data,$table);
   $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully Deactivate!');
   redirect('messages/sms_messages');
   

}
//   
function add_sms_messages(){
   // $data['DISP_EMPLOYEES']=$this->payrolls_model->GET_EMPLOYEE_LIST();
   // $data['LOAN_TYPES']=$this->payrolls_model->GET_LOAN_TYPE_DATA();
   $this->load->view('templates/header_sms');
   $this->load->view('modules/messages/add_sms_message_views');
   
}
function insert_new_sms_message(){
       $inputs                          = $this->input->post();
       $inputs['insrt_employee']        = $this->session->userdata('SESS_USER_ID');
       $is_now                          = $this->input->post('send_now');
       if($is_now=='on'){
           $inputs['insrt_date']        = date('Y-m-d H:i:s');
       }

       $mobile_num_raw                  = $inputs['insrt_mobile_num'];
       $message                         = $inputs['insrt_message'];

 
       $separator = ",";
       $mobile_numbers = explode($separator, $mobile_num_raw);

       foreach ($mobile_numbers as $numbers) {
         $this->test_api($numbers,$message);
       }

                  

       $res_new                         = $this->message_model->Add_NEW_MESSAGE($inputs);
     
       if($res_new){
           $this->session->set_flashdata('SESS_SUCC_LOAN', 'Successfully added!');
       }else{
           $this->session->set_flashdata('SESS_ERR_LOAN', 'Fail to add new data!');
       }
       redirect('sms_user');
      
       
   }

   function test_api($number,$message){
     $ch      = curl_init();

     
     curl_setopt($ch, CURLOPT_URL, "https://api.promotexter.com/sms/send");
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     curl_setopt($ch, CURLOPT_HEADER, FALSE);

     curl_setopt($ch, CURLOPT_POST, TRUE);

     curl_setopt($ch, CURLOPT_POSTFIELDS, "{
       \"apiKey\": \"RlMidXh8xm6ITdvn3u5L4Oh8EX2F8o\",
       \"apiSecret\": \"nB5yKhiJA-BlB-pixZK-Pi34esYVBN\",
       \"from\": \"SIEGEN\",
       \"to\": \"$number\",
       \"text\": \"$message\"
     }");

     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       "Content-Type: application/json"
     ));

     $response = curl_exec($ch);
     curl_close($ch);

     // var_dump($response);
   }
}
