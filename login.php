    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <?php
        require './server/validate_data.php';
        //check if they are logged in, if so let them know and give them an option to logout or redirect otherwise
		if (isset($_SESSION["s_id"])) {
			if(isset($_SESSION['redir']) && isset($_SESSION['redir']) != ""){
				echo "<span id='link'>" . $_SESSION["redir"] . "</span>";
			}else echo "<span id='link'>home.php</span>";
			?>
			<script type="text/javascript">
				let con = confirm("You are currently logged in, would you like to logout");
				window.location = ((con == true) ? "logout.php" : $("#link").html());
			</script>
			<?php
		}

        $errorMsg = "Invalid username or password";
		$errorMsgNamePass = $username = $password = "";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$usernameLower = strtolower($_POST["username"]);
			if (empty($usernameLower) || empty($_POST["password"])) {
				$errorMsgNamePass = $errorMsg;	
			} else {
				$username = check_inputs($usernameLower); 
				if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
					$errorMsgNamePass = $errorMsg;	
					$username = NULL;
				}
				$password = check_inputs($_POST["password"]);
				if (!preg_match("/^[a-zA-Z\s0-9\.\!\@\#\$\%\^\&\*\s]*$/", $password)){
					$errorMsgNamePass = $errorMsg;	
					$password = NULL;
				}
			}
			require("./includes/user.inc.php");
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
						<a id="forgot" href="forgot-password.php">Forgot Password?</a>
						<input type="button" style="color:red" onclick="window.location='signup.php'" value="Sign up">
					</div>
				</div>	
			</form>
		</div>
		<div class="col-sm-2" ></div>
	</div>
    <!--footer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="the_footer"></div>
        </div>
    </div>
    <!--end footer-->   
    <!--script-->
	<script src="js/footer.js" type="text/javascript"></script>
</body>      
</html>