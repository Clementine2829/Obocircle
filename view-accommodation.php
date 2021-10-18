    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

	<link rel="stylesheet" type="text/css" href="./css/style-accommodation-overview.css">
	<link rel="stylesheet" type="text/css" href="./css/style-accommodation-about.css">

	<link rel="stylesheet" type="text/css" href="./css/style-apply-accommodation.css">
    <!--heading-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="header_btns" class="sticky-top">
                <span class="header_btns">
                    <a href="#">Overview</a> |
                    <a href="#">Gallery</a> |
                    <a href="#">Direction</a> |
                    <a href="#">About</a> |
                    <a href="#">Reviews</a>
                </span>
                <span class="header_btns">
                    <button onclick="window.location='./featured.php'">Accommodations listing</button>
                </span>
           </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <?php
        $accommodation = (isset($_REQUEST['accommodation']) && $_REQUEST['accommodation'] != "") ? $_REQUEST['accommodation'] : "";
    ?>
    <input type="hidden" id="accommodation" value="<?php echo $accommodation; ?>">
    <!--displayer-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="display_accommodation">
            </div>
        </div>
        <div class="col-sm-1"></div>    
    </div>  

    <script type="text/javascript">
        
        function faq(){
            $("#reviews .faq")
        }
    
/*        
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div>
                Markers are placed at each waypoint along the route. Click on a marker to display the directions associated with that waypoint.
            </div>
            <div id="view_direction">
            </div>
        </div>
        <div class="col-sm-1"></div>    
    </div>

        function initMap() {
          const markerArray = [];
          // Instantiate a directions service.
          const directionsService = new google.maps.DirectionsService();
          // Create a map and center it on Manhattan.
          const map = new google.maps.Map(document.getElementById("view_direction"), {
            zoom: 13,
            center: {lat: -26.199070, lng: 28.058319},
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
        }*/
    </script>

    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="btn_apply">
                <br>
                <button onclick="load_apply_form()">Apply</button>
                <button id="visit" onclick="visit_site('S5NQ1JudWlOQLHQupsC6wu18RyLYcj53huEl2ZWO');">
                    <span class="fas fa-forward"></span> Visit site
                </button>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>

    <!--template displayer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="display_template"></div>
        </div>
    </div>

    <!--footer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="the_footer"></div>
        </div>
    </div>
    <!--end footer-->   
    <!--script-->
	<script src="./js/validate_email.js" type="text/javascript"></script>
	<script src="./js/footer.js" type="text/javascript"></script>
	<script src="./js/view-accommodation_main.js" type="text/javascript"></script>
	<script src="./js/view-accommodation_ext.js" type="text/javascript"></script>
    <script type="text/javascript">
        
        function visit_site(url){
            let con = confirm("You are now leaving our website and you visiting a third party website," + 
                                " Our T&Cs and Policies does not apply there."+
                                "\nSo we encourage you to read and understand that third-party website's T&Cs and Policies"+
                                "\nWe also encourage you to use our website to apply for any of the accommodations, " + 
                                " including this one.\nFor more details, please see our Terms of use at the bottom of the page\n" +
                                "Otherwise confirm to continue to visit the third-party website");
            if(con == true) window.location = './redirect-site.php?content_id=' + url;
        }
        function load_apply_form(url){
            load_template();
            url = './server/apply-accommodation.php?accommodation=' + url;
            let loc = "display_template";
            send_data(url, displayer, loc);
        }
        function load_template(){
            $("#apply_container").css({"display": "block"})
        }
        function close_apply(){
            $("#apply_container").css({"display": "none"})
        }
        
    </script>

</body>      
</html>