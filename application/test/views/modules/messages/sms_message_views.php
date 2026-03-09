
<html>
<?php $this->load->view('templates/css_link');?>
<?php
    $current_page=$PAGE;
    $next_page=$PAGE+1;
    $prev_page=$PAGE-1;
    $last_page=$PAGES_COUNT;
    $row=$ROW;
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
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <!-- <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url().'messages'; ?>">Messaging</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">SMS Messages
        </li>
      </ol>
    </nav> -->
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title">SMS Messages<h1>
      </div>
      <div class="col-md-6 button-title">
        <a href="<?=base_url().'sms_user/add_sms_messages'?>" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add New Message</a>
        <!--<a href="<?=base_url('payrolls/bulk_loans')?>" id="bulk_import" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>-->
        <!--<a id="btn_export" class=" btn technos-button-gray shadow-none rounded" ><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>-->
    </div>

    </div>
    <hr>
    <div class="pb-1">

    </div>
    <div class="card border-0 p-0 m-0">
      <!--<div class="p-1">-->
      <!--  <div class="col-md-4 pl-0">-->
      <!--    <div class="input-group p-1 pt-2">-->
      <!--      <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>-->
      <!--      <input type="text" class="form-control" placeholder="Search" id="search_data" aria-label="Username" aria-describedby="basic-addon1">-->
      <!--    </div>-->
      <!--  </div>-->
      <!--</div>-->
      <div class="card border-0 p-0 m-0">
        <div class="card-header p-0">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link head-tab <?= $TAB=='Active'?'active' :'' ?> " href="?page=1&row=<?=$row?>&tab=Active"  id="tab-Active" style='cursor:pointer'>
                        Active
                        <span class="ml-2 badge badge-pill badge-secondary"><?=$ACTIVES?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=1&row=<?=$row?>&tab=Inactive" class="nav-link head-tab <?= $TAB=='Inactive'?'active' :'' ?>"  id="tab-Inactive" style='cursor:pointer' >
                        Inactive
                        <span class="ml-2 badge badge-pill badge-secondary"><?=$INACTIVES?></span>
                    </a>
                </li>               
            </ul>
        </div>
        <div class="p-2">
          <div>
            <button class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal"   data-target="#modal_set_ssa" id="mark_as_active">
              <i class=""></i>&nbsp;Mark as Active
            </button>
            <button class="btn technos-button-gray shadow-none rounded bulk-button" data-toggle="modal"   data-target="#modal_set_ssa" id="mark_as_inactive">
              <i class=""></i>&nbsp;Mark as Inactive
            </button>
            <div class="float-right ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
                        <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                                            < </a>
                                    </li>
                                    <li><a href="?page=1&row=<?= $row ?>&tab=<?=$TAB?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                                    <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                                    <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>&tab=<?=$TAB?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                                    <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                                    <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>&tab=<?=$TAB?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                                    <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                                    <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>&tab=<?=$TAB?>" <?php if ($current_page == $last_page||$last_page<=0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                                    <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row&tab=$TAB'"; ?>>> </a></li>
                </ul>
                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                 <select id="row_dropdown" class="custom-select" style="width: auto;">
                    <option value="25"> 25 </option>
                    <option value="50"> 50 </option>
                    <option value="100"> 100 </option>
                 </select>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover m-0" id="TableToExport" style="width:100%">
            <thead>
              <tr>
                <th width="30" class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                <th width="60" class="text-center" >ID</th>
                <th width="200" class="text-center" >Date</th>
                <!-- <th class="text-center" >Employee</th> -->
                <th width="200" class="text-center" >Title</th>
                <th class="text-center" >Messages</th>
                <th width="250" class="text-center" >Mobile Number</th>
                <th width="30" class="text-center" >Action</th>
              </tr>

            </thead>
         
            <tbody id="tbl_application_container">

                <?php if($MESSAGES){
                  foreach($MESSAGES as $MESSAGE_ROW){ ?>
                  <tr>
                    <td class="text-center" id="select_item">
                      <input type="checkbox" name="approval_name" loan_id="<?=$MESSAGE_ROW->id?>"  class="check_single" approval_id=""  row_id="" value="">
                    </td>
                    <td class="text-left" ><?= 'MSG'.str_pad($MESSAGE_ROW->id, 5, '0', STR_PAD_LEFT) ; ?></td>
                    <td class="text-left" ><?=date('M d Y H:i A',strtotime($MESSAGE_ROW->create_date))?></td>
                    <!-- <td class="text-center" ><?=$MESSAGE_ROW->col_empl_cmid ?>- <?=$MESSAGE_ROW->col_last_name.' '.$MESSAGE_ROW->col_frst_name.', '.$MESSAGE_ROW->col_midl_name ?></td> -->
                    
                    <td class="text-left" ><?=$MESSAGE_ROW->title?></td>
                    <td class="text-left" ><?=$MESSAGE_ROW->message?></td>
                    <td class="text-left" ><?=$MESSAGE_ROW->mobile_number?></td>
                    <td class="text-left"><a href="<?=base_url('sms_user/view_message/'.$MESSAGE_ROW->id)?>" class='text-secondary'><i class="far fa-eye" ></a></td>
                  </tr>
              <?php  }

                }else {?>
       
                   <tr class="table-active">
                    <td colspan="12">
                      <center>No Data</center>
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
<form id='builk_activate' method='post' action="<?=base_url('sms_user/bulk_activate')?>">
    <input type='hidden' name='active' id='active_loans'/>
</form>
<form id='builk_inactivate' method='post' action="<?=base_url('sms_user/bulk_inactivate')?>">
    <input type='hidden' name='inactive' id='inactive_loans'/>
</form>
<!-- ================================================================ new design End here ======================================================= -->

<!-- jQuery -->

<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_APPROVER'); ?>',
      '',
      'error'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_INSRT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_UPDT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_UPDT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_ERR_MSG_DLT_APPROVER')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_ERR_MSG_DLT_APPROVER'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_ERR_MSG_DLT_APPROVER');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_REJECT_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_REJECT_LEAVE');
}
?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->userdata('SESS_SUCC_MSG_APPROVE_LEAVE'); ?>',
      '',
      'success'
    )
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_APPROVE_LEAVE');
}
?>

<?php
if ($this->session->flashdata('SESS_SUCC_LOAN')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->flashdata('SESS_SUCC_LOAN'); ?>',
      '',
      'success'
    )
  </script>
<?php
}
?>
<?php
if ($this->session->flashdata('SESS_ERROR')) {
?>
  <script>
    Swal.fire(
      '<?php echo $this->session->flashdata('SESS_ERROR'); ?>',
      '',
      'warning'
    )
  </script>
<?php
}
?>

<?php
  function convert_data($array, $id){
    $name = "";
    foreach($array as $row){
      if($row->id == $id){
        $name = $row->col_last_name.' '.$row->col_frst_name.' '.$row->col_midl_name;
      }
    }
    return $name;
  }

  function convert_img($array, $id){
    $img = "";
    foreach($array as $row){
      if($row->id == $id){
        $img = $row->col_imag_path;
      }
    }
    return $img;
  }

  function convert_cmid($array, $id){
    $cmid = "";
    foreach($array as $row){
      if($row->id == $id){
        $cmid = $row->col_empl_cmid;
      }
    }
    return $cmid;
  }



?>

<script>
  $(document).ready(function() {
    $('#row_dropdown').on('change',function(){
        let row = $(this).val();
        // alert(row);
        window.location="<?=base_url()?>sms_user?"+"page="+1+"&row="+row+'&tab=<?=$TAB?>';
    });
    
    
    $('#mark_as_active').on('click',function(){
        let selected=false;
        let loan_id=[];
        Array.from($('.check_single')).forEach(function(element) {
            if($(element).prop('checked')){
                 selected=true;
                 loan_id.push($(element).attr('loan_id'))
            }
            
        })
        $('#active_loans').val(loan_id);
        if(!selected){
                Swal.fire(
                  'Warning!',
                  'No item selected',
                  'warning'
                )
            }
        if(selected){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Confirm!'
            }).then((result) => {
              if (result.isConfirmed) {
                $('#builk_activate').submit();
              }
            })
        }
    })
    $('#mark_as_inactive').on('click',function(){
        let selected=false;
        let loan_id=[];
        Array.from($('.check_single')).forEach(function(element) {
            if($(element).prop('checked')){
                 selected=true;
                 loan_id.push($(element).attr('loan_id'))
            }
            
        })
        $('#inactive_loans').val(loan_id);
        if(!selected){
                Swal.fire(
                  'Warning!',
                  'No item selected',
                  'warning'
                )
            }
        if(selected){
            Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Confirm!'
            }).then((result) => {
              if (result.isConfirmed) {
                $('#builk_inactivate').submit();
              }
            })
        }
    })
    $('#approval').click(function(){
      let selected_id = [];
      let selected_att_id = [];
      $('#APPROVAL_ID').empty();
      $('#approval_list_id').empty();
      $('#select_item input[type=checkbox]:checked').each(function() {
        let selected_item = $(this).val();
        let att_approval_id = $(this).attr('approval_id');
        selected_id.push(selected_item);
        selected_att_id.push(att_approval_id);
      })
     
      if(selected_id.length > 0){
        $('.class_modal_approval_list').prop('id', 'modal_assign_approver');
        let approval_ids = selected_id.join(',');
        $('#APPROVAL_ID').val(approval_ids);
        selected_att_id.forEach(function(data){
            $('#approval_list_id').append(`<li class="col-md-6">Employee ID: <strong>${data}</strong></li>`);
        })
      }else {
            $('.class_modal_approval_list').prop('id', '');
            Swal.fire(
                'Please Select Employee!',
                '',
                'warning'
            )
        }
     
    })
    
    $('#check_all').click(function() {
      if (this.checked == true) {
        Array.from($('.check_single')).forEach(function(element) {
          $(element).prop('checked', true);
          $('.check_single').parent().parent().css('background', '#e7f4e4');
        })
      } else {
        Array.from($('.check_single')).forEach(function(element) {
          $(element).prop('checked', false);
          $('.check_single').parent().parent().css('background', '');
        })
      }
    })
    $('.check_single').on('change', function() {
      if (this.checked == true) {
        $(this).parent().parent().css('background', '#e7f4e4');
      } else {
        $(this).parent().parent().css('background', '');
      }
    })

    $("#search_btn").on("click", function() {
        $('#search_data').val();
        var optionValue = $('#search_data').val();
        var row         = $('#row_dropdown').val();
        var url = window.location.href.split("?")[0];
        if (window.location.href.indexOf("?") > 0) {
            window.location = url + "?page=1&row=<?=$row?>&tab=<?=$TAB?>&all=" + optionValue.replace(/\s/g, '_');
        } else {
            window.location = url + "?page=1&row=<?=$row?>&tab=<?=$TAB?>&all=" + optionValue.replace(/\s/g, '_');
        }
    })


  })
</script>
<!-------------------- Export ----------------->

</body>

</html>