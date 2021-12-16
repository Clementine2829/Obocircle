<?php
$link = password_hash($name, PASSWORD_DEFAULT);
$link = substr($link,7,50);
while(!preg_match("/^[a-zA-Z0-9]*$/", $link) || strlen($link) < 45) {
	$link = password_hash($name, PASSWORD_DEFAULT);
	$link = substr($link,7,50);
}
$id = password_hash($name, PASSWORD_DEFAULT);
$id = substr($link,7,35);
while(!preg_match("/^[a-zA-Z0-9]*$/", $id) || strlen($id) < 30) {
	$id = password_hash($name, PASSWORD_DEFAULT);
	$id = substr($id,7,35);
}
//delete any link that is present at the moment
$sql_delete = "DELETE FROM activate_account WHERE user_id = \"$user_id\"";
if (!$connection->query($sql_delete)){	
//	echo "<br>Error updating details. Please try again";
} 

$sql_update = "INSERT INTO reset_pass(reset_id, user_id, reset_link)
				VALUES(\"$id\", \"$user_id\", \"$link\")";
if (!$connection->query($sql_update)) 
	echo "<br>Error updating details. Please try again";

$link ="https://obocircle.com/reset-password.php?link=" . $link;

$message = '
Hi ' .  $username . ' 

Please click the reset link below to reset your password. 
If nothing happens. Copy and paste it on your url bar: ' . $link .'

Warm regards, 

Obocircle.com
https://obocircle.com/

Obocircle.com copyright © ' . date('Y') . ' | all rights reserved
Powered and maintained by https://www.mcnetsolutions.co.za [McNet Solutions (Pty) Ltd]';

$name = "Obocircle";
$subject = "Account Activation";
$recipient = $email;
$email = "no-reply@obocircle.com";

require 'send-email.php';
?>