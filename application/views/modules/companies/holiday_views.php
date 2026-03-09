<?php $this->load->view('templates/css_link'); ?>
<?php
$search_data = $this->input->get('search');
$search_data = str_replace("_", " ", $search_data ?? '');
?>
<div class="content-wrapper">
	<div class="container-fluid p-4">
		<div class="row pt-1">
			<div class="col-md-6">
				<h1 class="page-title d-flex align-items-center"><a onclick="afterRenderFunction()" href="<?= base_url('companies') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
					</a>&nbsp;Holidays<h1>
			</div>
		</div>

		<div class="card border-0 p-0 m-0">
			<div class="card border-0 pt-1 m-0">
				<div class="card-header p-0">
					<div class="row">
						<div class="col-xl-8">
							<ul class="nav nav-tabs">
								<?php foreach ($TAB_YEARS as $year) {  ?>

									<li class="nav-item">
										<a class="nav-link head-tab <?= $TAB == $year['year'] ? 'active' : '' ?> " href="?tab=<?= $year['year'] ?>"><?= $year['year'] ?><span class="ml-2 badge badge-pill badge-secondary "><?= $year['count'] ?></span></a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table table-bordered m-0" id="table_main" style="width:100%">
						<thead>
							<th class="text-center" style="width:5%" hidden><input type="checkbox" name="check_all" id="check_all"></th>
							<th style='width:20%;text-align: left;'>DATE</th>
							<th style='width:15%;text-align: left;'>NAME</th>
							<th style='width:15%;text-align: left;'>TYPE</th>
							<th style="width:15%" class="text-center" hidden>ACTION</th>
						</thead>

									<!-- <?php var_dump($DATE_FORMAT);?> -->

						<tbody id="tbl_application_container">
							<?php foreach ($HOLIDAYS as $holiday) : ?>
								<tr>
								<td class="text-left"><?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($holiday->col_holi_date)) ?></td>
									<td class="text-left" style="width:15%"><?= $holiday->name ?></td>
									<td class="text-left" style="width:15%"><?= $holiday->col_holi_type ?></td>
								</tr>

							<?php endforeach ?>
							<?php if (!$HOLIDAYS) : ?>
								<tr class="table-active">
									<td colspan="9">
										<center>No Records</center>
									</td>
								</tr>
							<?php endif ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>