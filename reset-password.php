    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

	<style type="text/css">
		#logo{
			margin: 1px 1px 5px 1px;
			text-align: left;
		}
		#logo img{
			width: 250px;
			height: 50px;

		}
		.account_holder{
			border: 2px solid lightblue;
			margin: 5% 15%;
			padding: 15px;
			border-radius: 10px;
		}
		.account_holder input[type=password]{
			width: 50%;
			padding: 3px 5px;
			border: 1px solid skyblue;
		}
		.account_holder input[type=submit]{
			background-color: red;
			padding: 3px 10px;
			width: 25%;
			color: white;
			border: 1px solid red;
		}
		.err{color: red;}
        #user_account{display: none}
        #footer1, 
        #footer2{display: none;}
        #footer3{margin-bottom: 0px;}
        #footer4{margin-top: 0px;}
		@media only screen and (max-width: 800px){

		}
		@media only screen and (max-width: 500px){
		    #account_holder{
		        width: 98%;
		        margin: 1%;
		    }
		    .account_holder input[type=password]{
		        width: 65%;
		    }
		    .account_holder input[type=password]{
		        width: auto;
		        padding: 1% 8%;
		    }
            #footer3{display: none;}		
		}
	</style>
	<?php
		if (isset($_SESSION["s_id"]) && isset($_SESSION["s_user_type"])) {
			?>
			<script type="text/javascript">
				window.location ="view-profile.php";
			</script>
			<?php
		}
		$user_id="";
        $link = (isset($_REQUEST['link'])) ? $_REQUEST['link'] : "";
		$link_error = '
					<div style="margin: 10%; color:red">
						<p><b>
							Link seems to be invalid, either it has expired or there was a typo if you typed it manually.
							<br>Please go to your email box and click on the provided email. Alternatively 
							click <a href="https://obocircle.com/forgot-password.php">here</a> to request another link.
						</b></p>
					</div>
                    <!--footer-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="the_footer"></div>
                        </div>
                    </div>
                    <!--end footer-->   
                    <!--script-->
                    <script src="js/validate_email.js" type="text/javascript"></script>
                    <script src="js/footer.js" type="text/javascript"></script>
                </body>      
                </html>';
		require("./includes/conn.inc.php");
		$sql = "SELECT user_id FROM reset_pass 
				WHERE reset_link = \"$link\" LIMIT 1";
		$sql_results = new SQL_results();
		$results = $sql_results->results_profile($sql);	
		if($results->num_rows == 1){
			$row = $results->fetch_assoc();
            //validate id
            $temp_id = $row['user_id'];	
            $sql = "SELECT id, first_name FROM users WHERE id = \"$temp_id\" LIMIT 1";
            $results = $sql_results->results_profile($sql);	
            if($results->num_rows < 1){
                echo $link_error;
                return;
            }
		}else{
			echo $link_error;
			return;
		}

		$password = $password2  = "" ;
		$err_password = $err_password2 = $success_msg = "";	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (empty($_POST["password1"]))
				$err_password = " New password is required";
			else $password = $_POST["password1"];
			if (empty($_POST["password2"]))
				$err_password2 = " Confirm password is required";
			else $password2 = $_POST["password2"];
			if($password && $password2){
				$password = check_inputs($_POST["password1"]);
				$password2 = check_inputs($_POST["password2"]);

				if (!preg_match("/^[a-zA-Z0-9\!\@\#\%\&\?]+$/", $password)) {
					$err_password = " Invalid use of some special characters, only ! @  # % & ? can bee used";
				}elseif (strlen($password) < 8 || strlen($password) > 25) {
					$err_password = " Password is too short/long, Min is 8, Max 25";
				}elseif ($password != $password2) {
					$err_password2 = "Password does not match";
				}else{
			
					$db_login = new DB_login_updates();
					$connection = $db_login->connect_db("obo_users");
					$sql = "SELECT user_id FROM reset_pass 
							WHERE reset_link = \"$link\" LIMIT 1";
					$results = $connection->query($sql);
					if($results->num_rows > 0){
						$row = $results->fetch_assoc();
                        $user_id = $row['user_id'];
                        $hash = password_hash($password, PASSWORD_DEFAULT);

                        $sql_delete = "DELETE FROM reset_pass WHERE user_id = \"$user_id\"";
                        if (!$connection->query($sql_delete)){
                            //do something...
                        }
                        $sql_update = "UPDATE users 
                                       SET password = \"$hash\"
                                       WHERE id = \"$user_id\"";
                        if (!$connection->query($sql_update)) 
                            echo "<br>Error updating details. Please try again";
                        else {
                            $success_msg = "Password updated successfully.<br>
                            Click <a href='./login.php'>here</a> to login
                            <br>";
                            $link = "pass";
                            $password = "";
                        }
					}else{
						echo $link_error;
							return;
					}
					$connection->close();
				}
			}
		}
		function check_inputs($data){
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}	
	?>
	<br><br>
	<div class="row" >
		<div class="col-sm-2" ></div>
		<div class="col-sm-8">
			<form method="POST" action="reset-password.php?link=<?php echo $link;?>">
				<div class="account_holder" >
					<span style="color:blue; font-size:16px;"><?php echo $success_msg;?></span>
					<p style="border-bottom: 1px solid lightblue; width:100%; font-size:20px;">
						<b>Recover Your Account</b>
					</p>		
					<div class="form-group"  style="margin-top:1%;">
						<div>
							<label for="password1">Create New Password: </label>
							<br>
							<input type="password" name="password1" value="<?php echo $password; ?>">
							<span class="err"> * <?php echo $err_password; ?></span>
						</div>		
						
						<div>
							<label for="password2">Confirm Password:</label>
							<br><input type="password" name="password2">
							<span class="err"> * <?php echo $err_password2; ?></span>
						</div>	
						<br>
						<input type="submit" value="Submit">	
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
    <script src="js/validate_email.js" type="text/javascript"></script>
    <script src="js/footer.js" type="text/javascript"></script>
</body>      
</html>