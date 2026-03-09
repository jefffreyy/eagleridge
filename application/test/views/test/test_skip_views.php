<?php $this->load->view('templates/css_link'); ?>

<html>

<body style="overflow: hidden; height: 100%; width: 100%;">
  <a href="<?= base_url() ?>test/test_guide/<?= $page_number ?>">
    <div style="width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: rgba(0, 0, 0, 0.74)"></div>
  </a>

  <div style="width: 850px; height: 395px; left: 535px; top: 342px; position: absolute">


    <div style="width: 850px; height: 395px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="width: 850px; height: 36px; left: 0px; top: 151px; position: absolute; text-align: center; color: black; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Are you sure to skip this Test?</div>

    <a href="<?= base_url() ?>test/test_guide/<?= $page_number ?>">
      <div style="width: 395px; height: 73px; left: 20px; top: 302px; position: absolute; background: linear-gradient(180deg, #FFC000 0%, #DCA600 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
      <div style="width: 395px; height: 32px; left: 20px; top: 323px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Return</div>
    </a>
    <a href="<?= base_url() ?>test/test_skip_insert/<?= $page_number?>">
      <div style="width: 395px; height: 73px; left: 435px; top: 302px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
      <div style="width: 395px; height: 32px; left: 435px; top: 323px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-solid fa-hand-point-right fa-beat-fade mb-2"></i>&nbsp;&nbsp;Skip</div>
    </a>
    <a href="<?= base_url() ?>test/test_guide/<?= $page_number ?>">
      <div style="left: 803px; top: 19px; position: absolute; text-align: center; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">X</div>
    </a>
  </div>





</body>

</html>