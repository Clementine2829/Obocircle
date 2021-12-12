<?php session_start();
	$name = $email = $subject = $message = $id = $select = "";
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		if(isset($_REQUEST["name"]) && preg_match("/^[a-zA-Z\'\s]*$/", $_REQUEST["name"]))
			$name = check_inputs($_REQUEST["name"]);
		if(isset($_REQUEST["select"]) && preg_match("/(request|post)/", $_REQUEST["select"]))
			$select = check_inputs($_REQUEST["select"]);
		if(isset($_REQUEST["email"]) && filter_var($_REQUEST["email"], FILTER_VALIDATE_EMAIL))
			$email = $_REQUEST["email"];
		if(isset($_REQUEST["subject"]) && preg_match("/^[a-zA-Z 0-9\s\'\"\?\,\.\/\\\(\)\@\+\-\*\=]*$/", $_REQUEST["subject"]))
			$subject = check_inputs($_REQUEST["subject"]);
		if(isset($_REQUEST["message"]) && preg_match("/^[a-zA-Z 0-9\s\'\"\?\,\.\/\\\(\)\@\+\-\*\=]*$/", $_REQUEST["message"]))
			$message = $_REQUEST["message"];
		if($select == "request") $select = "I am selling";
		else if($select == "post") $select = "I want to buy";
		if($select != "") check_inputs($subject = $select);

		$recipient = "support@obocircle.com";
		require_once 'send-email.php';
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