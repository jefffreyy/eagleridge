
<?php $this->load->view('templates/css_link'); ?>
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <h1>Uploader</h1>
            <!--<form action="<?=base_url('uploaders/upload_file')?>" enctype="multipart/form-data" method="post">-->
            <!--    <input type="file" name="raw_file" multiple="multiple" />-->
            <!--    <button type='submit'>Submit</button>-->
            <!--</form>-->
            <!-- Large modal -->
            
            <div class="file_uploader m-2" >
                <input type="hidden" name="photos" class="selected_images d-block w-100"/>
            </div>
            <div class="file_uploader " >
                <input type="hidden" name="file" class="selected_images"/>
            </div>
        </div>
       
    </div>
     <?php $this->load->view('templates/jquery_link'); ?>