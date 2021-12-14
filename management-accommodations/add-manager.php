<?php session_start();

$accommodation_name = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){    
    if(isset($_SESSION['s_id']) || isset($_SESSION['s_user_type'])){
        if($_SESSION['s_user_type'] != "premium_user"){
            require_once '../access_denied.html';
            return;
        }
        $user_id = $_SESSION['s_id'];
        require("../includes/conn.inc.php");
        $sql = "SELECT id, name
                FROM accommodations
                WHERE manager=\"$user_id\"";
        $accommodation = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
        if($accommodation != ""){
            $sql .= " AND (id = \"$accommodation\")";
        }
        $sql .= " LIMIT 15";
        $sql_results = new SQL_results();
        $results = $sql_results->results_accommodations($sql);
        $div = "";
        if($results->num_rows == 1){
            $row = $results->fetch_assoc();
            $accommodation_name = $row['name'];    
        }else if($results->num_rows > 1){
            while($row = $results->fetch_assoc()){
                $div .= '<br><li><a href="./dashboard.php?payload='. $row['id'] . '">'. $row['name'] . '</a></li>';
            }
            ?>
                <div id="select_accommodations">
                    <br>
                    <h5>Select an accommodation to manage below</h5>
                    <ul>
                        <?php echo $div; ?>
                    </ul>
                </div>
            <?php
            return;
        }else if($results->num_rows < 1){
            require_once 'accommodation-not-found.html';
            return;
        }
    }else {
        require_once '../offline.html';
        return;
    }
}else{
    echo "<span style='color: red'>Unknow request</span>";
    return;
}
?>
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
        <h4>
            Use the form below to find the person you wish to add as a manger for this accommodations 
            <span id="accommodation_name"><?php echo $accommodation_name; ?> </span></h4><br>
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
        $("#results_manager_info").html("");
        if(ref != ""){
            let url = "./server/find-person.php?action=management&ref=" + ref;
            let loc = "#results_manager_info";
            console.log(url);
            send_data(url, displayer, loc, "", "", "#find_manager_btn");
        }
    }
    function get_ref(){
        let pattern = /\d/;
        let ref = $("#search_manager").val();
        if(ref == ""){
            $("#err_manager_code").html("Ref code is required");
            return "";
        }else if(!ref.match(pattern) || ref.length != 6){
            $("#err_manager_code").html("Invalid ref code");
            return "";
        }else{
            $("#err_manager_code").html("");
            return ref;
        }
    }
    function add_as_manager_fn(user){
        let payload = $("#payload").val();
        let name = $("#full_name").html();
        let a_name = " " + $("#accommodation_name").html();
        let con = confirm("Are you sure you want to add " + name + " as one of the managers for this accommodation" + a_name + "?");
        if(con == true){
            let url = "./management-accommodations/server/add-manager.inc.php?user=" + user + "&payload=" + payload;
            send_data(url, alert_action, "", "", "", "#add_as_manager")
        }
    }
    function alert_action(data, loc){
        $("#results_manager_info").html(data);
    }
</script>