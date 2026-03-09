
<html>



<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">
  <div style="width: 1920px; height: 150px; position: absolute; background-color : #EEFBFF">
    <img style="width: 130px; height: 130px; left: 10px; top: 10px; position: absolute" src="https://via.placeholder.com/130x130" />
    <div style="width: 1440px; height: 0px; left: 215; top: 50px; position: absolute; border: 1px #DFDFDF solid"></div>

    

    <div style="left:<?= $page_posi_1 ?>px; top: 50px; position: absolute">

        <?php if ($page_status_1 == 0){ ?>
          <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
        <?php }elseif($page_status_1 == 1){ ?>
          <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
        <?php }elseif($page_status_1 == 2){ ?>
          <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
        <?php }elseif($page_status_1 == 3){ ?>
          <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
             <?php } ?>
    </div>


    <div style="left:<?= $page_posi_2 ?>px; top: 50px; position: absolute">

        <?php if ($page_status_2 == 0){ ?>
          <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
        <?php }elseif($page_status_2 == 1){ ?>
          <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
        <?php }elseif($page_status_2 == 2){ ?>
          <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
        <?php }elseif($page_status_2 == 3){ ?>
          <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
             <?php } ?>
    </div>

    <div style="left:<?= $page_posi_3 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_3 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_3 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_3 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_3 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>

    <div style="left:<?= $page_posi_4 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_4 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_4 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_4 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_4 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>

    <div style="left:<?= $page_posi_5 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_5 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_5 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_5 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_5 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>
 
    <div style="left:<?= $page_posi_6 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_6 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_6 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_6 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_6 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>

    <div style="left:<?= $page_posi_7 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_7 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_7 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_7 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_7 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>

    <div style="left:<?= $page_posi_8 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_8 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_8 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_8 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_8 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>
    
 
    <div style="left:<?= $page_posi_9 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_9 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_9 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_9 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_9 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>   
    

    <div style="left:<?= $page_posi_10 ?>px; top: 50px; position: absolute">
      <?php if ($page_status_10 == 0){ ?>
        <i class="fa-duotone fa-circle-dot fa-2xl" style="--fa-primary-color: #ededed; --fa-secondary-color: #d6d6d6; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_10 == 1){ ?>
        <i class="fa-duotone fa-circle-o fa-beat-fade fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #0044cc; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_10 == 2){ ?>
        <i class="fa-duotone fa-circle-check fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #00B050; --fa-secondary-opacity: 1;"></i>
      <?php }elseif($page_status_10 == 3){ ?>
        <i class="fa-duotone fa-circle-xmark fa-2xl" style="--fa-primary-color: #ffffff; --fa-secondary-color: #ff0000; --fa-secondary-opacity: 1;"></i>
          <?php } ?>
    </div>    
    
    
    
    
    <div style="width: 120px; height: 120px; left: 1780px; top:15px; position: absolute; padding-bottom:20px; border-radius: 9999px; border: 2.50px #A1DEFF solid">
  <div style="display: block; text-align: center; color: black; font-size: 48px; font-family: Lato; font-weight: 700; margin-top:10px;word-wrap: break-word" id ="time_difference"></div>
</div>
<div style="left:1805px; top:90px; position:absolute;display: block; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Time Left</div>

    

    <div style="width: 1920px; height: 0px; left: 0px; top: 150px; position: absolute; border: 1px #A1DEFF solid"></div>

    <?php
    echo ('<div style="left:  ' . $page_pos_1 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_1 . '</div>');
    echo ('<div style="left:  ' . $page_pos_2 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_2 . '</div>');
    echo ('<div style="left:  ' . $page_pos_3 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_3 . '</div>');
    echo ('<div style="left:  ' . $page_pos_4 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_4 . '</div>');
    echo ('<div style="left:  ' . $page_pos_5 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_5 . '</div>');
    echo ('<div style="left:  ' . $page_pos_6 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_6 . '</div>');
    echo ('<div style="left:  ' . $page_pos_7 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_7 . '</div>');
    echo ('<div style="left:  ' . $page_pos_8 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_8 . '</div>');
    echo ('<div style="left:  ' . $page_pos_9 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_9 . '</div>');
    echo ('<div style="left:  ' . $page_pos_10 . 'px; top: 81px; position: absolute; color: black; font-size: 20px; font-family: Lato; font-weight: 500; word-wrap: break-word">' . $page_title_10 . '</div>');
    ?>

    <?php
    echo (' <div style="left: ' . $page_pos_1 . 'px; top: 104px; position: absolute; color: ' . $page_color_1 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_1 . '</div>');
    echo (' <div style="left: ' . $page_pos_2 . 'px; top: 104px; position: absolute; color: ' . $page_color_2 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_2 . '</div>');
    echo (' <div style="left: ' . $page_pos_3 . 'px; top: 104px; position: absolute; color: ' . $page_color_3 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_3 . '</div>');
    echo (' <div style="left: ' . $page_pos_4 . 'px; top: 104px; position: absolute; color: ' . $page_color_4 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_4 . '</div>');
    echo (' <div style="left: ' . $page_pos_5 . 'px; top: 104px; position: absolute; color: ' . $page_color_5 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_5 . '</div>');
    echo (' <div style="left: ' . $page_pos_6 . 'px; top: 104px; position: absolute; color: ' . $page_color_6 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_6 . '</div>');
    echo (' <div style="left: ' . $page_pos_7 . 'px; top: 104px; position: absolute; color: ' . $page_color_7 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_7 . '</div>');
    echo (' <div style="left: ' . $page_pos_8 . 'px; top: 104px; position: absolute; color: ' . $page_color_8 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_8 . '</div>');
    echo (' <div style="left: ' . $page_pos_9 . 'px; top: 104px; position: absolute; color: ' . $page_color_9 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_9 . '</div>');
    echo (' <div style="left: ' . $page_pos_10 . 'px; top: 104px; position: absolute; color: ' . $page_color_10 . '; font-size: 20px; font-family: Lato; font-weight: 700; word-wrap: break-word"> ' . $page_text_10 . '</div>');

    ?>



</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- your-script.js -->

<script>

  var set_time = 100;
  var time1_ms;
  var countdownInterval;
  var countdownStarted = false;
  var pageWithScriptLoaded = false;

  function saveCountdownState() {
    // Save the current set_time and the start time in session storage
    sessionStorage.setItem("countdown_set_time", set_time);
    sessionStorage.setItem("countdown_start_time", time1_ms);
    sessionStorage.setItem("countdown_started", countdownStarted);
    sessionStorage.setItem("page_with_script_loaded", pageWithScriptLoaded);
  }

  function loadCountdownState() {
    // Retrieve the set_time, the start time, countdown_started flag, and page_with_script_loaded flag from session storage
    var storedSetTime = sessionStorage.getItem("countdown_set_time");
    var storedStartTime = sessionStorage.getItem("countdown_start_time");
    var storedCountdownStarted = sessionStorage.getItem("countdown_started");
    var storedPageWithScriptLoaded = sessionStorage.getItem("page_with_script_loaded");

    if (storedSetTime !== null && storedStartTime !== null) {
      set_time = parseInt(storedSetTime);
      time1_ms = parseInt(storedStartTime);

      // If the countdown has already started (flag is true), don't reset the countdown
      countdownStarted = storedCountdownStarted === "true";

      // Set the pageWithScriptLoaded flag
      pageWithScriptLoaded = storedPageWithScriptLoaded === "true";
    }
  }

  function get_time_difference_in_seconds() {
  var start_time =      <?= $start_time ?>;
  var allocated_time =  <?= $allocated_time ?>;

  var cur_time = new Date().getTime();
  var time_difference_in_seconds = allocated_time - (parseInt(cur_time/1000) - parseInt(start_time));
  return time_difference_in_seconds;
}


  function handleCountdownFinish() {
    console.log("Countdown reached 0. Making AJAX request...");
    // Make an AJAX request to the absolute URL of the "welcome" function using fetch API
    fetch("/healthkiosk/home")
      .then((response) => {
        if (response.ok) {
          console.log(window.location.href);
          // If the response is successful, you can redirect to the current page
          window.location.href = "/healthkiosk/home";
        } else {
          console.log("AJAX request failed");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }

  $(document).ready(function () {
    loadCountdownState(); // Load the previous countdown state

    if (!countdownStarted) {
      // Start the countdown only if it hasn't started already
      countdownStarted = true;
      time1_ms = new Date().getTime();
      saveCountdownState();
    }

    // Check if this page has the script loaded
    var scriptTag = $("script[src$='your-script.js']");
    pageWithScriptLoaded = scriptTag.length > 0;

    // Restart the countdown if returning to the initial page without the script being loaded
    if (!pageWithScriptLoaded) {
      countdownStarted = false;
      set_time = 100; // Reset the countdown time to 100
      saveCountdownState();
    }

    var time_difference_in_seconds = get_time_difference_in_seconds();
    $("#time_difference").html(time_difference_in_seconds);

    countdownInterval = setInterval(function () {
      time_difference_in_seconds = get_time_difference_in_seconds();
      $("#time_difference").html(time_difference_in_seconds);

      if (time_difference_in_seconds <= 0) {
        clearInterval(countdownInterval);
        handleCountdownFinish();
        // No need to save countdown state here, as we will save it when the page is unloaded
      }

      time1_ms = new Date().getTime();
      set_time -= 1;
    }, 1000);
  });

  // Clear the countdown state when the user navigates away from the page
  $(window).on("beforeunload", function () {
    // Only clear the countdown state if the countdown has finished or hasn't started
    if (time_difference_in_seconds <= 0 || !countdownStarted) {
      sessionStorage.removeItem("countdown_set_time");
      sessionStorage.removeItem("countdown_start_time");
      sessionStorage.removeItem("countdown_started");
      sessionStorage.removeItem("page_with_script_loaded");
    }
  });
</script>





</html>