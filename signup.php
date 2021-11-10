    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <?php 
//	if(!isset($_SESSION['reder'])) $_SESSION['reder'] = "signup.php";
/*	if(isset($_SESSION['s_id'])){
		if(isset($_SESSION['reder']) && $_SESSION['reder'] != 'signup.php')
			echo "<span style='display:none' id='red'>" . $_SESSION['reder'] . "</span>"; 
		else echo "<span style='display:none' id='red'></span>"; 
		?>
			<script type="text/javascript">
			 (function redirect(){
			 	let con = false;
			 	if(document.getElementById('red').innerHTML == "signup.php")
				 	con = confirm("You are currently logged in. You must log out to create new account.\nDo you want to logout?");
			 	if(con) window.location = "logout.php?log=account"
			 	else if($('#red').html() != "") window.location = $('#red').html();
			 	else window.location = "home.php";
			 	return;
			 }) ();
			</script>
		<?php
	}
*/
	require './server/signup-inc.php'; 
    ?>
	<link rel="stylesheet" type="text/css" href="./css/style-signup.css">
	<div class="row">
		<div class="col-sm-1"></div>
        <div class="col-sm-10" id="sign_body">
            <div style="margin-bottom:2%; color:green;">
                <h4>Creat your free account right now, and enjoy</h4>
            </div>
            <p style="color:blue; font-size:16px;"><?php echo $success_msg;?></p>
            <p style="color:red; font-size:16px;"><?php echo $err_msg;?></p>
            <form method="POST" id="signup_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <div class='sub_container'>
                    <div>
                        <label for="firstname">First name:</label>
                        <span class="err" id="err_f_name"> * <?php echo $err_firstname; ?></span>
                        <br>
                        <input type="text" id="f_name" name="firstname" onblur="get_f_name()" max="5" placeholder="Enter your Name" value="<?php echo $firstname; ?>"> 
                    </div>	
                    <div>
                        <label for="lastname">Last name:</label>
                        <span class="err" id="err_l_name"> * <?php echo $err_lastname; ?></span>
                        <br>
                        <input type="text" id="l_name" name="lastname" onblur="get_l_name()" placeholder="Enter your Surname" value="<?php echo $lastname; ?>">
                    </div>		
                    <div>
                        <label for="gender">Gender:</label>
                        <input type="radio" onclick="get_gender()" id="m" name="gender" value="M">Male
                        <input type="radio" onclick="get_gender()" id="f" name="gender" value="F">Female
                        <span class="err" id="err_gender"> * <?php echo $err_gender; ?></span>
                    </div>	
                    <div>
                        <label for="birthdate">Date of Birth:</label>
                        <span class="err" id="err_birthdate"> * <?php echo $err_birthdate; ?></span>
                        <br>
                        <?php $max_data = (date('Y') - 16) . "-" . date("m-d"); ?>
                        <input type="date" id="birthdate" name="birthdate" min="1975-01-01" max="<?php echo $max_data; ?>" 
                                onblur="get_birthdate()" value="<?php echo $birthdate; ?>">
                    </div>
                    <div>
                        <label for="cellphone1">Cell Number:</label>
                        <span class="err" id="err_cellphone1" > * <?php echo $err_cell_1; ?></span>
                        <br>
                        <input type="number" id="cellphone1" onblur="get_phone()" max="5" placeholder="Enter your phone number" name="cellphone1" value="<?php echo $cell_1; ?>">
                    </div>
                </div>
                <div class='sub_container'>
                    <div>
                        <label for="email">Email Address:</label>
                        <span data-toggle="tooltip" data-placement="bottom top auto"
                                title="Enter a working email because you will be required to validate it" 
                                class="glyphicon glyphicon-info-sign">
                        </span>
                        <span data-toggle="tooltip" data-placement="bottom top auto"
                                title="Supported email types are gmail, icloud, outlook, yahoo and yandex" 
                                class="glyphicon glyphicon-info-sign">
                        </span>
                        <span class="err" id="err_email"> * <?php echo $err_email; ?></span>
                        <br>
                        <input type="email" onblur="get_signup_email()" id="email" name="email" placeholder="Enter your valid email address" value="<?php echo $email; ?>">
                    </div>		

                    <div>
                        <label for="password1">Create Password: </label>
                        <span class="err" id="err_password"> * <?php echo $err_password; ?></span>
                        <br>
                        <input type="password" onblur="get_password()" id="password1" placeholder="Enter strong password" name="password1" value="<?php echo $password; ?>">
                        <span id="check_pass"></span>
                    </div>		

                    <div>
                        <label for="password2">Confirm Password:</label>
                        <span class="err" id="err_password2"> * <?php echo $err_password2; ?></span>
                        <br>
                        <input type="password" onblur="get_password2()" placeholder="Confirm your password" id="password2" name="password2">
                    </div>		

                    <div>
                        <label for="ref_code">Ref CODE:</label>
                        <span class="err" id="err_ref" > <?php echo $err_ref_code; ?></span>
                        <br>
                        <input type="number" id="ref_code" onblur="get_ref()" name="ref_code" 
                                    placeholder="Enter your friend ref code if you have one" value="<?php echo $ref_code; ?>">
                    </div>
                </div>
                <div class='sub_container'>
                    <br>
                    <p>
                        <span>
                            <input type="checkbox" required>
                        </span>
                        <strong> 
                            <span class="agree">
                                By registering an account with us, you agree to our 
                            </span>
                            <i><a href="terms_of_use.html">Terms & Services</a></i>
                        </strong>
                    </p>
                    <input type="button" id="send_data" class="btn btn-primary " value="Register Now" >
    <!--				<input type="button" id="cancel" onclick="window.location='login.php'" value='Cancel'>
    -->				<br>
                    <p style="padding:1% 0px;"> 
                        <a href="login.php"><i><strong>Already have an Account</strong></i></a>
                    </p>
                </div>
            </form>
        </div>
		<div class="col-sm-1"></div>
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
	<script src="js/signup.js" type="text/javascript"></script>
</body>      
</html>


