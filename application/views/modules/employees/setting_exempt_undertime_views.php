<?php $this->load->view('templates/companycontribution_style'); ?>
<?php $this->load->view('templates/css_link'); ?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" /> -->

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
                    <h1 class="page-title"><a href="<?= base_url() . 'employees'; ?>"><img style="width: 24px; height: 24px; margin: 0 0 6px 5px" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a>&nbsp;Employee Settings<h1>
                </div>
                <div class="col-md-6" style="text-align: right;">
                </div>
            </div>
            <hr>
<!-- 
            <div class="mx-auto card d-block d-lg-none col-11">
                <div class="form-group row d-flex justify-content-center">
                    <label for="" class="col-10">Navigate Settings</label>
                    <select name="" class="form-control col-10" id="settingsDropdown">
                        <option value="general" >
                           General
                        </option>
                        <option value="auto_approve">
                          Auto Approve
                        </option>
                        <option value="offset_access">
                          Offset Access
                        </option>
                        <option value="emp_types">
                           Employee Types
                        </option>
                        <option value="requirements" >
                        Requirements
                        </option>
                        <option value="customized_info">
                           Customized Informations
                        </option>
                        <option value="positions">
                           Positions
                        </option>
                        <option value="departments">
                           Departments
                        </option>
                        <option value="divisions">
                           Divisions
                        </option>
                        <option value="marital_stat">
                           Marital Statuses
                        </option>
                        <option value="genders">
                           Genders
                        </option>
                        <option value="nationalities">
                           Nationalities
                        </option>
                        <option value="religions">
                           Religions
                        </option>
                        <option value="blood_types">
                           Blood Types
                        </option>
                        <option value="hmos">
                           HMOs
                        </option>
                        <option value="shirt_sizes">
                           Shirt Sizes
                        </option>
                        <option value="banks">
                           Banks
                        </option>
                        <option value="custom_groups">
                           Custom Groups
                        </option>
                    </select>
                </div>
            </div> -->

            <div class="ml-0 pr-0 pl-0 " style="display: flex; align-items: center; justify-content: center;">
                <div class="card col-xl-8 col-lg-4 col-md-8 col-11" style="min-height:700px ">
                    <div class="row">
                        <div class="col-md-3 d-none d-lg-inline-block">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?php $this->load->view('templates/settings_employee_nav_views'); ?>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <span style="font-weight: 500; font-size: 18px">Exempt Undertime Access</span>
                                    <button type="submit" class="btn btn-primary mb-2 mr-3 submit_form d-flex align-items-center">
                                        <img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url() ?>assets_system/icons/circle-arrow-up-sharp-solid.svg" alt="">&nbsp;Update
                                    </button>
                                </div>

                                <div class="col-md-12">
                                    <!-- Manage leave settings and related features. These settings are applied company-wide. -->
                                </div>
                            </div>
                            <hr>
                            <div class="col">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-system_setup" role="tabpanel" aria-labelledby="v-pills-system_setup-tab">
                                    <form id="submit_payroll" action="<?= base_url('employees/update_exemptundertime_access') ?>" method="Post" enctype="multipart/form-data">
                                        <div class="row mt-3 ">
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group col-5">
                                                    <label for="selfservice_exempt_undertime">Self-Service</label>
                                                    <select name="selfservice_exempt_undertime[]" id="selfservice_exempt_undertime" class="form-control" style='width:100%' multiple multiselect-search="true">
                                                        <?php
                                                        if ($EMPLOYEE_LISTS) {
                                                            foreach ($EMPLOYEE_LISTS as $row) {
                                                                $selected = (in_array($row->id, $selfservice_exempt_undertime)) ? 'selected' : '';
                                                        ?>
                                                                <option value="<?= $row->id ?>" <?= $selected ?>><?= $row->nameWithCMIDList ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group col-5">
                                                    <label for="teams_exempt_undertime">Teams</label>
                                                    <select name="teams_exempt_undertime[]" id="teams_exempt_undertime" class="form-control" style='width:100%' multiple multiselect-search="true">
                                                        <?php if ($EMPLOYEE_LISTS) {
                                                            foreach ($EMPLOYEE_LISTS as $row) {
                                                                $selected = (in_array($row->id, $teams_exempt_undertime)) ? 'selected' : '';
                                                        ?>
                                                                <option value="<?= $row->id ?>" <?= $selected ?>><?= $row->nameWithCMIDList ?></option>
                                                        <?php }
                                                        } ?>

                                                    </select>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- <button type="submit" class="btn btn-primary ml-auto d-block"><img class="mb-1" style="height: 1.1rem; width: 1.1rem;" src="<?= base_url('assets_system/icons/circle-arrow-up-sharp-solid.svg') ?>" alt="" />&nbsp;Update</button> -->
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


    <aside class="control-sidebar control-sidebar-dark">
    </aside>
    <?php $this->load->view('templates/jquery_link'); ?>
    <script>
        $(document).ready(function() {
            $('input[name$="_enable"]').change(function() {
                var sectionName = $(this).attr('name').replace('_enable', '');
                toggleSections(sectionName);
            });

            function toggleSections(sectionName) {
                var enableSwitch = $('input[name="' + sectionName + '_enable"]');
                var sections = $('.' + sectionName + '-sections');

                if (enableSwitch.is(':checked')) {
                    // sections.show();

                    sections.removeClass('d-none');
                } else {
                    // sections.hide();
                    sections.addClass('d-none');
                }
            }
        });
    </script>

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
        $(document).ready(function() {
            $(document).on('click', 'button.clear_changes', function() {
                window.location.reload();
            });

            $(document).on('click', 'button.submit_form', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to update?",
                    text: "Confirm to save the settings!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Confirm"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form').submit();
                    }
                });
            });
        });
    </script>

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
                                    text: 'ðŸ—™',
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

            if (selectedValue === 'general') {
                window.location.href = '<?= base_url('employees/setting_general') ?>';
            }
            if (selectedValue === 'auto_approve') {
                window.location.href = '<?= base_url('employees/setting_auto_approve') ?>';
            }
            if (selectedValue === 'offset_access') {
                window.location.href = '<?= base_url('employees/employee_offset_access') ?>';
            }
            if (selectedValue === 'emp_types') {
                window.location.href = '<?= base_url('employees/employee_types') ?>';
            }
            if (selectedValue === 'requirements') {
                window.location.href = '<?= base_url('employees/requirements') ?>';
            }
            if (selectedValue === 'customized_info') {
                window.location.href = '<?= base_url('employees/customize_informations') ?>';
            }
            if (selectedValue === 'positions') {
                window.location.href = '<?= base_url('employees/positions') ?>';
            }
   
            if (selectedValue === 'departments') {
                window.location.href = '<?= base_url('employees/departments') ?>';
            }
            if (selectedValue === 'divisions') {
                window.location.href = '<?= base_url('employees/divisions') ?>';
            }
            if (selectedValue === 'marital_stat') {
                window.location.href = '<?= base_url('employees/marital_statuses') ?>';
            }
            if (selectedValue === 'genders') {
                window.location.href = '<?= base_url('employees/genders') ?>';
            }
            if (selectedValue === 'nationalities') {
                window.location.href = '<?= base_url('employees/nationalities') ?>';
            }
            if (selectedValue === 'religions') {
                window.location.href = '<?= base_url('employees/religions') ?>';
            }
            if (selectedValue === 'blood_types') {
                window.location.href = '<?= base_url('employees/blood_types') ?>';
            }
            if (selectedValue === 'hmos') {
                window.location.href = '<?= base_url('employees/hmos') ?>';
            }
            if (selectedValue === 'shirt_sizes') {
                window.location.href = '<?= base_url('employees/shirt_sizes') ?>';
            }
            if (selectedValue === 'banks') {
                window.location.href = '<?= base_url('employees/banks') ?>';
            }
            if (selectedValue === 'custom_groups') {
                window.location.href = '<?= base_url('employees/settings_custom_groups') ?>';
            }
            

        });
    });
</script>