
<link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/fullcalendar/main.css">
<style>
	.active {
		font-weight: 600;
	}
	.fc-col-header-cell-cushion {
		font-size: 16.5px !important;
		font-weight: 500;
	}
	.fc-button-primary {
		background-color: #f5f5f5 !important;
		border: 1px solid #ddd !important;
		color: #333333 !important;
	}
	.fc-daygrid-day-number {
		color: #0F0F0F;
	}
</style>
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/home_style'); ?>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">

<div class="content-wrapper">
	<!-- <div class="navbar navbar-expand-md py-0">
        	<div class="container-fluid">
          		<div class="navbar-collapse ">
              		<ul class="nav navbar-nav list-group list-group-horizontal">
    					<li class="nav-item py-2 px-1 nav_item_active">
      						<p class="nav-link nav_pill active py-0">Calendar</p>
						</li>
					</ul>
				</div>
			</div>
		</div> -->
	<div class="px-3 my-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?= base_url() ?>selfservices">Self-Service</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">My Calendar</li>
			</ol>
		</nav>
		<div>
			<h1 class="page-title"><?= $TITLE ?></h1>
		</div>
	</div>
	<div class="card px-3 mx-3">
		<div class="card-body">
			<div id="calendar"></div>
		</div>
		<div>
			<ul class="d-flex align-items-center" style="list-style-type:none">
				<li class="mr-3"><span class="d-inline-block align-middle m-2"
					style="width:20px;height:20px;background-color:#ff4d4d;"></span>Rest Day</li>
				<li class="mr-3"><span class="d-inline-block align-middle m-2"
					style="width:20px;height:20px;background-color:limegreen;"></span>Work Day</li>
				<li class="mr-3"><span class="d-inline-block align-middle m-2"
						style="width:20px;height:20px;background-color:#FE6E00;"></span>Event</li>
				<li class="mr-3"><span class="d-inline-block align-middle m-2"
						style="width:20px;height:20px;background-color:#029139;"></span>Task</li>
				<li class="mr-3"> <span class="d-inline-block align-middle m-2"
						style="width:20px;height:20px;background-color:#FF00FF;"></span>Holiday</li>
			</ul>
		</div>
	</div>
</div>

<!-- jQuery -->
<?php $this->load->view('templates/jquery_link'); ?>


<script>
	$(document).ready(function () {
        var url = '<?= base_url() ?>selfservices';
		var calendarEl = document.getElementById('calendar');
		var date = new Date();
		var month= (date.getMonth() + 1)<10 ? ""+date.getMonth()+1 : date.getMonth()+1;
		var day=    date.getDate() < 10 ? '0'+date.getDate():date.getDate();
		var today =date.getFullYear()+'-'+(month) +'-'+ day;

		var calendar = new FullCalendar.Calendar(calendarEl, {
			headerToolbar: {
				left: 'prevYear,prev,next,nextYear today',
				center: 'title',
				right: 'dayGridMonth,dayGridWeek,timeGridDay'
			},
			// initialDate: today,
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			dayMaxEvents: true, // allow "more" link when too many events
			/*events: [
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
			 start: '2022-12-01',
			 end: '2022-12-05T12:00:00'
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
		
		fetch(url+'/fetch_data').then((response)=>{
            // console.log(response);
            return response.json()
        }).then((res)=>{
            console.log(res);
			// console.log(calendar);
            for (const key in res) {
				
				for (let i = 0; i < res[key].length; i++) {

					calendar.addEvent({
						title: res[key][i]["title"],
						start: res[key][i]["start"],
						end: res[key][i].hasOwnProperty('end') ? res[key][i]["end"] : "",
						color: key == 'HOLIDAYS_INFO' ? '#FF00FF' : key == 'EVENTS_INFO' ? '#FE6E00' : key == 'MY_SCHEDULE' ? res[key][i]["title"] == "REST" ? '#ff4d4d' : 'limegreen' : '#029139',
						editable: false,
					});

				}
			}
        }).then(()=>{
            calendar.render();
        }).catch((error)=>{
            console.log(error);
        })
	})
</script>
</body>
</html>
