<?php
    //session_start();
    if($_SERVER['REQUEST_METHOD'] != "POST"){
        if(isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]+$/', $_SESSION['s_id'])){
            $user = $_SESSION['s_id'];
            
            $sql = "SELECT new_applicants.accommodation, new_applicants.action_date, new_applicants.a_status 
                    FROM (new_applicants 
                        INNER JOIN applications ON new_applicants.id = applications.app_id)
                    WHERE applications.id = \"$user\" 
                        AND (new_applicants.a_status = \"1\" OR  new_applicants.a_status = \"2\" OR  new_applicants.a_status = \"3\")  
                    LIMIT 20";
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();
            $results = $sql_results->results_applicaations($sql);
            $applications = array();
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()){
                    $temp_applications = array("accommodation"=>$row['accommodation'],
                                          "address"=>"",
                                          "status"=>$row['a_status'],
                                          "date"=>$row['action_date']);
                    array_push($applications, $temp_applications);
                }
                
                if(sizeof($applications) > 0){
                    foreach($applications as $application => $value){
                        $accommodation = $applications[$application]['accommodation'];
                        $sql = "SELECT accommodations.name, address.main_address
                                FROM ( accommodations
                                    INNER JOIN address ON accommodations.id = address..accommo_id)
                                WHERE accommodations.id = \"$accommodation\" LIMIT 1";
                        $results = $sql_results->results_applicaations($sql);
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $applications[$application]['accommodation'] = $row['name'];
                            $applications[$application]['address'] = $row['address'];
                        }
                        if($applications[$application]['address'] != ""){
                            $temp_address = explode(",", str_replace("<br>", ",", $applications[$application]['address']));
                            for($i = 0; $i < 4; $i++){
                                if($temp_address[$i] != "") $a_address .= $temp_address[$i] . ", ";
                                else continue;
                            }
                            $applications[$application]['address'] = substr($a_address, 0, (strlen($a_address) - 2));
                        }
                    }   
                }
            }else{
                echo "<h5>No applications found<h5>
                        <p>You can click <a href='#'>here</a> to browse for accommodations to apply for one</p>";
                return;
            }
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