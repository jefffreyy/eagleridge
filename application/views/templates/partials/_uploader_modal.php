<div class="modal fade uploader_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true" style="z-index:10000">
  <div class="modal-dialog modal-xl" style="height:90%">
    <div class="modal-content h-100">
      <div class="modal-header">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-select_file-tab" data-toggle="tab" href="#nav-select_file" role="tab" aria-controls="nav-select_file" aria-selected="true">Select File</a>
            <a class="nav-item nav-link" id="nav-new_upload-tab" data-toggle="tab" href="#nav-new_upload" role="tab" aria-controls="nav-new_upload" aria-selected="false">Upload New</a>
          </div>
        </nav>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3" style="overflow:auto" >
        <div class="tab-content uploader_container" id="nav-tabContent" >
          <div class="tab-pane fade show active" id="nav-select_file" role="tabpanel" aria-labelledby="nav-select_file-tab">
            <div class="w-100">
                <!--<div>-->
                <!--     <input type="checkbox"> <span>Selected only</span>-->
                <!--</div>-->
                <fom class=" d-flex align-items-center">
                  <div class="form-group  m-0 w-25">
                    <input type="text" class="form-control uploader-search_file"  placeholder="Search your files">
                  </div>
                </fom>
                <div class="form-check mt-3">
                  <input class="form-check-input uploader-multi_selection" type="checkbox">
                  <label class="form-check-label">Enable Multiple Selection</label>
                </div>
            </div>
            <hr>
                <div id="image-grid" class="d-flex flex-wrap h-100">
                    
                </div>
          </div>
          <div class="tab-pane fade d-flex justify-content-center" id="nav-new_upload" role="tabpanel" aria-labelledby="nav-new_upload-tab">
              
          </div>
        </div>
      </div>
      <div class="modal-footer">
            <div class="d-flex mr-auto align-items-center" style="font-weight:500">
                <div class="">
                    <span></span>
                    <p class="m-0 p-0 text-primary"></p>
                </div>
                <div class="ml-3" >
                    <button  type="button" id="prev_file" class="btn_modal btn btn-primary btn-sm text-light" style="font-weight:500"><span>Prev</span></button>
                    <button type="button"  id="next_file" class="btn_modal btn btn-primary btn-sm text-light" style="font-weight:500"><span>Next</span></button>
                </div>
          </div>
          <button type="button" class="btn btn-danger btn-sm uploader_file_delete" >Delete</button>
          <button type="button" class="btn btn-primary btn-sm uploader_file_add" >Select File</button>
      </div>
    </div>
  </div>
</div>