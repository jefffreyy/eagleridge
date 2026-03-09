<?php $this->load->view('templates/css_link'); ?>

<html>

<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">
<div style="width: 1920px; height: 1080px; position: relative">

  <div style="width: 800px; height: 750px; left: 40px; top: 290px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="width: 263px; height: 30px; left: 60px; top: 310px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-solid fa-arrow-progress mb-2"></i>&nbsp;&nbsp;Instructions</div>





  <div style="width: 760px; height: 475px; left: 60px; top: 360px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
  <!-- <div style="width: 960px; height: 765px; left: 900px; top: 255px; position: absolute; background: #F2F2F2; border-radius: 20px"></div> -->
  <div style="width: 665px; height: 90px; left: 40px; top: 184px; position: absolute">
  <div style="width: 90px; height: 90px; left: 0px; top: 0px; position: absolute; background: white"></div>
  <div style="width: 552px; height: 62px; left: 113px; top: 14px; position: absolute; color: black; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word"><?= $page_title ?></div>
  <div style="width: 90px; height: 62px; left: 0px; top: 14px; position: absolute; text-align: center; color: black; font-size: 24px; font-family: Lato; font-weight: 600; word-wrap: break-word">STEP<br/><?= $page_number ?></div>
  </div>
  <!-- <div style="width: 263px; height: 30px; left: 900px; top: 205px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Reference Ranges</div> -->
  <div style="width: 1000px; height: 410px; left: 880px; top: 630px; position: absolute">
    <div style="width: 1000px; height: 410px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
       <div style="width: 263px; height: 30px; left: 20px; top: 20px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-sharp fa-solid fa-dial-med-low mb-2"></i>&nbsp;&nbsp;Reference Ranges</div>
  
  </div>
  <div style="width: 960px; height: 325px; left: 898px; top: 695px; position: absolute">
    <div style="width: 960px; height: 325px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
    <div style="width: 271px; height: 33.78px; left: 21px; top: 27.96px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Total Cholesterol (mg/dl)</div>
    <div style="width: 856px; height: 132px; left: 52px; top: 124px; position: absolute">
      <div style="width: 249px; left: 0px; top: 0px; position: absolute; text-align: center; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">< 200 mg/dl</div>
      <div style="left: 290px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">200 - 239 mg/dl</div>
      <div style="width: 266px; left: 590px; top: 0px; position: absolute; text-align: center; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">> 239 mg/dl</div>
      <div style="width: 176px; left: 37px; top: 103px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Normal</div>
      <div style="width: 176px; left: 332px; top: 103px; position: absolute; text-align: center; color: #FF0000; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Intermediate</div>
      <div style="width: 176px; left: 635px; top: 103px; position: absolute; text-align: center; color: #FF0000; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">High</div>
    </div>
  </div>
  <div style="width: 1000px; height: 410px; left: 880px; top: 185px; position: absolute">
    <div style="width: 1000px; height: 410px; left: 0px; top: 0px; position: absolute">
      <div style="width: 1000px; height: 410px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
            <div style="width: 263px; height: 30px; left: 20px; top: 20px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-regular fa-outdent mb-2"></i>&nbsp;&nbsp;Results</div>
    </div>
    <div style="width: 960px; height: 325px; left: 20px; top: 65px; position: absolute">
      <div style="width: 960px; height: 325px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
      <div style="width: 363px; left: 296px; top: 130px; position: absolute; text-align: center; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">200 mg/dl</div>
      <div style="width: 176px; left: 392px; top: 256px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Normal</div>
      <div style="left: 22px; top: 18px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Total Cholesterol (mg/dl)</div>
    </div>
  </div>
 

  
  <div style="width: 720px; height: 436px; left: 80px; top: 380px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 400; word-wrap: break-word"><?= $page_instruction ?></div>






  <?php 

  if($page_number == 10){ ?>
<a href="<?= base_url() ?>test/test_report"> 

  <?php } else { ?>
    <a href="<?= base_url() ?>test/test_guide/<?= $page_number + 1?>"> 



  <?php } ?>
  <div style="width: 760; height: 73px; left: 60; top: 854px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="width: 760; height: 32px; left: 60; top: 875px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">
  <?php 

  if($page_number == 10){ ?>
  <i class="fa-sharp fa-solid fa-file-chart-column mb-2"></i>&nbsp;&nbsp;Generate Report
  <?php } else { ?>
    <i class="fa-solid fa-hand-point-right fa-beat-fade mb-2"></i>&nbsp;&nbsp;Next Test



  <?php } ?>
 

</div>
</a>



<?php
  if($page_number == 1 || $page_number == 2 ){
    ?>
  <a href="<?= base_url() ?>test/test_manual/<?= $page_number ?>/1">  
  <div style="width: 760px; height: 73px; left: 60px; top: 947px; position: absolute; background: linear-gradient(180deg, #FFC000 0%, #DCA600 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="width: 760px; height: 32px; left: 60px; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-solid fa-repeat mb-2"></i>&nbsp;&nbsp;Re-test</div>
  </a>
  <?php } 
  else{?>
<a href="<?= base_url() ?>test/test_measuring/<?= $page_number ?>/1">  
  <div style="width: 760px; height: 73px; left: 60px; top: 947px; position: absolute; background: linear-gradient(180deg, #FFC000 0%, #DCA600 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="width: 760px; height: 32px; left: 60px; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-solid fa-repeat mb-2"></i>&nbsp;&nbsp;Re-test</div>
  </a>
<?php
  }?>
  
</div>
</body>
<script>
function BlockMove(event) { 
  event.preventDefault(); 
}


</script>
</html>

