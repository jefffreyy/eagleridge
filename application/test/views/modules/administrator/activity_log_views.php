<html>
<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?=base_url()?>selfservices">Self-Service
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Activity Logs
            </ol>
        </nav>
        <h1 class="page-title mb-3">Activity Logs</h1>
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
<?php foreach($C_ACTIVITIES as $ACTIVITY_ROW) { ?>
                            <tr>
                                <td><?=date_format(date_create($ACTIVITY_ROW["create_date"]),"M d Y  h:i a")?></td>
                                <td><?=getID($C_EMPLOYEES_ID,$ACTIVITY_ROW["empl_id"])?></td>
                                <td><?=$ACTIVITY_ROW["description"]?></td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>
<?php 
function getID($listID,$userId){
    foreach($listID as $ids){
        if($ids['id']==$userId){
            return $ids['col_empl_cmid'];
        }
    }
    return 'user not found';
}
?>
<?php $this->load->view('templates/jquery_link'); ?>
</html>