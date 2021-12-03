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
                Please use the link provided on the <a href="./featured.php">accommodations' listing</a><br>
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
                                Please use the link provided on the <a href="./featured.php">accommodations' listing</a><br>
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
                        
                        /************************** Load reviews *************************/
                        $temp_accommodation = $accommodation['id'];
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
                            $accommodation['stars'] = $sum_stars; 
                            $accommodation['ratings'] = $sum_scale; 
                            $accommodation['reviews'] = $counter;
                        }
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
                        Please use the link provided on the <a href="./featured.php">accommodations' listing</a><br>
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
                                    $reviews = ($reviews == 1) ? " 1 Review" : ' ' . $reviews . " Reviews";
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
            $sql = "SELECT accommodations.name, address.main_address
                    FROM (accommodations
                        INNER JOIN address ON accommodations.id = address.accommo_id)
                    WHERE accommo_id =\"$accommodation\" LIMIT 1";  
            $address = $name = "";
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();                            
            $results = $sql_results->results_accommodations($sql);
            if($results->num_rows > 0){
                $row = $results->fetch_assoc();
                if($row['main_address'] != ""){
                    $name = $row['name'];
                    $temp_address = explode(",", str_replace("<br>", ",", $row['main_address']));
                    for($i = 0; $i < 4; $i++){
                        if($temp_address[$i] != "") $address .= $temp_address[$i] . ", ";
                        else continue;
                    }
                    $address = substr($address, 0, (strlen($address) - 2));
                }
            }
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
                    <option value="<?php echo $address; ?>"><?php echo $name; ?></option>
                  </select> 
                </div>
                &nbsp;
                <div id="warnings-panel"></div>

                 <div id="view_direction" style="width: 100%; height: 400px">

                <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=initMap"></script>
                <script type="text/javascript">
function ipLookUp () {
  $.ajax('http://ip-api.com/json')
  .then(
      function success(response) {
          console.log('User\'s Location Data is ', response);
          console.log('User\'s Country', response.country);
          getAdress(response.lat, response.lon)
},

      function fail(data, status) {
          console.log('Request failed.  Returned status of',
                      status);
      }
  );
}
function getAddress (latitude, longitude) {
  $.ajax('https://maps.googleapis.com/maps/api/geocode/json?
          latlng=' + latitude + ',' + longitude + '&key=' + 
          GOOGLE_MAP_KEY)
  .then(
    function success (response) {
      console.log('User\'s Address Data is ', response)
    },
    function fail (status) {
      console.log('Request failed.  Returned status of',
                  status)
    }
   )
}
if ("geolocation" in navigator) {
  // check if geolocation is supported/enabled on current browser
  navigator.geolocation.getCurrentPosition(
   function success(position) {
     // for when getting location is a success
     console.log('latitude', position.coords.latitude, 
                 'longitude', position.coords.longitude);
     getAddress(position.coords.latitude, 
                position.coords.longitude)
   },
function error(error_message) {
    // for when getting location results in an error
    console.error('An error has occured while retrieving
                  location', error_message)
    ipLookUp()
 }
});
} else {
  // geolocation is not supported
  // get your location some other way
  console.log('geolocation is not enabled on this browser')
  ipLookUp();
}
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
            $name = $rate_counter = "";
            $rate_description = " Not good";
            $counter = $sum_stars = 0;
            $sum_scale = " / ";
            $sql = "SELECT name
                    FROM accommodations 
                    WHERE id = \"$accommodation\" LIMIT 1";
            require("../includes/conn.inc.php");
            $sql_results = new SQL_results();
            $results = $sql_results->results_accommodations($sql);
            if($results->num_rows > 0){
                $row = $results->fetch_assoc();
                $name = $row['name'];
            }
            $sql = "SELECT stars_values, scale_values, rate_counter
                    FROM star_and_scale_rating 
                    WHERE accommo_id = \"$accommodation\" LIMIT 1";
            $results = $sql_results->results_accommodations($sql);
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
                $sum_stars = ($sum_stars > 0) ? number_format(($sum_stars / $counter), 1) : $sum_stars;
                $sum_scale = ($sum_scale > 0) ? number_format(($sum_scale / $counter), 1) : $sum_scale;
                if($sum_stars > 5) $sum_stars = number_format(0.0, 1);
                if($sum_scale > 10 || $sum_scale <= 0) $sum_scale = number_format(0.0, 1);
                if($sum_scale > 0 && $sum_scale < 2) $rate_description = "Very Poor";
                else if($sum_scale >= 2 && $sum_scale < 4) $rate_description = "Poor";
                else if($sum_scale >= 4 && $sum_scale < 6) $rate_description = "Good";
                else if($sum_scale >= 6 && $sum_scale < 8) $rate_description = "Very good";
                else if($sum_scale >= 8 && $sum_scale <= 10) $rate_description = "Excelent";
                else {
                    $counter = 0;
                }
            }
            $rate_counter = $rate_location = $rate_services = $rate_rooms = $rate_stuff = 0;
            $sql = "SELECT average_ratings.rate_counter, 
                            rate_location.location_values, 
                            rate_services.services_values, 
                            rate_rooms.rooms_values, 
                            rate_stuff.stuff_values
                    FROM ((((average_ratings
                        INNER JOIN rate_location ON average_ratings.location_id = rate_location.location_id)
                        INNER JOIN rate_services ON average_ratings.services_id = rate_services.services_id)
                        INNER JOIN rate_rooms ON average_ratings.rooms_id = rate_rooms.rooms_id)
                        INNER JOIN rate_stuff ON average_ratings.stuff_id = rate_stuff.stuff_id)
                    WHERE accommo_id = \"$accommodation\" LIMIT 1";
            $results = $sql_results->results_accommodations($sql);
            if($results->num_rows > 0){
                $row = $results->fetch_assoc();
                //print_r($row);
                $rate_counter = $row['rate_counter'];
                $temp_location = explode(",", $row['location_values']);
                $temp_service = explode(",", $row['services_values']);
                $temp_rooms = explode(",", $row['rooms_values']);
                $temp_stuff = explode(",", $row['stuff_values']);
                for($i = 0; $i < $rate_counter; $i++){
                    $rate_location = $rate_location + (($temp_location[$i] > 0 && $temp_location[$i] <= 5) ? $temp_location[$i] : 0);
                    $rate_services = $rate_services + (($temp_service[$i] > 0 && $temp_service[$i] <= 5) ? $temp_service[$i] : 0);
                    $rate_rooms = $rate_rooms + (($temp_rooms[$i] > 0 && $temp_rooms[$i] <= 5) ? $temp_rooms[$i] : 0);
                    $rate_stuff = $rate_stuff + (($temp_stuff[$i] > 0 && $temp_stuff[$i] <= 5) ? $temp_stuff[$i] : 0);
                }
                $rate_location = ($counter > 0) ? number_format(($rate_location / $rate_counter), 1) : 0;
                $rate_services = ($counter > 0) ? number_format(($rate_services / $rate_counter), 1) : 0;
                $rate_rooms = ($counter > 0) ? number_format(($rate_rooms / $rate_counter), 1) : 0;
                $rate_stuff = ($counter > 0) ? number_format(($rate_stuff / $rate_counter), 1) : 0;
            }
            ?>
            <div id="reviews">
                <h4 class="name"><?php echo $name; ?>
                <span style="font-size: 15px">
                <?php
                    $stars = number_format($sum_stars);
                    for($j = 1; $j < 6; $j++){
                        echo '<span class="fas fa-star ' . (($stars >= $j) ? "checked" : "") . '"></span>';
                    }
                ?>
                </span>
                </h4>
                <div class="ratings">
                    <h5>Guest overall ratings</h5>
                    <div class="ratings_container">
                        <?php
                            if($sum_scale > 0){
                                ?>
                                <span class="rating_value"  
                                      style=" padding: 2px 6px;
                                              margin-right: 5px;
                                              border-radius: 40% 40% 0px 40%;
                                              background-color: blue;
                                              text-align: center;
                                              color: white;
                                              display: inline;"> <?php echo $sum_scale; ?> </span>
                                <?php
                            }else{
                                ?>
                                <span class="rating_value"  
                                      style=" padding: 2px 6px;
                                              margin-right: 5px;
                                              border-radius: 40% 40% 0px 40%;
                                              background-color: lightgray;
                                              text-align: center;
                                              color: white;
                                              display: inline;"> <?php echo $sum_scale; ?> </span>
                                <?php
                            }        
                        ?>
                        <span><strong><?php echo $rate_description; ?></strong></span>
                        <small> <?php echo $counter . (($counter != 1) ? " Reviews" : " Review"); ?> </small>
                        <div class="ratings_sub_container">
                            <br>
                            <div class="element">
                                <label for="location">
                                    Location
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar"><?php echo number_format(($rate_location / 5 * 100)); ?></div>
                                </div>
                                <p class="value"><?php echo $rate_location; ?></p>
                            </div>
                            <div class="element">
                                <label for="cleanliness">
                                    Cleanliness
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar"><?php echo number_format(($rate_services / 5 * 100)); ?></div>
                                </div>
                                <p class="value"><?php echo $rate_services; ?></p>
                            </div>
                            <div class="element">
                                <label for="rooms">
                                    Rooms
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar"><?php echo number_format(($rate_rooms / 5 * 100)); ?></div>
                                </div>
                                <p class="value"><?php echo $rate_rooms; ?></p>
                            </div>
                            <div class="element">
                                <label for="stuff">
                                    Stuff
                                    <span data-toggle="tooltip" data-placement="right" title class="fas fas fa-info-circle" 
                                        data-original-title="This includes this and that "></span>
                                </label>
                                <div class="bar">
                                    <div class="inner_bar"><?php echo number_format(($rate_stuff / 5 * 100)); ?></div>
                                </div>
                                <p class="value"><?php echo $rate_stuff; ?></p>
                            </div>
                        </div>
                        <div>
                            <a href="#" onclick="rate_this_accommodation('<?php echo $accommodation; ?>')"><i>I want to rate this accommodation</i></a>
                        </div>
                        <div id="display_rating" style="display: none"></div>
                    </div>
                </div>
                <?php
                     $sql = "SELECT faqs.question, question_answers.answer
                            FROM (faqs
                                INNER JOIN question_answers ON faqs.question_id = question_answers.question_id) 
                            WHERE question_answers.accommo_id = \"$accommodation\" LIMIT 7";
                    $results = $sql_results->results_accommodations($sql);
                    $questions_and_answers = [];
                    if($results->num_rows > 0){
                        while($row = $results->fetch_assoc()){
                            $temp_arr = array("question"=>$row['question'],
                                          "answer"=>$row['answer']);
                            array_push($questions_and_answers, $temp_arr);
                        }
                    }
                    if(sizeof($questions_and_answers) > 0){
                        echo '<div class="faq">
                                <h5>Frequently asked questions</h5>';                    
                        $counter = 1;
                        foreach($questions_and_answers as $q_a => $value){
                            $counter++;
                            ?>
                                <div class="question">
                                    <p class="q">
                                        <?php echo $questions_and_answers[$q_a]['question']; ?>
                                        <span class="fas fa-plus" onclick="view_answer(<?php echo $counter; ?>)"></span>
                                    </p>
                                    <p class="answer"><?php echo $questions_and_answers[$q_a]['answer']; ?></p>
                                </div>                
                            <?php
                        }
                        echo '</div>';
                    }
                ?>
                <script type="text/javascript">
                    $(document).ready(function(){
                        for(let i = 1; i < 6; i++){   
                            let w = $("#reviews .ratings .ratings_sub_container .element:nth-child(" + i + ") .bar .inner_bar").html();
                            if(parseInt(w) < 0.2)
                                $("#reviews .ratings .ratings_sub_container .element:nth-child(" + i + ") .bar .inner_bar").css({"width": "5%"})
                            else
                            $("#reviews .ratings .ratings_sub_container .element:nth-child(" + i + ") .bar .inner_bar").css({"color":"orange", "width": w + "%"})
                        }
                        view_answer(2);
                    })
                    function rate_this_accommodation(payload){
                        $("#display_rating").css({'display':'inline-block'})
                        let url = "./rate-accommodation.php?payload=" + payload;
                        let loc = "#display_rating";
                        send_data(url, displayer, loc);
                    }
                    function close_rating(){
                        $("#display_rating").css({'display':'none'})
                        setTimeout(function() { reviews();}, 300);
                    }
                    function view_answer(num){
/*                        $("#reviews .faq .question .answer").css({"display":"none"})
                        $("#reviews .faq .question:nth-child(" + num + ") .answer").css({"display":"inline-block"})
                        
                        $("#reviews .faq .question .q span").attr("class","fas fa-plus");
                        $("#reviews .faq .question:nth-child(" + num + ")  .q span").attr("class","fas fa-minus");
*/
                        let len = $("#reviews .faq .question").length;
                        for(let i = 2; i < len; i++){
                            //if(i != num){
                                $("#reviews .faq .question:nth-child(" + i + ") .answer").css({"display":"none"})
                                $("#reviews .faq .question:nth-child(" + i + ")  .q span").attr("class","fas fa-plus");
                            //}
                        }
                        $("#reviews .faq .question:nth-child(" + num + ")  .q span").attr("class","fas fa-minus");
                        $("#reviews .faq .question:nth-child(" + num + ") .answer").slideToggle();
                    }
                </script>
           <?php
        }
    }else{
        echo "<h5 style='color: red; margin: 7% 5%;>Invalid request</h5>";
    }

?>