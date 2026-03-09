<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />
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
</style>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 class="page-title"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Attendance Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Navigate Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="general">
                            General
                        </option>
                        <option value="holidays">
                            Holidays
                        </option>
                        <option value="years">
                            Years
                        </option>

                        <option value="biometrics">
                            Biometrics
                        </option>
                        <option value="remote_in_out">
                            Remote In Out
                        </option>
                        <option value="geofences" selected>
                            Geofences
                        </option>

                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_time_and_attendance_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12 d-flex">
                                    <span style="font-weight: 500; font-size: 18px">Geo Fencing</span>

                                </div>

                                <div class="col-md-12">

                                </div>
                            </div>
                            <hr>
                            <form action="<?=site_url('attendances/update_setting_geo_fence')?>" method="post" id="form_geo_fence">
                                <div class="d-flex">
                                    <label class="" for="">Enable Geo Fence</label>
                                    <div class="">
                                        <label class="switch ml-3">
                                            <input  type="hidden" class="setting" name="geo_fencing" value="<?=$geo_fencing['value']?>">
                                            <input  class="switch_on" <?=$geo_fencing['value'] == 1 ? 'checked': ''?> id="enable_geo_fence"  type="checkbox"  >
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </form>
                            <div class="col-12 justify-content-center mt-3">
                                <button class="btn btn-success btn-sm btn-lg-md mb-2" data-toggle="modal" data-target="#addGeoFence">Add</button>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($TABLE_DATA) { ?>
                                                <?php foreach ($TABLE_DATA as $row_data) { ?>
                                                    <tr>
                                                        <td><?= $row_data->name ?></td>
                                                        <td class="text-center">
                                                            <button class="btn btn-sm btn-primary" data-fence_name="<?= $row_data->name ?>" data-fence_id="<?= $row_data->id ?>" data-toggle="modal" data-target="#editGeoFence" data-area='<?= $row_data->area ?>'>View</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td col-span='5'>No records</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade " id="addGeoFence" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addGeoFenceLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="height:85%">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h5 class="modal-title" id="addGeoFenceLabel">Add new Fence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body position-relative">
                <div>
                    <form action="<?= site_url('attendances/add_new_fence') ?>" id="fence_form_add" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" required name="name" class="form-control" value="">
                        </div>
                        <input type="hidden" required name="area" id="fence_area" />
                    </form>
                </div>
                <div id="map-canvas" class="h-75 w-100"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_form_add">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade " id="editGeoFence" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editGeoFenceLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="height:85%">
        <div class="modal-content h-100">
            <div class="modal-header">
                <h5 class="modal-title" id="editGeoFenceLabel">Edit Fence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body position-relative">
                <div>
                    <form action="<?= site_url('attendances/update_fence') ?>" id="fence_form_edit" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" required name="name" id="edit_fence_name" class="form-control" value="">
                        </div>
                        <input type="hidden" name="id" value="" id="fence_id">
                        <input type="hidden" required name="area" id="edit_fence_area" />
                    </form>
                </div>
                <div id="edit_map-canvas" class="h-75 w-100"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn_form_edit">Submit</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('templates/jquery_link'); ?>
<script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>

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
        var fence_area = null;
        async function InitMap(x = 14.652752, y = 121.100531, map_id = 'map-canvas', paths = []) {
            try {
                var location = await new google.maps.LatLng(x, y)
                fence_area = new google.maps.Polygon({
                    path: paths,
                    editable: true,
                    clickable: true,
                    draggable: true,
                    editable: true,
                    // fillColor: '#ffff00',
                    fillColor: '#ADFF2F',
                    fillOpacity: 0.5,
                });
                mapOptions = {
                    zoom: 10,
                    center: location,
                    mapTypeId: google.maps.MapTypeId.RoadMap
                }
                map = new google.maps.Map(document.getElementById(map_id), mapOptions)
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
                drawingManager.setMap(map);
                if (paths.length > 0) {
                    fence_area.setMap(map);
                    drawingManager.setMap(null);
                }

                function clearSelection() {
                    if (selectedShape) {
                        selectedShape.setEditable(false);
                        selectedShape = null;
                    }
                }
                // setFenceArea(map,paths);
                function setFenceArea(map) {
                    let coordinates = '[]';
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
                    drawingManager.setMap(map);
                    if (fence_area != []) {
                        fence_area.setPath([]);
                        getPolygonCoords(fence_area);
                    }

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
                }
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
                    var str_poi_coor = len > 0 ? JSON.stringify(poi_coordinates) : '';
                    $('input#fence_area').val(str_poi_coor);
                    $('input#edit_fence_area').val(str_poi_coor);
                }

                google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                    var newArea = event.overlay; // Get coordinates of the new polygon
                    drawingManager.setDrawingMode(null)
                    drawingManager.setMap(null)
                    fence_area = newArea;
                    getPolygonCoords(newArea);
                });

                google.maps.event.addListener(fence_area.getPath(), 'insert_at', function(event) {
                    getPolygonCoords(fence_area)

                });
                google.maps.event.addListener(fence_area.getPath(), 'set_at', function(event) {
                    getPolygonCoords(fence_area)
                })
                var centerControlDiv = document.createElement('div');
                var centerControl = new CenterControl(centerControlDiv, map);


                centerControlDiv.index = 1;
                map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(centerControlDiv);
            } catch (error) {
                console.log(error)
            }
        }
        $('#addGeoFence').on('show.bs.modal', function(event) {
            InitMap()
        })
        $('#editGeoFence').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var area = button.data('area') // Extract info from data-* attributes
            var fence_id = button.data('fence_id') // Extract info from data-* attributes
            var fence_name = button.data('fence_name') // Extract info from data-* attributes
            // alert(area);
            var numPoints = area.length;
            var totalX = 0;
            var totalY = 0;
            var fence_path = [];
            for (var i = 0; i < numPoints; i++) {
                let coor = area[i].split(',');
                totalX += Number(coor[0]);
                totalY += Number(coor[1]);
                var latLng = {
                    lat: Number(coor[0]),
                    lng: Number(coor[1])
                };
                fence_path.push(latLng);
            }
            var centerX = 14.652752;
            var centerY = 121.100531;
            if (numPoints != 0) {
                centerX = totalX / numPoints;
                centerY = totalY / numPoints;
            }

            var modal = $(this);
            modal.find('.modal-body input#edit_fence_area').val(area)
            modal.find('.modal-body input#edit_fence_name').val(fence_name)
            modal.find('.modal-body input#fence_id').val(fence_id)

            InitMap(Number(centerX), Number(centerY), 'edit_map-canvas', fence_path)
        })
        $('#addGeoFence,#editGeoFence').on('hidden.bs.modal', function(event) {
            var modal = $(this)
            modal.find('.modal-body input#edit_fence_area').val('')
            modal.find('.modal-body input#edit_fence_name').val('')
            modal.find('.modal-body input#fence_area').val('')
            modal.find('.modal-body input#fence_name').val('')
        })
        $('button#btn_form_add').on('click', function() {
            $('form#fence_form_add').submit();
        })
        $('button#btn_form_edit').on('click', function() {
            $('form#fence_form_edit').submit();
        })
        $("form#form_geo_fence").on('submit',function(e){
            e.preventDefault;

        })
        $("#enable_geo_fence").on("change",function(){
            if($(this).prop('checked')){
                $(this).siblings('.setting').val(1);
            }else{
                $(this).siblings('.setting').val(0);
            }
            $("form#form_geo_fence").submit();
        })
    })
</script>

<script>
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'general') {
                window.location.href = '<?= base_url('attendances/setting_general') ?>';
            }
            if (selectedValue === 'holidays') {
                window.location.href = '<?= base_url('attendances/setting_holidays') ?>';
            }
            if (selectedValue === 'years') {
                window.location.href = '<?= base_url('attendances/setting_years') ?>';
            }
            if (selectedValue === 'biometrics') {
                window.location.href = '<?= base_url('attendances/setting_biometrics') ?>';
            }
            if (selectedValue === 'remote_in_out') {
                window.location.href = '<?= base_url('attendances/setting_remote_in_out') ?>';
            }
            if (selectedValue === 'geofences') {
                window.location.href = '<?= base_url('attendances/setting_geo_fences') ?>';
            }


        });
    });
</script>