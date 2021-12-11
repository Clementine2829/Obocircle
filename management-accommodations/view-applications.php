<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_SESSION['s_id']) || isset($_SESSION['s_user_type'])){
            if($_SESSION['s_user_type'] != "premium_user"){
                require_once '../access_denied.html';
                return;
            }
            $user_id = $_SESSION['s_id'];
            require("../includes/conn.inc.php");
            $accommodation = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
            if($accommodation == ""){
                $sql = "SELECT id, name
                        FROM accommodations
                        WHERE manager=\"$user_id\" LIMIT 15";

                $sql_results = new SQL_results();
                $results = $sql_results->results_accommodations($sql);
                $div = "";
                if($results->num_rows > 1){
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
                }else if($results->num_rows == 1){
                    $row = $results->fetch_assoc();
                    $accommodation = $row['id'];    
                }else if($results->num_rows < 1){
                    require_once 'accommodation-not-found.html';
                    return;
                }
            }
            ?>
            <style rel="stylesheet" type="text/css">
                #application_head{
                    width: 100%;
                    float: left;
                }
                #application_head .sub_head{
                    width: 50%;
                    float: left;
                }
                #application_head .sub_head p,
                #application_head .sub_head .radio_btn{
                    width: 100%;
                    float: left;
                }
                #application_head .sub_head:nth-child(2){
                    text-align: right;
                    padding-right: 0%;
                    margin-top: 5%;
                }
                #results{
                    width: 100%;
                    float: left;            
                }
                #results table{
                    width: 100%;
                    float: left;
                    border-collapse: collapse;
                    background-color: rgb(230, 230, 230);
                }
                #results table tr{
                    border-collapse: collapse;
                }
                #results table tr:hover{
                    background-color: rgb(200, 200, 200);
                }
                #results table tr th{
                    background-color: lightgray;   
                    padding: 7px 15px;
                    border-right: 1px solid white;
                }
                #results table tr th:nth-child(1),
                #results table tr th:nth-child(2){
                    border-right: none;
                }
                #results table tr td:nth-child(1),
                #results table tr td:nth-child(2),
                #results table tr td:nth-child(4),
                #results table tr td:nth-child(6),
                #results table tr th:nth-child(10),
                #results table tr th:nth-child(8),
                #results table tr td:nth-child(7),
                #results table tr td:nth-child(9),
                #results table tr td:nth-child(10){
                   text-align: center;
                }
                #results table colgroup col:nth-child(1),
                #results table colgroup col:nth-child(2) {
                    width: 3%;
                }
                #results table colgroup col:nth-child(3) {
                    width: 25%;
                }
                #results table colgroup col:nth-child(4),
                #results table colgroup col:nth-child(5),
                #results table colgroup col:nth-child(8) {
                    width: auto;
                }
                #results table colgroup col:nth-child(8) {
                    max-width: 25%;
                }
                #results table colgroup col:nth-child(6),
                #results table colgroup col:nth-child(7) {
                    width: 10%;
                }
                #results table colgroup col:nth-child(10) {
                    width: 15%;
                }
                #action button {
                    border: none;
                    padding: 3px 15px;
                    border-radius: 7px;
                    margin-top: 3%;
                }
            </style>
            <div id="application_head">
                <div class="sub_head">
                    <div class="radio_btns">
                        <input type="radio" name="results" value="pending" id="other_results" checked> <strong>Other applications<br></strong>
                        <input type="radio" name="results" value="accepted" id="new_results"> <strong>Accepted applications</strong>
                    </div>
                </div>
                <div class="sub_head" style="text-aligh: right">
                    <span><strong>Sort:</strong></span>
                    <select id="sort_results">
                        <option value="">Default</option>
                        <option value="name">Name</option>
                        <option value="payment">Payment Method</option>
                        <option value="room">Room Type</option>
                    </select>
                </div>
            </div>
            <div id="results" ></div>

            <script type="text/javascript">
                $(document).ready(function(){
                    load_data();
                    $("#results table tr td:nth-child(1) :checkbox").click(function(){
                        alert('clicked');
        //				disable_btns();
                    });
                    $("#application_head .sub_head .radio_btns :radio").click(function(){show_students();})
                });

                function get_data(){
                    let sort = $('#sort').val();
                    let sort_by = $('#sort_b').val();
                    load_data(sort, sort_by);	
                }
                function load_data(sort="", sort_by="", apps_type="") {
                    let payload = $('#payload').val();
                    let url = "./management-accommodations/server/applicants-inc.php?payload=" + payload + "&sort=" + sort + "&sort_by=" + sort_by + "&apps_type=" + apps_type;
                    let loc = '#results';
                    send_data(url, displayer_helper, loc);
                }
                function displayer_helper(data, loc){
                    $(loc).html(data);
                    select_all();
                }
                function disable_check(){
                    //check if all checkbox are checked then change btn value and vice versa 
                    $('#action button:nth-child(2)').prop("disabled", true);			
                    $('#action button:nth-child(3)').prop("disabled", true);			
                    var counter = document.getElementsByClassName('s_all');
                    for(let i = 0; i < counter.length; i++){
                        if(document.getElementsByClassName('s_all')[i].checked){
                            $('#action button:nth-child(2)').prop("disabled", false);			
                            $('#action button:nth-child(3)').prop("disabled", false);								
                            break;
                        }
                    }
                    for(let i = 0; i < counter.length; i++){
                        //if there is one that is not check, change btn value to check all and break
                        if(!document.getElementsByClassName('s_all')[i].checked){
                            $('#action button:nth-child(1)').html("Select All");
                            return;
                        }
                    }
                    $('#action button:nth-child(1)').html("Unselect All");
                }
                function select_all(){
                    if($('#action button:nth-child(1)').html() != "Unselect All"){
                        $('table tr td :checkbox').each(function(){
                            $('table tr td :checkbox').prop('checked', true);
                        })
                        $('#action button:nth-child(1)').html("Unselect All");
                    }else{
                        $('table tr td :checkbox').each(function(){
                            $('table tr td :checkbox').prop('checked', false);
                        })
                        $('#action button:nth-child(1)').html("Select All");				
                    }
                }
                function accept_application(){
        //			alert("Page still under construction"); return;
        //			alert('An email has been sent to all those applicants their results were successful');
                    //get all the ids of people selected and send them through

                    var counter = document.getElementsByClassName('s_all');
                    let apps = "";
                    for(let i = 0; i < counter.length; i++){
                        if(document.getElementsByClassName('s_all')[i].checked){
                            apps += document.getElementsByClassName('_applicants')[i].value + ",";
                        }
                    }
                    if(apps){
                        let payload = $('#payload').html();
                        let url = "./accepted-results.php?payload=" + payload + "&data=" + apps.substr(0, apps.length - 1);
                        let xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (this.readyState > 0 && this.readyState < 4) {
                                $('#action button:nth-child(2)').html("Loading..")
                                $('#action button').prop('disabled', true);
                            }
                            if (this.readyState == 4 && this.status == 200){
                                $('#action button').prop('disabled', false);
                                $('#action button:nth-child(2)').html("Accept");
                                $('#clement').html(this.responseText);
                                if(this.responseText == ""){	
        /*							for(let i = 0; i < counter.length; i++){
                                        if(document.getElementsByClassName('s_all')[i].checked){
                                            document.getElementByTagName('tr')[i].style.display = "false";
                                        }
                                    }
        */							alert("Data accepted successfully.");
                                    $('#show_students button').html('Show new results');
                                    load_data("", "", "accepted");
                                    //more details, either them that you send each individual emals letting them know 
                                    //and let them know where to find the new data of the individuas, 
                                    //either a new page where they will find the accepted client or send the data to their database
                                    //for them to work it on their own    
                                }else{
                                    //error occured 
                                }
                            }
                        };
                        xhttp.open("POST", url, true);
                        xhttp.send();				
                    }
                }
                function decline_application(){
                    let con = confirm("Are you sure you want to decline the results selected?");
                    if(con){
                        let message = "Do you want to want to send them personalised email regarding the reasons for declining their results?";
                        message += "\nNB: An automated email will be send either way to let them know of their results' status";
                        con = confirm(message);
                        let auto_mail = true;
                        if(con){
                            auto_mail = false;
                            while(true){
                                let msg = prompt("Please type your short message here", "");
                                if(msg != null){
                                    con = confirm("Your message:\n" + msg + "\nClick Ok to continue or cancel to reenter new message");
                                    if(con) break;
                                    else message = msg;
                                }else{
                                    message = "";
                                }
                            }
                        }else{
                            message = "";
                        }
                        //send data now with the message along 
                        alert("Button functionality still under construction\nSorry!");
                    }
                }

                function show_students(){
                    //switch between showing new results and accepted results
                    //use the same page to display the results i.e. this function load_data(sort="", sort_by="", type="new")
                    //for us type agr is "accepted"
                    if($("#new_results").is(":checked")){
                        load_data("", "", "accepted");
                    }else{
                        load_data("", "", "");
                    }

                }
            </script>
        <?php  
        }
    }else{
        echo "<p style='color: red'>Unkown request</p>";
        return;
    }
?>