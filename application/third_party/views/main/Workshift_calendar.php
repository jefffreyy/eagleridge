<style>
    body{
        font-family: 'Roboto';
        background-color: #fafafa;
    }

    h4{
        margin: 60px 0 10px 60px;
    }

    .wrapper{
        width: 100%;
        text-align: center;
    }

    .greenClass{
        background: green;
    }

    .blueClass{
        background: blue;
    }

    td{
        border: 1px solid #ccc;
    }

    .greenClass a{
        content: 'D01';
        color: #fff;
    }

</style>

<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/horizontal-calendar-events-rescalendar/dist/rescalendar.min.css">

	<div class="content-wrapper">
		<div class="container-fluid p-4">
            <div class="row">
                <div class = "col-md-6">
                    <h1><b>Work Shift Calendar</b><h1>
                </div>
                <div class = "col-md-6" style = "text-align: right;">
                    
                </div>
            </div>
            <div class="row">
                
            </div>
            <div class = "">
                <div class="rescalendar" id="my_calendar1"></div>
            </div>
        </div>
	</div>

	<aside class="control-sidebar control-sidebar-dark">
	</aside>
	<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
    <!-- RESCALENDAR -->
    <script src="<?= base_url(); ?>plugins/horizontal-calendar-events-rescalendar/dist/rescalendar.min.js"></script>
    <script>
        // Multiple instantiation (divs 1 and 2)
        $('#my_calendar1').rescalendar({
            id: 'my_calendar1',
            format: 'DD/MM/YYYY',
            jumpSize: 15,
            locale: 'en',
            refDate: '07/07/2021',
            lang: {
                'today': 'Today',
                'init_error': 'Error has occured',
                'no_data_error' : 'No se encontraron datos para mostrar'
            },

            data: [
                {
                    id: 1,
                    name: 'item1',
                    startDate: '01/07/2021',
                    endDate: '15/07/2021',
                    customClass: 'greenClass',
                    title: 'Test Blue'
                },
                {
                    id: 2,
                    name: 'item2',
                    startDate: '05/03/2019',
                    endDate: '15/03/2019',
                    customClass: 'blueClass'
                },
                {
                    id: 3,
                    name: 'item1',
                    startDate: '05/03/2019',
                    endDate: '08/03/2019'
                }
            ],

            dataKeyField: 'name',
            dataKeyValues: ['item1', 'item2', 'item3']

        });



    </script>
</body>
</html>
