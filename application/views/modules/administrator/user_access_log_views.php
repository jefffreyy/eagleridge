<html>
<?php $this->load->view('templates/css_link'); ?>
<style>
  .action_btn {
    display: flex !important;
    flex-direction: row !important;
    justify-content: center !important;
    align-items: center !important;
    margin: 0 auto;
    width: 100%;
  }

  .button-title {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 4px;
  }

  .image_profile::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    width: 1px;
    background-color: #000;
    border-left: 1px dashed #000;
  }
</style>
<?php
$this->load->library('session');

$url_count          = $this->uri->total_segments();
$url_directory      = $this->uri->segment($url_count);

?>
<?php
$search_data        = $this->input->get('all');
$employee_param     = $this->input->get('employee');
$search_data    = str_replace("_", " ", $search_data ?? '');
$id_prefix = 'MHW';
$TAB = 'active';
$ACTIVES = 0;
$INACTIVES = 0;
// $ROW=25;

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
<html>

<body>
  <div class="content-wrapper">
    <div class="container-fluid p-4">
      <div class="row pt-1">
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('administrators') ?>">
          <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;User Access Logs<h1>
        </div>
      </div>
      <div class=" py-3 w-25">
        <p class="p-0 my-1 text-bold">Employees</p>
        <select class="form-control select_employee">
          <option value="">All</option>
          <?php foreach ($EMPLOYEES as $employee) { ?>
            <option value="<?= $employee->id ?>" <?=$employee_param==$employee->id ? 'selected' : '' ?>><?= $employee->nameWithCMIDList ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="card border-0 p-0 m-0">
        <div class="card border-0 pt-1 m-0">


          <div class="p-2">
            <div>

              <div class="float-right ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                <ul class="d-inline pagination m-0 p-0 ">
                  <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                      < </a>
                  </li>
                  <li><a href="?status=<?= $STATUS ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a href="?status=<?= $STATUS ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a href="?status=<?= $STATUS ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?status=$STATUS&page=$next_page&row=$row'"; ?>>> </a></li>
                </ul>
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
          <div class="table-responsive">

            <table class="table table-hover table-bordered m-0" id="table_main" style="width:100%">
              <thead>
                <th style='width:10%;text-align: left;'>DATE</th>
                <th style='width:10%;text-align: left;'>EMPLOYEE ID</th>
                <th style='width:10%;text-align: left;'>EMPLOYEE</th>
                <th style='width:10%;text-align: left;'>IP ADDRESS</th>
                <th style='width:10%;text-align: left;'>DEVICE</th>
                <th style='width:20%;text-align: left;'>DESCRIPTION</th>
              </thead>
              <tbody id="tbl_application_container">
                <?php if ($TABLE_DATA) {  ?>
                  <?php foreach ($TABLE_DATA as $row_data) { ?>
                    <tr >
                        <!-- <td class="text-left"><?=date_format(date_create($row_data->create_date),$DATE_FORMAT . ' H:i:s A')?></td> -->
                        <td class="text-left"><?= date(($DATE_FORMAT ? $DATE_FORMAT : "d/m/Y") . "H:i:s A", strtotime($row_data->create_date)) ?></td>
                        <td class="text-left"><?= $row_data->col_empl_cmid ?></td>
                        <td class="text-left"><?=$row_data->employee ?></td>
                        <td class="text-left"><?=$row_data->ip_address?></td>
                        <td class="text-left"><?=$row_data->device?></td>
                        <td class="text-left"><?=$row_data->description?></td>
                        
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
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal_approval" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="approval_modal_content">
    </div>
  </div>
  <?php $this->load->view('templates/jquery_link'); ?>

  <?php
  if ($this->session->flashdata('SUCC')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-success toast_width',
        title: 'Success!',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('SUCC'); ?>'
      })
    </script>
  <?php
  }
  ?>

  <?php
  if ($this->session->flashdata('ERR')) {
  ?>
    <script>
      $(document).Toasts('create', {
        class: 'bg-warning toast_width',
        title: 'Warning!',
        subtitle: 'close',
        body: '<?php echo $this->session->flashdata('ERR'); ?>'
      })
    </script>
  <?php
  }
  ?>
<script>
    $(document).ready(function(){
        $('select.select_employee').select2();
        $('select.select_employee').on('change',function(){
            let limit=$('#row_dropdown').val();
            window.location.href="?employee="+$(this).val()+'&row='+limit;
        })
        $('#row_dropdown').on('change',function(){
            let employee=$('select.select_employee').val();
            window.location.href="?employee="+employee+'&row='+$(this).val();
        })
    })
</script>
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

</body>

</html>