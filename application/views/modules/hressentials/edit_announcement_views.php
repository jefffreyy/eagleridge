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
			<h2><a href="<?= base_url() . 'hressentials/announcements'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>

		</div>

	</div>

	<div class="container-fluid px-4">



		<div class="row d-flex justify-content-center">

			<div class="col-sm-6">

				<div class="card">

					<div class="modal-body pb-5">

						<div class="row">

							<div class="col-md-12">

								<form action="<?=base_url('hressentials/update_announcement')?>" method='POST'>

								    <div class="form-group">

    									<label class="text-dark" for="input_id">ID</label>

    									<input type="hidden" name="id" value="<?=$ANNOUNCEMENT->id?>"/>

    									<input type="text" class="form-control" name="input_id" id="input_id" disabled

    										value="<?='ANN' . str_pad($ANNOUNCEMENT->id, 5, '0', STR_PAD_LEFT)?>">

    								</div>

									<div class="form-group">
                                        <label class="" for="input_create_date">Create Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($ANNOUNCEMENT->create_date) ? 
                                        date_format(date_create($ANNOUNCEMENT->create_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>

    								<!-- <div class="form-group">

    									<label class="" for="input_create_date">Create Date</label>

    									<input type="datetime-local" class="form-control" name="input_create_date"

    										id="input_create_date" disabled value="<?=$ANNOUNCEMENT->create_date?>">

    								</div> -->

									<div class="form-group">
                                        <label class="" for="input_edit_date">Edit Date</label>
                                        <input type="text" class="form-control" disabled value="<?= !empty($ANNOUNCEMENT->edit_date) ? 
                                        date_format(date_create($ANNOUNCEMENT->edit_date), $DATE_FORMAT . ' H:i:s A') : '' ?>">
                                    </div>


    								<!-- <div class="form-group">

    									<label  for="input_edit_date">Edit Date</label>

    									<input type="datetime-local" class="form-control" name="input_edit_date"

    										id="input_edit_date" disabled value="<?=$ANNOUNCEMENT->edit_date?>">

    								</div> -->

    								<label class="">Last Edited By</label>

    								<select class="form-control" name="input_edit_user" id="input_edit_user" disabled>

    									<option value=1><?php
											$name = $ANNOUNCEMENT->col_empl_cmid.'-'.$ANNOUNCEMENT->col_last_name;
											if(!empty($ANNOUNCEMENT->col_suffix))$name = $name.' '.$ANNOUNCEMENT->col_suffix;
											if(!empty($ANNOUNCEMENT->col_frst_name))$name = $name.', '.$ANNOUNCEMENT->col_frst_name;
											if(!empty($ANNOUNCEMENT->col_midl_name))$name = $name.' '.$ANNOUNCEMENT->col_midl_name[0].'.';
											// $ANNOUNCEMENT->col_empl_cmid.' - '.$ANNOUNCEMENT->col_frst_name.' '.$ANNOUNCEMENT->col_last_name 
											echo $name;
											?></option>

    								</select>

    

    								<div class="form-group">

    									<label class="" for="input_title">Title</label>

    									<input type="text" class="form-control" name="title" id="input_title" 

    										value="<?=$ANNOUNCEMENT->title?>">

    								</div>

    								<div class="form-group">

    									<label class="" for="input_description">Description</label>

    									<textarea name="description" class="form-control" id="description" rows="4"

    										cols="50" ><?=$ANNOUNCEMENT->description?></textarea>

    								</div>
    								<div class="form-group">
                                        <label class="" for="input_attachment">Attachment(PNG,JPG,JPEG)</label>
                                        <div class="file_uploader" data-type="hressentials">
                                            <input type="hidden" name="attachment" value="<?=$ANNOUNCEMENT->attachment?>" class="selected_images d-block w-100"/>
                                        </div>
                                    </div>

    								<label class="">Status</label>

    								<div class="form-group">

    									<select class="form-control" name="status" >

    									<option value="Active" >Active</option>

    									<option value="Inactive"<?=$ANNOUNCEMENT->status=='Inactive'? 'selected' :'' ?>>Inactive</option>

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