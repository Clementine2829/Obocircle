<?php 
    if(session_start() == false) session_start();
    if($_SERVER['REQUEST_METHOD'] != "POST") {
        echo "<h5 style='color: red'><br>Unknown request<br></h5>";
        return;
    }
    if(isset($_SESSION['s_id']) && isset($_SESSION['s_user_type'])){
        if($_SESSION['s_user_type'] == "premium_user"){
            $user_id = $_SESSION['s_id'];
            $sql = "SELECT id, name 
                    FROM accommodations
                    WHERE manager=\"$user_id\" LIMIT 15";
            
            require("../includes/conn.inc.php");
			$sql_results = new SQL_results();
			$results = $sql_results->results_accommodations($sql);
			$div = "";
            if($results->num_rows > 0){
				while($row = $results->fetch_assoc()){
                    $div .= '<br><li><a href="./dashboard.php?payload='. $row['id'] . '">'. $row['name'] . '</a></li>';
                }
                ?>
                    <div id="select_accommodations">
                        <br>
                        <h5>Select an accommodation to manage below</h5>
                        <ul>
                            <?php echo $div; ?>
                        </ul>
                    </div>
                <?php
            }else{
                echo 'Not found';
            }
        }else{
            require_once '../access_denied.html';
            return;
        }
    }else{
        require_once '../offline.html';
        return;
    }

?>