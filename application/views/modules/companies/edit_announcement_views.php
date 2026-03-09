<?php $this->load->view('templates/css_link'); ?>
<style>
	label {
		color: black;
	}
</style>

<div class="content-wrapper">
	<div class='row'>
		<div class='col-md-8 ml-4 mt-3'>
			<h2><a href="<?= base_url('companies/announcements') ?>"><i class="fa-duotone fa-circle-left"></i></a></h2>
		</div>
	</div>

	<div class="container-fluid px-4">
		<div class="row d-flex justify-content-center">
			<div class="col-sm-6">
				<div class="card">
					<div class="modal-body pb-5">
						<div class="row">
							<div class="col-md-12">
								<form action="<?= base_url('companies/update_announcement') ?>" method='POST' enctype="multipart/form-data">
									<div class="form-group">
										<label class="text-dark" for="input_id">ID</label>
										<input type="hidden" name="id" value="<?= $ANNOUNCEMENT->id ?>" />
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
										<input type="text" class="form-control" name="title" id="input_title" value="<?= $ANNOUNCEMENT->title ?>">
									</div>

									<div class="form-group">
										<label class="" for="input_description">Description</label>
										<textarea name="description" class="form-control" id="description" rows="4" cols="50"><?= $ANNOUNCEMENT->description ?></textarea>
									</div>

									<div class="form-group">
										<label class="" for="input_attachment">Attachment (<span>PNG,JPG,JPEG</span>)</label>
										<input type="file" class="form-control" name="attachment" id="input_attachment">
										<br><a href="<?= base_url('assets_user/files/companies/' . $ANNOUNCEMENT->attachment) ?>" download> <?= $ANNOUNCEMENT->attachment ?></a>
										<?php if (file_exists(FCPATH . 'assets_user/files/companies/' . $ANNOUNCEMENT->attachment) && !empty($ANNOUNCEMENT->attachment)) { ?>
											<img width='200px' class="d-block" src="<?= base_url('assets_user/files/companies/' . $ANNOUNCEMENT->attachment) ?>" />
										<?php } ?>
									</div>

									<label class="">Status</label>
									<div class="form-group">
										<select class="form-control" name="status">
											<option value="Active">Active</option>
											<option value="Inactive" <?= $ANNOUNCEMENT->status == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
										</select>
									</div>

									<div class="mr-2" style="float: right !important">
										<button type='submit' id="btn_edit" class="btn technos-button-blue shadow-none rounded " ;> Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>
<?php if ($this->session->flashdata('ERR')) { ?>
	<script>
		Swal.fire(
			'<?= $this->session->flashdata('ERR') ?>',
			'',
			'error'
		)
	</script>
<?php } ?>