<div class="form-group">
    <label class="" for="WRK_SHFT_INPF_NAME">Shift Code</label>
    <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_CODE" id="WRK_SHFT_INPF_CODE">
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="" for="WRK_SHFT_INPF_NAME">Shift Name
            </label>
            <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_NAME" id="WRK_SHFT_INPF_NAME">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label class="mb-1 mt-2" for="">Color</label>
            <div class="input-group ">
                <input type="text" name="shift_color" id="shift_color" class="form-control shift_color colorpicker">
                <!-- <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div> -->
                <div class="input-group-append" data-target="#shift_color" data-toggle="colorpicker">
                    <span class="input-group-text"><i class="fas fa-square color_data"
                            style="font-size: 20px"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div class="row">
<div class="col-12">
    <div class="form-group">
    <label class="required " for="WRK_SHFT_INPF_WORKING_HOURS">No. of Working Hours
    </label>
    <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_WORKING_HOURS" id="WRK_SHFT_INPF_WORKING_HOURS">
    </div>
</div>
</div> -->
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class=" " for="WRK_SHFT_INPF_TIME_IN">Shift Time In</label>
            <div class="input-group date time_picker" id="timepicker" data-target-input="nearest"
                style="width: 100% !important;">
                <input type="text" class=" form-control datetimepicker-input time_text mr-0"
                    name="WRK_SHFT_INPF_TIME_IN" data-target=".time_picker" placeholder="hr:min">
                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class="" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out </label>
            <div class="input-group date time_picker" id="timepicker2" data-target-input="nearest"
                style="width: 100% !important;">
                <input type="text" class=" form-control datetimepicker-input time_text mr-0"
                    name="WRK_SHFT_INPF_TIME_OUT" data-target="#timepicker2" id="time_text2" placeholder="hr:min">
                <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-clock"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="d-flex">
            <div class="icheck-primary d-inline float-left">
                <input type="checkbox" id="auto-generate" value="true" name="has_next_day">
                <label class="mb-2" for="auto-generate"> Next Day</label>
            </div>
        </div>
    </div>
</div>