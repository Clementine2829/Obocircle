<?php session_start(); 
/*	Create a table with some keywords and their ids so that when you search, the keywords will be the 
	one doing the searchings and returning the ids
*/
	$accomo_id = $name = "";
	$next_page = 0;
    $sort_by = " accommodations.id ";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_REQUEST['next_page']) && preg_match('/\d{1,}/', $_REQUEST['next_page'])){
            $next_page = $_REQUEST['next_page'] * 5 - 5;	
        }
        $search = (isset($_REQUEST['search']) && preg_match('/^[a-zA-Z0-9\s\,\'\"\+\-]/', $_REQUEST['search'])) ? $_REQUEST['search'] : "";
        $room_type = (isset($_REQUEST['room_type']) && preg_match('/(any|single|double|multi)/', $_REQUEST['room_type'])) ? $_REQUEST['room_type'] : "";
        $guest_rating = (isset($_REQUEST['guest_rating']) && preg_match('/^[1-5]+$/', $_REQUEST['guest_rating'])) ? $_REQUEST['guest_rating'] : "";
        $sharing = (isset($_REQUEST['sharing'])) ? $_REQUEST['sharing'] : $room_type;
		if(isset($_REQUEST['sort'])){
            if($_REQUEST['sort'] == "name") $sort_by = " accommodations.name ";
            else if($_REQUEST['sort'] == "name") $sort_by = " accommodations.name ";
            else if($_REQUEST['sort'] == "nsfas") $sort_by = " accommodations.nsfas ";
            else if($_REQUEST['sort'] == "rating") $sort_by = " star_and_scale_rating.stars_main ";
            else if($_REQUEST['sort'] == "price") $sort_by = " accommodations.id ";
            else if($_REQUEST['sort'] == "recommendation") $sort_by = " star_and_scale_rating.scale_main ";            
        }
        $sql = "SELECT accommodations.*, rooms.*, address.main_address, address.geolocation 
                FROM (((accommodations
                    INNER JOIN address ON accommodations.id = address.accommo_id)
                    INNER JOIN rooms ON accommodations.id = rooms.accommo_id)
                    LEFT JOIN star_and_scale_rating ON accommodations.id = star_and_scale_rating.accommo_id)";
        if(preg_match('/(nsfas\s)]+$/', $search)){
            $sql .= " WHERE accommodations.display = 1) AND (accommodations.name LIKE \"%$search%\" OR accommodations.nsfas LIKE \"%$search%\") "; 
        }else if($search != ""){
            $sql .= " WHERE accommodations.display = 1) AND (accommodations.name LIKE \"%$search%\" OR accommodations.about LIKE \"%$search%\" OR 
                        address.main_address LIKE \"%$search%\" OR address.contact LIKE \"%$search%\") "; 
        }else $sql .= " WHERE (accommodations.display = 1) ";    
        
        if($sharing == "any"){
            $sql .= " AND (rooms.single_sharing = \"1\" OR rooms.double_sharing = \"1\" OR rooms.multi_sharing = \"1\") ";
        }else if($sharing == "single"){
            $sql .= " AND (rooms.single_sharing = \"1\" ) ";
        }else if($sharing == "double"){
            $sql .= " AND (rooms.double_sharing = \"1\" ) ";
        }else if($sharing == "multi"){
            $sql .= " AND (rooms.multi_sharing = \"1\" ) ";
        }
        if($guest_rating > 0 && $guest_rating <= 5){
            $sql .= " AND (star_and_scale_rating.stars_main >= \"$guest_rating\" ) ";
        }
        
        $sql .= " ORDER BY $sort_by DESC LIMIT 5 OFFSET $next_page";
        //echo $sql;
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
								"image" => "", 
								"nsfas" => $row['nsfas'], 
								"room" => array("id" =>$row['room_id'],
                                                 "single_available" =>$row['single_sharing'],
                                                 "double_available" =>$row['double_sharing'],
                                                 "multi_available" =>$row['multi_sharing'],
                                                 "single_sharing_amount" =>"0.01",
                                                 "double_sharing_amount" =>"0.01",
                                                 "muti_sharing_amount" =>"0.01"),
								"display_ammount" => 0,
								"manager" => $row['manager'],
								"stars" => 0,
								"coordinates" => $row['geolocation'],
								"ratings" => 0,
								"reviews" => 0,
								"location" => $row['main_address'],
								"about" => $row['about']);
				array_push($accommodations, $temp_arr);
			}
		}else {
            if(isset($_REQUEST['map']) && $_REQUEST['map'] == "true") return; //google maps requires coordinates 
			echo('<style type="text/css">
						#Contents{
							font-size: 20px;
							color: red;
							margin: 3%;
							margin-left: 2%;
							font-weight: bold;
							text-align: left;
						}
					</style>');
			if((($next_page + 5) / 5) > 1){ //reverse the one on set up at the top 
				echo '<p id="Contents">No more accommodations to display, please make use of the "prev" button</p>';
			}else{
                if($search != ""){
				    echo '<p id="Contents">Accommodations for the keyword "' . $search . '" not available. Please try again with different keyword</p>';
                }else{
				    echo '<p id="Contents">Accommodations not available at the moment. Check again later</p>';
                }
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
            $google_maps = [];
            $ammounts = [];
            if(isset($_REQUEST['map']) && $_REQUEST['map'] == "true"){
                require_once '../maps-body.php';   
                    ?>
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=initMap&v=weekly" async></script>
                    <script type="text/javascript">

                    function initMap() {                    
                        const map = new google.maps.Map(document.getElementById("accommodation_map"), {
                            zoom: 13,
                            center: { lat: -26.199070, lng: 28.058319 },
                        });
                        // Set LatLng and title text for the markers. The first marker (Boynton Pass)
                        // receives the initial focus when tab is pressed. Use arrow keys to
                        // move between markers; press tab again to cycle through the map controls.

                        const tourStops = (<?php echo json_encode($google_maps); ?>);
                        const ammounts = (<?php echo json_encode($ammounts); ?>);
                        
                        // Create an info window to share between markers.
                        const infoWindow = new google.maps.InfoWindow();

                        const image = {
                            url: "./images/google_maps_logo.png",
                            size: new google.maps.Size(75, 40),
                            scaledSize: new google.maps.Size(100, 100),
                        };
                        // Create the markers.
                        tourStops.forEach(([position, title, arr], i) => {
                            const marker = new google.maps.Marker({
                                position,
                                label: ammounts[i], //"$accommodations[$accommodation]['display_ammount']",
                                map,
                                icon: image,
                                title: `${title}`,
                                optimized: true,
                            });

                            // Add a click listener for each marker, and set up the info window.
                            marker.addListener("click", () => {
                                infoWindow.close();
                                infoWindow.setContent(marker.getTitle());
                                infoWindow.open(marker.getMap(), marker);
                            });
                        });
                    }     
                    </script>
                <?php
                return; //google maps requires coordinates 
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
	}else {
        echo "Invalid request";
        return;		
	}