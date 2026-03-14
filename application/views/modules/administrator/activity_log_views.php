<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$current_page = $PAGE;
$next_page = $PAGE + 1;
$prev_page = $PAGE - 1;
$last_page = $PAGES_COUNT;
$row = $ROW;
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
?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="col-md-6">
            <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Activity Logs</h1>
        </div>

        <hr>

        <div class="d-flex align-items-center gap-3 mb-3">
            <div>
                <label class="mb-1">Employee</label>
                <select class="form-control select_employee" style="min-width:200px;">
                    <option value="">All</option>
                    <?php foreach ($C_EMPLOYEES_ID as $emp) { ?>
                        <option value="<?= $emp['id'] ?>" <?= ($EMPLOYEE_FILTER == $emp['id']) ? 'selected' : '' ?>><?= $emp['col_empl_cmid'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="card p-0 mt-3">
            <table class="m-0 table table-hover" id="positions_tbl">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee ID</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Computer Name</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($C_ACTIVITIES as $ACTIVITY_ROW) { ?>
                        <tr>
                            <td><?= date(($DATE_FORMAT ? $DATE_FORMAT : "d/m/Y") . " h:i a", strtotime($ACTIVITY_ROW["create_date"])) ?></td>
                            <td><?= getID($C_EMPLOYEES_ID, $ACTIVITY_ROW["empl_id"]) ?></td>
                            <td><?= $ACTIVITY_ROW["description"] ?></td>
                            <td><?= isset($ACTIVITY_ROW["ip_address"]) ? $ACTIVITY_ROW["ip_address"] : '' ?></td>
                            <td><?= isset($ACTIVITY_ROW["computer_name"]) ? $ACTIVITY_ROW["computer_name"] : '' ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                <span>Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries</span>
                &nbsp;
                <select class="form-control d-inline-block select_row" style="width:auto;">
                    <?php foreach ($C_ROW_DISPLAY as $r) { ?>
                        <option value="<?= $r ?>" <?= ($row == $r) ? 'selected' : '' ?>><?= $r ?></option>
                    <?php } ?>
                </select>
            </div>
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= base_url('administrators/activity_logs?page=1&row=' . $row . '&employee=' . $EMPLOYEE_FILTER) ?>">First</a>
                    </li>
                    <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= base_url('administrators/activity_logs?page=' . $prev_page . '&row=' . $row . '&employee=' . $EMPLOYEE_FILTER) ?>">Prev</a>
                    </li>
                    <li class="page-item active">
                        <span class="page-link"><?= $current_page ?> / <?= $last_page ?></span>
                    </li>
                    <li class="page-item <?= ($current_page >= $last_page) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= base_url('administrators/activity_logs?page=' . $next_page . '&row=' . $row . '&employee=' . $EMPLOYEE_FILTER) ?>">Next</a>
                    </li>
                    <li class="page-item <?= ($current_page >= $last_page) ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= base_url('administrators/activity_logs?page=' . $last_page . '&row=' . $row . '&employee=' . $EMPLOYEE_FILTER) ?>">Last</a>
                    </li>
                </ul>
            </nav>
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

<script>
$(document).ready(function() {
    function buildUrl(params) {
        var base = '<?= base_url("administrators/activity_logs") ?>';
        var employee = params.employee !== undefined ? params.employee : '<?= $EMPLOYEE_FILTER ?>';
        var row = params.row !== undefined ? params.row : '<?= $ROW ?>';
        var page = params.page !== undefined ? params.page : 1;
        return base + '?page=' + page + '&row=' + row + '&employee=' + employee;
    }

    $('.select_employee').on('change', function() {
        window.location.href = buildUrl({ employee: $(this).val(), page: 1 });
    });

    $('.select_row').on('change', function() {
        window.location.href = buildUrl({ row: $(this).val(), page: 1 });
    });
});
</script>
</html>