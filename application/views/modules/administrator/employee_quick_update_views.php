<html>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->
<link rel="stylesheet" href="<?= base_url('assets_system/css/handsontable14.css') ?>" />

<body>

    <div class="content-wrapper">
        <div class="p-3">
            <div class="flex-fill">
                <div class="row pr-3 mb-3">
                    <div class="col">
                        <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() . 'administrators/access'; ?>"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" /></a>&nbsp;Quick Edit Employees</h1>
                    </div>

                    <div class="col ml-auto button-title">
                        <button  class="btn btn-primary" id="btn-update"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;"  src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" /> Update</button>
                    </div>
                </div>

                <div class="card">

                    <div id="example"></div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script> -->
    <script type="text/javascript" src="<?= base_url('assets_system/js/handsontable14.js') ?>"></script> 

    <script>
        var url = '<?= base_url() ?>';
        var cUserAccess = <?php echo json_encode($C_USER_ACCESS); ?>;
        var cPositions = <?php echo json_encode($C_POSITIONS); ?>;

        function json_data(data) {
            return data.map(arg => arg.name);
        }

        function json_userAccess(data) {
            return data.map(arg => arg.user_access);
        }

        const customStyleRenderer = function(instance, td, row, col, prop, value, cellProperties) {
            Handsontable.renderers.TextRenderer.apply(this, arguments);
            td.style.whiteSpace = 'nowrap';
            td.style.overflow = 'hidden';
        };

        const apiUrl = url + 'administrators/get_employee_data';
        var hot;

        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                initializeHandsontable(data);
            })
            .catch(error => {
                console.error('Data fetch error:', error);
            });

        function initializeHandsontable(data) {
            console.log(data);

            const container = document.querySelector('#example');
            hot = new Handsontable(container, {
                data: data,
                colHeaders: ['Id', 'Employee ID', 'Fullname', 'Position', 'User Access', 'Remote Attendance', 'Status'],
                rowHeaders: true,
                stretchH: 'all',
                height: window.innerHeight - container.getBoundingClientRect().top - 50,
                outsideClickDeselects: false,
                selectionMode: 'multiple',
                licenseKey: 'non-commercial-and-evaluation',
                renderer: customStyleRenderer,
                hiddenColumns: {
                    columns: [0],
                    indicators: true,
                },
                columns: [{
                        data: 'id',
                    },
                    {
                        data: 'col_empl_cmid',
                        readOnly: true
                    },
                    {
                        data: 'fullname',
                        readOnly: true
                    },
                    {
                        data: 'col_empl_posi',
                        readOnly: true
                    },
                    {
                        data: 'col_user_access',
                        type: 'dropdown',
                        source: json_userAccess(cUserAccess),
                    },
                    {
                        data: 'remote_att',
                        type: 'dropdown',
                        source: ['Enabled', 'Disabled'],
                    },
                    {
                        data: 'disabled',
                        type: 'dropdown',
                        source: ['Active', 'Inactive'],
                    },
                ],
            });
        }

        var update_data = document.getElementById('btn-update');
        update_data.addEventListener('click', function() {
            const confirmed = confirm('Are you sure you want to update the data?');
            if (!confirmed) {
                return;
            }

            const updatedData = hot.getData();
            fetch(url + 'administrators/update_data', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(updatedData)
                })
                .then(response => response.json())
                .then(result => {
                    console.log(result);

                    if (result.messageSuccess) {
                        $(document).Toasts('create', {
                            class: 'bg-success toast_width',
                            title: 'Success!',
                            subtitle: 'close',
                            body: result.messageSuccess
                        })

                        $('.toast button[data-dismiss="toast"]').on('click', function() {
                            location.reload();
                        });
                    }

                    if (result.messageError) {
                        $(document).Toasts('create', {
                            class: 'bg-warning toast_width',
                            title: 'Warning!',
                            subtitle: 'close',
                            body: result.messageError
                        })
                    }

                })
                .catch(error => {
                    $(document).Toasts('create', {
                        class: 'bg-warning toast_width',
                        title: 'Warning!',
                        subtitle: 'close',
                        body: 'Please provide all required information.'
                    })
                    console.error('Data update error:', error);
                });
        });
    </script>

</body>

</html>