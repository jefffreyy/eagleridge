<?php $this->load->view('templates/css_link'); ?>
<style>
body {
  overscroll-behavior: none; /* Prevents rubber-banding for the whole body */
}

</style>
<html>

<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">
<div style="width: 1920px; height: 1080px; position: relative">
  <!-- <div style="width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: #E6EAEE"></div> -->
 
  <div style="width: 1000px; height: 855px; left: 880px; top: 185px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
  <div style="width: 800px; height: 750px; left: 40px; top: 290px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
  <div style="width: 263px; height: 30px; left: 60px; top: 310px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-solid fa-arrow-progress mb-2"></i>&nbsp;&nbsp;Instructions</div>

  <div style="width: 760px; height: 475px; left: 60px; top: 360px; position: absolute; background: #F2F2F2; border-radius: 20px">


</div>




  <div style="width: 665px; height: 90px; left: 40px; top: 184px; position: absolute">
  <div style="width: 90px; height: 90px; left: 0px; top: 0px; position: absolute; background: white"></div>
  <div style="width: 552px; height: 62px; left: 113px; top: 14px; position: absolute; color: black; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word"><?= $page_title ?></div>
  <div style="width: 90px; height: 62px; left: 0px; top: 14px; position: absolute; text-align: center; color: black; font-size: 24px; font-family: Lato; font-weight: 600; word-wrap: break-word">STEP<br/><?= $page_number ?></div>
  </div>

  <div style="width: 1000px; height: 855px; left: 880px; top: 183px; position: absolute">
    <div style="width: 1000px; height: 855px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="width: 960px; height: 372px; left: 20px; top: 462px; position: absolute">
      <div style="width: 960px; height: 372px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
      <div style="width: 464.31px; left: 24px; top: 13px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Pulse Rate (bpm)</div>
      <div style="width: 190px; height: 121px; left: 509px; top: 140px; position: absolute">
        <div style="width: 146.82px; left: 21.59px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">60 - 100</div>
        <div style="width: 190px; left: 0px; top: 92px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Normal</div>
      </div>
      <div style="width: 190px; height: 121px; left: 756px; top: 140px; position: absolute">
        <div style="width: 100.40px; left: 45.34px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">> 100</div>
        <div style="width: 190px; left: 0px; top: 92px; position: absolute; text-align: center; color: #FF0000; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Excessive</div>
      </div>
      <div style="width: 190px; height: 121px; left: 262px; top: 140px; position: absolute">
        <div style="width: 124.15px; left: 33.47px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">40 - 60</div>
        <div style="width: 190px; left: 0px; top: 92px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Athlete</div>
      </div>
      <div style="width: 190px; height: 121px; left: 15px; top: 140px; position: absolute">
        <div style="width: 68.01px; left: 61.53px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word"><40 </div>
        <div style="width: 190px; left: 0px; top: 92px; position: absolute; text-align: center; color: #FF0000; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Deficient</div>
      </div>
    </div>
    <div style="width: 263px; height: 30px; left: 20px; top: 20px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-sharp fa-solid fa-dial-med-low mb-2"></i>&nbsp;&nbsp;Reference Ranges</div>
    <div style="width: 960px; height: 372px; left: 20px; top: 70px; position: absolute">
      <div style="width: 960px; height: 372px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
      <div style="width: 141.18px; left: 24px; top: 11px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">SpO2%</div>
      <div style="width: 568px; height: 132px; left: 200px; top: 120px; position: absolute">
        <div style="left: 42px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">≥ 95 %</div>
        <div style="left: 425px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">< 95 °C</div>
        <div style="width: 176px; left: 0px; top: 103px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Normal</div>
        <div style="width: 176px; left: 392px; top: 103px; position: absolute; text-align: center; color: #FF0000; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Abnormal</div>
      </div>
    </div>
  </div>
  

  
  <div style="width: 720px; height: 436px; left: 80px; top: 380px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 400; word-wrap: break-word"><?= $page_instruction ?></div>

  <?php
  if($page_number == 1 || $page_number == 2 ){
    ?>
  <a href="<?= base_url() ?>test/test_manual/<?= $page_number ?>/0">  
  <div style="width: 760px; height: 73px; left: 60px; top: 854px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="width: 760px; height: 32px; left: 60px; top: 875px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"> <i class="fa-solid fa-hand-point-right fa-beat-fade mb-2"></i>&nbsp;&nbsp;Start</div>
  </a>
  <?php } 
  else{?>
<a href="<?= base_url() ?>test/test_measuring/<?= $page_number ?>/0">  
  <div style="width: 760px; height: 73px; left: 60px; top: 854px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="width: 760px; height: 32px; left: 60px; top: 875px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"> <i class="fa-solid fa-hand-point-right fa-beat-fade mb-2"></i>&nbsp;&nbsp;Start</div>
  </a>
<?php
  }?>


  <?php
  if($page_enable_manual){?>
  <a href="<?= base_url() ?>test/test_manual/<?= $page_number ?>/0">  

  <div style="width: 370px; height: 73px; left: 60px; top: 947px; position: absolute; background: linear-gradient(180deg, #FFC000 0%, #DCA600 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"  <?php echo($page_enable_manual)? "":"hidden"  ?>></div>
  <div style="width: 370px; height: 32px; left: 60px; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word" <?php echo($page_enable_manual)? "":"hidden"  ?>><i class="fa-solid fa-keyboard mb-2"></i></i>&nbsp;&nbsp;Manual Entry</div>
  </a>


  <a href="<?= base_url() ?>test/test_skip/<?= $page_number?>/0"> 

    <div style="width: 370px; height: 73px; left: 450px; top: 947px; position: absolute; background: linear-gradient(180deg, #BFBFBF 0%, #989898 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
    <div style="width: 370px; height: 32px; left: 450px; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-sharp fa-solid fa-forward mb-2"></i>&nbsp;&nbsp;Skip</div>
  </a>

  <?php
  }
  else{
    ?>


<a href="<?= base_url() ?>test/test_skip/<?= $page_number?>"> 

  <div style="width: 760; height: 73px; left: 60; top: 947px; position: absolute; background: linear-gradient(180deg, #BFBFBF 0%, #989898 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="width: 760; height: 32px; left: 60; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-sharp fa-solid fa-forward mb-2"></i>&nbsp;&nbsp;Skip</div>
</a>



    <?php
  }
  ?>
  
</div>
</body>
<script>
function BlockMove(event) { 
  event.preventDefault(); 
}


</script>
</html>