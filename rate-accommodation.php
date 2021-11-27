<?php session_start(); ?>
<style type="text/css">
input[type=number], select{
    width: 65%;
    border-radius: 10px;
    padding: 2px 10px;
    border: 1px solid lightblue;
    outline: none;
}
#rate_us{
    border:1px solid gray;
    border-radius: 7px;
    background-color: lightgray;
    padding: 15px 1px;
    margin: auto 1%;
    width: 50%;
}
#rate_us button{
    margin-left: 6%;
    margin-top: 5%;
    background-color: lightblue;
    border-radius: 5px;
    border:2px solid gray;
}	
#display_rating {
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,.9);
    padding-top: 60px;
}
#rate_us {
    background-color: #fefefe;
    margin: 2% auto 15% auto;
    border: 1px solid #888;
    width: 80%;
}
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
    color: red;
}
#my_table col:nth-child(1){
    width: 65%;
}
#my_table col:nth-child(2){
    width: 40%;
}
#my_table tr td{
    padding-left: 2%;
}

@media only screen and (max-width: 800px){
#display_rating {
    margin: 5% auto 15% 4%;
    padding: 5px 15px 15px 5px;
    width: 90%;
}
#my_table tr td:first-child{padding-right: 10px;}
}
</style>
<div id="rate_us">
    <p style="text-align:center; font-weight: bold">
        <span id="rate_msg_success" style="color:blue"></span>
        <span id="rate_msg_err" style="color:red"></span>
    </p>
    <span onclick="close_rating()" 
        class="close" title="Close Modal">&times;</span>
    <?php 
        if(!isset($_SESSION['s_id']) || !isset($_SESSION['s_email'])){
            echo "<div style='margin-left: 5%'>";
                require_once "./offline.html";
            echo "</div>";
            return;
        }else if(!isset($_SESSION['s_profile_status']) || 
                (isset($_SESSION['s_profile_status']) && $_SESSION['s_profile_status'] != "1")){
            echo "<div style='margin-left: 5%'>";
                require_once "./access_denied.html";
            echo "</div>";
            return;
        }
    ?>
    <table id="my_table">
        <colgroup>
            <col span="1">
            <col span="1">
        </colgroup>
        <tbody>
            <tr>
                <td style="float:right">
                    Overrall accommodation ratings :
                </td>
                <td>
                    <div id="u_ratings">
                        <span class="fas fa-star" ></span>
                        <span class="fas fa-star" ></span>
                        <span class="fas fa-star" ></span>
                        <span class="fas fa-star" ></span>
                        <span class="fas fa-star" ></span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="text-align:right">
                        <b>Location:</b>  
                        <br>i.e. safety, distance to/from campus and shops, sorroundings, atc <br>
                    </div>
                </td>
                <td>
                    <div>
                        <select id="rate_location">
                            <option value="select">--Select--</option>
                            <option value="5">Very satisfing</option>
                            <option value="4">Satisfing</option>
                            <option value="3">Fair/Fine</option>
                            <option value="2">Poor</option>
                            <option value="1">Very Poor</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td >
                    <div style="text-align:right">
                        <b>Services:</b> 
                        <br>i.e. Transportation, security, Parking, atc <br>
                    </div>						
                </td>
                <td>
                    <div>
                        <select id="rate_services">  
                            <option value="select">--Select--</option>
                            <option value="5">Very Good</option>
                            <option value="4">Good</option>
                            <option value="3">Ok/Fine</option>
                            <option value="2">Poor</option>
                            <option value="1">Very poor</option>
                        </select>
                    </div>

                </td>
            </tr>
            <tr>
                <td>
                    <div style="text-align:right">
                        <b>Rooms:</b> 
                        <br>i.e. Cleanliness, wifi, furniture, atc<br> 
                    </div>
                </td>
                <td>
                    <div>
                        <select id="rate_rooms">
                            <option value="select">--Select--</option>
                            <option value="5">Very Good</option>
                            <option value="4">Good</option>
                            <option value="3">Ok/Fine</option>
                            <option value="2">Poor</option>
                            <option value="1">Very poor</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="text-align:right">
                        <b>Stuff:</b> 
                        <br>i.e. Friendliness, communnication skills, atc<br> 
                    </div>
                </td>
                <td>
                    <div>
                        <select id="rate_stuff">
                            <option value="select">--Select--</option>
                            <option value="5">Very Good</option>
                            <option value="4">Good</option>
                            <option value="3">Ok/Fine</option>
                            <option value="2">Poor</option>
                            <option value="1">Very poor</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="text-align:right">
                        how likely would you be to recommend this accommodation<br>
                        to a friend or a colleague?<br>
                        <span style="color:red">
                            <b>
                                Enter scale of 0 - 10. <br>
                                0-very unlikely<br>
                                10-very likely
                            </b>
                        </span>
                    </div>
                </td>
                <td>
                    <input type="number" id="recommend" max="10" min="0">
                </td>
            </tr>
        </tbody>
    </table>
    <button class="btns_rates" onclick="star_ratings()">Submit results</button>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#u_ratings span").each(function(){
			$(this).click(function() {
				var $this = $(this);
				clicked = $("#u_ratings span").index($this) + 1;
				$this.prop("checked", true);
				//alert($("#u_ratings span").index($this) + 1);
				unchecked_n($("#u_ratings span").index($this) + 1);
				checked_n($("#u_ratings span").index($this) + 1);
			});
		});
	});
</script>
