<html>
<?php $this->load->view('templates/css_link');
$LOAN_TERMS = array(6, 12, 18, 24);
?>

<body>
    <div class="content-wrapper">
        <div class='row'>
            <div class='col-md-8 ml-4 mt-3'>
                <h2><a href="<?= base_url() . 'payrolls/cash_advances'; ?>"><i class="fa-duotone fa-circle-left"></a></i></h2>
            </div>
        </div>
        <div class="container-fluid px-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'payrolls' ?>">Payroll</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'payrolls/cash_advances' ?>">Cash Advance</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Add&nbsp;Cash Advance
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= base_url('payrolls/insert_new_cash_advance') ?>" id='form_loan' method="POST">
                                        <div class="form-group ">
                                            <label class="required">Cash Advance Title</label>
                                            <input type="text" class="form-control" name="insrt_name" id="insrt_loan_name" required>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Employee</label>
                                            <select style='width:100%' class="form-control" name="insrt_employee" id="select_employee" required>
                                                <?php if (isset($DISP_EMPLOYEES)) {
                                                    foreach ($DISP_EMPLOYEES as $DISP_EMPLOYEES_ROW) { ?>
                                                        <option value="<?= $DISP_EMPLOYEES_ROW->id ?>"><?= $DISP_EMPLOYEES_ROW->col_empl_cmid . ' - ' . $DISP_EMPLOYEES_ROW->col_last_name . ', ' . $DISP_EMPLOYEES_ROW->col_frst_name . '' . $DISP_EMPLOYEES_ROW->col_midl_name; ?></option>
                                                <?php    }
                                                } ?>

                                            </select>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Date</label>
                                            <input type="date" class="form-control" name="insrt_date" id="insrt_date" required>

                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Amount</label>
                                            <input type="number" min="0" step="1" class="form-control" name="insrt_amount" id="insrt_amount" placeholder="Enter Amount" required>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Terms</label>
                                            <select class="form-control" name="insrt_terms" id="insrt_terms" required>
                                                <?php for ($i = 1; $i <= 24; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>

                                            </select>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Payment</label>
                                            <input type="number" min="0" step="1" class="form-control" name="payment_calc" id="payment_calc" placeholder="Enter Amount" value='0' disabled>
                                        </div>

                                        <div class="form-group ">
                                            <label class="required">Terms Paid</label>
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

                                        <!-- <div class="form-group ">
                                            <label class="required">Inital Paid Terms</label>
                                            <select class="form-control" name="insrt_inital_payment" id="insrt_inital_payment" required>
                                                <?php for ($i = 1; $i <= 24; $i++) { ?>
                                                    <option value="<?= $i ?>"><?= $i ?></option>
                                                <?php } ?>
                                                
                                            </select>
                                        </div> -->
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
            //  $('.btn_submit').on('click',function(e){
            //      e.preventDefault();
            //      if($('#form_loan').valid()){
            //          Swal.fire({
            //           title: 'Confirmation',
            //           text: "You won't be able to revert this!",
            //           icon: 'warning',
            //           showCancelButton: true,
            //           confirmButtonColor: '#3085d6',
            //           cancelButtonColor: '#d33',
            //           confirmButtonText: 'Yes'
            //         }).then((result) => {
            //             $('#form_loan').submit();
            //         })
            //      }
            //     //  return false;
            //  })


            $('#insrt_amount').on('keyup', function(e) {
                calculate_payment();
            });

            $('#insrt_terms').on('change', function(e) {
                calculate_payment();
            });

            $('#insrt_inital_payment').on('change', function(e) {
                var paid_terms = parseFloat($("#insrt_inital_payment").val());
                var terms = parseFloat($("#insrt_terms").val());
                if (paid_terms > terms) {
                    $("#insrt_inital_payment").val(terms);
                }
                calculate_payment();
            });


            function calculate_payment() {
                var amount = parseFloat($("#insrt_amount").val());
                var terms = parseFloat($("#insrt_terms").val());
                var paid_terms = parseFloat($("#insrt_inital_payment").val());
                var payment = amount / terms;
                var paid = payment * paid_terms;
                var balance = amount - paid;
                $("#payment_calc").val(payment.toFixed(2));
                $("#paid_calc").val(paid.toFixed(2));
                $("#bal_calc").val(balance.toFixed(2));
            }

        })
    </script>
</body>

</html>