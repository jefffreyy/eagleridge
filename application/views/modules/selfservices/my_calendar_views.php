<!-- <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/fullcalendar/main.css"> -->
<link rel="stylesheet" href="<?= base_url('assets_system') ?>/_eyeboxroot/plugins/fullcalendar/main.css">
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

<div class="content-wrapper">

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
			<h1 class="page-title">
				<a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>">
					<img style="width: 32px; height: 32px; margin-bottom: 7px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
				</a>&nbsp;<?= $TITLE ?>
			</h1>
		</div>
	</div>
	<div class="card px-3 mx-3">
		<div class="card-body">
			<div id="calendar"></div>
		</div>
		<div>
			<ul class="d-flex align-items-center" style="list-style-type:none">
				<li class="mr-3"><span class="d-inline-block align-middle m-2" style="width:20px;height:20px;background-color:#ff4d4d;"></span>Rest Day</li>
				<li class="mr-3"><span class="d-inline-block align-middle m-2" style="width:20px;height:20px;background-color:limegreen;"></span>Work Day</li>
				<li class="mr-3"><span class="d-inline-block align-middle m-2" style="width:20px;height:20px;background-color:#FE6E00;"></span>Event</li>
				<li class="mr-3"><span class="d-inline-block align-middle m-2" style="width:20px;height:20px;background-color:#029139;"></span>Task</li>
				<li class="mr-3"> <span class="d-inline-block align-middle m-2" style="width:20px;height:20px;background-color:#FF00FF;"></span>Holiday</li>
			</ul>
		</div>
	</div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>


<script>
	$(document).ready(function() {
		var url = '<?= base_url() ?>selfservices';
		var calendarEl = document.getElementById('calendar');
		var date = new Date();
		var month = (date.getMonth() + 1) < 10 ? "" + date.getMonth() + 1 : date.getMonth() + 1;
		var day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
		var today = date.getFullYear() + '-' + (month) + '-' + day;

		var calendar = new FullCalendar.Calendar(calendarEl, {
			headerToolbar: {
				left: 'prevYear,prev,next,nextYear today',
				center: 'title',
				right: 'dayGridMonth,dayGridWeek,timeGridDay'
			},
			navLinks: true,
			editable: true,
			dayMaxEvents: true,

		});

		fetch(url + '/fetch_data').then((response) => {
			return response.json()
		}).then((res) => {
			console.log(res);
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
		}).then(() => {
			calendar.render();
		}).catch((error) => {
			console.log(error);
		})
	})
</script>
</body>

</html>