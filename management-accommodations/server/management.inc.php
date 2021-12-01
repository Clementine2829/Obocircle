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
        $payload = (isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
        $room_id = "";
        $user_id = $_SESSION['s_id'];
        require("../../includes/conn.inc.php");
        if($payload == ""){
            $sql = "SELECT id, name
                    FROM accommodations
                    WHERE manager=\"$user_id\" LIMIT 15";
            echo $sql; 
            $sql_results = new SQL_results();
            $results = $sql_results->results_accommodations($sql);
            $div = "";
            if($results->num_rows > 1){
                echo "Updates failed. Internal error. <br>Please reload page and try again";
                return;
            }else if($results->num_rows == 1){
                $row = $results->fetch_assoc();
                $payload = $row['id'];
            }else if($results->num_rows < 1){
                echo '<p style="color: red"><strong><br>No accommodation found</strong><br>
                        If you belive this is an errro, please contact us at support@obocircle.com</p>';
                return;
            }
        }
        
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
        $result = $sql_results->results_accommodations($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $room_id = $data['room_id'];
        }
        $sql = "SELECT single_id 
                FROM single_s 
                WHERE room_id = \"$room_id\" LIMIT 1";
        $result = $sql_results->results_accommodations($sql);
        if ($result->num_rows > 0) {
            $sql_update = "UPDATE single_s
                            SET cash = \"$single_c\", bursary = \"$single_b\"
                            WHERE room_id = \"$room_id\"";
            if ($connection->query($sql_update)){
                //do nothing
            }
            $sql_update = "UPDATE double_s
                            SET cash = \"$double_c\", bursary = \"$double_b\"
                            WHERE room_id = \"$room_id\"";
            if ($connection->query($sql_update)){
                //do nothing
            }
            $sql_update = "UPDATE multi_s
                            SET cash = \"$multi_c\", bursary = \"$multi_b\"
                            WHERE room_id = \"$room_id\"";
            if ($connection->query($sql_update)){
                //do nothing
            }
        }else{
            $single_id = $double_id = $multi_id = rand_text($payload, 20);
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