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
$STATUS='';
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
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('leaves/leave_lists') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />

            </a>&nbsp;Leave Recommendation<h1>
        </div>
      </div>

      <div class=" py-3 w-25">
        <p class="p-0 my-1 text-bold">Cut-off Period:</p>
        <select class="form-control" id="cut_off_select">
<?php foreach($CUTOFF as $cutoff_period) : ?>
            <option value="<?=$cutoff_period->id?>" <?= $cutoff_period->id==$CUTOFF_ID ? 'selected' : '' ?>><?=$cutoff_period->name?></option>
<?php endforeach ?>
        </select>
      </div>




      <div class="card border-0 p-0 m-0">
        <div class="card border-0 pt-1 m-0">
          <div class="p-2">
            <div>
              <div class=" ">
                <div class="pb-2 row d-flex align-items-center justify-content-center">
                  <div class="d-flex col-8 col-md-10 col-lg-11">
                    <div class="d-flex align-items-center ml-auto">

                      <p class="my-auto d-inline" style="color: gray">Showing <?= $low_limit ?> to <?= $high_limit ?> of <?= $C_DATA_COUNT ?> entries&nbsp;</p>
                      <ul class="d-inline pagination m-0 p-0 ">
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

                  <div class="col-4 col-md-2 col-lg-1  d-flex align-items-center justify-content-end">
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
                    <th style="width:10%" class="text-center">Action</th>
                  </thead>
                  <tbody id="tbl_application_container">
            <?php if ($TABLE_DATA) {  ?>
                <?php foreach($TABLE_DATA as $row_data) : ?>
                    <tr>
                        <td><?=date_format(date_create($row_data->date),'d/m/Y')?></td>
                        <td><?=$row_data->employee?></td>
                        <td><?=$row_data->shift?></td>
                        <td><?=$row_data->time_in?></td>
                        <td><?=$row_data->time_out?></td>
                        <td><?=$row_data->work_hours?></td>
                        <td>
                            <button class="btn btn-sm btn-primary apply_leave" data-toggle="modal" data-target="#apply_leave_modal" 
                            data-date="<?=$row_data->date?>" data-empl_id="<?=$row_data->empl_id?>"
                            data-employee="<?=$row_data->employee?>"
                            >Apply Leave</button>
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
            </div>
          </div>
        </div>
      </div>

<div class="modal fade " id="apply_leave_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apply Leave</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="leaveForm" style="width:100%">
            <div class="col-md-12">
                <!-- <?php echo form_open('leaves/add_new_leave'); ?> -->
                <!--<label class="">Assigned by</label>-->
                <!--<select class="form-control custom_selection" name="assigned_by" id="input_assigned_by">-->
                <!--</select>-->
                <div class="form-group">
                    <label class="">Employee</label>
                    <select class="form-control" name="empl_id" id="input_empl_id">
                        
                    </select>
                </div>
                <div class="form-group">
                    <label class="">Type</label>
                    <select class="form-control" name="type" id="type" enabled="">
                        <?php foreach ($LEAVE_TYPES as $type) { ?>
                            <option value='<?= $type->id ?>' data-name='<?= $type->name ?>'><?= $type->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div id="diplayBalance_div" style="display: none;">
                    <label class="">Current Leave Balance</label>
                    <div class="form-group">
                        <input type="text" class="form-control " min="0" name="duration" id="diplayBalance" required enabled="" disabled>
                    </div>
                </div>
                <table id="timeTable">
                    <thead>
                        <tr>
                            <!-- <th>Date</th>
                            <th>Leave Range</th>
                            <th>Number of Hours</th>
                            <th>Action</th> -->
                            <th style="width: 40%;">Date</th>
                            <th style="width: 40%;">Leave Range</th>
                            <th style="width: 10%;">Hours</th>
                            <th style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <input type="date" name="dates[]" id="date_input" value="" class="date form-control">
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="leave_range[]" value="" class=" leaverange form-control" placeholder="Select time range">
                                </div>
                            </td>
                            <td><input type="number" name="hours[]" value="8" class="hours form-control"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group" id="reason">
                    <label class="" for="input_reason">Reason</label>
                    <textarea name="reason" class="form-control" id="remarks" rows="4" cols="50" enabled=""></textarea>
                </div>
                <div class="file_uploader form-group" data-type="leave" id="attachment">
                    <label>Attachment</label>
                    <input type="hidden" name="attachment" class="selected_images d-block w-100" />
                </div>
                <div class="mr-2" style="float: right !important">
                    <button type='button' id="btn_add" class="btn technos-button-blue shadow-none rounded " onclick="submitForm()">
                        Submit</button>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="submitForm()">Apply Leave</button>
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
        $('#apply_leave_modal').on('shown.bs.modal', function (event) {
          var button    = $(event.relatedTarget); // Button that triggered the modal
          var date      = button.data('date');
          var employee  = button.data('employee');
          var empl_id   = button.data('empl_id');
          
          var modal = $(this);
          modal.find('.modal-body input#date_input,.modal-body input#date').val(date)
          modal.find('.modal-body input#input_employee').val(employee);
          modal.find('.modal-body select#input_empl_id').html('<option value='+empl_id+'>'+employee+'</option>');
        })
          function reloadPage() {
            var cutoff  = $('#cut_off_select').val();
            var row     = $('#row_dropdown').val();
            var page    = "<?= $PAGE ?>";
            window.location.href ="?cutoff=" + cutoff + "&page=" + page + "&row=" + row;
          }
          $("#btn_export").on('click', function() {
            var wb = XLSX.utils.table_to_book(document.getElementById('table_main'));
            XLSX.writeFile(wb, "my_time_adjustment.xlsx");
          });
        })
      </script>
     
<script>
    function addRow() {
        const lastRow = document.getElementById('timeTable').rows.length - 1;
        const lastDate = document.getElementById('timeTable').rows[lastRow].querySelector('.date').value;
        const lastHours = document.getElementById('timeTable').rows[lastRow].querySelector('.hours').value;
        const leaverange = document.getElementById('timeTable').rows[lastRow].querySelector('.leaverange').value;
        const newRow = document.createElement('tr');
        newRow.classList.add('dynamic-row');
        const nextDate = new Date(lastDate);
        nextDate.setDate(nextDate.getDate() + 1);

        // newRow.innerHTML = '<td><input type="date" name="dates[]"  value="' + nextDate.toISOString().split('T')[0] + '" class="date form-control"></td>' +
        //     '<td><input type="number" name="hours[]" value="' + lastHours + '" class="hours form-control"></td>';
        newRow.innerHTML = '<td><input type="date" name="dates[]" value="' + nextDate.toISOString().split('T')[0] + '" class="date form-control"></td>' +
            '<td><input type="text" name="leave_range[]" value="' + leaverange + '" class="leaverange form-control"  placeholder="Select time range"></td>' +
            '<td><input type="number" name="hours[]" value="' + lastHours + '" class="hours form-control"></td>' +
            '<td class ="text-center"><a class="select_row p-2" style="color: gray; cursor: pointer; !important" id="remove_row" > <img src="<?= base_url('assets_system/icons/trash-solid.svg') ?>" onclick="removeRow(this)" alt=""> </a></td>';

        document.getElementById('timeTable').querySelector('tbody').appendChild(newRow);

        // Initialize daterangepicker for the leaverange input in the newly added row
        $(newRow).find('.leaverange').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            showCalendar: false,
            startDate: moment().startOf('day').add(8, 'hours'), // Set start time to 8 AM
            endDate: moment().startOf('day').add(17, 'hours'), // Set end time to 5 PM (17:00)
            locale: {
                format: 'HH:mm:ss'
            }
        });
    }
    document.querySelector('.date').valueAsDate = new Date();

    $('.leaverange').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        showCalendar: false,
        startDate: moment().startOf('day').add(8, 'hours'), // Set start time to 8 AM
        endDate: moment().startOf('day').add(17, 'hours'), // Set end time to 5 PM (17:00)
        locale: {
            format: 'HH:mm:ss'
        }
    });

    function removeRow(icon) {
        const rowToRemove = icon.closest('tr');

        // Check if the row is a dynamically added row (not the first row)
        if (rowToRemove.classList.contains('dynamic-row')) {
            rowToRemove.remove();
        } else {
            console.log("Cannot delete the first row");
            // Or display an alert/message indicating the first row cannot be deleted
        }
    }

    // function handleLeaveTypeChange() {
    //     var leaveDropdown = document.getElementById("leave_types_dropdown");
    //     var durationInput = document.getElementById("input_duration");

    //     if (leaveDropdown.value === "Leave without Pay (LWOP)") {
    //         console.log("dede");
    //         durationInput.style.display = "none"; // Hide the input_duration
    //     } else {
    //         console.log("Other leave type selected");
    //         durationInput.style.display = "block"; // Show the input_duration
    //     }
    // }
</script>

<script>
    // $(document).ready(function() {

    //     // $('.custom_selection').select2()

    //     const input_empl_id = document.getElementById('input_empl_id');
    //     input_empl_id.addEventListener('change', (event) => {
    //     getRequestLeaveBalance();
    //     });
    //     $('#input_empl_id').select2();
    // })
    $(document).ready(function() {

        $('#input_empl_id').on('select2:select', function(event) {
            getRequestLeaveBalance();
        });
    });
</script>

<script>
    var baseUrl = '<?= base_url() ?>';
    const apiUrl = baseUrl + 'leaves/get_request_leave_by_date';
    const input_empl_id = document.getElementById('input_empl_id');
    const input_type = document.getElementById('type');
    // const input_leave_date = document.getElementById('input_leave_date');
    const input_leave_date = document.getElementById('timeTable').rows[1].querySelector('.date');

    // const input_duration = document.getElementById('input_duration');

    input_type.addEventListener('change', (event) => {
        getRequestLeaveBalance();


        const displayBalanceInput = document.getElementById('type').selectedOptions[0].dataset.name;
        if (displayBalanceInput != "Leave without Pay (LWOP)" && displayBalanceInput != "Offset") {
            document.getElementById("diplayBalance_div").style.display = "block";
        } else {
            document.getElementById("diplayBalance_div").style.display = "none";
        }
    });
    input_leave_date.addEventListener('change', (event) => {
        getRequestLeaveBalance();
    });

    // input_duration.addEventListener('change', (event) => {
    //     console.log('diplayBalance',document.getElementById('diplayBalance').textContent)
    //     console.log('input_duration',input_duration.value)
    //     if( !(document.getElementById('diplayBalance').textContent !== undefined && 
    //         document.getElementById('diplayBalance').textContent !== null && 
    //         document.getElementById('diplayBalance').textContent !== '' && 
    //         !isNaN(document.getElementById('diplayBalance').textContent))
    //         ){
    //             document.getElementById('diplayBalanceAfter').textContent = 'select valid date';
    //             return;
    //         }
    //     if (
    //         !(input_duration.value !== undefined &&
    //         input_duration.value !== null &&
    //         input_duration.value !== '' &&
    //         !isNaN(input_duration.value))
    //         ) {
    //             document.getElementById('diplayBalanceAfter').textContent = 'input duration'; return;
    //     }

    //     document.getElementById('diplayBalanceAfter').textContent = document.getElementById('diplayBalance').textContent - input_duration.value;
    // });

    function getRequestLeaveBalance() {
        const empl_id = input_empl_id.value;
        const type = input_type.value;
        const typeName = input_type.selectedOptions[0].dataset.name;
        // const selectedOption = document.getElementById('type').selectedOptions[0];
        // const name = selectedOption.dataset.name;
        const leave_date = input_leave_date.value;
        // const duration = input_duration.value;
        if (empl_id && type && leave_date) {
            fetch(apiUrl, {
                    method: 'POST',
                    body: JSON.stringify({
                        empl_id,
                        type,
                        leave_date,
                        typeName
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('data', data);
                    if (data.messageError) {
                        document.getElementById('diplayBalance').value = data.messageError;
                        // document.getElementById('diplayBalanceAfter').textContent = data.messageError;
                        // console.log('Error');
                    } else if (data.balance !== undefined && data.balance !== null) {
                        document.getElementById('diplayBalance').value = data.balance;
                        // console.log('Error');
                        // if (input_duration.value) {
                        //     document.getElementById('diplayBalanceAfter').textContent = data.balance - input_duration.value;
                        // }else{
                        //     document.getElementById('diplayBalanceAfter').textContent = 'input duration';
                        // }
                    } else {
                        console.log('unexpected output occured');
                        document.getElementById('diplayBalance').value = '';
                        // document.getElementById('diplayBalanceAfter').textContent = '';
                    }

                    // const btnAdd = document.getElementById('btn_add');

                    // // Enable the button for Offset and LWOP, and if balance is greater than 0
                    // if ((typeName === "Offset" || typeName === "Leave without Pay (LWOP)") || data.balance > 0) {
                    //     btnAdd.disabled = false;
                    // } else {
                    //     btnAdd.disabled = true;
                    // }

                    // if (data.display_reason == 0) {
                    //     console.log('Hiding elements');
                    //     document.getElementById("reason").style.display = "none";

                    // } else {
                    //     console.log('Showing elements');
                    //     document.getElementById("reason").style.display = "block";

                    // }

                    // if (data.display_attachment == 0) {
                    //     console.log('Hiding elements');
                    //     document.getElementById("attachment").style.display = "none";

                    // } else {
                    //     console.log('Showing elements');
                    //     document.getElementById("attachment").style.display = "block";

                    // }
                })
                .catch(error => {
                    console.error('Error sending date to controller:', error);
                });
        }
    }
    getRequestLeaveBalance();
</script>

<?php

if ($this->session->flashdata('SUCC')) { ?>
    <!-- <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script> -->
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php } ?>

<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>', '', 'error')
    </script>
<?php } ?>

<script>
    function submitForm() {
        const formData = new FormData(document.getElementById('leaveForm'));
        const apiUrl = baseUrl + 'leaves/add_leaves_api';
        fetch(apiUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.messageError) {
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning',
                        subtitle: 'close',
                        body: data.messageError
                    })
                } else {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
</body>

</html>