<?php $this->load->view('templates/css_link'); ?>
<style>
    .container {
    border: 2px solid #dedede;
    background-color: #f1f1f1;
    border-radius: 5px;
    padding: 10px;
    margin: 10px 0;
    }

    .darker {
    border-color: #ccc;
    background-color: #ddd;
    }

    .container::after {
    content: "";
    clear: both;
    display: table;
    }

    .container img {
    float: left;
    border-radius: 50% !important;
    width: 50px !important;
    height: 50px !important;
    object-fit: scale-down;
    background: #fff;
    }

    .container img.right {
    float: right;
    margin-left: 20px;
    margin-right:0;
    }

    .time-right {
    float: right;
    color: #aaa;
    }

    .time-left {
    float: left;
    color: #999;
    }
</style>
<style>
    .hover{
        cursor: pointer;
    }
</style>
<script>
      function setDefaultImage(img) {
        img.src = "<?= base_url() ?>/assets_system/images/default_user.jpg";
        img.alt = 'Default Image';
      }
</script>
<div class="content-wrapper" style="min-height: 624px;">
    <div class='row'>
        <div class='col-md-8 ml-4 mt-3'>
            <h2><a onclick="afterRenderFunction()" href="<?= base_url() . 'selfservices'; ?>"><img style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt=""></a></h2>
        </div>
    </div>

    <div class="mx-auto" style="max-width: 500px">
        <!-- <div class=""> -->
            <div class="card">

                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                        <img id="refreshButton" onclick="refresh()" class="hover d-none" style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/circle-left-duotone.svg') ?>" alt="">
                            <h4 class="mx-2 my-0" id="messageTitle">
                                <?=isset($receiverName) ? $receiverName : (!$unseenCount ? 'Messages' : 'Messages <span class="badge badge-danger">'.$unseenCount.'</span>') ?> 
                            </h4>
                        </div> 
                        <div class="hover">
                            <img onclick="reload()"  style="width: 32px; height: 32px;" src="<?= base_url('assets_system/icons/refresh.png') ?>" alt="">
                        </div>
                    </div>
                </div>
                    
                <div class="card-body ">
                    <div class="input-group mb-3 <?=isset($receiverName)? 'd-none' : ''?>" id="searchDiv">
                        <input type="text" class="form-control" id="search" placeholder="Search" aria-label="search" aria-describedby="search">
                        <div class="input-group-append">
                            <button onclick="clearSearch()" class="btn btn-outline-secondary" type="button">Clear</button>
                            <button onclick="searchEmployees()" class="btn btn-outline-secondary" type="button">Search</button>
                        </div>
                    </div>
                    <div id="messagesBody" style="height:350px;overflow-y:auto">
                        <?php if(isset($search)){ ?>
                            
                            <?php if(!empty($data)){ 
                                foreach($data as $item){ ?> 
                                    <div class="container hover" onclick="getMessage(`<?=$item->id?>`, `<?=$item->name?>`)">
                                        <img  src="<?=base_url()?>assets_user/user_profile/<?=$item->col_imag_path?>" alt="Avatar" style="width:100%;" onerror="setDefaultImage(this)">
                                        <div class="m-0 ml-2" >
                                            <h5 class="m-0"><?=$item->name?></h5>
                                            <span>Position: <?=$item->position?></span>
                                        </div>
                                    </div>
                            <?php } } else {?>
                                <h5 class="text-center">No Records</h5>
                            <?php } ?>
                        
                        <?php } else if(isset($groupId) && !empty($groupId)) { ?> 
                            
                            <?php if(!empty($data)){ 
                                foreach($data as $item){ 
                                    $create_date = $item->create_date;
                                    $dateTimeParts = explode(' ', $create_date);
                                    $dateParts = explode('-', $dateTimeParts[0]);
                                    $formattedDate = $dateParts[2] . '/' . $dateParts[1] . '/' . $dateParts[0] . ' ' . $dateTimeParts[1];
                                ?> 
                                    <div class="container <?=$userId == $item->sender_id? 'darker' : ''?> ">
                                        <img src="<?=base_url()?>assets_user/user_profile/<?=$item->col_imag_path?>" alt="Avatar" class="<?=$userId == $item->sender_id? 'right' : ''?>" style="width:100%;" onerror="setDefaultImage(this)">
                                        <p class="mb-1"><?=$item->message?></p>
                                        <a href="<?=base_url()?>assets_user/files/selfservices/<?=$item->attachment?>"  download><?=$item->attachment?></a>
                                        <span class="time-<?=$userId == $item->sender_id? 'left' : 'right'?>"><?=$formattedDate?></span>
                                    </div>
                                    <!-- <div class="container">
                                        <img src="http://localhost/hrms-dev.eyebox.app/assets_user/user_profile/b424bd77e5af7208ea7229a509592d03.jpg" alt="Avatar" style="width:100%;">
                                        <p>Sweet! So, what do you wanna do today?</p>
                                        <span class="time-right">11:02</span>
                                    </div> -->
                            <?php } } else {?>
                                <h5 class="text-center">No Message</h5>
                            <?php } ?>
                        
                        <?php } else { ?> 
                            
                            <?php if(!empty($data)){ 
                                foreach($data as $item){ ?> 
                                    <div class="container hover" style="<?=in_array($userId, explode(",", $item->seen_by))? '': 'background: #ddcdf7' ?>" 
                                        onclick="getMessage(`<?=isset($item->id)?$item->id:null?>`, `<?=$item->name?>`,`<?=isset($item->groupId)?$item->groupId:null?>`)">
                                        <img  src="<?=base_url()?>assets_user/user_profile/<?=$item->col_imag_path?>" alt="Avatar" style="width:100%;" onerror="setDefaultImage(this)">
                                        <div class="m-0 ml-2" >
                                            <h5 class="m-0"><?=$item->name?></h5>
                                            <span class="<?=in_array($userId, explode(",", $item->seen_by))? '': 'font-weight-bold' ?>"> <?=$item->message?></span>
                                        </div>
                                    </div>
                            <?php } } else {?>
                                <h5 class="text-center">No Messages</h5>
                            <?php } ?>
                        
                        <?php } ?>



                    </div>
                    
                    <div class="<?=isset($receiverName)? '' : 'd-none'?>" id="messageInputDiv">
                        <div class="form-group">
                            <label for="textarea">Message:</label> <small id="characterCount" class="form-text text-muted float-right">100 characters remaining</small>
                            <textarea id="messageInput" class="form-control" placeholder="Type your message here" id="text" rows="1"></textarea>
                            
                        </div>
                        <div class="file_uploader form-group" data-type="self_services">
                            <label>Attachment</label>
                            <input type="hidden" id="attachment" class="selected_images d-block w-100" />
                        </div>
                        <div class="float-right">
                            <input type="hidden" id="groupId" value="<?=isset($groupId) && !empty($groupId)? $groupId : ''?>">
                            <button onclick="sendMessage()" type="button" id="sendButton" class="btn btn-primary" disabled>Send</button>
                        </div>
                    </div>

                </div>
        <!-- </div> -->
    </div>
</div>

<?php $this->load->view('templates/jquery_link'); ?>
<?php if ($this->session->flashdata('SUCC')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('SUCC'); ?>', '', 'success')
    </script>
<?php } ?>
<?php if ($this->session->flashdata('ERR')) { ?>
    <script>
        Swal.fire('<?php echo $this->session->flashdata('ERR'); ?>',
            '',
            'error'
        )
    </script>
<?php } ?>

<!-- <script>
    $(document).ready(function() {
        $('#input_empl_id').select2();
    });
</script> -->

<script>
    function checkSearchParams(url, paramName) {
        const urlObject = new URL(url);
        if (urlObject.searchParams.has(paramName)) {
            const paramValue = urlObject.searchParams.get(paramName);
            // console.log(`URL contains '${paramName}' parameter with value: ${paramValue}`);
            return paramValue;
        } else {
            // console.log(`URL does not contain '${paramName}' parameter`);
            return null;
        }
    }
    console.log('checkSearchParams', checkSearchParams(window.location.href, 'search'))
</script>
<script>
    function clearSearch(){
        let currentUrl = window.location.href;
        var urlWithoutParams = currentUrl.split('?')[0];
        currentUrl = urlWithoutParams + '?search=';
        window.history.pushState({ path: currentUrl }, '', currentUrl);
        document.getElementById('search').value = '';
    }
</script>
<script>
    if (checkSearchParams(window.location.href, 'search') != null) {
        document.getElementById("messageTitle").textContent  = 'Search Results';
        document.getElementById("search").value  = checkSearchParams(window.location.href, 'search');
    } else if(checkSearchParams(window.location.href, 'groupId')) {
        // document.getElementById("messageTitle").textContent  = 'Search Results';
    }
</script>
<script>
    const base_url = `<?=base_url()?>`;
    function searchEmployees(){
        document.getElementById("messageTitle").textContent  = 'Search Results';
        
        const messagesBody = document.getElementById('messagesBody');
        while (messagesBody.firstChild) {
            messagesBody.removeChild(messagesBody.firstChild);
        }
        messagesBody.innerHTML = '<h5 class="text-center">Searching...</h5>';
        const search = document.getElementById('search').value;
        console.log('search',search);
        let currentUrl = window.location.href;
        var urlWithoutParams = currentUrl.split('?')[0];
        currentUrl = urlWithoutParams + '?search='+search;
        window.history.pushState({ path: currentUrl }, '', currentUrl);
        fetch('<?php echo base_url('selfservices/my_messages_api')?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ search })
        })
        .then(response => response.json())
        .then(data => {
            console.log('data', data)
            let htmlContent = '';
            if (data.length > 0) {
            data.forEach(item => {
                htmlContent += `<div class="container hover" onclick="getMessage(${item.id},'${item.name}')">
                                    <img src="${base_url}assets_user/user_profile/${item.col_imag_path}" alt="Avatar" style="width:100%;" onerror="setDefaultImage(this)">
                                    <div class="m-0 ml-2">
                                        <h5 class="m-0">${item.name}</h5>
                                        <span>Position: ${item.position?item.position:''}</span>
                                    </div>
                                </div>`;
            });
                messagesBody.innerHTML = htmlContent;
            } else {
                // If data is empty, show a message
                htmlContent = '<h5 class="text-center">No Records</h5>';
                messagesBody.innerHTML = htmlContent;
            }
        })
        .catch(error => console.error('Error:', error));
        toggleRefresh(true);
    
    }
</script>

<script>
    function getMessage(id, name,groupId){
        console.log('name', name);

        document.getElementById("messageTitle").textContent  = name;
        document.getElementById("searchDiv").classList.add("d-none");
        document.getElementById("messageInputDiv").classList.remove("d-none");
        const messagesBody = document.getElementById('messagesBody');
        while (messagesBody.firstChild) {
            messagesBody.removeChild(messagesBody.firstChild);
        }
        messagesBody.innerHTML = '<h5 class="text-center">Retrieving Messages...</h5>';
        fetch('<?php echo base_url('selfservices/get_messages_api')?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id,groupId })
        })
        .then(response => response.json())
        .then(data => {
            console.log('data', data)
            let htmlContent = '';
            document.getElementById("groupId").value  = data['groupId'];
            let currentUrl = window.location.href;
            var urlWithoutParams = currentUrl.split('?')[0];
            currentUrl = urlWithoutParams + '?groupId='+data['groupId'];
            // window.history.pushState({ path: currentUrl }, '', currentUrl);
            window.location.href = currentUrl;
            // if (data['messages'].length > 0) {
            //     data['messages'].forEach(item => {
            //         var dateTimeParts = item.create_date.split(' ');
            //         var dateParts = dateTimeParts[0].split('-');
            //         var formattedDate = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0] + ' ' +dateTimeParts[1];
            //         htmlContent += 
            //         `
            //         <div class="container ${data['userId'] == item.sender_id? 'darker': ''} ">
            //             <img src="${base_url}assets_user/user_profile/${item.col_imag_path}" alt="Avatar" class="${data['userId'] == item.sender_id? 'right': ''}" style="width:100%;" onerror="setDefaultImage(this)">
            //             <p class="mb-1">${item.message}</p>
            //             <a href="${base_url}assets_user/files/selfservices/${item.attachment}" download>${item.attachment}</a>
            //             <span class="time-${data['userId'] == item.sender_id? 'left': 'right'}">${formattedDate}</span>
            //         </div>
            //         `;
            //     });
            //     messagesBody.innerHTML = htmlContent;
            // } else {
            //     // If data is empty, show a message
            //     htmlContent = '<h5 class="text-center">No Message</h5>';
            //     messagesBody.innerHTML = htmlContent;
            // }
        }).catch(error => console.error('Error:', error));
        toggleRefresh(true);
    }
</script>
<script>
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    messageInput.addEventListener('input', function() {
        const textValue = messageInput.value;
        let textLength = textValue.length;

        if (textLength > 100) {
            text = textValue.slice(0, 100);
            messageInput.value = text;
            textLength = text.length;
        }

        const numLines = Math.ceil(textLength/ 50); 
        messageInput.rows = numLines < 1 ? 1 : numLines; 

        const remainingCharacters = 100 - textLength;
        characterCount.textContent = remainingCharacters + " characters remaining";

        if (textLength > 0 && textLength <= 100) {
            sendButton.disabled = false;
        } else {
            sendButton.disabled = true;
        }
    });
</script>
<script>
    function sendMessage(){
        sendButton.disabled = true;
        sendButton.textContent = 'Sending...'
        const messageInputValue = messageInput.value;
        const attachment = document.getElementById('attachment').value;
        const groupId = document.getElementById('groupId').value;
        console.log('messageInput',messageInputValue);
        console.log('attachment',attachment);
        console.log('groupId',groupId);
        fetch('<?php echo base_url('selfservices/send_messages_api')?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ groupId, messageInputValue, attachment})
        })
        .then(response => response.json())
        .then(data => {
            console.log('data', data)
            messageInput.value = '';
            document.getElementById('attachment').value = '';
            var selectedFileParagraph = document.querySelector('.selected_file p');
            if (selectedFileParagraph !== null) {
                selectedFileParagraph.textContent = '';
            }
            let htmlContent = '';
            document.getElementById("groupId").value  = data['groupId'];
            if (data['messages'].length > 0) {
                data['messages'].forEach(item => {
                    var dateTimeParts = item.create_date.split(' ');
                    var dateParts = dateTimeParts[0].split('-');
                    var formattedDate = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0] + ' ' +dateTimeParts[1];
                    htmlContent += 
                    `
                    <div class="container ${data['userId'] == item.sender_id? 'darker': ''} ">
                        <img src="<?php echo base_url()?>assets_user/user_profile/${item.col_imag_path}" alt="Avatar" class="${data['userId'] == item.sender_id? 'right': ''}" style="width:100%;" onerror="setDefaultImage(this)">
                        <p class="mb-1">${item.message}</p>
                        <a href="<?=base_url()?>assets_user/files/selfservices/${item.attachment}"  download>${item.attachment}</a>
                        <span class="time-${data['userId'] == item.sender_id? 'left': 'right'}">${formattedDate}</span>
                    </div>
                    `;
                });
                messagesBody.innerHTML = htmlContent;
                sendButton.textContent = 'Send';
            } else {
                // If data is empty, show a message
                htmlContent = '<h5 class="text-center">No Message</h5>';
                messagesBody.innerHTML = htmlContent;
            }
        }).catch(error => {
            sendButton.textContent = 'Send';
            console.error('Error:', error)});
            toggleRefresh(true);
    }
</script>
<script>
    function reload() {
        location.reload();
    }
    function refresh(){
        window.location.href = base_url+'selfservices/my_messages';
    }
    function toggleRefresh(show){
        const search = checkSearchParams(window.location.href, 'search');
        const groupId = checkSearchParams(window.location.href, 'groupId');
        console.log('toggleRefresh search', search );
        console.log('toggleRefresh groupId', groupId );
        console.log('toggleRefresh show', show );
        if (show) {
            document.getElementById("refreshButton").classList.remove("d-none");
        } else {
            if (search == null && groupId == null) {
            document.getElementById("refreshButton").classList.add("d-none");
            }else{
                document.getElementById("refreshButton").classList.remove("d-none");
            }
        }

    }
    toggleRefresh(false);
</script>