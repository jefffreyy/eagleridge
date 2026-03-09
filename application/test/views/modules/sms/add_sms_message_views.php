<html>
<?php 
$this->load->view('templates/css_link');

?>
<style>
    .contact{
        margin:5px 2px;
        width:max-content;
        border-radius:20px;font-size:12px;
        padding:10px;
    }
    .icon_contact{
        font-size:12px !important;
    }
    .remove_contact{
        cursor:pointer;
    }
</style>
<body>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'messages' ?>">Messaging</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url() . 'messages/sms_messages' ?>">SMS Messages</a>
                    </li>

                    <li class="breadcrumb-item active" aria-current="page">Add&nbsp;SMS&nbsp;Message
                    </li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="modal-body pb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?=base_url('messages/insert_new_sms_message')?>" id='form_deduction' method="POST">
                                        <div class="form-group ">
                                            <label class="required">Message Title</label>
                                            <input type="text" class="form-control" name="insrt_title" id="insrt_title" placeholder="Enter Message Title" required>
                                        </div>
                                        <div class="form-group ">
                                            <label class="required">Schedule Date</label>
                                            <div class="custom-control custom-switch d-inline">
                                                <input type="checkbox"  class="custom-control-input" name='send_now' checked id="send_now">
                                                <label class="custom-control-label" for="send_now">Send now</label>
                                            </div>
                                            <input type="datetime-local" class="form-control" disabled name="insrt_date" id="insrt_date"  required>
                                        </div>
                                        

                                         <div class="form-group">
                                            <label for="insrt_message">Messages</label>
                                            <textarea class="form-control" id="insrt_message" name='insrt_message' rows="3" required></textarea>
                                          </div>
                                        <div class="form-group ">
                                            <label class="required">Mobile Number</label>
                                            <div id='numbers' class='d-flex flex-wrap'>
                                                
                                            </div>
                                            <input type="tel" class="form-control mt-1" name="insrt_mobile_num" id="insrt_mobile_num" required>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"
    integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
             $('#select_employee').select2();
             let contact_numbers=[];
             
             $('#send_now').on('change',function(){
                 if ($(this).is(':checked')) {
                  // Checkbox is checked
                  $('#insrt_date').prop('disabled',true);
                } else {
                  // Checkbox is not checked
                  
                  $('#insrt_date').prop('disabled',false);
                }

             })
             $('#insrt_mobile_num').on('keydown',function(e){
                  const ENTER_KEY_CODE  = 13;
                  const ENTER_KEY       = "Enter";
                  var value     = parseInt($(this).val());
                  var code      = e.keyCode || e.which;
                  var key       = e.key;
                  if ((code == ENTER_KEY_CODE || key == ENTER_KEY) && value!='' && value!=NaN) {
                      e.preventDefault();
                    contact_numbers.push(value);
                    display_contact();
                    $(this).val('');
                  }
             })
             
             $(document).on('click','.remove_contact',function(){
                 let index=$(this).parent().index();
                 contact_numbers.splice(index,1);
                 display_contact()
             })
             
             $('.btn_submit').on('click',function(e){
                 e.preventDefault();
                 $("#insrt_mobile_num").val(contact_numbers.join(','))
                 if($('#form_deduction').valid()){
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
             function display_contact(){
                 let str="";
                 for(let i=0;i<contact_numbers.length;i++){
                     str+="<div class='bg-success contact'>"+
                            "<i class='fas fa-user-plus text-sm icon_contact'></i>"+
                            "<span class='mx-1 number_data'>"+contact_numbers[i]+"</span>"+
                            "<i class='fa fa-close remove_contact icon_contact'></i>"+
                            "</div>"
                 }
                 $('#numbers').html(str);
                 
             }
             
        })
    </script>
</body>

</html>