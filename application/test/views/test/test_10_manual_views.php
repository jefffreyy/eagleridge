<?php $this->load->view('templates/css_link'); ?>

<html>

<body style="overflow: hidden; height: 100%; width: 100%;">

  <?php if ($page_location == 1) {
  ?>
    <a href="<?= base_url() ?>test/test_result/<?= $page_number ?>">
    <?php } else { ?>
      <a href="<?= base_url() ?>test/test_guide/<?= $page_number ?>">
      <?php } ?>
      <div style="width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: rgba(0, 0, 0, 0.74)"></div>
      </a>



      <div style="width: 850px; height: 600px; left: 535px; top: 50px; position: absolute">

        <div style="width: 850px; height: 600px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
        <?php if ($page_location == 1) {
        ?>
          <a href="<?= base_url() ?>test/test_result/<?= $page_number ?>">
          <?php } 
          else { ?>
            <a href="<?= base_url() ?>test/test_guide/<?= $page_number ?>">
            <?php } ?>

            <div style="left: 803px; top: 15px; position: absolute; text-align: center; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">X</div>
          </a>
          
        </a>
        <div style="width: 168px; height: 36px; left: 70px; top: 112px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">TC</div>
        <div style="width: 471px; height: 56px; left: 256px; top: 105px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid"></div>
        <div style="width: 94px; height: 36px; left: 747px; top: 112px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">mg/dl</div>

        <div style="width: 168px; height: 36px; left: 70px; top: 186px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">HDL</div>
        <div style="width: 471px; height: 56px; left: 256px; top: 179px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid"></div>
        <div style="width: 94px; height: 36px; left: 747px; top: 186px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">mg/dl</div>

        <div style="width: 168px; height: 36px; left: 70px; top: 260px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">TG</div>
        <div style="width: 471px; height: 56px; left: 256px; top: 253px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid"></div>
        <div style="width: 94px; height: 36px; left: 747px; top: 260px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">mg/dl</div>

        <div style="width: 168px; height: 36px; left: 70px; top: 334px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">TC/HDL</div>
        <div style="width: 471px; height: 56px; left: 256px; top: 327px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid"></div>

        <div style="width: 168px; height: 36px; left: 70px; top: 408px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">LDL</div>
        <div style="width: 471px; height: 56px; left: 256px; top: 401px; position: absolute; background: white; border-radius: 10px; border: 0.50px black solid"></div>
        <div style="width: 94px; height: 36px; left: 747px; top: 408px; position: absolute; color: #070707; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">mg/dl</div>
        <!-- <div style="width: 710px; height: 36px; left: 70px; top: 116px; position: absolute; color: #FF0000; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Error: Please put non-zero value</div> -->



 
        <div style="width: 263px; height: 30px; left: 31px; top: 30px; position: absolute; color: black; font-size: 32px; font-family: Lato; font-weight: 700; word-wrap: break-word">Enter Result Data</div>
        

      
          <a href="<?= base_url() ?>test/test_result/<?= $page_number ?>">
         
           
            <div style="width: 810px; height: 73px; left: 20px; top: 507px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
            <div style="width: 810px; height: 32px; left: 20px; top: 528px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-solid fa-hand-point-right fa-beat-fade mb-2"></i>&nbsp;&nbsp;Submit</div>
          </a>
      
      </div>
      <div style="width: 1920px; height: 350px; left: 0px; top: 730px; position: absolute; background: #B8CBE9"></div>
  <div style="width: 640px; height: 70px; left: 375px; top: 910px; position: absolute">
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Z</div>
        </div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">X</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">C</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">V</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">B</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">N</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">M</div>
      </div>
    </div>
  </div>
  <div style="width: 640px; height: 70px; left: 375px; top: 991px; position: absolute">
    <div style="width: 640px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
        </div>
      </div>
    </div>
    <div style="width: 640px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
        </div>
      </div>
    </div>
  </div>
  <div style="width: 826px; height: 70px; left: 282px; top: 829px; position: absolute">
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">A</div>
        </div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">S</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">D</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">F</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key"style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">G</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">H</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">J</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 651px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">K</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 744px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">L</div>
      </div>
    </div>
  </div>
  <div style="width: 919px; height: 70px; left: 235px; top: 748px; position: absolute">
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Q</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">W</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">E</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 279px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">R</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 372px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">T</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 465px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">Y</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 558px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">U</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 651px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">I</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 744px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">O</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 837px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">P</div>
      </div>
    </div>
  </div>
  <div style="width: 268px; height: 70px; left: 1184px; top: 829px; position: absolute">
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">4</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">5</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">6</div>
      </div>
    </div>
  </div>
  <div style="width: 268px; height: 70px; left: 1184px; top: 910px; position: absolute">
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">1</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">2</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">3</div>
      </div>
    </div>
  </div>
  <div style="width: 175px; height: 70px; left: 1184px; top: 991px; position: absolute">
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">.</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key"style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">0</div>
      </div>
    </div>
  </div>
  <div style="width: 203px; padding-top: 22.50px; padding-bottom: 22.50px; left: 1482px; top: 829px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
    <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
      <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
        <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">CLEAR ALL</div>
      </div>
    </div>
  </div>
  <div style="width: 203px; padding-top: 22.50px; padding-bottom: 22.50px; left: 1482px; top: 991px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
    <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
      <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
        <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">NEXT</div>
      </div>
    </div>
  </div>
  <div style="width: 203px; height: 70px; left: 1482px; top: 748px; position: absolute">
    <div style="width: 203px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">SPACEBAR</div>
        </div>
      </div>
    </div>
    <div style="width: 203px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div style="align-self: stretch; justify-content: flex-start; align-items: flex-start; gap: 10px; display: inline-flex">
          <div class="key" style="flex: 1 1 0; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">BACKSPACE</div>
        </div>
      </div>
    </div>
  </div>
  <div style="width: 268px; height: 70px; left: 1184px; top: 748px; position: absolute">
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 0px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">7</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 93px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">8</div>
      </div>
    </div>
    <div style="width: 82px; height: 70px; padding-top: 22.50px; padding-bottom: 22.50px; left: 186px; top: 0px; position: absolute; background: #FFFFFF; box-shadow: 0px 1px 0px black; border-radius: 4.60px; justify-content: center; align-items: center; display: inline-flex">
      <div style="flex: 1 1 0; align-self: stretch; flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
        <div class="key" style="align-self: stretch; height: 25px; text-align: center; color: #3A3A3A; font-size: 22px; font-family: Lato; font-weight: 400; line-height: 21px; word-wrap: break-word">9</div>
      </div>
    </div>
  </div>
</body>

</html>