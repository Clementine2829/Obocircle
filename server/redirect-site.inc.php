<?php
    $data = ["", ""];
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $payload = (isset($_REQUEST['payload'])) ? $_REQUEST['payload'] : "";
        $sql = "SELECT website FROM websites WHERE accommo_id = \"$payload\" LIMIT 1";
        require("../includes/conn.inc.php");
        $sql_results = new SQL_results();
        $results = $sql_results->results_accommodations($sql);
        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            $data[0] = "1";
            $data[1] = $row['website'];
        }else{
            $data[0] = "2";
            $data[1] = "";            
        }
        echo json_encode($data);
    }else{
        echo json_encode($data);
        return;
    }
?>