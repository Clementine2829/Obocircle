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
                    <p><strong>Full name</strong></p>
                    <span>Clement Mamogale</span>
                </div>
                <div class="sub_container">
                    <p><strong>Date of birth</strong></p>
                    <span>25 Jun 2001</span>
                </div>
                <div class="sub_container">
                    <p><strong>Gender</strong></p>
                    <span>Male</span>
                </div>
                <div class="sub_container">
                    <p><strong>Contact</strong></p>
                    <span>
                        <span class="fas fa-phone"></span> 011 478 1474<br>
                        <span class="fas fa-envelope"></span> clementine123456987@gmail.com
                    </span>
                </div>
                <div class="sub_container">
                    <p><strong>Address</strong></p>
                    <span>
                        150 Smith Street<br>
                        Braamfontein<br>
                        Johannesburg<br>
                        2002
                    </span>
                </div>
                <div class="sub_container"><br>
                    <p><strong>Invite a friend:</strong></p>
                    <span>
                        Invite a friend to earn 35% of referals. Copy and share this link <a href="https://obocircle.com/signup.php?ref=128172">https://obocircle.com/signup.php?ref=128172</a><br>
                        Or Share this code CODE: 128172 to be used on signup page as ref code
                    </span>
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
</body>      
</html>