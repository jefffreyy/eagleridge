<?php $this->load->view('templates/css_link'); ?>

<html>

<body style="overflow: hidden; height: 100%; width: 100%;">

    <div style="width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: rgba(0, 0, 0, 0.74)"></div>
  <div style="width: 850px; height: 395px; left: 535px; top: 342px; position: absolute">
    <div style="width: 850px; height: 395px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="width: 850px; height: 36px; left: 0px; top: 171px; position: absolute; text-align: center; color: black; font-size: 30px; font-family: Lato; font-weight: 400; word-wrap: break-word">Measuring. Please Wait &nbsp;&nbsp;<i class="fa-solid fa-spinner fa-spin-pulse fa-xl"></i></div>

  </div>
 
<script>
$(document).ready(function() {
setInterval(function() {
$.ajax({
url: '<?=base_url()?>test/get_bp_data',
type: 'get',
dataType: 'json',
success: function(data) {

  console.log(data.bp_systolic);
  if(data.bp_systolic !== null){
    window.location = '<?=base_url()?>test/test_result/4';
  }
  
}
});
}, 3000);
});
  </script>

</body>

</html>