<?php
    if(session_start() == false) session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){    
        if(isset($_SESSION['s_id']) && isset($_SESSION['s_user_type'])){
            if($_SESSION['s_user_type'] != "premium_user"){
                require_once '../../access_denied.html';
                return;
            }
        }else{
            require_once '../../offline.html';
            return;
        }
        
        /********all is good**********/
        $payload = $room_id = "";
        if(isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])){
            $payload = $_REQUEST['payload'];
        }else{
            echo "<span style='color: red'>Payload error. payload not found</span><br>";
            return;
        }

        require("../../includes/conn.inc.php");
        $db_login = new DB_login_updates();
        $connection = $db_login->connect_db("accommodations");
        $sql_results = new SQL_results();
        
        
        $single_c = (isset($_REQUEST['single_c']) && preg_match('/^[0-9\.]*$/', $_REQUEST['single_c'])) ? $_REQUEST['single_c'] : "";
        $single_b = (isset($_REQUEST['single_b']) && preg_match('/^[0-9\.]*$/', $_REQUEST['single_b'])) ? $_REQUEST['single_b'] : "";
        $double_c = (isset($_REQUEST['double_c']) && preg_match('/^[0-9\.]*$/', $_REQUEST['double_c'])) ? $_REQUEST['double_c'] : "";
        $double_b = (isset($_REQUEST['double_b']) && preg_match('/^[0-9\.]*$/', $_REQUEST['double_b'])) ? $_REQUEST['double_b'] : "";
        $multi_c = (isset($_REQUEST['multi_c']) && preg_match('/^[0-9\.]*$/', $_REQUEST['multi_c'])) ? $_REQUEST['multi_c'] : "";
        $multi_b = (isset($_REQUEST['multi_b']) && preg_match('/^[0-9\.]*$/', $_REQUEST['multi_b'])) ? $_REQUEST['multi_b'] : "";
        
        
        $available_single = (isset($_REQUEST['single_a']) && preg_match('/(-1|0|1)/', $_REQUEST['single_a'])) ? $_REQUEST['single_a'] : "";
        $available_double = (isset($_REQUEST['double_a']) && preg_match('/(-1|0|1)/', $_REQUEST['double_a'])) ? $_REQUEST['double_a'] : "";
        $available_multi = (isset($_REQUEST['multi_a']) && preg_match('/(-1|0|1)/', $_REQUEST['multi_a'])) ? $_REQUEST['multi_a'] : "";
        
        $phone = (isset($_REQUEST['phone']) && preg_match('/\d{10}/', $_REQUEST['phone'])) ? $_REQUEST['phone'] : "";
        $website = mysqli_real_escape_string($connection, substr($_REQUEST['website'], 0, 100));
        $nsfas = (isset($_REQUEST['nsfas']) && preg_match('/(0|1)/', $_REQUEST['nsfas'])) ? $_REQUEST['nsfas'] : "";
       
        $sql_update = "UPDATE accommodations
                        SET nsfas = \"$nsfas\"
                        WHERE id = \"$payload\"";
        if ($connection->query($sql_update)){
            echo "<p style='color: blue'>Data updated successfully</p>";
        }else echo "Internal error occured trying to update information. Make sure that the information supplied are correct";
        $sql_update = "UPDATE rooms
                        SET single_sharing = \"$available_single\",
                            double_sharing = \"$available_double\",
                            multi_sharing = \"$available_multi\"
                        WHERE accommo_id = \"$payload\"";
        if ($connection->query($sql_update)){
            //do nothing
        }
        if($phone != ""){
            $sql_update = "UPDATE address
                            SET contact = \"$phone\"
                            WHERE accommo_id = \"$payload\"";
            if ($connection->query($sql_update)){
                //do nothing
            }
        }
        if($website != ""){
            $sql = "SELECT website 
                    FROM websites 
                    WHERE accommo_id = \"$payload\" LIMIT 1";
            $result = $sql_results->results_accommodations($sql);
            $sql_update = "UPDATE websites
                            SET website = \"$website\"
                            WHERE accommo_id = \"$payload\"";
            if ($result->num_rows < 1) {
                $website_id = rand_text($website, 10);
                $sql_update = "INSET INTO websites
                                VALUES(\"$website_id\", \"$payload\", \"$website\")";
            }
            if ($connection->query($sql_update)){
                //do nothing
            }
        }
        
        /******* update the accommodation fees ****/
        $sql = "SELECT room_id 
                FROM rooms 
                WHERE accommo_id = \"$payload\" LIMIT 1";
        echo $sql;
        $result = $sql_results->results_accommodations($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            print_r($data);
            $room_id = $data['room_id'];
        }
        $sql = "SELECT single_id 
                FROM single_s 
                WHERE room_id = \"$room_id\" LIMIT 1";
        $result = $sql_results->results_accommodations($sql);
        if ($result->num_rows > 0) {
            $sql_update = "UPDATE single_s
                            SET cash = \"$single_c\" AND bursary = \"$single_b\"
                            WHERE room_id = \"$payload\"";
            if ($connection->query($sql_update)){
                //do nothing
            }
            $sql_update = "UPDATE double_s
                            SET cash = \"$double_c\" AND bursary = \"$double_b\"
                            WHERE room_id = \"$payload\"";
            if ($connection->query($sql_update)){
                //do nothing
            }
            $sql_update = "UPDATE multi_s
                            SET cash = \"$multi_c\" AND bursary = \"$multi_b\"
                            WHERE room_id = \"$payload\"";
            if ($connection->query($sql_update)){
                //do nothing
            }
            echo "num 1" ;
        }else{
            $single_id = $double_id = $multi_id = rand_text($payload, 20);
            echo "num 2" ;
            $sql_update = "INSERT INTO single_s
                    VALUES (\"$single_id\", \"$room_id\", \"$single_c\", \"$single_b\")";
            if ($connection->query($sql_update)){
                //do nothing
            }
            $sql_update = "INSERT INTO double_s
                    VALUES (\"$double_id\", \"$room_id\", \"$double_c\", \"$double_b\")";
            if ($connection->query($sql_update)){
                //do nothing
            }
            $sql_update = "INSERT INTO multi_s
                    VALUES (\"$multi_id\", \"$room_id\", \"$multi_c\", \"$multi_b\")";
            if ($connection->query($sql_update)){
                //do nothing
            }
        }
		$connection->close();   
    }else{
        echo "</p style='color: red'><br>Unknown request<br></p>";
    }
    /**
        @$txt Text
        @len length
    */
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