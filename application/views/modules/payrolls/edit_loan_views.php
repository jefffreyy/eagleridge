<html>
<?php $this->load->view('templates/css_link');
$LOAN_TERMS = array(6, 12, 18, 24);
?>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">

            <div class='row'>
                <div class='col-md-8 '>
                    <h2  class="page-title"><a href="<?= base_url() . 'benefits/loans'; ?>"><i class="fa-duotone fa-circle-left"></i></a>&nbsp;Edit Loan</h2>

                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= base_url('payrolls/update_loan/' . $LOAN_INFO->id) ?>" id='form_loan' method="POST">
                                        <div class="form-group ">
                                            <label class="required">Loan Name</label>
                                            <input type="text" class="form-control" value='<?= $LOAN_INFO->loan_name ?>' name="insrt_loan_name" id="insrt_loan_name" required>
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
                                            <label class="required">Loan Date</label>
                                            <input type="date" class="form-control" value='<?= $LOAN_INFO->loan_date ?>' name="insrt_loan_date" id="insrt_employee" required>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Loan Type</label>
                                            <select class="form-control" name="insrt_loan_type" id="insrt_loan_type" required>
                                                <?php if (isset($LOAN_TYPES)) {
                                                    foreach ($LOAN_TYPES as $LOAN_TYPE) { ?>
                                                        <option <?= $LOAN_INFO->loan_type == $LOAN_TYPE->id ? 'selected' : '' ?> value="<?= $LOAN_TYPE->id ?>"><?= $LOAN_TYPE->name ?></option>
                                                <?php    }
                                                } ?>

                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Loan Terms</label>
                                            <select class="form-control" name="insrt_loan_terms" id="insrt_loan_terms" required>
                                                <?php for ($i = 0; $i <= 24; $i++) { ?>
                                                    <option value="<?= $i ?>" <?= $i == $LOAN_INFO->loan_terms ? 'selected' : '' ?>><?= $i ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Loan Amount</label>

                                            <input type="number" value='<?= $LOAN_INFO->loan_amount ?>' min="0" step="1" class="form-control" name="insrt_loan_amount" id="insrt_loan_amount" placeholder="Enter Loan Amount" required>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Inital Payment</label>
                                            <input type="number" min="0" step="1" class="form-control" value='<?= $LOAN_INFO->initial_paid ?>' name="insrt_inital_payment" id="insrt_inital_payment" placeholder="Enter Initial Payment" required>
                                        </div>
                                        <div class="mr-2" style="float: right !important">
                                            <button type='submit' class="btn technos-button-green shadow-none rounded ">Submit</button>
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

        })
    </script>
</body>

</html>