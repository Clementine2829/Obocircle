<?php session_start();
function get_contact($contact, $sql_type){
    //hide some information so that they cannot contact the people themselves without responding first
    if($sql_type == "accepted"){
        if(preg_match('/\d{10}/', $contact))
            return "(" . substr($contact, 0, 3) . ")-" . substr($contact, 3, 3) . "-" . substr($contact, 6); 
        else return $contact;
    }
    if(preg_match('/\d{10}/', $contact)){
        //number phone
        $contact = "(" . substr($contact, 0, 3) . ") *** *" . substr($contact, 7, 3); 
    }else if(filter_var($contact, FILTER_VALIDATE_EMAIL)){
        //EMAIL 
        $temp_email = $contact;
        $indexOfAt = strpos($temp_email, '@');
        $counter = strpos($temp_email, '@') - 3;
        if($counter > 1){
            $temp_email = substr($contact, 0, 3);
            for($i = 0; $i < $counter; $i++){
                $temp_email .= "*";
            }
        }else{
            $temp_email = substr($contact, 0, 1);
            if($counter == 0) $counter = 2;
            else if($counter == -1) $counter = 1;
            else $counter = 3;
            for($i = 0; $i < $counter; $i++){
                $temp_email .= "*";
            }
        }
        $temp_email .= substr($contact, $indexOfAt);
        $contact = $temp_email;
    }
    return $contact;
}
if($_SERVER['REQUEST_METHOD'] == "POST"){    
    if(isset($_SESSION['s_id']) || isset($_SESSION['s_user_type'])){
        if($_SESSION['s_user_type'] != "premium_user"){
            require_once '../../access_denied.html';
            return;
        }
        $user_id = $_SESSION['s_id'];
        require("../../includes/conn.inc.php");
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
    }else return;
	
	$sql = $err_inner_msg = $err_inner_msg = $sql_type = "";
	$sort = "";
	$sort_by = 1;

	if(isset($_REQUEST['sort']) && preg_match('/^[a-z\_]+$/', $_REQUEST['sort'])){
		$sort = $_REQUEST['sort'];
		if($sort == "name") $sort = "full_names";
		else if($sort == "payment") $sort = "payment_method";
		else if($sort == "room") $sort = "room_type";
		//echo "<br> Sort: " . $sort;
	}	
	if(isset($_REQUEST['sort_by']) && preg_match('/(1|2)/', $_REQUEST['sort_by'])){
		$sort_by = $_REQUEST['sort_by'];
		if($sort != ""){
			if($sort_by = 1) $sort .= " ASC";
			else if($sort_by == 2) $sort .= " DESC";
		}	
	}
	if(isset($_REQUEST['apps_type']) && preg_match('/(accepted)/', $_REQUEST['apps_type'])){
		$sql_type = "accepted";
	}
	if($sort == "" && $sort_by != 2) $sort = "full_names ASC";
	else if($sort == "") $sort = "full_names DESC";
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $sql = "SELECT * 
                FROM new_applicants
                WHERE accommodation = \"$accommodation\" AND (a_status = 0 OR a_status = 2 OR a_status = 3 OR a_status = 4) 
                ORDER BY $sort LIMIT 35";
                /* 0 => no action, 1 => accepted, 2 => declined */
		if($sql_type == "accepted"){
			$sql = "SELECT * 
					FROM new_applicants
					WHERE accommodation = \"$accommodation\" AND a_status = 1 
					ORDER BY $sort LIMIT 35";
					/* 0 => no action, 1 => accepted, 2 => declined */
		}
		$client_id = $name = $gender = $email = $phone = $institution = $payment = $room = $get_date = "";
		require_once '../../includes/conn.inc.php';
		$sql_results = new SQL_results();
		$results = $sql_results->results_applicaations($sql);
		if($results->num_rows > 0){
			if($sql_type != "accepted")
				echo '<strong class="nb" style="float: left">NB!</strong> <span class="nb">Some information might be hidden for security reasons!</span>';
			?>
			<table>
                <colgroup>
                    <col span="1">
                    <col span="1">
                    <col span="1">
                    <col span="1">
                    <col span="1">
                    <col span="1">
                    <col span="1">
                    <col span="1">
                    <col span="1">
                    <col span="1">
                </colgroup>
                <tbody>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Contact details</th>
                        <th>Institution</th>
                        <th>Payment mode</th>
                        <th>Preffered room type</th>
                        <th>Status</th>
                        <th>Move in Date</th>
                    </tr>
                <?php
                $j = 1; //counter
                while($row = $results->fetch_assoc()){
                    if(true){
                        $client_id = $row['id']; 
                        $name = substr($row['full_names'], 0, 1) . ". " . $row['surname'];
                        $gender = $row['gender'];
                        $email = $row['email'];
                        $phone = $row['phone'];
                        $institution = $row['institution'];
                        $payment = $row['payment_method'];
                        $room = $row['room_type'];
                        $id = $row['id'];
                        $contact_mode = $row['communication_method'];
                        $status = $row['a_status'];
                        $get_date = date("d/m/y", strtotime(substr($row['move_in'], 0, 10)));

                        if($payment == 1) $payment = "NSFAS";
                        else if($payment == 2) $payment = "BURSARY";
                        else if($payment == 3) $payment = "CASH";
                        else if($payment == 4) $payment = "Other";

                        if($room == 1) $room = "Single room";
                        else if($room == 2) $room = "Double Sharing";
                        else if($room == 3) $room = "Three Sharing";
                        else if($room == 4) $room = "Any Sharing";

                        if($contact_mode == 1)
                            $contact = get_contact($email, $sql_type);
                        else if($contact_mode == 2)
                            $contact = get_contact($phone, $sql_type);
                        if($status == 0) 
                            $status = "<span style=\"padding:3px 7px; color: gray; border-radius:6px\">Pending <i>your</i> approval</span>";
                        else if($status == 1) 
                            $status = "<span style=\"padding:3px 7px; color: green; border-radius:6px;\">They Accepted</span>";
                        else if($status == 2) 
                            $status = "<span style=\"padding:3px 7px; color: red; border-radius:6px;\"><i>You</i> rejected </span>";
                        else if($status == 3) 
                            $status = "<span style=\"padding:3px 7px; color: blue; border-radius:6px;\">Pending Thier approval</span>";
                        else if($status == 4) 
                            $status = "<span style=\"padding:3px 7px; color: red; border-radius:6px;\">They rejected</span>";

                        echo '<tr>';
                        if($sql_type != "accepted"){
                            echo '<td>' . $j . '</td>
                                <td style="border-right: 1px solid gray">
                                    <input type="checkbox" class="s_all" onchange="disable_check()">
                                    <input type="hidden" class="_applicants" value="' . $client_id . '">
                                </td>';
                        }else{
                            echo '  <td style="border-right: 1px solid gray">' . $j . '</td><td></td>';						
                        }
                        echo ' 	<td>' . $name . '</td>
                                <td>' . $gender . '</td>
                                <td>' . $contact . '</td>
                                <td>' . $institution . '</td>
                                <td>' . $payment . '</td>
                                <td>' . $room . '</td>
                                <td>' . $status . '</td>
                                <td>' . $get_date . '</td>
                            </tr>';
                        $j++;
                    }else continue;
                }
                echo'  </tbody>
                </table>';
                if($sql_type != "accepted"){
                    ?>
                    <div id="action">
                        <button style="background-color: skyblue;" onclick="select_all()">Select all</button>
                        <button style="background-color: green;" onclick="accept_application()">Accept</button>
                        <button style="background-color: red; color:white" onclick="decline_application()">Decline</button>
                    </div>
				<?php
			}
		}else{
			if($sql_type != "accepted")
				echo "<div style='color: red; padding: 2% 1px;'>
						<b>Zero (0) application(s) found.</b>
					<div>";
			else
				echo "<div style='color: red; padding: 2% 1px;'>
						<b>No accepted application found.</b>
					<div>";
			return;
		}
	}else{
		echo "<div style='color: red; padding: 2% 1px;'>
				<b>Error loading data.</b>
				<br>Link seems to be broken. 
				<br>Please reload page
			<div>";
		return;
	}
}else{
    echo "<p style='color: red'>Unkown request</p>";
    return;
}
?>
