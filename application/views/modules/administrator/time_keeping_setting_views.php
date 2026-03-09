<?php $this->load->view('templates/css_link'); ?>
<?php $this->load->view('templates/companycontribution_style'); ?>
<style>
    .image {
        display: flex;
        flex-direction: column;
    }

    .image p {
        margin-left: 8px;
        font-size: 12px;
    }
</style>
<style>
    .switch {
        position: relative;
        display: block;
        width: 50px;
        height: 26px;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .switch input {
        display: none;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 21px;
        width: 21px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50px;
    }

    input:checked+.slider:before {
        background-color: limegreen;
    }

    input:checked+.slider:before {
        transform: translateX(23px);
    }
</style>
<div class="content-wrapper" >
    <div class="container-fluid p-4">
        <div class="flex-fill">

            <div class="row p-0">
                <div class="col-md-6">
                    <h1 style="font-size: 24px;" class="page-title"><a href="<?= base_url() . 'administrators'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;General Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>

            <div class="ml-0 pr-0 pl-0 "  style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-8" style="min-height:700px ">
                    <div class="row" >
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                              <a class="nav-link" href="<?=site_url('administrators/generalsettings')?>">System Setup</a>
                              <a class="nav-link" href="<?=site_url('administrators/home_settings')?>">Home</a>
                              <!-- <a class="nav-link active" href="<?=site_url('administrators/time_keeping_settings')?>">Remote In / Out</a> -->
                              <a class="nav-link" href="<?=site_url('administrators/employee_settings')?>">Employee</a>
                              <a class="nav-link" href="<?=site_url('administrators/company_settings')?>">Company Structure</a>
                              <a class="nav-link" href="<?=site_url('administrators/administrator_settings')?>">Administrators</a>
                              <a class="nav-link" href="<?=site_url('administrators/payroll_settings')?>">Payroll Officers</a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="tab-content" id="v-pills-tabContent">
                              <div class="tab-pane fade show active" id="v-pills-system_setup" role="tabpanel" aria-labelledby="v-pills-system_setup-tab">
                                <form action="<?=base_url('administrators/update_settings')?>" method="post">
                                        <div class="">
                                            <div class="col-5 m-2 d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <label for="">Remote Camera</label>
                                                </div>
                                                <label class="switch ml-3">
                                                    <input  type="hidden" class="setting" name="remoteCamera" value="<?=$remoteCamera['value']?>">
                                                    <input  class="switch_on"  type="checkbox"  <?= $remoteCamera['value'] == '1' ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="col-5 m-2 d-flex align-items-center justify-content-between">
                                                <div class="">
                                                    <label for="">Remote GPS</label>
                                                </div>
                                                <label class="switch ml-3">
                                                    <input  type="hidden" class="setting" name="remoteGPS" value="<?=$remoteGPS['value']?>">
                                                    <input  class="switch_on"  type="checkbox"  <?= $remoteGPS['value'] == '1' ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary ml-auto d-block">Update</button>
                                    </form>
                              </div>
                            </div>
                        </div>
                    </div>
                    <nav class="d-none">
                      <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-system-tab" data-toggle="tab" href="#nav-system" role="tab" aria-controls="nav-system" aria-selected="true">System Setup</a>
                        <a class="nav-item nav-link" id="nav-home_setting-tab" data-toggle="tab" href="#nav-home_setting" role="tab" aria-controls="nav-home_setting" aria-selected="false">Home</a>
                        <a class="nav-item nav-link" id="nav-company_structure-tab" data-toggle="tab" href="#nav-company_structure" role="tab" aria-controls="nav-company_structure" aria-selected="false">Company Structure</a>
                      </div>
                    </nav>
                    <div class="tab-content d-none" id="nav-tabContent">
                      <div class="tab-pane fade show active" id="nav-system" role="tabpanel" aria-labelledby="nav-system-tab">
                            
                      </div>
                      <div class="tab-pane fade" id="nav-home_setting" role="tabpanel" aria-labelledby="nav-home_setting-tab">
                        
                      </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<aside class="control-sidebar control-sidebar-dark">
</aside>
<?php $this->load->view('templates/jquery_link'); ?>

<?php
if ($this->session->userdata('SESS_UPDATE')) {
?>
    <script>
        Swal.fire(
            '<?php echo $this->session->userdata('SESS_UPDATE'); ?>',
            '',
            'success'
        )
    </script>
<?php
    $this->session->unset_userdata('SESS_UPDATE');
}
?>

<?php
if ($this->session->userdata('SESS_SUCC_UPDATE')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success',
            subtitle: 'close',
            body: '<?php echo $this->session->userdata('SESS_SUCC_UPDATE'); ?>'
        })
    </script>
<?php
    $this->session->unset_userdata('SESS_SUCC_UPDATE');
}
?>

<?php
if ($this->session->flashdata('SUCC')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-success toast_width',
            title: 'Success!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('SUCC'); ?>'
        })
    </script>
<?php 
}
?>

<?php
if ($this->session->flashdata('ERR')) {
?>
    <script>
        $(document).Toasts('create', {
            class: 'bg-warning toast_width',
            title: 'Warning!',
            subtitle: 'close',
            body: '<?php echo $this->session->flashdata('ERR'); ?>'
        })
    </script>
<?php
}
?>

<script>
    $(function() {
        function update_login_logo(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#preview_login_logo').text(uploader.files[0].name);
            }
        }
        $("#update_login_logo").change(function() {
            update_login_logo(this);
        });

        function update_header_logo(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#preview_header_logo').text(uploader.files[0].name);
            }
        }
        $("#update_header_logo").change(function() {
            update_header_logo(this);
        });

        function update_nav_logo(uploader) {
            if (uploader.files && uploader.files[0]) {
                $('#preview_nav_logo').text(uploader.files[0].name);
            }
        }
        $("#update_nav_logo").change(function() {
            update_nav_logo(this);
        });
        $('input.switch_on').on('change',function(){
            if($(this).prop('checked')){
                $(this).siblings('input.setting').val('1')
                return;
            }
            $(this).siblings('input.setting').val('0')
        })
    });
</script>
<!-- <script>
    $(document).ready(function() {
        $('#payroll_managers').select2();
        $('#payroll_rankandfile').select2();

        $('#submit_payroll').on('submit', function() {
            // Get the selected values from Select2
            var selectedValues = $('#payroll_managers').val();
            console.log('selectedValues', selectedValues);
            // Update the original select input with the array of selected values
            $('#payroll_managers').val(selectedValues);
        });
    });
    $('#payroll_managers').on('change', function() {
      console.log('Selected value for payroll_managers:', $(this).val());
    });
</script> -->
<!-- <script>
    $(document).ready(function() {
        $('#payroll_managers').select2();
        $('#payroll_rankandfile').select2();
    });
    // var testValue = <?php echo json_encode($payroll_rankandfile); ?>;
    // console.log(testValue);
</script> -->

<script>
    var style = document.createElement('style');
    style.setAttribute("id","multiselect_dropdown_styles");
    style.innerHTML = `
    .multiselect-dropdown{
    width: 300px !important;
    display: inline-block;
    padding: 2px 5px 0px 5px;
    border-radius: 4px;
    border: solid 1px #ced4da;
    background-color: white;
    position: relative;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right .75rem center;
    background-size: 16px 12px;
    }
    .multiselect-dropdown span.optext, .multiselect-dropdown span.placeholder{
    margin-right:0.5em; 
    margin-bottom:2px;
    padding:1px 0; 
    border-radius: 4px; 
    display:inline-block;
    }
    .multiselect-dropdown span.optext{
    background-color:lightgray;
    padding:1px 0.75em; 
    }
    .multiselect-dropdown span.optext .optdel {
    float: right;
    margin: 0 -6px 1px 5px;
    font-size: 0.7em;
    margin-top: 2px;
    cursor: pointer;
    color: #666;
    }
    .multiselect-dropdown span.optext .optdel:hover { color: #c66;}
    .multiselect-dropdown span.placeholder{
    color:#ced4da;
    }
    .multiselect-dropdown-list-wrapper{
    box-shadow: gray 0 3px 8px;
    z-index: 100;
    padding:2px;
    border-radius: 4px;
    border: solid 1px #ced4da;
    display: none;
    margin: -1px;
    position: absolute;
    top:0;
    left: 0;
    right: 0;
    background: white;
    }
    .multiselect-dropdown-list-wrapper .multiselect-dropdown-search{
    margin-bottom:5px;
    }
    .multiselect-dropdown-list{
    padding:2px;
    height: 15rem;
    overflow-y:auto;
    overflow-x: hidden;
    }
    .multiselect-dropdown-list::-webkit-scrollbar {
    width: 6px;
    }
    .multiselect-dropdown-list::-webkit-scrollbar-thumb {
    background-color: #bec4ca;
    border-radius:3px;
    }

    .multiselect-dropdown-list div{
    padding: 5px;
    }
    .multiselect-dropdown-list input{
    height: 1.15em;
    width: 1.15em;
    margin-right: 0.35em;  
    }
    .multiselect-dropdown-list div.checked{
    }
    .multiselect-dropdown-list div:hover{
    background-color: #ced4da;
    }
    .multiselect-dropdown span.maxselected {width:100%;}
    .multiselect-dropdown-all-selector {border-bottom:solid 1px #999;}
    `;
    document.head.appendChild(style);

    function MultiselectDropdown(options){
    var config={
        search:true,
        height:'15rem',
        placeholder:'select',
        txtSelected:'selected',
        txtAll:'All',
        txtRemove: 'Remove',
        txtSearch:'search',
        ...options
    };
    function newEl(tag,attrs){
        var e=document.createElement(tag);
        if(attrs!==undefined) Object.keys(attrs).forEach(k=>{
        if(k==='class') { Array.isArray(attrs[k]) ? attrs[k].forEach(o=>o!==''?e.classList.add(o):0) : (attrs[k]!==''?e.classList.add(attrs[k]):0)}
        else if(k==='style'){  
            Object.keys(attrs[k]).forEach(ks=>{
            e.style[ks]=attrs[k][ks];
            });
        }
        else if(k==='text'){attrs[k]===''?e.innerHTML='&nbsp;':e.innerText=attrs[k]}
        else e[k]=attrs[k];
        });
        return e;
    }

    
    document.querySelectorAll("select[multiple]").forEach((el,k)=>{
        
        var div=newEl('div',{class:'multiselect-dropdown',style:{width:config.style?.width??el.clientWidth+'px',padding:config.style?.padding??''}});
        el.style.display='none';
        el.parentNode.insertBefore(div,el.nextSibling);
        var listWrap=newEl('div',{class:'multiselect-dropdown-list-wrapper'});
        var list=newEl('div',{class:'multiselect-dropdown-list',style:{height:config.height}});
        var search=newEl('input',{class:['multiselect-dropdown-search'].concat([config.searchInput?.class??'form-control']),style:{width:'100%',display:el.attributes['multiselect-search']?.value==='true'?'block':'none'},placeholder:config.txtSearch});
        listWrap.appendChild(search);
        div.appendChild(listWrap);
        listWrap.appendChild(list);

        el.loadOptions=()=>{
        list.innerHTML='';
        
        if(el.attributes['multiselect-select-all']?.value=='true'){
            var op=newEl('div',{class:'multiselect-dropdown-all-selector'})
            var ic=newEl('input',{type:'checkbox'});
            op.appendChild(ic);
            op.appendChild(newEl('label',{text:config.txtAll}));
    
            op.addEventListener('click',()=>{
            op.classList.toggle('checked');
            op.querySelector("input").checked=!op.querySelector("input").checked;
            
            var ch=op.querySelector("input").checked;
            list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")
                .forEach(i=>{if(i.style.display!=='none'){i.querySelector("input").checked=ch; i.optEl.selected=ch}});
    
            el.dispatchEvent(new Event('change'));
            });
            ic.addEventListener('click',(ev)=>{
            ic.checked=!ic.checked;
            });
            el.addEventListener('change', (ev)=>{
            let itms=Array.from(list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")).filter(e=>e.style.display!=='none')
            let existsNotSelected=itms.find(i=>!i.querySelector("input").checked);
            if(ic.checked && existsNotSelected) ic.checked=false;
            else if(ic.checked==false && existsNotSelected===undefined) ic.checked=true;
            });
    
            list.appendChild(op);
        }

        Array.from(el.options).map(o=>{
            var op=newEl('div',{class:o.selected?'checked':'',optEl:o})
            var ic=newEl('input',{type:'checkbox',checked:o.selected});
            op.appendChild(ic);
            op.appendChild(newEl('label',{text:o.text}));

            op.addEventListener('click',()=>{
            op.classList.toggle('checked');
            op.querySelector("input").checked=!op.querySelector("input").checked;
            op.optEl.selected=!!!op.optEl.selected;
            el.dispatchEvent(new Event('change'));
            });
            ic.addEventListener('click',(ev)=>{
            ic.checked=!ic.checked;
            });
            o.listitemEl=op;
            list.appendChild(op);
        });
        div.listEl=listWrap;

        div.refresh=()=>{
            div.querySelectorAll('span.optext, span.placeholder').forEach(t=>div.removeChild(t));
            var sels=Array.from(el.selectedOptions);
            if(sels.length>(el.attributes['multiselect-max-items']?.value??5)){
            div.appendChild(newEl('span',{class:['optext','maxselected'],text:sels.length+' '+config.txtSelected}));          
            }
            else{
            sels.map(x=>{
                var c=newEl('span',{class:'optext',text:x.text, srcOption: x});
                if((el.attributes['multiselect-hide-x']?.value !== 'true'))
                c.appendChild(newEl('span',{class:'optdel',text:'ðŸ—™',title:config.txtRemove, onclick:(ev)=>{c.srcOption.listitemEl.dispatchEvent(new Event('click'));div.refresh();ev.stopPropagation();}}));

                div.appendChild(c);
            });
            }
            if(0==el.selectedOptions.length) div.appendChild(newEl('span',{class:'placeholder',text:el.attributes['placeholder']?.value??config.placeholder}));
        };
        div.refresh();
        }
        el.loadOptions();
        
        search.addEventListener('input',()=>{
        list.querySelectorAll(":scope div:not(.multiselect-dropdown-all-selector)").forEach(d=>{
            var txt=d.querySelector("label").innerText.toUpperCase();
            d.style.display=txt.includes(search.value.toUpperCase())?'block':'none';
        });
        });

        div.addEventListener('click',()=>{
        div.listEl.style.display='block';
        search.focus();
        search.select();
        });
        
        document.addEventListener('click', function(event) {
        if (!div.contains(event.target)) {
            listWrap.style.display='none';
            div.refresh();
        }
        });    
    });
    }

    window.addEventListener('load',()=>{
    MultiselectDropdown(window.MultiselectDropdownOptions);
    });

</script>
