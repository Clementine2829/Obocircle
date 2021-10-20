<?php session_start(); 
	unset($_SESSION["s_tittle"]);
	$_SESSION["s_last_name"] = "";
	$_SESSION["s_email"] = "";
	$_SESSION["s_password"] = "";
 	session_unset(); 
	session_destroy(); //destroy all sessions in php
	if(isset($_SESSION['reder'])) unset($_SESSION['reder']);
	if(isset($_REQUEST['log']) && $_REQUEST['log'] == 'account'){
		?>
			<script type="text/javascript">
				window.location = "signup.php";
			</script>
		<?php		
	}
?>
<script type="text/javascript">window.location = "./login.php";</script>
