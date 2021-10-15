    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    
    <!--main-->
	<link rel="stylesheet" type="text/css" href="./css/style-index-search.css">
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="main_container">
                <h3>Accommodations all over South Africa. All in one place.</h3>
                <form action="search.php" method="get" id="search_form">
                    <label>I am looking for accommodation at: </label><br>
                    <span id="search_error" class="err"></span>
                    <br>
                    <div class="search_keyword">
                        <span class="fas fa-map-marker-alt"></span>
                        <input type="text" id="search_keyword" name="search" placeholder="E.g. Johannesburg" >
                    </div>
                    <div class="user">
                        <span class="fas fa-user"></span>
                        <select id="sharing" name="sharing">
                            <option value="any" selected>Any Sharing</option>
                            <option value="double">Double Sharing</option>
                            <option value="single">Single Sharing</option>
                            <option value="multi">Multi-Sharing</option>
                        </select>
                    </div>
                    <div class="search">
                        <button type="button" onclick="search_function()">
                            <span class="fas fa-search"></span>
                            SEARCH
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <!--end main-->
    <!--***********featured accommodations***********-->
    <style rel="sytlesheet" type="text/css">        
        #featured_accommodations_heading{
            margin-top: 8%;
        }
        #featured_accommodations_heading p{
            border-bottom: 2px solid lightblue;            
        }
        #featured_accommodations_heading p a{
            float: right;
            text-decoration: none;
        }
        #featured_accommodations .featured_accommodations{
            width: 100%;
            height: 250px;
            float: left;
            margin-bottom: 1%;            
        }
        #featured_accommodations .featured_accommodations .accommodation{
            width: 20%;
            height: 100%;
            padding: 3px;
            float: left;            
        }
        #featured_accommodations .featured_accommodations .accommodation .image{ 
            width: 100%;
            height: 74%;            
        }
        #featured_accommodations .featured_accommodations .accommodation .image img{ 
            border-radius: 8px;
        }
        #featured_accommodations .featured_accommodations .accommodation_detaails .checked {
            color: orange;
        }
    </style>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="featured_accommodations_heading">
                <p><strong>FEATURED ACCOMMODATIONS</strong> <a href="#" class="view_more">...VIEW MORE</a></p>
            </div>
            <div id="featured_accommodations">
                <div class="featured_accommodations">
                    <div class="accommodation">
                        <div class="image">
                            <a href="featured.php?accommodation=123" target="_blank">
                                <img src="./images/accommodation/African House/res1.jpg" alt="African House" style="width: 100%; height: 100%; ">
                            </a> 
                        </div>
                        <div class="accommodation_detaails">
                            <a class="accommodation_name">Africa House</a><br>
                            <p>
                                Johannesburg<br>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star"></span>
                                <span class="fas fa-star"></span>
                                <small>7 reviews</small>
                            </p>
                        </div>
                    </div>
                    <div class="accommodation">
                        <div class="image">
                            <a href="featured.php?accommodation=123" target="_blank">
                                <img src="./images/accommodation/Lithuba residence/res1.jpg" alt="African House" style="width: 100%; height: 100%; ">
                            </a> 
                        </div>
                        <div class="accommodation_detaails">
                            <a class="accommodation_name">Lithuba residence</a><br>
                            <p>
                                Johannesburg<br>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star"></span>
                                <small>10 reviews</small>
                            </p>
                        </div>
                    </div>
                    <div class="accommodation">
                        <div class="image">
                            <a href="featured.php?accommodation=123" target="_blank">
                                <img src="./images/accommodation/South Point/res1.jpg" alt="African House" style="width: 100%; height: 100%; ">
                            </a> 
                        </div>
                        <div class="accommodation_detaails">
                            <a class="accommodation_name">South Point</a><br>
                            <p>
                                Johannesburg<br>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <span class="fas fa-star checked"></span>
                                <small>22 reviews</small>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>

    <!--*********** accommodations in my location ***********-->
    <style rel="sytlesheet" type="text/css">        
        #accommodations_heading{
            margin-top: 4%;
        }
        #accommodations_heading p{
            border-bottom: 2px solid lightblue;            
        }
        #accommodations_heading p a{
            float: right;
            text-decoration: none;
        }
        #accommodations_by_location .accommodations_by_location{
            width: 100%;
            height: 250px;
            float: left;
            margin-bottom: 1%;            
        }
        #accommodations_by_location .accommodations_by_location .accommodation{
            width: 20%;
            height: 100%;
            padding: 3px;
            float: left;            
        }
        #accommodations_by_location .accommodations_by_location .accommodation .image{ 
            width: 100%;
            height: 74%;
            position: relative;
            text-align: center;
        }
        #accommodations_by_location .accommodations_by_location .accommodation .image img{ 
            border-radius: 8px;
        }
        #accommodations_by_location .accommodations_by_location .accommodation .image img:hover{ 
            -sm-transform: scale(1.05); /*IE 9*/
            -webkit-transform: scale(1.05); /*Safari3-8*/
            transform: scale(1.05);
        }
        #accommodations_by_location .accommodations_by_location .accommodation .image .accommodation_name{ 
            position: absolute;
            bottom: 7px;
            right: 10px;
            color: black;
            background-color: lightgray;
            padding: 1% 4%;
            border-radius: 12px;
        }

    </style>        

    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="accommodations_heading">
                <small style="float: right; font-style: italic;">
                    Enable location for better accuracy in finding accommodations
                    <span data-toggle="tooltip" data-placement="left" title class="fas fas fa-info-circle" 
                        data-original-title="Click on the lock on the URL bar to grant-access"></span>
                </small><br>
                <p><strong>ACCOMMODATIONS @ JOHANNESBURG</strong> <a href="#" class="view_more">...VIEW MORE</a></p>
            </div>
            <div id="accommodations_by_location">
                <div class="accommodations_by_location">
                    <div class="accommodation">
                        <div class="image">
                            <a href="featured.php?accommodation=123&location=johannesburg" target="_blank">
                                <img src="./images/accommodation/African House/res1.jpg" alt="African House" style="width: 100%; height: 100%; ">
                                <div class="accommodation_name">House Africa</div>
                            </a> 
                        </div>
                    </div>
                    <div class="accommodation">
                        <div class="image">
                            <a href="featured.php?accommodation=123&location=vaal" target="_blank">
                                <img src="./images/accommodation/Lithuba residence/res1.jpg" alt="Lithuba Residence" style="width: 100%; height: 100%; ">
                                <div class="accommodation_name">Lithuba Residence</div>
                            </a> 
                        </div>
                    </div>
                    <div class="accommodation">
                        <div class="image">
                            <a href="featured.php?accommodation=123&location=pretoria" target="_blank">
                                <img src="./images/accommodation/South Point/res1.jpg" alt="South Point" style="width: 100%; height: 100%; ">
                                <div class="accommodation_name">South Point</div>
                            </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>

    <!--*************** Reviews **********************-->

    <style rel="sytlesheet" type="text/css">        
        #post_accommodation{
            background-color: skyblue;
            padding: 3% 5%;
            border-radius: 20px;
            border: 1px solid lightblue;
        }
    
    </style>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-5">
            <button id="post_accommodation" onclick="window.location='post-accommodation.php'">
                <strong>I WANT TO POST<br>AN ACCOMMODATION</strong>
            </button>
        </div>
        <div class="col-sm-5" style="text-align:right;">
			<div id="review_slide" class="carousel slide" data-ride="carousel" >
				<div class="carousel-inner" style="border-right:4px solid lightblue; border-radius:5px; padding-right:5px;" >
					<div class="carousel-item active">
					    <p>
                            <i>Obocircle helped to find the best accommodation for my sister at Living @ Rissik, I will always be thankful.</i>
                            <br>
                            <strong><i>--Clementine @ UJ--</i></strong>
					    </p>
					</div>					
					<div class="carousel-item ">
					    <p><i>
					    	Obocircle helped to find the best accommodation for my sister at Living @ Rissik, I will always be thankful.</i>
                            <br> 
                            <strong><i>--Edison Mkhabela - Eddi's Printing--</i></strong>
					    </p>
					</div>
					<div class="carousel-item ">
					    <p><i>
					    	I never thoguht it will be this easy to find accommodations. all thanks to Obocircle. especially since i am new here at Pretoria.</i> 
                            <br>
                            <strong><i>--Eric  Hlongwayo @ GreenSite Project--</i></strong> 
					    </p>
					</div>
				</div>
			</div>
			<div>
				<a class="carousel-control-prev" href="#review_slide" data-slide="prev">
					<span class="carousel-control-prev-icon" style="color:black"></span>
				</a>
				<a class="carousel-control-next" href="#review_slide" data-slide="next">
					<span class="carousel-control-next-icon"></span>
				</a>
			</div>
		</div>
        <div class="col-sm-1"></div>
    </div>

    <!--************** accommodations in big cities ******************-->
    <style rel="sytlesheet" type="text/css">       
        #accommodations_by_cities{
            margin-top: 5%;
        }
        #accommodations_by_cities .accommodations_by_cities{
            width: 100%;
            height: auto;
            float: left;
            margin-bottom: 1%;            
        }
        #accommodations_by_cities .accommodations_by_cities .city{
            width: 33%;
            height: auto;
            padding: 3px;
            float: left;            
        }
        #accommodations_by_cities .accommodations_by_cities .city .image{ 
            width: 100%;
            height: 74%;
            position: relative;
        }
        #accommodations_by_cities .accommodations_by_cities .city .image img{ 
            border-radius: 8px;
        }
        #accommodations_by_cities .accommodations_by_cities .city .image .city_details{ 
            position: absolute;
            top: 7px;
            left: 10px;
            color: black;
            padding: 1% 4%;
        }
        #accommodations_by_cities .accommodations_by_cities .city .image .city_details small{ 
            font-size: 18px;   
        }
    </style>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="accommodations_by_cities">
                <div class="accommodations_by_cities">
                    <div class="city">
                        <div class="image">
                            <a href="featured.php?&location=polokwane" target="_blank">
                                <img src="./images/places/polokwane.jpeg" alt="South Point" style="width: 100%; height: 100%; ">
                                <div class="city_details">
                                    <strong>Polokwane</strong><br>
                                    <small>13 Properties</small>
                                </div>
                            </a> 
                        </div>
                    </div>
                    <div class="city">
                        <div class="image">
                            <a href="featured.php?&location=pretoria" target="_blank">
                                <img src="./images/places/pretoria.jpeg" alt="South Point" style="width: 100%; height: 100%; ">
                                <div class="city_details">
                                    <strong>Pretoria</strong><br>
                                    <small>2 Properties</small>
                                </div>
                            </a> 
                        </div>
                    </div>
                    <div class="city">
                        <div class="image">
                            <a href="featured.php?location=johannesburg" target="_blank">
                                <img src="./images/places/johannesburg.jpeg" alt="African House" style="width: 100%; height: 100%; ">
                                <div class="city_details">
                                    <strong>Johannesburg</strong><br>
                                    <small>22 Properties</small>
                                </div>
                            </a> 
                        </div>
                    </div>
                    <div class="city">
                        <div class="image">
                            <a href="featured.php?&location=durban" target="_blank">
                                <img src="./images/places/durban.jpeg" alt="Lithuba Residence" style="width: 100%; height: 100%; ">
                                <div class="city_details">
                                    <strong>Durban</strong><br>
                                    <small>Coming soon</small>
                                </div>
                            </a> 
                        </div>
                    </div>
                    <div class="city">
                        <div class="image">
                            <a href="featured.php?&location=capetown" target="_blank">
                                <img src="./images/places/capetown.jpeg" alt="South Point" style="width: 100%; height: 100%; ">
                                <div class="city_details">
                                    <strong>Cape town</strong><br>
                                    <small>Coming soon</small>
                                </div>
                            </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>


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
    <script type="text/javascript">
        function search_function(){
            $("#search_error").html("");
            let search = $("#search_keyword").val();
            if(search == ""){
                $("#search_error").html("Enter a keyword to search<br>");
                return;
            }else{
                window.location = "./search.php?search=" + search + "&sharing=" + $("#sharing").val();
                //$("#search_form").submit();
            }
        }
    </script>
</body>      
</html>