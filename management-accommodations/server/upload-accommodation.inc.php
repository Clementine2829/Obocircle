<?php session_start();
    require './validate_data.php';
    if($_SERVER["REQUEST_METHOD"] == "POST"){	        
        if(!isset($_SESSION['s_first_name']) || !isset($_SESSION['s_id']) || 
            !isset($_SESSION['s_profile_status']) || !isset($_SESSION['s_user_type'])){
            require "../offile.html";
            return;
        }else if(isset($_SESSION['s_profile_status']) && !$_SESSION['s_profile_status']) {
            require "../access_denied.html";
            return;
        }
        require_once '../includes/conn.inc.php';
        /*$temp_id = $_SESSION['s_id'];
        $sql = "SELECT manager FROM accommodation WHERE manager = \"$temp_id\" LIMIT 10";
        $sql_results = new SQL_results();
        $res = $sql_results->results_a($sql);
        $count = 0;
        if($res->num_rows > 0)
            $count = $res->num_rows;
        */

        $name = $address1 = $address2 = $address3 = $town = $code = $checkbox1 = $address = "";
        $checkbox2 = $checkbox3 = $about = "";

        if(isset($_REQUEST["name"]) && preg_match("/^[a-zA-Z0-9\'\.\@\,\s]*$/", $_REQUEST["name"]) &&
            $_REQUEST["name"] != "") $name = check_inputs($_REQUEST["name"]); 
        else $name = "";
        if(isset($_REQUEST['address']) && $_REQUEST['address'] == "google"){
            $address = $_REQUEST['address'];
        }else{
            if(isset($_REQUEST["address1"]) && preg_match("/^[a-zA-Z0-9\'\.\@\,\s]*$/", $_REQUEST["address1"]) &&
                $_REQUEST["address1"] != "") $address1 = check_inputs($_REQUEST["address1"]); 
            else echo "<br>Error address1";
            if(isset($_REQUEST["address2"]) && preg_match("/^[a-zA-Z0-9\'\.\@\,\s]*$/", $_REQUEST["address2"]) &&
                $_REQUEST["address2"] != "") $address2 = check_inputs($_REQUEST["address2"]); 
            else $address2 = "";
            if(isset($_REQUEST["town"]) && preg_match("/^[a-zA-Z0-9\'\.\@\,\s]*$/", $_REQUEST["town"]) &&
                $_REQUEST["town"] != "") $town = check_inputs($_REQUEST["town"]); 
            else $town = "";
            if(isset($_REQUEST["code"]) && preg_match("/\d{4}/", $_REQUEST["code"]) &&
                $_REQUEST["code"] != "") $code = check_inputs($_REQUEST["code"]); 
            else $code = "";
        }
        if(isset($_REQUEST["about"]) && preg_match("/^[a-zA-Z0-9\'\.\@\,\(\)\s\!\?\"\%]*$/", $_REQUEST["about"]) &&
            $_REQUEST["about"] != "") $about = check_inputs($_REQUEST["about"]); 
        else $about = "";

        if(isset($_REQUEST["checkbox1"]) && $_REQUEST["checkbox1"] == 1) 
                $checkbox1 = check_inputs($_REQUEST["checkbox1"]); 
        else $checkbox1 = 0;
        if(isset($_REQUEST["checkbox2"]) && $_REQUEST["checkbox2"] == 1) 
                $checkbox2 = check_inputs($_REQUEST["checkbox2"]); 
        else $checkbox2 = 0;
        if(isset($_REQUEST["checkbox3"]) && $_REQUEST["checkbox3"] == 1) 
                $checkbox3 = check_inputs($_REQUEST["checkbox3"]); 
        else $checkbox3 = 0;
        if(isset($_REQUEST["declare"]) && $_REQUEST["declare"] == 1) 
            $declare = date("d/m/Y H:i:s");
        else $declare = 0;

        //	if(($checkbox1 != 1 && $checkbox2 != 1 && $checkbox3 != 1) && $declare != 1) return;
            if(($checkbox1 != 1 && $checkbox2 != 1 && $checkbox3 != 1) && $declare != 1) 
                echo "Error in declare or one of the check boxes ";

        //	echo "Name and About  " . $name . " " . $about ; return;
        /*	echo "Name: " . $name;
            echo "<br>Address: " . $address1  ;
            echo "<br>Town: " . $town  ;
            echo "<br>Code: " . $code  ;
            echo "<br>Declare: " . $declare;
            echo "<br>CheckBoxes-> 1: " . $checkbox1 . " 2: " . $checkbox2 . " 3: " . $checkbox3;
        */
            if ($name != "" && ($address != "" || ($address1 != "" && $town != "" && $code != "")) && $declare != 0 &&
                ($checkbox1 == 1 || $checkbox2 == 1 || $checkbox3 == 1)){

        //echo "Returned here "; return;
                $id = rand_text($name, 40);
                $rooms = rand_text($name, 35);
                $addr = rand_text($name, 30);
                //rooms
                $single = rand_text($name, 20);
                $double = rand_text($name, 20);
                $three = rand_text($name, 20);

                $db_login = new DB_login_updates();
                $connection = $db_login->connect_db("accommodations");

                $name = mysqli_real_escape_string($connection, $name);
                if($address == ""){
                    $address = mysqli_real_escape_string($connection, $address);
                }else{
                    $address1 = mysqli_real_escape_string($connection, $address1);
                    $address2 = mysqli_real_escape_string($connection, $address2);
                    $address3 = mysqli_real_escape_string($connection, $address3);
                    $town = mysqli_real_escape_string($connection, $town);
                    $code = mysqli_real_escape_string($connection, $code);
                }
                $about = mysqli_real_escape_string($connection, $about);

                $username =	$_SESSION['s_id'];
                $insert_main_table = "INSERT INTO accommodations (id, name, manager, about, date_posted)
                                        VALUES ('$id', '$name','$username', '$about', '$declare')";	
                if ($connection->query($insert_main_table)) echo "success";
                else echo "Error uploading this accommoddation. please try again";
                
                $my_address = "";
                if($address != ""){
                    $my_address = $address;
                }else{
                    if($address2 == "" && $address3 == "")
                        $my_address = $address1 . '<br>' . $town;
                    else if($address2 == "" )
                        $my_address = $address1 . '<br>' . $address3 . '<br>' . $town;
                    else if($address3 == "" )
                        $my_address = $address1 . '<br>' . $address2 . '<br>' . $town;		
                    else $my_address = $address1 . '<br>' . $address2 . '<br>' . $address3 . '<br>' . $town;
                }
                $my_address = "";
                $insert_rooms_table = "INSERT INTO rooms (room_id, accommo_id, single_sharing, double_sharing, multi_sharing)
                                       VALUES ('$rooms', '$id', '$checkbox1', '$checkbox2', '$checkbox3')";
                if (!$connection->query($insert_rooms_table)) 
                    echo "<br>Error setting up your accommodation. Please try again";			
                $insert_address_table = "INSERT INTO address
                                       VALUES ('$addr', '$id', '$address')";
                if (!$connection->query($insert_address_table)) 
                    echo "<br>Error setting up your accommodation. Please try again<br> address error";			

                $notification = "Your accommodation has been uploaded successfully.<br>Now waiting for the manager to overview it and set it to display for the public to view. In the meantine, please complete it fully by clicking <a href='./dashboard.php'>here</a>";
                $this_date = substr($declare, 0, 16);
                $notification_id = rand_text($name, 10);
                $sql_notification = "INSERT INTO notifications(notification_id, user_id, n_message, n_date)
								VALUES(\"$notification_id\", \"$username\", \"$notification\", \"$this_date\")";
                $con = $db_login->connect_db("obo_users");
				if ($con->query($sql_notification)){
				    //do nothing
                }                
                $con->close();
                $connection->close();
            }
    }else{
        echo "<h5 style='color: red'>Invalid request</h5>";
        return;
    }
    
    function rand_text($txt, $len){
		$txt = password_hash($txt, PASSWORD_DEFAULT);
		$txt = substr($txt,7,$len);
		while(!preg_match("/^[a-zA-Z0-9]*$/", $txt) || strlen($txt) < $len){
			$txt = password_hash($txt, PASSWORD_DEFAULT);
			$txt = substr($txt,7,$len);
		}
		return $txt;			
	}
	?>