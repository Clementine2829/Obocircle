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

        echo "Returned here "; return;
                $id = rand_text($name, 40);
                $rooms = rand_text($name, 35);
                //rooms
                $single = rand_text($name, 20);
                $double = rand_text($name, 20);
                $three = rand_text($name, 20);

                $db_login = new DB_login_updates();
                $connection = $db_login->connect_db("accommodations");

                $name = mysqli_real_escape_string($connection, $name);
                if(address == ""){
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
                if (!$connection->query($insert_main_table)) {
        			echo "Error: " . $connection->error;
        //            echo "<br>Error uploading your accommodation. Please try again";			
                }else{
                    $connect = $db_login->connect_db("obo_users");
                    $sql_update_client =  "UPDATE veri_clients SET upload_a = upload_a + 1 
                                            WHERE client = \"$username\"";
                    if (!$connect->query($sql_update_client)) echo "Error occured";
                    $_SESSION['s_upload_a']++;   
                }
                unset($username);

                $insert_user_rating_table = "INSERT INTO user_ratings (rating_id, accommo_id)
                                                VALUES ('$user_ratings', '$id')";
                if (!$connection->query($insert_user_rating_table)) 
                    echo "<br>Error setting up your accommodation. Please try again";			
        //			echo "Error: " . $connection->error;
                $my_address = "";
                if($address2 == "" && $address3 == "")
                    $my_address = $address1 . '<br>' . $town;
                else if($address2 == "" )
                    $my_address = $address1 . '<br>' . $address3 . '<br>' . $town;
                else if($address3 == "" )
                    $my_address = $address1 . '<br>' . $address2 . '<br>' . $town;		
                else $my_address = $address1 . '<br>' . $address2 . '<br>' . $address3 . '<br>' . $town;

        //	echo "<br>" . $my_address;
        //return;
                $insert_address_table = "INSERT INTO address (address_id, main_address, code, accommo_id) 
                                         VALUES ('$address', '$my_address', '$code', '$id')";
                if (!$connection->query($insert_address_table)) 
                    echo "<br>Error setting up your accommodation. Please try again";			
        //			echo "Error: " . $connection->error;
                $my_address = "";
                $insert_rooms_table = "INSERT INTO rooms (room_id, s_a, d_a, m_a, accommo_id)
                                       VALUES ('$rooms', '$checkbox1', '$checkbox2', '$checkbox3', '$id')";
                if (!$connection->query($insert_rooms_table)) 
                    echo "<br>Error setting up your accommodation. Please try again";			
        //			echo "Error: " . $connection->error;

                $insert_single_table = "INSERT INTO single (single_id, cash, bursary, room_id) 
                                        VALUES ('$single', NULL, NULL, '$rooms')";
                if (!$connection->query($insert_single_table)) 
                    echo "<br>Error setting up your accommodation. Please try again";			
        //			echo "Error: " . $connection->error;

                $insert_double_table = "INSERT INTO two_sharing (two_sharing_id, cash, bursary, room_id) 
                                        VALUES ('$double', NULL, NULL, '$rooms')";
                if (!$connection->query($insert_double_table)) 
                    echo "<br>Error setting up your accommodation. Please try again";			
        //			echo "Error: " . $connection->error;

                $insert_three_table = "INSERT INTO three_sharing (three_sharing_id, cash, bursary, room_id) 
                    VALUES ('$three', NULL, NULL, '$rooms')";
                if (!$connection->query($insert_three_table)) 
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";			

                $update_rooms_table = "UPDATE rooms 
                                        SET single = '$single', 
                                            two_s = '$double', 
                                            three_s = '$three' 
                                        WHERE room_id = '$rooms'";
                if (!$connection->query($update_rooms_table)) 
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";

                $insert_average_user_rating_table = "INSERT INTO average_user_rating 
                                            (ave_rating_id, ave_location, ave_services, ave_rooms, accommo_id)
                                             VALUES ('$average_user_rating',  NULL, NULL, NULL, '$id')";
                if (!$connection->query($insert_average_user_rating_table))
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";			

                $insert_location_table = "INSERT INTO location (loc_id, rating_id)
                                             VALUES ('$location', '$average_user_rating')";
                if (!$connection->query($insert_location_table)) 
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";			

                $insert_services_table = "INSERT INTO services (service_id, rating_id)
                                             VALUES ('$services', '$average_user_rating')";
                if (!$connection->query($insert_services_table)) 
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";			

                $insert_rooms_table = "INSERT INTO rating_rooms (ave_room_id, rating_id)
                                             VALUES ('$rating_rooms', '$average_user_rating')";
                if (!$connection->query($insert_rooms_table)) 
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";			

                $insert_features_table = " INSERT INTO features (f_id, accommo_id) 		
                                        VALUES ('$include_features', '$id')";
                if (!$connection->query($insert_features_table)) 
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";			

                $update_rooms_table = "UPDATE rooms 
                                        SET single = '$single', two_s = '$double', three_s = '$three' 
                                    WHERE room_id  = '$rooms'";
                if (!$connection->query($update_rooms_table)) 
                    echo "Error: " . $connection->error;
        //			echo "<br>Error setting up your accommodation. Please try again";			

                $update_accommo_table = "UPDATE accommodation 
                                        SET star_rating = '$user_ratings', 
                                            address = '$address', 
                                            rooms = '$rooms', 
                                            user_ratings = '$average_user_rating', 
                                            inc_features = '$include_features', 
                                            display = '0' 
                                        WHERE id = '$id'";
                if (!$connection->query($update_accommo_table)) 
        //			echo "Error: " . $connection->error;
                    echo "<br>Error setting up your accommodation. Please try again";			

                $update_average_table = "UPDATE average_user_rating 
                                        SET ave_location = '$location', 
                                        ave_services = '$services', 
                                        ave_rooms = '$rating_rooms' 
                                        WHERE ave_rating_id = '$average_user_rating'";
                if (!$connection->query($update_average_table)) 
        //			echo "Error: " . $connection->error;
                    echo "<br>Error setting up your accommodation. Please try again";
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