<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />


<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'attendances'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
          </a>&nbsp;Advance Filing of Time Records<h1>
      </div>
      <!-- <div class="col-md-6 button-title">
        <a href="<?= base_url('attendances/add_attendance_summary_advance') ?>" class="btn btn-primary"><img style="width: 16px; height: 16px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/circle-plus-solid.svg') ?>" alt="" id="edit">
          &nbsp;Add Record</a>

      </div> -->
    </div>

    <div class="row">
      <div class='col-md-3 m-2'>
        <h6 class="p-0 mb-1">Employees</h6>
        <select class="form-control" id="employee_select">
          <?php foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEE) { ?>
            <option value="<?= $DISP_EMPLOYEE->id ?>" <?= $EMPL_ID == $DISP_EMPLOYEE->id ? 'selected' : '' ?>> <?= $DISP_EMPLOYEE->col_empl_cmid ?> - <?= $DISP_EMPLOYEE->fullname ?> </option>
          <?php } ?>
        </select>
      </div>

      <div class='col-md-3 m-2'>
        <h6 class='p-0 mb-1'>Start Date</h6>
        <input class="custom-select " type="date" id="date_period" name="date_period" value="<?= $DATE_PERIOD ?>" max="<?= $END_DATE_PERIOD ?>">
      </div>
      <div class='col-md-3 m-2'>
        <h6 class='p-0 mb-1'>End Date</h6>
        <input class="custom-select " type="date" id="end_date_period" name="end_date_period" value="<?= $END_DATE_PERIOD ?>" min="<?= $DATE_PERIOD ?>">
      </div>
    </div>

    <div class="card border-0 p-0 m-0">
      <div class="card border-0 pt-1 m-0">
        <div class="card-header d-none p-0">
          <div class="row ">

           
          </div>
        </div>

        <div class="p-2">
          <div>
            <button class="btn btn-primary" id="btn-update"><img style="width: 16px; height: 16px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
              &nbsp;Update</button>

          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="">
              <div id="table_data"> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="modal_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <p style="font-size: 400px;" class="modal-title text-muted" id="exampleModalLabel">Ready to Leave?</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="text-white">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <p>Hi are you sure you want to logout? </p>
      </div>

      <div class="modal-footer pb-1 pt-1">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="<?php echo base_url() . 'login/logout'; ?>" class="btn btn-info">Logout</a>
      </div>
    </div>
  </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script>
  var url = '<?= base_url() ?>';
  var attendance_record = <?= json_encode($DISP_ATTENDANCE_RECORDS); ?>;
  var employees = <?= json_encode($DISP_EMPLOYEES); ?>;
  console.log('attendance_record', attendance_record);
  const updatedConvertedData = attendance_record.map(item => {
    if (item.date) {
      const [year, month, day] = item.date.split('-');
      item.date = `${day}/${month}/${year}`;
    }

    const employee = employees.find(emp => emp.id === item.empl_id);
    if (employee) {
      item.empl_id = employee.col_empl_cmid;
    }
    return item;
  });

  const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    td.style.whiteSpace = 'nowrap';
    td.style.overflow = 'hidden';
  };

  const container = document.querySelector('#table_data');
  hot = new Handsontable(container, {
    data: updatedConvertedData,
    nestedHeaders: [
      ['','','',{label: 'ZKTECO',colspan: 2},{label: 'Remote',colspan: 2},{label: 'Advance',colspan: 2},{label: 'Shift',colspan: 2}],
      ['id','Employee ID', 'Date', 'Time in', 'Time out', 'Time in', 'Time out', 'Time in', 'Time out', 'Shift in', 'Shift out']
    ],
    rowHeaders: true,
    height: window.innerHeight - container.getBoundingClientRect().top - 50,
    outsideClickDeselects: false,
    selectionMode: 'multiple',
    licenseKey: 'non-commercial-and-evaluation',
    renderer: customStyleRenderer_new,
    stretchH: 'all',
    minRows: 1,
    hiddenColumns: {
      columns: [0,1],
      indicators: true,
    },
    columns: [
      {
        data: 'id',
        readOnly: true
      },
      {
        data: 'empl_id',
        readOnly: true
      },
      {
        data: 'date',
        readOnly: true
      },
      {
        data: 'zkteco_in',
        readOnly: true
      },
      {
        data: 'zkteco_out',
        readOnly: true
      },
      {
        data: 'remote_in',
        readOnly: true
      },
      {
        data: 'remote_out',
        readOnly: true
      },
      {
        data: 'advance_in',
      },
      {
        data: 'advance_out',
      },
      {
        data: 'time_regular_start',
        readOnly: true
      },
      {
        data: 'time_regular_end',
        readOnly: true
      },
    ]
  });

  var udpate_date = document.getElementById('btn-update');
  udpate_date.addEventListener('click', function() {

    const confirmed = confirm('Are you sure you want to update the data?');
    if (!confirmed) {
      return;
    }

    // const updatedData = hot.getData();
    // console.log('updatedConvertedData', updatedConvertedData);
    // const revertedData = updatedConvertedData.map(obj => ({ id: obj.id, advance_in: obj.advance_in, advance_out: obj.advance_out, empl_id: obj.empl_id, date: obj.date }));
    const revertedData = updatedConvertedData.map(obj => {
    const originalDate = obj.date;
    const dateComponents = originalDate.split('/');
    const formattedDate = `${dateComponents[2]}-${dateComponents[1].padStart(2, '0')}-${dateComponents[0].padStart(2, '0')}`;
      if (obj.id) {
        return {
              id: obj.id,
              advance_in: obj.advance_in,
              advance_out: obj.advance_out,
              empl_id: obj.empl_id,
              date: formattedDate
          };
      }else if(obj.advance_in || obj.advance_out){
        return {
              id: obj.id,
              advance_in: obj.advance_in,
              advance_out: obj.advance_out,
              empl_id: obj.empl_id,
              date: formattedDate
          };
      }
    });

    const filteredData = revertedData.filter(value => value !== undefined);

    console.log('revertedData', revertedData);
    console.log('filteredData', filteredData);
    console.log('filteredData', filteredData.length);
    let empl_id = document.getElementById("employee_select").value;
    console.log('empl_id',empl_id);
    // return;
    // if (!(revertedData.length < 1 && revertedData[0] != undefined)) {
    //   $(document).Toasts('create', {
    //       class: 'bg-warning toast_width',
    //       title: 'Warning!',
    //       subtitle: 'close',
    //       body: 'No Changes'
    //     })
    // }
    fetch(url + 'attendances/update_attendance_record_advance', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({filteredData,empl_id})
      })
      .then(response => response.json())
      .then(result => {
        console.log(result);

        if (result.success_message) {
          $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: result.success_message
          })
        }

        if (result.warning_message) {
          $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: result.warning_message
          })
        }

      })
      .catch(error => {
        $(document).Toasts('create', {
          class: 'bg-warning toast_width',
          title: 'Warning!',
          subtitle: 'close',
          body: 'Please provide all required information.'
        })
        console.error('Data update error:', error);
      });
  });

  const employeeSelect = document.getElementById("employee_select");
  const datePeriod = document.getElementById("date_period");
  const endDatePeriod = document.getElementById("end_date_period");

  employeeSelect.addEventListener("change", filterData);
  datePeriod.addEventListener("change", filterData);
  endDatePeriod.addEventListener("change", filterData);

  function filterData() {
    const selectedEmployee = employeeSelect.value;
    const selectedDate = datePeriod.value;
    const selectedEndDate = endDatePeriod.value;
    const redirectUrl = `${url}attendances/update_attendance_summary_advance?employee=${selectedEmployee}&start_date=${selectedDate}&end_date=${selectedEndDate}`;

    window.location.href = redirectUrl;
  }
</script>

</body>

</html>