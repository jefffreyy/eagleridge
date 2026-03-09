<?php defined('BASEPATH') or exit('No direct script access allowed');
ob_start();
class userguide extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    // $this->load->model('home/home_model');

    // if ($this->session->userdata('SESS_USER_ID') == '' || $this->session->userdata('SESS_USER_ID') == null || $this->session->userdata('SESS_ADMIN') == '') {
    //   redirect('login');
    // }
  }
  function index(){
    $data["C_CONTENT"]=array(
      array(
      "title"=>"What is HRMS",
      'id'=>"top_1",
      "content"=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. 
      Possimus, asperiores molestias, sed hic ducimus, consequuntur 
      repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
      quos placeat quaerat doloribus dicta labore cumque.
      Lorem ipsum dolor sit amet consectetur adipisicing elit. 
      Possimus, asperiores molestias, sed hic ducimus, consequuntur 
      repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
      quos placeat quaerat doloribus dicta labore cumque.
      ",
      "image"=>"/assets_system/images/user_onboarding.jpg",
      "icon"=>"fab fa-angular"
      ),
      array(
        "title"=>"Topic 2",'id'=>"top_2",
        "content"=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Possimus, asperiores molestias, sed hic ducimus, consequuntur 
        repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
        quos placeat quaerat doloribus dicta labore cumque.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Possimus, asperiores molestias, sed hic ducimus, consequuntur 
        repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
        quos placeat quaerat doloribus dicta labore cumque.
        ",
        "image"=>"/assets_system/images/user_onboarding.jpg",
        "icon"=>"fab fa-angular"
        ),
        array(
          "title"=>"Topic 3",'id'=>"top_3",
          "content"=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. 
          Possimus, asperiores molestias, sed hic ducimus, consequuntur 
          repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
          quos placeat quaerat doloribus dicta labore cumque.
          Lorem ipsum dolor sit amet consectetur adipisicing elit. 
          Possimus, asperiores molestias, sed hic ducimus, consequuntur 
          repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
          quos placeat quaerat doloribus dicta labore cumque.
          ",
          "image"=>"/assets_system/images/user_onboarding.jpg",
          "icon"=>"fab fa-angular"
          ),
          array(
            "title"=>"Topic 4",'id'=>"top_4",
            "content"=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Possimus, asperiores molestias, sed hic ducimus, consequuntur 
            repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
            quos placeat quaerat doloribus dicta labore cumque.
            Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Possimus, asperiores molestias, sed hic ducimus, consequuntur 
            repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
            quos placeat quaerat doloribus dicta labore cumque.
            ",
            "image"=>"/assets_system/images/user_onboarding.jpg",
            "icon"=>"fab fa-angular"
            ),
            array(
              "title"=>"Topic 5",'id'=>"top_5",
              "content"=>"Lorem ipsum dolor sit amet consectetur adipisicing elit. 
              Possimus, asperiores molestias, sed hic ducimus, consequuntur 
              repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
              quos placeat quaerat doloribus dicta labore cumque.
              Lorem ipsum dolor sit amet consectetur adipisicing elit. 
              Possimus, asperiores molestias, sed hic ducimus, consequuntur 
              repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
              quos placeat quaerat doloribus dicta labore cumque.
              ",
              "image"=>"/assets_system/images/user_onboarding.jpg",
              "icon"=>"fas fa-dharmachakra"
              )
    );
    $this->load->view('modules/user_guide/user_guide_views',$data);
  }
}