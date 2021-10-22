<?php
    /*
    require("includes/conn.inc.php");
	$db_login = new DB_login_updates();
	$connection = $db_login->connect_db("accommodation");
	$payload = $sql = "";
	$manager_id = $_SESSION['s_id'];
	if(isset($_REQUEST['payload']) && $_REQUEST['payload'] != "" &&
		preg_match('/^[a-zA-Z0-9]*$/', $_REQUEST['payload'])){
		$payload = $_REQUEST['payload'];
		$sql = "SELECT * FROM accommodation 
				WHERE id = \"$payload\" AND manager = \"$manager_id\" LIMIT 1";
	}else{
		if(isset($_SESSION['s_pac']) && $_SESSION['s_pac'] == "pro")
			$sql = "SELECT id, name FROM accommodation WHERE manager = '$manager_id' LIMIT 1";
		else if(isset($_SESSION['s_pac']) && $_SESSION['s_pac'] == "pre")
			$sql = "SELECT id, name FROM accommodation WHERE manager = '$manager_id' LIMIT 3";
		else
			$sql = "SELECT id, name FROM accommodation WHERE manager = '$manager_id' LIMIT 5";
	}
	$name = "";
	$results = $connection->query($sql);
	$my_array = array();
	$err_reason = "
		<style type='text/css'>
			#error_access{
				margin: 3% auto auto 10%;
				font-size: 18px;
				color: red;
			}
			#error_access{
				margin: 15% 8%;
				padding-top: 5%;
				font-size: 17px;
				margin-top: 5%;
				color: red;
			}
		</style>
		<p id='error_access'><b> Oops!</b> <br>It seems like no accommodation 
			linked to you at the moment. <br>
			If you posted one, reload the page else contact us at 
			<b style='color:blue;'>support@obocircle.com</b> if the error persist
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
	if ($results->num_rows > 0) {
		while ($row = $results->fetch_assoc()) {
			$new_me = array("id" => $row['id'], 
							"name" => $row['name']);
			array_push($my_array, $new_me);
			$payload = $row['id'];
			$name = $row['name'];
		}
	}else {
			echo $err_reason;
			return;
	}
	if ($results->num_rows > 1) {
		echo "<div class='selector'>
			<h4>Select accommodation to monitor</h4>";
		foreach ($my_array as $accommo_name => $value) {
		?>
			<button
			onclick="window.location='profile.php?payload=<?php echo $my_array[$accommo_name]['id']; ?>'">
				<?php echo $my_array[$accommo_name]['name']; ?>
			</button>
		<?php
		}
		echo "<style type=\"text/css\">
				#btn_back button:last-child{display: none;}
			</style>";
		echo "</div>";
		echo '
			<div id=\'the_footer\'></div>
		</div>
		<script src="jquery-3.3.1.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="subscribe.js"></script>
		<script type="text/javascript" src="footer.js"></script>
		</body>
		</html>';
		return;
	}else {
		echo "<style type=\"text/css\">
				#btn_back button:last-child{display: none;}
				.selector{display: inline;}
				@media only screen and (max-width: 800px){
					#btn_back button:last-child{display: inline;}
					.selector{display: none;}
				}
			</style>";
		?>
			<div class="selector" >
				<b>Menu:</b> 
				<button onclick='window.location="profile.php"'>Select new </button>
				<button onclick='window.location="upload-accommodation.php"'>Upload New </button>
			</div>
		<?php
	}

	if(isset($_SESSION['s_pac']) && $_SESSION['s_pac'] == "pro")
	$sql = "SELECT * FROM accommodation WHERE id = \"$payload\" AND manager = \"$manager_id\" LIMIT 1";
	else if(isset($_SESSION['s_pac']) && $_SESSION['s_pac'] == "pre")
	$sql = "SELECT * FROM accommodation WHERE id = \"$payload\" AND manager = \"$manager_id\" LIMIT 3";
	else
	$sql = "SELECT * FROM accommodation WHERE id = \"$payload\" AND manager = \"$manager_id\" LIMIT 5";
	
	$results = $connection->query($sql);
	$myArray = array();
	if ($results->num_rows > 0) {
		while ($row = $results->fetch_assoc()) {
			$new_me = array("id" => $row['id'], 
							"name" => $row['name'], 
							"address" => $row['address'],
							"room" => $row['rooms'], 
							"nsfas" => $row['nsfas'],
							"about" => $row['about_us']);
			array_push($myArray, $new_me);
			$name = $row['name'];
		}
	}else{
		echo $err_reason;
		return;
	}

	if($myArray) {
		foreach ($myArray as $accommo_name => $value) {
			$temp_id = $myArray[$accommo_name]['id'];
		echo '<span style="display:none;" id="payload">' . $temp_id . '</span>';
	?>
	<div id="btns" >
		<button onclick="window.location='profile.php?payload=<?php echo $temp_id; ?>'">Default page</button>
		<button onclick="window.location='uploads.php?payload=<?php 
				echo $temp_id . '&a_name=' . $name; ?>'">Upload Images</button>
		<button onclick="window.location='finish-up.php?payload=<?php echo $temp_id; ?>'">Finish up</button>
		<button onclick="window.location='applicants.php?payload=<?php echo $payload; ?>'"
			style="background-color: red; color: white; border: 1px solid red; border-left: 3px solid blue">
			Applicants</button>
	</div>
	<br>
		<style type="text/css">
			#show_students{
				width: 100%;
			}
			#show_students button{
				border-radius: 7px;
				background-color: rgb(60, 10, 0);
				color: orange;
				padding: 2px 15px;
			}			
			#results{
				overflow: auto;
			}
			table,
			table tr{
				border: 1px solid gray;
				border-collapse: collapse;
			}
			table tr th{
				background-color: gray;
				color: lightgray;
				border: none;
				padding: 1px 5px;
			} 
			table tr td{
				background-color: lightgray;
				border: none;
				padding: 1px 5px;
			}
			#sort_by select{
				padding: 1px 5px;
			}
			#sort_by select:active, 
			#sort_by select:focus {
				outline: none;
			}
			#action{
				margin: 1.5% auto;
			}
			#action button{
				border: none;
				padding: 3px 15px;
				border-radius: 7px;
			}
		</style>
		<div class="row">
			<div class="col-sm-1" ></div>
			<div class="col-sm-10" >
				<div>
<!--
					<br>
					<div id="sort_by">
						<b>Sort by: </b>
						<select id="sort" onchange="get_data()">
							<option value="1">Name</option>
							<option value="2">Sex</option>
							<option value="3">Institution</option>
							<option value="4">Payment Method</option>
							<option value="5">Room type</option>
						</select>
						<select id="sort_b" onchange="get_data()">
							<option value="1">Ascending</option>
							<option value="2">Descending</option>
						</select>
					</div>
-->
					<div id="results"></div>
					<div id="clement" ></div>
				</div>
			</div>
			<div class="col-sm-1" ></div>
		</div>
	<?php
		}
	}*/
	?>

    <script type="text/javascript">
		$(document).ready(function(){
			load_data();
			$("#results table tr td:nth-child(1) :checkbox").click(function(){
				alert('clicked');
//				disable_btns();
			});
		});

		function get_data(){
			let sort = $('#sort').val();
			let sort_by = $('#sort_b').val();
			load_data(sort, sort_by);	
		}
		function load_data(sort="", sort_by="", apps_type="") {
			let payload = $('#payload').html();
			let url = "applicants-inc.php?payload=" + payload + "&sort=" + sort + "&sort_by=" + sort_by + "&apps_type=" + apps_type;
			let xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState > 0 && this.readyState < 4) 
					$('#results').html("Loading...");
				if (this.readyState == 4 && this.status == 200){
					$('#results').html(this.responseText);
					select_all();
				}
			};
			xhttp.open("POST", url, true);
			xhttp.send();
		}
		function disable_check(){
			//check if all checkbox are checked then change btn value and vice versa 
			$('#action button:nth-child(2)').prop("disabled", true);			
			$('#action button:nth-child(3)').prop("disabled", true);			
			var counter = document.getElementsByClassName('s_all');
			for(let i = 0; i < counter.length; i++){
				if(document.getElementsByClassName('s_all')[i].checked){
					$('#action button:nth-child(2)').prop("disabled", false);			
					$('#action button:nth-child(3)').prop("disabled", false);								
					break;
				}
			}
			for(let i = 0; i < counter.length; i++){
				//if there is one that is not check, change btn value to check all and break
				if(!document.getElementsByClassName('s_all')[i].checked){
					$('#action button:nth-child(1)').html("Select All");
					return;
				}
			}
			$('#action button:nth-child(1)').html("Unselect All");
		}
		function select_all(){
			if($('#action button:nth-child(1)').html() != "Unselect All"){
				$('table tr td :checkbox').each(function(){
					$('table tr td :checkbox').prop('checked', true);
				})
				$('#action button:nth-child(1)').html("Unselect All");
			}else{
				$('table tr td :checkbox').each(function(){
					$('table tr td :checkbox').prop('checked', false);
				})
				$('#action button:nth-child(1)').html("Select All");				
			}
		}
		function accept_application(){
//			alert("Page still under construction"); return;
//			alert('An email has been sent to all those applicants their applications were successful');
			//get all the ids of people selected and send them through
			
			var counter = document.getElementsByClassName('s_all');
			let apps = "";
			for(let i = 0; i < counter.length; i++){
				if(document.getElementsByClassName('s_all')[i].checked){
					apps += document.getElementsByClassName('_applicants')[i].value + ",";
				}
			}
			if(apps){
				let payload = $('#payload').html();
				let url = "./accepted-applications.php?payload=" + payload + "&data=" + apps.substr(0, apps.length - 1);
				let xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function() {
					if (this.readyState > 0 && this.readyState < 4) {
						$('#action button:nth-child(2)').html("Loading..")
						$('#action button').prop('disabled', true);
					}
					if (this.readyState == 4 && this.status == 200){
						$('#action button').prop('disabled', false);
						$('#action button:nth-child(2)').html("Accept");
						$('#clement').html(this.responseText);
						if(this.responseText == ""){	
/*							for(let i = 0; i < counter.length; i++){
								if(document.getElementsByClassName('s_all')[i].checked){
									document.getElementByTagName('tr')[i].style.display = "false";
								}
							}
*/							alert("Data accepted successfully.");
							$('#show_students button').html('Show new applications');
							load_data("", "", "accepted");
							//more details, either them that you send each individual emals letting them know 
							//and let them know where to find the new data of the individuas, 
							//either a new page where they will find the accepted client or send the data to their database
							//for them to work it on their own    
						}else{
							//error occured 
						}
					}
				};
				xhttp.open("POST", url, true);
				xhttp.send();				
			}
		}
		function decline_application(){
			let con = confirm("Are you sure you want to decline the applications selected?");
			if(con){
				let message = "Do you want to want to send them personalised email regarding the reasons for declining their applications?";
				message += "\nNB: An automated email will be send either way to let them know of their applications' status";
				con = confirm(message);
				let auto_mail = true;
				if(con){
					auto_mail = false;
					while(true){
						let msg = prompt("Please type your short message here", "");
						if(msg != null){
							con = confirm("Your message:\n" + msg + "\nClick Ok to continue or cancel to reenter new message");
							if(con) break;
							else message = msg;
						}else{
							message = "";
						}
					}
				}else{
					message = "";
				}
				//send data now with the message along 
				alert("Button functionality still under construction\nSorry!");
			}
		}

		function show_students(){
			//switch between showing new applications and accepted applications
			//use the same page to display the results i.e. this function load_data(sort="", sort_by="", type="new")
			//for us type agr is "accepted"
			
			if($('#show_students button').html() == 'Show accepted students'){
				load_data("", "", "accepted");
			}else{
				load_data("", "", "");
			}
		
		}

	</script>