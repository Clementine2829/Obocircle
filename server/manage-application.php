<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]+$/', $_SESSION['s_id'])){
            $application = (isset($_REQUEST['application'])) ? $_REQUEST['application'] : "";
            $accommodation = (isset($_REQUEST['accommodation'])) ? $_REQUEST['accommodation'] : "";
            if($accommodation == "") $accommodation = $application;
            $action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : "";
            $sql = "";
            require("../includes/conn.inc.php");
            $db_login = new DB_login_updates();
            $connection = $db_login->connect_db("applications");
            if($application != "" && $action == "delete"){
                //delete
                $action = "5";
            }else if($application == "" && $action == "synch-applications"){
                $email = (isset($_SESSION['s_email'])) ? $_SESSION['s_email'] : "";
                $sql = "SELECT id FROM new_applicants  WHERE email = \"$email\" LIMIT 50";
                $sql_results = new SQL_results();
                $results = $sql_results->results_applicaations($sql);
                if ($results->num_rows > 0) {
                    $user = $_SESSION['s_id'];
                    while($row = $results->fetch_assoc()){
                        $id = $row['id'];
                        if($id != ""){
                            $sql = "INSERT INTO application VALUES(\"$user\", \"$id\")";
                            if ($connection->query($sql));
                                //do noting 
                            }else echo "Error: " . $connection->error;
                        }
                    echo "found";
                }else echo "Not found";
                
                return;
            }else if($application == "" && ($action == "reject" || $action == "approve")){
                $action = ($action == "reject") ? "4" : "1";
            }else{
                echo "<br><br><br>Invalid operation";
                return;                
            }
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