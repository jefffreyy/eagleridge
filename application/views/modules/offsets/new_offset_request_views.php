<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a href="<?= base_url() . 'offsets/offset_lists'; ?>"><i class="fa-duotone fa-circle-left"></a></i></h2>
        </div>
    </div>
    <div class="container-fluid px-4">
        <div class="row d-flex justify-content-center">

            <div class="col-sm-6">

                <div class="card">

                    <div class="modal-body pb-5">

                        <div class="row">

                            <div class="col-md-12">

                                <?php echo form_open('offsets/add_new_offset'); ?>

                                <!--<label class="">Assigned by</label>-->

                                <!--<select class="form-control custom_selection" name="assigned_by" id="input_assigned_by">-->


                                <!--</select>-->



                                <label class="">Employee</label>

                                <select class="form-control custom_selection" name="empl_id" id="input_empl_id">
                                    <?php foreach($EMPLOYEES as $employee) { 
                                        $name = $employee->col_empl_cmid.'-'.$employee->col_last_name;
                                        if($employee->col_suffix)$name = $name.' '.$employee->col_suffix;
                                        if($employee->col_frst_name)$name = $name.', '.$employee->col_frst_name;
                                        if($employee->col_midl_name)$name = $name.' '.$employee->col_midl_name[0].'.';
                                        ?>
                                        <option value="<?=$employee->id?>"> 
                                        <?= $name
                                        // $employee->col_empl_cmid.' - '. $employee->col_last_name.' '. $employee->col_frst_name
                                        ?></option>     
                                    <?php } ?>

                                </select>

                                <label class="">Type</label>

                                <div class="form-group">

                                    <select class="form-control" name="type" id="type" enabled="">

                                        <?php foreach ($OFFSET_TYPES as $type) { ?>

                                            <option value='<?= $type->id ?>' data-name='<?= $type->name ?>' ><?= $type->name ?></option>



                                        <?php } ?>

                                    </select>

                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_offset_date">Offset Date</label>

                                    <input type="date" class="form-control" name="offset_date" id="input_offset_date" required enabled="" value="">
                                    <div style="font-size: 14px">
                                        <p style="font-weight: 500">Balance: <span id="diplayBalance" style="font-weight:400">select valid date</span></p> 
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="required" for="input_duration">Offset Duration (Hours)</label>

                                    <input type="number" class="form-control " min="0" name="duration" id="input_duration" enabled="" value="" required>
                                    <div style="font-size: 14px">
                                        <p style="font-weight: 500">Balance: <span id="diplayBalanceAfter" style="font-weight:400">select valid date</span></p> 
                                    </div>    
                                </div>
                                <div class="form-group">

                                    <label class="" for="input_reason">Reason</label>

                                    <textarea name="reason" class="form-control" id="remarks" rows="4" cols="50"

                                        enabled=""></textarea>

                                </div>

                                <!--<div class="form-group">-->

                                <!--    <label class="" for="input_attachment">Attachment</label>-->

                                <!--    <input type="file" class="form-control file_upload" name="attachment" id="input_attachment" enabled="" value="">-->

                                <!--</div>-->
                                <div class="file_uploader form-group" data-type="offset" >
                                     <label>Attachment</label>
                                    <input type="hidden" name="attachment" class="selected_images d-block w-100" />
                                </div>

                                <div class="mr-2" style="float: right !important">

                                    <button type='submit' id="btn_add" class="btn technos-button-blue shadow-none rounded " ;="">

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

<script>
    // $(document).ready(function() {

    //     // $('.custom_selection').select2()
        
    //     const input_empl_id = document.getElementById('input_empl_id');
    //     input_empl_id.addEventListener('change', (event) => {
    //     getRequestLeaveBalance();
    //     });
    //     $('#input_empl_id').select2();
    // })
    $(document).ready(function() {
    $('#input_empl_id').select2();

    $('#input_empl_id').on('select2:select', function (event) {
        getRequestLeaveBalance();
    });
});

</script>

<script>
    var baseUrl = '<?= base_url() ?>';
    const apiUrl = baseUrl + 'offsets/get_request_offset_by_date';
    const input_empl_id = document.getElementById('input_empl_id');
    const input_type = document.getElementById('type');
    const input_offset_date = document.getElementById('input_offset_date');
    const input_duration = document.getElementById('input_duration');

    input_type.addEventListener('change', (event) => {
        getRequestLeaveBalance();
    });
    input_offset_date.addEventListener('change', (event) => {
        getRequestLeaveBalance();
    });
    input_duration.addEventListener('change', (event) => {
        console.log('diplayBalance',document.getElementById('diplayBalance').textContent)
        console.log('input_duration',input_duration.value)
        if( !(document.getElementById('diplayBalance').textContent !== undefined && 
            document.getElementById('diplayBalance').textContent !== null && 
            document.getElementById('diplayBalance').textContent !== '' && 
            !isNaN(document.getElementById('diplayBalance').textContent))
            ){
                document.getElementById('diplayBalanceAfter').textContent = 'select valid date';
                return;
            }
        if (
            !(input_duration.value !== undefined &&
            input_duration.value !== null &&
            input_duration.value !== '' &&
            !isNaN(input_duration.value))
            ) {
                document.getElementById('diplayBalanceAfter').textContent = 'input duration'; return;
        }

        document.getElementById('diplayBalanceAfter').textContent = document.getElementById('diplayBalance').textContent - input_duration.value;
    });

    function getRequestLeaveBalance(){
        const empl_id = input_empl_id.value;
        const type = input_type.value;
        const typeName = input_type.selectedOptions[0].dataset.name;
        // const selectedOption = document.getElementById('type').selectedOptions[0];
        // const name = selectedOption.dataset.name;
        const offset_date = input_offset_date.value;
        const duration = input_duration.value;
        if (empl_id && type && offset_date) {
            fetch(apiUrl, {
                method: 'POST',
                body: JSON.stringify({empl_id,type,offset_date,typeName}),
                headers: {
                    'Content-Type': 'application/json'
            }
            })
            .then(response => response.json())
            .then(data => {
                console.log('data',data);
                if (data.messageError) {
                    document.getElementById('diplayBalance').textContent = data.messageError;
                    document.getElementById('diplayBalanceAfter').textContent = data.messageError;
                    // console.log('Error');
                }else if (data.balance !== undefined && data.balance !== null) {
                    document.getElementById('diplayBalance').textContent = data.balance;
                    // console.log('Error');
                    if (input_duration.value) {
                        document.getElementById('diplayBalanceAfter').textContent = data.balance - input_duration.value;
                    }else{
                        document.getElementById('diplayBalanceAfter').textContent = 'input duration';
                    }
                } else {
                console.log('unexpected output occured');
                document.getElementById('diplayBalance').textContent = '';
                document.getElementById('diplayBalanceAfter').textContent = '';
                }
            })
            .catch(error => {
                console.error('Error sending date to controller:', error); 
            });
        }
    }
</script>

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



