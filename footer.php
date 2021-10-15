
    <br><br>
    <!--***********footer*************-->
	<div class="row" id="footer1">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="subscribe_footer">
				<span class="label">Join our mailing list for updates & discounted offers</span><br><br>
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
		<div class="col-md-5">
			<div class="footer_container" style="text-align: right">
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
		</div>
		<div class="col-md-5">
			<div class="footer_container" >
				<h3>Help Center</h3>
				<a href="faq.php">FAQ</a><br>
				<a href="#">File a report</a><br>
				<a href="./demo-videos.php">Demo Videos</a><br>
			</div>
        </div>
        <div class="col-sm-1"></div>
    </div>
	<div class="row" id="footer3">
        <div class="col-sm-1"></div>
        <div class="col-md-10">
			<div class="footer_container">
				<h4>Reach to us..</h4>
				<p style="color:#0066ff">Email: info@obocircle.com 
                <span class="social-media">
                    <!-- Add font awesome icons -->
                    <a href="https://www.facebook.com/clementine.mc.79" class="fa fa-facebook" target="_blank"></a>
                    <a href="https://www.twitter.com/clementine2829" class="fa fa-twitter" target="_blank"></a>
                    <a href="https://www.instagram.com/clementinemamogale/" class="fa fa-instagram " target="_blank"></a>
                    <a href="https://www.linkedin.com/mwlite/in/clementine-mamogale-6131aa174/" class="fa fa-linkedin " target="_blank"></a>
                </span>
                </p>
			</div>
        </div>
        <div class="col-sm-1"></div>
    </div>

	<div class="row" id="footer4">
        <div class="col-sm-1"></div>
        <div class="col-md-5">
            <div>
                <p>Obocircle.com Copyright © 2021 | All rights reserved</p>
            </div>
        </div>
        <div class="col-md-5">
            <small style="float: right; padding-right: 10%">
                <a href="privacy_policy.html">Privacy Policy</a> | 
                <a href="terms_of_use.html">Terms of Use</a> | 
                <a href="cookies.html" target="_blank">Cookies Policy</a>
            </small>            
		</div>
        <div class="col-sm-1"></div>
    </div>