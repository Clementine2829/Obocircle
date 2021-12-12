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
// The following example creates five accessible and
// focusable markers.
function initMap() {
  const map = new google.maps.Map(document.getElementById("accommodation_map"), {
    zoom: 14,
    center: { lat: -26.202493, lng: 28.043779 },
  });
  // Set LatLng and title text for the markers. The first marker (Boynton Pass)
  // receives the initial focus when tab is pressed. Use arrow keys to
  // move between markers; press tab again to cycle through the map controls.
  const tourStops = [
    [{ lat: -26.199070, lng: 28.058319 }, "Boynton Pass"],
    [{ lat: -26.198563, lng: 28.049817 }, "Airport Mesa"],
    [{ lat: -26.196301, lng: 28.048787 }, "Chapel of the Holy Cross"],
    [{ lat: -26.200580, lng: 28.057721 }, "Red Rock Crossing"],
    [{ lat: -26.201778, lng: 28.032548 }, "Bell Rock"],
  ]
  // Create an info window to share between markers.
  const infoWindow = new google.maps.InfoWindow();

  // Create the markers.
  tourStops.forEach(([position, title], i) => {
    const marker = new google.maps.Marker({
      position,
      map,
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
