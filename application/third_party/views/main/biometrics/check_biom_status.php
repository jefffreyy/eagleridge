<!DOCTYPE html>
<html lang="en">
<head>
    <!-- STANDARD 1: EROVOUTIKA HTML STANDARD CODE, DO NOT CHANGE -->
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    <link rel="shortcut icon" href="<?=base_url()?>images/HrCare_title_icon.png" type="image/x-icon">
	<title>HRCare</title>


	<!-- STANDARD 2: EROVOUTIKA STANDARD CSS PLUGINS, DO NOT CHANGE -->
    <link rel="preconnect" href="https://fonts.gstatic.com"> <!-- For Font Lato initialization -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet"> <!-- For Font Lato initialization -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fontawesome-free/css/all.min.css"><!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> <!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css"><!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?= base_url(); ?>dist/css/adminlte.min.css"><!-- Theme style -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><!-- Bootstrap --> 
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"><!-- Sweet Alert -->
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/toastr/toastr.min.css"><!-- Toastr -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css"><!-- iCheck bootstrap -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>

    <!-- STANDARD 3: EROVOUTIKA EXTERNAL CSS, DO NOT CHANGE -->
    <link href="<?= base_url(); ?>css/head_styles.css" rel="stylesheet">

    <!-- button class
    btn-primary:  blue button design -->
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron&display=swap');

    .nav-link:not(.nav_pill,.toggle_menu,.btn_notif):hover{
        background-color: rgba(255, 255, 255, 0.1) !important;
        color:#fff !important;
    }

    .nav-link.active{
        background-color: transparent !important;
        color: skyblue !important;
    }

    li a i:not(.right){
        width: 40px !important;
        text-align:center;
        /* padding-right: 30px;
        padding-left: 10px; */
        margin-right:8px !important;
    }

    .firebase_dropdown{
        transition: 0.5s;
        height: 78px !important;
        border-top: 1px solid #002c67 !important;
        margin-bottom: 0px !important;
        cursor: pointer;
    }
    
    .firebase_dropdown_open{
        transition: 0.5s;
        height: 50px !important;
        border-top: 1px solid #002c67 !important;
        margin-bottom: 0px !important;
        cursor: pointer;
    }

    .badge {
        border-radius: 3.125rem!important;
        font-weight: 500;
        display: inline-block;
        padding: 0.4em 0.71111em;
        font-size: 11.7px !important;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.125rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .navbar-badge {
        font-size: 0.8rem !important;
        font-weight: 300 !important;
        padding: 2px 6px !important;
        position: absolute !important;
        right: 5px !important;
        top: 9px !important;
    }

    .light_bg{
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .dropdown-toggle{
        cursor: pointer;
    }

    .nav-pills .nav-link{
        border-radius: 0px !important;
    }

    .menu-open{
        background-color: rgba(255, 255, 255, 0.1) !important;
    }

    .settings_button{
        transition: 0.4s;
    }

    .settings_button:hover{
        transition: 0.4s;
        -ms-transform: rotate(40deg); /* IE 9 */
        transform: rotate(80deg);
        border-radius: 50px;
    }

    @media only screen and (max-width: 1010px){
        .navbar_full_width{
            display: none;
        }
        .profile_name{
            display: none;
        }
    }

    /* Erovoutika Internal CSS */
    @media 
	only screen and (max-width: 992px)
	{ 
		.sms_buttons{
			width: 100% !important;
			text-align: center !important;
			margin-top: 10px;
		}
		.sms_length{
			width: 100% !important;
			text-align: center !important;
			margin-top: 5px !important;
		}
		.sms_length_container{
			margin-top: 10px !important;
		}
		.quick_section_right{
			padding: 0px !important;
		}
		.message_counter{
			display: block;
		}
	} 

    @media 
	only screen and (max-width: 500px)
	{ 
		#sidebar-overlay{
            z-index: 1000 !important;
        }

        #username_nav{
            display: none;
        }

        .dropdown-toggle{
            position: fixed;
            right: 15px;
            top: 13px;
            font-size: 18px;
        }

        .dropdown-menu{
            top: 13px !important;
            font-size: 18px !important;
        }
	} 

    .guides{
        padding: 10px;
    }
    .guides:hover{
        color: #0D74BC !important;
        background-color: #eaeaea !important;
        border-radius: 8px;
    }
    .spinner-border {
        width: 10px; 
        height: 10px;
    }

    #btn_notif i:hover{
        color: #0D74BC !important;
    }

    li a i:not(.right) {
        margin-right: 0px !important;
    }

    .card{
        padding: 15px;
    }
    li a{
        color: #0D74BC;
    }
    .page-item .active{
        background-color: #0D74BC !important;
    }
    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }
    
    .label-note{
        background-color: #fde6d8;
        padding: 5px 10px;
        border-radius: 30px;
        color: #c46632;
        font-weight: bold;
        text-align: center;
        line-height: normal;
    }
    table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
   
    }
    th, td {
    text-align: left;
    padding: 8px;
    font-size: 14px !important;
    font-weight: normal;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }

    .badge{
        border-radius: 5px !important;
        font-weight: bold;
        padding: 8px 10px;
    }

    .icon{
        width: 140px;
        height: 140px;
        border-radius: 8px 8px 8px 8px;
        -webkit-transform-origin: 50% 10%;
        transform-origin: 50% 10%;
    }

    .icon:hover, .icon:focus
    {
        -webkit-animation: swing 0.6s ease-out;
        animation: swing 0.6s ease-out;
    }

    .time_container{
        transform: translateY(25%) !important;
    }

    @-webkit-keyframes swing {
        0%   { -webkit-transform: rotate(0deg)  skewY(0deg); }
        20%  { -webkit-transform: rotate(12deg) skewY(4deg); }
        60%  { -webkit-transform: rotate(-9deg) skewY(-3deg); }
        80%  { -webkit-transform: rotate(6deg)  skewY(-2deg); }
        100% { -webkit-transform: rotate(0deg)  skewY(0deg); }
    }

    @keyframes swing {
        0%   { transform: rotate(0deg)  skewY(0deg); }
        20%  { transform: rotate(12deg) skewY(4deg); }
        60%  { transform: rotate(-9deg) skewY(-3deg); }
        80%  { transform: rotate(6deg)  skewY(-2deg); }
        100% { transform: rotate(0deg)  skewY(0deg); }
    }

    @media screen and (max-width: 500px){
        #current_time,#current_phase{
            text-align: center;
        }
        .time_container{
            transform: translateY(25%) !important;
        }
        #btn_time_in,#btn_time_out{
            width: 100%;
            margin-bottom: 10px;
            padding: 20px 20px;
        }
    }

    @media 
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {
		
        /* Force table to not be like tables anymore */
        table, thead, tbody, th, td, tr { 
            display: block; 
        }
        
        /* Hide table headers (but not display: none;, for accessibility) */
        thead tr { 
            position: absolute;
            top: -9999px;
            left: -9999px;
        }
        
        tr { 
            border: 1px solid #ccc;
            margin-bottom: 20px; 
        }
        
        td{ 
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee; 
            position: relative;
            padding-left: 50% !important;
            text-align: right;
        }
        
        td:before { 
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%; 
            padding-right: 10px; 
            white-space: nowrap;
            color: #5c5b5b;
            text-transform: capitalize;
            text-align: left !important;
        }

        .modal_head{
            margin-top: 15px;
            padding-bottom: 10px;
            color: #007BFF;
        }
        
        /* Labels the sliced thead of the table */
        td:nth-of-type(1):before { content: "Date"; }
        td:nth-of-type(2):before { content: "Shift"; }
        td:nth-of-type(3):before { content: "Time In"; }
        td:nth-of-type(4):before { content: "Time Out"; }
        /* Add as you add content to the thead */
	}
    
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Datatables -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Pagination -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/bs-pagination.min.css">


<div class="container-fluid">
    <div class="flex-fill p-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="page-title">Check Biometrics Records</h1>
                <label for="filter_by_date" style="display: none;">Filter by date</label>
                <input type="date" style="display: none;" name="filter_by_date" id="filter_by_date" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-6">
               
            </div>
        </div>
        
        <hr>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table class="table mb-0" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Num</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_chk_biometrics_data_container">
                            <?php
                                if($DISP_CHK_BIOM_DATA){
                                    foreach($DISP_CHK_BIOM_DATA as $DISP_CHK_BIOM_DATA_ROW){
                                        ?>
                                            <tr id="row_biom_data">
                                                <td><?= $DISP_CHK_BIOM_DATA_ROW->id ?></td>
                                                <td><?= $DISP_CHK_BIOM_DATA_ROW->num ?></td>
                                                <td><?= $DISP_CHK_BIOM_DATA_ROW->biom_status ?></td>
                                            </tr>
                                        <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <ul id="example" class="pagination"></ul>

        <input type="hidden" name="curr_date" id="curr_date" value="<?= date('n/j/Y'); ?>">

        <input type="hidden" name="biom_data_num" class="biom_data_num" id="biom_data_num">
        <input type="hidden" name="db_biom_data_num" class="db_biom_data_num" id="db_biom_data_num">
    </div>

</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>

<div id="sidebar-overlay"></div>
<!-- jQuery -->
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- Datatables -->
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
<!-- Full Calendar 2.2.5 -->
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<!-- Pagination -->
<script src="<?= base_url(); ?>plugins/ajax_enabled_pagination/dist/pagination.min.js"></script>


<?php
if($this->session->userdata('success')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('success'); ?>',
    '',
    'success'
  )
</script>
<?php
$this->session->unset_userdata('success');
}
?>

<?php
if($this->session->userdata('error')){
?>
<script>
  Swal.fire(
    '<?php echo $this->session->userdata('error'); ?>',
    '',
    'error'
  )
</script>
<?php
$this->session->unset_userdata('error');
}
?>




<script>

    $(document).ready(function(){

        var url_get_biom_check = '<?= base_url() ?>check_biom_status/get_biom_check';
        var url_updt_biom_check_status = '<?= base_url() ?>check_biom_status/updt_biom_check_status';


        var time_lapse = 0;

        var chk_biometrics_row = $('#tbl_chk_biometrics_data_container').children()[0];
        
        $('#biom_data_num').val($(chk_biometrics_row.childNodes[3]).html());

        var biom_num_arr = [];

        setInterval(() => {
            get_biom_check(url_get_biom_check, 'test').then(function(data){
                var db_biom_num = '';
                var biom_id = '';

                Array.from(data).forEach(function(x){
                    $('#tbl_chk_biometrics_data_container').html(`
                        <tr>
                            <td>`+x.id+`</td>
                            <td>`+x.num+`</td>
                            <td>`+x.biom_status+`</td>
                        </tr>
                    `)

                    db_biom_num = x.num;
                    biom_id = x.id;
                    $('#db_biom_data_num').val(db_biom_num);
                })
                

                if($('#biom_data_num').val() != $('#db_biom_data_num').val()){
                    time_lapse = 0;
                    $('#biom_data_num').val(db_biom_num);
                    updt_biom_check_status(url_updt_biom_check_status,'0',biom_id).then(function(data){
                        console.log(data);
                    })
                } else {
                    if(time_lapse == 60){
                        console.log('1 minute!');
                        time_lapse = 0;
                        updt_biom_check_status(url_updt_biom_check_status,'1',biom_id).then(function(data){
                            console.log(data);
                        })
                    }
                }


                
                
            })

            console.log(time_lapse += 5);
        }, 5000);
        



        async function get_biom_check(url,empl_cmid){
            var formData = new FormData();
            formData.append('empl_cmid', empl_cmid);
            const response = await fetch(url, {
            method: 'POST',
            body: formData
            });
            return response.json();
        }

        async function updt_biom_check_status(url,biom_status,biom_id){
            var formData = new FormData();
            formData.append('biom_status', biom_status);
            formData.append('biom_id', biom_id);
            const response = await fetch(url, {
            method: 'POST',
            body: formData
            });
            return response.json();
        }

    })
</script>

</body>

</html>