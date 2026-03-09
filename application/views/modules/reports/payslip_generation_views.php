<html>
<?php $this->load->view('templates/css_link'); ?>


<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
        <div class="col-md-12">
            <div class="col-md-12">
                <h1 class="page-title">
                    <a href="<?= base_url('reports');?>">
                        <img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                    </a>&nbsp;Payroll Reports
                </h1>
            </div>
        </div>
    </div>

    <div class="row pt-1 justify-content-md-center">
      <div class="col-md-8">
            <div class="card border-0 p-1 mt-3">
              <div class="table-responsive" style="max-height: 75vh">
                <table class="table table-hover m-0" id="TableToExport">
                  <thead style="position: sticky; top: 0;">
                    <tr>
                      <th class="text-left" style="min-width: 300px !important">REPORT TITLE</th>
                      <th class="text-left" style="min-width: 150px !important">FREQUENCY</th>
                    </tr>
                  </thead>
                  <tbody id="tbl_application_container">
                    <tr>
                        <td>
                            <a href="<?= site_url('reports/payslips_loan_deductions')?>">Payslips: Cutoff / Loans and Deductions</a>
                        </td>
                        <td>Cut-off Period</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="<?= site_url('reports/payslip_benifits')?>">Payslips: Cutoff SSS Pagibig Philhealth</a>
                        </td>
                        <td>Cut-off Period</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="<?= site_url('reports/payslip_remittances')?>">Payslips: Cutoff Remittance</a>
                        </td>
                        <td>Cut-off Period</td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
      </div>
    </div>
  </div>
</div>
</body>

</html>