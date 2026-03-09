<?php $this->load->view('templates/css_link'); ?>
<style>
    #map {
        width: 100%;
        height: 80vh;
        background-color: grey;
        z-index: 1;
    }

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    h5 {}
</style>

<body>
    <div class="content-wrapper min-vh-100">
        <div class="container-fluid p-4">
           

            <div class="flex-fill">
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>"> 
                                <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                            </a>&nbsp;My Remote Attendance
                        </h1>
                    </div>
                </div>
                <div class="row justify-content-md-center">
                    <div class="col-md-10 ">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card p-0" style="border-radius: 5px !important">
                                    <div class="card-body text-center">
                                        <h1 class="text-primary" id="time">
                                        <!-- <?php
                                            date_default_timezone_set('Asia/Hong_Kong');
                                            ?>
                                        <?php echo date('h:i A'); ?> -->
                                        </h1>
                                        <?php
                                        if ($SHIFT_NAME == 'N/A') {  ?>
                                            <h5>Shift Today : Unassigned Shift</h5>
                                        <?php } else if ($SHIFT_NAME == 'Rest Day') { ?>
                                            <h5>Shift Today : Rest Day</h5>
                                        <?php } else { ?>
                                            <h5>Shift Today : <?= $SHIFT_NAME ?></h5>
                                            <h5><?= $SHIFT_IN1 ?> - <?= $SHIFT_OUT1 ?></h5>
                                        <?php } ?>
                                    </div>


                                    <?php if ($DISP_EMPLOYEE_INFO[0]->remote_att != 0) {  ?>
                                    <?php if ($SHIFT_NAME) {  ?>
                                        <div class="row p-2">
                                            <div class="col-lg-6 col-md-12 p-1">
                                                <?php if (!$SHIFT_IN1_A) { ?>
                                                    <button class="btn btn-success btn-block btn-clock_stamp" id="btn_time_in1" style=" border-radius: 5px !important" disabled>Clock In</button>
                                                <?php } else { ?>
                                                    <button class="btn btn-secondary btn-block" id="" style=" border-radius: 5px !important;" disabled>Clock In : <?= $SHIFT_IN1_A ?></button>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-12 p-1">
                                                <?php if ((is_null($SHIFT_IN2_A) || !isset($SHIFT_IN2_A) || !$SHIFT_IN2_A)) { ?>
                                                    <?php if (!(is_null($SHIFT_IN1_A) || !isset($SHIFT_IN1_A) || !$SHIFT_IN1_A) && (is_null($SHIFT_OUT1_A) || !isset($SHIFT_OUT1_A) || !$SHIFT_OUT1_A)) { ?>
                                                        <button class="btn btn-success btn-block btn-clock_stamp" id="btn_time_in2" style=" border-radius: 5px !important" disabled>Break In</button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-secondary btn-block" id="" style=" border-radius: 5px !important;" disabled>Break In</button>
                                                        <?php } ?>
                                                <?php } else { ?>
                                                    <button class="btn btn-secondary btn-block" id="" style=" border-radius: 5px !important;" disabled>Break In : <?= $SHIFT_IN2_A ?></button>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-12 p-1">
                                                <?php if ((is_null($SHIFT_OUT2_A) || !isset($SHIFT_OUT2_A) || !$SHIFT_OUT2_A)) { ?>
                                                    <?php if (!(is_null($SHIFT_IN2_A) || !isset($SHIFT_IN2_A) || !$SHIFT_IN2_A) && (is_null($SHIFT_OUT1_A) || !isset($SHIFT_OUT1_A) || !$SHIFT_OUT1_A)) { ?>
                                                        <button class="btn btn-success btn-block btn-clock_stamp" id="btn_time_out2" style=" border-radius: 5px !important" disabled>Break Out</button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-secondary btn-block" id="" style=" border-radius: 5px !important;" disabled>Break Out</button>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <button class="btn btn-secondary btn-block" id="" style=" border-radius: 5px !important;" disabled>Break Out : <?= $SHIFT_OUT2_A ?></button>
                                                <?php } ?>
                                            </div>
                                            <div class="col-lg-6 col-md-12 p-1">
                                                <?php if ((is_null($SHIFT_OUT1_A) || !isset($SHIFT_OUT1_A) || !$SHIFT_OUT1_A)) { ?>
                                                    <?php if (!(is_null($SHIFT_IN1_A) || !isset($SHIFT_IN1_A) || !$SHIFT_IN1_A)) { ?>
                                                        <button class="btn btn-success btn-block btn-clock_stamp" id="btn_time_out1" style=" border-radius: 5px !important" disabled>Clock Out</button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-secondary btn-block" id="" style=" border-radius: 5px !important;" disabled>Clock Out</button>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <button class="btn btn-secondary btn-block" id="" style=" border-radius: 5px !important;" disabled>Clock Out : <?= $SHIFT_OUT1_A ?></button>
                                                <?php } ?>
                                            </div>
                                        </div>


                                    <?php } ?>
                                <?php } ?>
                                </div>
                            
                             
                                <div class="card p-0" style="border-radius: 5px !important">
                                <center>
                                    <?php if (!empty($remoteCamera) && $remoteCamera == 1) { ?>
                                     
                                                <video id="webCam" autoplay playsinline width = "400px"></video>
                                                <canvas id="canvas" style="display: none;"></canvas>
      
                                      
                                    <?php } ?>
                                    </center> 
                                </div>

                                               
                                
                            </div>
                            <!-- <div class="col-md-4">
                                
                            </div>        -->
                            <div class="col-md-6">
                                <?php if (!empty($remoteGPS) && $remoteGPS == 1) { ?>
                                    <div id="map" style="height: 67vh;"></div>
                                    <p class="mt-3 text-bold"><span id="current_location"></span></p>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <form action="<?php echo base_url('selfservices/employee_time_in1'); ?>" enctype="multipart/form-data" id="form_time_in1" method="post" accept-charset="utf-8" autocomplete='off'>
        <?php if (!empty($remoteGPS) && $remoteGPS == 1) { ?>
            <input type="hidden" name="time_latitude" class="time_latitude">
            <input type="hidden" name="time_longitude" class="time_longitude">
        <?php } ?>
        <input type="hidden" name="time_address" class="time_address">
        <?php if (!empty($remoteCamera) && $remoteCamera == 1) { ?>
            <input type="hidden" name="image" id="image_input">
        <?php } ?>
    </form>
    <form action="<?php echo base_url('selfservices/employee_time_out1'); ?>" id="form_time_out1" method="post" accept-charset="utf-8" autocomplete='off'>
        <?php if (!empty($remoteGPS) && $remoteGPS == 1) { ?>
            <input type="hidden" name="time_latitude" class="time_latitude">
            <input type="hidden" name="time_longitude" class="time_longitude">
        <?php } ?>
        <input type="hidden" name="time_address" class="time_address">
        <?php if (!empty($remoteCamera) && $remoteCamera == 1) { ?>
            <input type="hidden" name="image_out" id="image_input_out">
        <?php } ?>
    </form>
    <form action="<?php echo base_url('selfservices/employee_time_in2'); ?>" id="form_time_in2" method="post" enctype="multipart/form-data" accept-charset="utf-8" autocomplete='off'>
       <?php if (!empty($remoteGPS) && $remoteGPS == 1) { ?>
            <input type="hidden" name="time_latitude" class="time_latitude">
            <input type="hidden" name="time_longitude" class="time_longitude">
        <?php } ?>
        <input type="hidden" name="time_address" class="time_address">
        <?php if (!empty($remoteCamera) && $remoteCamera == 1) { ?>
            <input type="hidden" name="image" id="break_in_image_input">
        <?php } ?>
    </form>
    <form action="<?php echo base_url('selfservices/employee_time_out2'); ?>" id="form_time_out2" method="post" accept-charset="utf-8" autocomplete='off'>
        <?php if (!empty($remoteGPS) && $remoteGPS == 1) { ?>
            <input type="hidden" name="time_latitude" class="time_latitude">
            <input type="hidden" name="time_longitude" class="time_longitude">
        <?php } ?>
        <input type="hidden" name="time_address" class="time_address">
        <?php if (!empty($remoteCamera) && $remoteCamera == 1) { ?>
            <input type="hidden" name="image" id="break_out_image_input"> 
        <?php } ?>
    </form>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <div id="sidebar-overlay"></div>
    <?php $this->load->view('templates/jquery_link'); ?>

    <script>
        // var parsedData = <?php echo $data; ?>;
        // console.log('parsedData', parsedData)
    </script>

    <?php if ($this->session->flashdata('SUCC')) { ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('SUCC'); ?>'
            })
        </script>
    <?php } ?>
    <?php if ($this->session->flashdata('ERR')) { ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('ERR'); ?>'
            })
        </script>
    <?php } ?>

    <?php if (!empty($remoteGPS) && $remoteGPS == 1) { ?>
        <!-- <script>console.log('remoteGPS true url maps')</script> -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy_b_G7emL5aBoKkflJShoo_QEwO6afb8&libraries=geometry&loading=async"></script>
    <?php } ?>
    <script>
        $(document).ready(function(){
            $('.btn-clock_stamp').prop('disabled',false)
        })
    </script>
    <script>
        function checkValidPicture(base64String) {
            return new Promise((resolve, reject) => {
                var img = new Image();
                img.onload = function() {
                    resolve(true);
                };
                img.onerror = function() {
                    resolve(false); 
                };
                img.src = 'data:image/png;base64,' + base64String;
            });
        }
        function validateForm() {
            var latitude = document.getElementsByName('time_latitude')[0].value;
            var longitude = document.getElementsByName('time_longitude')[0].value;
            var latPattern = /^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/;
            var lonPattern = /^[-+]?([1-9]?\d(\.\d+)?|1[0-7]\d(\.\d+)?|180(\.0+)?)$/;

            if (!latPattern.test(latitude) || !lonPattern.test(longitude)) {
                alert("Invalid GPS Location. Enable GPS, refresh the page and try again");
                return false;
            }
            return true;
        }
    </script>
    <script>
        $(document).ready(function(){
        (function (){
            var remoteGPS           = <?php echo $remoteGPS ?>;
            var remoteCamera        = <?php echo $remoteCamera ?>;
            var current_location    = null;
            var fences_areas        = <?=json_encode($FENCES_AREAS)?>;
            var is_geo_fencing      = <?= $geo_fencing?>;
            let webCamElement;
            let canvasElement;
            let webcam;
            if (remoteCamera == 1) {
                webCamElement = document.getElementById("webCam");
                canvasElement = document.getElementById("canvas");
                webcam = new Webcam(webCamElement, "user", canvasElement);
                webcam.start();
            }


            // function takeAPicture() {
            //     let picture = webcam.snap();

            // }

            // console.log(JSON.parse(fences_areas[0]));
            // console.log('remoteGPS',remoteGPS)
            if (remoteGPS == 1) {
                // console.log('gps true')
                function initMap(lat, lng) {
                    let myLatLng = {
                        lat,
                        lng
                    };
                    let map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 17,
                        center: myLatLng,
                        mapTypeControl: false,
                        draggable: false,
                        scaleControl: false,
                        scrollwheel: false,
                        navigationControl: false,
                        streetViewControl: false,
                        disableDefaultUI: true,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        styles: [{
                                "featureType": "administrative",
                                "elementType": "geometry",
                                "stylers": [{
                                    "visibility": "off"
                                }]
                            },
                            {
                                "featureType": "poi",
                                "stylers": [{
                                    "visibility": "off"
                                }]
                            },
                            {
                                "featureType": "road",
                                "elementType": "labels.icon",
                                "stylers": [{
                                    "visibility": "off"
                                }]
                            },
                            {
                                "featureType": "transit",
                                "stylers": [{
                                    "visibility": "off"
                                }]
                            }
                        ]
                    });
                    let marker = new google.maps.Marker({
                        position: myLatLng,
                        map: map,
                    });
                }

                function getReverseGeocodingData(lat, lng) {
                    let latlng = new google.maps.LatLng(lat, lng);

                    let geocoder = new google.maps.Geocoder();
                    geocoder.geocode({
                        'latLng': latlng
                    }, (results, status) => {
                        console.log('test ' + results[0].formatted_address);
                        // Current Location
                        $('#current_location').text('Location : '+ results[0].formatted_address);
                        if (status == google.maps.GeocoderStatus.OK) {
                            let address = (results[0].formatted_address);
                            $("#address").text(address);
                            $(".time_address").val(address);

                        }
                    });
                }
            }

            $(document).ready(function() {
                function refreshTime() {
                    const dateString = new Date();
                    let newTime = dateString.toLocaleTimeString([], {
                        timeStyle: 'short'
                    });
                    $("#time").text(newTime)
                }
                setInterval(refreshTime, 1000);
                if (remoteGPS == 1) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(showPosition);
                    }

                    function showPosition(position) {
                        console.log('this is position = ' + position.coords.latitude)
                        current_location=[position.coords.latitude,position.coords.longitude]
                        initMap(position.coords.latitude, position.coords.longitude)
                        getReverseGeocodingData(position.coords.latitude, position.coords.longitude)
                        $('.time_latitude').val(position.coords.latitude);
                        $('.time_longitude').val(position.coords.longitude);
                    }

                    function validateLatLng(lat, lng) {
                        let pattern = new RegExp('^-?([1-8]?[1-9]|[1-9]0)\\.{1}\\d{1,6}');
                        return pattern.test(lat) && pattern.test(lng);
                    }
                }
                function check_fence_area(area){
                    // Define the polygon coordinates
                    var polygonCoords = [...area];
                    // Create a new polygon object
                    var polygon = new google.maps.Polygon({
                        paths: polygonCoords
                    });

                    // Define the point to check
                    console.log(current_location);
                    var pointToCheck = new google.maps.LatLng(current_location[0],current_location[1]);

                    // Check if the point is within the polygon
                    var isWithinPolygon = google.maps.geometry.poly.containsLocation(pointToCheck, polygon);

                    return isWithinPolygon;
                }
                $('#btn_time_in1').click(function() {
                    Swal.fire({
                        title: 'Do you want to time in?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28A745',
                        cancelButtonColor: '#DC3545',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        let processContinue = true;
                        if (result.isConfirmed) {

                            function processGPS() {
                                if (remoteGPS == 1) {
                                    if (is_geo_fencing == 1) {
                                        if (validateForm()) {
                                            let is_within_area = false;
                                            for (let i = 0; i < fences_areas.length; i++) {
                                                let paths_arr = JSON.parse(fences_areas[i]);
                                                let area_path = [];
                                                paths_arr.forEach(function (coor) {
                                                    let coor_arr = coor.split(',');
                                                    area_path.push({
                                                        lat: Number(coor_arr[0]),
                                                        lng: Number(coor_arr[1])
                                                    });
                                                });
                                                is_within_area = check_fence_area(area_path);
                                                if (is_within_area) {
                                                    break;
                                                }
                                            }
                                            if (is_within_area) {
                                                $('#form_time_in1').submit();
                                            } else {
                                                alert("You're currently not in a valid area.");
                                            }
                                        }

                                    } else {
                                        if (validateForm()) {
                                            $('#form_time_in1').submit();
                                        }
                                    }
                                } else {
                                    $('#form_time_in1').submit();
                                }
                            }
                            if (remoteCamera == 1) {
                                let picture = webcam.snap();
                                document.getElementById('image_input').value = picture;
                                async function processCameraInput() {
                                    let picture = webcam.snap();
                                    console.log('picture', picture);
                                    if (
                                        // await checkValidPicture(picture)
                                        picture
                                        ) {
                                        document.getElementById('image_input').value = picture;
                                        processGPS();
                                    } else {
                                        alert("Invalid Camera Input. Enable camera, refresh the page and try again");
                                    }
                                }
                                processCameraInput();
                            }else{
                                processGPS();
                            }
                        }
                    })
                })
                $('#btn_time_out1').click(function() {
                    Swal.fire({
                        title: 'Do you want to time out?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28A745',
                        cancelButtonColor: '#DC3545',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            function processGPS() {
                                if (remoteGPS == 1) {
                                    if (is_geo_fencing == 1) {
                                        if (validateForm()) {
                                            let is_within_area = false;
                                            for (let i = 0; i < fences_areas.length; i++) {
                                                let paths_arr = JSON.parse(fences_areas[i]);
                                                let area_path = [];
                                                paths_arr.forEach(function (coor) {
                                                    let coor_arr = coor.split(',');
                                                    area_path.push({
                                                        lat: Number(coor_arr[0]),
                                                        lng: Number(coor_arr[1])
                                                    });
                                                });
                                                is_within_area = check_fence_area(area_path);
                                                if (is_within_area) {
                                                    break;
                                                }
                                            }
                                            if (is_within_area) {
                                                $('#form_time_out1').submit();
                                            } else {
                                                alert("You're currently not in a valid area.");
                                            }
                                        }
                                    } else {
                                        // console.log('gps enabled, fencing off', validateForm())
                                        if (validateForm()) {
                                            $('#form_time_out1').submit();
                                        }
                                        // $('#form_time_in1').submit();
                                    }
                                } else {
                                    $('#form_time_out1').submit();
                                }
                            }
                            if (remoteCamera == 1) {
                                let picture = webcam.snap();
                                async function processCameraInput() {
                                    let picture = webcam.snap();
                                    if (
                                        // await checkValidPicture(picture)
                                        picture
                                        ) {
                                        document.getElementById('image_input_out').value = picture;
                                        processGPS();
                                    } else {
                                        alert("Invalid Camera Input. Enable camera, refresh the page and try again");
                                    }
                                }
                                processCameraInput();
                            }else{
                                processGPS();
                            }
                        }
                    })
                })

                $('#btn_time_in2').click(function() {
                    Swal.fire({
                        title: 'Do you want to time in?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28A745',
                        cancelButtonColor: '#DC3545',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            function processGPS() {
                                if (remoteGPS == 1) {
                                    if (is_geo_fencing == 1) {
                                        if (validateForm()) {
                                            let is_within_area = false;
                                            for (let i = 0; i < fences_areas.length; i++) {
                                                let paths_arr = JSON.parse(fences_areas[i]);
                                                let area_path = [];
                                                paths_arr.forEach(function (coor) {
                                                    let coor_arr = coor.split(',');
                                                    area_path.push({
                                                        lat: Number(coor_arr[0]),
                                                        lng: Number(coor_arr[1])
                                                    });
                                                });
                                                is_within_area = check_fence_area(area_path);
                                                if (is_within_area) {
                                                    break;
                                                }
                                            }
                                            if (is_within_area) {
                                                $('#form_time_in2').submit();
                                            } else {
                                                alert("You're currently not in a valid area.");
                                            }
                                        }

                                    } else {
                                        if (validateForm()) {
                                            $('#form_time_in2').submit();
                                        }
                                    }
                                } else {
                                    $('#form_time_in2').submit();
                                }
                            }
                            if (remoteCamera == 1) {
                                let picture = webcam.snap();
                                async function processCameraInput() {
                                    let picture = webcam.snap();
                                    if (
                                        // await checkValidPicture(picture)
                                        picture
                                        ) {
                                        document.getElementById('break_in_image_input').value = picture;
                                        processGPS();
                                    } else {
                                        alert("Invalid Camera Input. Enable camera, refresh the page and try again");
                                    }
                                }
                                processCameraInput();
                            }else{
                                processGPS();
                            }
                        }
                    })
                })
                $('#btn_time_out2').click(function() {
                    Swal.fire({
                        title: 'Do you want to time out?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28A745',
                        cancelButtonColor: '#DC3545',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            function processGPS() {
                                if (remoteGPS == 1) {
                                    if (is_geo_fencing == 1) {
                                        if (validateForm()) {
                                            let is_within_area = false;
                                            for (let i = 0; i < fences_areas.length; i++) {
                                                let paths_arr = JSON.parse(fences_areas[i]);
                                                let area_path = [];
                                                paths_arr.forEach(function (coor) {
                                                    let coor_arr = coor.split(',');
                                                    area_path.push({
                                                        lat: Number(coor_arr[0]),
                                                        lng: Number(coor_arr[1])
                                                    });
                                                });
                                                is_within_area = check_fence_area(area_path);
                                                if (is_within_area) {
                                                    break;
                                                }
                                            }
                                            if (is_within_area) {
                                                $('#form_time_out2').submit();
                                            } else {
                                                alert("You're currently not in a valid area.");
                                            }
                                        }

                                    } else {
                                        if (validateForm()) {
                                            $('#form_time_out2').submit();
                                        }
                                    }
                                } else {
                                    $('#form_time_out2').submit();
                                }
                            }
                            if (remoteCamera == 1) {
                                let picture = webcam.snap();
                                async function processCameraInput() {
                                    let picture = webcam.snap();
                                    if (
                                        // await checkValidPicture(picture)
                                        picture
                                        ) {
                                        document.getElementById('break_out_image_input').value = picture;
                                        processGPS();
                                    } else {
                                        alert("Invalid Camera Input. Enable camera, refresh the page and try again");
                                    }
                                }
                                processCameraInput();
                            }else{
                                processGPS();
                            }
                        }
                    })
                })
            })
        })(jQuery);

        })
    </script>

    <?php
    if ($this->session->userdata('session_error_time_in')) {
    ?>
        <script>
            Swal.fire(
                'Oops',
                '<?php echo $this->session->userdata('session_error_time_in'); ?>',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('session_error_time_in');
    }
    ?>
    <?php
    if ($this->session->userdata('session_success_time_in')) {
    ?>
        <script>
            Swal.fire(
                'Success',
                '<?php echo $this->session->userdata('session_success_time_in'); ?>',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('session_success_time_in');
    }
    ?>
    <?php
    if ($this->session->userdata('session_success_time_out')) {
    ?>
        <script>
            Swal.fire(
                'Success',
                '<?php echo $this->session->userdata('session_success_time_out'); ?>',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('session_success_time_out');
    }
    ?>
    <?php
    if ($this->session->userdata('session_error_time_out')) {
    ?>
        <script>
            Swal.fire(
                'Oops!',
                '<?php echo $this->session->userdata('session_error_time_out'); ?>',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('session_error_time_out');
    }
    ?>



    <?php
    if ($this->session->userdata('succ_time_in1')) {
    ?>
        <script>
            Swal.fire(
                'Success',
                '<?php echo $this->session->userdata('succ_time_in1'); ?>',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('succ_time_in1');
    }
    ?>
    <?php
    if ($this->session->userdata('succ_time_out1')) {
    ?>
        <script>
            Swal.fire(
                'Success',
                '<?php echo $this->session->userdata('succ_time_out1'); ?>',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('succ_time_out1');
    }
    ?>

    <?php
    if ($this->session->userdata('succ_time_in2')) {
    ?>
        <script>
            Swal.fire(
                'Success',
                '<?php echo $this->session->userdata('succ_time_in2'); ?>',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('succ_time_in2');
    }
    ?>
    <?php
    if ($this->session->userdata('succ_time_out2')) {
    ?>
        <script>
            Swal.fire(
                'Success',
                '<?php echo $this->session->userdata('succ_time_out2'); ?>',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('succ_time_out2');
    }
    ?>

    <?php
    if ($this->session->userdata('error_time_in')) {
    ?>
        <script>
            Swal.fire(
                'Warning!',
                '<?php echo $this->session->userdata('error_time_in'); ?>',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('error_time_in');
    }
    ?>

    <?php
    if ($this->session->userdata('error_time_out')) {
    ?>
        <script>
            Swal.fire(
                'Warning!',
                '<?php echo $this->session->userdata('error_time_out'); ?>',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('error_time_out');
    }
    ?>

    <?php if (!empty($remoteCamera) && $remoteCamera == 1) { ?>
        <!-- <script>console.log('remoteCamera scripts true')</script> -->

        <script>

            class Webcam {
                constructor(webcamElement, facingMode = 'user', canvasElement = null, snapSoundElement = null) {
                    this._webcamElement = webcamElement;
                    this._webcamElement.width = this._webcamElement.width || 640;
                    this._webcamElement.height = this._webcamElement.height || 360;
                    this._facingMode = facingMode;
                    this._webcamList = [];
                    this._streamList = [];
                    this._selectedDeviceId = '';
                    this._canvasElement = canvasElement;
                    this._snapSoundElement = snapSoundElement;
                }

                get facingMode() {
                    return this._facingMode;
                }

                set facingMode(value) {
                    this._facingMode = value;
                }

                get webcamList() {
                    return this._webcamList;
                }

                get webcamCount() {
                    return this._webcamList.length;
                }

                get selectedDeviceId() {
                    return this._selectedDeviceId;
                }

                /* Get all video input devices info */
                getVideoInputs(mediaDevices) {
                    this._webcamList = [];
                    mediaDevices.forEach(mediaDevice => {
                        if (mediaDevice.kind === 'videoinput') {
                            this._webcamList.push(mediaDevice);
                        }
                    });
                    if (this._webcamList.length == 1) {
                        this._facingMode = 'user';
                    }
                    return this._webcamList;
                }

                /* Get media constraints */
                getMediaConstraints() {
                    var videoConstraints = {};
                    if (this._selectedDeviceId == '') {
                        videoConstraints.facingMode = this._facingMode;
                    } else {
                        videoConstraints.deviceId = {
                            exact: this._selectedDeviceId
                        };
                    }
                    videoConstraints.width = {
                        exact: this._webcamElement.width
                    };
                    videoConstraints.height = {
                        exact: this._webcamElement.height
                    };
                    var constraints = {
                        video: videoConstraints,
                        audio: false
                    };
                    return constraints;
                }

                /* Select camera based on facingMode */
                selectCamera() {
                    for (let webcam of this._webcamList) {
                        if ((this._facingMode == 'user' && webcam.label.toLowerCase().includes('front')) ||
                            (this._facingMode == 'enviroment' && webcam.label.toLowerCase().includes('back'))
                        ) {
                            this._selectedDeviceId = webcam.deviceId;
                            break;
                        }
                    }
                }

                /* Change Facing mode and selected camera */
                flip() {
                    this._facingMode = (this._facingMode == 'user') ? 'enviroment' : 'user';
                    this._webcamElement.style.transform = "";
                    this.selectCamera();
                }

                /*
                    1. Get permission from user
                    2. Get all video input devices info
                    3. Select camera based on facingMode 
                    4. Start stream
                */
                async start(startStream = true) {
                    return new Promise((resolve, reject) => {
                        this.stop();
                        navigator.mediaDevices.getUserMedia(this.getMediaConstraints()) //get permisson from user
                            .then(stream => {
                                this._streamList.push(stream);
                                this.info() //get all video input devices info
                                    .then(webcams => {
                                        this.selectCamera(); //select camera based on facingMode
                                        if (startStream) {
                                            this.stream()
                                                .then(facingMode => {
                                                    resolve(this._facingMode);
                                                })
                                                .catch(error => {
                                                    reject(error);
                                                });
                                        } else {
                                            resolve(this._selectedDeviceId);
                                        }
                                    })
                                    .catch(error => {
                                        reject(error);
                                    });
                            })
                            .catch(error => {
                                reject(error);
                            });
                    });
                }

                /* Get all video input devices info */
                async info() {
                    return new Promise((resolve, reject) => {
                        navigator.mediaDevices.enumerateDevices()
                            .then(devices => {
                                this.getVideoInputs(devices);
                                resolve(this._webcamList);
                            })
                            .catch(error => {
                                reject(error);
                            });
                    });
                }

                /* Start streaming webcam to video element */
                async stream() {
                    return new Promise((resolve, reject) => {
                        navigator.mediaDevices.getUserMedia(this.getMediaConstraints())
                            .then(stream => {
                                this._streamList.push(stream);
                                this._webcamElement.srcObject = stream;
                                if (this._facingMode == 'user') {
                                    this._webcamElement.style.transform = "scale(-1,1)";
                                }
                                this._webcamElement.play();
                                resolve(this._facingMode);
                            })
                            .catch(error => {
                                console.log(error);
                                reject(error);
                            });
                    });
                }

                /* Stop streaming webcam */
                stop() {
                    this._streamList.forEach(stream => {
                        stream.getTracks().forEach(track => {
                            track.stop();
                        });
                    });
                }

                snap() {
                    if (this._canvasElement != null) {
                        if (this._snapSoundElement != null) {
                            this._snapSoundElement.play();
                        }
                        this._canvasElement.height = this._webcamElement.scrollHeight;
                        this._canvasElement.width = this._webcamElement.scrollWidth;
                        let context = this._canvasElement.getContext('2d');
                        if (this._facingMode == 'user') {
                            context.translate(this._canvasElement.width, 0);
                            context.scale(-1, 1);
                        }
                        context.clearRect(0, 0, this._canvasElement.width, this._canvasElement.height);
                        context.drawImage(this._webcamElement, 0, 0, this._canvasElement.width, this._canvasElement.height);
                        let data = this._canvasElement.toDataURL('image/png');
                        return data;
                    } else {
                        throw "canvas element is missing";
                    }
                }
            }
        </script>

        <script>
            $(document).ready(function(){
                
            })
        </script>
    <?php } ?>


</body>

</html>