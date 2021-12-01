<?php session_start();
    $accommodation = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
    if($accommodation == ""){
        if(isset($_SESSION['s_id']) && isset($_SESSION['s_user_type'])){
            if($_SESSION['s_user_type'] != "premium_user"){
                require_once '../access_denied.html';
                return;
            }
            $user_id = $_SESSION['s_id'];
            $sql = "SELECT id, name
                    FROM accommodations
                    WHERE manager=\"$user_id\" LIMIT 15";

            require("../includes/conn.inc.php");
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
            }else if($results->num_rows < 1){
                require_once 'accommodation-not-found.html';
                return;
            }
        }else{
            require_once '../offline.html';
            return;
        }
    }else{
        if(isset($_SESSION['s_id']) && isset($_SESSION['s_user_type'])){
            if($_SESSION['s_user_type'] != "premium_user"){
                require_once '../access_denied.html';
                return;
            }
        }else{
            require_once '../offline.html';
            return;
        }
    }


?>

<style type="text/css">
    #main_container{margin: auto 5%;}
    table input[type=number]{width: 100px;}
    #form{
        width: 100%;
        float: left;
        margin-bottom: 2%;
    }
    .my_images{
        float: left;
        width: 25%;
        height: 250px;
    }
    .my_images img{
        width: 95%;
        height: 80%;
    }
    .container{
        width: 50%;
        float: left;
    }
    .container select{
        width: 75%;
    }
    #add_features_submit {
        border: 1px solid lightblue;
        border-radius: 10px;
        padding: 3px 15px;
        background-color: lightblue;
    }
</style>
<div id="main_container" >
    <div id="form">
        <p style="color:red">
            <b>
                <i>
                    <u>NB!</u>
                </i>
                If you using this form not for the first time. Values entered previously will be replaced with these ones 
            </b>
        </p>
        <p><b>Select Available Features </b></p>
        <div class="container">
            <input type="checkbox" id="handicapped"> Handicapped friently<br>
            <input type="checkbox" id="washing_line"> Washing Line<br>
            <input type="checkbox" id="security"> Security 24/7<br>
            <input type="checkbox" id="cctv"> CCTV<br>
            <input type="checkbox" id="biometric"> Biometric Access Control<br>
            <input type="checkbox" id="shops"> Shops<br>
            <input type="checkbox" id="bar"> Bar<br>
            <input type="checkbox" id="study_area"> Study Area<br>
            <input type="checkbox" id="recreational"> Recreational/ Entertainment Area<br>
            <input type="checkbox" id="games_room"> Games Room<br>
            <input type="checkbox" id="playstation"> Playstation TV<br>
            <input type="checkbox" id="cinema"> Cinema room<br>
            <input type="checkbox" id="soccer"> Soccer Team<br>
            <input type="checkbox" id="netball"> Netball team<br>
            <input type="checkbox" id="sports"> Sports fields<br>
            <input type="checkbox" id="first_aid"> First Aid Kit provided<br>
            <input type="checkbox" id="beds"> Comfortable Beds<br>
            <input type="checkbox" id="pool"> Swimming pool<br>
            <input type="checkbox" id="furnished"> Fully Furnished<br>
        </div>
        <div class="container">
            <table>
                <tr>			
                    <td>Wifi:</td>
                    <td>
                        <select id="wifi">
                            <option value="select">--Select--</option>
                            <option value="1">Free Uncapped WiFi</option>
                            <option value="2">Uncapped WiFi</option>
                            <option value="0">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Transport:</td>
                    <td>
                        <select id="transport">
                            <option value="select">--Select--</option>
                            <option value="1">Free Transport</option>
                            <option value="2">Paid Trasport</option>
                            <option value="0">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Computer Facilities:</td>
                    <td>
                        <select id="computer">
                            <option value="select">--Select--</option>
                            <option value="1">Free Computers</option>
                            <option value="2">Paid Computers</option>
                            <option value="0">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Laundry Facilities:</td>
                    <td>
                        <select id="laundry">
                            <option value="select">--Select--</option>
                            <option value="1">Free</option>
                            <option value="2">Paid</option>
                            <option value="0">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Electricity:</td>
                    <td>
                        <select id="electricity">
                            <option value="select">--Select--</option>
                            <option value="1">Free</option>
                            <option value="2">Prepaid</option>
                            <option value="0">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Gym:</td>
                    <td>
                        <select id="gym">
                            <option value="select">--Select--</option>
                            <option value="1">Free indoor gym</option>
                            <option value="2">Free outdoor gym</option>
                            <option value="3">Indoor gym</option>
                            <option value="4">Outdoor gym</option>
                            <option value="0">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Parking:</td>
                    <td>
                        <select id="parking">
                            <option value="select">--Select--</option>
                            <option value="1">Free</option>
                            <option value="2">Paid</option>
                            <option value="0">N/A</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Room type:</td>
                    <td>
                        <select id="room">
                            <option value="select">--Select--</option>
                            <option value="1">1 Persons Room</option>
                            <option value="2">1/2 Persons Rooms</option>
                            <option value="3">1/2/3+ Persons Room</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Kitchen type:</td>
                    <td>
                        <select id="kitchen">
                            <option value="select">--Select--</option>
                            <option value="1">Inroom/Own kitchen</option>
                            <option value="2">Commune Sharing</option>
                            <option value="3">Floor Sharing</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>Bathroom type:</td>
                    <td>
                        <select id="bathroom">
                            <option value="select">--Select--</option>
                            <option value="1">Inroom/Own kitchen</option>
                            <option value="2">Commune Sharing</option>
                            <option value="3">Floor Sharing</option>
                        </select>
                    </td>
                </tr>
                <tr>			
                    <td>TV:</td>
                    <td>
                        <select id="tv">
                            <option value="select">--Select--</option>
                            <option value="1">inroom/own DSTV </option>
                            <option value="2">Commune Sharing DSTV</option>
                            <option value="3">Floor Sharing DSTV</option>
                            <option value="0">None</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>	
    <span id="err_add_features" class="err"></span><br>
    <button id="add_features_submit" onclick="update()">Update changes</button>
</div>
<div id="mc"></div>
<div id="the_footer" ></div>
<script type="text/javascript">
    function update(){
        var handicapped = chkd($('#handicapped'));
        var washing_line = chkd($('#washing_line'));
        var security = chkd($('#security'));
        var cctv = chkd($('#cctv'));
        var biometric = chkd($('#biometric'));
        var shops = chkd($('#shops'));
        var bar = chkd($('#bar'));
        var study_area = chkd($('#study_area'));
        var recreational = chkd($('#recreational'));
        var games_room = chkd($('#games_room'));
        var playstation = chkd($('#playstation'));
        var cinema = chkd($('#cinema'));
        var soccer = chkd($('#soccer'));
        var netball = chkd($('#netball'));
        var sports = chkd($('#sports'));
        var first_aid = chkd($('#first_aid'));
        var beds = chkd($('#beds'));
        var pool = chkd($('#pool'));
        var furnished = chkd($('#furnished'));
        var wifi = selectx($('#wifi'));
        var transport = selectx($('#transport'));
        var computer = selectx($('#computer'));
        var laundry = selectx($('#laundry'));
        var electricity = selectx($('#electricity'));
        var gym = selectx($('#gym'));
        var parking = selectx($('#parking'));
        var room = selectx($('#room'));
        var kitchen = selectx($('#kitchen'));
        var bathroom = selectx($('#bathroom'));
        var tv = selectx($('#tv'));
        let payload = $('#payload').val();

        if(!wifi || !transport || !computer || !laundry || !electricity || !gym || !parking ||
            !room || !kitchen || !bathroom || !tv) {
            $("#err_add_features").html("Fix errors on select boxes at top right in red boxes");
                return;
        }
        var data = "payload=" + payload + "&handicapped=" + handicapped + "&washing_line=" + 
                    washing_line + "&security=" + security + "&cctv=" + cctv + "&biometric=" + 
                    biometric + "&shops=" + shops + "&bar=" + bar + "&study_area=" + study_area +
                    "&recreational=" + recreational + "&games_room=" + games_room + "&playstation=" + 
                    playstation + "&cinema=" + cinema + "&soccer=" + soccer + "&netball=" + netball + 
                    "&sports=" + sports + "&first_aid=" + first_aid + "&beds=" + beds + "&pool=" + 
                    pool + "&wifi=" + wifi + "&transport=" + transport + "&computer=" + computer + 
                    "&laundry=" + laundry + "&electricity=" + electricity + "&gym=" + gym + 
                    "&parking=" + parking + "&room=" + room + "&kitchen=" + kitchen + "&bathroom=" + 
                    bathroom + "&tv=" + tv + "&furnished=" + furnished; 
        let url = "./management-accommodations/server/add-features.inc.php?" + data;
        let loc = "#err_add_features";
        let btn = "#add_features_submit";
        send_data(url, displayer, loc, "", "", btn);
    }
    function check_temp(name_val, err_msg, patten){
        if(!name_val == ""){
            if(!name_val.match(patten)){
                err_msg.html("Invalid use of special characters");
                return "";
            }else{ 
                err_msg.html("");
                return name_val;
            }
        }	
        err_msg.html("");
        return "";
    }
    function chkd(x) {
        return (x.is(':checked')) ? 1 : "";
    }
    function selectx(x) {
        if(x.val() == "" || x.val().length != 1 || x.val() == "select") {
            x.css({'border' : '1px solid red'}); 
            return "";
        }else {
            x.css({'border' : '1px solid rgb(150, 150, 150)'}); 
            return x.val();
        }
    }
</script>
