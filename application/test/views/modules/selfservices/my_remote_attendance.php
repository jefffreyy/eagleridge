
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
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
    h5 {
        font-size: 12px;
    }
</style>
<body>
    <div class="content-wrapper min-vh-100">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item">
                <a href="<?=base_url()?>selfservices">Self-Service</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Remote Attendance
                </li>
                </ol>
            </nav>
            <div class="flex-fill">
               
            <div class="row" >
                <div class="col-sm-12">
                    <div class="card p-0" style="margin-bottom: -2rem; z-index: 9; border-radius: 0px !important">
                        <div class="card-body text-center">
                            <h1 class="text-primary" id="time"></h1>
                            <?php 
                                if($SHIFT_NAME == 'N/A'){  ?> 
                                   <h5>Shift Today : Unassigned Shift</h5>
                                <?php } 
                                else if($SHIFT_NAME == 'Rest Day'){ ?>
                                    <h5>Shift Today : Rest Day</h5>
                                
                                
                                <?php }                                
                                else { ?>
                                    <h5>Shift Today : <?= $SHIFT_NAME ?></h5>
                                    
                                    <h5><?= $SHIFT_IN1 ?> - <?= $SHIFT_OUT1 ?></h5>
                                    <!-- <h5><?= $SHIFT_IN2 ?> - <?= $SHIFT_OUT2 ?></h5> -->
                            <?php
                                }
                            ?>
                        </div>

                        <?php if($SHIFT_NAME != 'N/A'){  ?> 
                            <?php   
                            if ($SHIFT_IN1_A == "N/A") {
                            ?>
                                <button class="btn btn-success mb-0 pt-2 pb-2" id="btn_time_in1" style=" border-radius: 0px !important" <?= ($DISP_EMPLOYEE_INFO[0]->remote_att == "0") ? "hidden" : "" ?>>Clock In 1</button>
                                <?php
                            }else {
                            ?>
                                <button class="btn mb-0 pt-2 pb-2" id="btn_time_in1" style=" border-radius: 0px !important;" disabled <?= ($DISP_EMPLOYEE_INFO[0]->remote_att == "0") ? "hidden" : "" ?>>Clock In 1 : <?= $SHIFT_IN1_A ?></button>
                                <?php
                            }
                            ?>
                            

                            <?php
                            if ($SHIFT_IN1_A == 'N/A' || $SHIFT_IN1_A == "00:00:00") {
                            }
                            else if ($SHIFT_IN1_A != 'N/A' && $SHIFT_IN1_A != "00:00:00" && $SHIFT_OUT1_A == "00:00:00") {
                            ?>
                                <button class="btn btn-danger mb-0 pt-2 pb-2" id="btn_time_out1" style=" border-radius: 0px !important" <?= ($DISP_EMPLOYEE_INFO[0]->remote_att == "0") ? "hidden" : "" ?>>Clock Out 1</button>
                            <?php
                            }else{
                            ?>
                                <button class="btn mb-0 pt-2 pb-2" id="btn_time_out1" style=" border-radius: 0px !important" disabled <?= ($DISP_EMPLOYEE_INFO[0]->remote_att == "0") ? "hidden" : "" ?>>Clock Out 1: <?= $SHIFT_OUT1_A ?></button>
                            <?php
                            }
                            ?>

                            <?php if($SHIFT_IN1_A != 'N/A' && $SHIFT_IN1_A != "00:00:00" && $SHIFT_OUT1_A != "00:00:00"){ ?>
                                <button <?= ($DISP_INOUT_TYPE <= '1')? '': 'hidden' ?> class="btn btn-danger mb-0 pt-2 pb-2" id="btn_time_out" style=" border-radius: 0px !important" <?= ($DISP_EMPLOYEE_INFO[0]->remote_att == "0") ? "hidden" : "" ?>>Clock Out</button>
                            <?php } ?>
                                

                            <?php
                            if ($SHIFT_OUT1_A == 'N/A' || $SHIFT_OUT1_A == "00:00:00") {
                            }
                            else if ($SHIFT_OUT1_A != 'N/A' && $SHIFT_OUT1_A != "00:00:00" && $SHIFT_IN2_A == "00:00:00") {
                            ?>
                                <button <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?> class="btn btn-success mb-0 pt-2 pb-2" id="btn_time_in2" style=" border-radius: 0px !important">Clock In 2</button>
                            <?php
                            }else{
                            ?>
                                <button <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?>  class="btn mb-0 pt-2 pb-2" id="btn_time_in2" style=" border-radius: 0px !important" disabled>Clock In 2: <?= $SHIFT_IN2_A ?></button>
                            <?php
                            }
                            ?>
                            

                            <?php
                            if ($SHIFT_IN2_A == 'N/A' || $SHIFT_IN2_A == "00:00:00") {
                            }
                            else if ($SHIFT_IN2_A != 'N/A' && $SHIFT_IN2_A != "00:00:00" && $SHIFT_OUT2_A == "00:00:00") {
                            ?>
                                <button <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?> class="btn btn-danger mb-0 pt-2 pb-2" id="btn_time_out2" style=" border-radius: 0px !important">Clock Out 2</button>
                            <?php
                            }else{
                            ?>
                                <button <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?> class="btn mb-0 pt-2 pb-2" id="btn_time_out2" style=" border-radius: 0px !important" disabled>Clock Out 2: <?= $SHIFT_OUT2_A ?></button>
                            <?php
                            }
                            ?>

                            <?php if($SHIFT_IN2_A != 'N/A' && $SHIFT_IN2_A != "00:00:00" && $SHIFT_OUT2_A != "00:00:00"){ ?>
                                <button <?= ($DISP_INOUT_TYPE <= '1')? 'hidden': '' ?> class="btn btn-danger mb-0 pt-2 pb-2" id="btn_time_out_2" style=" border-radius: 0px !important" <?= ($DISP_EMPLOYEE_INFO[0]->remote_att == "0") ? "hidden" : "" ?>>Clock Out</button>
                            <?php } ?>
                            
                               
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div id="map" style="height: 90vh;"></div>
            <!-- <div class="col-sm-12">
                <div class="card" style="z-index: 9;">
                    <div class="card-body text-center">
                    </div>
                </div>
            </div> -->
        </div>
        </div>
       
    </div>
    <form action="<?php echo base_url('selfservices/employee_time_in1'); ?>" id="form_time_in1" method="post" accept-charset="utf-8" autocomplete='off'>
        <input type="hidden" name="time_latitude" class="time_latitude">
        <input type="hidden" name="time_longitude" class="time_longitude">
        <input type="hidden" name="time_address" class="time_address">
    </form>
    <form action="<?php echo base_url('selfservices/employee_time_out1'); ?>" id="form_time_out1" method="post" accept-charset="utf-8" autocomplete='off'>
        <!-- get employee info and current date -->
        <input type="hidden" name="time_latitude" class="time_latitude">
        <input type="hidden" name="time_longitude" class="time_longitude">
        <input type="hidden" name="time_address" class="time_address">
    </form>
    <form action="<?php echo base_url('selfservices/employee_time_in2'); ?>" id="form_time_in2" method="post" accept-charset="utf-8" autocomplete='off'>
        <!-- get employee info and current date -->
        <input type="hidden" name="time_latitude" class="time_latitude">
        <input type="hidden" name="time_longitude" class="time_longitude">
        <input type="hidden" name="time_address" class="time_address">
    </form>
    <form action="<?php echo base_url('selfservices/employee_time_out2'); ?>" id="form_time_out2" method="post" accept-charset="utf-8" autocomplete='off'>
        <!-- get employee info and current date -->
        <input type="hidden" name="time_latitude" class="time_latitude">
        <input type="hidden" name="time_longitude" class="time_longitude">
        <input type="hidden" name="time_address" class="time_address">
    </form>
    <!-- =============== ATTENDANCE SUMMARY ================= -->
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <div id="sidebar-overlay"></div>
    <!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
    <?php $this->load->view('templates/jquery_link'); ?>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy_b_G7emL5aBoKkflJShoo_QEwO6afb8&callback=initMap"></script>
    <script>
        function initMap(lat, lng) {
            let myLatLng = {
                lat,
                lng
            };
            let map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14.5,
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
            // This is making the Geocode request
            
            let geocoder = new google.maps.Geocoder();
            
            geocoder.geocode({
                'latLng': latlng
            }, (results, status) => {
                console.log('test '+results[0].formatted_address);
                // This is checking to see if the Geoeode Status is OK before proceeding
                if (status == google.maps.GeocoderStatus.OK) {
                    let address = (results[0].formatted_address);
                    $("#address").text(address);
                    $(".time_address").val(address);
                    // $("#btn_time_in").removeAttr("disabled");
                    // $("#btn_time_out").removeAttr("disabled");
                }
            });
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
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
            function showPosition(position) {
                console.log('this is position = '+position.coords.latitude)
                initMap(position.coords.latitude, position.coords.longitude)
                getReverseGeocodingData(position.coords.latitude, position.coords.longitude)
                $('.time_latitude').val(position.coords.latitude);
                $('.time_longitude').val(position.coords.longitude);
            }
            function validateLatLng(lat, lng) {
                let pattern = new RegExp('^-?([1-8]?[1-9]|[1-9]0)\\.{1}\\d{1,6}');
                return pattern.test(lat) && pattern.test(lng);
            }
            // ========================================= TIME IN1 ========================================
            $('#btn_time_in1').click(function() {
                Swal.fire({
                    title: 'Do you want to time in?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28A745',
                    cancelButtonColor: '#DC3545',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form_time_in1').submit();
                    }
                })
            })
            // ========================================= TIME OUT1 ========================================
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
                        $('#form_time_out1').submit();
                    }
                })
            })

            // ========================================= TIME OUT1 ========================================
            $('#btn_time_out').click(function() {
                Swal.fire({
                    title: 'Do you want to time out?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28A745',
                    cancelButtonColor: '#DC3545',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form_time_out1').submit();
                    }
                })
            })



            // ========================================= TIME IN1 ========================================
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
                        $('#form_time_in2').submit();
                    }
                })
            })
              // ========================================= TIME OUT1 ========================================
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
                        $('#form_time_out2').submit();
                    }
                })
            })

             // ========================================= TIME OUT1 ========================================
             $('#btn_time_out_2').click(function() {
                Swal.fire({
                    title: 'Do you want to time out?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28A745',
                    cancelButtonColor: '#DC3545',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form_time_out2').submit();
                    }
                })
            })

            
            
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
</body>
</html>