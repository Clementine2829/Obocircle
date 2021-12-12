    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <link rel="stylesheet" type="text/css" href="./css/activate-contact-us.css">
    <div class="row">
        <div class="col-sm-1" ></div>
        <div class="col-sm-10" >
            <div class="form_container">
                <div>
                    <h3>Get in touch</h3>
                    <p>Hi there, We're here to help and attend to any quiries that you might 
                    be having. Please hit us on the form </p>
                </div>
                <div>
                    <span id="success_msg"></span>
                    <form method="post">
                        <div>
                            <div>
                                <span><b>Full Name</b></span>
                                <span class="err" id="name_err"> * </span><br>
                                <input type="text" id="name" onblur="sname()" placeholder="Enter your name and surname">
                            </div>
                            <div>
                                <span><b>Email address</b></span>
                                <span class="err" id="email_err"> * </span><br>
                                <input type="email" id="email" onblur="semail()" placeholder="Enter your Email Address">
                            </div>
                            <div>
                                <span><b>Subject</b></span>
                                <span class="err" id="subject_err"> * </span><br>
                                <input type="text" id="subject" onblur="ssubject()" placeholder="Message Subject">
                            </div>
                        </div>						
                        <div>
                            <span><b>Message</b></span>
                            <span class="err" id="message_err"> * </span><br>
                            <textarea id="message" onblur="smessage()" placeholder="Type your message here..."></textarea>
                        </div>
                        <input type="button" value="Send Message" onclick="send_msg()" >
                    </form>
                </div>
            </div>
            <div class="form_container" style="color:red">
                Email us at: <u>info@obocircle.com</u>
            </div>
        </div>
        <div class="col-sm-1" ></div>
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
	<script src="js/contact-us.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    </script>
</body>      
</html>