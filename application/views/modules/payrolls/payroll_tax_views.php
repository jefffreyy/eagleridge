<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="../assets_system/css/handsontable.css" /> -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?php echo base_url()?>/assets_system/css/handsontable14.css" />
<?php
if (isset($_GET['search'])) {
    $search = $_GET['search'];
} else {
    $search = "";
}
?>
<div class="content-wrapper">

    <div class="container-fluid p-4">

        <div class="row pt-1">

            <div class="col-md-6">

                <h1 class="page-title d-flex align-items-center"><a href="<?= base_url('payrolls') ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Withholding Tax Table<h1>

            </div>

        </div>

        <hr>

        <!-- <div class = "pb-1">     -->

        <!-- </div> -->

        <div class="col-md-2 mt-2" <?php echo (true ? "" : "hidden") ?>>
            <label class="mb-1 text-secondary ">Search Year</label>
            <select id="search_select" class="form-control">
                <?php
                if ($YEAR_LISTS) {
                ?>
                    <option value="all" <?php foreach ($YEAR_LISTS as $row_1) {
                                                    if ($row_1->year == '') {
                                                        echo 'selected';
                                                    }
                                                } ?>>All </option>
                    <?php
                    foreach ($YEAR_LISTS as $row) {
                        if ($row->year != '') {
                    ?>
                            <option value="<?= $row->year ?>" <?php echo $search == $row->year ? 'selected' : '' ?>>
                                <?= $row->year ?>
                            </option>
                <?php
                        }
                    }
                }
                ?>
            </select>
        </div>
        
        <div class="card border-0 p-0 mt-3">
            <div class="card border-0" style="margin: 0px !important;">
                <div class="row">
                    <div class="col">
                        <div>
                            <div id="hansontable"> </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
<?php $this->load->view('templates/jquery_link'); ?>
<!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url()?>/assets_system/js/handsontable14.js"></script>
<script>
    var url = '<?= base_url() ?>';
    var tableData = <?= json_encode($TABLE_DATA); ?>;
    console.log('tableData', tableData);

    const customStyleRenderer_new = function(instance, td, row, col, prop, value, cellProperties) {
        Handsontable.renderers.TextRenderer.apply(this, arguments);
        td.style.whiteSpace = 'nowrap';
        td.style.overflow = 'hidden';
        td.style.backgroundColor = '#f9f9f9'; 
    };

    let value_custom = function(instance, td, row, col, prop, value, cellProperties) {
                Handsontable.renderers.TextRenderer.apply(this, arguments);
                td.style.textAlign = 'right'; 
                td.style.backgroundColor = '#f9f9f9'; 
                value = parseFloat(value || 0).toFixed(2);
                td.innerHTML = '<span style="float: left;">&#8369;</span>' + value;
    };
    

    initializeHandsontable(tableData);

    function initializeHandsontable(data) {
        const container = document.querySelector('#hansontable');
        hot = new Handsontable(container, {
            data,
            readOnly: true,
            nestedHeaders: [
                ['id', 'Year', 'Pay Frequency', 'Salary Min', 'Salary Max', 'Fixed', 'C Level', 'C Parent'],
            ],
            rowHeaders: true,
            height: 'auto',
            outsideClickDeselects: false,
            selectionMode: 'multiple',
            licenseKey: 'non-commercial-and-evaluation',
            // Custom renderer to prevent text wrapping
            renderer: customStyleRenderer_new,
            // readOnly: false,
            hiddenColumns: {
                columns: [0, 1],
                // indicators: true,
            },
            stretchH: 'all',
            columns: [{
                    data: 'id',
                    readOnly: true
                },
                {
                    data: 'year',
                    readOnly: true
                },
                {
                    data: 'pay_frequency',
                    readOnly: true,
                    width: 100
                },
                {
                    data: 'salary_min',
                    readOnly: true,
                    renderer: value_custom,
                    width: 100
                },
                {
                    data: 'salary_max',
                    readOnly: true,
                    renderer: value_custom,
                    width: 100
                },
                {
                    data: 'fixed',
                    readOnly: true,
                    renderer: value_custom,
                    width: 100
                },
                {
                    data: 'c_level',
                    readOnly: true,
                    renderer: value_custom,
                    width: 100
                },
                {
                    data: 'c_percent',
                    renderer: value_custom,
                    readOnly: true,
                    width: 100
                },
            ],
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#search_select').select2();
        $("#search_select").on("change", function() {
            search();
        });
    });

    function search() {
        let search_select = $("#search_select").find(":selected").val();
        console.log('search_select', search_select);
        if (!search_select) return;
        if (search_select == 'all') {
            filter_clear();
        } else {
            window.location.href = "?search=" + search_select.replace(/\s/g, '_');
        }
    }

    function filter_clear() {
        document.location.href = "payroll_tax";
    }
</script>