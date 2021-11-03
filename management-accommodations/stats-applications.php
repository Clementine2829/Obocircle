<?php session_start();

	function get_data(){
		/*$year = Date('Y');
		$sql = "SELECT date_applied
				FROM job_applications
				WHERE date_applied LIKE '%$year%' 
				LIMIT 500";
		require("./includes/conn.inc.php");
		$sql_results = new SQL_results();
		$results = $sql_results->results_teamaces($sql);*/
		$months = array("01" => 5,
						"02" => 10,
						"03" => 0,
						"04" => 4,
						"05" => 15,
						"06" => 2,
						"07" => 12,
						"08" => 13,
						"09" => 0,
						"10" => 8,
						"11" => 7,
						"12" => 5);

		/*if($results->num_rows > 0){
			while ($row = $results->fetch_assoc()) {
				$temp_month = substr($row['date_applied'], 3, 2);
				$this_month = Date('m');
	
				if($temp_month > $this_month) continue;
				if($temp_month == '01') $months['01']++;
				else if($temp_month == '01') $months['01']++;
				else if($temp_month == '02') $months['02']++;
				else if($temp_month == '03') $months['03']++;
				else if($temp_month == '04') $months['04']++;
				else if($temp_month == '05') $months['05']++;
				else if($temp_month == '06') $months['06']++;
				else if($temp_month == '07') $months['07']++;
				else if($temp_month == '08') $months['08']++;
				else if($temp_month == '09') $months['09']++;
				else if($temp_month == '10') $months['10']++;
				else if($temp_month == '11') $months['11']++;
				else if($temp_month == '12') $months['12']++;
			}
		}*/
		return $months;
	}

	/*if( (isset($_SESSION['s_id']) && preg_match('/^[a-zA-Z0-9]+$/', $_SESSION['s_id']) ) &&
		(isset($_SESSION['s_user_type']) && preg_match('/(Manager|AssistantManager)/', $_SESSION['s_user_type']) ) ){

	*/	$temp_months = get_data();
		$months = array(
						array("label" => "Jan", "y" => $temp_months['01']),
						array("label" => "Feb", "y" => $temp_months['02']),
						array("label" => "Mar", "y" => $temp_months['03']),
						array("label" => "Apr", "y" => $temp_months['04']),
						array("label" => "May", "y" => $temp_months['05']),
						array("label" => "Jun", "y" => $temp_months['06']),
						array("label" => "Jul", "y" => $temp_months['07']),
						array("label" => "Aug", "y" => $temp_months['08']),
						array("label" => "Sep", "y" => $temp_months['09']),
						array("label" => "Oct", "y" => $temp_months['10']),
						array("label" => "Nov", "y" => $temp_months['11']),
						array("label" => "Dec", "y" => $temp_months['12']));
	//}
?>

	<script>
		var arrDataPointsJobAppStats = [ {
				type: "spline",
				visible: false,
				showInLegend: true,
				yValueFormatString: "##. Application(s)",
				name: "Previous year (2020)",
				dataPoints: [
					{ label: "Jan", y: 15 },
					{ label: "Feb", y: 18 },
					{ label: "Mar", y: 12 },
					{ label: "Apr", y: 8 },
					{ label: "May", y: 0 },
					{ label: "Jun", y: 18 },
					{ label: "Jul", y: 22 },
					{ label: "Aug", y: 4 },
					{ label: "Sep", y: 4 },
					{ label: "Oct", y: 5 },
					{ label: "Nov", y: 10 },
					{ label: "Dec", y: 19 }
				]
			}
			,
		    {
				type: "spline", 
				showInLegend: true,
				yValueFormatString: "##. Application(s)",
				name: "Current year (2021)",
				dataPoints: <?php echo json_encode($months); ?>
		} ];
	
		var chart = new CanvasJS.Chart("chartContainer", {
			theme:"light2",
			animationEnabled: true,
			title:{
				text: "Applications for the current and the previous year"
			},
			axisY :{
				title: "Number of applications",
				suffix: ""
			},
			toolTip: {
				shared: "true"
			},
			legend:{
				cursor:"pointer",
				itemclick : toggleDataSeries
			},
			data: arrDataPointsJobAppStats
		});
		function toggleDataSeries(e) {
			if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible ){
				e.dataSeries.visible = false;
			} else {
				e.dataSeries.visible = true;
			}
			chart.render();
		}

		chart.render();
	</script>

	<div id="chartContainer" style="height: 300px; width: 100%; margin-top: 4%;"></div>
