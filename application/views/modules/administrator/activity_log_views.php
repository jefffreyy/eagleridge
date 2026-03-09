<html>
<?php $this->load->view('templates/css_link'); ?>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="col-md-6">
            <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Activity Logs</h1>
        </div>


        <hr>
        <div class="card p-0 mt-3">
            <table class="m-0 table table-hover" id="positions_tbl">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee ID</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($C_ACTIVITIES as $ACTIVITY_ROW) { ?>
                        <tr>
                            <!-- <td><?= date_format(date_create($ACTIVITY_ROW["create_date"]), $DATE_FORMAT . ' H:i:s A') ?></td> -->
                            <td ><?= date(($DATE_FORMAT ? $DATE_FORMAT : "d/m/Y") . " h:i a", strtotime($ACTIVITY_ROW["create_date"])) ?></td>
                            <td><?= getID($C_EMPLOYEES_ID, $ACTIVITY_ROW["empl_id"]) ?></td>
                            <td><?= $ACTIVITY_ROW["description"] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
function getID($listID, $userId)
{
    foreach ($listID as $ids) {
        if ($ids['id'] == $userId) {
            return $ids['col_empl_cmid'];
        }
    }
    return 'user not found';
}
?>
<?php $this->load->view('templates/jquery_link'); ?>

</html>