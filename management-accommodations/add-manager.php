<style rel="stylesheet" type="text/css">
    #search_info{
        
    }
    #search_info .search_info{
    
    }
    #search_info .search_info label{
        padding-left: 1%;
    }
    #search_manager, 
    #find_manager_btn{
        padding: 1% 2%;
        border-radius: 12px;
        border: 1px solid lightblue;
    }
    
    #find_manager_btn{
        background-color: lightblue;
        margin-left: 1%;
        color: white;
        padding: 1% 3%;        
    }
    #results_manager_info{
        margin-top: 3%;
    }
    #results_manager_info .info_container{
        width: 100%;
        float: left;
    }
    #results_manager_info .info_container .info{
        width: 25%;
        float: left;
        margin-top: 2%;
    }
    #results_manager_info .action button{
        background-color: lightblue;
        padding: 1% 3%;
        border-radius: 12px;
        border: 1px solid lightblue;        
    }
</style>
<div id="manager_info">
    <div class="search_info">
        <h4>Use the form below to find the person you wish to add as a manger for this accommodations</h4><br>
        <label for="manager">Person's Ref Code: </label>
        <span class="err" id="err_manager_code"> * </span><br>
        <input type="text" id="search_manager" placeholder="Ref code">
        <button id="find_manager_btn" onclick="find_manager()">Find manager</button>
    </div>
    <div id="results_manager_info">
    </div>
</div>
<script type="text/javascript">
    function find_manager(){
        let ref = get_ref();
        if(ref != ""){
            let url = "./server/find-person.php?action=management&ref=" + ref;
            let loc = "#results_manager_info";
            send_data(url, displayer, loc, "", "", "#find_manager_btn")
        }
    }
    function get_ref(){
        let pattern = /\d{6}/;
        let ref = $("#search_manager").val();
        if(ref == ""){
            $("#err_manager_code").html("Ref code is required");
            return "";
        }else if(!ref.match(pattern)){
            $("#err_manager_code").html("Invalid ref code");
            return "";
        }else{
            $("#err_manager_code").html("");
            return ref;
        }
    }
    function add_as_manager_fn(user){
        let name = $("#full_name").html();
        let con = confirm("Are you sure you want to add " + name + " as one of the managers for this accommodation?");
        if(con == true){
            let url = "./server/find-person.php?action=add_as_manager&user=" + user;
            send_data(url, alert_action, "", "", "", "#add_as_manager")
        }
    }
    function alert_action(data, loc){
        alert(data);
    }
</script>