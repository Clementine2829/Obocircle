<?php session_start();
$stars = $location = $service = $rooms = $stuff = $scale = $payload = $user = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_REQUEST['stars']) && preg_match('/[12345]/', $_REQUEST['stars']))
		$stars = check_inputs($_REQUEST["stars"]);
	else return;
	if(isset($_REQUEST['location']) && preg_match('/[12345]/', $_REQUEST['location']))
		$location = check_inputs($_REQUEST["location"]);
	else return;
	if(isset($_REQUEST['service']) && preg_match('/[12345]/', $_REQUEST['service']))		
		$service = check_inputs($_REQUEST["service"]);
	else return;
	if(isset($_REQUEST['rooms']) && preg_match('/[12345]/', $_REQUEST['rooms']))
		$rooms = check_inputs($_REQUEST["rooms"]);
	else return;
	if(isset($_REQUEST['stuff']) && preg_match('/[12345]/', $_REQUEST['stuff']))
		$stuff = check_inputs($_REQUEST["stuff"]);
	else return;
	if(isset($_REQUEST['scale']) && preg_match('/\d{1}/', $_REQUEST['scale']))
		$scale = check_inputs($_REQUEST["scale"]);
	else return;
	if(isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload']))
		$payload = check_inputs($_REQUEST["payload"]);
	else return;
	if(isset($_SESSION['s_email']) && filter_var($_SESSION['s_email'], FILTER_VALIDATE_EMAIL))
		$user = strtolower($_SESSION['s_email']); 
	else return;
	if(!isset($_SESSION['s_id'])) return;
    $_SESSION['reder'] = "view-accommodation.php?accommodation=" . $payload;

	require("../includes/conn.inc.php");
	$db_login = new DB_login_updates();
	$connection = $db_login->connect_db("accommodations");
    $id = password_hash(rand(0, 100), PASSWORD_DEFAULT);
    $id = substr($id,7,10);
    while(!preg_match("/^[a-zA-Z0-9]*$/", $id)) {
        $id = password_hash($id, PASSWORD_DEFAULT);
        $id = substr($id,7,10);
    }
    
    $sql = "SELECT * FROM star_and_scale_rating WHERE accommo_id = \"$payload\" LIMIT 1";
    $results = $connection->query($sql);
	$rate_count = 0;
	//ratings exist already 
    if ($results->num_rows > 0) {
		$row = $results->fetch_assoc();
        $star_values = explode(",", $row['stars_values']);
        $scale_values = explode(",", $row['scale_values']);
        $rate_count = $row['rate_counter'];
        
        $temp_names = $row['names']; //to be used tfor searching
        if(strpos($temp_names, $user) !== false){ //the person is found on the list 
            $names = explode(",", $temp_names);
            for($i = 0; $i < $rate_count; $i++){
                if($user == $names[$i]){
                    $star_values[$i] = $stars;
                    $scale_values[$i] = $scale;
                  
                    $temp_star_values = implode(",", $star_values);
                    $temp_scale_values = implode(",", $scale_values);
                    $sql = "UPDATE star_and_scale_rating 
                            SET stars_values = \"$temp_star_values\",
                                scale_values = \"$temp_scale_values\"
                            WHERE accommo_id = \"$payload\"";
                    break;
                }else{
                    continue;
                }
            }            
        }else{//the person is not found on the list 
            $temp_star_values = $row['stars_values'] . $stars . ",";
            $temp_scale_values = $row['scale_values'] . $scale . ",";
            $temp_names .= $user . ",";
            $rate_count++;
            $sql = "UPDATE star_and_scale_rating 
                    SET stars_values = \"$temp_star_values\",
                    scale_values = \"$temp_scale_values\",
                    names = \"$temp_names\",
                    rate_counter = \"$rate_count\"
                    WHERE accommo_id = \"$payload\"";            
        }
    }else{
        $temp_stars = $stars . ",";
        $temp_scale = $scale . ",";
        $user = $user . ",";
        $sql = "INSERT INTO star_and_scale_rating
                VALUES (\"$id\", \"$payload\", \"$temp_stars\", \"$temp_scale\", \"$user\", \"1\")";
    }
    if ($connection->query($sql)){
        //write the next ones from  here
        echo "success";
        $sql = "SELECT average_ratings.*,
                        rate_location.location_values,
                        rate_services.services_values,
                        rate_rooms.rooms_values,
                        rate_stuff.stuff_values
                FROM ((((average_ratings 
                    INNER JOIN rate_location ON average_ratings.location_id = rate_location.location_id)
                    INNER JOIN rate_services ON average_ratings.services_id = rate_services.services_id)
                    INNER JOIN rate_rooms ON average_ratings.rooms_id = rate_rooms.rooms_id)
                    INNER JOIN rate_stuff ON average_ratings.stuff_id = rate_stuff.stuff_id)
                WHERE average_ratings.accommo_id = \"$payload\"";    
        $results = $connection->query($sql);
        $rate_count = $rate_values = 0;
        //ratings exist already 
        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            $location_id = $row['location_id'];
            $services_id = $row['services_id'];
            $rooms_id = $row['rooms_id'];
            $stuff_id = $row['stuff_id'];
            $temp_names = $row['rate_names'];
            $rate_count = $row['rate_counter'];
            if(strpos($temp_names, $user) !== false){ //the person is found on the list 
                $names = explode(",", $temp_names);
                $location_values = explode(",", $row['location_values']);
                $service_values = explode(",", $row['services_values']);
                $room_values = explode(",", $row['rooms_values']);
                $stuff_values = explode(",", $row['stuff_values']);
                for($i = 0; $i < $rate_count; $i++){
                  if($user == $names[$i]){
                        $location_values[$i] = $location;
                        $service_values[$i] = $service;
                        $room_values[$i] = $rooms;
                        $stuff_values[$i] = $stuff;

                        $temp_location_values = implode(",", $location_values);
                        $temp_service_values = implode(",", $service_values);
                        $temp_room_values = implode(",", $room_values);
                        $temp_stuff_values = implode(",", $stuff_values);
                        $sql = "UPDATE rate_location 
                                SET location_values = \"$temp_location_values\"
                                WHERE location_id = \"$location_id\"";
                        if ($connection->query($sql)){ 
                            //do nothing
                        }
                        $sql = "UPDATE rate_services 
                                SET services_values = \"$temp_service_values\"
                                WHERE services_id = \"$services_id\"";
                        if ($connection->query($sql)){ 
                            //do nothing
                        }
                        $sql = "UPDATE rate_rooms 
                                SET rooms_values = \"$temp_room_values\"
                                WHERE rooms_id = \"$rooms_id\"";
                        if ($connection->query($sql)){ 
                            //do nothing
                        }
                        $sql = "UPDATE rate_stuff 
                                SET stuff_values = \"$temp_stuff_values\"
                                WHERE stuff_id = \"$stuff_id\"";
                        if ($connection->query($sql)){ 
                            //do nothing
                        }
                        break;
                    }else{
                        continue;
                    }
                }
            }else{//the person is not found on the list 
                $temp_location_values = $row['location_values'] . $location . ",";
                $temp_service_values = $row['services_values'] . $service . ",";
                $temp_room_values = $row['rooms_values'] . $rooms . ",";
                $temp_stuff_values = $row['stuff_values'] . $stuff . ",";
                $temp_names .= $user . ",";
                $rate_count++;
                
                $sql = "UPDATE average_ratings 
                        SET rate_names = \"$temp_names\",
                            rate_counter = \"$rate_count\"
                        WHERE location_id = \"$location_id\"";
                if ($connection->query($sql)){ 
                    //do nothing
                }
                $sql = "UPDATE rate_location 
                        SET location_values = \"$temp_location_values\"
                        WHERE location_id = \"$location_id\"";
                if ($connection->query($sql)){ 
                    //do nothing
                }
                $sql = "UPDATE rate_services 
                        SET services_values = \"$temp_service_values\"
                        WHERE services_id = \"$services_id\"";
                if ($connection->query($sql)){ 
                    //do nothing
                }
                $sql = "UPDATE rate_rooms 
                        SET rooms_values = \"$temp_room_values\"
                        WHERE rooms_id = \"$rooms_id\"";
                if ($connection->query($sql)){ 
                    //do nothing
                }
                $sql = "UPDATE rate_stuff 
                        SET stuff_values = \"$temp_stuff_values\"
                        WHERE stuff_id = \"$stuff_id\"";
                if ($connection->query($sql)){ 
                    //do nothing
                }
            }
        }else{
            $temp_location = $location . ",";
            $temp_services = $service . ",";
            $temp_rooms = $rooms . ",";
            $temp_stuff = $stuff . ",";
            $sql = "INSERT INTO rate_location
                    VALUES (\"$id\", \"$temp_location\")";
            if ($connection->query($sql)){
                //do nothign
            }
            $sql = "INSERT INTO rate_services
                    VALUES (\"$id\", \"$temp_services\")";
            if ($connection->query($sql)){
                //do nothign
            }
            $sql = "INSERT INTO rate_rooms
                    VALUES (\"$id\", \"$temp_rooms\")";
            if ($connection->query($sql)){
                //do nothign
            }
            $sql = "INSERT INTO rate_stuff
                    VALUES (\"$id\", \"$temp_stuff\")";
            if ($connection->query($sql)){
                //do nothign
            }
            $sql = "INSERT INTO average_ratings
                    VALUES (\"$payload\", \"$id\", \"$id\", \"$id\", \"$id\", \"$user,\", \"1\")";
            if ($connection->query($sql)){
                //do nothign
            }
        }
    }else{
        echo "<br><h5 style='color: red'>Error updating ratings. Please try again</br>";
        return;		
    }
    $connection->close();
}else {
    echo "<br><h5 style='color: red'>Invalid request</br>";
    return;		
}
function check_inputs($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
