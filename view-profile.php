    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <?php
    if(!isset($_SESSION['s_id'])){
        ?>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div style="margin: 5% auto;">
                    <h4 style="color: red">You must be logged in to access this page</h4>
                    <p>Click <a href="./login.php">here</a> to login</p>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
        <?php
    }else{
        $user_id = $_SESSION['s_id'];
        $full_name = $gender = $date_of_birth = $phone = $email = $ref_code = $address = "";
        $sql = "SELECT users.first_name, users.last_name, users.gender, users.date_of_birth, users.phone, users.email, users.ref_code,
                       users_extended.address 
                FROM (users
                    INNER JOIN users_extended ON users.id = users_extended.user_id)
                WHERE users.id = \"$user_id\" LIMIT 1";
        
        //echo "SQL: " . $sql;
        require("./includes/conn.inc.php");
        $sql_results = new SQL_results();
        $results = $sql_results->results_profile($sql);
        if($results->num_rows > 0){
            while ($row = $results->fetch_assoc()) {
                $full_name = $row['first_name'] . " " . $row['last_name'];
                if($row['gender'] == "M") $gender = "Male";
                else if($row['gender'] == "F") $gender = "Female";
                else if($row['gender'] == "o") $gender = "Other";
                $date_of_birth = $row['date_of_birth'];
                $phone = $row['phone'];
                $email = $row['email'];
                $ref_code = $row['ref_code'];
                $address = $row['address'];
                
                break;
            }
        }
        ?>
        <link rel="stylesheet" type="text/css" href="./css/style-view-profile.css">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="heading">
                    <h3>Personal Details</h3>
                </div>
                <div id="image">
                    <div class="dp_container">
                        <?php
                            $image = (isset($_SESSION['s_dp']) && $_SESSION['s_dp'] != "") ? substr($_SESSION['s_id'], 7, 10) . "/" . $_SESSION['s_dp'] : "";
                        ?>
                        <img src="./images/users/<?php echo $image; ?>" alt="<?php echo $full_name; ?>">				
                        <a href="update-display-picture.php">
                            <span class="fa fa-camera"></span> Edit
                        </a>
                    </div>
                </div>
                <div id="user_info">
                    <div class="sub_container">
                        <p><strong>Full name</strong></p>
                        <span><?php echo $full_name; ?></span>
                    </div>
                    <div class="sub_container">
                        <p><strong>Date of birth</strong></p>
                        <span><?php echo $date_of_birth; ?></span>
                    </div>
                    <div class="sub_container">
                        <p><strong>Gender</strong></p>
                        <span><?php echo $gender; ?></span>
                    </div>
                    <div class="sub_container">
                        <p><strong>Contact</strong></p>
                        <span>
                            <span class="fas fa-phone"></span> <?php echo $phone; ?><br>
                            <span class="fas fa-envelope"></span> <?php echo $email; ?>
                        </span>
                    </div>
                    <div class="sub_container">
                        <p><strong>Address</strong></p>
                        <span><?php echo $address; ?></span>
                    </div>
                    <div class="sub_container"><br>
                        <?php
                            if(isset($_SESSION['s_profile_status']) && $_SESSION['s_profile_status'] != 1){
                                ?>
                                    <p><strong>Activate account:</strong></p>
                                    <span>
                                        Your account is not activated yet. Click <a href="./activate-account.php">here</a> to activate it.<br><br>
                                    </span>
                                <?php
                            }
                        ?>
                        <p><strong>Invite a friend:</strong></p>
                        <span>
                            Invite a friend to earn 35% of referals. Copy and share this link <a href="https://obocircle.com/signup.php?ref=<?php echo $ref_code; ?>">https://obocircle.com/signup.php?ref=<?php echo $ref_code; ?></a><br>
                            Or Share this code CODE: <?php echo $ref_code; ?> to be used on signup page as ref code
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
    <?php
    }        
    ?>

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