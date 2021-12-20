<?php session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    require 'validate_data.php';
    require("../includes/conn.inc.php");

    $id = $_SESSION['s_id'];
    $sql = "SELECT user_type FROM users_extended WHERE user_id = \"$id\" AND profile_status = \"1\" LIMIT 1";
    $sql_results = new SQL_results();
    $results = $sql_results->results_profile($sql);
    if($results->num_rows > 0){
        echo "activated";
        return;
    }
    
    $db_login = new DB_login_updates();
    $connection = $db_login->connect_db("obo_users");
    $sql = "DELETE FROM activate_account WHERE user_id = \"$id\"";
    if ($connection->query($sql)){
        //Delete previous links   
    }else echo "Error: " . $connection->error;
    $link = rand(100000,999999);
    $veri_id = password_hash(rand(0,100), PASSWORD_DEFAULT);
    $veri_id = substr($link,7,30);
    while(!preg_match("/^[a-zA-Z0-9]*$/", $veri_id) || strlen($veri_id) < 26) {
        $veri_id = password_hash($veri_id, PASSWORD_DEFAULT);
        $veri_id = substr($veri_id,7,30);
    }
    $expire_date = date('d/m/Y');
    $sql_update = "INSERT INTO activate_account(activate_id, user_id, expire_date, veri_link)
                    VALUES(\"$veri_id\", \"$id\", \"$expire_date\", \"$link\")";
    if ($connection->query($sql_update)){
        echo "success";
        $name = "Obocircle";
        $subject = "Account Activation link";
        $email = "no-reply@obocircle.com";
        $recipient = $email;
        $message = "
Hi, there,

Please use the code below to activate your account


" . $link . "


Copyright © " . date("Y") . " Obocircle.com | All rights reserved
    info@obocircle.com";
        //require 'send-email.php';

    }                
}else{
    echo "Unknown request";
    return;
}
function test_input($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>