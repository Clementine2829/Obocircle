    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <?php
/*
        if(!isset($_SESSION['file'])) $_SESSION['file'] = "";		
		if (isset($_SESSION["s_first_name"]) && isset($_SESSION["s_email"])) {
			?>
			<script type="text/javascript">
				window.location = "my-details.php";
			</script>
			<?php
		}
*/
        $errorMsg = "Invalid username or password";
		$errorMsgNamePass = $username = $password = "";
/*
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$usernameLower = strtolower($_POST["username"]);
			if (empty($usernameLower) || empty($_POST["password"])) {
				$errorMsgNamePass = $errorMsg;	
			} else {
				$username = test_input($usernameLower); 
				if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
					$errorMsgNamePass = $errorMsg;	
					$username = NULL;
				}
				$password = test_input($_POST["password"]);
				if (!preg_match("/^[a-zA-Z\s0-9\.\!\@\#\$\%\^\&\*\s]*$/", $password)){
					$errorMsgNamePass = $errorMsg;	
					$password = NULL;
				}
			}
			require("includes/user.inc.php");
			$user = new User($username, $password);
			if($user->get_user()) {
				if(isset($_SESSION['reder']) && isset($_SESSION['reder']) != ""){
					echo "<span id='reder' style='display:none'>" . $_SESSION['reder'] . "</span>"; 
					?>
					<script type="text/javascript">
						window.location = document.getElementById('reder').innerHTML; 
					</script>
					<?php
				}else{
					?>
						<script type="text/javascript">
							window.location = "home.php";
						</script>
					<?php
				}
			}else $errorMsgNamePass = $errorMsg;
		}
		function test_input($data){
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}*/
	?>
	<link rel="stylesheet" type="text/css" href="./css/style-login.css">
	<br><br>
	<div class="row" >
		<div class="col-sm-2" ></div>
		<div class="col-sm-8" style="text-align:center">
			<form action="login.php" method="POST" autofill="off" autocomplete="off">
				<div class="login" >
					<span id="error_msgInputs" style="color:red;">
						<strong> <?php echo $errorMsgNamePass;?></strong>
					</span><br>
					<div class="form-group">
						<span class="fas fa-user"></span>
						<label for="username">Username:</label>
						<input type="email" id="email1" name="username" placeholder="Email Address" value="<?php echo $username; ?>" required>
					</div>
					<div class="form-group" >
						<span class="fas fa-briefcase"></span>
						<label for="password" >Password:</label>
						<input type="password" name="password" placeholder="Password"  value="<?php echo $password; ?>" required>
					</div>
					<div class="form-group" >
						<input type="submit" value="Submit" >
					</div>
					<div class="form-group">
						<a id="forgot" href="forgot-pass.php">Forgot Password?</a>
						<input type="button" style="color:red" onclick="window.location='signup.php'" value="Sign up">
					</div>
				</div>	
			</form>
		</div>
		<div class="col-sm-2" ></div>
	</div>
<!--	<button onclick="document.getElementById('de-form').style.display='block'" style="width:auto;">Sign Up</button>-->
	<hr>
	<p style="text-align:center;">
		<a href="home.php" style="font-size:22px; text-decoration:none;">Home</a>
	</p>
	<hr>
	<div style="text-align:center">
		<p id="fot">
			<span style="font-size:20px">Obocircle<span style="color:orange; fint-size:20px; margin:auto 2px;">.com</span></span> 
			© <?php echo date('Y'); ?> | All rights reserved <br>
			Email: info@obocircle.com
		</p>
	</div>
</body>
</html>