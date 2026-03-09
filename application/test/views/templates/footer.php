
<aside class="control-sidebar control-sidebar-dark">
</aside>
<div id="sidebar-overlay"></div>
<script>
    $('#sidebar-overlay').click(function(){
        $('.toggle_menu')[0].click();
    });
    
</script>
<script type="text/javascript">
    function activityWatcher(){
fetch("<?=base_url()?>superadministrators/get_time_out")
.then((res)=> res.json())
.then((res)=>{
    if(res['value']<=0){
        return;
    }
    //The number of seconds that have passed
    //since the user was active.
    var secondsSinceLastActivity = 0;

    //Five minutes. 60 x 5 = 300 seconds.
    var maxInactivity = (60)*res['value'];

    //Setup the setInterval method to run
    //every second. 1000 milliseconds = 1 second.
    const sessionInterval=setInterval(checkInactive,1000);

    function checkInactive(){
            secondsSinceLastActivity++;

        if(secondsSinceLastActivity >= maxInactivity){
            clearInterval(sessionInterval);
            alert_inactive()
        }
    }
    //The function that will be called whenever a user is active
    function activity(){
        //reset the secondsSinceLastActivity variable
        //back to 0
        secondsSinceLastActivity = 0;
    }

    //An array of DOM events that should be interpreted as
    //user activity.
    var activityEvents = [
        'mousedown', 'mousemove', 'keydown',
        'scroll', 'touchstart'
    ];

    //add these events to the document.
    //register the activity function as the listener parameter.
    activityEvents.forEach(function(eventName) {
        document.addEventListener(eventName, activity, true);
    });


})
.catch((err)=>{
})

}
function alert_inactive(){
    let timerInterval
    Swal.fire({
    title: 'You been inaactive for more than 5 minutes',
    html:
        'Logging out in <strong></strong> seconds.<br/><br/>'
        ,
    timer: 10000,
    didOpen: () => {
        const content = Swal.getHtmlContainer()
        const $ = content.querySelector.bind(content)
        Swal.showLoading()

        timerInterval = setInterval(() => {
        Swal.getHtmlContainer().querySelector('strong')
            .textContent = (Swal.getTimerLeft() / 1000)
            .toFixed(0)
        }, 100)
    },
    willClose: () => {
        clearInterval(timerInterval);
        if(Swal.getTimerLeft()<=0){
            
            window.location = '<?=base_url()?>login/session_expired';
           
        }else{ 
            activityWatcher();
        } 

    }
    })
}
activityWatcher();
</script>
<footer class="main-footer overflow-hidden p-2" style="width: 100%;">

</footer>
<style>
    .main-footer{
        position: fixed; 
        bottom: 0px;
        font-size: 14px;
    }
    @media (min-width: 1200px){
        body{
            margin-bottom: 40px;
        }
    }
    @media (max-width: 780px) {
        .main-footer{
           font-size: 10px;
           margin-bottom: 50px;
           position: relative;
        }
    }
</style>