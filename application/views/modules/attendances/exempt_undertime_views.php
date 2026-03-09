<html>
<?php $this->load->view('templates/css_link'); ?>
<style>
  .swal2-validation-message {
    max-width: 100% !important;
    margin: auto !important;
  }

  @media (max-width: 576px) {
    .py-3 .cut_off_period {
      width: 100% !important;
    }
  }
</style>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->

<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class="col-md-6">
        <!-- <a href="<?= base_url() . 'payrolls'; ?>"><i class="fa-solid fa-square-left"></i> -->
        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('attendances'); ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Exempt Undertime<h1>
      </div>
      <div class="col-md-6 button-title">
        <!--<a href="<?= base_url() . 'payrolls/add_loans' ?>" id="btn_new" class=" btn technos-button-green shadow-none rounded"><i class="fas fa-plus"></i>&nbsp;Add New Loan</a>-->
        <!--<a href="<?= base_url('payrolls/bulk_loans') ?>" id="bulk_import" class=" btn technos-button-green shadow-none rounded" ><i class="fas fa-file-import"></i>&nbsp;Bulk Import</a>-->
        <!-- <a id="btn_export" class=" btn technos-button-blue shadow-none rounded" ><i class="fas fa-file-pdf"></i>&nbsp;Export PDF</a> -->
      </div>
    </div>
    <div class=" py-3 w-25">
      <h6>Cut-off Period</h6>
      <select class="form-control cut_off_period">
        <?php foreach ($CUT_OFF_PERIOD as $period) { ?>
          <option value="<?= $period->id ?>" <?= $period->id == $CUT_OFF ? 'selected' : '' ?>><?= $period->name ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="card border-0 p-0 m-0">
      <div class="card border-0 pt-1 m-0">
        <div>
          <p class=" m-2 bg-primary p-1  text-center ml-auto" style="color: gray;width:150px;border-radius:15px">Showing <?= count($UNDERTIME) ?> entries&nbsp;</p>
        </div>
        <div class="table-responsive" style="max-height: 75vh">
          <table class="table table-bordered table-hover m-0" id="TableToExport">
            <thead style="position: sticky; top: 0;">
              <tr>
                <!--<th class="text-center" style="min-width: 50px !important"><input type="checkbox" name="check_all" id="check_all"></th>-->
                <!--<th class="text-center" style="min-width: 100px !important">ID</th>-->
                <th class="text-left" style="min-width: 150px !important">DATE</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE ID</th>
                <th class="text-left" style="min-width: 300px !important">EMPLOYEE NAME</th>
                <th class="text-left" style="min-width: 150px !important">SHIFT TIME OUT</th>
                <th class="text-left" style="min-width: 150px !important">TIME OUT</th>
                <th class="text-left" style="min-width: 100px !important">NO. OF HOURS</th>
                <!--<th class="text-center" style="min-width: 100px !important">Payment&nbsp;Amount</th>-->
                <!--<th class="text-center" style="min-width: 100px !important">Terms</th>-->
                <!--<th class="text-center" style="min-width: 100px !important">Status</th>-->
                <th class="text-center" style="min-width: 100px !important">ACTION</th>
              </tr>
            </thead>
            <tbody id="tbl_application_container">
              <?php if ($UNDERTIME) {
                foreach ($UNDERTIME as $undertime) {
              ?>
                  <tr>
                    <!-- <td class="text-left"><?= date_format(date_create($undertime->date), "d/m/Y") ?></td> -->
                    <td class="text-left"> <?= date(($DATE_FORMAT) ? $DATE_FORMAT : "d/m/Y", strtotime($undertime->date)) ?></td>
                    <td class="text-left"><?= $undertime->col_empl_cmid ?></td>
                    <td class="text-left"><?= $undertime->fullname ?></td>
                    <td class="text-left"><?= $undertime->time_regular_end ?></td>
                    <td class="text-left"><?= $undertime->time_out ?></td>
                    <td class="text-left"><?= $undertime->duration ?></td>
                    <td class="text-left">
                      <form action="<?= site_url('attendances/exempt_undertime') ?>" method="POST">
                        <input type="hidden" name="attendance_id" value="<?= $undertime->id ?>" />
                        <input type="hidden" name="description" class="exempt_description" />
                        <button type="submit" class="btn btn-primary exempt_submit">Exempt</button>
                      </form>
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
      </div>
    </div>
  </div>

</div>
<!-- ================================================================ new design End here ======================================================= -->

<!-- LOGOUT MODAL -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.7/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> -->
<!-------------------- Export ----------------->
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
  $(document).ready(function() {

    function setCutOffPeriod() {
      const selectedCutOff = localStorage.getItem('selectedCutOff');
      if (selectedCutOff) {
        $('select.cut_off_period').val(selectedCutOff);
      }
    }

    setCutOffPeriod();

    $('select.cut_off_period').on('change', function() {
      const cutOffValue = $(this).val();
      localStorage.setItem('selectedCutOff', cutOffValue);
      window.location.href = "<?= base_url('attendances/undertime?cut_off=') ?>" + cutOffValue;
    });

    $('.exempt_submit').on('click', function(e) {
      e.preventDefault();
      let formElement = $(this).form();
      console.log(formElement);
      Swal.fire({
        icon: 'warning',
        input: "textarea",
        inputLabel: "Add Reason",
        inputPlaceholder: "Type your message here...",
        inputAttributes: {
          "aria-label": "Type your message here"
        },
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return "You need to write something!";
          }
        },
        preConfirm: async (val) => {
          let descriptionElem = $(formElement).children('.exempt_description');
          await $(descriptionElem).val(val);
          console.log(descriptionElem);

          // Include the cut-off period in the form data
          let cutOffValue = $('select.cut_off_period').val();
          $(formElement).append('<input type="hidden" name="cut_off" value="' + cutOffValue + '">');
        },
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Exempt'
      }).then((result) => {
        if (result.isConfirmed) {
          $(formElement).submit();
        }
      });
      return false;
    });

  });
</script>

</body>

</html>