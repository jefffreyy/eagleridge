<html>
<?php
$this->load->view('templates/css_link');

?>
<style>
    .contact {
        margin: 5px 2px;
        width: max-content;
        border-radius: 20px;
        font-size: 12px;
        padding: 10px;
    }

    .icon_contact {
        font-size: 12px !important;
    }

    .remove_contact {
        cursor: pointer;
    }
</style>

<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?= base_url('sms_user/insert_new_sms_message') ?>" id='form_deduction' method="POST">
                                        <div class="form-group ">
                                            <label class="required">Message Title</label>
                                            <input type="text" class="form-control" name="insrt_title" id="insrt_title" placeholder="Enter Message Title" required>
                                        </div>
                                        <!--<div class="form-group d-none">-->
                                        <!--    <label class="required">Schedule Date</label>-->
                                        <!--    <div class="custom-control custom-switch d-inline">-->
                                        <!--        <input type="checkbox"  class="custom-control-input" name='send_now' checked id="send_now">-->
                                        <!--        <label class="custom-control-label" for="send_now">Send now</label>-->
                                        <!--    </div>-->
                                        <!--    <input type="datetime-local" class="form-control" disabled name="insrt_date" id="insrt_date"  required>-->
                                        <!--</div>-->


                                        <div class="form-group m-0 p-0">
                                            <div class='d-flex justify-content-between'>
                                                <label for="insrt_message">Messages</label>
                                                <div class='d-flex text-bold'>
                                                    <p class='mx-2'>Characters: <span id='char_count'>0/160</span></p>
                                                    <p>SMS Parts: <span id='page_count'>1</span>/6</p>
                                                </div>
                                            </div>
                                            <textarea class="form-control m-0" id="insrt_message" name='insrt_message' rows="3" required></textarea>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="required">Mobile Number</label>
                                            <div id='numbers' class='d-flex flex-wrap'>

                                            </div>
                                            <input type="number" class="form-control mt-1" name="insrt_mobile_num" id="insrt_mobile_num" required>
                                        </div>

                                        <div class="mr-2" style="float: right !important">
                                            <button type='submit' class="btn technos-button-green shadow-none rounded btn_submit">Send</button>
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
            let contact_numbers = [];
            let max_char = 0;
            let page_count = 0;
            $('#insrt_message').on('keyup', function(e) {
                e.preventDefault();
                var string = $(this).val();
                var char_count = 0;
                for (var i = 0; i < string.length; i++) {
                    if (string[i].match(/[a-zA-Z0-9]/)) {
                        char_count++;
                    } else {
                        char_count += 2;
                    }
                }
                page_count = parseInt(char_count / 160) + 1;
                max_char = (page_count) * 160;
                $('#page_count').text(page_count);
                $('#char_count').text(char_count + '/' + max_char);
                //  if(char_count>=max_char){
                //      $(this).attr('maxlength','0');
                //  }else{
                //      $(this).attr('maxlength',max_char);
                //  }
            })
            $('#send_now').on('change', function() {
                if ($(this).is(':checked')) {
                    // Checkbox is checked
                    $('#insrt_date').prop('disabled', true);
                } else {
                    // Checkbox is not checked

                    $('#insrt_date').prop('disabled', false);
                }

            })
            $('#insrt_mobile_num').on('keydown', function(e) {
                const ENTER_KEY_CODE = 13;
                const ENTER_KEY = "Enter";




                var code = e.keyCode || e.which;
                var key = e.key;
                if ((code == ENTER_KEY_CODE || key == ENTER_KEY) && value != '' && value != NaN) {
                    e.preventDefault();

                    var value = '';
                    var value_raw = parseInt($(this).val());
                    var value_text = value_raw.toString();
                    var prefix_check_1 = value_text.slice(0, 1);
                    var length = value_text.length;
                    var prefix_check_2 = value_text.slice(0, 2);
                    var prefix_check_3 = value_text.slice(0, 3);
                    if (prefix_check_1 != '6' && prefix_check_1 != '9') {
                        alert('Wrong mobile number format. \n 1. Number must start at 639 or 09. \n 2. Number must complete.');
                    } else {
                        if ((prefix_check_3 == '639' && length == 11) || (prefix_check_1 == '9' && length == 10)) {
                            if (prefix_check_3 == '639') {
                                value = value_raw;
                            }
                            if (prefix_check_1 == '9') {
                                value = '63' + value_text.toString();
                            }
                            contact_numbers.push(value);
                            display_contact();
                            $(this).val('');
                        } else {
                            alert('Wrong mobile number format. \n 1. Number must start at 639 or 09. \n 2. Number must complete.');
                        }
                    }
                    
                }
            })

            $(document).on('click', '.remove_contact', function() {
                let index = $(this).parent().index();
                contact_numbers.splice(index, 1);
                display_contact()
            })

            $('.btn_submit').on('click', function(e) {
                e.preventDefault();
                $("#insrt_mobile_num").val(contact_numbers.join(','))
                if ($('#form_deduction').valid()) {
                    Swal.fire({
                        title: 'Confirmation',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {

                        $('#form_deduction').submit();
                    })
                }



                //  return false;
            })

            function display_contact() {
                let str = "";
                for (let i = 0; i < contact_numbers.length; i++) {
                    str += "<div class='bg-success contact'>" +
                        "<i class='fas fa-user-plus text-sm icon_contact'></i>" +
                        "<span class='mx-1 number_data'>" + contact_numbers[i] + "</span>" +
                        "<i class='fa fa-close remove_contact icon_contact'></i>" +
                        "</div>"
                }
                $('#numbers').html(str);

            }

        })
    </script>
</body>

</html>