<?php $this->load->view('templates/css_link'); ?>

<style>

    label,input{

        color:black;

    }

</style>

<div class="content-wrapper">

	<div class='row'>

		<div class='col-md-8 ml-4 mt-3'>

			<!-- <h2><a href="<?=base_url('hressentials/policies')?>"><i class="fa-duotone fa-circle-left"></i></a></h2> -->
			<h2><a href="<?= base_url() . 'hressentials/policies'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>


		</div>

	</div>

	<div class="container-fluid px-4">



		<div class="row d-flex justify-content-center">

			<div class="col-sm-6">

				<div class="card">

					<div class="modal-body pb-5">

						<div class="row">



							<div class="col-md-12">

								<form action="<?=base_url('hressentials/update_policy')?>" method="POST" enctype="multipart/form-data">

								    <div class="form-group">

								        <input type="hidden" name="id" value="<?=$POLICY->id?>">

									    <label class="" for="input_id">ID</label>

									    <input type="text" class="form-control" name="input_id" id="input_id" disabled

										value="<?='POL' . str_pad($POLICY->id, 5, '0', STR_PAD_LEFT)?>">

    								</div>

									<div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($POLICY->create_date) ? 
                                        date_format(date_create($POLICY->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

    								<!-- <div class="form-group">

    									<label class="" for="input_create_date">Create Date</label>

    									<input type="datetime-local" class="form-control" name="input_create_date"

    										id="input_create_date" disabled value="<?=$POLICY->create_date?>">

    								</div> -->

									
									<div class="form-group">
                                        <label class="" for="input_edit_date">Edit Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($POLICY->edit_date) ? 
                                        date_format(date_create($POLICY->edit_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

    								<!-- <div class="form-group">

    									<label class="" for="input_edit_date">Edit Date</label>

    									<input type="datetime-local" class="form-control" name="input_edit_date"

    										id="input_edit_date" disabled value="<?=$POLICY->edit_date?>">

    								</div> -->

    								<label class="">Last Edited By</label>

    								<select class="form-control" name="input_edit_user" id="input_edit_user" disabled>

    									<option value=1><?=$POLICY->last_editor?></option>

    								</select>

    

    								<label class="">Employee</label>

    								<select class="form-control" name="employee_id" id="input_employee_id">

											<?php foreach($EMPLOYEES as $employee){

												$name2=$employee->col_empl_cmid.'-'.$employee->col_last_name;
												if(!empty($employee->col_suffix))$name2=$name2.' '.$employee->col_suffix;
												if(!empty($employee->col_frst_name))$name2=$name2.', '.$employee->col_frst_name;
												if(!empty($employee->col_midl_name))$name2=$name2.' '.$employee->col_midl_name[0].'.';
											
												?>

											<option value="<?=$employee->id?>" <?=$POLICY->employee_id == $employee->id ? 'selected': '' ?>>

													<?=
													$name2
													// $employee->col_empl_cmid.'-'.$employee->col_last_name.','.$employee->col_frst_name.' '.$employee->col_midl_name.'.'
													?>

											</option>

										<?php } ?>

    								</select>

    

    								<div class="form-group">

    									<label class="" for="input_title">Title</label>

    									<input type="text" class="form-control" name="title" id="input_title" enabled

    										value="<?=$POLICY->title?>">

    								</div>

    								<div class="form-group">

    									<label class="" for="input_description">Description</label>

    									<textarea name="description" class="form-control" id="input_description" rows="4"

    										cols="50" enabled><?=$POLICY->description?></textarea>

    								</div>

    								<div class="form-group">

    									<label class="" for="input_feedback">Feedback</label>

    									<textarea name="feedback" class="form-control" id="input_feedback" rows="4"

    										cols="50" enabled><?=$POLICY->feedback?></textarea>

    								</div>

    								<div class="form-group">

    									<label class="" for="input_attachment">Attachment</label>

    									<!-- <input type="file" class="form-control" name="input_attachment" id="input_attachment"  enabledstyle="display:none;"/> -->

    									<input type="file" class="form-control-file border p-1 mb-2" name="attachment"

    										id="input_attachment"   />

										<a href="<?=base_url('assets_user/files/hressentials/'.$POLICY->attachment)?>"

    										download><?=$POLICY->attachment?></a>

<?php if($this->system_functions->getFileType($POLICY->attachment)=='Image') { ?>

                                            <img width='300px' class="d-block" src="<?=base_url('assets_user/files/hressentials/'.$POLICY->attachment)?>">

<?php } ?>

    								</div>

    								<label class="">Status</label>

    								<div class="form-group">

    									<select class="form-control" name="status" id="input_status" enabled>

    										<option selected>Active</option>

    										<option> Inactive</option>

    									</select>

    								</div>

    								<div class="mr-2" style="float: right !important">

    									<button id="btn_edit" class="btn technos-button-blue shadow-none rounded" ;> Submit</button>

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