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
</style>
<script src="<?php echo base_url(); ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet Alert CSS -->
<link rel="stylesheet" href="<?= base_url(); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="<?= base_url(); ?>plugins/fullcalendar/main.css">
<!-- Code Mirror -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<!-- Include Editor style. -->
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />


<div class="content-wrapper">
    <div class="flex-fill p-3">
        <div class="card">
            <div class="card-header bg-white form-inline">
                <h6 class="card-title">New Knowledge Base Article</h6>
            </div>
            <div class="card-body">
                <form action="<?php echo site_url('knowledge_base/add_arti') ?>" id="" method="post" accept-charset="utf-8" autocomplete='off' class="m-2">
                    <div class="form-group">
                        <label class="required" for="article_title">Title</label>
                        <input autofocus="autofocus" class="form-control form-control form-control-lg" type="text" name="PG26_INF_TITLE">
                    </div>
                    <div class="form-group">
                        <label class="required" for="article_category">Category</label>
                        <select class="custom-select mr-sm-2" id="article_category" name="PG26_SEL_CATG">
                            <option value="">-- Select --</option>
                            <?php foreach ($list_category as $row) : ?>
                                <option value="<?= $row['name']; ?>" <?php if ($row == $row['name']) {
                                                                            echo 'selected';
                                                                        } ?>><?= $row['name']; ?></option>
                                }
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="froala-editor">
                        <p></p>
                    </div>
                    <fieldset>
                        <legend class="text-uppercase font-size-sm font-weight-bold">Assign To...</legend>
                        <p>
                            <span class="bg-dark py-1 px-2 rounded" x-ref="badge">
                                <span class="text-white">
                                    Currently assigned to <strong x-ref="count">all</strong> employees
                                </span>
                            </span>
                        </p>
                        <div class="form-group row" style="margin-left: 1px;">
                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Users</label>
                            <div class="col-lg-9">
                                <input type="text" name="PG26_INF_USER" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-left: 1px;">
                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Employment Types</label>
                            <div class="col-lg-9">
                                <input type="text" name="PG26_INF_EMTYP" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-left: 1px;">
                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Positions</label>
                            <div class="col-lg-9">
                                <input type="text" name="PG26_INF_POSI" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-left: 1px;">
                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Departments</label>
                            <div class="col-lg-9">
                                <input type="text" name="PG26_INF_DEPT" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-left: 1px;">
                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Divisions</label>
                            <div class="col-lg-9">
                                <input type="text" name="PG26_INF_DIVS" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row" style="margin-left: 1px;">
                            <label class="col-lg-2 col-form-label form-control-sm" for="article_ids-tomselected">Locations</label>
                            <div class="col-lg-9">
                                <input type="text" name="PG26_INF_LOCN" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="text-uppercase font-size-sm font-weight-bold py-3">Delivery Method</legend>
                        <div class="form-group">
                            <input type="checkbox" name="PG26_CHB_EMAIL" id="article_checkbox" values="1">
                            <label for="notify_checkbox" class="ml-2" style="cursor: pointer;color:#333333; font-weight: 500;">Notify by Email</label>
                        </div>
                    </fieldset>
                    <div class="form-group row" style="margin-left: 1px;">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn btn-primary mr-3" name="BTN_SAVE">Save</button>

                        </div>
                        <div class="form-group row" style="margin-left: 1px;">
                            <div class="form-group">
                                <a href="" style="color: #0D74BC">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>



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
<!-- Include external JS libs. -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.6/js/froala_editor.pkgd.min.js"></script>

<!-- Initialize the editor. -->
<script>
    $(function() {
        $('div#froala-editor').froalaEditor({
            // Set custom buttons with separator between them.
            toolbarButtons: ['undo', 'redo', '|', 'bold', 'italic', 'strikeThrough', 'subscript', 'superscript', 'outdent', 'indent', 'clearFormatting', 'html'],
            toolbarButtonsXS: ['undo', 'redo', '-', 'bold', 'italic', 'html']
        })

        $('i.fa.fa-rotate-left').attr('class')
    });
</script>
</body>

</html>