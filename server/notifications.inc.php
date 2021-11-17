<?php session_start();
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == "cart"){
			$cart = $user_id = 0;
			if(isset($_SESSION['s_id'])) $user_id = $_SESSION['s_id'];
			$sql = "SELECT n_status
					FROM notifications
					WHERE user_id = \"$user_id\" AND n_status = \"0\"
					LIMIT 50"; 
			require("../includes/conn.inc.php");
			$sql_results = new SQL_results();
			$results = $sql_results->results_profile($sql);
			if($results->num_rows > 0)
				$cart = $results->num_rows;	
			echo $cart;
		}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == "delete" && isset($_REQUEST['message'])){
			$message = $_REQUEST['message'];
			$sql = "UPDATE notifications
					SET n_status = \"3\"
					WHERE id = \"$message\"";
			require("../includes/conn.inc.php");
			$db_login = new DB_login_updates();
			$connection = $db_login->connect_db("teamaces");
			if ($connection->query($sql)) {
				echo "Message deleted successfully";
			}else{
				echo "Error deleting message, please try again";
			}
		}
	}
?>