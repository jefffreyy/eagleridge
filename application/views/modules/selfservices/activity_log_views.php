<html>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="title d-inline">

            <a href="<?= base_url() . 'selfservices'; ?>"><i class=" pl-0 h4 fa-duotone  fa-circle-left"></i>
                <h1 class="page-title mb-3 d-inline"> &nbsp;Activity Logs</h1>

        </div>
        <hr>
        <div class="card p-0 mt-3">
            <table class="m-0 table table-hover" id="positions_tbl">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($C_ACTIVITIES as $ACTIVITY_ROW) { ?>
                        <tr>
                            <td><?= date_format(date_create($ACTIVITY_ROW["create_date"]), "M d Y  h:i a") ?></td>
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