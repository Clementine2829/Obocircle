<?php 
/*
	Set the following before using this file
	$name -> Name from where the email is from
	$subject -> subject of the email
	$email -> your email address, or where the eamil is from 
	$recipient -> the address where the message is sent to
	$message-> the message 
*/
	$name = test_input($name);
	$subject = test_input($subject);
	$message = test_input($message);
	$message = wordwrap($message, 70);
	if (!empty($email) && !empty($message)) {
	    $mail_body = "Name: $name\nEmail: $email\n\n$message";
	    $sent_message = mail($recipient, $subject, $mail_body, "From: $name <$email>");
	   	if(!$sent_message) echo "Internal error sending message";
	}else echo "internal error occured2";

?>