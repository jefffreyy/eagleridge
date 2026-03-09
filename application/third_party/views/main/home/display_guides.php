<style>


    .video_card{
        cursor: pointer;
    }

    .video_card:hover{
        transition: 0.5s;
        box-shadow: 0px 0px 14px 0px rgba(85,168,248,0.75);
        -webkit-box-shadow: 0px 0px 14px 0px rgba(85,168,248,0.75);
        -moz-box-shadow: 0px 0px 14px 0px rgba(85,168,248,0.75);   
    }
    .modal-xl{
        max-width: 70% !important;
    }
    .card_bottom{
        height: 150px;  
    }

    .ytp-pause-overlay .ytp-scroll-min{
        display: none !important;
    }

    .ytp-chrome-top .ytp-show-cards-title{
        display: none !important;
    }
    .video_card img{
        object-fit: cover;
        width: 100%;
        height: auto;
    }

    .text-dropdown{
        font-size: 15px;
        color: black;
        margin-bottom: 0px;
        font-weight: bold;
    }

    .text-dropdown-sub{
        font-size: 12px;
        color: #8b8b8b;
        margin-bottom: 0px;
        display: inline;
        font-weight: normal;
    }

    .text-dropdown-icon{
        font-size: 12px;
        color: #8b8b8b;
        margin-bottom: 0px;
        display: inline;
    }
    

    @media only screen and (max-width: 1200px){
        .card_bottom .text-bold{
            font-size: 15px !important;
        }
        .card_bottom .text-secondary{
            font-size: 12px;
        }
    }

    @media only screen and (max-width: 1010px){
        .card_bottom .text-bold{
            font-size: 18px !important;
        }
        .card_bottom .text-secondary{
            font-size: 14px;
        }
    }

    @media only screen and (min-width: 1360px){
        .card_bottom .text-bold{
            font-size: 15px !important;
        }
        .card_bottom .text-secondary{
            font-size: 12px;
        }
        .card_bottom{
            height: 120px;
        }
    }

    @media only screen and (max-width: 500px){
        .col-xs-6{
            width: 50%;
            padding-left: 5px;
            padding-right: 5px;
        }
        .card_bottom .text-bold{
            font-size: 13px !important;
            text-align: left;
        }
        .card_bottom .text-secondary{
            font-size: 12px;
            text-align: left !important;
        }
        .card_bottom{
            height: 120px;
            padding-top: 5px !important;
        }

        .card{
            padding: 0px !important;
        }
        .page-title{
            margin-bottom: 20px;
            font-size: 20px;
        }
        
    }

    .links{
        width: 300px;
    }
    
    .section_list{
        width: 300px;
        /* height: 90vh;
        overflow-y: scroll; */
        overflow-x: hidden;
        transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
    }

    .section_list a{
        display: block;
        padding: 10px 20px;
        background-color: #002c67;
        margin-top: 2px;
        text-decoration: none;
        color: #fff;
        font-weight: bold;
    }

    .dropdown_btn{
        border-top-style: solid;
        border-top-color: #cfcfcf;
        border-top-width: 1px;

        background-color: #f7f9fa !important;
        color: black !important;
        font-size: 14px;
    }

    .dropdown_container a{
        border-style: none;

        background-color: #ffffff;
        color: #373737;
        font-size: 14px;
    }

    .btn_prev:hover{
        color: #f0f0f0 !important;
    }
    .btn_next:hover{
        color: #f0f0f0 !important;
    }
</style>

<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

<?php 

    $previous_vid = $IFRAME_INDEX - 1;
    $next_vid = $IFRAME_INDEX + 1;
    
?>

<div class="content-wrapper">
    <div class="d-flex pl-0">
        <div class="flex-fill pl-0">
            <h3 class="ml-4 mt-3 text-bold" style="color: #424F5C"><?= $IFRAME_TITLE ?></h3>
            <div class="card p-3 mx-auto mt-2" style=" width: 99%;">
                <iframe id="iframe_video" src="<?= $IFRAME_LINK ?>" style="width: 100%; height: 80vh; " frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                
                <div class="w-100 mt-3">
                    <div style="width: 150px; cursor: <?php if($previous_vid >=  0){echo 'pointer';}else{echo 'not-allowed';} ?>;" class="btn_prev float-left p-3" onclick="window.location.href = '<?php if($previous_vid >=  0){echo base_url().'home/display_guide?guide_index='.$previous_vid;}else{echo '#';} ?>'">
                        <div class="d-flex" style="color: #7b7b7b">
                            <i class="fas fa-chevron-left mr-4" style="font-size: 30px !important;"></i>
                            <p class="float-left mb-0" style="font-size: 20px;">Previous</p>
                        </div>
                    </div>
                    <div style="width: 150px; cursor: <?php if($next_vid < $IFRAME_ARR_LENGTH){echo 'pointer';}else{echo 'not-allowed';} ?>;" class="btn_next float-right p-3" onclick="window.location.href = '<?php if($next_vid < $IFRAME_ARR_LENGTH){echo base_url().'home/display_guide?guide_index='.$next_vid;}else{echo '#';} ?>'">
                        <div class="d-flex" style="color: #7b7b7b">
                            <div class="flex-fill"></div>
                            <p class="float-right mb-0" style="font-size: 20px;">Next</p>
                            <i class="fas fa-chevron-right ml-4" style="font-size: 30px !important;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

</body>

</html>