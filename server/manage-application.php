<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]+$/', $_SESSION['s_id'])){
            $application = (isset($_REQUEST['application'])) ? $_REQUEST['application'] : "";
            $accommodation = (isset($_REQUEST['accommodation'])) ? $_REQUEST['accommodation'] : "";
            if($accommodation == "") $accommodation = $application;
            $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : "";
            $sql = "";
            if($application != "" && $action == "delete"){
                //delete
                $action = "5";
            }else if($application == "" && ($action == "reject" || $action == "approve")){
                $action = ($action == "reject") ? "4" : "1";
            }else{
                echo "<br><br><br>Invalid operation";
                return;                
            }
            require("../includes/conn.inc.php");
            $db_login = new DB_login_updates();
            $connection = $db_login->connect_db("applications");
            $sql = "UPDATE new_applicants
                    SET a_status = \"$action\"
                    WHERE id = \"$accommodation\"";
            if ($connection->query($sql)) echo "Updated sucessfully";
        }else{
            echo "<br><br><br>";
            require_once './offline.html';
            return;
        }
    }else{
        echo "Invalid request";
        return;
    }
?>