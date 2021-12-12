<?php session_start();
	$name = $email = $subject = $message = $id = $select = "";
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if(isset($_REQUEST["name"]) && preg_match("/^[a-zA-Z\'\s]*$/", $_REQUEST["name"]))
			$name = test_input($_REQUEST["name"]);
		if(isset($_REQUEST["select"]) && preg_match("/(request|post)/", $_REQUEST["select"]))
			$select = test_input($_REQUEST["select"]);
		if(isset($_REQUEST["email"]) && filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL))
			$email = test_input($_REQUEST["email"]);
		if(isset($_REQUEST["subject"])) $subject = test_input($_REQUEST["subject"]);
		if(isset($_REQUEST["message"]))$message = test_input($_REQUEST["message"]);
		if($select == "request") $select = "I am selling";
		else if($select == "post") $select = "I want to buy";
		if($select != "") test_input($subject = $select);

		$recipient = "support@obocircle.com";
		require_once 'send-email.php';
	}else {
        echo "<p style='color: red'>Unknow request</p>";
        return;		
	}
	function test_input($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>