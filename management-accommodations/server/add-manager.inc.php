<?php session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_SESSION['s_id']) || isset($_SESSION['s_user_type'])){
            if($_SESSION['s_user_type'] != "premium_user"){
                require_once '../access_denied.html';
                return;
            }
            $user_id = $_SESSION['s_id'];
            require("../../includes/conn.inc.php");
            $user = (isset($_REQUEST['user']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['user'])) ? $_REQUEST['user'] : "";
            $payload = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
            if($payload == ""){
                echo "Internal error occured. Please reload page and try again";
                return;
            }
        }else{
            echo "Minor error occured. Please reload page and try again.";
            return;
        }
        $added_by = $_SESSION['s_id'];
        if($added_by == $user){
            echo "<h5 style='color: red'>You cannot add yourself as a manager to this accommodation</h5>";
            return;   
        }
        require_once '../../includes/conn.inc.php';
        $db_login = new DB_login_updates();
        $connection = $db_login->connect_db("accommodations");
        $today_date = date("d/m/Y h:i:s");
        $sql = "INSERT INTO managers VALUES(\"$payload\", \"$user\", \"$added_by\", \"$today_date\", \"2\") ";
        if ($connection->query($sql) == true){
            echo "<br><h5 style='color: blue'>Your request has been send successfully</h5>";
            echo "<p>An email has been send has been send to them and also a notitifcation has been send to their profile</p>";
            
            $sql = "SELECT first_name, last_name, email FROM users WHERE id = \"$user\" LIMIT 1";
            $sql_results = new SQL_results();
            $results = $sql_results->results_profile($sql);
            $a_name = $full_name = $email = "";
            if($results->num_rows == 1){
                $row = $results->fetch_assoc();
                $full_name = strtoupper(substr($row['first_name'], 0, 1)) . substr($row['first_name'], 1) . " ";
                $full_name .= strtoupper(substr($row['last_name'], 0, 1)) . substr($row['last_name'], 1);
                $email = $row['email'];
            }
            
            $sql = "SELECT name FROM accommodations WHERE id = \"$payload\" LIMIT 1";
            $results = $sql_results->results_accommodations($sql);
            if($results->num_rows == 1){
                $row = $results->fetch_assoc();
                $a_name = $row['name'];
            }
            
            //write notification 
            $notification_id = password_hash(rand(0, 100), PASSWORD_DEFAULT);
            $notification_id = substr($notification_id,7,10);
            while(!preg_match("/^[a-zA-Z0-9]*$/", $notification_id)) {
                $notification_id = password_hash($notification_id, PASSWORD_DEFAULT);
                $notification_id = substr($notification_id,7,10);
            }
            $notification = "You have been invited to be a manager for this accommodation " . $a_name . ". Click <a href='./dashboard.php'>here</a> 
                            accept the offer. <br>Please check your email address you provided on sign-up for details about this invitation";

			$this_date = date("d/m/Y H:i");
            $sql_notification = "INSERT INTO notifications(notification_id, user_id, n_message, n_date)
                            VALUES(\"$notification_id\", \"$user\", \"$notification\", \"$this_date\")";
            if ($connection->query($sql_notification)){
                //do nothing
            };                                           
                                         
            //send email
            $name = "Obocircle";
            $subject = "Manager request";
            $recipient = $email;
            $email = "no-reply@obocircle.com";
            $message = "
Dear " . $full_name . ", 

Your have been invited to be a manager for the accommodations " . $a_name . ". 

Please go to the link https://obocircle.com/dashboard.php and navigate to 'become a manger' under manager panel to accept the request or reject it. You going to need the person's ref number to aapprove their request. This is made so that random people do not manager other people's accommodations without their knowledge.  

Warm regards, 

Obocircle.com
https://obocircle.com/

Obocircle.com copyright © " . date('Y') . " | all rights reserved
Powered and maintained by https://www.mcnetsolutions.co.za [McNet Solutions (Pty) Ltd]";
            //require '../../server/send-email.php';
            
        }
    }else{
        echo "<span style='color: red'>Unknow request</span>";
        return;
    }
?>