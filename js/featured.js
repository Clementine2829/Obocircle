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
    alert(url);
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
function this_map(){
var my_latlng = {lat: -26.199070, lng: 28.058319};

var map = new google.maps.Map(document.getElementById('google_map_div'), {
    zoom: 8, 
    center:my_latlng
})

var marker = new google.maps.Marker({
    position: my_latlng, 
    map: map,
    title: 'Truman House' 
});
}
