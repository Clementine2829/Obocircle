$(document).ready(function(){
    let search = $("#search_keyword").val();
    load_main_default(search);
    $("#search_toggle").click(function(){
        $("#main_container").slideToggle();
    })
    $("#sort_results").change(function(){main_filter()})
    $("#google_map_btn").click(function(){
        $(".sub_container:nth-child(1)").css({"display":"none"})
        $(".sub_container:nth-child(2)").css({"display":"block"})
        $("#google_map_btn").css({"display":"none"});
        $("#list_view_btn").css({"display":"block"});
    })
    $("#list_view_btn").click(function(){
        $(".sub_container:nth-child(1)").css({"display":"block"})
        $(".sub_container:nth-child(2)").css({"display":"none"})
        $("#list_view_btn").css({"display":"none"});
        $("#google_map_btn").css({"display":"block"});
    })
});
function load_main_default(url="", search=""){
    url = "./server/featured.inc.php?next_page=" + page + "&search=" + search + url + "&resolution=" + window.innerWidth;
    //alert(url);
    get_btns();
    send_data(url, displayer, "#display_results");

    url = "./server/featured.inc.php?next_page=" + page + "&search=" + search + url + "&map=true&resolution=" + window.innerWidth;
    send_data(url, initMapDisplayer, "#accommodation_map");
}
function view_accommodation(accommodation){
    window.location = "view-accommodation.php?accommodation=" + accommodation;
}
function main_filter(){
    function_type = 1;
    let search = $("#search_keyword").val();
    let room_type = get_room_type();
    let guest_rating = get_guest_rating();
    let url = "&room_type=" + room_type + "&guest_rating=" + guest_rating + "&sort=" + $("#sort_results").val();
    load_main_default(url, search);
}
function get_room_type(){
    let room = $("#worktype div :radio");
    for(let i = 0; i < room.length; i++){
        if($(room[i]).is(":checked")){
            return ($(room[i]).val());
        }
    }
    return "";
}
function get_guest_rating(){
    let ratings = $("#guest_ratings div :radio");
    for(let i = 0; i < ratings.length; i++){
        if($(ratings[i]).is(":checked")){
            return ($(ratings[i]).val());
        }
    }    
    return 0;
}
/***********************************/

function google_maps(){
    var my_latlng = {lat: -26.199070, lng: 28.058319};

    var map = new google.maps.Map(document.getElementById('accommodation_map'), {
        zoom: 8, 
        center:my_latlng
    })

    var marker = new google.maps.Marker({
        position: my_latlng, 
        map: map,
        title: 'Truman House' 
    });
}
function initMapDisplayer(data, loc){

// Create the script tag, set the appropriate attributes
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=initMap&v=weekly';
script.async = true;

// Attach your callback function to the `window` object
window.initMap = function() {
  // JS API is loaded and available
};

// Append the 'script' element to 'head'
document.head.appendChild(script);
    //initMap();
}
// The following example creates five accessible and
// focusable markers.
function initMap() {
  const map = new google.maps.Map(document.getElementById("accommodation_map"), {
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
   
