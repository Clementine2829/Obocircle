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
require 'validate_data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["gender"])) {
		$err_gender = "  Gender is required";
	} else {
		$gender = substr($_POST["gender"], 0, 1);	
	}

	if (empty($_POST["birthdate"])) {
		$err_birthdate = " Date of birth is required";
	} else {
		$birthdate = check_inputs(substr($_POST["birthdate"], 0, 10));
		/*if ((!preg_match("/^[0-9]*$/", $date_of_birth)) || $date_of_birth > 31122020 || $date_of_birth < 1011991) {
			$err_date_of_birth = " * Invalid date format. Use (dd mm yyyy)" ;
		}*/
	}

	if (empty($_POST["firstname"])) {
		$err_firstname = " Name is required";
	} else {
		$firstname = check_inputs(substr($_POST["firstname"], 0, 30));
		if (!preg_match("/^[a-zA-Z]*$/", $firstname)) {
			$err_firstname = " Only letters allowed" ;
		}
	}

	if (empty($_POST["lastname"])) {
		$err_lastname = " Surname is required";
	} else {
		$lastname = check_inputs(substr($_POST["lastname"], 0, 30));
		if (!preg_match("/^[a-zA-Z]*$/", $lastname)) {
			$err_firstname = " Only letters are allowed" ;
			$lastname = "";
		}
	}

	if (empty($_POST["email"])) {
		$err_email = " Email is required ";
	} else {
		$email = strtolower(substr(check_inputs($_POST["email"]), 0, 75));
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
		$err_cell_1 = " Cell number is required.";
	} else {
		$cell_1 = check_inputs($_POST["cellphone1"]);
		if (!preg_match("/^[0-9]*$/", $cell_1) || strlen($cell_1) != 10) {
			$err_cell_1 = " invalid cell number.";	
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
		$sql = "SELECT email FROM users WHERE email = \"$email\" LIMIT 1";
		$sql_results = new SQL_results();
		$results = $sql_results->results_profile($sql);
		if($results->num_rows > 0){
			$err_msg = "User with this email address already exist. 
				<br>Please make use of these options below <br>
				<a href=\"login.php\">login</a> | <a href=\"forgot-password.php\">recover account</a>
				<br>";
			$email = "";
		}else{
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$id = password_hash($password, PASSWORD_DEFAULT);
			$id = substr($id,7,45);
			while(!preg_match("/^[a-zA-Z0-9]*$/", $id)) {
				$id = password_hash($id, PASSWORD_DEFAULT);
				$id = substr($id,7,45);
			}
			$user_ex = password_hash($password, PASSWORD_DEFAULT);
			$user_ex = substr($user_ex,7,20);
			while(!preg_match("/^[a-zA-Z0-9]*$/", $user_ex)) {
				$user_ex = password_hash($user_ex, PASSWORD_DEFAULT);
				$user_ex = substr($id,7,20);
			}

			$this_date = date("d/m/Y H:i:s");
			$ref_code = get_ref_code($sql_results);
			$insert_in_table = "INSERT INTO users (id, first_name, last_name, gender, 
											date_of_birth, email, password, phone, ref_code, reg_date)
			VALUES (\"$id\", \"$firstname\", \"$lastname\", \"$gender\", \"$birthdate\", \"$email\", \"$hash\", \"$cell_1\", 
                    \"$ref_code\", \"$this_date\")";	
			
			$db_login = new DB_login_updates();
			$connection = $db_login->connect_db("obo_users");
			if ($connection->query($insert_in_table)) {
				$success_msg = "Account created successfully. Click <a href='login.php'>here</a> to login";

				$users_ex = "INSERT INTO users_extended (user_ex_id, user_id) VALUES(\"$user_ex\", \"$id\")";
				if ($connection->query($users_ex)){
                    //do thing
                } else echo "Error 1: " . $connection->error;
				
				$sql_validate_ref_code = "SELECT first_name FROM users WHERE ref_code = \"$ref_code\" LIMIT 1";
				$results = $sql_results->results_profile($sql_validate_ref_code);
				if($results->num_rows > 0){
					$sql_ref_code = "INSERT INTO refs VALUES(\"$ref_code\", \"$email\")";
					if (!$connection->query($sql_ref_code)){
						echo "Error 2: " . $connection->error;
					}
				}else{
					if($ref_code != ""){
						$err_ref_code = "This ref code: " . $ref_code . " is inavlid";
					}
				}

				$link = password_hash($firstname, PASSWORD_DEFAULT);
                $sql = "SELECT activate_id FROM activate_account WHERE user_id = \"\" LIMIT 1";
				$link = $ref_code = get_ref_code($sql_results, $sql);
				$veri_id = password_hash($firstname, PASSWORD_DEFAULT);
				$veri_id = substr($link,7,30);
				while(!preg_match("/^[a-zA-Z0-9]*$/", $veri_id) || strlen($veri_id) < 26) {
					$veri_id = password_hash($firstname, PASSWORD_DEFAULT);
					$veri_id = substr($veri_id,7,30);
				}
                $expire_date = substr($this_date, 0, 10);
				$sql_update = "INSERT INTO activate_account(activate_id, user_id, expire_date, veri_link)
								VALUES(\"$veri_id\", \"$id\", \"$expire_date\", \"$link\")";
				if (!$connection->query($sql_update)){
					$name = "Obocircle (Auto-generated-mail)";
					$subject = "Account Activation link";
					$email = "no-reply@obocircle.com";
					$recipient = $email;
					$message = "
Hi, " . $firstname . ", 
Please use the code below to activate your account


" . $link . "



Copyright © " . date("Y") . " Obocircle.com | All rights reserved
				info@obocircle.com";

					$success_msg .= "<br>An activation link has been sent to your email address.<br>
									If the link is not found in your mail box, you can <a href='login.php'>login</a> to and find it 
                                    in your notifications";
					require 'send-email.php';
				
                }
                $notification_id = password_hash($this_date, PASSWORD_DEFAULT);
                $notification_id = substr($notification_id,7,10);
                while(!preg_match("/^[a-zA-Z0-9]*$/", $id)) {
                    $notification_id = password_hash($notification_id, PASSWORD_DEFAULT);
                    $notification_id = substr($notification_id,7,10);
                }
                $notification = "Your account has not been activated yet. Please click <a href='activate-account.php'>here</a> 
                                to activate your account now";
                $this_date = substr($this_date, 0, 16);
                $sql_notification = "INSERT INTO notifications(notification_id, user_id, n_message, n_date)
								VALUES(\"$notification_id\", \"$id\", \"$notification\", \"$this_date\")";
				if ($connection->query($sql_notification)){
				    //do nothing
                };
				$firstname = $middlename = $lastname = $date_of_birth = $email = "";
				$password = $password2  = $cell_1 = $ref_code = "" ;
			} else $err_msg .= "Internal error occured while registering your account. Please try again ";
		}
	}
}

function get_ref_code($sql_results, $sql_validate_ref_code=""){
	$ref_code = rand(100000, 999999);
	$sql_validate_ref_code = ($sql_validate_ref_code == "") ? "SELECT first_name FROM users WHERE ref_code = \"$ref_code\" LIMIT 1" : $sql_validate_ref_code;
	$results = $sql_results->results_profile($sql_validate_ref_code);
	while(true){
		if($results->num_rows > 0){
			$ref_code = rand(100000, 999999);
	$sql_validate_ref_code = ($sql_validate_ref_code == "") ? "SELECT first_name FROM users WHERE ref_code = \"$ref_code\" LIMIT 1" : $sql_validate_ref_code;			$results = $sql_results->results_profile($sql_validate_ref_code);
		}else{
			break;
		}
	}
	return $ref_code;
}
?>
