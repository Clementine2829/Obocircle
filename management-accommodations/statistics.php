<?php session_start();

	if( (isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]+$/', $_SESSION['s_id']) ) &&
		(isset($_SESSION['s_user_type']) && preg_match('/(Manager|AssistantManager)/', $_SESSION['s_user_type']) ) ){
		$sql = "SELECT *
				FROM job_categories
				LIMIT 50";

		require("./includes/conn.inc.php");
		$sql_results = new SQL_results();
		$results = $sql_results->results_teamaces($sql);
		$dataPoints = [];
		if($results->num_rows > 0){
			while ($row = $results->fetch_assoc()) {
				$temp_job = array("y" => 0, 
									"label" => $row['category']); 
				$temp_job = GetJobsCount($row['id'], $temp_job);
		        array_push($dataPoints, $temp_job);
			}
		}

		?>
		<script type="text/javascript">
			$(document).ready(function(){

				var chart = new CanvasJS.Chart("chartContainer", {
					title: {
						text: "Job applications by categories"
					},
					axisY: {
						title: "Number of applications"
					},
					axisX: {
						title: "Job categories"
					},
					data: [{
						type: "line",
						dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
					}]
				});
				chart.render();	 
			})
		</script>
		<div id="chartContainer" style="height: 370px; width: 100%;"></div>
		<?php
	}
	function GetJobsCount($job_category, $job){
		$sql = "SELECT jobs.job_status 
				FROM (jobs
					INNER JOIN job_applications
					ON jobs.job_id = job_applications.job_id)
				WHERE jobs.category = $job_category
				LIMIT 250";
		$sql_results = new SQL_results();
		$results = $sql_results->results_teamaces($sql);
		if($results->num_rows > 0)
			$job['y'] = $results->num_rows;

		return $job;
	}

?>


