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
            <div id="featured_accommodations"></div>
        </div>
        <div class="col-sm-1"></div>
    </div>

    <!--*********** accommodations in my location ***********-->
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <div id="accommodations_heading"></div>
            <div id="accommodations_by_location"></div>
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
			<div id="review_slide" class="carousel slide" data-ride="carousel" ></div>
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
                                    <small id="polokwane">Coming soon</small>
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
                                    <small id="pretoria">Coming soon</small>
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
                                    <small id="johannesburg">Coming soon</small>
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
                                    <small id="capetown">Coming soon</small>
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
                                    <small id="durban">Coming soon</small>
                                </div>
                            </a> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
    </div>
    <?php 
        if(!isset($_SESSION['s_cookies'])){
            ?>
            <div id="sticky_agreement">
                <style type="text/css">
                    /*.sticky {
                        position: -webkit-sticky;
                        position: fixed;
                        z-index: 1;
                        bottom: 0;
                        background-color: gray;
                        padding: 14px;
                        font-size: 15px;
                        float: left;
                        width: 100%;
                    }
                    .sticky div {
                        width: 92%;
                        text-align: center;
                    }
                    #sticky_me{
                        width: 8%;
                        float: right;
                        background-color: lightblue;
                        border: 1px solid lightblue;
                        margin-left: 2%;
                        border-radius: 12px;
                    }*/
                </style>
                <div class="sticky">
                    <div>
                    This Website uses cookies, and it collect some information for Analytics. Please review our legal agreements: 
                        <a style="text-decoration:none; color:#660088" href="privacy_policy.html">Privacy Policy</a> and 
                        <a style="text-decoration:none; color:#660088" href="terms_of_use.html">Terms of Use</a> for this website
                    </div>
                    <button id="sticky_me">Ok, Got it</button>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#sticky_me").click(function(){
                            //$("#sticky_me").remove();
                            $("#sticky_agreement").remove();
                            send_data("./logout.php?cookies=true", displayer, "");
                        })
                    })
                </script>
            </div>
            <?php
        }
    ?>
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
        
        $(document).ready(function(){
            //load featured
            let url = "./server/accommodations-home-page.inc.php?action=featured";
            let loc = "#featured_accommodations";
            send_data(url, displayer, loc);
            
            //load by loactions
            url = "./server/accommodations-home-page.inc.php?action=location";
            loc = "#accommodations_by_location";
            send_data(url, displayer, loc);
            
            url = "./server/accommodations-home-page.inc.php?action=heading";
            loc = "#accommodations_heading";
            send_data(url, displayer, loc);
            
            //load testimonials
            url = "./server/testimonials.php";
            loc = "#review_slide";
            send_data(url, displayer, loc);
            
            //load accommodatoins count
            url = "./server/accommodations-home-page.inc.php?action=accommodations";
            send_data(url, accommodations_count, "");
        })
        function accommodations_count(data, loc){
            console.log(data);
            if (data != "" && data != null) {
                data = JSON.parse(data);
                if(parseInt(data.polokwane) > 0) $("#polokwane").html(data.polokwane);
                if(parseInt(data.pretoria) > 0) $("#pretoria").html(data.pretoria);
                if(parseInt(data.johannesburg) > 0) $("#johannesburg").html(data.johannesburg);
                if(parseInt(data.capetown) > 0) $("#capetown").html(data.capetown);
                if(parseInt(data.durban) > 0) $("#durban").html(data.durban);
            }
        }
    </script>
</body>      
</html>