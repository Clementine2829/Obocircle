<?php session_start();
    $accommodation = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";

    if($accommodation == ""){
        require_once './select-accommodation.php';
        return;
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
<link rel="stylesheet" type="text/css" href="./management-accommodations/css/style-main-page.css">
<div id="main_page">
<div class="sub">
    <h4>Web Gate Residence</h4>
    <div class="address">
        <p>
            105 Smith Ave<br>
            Dobsonville<br>
            Soweto<br>
            Johannebsurg 2525  
        </p>
    </div>
</div>
<div class="sub">
    <label for="nsfas" style="background-color: orange;padding: 3px;margin: 4px 4px 4px auto;">NSFAS ACCREDIED ??</label>
    <select id="nsfas"> 
        <option value="1">Yes</option>
        <option value="0">No</option>
    </select>
    <table>
        <optgroup>
            <col span="1">
            <col span="1">
            <col span="1">
            <col span="1">
        </optgroup>
        <tbody>
            <tr>
                <th>Room type </th>
                <th>Cash Prices</th>
                <th>Bursary Prices</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><span class="fas fa-user"></span> Single:</td>
                <td>R:<input type="number" id="single_c" value="6550.25" placeholder="0.00"></td>
                <td>R:<input type="number" id="single_b" value="7500.95" placeholder="0.00"></td>
                <td>
                    <select id="single_a">
                        <option value="1">Available</option>
                        <option value="0">Full</option>
                        <option value="-1">N/A</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="fas fa-user-friends"></span> Double:</td>
                <td>R:<input type="number" id="double_c" value="4000.00" placeholder="0.00" ></td>
                <td>R:<input type="number" id="double_b" value="5200.99" placeholder="0.00"></td>
                <td>
                    <select id="double_a">	
                        <option value="1">Available</option>
                        <option value="0">Full</option>
                        <option value="-1">N/A</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="fas fa-users"></span> Multi-sharing:</td>
                <td>R:<input type="number" id="three_c" value="3500.35" placeholder="0.00"></td>
                <td>R:<input type="number" id="three_b" value="4000.25" placeholder="0.00" ></td>
                <td>
                    <select id="three_a">
                        <option value="1">Available</option>
                        <option value="0">Full</option>
                        <option value="-1">N/A</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <label for="telephone">Telephone number</label>
    <span class="err" id="err_telephone"> * </span><br>
    <input type="number" onblur="get_telephone()" id='telephone'>
    <br>
    <label for="website">
        Website link(Optional) <span style="color: gray; font-style: italic">E.g. https://obocircle.com/</span>
    </label>
    <span class="err" id="err_website"></span><br>
    <input type="text" id='website' placeholder="Your website URL"><br><br>
    <span id="err_update_main_page" class="err"></span>
    <input type="button" id="update_main_page" value="Update Changes">
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#update_main_page").click(function(){update_changes();})
    })
    function update_changes(){
        let telephone = get_telephone();
        let website = get_website();

        let nsfas = $('#nsfas').val();
        let single_c = $('#single_c').val();
        let single_b = $('#single_b').val();
        let double_c = $('#double_c').val();
        let double_b = $('#double_b').val();
        let three_c = $('#three_c').val();
        let three_b = $('#three_b').val();
        
        if(telephone != ""){
            
        }
        let con;
        let payload = $('#my_room').html();
        let pattern = /^[a-zA-Z0-9]*$/;
        if(!payload.match(pattern) || payload == "") return;
        if(single_c == "" || single_b == "" ||
            double_c == "" || double_b == "" ||
            three_c == "" || three_b == "" ||
            single_a == "" || double_a == "" || three_a == "" || tell == "" ||  website == "")
            con = confirm("Some fields were left empty. Confirm to proceed with changes.");
        else con = confirm("Confirm to proceed with changes."); 
        if(con){   
            data = "payload=" + payload + "&single_c=" + single_c + "&single_b=" + single_b +
                    "&double_c=" + double_c + "&double_b=" + double_b +
                    "&three_c=" + three_c + "&three_b=" + three_b +
                    "&single_a=" + single_a + "&double_a=" + double_a + 
                    "&three_a=" + three_a + "&nsfas=" + nsfas + "&tell=" + tell + "&website=" + website;
            let url = "./server/management.inc.php?action=update_main&" + data;
            let loc = "#err_update_main_page";
            let btn = "#update_main_page";
            send_data(url, displayer, loc, " ", " ", btn);   
        }
    }
    function get_telephone(){
        let tell = $('#telephone').val();
        if(tell != ""){
            let pattern = /\d{10}/;
            if(!tell.match(pattern) || tell.length != 10){
                $('#err_telephone').html("Invalid phone number");
                return tell;
            }else{
                $('#err_telephone').html(" * ");
            }
        }else $('#err_telephone').html(" * ");                                
        return "";
    }
    function get_website(){
        let website = $('#website').val();
        if(website != ""){
//                                  let pattern = "/(http|https)+(://)+(wwww)?+[a-zA-Z0-9\-\.]/";
            let pattern = "/^[a-zA-Z0-9\-\.\:\/]+$/";
            if(!website.match(pattern)){
                $('#err_website').html("Invalid website format, refer to the e.g given above");
                return "";
            }else{
                $('#err_website').html("");
                return website;
            } 
        }else $('#err_website').html("");                                
        return "";
    }
</script>
</div>
