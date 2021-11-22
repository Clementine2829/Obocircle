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
	
    if(isset($_SESSION['s_id']) && isset($_SESSION['s_user_type'])){
        if($_SESSION['s_user_type'] != "premium_user"){
            echo "<br><br><br>";
            require_once './access_denied.html';
            return;
        }
    }else{
        echo "<br><br><br>";
        require_once './offline.html';
        return;
    }
    
	require("../includes/conn.inc.php");
	$db_login = new DB_login_updates();
	$connection = $db_login->connect_db("accommodations");
	$payload = $sql = $name = "";
	$manager_id = $_SESSION['s_id'];

	if(isset($_REQUEST['payload']) && $_REQUEST['payload'] != "" &&
		preg_match('/^[a-zA-Z0-9]*$/', $_REQUEST['payload'])){
		$payload = $_REQUEST['payload'];
		$sql = "SELECT accommodation_images.accommo_id, accommodation_images.image_id, images.image 
                FROM (images
                    INNER JOIN accommodation_images ON images.image_id = accommodation_images.image_id) 
                WHERE accommo_id = \"$payload\" LIMIT 15";
	}else{
		$foot_div = "<br><br><br><br>
                            </div>
                        <div class='col-sm-1'></div>
                    </div>
                    <!--footer-->
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div id='the_footer'></div>
                        </div>
                    </div>          
                    <!--script-->
                    <script src='js/footer.js' type='text/javascript'></script>
                </body>      
                </html>";
            
                $err_link =  "<style type='text/css'>
                                #error_access{
                                    margin-left: 8%;
                                    font-size: 17px;
                                    margin-top: 6%;
                                    color: red;
                                }
                            </style>
                            <p id='error_access'><b> Oops!</b> <br>It seems like the link provided is broken or no accommodations linked 
                                to you at the moment. <br>
                                Make sure you are using the link provide on the dashboard page<br>
                                If you believe that this is an error, please contact using this email address 
                                <span style='color:blue;'>support@obocircle.com</span>
                                <br><br>
                                <span style='color:black'>
                                    Otherwise click <a href='upload-accommodation.php'>here</a> to upload new 
                                    accommodation.
                                    </span>
                            </p>" . $foot_div;
            echo $err_link;
			return;
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
    $sql = "SELECT name FROM accommodations WHERE id = \"$payload\" LIMIT 1";

    $sql_results = new SQL_results();
    $result = $sql_results->results_accommodations($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];    
    }

	?>

        <div id="form">
		<?php
			echo '<br><span style="font-size:20px"; ><b id="file_name">' . $name. '</b></span><br><br>';
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
							onclick="delete_me(\'' . $my_array[$i]['image_id'] . '\',\'' . $payload . '\',\''. $my_array[$i]['image'] 
								. '\',\'' . $i . '\')">delete</a>
						 </div>';
					$image = "";
					$i++;	
				}
			}
			if(sizeof($my_array) > 15){
				echo "<br>
					<a href='#' style='border:2px solid red; padding: 5px 10px 10px 10px; 
						background-color:red; color: white; border-radius: 10px;
						text-decoration:none'>
						You have reached max number of uploads. You can only change the 
						existing images from now on</a>";
				return;
			}
			if(sizeof($my_array) < 15){
				echo '<div style="margin-top:2%">
						<a href="change-image.php?payload=' . $payload . '&image_no=&src=' .
						$name . '&image=empty"
						style="border:2px solid green; padding: 5px 10px 10px 10px; 
						background-color:green; color: white; border-radius: 10px;" target="_blank">
						Upload new Image
						</a><br><br><br><br><br><br>
					</div>';
			}
		$connection->close();
	echo '</div>';
	?>
	<script type="text/javascript">
		function delete_me (w, x, y, z) {
			let con = confirm("Are you sure you want to delete this file?\nThis file will be deleted permanently.");
			if(con){
				if(x.match(/^[a-zA-Z0-9]+$/) && y.match(/^[a-zA-Z0-9]+\.+(jpg|jpeg|png|gif)*$/)){
					let data = "payload=" + x + "&image=" + y + "&image_no=" + w + "&file=" + $("#file_name").html();
                    $.ajax({
						type: 'POST', 
						url: './management-accommodations/delete-image.php',
						data: data, 
						success: function(response){
							if(response == "Image deleted successfully")
								document.getElementById(z).style.display = "none";
							alert(response);
						},
                        error: function(err){
                            alert("Delete failed, internal error");
                        }
					});
				}else alert("Error occured while deleting this image")
			}
		}
	</script>
