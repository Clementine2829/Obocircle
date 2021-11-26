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
		stuff = check_inputs($_REQUEST["stuff"]);
	else return;
	if(isset($_REQUEST['scale']) && preg_match('/\d{1}/', $_REQUEST['scale']))
		$scale = check_inputs($_REQUEST["scale"]);
	else return;
	if(isset($_REQUEST['payload']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload']))
		$payload = check_inputs($_REQUEST["payload"]);
	else return;
	if(isset($_SESSION['s_email']) && filter_var($_SESSION['s_email'], FILTER_VALIDATE_EMAIL))
		$user = $_SESSION['s_email']; 
	else return;
	if(!isset($_SESSION['s_id'])) return;
    $_SESSION['reder'] = "view-accommodation.php?accommodation=" . $payload;

	require("../includes/conn.inc.php");
	$db_login = new DB_login_updates();
	$connection = $db_login->connect_db("accommodations");


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
