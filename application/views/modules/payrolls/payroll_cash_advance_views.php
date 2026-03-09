
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

    $search_data = $this->input->get('all');
    $search_data = str_replace("_", " ", $search_data ?? '');
?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url().'payrolls'; ?>">Payroll</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Cash Advance
        </li>
      </ol>
    </nav>
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title"><a href="<?= base_url().'payrolls';?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Cash Advance<h1>
      </div>
      <div class="col-md-6 button-title">
        <a href="<?=base_url().'payrolls/add_cash_advance'?>" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add New Cash Advance</a>
        <!--<a href="<?=base_url('payrolls/bulk_loans')?>" id="bulk_import" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>-->
        <!--<a id="btn_export" class=" btn technos-button-gray shadow-none rounded" ><i class="fas fa-file-export"></i>&nbsp;Export XLSX</a>-->
    </div>

    </div>
    <hr>
    <div class="pb-1">

    </div>
    <div class="card border-0 p-0 m-0">
      <div class="p-1">
        <div class="col-md-4 pl-0">
          <div class="input-group p-1 pt-2">
          <?php 
                if($search_data){ ?>
                <button id="clear_search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fa-regular fa-broom-wide" style="margin-top: 4px"></i>&nbsp;Clear</button>
            <?php } else{?>
                <button id="search_btn" class="input-group-prepend btn technos-button-blue shadow-none"><i class="fas fa-search" style="margin-top: 4px"></i>&nbsp;Search</button>
            <?php } ?>
            <input type="text" class="form-control" placeholder="Search" value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
          </div>
        </div>
      </div>
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
                    <?php
                        foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) {?>
                            <option value=<?= $C_ROW_DISPLAY_ROW?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW?> </option>
                        <?php
                    } ?>
                </select>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover m-0" id="TableToExport" style="width:100%">
            <thead>
              <tr>
                <th class="text-center"><input type="checkbox" name="check_all" id="check_all"></th>
                <th class="text-center" >ID</th>
                <th class="text-center" >Date</th>
                <th class="text-center" >Employee</th>
                <th class="text-center" >Amount</th>
                <th class="text-center" >Payment&nbsp;Amount</th>
                <th class="text-center" >Terms</th>
                <th class="text-center" >Status</th>
                <th class="text-center" >Action</th>
              </tr>

            </thead>
         
            <tbody id="tbl_application_container">

                <?php if($DISP_PAYROLL_LOAN){
                  foreach($DISP_PAYROLL_LOAN as $DISP_PAYROLL_LOAN_ROW){ ?>
                  <tr>
                    <td class="text-center" id="select_item">
                      <input type="checkbox" name="approval_name" loan_id=<?=$DISP_PAYROLL_LOAN_ROW['id']?>  class="check_single" approval_id=""  row_id="" value="">
                    </td>
                    <td class="text-center" ><?= 'CA'.str_pad($DISP_PAYROLL_LOAN_ROW['id'], 5, '0', STR_PAD_LEFT) ; ?></td>
                    <td class="text-center" ><?=$DISP_PAYROLL_LOAN_ROW['date'] ?></td>
                    <td class="text-center" ><?=$DISP_PAYROLL_LOAN_ROW['name']?></td>
                    <td class="text-center" ><?=$DISP_PAYROLL_LOAN_ROW['loan_amount']?></td>
                    <td class="text-center" ><?=$DISP_PAYROLL_LOAN_ROW['term_amount']?></td>
                    <td class="text-center" ><?=$DISP_PAYROLL_LOAN_ROW['loan_id'].'/'.$DISP_PAYROLL_LOAN_ROW['loan_terms']?></td>
                    <td class="text-center" ><?=$DISP_PAYROLL_LOAN_ROW['loan_status']?></td>
                    
                    <td style="width:15%" class="text-center">
                      <a class="select_row p-2" href="<?=base_url('payrolls/edit_cash_advance/'.$DISP_PAYROLL_LOAN_ROW['id'])?>" style="color: gray; " row_id=""><i class="far fa-edit" ></i></a>
                      <!--<a class="delete_data p-2 " style="color: gray !important" delete_key=""><i class="far fa-trash-alt" id="trash"></i></a>-->
                    </td>
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
<form id='builk_activate' method='post' action="<?=base_url('payrolls/bulk_activate')?>">
    <input type='hidden' name='active' id='active_loans'/>
    <input type='hidden' name='table'  value='tbl_payroll_cashadvance'/>
</form>
<form id='builk_inactivate' method='post' action="<?=base_url('payrolls/bulk_inactivate')?>">
    <input type='hidden' name='inactive' id='inactive_loans'/>
    <input type='hidden' name='table'  value='tbl_payroll_cashadvance'/>
</form>
<!-- ================================================================ new design End here ======================================================= -->

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
<!-- jQuery -->
<?php $this->load->view('templates/jquery_link'); ?>


<?php
if ($this->session->userdata('SESS_SUCCESS')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_SUCCESS'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('SESS_SUCCESS');
}
?>

<?php
if ($this->session->userdata('SESS_ERROR')) {
?>
<script>
    $(document).Toasts('create', {
        class: 'bg-danger toast_width',
        title: 'Error',
        subtitle: 'close',
        body: '<?php echo $this->session->userdata('SESS_ERROR'); ?>'
      })
</script>
<?php
$this->session->unset_userdata('SESS_ERROR');
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
        window.location="<?=base_url()?>payrolls/cash_advances?"+"page="+1+"&row="+row+'&tab=<?=$TAB?>';
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


    $("#clear_search_btn").on("click", function() {
          var url = window.location.href.split("?")[0];
          window.location = url
      });

      $("#search_btn").on("click", function() {
          search();
      });

      $("#search_data").on("keypress", function(e) {
          if (e.which === 13) {
          search();
          }
      });

      function search() {
          let tab = '<?=$TAB?>';
          var optionValue = $('#search_data').val();
          var url = window.location.href.split("?")[0];
          if (window.location.href.indexOf("?") > 0) {
          window.location = url + "?page=1&tab="+tab+"&all=" + optionValue.replace(/\s/g, '_');
          } else {
          window.location = url + "?page=1&tab="+tab+"&all=" + optionValue.replace(/\s/g, '_');
          }
      }


  })
</script>
<!-------------------- Export ----------------->

</body>

</html>