<style type="text/css">
    #form{margin: auto auto 1% 1%;}
    .my_images{
        float: left;
        width: 33%;
        height: 250px;
    }
    .my_images img{
        width: 95%;
        height: 80%;
    }
    @media only screen and (max-width: 800px){
        .my_images{
            width: 50%;
            height: 250px;
        }
        .my_images img{
            width: 95%;
            height: 80%;
        }
    }
</style>
<?php session_start(); 
/*	if(!isset($_SESSION['s_first_name']) || !isset($_SESSION['s_id']) || 
		!isset($_SESSION['s_activated']) || !isset($_SESSION['s_pac'])){
		require 'offline.php';
		return;
	}else if(isset($_SESSION['s_activated']) && !$_SESSION['s_activated'] ){
		require 'not-activated.php';
		return;
	}else if(isset($_SESSION['s_pac'])){
		if(!isset($_SESSION['s_upload_a']) || !isset($_SESSION['s_upload_a']) || 
			!isset($_SESSION['s_upload_a']) || !isset($_SESSION['s_upload_a'])){
			$offline = "Your account seems to have had problems when logging in.";
			require 'offline.php';
			return;
		}
		if($_SESSION['s_pac'] == "bas"){
			$type = "accommodation";
			$err_reason = "You are on a Basic package account.";
			require 'account-denied.php';
			return;
		}else if($_SESSION['s_pac'] == "sta"){
			$type = "accommodation";
			$err_reason = "You are on a Standard package account.";
			require 'account-denied.php';
			return;
		}else if($_SESSION['s_pac'] == "cus"){
			if($_SESSION['s_c_upload_a'] < 0){
				$err_reason = "";
				$type = "accommodation";
				require 'account-denied.php';
				return;
			}
		}
	}else{	
		require 'unknown-error.php';
		return;
	}
	require("includes/conn.inc.php");
	$db_login = new DB_login_updates();
	$connection = $db_login->connect_db("accommodation");
	$payload = $sql = $name = "";
	$manager_id = $_SESSION['s_id'];

	if(isset($_REQUEST['payload']) && $_REQUEST['payload'] != "" &&
		preg_match('/^[a-zA-Z0-9]*$/', $_REQUEST['payload'])){
		$payload = $_REQUEST['payload'];
		$sql = "SELECT accommo_id, image_id, image FROM images WHERE accommo_id = \"$payload\" LIMIT 13";
	}else{
		echo "<style type='text/css'>
				#error_access{
					margin-left: 8%;
					font-size: 17px;
					margin-top: 5%;
					color: red;
				}
			</style>
			<p id='error_access'><b> Oops!</b> <br>It seems like no images/accommodation 
				linked to you at the moment. <br>
				If you posted one, reload the page else contact us at 
				<b style='color:blue;'>info@obocircle.com</b> if the error persist
				<br><br>
				<span style='color:black'>
					Otherwise click <a href='upload-accommodation.php'>here</a> to upload new 
					accommodation.
					</span>
			</p>	
			<div id='the_footer'></div>
			<script type=\"text/javascript\" src=\"footer.js\"></script>
			</body>
			</html>";
			return;
	}

	if(isset($_REQUEST['a_name']) && $_REQUEST['a_name'] != "" &&
		preg_match('/^[a-zA-Z0-9\'\,\@\s]*$/', $_REQUEST['a_name']))
		$name = $_REQUEST['a_name'];
	else{
		$sql_name = "SELECT id, name FROM accommodation 
						WHERE /*display = 1 AND*//* id = \"$payload\" ORDER BY name LIMIT 5";
		$results = $connection->query($sql_name);
		if ($results->num_rows > 1) {
			while ($row = $results->fetch_assoc())
				if(preg_match('/^[a-zA-Z0-9]*$/', $row['id']) && 
					preg_match('/^[a-zA-Z0-9\,\.\@\'\s]*$/', $row['name'])){
					echo "<button onclick='window.location=\"uploads.php?payload=" . 
							$payload . "&a_name=" . $row['name'] . "\"'> " . $row['name'] . "</button>";
					return;
				}

		}else if ($results->num_rows > 0) 
			while ($row = $results->fetch_assoc())
				$name = $row['name'];
	}
	$message = "";
	$results = $connection->query($sql);
	$my_array = array();
	if ($results->num_rows > 0) {
		while ($row = $results->fetch_assoc()) {
			if(preg_match('/^[a-zA-Z0-9]*$/', $row['accommo_id']) &&
				preg_match('/^[a-zA-Z0-9]+\.+(jpg|jpeg|png|gif)*$/', $row['image'])){
				$new_array = array('image' => $row['image'], 
									'id' => $row['accommo_id'], 
									'image_id' => $row['image_id']);
				array_push($my_array, $new_array);
			}
		}
	}else {
		$message =
		 "<style type='text/css'>
				#error_access{
					font-size: 17px;
					color: red;
				}
			</style>
			<p id='error_access'><b> Oops!</b> <br>It seems like you haven't uploaded any images 
				for this accommodation 	
			</p>";
	}
	?>
	<br>
	<div id="btns" >
		<button onclick="window.location='profile.php?payload=<?php echo $payload; ?>'">Default page</button>
		<button onclick="window.location='uploads.php?payload=<?php echo $payload; ?>'">Upload Images</button>
		<button onclick="window.location='finish-up.php?payload=<?php echo $payload; ?>'">Finish up</button>
		<button onclick="window.location='applicants.php?payload=<?php echo $payload; ?>'"
			style="background-color: red; color: white; border: 1px solid red; border-left: 3px solid blue">
			Applicants</button>
	</div>
	<br>
	<div id="form">
		<?php
			echo '<br><span style="font-size:20px"; ><b>' . $name. '</b></span><br><br>';
			echo $message;
			$i = 1;
			if(sizeof($my_array) > 0 && sizeof($my_array) < 14){
				foreach ($my_array  as $i => $value) {
					echo'<div class="my_images", id="' . $i . '">
							<img src="images/accommodation/' . $name . '/'
							 . $my_array[$i]['image'] . '" alt="' . $name . '">
							<br>
							<a href="change-image.php?payload=' . $payload . '&image_no=' . 
							$my_array[$i]['image_id'] . '&src=' . $name . '&image=' . 
							$my_array[$i]['image'] . '">
							Change Image</a> | 
							<a href="#" style="color: red" 
							onclick="delete_me(\'' . $payload . '\',\''. $my_array[$i]['image'] 
								. '\',\'' . $i . '\')">delete</a>
						 </div>';
					$image = "";
					$i++;	
				}
			}
			if(sizeof($my_array) > 13){
				echo "<br>
					<a href='#' style='border:2px solid red; padding: 5px 10px 10px 10px; 
						background-color:red; color: white; border-radius: 10px;
						text-decoration:none'>
						You have reached max number of uploads. You can only change the 
						existing images from now on</a>";
				return;
			}
			if(sizeof($my_array) < 13){
				echo '<div style="margin-top:2%">
						<a href="change-image.php?payload=' . $payload . '&image_no=&src=' .
						$name . '&image=empty"
						style="border:2px solid green; padding: 5px 10px 10px 10px; 
						background-color:green; color: white; border-radius: 10px;">
						Upload new Image
						</a><br><br><br><br><br><br>
					</div>';
			}
		$connection->close()
	</div>
*/	?>

<div id="form">
		<br><span style="font-size:20px"; ><b>West Gate Residence</b></span><br><br><div class="my_images", id="0">
        <img src="./images/accommodation/Lithuba residence/res1.jpg" alt="West Gate Residence">
        <br>
        <a href="./change-image.php?payload=KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w&image_no=14&src=West Gate Residence&image=GGCmU7x7ae200409011916.jpg" target="_blank">
        Change Image</a> | 
        <a href="#" style="color: red" 
        onclick="delete_me('KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w','GGCmU7x7ae200409011916.jpg','0')">delete</a>
     </div><div class="my_images", id="1">
        <img src="./images/accommodation/Lithuba residence/res2.jpg" alt="West Gate Residence">
        <br>
        <a href="./change-image.php?payload=KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w&image_no=15&src=West Gate Residence&image=5RVL1jykqZ200409012424.jpg" target="_blank">
        Change Image</a> | 
        <a href="#" style="color: red" 
        onclick="delete_me('KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w','5RVL1jykqZ200409012424.jpg','1')">delete</a>
     </div><div class="my_images", id="2">
        <img src="./images/accommodation/Lithuba residence/res3.jpg" alt="West Gate Residence">
        <br>
        <a href="./change-image.php?payload=KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w&image_no=16&src=West Gate Residence&image=k09p6pfCsf200409012438.jpg" target="_blank">
        Change Image</a> | 
        <a href="#" style="color: red" 
        onclick="delete_me('KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w','k09p6pfCsf200409012438.jpg','2')">delete</a>
     </div><div class="my_images", id="3">
        <img src="./images/accommodation/Lithuba residence/res4.jpg" alt="West Gate Residence">
        <br>
        <a href="./change-image.php?payload=KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w&image_no=63&src=West Gate Residence&image=LveqIYoI6g201023101444.jpg" target="_blank">
        Change Image</a> | 
        <a href="#" style="color: red" 
        onclick="delete_me('KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w','LveqIYoI6g201023101444.jpg','3')">delete</a>
     </div><div style="margin-top:2%">
    <a href="change-image.php?payload=KCwybFhwuD9ate6s4pqiJusaAosdGiHUxJSGb71w&image_no=&src=West Gate Residence&image=empty" 
       target="_blank" 
       style="border:2px solid green; padding: 5px 10px 10px 10px; background-color:green; color: white; border-radius: 10px;">
    Upload new Image
    </a><br><br><br><br><br><br>
					</div>	</div>
	<script type="text/javascript">
		function delete_me (x, y, z) {
			let con = confirm("Are you sure you want to delete this file?\nThis file will be deleted permanently.");
			if(con){
				if(x.match(/^[a-zA-Z0-9]+$/) && y.match(/^[a-zA-Z0-9]+\.+(jpg|jpeg|png|gif)*$/)){
					let data = "payload=" + x + "&image=" + y;
					$.ajax({
						type: 'POST', 
						url: 'delete-image.php',
						data: data, 
						success: function(response){
							if(response == "Image deleted successfully")
								document.getElementById(z).style.display = "none";
							alert(response);
						}
					});
				}else alert("Error occured while deleting this image")
			}
		}
	</script>
