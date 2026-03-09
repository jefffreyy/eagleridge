<?php $this->load->view('templates/css_link'); ?>

<html>

<body style="overflow: hidden; height: 100%; width: 100%;">

    <div style="width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: rgba(0, 0, 0, 0.74)"></div>
  <div style="width: 850px; height: 395px; left: 535px; top: 342px; position: absolute">
    <div style="width: 850px; height: 395px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="width: 850px; height: 36px; left: 0px; top: 171px; position: absolute; text-align: center; color: black; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Measuring. Please Wait &nbsp;&nbsp;<i class="fa-solid fa-spinner fa-spin-pulse fa-xl"></i></div>
    <div style="width: 395px; height: 73px; left: 227px; top: 250px; position: absolute; background: #92D050; border-radius: 20px"></div>
    <a href="<?= base_url() ?>test/test_result/<?= $page_number ?>">
      <div style="width: 395px; height: 32px; left: 227px; top: 271px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word">Override</div>
    </a>
  </div>



</body>

</html>