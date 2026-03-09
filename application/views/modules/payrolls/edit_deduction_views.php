<html>
<?php $this->load->view('templates/css_link');
$LOAN_TERMS = array(6, 12, 18, 24);
?>

<body>
    <div class="content-wrapper">
        <div class='row'>
            <div class='col-md-8 ml-4 mt-3'>
                <h2><a href="<?= base_url() . 'payrolls/deductions'; ?>"><i class="fa-duotone fa-circle-left"></a></i></h2>
            </div>
        </div>
        <div class="container-fluid px-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'payrolls' ?>">Payroll</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'payrolls/deductions' ?>">Deductions</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Edit&nbsp;Deduction
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= base_url('payrolls/update_deduction/' . $LOAN_INFO->id) ?>" id='form_loan' method="POST">
                                        <div class="form-group ">
                                            <label class="required">Deduction Title</label>
                                            <input type="text" class="form-control" value='<?= $LOAN_INFO->loan_name ?>' name="insrt_name" id="insrt_name" required>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Employee</label>
                                            <select class="form-control" name="insrt_employee" id="select_employee" required>
                                                <?php if (isset($DISP_EMPLOYEES)) {
                                                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) { ?>
                                                        <option <?= $LOAN_INFO->empl_id == $DISP_EMPLOYEES_ROW->id ? 'selected' : '' ?> value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_last_name . ', ' . $DISP_EMPLOYEES_ROW->col_frst_name . '' . $DISP_EMPLOYEES_ROW->col_midl_name; ?></option>
                                                <?php    }
                                                } ?>

                                            </select>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Date</label>
                                            <input type="date" class="form-control" value='<?= $LOAN_INFO->loan_date ?>' name="insrt_date" id="insrt_employee" required>
                                        </div>

                                        <!-- <div class="form-group ">
                                            <label class="required">Type</label>
                                            <select class="form-control" name="insrt_type" id="insrt_type" required>
                                                <?php if (isset($LOAN_TYPES)) {
                                                    foreach ($LOAN_TYPES as $LOAN_TYPE) { ?>
                                                    <option <?= $LOAN_INFO->loan_type == $LOAN_TYPE->id ? 'selected' : '' ?> value="<?= $LOAN_TYPE->id ?>"><?= $LOAN_TYPE->name ?></option>
                                                <?php    }
                                                } ?>
                                                
                                            </select>
                                        </div> -->
                                        <div class="form-group ">
                                            <label class="required">Terms</label>
                                            <select class="form-control" name="insrt_terms" id="insrt_terms" required>
                                                <?php for ($i = 0; $i <= 24; $i++) { ?>
                                                    <option value="<?= $i ?>" <?= $i == $LOAN_INFO->loan_terms ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Amount</label>

                                            <input type="number" value='<?= $LOAN_INFO->loan_amount ?>' min="0" step="1" class="form-control" name="insrt_amount" id="insrt_amount" placeholder="Enter Loan Amount" required>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Inital Paid Terms</label>
                                            <!-- <input type="number" min="0" step="1" class="form-control" value='<?= $LOAN_INFO->initial_paid ?>' name="insrt_inital_payment" id="insrt_inital_payment" placeholder="Enter Initial Payment" required> -->
                                            <select class="form-control" name="insrt_terms" id="insrt_terms" required>
                                                <?php for ($i = 0; $i <= 24; $i++) { ?>
                                                    <option value="<?= $i ?>" <?= $i == $LOAN_INFO->initial_paid ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="mr-2" style="float: right !important">
                                            <button type='submit' class="btn technos-button-green shadow-none rounded btn_submit">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('templates/jquery_link'); ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('#select_employee').select2();
            $('.btn_submit').on('click', function(e) {
                e.preventDefault();

                if ($('#form_loan').valid()) {
                    Swal.fire({
                        title: 'Confirmation',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        $('#form_loan').submit();
                    })
                }
            })
        })
    </script>
</body>

</html>