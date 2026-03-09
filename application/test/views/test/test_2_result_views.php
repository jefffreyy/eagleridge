<?php $this->load->view('templates/css_link'); ?>

<html>

<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">
<div style="width: 1920px; height: 1080px; position: relative">

  <div style="width: 800px; height: 750px; left: 40px; top: 290px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="width: 263px; height: 30px; left: 60px; top: 310px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-solid fa-arrow-progress mb-2"></i>&nbsp;&nbsp;Instructions</div>





  <div style="width: 760px; height: 475px; left: 60px; top: 360px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
  <div style="width: 665px; height: 90px; left: 40px; top: 184px; position: absolute">
  <div style="width: 90px; height: 90px; left: 0px; top: 0px; position: absolute; background: white"></div>
  <div style="width: 552px; height: 62px; left: 113px; top: 14px; position: absolute; color: black; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word"><?= $page_title ?></div>
  <div style="width: 90px; height: 62px; left: 0px; top: 14px; position: absolute; text-align: center; color: black; font-size: 24px; font-family: Lato; font-weight: 600; word-wrap: break-word">STEP<br/><?= $page_number ?></div>
  </div>

  
  <div style="width: 720px; height: 436px; left: 80px; top: 380px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 400; word-wrap: break-word"><?= $page_instruction ?></div>

  <div style="width: 1000px; height: 410px; left: 880px; top: 185px; position: absolute">
    <div style="width: 1000px; height: 410px; left: 0px; top: 0px; position: absolute">
      <div style="width: 1000px; height: 410px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
            <div style="width: 263px; height: 30px; left: 20px; top: 20px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-regular fa-outdent mb-2"></i>&nbsp;&nbsp;Results</div>
    </div>
    <div style="width: 958px; height: 325px; left: 20px; top: 65px; position: absolute">
      <div style="width: 306px; height: 325px; left: 0px; top: 0px; position: absolute">
        <div style="width: 306px; height: 325px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
        <div style="left: 124px; top: 130px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">123.4</div>
        <div style="width: 176px; left: 65px; top: 256px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Normal</div>
        <div style="left: 22px; top: 18px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">BMI</div>
        <div style="width: 43px; height: 0px; left: 95px; top: 173px; position: absolute; transform: rotate(-90deg); transform-origin: 0 0; border: 2.50px #FF0000 solid"></div>
        <div style="width: 43px; height: 0px; left: 95px; top: 173px; position: absolute; transform: rotate(-90deg); transform-origin: 0 0; border: 2.50px #FF0000 solid"></div>
      </div>
      <div style="width: 306px; height: 325px; left: 326px; top: 0px; position: absolute">
        <div style="width: 306px; height: 325px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
        <div style="left: 146px; top: 130px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">1.45</div>
        <div style="width: 176px; left: 66px; top: 256px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Normal</div>
        <div style="left: 22px; top: 18px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Body Fat Rate</div>
        <div style="width: 43px; height: 0px; left: 96px; top: 173px; position: absolute; transform: rotate(-90deg); transform-origin: 0 0; border: 2.50px #FF0000 solid"></div>
        <div style="width: 43px; height: 0px; left: 96px; top: 173px; position: absolute; transform: rotate(-90deg); transform-origin: 0 0; border: 2.50px #FF0000 solid"></div>
      </div>
      <div style="width: 306px; height: 325px; left: 652px; top: 0px; position: absolute">
        <div style="width: 306px; height: 325px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
        <div style="left: 106px; top: 130px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">123.0</div>
        <div style="left: 24px; top: 18px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Basal Metabolic Rate</div>
      </div>
    </div>
  </div>

  <div style="width: 1000px; height: 410px; left: 878px; top: 630px; position: absolute">
    <div style="width: 1000px; height: 410px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
       <div style="width: 263px; height: 30px; left: 20px; top: 20px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-sharp fa-solid fa-dial-med-low mb-2"></i>&nbsp;&nbsp;Reference Ranges</div>
  
  </div>
  <div style="width: 960px; height: 325px; left: 898px; top: 695px; position: absolute">
    <div style="width: 470px; height: 325px; left: 0px; top: 0px; position: absolute">
      <div style="width: 470px; height: 325px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
      <div style="width: 72.19px; left: 346px; top: 62px; position: absolute; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">kg/m2</div>
      <div style="width: 69.12px; left: 347px; top: 94px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">< 18.5</div>
      <div style="width: 119.80px; left: 322px; top: 126px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">18.5 - 24.9</div>
      <div style="width: 99.84px; left: 332px; top: 158px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">25 - 29.9</div>
      <div style="width: 99.84px; left: 332px; top: 190px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">30 - 34.9</div>
      <div style="width: 99.84px; left: 332px; top: 222px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">35 - 39.9</div>
      <div style="width: 99.84px; left: 332px; top: 254px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">40 - 49.9</div>
      <div style="width: 49.15px; left: 357px; top: 286px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">> 50</div>
      <div style="width: 99.84px; left: 33.79px; top: 62px; position: absolute; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Category</div>
      <div style="width: 141.31px; left: 33.79px; top: 94px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Underweight</div>
      <div style="width: 86.01px; left: 33.79px; top: 126px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Healthy</div>
      <div style="width: 127.48px; left: 33.79px; top: 158px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Overweight</div>
      <div style="width: 96.76px; left: 33.79px; top: 190px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Obese (I)</div>
      <div style="width: 201.21px; left: 33.79px; top: 222px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Severely Obese (II)</div>
      <div style="width: 213.50px; left: 33.79px; top: 254px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Morbidly Obese (III)</div>
      <div style="width: 181.24px; left: 33.79px; top: 286px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Super Obese (IV)</div>
      <div style="width: 470px; height: 0px; left: 0px; top: 88px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 470px; height: 0px; left: 0px; top: 55px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 270px; height: 0px; left: 287.22px; top: 55px; position: absolute; transform: rotate(90deg); transform-origin: 0 0; border: 0.50px black solid"></div>
      <div style="width: 69.12px; left: 17px; top: 18px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">BMI</div>
    </div>
    <div style="width: 470px; height: 325px; left: 490px; top: 0px; position: absolute">
      <div style="width: 470px; height: 325px; left: 0px; top: 0px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
      <div style="width: 50.69px; left: 246px; top: 62px; position: absolute; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Men</div>
      <div style="width: 87.55px; left: 365px; top: 62px; position: absolute; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Women</div>
      <div style="width: 76.80px; left: 233px; top: 94px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">2 - 4 %</div>
      <div style="width: 84.48px; left: 367px; top: 94px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">9 - 11%</div>
      <div style="width: 84.48px; left: 229px; top: 126px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">6 - 13%</div>
      <div style="width: 99.84px; left: 359px; top: 126px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">14 - 20%</div>
      <div style="width: 99.84px; left: 221px; top: 158px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">14 - 17%</div>
      <div style="width: 99.84px; left: 359px; top: 158px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">21 - 24%</div>
      <div style="width: 99.84px; left: 221px; top: 190px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">18 - 25%</div>
      <div style="width: 99.84px; left: 359px; top: 190px; position: absolute; text-align: center; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">25 - 31%</div>
      <div style="width: 62.97px; left: 239px; top: 222px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">26%+</div>
      <div style="width: 62.97px; left: 377px; top: 222px; position: absolute; text-align: center; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">32%+</div>
      <div style="width: 145.92px; left: 33.79px; top: 62px; position: absolute; color: black; font-size: 16px; font-family: Lato; font-weight: 700; word-wrap: break-word">Classification</div>
      <div style="width: 95.23px; left: 33.79px; top: 94px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Essential</div>
      <div style="width: 79.87px; left: 33.79px; top: 126px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Athlete</div>
      <div style="width: 29.18px; left: 33.79px; top: 158px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Fit</div>
      <div style="width: 79.87px; left: 33.79px; top: 190px; position: absolute; color: #00B050; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Normal</div>
      <div style="width: 70.65px; left: 33.79px; top: 222px; position: absolute; color: #FF0000; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Obese</div>
      <div style="width: 470px; height: 0px; left: 0px; top: 88px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 470px; height: 0px; left: 0px; top: 55px; position: absolute; border: 0.50px black solid"></div>
      <div style="width: 270px; height: 0px; left: 202.75px; top: 55px; position: absolute; transform: rotate(90deg); transform-origin: 0 0; border: 0.50px black solid"></div>
      <div style="width: 270px; height: 0px; left: 340.98px; top: 55px; position: absolute; transform: rotate(90deg); transform-origin: 0 0; border: 0.50px black solid"></div>
      <div style="width: 227.32px; left: 20px; top: 18px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Body Fat Rate</div>
    </div>
  </div>


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

