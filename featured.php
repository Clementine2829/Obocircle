    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

    <?php require_once('./search_div.php'); ?>

    <!--main structure-->
	<link rel="stylesheet" type="text/css" href="./css/style-featured.css">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
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
						<div id="sort_by" class="sub_filter">
							<p>
								<strong>Sort by</strong>
								<span class="fas fa-angle-down"></span>
							</p>
							<div>
								<input type="radio" name="sort_by" id="nsfas" value="nsfas" > 
								<span>NSFAS Accredited</span>
							</div>
							<div>
								<input type="radio" name="sort_by" id="popular" value="popular" > 
								<span>Most Popular</span>
							</div>
							<div>
								<input type="radio" name="sort_by" id="rating" value="rating" > 
								<span>Best Ratings</span>
							</div>
							<div>
								<input type="radio" name="sort_by" id="recommendations" value="recommendations" > 
								<span>Recommendations</span>
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
            <div id="display_results">
                <div class="accommodations">
                    <div class="accommodation">
                        <div class="images">
                            <!--<div id="accommodation1" class="carousel slide" data-ride="carousel" data-interval="false">//auto-slide off-->
                            <div id="accommodation1" class="carousel slide" data-ride="carousel">
                              <!-- Indicators -->
                              <ul class="carousel-indicators">
                                <li data-target="#accommodation1" data-slide-to="0" class="active"></li>
                                <li data-target="#accommodation1" data-slide-to="1"></li>
                                <li data-target="#accommodation1" data-slide-to="2"></li>
                              </ul>

                              <!-- The slideshow -->
                              <div class="carousel-inner" style="width: 100%; height: 100%;">
                                <div class="carousel-item active">
                                  <img src="./images/accommodation/African House/res1.jpg" alt="South House" width="100%" height="100%">
                                </div>
                                <div class="carousel-item">
                                  <img src="./images/accommodation/African House/res3.jpg" alt="South House" width="100%" height="100%">
                                </div>
                                <div class="carousel-item">
                                  <img src="./images/accommodation/African House/res4.jpg" alt="South House" width="100%" height="100%">
                                </div>
                              </div>

                              <!-- Left and right controls -->
                              <a class="carousel-control-prev" href="#accommodation1" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                              </a>
                              <a class="carousel-control-next" href="#accommodation1" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                              </a>
                            </div>
                        </div>
                        <div class="map">
                            <div id="google_map_div"></div>
                        </div>
                        <div class="details">
                            <h4>African House</h4>
                            <span class="stars">
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                            </span><br>
                            <p class="ratings" style="padding: 1% 3%;
                                                      margin-right: 2%;
                                                      border-radius: 10px;
                                                      background-color: blue;
                                                      text-align: center;
                                                      color: white;
                                                      display: inline;">
                                6.9 </p>
                            <small>12 Reviews</small>
                            <p class="nsfas"><span>NSFAS Accredited</span></p>
                            <p class="location"><span class="fas fa-map-marker-alt"></span> <strong>Johannesburg</strong></p>
                        </div>
                        <div class="view_deal">
                            <button onclick="view_accommodation('123')" class="view_deal_btn">
                                VIEW DEAL 
                                 <span class="fas fa-angle-right"></span>
                            </button>
                            <div>
                                <span class="fas fa-users"></span> 
                                <span> Double Sharing</span><br>
                                <span class="price">R4010.29</span>
                            </div>
                        </div>
                    </div>

                    <div class="accommodation">
                        <div class="images">
                            <div id="accommodation2" class="carousel slide" data-ride="carousel">
                              <!-- Indicators -->
                              <ul class="carousel-indicators">
                                <li data-target="#accommodation2" data-slide-to="0" class="active"></li>
                                <li data-target="#accommodation2" data-slide-to="1"></li>
                                <li data-target="#accommodation2" data-slide-to="2"></li>
                              </ul>

                              <!-- The slideshow -->
                              <div class="carousel-inner" style="width: 100%; height: 100%;">
                                <div class="carousel-item active">
                                  <img src="./images/accommodation/West Gate Residence/res1.jpg" alt="South House" width="100%" height="100%">
                                </div>
                                <div class="carousel-item">
                                  <img src="./images/accommodation/West Gate Residence/res2.jpg" alt="South House" width="100%" height="100%">
                                </div>
                                <div class="carousel-item">
                                  <img src="./images/accommodation/West Gate Residence/res6.jpg" alt="South House" width="100%" height="100%">
                                </div>
                              </div>

                              <!-- Left and right controls -->
                              <a class="carousel-control-prev" href="#accommodation2" data-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                              </a>
                              <a class="carousel-control-next" href="#accommodation2" data-slide="next">
                                <span class="carousel-control-next-icon"></span>
                              </a>
                            </div>
                        </div>
                        <div class="map">

                        </div>
                        <div class="details">
                            <h4>West gate Residence</h4>
                            <span class="stars">
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                            </span><br>
                            <p class="rating" style=" padding: 1% 3%;
                                                      border-radius: 10px;
                                                      margin-right: 2%;
                                                      background-color: lightgray;
                                                      text-align: center;
                                                      color: white;
                                                      display: inline;">
                            / </p>
                            <small> 0 Reviews</small><br>
                            <p class="nsfas"><span style="background-color: pink"><del>NSFAS Accredited</del></span></p>
                            <p class="location"><span class="fas fa-map-marker-alt"></span> <strong>Pretoria</strong></p>
                        </div>
                        <div class="view_deal">
                            <button onclick="view_accommodation('123')" class="view_deal_btn">
                                VIEW DEAL 
                                 <span class="fas fa-angle-right"></span>
                            </button>
                            <div>
                                <span class="fas fa-users"></span> 
                                <span> Double Sharing</span><br>
                                <span class="price">R3990.50</span>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
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
    <script type="text/javascript">        
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
        
        
    </script>
    <script type="text/javascript">

    	
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&callback=this_map"></script>

</body>      
</html>