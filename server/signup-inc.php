<?php
$gender = $birthdate =  "";
$success_msg = $err_msg = "";

$firstname = $middlename = $lastname = $date_of_birth = $email = "";
$password = $password2  = $cell_1 = $ref_code = "" ;

$err_gender = $err_birthdate = "";	

$err_firstname = $err_middlename = $err_lastname = "";
$err_email = $err_password = $err_password2 = $err_cell_1 = $err_ref_code = "";

if(isset($_REQUEST['ref']) && preg_match("/\d{6}/", $_REQUEST['ref'])){
	$ref_code = $_REQUEST['ref'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["gender"])) {
		$err_gender = "  Gender is required";
	} else {
		$gender = $_POST["gender"];	
	}

	if (empty($_POST["birthdate"])) {
		$err_birthdate = " Date of birth is required";
	} else {
		$birthdate = check_inputs($_POST["birthdate"]);
		/*if ((!preg_match("/^[0-9]*$/", $date_of_birth)) || $date_of_birth > 31122020 || $date_of_birth < 1011991) {
			$err_date_of_birth = " * Invalid date format. Use (dd mm yyyy)" ;
		}*/
	}

	if (empty($_POST["firstname"])) {
		$err_firstname = " Name is required";
	} else {
		$firstname = check_inputs($_POST["firstname"]);
		if (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
			$err_firstname = " Only letters allowed" ;
		}
	}

	if (!empty($_POST["middlename"])) {
		$middlename = check_inputs($_POST["middlename"]);
		if (!preg_match("/^[a-zA-Z]*$/", $middlename)) {
			$err_middlename = " Only letters allowed" ;
			$middlename = "";
		}
	} 

	if (empty($_POST["lastname"])) {
		$err_lastname = " Surname is required";
	} else {
		$lastname = check_inputs($_POST["lastname"]);
		if (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
			$err_firstname = " Only letters are allowed" ;
			$lastname = "";
		}
	}

	if (empty($_POST["email"])) {
		$err_email = " Email is required ";
	} else {
		$email = strtolower(check_inputs($_POST["email"]));
		$pattern = '/^[a-zA-Z0-9\.]+\@+(gmail.com|icloud.com|outlook.com|yandex.mail|yahoo.com)+$/';
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$err_email = " Invalid email format"; 
				$email = "";
			}else if(!preg_match($pattern, $email)){
				$err_email = " This email type is not supported"; 
				$email = "";
			}
	}

	if (empty($_POST["password1"])) {
		$err_password = " Password is required";
		$password = "";
	} else {
		if (empty($_POST["password2"])) {
			$err_password2 = " Confirm password is required";
			$password2 = "";
		}

		$password = check_inputs($_POST["password1"]);
		$password2 = check_inputs($_POST["password2"]);

		if (!preg_match("/^[a-zA-Z0-9 \.\!\@\#\$\%\&\?\,\s]*$/", $password)) {
			$err_password = " Only letters and numbers are allowed ";
		}elseif (strlen($password) < 8  ) {
			$err_password = " Password is too short, Min is 8";
		}elseif ($password != $password2) {
			$err_password2 = "Password does not match";
			$password1 = $password = "";
		}
	}

	if (empty($_POST["cellphone1"])) {
		$err_cell_1 = " Cell number is required ";
	} else {
		$cell_1 = check_inputs($_POST["cellphone1"]);
		if (!preg_match("/^[0-9]*$/", $cell_1) || strlen($cell_1) < 8 || strlen($cell_1) > 13) {
			$err_cell_1 = " invalid cell number format.";	
			$cell_1 = "";
		}
	}
	if (!empty($_POST["ref_code"])) {
		$ref_code = check_inputs($_POST["ref_code"]);
		if (!preg_match("/\d{6}/", $ref_code)) {
			$err_ref_code = " invalid ref code.";	
			$ref_code = "";
		}
	}

	if ($firstname != "" && $lastname != "" && $gender != "" && $email != "" && 
		$password != "" && $password2 != "" && $cell_1 != "" ) {
	
		$success_msg = $err_msg = "";
		require("includes/conn.inc.php");
		$sql = "SELECT email FROM clients WHERE email = \"$email\" LIMIT 1";
		$sql_results = new SQL_results();
		$results = $sql_results->my_profile($sql);
		if($results->num_rows > 0){
			$err_msg = "User with this email address already exist. 
				<br>Please make use of these options below <br>
				<a href=\"login.php\">login</a> | <a href=\"forgot-pass.php\">recover account</a>
				<br>";
			$email = "";
		}else{
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$id = password_hash($password, PASSWORD_DEFAULT);
			$id = substr($id,7,35);
			while(!preg_match("/^[a-zA-Z0-9]*$/", $id) ) {
				$id = password_hash($id, PASSWORD_DEFAULT);
				$id = substr($id,7,35);
			}
			$veri_client = password_hash($password, PASSWORD_DEFAULT);
			$veri_client = substr($veri_client,7,30);
			while(!preg_match("/^[a-zA-Z0-9]*$/", $veri_client) ) {
				$veri_client = password_hash($veri_client, PASSWORD_DEFAULT);
				$veri_client = substr($id,7,30);
			}

			$this_date = date("d/m/Y H:i:s");
			$ref_code = get_ref_code($sql_results);
			$insert_in_table = "INSERT INTO clients (id, first_name, middle_name, last_name, gender, 
											date_of_birth, email, password, phone, ref_code, reg_date)
			VALUES (\"$id\", \"$firstname\", \"$middlename\", \"$lastname\", \"$gender\", 
					\"$birthdate\", \"$email\", \"$hash\", \"$cell_1\", \"$ref_code\", \"$this_date\")";	
			
			$db_login = new DB_login_updates();
			$connection = $db_login->connect_db("mcnethub");
			if ($connection->query($insert_in_table)) {
				$success_msg = "Account created successfully. Thank you.";

				$sql_veri_clients = "INSERT INTO veri_clients (user_id, start_date, client)
				 						VALUES(\"$veri_client\", \"$this_date\", \"$id\")";
				if (!$connection->query($sql_veri_clients)){
					//$err_msg = "Internal error. Profile incomplete<br>";
				}
				$update_sql = "UPDATE clients SET veri_client = \"$veri_client\" 
								WHERE id = \"$id\"";
				if (!$connection->query($update_sql)){
					//$err_msg .= "Profile couldn't be updated to latest";
				}
				$sql_validate_ref_code = "SELECT first_name FROM clients WHERE ref_code = \"$ref_code\" LIMIT 1";
				$results = $sql_results->my_profile($sql_validate_ref_code);
				if($results->num_rows > 0){
					$sql_ref_code = "INSERT INTO refs VALUES(\"$ref_code\", \"$email\")";
					if (!$connection->query($sql_ref_code)){
						echo "Error: " . $connection->error;
					}
				}else{
					if($ref_code != ""){
						$err_ref_code = "This ref code: " . $ref_code . " is inavlid";
					}
				}

				$link = password_hash($firstname, PASSWORD_DEFAULT);
				$link = substr($link,7,50);
				while(!preg_match("/^[a-zA-Z0-9]*$/", $link) || strlen($link) < 45) {
					$link = password_hash($firstname, PASSWORD_DEFAULT);
					$link = substr($link,7,50);
				}
				$veri_id = password_hash($firstname, PASSWORD_DEFAULT);
				$veri_id = substr($link,7,30);
				while(!preg_match("/^[a-zA-Z0-9]*$/", $veri_id) || strlen($veri_id) < 26) {
					$veri_id = password_hash($firstname, PASSWORD_DEFAULT);
					$veri_id = substr($veri_id,7,30);
				}

				$sql_update = "INSERT INTO verify(veri_id, client_id, veri_link)
								VALUES(\"$veri_id\", \"$id\", \"$link\")";
				if (!$connection->query($sql_update)){
					$link ="https://obocircle.com/activate-me.php?link=" . $link;
					$name = "Obocircle (Auto-generated-mail)";
					$subject = "Account Activation link";
					$email = "no-reply@obocircle.com";
					$recipient =  $email;
					$message = "
Hi, " . $firstname . ", 
Please click on the link below to activate your account.
If nothing happens. Copy and paste it to your url space
" . $link . "

Please DO NOT share this link with anyone.

Copyright © " . date("Y") . " Obocircle.com | All rights reserved
				info@obocircle.com";

					$success_msg .= "<br>An activation link has been sent to your email address.<br>
									If the link is not found in your mail box, you can click <a href='login.php'>here</a> to login 
									and go to your profile then click on the 'activate account' button at the bottom of the page.";
					require 'send-msg.php';
				} 

				$firstname = $middlename = $lastname = $date_of_birth = $email = "";
				$password = $password2  = $cell_1 = "" ;
			} else $err_msg .= "Internal error occured while registering your account. Please try again " . $connection->error;
		}
	}
}
function check_inputs($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
function get_ref_code($sql_results){
	$ref_code = rand(100000, 999999);
	$sql_validate_ref_code = "SELECT first_name FROM clients WHERE ref_code = \"$ref_code\" LIMIT 1";
	$results = $sql_results->my_profile($sql_validate_ref_code);
	while(true){
		if($results->num_rows > 0){
			$ref_code = rand(100000, 999999);
			$sql_validate_ref_code = "SELECT first_name FROM clients WHERE ref_code = \"$ref_code\" LIMIT 1";
			$results = $sql_results->my_profile($sql_validate_ref_code);
		}else{
			break;
		}
	}
	return $ref_code;
}
?>
