<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS
@author     Technos Developers
@datetime   16 November 2022
@purpose    Company Contributions
CONTROLLER FILES:
MODEL FILES:
----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->
<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="row">
            <!-- Title Text -->
            <div class="col-md-6">
                <h1 class="page-title">Super Administrator Module<h1>
            </div>
            <div class="col-md-6" style="text-align: right;">
            </div>
        </div>
        <!-- Title Header Line -->
        <hr>
        <div class="row">
            <!-- My Info -->
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="<?= base_url() ?>superadministrators/setups" style="text-decoration: none;   color: black;">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="fas fa-tools"></i></span>
                       <div class="info-box-content" style=" width:50px;">
                            <span class="info-box-text" style="font-size:large !important">Setup</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="<?= base_url() ?>superadministrators/module_activations" style="text-decoration: none;   color: black;">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="fas fa-check-double"></i></span>
                       <div class="info-box-content" style=" width:50px;">
                            <span class="info-box-text" style="font-size:large !important">Module Activation</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                <a href="<?= base_url() ?>superadministrators/truncate_database_tables" style="text-decoration: none;   color: black;">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="fas fa-check-double"></i></span>
                       <div class="info-box-content" style=" width:50px;">
                            <span class="info-box-text" style="font-size:large !important">Truncate Tables</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                <a href="<?= base_url() ?>superadministrators/configurations" style="text-decoration: none;   color: black;">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="fas fa-check-double"></i></span>
                       <div class="info-box-content" style=" width:50px;">
                            <span class="info-box-text" style="font-size:large !important">Configuration</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                <a href="<?= base_url() ?>superadministrators/system_variables" style="text-decoration: none;   color: black;">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="fas fa-check-double"></i></span>
                       <div class="info-box-content" style=" width:50px;">
                            <span class="info-box-text" style="font-size:large !important">System Variables</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 col-12">
                <a href="<?= base_url() ?>payrolls/attendance_records_lock" style="text-decoration: none;   color: black;">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-warning"><i class="fa-duotone fa-file-lock"></i></span>
                       <div class="info-box-content" style=" width:50px;">
                            <span class="info-box-text" style="font-size:large !important">Attendance Records Lock</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
</body>
</html>