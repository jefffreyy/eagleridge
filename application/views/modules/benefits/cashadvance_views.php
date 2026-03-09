<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$search_data  = $this->input->get('all');
$search_data  = str_replace("_", " ", $search_data ?? '');
$current_page = $PAGE;
$next_page    = $PAGE + 1;
$prev_page    = $PAGE - 1;
$last_page    = $PAGES_COUNT;
$row          = $ROW;
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
<style>
  .hover {
    cursor: pointer;
  }
</style>

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'benefits'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Cash Advances<h1>
      </div>

      <div class="col-md-6 button-title d-flex justify-content-end">
        <a href="<?= base_url() . 'benefits/add_cashadvance' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/plus-solid.svg') ?>" alt="">
          &nbsp;Add Request</a>
      </div>
    </div>

    <hr>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0" style="margin: 0px !important;">
        <div class="card-header p-0">

        </div>

        <div class="p-2">
          <div class="row align-items-center justify-content-between">
            <div class="col-12 col-lg-4  justify-content-center justify-content-lg-start align-items-center">
              <p class="mb-1 text-secondary ">Search Employee</p>
              <div class="d-flex">

                <select class="select-employee form-control" id="search_data" style="min-width:300px;width:max-content">
                  <option value=''>All</option>
                  <?php foreach ($EMPLOYEES as $employee) {
                  ?>
                    <option value="<?= $employee->id ?>" <?= $search_data == $employee->id ? 'selected' : '' ?>><?= $employee->name
                                                                                                                // $employee->col_empl_cmid."-".$this->system_functions->fomatName($employee->col_last_name,$employee->col_frst_name,$employee->col_midl_name)
                                                                                                                ?></option>
                  <?php } ?>
                </select>
                <a style="max-width: 150px" href=<?= base_url() . "benefits/reimbursement" ?> id="btn_clear_filter" class="col btn btn-primary mx-1"><img src="<?= base_url('assets_system/icons/clear_filter.svg') ?>" alt="" />&nbsp;Clear Filter</a>
              </div>

            </div>

            <!-- <div class="float-right "> -->
            <div class="col-12 col-lg-4 d-lg-flex d-none justify-content-lg-center align-items-center">

              <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0">
                <div class="row d-flex align-items-center justify-content-center">
                  <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                </div>

              </div>

              <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-start justify-content-center">
                <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                      < </a>
                  </li>
                  <li><a href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                </ul>
              </div>

              <div class="col-sm-3 col-md-2 col-lg-2  d-none d-lg-flex align-items-center justify-content-center mr-lg-0 mr-2">
                <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
                <select id="row_dropdown" class="custom-select" style="width: auto;">
                  <?php
                  foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                    <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                  <?php
                  } ?>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive" style="max-height: 75vh">
          <table class="table table-bordered table-hover m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <!-- <th class="text-center" style="min-width: 50px !important"><input type="checkbox" name="check_all" id="check_all"></th> -->
                <th class="text-left" style="min-width: 100px !important">ID</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE</th>
                <th class="text-left" style="min-width: 150px !important">TYPE</th>
                <th class="text-left" style="min-width: 100px !important">DESCRIPTION</th>
                <th class="text-left" style="min-width: 100px !important">AMOUNT</th>
                <th class="text-center" style="min-width: 100px !important">STATUS</th>
                <th class="text-center" style="min-width: 100px !important">ACTION</th>
              </tr>
            </thead>

            <tbody id="tbl_application_container">

              <?php if ($tableData) {
                foreach ($tableData as $tableDatarow) { ?>
                  <tr>
                    <td class="text-left"><?= 'CA' . str_pad($tableDatarow->id, 5, '0', STR_PAD_LEFT); ?></td>
                    <td class="text-left"><?= $tableDatarow->employee ?></td>
                    <td class="text-left"><?= $tableDatarow->type ?></td>
                    <td class="text-left"><?= $tableDatarow->description ?></td>
                    <td class="text-right"><span style="float: left;">&#8369;</span> <?= number_format($tableDatarow->amount, 2) ?></td>
                    <td class="text-left">
                      <?php if ($tableDatarow->status == "Approved") { ?>
                        <span class='btn btn-sm btn-success disabled'><?= $tableDatarow->status ?></span>
                      <?php } elseif ($tableDatarow->status == "Rejected") { ?>
                        <span class='btn btn-sm btn-danger disabled'><?= $tableDatarow->status ?></span>
                      <?php } elseif ($tableDatarow->status == "Withdrawed") { ?>
                        <span class='btn btn-sm btn-secondary disabled'><?= $tableDatarow->status ?></span>
                      <?php } else { ?>
                        <span class='btn btn-sm btn-warning disabled'>Pending</span>
                      <?php } ?>
                    </td>
                    <td class="d-flex justify-content-center">
                      <!-- <a class="btn btn-sm btn_edit indigo lighten-2 ml-2" href="<?= base_url() . 'benefits/edit_reimbursement/' . $tableDatarow->id ?>"  >
                            <img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" id="edit">
                        </a> -->
                      <a class="btn btn-sm btn_edit indigo lighten-2 ml-2" href="<?= base_url() . 'benefits/approval_cashadvance/' . $tableDatarow->id ?>">
                        <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="" id="edit">
                      </a>
                      <!-- <button type="button"  data-id="<?= $tableDatarow->id ?>" class="btn_view" style="background-color: transparent; border: none;color: gray; cursor: pointer; !important" row_id="1">
                            <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="" id="view">
                        </button> -->
                      <!-- <a href="<?= base_url() . 'benefits/edit_reimbursement' ?>" id="btn_new" class=" btn btn-primary shadow-none rounded"><img class="mb-1" src="<?= base_url('assets_system/icons/pen-to-square-solid_light.svg') ?>" alt="">
                          &nbsp;Edit Reimbursement</a> -->
                    </td>
                  </tr>

                <?php  }
              } else { ?>

                <tr class="table-active">
                  <td colspan="12">
                    <center>No Records</center>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="col-12 col-lg-4 d-lg-none d-flex justify-content-lg-center align-items-center">

          <div class="col-12 col-lg-4 d-flex justify-content-center my-2 my-lg-0">
            <div class="row d-flex align-items-center justify-content-center">
              <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              <div class="d-lg-inline col-12 col-lg-4 d-flex justify-content-lg-start justify-content-center">
                <ul class="pagination ml-0 ml-lg-4 m-0 p-0">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                      < </a>
                  </li>
                  <li><a href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                </ul>
              </div>
              <div class="col-sm-3 col-md-2 col-lg-2  d-flex d-lg-none align-items-center justify-content-center mr-lg-0 mr-2 my-1">
              <p class="p-0 m-0 d-inline" style="color: gray">&nbsp;&nbsp;Rows:&nbsp;</p>
              <select id="row_dropdown" class="custom-select" style="width: auto;">
                <?php
                foreach ($C_ROW_DISPLAY as $C_ROW_DISPLAY_ROW) { ?>
                  <option value=<?= $C_ROW_DISPLAY_ROW ?> <?php echo ($C_ROW_DISPLAY_ROW == $row) ? "selected" : ''; ?>> <?= $C_ROW_DISPLAY_ROW ?> </option>
                <?php
                } ?>
              </select>
            </div>
            </div>
           
          </div>


        </div>
      </div>
    </div>
  </div>
</div>




<?php $this->load->view('templates/jquery_link'); ?>



<?php if ($this->session->flashdata('SUCC')) { ?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-success toast_width',
      title: 'Success!',
      subtitle: 'close',
      body: '<?php echo $this->session->flashdata('SUCC'); ?>'
    })
  </script>
<?php } ?>


<?php if ($this->session->flashdata('ERR')) { ?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-warning toast_width',
      title: 'Warning!',
      subtitle: 'close',
      body: '<?php echo $this->session->flashdata('ERR'); ?>'
    })
  </script>
<?php } ?>


<script>
  $(document).ready(function() {
    $("#search_data").on("change", function() {
      search();
    });

    // $("#search_data").on("keypress", function(e) {
    //   if (e.which === 13) {
    //     search();
    //   }
    // });

    function search() {
      var optionValue = $('#search_data').val();
      var url = window.location.href.split("?")[0];
      if (window.location.href.indexOf("?") > 0) {
        window.location = url + "?page=1&row=<?= $row ?>&all=" + optionValue.replace(/\s/g, '_');
      } else {
        window.location = url + "?page=1&row=<?= $row ?>&all=" + optionValue.replace(/\s/g, '_');
      }
    }
    $('.select-employee').select2();
  })
</script>


</body>

</html>