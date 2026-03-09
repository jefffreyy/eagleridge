<html>
<?php $this->load->view('templates/css_link'); ?>
<?php
$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data ?? '');

if (isset($_GET['row'])) {
  $row = $_GET['row'];
} else {
  $row = 25;
}

if (isset($_GET['page'])) {
  $current_page = $_GET['page'];
} else {
  $current_page = 1;
}

$prev_page = $current_page - 1;
$next_page = $current_page + 1;
$last_page_initial = ceil($C_DATA_COUNT / $row);
$last_page = ($last_page_initial == 0 || $last_page_initial == 1) ? 1 : $last_page_initial;

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
  .switch {
    margin-top: 11px;
    margin-left: 7px;
    position: relative;
    display: block;
    width: 50px;
    height: 26px;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
  }

  .switch input {
    display: none;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 21px;
    width: 21px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50px;
  }

  input:checked+.slider:before {
    background-color: limegreen;
  }

  input:checked+.slider:before {
    transform: translateX(23px);
  }

  .ip_on {
    font-size: 15px;
    font-weight: bold;
    color: green;
    margin-top: 11px;
    margin-left: 5px;
    background-color: #a0f2c1;
    padding: 2px 10px;
    border-radius: 12px;
  }

  .ip_off {
    font-size: 15px;
    font-weight: bold;
    color: red;
    margin-top: 11px;
    margin-left: 5px;
    background-color: pink;
    padding: 2px 10px;
    border-radius: 12px;
  }
</style>

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?= base_url() ?>administrators">Administrator</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">IP Address
        </li>
      </ol>
    </nav>

    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;IP Address<h1>
      </div>

      <div class="col-md-6 button-title">
        <a href="<?= base_url() . 'administrators/ip_address_form' ?>" class=" btn btn-primary shadow-none rounded" id="ip_address"><img class="mb-1" src="<?= base_url('assets_system/icons/circle-plus-solid.svg') ?>" alt=""> Add&nbsp;IP Address</a>
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
            if ($search_data) { ?>
              <button id="clear_search_btn" class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img style="height: 16px;" src="<?= base_url('assets_system/icons/broom-wide-sharp-solid.svg') ?>" alt="">&nbsp;Clear</button>
            <?php } else { ?>
              <button id="search_btn" class="input-group-prepend btn btn-primary shadow-none d-flex align-items-center"><img src="<?= base_url('assets_system/icons/magnifying-glass-solid.svg') ?>" alt="">&nbsp;Search</button>
            <?php } ?>
            <input type="text" class="form-control" placeholder="Search" value="<?= ($search_data) ? $search_data : ""; ?>" id="search_data" aria-label="Username" aria-describedby="basic-addon1">
          </div>
        </div>
      </div>

      <div class="card border-0 p-0 m-0">
        <div class="py-2">
          <div class="row d-flex justify-content-between align-items-center">
            <div class="col-12 col-lg-2 d-flex justify-content-start">
              <form action="<?php echo base_url() . 'administrators/update_ip_address'; ?>" method="post" accept-charset="utf-8" class="p-0">
                <label class="switch p-0">
                  <input class="switch_on p-0" type="checkbox" <?= $SYSTEM_IP_ADDRESS == '0' ? '' : 'checked'; ?> name="val_setting" onchange="this.form.submit()">
                  <span class="slider round" id="branch"></span>
                </label>
              </form>

              <p class="ip_on" <?= $SYSTEM_IP_ADDRESS == '1' ? '' : 'hidden'; ?>>On</p>
              <p class="ip_off" <?= $SYSTEM_IP_ADDRESS == '0' ? '' : 'hidden'; ?>>Off</p>
            </div>


            <div class='col-12 col-lg-8 d-none d-lg-flex justify-content-end align-items-center'>
              <div class="col-12 col-lg-9 d-flex justify-content-end ">
                <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
              </div>
              <div class="col-12 col-lg-2 d-flex justify-content-end">
                <ul class="d-inline pagination m-0 p-0 ">
                  <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                      < </a>
                  </li>
                  <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                  <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                  <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                  <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                  <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                  <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                  <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
                  <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
                </ul>
              </div>
            </div>
            <div class="col-12 col-lg-1 d-none d-lg-flex">
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
          <table class="table table-bordered table-hover m-0" id="TableToExport" style="width:100%">
            <thead>
              <tr>
                <th class="text-left">IP ADDRESS</th>
                <th class="text-left">REMARKS</th>
                <th class="text-center">ACTION</th>
              </tr>
            </thead>

            <tbody id="tbl_application_container">
              <?php if ($DISP_IP_ADDRESS) {
                foreach ($DISP_IP_ADDRESS as $DISP_IP_ADDRESS_ROW) {
              ?>
                  <tr>
                    <td class="text-left"><?= $DISP_IP_ADDRESS_ROW->ip_address; ?></td>
                    <td class="text-left"><?= $DISP_IP_ADDRESS_ROW->remarks; ?></td>
                    <td style="width:15%" class="text-center">
                      <a class="select_row p-2" href="" style="color: gray; " row_id=""> <img src="<?= base_url('assets_system/icons/eye-sharp-solid_dark.svg') ?>" alt="" hidden></a>
                      <a class="select_edit_row p-2" href="" style="color: gray; " row_id=""><img src="<?= base_url('assets_system/icons/pen-to-square-solid.svg') ?>" alt="" hidden></a>
                      <a class="delete_data p-2 APPROVAL_DLT" href="" style="color: gray !important" delete_key="<?= $DISP_IP_ADDRESS_ROW->id ?>"><img src="<?= base_url('assets_system/icons/trash-solid.svg') ?>" alt="" id="trash" hidden></a>
                    </td>
                  </tr>
                <?php }
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
        <div class='col-12 col-lg-8  d-lg-none justify-content-center align-items-center my-2'>
          <div class="col-12 col-lg-9 d-flex justify-content-center ">
            <p class="p-0 m-0 d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
          </div>
          <div class="col-12 col-lg-2 d-flex justify-content-center">
            <ul class="d-inline pagination m-0 p-0 ">
              <li><a class="page_row" <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row'"; ?>>
                  < </a>
              </li>
              <li><a class="page_row" href="?page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
              <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
              <li><a class="page_row" href="?page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
              <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
              <li><a class="page_row" href="?page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
              <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
              <li><a class="page_row" href="?page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page) echo "hidden"; ?>><?= $last_page ?> </a></li>
              <li><a class="page_row" style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?page=$next_page&row=$row'"; ?>>> </a></li>
            </ul>
          </div>
        </div>
        <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center my-2">
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


<?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->userdata('SESS_SUCC_MSG_INSRT')) {
?>
  <script>
    $(document).Toasts('create', {
      class: 'bg-success toast_width',
      title: 'Success',
      subtitle: 'close',
      body: '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT'); ?>'
    })
  </script>
<?php
  $this->session->unset_userdata('SESS_SUCC_MSG_INSRT');
}
?>