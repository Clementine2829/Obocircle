    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    <link rel="stylesheet" type="text/css" href="./management-accommodations/css/style-dashboad.css">
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
						<h5>Accommodations</h5>
						<ul class="btns">
							<li><div onclick="window.location='upload-accommodation.php'">Post New</div></li>
							<li><div onclick="new_accommodation()">Select New</div></li>
						</ul>	
					</div>
					<div>	
						<h5>More Actions</h5>
						<ul class="btns">
							<li><div id="main_page">Main page</div></li>
							<li><div id="upload_images">Upload images</div></li>
							<li><div id="add_features">Add Features</div></li>
							<li><div id="applications">Applications</div></li>
						</ul>	
					</div>
					<div>	
						<h5>Manager</h5>
						<ul class="btns">
                            <!--user their ref number to find them--> 
							<li><div id="add_new_manager">Add new manager</div></li>
						</ul>	
					</div>										
					<div>	
						<h5>Statistics</h5>
						<ul class="btns">
							<li><div id="stats_applications">Applications</div></li>
							<li><div id="stats_accommodation">Accommodations</div></li>
						</ul>	
					</div>										
					<div>	
						<h5>Help</h5>
						<ul class="btns">
							<li><div id="reviews_feeds">Help</div></li>
						</ul>	
					</div>										
				</div>
				<div class="main_container" style="border: 1px solid gray;border-radius: 12px; padding: 1%;" id="displayer"></div>
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
	<script src="./management-accommodations/js/dashboard.js" type="text/javascript"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

    <script type="text/javascript">

    </script>
</body>      
</html>