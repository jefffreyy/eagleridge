<div class="card_container">
    <p style="font-size:16px;font-weight:bolder">Progress: <?=$progress?>% completed</p>
    <div class="progress" style="height:10px;border-radius:15px">
        <div class="progress-bar <?php echo ($progress<=25) ? 'bg-danger' : (($progress<=50) ? 'bg-warning':(($progress<=99) ? 'bg-info' : 'bg-success') ) ;?>" role="progressbar" 
        style="<?php echo 'width:'.$progress.'%';?> ;border-radius:15px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>