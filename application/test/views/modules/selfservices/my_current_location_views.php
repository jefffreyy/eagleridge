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

    #address{
        font-size: 18px;
        color: #0c9435;
    }
</style>

<body>
    <div class="content-wrapper min-vh-100">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>selfservices/my_time_records">My Time Record</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">My Time <?= $in_out ?> Address
                    </li>
                </ol>
            </nav>
            <div class="row pt-1">
                <div class="col-md-6">
                    <h1 class="page-title">My Time <?= $in_out ?> Address<h1>
                </div>
            </div>
            <hr>

            <div class="flex-fill">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card p-0" style=" border-radius: 0px !important">
                            <div class="card-body text-center">
                                <div id="address"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map" style="height: 90vh;"></div>
            </div>
        </div>

    </div>

    <input type="hidden" id="time_latitude" value="<?= $lat_loc ?>">
    <input type="hidden" id="time_longitude" value="<?= $long_loc ?>">

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
                console.log('test ' + results[0].formatted_address);
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
            // function refreshTime() {
            //     const dateString = new Date();
            //     let newTime = dateString.toLocaleTimeString([], {
            //         timeStyle: 'short'
            //     });
            //     $("#time").text(newTime)
            // }
            // setInterval(refreshTime, 1000);
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }

            function showPosition(position) {
                let time_latitude = document.getElementById('time_latitude').value;
                let time_longitude = document.getElementById('time_longitude').value;

                // initMap(position.coords.latitude, position.coords.longitude)
                // getReverseGeocodingData(position.coords.latitude, position.coords.longitude)

                initMap(Number(time_latitude), Number(time_longitude))
                getReverseGeocodingData(time_latitude, time_longitude)

                $('.time_latitude').val(position.coords.latitude);
                $('.time_longitude').val(position.coords.longitude);
            }

            // function validateLatLng(lat, lng) {
            //     let pattern = new RegExp('^-?([1-8]?[1-9]|[1-9]0)\\.{1}\\d{1,6}');
            //     return pattern.test(lat) && pattern.test(lng);
            // }


        })
    </script>
</body>

</html>