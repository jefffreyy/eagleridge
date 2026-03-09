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

                    <a href="<?= base_url() ?>nav_superadmins">Super Administrator</a>

                </li>

                <li class="breadcrumb-item active" aria-current="page">Truncate Table

                </li>

            </ol>

        </nav>



        <div class="row mb-2">

            <!-- Title Text -->

            <div class="col-md-6">

                <h1 class="page-title">Database Table List<h1>

            </div>

        </div>



             <!-- Title Header Line -->

      <hr>

        <div class="card border-0 mt-2" style="padding: 0px; margin: 0px">

            <div class="row">

                <div class="col">

                    <div class="table-responsive">

                        <table class="table table-striped">

                            <thead>

                                <tr>

                                    <th scope="col">Table Name</th>

                                    <th style="text-align: right; "  scope="col">Action </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php foreach ($tables as $table) { ?>
                                    <?php if($table!='tbl_setup') { ?>
                                    <tr >

                                        <td><?= $table ?></td>

                                        <td style="text-align: right;">

                                            <button type="button" class="btn btn-danger btn_reset" data-toggle="modal" data-target="#confirm_action">

                                                Reset

                                            </button>

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
        let base_url='<?=base_url()?>'
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
                fetch(base_url+"database_tables/db_tracate/" + db_name).then((res)=>{
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