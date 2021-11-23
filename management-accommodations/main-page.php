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
                echo '<p style="color: red"><strong><br>No accommodation found</strong><br>
                        If you belive this is an errro, please contact us at support@obocircle.com</p>';
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

    /*********************************** body *************************************/
    
    $user_id = $_SESSION['s_id'];
    $sql = "SELECT accommodations.name, accommodations.nsfas,
                    address.main_address, address.contact, 
                    rooms.room_id,rooms.single_sharing,rooms.double_sharing,rooms.multi_sharing
            FROM ((accommodations
                INNER JOIN address ON accommodations.id = address.accommo_id)
                INNER JOIN rooms ON accommodations.id = rooms.accommo_id)
            WHERE accommodations.id=\"$accommodation\" AND accommodations.manager=\"$user_id\" LIMIT 1";

    //echo "SQL: " . $sql;
    require("../includes/conn.inc.php");
    $sql_results = new SQL_results();
    $results = $sql_results->results_accommodations($sql);
    $name = $nsfas = $address = $room_id = $s_sharing = $d_sharing = $m_sharing = $website = $phone = "";
    $single_cash = $single_bursary = "";
    $double_cash = $double_bursary = "";
    $multi_cash = $multi_bursary = "";

    if($results->num_rows > 0){
        $data = $results->fetch_assoc();
        $name = $data['name'];
        $nsfas = $data['nsfas'];
        $address = $data['main_address'];
        $phone = $data['contact'];
        $room_id = $data['room_id'];
        $s_sharing = $data['single_sharing'];
        $d_sharing = $data['double_sharing'];
        $m_sharing = $data['multi_sharing'];
    
        /****** get website*/ 
        $sql = "SELECT website
                FROM websites
                WHERE accommo_id=\"$accommodation\" LIMIT 1";
        //echo "SQL: " . $sql;
        $results = $sql_results->results_accommodations($sql);
        if($results->num_rows > 0){
            $data = $results->fetch_assoc();
            $website = $data['website'];
        }

        /****** get single room*/ 
        $sql = "SELECT cash, bursary
                FROM single_s
                WHERE room_id=\"$room_id\" LIMIT 1";
        //echo "SQL: " . $sql;
        $results = $sql_results->results_accommodations($sql);
        if($results->num_rows > 0){
            $data = $results->fetch_assoc();
            $single_cash = price_format($data['cash']);
            $single_bursary = price_format($data['bursary']);
        }
        /****** get double room*/ 
        $sql = "SELECT cash, bursary
                FROM double_s
                WHERE room_id=\"$room_id\" LIMIT 1";
        //echo "SQL: " . $sql;
        $results = $sql_results->results_accommodations($sql);
        if($results->num_rows > 0){
            $data = $results->fetch_assoc();
            $double_cash = price_format($data['cash']);
            $double_bursary = price_format($data['bursary']);
        }
        /****** get single room*/ 
        $sql = "SELECT cash, bursary
                FROM multi_s
                WHERE room_id=\"$room_id\" LIMIT 1";
        //echo "SQL: " . $sql;
        $results = $sql_results->results_accommodations($sql);
        if($results->num_rows > 0){
            $data = $results->fetch_assoc();
            $multi_cash = price_format($data['cash']);
            $multi_bursary = price_format($data['bursary']);
        }
    }else{
        echo '<p style="color: red"><strong><br>No accommodation found</strong><br>
                If you belive this is an errro, please contact us at support@obocircle.com</p>';
        return;
    }
	function price_format($x){
		return number_format( sprintf( "%.2f", ($x)), 2, '.', '' );
	}
?>
<link rel="stylesheet" type="text/css" href="./management-accommodations/css/style-main-page.css">
<div id="main_page">
<div class="sub">
    <h4><?php echo $name; ?></h4>
    <div class="address">
        <?php
            //check if is google maps addres or not
            $address = ($address != "") ? str_replace(",", "<br>", $address) : $address;             
            echo "<p>" . $address . "</p>";
        ?>

    </div>
</div>
<div class="sub">
    <label for="nsfas" style="background-color: orange;padding: 3px;margin: 4px 4px 4px auto;">NSFAS ACCREDIED ??</label>
    <select id="nsfas"> 
        <?php
            echo '<option value="1" ' . (($nsfas == 1) ? "selected" : "") . '>Yes</option>';
            echo '<option value="0"' . (($nsfas == 0) ? "selected" : "") . '>No</option>';
        ?>
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
                <td>R:<input type="number" id="single_c" value="<?php echo $single_cash; ?>" onblur="format_amouts('#single_c')" placeholder="0.00"></td>
                <td>R:<input type="number" id="single_b" value="<?php echo $single_bursary; ?>" onblur="format_amouts('#single_b')" placeholder="0.00"></td>
                <td>
                    <select id="single_a">
                        <?php
                            echo '<option value="1" ' . (($s_sharing == 1) ? "selected" : "") . '>Available</option>';
                            echo '<option value="0" ' . (($s_sharing == 0) ? "selected" : "") . '>Full</option>';
                            echo '<option value="-1" ' . (($s_sharing == -1) ? "selected" : "") . '>N/A</option>';
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="fas fa-user-friends"></span> Double:</td>
                <td>R:<input type="number" id="double_c" value="<?php echo $double_cash; ?>" onblur="format_amouts('#double_c')" placeholder="0.00" ></td>
                <td>R:<input type="number" id="double_b" value="<?php echo $double_bursary; ?>" onblur="format_amouts('#double_b')" placeholder="0.00"></td>
                <td>
                    <select id="double_a">	
                        <?php
                            echo '<option value="1" ' . (($d_sharing == 1) ? "selected" : "") . '>Available</option>';
                            echo '<option value="0" ' . (($d_sharing == 0) ? "selected" : "") . '>Full</option>';
                            echo '<option value="-1" ' . (($d_sharing == -1) ? "selected" : "") . '>N/A</option>';
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span class="fas fa-users"></span> Multi-sharing:</td>
                <td>R:<input type="number" id="multi_c" value="<?php echo $multi_cash; ?>" onblur="format_amouts('#multi_c')" placeholder="0.00"></td>
                <td>R:<input type="number" id="multi_b" value="<?php echo $multi_bursary; ?>" onblur="format_amouts('#multi_b')" placeholder="0.00" ></td>
                <td>
                    <select id="multi_a">
                        <?php
                            echo '<option value="1" ' . (($m_sharing == 1) ? "selected" : "") . '>Available</option>';
                            echo '<option value="0" ' . (($m_sharing == 0) ? "selected" : "") . '>Full</option>';
                            echo '<option value="-1" ' . (($m_sharing == -1) ? "selected" : "") . '>N/A</option>';
                        ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <label for="telephone">Telephone number</label>
    <span class="err" id="err_telephone"> * </span><br>
    <input type="number" onblur="get_telephone()" id='telephone' value="<?php echo $phone; ?>">
    <br>
    <label for="website">
        Website link(Optional) <span style="color: gray; font-style: italic">E.g. https://obocircle.com/</span>
    </label>
    <span class="err" id="err_website"></span><br>
    <input type="text" id='website' placeholder="Your website URL" value="<?php echo $website; ?>"><br><br>
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
        let single_c = format_amouts('#single_c');
        let single_b = format_amouts('#single_b');
        let double_c = format_amouts('#double_c');
        let double_b = format_amouts('#double_b');
        let multi_c = format_amouts('#multi_c');
        let multi_b = format_amouts('#multi_b');
        
        let single_a = $('#single_a').val();
        let double_a = $('#double_a').val();
        let multi_a = $('#multi_a').val();

        let con;
        let payload = $('#payload').val();
        let pattern = /^[a-zA-Z0-9]+$/;
        if(!payload.match(pattern) || payload == "") return;
        if(single_c == "" || single_b == "" ||
            double_c == "" || double_b == "" ||
            multi_c == "" || multi_b == "" ||
            single_a == "" || double_a == "" || multi_a == "" || telephone == "" ||  website == "")
            con = confirm("Some fields were left empty. Confirm to proceed with changes.");
        else con = confirm("Confirm to proceed with changes."); 
        if(con){   
            data = "payload=" + payload + "&single_c=" + single_c + "&single_b=" + single_b +
                    "&double_c=" + double_c + "&double_b=" + double_b +
                    "&multi_c=" + multi_c + "&multi_b=" + multi_b +
                    "&single_a=" + single_a + "&double_a=" + double_a + 
                    "&multi_a=" + multi_a + "&nsfas=" + nsfas + "&phone=" + telephone + "&website=" + website;
            let url = "./management-accommodations/server/management.inc.php?action=update_main&" + data;
            let loc = "#err_update_main_page";
            let btn = "#update_main_page";
            //console.log(url); return;
            send_data(url, displayer, loc, " ", " ", btn);   
        }
    }
    function format_amouts(amount){
        if(amount != ""){
            input_val = amount; 
            amount = Number($(amount).val()).toFixed(2);
            let zero_amount = 0;
            amount = (amount > 0) ? amount : zero_amount.toFixed(2);
            if(input_val != "") $(input_val).val(amount);
        }
        return (amount != 0.00) ? amount : "";
    }
    function get_telephone(){
        let tell = $('#telephone').val();
        if(tell != ""){
            let pattern = /^[0-9]+$/;
            if(tell.match(pattern) && tell.length == 10){
                $('#err_telephone').html(" * ");
                return tell;
            }else{
                $('#err_telephone').html("Invalid phone number");
            }
        }else $('#err_telephone').html(" * ");                                
        return "";
    }
    function get_website(){
        let website = $('#website').val();
        if(website != ""){
            //let pattern = "/(http|https)+(://)+(wwww)?+[a-zA-Z0-9\-\.]/";
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
