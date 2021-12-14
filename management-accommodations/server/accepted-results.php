<?php session_start();
   if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_SESSION['s_id']) || isset($_SESSION['s_user_type'])){
            if($_SESSION['s_user_type'] != "premium_user"){
                require_once '../access_denied.html';
                return;
            }
            $user_id = $_SESSION['s_id'];
            require("../includes/conn.inc.php");
            $payload = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
            if($payload == ""){
                $sql = "SELECT id, name
                        FROM accommodations
                        WHERE manager=\"$user_id\" LIMIT 15";

                $sql_results = new SQL_results();
                $results = $sql_results->results_accommodations($sql);
                $div = "";
                if($results->num_rows != 1){
                    echo "Minor error occured. Please reload page and try again.";
                    return;
                }else if($results->num_rows == 1){
                    $row = $results->fetch_assoc();
                    $payload = $row['id'];    
                }
            }
        }else{
            echo "Minor error occured. Please reload page and try again.";
            return;
        }
  		$sql = $load = "";
		if(isset($_REQUEST['data']) && preg_match('/^[a-zA-Z0-9\,]+$/', $_REQUEST['data']))
			$load = $_REQUEST['data'];
		else{
            echo "Internal errror occured. Please reload page and try again.";
			return;
		}

		require_once '../../includes/conn.inc.php';
		$db_login = new DB_login_updates();
		$connection = $db_login->connect_db("applications");
		$new_load = explode(",", $load);
		foreach ($new_load as $new_data => $value) {
			$temp_id = $value;
			$nowDate = date("Y/m/d/ H:i:s");
			$sql_update = "UPDATE new_applicants 
						   SET a_status = 1,
						   status_date = $nowDate
						   WHERE id = \"$temp_id\"";
			if ($connection->query($sql_update) == true){
				//verything is set right, send them email to let them know of this 
				$full_name = $a_name = $a_id = $email = $recipient = "";
				$a_id = $temp_id;
				$sql = "SELECT full_names, surname, email, accommodation 
						FROM new_applicants
						WHERE id = \"$temp_id\" AND a_status = 1
						LIMIT 1";
				$sql_results = new SQL_results();
				$results = $sql_results->applications($sql);
				if($results->num_rows > 0){
					$row = $results->fetch_assoc();
                    if(true){
                        $full_name = strtoupper(substr($row['surname'], 0, 1)) . substr($row['surname'], 1); 
                        $full_name .= " " . strtoupper(substr($row['full_names'], 0, 1)) . substr($row['full_names'], 1); 
                        $email = $row['email'];
                        $temp_id = $row['accommodation'];
					}
				}
				$sql = "SELECT name 
						FROM accommodation
						WHERE id = \"$temp_id\"
						LIMIT 1";
				$sql_results = new SQL_results();
				$results = $sql_results->results_accommodations($sql);
				if($results->num_rows > 0){
					$row = $results->fetch_assoc();
                    if(true){
                        $a_name = strtoupper(substr($row['name'], 0, 1)) . substr($row['name'], 1); 
					}
				}

				/*
				Set the following before using this file
				$name -> Name from where the email is from
				$subject -> subject of the email
				$email -> your email address, or where the eamil is from 
				$recipient -> the address where the message is sent to
				$message-> the message 
				*/
				$name = "Obocircle";
				$subject = "Accommodation applications status";
				$recipient = $email;
				$email = "no-reply@obocircle.com";
				$message = "
Dear " . $full_name . ", 

This is to let you know that your applications to apply for accommodation at " . $a_name . " has been accepted by the manager. 

Follow this link http://localhost:9090/dashboard/obocircle/view-my-applications.php to view and either accept or reject their offer incase you've found a place already.

NB. This is a formal confirmation of you application being accepted from Obocircle, you might expect a seperate communication from the accommodation specified either via email or call.

Thank you for choosing us. Please can you take few minutes of your time to participate in this survey bolow.
https://obocircle.com/survey.php?accommodation=" . $a_id . "
This survey is anonymous, it is used to measure the level of service that we provide to our clients and to let us know where and how to improve for better services.  
				
Warm regards, 

Obocircle.com
https://obocircle.com/

Obocircle.com copyright © " . date('Y') . " | all rights reserved
Powered and maintained by https://www.mcnetsolutions.co.za [McNet Solutions (Pty) Ltd]";
				require '../../send-msg.php';
			}
		}
		$connection->close();
	}else{
		echo "<div style='color: red; padding: 2% 1px;'>
					<b>Error loading data.</b>
					<br>Link seems to be broken. 
					<br>Please reload page
				<div>";
		return;

	}
    function test_input($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>