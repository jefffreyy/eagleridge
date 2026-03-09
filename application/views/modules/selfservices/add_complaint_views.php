<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8 ml-4 mt-3">
            <h2><a onclick="afterRenderFunction()" href="<?= base_url('selfservices/my_complaints') ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open('selfservices/add_new_complaint'); ?>

                                <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" name='employee_id' />
                                

                                <div class="form-group">

                                    <label class="required" for="input_title">Title</label>

                                    <input type="text" required class="form-control" name="title" id="input_title" enabled="" value="">

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_description">Description</label>

                                    <textarea required name="description" class="form-control" id="description" rows="4" cols="50" enabled=""></textarea>

                                </div>


                                <div class="file_uploader form-group" data-type="self_services">
                                     <label>Attachment</label>
                                    <input type="hidden" name="attachment" class="selected_images d-block w-100"/>
                                </div>

                                <label class="">Status</label>

                                <div class="form-group">

                                    <select class="form-control" name="status" id="input_status" enabled="">

                                        <option>Active</option>

                                        <option> Inactive</option>

                                    </select>

                                </div>

                                <div class="mr-2" style="float: right !important">

                                    <button type='submit' onclick="afterRenderFunction()" class="btn technos-button-blue shadow-none rounded " ;="">

                                        Submit</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('templates/jquery_link'); ?>

<?php

if ($this->session->flashdata('SUCC')) {

?>

    <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>

<?php

}

?>

<?php

if ($this->session->flashdata('ERR')) {

?>

    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',

            '',

            'error'

        )
    </script>

<?php

}

?>