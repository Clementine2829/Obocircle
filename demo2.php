<!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- JQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="js/jquery-3.4.1.js" type="text/javascript"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('[data-toggle="tooltip"]').tooltip();
		})
	</script>
	<script src="https://kit.fontawesome.com/3e0b52ccd4.js" crossorigin="anonymous"></script>      
    <title>Custom Popups</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style type="text/css">
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
#map {
  height: 100%;
}

/* Optional: Makes the sample page fill the window. */
html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}

/* The popup bubble styling. */
.popup-bubble {
  /* Position the bubble centred-above its parent. */
  position: absolute;
  top: 0;
  left: 0;
  transform: translate(-50%, -100%);
  /* Style the bubble. */
  background-color: white;
  padding: 5px;
  border-radius: 5px;
  font-family: sans-serif;
  overflow-y: auto;
  max-height: 60px;
  box-shadow: 0px 2px 10px 1px rgba(0, 0, 0, 0.5);
}

/* The parent of the bubble. A zero-height div at the top of the tip. */
.popup-bubble-anchor {
  /* Position the div a fixed distance above the tip. */
  position: absolute;
  width: 100%;
  bottom: 8px;
  left: 0;
}

/* This element draws the tip. */
.popup-bubble-anchor::after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  /* Center the tip horizontally. */
  transform: translate(-50%, 0);
  /* The tip is a https://css-tricks.com/snippets/css/css-triangle/ */
  width: 0;
  height: 0;
  /* The tip is 8px high, and 12px wide. */
  border-left: 6px solid transparent;
  border-right: 6px solid transparent;
  border-top: 8px solid white;
}

/* JavaScript will position this div at the bottom of the popup tip. */
.popup-container {
  cursor: auto;
  height: 0;
  position: absolute;
  /* The max width of the info window. */
  width: 200px;
}      
    </style>
    </head>
  <body>
      <style type="text/css">
          #map .accommodations .accommodation{
              width: 350px;
              height: 100px;
              border-radius: 12px;
          }
          #map .accommodations .accommodation .image{
              width: 36%;
              height: 100%;
              float: left;
              border-top-left-radius: 12px;
          
          }
          #map .accommodations .accommodation .details{
              width: 64%;
              float: left;
              padding: 1% 2%;
          }
          #map .accommodations .accommodation .details h4,
          #map .accommodations .accommodation .details p{
              margin-bottom: 0px;
          }
          #map .accommodations .accommodation .details .location{
            float: left;
          }
          #map .accommodations .accommodation .details .stars .checked{
              color: orange;
          }
          #map .accommodations .accommodation .details .nsfas span {
            background-color: red;
            border-radius: 7px;
            color: white;
            font-size: 15px;
            padding: 3px 3%;
            margin-top: 5px;
            width: auto;
          }
          #map .accommodations .accommodation .details .view_deal_btn{
                float: right;
                background-color: gray;
                padding: 1% 3%;
                color: white;
                border: none;
                border-radius: 7px;
                box-shadow: 2px 2px 7px 1px;
                margin-bottom: 1%;
          }
      </style>
          
    <div id="map"></div>
    <div id="content">Hello world!</div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=initMap&v=weekly"
      async
    ></script>
      <script type="text/javascript">
// The following example creates five accessible and
// focusable markers.
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 14,
    center: { lat: -26.199070, lng: 28.058319 },
  });
    let div_container = '<div class="accommodations">';
        div_container += '<div class="accommodation">';
        div_container += '<div class="image">';
        div_container += '<img src="./images/accommodation/African House/res1.jpg" alt="" style="width: 100%; height: 100%;">';
        div_container += '</div>';
        div_container += '<div class="details">';
        div_container += '<h4>African House</h4>';
        div_container += '<span class="stars">';
        div_container += '<span class="fas fa-star checked"></span>';
        div_container += '<span class="fas fa-star checked"></span>';
        div_container += '<span class="fas fa-star checked"></span>';
        div_container += '<span class="fas fa-star" ></span>';
        div_container += '<span class="fas fa-star" ></span>';
        div_container += '</span>';
        div_container += '<p class="nsfas">';
        div_container += '<span>NSFAS Accredited</span>';
        div_container += '</p>';
        div_container += '<p class="location">';
        div_container += '<span class="fas fa-map-marker-alt"></span>';
        div_container += '<strong>Johannesburg</strong>';
        div_container += '</p>';
        div_container += '<button class="view_deal_btn">';
        div_container += 'VIEW DEAL';
        div_container += '<span class="fas fa-angle-right"></span>';
        div_container += '</button>';
        div_container += '</div>  ';                
        div_container += '</div>';
        div_container += '</div>';
  // Set LatLng and title text for the markers. The first marker (Boynton Pass)
  // receives the initial focus when tab is pressed. Use arrow keys to
  // move between markers; press tab again to cycle through the map controls.
  const tourStops = [
    [{ lat: -26.199716, lng: 28.051702 }, div_container],
    [{ lat: -26.194608, lng: 28.034257 }, div_container],
    [{ lat: -26.200038, lng: 28.040672 }, div_container],
    [{ lat: -26.197651, lng: 28.041348 }, div_container],
    [{ lat: -26.192629, lng: 28.042639 }, div_container],
  ];
  // Create an info window to share between markers.
  const infoWindow = new google.maps.InfoWindow();

  const image = {
    url: "./images/google_maps_logo.png",
    size: new google.maps.Size(75, 40),
    scaledSize: new google.maps.Size(100, 100),
  };
  // Create the markers.
  tourStops.forEach(([position, title], i) => {
    const marker = new google.maps.Marker({
      position,
      label: "R2500",
      map,
      icon: image,
      title: `${title}`,
      optimized: false,
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
  </body>
</html>


<?php

//it has markers and on click they show some details next to them 
//https://developers.google.com/maps/documentation/javascript/examples/marker-accessibility 


//this shows a big box with information inside it 
///https://developers.google.com/maps/documentation/javascript/infowindows

?>

