<html>
<?php $this->load->view('templates/css_link'); ?>


<div class="content-wrapper">
  <div class="container-fluid p-4">
    <div class="row pt-1">
      <div class='row'>
        <div class="col-md-6">
          <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'reports'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
            </a>&nbsp;Reports</h1>
        </div>
      </div>
    </div>
    <hr>
    <div class="row pt-1 justify-content-md-center">
      <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center">
          <h1 class="page-title">Government Remittance Forms<h1>
              <a class="btn btn-primary" href="<?= site_url('reports/form_settings') ?>"><img style="width: 16px; height: 16px; margin-bottom: 4px;" src="<?= base_url('assets_system/icons/gear-solid_xs.svg') ?>" alt="" /> Settings</a>
        </div>

        <div class="card border-0 py-1 mt-3">
          <div class="table-responsive" style="max-height: 75vh">
            <table class="table table-bordered table-hover m-0" id="TableToExport">
              <thead style="position: sticky; top: 0;">
                <tr>
                  <th class="text-left" style="min-width: 300px !important">REPORT TITLE</th>
                  <th class="text-left" style="min-width: 150px !important">FREQUENCY</th>
                </tr>
              </thead>
              <tbody id="tbl_application_container">
                <tr>
                  <td><a href="<?= site_url('reports/bir_2316') ?>" class="pdf-file text-primary">BIR 2316</a></td>
                  <td>Monthly</td>
                </tr>
                <tr>
                  <td><a href="<?= site_url('reports/bir_1601_c') ?>" class="pdf-file text-primary">BIR 1601-C: Monthly Remittance Return of Income Taxes Withheld on Compensation</a></td>
                  <td>Monthly</td>
                </tr>

                <tr>
                  <td><a href="<?= site_url('reports/bir_alpha_list') ?>" class="pdf-file text-primary">BIR Alphalist</a></td>
                  <td>Annually</td>
                </tr>

                <tr>
                  <td><a href="<?= site_url('reports/bir_alpha_list_dat') ?>" class="pdf-file text-primary">BIR Alphalist DAT File</a></td>
                  <td>Annually</td>
                </tr>

                <tr>
                  <td><a href="<?= site_url('reports/sss_employees_report') ?>" class=" text-primary ">SSS Form R-1a: Employment Report</a></td>
                  <td>Monthly</td>
                </tr>

                <tr>
                  <td><a href="<?= site_url('reports/sss_collection_lists') ?>" class="pdf-sssr_file text-primary">SSS Form R-3: Contribution Collection List</a></td>
                  <td>Monthly</td>
                </tr>

                <tr>
                  <td><a href="<?= site_url('reports/sss_employer_return') ?>" class="pdf-sss_file text-primary">SSS Form R-5: Employer Contributions Payment Return</a></td>
                  <td>Monthly</td>

                </tr>

                <tr>
                  <td><a href="<?= base_url() ?>assets_system/reports/PHIC_RF1.xlsx" target="_blank">PhilHealth RF-1: Remittance Report</a></td>
                  <td>Monthly</td>

                </tr>

                <tr>
                  <td><a href="<?= base_url() ?>assets_system/reports/PHIC_RF1.xlsx" target="_blank">PhilHealth RF-1: Remittance Report (XLS)</a></td>
                  <td>Monthly</td>

                </tr>

                <tr>
                  <td><a href="<?= site_url('reports/phil_health_member_report') ?>" class="pdf-phic text-primary">PhilHealth Er2: Employee-Members Report</a></td>
                  <td>Monthly</td>

                </tr>

                <tr>
                  <td><a href="<?= site_url('reports/pag_ibig_contribution_remitance') ?>" class="pdf-sss_file text-primary">Pag-ibig FPF060: Membership Contributions Remittance Form (MCRF)</a></td>
                  <td>Monthly</td>
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