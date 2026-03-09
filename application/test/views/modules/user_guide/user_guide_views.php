<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------

TECHNOS SYSTEM ENGINEERING INC.

EyeBox HRMS

@author     Technos Developers

@datetime   16 November 2022

@purpose    Company Contributions

CONTROLLER FILES:

MODEL FILES:

----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->

<?php $this->load->view('templates/css_link'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600&family=Lato:ital,wght@0,300;0,400;1,100&family=Poppins:ital,wght@0,300;0,400;1,300;1,400&display=swap');
    *{
        padding:0px;
        margin:0px;
        font-family: 'Lato', sans-serif;
        scroll-behavior: smooth;
    }
    li a{
        color:black;
    }
    .bg-success{
        background-color:#008036;
    }
</style>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<div class="fluid">
    <nav class="p-3  fixed-top border-warning navbar-light ">
        <div class="logo pt-2">
            <img  class="img-fluid" width="150" alt="Responsive image" src="<?=base_url()?>assets_system/images/login_logo.png">
        </div>
    </nav>
    <div style="height:120px"></div>
    <div class="container h-100">
        <div class="d-flex flex-wrap">
<?php foreach($C_CONTENT as $content) { ?>
    <a href="#<?=$content["id"]?>" class="mx-1 mb-2 pointer">
        <div class="p-3 text-center  d-flex flex-column  justify-content-center h-100" style="width:150px;height:150;border:3px solid #008037;border-radius:20px">
            <p><i class="<?=$content["icon"]?> text-success" style="font-size:50px"></i></p>
            <p class="text-center text-sm text-dark"><?=$content["title"]?></p>
        </div>
    </a>
            
<?php } ?>
        </div>
    </div>
    <div class="row p-3 w-100 ">
        <div class="col px-5 d-flex flex-column">
            <h3>Getting started guide for using Eyebox HRMS</h3>
            <br>
            <img  src="<?=base_url()?>/assets_system/images/user_onboarding.jpg">
            <br>
            <p class="text-bold text-justify" style="line-height:30px">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Possimus, asperiores molestias, sed hic ducimus, consequuntur 
                repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
                quos placeat quaerat doloribus dicta labore cumque.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Possimus, asperiores molestias, sed hic ducimus, consequuntur 
                repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
                quos placeat quaerat doloribus dicta labore cumque.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Possimus, asperiores molestias, sed hic ducimus, consequuntur 
                repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
                quos placeat quaerat doloribus dicta labore cumque.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Possimus, asperiores molestias, sed hic ducimus, consequuntur 
                repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
                quos placeat quaerat doloribus dicta labore cumque.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Possimus, asperiores molestias, sed hic ducimus, consequuntur 
                repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
                quos placeat quaerat doloribus dicta labore cumque.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Possimus, asperiores molestias, sed hic ducimus, consequuntur 
                repudiandae praesentium ab nemo magni consequatur. Quam doloremque 
                quos placeat quaerat doloribus dicta labore cumque.
            </p>
<?php foreach($C_CONTENT as $content) { ?>
            <h3 id="<?=$content["id"]?>"><?=$content["title"]?></h3>
            <img class="img-responsive" src="<?=base_url().$content["image"]?>" alt="">
            <p  class="text-justify"><?=$content["content"]?> </p>
<?php } ?>
            
        </div>
    </div>

</div>

<!-- Modal -->

<?php $this->load->view('templates/jquery_link'); ?>
<script>
    $(document).ready(function(){
        
        $("li").hover(function(){
    $(this).children(".sub_list").toggle('slow');
    }, function(){
        $(this).children(".sub_list").toggle('slow');
  });
    })
</script>
<script>
</script>