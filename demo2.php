<!DOCTYPE html>
<html>
  <head>
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
    center: { lat: 34.84555, lng: -111.8035 },
  });
  // Set LatLng and title text for the markers. The first marker (Boynton Pass)
  // receives the initial focus when tab is pressed. Use arrow keys to
  // move between markers; press tab again to cycle through the map controls.
  const tourStops = [
    [{ lat: 34.8791806, lng: -111.8265049 }, "Boynton Pass"],
    [{ lat: 34.8559195, lng: -111.7988186 }, "Airport Mesa"],
    [{ lat: 34.832149, lng: -111.7695277 }, "Chapel of the Holy Cross"],
    [{ lat: 34.823736, lng: -111.8001857 }, "Red Rock Crossing"],
    [{ lat: 34.800326, lng: -111.7665047 }, "Bell Rock"],
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
      label: "Afric",
      map,
      icon: image,
      title: `${i + 1}. ${title}`,
      label: `${i + 1}`,
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

