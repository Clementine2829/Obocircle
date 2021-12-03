<?php session_start();
require_once "./validate_data.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $full_name = (isset($_REQUEST['full_name']) && preg_match('/^[a-zA-Z\s\']*$/', $_REQUEST['full_name'])) ?check_inputs($_REQUEST['full_name']) : "";
    $surname = (isset($_REQUEST['surname']) && preg_match('/^[a-zA-Z\s\']*$/', $_REQUEST['surname'])) ?check_inputs($_REQUEST['surname']) : "";
    $student_no = (isset($_REQUEST['student_no']) && preg_match('/^[a-zA-Z0-9]*$/', $_REQUEST['student_no'])) ?check_inputs($_REQUEST['student_no']) : "";
    $gender = (isset($_REQUEST['gender']) && preg_match('/[mfMF]/', $_REQUEST['gender'])) ?check_inputs($_REQUEST['gender']) : "";
    $phone = (isset($_REQUEST['phone']) && preg_match('/\d{10}/', $_REQUEST['phone'])) ?check_inputs($_REQUEST['phone']) : "";
    $email = (isset($_REQUEST['email']) && filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) ? strtolower(check_inputs($_REQUEST['email'])) : "";
    $address_line_1 = (isset($_REQUEST['address_line_1']) && preg_match('/^[a-zA-Z0-9\s\'\@\&\.]*$/', $_REQUEST['address_line_1'])) ?check_inputs($_REQUEST['address_line_1']) : "";
    $address_line_2 = (isset($_REQUEST['address_line_2']) && preg_match('/^[a-zA-Z0-9\s\'\@\&\.]*$/', $_REQUEST['address_line_2'])) ?check_inputs($_REQUEST['address_line_2']) : "";
    $address_code = (isset($_REQUEST['address_code']) && preg_match('/\d{4}/', $_REQUEST['address_code'])) ?check_inputs($_REQUEST['address_code']) : "";
    $address_town = (isset($_REQUEST['address_town']) && preg_match('/^[a-zA-Z0-9\s\'\@\&\.]*$/', $_REQUEST['address_town'])) ?check_inputs($_REQUEST['address_town']) : "";
    $learning = (isset($_REQUEST['learning']) && preg_match('/^[a-zA-Z\s\']*$/', $_REQUEST['learning'])) ?check_inputs($_REQUEST['learning']) : "";
    $payment_mode = (isset($_REQUEST['payment_mode']) && preg_match('/^[1234]+$/', $_REQUEST['payment_mode'])) ?check_inputs($_REQUEST['payment_mode']) : "";
    $room_type = (isset($_REQUEST['room_type']) && preg_match('/^[1234]+$/', $_REQUEST['room_type'])) ?check_inputs($_REQUEST['room_type']) : "";
    $communication_mode = (isset($_REQUEST['communication_mode']) && preg_match('/[12]/', $_REQUEST['communication_mode'])) ?check_inputs($_REQUEST['communication_mode']) : "";
    $move_in = (isset($_REQUEST['move_in']) && preg_match('/[0-9\-]/', $_REQUEST['move_in'])) ?check_inputs($_REQUEST['move_in']) : "";
    $transportation = (isset($_REQUEST['transportation']) && preg_match('/^[123]+$/', $_REQUEST['transportation'])) ?check_inputs($_REQUEST['transportation']) : "";
    $accommodation = (isset($_REQUEST['accommodation']) && preg_match('/^[a-zA-Z0-9]*$/', $_REQUEST['accommodation'])) ?check_inputs($_REQUEST['accommodation']) : "";
    $applicant_id = (isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]*$/', $_SESSION['s_id'])) ?check_inputs($_SESSION['s_id']) : "";

	require_once '../includes/conn.inc.php';
	$db_login = new DB_login_updates();
	$connection = $db_login->connect_db("applications");

	$id = password_hash($full_name, PASSWORD_DEFAULT);
	$id = substr($id,7,10);
	while(!preg_match("/^[a-zA-Z0-9]*$/", $id)){
		$id = password_hash($id, PASSWORD_DEFAULT);
		$id = substr($id,7,10);
	}

	$address = "";
	if($address_line_2 != "") 
		$address = $address_line_1 . "<br>" . $address_line_2 . "<br>" .  
								$address_town . "<br>" . $address_code;
	else $address = $address_line_1 . "<br><br>" . $address_town . "<br>" . $address_code;

	$full_name = mysqli_real_escape_string($connection, $full_name);
	$surname = mysqli_real_escape_string($connection, $surname);
	$student_no = mysqli_real_escape_string($connection, $student_no);
	$learning = mysqli_real_escape_string($connection, $learning);
	$address = mysqli_real_escape_string($connection, $address);
	$learning = mysqli_real_escape_string($connection, $learning);
	//all fields are valid values 
	$exisit = false;
	$sql = "SELECT a_status
			FROM new_applicants
			WHERE full_names = \"$full_name\" AND surname = \"$surname\" AND student_no = \"$student_no\"
			AND accommodation = \"$accommodation\"
			LIMIT 1";
	$sql_results = new SQL_results();
	$results = $sql_results->results_applicaations($sql);
	if($results->num_rows > 0) {
        $row = $results->fetch_assoc();
        $respond = $row['a_status'];
		$exisit = true;
	}
	if($id != "" && $full_name != "" && $surname != "" && $gender != "" && $student_no != "" && $email != "" && $phone != "" && 
		$address != "" && $learning != "" && $payment_mode != "" && $room_type != "" && $communication_mode != "" && 
		$move_in != "" && $transportation != "" && $accommodation != ""){
		// check if student is applying to same accommodation?
		if($exisit != true){
			$sql = "INSERT INTO new_applicants(id, full_names, surname, gender, student_no, phone, email, 
								address, institution, payment_method, room_type, communication_method, 
								move_in, transportation, accommodation)
					VALUES(\"$id\", \"$full_name\", \"$surname\", \"$gender\", \"$student_no\", \"$phone\", 
							\"$email\", \"$address\", \"$learning\", \"$payment_mode\", \"$room_type\", 
							\"$communication_mode\", \"$move_in\", \"$transportation\", 
							\"$accommodation\")";
			if ($connection->query($sql)){

				echo '
						<span style="color: blue">
							<br><div style="margin:1%; color: blue">
							<span style="color: green">Application sent successfully</span>.<br>
							Thank you for using our service. <br>
							An email message has been sent to this email address ' . $email . ' as provided.<br>
							Now you can wait for communication from the accommodation you 
							applied to<br> Alternatively, you can track your applications <a href="#">here</a>.
						</span>
					';
/*
    Set the following before using this file
    $name -> Name from where the email is from
    $subject -> subject of the email
    $email -> your email address, or where the eamil is from 
    $recipient -> the address where the message is sent to
    $message-> the message 
*/
    $name = "Obocircle (Auto-generated-mail)";
    $subject = "Accommodation application";
    $recipient = $email;
    $email = "support@obocircle.com";

$message = "Dear " . $full_name . ",

Thank you, your accommodation application has been send successfully. They should be attended ASAP and get back to you soon.


Note: This email serves as an official receipt for your accommodation application.

Best regards,

Obocircle.com
https://obocircle.com/

Obocircle.com copyright © " . date('Y') . " | all rights reserved
Powered and maintained by https://www.mcnetsolutions.co.za [McNet Solutions (Pty) Ltd]";

    require_once './send-email.php';

			}else echo "Internal error encoutered while uploading your applications to this accommodation, Please try again";
		}else {
			//they already applied to this accommodation
			echo "<br>Your applications to this accommodation already exisit in the system.";
			if($respond == 0){
				echo " And, is still \"Pending\".";
            }
            echo "<br><br>Once the manager has seen or responded to it you will receive an email from us letting you know of those changes and also a notification will be put on the notification icon. Alternatively,  you can click <a href='#'>here</a> to check your application status and for other accommodations<br><br><br>";
		}
	}else{
		echo "Some information supplied are not valid";
	}
}else{
    echo "Unkown request";
	return;
}
//they should use their student numbers to track their applications 

function test_input($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>
