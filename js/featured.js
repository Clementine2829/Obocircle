    function load_main_default(url){
        get_btns();
        send_data(url, displayer, "#display_results");
    }
    function view_accommodation(accommodation){
        window.location = "view-accommodation.php?accommodation=" + accommodation;
    }

    function filter_results(action="reset"){
        /*
        let url = "single=" + single + ......
        let loc = "#display_results";
        url = (action=="reset") ? "featured.incl.php" : "featured.incl.php?" + url;

        send_data(url, displayer, loc)
        */
    }







    function validate_search(search, err_msg) {
        var patten = /^[a-zA-Z0-9\s\.\-\@\,\(\)\?\'\"]*$/;
        if(!search.match(patten)){
            return "";
            err_msg.innerHTML = "Invalid use of special characters";
        }else{
            err_msg.innerHTML = "";
            return search;
        }
    }
    function validate_patten(value) {
        var patten = /^[0-9a-zA-Z\s]*$/;
        if(!value.match(patten)){
            return "";
        }else return value;
    }
    function search_here() {
        function_type = 1; //to be used by the next & prev btns 
        let search = validate_search($('#location :text').val(), $('#err_msg'));
        let room_type = validate_patten($('#select_here').val());
        if((room_type == "select" || room_type == "") && search == ""){
            $('#err_msg').html("Please select at least location or room type. Else use the filters below");
            return;
        }else if(room_type != "select" || search != ""){
            if(search_val != search || r_type != room_type){
                page = 1; //restart the paging
            }
            let url = "search-accommo.php?search=" + search + "&room_type=" + room_type + "&next_page=" + page;
            set_url = "search" + "search=" + search + "&room_type=" + room_type; //global varriable 
            get_btns();
            send_data('display_here', url);
            $('#err_msg').html("");
            r_type = room_type;
            search_val = search;
        }
    }
    function search_filters() {
        function_type = 2; //to be used by the next & prev btns 
//			if(this.value == "select" || this.value == "none" || this.value == 0) return;
        let general_filter = $('#general_filter').val(); 
        let location = $('#locations').val();
        let ratings = $('#ratings').val();			
        if(general_filter == "select") general_filter = "";
        if(location == "none" || location == "select") location = "";
        if(ratings == "select" || ratings == 0) ratings = "";
        let data = "general_filter=" + general_filter + "&location=" + location + "&ratings=" + ratings + "&next_page=" + page;
        let url = "filter-accommo.php?" + data + "&next_page=" + page + "&w=" + get_window();
        set_url = "main"; //global varriable 
        get_btns();
        send_data("display_here", url);
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
