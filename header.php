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
    <style type="text/css">
        
		html {scroll-behavior: smooth;}
		* {box-sizing:border-box}
        @media only screen and (max-width: 1199px){
            #top_nav {
                margin: 0%;
                width: 100%;
                padding: 1%;
                padding-right: 0px;
            }
            #logo{
                width: 62%;
                padding: 2% 0% 3% 1%;
                height: 20px;
            }
            #user_account {
                width: 38%;
                padding: 3% 0% 3% 2%;
            }
            #loggedin_dropedown button {
                width: 90%;  
            }
            #logo .subNavitems {
                width: 100%;
            }
            #user_account .register{
                display: none;
            }
            #user_account .login{
                width: 70%;
            }
            #user_account .login button{
                width: 90%;
            }
            #user_account .notifications {
                margin-right: 4%;
            }
            #user_account .login, 
            #user_account .register {
                background-color: white;
            }
        }
    </style>
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
            <?php
                if(isset($_SESSION['s_id'])){
                        if(strlen($_SESSION["s_first_name"]) > 15)
                            echo "<span style='display: none' id='login_name'>Hi, " . substr($_SESSION["s_first_name"], 0, 6) . '..</span>';
                        else  
                            echo "<span style='display: none' id='login_name'>Hi, " . $_SESSION["s_first_name"] . '</span>';
                        $image = (isset($_SESSION['s_dp']) && $_SESSION['s_dp'] != "") ? substr($_SESSION['s_id'], 5, 15) . "/" . $_SESSION['s_dp'] : "avata.png";
                    ?>
						<span class="dropdown" id="loggedin_dropedown">
							<button type="button" class="btn dropdown-toggle" data-toggle="dropdown" style="" id="dropdown_login_btn">
                                <img src="./images/users/<?php echo $image; ?>" style="width: 30px; height: 30px; border-radius: 50%;">
                            </button>
                            <script type="text/javascript">
                                if(window.innerWidth > 500){                                    
                                    $("#dropdown_login_btn").html($("#login_name").html());
                                }
                            </script>
							<div class="dropdown-menu" id="dropdown_items" >
                                <?php
                                    if(isset($_SESSION['s_user_type'])  && $_SESSION['s_user_type'] == "premium_user")
                                        echo '<a class="dropdown-item" href="dashboard.php"> Dashboard </a>';
                                ?>
								<a class="dropdown-item" href="view-profile.php"> View  Profile </a>
								<a class="dropdown-item" href="update-profile.php"> Update  Profile </a>
								<a class="dropdown-item" href="change-password.php"> Change Password</a>
								<hr>
								<a class="dropdown-item" href="logout.php"> Log Out </a>
							</div>
						</span>
                    <?php
                }else{
                    ?>
                    <div class="login">
                        <button onclick="window.location='./login.php'">Login</button>
                    </div>
                    <div class="register">
                        <button onclick="window.location='./signup.php'">Register</button>
                    </div>
                    <?php
                }
            
            ?>
            <div class="notifications">
                <a href="notifications.php" id="notifications">
                    <span data-toggle="tooltip" data-placement="left" title class="fas fas fa-info-circle" 
                        data-original-title="Click the icon to view your notifications"></span>
                    <span id="cart">0</span>
                </a>		
            </div>
		</div>
		<div class="col-md-1" ></div>
    </div>
	