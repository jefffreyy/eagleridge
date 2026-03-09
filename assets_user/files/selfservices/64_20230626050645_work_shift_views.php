<html>
<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
$id_code = "SHF";
?>

<div class="content-wrapper">
    <div class="p-3">
        <div class="flex-fill">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>attendances">Attendance
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Work Shifts
                    </li>
                </ol>
            </nav>
            <div class="row pr-3 mb-2">
                <div class="col">
                    <h1 class="page-title">Work Shifts
                    </h1>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <form class="new_q" id="new_q" action="#" accept-charset="UTF-8" method="get">
                        <div class="form-row align-items-center">
                            <div class="col mb-1">
                                <input autofocus="autofocus" class="form-control" placeholder="Search..." type="search" name="work_pattern_search" id="work_pattern_search">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 button-title">
                    <a href="#" class="btn btn-primary shadow-none" id="btn_export"><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>
                </div>
                <div>
                    <a class="btn btn-primary float-right" title="Add" href="#" data-toggle="modal" data-target="#modal_add_work_shift" id="add">
                        <i class="fas fa-fw fa-plus">
                        </i> Add
                    </a>
                </div>
            </div>
            <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table table-hover" id="TableToExport">
                                <thead>
                                    <!-- Table Headers -->
                                    <th>Shift ID</th>
                                    <th>Shift&nbsp;Code</th>
                                    <th>Shift&nbsp;Name</th>
                                    <th>Shift&nbsp;Time&nbsp;In&nbsp;1</th>
                                    <th>Shift&nbsp;Time&nbsp;Out&nbsp;1</th>
                                    <th>Shift&nbsp;Time&nbsp;In&nbsp;2</th>
                                    <th>Shift&nbsp;Time&nbsp;Out&nbsp;2</th>
                                    <th>Next&nbsp;Day</th>
                                    <th class="text-center">Color</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($DISP_WRK_SHFT_INFO) {
                                        foreach ($DISP_WRK_SHFT_INFO as $ROW_WRK_SHFT_INFO) {
                                            $application_id = $id_code . str_pad($ROW_WRK_SHFT_INFO->id, 5, '0', STR_PAD_LEFT);
                                    ?>
                                            <tr>
                                                <td>
                                                    <?= $application_id ?>
                                                </td>
                                                <td>
                                                    <?= $ROW_WRK_SHFT_INFO->code ?>
                                                </td>
                                                <td>
                                                    <?= $ROW_WRK_SHFT_INFO->name ?>
                                                </td>
                                                <td>
                                                    <?php echo ($ROW_WRK_SHFT_INFO->fixed ? '' : $ROW_WRK_SHFT_INFO->time_in) ?>
                                                </td>
                                                <td>
                                                    <?php echo ($ROW_WRK_SHFT_INFO->fixed ? '' :  $ROW_WRK_SHFT_INFO->time_out) ?>
                                                </td>
                                                <td>
                                                    <?php echo ($ROW_WRK_SHFT_INFO->fixed ? '' :  $ROW_WRK_SHFT_INFO->time_in_2) ?>
                                                </td>
                                                <td>
                                                    <?php echo ($ROW_WRK_SHFT_INFO->fixed ? '' :  $ROW_WRK_SHFT_INFO->time_out_2) ?>
                                                </td>
                                                <td>
                                                    <?php if (!$ROW_WRK_SHFT_INFO->fixed) {
                                                        if ($ROW_WRK_SHFT_INFO->next_day == 'true') {
                                                            echo 'Yes';
                                                        } else {
                                                            echo 'No';
                                                        }
                                                    } ?>
                                                </td>
                                                <td>
                                                    <?php if (!$ROW_WRK_SHFT_INFO->fixed) { ?>
                                                        <center>
                                                            <p style="width: 50px; height 50px; background-color: <?= $ROW_WRK_SHFT_INFO->color ?>;">
                                                                &nbsp;</p>
                                                        </center>
                                                    <?php  } ?>
                                                </td>

                                                <td class="">
                                                    <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                                                        <div class="btn-group mr-2 btn-group-sm" role="group" aria-label="First group" <?php echo ($ROW_WRK_SHFT_INFO->fixed ? 'hidden' : '') ?>>
                                                            <a class="btn btn-sm indigo lighten-2 edit_workshift" href="<?= base_url() ?>attendances/edit_work_shift/<?= $ROW_WRK_SHFT_INFO->id ?>" work_shift_id="<?= $ROW_WRK_SHFT_INFO->id ?>" title="Edit" data-toggle="modal" data-target="#modal_edit_work_shift">
                                                                <i class="fas fa-edit" id="edit">
                                                                </i>
                                                            </a>
                                                            <a class="btn btn-sm indigo lighten-2 text-danger WRK_SHFT_BTN_DLT" delete_key="<?= $ROW_WRK_SHFT_INFO->id ?>">
                                                                <i class="fas fa-trash" id="trash">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    } else { ?>

                                        <!-- Message if no entries -->
                                        <tr class="table-active">
                                            <td colspan="9">
                                                <center>No Data Yet</center>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- flex-fill -->
    </div>
    <!-- p-3 -->
</div>
<!-- content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<!-- Add position -->
<div class="modal fade" id="modal_add_work_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Add Work Shifts
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <form action="<?php echo base_url('attendances/insrt_work_shift'); ?>" id="WRK_SHFT_FORM_ADD" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="" for="WRK_SHFT_INPF_NAME">Shift Code</label>
                                <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_CODE" id="wrk_shft_inpf_code">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="" for="WRK_SHFT_INPF_NAME">Shift Name
                                        </label>
                                        <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_NAME" id="wrk_shft_inpf_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-1 mt-2" for="">Color</label>
                                        <div class="input-group ">
                                            <input type="text" name="shift_color" id="shift_color" class="form-control shift_color colorpicker">
                                            <div class="input-group-append" data-target="#shift_color" data-toggle="colorpicker">
                                                <span class="input-group-text"><i class="fas fa-square color_data" style="font-size: 20px"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class=" " for="WRK_SHFT_INPF_TIME_IN">Shift Time In 1</label>
                                        <div class="input-group date time_picker" id="timepicker" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_IN" data-target=".time_picker" placeholder="hr:min" id="time_text1">
                                            <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out 1</label>
                                        <div class="input-group date time_picker" id="timepicker2" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_OUT" data-target="#timepicker2" id="time_text2" placeholder="hr:min">
                                            <div class="input-group-append" data-target="#timepicker2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class=" " for="WRK_SHFT_INPF_TIME_IN_2">Shift Time In 2</label>
                                        <div class="input-group date time_picker" id="timepicker_in_2" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_IN_2" data-target=".time_picker" placeholder="hr:min" id="time_text1">
                                            <div class="input-group-append" data-target="#timepicker_in_2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="" for="WRK_SHFT_INPF_TIME_OUT_2">Shift Time Out 2</label>
                                        <div class="input-group date time_picker" id="timepicker_out_2" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" name="WRK_SHFT_INPF_TIME_OUT_2" data-target="#timepicker_out_2" id="time_text2" placeholder="hr:min">
                                            <div class="input-group-append" data-target="#timepicker_out_2" data-toggle="datetimepicker">
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
                                            <label class="mb-2" for="auto-generate" id="next_day"> Next Day</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class='btn btn-primary text-light' id="WRK_SHFT_BTN_SAVE">&nbsp; Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit position -->
<div class="modal fade" id="modal_edit_work_shift" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pb-0" style="border-bottom: none;">
                <h4 class="modal-title ml-1" id="exampleModalLabel">Edit Work Shifts
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;
                    </span>
                </button>
            </div>
            <form action="<?php echo base_url('attendances/updt_work_shift'); ?>" id="WRK_SHFT_FORM_UPDT" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="" for="WRK_SHFT_INPF_NAME">Shift Code</label>
                                <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_CODE" id="WRK_SHFT_INPF_CODE_upt">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="" for="WRK_SHFT_INPF_NAME">Shift Name
                                        </label>
                                        <input class="form-control form-control " type="text" name="WRK_SHFT_INPF_NAME" id="WRK_SHFT_INPF_NAME_upt">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-1 mt-2" for="">Color</label>
                                        <div class="input-group ">
                                            <input type="text" name="shift_color" id="shift_color_upt" class="form-control shift_color colorpicker_upt">
                                            <!-- <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-clock"></i></div>
                              </div> -->
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-square color_data_upt" style="font-size: 20px"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class=" " for="WRK_SHFT_INPF_TIME_IN">Shift Time In 1</label>
                                        <div class="input-group date time_picker" id="timepicker_upt" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" id='shift_time_in_upt' name="WRK_SHFT_INPF_TIME_IN" data-target="#timepicker_upt" placeholder="hr:min">
                                            <div class="input-group-append" data-target="#timepicker_upt" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="" for="WRK_SHFT_INPF_TIME_OUT">Shift Time Out 1</label>
                                        <div class="input-group date time_picker" id="timepicker_out_upt" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" id='shift_timeout_upt' name="WRK_SHFT_INPF_TIME_OUT" data-target="#timepicker_out_upt" id="time_text_out_upt" placeholder="hr:min">
                                            <div class="input-group-append" data-target="#timepicker_out_upt" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class=" " for="WRK_SHFT_INPF_TIME_IN_2">Shift Time In 2</label>
                                        <div class="input-group date time_picker" id="timepicker_upt_2" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" id='shift_time_in_upt_2' name="WRK_SHFT_INPF_TIME_IN_2" data-target="#timepicker_upt_2" placeholder="hr:min">
                                            <div class="input-group-append" data-target="#timepicker_upt_2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="" for="WRK_SHFT_INPF_TIME_OUT_2">Shift Time Out 2</label>
                                        <div class="input-group date time_picker" id="timepicker_out_upt_2" data-target-input="nearest" style="width: 100% !important;">
                                            <input type="text" class=" form-control datetimepicker-input time_text mr-0" id='shift_timeout_upt_2' name="WRK_SHFT_INPF_TIME_OUT_2" data-target="#timepicker_out_upt_2" id="time_text_out_upt_2" placeholder="hr:min">
                                            <div class="input-group-append" data-target="#timepicker_out_upt_2" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p></p>
                                    <div class="">
                                        <div class="icheck-primary d-inline float-left">
                                            <input type="checkbox" id="next_day_upt" value="true" name="has_next_day">
                                            <label class="mb-2" for="next_day_upt"> Next Day</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <input type="hidden" id="UPDT_WRK_SHFT_INPF_ID" name="WRK_SHFT_INPF_ID">
                        <button class='btn btn-primary text-light' id="UPDT_WRK_SHFT_BTN_SAVE">&nbsp;
                            Save</button>
                    </div>

                </div>
        </div>
    </div>

    </form>
</div>
</div>
<!-- LOGOUT MODAL -->
<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p style="font-size: 20px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?
                </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-white">&times;
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <p>Hi are you sure you want to logout?
                </p>
            </div>
            <div class="modal-footer pb-1 pt-1">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                </button>
                <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout
                </a>
            </div>
        </div>
    </div>
</div>



<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js">
</script>
<!-- Initialize the editor. -->
<script>
    $(function() {
        $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'strikeThrough', 'subscript',
                'superscript', 'outdent', 'indent', 'clearFormatting', 'html'
            ],
            toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'html']
        })
        $('i.fa.fa-rotate-left').attr('class')
    });
</script>
<!-- SESSION MESSAGES -->

<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('SESS_SUCC_MSG_INSRT_WRK_SHFT');
}
?>


<?php
if ($this->session->flashdata('SESS_SUCC_MSG_UPDT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SESS_SUCC_MSG_UPDT_WRK_SHFT'); ?>'
      })
</script>
<?php
}
?>


<?php
if ($this->session->flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-danger toast_width',
        title: 'Unable to Update',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SESS_ERROR_MSG_UPDT_WRK_SHFT'); ?>'
      })
</script>
<?php
}
?>

<?php
if ($this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT'); ?>'
      })
</script>
<?php
}
?>

<!-- <?php
if ($this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->flashdata('SESS_SUCC_MSG_DLT_WRK_SHFT'); ?>',
            '',
            'success'
        )
    </script>
<?php
}
?> -->

<script>
    $(document).ready(function() {
        // Color picker init (add modal)
        //color picker with addon
        $('.shift_color').colorpicker();
        $('.shift_color').on('change', function() {
            $('.color_data').css('color', $(this).val());
        })
        // $('.shift_color').on('colorpickerChange', function(event) {
        //   console.log("asdabsj");
        //   console.log($(this).val())
        //   $('.color_data').css('color', $(this).val());
        // });
        //Timepicker
        // $('#time_picker').datetimepicker({
        //   stepping: 30,
        //   format: 'LT'
        // })
        $('.time_picker').datetimepicker({
            stepping: 30,
            format: 'LT'
        })
        // $('#timepicker2').datetimepicker({
        //   stepping: 30,
        //   format: 'LT'
        // })
        // $('#timepicker7').datetimepicker({
        //   stepping: 30,
        //   format: 'LT'
        // })
        // Color picker init (update modal)
        //color picker with addon
        $('.updt-my-colorpicker2').colorpicker()
        $('.updt-my-colorpicker2').on('colorpickerChange', function(event) {
            $('.updt-my-colorpicker2 .fa-square').css('color', event.color.toString());
        });
        //Timepicker
        $('#updt_timepicker').datetimepicker({
            stepping: 30,
            format: 'LT'
        })
        $('#updt_timepicker2').datetimepicker({
            stepping: 30,
            format: 'LT'
        })
        $('#updt_timepicker7').datetimepicker({
            stepping: 30,
            format: 'LT'
        })
        // Get & Display Data to Edit Modal Using Async JS function
        $('.edit_workshift').on('click', function() {
            console.log("fasfv")
            let url = $(this).attr('href');
            fetch(url)
                .then((res) => res.json())
                .then((data) => {
                    console.log(data)
                    $('#WRK_SHFT_INPF_CODE_upt').val(data['code']);
                    $('#WRK_SHFT_INPF_NAME_upt').val(data['name']);
                    $('#shift_color_upt').val(data['color']);
                    $('.color_data_upt').css("color", data['color']);
                    $('#shift_time_in_upt').val(data['time_in']);
                    $('#shift_timeout_upt').val(data['time_out']);
                    $('#shift_time_in_upt_2').val(data['time_in_2']);
                    $('#shift_timeout_upt_2').val(data['time_out_2']);
                    $('#shit_ot_out').val(data['time_out_ot']);
                    $('#UPDT_WRK_SHFT_INPF_ID').val(data['id']);
                    if (data['has_break']) {
                        $('#break_time_upt').prop('checked', true);
                    }
                    if (data['next_day']) {
                        $('#next_day_upt').prop('checked', true);
                    }
                    $('#night_shift_upt')

                })
                .catch((err) => {
                    console.log(err)
                })
        })
        // Update Position
        $('#WRK_SHFT_BTN_UPDT').click(function() {
            var work_shift_name = $('#UPDT_WRK_SHFT_INPF_NAME').val();
            var hasErr = 0;
            if (!work_shift_name) {
                hasErr++;
            }
            if (hasErr == 0) {
                Swal.fire({
                    title: 'Do you want to save the following changes?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#WRK_SHFT_FORM_EDIT').submit();
                    }
                })
            } else {
                $('#UPDT_WRK_SHFT_INPF_NAME').addClass('is-invalid');
            }
        })
        $('#UPDT_WRK_SHFT_INPF_NAME').keyup(function() {
            $('#UPDT_WRK_SHFT_INPF_NAME').removeClass('is-invalid');
        })
        // Delete Position
        $('.WRK_SHFT_BTN_DLT').click(function(e) {
            e.preventDefault();
            var user_deleteKey = $(this).attr('delete_key');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href =
                        "<?= base_url(); ?>attendances/dlt_work_shift?delete_id=" +
                        user_deleteKey;
                }
            })
        })
    })
</script>
<!-------------------- Export ----------------->
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById("btn_export").addEventListener('click', function() {
        /* Create worksheet from HTML DOM TABLE */
        var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
        /* Export to file (start a download) */
        XLSX.writeFile(wb, "Workshift.xlsx");
    });
</script>
</body>

</html>
​