<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 624px;">

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <!-- <h2><a href="<?= base_url('companies/knowledges_bases'); ?>"><i class="fa-duotone fa-circle-left"></a></i></h2> -->
            <h2><a href="<?= base_url() . 'companies/knowledges_bases'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
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
                                    <label class="required" for="input_employee">Employee</label>
                                    <select disabled class="form-control" name="employee_id">
                                        <option><?=$KNOWLEDGE_BASE->employee?></option>
                                    </select>
                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_title">Title</label>

                                    <input type="text" disabled class="form-control" name="title" id="input_title" enabled="" value="<?=$KNOWLEDGE_BASE->title?>">

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_description">Description</label>

                                    <textarea disabled name="description" class="form-control" id="input_description" rows="4" cols="50"><?=$KNOWLEDGE_BASE->description?></textarea>

                                </div>
                                


                                <!--<div class="form-group">-->

                                <!--    <label class="" for="input_attachment">Attachment(PNG,JPG,JPEG)</label>-->

                                <!--    <input type="file" class="form-control file_upload" name="attachment" id="input_attachment" enabled="" value="">-->

                                <!--</div>-->
                                <div class="form-group">
                                    <label class="" for="input_attachment">Attachment</label>
                                    <div class="file_uploader disabled" data-type="hressentials">
                                        <input type="hidden" name="attachment" value="<?=$KNOWLEDGE_BASE->attachment?>" class="selected_images d-block w-100"/>
                                    </div>
                                    <!--<a class="d-block h6"><?=$KNOWLEDGE_BASE->attachment?></a>-->
                                </div>
                                <div class="form-group">
                                    <label  for="input_feedback">Feedback</label>
                                    <textarea name="feedback" disabled class="form-control" id="input_feedback" rows="4" cols="50" enabled=""><?=$KNOWLEDGE_BASE->feedback?></textarea>
                                </div>

                                <label class="">Status</label>

                                <div class="form-group">

                                    <select class="form-control" name="status" id="input_status" disabled>
                                        <option><?=$KNOWLEDGE_BASE->status?></option>
                                    </select>

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