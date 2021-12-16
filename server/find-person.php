<?php session_start();
    $user_id = (isset($_REQUEST['ref']) && preg_match('/^[a-zA-Z0-9+$]/', $_REQUEST['ref'])) ? $_REQUEST['ref'] : "";
    $accommodation = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9+$]/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
    $already_a_manager = false;
    if($_SERVER['REQUEST_METHOD'] == "POST"){    
        if(!isset($_SESSION['s_id'])){
            require_once '../offline.html';
            return;
        }
    }else{
        echo "<span style='color: red'>Unknow request</span>";
        return;
    }
    $user_name = $gender = $address = $phone = $email = "";
    $sql = "SELECT users.id, users.first_name, users.last_name, users.gender, users.phone, users.email,
                    users_extended.address 
            FROM (users
                LEFT JOIN users_extended ON users.id = users_extended.user_id)
            WHERE users.ref_code = \"$user_id\"
            LIMIT 1";
    require("../includes/conn.inc.php");
    $sql_results = new SQL_results();
    $results = $sql_results->results_profile($sql);
    if($results->num_rows == 1){
        $row = $results->fetch_assoc();
        $user_id = $row['id'];
        $user_name = $row['first_name'] . " " . $row['last_name'];
        $gender = $row['gender'];
        $address = $row['address'];
        $phone = $row['phone'];
        $email = $row['email'];

        if($gender == "M") $gender = "Male";
        else if($gender == "F") $gender = "Female";
        else if($gender == "O") $gender = "Other";

        if($address != ""){
            $temp_loc = explode("<br>", $address);
            $address = "";
            $counter = 0;
            for($i = 0; $i < 4; $i++){
                if(isset($temp_loc[$i])){
                    if($temp_loc[$i] == "") continue;
                    else {
                        $counter++;
                        if($counter == 3){
                            $address .= $temp_loc[$i] . " ";
                        }else{
                            $address .= $temp_loc[$i] . "<br>"; 
                        }
                        if($counter == 3 && $i == 3) $address .= "<br>";
                    }
                } 
            }
            $address = substr($address, 0, (strlen($address) - 4));  
        }else $address = "<i style='color: gray'>Address N/A</i>";

        $sql = "SELECT date_added 
                FROM managers 
                WHERE user_id = \"$user_id\"
                LIMIT 1";
        $results = $sql_results->results_accommodations($sql);
        if($results->num_rows > 0){
            $already_a_manager = true;
        } 
        $sql = "SELECT name 
                FROM accommodations 
                WHERE manager = \"$user_id\"
                LIMIT 1";
        $results = $sql_results->results_accommodations($sql);
        if($results->num_rows > 0){
            $already_a_manager = true;
        }   
    }else{
        echo '<p style="color: red">No one could be  found with that searched ref number, make sure it is correct and try again</p>';
        return;
    }
?>
<div class="info_container">
    <div class="info">
        <p>
            <strong>Full name:</strong><br>
            <i><?php echo $user_name; ?></i>
        </p>
        <p>
            <strong>Gender:</strong><br>
            <i><?php echo $gender; ?></i>
        </p>        
    </div>
    <div class="info">
        <p>
            <strong>Address:</strong><br>
            <i><?php echo $address; ?></i>
        </p>
    </div>
    <div class="info">
        <p>
            <strong>Contact:</strong><br>
            <?php
                if($phone != "") echo '<i><span class="fas fa-phone"></span> ' . $phone . '<br></i>';
                if($email != "") echo '<i><span class="fas fa-envelope"></span> ' . $email . '</i>';            
            ?>
        </p>
    </div>
    <div class="info">
        <?php 
        if(isset($_SESSION['s_id']) || isset($_SESSION['s_user_type'])){
            if(($_SESSION['s_user_type'] == "premium_user") && (isset($_REQUEST['action']) && $_REQUEST['action'] == "management")){
                echo '<p>
                        <strong>Manager already?</strong><br>
                        Yes<br>
                        Click <a href="#" target="_blank">here</a> to view places they manage already.
                    </p>';
            }
        }
        ?>
    </div>
</div>
<div class="action">
    <?php
        if(isset($_SESSION['s_id']) || isset($_SESSION['s_user_type'])){
            if(($_SESSION['s_user_type'] == "premium_user") && (isset($_REQUEST['action']) && $_REQUEST['action'] == "management")){
                if($already_a_manager){
                    echo '<p style="color: blue;">' . $user_name . ' is already a manager to this acccommodation</p>';
                    return;
                }else{
                    echo "<button id='add_as_manager' 
                            onclick='add_as_manager_fn(\"" . $user_id . "\")'>
                            Add Them as manager
                          </button>";
                    return;
                } 
            }
        }
        
    ?>
</div>
