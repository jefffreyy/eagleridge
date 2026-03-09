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
<div class="content-wrapper">
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

            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Select Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="system_setup" selected>
                            System Setup
                        </option>
                        <option value="home">
                            Home
                        </option>
                        <option value="company_structure">
                            Company Structure
                        </option>
                        <option value="administrators">
                            Administrators
                        </option>
                        <option value="payroll_officers">
                            Payroll Officers
                        </option>
                        <option value="employee_pass">
                            Employee Password Management
                        </option>
                        <option value="self_service_settings">
                            Self Service Settings
                        </option>
                        <option value="date_format_settings">
                            Date Format Settings
                        </option>
                        <!-- <option value="admin_geo_fencing_settings">
                            Geo Fencing Settings
                        </option> -->
                    </select>
                </div>
            </div>

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-2 d-none d-lg-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link" href="<?= site_url('administrators/generalsettings') ?>">System Setup</a>
                                <a class="nav-link " href="<?= site_url('administrators/home_settings') ?>">Home</a>
                                <a class="nav-link" href="<?= site_url('administrators/company_settings') ?>">Company Structure</a>
                                <a class="nav-link" href="<?= site_url('administrators/administrator_settings') ?>">Administrators</a>
                                <a class="nav-link" href="<?= site_url('administrators/payroll_settings') ?>">Payroll Officers</a>
                                <a class="nav-link" href="<?= site_url('administrators/employee_password_settings') ?>">Employee Password Management</a>
                                <a class="nav-link" href="<?= site_url('administrators/self_service_settings') ?>">Self Service Settings</a>
                                <a class="nav-link active" href="<?= site_url('administrators/date_format_settings') ?>">Date Format Settings</a>
                                <!-- <a class="nav-link" href="<?= site_url('administrators/geo_fencing_settings') ?>">Geo Fencing Settings</a> -->
                            </div>
                        </div>
                        <div class="col p-3">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-system_setup" role="tabpanel" aria-labelledby="v-pills-system_setup-tab">
                                    <form action="<?php echo base_url(); ?>administrators/update_date_settings" method="post" accept-charset="utf-8" autocomplete='off' class="m-2" enctype="multipart/form-data">

                                    
                                    <div class="col-12 d-flex justify-content-end mb-3">
                                            <button class="btn btn-primary" id="update_btn" type="submit"><img class="mb-1" style="height: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                        </div>

                                        <div class="form-group row mt-3">
                                            <label for="date_format" class="col-12 col-lg-2">Date Format</label>
                                            <div class="col-12 col-lg-5">
                                                <select class="form-control" name="date_format" id="date_format">
                                                <option value="">-Select Date Format-</option>
                                                <option value="M. d, Y"<?= ($DATE_FORMAT == 'M. d, Y') ? 'selected' : '' ?>>MM.DD,YYYY (e.g., Mar. 15, 2024)</option>
                                                <option value="d, M. Y"<?= ($DATE_FORMAT == 'd, M. Y') ? 'selected' : '' ?>>DD,MM.YYYY (e.g., 15, Mar. 2024)</option>
                                                <option value="Y, M. d"<?= ($DATE_FORMAT == 'Y, M. d') ? 'selected' : '' ?>>YYYY,MM.DD (e.g., 2024, Mar. 15)</option>
                                                <option value="Y, d, M"<?= ($DATE_FORMAT == 'Y, d, M') ? 'selected' : '' ?>>YYYY,DD,MM (e.g., 2024, 15, Mar)</option>
                                                <hr>
                                                <option value="M/d/Y"<?= ($DATE_FORMAT == 'M/d/Y') ? 'selected' : '' ?>>MM/DD/YYYY (e.g., Mar/15/2024)</option>
                                                <option value="d/M/Y"<?= ($DATE_FORMAT == 'd/M/Y') ? 'selected' : '' ?>>DD/MM/YYYY (e.g., 15/Mar/2024)</option>
                                                <option value="Y/M/d"<?= ($DATE_FORMAT == 'Y/M/d') ? 'selected' : '' ?>>YYYY/MM/DD (e.g., 2024/Mar/15)</option>
                                                <option value="Y/d/M"<?= ($DATE_FORMAT == 'Y/d/M') ? 'selected' : '' ?>>YYYY/DD/MM (e.g., 2024/15/Mar)</option>
                                                <hr>
                                                <option value="M. d, y"<?= ($DATE_FORMAT == 'M. d, y') ? 'selected' : '' ?>>MM.DD,YY (e.g., Mar. 15, 24)</option>
                                                <option value="d, M. y"<?= ($DATE_FORMAT == 'd, M. y') ? 'selected' : '' ?>>DD,MM.YY (e.g., 15, Mar. 24)</option>
                                                <option value="y, M. d"<?= ($DATE_FORMAT == 'y, M. d') ? 'selected' : '' ?>>YY,MM.DD (e.g., 24, Mar. 15)</option>
                                                <option value="y, d, M"<?= ($DATE_FORMAT == 'y, d, M') ? 'selected' : '' ?>>YY,DD,MM (e.g., 24, 15, Mar)</option>
                                                <hr>
                                                <option value="M/d/y"<?= ($DATE_FORMAT == 'M/d/y') ? 'selected' : '' ?>>MM/DD/YY (e.g., Mar/15/24)</option>
                                                <option value="d/M/y"<?= ($DATE_FORMAT == 'd/M/y') ? 'selected' : '' ?>>DD/MM/YY (e.g., 15/Mar/24)</option>
                                                <option value="y/M/d"<?= ($DATE_FORMAT == 'y/M/d') ? 'selected' : '' ?>>YY/MM/DD (e.g., 24/Mar/15)</option>
                                                <option value="y/d/M"<?= ($DATE_FORMAT == 'y/d/M') ? 'selected' : '' ?>>YY/DD/MM (e.g., 24/15/Mar)</option>
                                                <hr>
                                                <option value="m-d-Y"<?= ($DATE_FORMAT == '"m-d-Y') ? 'selected' : '' ?>>mm-dd-yyyy (e.g., 03-15-2024)</option>
                                                <option value="d-m-Y"<?= ($DATE_FORMAT == 'd-m-Y') ? 'selected' : '' ?>>dd-mm-yyyy (e.g., 15-03-2024)</option>
                                                <option value="Y-m-d"<?= ($DATE_FORMAT == 'Y-m-d') ? 'selected' : '' ?>>yyyy-mm-dd (e.g., 2024-03-15)</option>
                                                <option value="Y-d-m"<?= ($DATE_FORMAT == 'Y-d-m') ? 'selected' : '' ?>>yyyy-dd-mm (e.g., 2024-15-03)</option>
                                                <hr>
                                                <option value="m/d/Y"<?= ($DATE_FORMAT == 'm/d/Y') ? 'selected' : '' ?>>mm/dd/yyyy (e.g., 03/15/2024)</option>
                                                <option value="d/m/Y"<?= ($DATE_FORMAT == 'd/m/Y') ? 'selected' : '' ?>>dd/mm/yyyy (e.g., 15/03/2024)</option>
                                                <option value="Y/m/d"<?= ($DATE_FORMAT == 'Y/m/d') ? 'selected' : '' ?>>yyyy/mm/dd (e.g., 2024/03/15)</option>
                                                <option value="Y/d/m"<?= ($DATE_FORMAT == 'Y/d/m') ? 'selected' : '' ?>>yyyy/dd/mm (e.g., 2024/15/03)</option>
                                                <hr>
                                                <option value="m-d-y"<?= ($DATE_FORMAT == 'm-d-y') ? 'selected' : '' ?>>mm-dd-yy (e.g., 03-15-24)</option>
                                                <option value="d-m-y"<?= ($DATE_FORMAT == 'd-m-y') ? 'selected' : '' ?>>dd-mm-yy (e.g., 15-03-24)</option>
                                                <option value="y-m-d"<?= ($DATE_FORMAT == 'y-m-d') ? 'selected' : '' ?>>yy-mm-dd (e.g., 24-03-15)</option>
                                                <option value="y-d-m"<?= ($DATE_FORMAT == 'y-d-m') ? 'selected' : '' ?>>yy-dd-mm (e.g., 24-15-03)</option>
                                                <hr>
                                                <option value="m/d/y"<?= ($DATE_FORMAT == 'm/d/y') ? 'selected' : '' ?>>mm/dd/yy (e.g., 03/15/24)</option>
                                                <option value="d/m/y"<?= ($DATE_FORMAT == 'd/m/y') ? 'selected' : '' ?>>dd/mm/yy (e.g., 15/03/24)</option>
                                                <option value="y/m/d"<?= ($DATE_FORMAT == 'y/m/d') ? 'selected' : '' ?>>yy/mm/dd (e.g., 24/03/15)</option>
                                                <option value="y/d/m"<?= ($DATE_FORMAT == 'y/d/m') ? 'selected' : '' ?>>yy/dd/mm (e.g., 24/15/03)</option>
                                                </select>
                                                <p style="color: gray;">Equivalent Date: <?= $SAMPLE_DATE ?></p>
                                            </div>
                                        </div>

                                        <!-- <div class="col-12 d-flex justify-content-end">
                                            <button class="btn btn-primary" id="update_btn" type="submit"><img class="mb-1" style="height: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button>
                                        </div> -->

                                    </form>
                                </div>

                            </div>
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
        $('input.switch_on').on('change', function() {
            if ($(this).prop('checked')) {
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
    style.setAttribute("id", "multiselect_dropdown_styles");
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

    function MultiselectDropdown(options) {
        var config = {
            search: true,
            height: '15rem',
            placeholder: 'select',
            txtSelected: 'selected',
            txtAll: 'All',
            txtRemove: 'Remove',
            txtSearch: 'search',
            ...options
        };

        function newEl(tag, attrs) {
            var e = document.createElement(tag);
            if (attrs !== undefined) Object.keys(attrs).forEach(k => {
                if (k === 'class') {
                    Array.isArray(attrs[k]) ? attrs[k].forEach(o => o !== '' ? e.classList.add(o) : 0) : (attrs[k] !== '' ? e.classList.add(attrs[k]) : 0)
                } else if (k === 'style') {
                    Object.keys(attrs[k]).forEach(ks => {
                        e.style[ks] = attrs[k][ks];
                    });
                } else if (k === 'text') {
                    attrs[k] === '' ? e.innerHTML = '&nbsp;' : e.innerText = attrs[k]
                } else e[k] = attrs[k];
            });
            return e;
        }


        document.querySelectorAll("select[multiple]").forEach((el, k) => {

            var div = newEl('div', {
                class: 'multiselect-dropdown',
                style: {
                    width: config.style?.width ?? el.clientWidth + 'px',
                    padding: config.style?.padding ?? ''
                }
            });
            el.style.display = 'none';
            el.parentNode.insertBefore(div, el.nextSibling);
            var listWrap = newEl('div', {
                class: 'multiselect-dropdown-list-wrapper'
            });
            var list = newEl('div', {
                class: 'multiselect-dropdown-list',
                style: {
                    height: config.height
                }
            });
            var search = newEl('input', {
                class: ['multiselect-dropdown-search'].concat([config.searchInput?.class ?? 'form-control']),
                style: {
                    width: '100%',
                    display: el.attributes['multiselect-search']?.value === 'true' ? 'block' : 'none'
                },
                placeholder: config.txtSearch
            });
            listWrap.appendChild(search);
            div.appendChild(listWrap);
            listWrap.appendChild(list);

            el.loadOptions = () => {
                list.innerHTML = '';

                if (el.attributes['multiselect-select-all']?.value == 'true') {
                    var op = newEl('div', {
                        class: 'multiselect-dropdown-all-selector'
                    })
                    var ic = newEl('input', {
                        type: 'checkbox'
                    });
                    op.appendChild(ic);
                    op.appendChild(newEl('label', {
                        text: config.txtAll
                    }));

                    op.addEventListener('click', () => {
                        op.classList.toggle('checked');
                        op.querySelector("input").checked = !op.querySelector("input").checked;

                        var ch = op.querySelector("input").checked;
                        list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")
                            .forEach(i => {
                                if (i.style.display !== 'none') {
                                    i.querySelector("input").checked = ch;
                                    i.optEl.selected = ch
                                }
                            });

                        el.dispatchEvent(new Event('change'));
                    });
                    ic.addEventListener('click', (ev) => {
                        ic.checked = !ic.checked;
                    });
                    el.addEventListener('change', (ev) => {
                        let itms = Array.from(list.querySelectorAll(":scope > div:not(.multiselect-dropdown-all-selector)")).filter(e => e.style.display !== 'none')
                        let existsNotSelected = itms.find(i => !i.querySelector("input").checked);
                        if (ic.checked && existsNotSelected) ic.checked = false;
                        else if (ic.checked == false && existsNotSelected === undefined) ic.checked = true;
                    });

                    list.appendChild(op);
                }

                Array.from(el.options).map(o => {
                    var op = newEl('div', {
                        class: o.selected ? 'checked' : '',
                        optEl: o
                    })
                    var ic = newEl('input', {
                        type: 'checkbox',
                        checked: o.selected
                    });
                    op.appendChild(ic);
                    op.appendChild(newEl('label', {
                        text: o.text
                    }));

                    op.addEventListener('click', () => {
                        op.classList.toggle('checked');
                        op.querySelector("input").checked = !op.querySelector("input").checked;
                        op.optEl.selected = !!!op.optEl.selected;
                        el.dispatchEvent(new Event('change'));
                    });
                    ic.addEventListener('click', (ev) => {
                        ic.checked = !ic.checked;
                    });
                    o.listitemEl = op;
                    list.appendChild(op);
                });
                div.listEl = listWrap;

                div.refresh = () => {
                    div.querySelectorAll('span.optext, span.placeholder').forEach(t => div.removeChild(t));
                    var sels = Array.from(el.selectedOptions);
                    if (sels.length > (el.attributes['multiselect-max-items']?.value ?? 5)) {
                        div.appendChild(newEl('span', {
                            class: ['optext', 'maxselected'],
                            text: sels.length + ' ' + config.txtSelected
                        }));
                    } else {
                        sels.map(x => {
                            var c = newEl('span', {
                                class: 'optext',
                                text: x.text,
                                srcOption: x
                            });
                            if ((el.attributes['multiselect-hide-x']?.value !== 'true'))
                                c.appendChild(newEl('span', {
                                    class: 'optdel',
                                    text: '🗙',
                                    title: config.txtRemove,
                                    onclick: (ev) => {
                                        c.srcOption.listitemEl.dispatchEvent(new Event('click'));
                                        div.refresh();
                                        ev.stopPropagation();
                                    }
                                }));

                            div.appendChild(c);
                        });
                    }
                    if (0 == el.selectedOptions.length) div.appendChild(newEl('span', {
                        class: 'placeholder',
                        text: el.attributes['placeholder']?.value ?? config.placeholder
                    }));
                };
                div.refresh();
            }
            el.loadOptions();

            search.addEventListener('input', () => {
                list.querySelectorAll(":scope div:not(.multiselect-dropdown-all-selector)").forEach(d => {
                    var txt = d.querySelector("label").innerText.toUpperCase();
                    d.style.display = txt.includes(search.value.toUpperCase()) ? 'block' : 'none';
                });
            });

            div.addEventListener('click', () => {
                div.listEl.style.display = 'block';
                search.focus();
                search.select();
            });

            document.addEventListener('click', function(event) {
                if (!div.contains(event.target)) {
                    listWrap.style.display = 'none';
                    div.refresh();
                }
            });
        });
    }

    window.addEventListener('load', () => {
        MultiselectDropdown(window.MultiselectDropdownOptions);
    });
</script>
<script>
    $(document).ready(function() {

        $('#settingsDropdown').on('change', function() {
            var selectedValue = $(this).val();

            if (selectedValue === 'system_setup') {
                window.location.href = '<?= base_url('administrators/generalsettings') ?>';
            }
            if (selectedValue === 'home') {
                window.location.href = '<?= base_url('administrators/home_settings') ?>';
            }
            if (selectedValue === 'company_structure') {
                window.location.href = '<?= base_url('administrators/company_settings') ?>';
            }
            if (selectedValue === 'administrators') {
                window.location.href = '<?= base_url('administrators/administrator_settings') ?>';
            }
            if (selectedValue === 'payroll_officers') {
                window.location.href = '<?= base_url('administrators/payroll_settings') ?>';
            }
            if (selectedValue === 'employee_pass') {
                window.location.href = '<?= base_url('administrators/employee_password_settings') ?>';
            }
            if (selectedValue === 'self_service_settings') {
                window.location.href = '<?= base_url('administrators/self_service_settings') ?>';
            }
            if (selectedValue === 'date_format_settings') {
                window.location.href = '<?= base_url('administrators/date_format_settings') ?>';
            }

        });
    });
</script>