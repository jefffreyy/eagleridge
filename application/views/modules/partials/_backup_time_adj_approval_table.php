    <div class="table-responsive">
      <table class="table table-hover m-0" id="TableToExport" style="width:100%">
        <thead>
          <tr>
            <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
            <th class="text-center">ID</th>
            <th class="text-center" style='min-width:350px'>Employee</th>
            <th class="text-center">Type</th>
            <th class="text-center">&nbsp;Date</th>
            <th class="text-center">Time In</th>
            <th class="text-center">Time Out</th>
            <th class="text-center">Status</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody id="tbl_application_container">
          <?php if ($DISP_SHIFT) {
            foreach ($DISP_SHIFT as $DISP_SHIFT_ROW) { ?>
              <tr data-leave_id="<?= $DISP_SHIFT_ROW->id ?>" data-toggle="modal" data-target="#modal_approval" class="hover">
                <td class="text-center select-item-td" id="select_item" >
                  <input type="checkbox" name="approval_name" class="check_single" approval_id="<?= convert_cmid($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?>" employee_id="<?= $DISP_SHIFT_ROW->empl_id ?>" row_id="<?= $DISP_SHIFT_ROW->id ?>" value="<?= $DISP_SHIFT_ROW->empl_id ?>" checkbox_stat="">
                </td>
                <td class="text-center"><?=$PREFIX.str_pad($DISP_SHIFT_ROW->id, 5, '0', STR_PAD_LEFT) ?></td>
                <!-- <td class="text-center">LEA00<?= $DISP_SHIFT_ROW->id ?></td> -->
                <!-- <td class="text-center hover td-directs text-dark text-bold font-italic" -->
                <td class="text-center hover td-directs text-primary"
                 data-empl_id="<?= $DISP_SHIFT_ROW->empl_id ?>" >
                    <!-- <u><?= convert_cmid($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?> - <?= convert_data($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?></u> -->
                    <?= convert_cmid($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?> - <?= convert_data($DISP_EMPLOYEES, $DISP_SHIFT_ROW->empl_id) ?>
                </td>
                <td class="text-center"> <?= convert_type($DISP_TYPES, $DISP_SHIFT_ROW->type) ?></td>
                <td class="text-center"> <?= date("d/m/Y", strtotime($DISP_SHIFT_ROW->date)) ?> </td>
                <td class="text-center"> <?= $DISP_SHIFT_ROW->time_in_1 ?></td>
                <td class="text-center"> <?= $DISP_SHIFT_ROW->time_out_1 ?></td>
                <td class="text-center"> <?= $DISP_SHIFT_ROW->status ?></td>
                <td style="width:15%" class="text-center">
                  <!--<a class="select_row p-1 request_id btn btn-warning" href="<?= base_url() ?>selfservices/get_specific_leave_request/<?= $DISP_SHIFT_ROW->id ?>" id="view_button" data-toggle="modal" data-target="#modal_leave_request" leave_id="<?= $DISP_SHIFT_ROW->id; ?>"><i class="far fa-eye"></i></a>-->
                  <!--<button class="select_edit_row p-1 approved_data btn btn-success" href="" approved_id="<?= $DISP_SHIFT_ROW->id; ?>" row_id=""><i class="fas fa-check-circle" id="btn_approved"></i></button>-->
                  <!--<button  class="select_edit_row p-1 reject_data btn btn-danger " href="" reject_key="<?= $DISP_SHIFT_ROW->id; ?>" row_id=""><i class="fas fa-times-circle" id="btn_rejected"></i></button>-->
                  <a class="select_row p-1 request_id btn btn-warning" data-leave_id="<?= $DISP_SHIFT_ROW->id ?>" data-toggle="modal" data-target="#modal_approval">
                    <i class="far fa-eye"></i>
                  </a>
                </td>
              </tr>
            <?php
            }
          } else {
            ?>
            <tr class="table-active">
              <td colspan="12">
                <center>No Data</center>
              </td>
            </tr>
          <?php  } ?>
        </tbody>
      </table>
    </div>