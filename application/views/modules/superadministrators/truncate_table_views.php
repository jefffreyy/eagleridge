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
        <nav aria-label="breadcrumb">

            <ol class="breadcrumb">

                <li class="breadcrumb-item">

                    <a href="<?= base_url() ?>superadministrators">Super Administrator</a>

                </li>

                <li class="breadcrumb-item active" aria-current="page">Truncate Table

                </li>

            </ol>

        </nav>



        <div class="row mb-2">

            <!-- Title Text -->

            <div class="col d-flex align-items-center">
                <a href="<?= base_url() . 'superadministrators'; ?>"><img style="width: 24px; height: 24px; margin: 0 7px 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>
                <h1 style="font-size: 24px;" class="page-title d-inline">Database Table Lists</h1>

            </div>
            <div class="col-md-6 button-title d-flex justify-content-end">

                <button type="button" class="btn btn-danger btn_reset_all" data-toggle="modal" data-target="#confirm_action"><img class="mb-1" src="<?= base_url('assets_system/icons/rotate-solid.svg') ?>" alt=""> Reset System</button>


            </div>
            <!-- <form action="<?= base_url('superadministrators/trial_mode') ?>">
            <button type="submit" class="btn btn-primary btn_trial_mode" ><i class="fa-regular fa-rotate"></i> Trial Mode</button>

            </form> -->


        </div>



        <!-- Title Header Line -->

        <hr>

        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">

            <div class="row">

                <div class="col">

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover table-striped" style="padding: 0px; margin: 0px">

                            <thead>

                                <tr>

                                    <th scope="col">TABLE NAME</th>

                                    <th style="text-align: center; " scope="col">ACTION </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($tables as $table) { ?>
                                    <?php if ($table != 'tbl_setup') { ?>
                                        <tr>

                                            <td><?= $table ?></td>

                                            <td style="text-align: center;">

                                                <button type="button" class="btn btn-danger btn_reset" data-toggle="modal" data-target="#confirm_action">

                                                    Reset

                                                </button>

                                            </td>

                                        </tr>
                                    <?php } 
                                    else { ?>
                                        <tr class="table-active">
                                            <td colspan="12">
                                                <center>No Records</center>
                                            </td>
                                        </tr>
                                        <?php } ?>
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

<script>
    $(document).ready(function() {
        let base_url = '<?= base_url() ?>';
        $('button.btn_reset').on("click", function() {
            let db_name = $(this).parent().parent().children(':nth-child(1)').text();
            $("span#db_name").text(db_name);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(base_url + "superadministrators/db_tracate/" + db_name).then((res) => {
                        console.log(res);
                        Swal.fire(
                            'Deleted!',
                            'Table has been reset.',
                            'success'
                        )
                    })

                }
            })

        })

        $('button.btn_reset_all').on("click", function() {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(base_url + "superadministrators/truncate_all_tables/").then((res) => {
                        console.log(res);
                        Swal.fire(
                            'Deleted!',
                            'Table has been reset.',
                            'success'
                        )
                    })

                }
            })

        })



    })
</script>