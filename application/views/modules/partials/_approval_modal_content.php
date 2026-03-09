<style>
    .image_profile{
        z-index:5;
    }
    td,
    th {
        text-align: center;
    }
</style>
<div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Leave Approval</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body position-relative">
           
            <div class="mb-3">
                <div class="row">
                        <div class="col-2 m-0">
                            <p class="h6">Date</p>
                        </div>
                        <div class="col-4 m-0">
                            <p class = "m-0"><?=date("d/m/Y", strtotime($LEAVE->leave_date))?></p>
                        </div>
                        <div class="col-2 m-0">
                            <p class="h6">Assigned by:</p>
                        </div>
                        <div class="col-4 m-0">
                            <p class="m-0"><?=$LEAVE->assigned_by?></p>
                        </div>
                        <div class="col-2 m-0">
                            <p class="h6">ID:</p>
                        </div>
                        <div class="col-4 m-0">
                            <p class="m-0"><?='LEA'. str_pad($LEAVE->id, 5, '0', STR_PAD_LEFT)?></p>
                        </div>
                        <div class="col-2 m-0">
                            <p class="h6">Reason:</p>
                        </div>
                        <div class="col-4 m-0">
                            <p class="m-0"><?=$LEAVE->reason?></p>
                        </div>
                        <div class="col-2 m-0">
                            <p class="h6">Type:</p>
                        </div>
                        <div class="col-4 m-0">
                            <p class="m-0"><?=$LEAVE->type?></p>
                        </div>
                        <div class="col-2">
                            <p class="h6">Attachment:</p>
                        </div>
                        <div class="col-4 text-break">
                            <p class="m-0"><a download href="<?=base_url('assets_user/files/leaves/'.$LEAVE->attachment)?>"><?=$LEAVE->attachment?></a></p>
                        </div>
                        <div class="col-2">
                            <p class="h6">Duration:</p>
                        </div>
                        <div class="col-4">
                            <p class="m-0"><?=$hours?> Hour/s (<?= $days ?> Day/s)</p>
                        </div>
                        <div class="col-2">
                            <p class="h6">Remarks:</p>
                        </div>
                        <div class="col-4">
                            <p class="m-0"><?=$LEAVE->remarks?></p>
                        </div>
                        <div class="col-2">
                            <p class="h6">Final Status:</p>
                        </div>
                        <div class="col-4">
                            <p>
                                <?php if($LEAVE->status == "Approved"){?>
                                                                <span class='btn btn-sm btn-success disabled'><?=$LEAVE->status?></span>
                                <?php } elseif($LEAVE->status == "Rejected"){ ?>
                                                                <span class='btn btn-sm btn-danger disabled'><?=$LEAVE->status?></span>
                                <?php } elseif($LEAVE->status == "Withdrawed"){ ?>
                                                                <span class='btn btn-sm btn-secondary disabled'><?=$LEAVE->status?></span>
                                <?php }  else{ ?>
                                                                <span class='btn btn-sm btn-warning disabled'>Pending</span>
                                <?php } ?>                                                             
                            </p>
                        </div>
                </div>
            </div>
            
            <div class="d-none mb-3">
                <!--<p class="h6">Date: </p>-->
                <!---->
            </div>

            <div class="d-flex justify-content-left mb-3">
                <table id="timeTable" style="width: 100%;border: 1px solid #E7ECF0;">
                    <thead>
                        <tr>
                            <th style="width: 35%">Date</th>
                            <th style="width: 35%">Time Range</th>
                            <th style="width: 30%">Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($tableData) {  ?>
                            <?php foreach ($tableData as $row_data) { ?>
                                <tr>
                                    <td><?= date_format(date_create($row_data->leave_date), 'd/m/Y') ?></td>
                                    <td><?= $row_data->leave_range ?></td>
                                    <td><?= $row_data->duration ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr class="table-active">
                                <td colspan="10">
                                    <center>No Records</center>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>


            <?php if (show_approver3($LEAVE) != ''){?>
                <p class="h6 mb-0">Approval Route:</p>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                       <div class="line_progress" style="position:relative;width:2px;height:100px;background-color:black;bottom:-65px;left:26px"></div>
                    <img src="<?=set_profile($LEAVE,'Pending 3')?>"  class="image_profile img-circle elevation-2" width='50' height='50'/>
                    <div class="ml-2">
                        <p class="p-0 m-0">Step 3:&nbsp;<?=step_3_response($LEAVE->status,$LEAVE->approver_3_stat)?></p>
                        <p class="p-0 m-0"><?= show_approver($LEAVE->approver_3_stat,$LEAVE->pending_approver3,$LEAVE->approver3)?></p>
                        <p class="p-0 m-0"><?=get_email( $LEAVE->approver_3_stat, $LEAVE->approver3a_email, $LEAVE->approver3_email)?></p>
                    </div>
                </div>
                <div>
                     <span><?= $LEAVE->approver_3_stat ? date_format(date_create($LEAVE->approver3_date),'d/m/Y H:i:s A') :'' ?></span>
                </div>
            </div>
            <?php } ?>
           
            <?php if (show_approver2($LEAVE) != ''){?>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                       <div class="line_progress" style="position:relative;width:2px;height:100px;background-color:black;bottom:-65px;left:26px"></div>
                    <img src="<?=set_profile($LEAVE,'Pending 2')?>"  class="image_profile img-circle elevation-2" width='50' height='50'/>
                    <div class="ml-2">
                        <p class="p-0 m-0">Step 2:&nbsp;<?= step_2_response($LEAVE->status,$LEAVE->approver_2_stat,$LEAVE->approver_3_stat,$LEAVE->approver_1_stat) ?></p>
                        <p class="p-0 m-0"><?=show_approver2($LEAVE)?></p>
                        <p class="p-0 m-0"><?=get_email( $LEAVE->approver_2_stat, $LEAVE->approver2a_email, $LEAVE->approver2_email)?></p>
                    </div>
                </div>
                <div>
                     <span><?= $LEAVE->approver_2_stat ? date_format(date_create($LEAVE->approver2_date),'d/m/Y H:i:s A') :'' ?></span>
                </div>
            </div>
            <?php } ?>

            <?php if (show_approver1($LEAVE) != ''){?>
                <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center">
                <div class="line_progress" style="position:relative;width:2px;height:100px;background-color:black;bottom:-65px;left:26px"></div>
                    <img src="<?=set_profile($LEAVE,'Pending 1')?>"  class="image_profile img-circle elevation-2" width='50' height='50'/>
                    <div class="ml-2">
                        <p class="p-0 m-0">Step 1:&nbsp;<?=step_1_response($LEAVE->status,$LEAVE->approver_1_stat,$LEAVE->approver_2_stat)?></p>
                        <p class="p-0 m-0"><?=show_approver1($LEAVE)?></p>
                        <p class="p-0 m-0"><?=get_email( $LEAVE->approver_1_stat, $LEAVE->approver1a_email, $LEAVE->approver1_email)?></p>
                    </div>
                </div>
                <div>
                    <span><?= $LEAVE->approver_1_stat ? date_format(date_create($LEAVE->approver1_date),'d/m/Y H:i:s A') :'' ?></span>
                </div>
            </div>



            <?php } ?>


            <div class="d-flex align-items-center justify-content-between" style="margin-top: 0px">
                <div class="d-flex align-items-center">
                    <img src="<?=set_profile($LEAVE,'employee')?>"  class="image_profile img-circle elevation-2"  width='50' height='50'/>
                    <div class="ml-2">
                        <p class="p-0 m-0" style="font-weight:bold"><?=$LEAVE->status=='Withdrawed' ? 'Withdrawed by' : 'Requested by' ?></p>
                        <p class="p-0 m-0"><?=$LEAVE->employee?></p>
                        <p class="p-0 m-0"><?=$LEAVE->employee_email?></p>
                        
                    </div>
                </div>
                <div>
                    <span><?=date_format(date_create($LEAVE->create_date),'d/m/Y H:i:s A')?></span>
                </div>
            </div>
        </div> 
        <div class="modal-footer">
            <button type="button" data-id="<?=$LEAVE->id?>" class='btn btn-default btn_withdraw 
            <?= $LEAVE->status == "Withdrawed"||$LEAVE->status == "Rejected" || $LEAVE->status == "Approved"?  "d-none" : ""; ?>' >Withdraw Leave</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
    <?php
        function get_email($approver,$approverA_email,$approver1_email){
            if($approver!=0){
                return $approver1_email;
            }
            return$approverA_email;
        }
        function show_approver($approver_stat,$approverA,$approver){
            if($approver_stat>0){
                return $approver;
            }
            return $approverA;
        }
        function show_approver1($leave){
            if(!$leave->approver_1_stat && $leave->status!='Approved'){
                return $leave->pending_approver1;
            }
            return $leave->approver1;
        }
        function show_approver2($leave){
            if(!$leave->approver_2_stat && $leave->status!='Approved'){
                return $leave->pending_approver2;
            }
            return $leave->approver2;
        }
        function show_approver3($leave){
            if(!$leave->approver_3_stat && $leave->status!='Approved'){
                return $leave->pending_approver3;
            }
            return $leave->approver3;
        }
        function step_1_response($status,$approver_id,$next_approver){
         
          if($status=='Pending 1'){
              return '<span style="font-weight: bold; color: black;">Pending response</span>';
          }
          if($status=='Pending 2' || $status== 'Pending 3'){
              return '<span style="font-weight: bold; color: green;">Approved by</span>';
          }
          if(($status=='Withdrawed' && $approver_id!=0) || $status=='Approved' ){
              return '<span style="font-weight: bold; color: green;">Approved by</span>';
          }
          if($status=='Withdrawed' & $approver_id==0){
               return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
          }
          if($status=='Rejected' && $next_approver==0){
              return '<span style="font-weight: bold; color: red;">Rejected by</span>';
          }
          if($status=='Rejected' && $next_approver!=0){
              return '<span style="font-weight: bold; color: green;">Approved by</span>';
          }
          
       }
       function step_2_response($status,$approver_id,$next_approver,$prev_approver){
            if($status=='Pending 2'){
               return '<span style="font-weight: bold; color: black;">Pending response</span>';
             }
            if($status=='Pending 3'){
               return '<span style="font-weight: bold; color: green;">Approved by</span>';
            }
            if($status=='Pending 1'){
               return '<span style="font-weight: bold; color: black;">Needs response from</span>';
            }
            if(($status=='Withdrawed' && $approver_id!=0) || $status=='Approved' ){
              return '<span style="font-weight: bold; color: green;">Approved by</span>';
            }
            if($status=='Withdrawed' && $approver_id==0){
               return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
            }
            if($status=='Rejected' && $next_approver==0 && $approver_id!=0){
              return '<span style="font-weight: bold; color: red;">Rejected by</span>';
            }
            if($status=='Rejected' && $next_approver!=0){
                  return '<span style="font-weight: bold; color: green;">Approved by</span>';
            }
            if($status=='Rejected'&&$approver_id==0){
                return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
            }
            
       }
       function step_3_response($status,$approver_id){
           if($status=='Pending 3'){
               return '<span style="font-weight: bold; color: black;">Pending response</span>';
           }
           if($status=='Pending 1'||$status=='Pending 2'){
               return '<span style="font-weight: bold; color: black;">Needs response from</span>';
           }
           if(($status=='Withdrawed' && $approver_id!=0) || $status=='Approved' ){
              return '<span style="font-weight: bold; color: green;">Approved by</span>';
            }
            if($status=='Withdrawed' && $approver_id==0){
               return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
            }
            if($status=='Rejected' && $approver_id!=0){
              return '<span style="font-weight: bold; color: red;">Rejected by</span>';
            }
            if($status=='Rejected' && $approver_id==0){
                  return '<span style="font-weight: bold; color: #474747;">No response needed</span>';
            }
            
       }

        function set_profile($leave,$status){
           $file_name=$leave->empl_image;
           if($status=='Pending 1'){
              if(!$leave->approver_1_stat){
                  $file_name=$leave->pending_approver1_img;
              }else{
                  $file_name=$leave->approver_1_img;
              }
           }
           if($status==='Pending 2'){
              if(!$leave->approver_2_stat){
                  $file_name=$leave->pending_approver2_img;
              }else{
                  $file_name=$leave->approver_2_img;
              }
           }
           if($status==='Pending 3'){
              if(!$leave->approver_3_stat ){
                  $file_name=$leave->pending_approver3_img;
              }else{
                  $file_name=$leave->approver_3_img;
              }
           }
           if (file_exists(FCPATH.'assets_user/user_profile/' . $file_name)&&!empty( $file_name)) {
                return base_url() . 'assets_user/user_profile/' . $file_name;
            } else {
                return base_url() . 'assets_system/images/default_user.jpg';
            } 
       }
    ?>