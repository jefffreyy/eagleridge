<!------------------------------------------------------ A. PAGE INFORMATION  -----------------------------------------------------
TECHNOS SYSTEM ENGINEERING INC.
EyeBox HRMS
@author     Technos Developers
@datetime   16 November 2022
@purpose    Table Records
CONTROLLER FILES:
MODEL FILES:
----------------------------------------------------------- A. STYLESHEETS  ----------------------------------------------------->
<?php $this->load->view('templates/css_link'); ?>
<!----------------------------------------------------------B. PAGE DESIGN  ----------------------------------------------------->
<?php
(isset($_GET['cut_off']) ? $cut_off_url = $_GET['cut_off'] : $cut_off_url = "");
?>

<body>
    <!-- Content Starts -->
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo base_url() ?>attendances">Attendance
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Table Records
                    </li>
                </ol>
            </nav>
            <div class="row">
                <!-- Title Text -->
                <div class="col-md-6">
                    <h1 class="page-title">Suminac Table Records</h1>
                </div>
                <div class="col-md-6 button-title">
                    <a href="<?= base_url() ?>attendances/csv_uploads" class="btn btn-primary"><i class=" fas fa-file-export"></i>Bulk import</a>
                </div>
            </div>
            <hr>

            <div class="col-md-12 card p-1" id="content_container">
                <div class="row mb-3">
                    <div class="col-md-3 ">
                        <label for="">Cut-off Period</label>
                        <select class="form-control" id="cut_off_period">
                            <option value="">All Cut-off Period</option>
                            <?php if ($C_PAY_SCHED) {
                                foreach ($C_PAY_SCHED as $C_PAY_SCHED_ROW) { ?>
                                    <option value="<?= $C_PAY_SCHED_ROW->id ?>" <?= ($cut_off_url == $C_PAY_SCHED_ROW->id) ? 'Selected' : ''; ?>><?= $C_PAY_SCHED_ROW->name ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row ">
                    <div class="col">
                        <div class="table-responsive ">
                            <table class="table table-xs table-hover mb-0 text-nowrap" style="border:none;">
                                <thead>
                                    <th>Employee&nbsp;Name</th>
                                    <th>Cut&nbsp;off</th>
                                    <th>Reg&nbsp;hrs</th>
                                    <th>Paid&nbsp;leave</th>
                                    <th>Swap</th>
                                    <th>Rest&nbsp;day&nbsp;OT</th>
                                    <th>Legal&nbsp;w</th>
                                    <th>Legal&nbsp;wo</th>
                                    <th>Spe&nbsp;hol</th>
                                    <th>Reg&nbsp;OT</th>
                                    <th>Free&nbsp;Lunch</th>
                                    <th>Excess&nbsp;OT&nbsp;hol</th>
                                    <th>Excess&nbsp;OT&nbsp;spe</th>
                                    <th>Excess&nbsp;OT&nbsp;reg</th>
                                    <th>Allo&nbsp;Meal&nbsp;OT</th>
                                    <th>nd</th>
                                    <th>nd&nbsp;OT</th>
                                    <th>Absent</th>
                                    <th>Tardiness</th>
                                    <th>Undertime</th>
                                    <th>Allo&nbsp;rice</th>
                                    <th>Allo&nbsp;ctpa</th>
                                    <th>Allo&nbsp;sea</th>
                                    <th>Allo&nbsp;transpo</th>
                                    <th>Allo&nbsp;swc</th>
                                    <th>Loan_rcbc</th>
                                    <th>VAC</th>
                                    <th>Adj&nbsp;medical</th>
                                    <th>Adj&nbsp;rice</th>
                                    <th>Adj&nbsp;nightdiff</th>
                                    <th>Adj&nbsp;restot</th>
                                    <th>Adj&nbsp;shot</th>
                                    <th>Adj&nbsp;lhot</th>
                                    <th>Adj&nbsp;aloo&nbsp;transpo</th>
                                    <th>Adj&nbsp;regot</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <?php if ($C_SUMINAC_REC) {
                                        foreach ($C_SUMINAC_REC as $C_SUMINAC_REC_ROW) { ?>
                                            <tr>
                                                <td><?= convert_id2name($C_EMP_NAME, $C_SUMINAC_REC_ROW->user_id); ?></td>
                                                <td><?= convert_id2name($C_PAY_SCHED, $C_SUMINAC_REC_ROW->cut_off); ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->reg_hrs; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->paid_leave; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->swap; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->rest_day_ot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->legal_w; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->legal_wo; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->spe_hol; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->reg_ot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->free_lunch; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->excess_ot_hol; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->excess_ot_spe; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->excess_ot_reg; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->allo_meal_ot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->nd; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->nd_ot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->absent; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->tardiness; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->undertime; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->allo_rice; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->allo_ctpa; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->allo_sea; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->allo_transpo; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->allo_swc; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->loan_rcbc; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->vac; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_medical; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_rice; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_nightdiff; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_restot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_shot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_lhot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_allo_transpo; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->adj_regot; ?></td>
                                                <td><?= $C_SUMINAC_REC_ROW->status; ?></td>

                                            </tr>
                                        <?php  }
                                    } else {
                                        ?>
                                        <!-- Message if no entries -->
                                        <tr class="table-active">
                                            <td colspan="100%">
                                                <center>No Data Yet</center>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url(); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url(); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- Summernote -->
    <script src="<?php echo base_url(); ?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?php echo base_url(); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>dist/js/adminlte.js"></script>
    <!-- Full Calendar 2.2.5 -->
    <script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>plugins/fullcalendar/main.js"></script>
    <!-- Sweet Alert -->
    <script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="<?php echo base_url(); ?>plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
    <?php
    if ($this->session->userdata('SESS_ERR_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_ERR_MSG_INSRT_CSV'); ?>',
                '',
                'error'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_ERR_MSG_INSRT_CSV');
    }
    ?>
    <?php
    if ($this->session->userdata('SESS_SUCC_MSG_INSRT_CSV')) {
    ?>
        <script>
            Swal.fire(
                '<?php echo $this->session->userdata('SESS_SUCC_MSG_INSRT_CSV'); ?>',
                '',
                'success'
            )
        </script>
    <?php
        $this->session->unset_userdata('SESS_SUCC_MSG_INSRT_CSV');
    }
    ?>

</body>

<?php function convert_id2name($array, $pos)
{
    $name = "";
    foreach ($array as $e) {
        if ($e->id == $pos) {
            $name = $e->name;
        }
    }
    if ($name == "") {
        $name = "error: can't be found";
    }
    return $name;
}
?>

<script>
    $(document).ready(function() {
        $('#cut_off_period').change(function() {

            var cut_off_val = document.getElementById("cut_off_period");
            document.location.href = 'table_record?' + 'cut_off=' + cut_off_val.value;
        })
    })
</script>

</html>