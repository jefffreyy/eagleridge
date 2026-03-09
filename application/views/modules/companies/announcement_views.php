<?php $this->load->view('templates/css_link'); ?>

<style>
	label {
		color: black;
	}
</style>

<div class="content-wrapper">
	<div class='row'>
		<div class='col-md-8 ml-4 mt-3'>
			<h2><a href="<?= base_url('companies/announcements') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
</a></h2>
		</div>
	</div>

	<div class="container-fluid px-4">
		<div class="row d-flex justify-content-center">
			<div class="col-sm-6">
				<div class="card">
					<div class="modal-body pb-5">
						<div class="row">

							<div class="col-md-12">
								<div class="form-group">
									<label class="text-dark" for="input_id">ID</label>
									<input type="text" class="form-control" name="input_id" id="input_id" disabled value="<?= 'ANN' . str_pad($ANNOUNCEMENT->id, 5, '0', STR_PAD_LEFT) ?>">
								</div>

								<div class="form-group">
									<label class="" for="input_create_date">Create Date</label>
									<input type="datetime-local" class="form-control" name="input_create_date" id="input_create_date" disabled value="<?= $ANNOUNCEMENT->create_date ?>">
								</div>

								<div class="form-group">
									<label for="input_edit_date">Edit Date</label>
									<input type="datetime-local" class="form-control" name="input_edit_date" id="input_edit_date" disabled value="<?= $ANNOUNCEMENT->edit_date ?>">
								</div>

								<label class="">Last Edited By</label>
								<select class="form-control" name="input_edit_user" id="input_edit_user" disabled>
									<option value=1><?= $ANNOUNCEMENT->col_empl_cmid . ' - ' . $ANNOUNCEMENT->col_frst_name . ' ' . $ANNOUNCEMENT->col_last_name ?></option>
								</select>

								<div class="form-group">
									<label class="" for="input_title">Title</label>
									<input type="text" class="form-control" name="input_title" id="input_title" disabled value="<?= $ANNOUNCEMENT->title ?>">
								</div>

								<div class="form-group">
									<label class="" for="input_description">Description</label>
									<textarea name="description" class="form-control" id="input_description" rows="4" cols="50" disabled><?= $ANNOUNCEMENT->description ?></textarea>
								</div>

								<div class="form-group">
									<label class="" for="input_attachment">Attachment</label>
									<br><a href="<?= base_url('assets_user/files/companies/' . $ANNOUNCEMENT->attachment) ?>" download> <?= $ANNOUNCEMENT->attachment ?></a>
									<img width='200px' class="d-block" src="<?= base_url('assets_user/files/companies/' . $ANNOUNCEMENT->attachment) ?>" />
								</div>

								<label class="">Status</label>
								<div class="form-group">
									<select class="form-control" name="input_status" id="input_status" disabled>
										<option><?= $ANNOUNCEMENT->status ?></option>
									</select>
								</div>
								
								<div class="mr-2" style="float: right !important">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>