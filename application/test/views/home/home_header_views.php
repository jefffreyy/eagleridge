
<html>



<body style="overflow: hidden; height: 100%; width: 100%;" ontouchmove="BlockMove(event);">
  <div style="width: 1920px; height: 150px; position: absolute; background-color : #EEFBFF">
    <img style="width: 130px; height: 130px; left: 10px; top: 10px; position: absolute" src="https://via.placeholder.com/130x130" />
    <!-- <div style="width: 1440px; height: 0px; left: 215; top: 50px; position: absolute; border: 1px #DFDFDF solid"></div> -->

    
    
    <div style="width: 120px; height: 120px; left: 1780px; top:15px; position: absolute; padding-bottom:20px; border-radius: 9999px; border: 2.50px #A1DEFF solid">
  <div style="display: block; text-align: center; color: black; font-size: 48px; font-family: Lato; font-weight: 700; margin-top:10px;word-wrap: break-word" id ="time_difference"></div>
</div>
<div style="left:1805px; top:90px; position:absolute;display: block; text-align: center; color: black; font-size: 16px; font-family: Lato; font-weight: 400; word-wrap: break-word">Time Left</div>

    

    <div style="width: 1920px; height: 0px; left: 0px; top: 150px; position: absolute; border: 1px #A1DEFF solid"></div>

   


    <!-- <div style="width: 1000px; height: 91px; left: 460px; top: 31px; position: absolute; background: #E3E3E3; border-radius: 20px"></div>
    <div style="width: 480px; height: 62px; left: 720px; top: 42px; position: absolute; text-align: center; color: #070707; font-size: 48px; font-family: Lato; font-weight: 600; word-wrap: break-word">Account Selection</div>
    <div style="width: 1191px; height: 33px; left: 364px; top: 170px; position: absolute; text-align: center; color: #070707; font-size: 32px; font-family: Lato; font-weight: 400; word-wrap: break-word">Please select appropriate option</div>
    -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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



</body>

</html>