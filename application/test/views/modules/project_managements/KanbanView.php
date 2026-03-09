<html>

<?php $this->load->view('templates/css_link'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<body>

    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() ?>nav_project_managements">Project Management</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Kanban Board</li>
                </ol>
            </nav>
            <h2 class="m-3">Kanban Board</h2>
            <section class="content pb-3">
                <div class="container-fluid h-100 d-flex">
                    <div class="card card-row card-secondary w-25 m-1">
                        <div class="card-header">
                            <h3 class="card-title">
                                Backlog
                            </h3>
                        </div>
                        <div class="card-body card_content">
                            <div class="card card-info card-outline">
                                <div class="card-header p-2">
                                    <h5 class="card-title">Create Labels</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#3</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen text-primary"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="custom-control custom-checkbox ">
                                        <label for="customCheckbox1" class="custom-control-label">Bug</label>
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox1"
                                            disabled="">
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox2"
                                            disabled="">
                                        <label for="customCheckbox2" class="custom-control-label">Feature</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox3"
                                            disabled="">
                                        <label for="customCheckbox3" class="custom-control-label">Enhancement</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox4"
                                            disabled="">
                                        <label for="customCheckbox4" class="custom-control-label">Documentation</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox5"
                                            disabled="">
                                        <label for="customCheckbox5" class="custom-control-label">Examples</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary card-outline">
                                <div class="card-header ">
                                    <h5 class="card-title">Create Issue template</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#4</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox1_1"
                                            disabled="">
                                        <label for="customCheckbox1_1" class="custom-control-label">Bug Report</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="customCheckbox1_2"
                                            disabled="">
                                        <label for="customCheckbox1_2" class="custom-control-label">Feature
                                            Request</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Create PR template</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#6</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-light card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Create Actions</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#7</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                        Aenean commodo ligula eget dolor. Aenean massa.
                                        Cum sociis natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-row card-primary w-25 m-1">
                        <div class="card-header">
                            <h3 class="card-title">
                                To Do
                            </h3>
                        </div>
                        <div class="card-body card_content">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Create first milestone</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#5</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-row card-default w-25 m-1">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                In Progress
                            </h3>
                        </div>
                        <div class="card-body card_content">
                            <div class="card card-light card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Update Readme</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#2</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                        Aenean commodo ligula eget dolor. Aenean massa.
                                        Cum sociis natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-row card-success w-25 m-1">
                        <div class="card-header">
                            <h3 class="card-title">
                                Done
                            </h3>
                        </div>
                        <div class="card-body card_content">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Create repo</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#1</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php $this->load->view('templates/jquery_link'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $(function () {
                $('div.card_content').addClass("connectedSortable")
                $('div.card_content').sortable({
                    connectWith: ".connectedSortable"
                }).disableSelection();
            });
        })
    </script>
</body>

</html>