<?php session_start();
$stars = $location = $service = $rooms = $stuff = $scale = $payload = $user = "";
if ($_SERVER["REQUEST_METHOD"] != "POST"){
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
		stuff = check_inputs($_REQUEST["stuff"]);
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
    $results_location = $connection->query($sql);
	$rate_count = $rate_values = 0;
	//ratings exist already 
    if ($results_location->num_rows > 0) {
		$row = $results_location->fetch_assoc();
        $star_values = explode(",", $row['stars_values']);
        $scale_values = explode(",", $row['scale_values']);
        $names = explode(",", $row['names']);
        $rate_count = $row['rate_counter'];
        if($user != ""){
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
        }
    }else{
        $temp_stars = $star_values . ",";
        $temp_scale = $scale_values . ",";
        $sql = "INSERT INTO star_and_scale_rating
                VALUES (\"$id\", \"$payload\", \"$temp_stars\", \"$temp_scale\", \"$user\", \"1\")";
    }
    if ($connection->query($sql)){
        //do nothing, all is good
    
        //write the next ones from  here
    }

    $connection->close();
}else {
    echo "<br><h5>Invalid request</br>";
    return;		
}
function check_inputs($data){
	$data = trim($data);
	$data = stripcslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

?>
