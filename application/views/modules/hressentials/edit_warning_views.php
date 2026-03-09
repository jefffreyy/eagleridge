<?php $this->load->view('templates/css_link'); ?>

<style>

    label{

        color:black;

    }

</style>

<div class="content-wrapper">

	<div class='row'>

		<div class='col-md-8 ml-4 mt-3'>

			<!-- <h2><a href="<?=base_url('hressentials/announcements')?>"><i class="fa-duotone fa-circle-left"></i></a></h2> -->
			<h2><a href="<?= base_url() . 'hressentials/warnings'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>

		</div>

	</div>

	<div class="container-fluid px-4">



		<div class="row d-flex justify-content-center">

			<div class="col-sm-6">

				<div class="card">

					<div class="modal-body pb-5">

						<div class="row">

							<div class="col-md-12">

								<form action="<?=base_url('hressentials/update_warning/'.$WARNING->id)?>" method='POST'>

								    <div class="form-group">

    									<label class="text-dark" for="input_id">ID</label>

    									<input type="text" class="form-control" name="input_id" id="input_id" disabled

    										value="<?='WRN' . str_pad($WARNING->id, 5, '0', STR_PAD_LEFT)?>">

    								</div>

									
									<div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($WARNING->create_date) ? 
                                        date_format(date_create($WARNING->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

    								<!-- <div class="form-group">

    									<label class="" for="input_create_date">Create Date</label>

    									<input type="datetime-local" class="form-control" name="input_create_date"

    										id="input_create_date" disabled value="<?=$WARNING->create_date?>">

    								</div> -->

									<div class="form-group">
                                        <label class="" for="input_edit_date">Edit Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($WARNING->edit_date) ? 
                                        date_format(date_create($WARNING->edit_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

    								<!-- <div class="form-group">

    									<label  for="input_edit_date">Edit Date</label>

    									<input type="datetime-local" class="form-control" name="input_edit_date"

    										id="input_edit_date" disabled value="<?=$WARNING->edit_date?>">

    								</div> -->

    							<div class="form-group">
    							    <label class="">Last Edited By</label>

    								<select class="form-control" name="input_edit_user" id="input_edit_user" disabled>

    									<option value=1><?=$WARNING->editor?></option>

    								</select>
    							</div>	
                                <div class="form-group">
                                    <label class="">Employee</label>

                                    <select class="form-control custom_selection" name="employee_id" id="input_employee_id">
    
                                        <?php foreach ($C_EMPLOYEES as $employee) { ?>
    
                                            <option value="<?=$employee->id?>" <?=$employee->id==$WARNING->empl_id ?'selected': '' ?> ><?= $employee->col_empl_cmid . '-' . $employee->col_last_name . ' ' . $employee->col_frst_name ?></option>
    
                                        <?php } ?>
    
    
    
                                    </select>
                                </div>
    								<div class="form-group">

    									<label class="" for="input_title">Title</label>

    									<input type="text" class="form-control" name="title" id="input_title" 

    										value="<?=$WARNING->title?>">

    								</div>

    								<div class="form-group">

    									<label class="" for="input_description">Description</label>

    									<textarea name="description" class="form-control" id="description" rows="4"

    										cols="50" ><?=$WARNING->description?></textarea>

    								</div>
    								<div class="form-group">

    									<label class="" for="input_description">Feedback</label>

    									<textarea name="description" class="form-control" id="description" rows="4"

    										cols="50" ><?=$WARNING->feedback?></textarea>

    								</div>
    								<div class="form-group">
                                        <label class="" for="input_attachment">Attachment</label>
                                        <div class="file_uploader" data-type="hressentials">
                                            <input type="hidden" name="attachment" value="<?=$WARNING->attachment?>" class="selected_images d-block w-100"/>
                                        </div>
                                    </div>

    								<label class="">Status</label>

    								<div class="form-group">

    									<select class="form-control" name="status" >

    									<option value="Active" >Active</option>

    									<option value="Inactive"<?=$WARNING->status=='Inactive'? 'selected' :'' ?>>Inactive</option>

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

<?php if($this->session->flashdata('ERR')) { ?>

    <script>

        Swal.fire(

            '<?=$this->session->flashdata('ERR')?>',

            '',

            'error'

        )

    </script>

<?php } ?>