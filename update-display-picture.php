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
                if(isset($_SESSION['s_id']) && isset($_SESSION['s_profile_status'])){
                    if($_SESSION['s_profile_status'] != "1"){
/*                        echo "<br><br><br>";
                        require_once './access_denied.html';
                        return;
  */                  }
                }else{
                    echo "<br><br><br>";
                    require_once './offline.html';
                    return;
                }
                $success_msg = $err_img = "";
                require("includes/conn.inc.php");
                $db_login = new DB_login_updates();
                $connection = $db_login->connect_db("obo_users");
                $user_id = $_SESSION['s_id'];

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
                        $dir = "images/users/" . substr($user_id, 5, 15) . "/";
                        if(is_dir($dir) === false) mkdir($dir);
                        
                        $image_name = $image = $new_name = rand_text(rand(0, 120), 10) . date('His') . "." . $ext;
                        $new_name = $dir . $new_name;
            //			$new_name = mysqli_real_escape_string($connection, $new_name); 
                        $update_table = $sql_type = "";
                        if ($_SESSION["s_dp"] != ""){
                            $update_table = "UPDATE display_picture 
                                            SET image = \"$image\" 
                                            WHERE user_id =  \"$user_id\"";
                            
                            $filename = "./images/users/" . substr($user_id, 5, 15) . "/" . $image;
                            if(unlink($filename)){
                                //do nothing, all is good
                            }
                        } else {
                            $_SESSION["s_dp"] = $image;
                            $sql_type = "new";
                            $image_id = rand_text(rand(0, 120), 10);
                            $update_table = "INSERT INTO display_picture (dp_id, user_id, image) 
                                            VALUES(\"$image_id\", \"$user_id\", \"$image_name\")";
                        }
                        if ($connection->query($update_table) === TRUE){
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
                
	if(isset($_SESSION['s_dp']) && preg_match('/^[a-zA-Z0-9]+\.+(jpg|jpeg|png|gif)*$/', $_SESSION['s_dp'])){
		?>
		<div id="image" >
			<?php echo '<br><br><br><img src="images/users/' . substr($user_id, 5, 15) . '/' . $_SESSION['s_dp'] . '"  alt="image" 
						style="width:450px; height:250px">'; ?>
		</div>
		<?php
		echo'<form style="padding:3%; padding-bottom:0%;" action="update-display-picture.php" 
					method="post" enctype="multipart/form-data">
				<label>Select  Image</label><br>
			    <input type="file" name="fileToUpload" id="fileToUpload" style="width:220px; size:7px; margin-bottom:1%;"><br>
				<input type="submit" value="Upload Image">
			</form>
		</body>
		</html>';
		return;
	}else{
		echo
		'<form style="padding:3%; padding-bottom:0%;" 
			action="update-display-picture.php"
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
        //$_SESSION['prevent_reload'] = "yes";        
        $payload = $image_no = $src = $image = "";
		$connection->close();
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
