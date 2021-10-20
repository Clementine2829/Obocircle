    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    
    <style type="text/css">
		#main_container_div{
			margin-top: 2%;
		}
		#main_container_div .main_container:nth-child(1){
			border: none;
			border-right: 2px solid gray;
			border-radius: 10px;
			padding: 4px;
			width: 20%;
			float: left;
			height: 400px;
		}
		#main_container_div .main_container:nth-child(2){
			border: none;
			padding-left: 2%;
			width: 80%;
			float: left;
			height: 400px;
			overflow: auto;
		}
		#main_container_div .main_container:nth-child(1) .btns{
			width: 100%;
			margin-bottom: 10%; 
		}
		#main_container_div .main_container:nth-child(1) .btns a{
			text-decoration: none;
		}

		#displayer{
			overflow: auto;
		}
		#displayer table tr td .span_btns{
			cursor: pointer;
		}
		#overview_displayer{
			display: none;
			position: fixed;
			z-index: 1;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			float: left;
			overflow: auto;
			background-color: rgb(0,0,0);
			background-color: rgba(0,0,0,.9);
			padding-top: 5px;
		}
		#overview_displayer_inner {
			width: 86%;
			float: left;
			background-color: white;
			padding: 1% 4%;
			margin: 1% 7% 4% 7%;
		}
		#main_job_container .container .description h4 .remote {
		font-size: 10px;
		background-color: red;
		color: white;
		border-radius: 7px;
		padding: 5px;
		}
		.close{
			color: red;
			margin-top: 2%;
			margin-right: 3%;
		}
        #footer1, 
        #footer2{display: none;}
	</style>
	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-11" id="main_container_div">
						<div>
				<span style="font-size: 15px; color: gray; float: right; padding-right: 8px" id="page_reload"></span>
				<br>
			</div>
			<div>
				<div class="main_container">
					<h4>MANAGEMENT</h4>
					<div>	
						<h5>Manage Jobs</h5>
						<ul class="btns">
							<li id="view_jobs"><a href="#">Active jobs</a></li>
							<li id="categories_jobs"><a href="#">Categories</a></li>
							<li id="applications_jobs"><a href="#">Applications</a></li>
						</ul>	
					</div>
					<div>	
						<h5>Manage People</h5>
						<ul>
							<li><a href="#" id="find_employees_management">Employee</a></li>
							<li><a href="#" id="find_employers_management">Employer</a></li>
							<li><a href="#" id="people_stats">Statistics</a></li>
						</ul>	
					</div>
					<div>	
						<h5>Manage Companies</h5>
						<ul>
							<li><a href="#" id="view_applications">Applications</a></li>
							<li><a href="#" id="reviews_feeds">Reviews & Feedback</a></li>
							<li id="#">
								<a href="#">Statistics</a>
								<span data-toggle="tooltip" data-placement="bottom" title class="fas fa-info-circle" 
												data-original-title="For statistics, please click on each company's name"></span>
							</li>
						</ul>	
					</div>										
				</div>
				<div class="main_container" id="displayer"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div id="overview_displayer">
				<span onclick="close_apply()" class="close" title="Close Modal">×</span>
				<div id="overview_displayer_inner">

				</div>
			</div>
		</div>
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