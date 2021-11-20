<!--header-->
<?php require_once('./header.php'); ?>
    <style rel="stylesheet" type="text/css">



        #footer1, 
        #footer2{display: none;}
        #footer3{margin-bottom: 0px;}
        #footer4{
            margin-top: 0px;
            margin-bottom: 1%;
        }
    </style>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <?php
                function rand_text($txt, $len){
                    $txt = password_hash($txt, PASSWORD_DEFAULT);
                    $txt = substr($txt,7,$len);
                    while(!preg_match("/^[a-zA-Z0-9]*$/", $txt) || strlen($txt) < $len){
                        $txt = password_hash($txt, PASSWORD_DEFAULT);
                        $txt = substr($txt,7,$len);
                    }
                    return $txt;			
                }
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
                
                $payload = $image_no = $src = $image = "";
                $success_msg = $err_img = "";
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
                if($_SESSION['prevent_reload'] == "yes"){
                    echo $err_link;
                    return;
                }

                if(isset($_REQUEST['payload']) && $_REQUEST['payload'] != "" &&
                    preg_match('/^[a-zA-Z0-9]+$/', $_REQUEST['payload']))
                    $payload = $_REQUEST['payload'];
                else{
                    echo $err_link;
                    return;
                }
                if(isset($_REQUEST['image']))
                    if(preg_match('/^[a-zA-Z0-9]+\.+(jpg|jpeg|png|gif)*$/', $_REQUEST['image']))
                        $image = $_REQUEST['image'];
                    else $image = "";
                if(isset($_REQUEST['image_no']) && preg_match('/\d{1,3}/', $_REQUEST['image_no']))
                    $image_no = $_REQUEST['image_no'];
                if(isset($_REQUEST['src']) && $_REQUEST['src'] != "" &&
                    preg_match('/^[a-zA-Z\@\'\.\,\s]*$/', $_REQUEST['src']))
                    $src = $_REQUEST['src'];
                else {
                    echo $err_link;
                    return;
                }
            /*	else if(isset($_REQUEST['a_name']) && $_REQUEST['a_name'] != "" &&
                    preg_match('/^[a-zA-Z\@\'\.\,\s]*$/', $_REQUEST['a_name']))
                    $src = $_REQUEST['a_name'];
            */	

                require("includes/conn.inc.php");
                $db_login = new DB_login_updates();
                $connection = $db_login->connect_db("accommodationS");
                $manager_id = $_SESSION['s_id'];

                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $uploadOk = 0;
                    $allowed_exts = array("jpg", "jpeg", "png", "gif");
                    $tmp = explode(".", $_FILES["fileToUpload"]["name"]);
                    $ext = end($tmp);
                    if($_FILES["fileToUpload"]["name"] == ""){
                        $err_img = " Select image to upload.";
                        $uploadOk = 0;
                    }else if(!in_array($ext, $allowed_exts)){
                        $err_img = " Only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }else if ($_FILES["fileToUpload"]["size"] < 5000) {
                        $err_img = " Image quality is not enough.";
                        $uploadOk = 0;
                    }else if ($_FILES["fileToUpload"]["size"] > 15000000) {
                        $err_img = " Image is too large.";
                        $uploadOk = 0;
                    }else if ($_FILES["fileToUpload"]["error"] > 0){
                        $err_img = " Internal error occured while uploading your file.";
                        $uploadOk = 0;
                    }else $uploadOk = 1;

                    if($uploadOk == 1){
                        $error = "";
                        $dir = "images/accommodation/$src/";
                        if(is_dir($dir) === false) mkdir($dir);
                        
                        $image_name = $image = $new_name = rand_text(rand(0, 120), 10) . date('ymdHis') . "." . $ext;
                        $new_name = $dir . $new_name;
            //			$new_name = mysqli_real_escape_string($connection, $new_name); 

                        $update_table = $sql_type = "";
                        if ($image_no != "" && preg_match('/^[a-zA-Z0-9]+$/',$image_no)){
                            $update_table = "UPDATE images 
                                            SET Image = \"$image\" 
                                            WHERE image_id =  \"$image_no\"";
                        } else {
                            $sql_type = "new";
                            $image_id = rand_text(rand(0, 120), 15);
                            $update_table = "INSERT INTO images (image_id, image) 
                                            VALUES(\"$image_id\", \"$image_name\")";
                        }
                        if ($connection->query($update_table) === TRUE){
                            if($sql_type == "new"){
                                $update_table = "INSERT INTO accommodation_images (accommo_id, image_id) 
                                                VALUES(\"$payload\", \"$image_id\")";
                                if ($connection->query($update_table) === TRUE){
                                    //do nothing 
                                }
                            }
                            
                            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $new_name);
                            $success_msg = "<span style='color:blue'>Image has been uploaded successfully<br></span>";
                            echo '<style type="text/css">
                                        form input, form label{display: none;}
                                    </style>';
                        }else $success_msg = "<span style='color:red'>Internal error in uploading your file </span>";
                    }
                    echo "<br><br>";
                    if($uploadOk == 0) echo "<span style='color:red'><b>Error: </b>" . $err_img . "</span>";
                }
                
/*		new  image
		->playload
		->image_no = none
		->sorce = name of accommodation
		->image = empty
		*****************
		chnage
		->playload 
		->image_no = 5
		->sorce = name of accommodation
		->image = name of the image

		if image = empty and image_no = none
			upload new image
		else if image = name of the image  and image_no = \d
			change image
		else echo error

		on upload set/chnage 
		payload same 
		image_no -> find the name of the image and set its id from the latest
		source same 
		image none

		if image = empty and image_no = none
			upload new image
		else if image = none  and image_no = \d
			change image
		else echo error
*/
	if($image == "empty" || $image == "" || preg_match('/[^0-9]/', $image_no)){
		echo'<form style="padding:3%; padding-bottom:0%;" action="change-image.php?payload=' . $payload . 
					'&image_no=' . $image_no .'&src=' . $src . '" 
					method="post" enctype="multipart/form-data">
				<label>Select  Image</label><br>
			    <input type="file" name="fileToUpload" id="fileToUpload" style="width:220px; size:7px; margin-bottom:1%;"><br>
				<input type="submit" value="Upload Image">
			</form>
		</body>
		</html>' . $foot_div;
		return;
	}else if($image != "" && (preg_match('/\d{1,4}/', $image_no) || $image_no == "")){
		?>
		<div id="image" >
			<?php echo '<img src="images/accommodation/'. $src . '/' . $image .'" alt="' . $src . '" 
						style="width:450px; height:250px">'; ?>
		</div>
		<?php
		echo
		'<form style="padding:3%; padding-bottom:0%;" 
			action="change-image.php?payload=' . $payload . '&src=' . $src . '&image_no=' . $image_no .'"
			method="post" enctype="multipart/form-data">
			<label>Select  New Image</label><br>
		    <input type="file" name="fileToUpload" id="fileToUpload" 
		    	style="width:220px; size:7px; margin-bottom:1%;"><br>
			<input type="submit" value="Upload Image">
		</form>';
        if($success_msg != ""){
            echo '<div style="margin-top:0%;">' . $success_msg . '</div>';
            ?>
                <script type="text/javascript">
                    document.getElementsByTagName('form')[0].remove();
                </script>
            <?php
        }   
        $_SESSION['prevent_reload'] = "yes";        
        $payload = $image_no = $src = $image = "";
		$connection->close();
	}else{
		echo $err_link;
		return;
	}
?>
  

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
	<script src="js/footer.js" type="text/javascript"></script>
    <script type="text/javascript">
        
    </script>
</body>      
</html>
