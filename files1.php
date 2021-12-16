<?php
$users = [];
if($file = fopen("data.txt", "r")){
    while(!feof($file)){
        $data = explode("|", fgets($file));
         $user = array("id"=>((isset($data[0])) ? $data[0] : ""),
                      "first_name"=>((isset($data[1])) ? $data[1] : ""),
                      "last_name"=>((isset($data[2])) ? $data[2] : ""),
                      "gender"=>((isset($data[3])) ? $data[3] : ""),
                      "date_of_birth"=>((isset($data[4])) ? $data[4] : ""),
                      "email"=>((isset($data[5])) ? $data[5] : ""),
                      "password"=>((isset($data[6])) ? $data[6] : ""),
                      "phone"=>((isset($data[7])) ? $data[7] : ""),
                      "ref"=>((isset($data[8])) ? $data[8] : ""),
                      "extended"=>((isset($data[9])) ? $data[9] : ""),
                      "address"=>((isset($data[10])) ? $data[10] : ""),
                      "reg_date"=>((isset($data[11])) ? $data[11] : ""));
        array_push($users, $user);
    }
    fclose($file);
}
require("./includes/conn.inc.php");
$sql_results = new SQL_results();
$db_login = new DB_login_updates();
foreach($users as $user => $value){
    $id = $users[$user]['id'];
    $first_name = $users[$user]['first_name'];
    $last_name = $users[$user]['last_name'];
    $gender = $users[$user]['gender'];
    $date_of_birth = $users[$user]['date_of_birth'];
    $email = $users[$user]['email'];
    $password = $users[$user]['password'];
    $phone = $users[$user]['phone'];
    $ref_code = $users[$user]['ref'];
    $reg_date = $users[$user]['reg_date'];
    $extended = $users[$user]['extended'];
    if($id == "") continue;

    $insert_in_table = "INSERT INTO users (id, first_name, last_name, gender, 
                                    date_of_birth, email, password, phone, ref_code, reg_date)
    VALUES (\"$id\", \"$first_name\", \"$last_name\", \"$gender\", 
            \"$date_of_birth\", \"$email\", \"$password\", \"$phone\", \"$ref_code\", \"$reg_date\")";	
    $connection = $db_login->connect_db("obo_users");
    if ($connection->query($insert_in_table)) {
        echo "<br>Account created successfully. Click <a href='login.php'>here</a> to login";

        $users_ex = "INSERT INTO users_extended (user_ex_id, user_id) VALUES(\"$extended\", \"$id\")";
        if ($connection->query($users_ex)){
            //do thing
        } else echo "Error 1: " . $connection->error;



        $link = password_hash(rand(0,100), PASSWORD_DEFAULT);
        $sql = "SELECT activate_id FROM activate_account WHERE user_id = \"$id\" LIMIT 1";
        $link = $ref_code = get_ref_code($sql_results, $sql);
        $veri_id = password_hash($link, PASSWORD_DEFAULT);
        $veri_id = substr($link,7,30);
        while(!preg_match("/^[a-zA-Z0-9]*$/", $veri_id) || strlen($veri_id) < 26) {
            $veri_id = password_hash($link, PASSWORD_DEFAULT);
            $veri_id = substr($veri_id,7,30);
        }
        $expire_date = substr(date("d/m/Y H:i:s", strtotime($reg_date)), 0, 10);
        $sql_update = "INSERT INTO activate_account(activate_id, user_id, expire_date, veri_link)
                        VALUES(\"$veri_id\", \"$id\", \"$expire_date\", \"$link\")";
        if ($connection->query($sql_update)){
            //DO NOTHING
        }
    } else echo "Error 2: " . $connection->error;
}

function get_ref_code($sql_results, $sql_validate_ref_code=""){
	$ref_code = rand(100000, 999999);
	$sql_validate_ref_code = ($sql_validate_ref_code == "") ? "SELECT first_name FROM users WHERE ref_code = \"$ref_code\" LIMIT 1" : $sql_validate_ref_code;
	$results = $sql_results->results_profile($sql_validate_ref_code);
	while(true){
		if($results->num_rows > 0){
			$ref_code = rand(100000, 999999);
	$sql_validate_ref_code = ($sql_validate_ref_code == "") ? "SELECT first_name FROM users WHERE ref_code = \"$ref_code\" LIMIT 1" : $sql_validate_ref_code;			$results = $sql_results->results_profile($sql_validate_ref_code);
		}else{
			break;
		}
	}
	return $ref_code;
}
?>