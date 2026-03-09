<?php $this->load->view('templates/css_link'); ?>
<style>
body {
  overscroll-behavior: none; /* Prevents rubber-banding for the whole body */
}

</style>
<html>

<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">
<div style="user-select: none;user-select: none;user-select: none;width: 1920px; height: 1080px; position: relative">
  <!-- <div style="user-select: none;user-select: none;user-select: none;width: 1920px; height: 1080px; left: 0px; top: 0px; position: absolute; background: #E6EAEE"></div> -->
 
<div style="user-select: none;user-select: none;user-select: none;width: 800px; height: 750px; left: 40px; top: 290px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 263px; height: 30px; left: 60px; top: 310px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-solid fa-arrow-progress mb-2"></i>&nbsp;&nbsp;Instructions</div>

  <div style="user-select: none;user-select: none;user-select: none;width: 760px; height: 475px; left: 60px; top: 360px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>




  <div style="user-select: none;user-select: none;user-select: none;width: 665px; height: 90px; left: 40px; top: 184px; position: absolute">
  <div style="user-select: none;user-select: none;user-select: none;width: 90px; height: 90px; left: 0px; top: 0px; position: absolute; background: white"></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 552px; height: 62px; left: 113px; top: 14px; position: absolute; color: black; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word"><?= $page_title ?></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 90px; height: 62px; left: 0px; top: 14px; position: absolute; text-align: center; color: black; font-size: 24px; font-family: Lato; font-weight: 600; word-wrap: break-word">STEP<br/><?= $page_number ?></div>
  </div>
 
  <div style="user-select: none;user-select: none;user-select: none;width: 1000px; height: 855px; left: 880px; top: 185px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;width: 1000px; height: 855px; left: 0px; top: 0px; position: absolute; background: white; border-radius: 20px; border: 0.50px #A3A3A3 solid"></div>
    <div style="user-select: none;user-select: none;user-select: none;width: 960px; height: 765px; left: 20px; top: 70px; position: absolute; background: #F2F2F2; border-radius: 20px"></div>
    <div style="user-select: none;user-select: none;user-select: none;width: 263px; height: 30px; left: 20px; top: 20px; position: absolute; color: black; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word"><i class="fa-sharp fa-solid fa-dial-med-low mb-2"></i>&nbsp;&nbsp;Reference Ranges</div>
  </div>
  <div style="user-select: none;user-select: none;user-select: none;width: 576px; height: 132px; left: 1088px; top: 540px; position: absolute">
    <div style="user-select: none;user-select: none;user-select: none;left: 0px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">36 - 37.4 °C</div>
    <div style="user-select: none;user-select: none;user-select: none;left: 413px; top: 0px; position: absolute; text-align: right; color: black; font-size: 36px; font-family: Lato; font-weight: 700; word-wrap: break-word">> 37.5 °C</div>
    <div style="user-select: none;user-select: none;user-select: none;width: 176px; left: 8px; top: 103px; position: absolute; text-align: center; color: #00B050; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Normal</div>
    <div style="user-select: none;user-select: none;user-select: none;width: 176px; left: 400px; top: 103px; position: absolute; text-align: center; color: #FF0000; font-size: 24px; font-family: Lato; font-weight: 700; word-wrap: break-word">Fever</div>
  </div>



  <div style="user-select: none;user-select: none;user-select: none;width: 665px; height: 90px; left: 40px; top: 184px; position: absolute">
  <div style="user-select: none;user-select: none;user-select: none;width: 90px; height: 90px; left: 0px; top: 0px; position: absolute; background: white"></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 552px; height: 62px; left: 113px; top: 14px; position: absolute; color: black; font-size: 48px; font-family: Lato; font-weight: 700; word-wrap: break-word"><?= $page_title ?></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 90px; height: 62px; left: 0px; top: 14px; position: absolute; text-align: center; color: black; font-size: 24px; font-family: Lato; font-weight: 600; word-wrap: break-word">STEP<br/><?= $page_number ?></div>
  </div>

  
  <div style="user-select: none;user-select: none;user-select: none;width: 720px; height: 436px; left: 80px; top: 380px; position: absolute;">
    <div style= " color: black; font-size: 20px; font-family: Lato; font-weight: 400; word-wrap: break-word;overflow-y: scroll; height: 100%;"
      ontouchstart="handleTouchStart(event)"
      ontouchmove="handleTouchMove(event)"
      ontouchend="handleTouchEnd()">
      <?= $page_instruction ?>
    </div>
  </div>

  <?php
  if($page_number == 1 || $page_number == 2 ){
    ?>
  <a href="<?= base_url() ?>test/test_manual/<?= $page_number ?>/0">  
  <div style="user-select: none;user-select: none;user-select: none;width: 760px; height: 73px; left: 60px; top: 854px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 760px; height: 32px; left: 60px; top: 875px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"> <i class="fa-solid fa-hand-point-right fa-beat-fade mb-2"></i>&nbsp;&nbsp;Start</div>
  </a>
  <?php } 
  else{?>
<a href="<?= base_url() ?>test/test_measuring/<?= $page_number ?>/0">  
  <div style="user-select: none;user-select: none;user-select: none;width: 760px; height: 73px; left: 60px; top: 854px; position: absolute; background: linear-gradient(180deg, #92D050 0%, #53A100 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 760px; height: 32px; left: 60px; top: 875px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"> <i class="fa-solid fa-hand-point-right fa-beat-fade mb-2"></i>&nbsp;&nbsp;Start</div>
  </a>
<?php
  }?>


  <?php
  if($page_enable_manual){?>
  <a href="<?= base_url() ?>test/test_manual/<?= $page_number ?>/0">  

  <div style="user-select: none;user-select: none;user-select: none;width: 370px; height: 73px; left: 60px; top: 947px; position: absolute; background: linear-gradient(180deg, #FFC000 0%, #DCA600 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"  <?php echo($page_enable_manual)? "":"hidden"  ?>></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 370px; height: 32px; left: 60px; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word" <?php echo($page_enable_manual)? "":"hidden"  ?>><i class="fa-solid fa-keyboard mb-2"></i></i>&nbsp;&nbsp;Manual Entry</div>
  </a>


  <a href="<?= base_url() ?>test/test_skip/<?= $page_number?>/0"> 

    <div style="user-select: none;user-select: none;user-select: none;width: 370px; height: 73px; left: 450px; top: 947px; position: absolute; background: linear-gradient(180deg, #BFBFBF 0%, #989898 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
    <div style="user-select: none;user-select: none;user-select: none;width: 370px; height: 32px; left: 450px; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-sharp fa-solid fa-forward mb-2"></i>&nbsp;&nbsp;Skip</div>
  </a>

  <?php
  }
  else{
    ?>


<a href="<?= base_url() ?>test/test_skip/<?= $page_number?>"> 

  <div style="user-select: none;user-select: none;user-select: none;width: 760; height: 73px; left: 60; top: 947px; position: absolute; background: linear-gradient(180deg, #BFBFBF 0%, #989898 100%); box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25); border-radius: 20px"></div>
  <div style="user-select: none;user-select: none;user-select: none;width: 760; height: 32px; left: 60; top: 968px; position: absolute; text-align: center; color: white; font-size: 24px; font-family: Lato; font-weight: 500; word-wrap: break-word"><i class="fa-sharp fa-solid fa-forward mb-2"></i>&nbsp;&nbsp;Skip</div>
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
var scrollableDiv = document.querySelector("div[style*='overflow-y: scroll']");
  var isDragging = false;
  var startPosition = { x: 0, y: 0 };
  var scrollPosition = { x: 0, y: 0 };

  function handleTouchStart(event) {
    isDragging = true;
    var touch = event.touches[0];
    startPosition.x = touch.clientX;
    startPosition.y = touch.clientY;
    scrollPosition.x = scrollableDiv.scrollLeft;
    scrollPosition.y = scrollableDiv.scrollTop;
  }

  function handleTouchMove(event) {
    if (!isDragging) return;
    var touch = event.touches[0];
    var dx = touch.clientX - startPosition.x;
    var dy = touch.clientY - startPosition.y;
    scrollableDiv.scrollLeft = scrollPosition.x - dx;
    scrollableDiv.scrollTop = scrollPosition.y - dy;
  }

  function handleTouchEnd() {
    isDragging = false;
  }

  scrollableDiv.addEventListener("mousedown", function (e) {
    isDragging = true;
    startPosition.x = e.clientX;
    startPosition.y = e.clientY;
    scrollPosition.x = scrollableDiv.scrollLeft;
    scrollPosition.y = scrollableDiv.scrollTop;
  });

  document.addEventListener("mouseup", function () {
    isDragging = false;
  });

  document.addEventListener("mousemove", function (e) {
    if (isDragging) {
      var dx = e.clientX - startPosition.x;
      var dy = e.clientY - startPosition.y;
      scrollableDiv.scrollLeft = scrollPosition.x - dx;
      scrollableDiv.scrollTop = scrollPosition.y - dy;
    }
  });
  document.addEventListener("copy", function(event) {
  event.preventDefault();
  });

  document.addEventListener("paste", function(event) {
  event.preventDefault();
  });
  document.addEventListener("mousedown", function(event) {
  if (event.target.tagName !== "body") {
    event.preventDefault();
  }
});


</script>
</html>