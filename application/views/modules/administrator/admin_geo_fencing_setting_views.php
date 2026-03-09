<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>
<style>
    .image {
        display: flex;
        flex-direction: column;
    }

    .image p {
        margin-left: 8px;
        font-size: 12px;
    }
</style>
<style>
    .switch {
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .switch input {
        display: none;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }

    input:checked+.slider:before {
        background-color: limegreen;
    }

    input:checked+.slider:before {
        transform: translateX(23px);
    }

    #map-canvas {
        height: 60vh;
    }

    @media (min-width: 960px) {
        #map-canvas {
           height: 40vh;
        }
    }
</style>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 style="font-size: 24px;" class="page-title"><a href="<?= base_url() . 'administrators/generalsettings'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Geo Fencing Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-12 d-flex justify-content-center row">
                    <div class="card col-12 col-lg-8">
                        <div class="card-header">
                            <div class="">
                                <div class="d-flex">
                                    <div class="">
                                        <label for="">Enable Geo Fencing</label>
                                    </div>
                                    <label class="switch ml-5">
                                        <input type="hidden" class="setting" name="geo_fencing" value="<?= $GEO_FENCING ?>">
                                        <input class="switch_on" name="geo_fencing" type="checkbox" <?= $GEO_FENCING == 1 ? 'checked' : '' ?>>
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                                <form action="<?= site_url('administrators/update_geo_fence') ?>" method="Post">

                                    <input type='hidden' name="geo_fencing_coordinates" id="geo_fencing_coordinates" value='<?= $GEO_FENCE_AREA ?>' />
                                    <div id="map-canvas" class="" style="width: 100%; height: 60vh;"></div>
                                    <div id="info" style="position:absolute; color:red; font-family: Arial; height:200px; font-size: 12px;"></div>
                                    <button class="btn btn-primary ml-auto d-block mt-3"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>
<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->userdata('SESS_UPDATE')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_UPDATE'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_UPDATE');
}
?>

<?php
if ($this->session->userdata('SESS_SUCC_UPDATE')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_SUCC_UPDATE'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDATE');
}
?>

<?php
if ($this->session->flashdata('SUCC')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php
}
?>

<?php
if ($this->session->flashdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
}
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCy_b_G7emL5aBoKkflJShoo_QEwO6afb8&libraries=drawing&loading=async"></script>
<script>
    $(document).ready(function() {

        var mapOptions;
        var map;

        var coordinates = []
        let new_coordinates = []
        let lastElement
        var poi_area = [];
        async function InitMap() {
            try {
                var location = await new google.maps.LatLng(14.652752, 121.100531)
                var fenced_area = new google.maps.Polygon({
                    path: [],
                    editable: true,
                    clickable: true,
                    draggable: true,
                    editable: true,
                    // fillColor: '#ffff00',
                    fillColor: '#ADFF2F',
                    fillOpacity: 0.5,
                });
                mapOptions = {
                    zoom: 12,
                    center: location,
                    mapTypeId: google.maps.MapTypeId.RoadMap
                }
                map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions)
                var drawingManager = new google.maps.drawing.DrawingManager({
                    //drawingMode: google.maps.drawing.OverlayType.MARKER,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: [
                            //google.maps.drawing.OverlayType.MARKER,
                            //google.maps.drawing.OverlayType.CIRCLE,
                            google.maps.drawing.OverlayType.POLYGON,
                            //google.maps.drawing.OverlayType.RECTANGLE
                        ]
                    },
                    markerOptions: {
                        //icon: 'images/beachflag.png'
                    },
                    circleOptions: {
                        fillColor: '#ffff00',
                        fillOpacity: 0.2,
                        strokeWeight: 3,
                        clickable: false,
                        editable: true,
                        zIndex: 1
                    },
                    polygonOptions: {
                        clickable: true,
                        draggable: true,
                        editable: true,
                        // fillColor: '#ffff00',
                        fillColor: '#ADFF2F',
                        fillOpacity: 0.5,

                    },
                    rectangleOptions: {
                        clickable: true,
                        draggable: true,
                        editable: true,
                        fillColor: '#ffff00',
                        fillOpacity: 0.5,
                    }
                });

                function clearSelection() {
                    if (selectedShape) {
                        selectedShape.setEditable(false);
                        selectedShape = null;
                    }
                }
                setFenceArea(map);

                function setFenceArea(map) {
                    let coordinates = '<?= $GEO_FENCE_AREA ?>';
                    if (coordinates != "" && coordinates != "[]") {
                        coordinates = JSON.parse(coordinates);
                    } else {
                        coordinates = [];
                    }
                    if (coordinates.length <= 0) {
                        return;
                    }
                    var path = [];
                    coordinates.forEach(function(poi) {
                        let paths = [];
                        poi.forEach(function(coor) {
                            let fence_coor = coor.split(',');
                            var latLng = {
                                lat: Number(fence_coor[0]),
                                lng: Number(fence_coor[1])
                            };
                            paths.push(latLng);
                        })
                        let fence_area = new google.maps.Polygon({
                            path: paths,
                            editable: true,
                            clickable: true,
                            draggable: true,
                            editable: true,
                            // fillColor: '#ffff00',
                            fillColor: '#ADFF2F',
                            fillOpacity: 0.5,
                        });
                        poi_area.push(fence_area);
                        fence_area.setMap(map);
                    })
                    // getPlaceOfInterest();
                }


                function deleteSelectedShape() {
                    poi_area.forEach(function(area) {
                        area.setMap(null);
                    });
                    poi_area = [];
                    getPlaceOfInterest();

                }

                function CenterControl(controlDiv, map) {

                    // Set CSS for the control border.
                    var controlUI = document.createElement('div');
                    controlUI.style.backgroundColor = '#fff';
                    controlUI.style.border = '2px solid #fff';
                    controlUI.style.borderRadius = '3px';
                    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
                    controlUI.style.cursor = 'pointer';
                    controlUI.style.marginBottom = '22px';
                    controlUI.style.textAlign = 'center';
                    controlUI.title = 'Select to delete the shape';
                    controlDiv.appendChild(controlUI);

                    // Set CSS for the control interior.
                    var controlText = document.createElement('div');
                    controlText.style.color = 'rgb(25,25,25)';
                    controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
                    controlText.style.fontSize = '16px';
                    controlText.style.lineHeight = '38px';
                    controlText.style.paddingLeft = '5px';
                    controlText.style.paddingRight = '5px';
                    controlText.innerHTML = 'Delete Selected Area';
                    controlUI.appendChild(controlText);

                    //to delete the polygon
                    controlUI.addEventListener('click', function() {
                        deleteSelectedShape();
                    });
                    add_event_poi();
                }

                drawingManager.setMap(map);
                var getPlaceOfInterest = function() {
                    let poi_area_data = [];
                    poi_area.forEach(function(area) {
                        poi_area_data.push(getPolygonCoords(area));
                    })
                    let poi_area_data_str = JSON.stringify(poi_area_data);
                    document.getElementById('geo_fencing_coordinates').value = poi_area_data_str;

                }
                var getPolygonCoords = function(newShape) {
                    let poi_coordinates = [];
                    var len = newShape.getPath().getLength();
                    for (var i = 0; i < len; i++) {
                        poi_coordinates.push(newShape.getPath().getAt(i).toUrlValue(6))
                    }
                    // let coordinate_string=JSON.stringify(coordinates);
                    // console.log(coordinate_string);
                    // document.getElementById('geo_fencing_coordinates').value=coordinate_string;
                    // document.getElementById('info').innerHTML = coordinates
                    return poi_coordinates;
                }

                var add_event_poi = function() {
                    poi_area.forEach(function(poi, poi_index) {
                        google.maps.event.addListener(poi.getPath(), 'set_at', function(index) {
                            poi_area[poi_index] = poi
                            getPlaceOfInterest();
                        });
                        google.maps.event.addListener(poi.getPath(), 'insert_at', function(index) {
                            poi_area[poi_index] = poi
                            getPlaceOfInterest();
                        });
                    })

                }

                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                    var newArea = event.overlay; // Get coordinates of the new polygon
                    // console.log(newArea);
                    poi_area.push(newArea);
                    add_event_poi();
                    getPlaceOfInterest();
                });


                var centerControlDiv = document.createElement('div');
                var centerControl = new CenterControl(centerControlDiv, map);


                centerControlDiv.index = 1;
                map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);
            } catch (error) {
                console.log(error)
            }
        }
        InitMap()
    })
</script>
<script>

</script>

<script>
    $(document).ready(function() {


    function setMapWidth() {
        var screenWidth = $(window).width();
        var mapWidth = screenWidth <= 960 ? 350 : 700;
        $('#map-canvas').css('width', mapWidth + 'px');
    }


    setMapWidth();

 
    $(window).resize(function() {
        setMapWidth();
    });

});
</script>