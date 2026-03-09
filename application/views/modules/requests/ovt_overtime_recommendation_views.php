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

  .calendar-table {
    display: none !important;
  }
</style>
<?php
$this->load->library('session');
$url_count          = $this->uri->total_segments();
$url_directory      = $this->uri->segment($url_count);
function technos_encrypt($input)
{
  $ciphering = "AES-128-CTR";
  $iv_length = openssl_cipher_iv_length($ciphering);
  $options = 0;
  $encryption_iv = '6234564891013126';
  $encryption_key = "Technos";
  $result_raw = openssl_encrypt($input, $ciphering, $encryption_key, $options, $encryption_iv);
  $result = str_replace("/", "&", $result_raw);
  return $result;
}

?>
<?php
$search_data = $this->input->get('all');
$search_data = str_replace("_", " ", $search_data ?? '');
$id_prefix = 'ADJ';
$TAB = 'active';
$STATUS = '';
$ACTIVES = 0;
$INACTIVES = 0;
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
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('requests/overtime') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;Overtime Recommendation<h1>
        </div>
      </div>

      <div class="row">
        <div class="col-6 col-lg-2 py-3 w-25">
          <p class="p-0 my-1 text-bold">Cut-off Period:</p>
          <select class="form-control" id="cut_off_select">
            <?php foreach ($CUTOFF as $cutoff_period) : ?>
              <option value="<?= $cutoff_period->id ?>" <?= $cutoff_period->id == $CUTOFF_ID ? 'selected' : '' ?>><?= $cutoff_period->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>


      <div class="card border-0 p-0 m-0">
        <div class="card border-0 pt-1 m-0">
          <div class="p-2">
            <div class="card-header p-0">
              <div class=" ">
                <div class="d-flex row justify-content-between align-items-center mb-2">
                  <div class="col-12 col-lg-5 d-flex"></div>

                  <div class="col-12 col-lg-6 row d-none d-lg-flex justify-content-end">
                    <div class="col-12 col-lg-6 d-flex justify-content-lg-end justify-content-center align-items-center mx-2">
                      <div class="d-flex align-items-center row">
                        <div class="d-inline col-12 col-lg-6">
                          <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                        </div>

                        <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center justify-content-lg-end">
                          <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                            <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                                < </a>
                            </li>
                            <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                            <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                            <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                            <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                            <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                            <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                            <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                            <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?cutoff=$CUTOFF_ID&page=$next_page&row=$row'"; ?>>> </a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 col-lg-1 d-none d-lg-flex justify-content-center align-items-center">
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
                <table class="table table-bordered m-0" id="table_main" style="width:100%">
                  <thead>
                    <th style='width:15%;'>Date</th>
                    <th>Employee</th>
                    <th>Shift</th>
                    <th style='width:10%;'>Time In</th>
                    <th style='width:10%;'>Time Out</th>
                    <th>Work Hours</th>
                    <th>Regular Work Hours</th>
                    <th style="width:10%" class="text-center">Action</th>
                  </thead>
                  <tbody id="tbl_application_container">
                    <?php if ($TABLE_DATA) {  ?>
                      <?php foreach ($TABLE_DATA as $row_data) : ?>
                        <tr>
                          <td><?= date_format(date_create($row_data->date), 'd/m/Y') ?></td>
                          <td><?= $row_data->employee ?></td>
                          <td><?= $row_data->shift ?></td>
                          <td><?= $row_data->time_in ?></td>
                          <td><?= $row_data->time_out ?></td>
                          <td><?= $row_data->work_hours ?></td>
                          <td><?= $row_data->regular_work_hours ?></td>
                          <td>
                            <button class="btn btn-sm btn-primary apply_leave" data-toggle="modal" data-target="#apply_overtime_modal" data-date="<?= $row_data->date ?>" data-empl_id="<?= $row_data->empl_id ?>" data-reg_time_out="<?= $row_data->time_regular_end ?>" data-time_out="<?= $row_data->time_out ?>" data-overtime="<?= $row_data->work_hours - $row_data->regular_work_hours ?>" data-attendance_id="<?= $row_data->id ?>" data-employee="<?= $row_data->employee ?>">Apply Overtime</button>
                          </td>
                        </tr>
                      <?php endforeach ?>
                    <?php } else { ?>
                      <tr class="table-active">
                        <td colspan="12">
                          <center>No Records</center>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
              <div class="col-12 col-lg-6 row d-flex d-lg-none justify-content-center">
                <div class="col-12 col-lg-6 d-flex justify-content-lg-end justify-content-center align-items-center mx-2">
                  <div class="d-flex align-items-center row">
                    <div class="d-inline col-12 col-lg-6">
                      <p class="p-0 m-0 mx-auto text-center text-nowrap" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                    </div>

                    <div class="d-lg-inline d-flex col-12 col-lg-4 justify-content-center justify-content-lg-end">
                      <ul class="pagination ml-0 ml-lg-4 m-0 p-0 ">
                        <li><a <?php if ($current_page > 1) echo "href='?page=$prev_page&row=$row&tab=$TAB'"; ?>>
                            < </a>
                        </li>
                        <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=1&row=<?= $row ?>" <?php if ($current_page == 1) echo "hidden"; ?>>1 </a></li>
                        <li><a <?php if ($current_page <= 2) echo "hidden"; ?>>... </a></li>
                        <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page - 1 ?>&row=<?= $row ?>" <?php if ($current_page <= 2) echo "hidden"; ?>><?= $prev_page ?></a></li>
                        <li><a style="color:white ; background-color:#007bff !important"> <?= $current_page ?> </a></li>
                        <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $current_page + 1 ?>&row=<?= $row ?>" <?php if ($current_page >= $last_page - 1)  echo "hidden";  ?>><?= $next_page ?> </a></li>
                        <li><a <?php if ($current_page >= $last_page - 1)  echo "hidden"; ?>>... </a></li>
                        <li><a href="?cutoff=<?= $CUTOFF_ID ?>&page=<?= $last_page ?>&row=<?= $row ?>" <?php if ($current_page == $last_page || $last_page <= 0) echo "hidden"; ?>><?= $last_page ?> </a></li>
                        <li><a style="margin-right: 10px;" <?php if ($current_page < $last_page)   echo "href='?cutoff=$CUTOFF_ID&page=$next_page&row=$row'"; ?>>> </a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-12 col-lg-1 d-flex d-lg-none justify-content-center align-items-center my-2">
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

      <div class="modal fade " id="apply_overtime_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Apply Overtime</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="<?= base_url('overtimes/add_recommendation_overtime') ?>" id="overtime_form" method='post'>
                <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" name='assigned_by' />
                <input type='hidden' value="<?= $this->session->userdata('SESS_USER_ID') ?>" id="input_employee_id" name='empl_id' />
                <input type="hidden" name="attendance_id" value="" id="attendance_id" />
                <div class="form-group">
                  <label class="">Employee</label>

                  <select class="form-control custom_selection" name="empl_id" id="input_empl_id">
                  </select>
                </div>

                <div class="form-group">
                  <label class="required" for="input_date_ot">Overtime Date</label>
                  <input type="date" class="form-control" name="date_ot" id="input_date_ot" value="<?= date('Y-m-d') ?>" required readonly>
                </div>
                <div class="form-group">
                  <label for="type">Date Type</label>
                  <input type="text" class="form-control" name="type" id="date_type" value="" readonly>
                </div>


                <div class="form-group">

                  <label class="required">Shift Type</label>

                  <!-- <input type="text" id="shift_type" class="form-control" value="" disabled> -->
                  <p class="p-0 p-2 m-0 bg-light rounded d-flex justify-content-between" id="shift_type"><span>No shift assign</span></p>

                </div>
                <div class="form-group">
                  <label class="required d-block " for="input_time_out">Time Range</label>
                  <div class="input-group">
                    <input type="text" name="time_out" class="form-control" id="time_range" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="required" for="input_hours">Overtime Hours</label>
                  <input type="number" required class="form-control " min="0" step="0.01" name="hours" id="input_hours" enabled="" readonly value="">
                </div>
                <div class="form-group">
                  <label class="" for="input_reason">Reason</label>
                  <textarea name="reason" class="form-control" id="reason" rows="4" cols="50" enabled=""></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="apply_request">Apply Overtime</button>
            </div>
          </div>
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
      <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
      <script>
        $(document).ready(function() {
          $('#cut_off_select,#row_dropdown').on('change', function() {
            reloadPage();
          })
          $('#apply_overtime_modal').on('shown.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var date = button.data('date');
            var employee = button.data('employee');
            var empl_id = button.data('empl_id');
            var reg_time_out = button.data("reg_time_out");
            var time_out = button.data("time_out");
            var hours = button.data('overtime');
            var attendance_id = button.data('attendance_id');
            var modal = $(this);
            modal.find('.modal-body input#input_date_ot,.modal-body input#date').val(date)
            modal.find('.modal-body input#input_employee').val(employee);
            modal.find('.modal-body select#input_empl_id').html('<option value=' + empl_id + '>' + employee + '</option>');
            modal.find('.modal-body input#time_range').val(reg_time_out + ' - ' + time_out);
            modal.find('.modal-body input#input_hours').val(hours);
            modal.find('.modal-body input#attendance_id').val(attendance_id);
          })

          function reloadPage() {
            var cutoff = $('#cut_off_select').val();
            var row = $('#row_dropdown').val();
            var page = "<?= $PAGE ?>";
            window.location.href = "?cutoff=" + cutoff + "&page=" + page + "&row=" + row;
          }
        })
      </script>
      <script>
        $(document).ready(function() {
          let date = ''; // Initialize the date variable outside the event handler

          $('#input_date_ot, #input_employee_id').on('change', function() {
            let empl_id = $('#input_employee_id').val();
            date = $('#input_date_ot').val(); // Update the global 'date' variable
            let formatted_date = moment(date);
            console.log(formatted_date.format('MM/DD/YYYY'));

            $.post("<?= base_url('overtimes/get_shift_type') ?>", {
              'empl': empl_id,
              'date': date
            }, function(res) {
              if (res) {
                let name = res.name ? res.name : '';
                let start_time = res.time_regular_start ? res.time_regular_start : '';
                let end_time = res.time_regular_end ? res.time_regular_end : '';
                let html_data = `<span>${name}</span><span>${start_time} To ${end_time}</span>`;
                $('#shift_type').html(html_data);
              }
              if (res.length <= 0) {
                $('#shift_type').html(`<span>No shift assign</span>`);
              }
            }, 'json');
          });

          // get the shift type when  page is loaded
          function fetchShiftType() {
            let empl_id = $('#input_employee_id').val();
            date = $('#input_date_ot').val(); // Update the global 'date' variable
            let formatted_date = moment(date);
            console.log(formatted_date.format('MM/DD/YYYY'));

            $.post("<?= base_url('overtimes/get_shift_type') ?>", {
              'empl': empl_id,
              'date': date
            }, function(res) {
              if (res) {
                let name = res.name ? res.name : '';
                let start_time = res.time_regular_start ? res.time_regular_start : '';
                let end_time = res.time_regular_end ? res.time_regular_end : '';
                let html_data = `<span>${name}</span><span>${start_time} To ${end_time}</span>`;
                $('#shift_type').html(html_data);
              }
              if (res.length <= 0) {
                $('#shift_type').html(`<span>No shift assign</span>`);
              }
            }, 'json');
          }

          // Call the function on page load
          fetchShiftType();

          // Bind the function to the change event of input elements
          $('#input_date_ot, #input_employee_id').on('change', function() {
            fetchShiftType();
          });
          $(document).on('click', 'button#apply_request', function() {
            $('form#overtime_form').submit();
          })


        })
      </script>
      <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->

      <script>
        $(document).ready(function() {

          function updateDateType() {
            var selectedDate = $('#input_date_ot').val();


            $.ajax({
              url: '<?= base_url('overtimes/check_holiday') ?>',
              method: 'POST',
              data: {
                date: selectedDate
              },
              success: function(response) {
                console.log(response);
                var dateType = (response.isHoliday) ? response.holidayType : 'Regular Day';
                $('#date_type').val(dateType);
              },
              error: function(error) {
                console.error('Error checking holiday:', error);
              }
            });
          }


          $('#input_date_ot').on('input', updateDateType);


          updateDateType();
        });
      </script>

</body>

</html>