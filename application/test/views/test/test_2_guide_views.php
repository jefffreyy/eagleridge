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
 
  <!-- <div style="width: 1000px; height: 855px; left: 880px; top: 185px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div> -->
  <div style="width: 800px; height: 750px; left: 40px; top: 290px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
  <div style="width: 263px; height: 30px; left: 60px; top: 310px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-solid fa-arrow-progress mb-2"></i>&nbsp;&nbsp;Instructions</div>

  <div style="width: 760px; height: 475px; left: 60px; top: 360px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>


  <div style="width: 1000px; height: 855px; left: 880px; top: 183px; position: absolute">
    <div style="width: 1000px; height: 855px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="width: 960px; height: 372px; left: 20px; top: 462px; position: absolute">
      <div style="width: 960px; height: 372px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
      <div style="width: 103.53px; left: 502.47px; top: 62px; position: absolute; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Men</div>
      <div style="width: 178.82px; left: 745.53px; top: 62px; position: absolute; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Women</div>
      <div style="width: 156.86px; left: 475.91px; top: 107px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">2 - 4 %</div>
      <div style="width: 172.55px; left: 749.62px; top: 107px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">9 - 11%</div>
      <div style="width: 172.55px; left: 467.74px; top: 162px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">6 - 13%</div>
      <div style="width: 203.92px; left: 733.28px; top: 162px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">14 - 20%</div>
      <div style="width: 203.92px; left: 451.40px; top: 217px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">14 - 17%</div>
      <div style="width: 203.92px; left: 733.28px; top: 217px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">21 - 24%</div>
      <div style="width: 203.92px; left: 451.40px; top: 272px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">18 - 25%</div>
      <div style="width: 203.92px; left: 733.28px; top: 272px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">25 - 31%</div>
      <div style="width: 128.63px; left: 488.17px; top: 327px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">26%+</div>
      <div style="width: 128.63px; left: 770.04px; top: 327px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">32%+</div>
      <div style="width: 298.04px; left: 69.02px; top: 62px; position: absolute; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Classification</div>
      <div style="width: 194.51px; left: 69.02px; top: 107px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Essential</div>
      <div style="width: 163.14px; left: 69.02px; top: 162px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Athlete</div>
      <div style="width: 59.61px; left: 69.02px; top: 217px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Fit</div>
      <div style="width: 163.14px; left: 69.02px; top: 272px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Normal</div>
      <div style="width: 144.31px; left: 69.02px; top: 327px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Obese</div>
      <div style="width: 960px; height: 0px; left: 0px; top: 88px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 960px; height: 0px; left: 0px; top: 55px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 317px; height: 0px; left: 414px; top: 55px; position: absolute; transform: rotate(90deg); transform-origin: 0 0; border: 0.50px black solid"></div>
      <div style="width: 317px; height: 0px; left: 696px; top: 55px; position: absolute; transform: rotate(90deg); transform-origin: 0 0; border: 0.50px black solid"></div>
      <div style="width: 464.31px; left: 24px; top: 13px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Body Fat Rate</div>
    </div>
    <div style="width: 263px; height: 30px; left: 20px; top: 20px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-sharp fa-solid fa-dial-med-low mb-2"></i>&nbsp;&nbsp;Reference Ranges</div>
    <div style="width: 960px; height: 372px; left: 20px; top: 70px; position: absolute">
      <div style="width: 960px; height: 372px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
      <div style="width: 147.45px; left: 706.72px; top: 62px; position: absolute; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">kg/m2</div>
      <div style="width: 141.18px; left: 708.77px; top: 103px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">< 18.5</div>
      <div style="width: 244.71px; left: 657.70px; top: 141px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">18.5 - 24.9</div>
      <div style="width: 203.92px; left: 678.13px; top: 179px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">25 - 29.9</div>
      <div style="width: 203.92px; left: 678.13px; top: 217px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">30 - 34.9</div>
      <div style="width: 203.92px; left: 678.13px; top: 255px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">35 - 39.9</div>
      <div style="width: 203.92px; left: 678.13px; top: 293px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">40 - 49.9</div>
      <div style="width: 100.39px; left: 729.19px; top: 331px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">> 50</div>
      <div style="width: 203.92px; left: 69.02px; top: 62px; position: absolute; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Category</div>
      <div style="width: 288.63px; left: 69.02px; top: 103px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Underweight</div>
      <div style="width: 175.69px; left: 69.02px; top: 141px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Healthy</div>
      <div style="width: 260.39px; left: 69.02px; top: 179px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Overweight</div>
      <div style="width: 197.65px; left: 69.02px; top: 217px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Obese (I)</div>
      <div style="width: 410.98px; left: 69.02px; top: 255px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Severely Obese (II)</div>
      <div style="width: 436.08px; left: 69.02px; top: 293px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Morbidly Obese (III)</div>
      <div style="width: 370.20px; left: 69.02px; top: 331px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Super Obese (IV)</div>
      <div style="width: 960px; height: 0px; left: 0px; top: 88px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 960px; height: 0px; left: 0px; top: 55px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 317px; height: 0px; left: 587px; top: 55px; position: absolute; transform: rotate(90deg); transform-origin: 0 0; border: 0.50px black solid"></div>
      <div style="width: 141.18px; left: 24px; top: 11px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">BMI</div>
    </div>
  </div>



  <div style="width: 665px; height: 90px; left: 40px; top: 184px; position: absolute">
  <div style="width: 90px; height: 90px; left: 0px; top: 0px; position: absolute; background: white"></div>
  <div style="width: 552px; height: 62px; left: 113px; top: 14px; position: absolute; color: black; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word"><?= $page_title ?></div>
  <div style="width: 90px; height: 62px; left: 0px; top: 14px; position: absolute; text-align: center; color: black; font-size: 24px; font-family: Lato; font-weight: 600; word-wrap: break-word">STEP<br/><?= $page_number ?></div>
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