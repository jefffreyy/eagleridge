<style>
		.active{
			font-weight: 600;
		}

		.fc-col-header-cell-cushion {
			font-size: 16.5px !important;
			font-weight: 500;
		}

		.fc-button-primary{
			background-color: #f5f5f5 !important;
			border: 1px solid #ddd !important;
			color: #333333 !important;
		}
		.fc-daygrid-day-number{
			color: #0F0F0F;
		}

	</style>
	
	<!-- Sweet Alert CSS -->
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

	<div class="content-wrapper">
		<div class="navbar navbar-expand-md py-0" style="margin-top: -5px; background-color: #fff;padding-left: 0px;">
        	<div class="container-fluid">
          		<div class="navbar-collapse ">
              		<ul class="nav navbar-nav list-group list-group-horizontal">
    					<li class="nav-item py-2 px-1 nav_item_active">
      						<a class="nav-link nav_pill active py-0"  href="#">Calendar</a>
						</li>
						<li class="nav-item py-2 px-1" style="margin-top: 0; border: none;">
							<a class="nav-link nav_pill py-0" href="#" style="color: #213148;">
							Schedule
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="row px-3 my-3">
			<div class="col">
				<h1 class="page-title">Leave Calendar</h1>
			</div>
		</div>
		<div class="d-flex px-2 py-1">
			<div class="p-2 mr-auto">
				<button class="btn btn-secondary dropdown-toggle " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-filter p-1"></i>&nbsp;&nbsp;Filter</button>
				<div class="dropdown-menu js-dropdown-propagate-click" style="width: 400px;">
					<div class="p-2">
						<div class="mb-2">
							<div data-controller="none">
								<select class="form-control custom-select mr-sm-2" data-none-target="input" name="criteria[filter_by]" id="criteria_filter_by">
									<option value="">-- Select --</option>
									<optgroup label="Events"><option value="birthdays">Birthdays</option>
										<option value="anniversaries">Anniversaries</option>
										<option value="terminations">Last day</option>
										<option value="custom">Events</option>
										<option value="hired_on">First day</option>
										<option value="holidays">Public holidays</option>
										<option value="probation_ends">Probation ending</option>
										<option value="one_on_ones">1-on-1's</option>
									</optgroup>
									<optgroup label="Leave Types">
										<option value="Annual Leave">Annual Leave</option>
										<option value="Sick Leave">Sick Leave</option>
										<option value="Without Pay">Without Pay</option>
									</optgroup>
								</select>
							</div>
						</div>
						<div class="mb-2">
							<input type="text" name="teams" id="teams" class="form-control" placeholder="Teams">
						</div>
						<div class="mb-2">
							<input type="text" name="department" id="department" class="form-control" placeholder="Department">
						</div>
						<div class="mb-2">
							<input type="text" name="divisions" id="divisions" class="form-control" placeholder="Divisions">
						</div>
						<div class="mb-2">
							<input type="text" name="locations" id="locations" class="form-control" placeholder="Locations">
						</div>
						<a href='#' value="Apply" class="btn btn-primary">Apply</a>
					</div>
				</div>
			</div>
			<div class="p-2">
				<a class="btn btn-primary text-white mr-2">
					<i class="fas fa-plus mr-1 p-1"></i><span style="margin-top: -10px !important;"> New Event</span>
				</a>
			</div>
			<div class="p-2">
			<a class="btn btn-light" data-remote="true">
				<i class="fas fa-share-alt mr-1 px-2"></i> Share
			</a>
			</div>
		</div>


		<div class="card px-3 mx-3">
			<div class="card-body">
				<div id="calendar"></div>
			</div>
		</div>
	</div>


	<!-- LOGOUT MODAL -->
	<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true" class="text-white">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Hi are you sure you want to logout?</p>
				</div>
				<div class="modal-footer pb-1 pt-1">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<a href="<?php echo base_url().'login/logout'; ?>" class="btn btn-info">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<aside class="control-sidebar control-sidebar-dark">
	</aside>
	
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

	<?php if($this->session->userdata('TemporaryPassword')){ ?>
		<script>$('#modal_change_pass').modal('toggle');</script>
	<?php } ?>
	<?php
		if($this->session->userdata('message')){
		?>
			<script>
				Swal.fire(
					'<?php echo $this->session->userdata('message'); ?>',
					'',
					'success'
				)
			</script>
			<?php
			$this->session->unset_userdata('message');
		}	
	?>
	
	<?php
		if($this->session->userdata('message')){
		?>
			<script>
				Swal.fire(
					'<?php echo $this->session->userdata('message'); ?>',
					'',
					'success'
				)
			</script>
			<?php
			$this->session->unset_userdata('message');
		}	
	?>
	
	<?php
		if($this->session->userdata('change_pass_msg')){
		?>
			<script>
				Swal.fire(
					'<?php echo $this->session->userdata('change_pass_msg'); ?>',
					'',
					'success'
				)
			</script>
			<?php
			$this->session->unset_userdata('change_pass_msg');
		}	
	?>
	
	<?php
		if($this->session->userdata('new_update_message') && (!$this->session->userdata('TemporaryPassword'))){
		?>
			<script>
				$('#latest_update').modal('toggle');
			</script>
			<?php
			$this->session->unset_userdata('new_update_message');
		}	
	?>

	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>

	
	<script>
		$(document).ready(function(){
			var calendarEl = document.getElementById('calendar');

			var calendar = new FullCalendar.Calendar(calendarEl, {
			headerToolbar: {
				left: 'prevYear,prev,next,nextYear today',
				center: 'title',
				right: 'dayGridMonth,dayGridWeek,dayGridDay'
			},
			initialDate: '2020-09-12',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			dayMaxEvents: true, // allow "more" link when too many events
			/* events: [
				{
				title: 'All Day Event',
				start: '2020-09-01'
				},
				{
				title: 'Long Event',
				start: '2020-09-07',
				end: '2020-09-10'
				},
				{
				groupId: 999,
				title: 'Repeating Event',
				start: '2020-09-09T16:00:00'
				},
				{
				groupId: 999,
				title: 'Repeating Event',
				start: '2020-09-16T16:00:00'
				},
				{
				title: 'Conference',
				start: '2020-09-11',
				end: '2020-09-13'
				},
				{
				title: 'Meeting',
				start: '2020-09-12T10:30:00',
				end: '2020-09-12T12:30:00'
				},
				{
				title: 'Lunch',
				start: '2020-09-12T12:00:00'
				},
				{
				title: 'Meeting',
				start: '2020-09-12T14:30:00'
				},
				{
				title: 'Happy Hour',
				start: '2020-09-12T17:30:00'
				},
				{
				title: 'Dinner',
				start: '2020-09-12T20:00:00'
				},
				{
				title: 'Birthday Party',
				start: '2020-09-13T07:00:00'
				},
				{
				title: 'Click for Google',
				url: 'http://google.com/',
				start: '2020-09-28'
				}
			] */
			});
			calendar.render();
		})
	</script>
</body>
</html>
