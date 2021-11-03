<?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'overview'){
            ?>
            <div id="accommodation">
                <div id="overview_container">
                    <div class="sub_container">
                        <div class="image">
                            <img src="./images/accommodation/African House/res1.jpg" alt="Africa House" style="width: 100%; height: 100%;">
                            <div onclick="images()">
                                <span class="fas fa-images"></span> More Images
                            </div>
                        </div>
                        <div class="info">
                            <h4>African House</h4>
                            <span class="stars">
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                            </span><br>
                            <p class="ratings" style="padding: 3px 12px;
                                                      margin-right: 2%;
                                                      border-radius: 10px;
                                                      background-color: blue;
                                                      text-align: center;
                                                      color: white;
                                                      display: inline;">
                                6.9 </p>
                            <small>12 Reviews</small>
                            <p class="nsfas"><span><del>NSFAS Accredited</del></span></p>
                            <p class="address">
                                <strong>
                                    23 Main road<br>
                                    Braam<br>
                                    Johannesburg 2525
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
                                        <tr>
                                            <th>Room Type</th>
                                            <th>Cash</th>
                                            <th>Bursary</th>
                                            <th>Status</th>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-user"></span> Single Room</td>
                                            <td>R4,350.25</td>
                                            <td>R3,990.00</td>
                                            <td><span style="color: red">Full</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-user-friends"></span> Double Shaing</td>
                                            <td>R3,510.99</td>
                                            <td>R3,990.50</td>
                                            <td><span style="color: blue">Available</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="fas fa-users"></span> Multi-Sharing</td>
                                            <td>R0.00</td>
                                            <td>R0.00</td>
                                            <td><span style="color: orange">N/A</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="sub_container">
                        <div class="features">
                            <h5>Features</h5>
                            <p>
                                <span>| <span class="fas fa-bed"></span> 1/2/3+ person rooms </span> 
                                <span>| Own/Inroom kitchen </span> 
                                <span>| <span class="fas fa-bath"></span> Commune Sharing bathroom </span> 
                                <span>| Security 24/7 </span>
                                <span>| CCTV </span>
                                <span>| <span class="fas fa-fingerprint"></span> Biometric Access Control </span> 
                                <span>| Fully Furnished </span> 
                                <span>| <span class="fas fa-chess"></span> Sports fields </span> 
                                <span>| <span class="fas fa-child"></span> Recreational/ Entertainment Area </span> 
                                <span>| <span class="fa fa-wifi"></span> Uncapped WiFi </span> 
                                <span>| <span class="fas fa-dumbbell"></span> Free indoor gym </span> 
                                <span><a href="#" onclick="about()">...more</a></span>
                            </p>
                        </div>
                        <div class="about_us">
                            <h5>About us</h5>
                            <p>
                                If you looking for luxurious accommodations that offer the best services of all times i am talking about this accommodations, starting from transporta... <a href="#" onclick="about()">more</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
          
            <?php
        }else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'images'){
            ?>
                
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
            ?>
    <!-- About -->
       <div id="about">
                <div class="name">
                    <h3>Living @ Rissik</h3>
                </div>
                <div class="address">
                    <h5>
                        Tell: 011 232 4455<br>
                        Email: student@afco.co.za
                    </h5>
                    <h5>Address</h5>
                    <p>
                        1515 End Street<br>
                        Doornfontein<br>
                        Johannesburg 4525
                    </p>
                    <div id="view_on_map">

                    </div>
                </div>
                <div class="features">
                    <h5>Features</h5>
                    <div>
                        <span>
                            <span></span> <span class="fas fa-bed"></span> 1/2/3+ person rooms 
                        </span> 
                        <span>
                            <span>| </span> Own/Inroom kitchen 
                        </span> 
                        <span>
                            <span>| </span> <span class="fas fa-bath"></span> Commune Sharing bathroom 
                        </span> 
                        <span>
                            <span>| </span> Security 24/7 
                        </span>
                        <span>
                            <span>| </span> CCTV 
                        </span>
                        <span>
                            <span>| </span> <span class="fas fa-fingerprint"></span> Biometric Access Control 
                        </span> 
                        <span>
                            <span>| </span> Fully Furnished 
                        </span> 
                        <span>
                            <span>| </span> <span class="fas fa-chess"></span> Sports fields 
                        </span> 
                        <span>
                            <span>| </span> <span class="fas fa-child"></span> Recreational/ Entertainment Area 
                        </span> 
                        <span>
                            <span>| </span> <span class="fa fa-wifi"></span> Uncapped WiFi 
                        </span> 
                        <span>
                            <span>| </span> <span class="fas fa-dumbbell"></span> Free indoor gym 
                        </span> 
                        <span>
                            <span>| </span> <span class="fas fa-desktop"></span> Floor Sharing TV 
                        </span> 
                        <span>
                            <span>| </span> <span class="fab fa-playstation"></span> Playstation TV 
                        </span> 
                        <span>
                            <span>| </span> <span class="fas fa-shopping-cart"></span> Shops 
                        </span> 
                        <span>
                            <span>| </span> Laundry Facilities  
                        </span> 
                        <span>
                            <span>| </span> Washing Line 
                        </span> 
                        <span>
                            <span>| </span> <span class="fas fa-parking"></span> Free Parking</
                            span> 
                    </div>
                </div>
                <div class="about_us">
                    <h5>About us </h5>
                    <p>
                        This accommodation is new in Johannesburg, but it has been doing the most in most of the Pretoria area hence we thought it is best we bring the joy to home of everyone which is Jozi baby, hope to see you soon for reviews   
                    </p>
                </div>
                <div class="manager">
                    <h5>Hosted by</h5>
                    <div class="info">
                        <div class="image">
                            <a href="#" target="_blank">
                                <img src="./images/users/123/img1.jpg" alt="Clement" style="width: 100%; height: 100%">
                            </a>
                        </div>
                        <div class="personal">
                            <p class="name"><strong>Clementine</strong></p>
                            <p class="joined">Joined in May, 2021</p>
                            <p><span class="fas fa-shield-virus" style="color: red"></span> Account Verified</p>
                        </div>
                    </div>
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