<?php 
	session_start(); 
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_REQUEST['payload']) || $_REQUEST['payload'] == "" ||
            !preg_match('/^[a-zA-Z0-9]*$/', $_REQUEST['payload'])) return;

		if(!isset($_REQUEST["handicapped"]) && !isset($_REQUEST["washing_line"]) && 
		!isset($_REQUEST["security"]) && !isset($_REQUEST["cctv"]) && 
		!isset($_REQUEST["biometric"]) && !isset($_REQUEST["shops"]) && 
		!isset($_REQUEST["bar"]) && !isset($_REQUEST["study_area"]) && 
		!isset($_REQUEST["recreational"]) && !isset($_REQUEST["sports"]) && 
		!isset($_REQUEST["games_room"]) && !isset($_REQUEST["first_aid"]) && 
		!isset($_REQUEST["playstation"]) && !isset($_REQUEST["beds"]) && 
		!isset($_REQUEST["cinema"]) && !isset($_REQUEST["pool"]) && 
		!isset($_REQUEST["soccer"]) && !isset($_REQUEST["furnished"]) && 
		!isset($_REQUEST["netball"]) && !isset($_REQUEST["wifi"]) &&
		!isset($_REQUEST["soccer"]) && !isset($_REQUEST["furnished"]) && 
		!isset($_REQUEST["transport"]) && !isset($_REQUEST["laundry"]) && 
		!isset($_REQUEST["computer"]) && !isset($_REQUEST["electricity"]) && 
		!isset($_REQUEST["gym"]) && !isset($_REQUEST["kitchen"]) && 
		!isset($_REQUEST["parking"]) && !isset($_REQUEST["bathroom"]) && 
		!isset($_REQUEST["room"]) && !isset($_REQUEST["tv"])) return;

		$f4 = checked($_REQUEST['security']);
		$f5 = checked($_REQUEST['cctv']);
		$f6 = checked($_REQUEST['biometric']);
		$f7 = checked($_REQUEST['furnished']);
		$f8 = checked($_REQUEST['sports']);
		$f9 = checked($_REQUEST['recreational']);
		
		$f15 = checked($_REQUEST['cinema']);
		$f16 = checked($_REQUEST['playstation']);
		$f17 = checked($_REQUEST['shops']);
		$f18 = checked($_REQUEST['bar']);
		$f19 = checked($_REQUEST['study_area']);
		$f20 = checked($_REQUEST['beds']);
		$f21 = checked($_REQUEST['games_room']);
		$f22 = checked($_REQUEST['first_aid']);
		$f23 = checked($_REQUEST['handicapped']);
		
		$f25 = checked($_REQUEST['washing_line']);
		
		$f28 = checked($_REQUEST['soccer']);
		$f29 = checked($_REQUEST['netball']);
		$f30 = checked($_REQUEST['pool']);

		if (preg_match('/[123]+/', $_REQUEST['room'])) $f1 = $_REQUEST['room']; 
		else $f1 = 0;
		if (preg_match('/[123]+/', $_REQUEST['kitchen'])) $f2 = $_REQUEST['kitchen']; 
		else $f2 = 0;
		if (preg_match('/[123]+/', $_REQUEST['bathroom'])) $f3 = $_REQUEST['bathroom']; 
		else $f3 = 0;

		if (preg_match('/[12]+/', $_REQUEST['wifi'])) $f10 = $_REQUEST['wifi']; 
		else $f10 = 0;
		if (preg_match('/[12]+/', $_REQUEST['transport'])) $f11 = $_REQUEST['transport']; 
		else $f11 = 0;
		if (preg_match('/[12]+/', $_REQUEST['computer'])) $f12 = $_REQUEST['computer']; 
		else $f12 = 0;
		if (preg_match('/[1234]+/', $_REQUEST['gym'])) $f13 = $_REQUEST['gym']; 
		else $f13 = 0;
		if (preg_match('/[123]+/', $_REQUEST['tv'])) $f14 = $_REQUEST['tv']; 
		else $f14 = 0;

		if (preg_match('/[12]+/', $_REQUEST['laundry'])) $f24 = $_REQUEST['laundry']; 
		else $f24 = 0;

		if (preg_match('/[12]+/', $_REQUEST['electricity'])) $f26 = $_REQUEST['electricity']; 
		else $f26 = 0;
		if (preg_match('/[12]+/', $_REQUEST['parking'])) $f27 = $_REQUEST['parking']; 
		else $f27 = 0;

		$location = check_inputs($_REQUEST["geoloc"]);
		if(!preg_match('/^[0-9\.]+\,+[0-9\.]+$/', $location)) $location = "";
		$payload = check_inputs($_REQUEST["payload"]);

		require("../includes/conn.inc.php");
		$db_login = new DB_login_updates();
		$connection = $db_login->connect_db("accommodations");

		$sql = "SELECT accommo_id FROM features WHERE accommo_id = \"$payload\" LIMIT 1";
		$results = $connection->query($sql);
		if ($results->num_rows < 1){
            $f_id = password_hash(rand(0, 100), PASSWORD_DEFAULT);
            $f_id = substr($f_id,7,10);
            while(!preg_match("/^[a-zA-Z0-9]*$/", $f_id)) {
                $f_id = password_hash($f_id, PASSWORD_DEFAULT);
                $f_id = substr($f_id,7,10);
            }
            $sql = "INSERT INTO features(f_id, accommo_id)
                    VALUES (\"$f_id\", \"$payload\")";    
			if ($connection->query($insert_in_table)) {
                //Alls is good   
            }
        } 

		$sql_f = "UPDATE features 
				  SET f1 = \"$f1\", 
				  	   f2 = \"$f2\",
				  	   f3 = \"$f3\",
				  	   f4 = \"$f4\",
				  	   f5 = \"$f5\",
				  	   f6 = \"$f6\",
				  	   f7 = \"$f7\",
				  	   f8 = \"$f8\",
				  	   f9 = \"$f9\",
				  	   f10 = \"$f10\",
				  	   f11 = \"$f11\",
				  	   f12 = \"$f12\",
				  	   f13 = \"$f13\",
				  	   f14 = \"$f14\",
				  	   f15 = \"$f15\",
				  	   f16 = \"$f16\",
				  	   f17 = \"$f17\",
				  	   f18 = \"$f18\",
				  	   f19 = \"$f19\",
				  	   f20 = \"$f20\",
				  	   f21 = \"$f21\",
				  	   f22 = \"$f22\",
				  	   f23 = \"$f23\",
				  	   f24 = \"$f24\",
				  	   f25 = \"$f25\",
				  	   f26 = \"$f26\",
				  	   f27 = \"$f27\",
				  	   f28 = \"$f28\",
				  	   f29 = \"$f29\",
				  	   f30 = \"$f30\"
				   WHERE accommo_id = \"$payload\"";

		if ($connection->query($sql_f) != TRUE)
			echo "<br>Error updating accommodation features.";
		/*$sql_address = "INSERT INTO geo_loc(accommo_id, geo_loc) VALUES(\"$payload\", \"$location\")";
		if ($connection->query($sql_address) != TRUE)
			echo "<br>Error updating the location";*/
		$connection->close();
	}else{
        echo "Invalid request";
		return;
	}
	function checked($x){
		return ($x == "1") ? 1 : 0;
	}
	function check_inputs($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	?>