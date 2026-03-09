<script src="">
    fetch("https://dev-env.eyebox.app/methodapi/get_employee_info?id=2").then((res)=>res.json()).then((response)=>{
        console.log(response);
    })
</script>