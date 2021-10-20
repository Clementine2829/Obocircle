    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    
    <!--main-->
    <?php require 'search_div.php'; ?>
    <link rel="stylesheet" type="text/css" href="./css/style-index-search.css">
    <link rel="stylesheet" type="text/css" href="./css/style-index.css">

    <!--end main-->
    <!--***********featured accommodations***********-->

    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="featured_accommodations_heading">
                <p><strong>FEATURED ACCOMMODATIONS</strong> <a href="featured.php" class="view_more">...VIEW MORE</a></p>
            </div>
            <div id="featured_accommodations">
                <div class="featured_accommodations">
                    <div class="accommodation">
                        <div class="image">
                            <a href="view-accommodation.php?accommodation=123" target="_blank">
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
                            <a href="view-accommodation.php?accommodation=123" target="_blank">
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
                            <a href="view-accommodation.php?accommodation=123" target="_blank">
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
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="accommodations_heading">
                <small style="float: right; font-style: italic;">
                    Enable location for better accuracy in finding accommodations
                    <span data-toggle="tooltip" data-placement="left" title class="fas fas fa-info-circle" 
                        data-original-title="Click on the lock on the URL bar to grant-access"></span>
                </small><br>
                <p><strong>ACCOMMODATIONS @ JOHANNESBURG</strong> <a href="./featured.php?location=Johannesburg" class="view_more">...VIEW MORE</a></p>
            </div>
            <div id="accommodations_by_location">
                <div class="accommodations_by_location">
                    <div class="accommodation">
                        <div class="image">
                            <a href="view-accommodation.php?accommodation=123&location=johannesburg" target="_blank">
                                <img src="./images/accommodation/African House/res1.jpg" alt="African House" style="width: 100%; height: 100%; ">
                                <div class="accommodation_name">House Africa</div>
                            </a> 
                        </div>
                    </div>
                    <div class="accommodation">
                        <div class="image">
                            <a href="view-accommodation.php?accommodation=123&location=vaal" target="_blank">
                                <img src="./images/accommodation/Lithuba residence/res1.jpg" alt="Lithuba Residence" style="width: 100%; height: 100%; ">
                                <div class="accommodation_name">Lithuba Residence</div>
                            </a> 
                        </div>
                    </div>
                    <div class="accommodation">
                        <div class="image">
                            <a href="view-accommodation.php?accommodation=123&location=pretoria" target="_blank">
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
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-5">
            <button id="post_accommodation" onclick="window.location='upload-accommodation.php'">
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
                            <a href="featured.php?&location=capetown" target="_blank">
                                <img src="./images/places/capetown.jpeg" alt="South Point" style="width: 100%; height: 100%; ">
                                <div class="city_details">
                                    <strong>Cape town</strong><br>
                                    <small>Coming soon</small>
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
	<script src="js/search.js" type="text/javascript"></script>
    <script type="text/javascript">

    </script>
</body>      
</html>