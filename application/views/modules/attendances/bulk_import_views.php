<?php $this->load->view('templates/css_link'); ?>
<div class="content-wrapper">
  <div class="container-fluid p-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?= base_url() ?>attendances">Attendance</a>
          </li>

         <li class="breadcrumb-item active" aria-current="page">
           <a href="<?= base_url() ?>attendances/shift_assignment">Shift Assignment</a>
          </li>

          <li class="breadcrumb-item active" aria-current="page">
            Bulk Import
          </li>

        </ol>
    </nav>

    <div class="d-flex justify-content-center">
      <div class="card w-50 p-3">
        <h2 clas="page-title">CSV Upload</h2>
        <hr>
        <div class="donwloadFile">
          <p><strong>Step 1 : </strong>Download sample file format <i><a href="" download>here.</a></i></p>
          <p><strong>Step 2 : </strong>Open the file using MS Excel or any Spreadsheet Software</p>
          <p><strong>Step 3 : </strong>Add new items on 2nd row onwards of the sheet</p>
          <p><strong>Step 4 : </strong>Save the file as CSV</p>
          <p><strong>Step 5 : </strong>Upload the CSV by clicking the Browse button below</p>
        </div>

        <div class="mt-4">
          <form method='post' action='' enctype="multipart/form-data">
            <div class="form-group w-50">
              <label for="inputState">Cut off period</label>
              <select id="inputState" class="form-control" required>
                <option selected>Select cut off</option>
                <option>...</option>
              </select>
            </div>

            <div class="form-group">
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input fileficker" id="file" name='file' onchange='myFunction()'>
                  <label class="custom-file-label" id="fileInput" for="file_step1">Choose csv file...</label>
                </div>

                <div class="input-group-append">
                  <input class="btn btn-success mt-0 " type='submit' value='Upload'>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>