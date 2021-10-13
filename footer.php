<!doctype html>
<html>
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

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
	<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		})
	</script>
	<script src="https://kit.fontawesome.com/3e0b52ccd4.js" crossorigin="anonymous"></script>

	<title>Obocircle.com</title>
	<link rel="icon" href="images/logo.png" type="image/gif" sizes="30*30">	    

</head>
<bod>
    <style rel="stylesheet" type="text/css">
        body{
            background-color: white;
        }
        #footer1{
            text-align: center;            
        }
        #footer1 .subscribe_footer{
            margin: 2%;            
        }
        #footer1 .subscribe_footer .label {
            margin-bottom: 1%;
        }
        #footer1 .subscribe_footer .subsribe {
            background-color: lightsteelblue;
            border-radius: 50px;
            padding: .5%;
            margin: auto 20%;
            width: 60%;
            
        }
        #footer1 .subscribe_footer .subsribe input[type=email] {
            width: 70%;
            border: none;
            padding: 1% 2%;
            margin-left: 2%;
            background-color: lightsteelblue;
            outline: none;
        }
        #footer1 .subscribe_footer .subsribe input[type=button] {
            padding: 2%;
            width: 27%;
            background-color: blue;
            color: white;
            border-radius: 50px;
            outline: none;
            border: 2px solid blue;
        }
        #footer1 .subscribe_footer .subsribe input[type=button]:hover {
            background-color: lightsteelblue;
        }
        
        .err{color: red;}
    </style>
    <br><br><br><br><br><br>
    <!--***********footer*************-->
	<div class="row" id="footer1">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="subscribe_footer">
				<span class="label">Join our mailing list for updates & discounted offers</span><br>
				<span class="err" id="err_email_footer"></span>
				<div class="subsribe">
					<input type="email" id="email_footer" onchange="get_email()" placeholder="Enter your email address" required>
					<input type="button" onclick="subscribe()" value="Subsrcibe">
				</div>
			</div>
        </div>
        <div class="col-sm-1"></div>
    </div>
	<div class="row" id="footer2">
        <div class="col-sm-1"></div>
		<div class="col-md-4">
			<div class="footer_container" >
				<h3>Obocircle</h3>
				<a href="home.php">Home</a><br>
				<a href="about-us.php">About Us</a><br>
				<a href="contact-us.php">Contact Us</a>
				<?php
					if(isset($_SESSION['s_id']) && 
						(isset($_SESSION['s_activated']) && $_SESSION['s_activated'] == 1)  && 
						(isset($_SESSION['s_pos_type']) && $_SESSION['s_pos_type'] == "Manager") ){
                            echo '<br><a href="admin.php" style="color: gray">Management</a>';
					}
				?>
			</div>
			<div class="footer_container" >
				<h3>Legal Info</h3>
				<a href="privacy_policy.html">Privacy Policy</a><br>
				<a href="terms_of_use.html">Terms of Use</a><br>
				<a href="cookies.html" target="_blank">Cookies Policy</a>
			</div>
		</div>
		<div class="col-md-4">
			<div class="footer_container" >
				<h3>Help Center</h3>
				<a href="faq.php">FAQ</a><br>
				<a href="#">File a report</a><br>
				<a href="./demo-videos.php">Demo Videos</a><br>
			</div>
			<div class="footer_container">
				<h3>Contact Us</h3>
				<p style="color:#0066ff">Email: info@mcnethub.com<br></p>
			</div>
        </div>
        <div class="col-sm-1"></div>
    </div>
	<div class="row" id="footer3">
        <div class="col-sm-1"></div>
        <div class="col-md-4">
            <div>
                <p>Obocircle.com Copyright © 2021 | All rights reserved</p>
            </div>
        </div>
        <div class="col-md-4">
			<span class="social-media">
				<!-- Add font awesome icons -->
				<a href="https://www.facebook.com/clementine.mc.79" class="fa fa-facebook" target="_blank"></a>
				<a href="https://www.twitter.com/clementine2829" class="fa fa-twitter" target="_blank"></a>
				<a href="https://www.instagram.com/clementinemamogale/" class="fa fa-instagram " target="_blank"></a>
				<a href="https://www.linkedin.com/mwlite/in/clementine-mamogale-6131aa174/" class="fa fa-linkedin " target="_blank"></a>
			</span>
		</div>
        <div class="col-sm-1"></div>
    </div>
</bod>
</html>