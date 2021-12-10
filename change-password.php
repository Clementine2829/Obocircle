    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <link rel="stylesheet" type="text/css" href="./css/style-view-profile.css">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div class="heading">
                <h3>Change password</h3>
            </div>            
            <div id="user_info">
                <form id="change_password_form" method="post" action="change-password.php">
                    <div class="sub_container">
                        <div class="sub_container">
                            <div>
                                <label><strong>Old password</strong></label>
                                <span class="err" id="err_old_password"> * </span><br>
                                <input type="password" id="old_password" value="" onblur="get_old_password()" placeholder="Your old password">
                            </div>
                            <div>
                                <label><strong>New password</strong></label>
                                <span class="err" id="err_new_password"> * </span><br>
                                <input type="password" id="new_password" value="" onblur="get_new_password()" placeholder="New password">
                            </div>
                            <div>
                                <label><strong>Confirm password</strong></label>
                                <span class="err" id="err_confirm_password"> * </span><br>
                                <input type="password" id="confirm_password" value="" onblur="get_old_password()" placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                    <div class="sub_container">
                        <span class="err" id="update_profile_response"></span>
                        <input type="button" id="change_password" value="Submit changes">
                    </div>
                </form>
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
	<script src="js/change-password.js" type="text/javascript"></script>
	<script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $('#change_password').click(function(){
                let old_password = get_old_password;
                let new_password = get_new_password;
                let confrim_password = get_confirm_password;
                if(old_password == "" || new_password == "" || confirm_password == "") return;
                $('#change_password_form').submit();
            });
        }); 
        function get_old_password(){
            let password = $("#old_password").val();
            let err = $("#err_old_password");
            if(password == ""){
                err.html("Old password is required")
                return "";
            }else if(password.length  < 8 ){
                err.html("Password is too short")
                return "";
            }
            err.html(" * ")
            return password;
        }
        function get_new_password(){
            let password = $("#new_password").val();
            let err = $("#err_new_password");
            if(password == ""){
                err.html("New password is required")
                return "";
            }else if(password.length  < 8 ){
                err.html("Password is too short")
                return "";
            }
            err.html(" * ")
            return password;
        }        
        function get_confirm_password(){
            if($("#confrim_password").val() != $("#new_password").val()){
                $("#err_confrim_password").html("Passwords does not match")
                return "";
            }
            $("#err_confrim_password").html(" * ")
            return $("#confrim_password").val();
        }
    </script>
</body>      
</html>