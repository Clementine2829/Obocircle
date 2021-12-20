    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    <?php
        
        if(!isset($_SESSION['s_id'])){
            ?>
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <br><br><br><div>
                    <?php require_once "./offline.html"; ?>
                </div>
                <div class="col-sm-1"></div>
            </div>
            <?php
            return;
        }
        $msg = "";
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $msg = "Invalid activation code. Please try again";   
            $activation_code = (isset($_POST['activate_account']) && preg_match('/\d{6}/', $_POST['activate_account'])) ? $_POST['activate_account'] : "";
            if($activation_code != ""){
                $user = $_SESSION['s_id'];
                $sql = "SELECT expire_date 
                        FROM activate_account 
                        WHERE user_id = \"$user\" AND veri_link = \"$activation_code\" LIMIT 1";
                require("./includes/conn.inc.php");
                $sql_results = new SQL_results();
                $results = $sql_results->results_profile($sql);
                if($results->num_rows > 0){
                    $data = $results->fetch_assoc();
                    $today_date = strtotime(date("Y-m-d"));
                    $expire_date = strtotime(preg_replace('[/]', '-', $data['expire_date']));
                    
                    $db_login = new DB_login_updates();
                    $connection = $db_login->connect_db("obo_users");

                    if($expire_date != "" && $today_date > $expire_date){
                        $msg = "This code has expired, please request another one";
                    }else if($today_date == $expire_date){
                        $_SESSION['s_profile_status'] = "1";
                        $msg = "<span style='color: blue'>Account has been activated successfully</span>";
                        $sql = "UPDATE users_extended
                                SET profile_status = \"1\"
                                WHERE user_id = \"$user\"";
                        if ($connection->query($sql)) {
                            //do nothing
                        }
                    }
                    $sql = "DELETE 
                            FROM activate_account 
                            WHERE user_id = \"$user\" AND veri_link = \"$activation_code\"";
                    if ($connection->query($sql)) {
                        //do nothing
                    }
                }
            }
        }
    ?>  
    <link rel="stylesheet" type="text/css" href="./css/activate-account.css">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="user_info">
                <form id="activate_account_form" method="POST" action="activate-account.php">
                    <div class="sub_container">
                        <h5>Activate account</h5>
                        <p>An activation code has been send to your email address you provided on signup. You can use the button below to request another one</p>
                        <div class="recover">
                            <label for="number">Enter 6 digit code: </label>
                            <span class="err"><?php echo $msg; ?> </span><br>
                            <input type="number" placeholder="Enter 6 digit code" name="activate_account" required>
                        </div>
                        <div class="btns">
                            <button id="activate_account_btn">Activate</button>
                            <button id="resend_code_btn" onclick="resend_code()">Resend code</button>
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
            $('[data-toggle="tooltip"]').tooltip();
            $('#resend_code_btn').click(function(){
                
            });
        });
        function resend_code(){
            let url = "./server/resend-code.php";
            send_data(url, displayer_helper, "");
        }
        function displayer_helper(d, l){
            if(d == "success"){
                alert("An activation code has been been send to your email address as provided on our system, please check your inbox ");
                document.getElementById('resend_code_btn').remove();
            }else if(d == "activated"){
                alert("Account activated already");
                window.location = "./home.php";
            }else{
                alert(d)
            }
        }
    </script>
</body>      
</html>