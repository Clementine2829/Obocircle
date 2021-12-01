<?php session_start(); 
/*	Create a table with some keywords and their ids so that when you search, the keywords will be the 
	one doing the searchings and returning the ids
*/
	$accomo_id = $name = "";
	$next_page = 0;
//	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_REQUEST['next_page']) && preg_match('/\d{1,}/', $_REQUEST['next_page'])) 
			$next_page = $_REQUEST['next_page'] * 5 - 5;
		$sql = "SELECT accommodations.*, rooms.*, address.main_address 
                FROM ((accommodations
                    INNER JOIN address ON accommodations.id = address.accommo_id)
                    INNER JOIN rooms ON accommodations.id = rooms.accommo_id)
                WHERE display = 1 
                ORDER BY id DESC LIMIT 5 OFFSET $next_page";
        require("../includes/conn.inc.php");
		$sql_results = new SQL_results();
		$results = $sql_results->results_accommodations($sql);
		$accommodations = array();
		if ($results->num_rows > 0) {
			while ($row = $results->fetch_assoc()) {
				if(false/*!preg_match('/^[a-zA-Z0-9]+$/', $row['id']) ||
					!preg_match('/^[a-zA-Z0-9\@\'\(\)\.\s]+$/', $row['name']) ||
					!preg_match('(0|1)', $row['nsfas']) ||
					!preg_match('/^[a-zA-Z0-9]+$/', $row['room_id']) ||
					!preg_match('/^[a-zA-Z0-9]+$/', $row['manager']) ||
					!preg_match('/^[a-zA-Z0-9\'\.\<\>]+$/', $row['main_address']) ||
					!preg_match('/^[a-zA-Z0-9\,\.\?\'\@\+\-\/\(\)\&\s]*$/', $row['about'])*/) continue;
				$temp_arr = array("id" => $row['id'],
								"name" => $row['name'], 
								"images" => "", 
								"nsfas" => $row['nsfas'], 
								"room" => array("id" =>$row['room_id'],
                                                 "single_available" =>$row['single_sharing'],
                                                 "double_available" =>$row['double_sharing'],
                                                 "multi_available" =>$row['multi_sharing'],
                                                 "single_sharing_amount" =>"Amount N/A",
                                                 "double_sharing_amount" =>"Amount N/A",
                                                 "muti_sharing_amount" =>"Amount N/A"),
								"manager" => $row['manager'],
								"stars" => 0,
								"map_coordinates" => "32.0.252.3, -6.36.005",
								"ratings" => 0,
								"reviews" => 0,
								"location" => $row['main_address'],
								"about" => $row['about']);
				array_push($accommodations, $temp_arr);
			}
		}else {
			echo('<style type="text/css">
						#Contents{
							font-size: 20px;
							color: red;
							margin: 3%;
							margin-left: 0px;
							font-weight: bold;
							text-align: left;
						}
					</style>');
			if((($next_page + 5) / 5) > 1){ //reverse the one on set up at the top 
				echo '<p id="Contents">No more accommodations to display, please make use of the "prev" button</p>';
			}else{
				echo '<p id="Contents">Accommodations not available at the moment. Check again later</p>';
			}
			return;
		}
		if(sizeof($accommodations) > 0) {
            foreach($accommodations as $accommodation => $value){
                $temp_accommodation = $accommodations[$accommodation]['id'];
                $sql = "SELECT stars_values, scale_values, rate_counter
                        FROM star_and_scale_rating 
                        WHERE accommo_id = \"$temp_accommodation\" LIMIT 1";
                $results = $sql_results->results_accommodations($sql);
                $sum_scale = " / ";
                $sum_stars = $counter = 0;
                if($results->num_rows > 0){
                    $row = $results->fetch_assoc();
                    $stars = explode(",", $row['stars_values']);
                    $scale = explode(",", $row['scale_values']);
                    $counter = $row['rate_counter'];
                    $sum_scale = 0;
                    for($i = 0; $i < (sizeof($stars) - 1);$i++){
                        $sum_stars = $sum_stars + $stars[$i];
                        $sum_scale = $sum_scale + $scale[$i];
                    }
                    $sum_stars = ($sum_stars > 0) ? number_format(($sum_stars / $counter)) : $sum_stars;
                    $sum_scale = ($sum_scale > 0) ? number_format(($sum_scale / $counter), 1) : $sum_scale;
                    if($sum_stars > 5) $sum_stars = number_format(0.0);
                    if($sum_scale > 10 || $sum_scale <= 0) $sum_scale = number_format(0.0, 1);
                    $accommodations[$accommodation]['stars'] = $sum_stars; 
                    $accommodations[$accommodation]['ratings'] = $sum_scale; 
                    $accommodations[$accommodation]['reviews'] = $counter; 
                }            
            }
            ?>
                <div class="accommodations">
                    <?php require_once 'featured-template.php'; ?>
                </div>
            <?php
        }else{
			echo('<style type="text/css">
					#Contents{
						font-size: 20px;
						color: red;
						margin: 3%;
						margin-left: 0px;
						font-weight: bold;
						text-align: left;					}
				</style>
				<p id="Contents">Accommodations not available at the moment. Try again later</p>');
				return;
		}
/*	}else {
        echo "Invalid request";
        return;		
	}*/