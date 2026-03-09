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

        <!--<nav aria-label="breadcrumb">-->

        <!--    <ol class="breadcrumb">-->

        <!--        <li class="breadcrumb-item">-->

        <!--            <a href="<?= base_url() ?>superadministrators">Super Administrator</a>-->

        <!--        </li>-->

        <!--        <li class="breadcrumb-item active" aria-current="page">System Variables-->

        <!--        </li>-->

        <!--    </ol>-->

        <!--</nav>-->



        <div class="row mb-2">

            <!-- Title Text -->

            <div class="col d-flex align-items-center">
                <a href="<?= base_url() . 'superadministrators'; ?>"><img style="width: 24px; height: 24px; margin: 0 7px 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>
                <h1 style="font-size: 24px;" class="page-title d-inline">System Variables</h1>
            </div>

        </div>



        <!-- Title Header Line -->

        <hr>

        <?php echo form_open('superadministrators/update_system_varibles', 'class="email" id="myform"'); ?>
        <button type='submit' class='btn btn-primary d-block ml-auto'><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />
          Save Changes</button>
        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">

            <div class="row">

                <div class="col">

                    <div class="table-responsive" style='max-height:75vh'>

                        <table class="table table-bordered table-hover table-striped" style="padding: 0px; margin: 0px">

                            <thead style='position:sticky;top:-1px'>

                                <tr class='text-center'>

                                    <th scope="col">SETTING</th>

                                    <th scope="col">VALUES </th>

                                </tr>

                            </thead>
                            <tbody>

                                <?php if ($SET_UP_VARIABLES) {
                                    foreach ($SET_UP_VARIABLES as $variable) { ?>
                                        <tr>

                                            <td style="text-align: left;">
                                                <?= $variable->setting ?>
                                            </td>
                                            <td style="text-align: left;">
                                                <input name="<?= $variable->setting ?>[id]" type='hidden' value="<?= $variable->id ?>">
                                                <input name="<?= $variable->setting ?>[value]" class="d-block w-100" type='text' value="<?= $variable->value ?>" style='background-color:transparent;border:none;height:30px;'>
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

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Modal -->

<?php $this->load->view('templates/jquery_link'); ?>

<?php if ($this->session->flashdata('success')) { ?>
    <script>
        Swal.fire(
            'Success!',
            "<?= $this->session->flashdata('success') ?>",
            'success'
        )
    </script>
<?php } ?>