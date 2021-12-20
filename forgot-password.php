    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    <?php
        $msg = $email = $name = "";
        $err_email = " * "; 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            require("./includes/conn.inc.php");
            $db_login = new DB_login_updates();
            $connection = $db_login->connect_db("obo_users");

            if (empty($_POST["recover_email"]))
                $err_email = " * Email is required ";
            else {
                $email = check_inputs($_POST["recover_email"]);
                $email = strtolower($email);	
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $err_email = " * Unsupported email domain"; 
                    $email = "";
                }else{
                    $user_id = "";
                    $err_email = " * "; 
                    $sql = "SELECT id, email, first_name FROM users 
                            WHERE email = \"$email\" LIMIT 1";
                    $results = $connection->query($sql);
                    if($results->num_rows > 0){
                        $row = $results->fetch_assoc();
                        $recipient = $row['email'];
                        $user_id = $row['id'];
                        $username = $row['first_name'];
                        $msg = "<span style='color:blue'><br>
                                Hi, " . $row['first_name'] . "<br>
                                An activation link has been sent to this email address as provided " . $email . "
                                </span><br><br>";	
                        require './server/forgot-pass-reset-link.php';
                        $email = "";
                    }else{
                        $msg = "<span style='color:red; margin-bottom:1%;'><br>
                            Opps!...It seems like this email address is not registered with us. 
                            <br>Please make sure that you entered a correct email address, otherwise <a href=\"./signup.php\">create new account</a>  or <a href=\"./login.php\">login</a> </span><br><br>";
                    }
                }
            }
        }
        function check_inputs($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        function test_input($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>
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
    @media only screen and (max-width: 500px){
        #user_info .sub_container{
            width: 96%;
            border: 1px solid lightblue;
            padding: 2% 1%;
            margin: 2%;
            margin-top: 10%;
            border-radius: 15px;
        }
        #user_info .sub_container .recover input {
            width: 60%;
        }
        #footer4{display: none;}
    }
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
                            <span class="err"> <?php echo $err_email; ?></span><br>
                            <?php echo $msg; ?>
                            <input type="email" name="recover_email" value="<?php echo $email; ?>" required>
                            <input type="submit" value="Find Account">
                        </div>
                        <div class="btns">
                            <button id="login_btn" onclick='window.location="./login.php"'>Login</button>
                            <button id="register_btn" onclick='window.location="./singup.php"'>Register new account</button>
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
</body>      
</html>