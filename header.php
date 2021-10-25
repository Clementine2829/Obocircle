<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- JQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="js/jquery-3.4.1.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		})
	</script>
	<script src="https://kit.fontawesome.com/3e0b52ccd4.js" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="./css/style-header.css">
	<link rel="stylesheet" type="text/css" href="./css/style-footer.css">
	<link rel="stylesheet" type="text/css" href="./css/style-index.css">
	<title>Obocircle.com</title>
	<link rel="icon" href="./images/logo/logo.png" type="image/gif" sizes="30*30">	    
</head>
<body>
	<div class="row" id="top_nav">
		<div class="col-md-1" ></div>
		<div class="col-sm-4" id="logo">
			<div class="subNavitems">
				<a href="index.php">
					<img src="./images/logo/logo.png" alt="Logo" style="height:100%; width:100%" />
				</a>
			</div>
		</div>
		<div class="col-sm-6" id="user_account">
            <div class="login">
                <button onclick="window.location='./login.php'">Login</button>
            </div>
            <div class="register">
                <button onclick="window.location='./signup.php'">Register</button>
            </div>
            <div class="notifications">
                <a href="notifications.php" id="notifications">
                    <span data-toggle="tooltip" data-placement="bottom" title class="fas fas fa-info-circle" 
                        data-original-title="Click the icon to view your notifications"></span>
                    <span id="cart">0</span>
                </a>		
            </div>
		</div>
		<div class="col-md-1" ></div>
    </div>
	