<?php session_start();
	$err_holder = 
		'<div id="apply_data">
			<span onclick="close_apply()" class="close" title="Close Modal">&times;</span>
			<div style="color: red; margin: 5% auto;">
				<b>Service not available at the moment!</b>
				<br>
				Reason might be:
				<li>Accommodation does not support this service</li>
				<li>Link is broken, especially if you entered it manually. if so, reload page from the accommodation list</li>
			</div>
		</div>';

	$a_name = $a_address = $a_id = $a_names = "";
	$id = $names = $surname = $phone = $email = $gender = "";
	$new_address = array("", "", "", "", "");

	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(isset($_REQUEST['accommodation']) && preg_match('/^[a-zA-Z0-9]+$/',$_REQUEST['accommodation']))
			$a_id = $_REQUEST['accommodation'];
		else{
			echo $err_holder;
			return;
		}
		if($a_id != "")
			$_SESSION['reder'] = "./main-accommodation.php?content_id=" . $a_id;
		else $_SESSION['reder'] = "featured.php";

		require '../includes/conn.inc.php';					
		$sql = "SELECT accommodations.name, address.main_address
                FROM (accommodations 
                    INNER JOIN address ON accommodations.id = address.accommo_id)
                WHERE accommodations.id = \"$a_id\" AND accommodations.display = \"1\" LIMIT 1";
		$sql_results = new SQL_results();
		$results = $sql_results->results_accommodations($sql);
		if($results->num_rows > 0){
			$row = $results->fetch_assoc();
            if(preg_match('/^[a-zA-Z0-9\s\@\,\.\'\&]+$/' , $row['name']) && 
                preg_match('/^[a-zA-Z0-9\<\>\s\@\'\.\,\&]+$/' , $row['main_address'])){
                $a_names = check_inputs($row['name']);
                $temp_address = explode(",", str_replace("<br>", ",", $row['main_address']));
                for($i = 0; $i < 4; $i++){
                    if($temp_address[$i] != "") $a_address .= $temp_address[$i] . ", ";
                    else continue;
                }
                $a_address = substr($a_address, 0, (strlen($a_address) - 2));
            } 
		}else{
			echo $err_holder;
			return;
		}
		if(isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]+$/' , $_SESSION['s_id'])){
			$id = $_SESSION['s_id'];
			$sql = "SELECT first_name, last_name, gender, email, phone
					FROM users WHERE id = \"$id\" LIMIT 1";
			$sql_results = new SQL_results();
			$results = $sql_results->results_profile($sql);
			if($results->num_rows > 0){
				$row = $results->fetch_assoc();
                if(preg_match('/^[a-zA-Z\']+$/' , $row['first_name'])) $names = check_inputs($row['first_name']);
                if(preg_match('/^[a-zA-Z\']+$/' , $row['last_name'])) $surname = check_inputs($row['last_name']);
                if(preg_match('/\d{10}/' , $row['phone'])) $phone = check_inputs($row['phone']);
                if(filter_var($row['email'], FILTER_VALIDATE_EMAIL)) $email = check_inputs($row['email']);
                if(preg_match('/^[mfMF]+$/' , $row['gender'])) $gender = $row['gender'];

                $sql = "SELECT address
                        FROM users_extended 
                        WHERE user_id = \"$id\" 
                        LIMIT 1";
                $sql_results = new SQL_results();
                $results = $sql_results->results_profile($sql);
                if($results->num_rows > 0){
                    $row = $results->fetch_assoc();
                    $address = (preg_match('/^[a-zA-Z0-9\<\>\s\@\'\.\,]+$/' , $row['address'])) ? $row['address'] : "";
                }
                if($address != "") $new_address = explode("<br>", $address);
			} 
		}
	}else {
		require_once 'not-post.html';	
		return;		
	}
	function check_inputs($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
    
?>
<div id="apply_data">
	<span onclick="close_apply()" class="close" title="Close Modal">&times;</span>
	<span id="returned_msg"></span>
	<form method="post" id="accommodation_application_form">
		<span>
			<b><u style="font-size:24px;"><?php echo $a_names; ?></u><br></b>
            <i><?php echo $a_address; ?> <br></i>
		</span>
		<div>
			<?php
				if($names == "" && $surname == ""){
					echo 
					'<div style="color: red; font-size:19px;" >
						We encourage applicants to apply to accommodations as a registered users<br>
						Click <a href="login.php">here</a> to login or 
						<a href="signup.php">here</a> to create new account
					</div>';
				}
			?>
		</div><br>
		<div class="sub_holders">
			<div>
				<label>First Names: </label>
				<span class="err" id="err_names"> * </span><br>
				<input type="text" id="firstnames" onblur="get_names()" value="<?php echo $names; ?>" 
					placeholder="Your first name(s)" >
			</div>
			<div>
				<label>Last Name: </label>
				<span class="err" id="err_surname" > * </span><br>
				<input type="text" id="surname" onblur="get_surname()" value="<?php echo $surname; ?>" 
					placeholder="Your surname" >
			</div>
			<div>
				<label>Student Number: </label>
				<span class="err" id="err_student_no" > * </span><br>
				<input type="text" id="student_no" onblur="get_student_no()" placeholder="Your student number" >
			</div>
			<div>
				<label>Gender: </label>
				<span class="err" id="err_gender"> * </span>
				<div id="gender">
					<?php
						if($gender == "M") echo 
							'<input type="radio" id="f" name="gender" value="F"> Female
							<input type="radio" id="m" name="gender" value="M" checked> Male';
						else if($gender == "F") echo 
							'<input type="radio" id="f" name="gender" value="F" checked> Female
							<input type="radio" id="m" name="gender" value="M"> Male';
						else echo 
							'<input type="radio" id="f" name="gender" value="F"> Female
							<input type="radio" id="m" name="gender" value="M"> Male';
					?>
				</div>
			</div>
		</div>
		<div class="sub_holders">
			<div>
				<label>Phone: </label>
				<span class="err" id="err_get_phone" > * </span><br>
				<input type="number" id="phone" onblur="get_phone()"value="<?php echo $phone; ?>" placeholder="Your phone" >
			</div>
			<div>
				<label>Email: </label>
				<span class="err" id="err_get_email" ></span><br>
				<input type="email" id="a_email" onblur="get_email()" value="<?php echo $email; ?>" placeholder="Your email address" >
			</div>
			<div>
				<label>Home address: </label><br>
				<input type="text" id="address_line_1" onblur="get_address_line_1()"
						value="<?php echo $new_address[0];?>" placeholder="Address line 1">
				<span class="err" id="err_address_line_1" > * </span><br>
				<input type="text" id="address_line_2" onblur="get_address_line_2()"
						value="<?php echo $new_address[1];?>" placeholder="Address line 2">
				<span class="err" id="err_address_line_2" >  </span><br>
				<input type="text" id="address_town" onblur="get_address_town()"
						value="<?php echo $new_address[2];?>" placeholder="Town/City">
				<span class="err" id="err_address_town" > * </span><br>
				<input type="text" id="address_code" onblur="get_address_code()"
						value="<?php echo $new_address[3];?>" placeholder="Address code">
				<span class="err" id="err_address_code" > * </span><br>
			</div>
		</div>	
		<div>
			<label>Learning institution: </label>
			<span class="err" id="err_institution" > * </span><br>
			<input type="text" id="learning_institution" onblur="get_learning()" placeholder="" >
		</div>
		<div>
			<label>Mode of Payment: </label>
			<span class="err" id="err_payment" > * </span><br>
			<select id="payment_mode" onchange="get_payment_mode()" >
				<option value="select">--Select--</option>
				<option value="1">NSFAS</option>
				<option value="2">BURSARY</option>
				<option value="3">CASH</option>
				<option value="4">OTHER</option>
			</select>
		</div>
		<div>
			<label>Preffered room type: </label>
			<span class="err" id="err_room_type" > * </span><br>
			<select id="preffered_room" onchange="get_room_type()" >
				<option value="select">--Select--</option>
				<option value="1">Single</option>
				<option value="2">Double</option>
				<option value="3">Multi-sharing</option>
				<option value="4">Any room</option>
			</select>
		</div>
		<div>
			<label>Preffered mode of communication: </label>
			<span class="err" id="preffered_communication"> * </span>
			<div id="communication">
				<input type="radio" name="mode_of_communications" value="1" id="email_me"> Email
				<input type="radio" name="mode_of_communications" value="2" id="call_me"> Phone call
			</div>
		</div>
		<div>
			<label>When would you like to move in? </label>
			<span class="err" id="err_move_in" > * </span><br>
			<input type="date" id="move_in" onblur="get_move_in()" min="<?php echo date('Y-m-d'); ?>">
		</div>
		<div>
			<label>Would you like to get our transportation services? </label>
			<span class="err" id="err_transportation"> * </span><br>
			<select id="transportation" onchange="get_transportation()">
				<option value="select">--Select--</option>
				<option value="1">Yes</option>
				<option value="2">No</option>
				<option value="3">Maybe</option>
			</select>
		</div>
		<div>
			<p id="transport_notice">
				<b><u>NB!</u></b> 
				This transport is a bakkie that you can use to put all your belongings and have them
				delivered to your place of interest with/out you. Prices within a city varies from 150-200 
				Rands and to outside it varies by distance. And you can opt out anytime from this service. 
			</p>
		</div>
		<div id="my_location" style="display:none">
			<span class="err" id='err_my_loc' ></span><br>
			<input type="checkbox" onclick="get_location()" > Use my current location<br> 
			Or Enter your location
			<input type="text" onblur="get_location()" placeholder="E.g. 105 Smith Street"> 
		</div>
		<br>
		<span id="all_errors" ></span>
		<span id="agreement">
			<input type="checkbox"> 
		</span>
		<span id="err_agreement">
			I agree to <a href="terms_of_use.html">T&Cs</a>
		</span><br>
		<input type="button" id="send_a" onclick="send_application()" value="Submit" >
	</form>
</div>