    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

<style rel="stylesheet" type="text/css">
    #user_info{
        margin: 8% auto 1% auto;
    }
    #user_info .sub_container{
        text-align: left;
        float: left;
        width: 60%;
        border: 1px solid lightblue;
        padding: 2% 1%;
        margin: 2% 20%;
        border-radius: 15px;
    }
    #user_info .sub_container h5{
        padding-bottom: 2%;
        border-bottom: 1px solid skyblue;
    }
    #user_info .sub_container .recover{
        padding-bottom: 4%;
        border-bottom: 1px solid skyblue;
    }
    #user_info .sub_container .recover input{
        border: 1px solid lightblue;
        padding: 1% 3%;
        width: 50%;
        outline: none;
    }
    #user_info .sub_container .recover input[type=submit]{
        width: auto;
        background-color: #007bff;
        color: white;        
    }
    
    #user_info .sub_container .btns{
        margin-top: 3%;
    }
    #user_info .sub_container .btns button{
        float: left;
        border-radius: 12px;
        border: 2px solid gray;
        padding: 1% 3%;
        background-color: gray;
        color: white;
    }
    #user_info .sub_container .btns button:nth-child(2){
        margin-left: 3%;
    }
    #user_info .sub_container .btns button:hover{
        background-color: white;
        color: gray;
    }
    #change_password{
        border: 2px solid gray;
        padding: 5px 10px;
        margin-top: 4%;
        width: 25%;
        background-color: gray;
        color: white;
    }
    #change_password:hover{
        color: gray;
        background-color: white;
    }

    #user_account{display: none}
    #footer1, 
    #footer2{display: none;}
    #footer3{margin-bottom: 0px;}
    #footer4{margin-top: 0px;}
</style>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="user_info">
                <form id="forgot_password_form" method="post" action="forgot-password.php">
                    <div class="sub_container">
                        <h5>Recover Your Account</h5>
                        <div class="recover">
                            <label for="email">Email address: </label>
                            <span class="err"> * </span><br>
                            <input type="email" name="recover_email" required>
                            <input type="submit" value="Find Account">
                        </div>
                        <div class="btns">
                            <button id="login_btn">Login</button>
                            <button id="register_btn">Register new account</button>
                        </div>
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
            $("#login_btn").click(function(){window.location = './login.php'})
            $("#register_btn").click(function(){window.location = './signup.php'})
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