<html>
<?php $this->load->view('templates/css_link');
$LOAN_TERMS = array(6, 12, 18, 24);
?>

<body>
    <div class="content-wrapper">
        <div class='row'>
            <div class='col-md-8 ml-4 mt-3'>
                <h2><a href="<?= base_url() . 'payrolls/loans'; ?>"><i class="fa-duotone fa-circle-left"></a></i></h2>
            </div>
        </div>
        <div class="container-fluid px-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'payrolls' ?>">Payroll</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'payrolls/loans' ?>">Loans</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Add&nbsp;Loan
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= base_url('payrolls/insert_new_loans') ?>" id='form_loan' method="POST">
                                        <div class="form-group ">
                                            <label class="required">Loan Name</label>
                                            <input type="text" class="form-control" name="insrt_loan_name" id="insrt_loan_name" required>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Employee</label>
                                            <select style='width:100%' class="form-control" name="insrt_employee" id="select_employee" required>
                                                <?php if (isset($DISP_EMPLOYEES)) {
                                                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) { ?>
                                                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_frst_name . ' ' . $DISP_EMPLOYEES_ROW->col_last_name; ?></option>
                                                <?php    }
                                                } ?>

                                            </select>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Loan Date</label>
                                            <input type="date" class="form-control" name="insrt_loan_date" id="insrt_employee" required>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Loan Type</label>
                                            <select class="form-control" name="insrt_loan_type" id="insrt_loan_type" required>
                                                <?php if (isset($LOAN_TYPES)) {
                                                    foreach ($LOAN_TYPES as $LOAN_TYPE) { ?>
                                                        <option value="<?= $LOAN_TYPE->id ?>"><?= $LOAN_TYPE->name ?></option>
                                                <?php    }
                                                } ?>

                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Loan Amount</label>
                                            <input type="number" min="0" step="1" class="form-control" name="insrt_loan_amount" id="insrt_loan_amount" placeholder="Enter Loan Amount" required>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Loan Terms</label>
                                            <select class="form-control" name="insrt_loan_terms" id="insrt_loan_terms" required>
                                                <?php for ($i = 1; $i <= 24; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>


                                        <div class="form-group ">
                                            <label class="required">Payment</label>
                                            <input type="number" min="0" step="1" class="form-control" name="payment_calc" id="payment_calc" placeholder="Enter Loan Amount" value='0' disabled>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Terms Paid</label>
                                            <!-- <input type="number" min="0" step="1" class="form-control" name="insrt_inital_payment" id="insrt_inital_payment" placeholder="Enter Terms Paid" required> -->
                                            <select class="form-control" name="insrt_inital_payment" id="insrt_inital_payment" required>
                                                <?php for ($i = 0; $i <= 24; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Paid (Amount)</label>
                                            <input type="number" min="0" step="1" class="form-control" name="paid_calc" id="paid_calc" placeholder="Enter Loan Amount" value='0' disabled>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Balance (Amount)</label>
                                            <input type="number" min="0" step="1" class="form-control" name="bal_calc" id="bal_calc" placeholder="Enter Loan Amount" value='0' disabled>
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

    <?php if ($this->session->flashdata('SUCC')) { ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-success toast_width',
                title: 'Success!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('SUCC'); ?>'
            })
        </script>
    <?php } ?>


    <?php if ($this->session->flashdata('ERR')) { ?>
        <script>
            $(document).Toasts('create', {
                class: 'bg-warning toast_width',
                title: 'Warning!',
                subtitle: 'close',
                body: '<?php echo $this->session->flashdata('ERR'); ?>'
            })
        </script>
    <?php } ?>

    <script>
        $(document).ready(function() {
            $('#select_employee').select2();

            $('#insrt_loan_amount').on('keyup', function(e) {
                calculate_payment();
            });
            $('#insrt_loan_terms').on('change', function(e) {
                calculate_payment();
            });
            $('#insrt_inital_payment').on('change', function(e) {
                var paid_terms = parseFloat($("#insrt_inital_payment").val());
                var terms = parseFloat($("#insrt_loan_terms").val());
                if (paid_terms > terms) {
                    $("#insrt_inital_payment").val(terms);
                }
                calculate_payment();
            });


        })

        function calculate_payment() {
            var amount = parseFloat($("#insrt_loan_amount").val());
            var terms = parseFloat($("#insrt_loan_terms").val());
            var paid_terms = parseFloat($("#insrt_inital_payment").val());
            var payment = amount / terms;
            var paid = payment * paid_terms;
            var balance = amount - paid;
            $("#payment_calc").val(payment.toFixed(2));
            $("#paid_calc").val(paid.toFixed(2));
            $("#bal_calc").val(balance.toFixed(2));
        }
    </script>


</body>

</html>