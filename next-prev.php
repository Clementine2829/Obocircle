<?php
/*
	use the url to see which sql to run, for example if url is accommodation then run accommodatino for 
*/
	
	$results = 0;
	$sql = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		require("includes/conn.inc.php");
		$sql_results = new SQL_results();
		if(isset($_REQUEST['file']) && $_REQUEST['file'] == "accommodations"){
            $sql = "SELECT name/*COUNT(name)*/ 
                    FROM accommodations
                    WHERE display = \"1\"";
            $results = $sql_results->results_accommodations($sql)->num_rows;
        }
		echo $results;
	}else{
		echo "0";
	}
?>