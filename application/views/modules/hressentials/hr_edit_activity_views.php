<?php $this->load->view('templates/css_link'); ?>
<style>
    .select2-container .select2-selection--multiple{
        max-height:300px !important;
        overflow:auto;
    }
</style>
<div class="content-wrapper" style="min-height: 624px;">

    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'hressentials/activities'; ?>">
                <img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="container-fluid px-4">

        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <?php echo form_open('hressentials/update_activity/'.$ACTIVITY->id); ?>
                                
                                    
                                <div class="form-group">

                                    <label class="required" for="input_title">Title</label>

                                    <input  type="text" class="form-control" name="title" id="input_title" enabled="" value="<?=$ACTIVITY->title?>">

                                </div>
                                <div class="form-group">

                                    <label class="required" for="input_title">Duration</label>

                                    <input type="text" class="form-control" name="duration" value="<?=$ACTIVITY->duration?>" id="input_duration" />

                                </div>
                                <div class="form-group">

                                    <label class="required" for="input_title">Location</label>

                                    <input type="text" class="form-control" name="location" id="input_location" value="<?=$ACTIVITY->location?>">

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_description">Description</label>

                                    <textarea name="description" name="description" class="form-control" id="input_description"><?=$ACTIVITY->description?></textarea>

                                </div>

                                <div class="form-group">
                                    <label class="">Participants</label>
                                    <label class="d-flex align-items-center">
                                       
                                        <input type="checkbox" <?=count($EMPLOYEES)==count(json_decode($ACTIVITY->participants))? 'checked' : '' ?>  class="mr-2 mb-0"  id="check-select_all"> 
                                        <span style="font-size:12px">Select All Employee</span>
                                    </label>
                                    
                                    <select multiple="multiple" class="form-control custom_selection" name="participants[]" id="input_employee_id">
                                        <?php foreach ($EMPLOYEES as $employee) {
                                            $name=$employee->col_empl_cmid.'-'.$employee->col_last_name;
                                            if(!empty($employee->col_suffix))$name=$name.' '.$employee->col_suffix;
                                            if(!empty($employee->col_frst_name))$name=$name.', '.$employee->col_frst_name;
                                            if(!empty($employee->col_midl_name))$name=$name.' '.$employee->col_midl_name[0].'.';
                                            ?>
    
                                            <option value="<?= $employee->id ?>" <?= in_array($employee->id ,json_decode($ACTIVITY->participants))? 'selected' :  '';?>>
                                            <?= $name?></option>
    
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="required">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Upcoming">Upcoming</option>
                                        <option value="Ongoing" <?=$ACTIVITY->status=='Ongoing'? 'selected' : '' ?>>Ongoing</option>
                                        <option value="Cancelled" <?=$ACTIVITY->status=='Cancelled'? 'selected' : '' ?>>Cancelled</option>
                                        <option value="Ended" <?=$ACTIVITY->status=='Ended'? 'selected' : '' ?>>Ended</option>
                                    </select>
                                </div>
                                <div class="mr-2" style="float: right !important">

                                    <button type='submit' class="btn technos-button-blue shadow-none rounded ">

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
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php
}
?>


<?php
if ($this->session->flashdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
}
?>


<script>
    $(document).ready(function() {
        
        let duration_select = $('.custom_selection').select2({theme: "classic"});
        $('input#input_duration').daterangepicker({
            timePicker: true,
            locale: {
            format: 'MM/DD/YYYY HH:mm:ss'
            }
        });
        $('#check-select_all').on("change",function(){
            var isChecked = $(this).prop("checked");
            var select2Instance = $("#input_employee_id").data("select2");
            var options = select2Instance.$element.find("option")
            var option_values=[];
            for(let i=0;i<options.length;i++){
                let value=$(options[i]).attr('value')
                option_values.push(value);
            }
            duration_select.val(option_values).trigger("change");
            if(!isChecked){
                duration_select.val([]).trigger("change");
            }
        })
    })
</script>