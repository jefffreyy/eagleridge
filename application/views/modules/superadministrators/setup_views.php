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
    <div class="p-4">
        <div class="flex-fill">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>nav_superadmins">Super Administrator</a>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Setup
                    </li>
                </ol>
            </nav>
            <div class="row d-flex">
                <!-- Title Text -->
                <div class="col-12 col-lg-6 d-flex align-items-center">
                    <a href="<?= base_url() . 'superadministrators'; ?>"><img style="width: 24px; height: 24px; margin: 0 7px 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>
                    <h1 style="font-size: 24px;" class="page-title d-inline">Setup</h1>
                </div>

                <div class="col-12 col-lg-6 d-flex justify-content-end">
                    <form action="<?= base_url('superadministrators/update_reset_maiya') ?>" method="post">
                        <button class="btn mr-2 btn-primary btn-block float-right" id="INSRT_BTN" type="submit">Reset to maiya</button>
                    </form>


                    <form action="<?= base_url('superadministrators/update_reset_eyebox') ?>" method="post">
                        <button class="btn  btn-success btn-block float-right" id="INSRT_BTN" type="submit">Reset to eyebox</button>
                    </form>
                </div>



            </div>
        </div>
        <!-- Title Header Line -->
        <hr>

        <div class="card col-12 col-md-10 col-lg-10 mx-auto">
            <form action="<?php echo base_url(); ?>superadministrators/update_company_name" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group " style="margin-bottom: 40px">
                    <label class="required" for="UPDATE_NAME">Company Name: </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <input type="text" class="form-control" name="UPDATE_NAME" id="UPDATE_NAME" value="<?= $DISP_NAME['value'] ?>">
                        </div>
                        <div class="col-4 col-lg-2">
                            <button class="btn w-100 btn-primary btn-block float-right" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="<?php echo base_url(); ?>superadministrators/update_header_content" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group" style="margin-top: 40px">
                    <label class="required" for="UPDATE_NAME">Header: </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <input type="text" class="form-control" name="header" id="UPDATE_NAME" value="<?= $DISP_HEADER_CONTENT['value'] ?>">
                        </div>
                        <div class="col-4 col-lg-2">
                            <button class="btn w-100 btn-primary btn-block float-right" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="<?php echo base_url(); ?>superadministrators/update_footer_content" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group" style="margin-top: 40px">
                    <label class="required" for="UPDATE_NAME">Footer: </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <input type="text" class="form-control" name="footer" id="footer" value="<?= $DISP_FOOTER_CONTENT['value'] ?>">
                        </div>
                        <div class="col-4 col-lg-2">
                            <button class="btn w-100 btn-primary btn-block float-right" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
            </form>
            <form action="<?php echo base_url(); ?>superadministrators/update_logo/" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group" id="application_file" style="margin-top: 40px">
                    <label class="required" for="INSRT_LOGIN_LOGO">Login Logo Image: </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input fileficker" id="INSRT_LOGIN_LOGO" name="INSRT_LOGIN_LOGO" accept=".gif, .jpg, .jpeg, .png, .webp">
                                    <label class="custom-file-label" for="INSRT_LOGIN_LOGO">Choose file
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-lg-2">
                            <button class="btn w-100 btn-primary btn-block float-right" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
                <?php if (file_exists(FCPATH . 'assets_system/images/' . $DISP_LOGO['value'])) { ?>
                    <img style="width:200px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_LOGO['value']; ?>">
                <?php } ?>
            </form>
            <form action="<?php echo base_url(); ?>superadministrators/update_navbar" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group" id="application_file" style="margin-top: 40px">
                    <label class="required" for="INSRT_NAVBAR_LOGO">Navigation Bar Logo: </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input fileficker" id="NAVBAR_LOGO" name="INSRT_NAVBAR_LOGO" accept=".gif, .jpg, .jpeg, .png, .webp">
                                    <label class="custom-file-label" for="INSRT_LOGIN_LOGO">Choose file </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-lg-2">
                            <button class="btn w-100 btn-primary btn-block float-right" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
                <?php if (file_exists(FCPATH . 'assets_system/images/' . $DISP_NAVBAR['value'])) { ?>
                    <img style="width:200px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_NAVBAR['value']; ?>">
                <?php } ?>
            </form>
            <form action="<?php echo base_url(); ?>superadministrators/update_header" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group" id="application_file" style="margin-top: 40px">
                    <label for="INSRT_HEADER_LOGO">Header Logo(Mobile) Image &nbsp;&nbsp; <span class="text-muted"></span>
                    </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input fileficker" id="INSRT_HEADER_LOGO" name="INSRT_HEADER_LOGO" accept=".gif, .jpg, .jpeg, .png, .webp">
                                    <label class="custom-file-label" for="INSRT_HEADER_LOGO">Choose file
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-lg-2">
                            <!-- <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>"> -->
                            <button class="btn w-100 btn-primary float-right" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
                <div>
                    <?php if (file_exists(FCPATH . 'assets_system/images/' . $DISP_HEADER['value'])) { ?>
                        <img style="width:200px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_HEADER['value']; ?>">
                    <?php } ?>
                </div>
            </form>
            <form action="<?php echo base_url(); ?>superadministrators/mobile_banner" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group" id="application_file" style="margin-top: 40px">
                    <label for="INSRT_MOBILE_BANNER">Banner Logo(Mobile) Image &nbsp;&nbsp; <span class="text-muted"></span>
                    </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input fileficker" id="INSRT_MOBILE_BANNER" name="INSRT_MOBILE_BANNER" accept=".gif, .jpg, .jpeg, .png, .webp">
                                <label class="custom-file-label" for="INSRT_MOBILE_BANNER">Choose file
                                </label>
                            </div>
                        </div>
                        <div class="col-4 col-lg-2">
                            <button class="btn btn-primary float-right w-100" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
                <div>
                    <img style="width:200px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_MOBILE_BANNER['value']; ?>">

                </div>
            </form> <!-- Form ends -->
            <form action="<?php echo base_url(); ?>superadministrators/desktop_banner" id="apply_form" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">
                <div class="form-group" id="application_file" style="margin-top: 40px">
                    <label for="INSRT_DESKTOP_BANNER">Banner Logo(Desktop) Image &nbsp;&nbsp; <span class="text-muted"></span>
                    </label>
                    <div class="row">
                        <div class="col-8 col-lg-10">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input fileficker" id="INSRT_DESKTOP_BANNER" name="INSRT_DESKTOP_BANNER" accept=".gif, .jpg, .jpeg, .png, .webp">
                                    <label class="custom-file-label" for="INSRT_DESKTOP_BANNER">Choose file
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-lg-2">
                            <!-- <input type="hidden" name="EMPL_ID" value="<?= $this->session->userdata('SESS_USER_ID') ?>"> -->
                            <button class="btn btn-primary float-right w-100" id="INSRT_BTN" type="submit"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                        </div>
                    </div>
                </div>
                <?php if (file_exists(FCPATH . 'assets_system/images/' . $DISP_DESKTOP_BANNER['value'])) { ?>
                    <img style="width:200px; object-fit:contain" src="<?= base_url() ?>assets_system/images/<?= $DISP_DESKTOP_BANNER['value']; ?>">
                <?php } ?>
            </form> <!-- Form ends -->
        </div>

    </div>
</div>
</div>
<aside class="control-sidebar control-sidebar-dark">
</aside>
<!------------------------------------------------------------- JS Add-ons  --------------------------------------------------------->
<?php $this->load->view('templates/jquery_link'); ?>
<?php
if ($this->session->flashdata('SESS_ERR_IMAGE')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->flashdata('SESS_ERR_IMAGE'); ?>',
            '',
            'warning'
        )
    </script>
<?php
}
?>
<?php
if ($this->session->flashdata('SESS_SUCC')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->flashdata('SESS_SUCC'); ?>',
            '',
            'success'
        )
    </script>
<?php
}
?>
<script>
    $(document).ready(function() {
        // $("input#INSRT_LOGIN_LOGO").on("change",function(evt){
        //     changeFilename(evt,"login_logo.png");
        // })
        // $("input#INSRT_HEADER_LOGO").on("change",function(evt){
        //     changeFilename(evt,"header_logo.png");
        // })
        // function changeFilename(evt,newfilename){
        //     const newName =newfilename ;
        //     const input = evt.currentTarget;
        //     const previousFile = input.files[0];
        //     const newFile = new File([previousFile], newName);
        //     // hack to update the selected file
        //     const dT = new DataTransfer();
        //     dT.items.add(newFile);
        //     input.files = dT.files;
        // }
        /* $("#export_table").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)'); */
        // for async data - fetch count of employees with no payslip
        base_url = '<?= base_url() ?>';
        url = '<?= base_url() ?>payroll/get_employee_no_payslip_count';
        url2 = '<?= base_url() ?>payroll/get_payslip_count_based_on_period';
        url3 = '<?= base_url() ?>payroll/getEmployeeData';
        var payroll_id = $('#date_period').val();
        var cut_off_period_text = $('#date_period option:selected').text();
        // ==================================================== INITITAL VALUE ========================================================
        var total_sss_arr = [];
        var total_pagibig_arr = [];
        var total_philhealth_arr = [];
        var sss_cutoff = $('#tbl_sss .payslip_row');
        var pagibig_cutoff = $('#tbl_pagibig .payslip_row');
        var philhealth_cutoff = $('#tbl_philhealth .payslip_row');
        if (cut_off_period_text) {
            Array.from(sss_cutoff).forEach(function(tr) {
                const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                if (cut_off_period_text == cut_off_period) {
                    tr.style.display = "";
                    var sss_total = $(tr.childNodes[17]).attr('sss_total');
                    total_sss_arr.push(parseFloat(sss_total));
                } else {
                    tr.style.display = 'none';
                    $('#total_sss').html(0);
                }
            });
            // get the total sum of array values
            // append the total sum of arrays to mini cards as texts
            $('#total_sss').html((total_sss_arr.reduce((a, b) => a + b, 0)).toFixed(2));
            Array.from(pagibig_cutoff).forEach(function(tr) {
                const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                // total_sss_arr.push(parseFloat($(tr.childNodes[11]).html()));
                if (cut_off_period_text == cut_off_period) {
                    tr.style.display = "";
                    var pagibig_total = $(tr.childNodes[17]).attr('pagibig_total');
                    total_pagibig_arr.push(parseFloat(pagibig_total));
                } else {
                    tr.style.display = 'none';
                    $('#total_pagibig').html(0);
                }
            });
            // get the total sum of array values
            // append the total sum of arrays to mini cards as texts
            $('#total_pagibig').html((total_pagibig_arr.reduce((a, b) => a + b, 0)).toFixed(2));
            Array.from(philhealth_cutoff).forEach(function(tr) {
                const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                if (cut_off_period_text == cut_off_period) {
                    tr.style.display = "";
                    var philhealth_total = $(tr.childNodes[17]).attr('philhealth_total');
                    total_philhealth_arr.push(parseFloat(philhealth_total));
                } else {
                    tr.style.display = 'none';
                    $('#total_philhealth').html(0);
                }
            });
            // get the total sum of array values
            // append the total sum of arrays to mini cards as texts
            $('#total_philhealth').html((total_philhealth_arr.reduce((a, b) => a + b, 0)).toFixed(2));
        } else {
            Array.from(sss_cutoff).forEach(function(tr) {
                tr.style.display = "";
            })
            Array.from(pagibig_cutoff).forEach(function(tr) {
                tr.style.display = "";
            })
            Array.from(philhealth_cutoff).forEach(function(tr) {
                tr.style.display = "";
            })
        }
        // Sort by cut-off period
        $('#date_period').change(function(e) {
            // clear container before appending
            var date_period_id_value = $(this).val();
            var date_period_value = $('#date_period option:selected').text();
            var total_sss_arr = [];
            var total_pagibig_arr = [];
            var total_philhealth_arr = [];
            var sss_cutoff = $('#tbl_sss .payslip_row');
            var pagibig_cutoff = $('#tbl_pagibig .payslip_row');
            var philhealth_cutoff = $('#tbl_philhealth .payslip_row');
            if (date_period_value) {
                Array.from(sss_cutoff).forEach(function(tr) {
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    if (date_period_value == cut_off_period) {
                        tr.style.display = "";
                        var sss_total = $(tr.childNodes[17]).attr('sss_total');
                        total_sss_arr.push(parseFloat(sss_total));
                    } else {
                        tr.style.display = 'none';
                        $('#total_sss').html(0);
                    }
                })
                // get the total sum of array values
                // append the total sum of arrays to mini cards as texts
                $('#total_sss').html((total_sss_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                Array.from(pagibig_cutoff).forEach(function(tr) {
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    // total_sss_arr.push(parseFloat($(tr.childNodes[11]).html()));
                    if (date_period_value == cut_off_period) {
                        tr.style.display = "";
                        var pagibig_total = $(tr.childNodes[17]).attr('pagibig_total');
                        total_pagibig_arr.push(parseFloat(pagibig_total));
                    } else {
                        tr.style.display = 'none';
                        $('#total_pagibig').html(0);
                    }
                })
                // get the total sum of array values
                // append the total sum of arrays to mini cards as texts
                $('#total_pagibig').html((total_pagibig_arr.reduce((a, b) => a + b, 0)).toFixed(2));
                Array.from(philhealth_cutoff).forEach(function(tr) {
                    const cut_off_period = $(tr.childNodes[9]).attr('payroll_period');
                    // total_sss_arr.push(parseFloat($(tr.childNodes[11]).html()));
                    if (date_period_value == cut_off_period) {
                        tr.style.display = "";
                        var philhealth_total = $(tr.childNodes[17]).attr('philhealth_total');
                        total_philhealth_arr.push(parseFloat(philhealth_total));
                    } else {
                        tr.style.display = 'none';
                        $('#total_philhealth').html(0);
                    }
                })
                // get the total sum of array values
                // append the total sum of arrays to mini cards as texts
                $('#total_philhealth').html((total_philhealth_arr.reduce((a, b) => a + b, 0)).toFixed(2));
            } else {
                Array.from(sss_cutoff).forEach(function(tr) {
                    tr.style.display = "";
                })
                Array.from(pagibig_cutoff).forEach(function(tr) {
                    tr.style.display = "";
                })
                Array.from(philhealth_cutoff).forEach(function(tr) {
                    tr.style.display = "";
                })
            }
        })
        async function getPayrollData_period(url, payroll_date) {
            var formData = new FormData();
            formData.append('employee_id', employee_id);
            const response = await fetch(url, {
                method: 'POST',
                body: formData
            });
            return response.json();
        }
    })
</script>
</body>

</html>