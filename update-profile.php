    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <link rel="stylesheet" type="text/css" href="./css/style-view-profile.css">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="heading">
                <h3>Personal Details</h3>
            </div>
            <div id="image">
                <div class="dp_container">
                    <img src="./images/users/123/img1.jpg" alt="Clement">				
                    <a href="update-display-picture.php" target="_blank">
                        <span class="fa fa-camera"></span> Edit
                    </a>
                </div>
            </div>
            <div id="user_info">
                <div class="sub_container">
                    <div>
                        <label><strong>First name</strong></label>
                        <span class="err" id="err_first_name"> * </span><br>
                        <input type="text" id="first_name" value="Clement" onblur="get_first_name()" placeholder="Your First name">
                    </div>
                    <div>
                        <label><strong>Last name</strong></label>
                        <span class="err" id="err_first_name"> * </span><br>
                        <input type="text" id="last_name" value="Mamogale" onblur="get_last_name()" placeholder="Your Surname">
                    </div>
                    <div>
                        <label><strong>Date of birth</strong></label>
                        <span class="err" id="err_date_of_birth"> * </span><br>
                        <input type="date" id="date_of_birth" onblur="get_date_of_birth()" min="<?php echo date("d-M-y"); ?>">
                    </div>                    
                    <div>
                        <label><strong>Gender</strong></label>
                        <span class="err" id="err_gender"> * </span><br>
                        <select id="gender" onchange="get_gender()">
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Other</option>
                        </select>
                    </div>
                </div>
                <div class="sub_container">
                    <div>
                        <label><strong>Phone Number</strong></label>
                        <span class="err" id="err_phone"> * </span><br>
                        <input type="text" id="phone" value="011475554" onblur="get_phone()" placeholder="Your primary phone number">
                    </div>
                    <div>
                        <label><strong>Email</strong></label>
                        <span class="err" id="err_your_email"> * </span><br>
                        <input type="email" id="your_emaillast_name" onblur="get_my_email_address()" value="clementine12354@yahoo.com" placeholder="Your primary email address">
                    </div>
                    <div>
                        <label><strong>Address</strong></label><br>
                        <input type="text" id="address_line_1" value="" onblur="get_address_line_1()" placeholder="Address line 1">
                        <span class="err" id="err_address_line_1"> * </span><br>
                        <input type="text" id="address_line_2" value="" onblur="get_address_line_2()" placeholder="Address line 2">
                        <span class="err" id="err_address_line_2"></span><br>
                        <input type="text" id="city" value="" onblur="get_city()" placeholder="City/Town">
                        <span class="err" id="err_city"> * </span><br>
                        <input type="text" id="address_code" value="" onblur="get_address_code()" placeholder="Address code">
                        <span class="err" id="err_address_code"> * </span>
                    </div>
                </div>
                <div class="sub_container">
                    <span class="err" id="update_profile_response"></span>
                    <button id="submit_changes" onclick="update_profile()">Submit changes</button>
                </div>
            </div>
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
	<script src="js/update-profile.js" type="text/javascript"></script>
	<script type="text/javascript">
 
    </script>
</body>      
</html>