    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <?php require_once('./search_div.php'); ?>

    <!--main structure-->
	<link rel="stylesheet" type="text/css" href="./css/style-featured.css">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-11">
            <div class="sub_container">
                <div class="buttons">
                    <button id="filter_main_btn">
                        <span class="fas fa-filter"></span>Filter
                    </button>
                    <select id="sort_results">
                        <option value="">Our recommendations</option>
                        <option value="name">Name</option>
                        <option value="name">NSFAS Accredited</option>
                        <option value="name">Most Popular</option>
                        <option value="name">Best Ratings</option>
                        <option value="name">Price</option>
                        <option value="name">Recommendations</option>
                    </select>
                </div>
                <div id="filter_accommodations">
                    <div class="filter_accommodations">
                        <!--filters-->
                        <div class="filters">
                            <div id="worktype" class="sub_filter">
                                <p>
                                    <strong>Room type</strong>
                                    <span class="fas fa-angle-down"></span>
                                </p>
                                <div>
                                    <input type="checkbox" name="room_type" id="roomtype1" value="roomtype1" > 
                                    <span>Single Room</span>
                                </div>
                                <div>
                                    <input type="checkbox" name="room_type" id="roomtype2" value="roomtype2" > 
                                    <span>Double Sharing</span>
                                </div>
                                <div>
                                    <input type="checkbox" name="room_type" id="roomtype3" value="roomtype3" > 
                                    <span>Multi-Sharing</span>
                                </div>
                                <div>
                                    <input type="checkbox" name="room_type" id="roomtype3" value="roomtype3" > 
                                    <span>Any Sharing</span>
                                </div>
                            </div>
                            <div id="guest_ratings" class="sub_filter">
                                <p>
                                    <strong>Guest Ratings</strong>
                                    <span class="fas fa-angle-down"></span>
                                </p>
                                <div>
                                    <input type="radio" name="guest_ratings" id="excellent" value="excellent" > 
                                    <span>Excellent</span>
                                </div>
                                <div>
                                    <input type="radio" name="guest_ratings" id="verygood" value="verygood" > 
                                    <span>Very Good</span>
                                </div>
                                <div>
                                    <input type="radio" name="guest_ratings" id="good" value="good" > 
                                    <span>Good</span>
                                </div>
                                <div>
                                    <input type="radio" name="guest_ratings" id="fair" value="fair" > 
                                    <span>Fair</span>
                                </div>
                                <div>
                                    <input type="radio" name="guest_ratings" id="fine" value="fine" > 
                                    <span>Fine</span>
                                </div>
                            </div>	
                            <div>
                                <button id="submit_filters" onclick="filter_results()">Submit</button>
                                <button id="reset_filters" onclick="filter_results('reset')">Reset Filter</button>
                            </div>
                        </div>
                    </div>								            
                </div>
                <div id="display_results"></div>
                <div id="next_page"></div>
            </div>
            <div class="sub_container">
                <div class="accommodation_map" id="accommodation_map">
                    This is us
                </div>             
            </div>
        </div>
        <!--<div class="col-sm-1"></div>-->
    </div>
    <!--end main structure-->
    
    <!--footer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="the_footer"></div>
        </div>
    </div>
    <!--end footer-->   
    <!--script-->
	<script src="js/validate_email.js" type="text/javascript"></script>
	<script src="js/footer.js" type="text/javascript"></script>
	<script src="js/search.js" type="text/javascript"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=google_maps"></script>
    <script type="text/javascript">
		var function_type = -1;
		var page = 1;
		var r_type = "";
		var search_val = "";
		var set_url = "accommodations";
		function get_url(){
			return "./server/featured.inc.php?next_page=" + page;
		}
		function set_urls(fun){
			return "next-prev.php?file=" + fun;
/*			if(fun == "main"){
			}else if(fun == "search"){
				return "next-prev.php?file=search";
				
			}
*/		}
    </script>
	<script src="./js/next-prev.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            load_main_default();
        });
        
        function load_main_default(){
            get_btns();    
            let url = "./server/featured.inc.php?next_page=" + page;
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
        
    </script>
    <script type="text/javascript">

    	
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

</script>

</body>      
</html>