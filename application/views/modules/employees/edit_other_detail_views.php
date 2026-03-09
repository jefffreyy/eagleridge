<html>

<?php $this->load->view('templates/css_link'); ?>



<div class="content-wrapper">

    <div class="container-fluid p-4">

        <div class="row pt-1">

            <div class="col-md-6">

                <h1 class="page-title"><a href="<?= base_url() ?>employees/personal?id=<?= $user_id ?>">

                    <img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">

                    </a>&nbsp;Edit Other Informations<h1>

            </div>

        </div>



        <div class="row mt-5 mx-auto justify-content-center">

            <div class="col-md-7">

                <div class="card p-3">

                    <form action="<?=site_url('employees/customize_form_field');?>" method="post" id="custom_field_options">

                        <input type="hidden" name="empl_id" value="<?=$user_id?>" />

                        <div class="form-group">

                            <label>

                                Custom Fields

                            </label>

                            <select class="custom_field form-control" name="fields[]" multiple="multiple">

<?php foreach($SETTINGS as $setting) {  ?>

                                <option value="<?=$setting->id?>" <?= in_array($setting->id,$EMPL_CUSTOM_INFO_ID)? 'selected' : '' ?>><?=$setting->name?></option>

<?php } ?>

                            </select>

                        </div> 

                    </form>

                    <form action="<?=site_url('employees/update_other_details')?>" method="POST">

                        <input type="hidden" name="empl_id" value="<?=$user_id?>" />

                        <div class="mt-3" id="container_form_field">  

<?php $index=0; foreach($EMPL_OTHER_INFO as $info) { ?>

                        

                        <div class="form-group">

                            <label class="required"><?=$info->field?></label>

                            <input type="hidden" name="field_data[<?=$index?>][empl_id]" value="<?=$user_id?>" />

                            <input type="hidden" name="field_data[<?=$index?>][custom_info_id]" value="<?=$info->custom_info_id?>" />

                            <input type="text"   class="form-control" name="field_data[<?=$index?>][value]" value="<?=$info->value?>" required >

                        </div>

<?php $index++; } ?>

                        </div>   

                        <button type="submit" class="btn btn-primary"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Upload</button>

                    </form>



                </div>

            </div>

        </div>

    </div>

</div>

<?php $this->load->view('templates/jquery_link'); ?>

<script>

    $(document).ready(function(){

        $(".custom_field").select2({

          theme: "classic"

        });

        $(".custom_field").on('change',function(){

            $.post("<?=site_url('employees/customize_form_field')?>",$('#custom_field_options').serialize(),function(res){

                $('#container_form_field').html(res);

            })

        })

    })

</script>

</body>



</html>