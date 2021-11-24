<?php
	function price_format($x){
		return number_format( sprintf( "%.2f", ($x)), 2, '.', '' );
	}
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $accommodation = (isset($_REQUEST['accommodation']) && preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['accommodation'])) ? $_REQUEST['accommodation'] : "";
        if($accommodation == ""){
            ?>
            <div style="color: red; margin: 4% 2%;">
                <h4>Oops..!!</h4>
                <p>It seems like the link is broken or has been changed <br>
                Please use the link provided on the <a href="../featured.php">accommodations' listing</a><br>
                If the error persist, we'll have a look at it on our side soon</p>
            </div>                
            <?php
            return;
        }
        
        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'overview'){
            
            $sql = "SELECT accommodations.*, rooms.*, address.main_address 
                FROM ((accommodations
                    INNER JOIN address ON accommodations.id = address.accommo_id)
                    INNER JOIN rooms ON accommodations.id = rooms.accommo_id)
                WHERE display = 1 AND accommodations.id =\"$accommodation\" LIMIT 1";
                require("../includes/conn.inc.php");
                $sql_results = new SQL_results();
                $results = $sql_results->results_accommodations($sql);
                $accommodation = array();
                if ($results->num_rows > 0) {
                    while ($row = $results->fetch_assoc()) {
                        if(false/*!preg_match('/^[a-zA-Z0-9]+$/', $row['id']) ||
                            !preg_match('/^[a-zA-Z0-9\@\'\(\)\.\s]+$/', $row['name']) ||
                            !preg_match('(0|1)', $row['nsfas']) ||
                            !preg_match('/^[a-zA-Z0-9]+$/', $row['room_id']) ||
                            !preg_match('/^[a-zA-Z0-9]+$/', $row['manager']) ||
                            !preg_match('/^[a-zA-Z0-9\'\.\<\>]+$/', $row['main_address']) ||
                            !preg_match('/^[a-zA-Z0-9\,\.\?\'\@\+\-\/\(\)\&\s]*$/', $row['about'])*/) {
                            ?>
                            <div style="color: red; margin: 4% 2%;">
                                <h4>Oops..!!</h4>
                                <p>It seems like the link is broken or has been changed <br>
                                Please use the link provided on the <a href="../featured.php">accommodations' listing</a><br>
                                If the error persist, we'll have a look at it on our side soon</p>
                            </div> 
                            <?php
                            return;
                        };

                        $accommodation = array("id" => $row['id'],
                                        "name" => $row['name'], 
                                        "images" => "", 
                                        "nsfas" => $row['nsfas'], 
                                        "room" => array("id" =>$row['room_id'],
                                                         "single_available" =>$row['single_sharing'],
                                                         "double_available" =>$row['double_sharing'],
                                                         "multi_available" =>$row['multi_sharing'],
                                                         "single_sharing_amount_c" =>"0.00",
                                                         "single_sharing_amount_b" =>"0.00",
                                                         "double_sharing_amount_c" =>"0.00",
                                                         "double_sharing_amount_b" =>"0.00",
                                                         "multi_sharing_amount_c" =>"0.00",
                                                         "multi_sharing_amount_b" =>"0.00"),
                                        "manager" => $row['manager'],
                                        "stars" => 0,
                                        "map_coordinates" => "32.0.252.3, -6.36.005",
                                        "ratings" => 0,
                                        "reviews" => 0,
                                        "location" => $row['main_address'],
                                        "about" => $row['about']);

                        /************************** Load amounts *************************/
                        $room_id = $accommodation['room']['id'];
                        $sql = "SELECT cash, bursary 
                                FROM single_s
                                WHERE room_id = \"$room_id\" LIMIT 1";
                        $results = $sql_results->results_accommodations($sql);
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $accommodation['room']['single_sharing_amount_c'] = $row['cash'];
                            $accommodation['room']['single_sharing_amount_b'] = $row['bursary'];
                        }
                        $sql = "SELECT cash, bursary 
                                FROM double_s
                                WHERE room_id = \"$room_id\" LIMIT 1";
                        $results = $sql_results->results_accommodations($sql);
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $accommodation['room']['double_sharing_amount_c'] = $row['cash'];
                            $accommodation['room']['double_sharing_amount_b'] = $row['bursary'];
                        }
                        $sql = "SELECT cash, bursary 
                                FROM multi_s
                                WHERE room_id = \"$room_id\" LIMIT 1";
                        $results = $sql_results->results_accommodations($sql);
                        if ($results->num_rows > 0) {
                            $row = $results->fetch_assoc();
                            $accommodation['room']['multi_sharing_amount_c'] = $row['cash'];
                            $accommodation['room']['multi_sharing_amount_b'] = $row['bursary'];
                        }                
                    }
                }else{
                    ?>
                    <div style="color: red; margin: 4% 2%;">
                        <h4>Oops..!!</h4>
                        <p>It seems like the link is broken or has been changed <br>
                        Please use the link provided on the <a href="../featured.php">accommodations' listing</a><br>
                        If the error persist, we'll have a look at it on our side soon</p>
                    </div>                
                    <?php
                    return;
                }
            ?>
            <div id="accommodation">
                <div id="overview_container">
                    <div class="sub_container">
                        <div class="image">
                            <?php
                                $payload = $accommodation["id"];
                                $sql = "SELECT image 
                                        FROM (images
                                            INNER JOIN accommodation_images  ON images.image_id = accommodation_images.image_id) 
                                        WHERE accommodation_images.accommo_id = \"$payload\" LIMIT 1";
                                $results = $sql_results->results_accommodations($sql);
                                if ($results->num_rows > 0) {
                                    $row = $results->fetch_assoc();
                                    $accommodation["image"] = $accommodation["name"] . "/" . $row['image'];   
                                }

                            ?>
                            <img src="./images/accommodation/<?php echo $accommodation["image"];?>" 
                                 alt="<?php echo $accommodation["name"]; ?>" style="width: 100%; height: 100%;">
                            <div onclick="photos()">
                                <span class="fas fa-images"></span> More Images
                            </div>
                        </div>
                        <div class="info">
                            <h4><?php echo $accommodation["name"]; ?></h4>
                            <span class="stars">
                                <?php 
                                    $stars = $accommodation["stars"];
                                    for($j = 1; $j < 6; $j++){
                                        echo '<span class="fas fa-star ' . (($stars >= $j) ? "checked" : "") . '"></span>';
                                    }
                                ?>
                            </span><br>
                            
                            <?php 
                                $ratings = $accommodation["ratings"];
                                if($ratings > 0){
                                    echo '<p class="ratings" style="padding: 1% 3%;
                                                  margin-right: 2%;
                                                  border-radius: 10px;
                                                  background-color: blue;
                                                  text-align: center;
                                                  color: white;
                                                  display: inline;">
                                            ' . $ratings . ' </p>';
                                    $reviews = $accommodation["reviews"];
                                    $reviews = (reviews == 1) ? " 1 Review" : ' ' . $reviews . " Reviews";
                                    echo '<small>' . $reviews . '</small>';
                                }else{
                                    echo '<p class="rating" style=" padding: 1% 3%;
                                                  border-radius: 10px;
                                                  margin-right: 2%;
                                                  background-color: lightgray;
                                                  text-align: center;
                                                  color: white;
                                                  display: inline;">
                                            / </p>';
                                    echo '<small> 0 Reviews</small>';
                                }

                                $nsfas = $accommodation["nsfas"];
                                if($nsfas == 1)
                                    echo '<p class="nsfas"><span>NSFAS Accredited</span></p>';                            
                                else echo '<p class="nsfas"><span style="background-color: pink"><del>NSFAS Accredited</del></span></p>';
                                $location = ($accommodation["location"]) ? $accommodation["location"] : "Location N/A";
                                $accommodation["location"] = str_replace(", ", "<br>", $location);  
                                $temp_loc = explode("<br>", $accommodation["location"]);
            
                                $accommodation["location"] = "";
                                $counter = 0;
                                for($i = 0; $i < 4; $i++){
                                    if(isset($temp_loc[$i])){
                                        if($temp_loc[$i] == "") continue;
                                        else {
                                            $counter++;
                                            if($counter == 3){
                                                $accommodation["location"] .= $temp_loc[$i] . " ";
                                            }else{
                                                $accommodation["location"] .= $temp_loc[$i] . "<br>"; 
                                            }
                                            if($counter == 3 && $i == 3) $accommodation["location"] .= "<br>";
                                        }
                                    } 
                                }
                                $accommodation["location"] = substr($accommodation["location"], 0, (strlen($accommodation["location"]) - 4));
                                //print_r($accommodation);
                            ?>
                            <p class="address">
                                <strong>
                                    <?php echo $accommodation['location']; ?>
                                    <span data-toggle="tooltip" data-placement="left" title class="fas fas fa-info-circle" 
                                        data-original-title="To get GPS direction, click on the 'Direction' button at the top"></span>
                                </strong>
                            </p>
                        </div>
                        <div class="price">
                            <div>
                                <table>
                                    <colgroup>
                                        <col span="1">
                                        <col span="1">
                                        <col span="1">
                                        <col span="1">
                                        <col span="1">
                                    </colgroup>
                                    <tbody>
                                        <?php
                                            $single_c = "R" . price_format($accommodation['room']['single_sharing_amount_c']); 
                                            $single_b = "R" . price_format($accommodation['room']['single_sharing_amount_b']); 
                                            $double_c = "R" . price_format($accommodation['room']['double_sharing_amount_c']); 
                                            $double_b = "R" . price_format($accommodation['room']['double_sharing_amount_b']); 
                                            $multi_c = "R" . price_format($accommodation['room']['multi_sharing_amount_c']); 
                                            $multi_b = "R" . price_format($accommodation['room']['multi_sharing_amount_b']);
                                            $single_s = $accommodation['room']['single_available'];
                                            $double_s = $accommodation['room']['double_available']; 
                                            $multi_s = $accommodation['room']['multi_available'];
                                            if($single_c == "R0.00") $single_c = "<del>" . $single_c . "</del>";
                                            if($single_b == "R0.00") $single_b = "<del>" . $single_b . "</del>";
                                            if($double_c == "R0.00") $double_c = "<del>" . $double_c . "</del>";
                                            if($double_b == "R0.00") $double_b = "<del>" . $double_b . "</del>";
                                            if($multi_c == "R0.00") $multi_c = "<del>" . $multi_c . "</del>";
                                            if($multi_b == "R0.00") $multi_b = "<del>" . $multi_b . "</del>";
                                        ?>
                                        <tr>
                                            <th>Room Type</th>
                                            <th>Cash</th>
                                            <th>Bursary</th>
                                            <th>Status</th>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-user"></span> Single Room</td>
                                            <td><?php echo $single_c; ?></td>
                                            <td><?php echo $single_b; ?></td>
                                            <?php
                                                if($single_s == 1)
                                                    echo '<td><span style="color: blue">Available</span></td>';
                                                else if($single_s == 0)
                                                    echo '<td><span style="color: red">Full</span></td>';
                                                else echo '<td><span style="color: orange">N/A</span></td>';
                                            ?>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-user-friends"></span> Double Shaing</td>
                                            <td><?php echo $double_c; ?></td>
                                            <td><?php echo $double_b; ?></td>
                                            <?php
                                                if($double_s == 1)
                                                    echo '<td><span style="color: blue">Available</span></td>';
                                                else if($double_s == 0)
                                                    echo '<td><span style="color: red">Full</span></td>';
                                                else echo '<td><span style="color: orange">N/A</span></td>';
                                            ?>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-users"></span> Multi-Sharing</td>
                                            <td><?php echo $multi_c; ?></td>
                                            <td><?php echo $multi_b; ?></td>
                                            <?php
                                                if($multi_s == 1)
                                                    echo '<td><span style="color: blue">Available</span></td>';
                                                else if($multi_s == 0)
                                                    echo '<td><span style="color: red">Full</span></td>';
                                                else echo '<td><span style="color: orange">N/A</span></td>';
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="sub_container">
                        <div class="features">
                            <br>
                            <h5>Features</h5>
                            <?php
                                $temp_id = $accommodation["id"];
                                $sql_feautures = "SELECT * FROM features WHERE accommo_id = \"$temp_id\"";
                                $results = $sql_results->results_accommodations($sql_feautures);
                                require_once './accommodation-features.php';
                                require_once './icons.php';
                                if($results->num_rows > 0){
                                    $features = [];
                                    while($row = $results->fetch_assoc()){
                                        $f = '';
                                        for ($i = 1; $i < 31; $i++) {
                                            $f = 'f' . $i;
                                            $f = $row[$f];
                                            array_push($features, $f);
                                        }
                                    }
                                    $features = to_text($features); // pass array to fun
                                    echo "<span> | ";
                                        for ($i = 0; $i < 13; $i++) { 
                                            if($features[$i] != 0 || $features[$i] != ""){
                                                echo '<span class="' . $icons[$i] . '"></span>';
                                                echo "<span> " . $features[$i] . " </span> | ";
                                            }
                                        }
                                    echo "</span>";
                                    echo ' <a href="#" onclick="about()">more...</a>';
                                }else echo "<i style='color:red'>Features for this accommodation not available at the moment</i>";            
                            ?>
                        </div>
                        <div class="about_us">
                            <br>
                            <h5>About us</h5>
                            <p>
                                <?php
                                    echo substr($accommodation["about"], 0, 150) . "... <a href='#' onclick='about()'> more</a>";
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
          
            <?php
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'images'){
            ?>
                <link rel="stylesheet" type="text/css" href="./css/style-slide-show.css">
                <link rel="stylesheet" type="text/css" href="./css/style-accommodation-images.css">
				<div id="image_container">
					<div class="images">
						<span tittle="Close Modal" id="close_slide" onclick="close_slide_show()" class="close">x</span>
						<?php
                            require("../includes/conn.inc.php");
                            $sql_results = new SQL_results();
                            $sql = "SELECT name FROM accommodations WHERE id =\"$accommodation\" LIMIT 1";
							$results = $sql_results->results_accommodations($sql);
							$accommodation_name = "";
                            if ($results->num_rows > 0) {
								$name = $results->fetch_assoc();
                                $accommodation_name = $name['name'];
                            }
                            $sql = "SELECT image 
                                    FROM (images
                                        INNER JOIN accommodation_images ON images.image_id = accommodation_images.image_id)
                                    WHERE accommodation_images.accommo_id = '$accommodation' LIMIT 15";
							$results = $sql_results->results_accommodations($sql);
							if ($results->num_rows > 0 && $results->num_rows < 16) {
								$counter = 0;
								$total = $results->num_rows;
								while ($row = $results->fetch_assoc()) {
									if(preg_match('/^[a-zA-Z0-9]+\.+(jpg|jpeg|png|gif)+$/', $row['image'])){
										$counter++;
										echo '<div class="image">';
											$tmp_image = explode(".", $row['image']);
											$ext = end($tmp_image);
											echo '<div class="num fade" style="display:none">' .
														$counter . '\\' . $total . '
													</div>';
											echo '<img src="images/accommodation/' . $accommodation_name . 
												'/' . $row['image'] . '" alt="' . $accommodation_name . '"
													onclick="slide_show_current(' . $counter . ')">
												<a href="images/accommodation/' . $accommodation_name . 
												'/' . $row['image'] . '" download="Obocircle.com_image.' . end($tmp_image) . '">
													<span class="fas fa-download"></span>
												</a><br>';
										echo "</div>\n";
									}
								}
							}else echo "<i style='color:red'>No images to display at the moment</i>";
						?>
						<a style="display:none" class="prev" onclick="plus_slide(-1)">
							&#10094
						</a>
						<a style="display:none" class="next" onclick="plus_slide(1)">
							&#10095
						</a>																					
					</div>
				</div>                
            <?php
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'direction'){
            ?>

<br>
    <div id="floating-panel">
      <b>From: </b>
      <select id="start">
        <option value="get_current_location()">Use my current location</option>
        <option value="23 Error street, johannesburg">
          Truman house
        </option>
        <option value="81 rissik treet, johannesburg">
          81 Rissik street
        </option>
      </select>
      <b>End: </b>
      <select id="end">
        <option value="23 Error street, johannesburg">
          Truman house
        </option>
        <option value="105 Smith Street, Johannesburg">
          Wits
        </option>
    </select>
        <!--<button>Find routes</button>-->
    </div>
    &nbsp;
    <div id="warnings-panel"></div>

 <div id="view_direction" style="width: 100%; height: 400px">

	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=initMap"></script>
    <script type="text/javascript">
        
         function initMap() {
  const markerArray = [];
  // Instantiate a directions service.
  const directionsService = new google.maps.DirectionsService();
  // Create a map and center it on Manhattan.
  const map = new google.maps.Map(document.getElementById("view_direction"), {
    zoom: 13,
    center: { lat: 40.771, lng: -73.974 },
  });
  // Create a renderer for directions and bind it to the map.
  const directionsRenderer = new google.maps.DirectionsRenderer({ map: map });
  // Instantiate an info window to hold step text.
  const stepDisplay = new google.maps.InfoWindow();

  // Display the route between the initial start and end selections.
  calculateAndDisplayRoute(
    directionsRenderer,
    directionsService,
    markerArray,
    stepDisplay,
    map
  );

  // Listen to change events from the start and end lists.
  const onChangeHandler = function () {
    calculateAndDisplayRoute(
      directionsRenderer,
      directionsService,
      markerArray,
      stepDisplay,
      map
    );
  };

  document.getElementById("start").addEventListener("change", onChangeHandler);
  document.getElementById("end").addEventListener("change", onChangeHandler);
}

function calculateAndDisplayRoute(
  directionsRenderer,
  directionsService,
  markerArray,
  stepDisplay,
  map
) {
  // First, remove any existing markers from the map.
  for (let i = 0; i < markerArray.length; i++) {
    markerArray[i].setMap(null);
  }

  // Retrieve the start and end locations and create a DirectionsRequest using
  // WALKING directions.
  directionsService
    .route({
      origin: document.getElementById("start").value,
      destination: document.getElementById("end").value,
      travelMode: google.maps.TravelMode.WALKING,
    })
    .then((result) => {
      // Route the directions and pass the response to a function to create
      // markers for each step.
      document.getElementById("warnings-panel").innerHTML =
        "<b>" + result.routes[0].warnings + "</b>";
      directionsRenderer.setDirections(result);
      showSteps(result, markerArray, stepDisplay, map);
    })
    .catch((e) => {
      window.alert("Directions request failed due to " + e);
    });
}

function showSteps(directionResult, markerArray, stepDisplay, map) {
  // For each step, place a marker, and add the text to the marker's infowindow.
  // Also attach the marker to an array so we can keep track of it and remove it
  // when calculating new routes.
  const myRoute = directionResult.routes[0].legs[0];

  for (let i = 0; i < myRoute.steps.length; i++) {
    const marker = (markerArray[i] =
      markerArray[i] || new google.maps.Marker());

    marker.setMap(map);
    marker.setPosition(myRoute.steps[i].start_location);
    attachInstructionText(
      stepDisplay,
      marker,
      myRoute.steps[i].instructions,
      map
    );
  }
}

function attachInstructionText(stepDisplay, marker, text, map) {
  google.maps.event.addListener(marker, "click", () => {
    // Open an info window when the marker is clicked on, containing the text
    // of the step.
    stepDisplay.setContent(text);
    stepDisplay.open(map, marker);
  });
}
</script>


            <?php
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'about'){
            $sql = "SELECT accommodations.name, accommodations.about, 
                            address.main_address, address.contact, address.email
                    FROM(accommodations
                         INNER JOIN address ON accommodations.id = address.accommo_id) 
                    WHERE id = \"$accommodation\" LIMIT 1";
            $name = $about = $address = $phone = $email = "";
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();
            $results = $sql_results->results_accommodations($sql);
            if ($results->num_rows > 0) {
                $data = $results->fetch_assoc();
                if(true){
                    $name = $data['name'];
                    $about = $data['about'];
                    $phone = ($data['contact'] != "") ? $data['contact'] : "N/A";
                    $email = ($data['email'] != "") ? $data['email'] : "N/A";
                    $address = ($data['main_address'] != "") ? $data['main_address'] : "Address N/A";
                }
            }
            $phone = substr($phone, 0, 3) . ' ' . substr($phone, 3, 3) . ' ' . substr($phone, 6, 4);
            $address = str_replace(", ", "<br>", $address);  
            $temp_loc = explode("<br>", $address);

            $address = "";
            $counter = 0;
            for($i = 0; $i < 4; $i++){
                if(isset($temp_loc[$i])){
                    if($temp_loc[$i] == "") continue;
                    else {
                        $counter++;
                        if($counter == 3){
                            $address .= $temp_loc[$i] . " ";
                        }else{
                            $address .= $temp_loc[$i] . "<br>"; 
                        }
                        if($counter == 3 && $i == 3) $address .= "<br>";
                    }
                } 
            }
            $address = substr($address, 0, (strlen($address) - 4));
            
            ?>
            <!-- About -->
               <div id="about">
                        <div class="name">
                            <h3><?php echo $name; ?></h3>
                        </div>
                        <div class="address">
                            <h5>
                                Tell: <span style="font-size: 18px;"><?php echo $phone; ?></span><br>
                                Email: <span style="font-size: 18px;"><?php echo $email; ?></span>
                            </h5>
                            <h5>Address</h5>
                            <p><?php echo $address; ?></p>
                            <div id="view_on_map">

                            </div>
                        </div>
                        <div class="features">
                            <h5>Features</h5>
                            <div>
                                <?php
                                    $sql_feautures = "SELECT * FROM features WHERE accommo_id = \"$accommodation\"";
                                    $results = $sql_results->results_accommodations($sql_feautures);
                                    require_once './accommodation-features.php';
                                    require_once './icons.php';
                                    if($results->num_rows > 0){
                                        $features = [];
                                        while($row = $results->fetch_assoc()){
                                            $f = '';
                                            for ($i = 1; $i < 31; $i++) {
                                                $f = 'f' . $i;
                                                $f = $row[$f];
                                                array_push($features, $f);
                                            }
                                        }
                                        $features = to_text($features); // pass array to fun
                                            for ($i = 0; $i < 30; $i++) { 
                                                if($features[$i] != 0 || $features[$i] != ""){
                                        echo "<span>";
                                                    echo (($i == 0) ? " <span></span> " : " <span>| </span> " );
                                                    echo (($icons[$i] != "") ? '<span class="' . $icons[$i] . '"></span>' : "");
                                                    echo "<span> " . $features[$i] . " </span>";
                                        echo "</span>";
                                                }
                                            }
                                    }else echo "<i style='color:red'>Features for this accommodation not available at the moment</i>";
                                ?>
                            </div>
                        </div>
                        <div class="about_us">
                            <h5>About us </h5>
                            <p><?php echo $about; ?></p>
                        </div>
                        <div class="manager">
                            <?php
                                $manager = "";
                                $sql = "SELECT manager FROM accommodations WHERE id = \"$accommodation\" LIMIT 1";
                                $results = $sql_results->results_accommodations($sql);
                                if($results->num_rows > 0){
                                    $row = $results->fetch_assoc();
                                    $manager = $row['manager'];
                                }
                                if(preg_match('/^[a-zA-Z0-9]+$/', $manager)){
                                    $sql = "SELECT  users.first_name, users.last_name, users.reg_date,
                                                    display_picture.image
                                            FROM ((users
                                                INNER JOIN users_extended ON users.id = users_extended.user_id)
                                                INNER JOIN display_picture ON users.id = display_picture.user_id)
                                            WHERE users.id = \"$manager\" AND users_extended.profile_status = \"1\" 
                                            LIMIT 1";
                                    $results = $sql_results->results_profile($sql);
                                    if($results->num_rows > 0){
                                        $row = $results->fetch_assoc();
                                        $name = $row['first_name'] . " " . $row['last_name'];
                                        $image = substr($manager, 5, 15) . "/" . $row['image'];
                                        $date_joined = "Joined in " . substr(date("d M, Y", strtotime(substr($row['reg_date'], 0, 10))), 3);
                                        ?>
                                        <h5>Hosted by</h5>
                                        <div class="info">
                                            <div class="image">
                                                <a href="#" target="_blank">
                                                    <img src="./images/users/<?php echo $image; ?>" alt="<?php echo $name; ?>" style="width: 100%; height: 100%">
                                                </a>
                                            </div>
                                            <div class="personal">
                                                <p class="name"><strong><?php echo $name; ?></strong></p>
                                                <p class="joined"><?php echo $date_joined; ?></p>
                                                <p><span class="fas fa-shield-virus" style="color: red"></span> Account Verified</p>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <script type="text/javascript">
                function my_map(){
                    var my_latlng = {lat: -26.199070, lng: 28.058319};
                    var map = new google.maps.Map(document.getElementById('view_on_map'), {
                        zoom: 16, 
                        center:my_latlng
                    })
                    var marker = new google.maps.Marker({
                        position: my_latlng, 
                        map: map,
                        title: 'Truman House' 
                    });
                  }
            </script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=my_map"></script>

            <?php
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'reviews'){
            ?>
            <div id="reviews">
                <h4 class="name">African House</h4>
                <div class="ratings">
                    <h5>Guest overall ratings</h5>
                    <div class="ratings_container">
                        <span class="rating_value"  style=" padding: 2px 6px;
                                                      margin-right: 5px;
                                                      border-radius: 40% 40% 0px 40%;
                                                      background-color: blue;
                                                      text-align: center;
                                                      color: white;
                                                      display: inline;"> 8.2 </span>
                        <span><strong>Excellent</strong></span>
                        <small> 55 reviews</small>
                        <div class="ratings_sub_container">
                            <br>
                            <div class="element">
                                <label for="location">
                                    Location
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar">50</div>
                                </div>
                                <p class="value">4.3</p>
                            </div>
                            <div class="element">
                                <label for="cleanliness">
                                    Cleanliness
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar">50</div>
                                </div>
                                <p class="value">4.3</p>
                            </div>
                            <div class="element">
                                <label for="rooms">
                                    Rooms
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar">50</div>
                                </div>
                                <p class="value">4.3</p>
                            </div>
                            <div class="element">
                                <label for="stuff">
                                    Stuff
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar">50</div>
                                </div>
                                <p class="value">4.3</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="faq">
                    <h5>Frequently asked questions</h5>
                    <div class="question">
                        <p class="q">
                            Can I move in in the middle of the month? 
                            Can I move in in the middle of the month.
                            <span class="fas fa-angle-left" style="float: right; margin-right: 5%;"></span>
                        </p>
                        <p class="answer">
                            Yes, we allows student to move in at anytime of the month. 
                            Yes, we allows student to move in at anytime of the month. 
                        </p>
                    </div>

                    <div class="question">
                        <p class="q">
                            Can I move in in the middle of the month? 
                            <span class="fas fa-angle-down" style="float: right; margin-right: 5%;"></span>
                        </p>
                        <p class="answer">
                            Yes, we allows student to move in at anytime of the month. 
                        </p>
                    </div>

                    <div class="question">
                        <p class="q">
                            Can I move in in the middle of the month? 
                            <span class="fas fa-angle-down" style="float: right; margin-right: 5%;"></span>
                        </p>
                        <p class="answer">
                            Yes, we allows student to move in at anytime of the month. 
                        </p>
                    </div>

                    <div class="question">
                        <p class="q">
                            Can I move in in the middle of the month? 
                            <span class="fas fa-angle-down" style="float: right; margin-right: 5%;"></span>
                        </p>
                        <p class="answer">
                            Yes, we allows student to move in at anytime of the month. 
                            Yes, we allows student to move in at anytime of the month. 
                        </p>
                    </div>
                </div>
           <?php
        }
    }else{
        echo "<h5 style='color: red; margin: 7% 5%;>Invalid request</h5>";
    }

?>