<?php
$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data ?? '');
$id_prefix = 'ADJ';
$TAB = 'active';
$STATUS='';
$ACTIVES = 0;
$INACTIVES = 0;
$current_page = $PAGE;
$next_page = $PAGE + 1;
$prev_page = $PAGE - 1;
$last_page = $PAGES_COUNT;
$row = $ROW;
$CUTOFF_ID=1;
if ($C_DATA_COUNT == 0) {
  $low_limit = 0;
} else {
  $low_limit = $row * ($current_page - 1) + 1;
}
if ($current_page * $row > $C_DATA_COUNT) {
  $high_limit = $C_DATA_COUNT;
} else {
  $high_limit = $row * ($current_page);
}
$_activity_id=$ACTIVITY->id;
?>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Activity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <div class="row">
                <div class="col-2 m-0">
                    <p class="h6">Title</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?=$ACTIVITY->title?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Location</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?=$ACTIVITY->location?></p>
                </div>
                <div class="col-2 m-0">
                    <p class="h6">Duration</p>
                </div>
                <div class="col-4 m-0">
                    <p class="m-0"><?=$ACTIVITY->duration?></p>
                </div>
                <div class="col-2">
                    <p class="h6">Status:</p>
                </div>
                <div class="col-4">
                    <p>
            <?php if($ACTIVITY->status=='Upcoming'){ ?>
                    <span class='btn btn-sm btn-info disabled'>Upcoming</span>
            <?php } elseif($ACTIVITY->status=='Cancelled') { ?>
                <span class='btn btn-sm btn-secondary disabled'>Cancelled</span>
            <?php } elseif ($ACTIVITY->status=='Ongoing') {  ?>
                <span class='btn btn-sm btn-primary disabled'>Ongoing</span>
            <?php } elseif ($ACTIVITY->status=='Ended') { ?>
                <span class='btn btn-sm btn-danger disabled'>Ended</span>
            <?php } else { ?>
                <span class='btn btn-sm btn-secondary disabled'>Unknown Status</span>
            <?php } ?>
                    </p>
                </div>
            </div>
            <div class="container-fluid">
                <div>
                    <div class="">
                        <div class="pb-2 d-flex align-items-center justify-content-end">
                            <div class="d-flex">
                                <div class="d-flex align-items-center">
                                    <p class="my-auto d-inline" style="color: gray">Showing <?= $low_limit ?> to
                                        <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                                    <ul class="d-inline pagination m-0 p-0 ">
                                        <li class="nav-link-_activity_participants"><a
                                                <?php if ($current_page > 1) echo "href=".$_activity_id."'?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                                                < </a>
                                        </li>
                                        <li class="nav-link-_activity_participants"><a href="<?=$_activity_id?>?cutoff=<?= $CUTOFF_ID ?>&page=1&row=<?= $row ?>"
                                                <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                        <li class="nav-link-_activity_participants"><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                        <li class="nav-link-_activity_participants"><a href="<?=$_activity_id?>?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>"
                                                <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a>
                                        </li>
                                        <li class="nav-link-_activity_participants"><a style="color:white ; background-color:#007bff !important">
                                                <?= $current_page ?> </a></li>
                                        <li class="nav-link-_activity_participants"><a href="<?=$_activity_id?>?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>"
                                                <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?>
                                            </a></li>
                                        <li class="nav-link-_activity_participants"><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a>
                                        </li>
                                        <li class="nav-link-_activity_participants"><a href="<?=$_activity_id?>?cutoff=<?= $CUTOFF_ID ?>&page=<?= $last_page ?>&row=<?= $row ?>"
                                                <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?>
                                            </a></li>
                                        <li class="nav-link-_activity_participants"><a style="margin-right: 10px;"
                                                <?php if ($current_page < $last_page)   echo "href='$_activity_id?cutoff=$CUTOFF_ID&page=$next_page&row=$row'"; ?>>>
                                            </a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                                <select id="row_dropdown" class="custom-select" style="width: auto;">
                                    <?php
            foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                                    <option value=<?= $C_ROW_DISPLAY_ROW ?>
                                        <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>>
                                        <?= $C_ROW_DISPLAY_ROW ?> </option>
                                    <?php
            } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered m-0" id="table_main" style="width:100%">
                            <thead>
                                <th colspan=7 class="text-center">Participants</th>
                            </thead>
                            <thead>
                                <th>Employee ID</th>
                                <th>Employee</th>
                                <th>Response</th>
                            </thead>
                            <tbody id="tbl_application_container">
<?php if ($TABLE_DATA) {  ?>
<?php foreach($TABLE_DATA as $_row_data) : ?>
                            <tr>
                                <td><?=$_row_data->col_empl_cmid?></td>
                                <td><?=$_row_data->employee?></td>
                                <td><?=$_row_data->response ? $_row_data->response : 'Pending reponse' ?></td>
                                
                            </tr>
<?php endforeach ?>
<?php } else { ?>
                                <tr class="table-active">
                                    <td colspan="12">
                                        <center>No Records</center>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>