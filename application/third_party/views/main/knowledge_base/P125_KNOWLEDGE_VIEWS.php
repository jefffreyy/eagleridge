<style>
    .active {
        font-weight: 600;
    }

    span {
        font-size: 15px !important;
    }

    .text-muted {
        color: #a9b6bc !important;
    }

    li a {
        color: #0D74BC;
    }

    a:hover {
        text-decoration: none;
    }

    h3 a {
        color: #0d74bc;
        font-family: inter, sans-serif;
        font-weight: 600;
        font-size: 21px;
    }

    .page-item .active {
        background-color: #0D74BC !important;
    }

    .modal-title {
        font-size: 20px;
    }

    label.required:after {
        content: " *";
    }

    label.required:after {
        content: " *";
        color: red;
    }

    .fr-toolbar {
        border-top: 1px solid #ccc !important;
        z-index: 0 !important;
        border-radius: 10px 10px 0px 0px !important;
    }

    .fr-wrapper {
        border-radius: 0px 0px 10px 10px !important;
        font-size: 14px !important;
        margin-bottom: 20px !important;
    }

    .fr-command {
        margin-top: 5px !important;
        margin-bottom: 5px !important;
    }

    .fr-counter {
        margin-right: 5px !important;
        border: none !important;
    }

    .fr-counter::before {
        content: 'Characters: ';
        font-family: inter, sans-serif;
    }

    #froala-editor {
        border-radius: 10px !important;
    }

    legend {
        font: 12px inter, sans-serif !important;
        color: #333333;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .col-form-label {
        font-weight: 500 !important;
    }

    .dropdown-item{
        font-size: 14px !important;
        font-weight: 500 !important;
        padding: 8px 16px;
    }

    .dropdown-item i{
        width: 18px !important;
        text-align: center;
        font-size: 14px;
    }

    button[data-toggle='dropdown']{
        padding: 3.4px 12px;
    }

    .input-group-text{
        padding: 9px 16px;
    }

    input[type='search']{
        padding: 9px 16px;
        height: 40px;
    }

    .input-group{
        height: 40px;
    }
</style>


<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />

<div class="content-wrapper">
    <div class="container-fluid p-4">
        <div class="flex-fill ">
            <div class="row">
                <div class="col">
                    <h1><b>Knowledge Base<b></h1>
                </div>
                <div class="col-md-6">
                    <a href="#" class="btn btn-light" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item " href="<?=base_url()?>knowledge_base/new_article">
                            Add Article
                        </a>
                        <a class="dropdown-item" data-toggle="modal" data-target="#modal_new_category">
                            Add Category
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center mt-4">
                <div class="col-md-12">
                    <form action="" accept-charset="UTF-8" method="get">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <div class="input-group-text bg-white border-right-0"><i class="fa fa-search text-muted"></i></div>
                            </span>
                            <input type="search" name="q" id="q" class="form-control border-left-0" placeholder="Search Knowledge Base..." required="required">
                            <span class="input-group-append">
                                <input type="submit" name="commit" value="Search" class=" btn btn-primary">
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($list_category as $row) { ?>
                            <div class="col-md-6">
                                <div class="d-flex mt-2">
                                    <div class="">
                                        <i class="fa-2x fa-fw mt-1 fas fa-book" style="color: #5a5a5a"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3>
                                            <div class="d-flex">
                                                <a href="<?= $row['id']; ?>">
                                                    <?= $row['name']; ?>
                                                    <input type="hidden"  name="hid_text" value="<?= $row['id']; ?>">
                                                </a>
                                                <div class="dropdown ml-3">
                                                    <button type="button" data-toggle="dropdown" class="btn btn-sm btn-light" style="margin-top: -8px;">
                                                        <i class="fa fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right o-dropdown-menu--secondary">
                                                        <a class="dropdown-item" href="">
                                                            <i class="fas fa-plus fa-fw mr-2"></i> Add Article
                                                        </a> <a class="dropdown-item" data-remote="true" href="#" data-url="">
                                                            <i class="fas fa-pen fa-fw mr-2"></i> Edit
                                                        </a>
                                                        <a data-confirm="Are you sure?" class="dropdown-item text-danger" href="#">
                                                            <i class="fas fa-trash-alt mr-2"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </h3>
                                        <span class="text-muted mb-4">
                                            <p><?= $row['description']; ?></p>
                                        </span>
                                         <!-- <ul class="list-unstyled">
                                            <li class="mb-1">
                                                <i class="far fa-file-alt ml-2 mr-2"></i> <a href=""><?= $row['article']; ?></a>
                                            </li>
                                        </ul>  -->
                                    </div>
                                </div>
                               
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category -->
    <div class="modal fade" id="modal_new_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0" style="border-bottom: none;">
                    <h4 class="modal-title ml-1" id="exampleModalLabel">Add Category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo site_url('knowledge_base/add_categ') ?>"  method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="required" for="knowledge_base_category_name">Name</label>
                                    <div data-controller="none" data-none-cache-value="1622704009">
                                        <input class="form-control form-control " type="text" name="PG25_INF_NAME" ></input>
                                    </div>
                                    <p class="text-bold mb-1 mt-2">Description</p>
                                    <textarea class="form-control form-control" name="PG25_INF_DESC" ></textarea>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                    <br>
                                    <fieldset>
                                        <legend class="text-uppercase font-size-sm font-weight-bold">Assign To...</legend>
                                        <p>
                                            <span class="bg-dark py-1 px-2 rounded" x-ref="badge">
                                                <span class="text-white">
                                                    Currently assigned to <strong x-ref="count_user">all</strong> employees
                                                </span>
                                            </span>
                                        </p>
                                        <div class="form-group row" style="margin-left: 1px;">
                                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Users</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="PG25_INF_USER" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-left: 1px;">
                                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Employment Types</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="PG25_INF_EMTYP" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-left: 1px;">
                                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Positions</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="PG25_INF_POSI" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-left: 1px;">
                                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Departments</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="PG25_INF_DEPT" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-left: 1px;">
                                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Divisions</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="PG25_INF_DIVS" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-left: 1px;">
                                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Locations</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="PG25_INF_LOCN" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row" style="margin-left: -1px;">
                                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">
                                                <input type="submit" name="BTN_SAVE" value="Save" class="btn btn-primary btn btn-primary" data-disable-with="Please Wait...">
                                            </label>
                                        </div>
                                    </fieldset>



                                </div>
                                <!-- <div class="modal-footer">
                                    <a class='btn btn-primary text-light' id="btn_updateContact">&nbsp;Save</a>
                                </div> -->

                            </div>

                        </div>
                </form>
            </div>
        </div>
    </div>


    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
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

    </body>

    </html>