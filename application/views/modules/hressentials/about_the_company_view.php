<html>
<?php $this->load->view('templates/css_link'); ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- Google Font: Source Sans Pro -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" /> -->
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/fontawesome/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css" /> -->
    <!-- Theme style -->
    <!-- <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/dist/css/adminlte.min.css"> -->
    <!-- <link rel="stylesheet" href="/dist/css/adminlte.min.css" /> -->
    <!-- summernote -->
    <!-- <link rel="stylesheet" href="https://technos-systems.com/_eyeboxroot/plugins/summernote/summernote-bs4.min.css" /> -->
    <!-- <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css" /> -->
    <!-- CodeMirror -->
    <!-- <link rel="stylesheet" href="/plugins/codemirror/codemirror.css" />
    <link rel="stylesheet" href="/plugins/codemirror/theme/monokai.css" /> -->
    <!-- SimpleMDE -->
    <!-- <link rel="stylesheet" href="/plugins/simplemde/simplemde.min.css" /> -->
</head>
<html>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <div class="row pt-1">
                <div class="col-md-6">
                    <h1 class="page-title d-flex align-items-center"><a href="<?= base_url() ?>hressentials"><img style="width: 24px; height: 24px; margin-bottom: 3px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="" />
                        </a>&nbsp;About The Company</h1>
                    <h1>
                    </h1>
                </div>
            </div>
            <!-- /.card-header -->

            <hr>
            <div class="card-body">
                <textarea id="summernote">
            Place <em>some</em> <u>text</u> <strong>here</strong>
            </textarea>
                <button id="checkAndSaveButton" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>

    <?php $this->load->view('templates/jquery_link'); ?>
    <!-- jQuery -->
    <!-- <script src="https://technos-systems.com/_eyeboxroot/plugins/jquery/jquery.min.js"></script> -->
    <!-- <script src="/plugins/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap 4 -->
    <!-- <script src="https://technos-systems.com/_eyeboxroot/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
    <!-- AdminLTE App -->
    <!-- <script src="https://technos-systems.com/_eyeboxroot/dist/js/adminlte.js"></script> -->
    <!-- <script src="/dist/js/adminlte.min.js"></script> -->
    <!-- Summernote -->
    <!-- <script src="https://technos-systems.com/_eyeboxroot/plugins/summernote/summernote-bs4.min.js"></script> -->
    <!-- Sweet Alert -->
    <!-- <script src="https://technos-systems.com/_eyeboxroot/plugins/sweetalert2/sweetalert2.min.js"></script> -->
    <!-- <script src="/plugins/summernote/summernote-bs4.min.js"></script> -->
    <!-- CodeMirror -->
    <!-- <script src="/plugins/codemirror/codemirror.js"></script>
    <script src="/plugins/codemirror/mode/css/css.js"></script>
    <script src="/plugins/codemirror/mode/xml/xml.js"></script> -->
    <!-- <script src="/plugins/codemirror/mode/htmlmixed/htmlmixed.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="/dist/js/demo.js"></script> -->
    <!-- Page specific script -->
    <script>
        $(document).ready(function() {
            $("#summernote").summernote();

            var htmlContent = <?php echo !empty($htmlContent) ? json_encode($htmlContent) : 'null'; ?>;
            if (htmlContent !== null) {
                $("#summernote").summernote("code", htmlContent);
            }
            $("#checkAndSaveButton").click(function() {
                let htmlContent = $("#summernote").summernote('code');
                // console.log(htmlContent)
                var sizeInBytes = new Blob([htmlContent]).size;
                var sizeInKilobytes = (sizeInBytes / 1024).toFixed(2);
                var maxAllowedSize = 1024 * 1024 * 9;

                if (sizeInBytes <= maxAllowedSize) {
                    fetch("<?= base_url('hressentials/about_the_company_save'); ?>", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json", // Set the appropriate content type
                                "X-Requested-With": "XMLHttpRequest", // Identify the request as AJAX
                            },
                            body: JSON.stringify({
                                htmlContent: htmlContent
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('data', data)
                            console.log('data', data.messageSuccess)
                            if (data.hasOwnProperty('messageSuccess')) {
                                console.log('Success: ' + data.messageSuccess);
                                $(document).Toasts('create', {
                                    class: 'bg-success toast_width',
                                    title: 'Success!',
                                    subtitle: 'close',
                                    body: data.messageSuccess,
                                })
                            }
                            if (data.hasOwnProperty('messageError')) {
                                console.log('Error: ' + data.messageError);
                                Swal.fire({
                                    title: 'Error!',
                                    text: data.messageError,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                })
                            }

                        })
                        .catch(error => {
                            console.error("Error saving HTML content:", error);
                            Swal.fire({
                                title: 'Error!',
                                text: `Failed Saving Welcome Message.`,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            })
                        });;
                } else {
                    console.log(`HTML content size exceeds the allowed limit ${sizeInKilobytes}. Must be less than ${maxAllowedSize}`)
                    Swal.fire({
                        title: 'Error!',
                        text: 'HTML content size exceeds the allowed limit.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        })
    </script>
</body>

</html>