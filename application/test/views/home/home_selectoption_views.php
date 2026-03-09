<?php $this->load->view('templates/css_link'); ?>


<html>

<body  ontouchmove="BlockMove(event);">
    <div style="width: 1920px; height: 1080px; position: relative">
        <!-- <div style="width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: #E6EAEE"></div>
        <img style="width: 141px; height: 141px; left: 14px; top: 10px; position: absolute" src="https://via.placeholder.com/141x141" /> -->

          <a href="<?= base_url() ?>test/test_guide/1">
        <div style="width: 480px; height: 300px; left: 720px; top: 390px; position: absolute;background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
        <div style="width: 480px; height: 62px; left: 720px; top: 495px; position: absolute; text-align: center; color: white; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word" >Health Record</div>
        </a>

       <a href="<?= base_url() ?>test/test_guide/1">  
        <div style="width: 480px; height: 300px; left: 212px; top: 390px; position: absolute;background: linear-gradient(180deg, #FFC000 0%, #DCA600 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
        <div style="width: 480px; height: 62px; left: 212px; top: 495px; position: absolute; text-align: center; color: white; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word">Health Check</div>
        </a>
       


        <div style="width: 480px; height: 300px; left: 1228px; top: 390px; position: absolute; background: #D9D9D9; border-radius: 20px"></div>

       
        <div style="width: 384px; height: 122px; left: 1277px; top: 465px; position: absolute; text-align: center; color: white; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word">Doctor Consultation</div>
        <!-- <div style="width: 200px; height: 80px; left: 1674px; top: 41px; position: absolute; background: #B8CBE9; border-radius: 20px"></div>
        
        <a href="<?= base_url() ?>home/userselections">
  <div style="width: 200px; height: 37px; left: 1674px; top: 59px; position: absolute; text-align: center; color: white; font-size: 32px; font-family: Lato; font-weight: 700; word-wrap: break-word">Back</div>
    </a> -->


        <div style="width: 1000px; height: 91px; left: 460px; top: 26px; position: absolute; background: #E3E3E3; border-radius: 20px"></div>
        <div style="width: 480px; height: 62px; left: 720px; top: 36px; position: absolute; text-align: center; color: #070707; font-size: 48px; font-family: Lato; font-weight: 600; word-wrap: break-word">Service Selection</div>
        <div style="width: 1191px; height: 33px; left: 364px; top: 250px; position: absolute; text-align: center; color: #070707; font-size: 32px; font-family: Lato; font-weight: 400; word-wrap: break-word">Please select appropriate option</div>
    </div>
</body>
<script>
function BlockMove(event) { 
  event.preventDefault(); 
}


</script>
</html>