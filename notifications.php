<?php 
require("header.php"); 
$_SESSION['redir'] = "notifications.php";
?>
	<div class="row">
		<div class="col-sm-12" ></div>
	</div>

	<div class="row">
		<div class="col-sm-1"></div>
		<div class="col-sm-10">
			<?php
				if(!isset($_SESSION['s_id'])){
					?>
					<div style="margin: 6% auto">
						<h5 style="color: red">You must be logged in to access this page</h5>
						<p>
							Click <a href="login.php">here</a> to login.
						</p>
					</div>				
				</div>
			<div class="col-sm-1"></div>
		</div>

		<!-- footer-->
		<div class="row">
			<div class="col-sm-12">
				<div id="the_footer"></div>
			</div>
		</div>

		<script src="js/validate_email.js" type="text/javascript"></script>
		<script src="js/footer.js" type="text/javascript"></script>

	</body>
	</html>
				<?php
					return;
				}
			?>
			<style type="text/css">
				#notifications_holder{
					margin-top: 7%;
				}
				#notifications_holder table,
				#notifications_holder table tr{
					border-collapse: collapse;
					width: 90%;

				}
				#notifications_holder table tr th{					
					background-color: gray;
				}
				#notifications_holder table tr td{					
					/*border-bottom: 1px solid #1b9ce3;*/
					background-color: lightgray;
				}
				#notifications_holder table tr td:hover{					
					background-color: rgb(225, 225, 225);
				}
				#notifications_holder col:nth-child(1){
					width: 3%;
				}
				#notifications_holder col:nth-child(2){
					width: 70%;
				}
				#notifications_holder col:nth-child(3){
					width: auto;
				}
				#notifications_holder col:nth-child(4){
					width: auto;
				}
				#notifications_holder tr th,
				#notifications_holder tr td{
					padding: 5px 1%;
				}
				#notifications_holder tr td button {
					color: red;
					outline: none;
					border: none;
					background-color: lightgray;
				}
                #footer1 .subscribe_footer {
                    padding-top: 5%;
                    border-top: none;
                }
                @media only screen and (max-width: 800px){
                    #notifications_holder {
                        margin: 1%;
                        margin-top: 7%;
                    }
                    #notifications_holder table{
                        width: 100%;
                    }
                }
			</style>
			<div id="notifications_holder">
				<table>
					<colgroup>
						<col span="1">
						<col span="1">
						<col span="1">
						<col span="1">
					</colgroup>
					<tbody>
						<?php
						$user_id = $_SESSION['s_id'];
						$sql = "SELECT * 
								FROM notifications
								WHERE user_id = \"$user_id\" AND n_status = \"0\"
								LIMIT 50";
						require("./includes/conn.inc.php");
						$sql_results = new SQL_results();
						$results = $sql_results->results_profile($sql);
						$counter = 0;
						if($results->num_rows > 0){
							echo '<tr>
									<th>#</th>
									<th>Message</th>
									<th>Date</th>
									<th>Action</th>
								  </tr>';
							while ($row = $results->fetch_assoc()) {
								$counter++;
								?>
									<tr>
										<td>
											<?php echo $counter; ?>
										</td>
										<td>
											<?php 
												if($row['n_action'] == 3){
													echo '<span><a href="view_employer.php?user=' . $row['n_message'] . '">This person</a> has requested to become an employer</span>';
												}else{
													echo $row['n_message']; 
												}
											?>
										</td>
										<td>
											<?php echo $row['n_date']; ?>
										</td>
										<td>
											<button onclick="delete_message('<?php echo $row['notification_id']; ?>')"><span class="fas fa-trash"></span></button>
										</td>
									</tr>
								<?php
							}
						}else echo "<div style='color: red'><h5>You have zero notifications at the moment..</h5><p>Please check again later</p></div>
									<span>Use the options below to continue browsing</span>
									<ul>
										<li><a href='index.php'>Home page</a>
										<li><a href='featured.php'>Accommodations</a>
										<li><a href='view-profile.php'>View my profile</a>
									</ul>";
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-1"></div>
	</div>

	<!-- footer-->
	<div class="row">
		<div class="col-sm-12">
			<div id="the_footer"></div>
		</div>
	</div>

	<script src="js/validate_email.js" type="text/javascript"></script>
	<script src="js/footer.js" type="text/javascript"></script>
	<script type="text/javascript">
		function delete_message(message){
			let con = confirm("Are you sure you want to delete this message?");
			if(con == true){
				let url = "./server/notifications.inc.php?action=delete&message=" + message;
				send_data(url, delete_message_helper);
			}
		}
		function delete_message_helper(data, loc){
			if(data == "Message deleted successfully"){
				window.location.reload();
			}
			alert(data);
		}

	</script>

</body>
</html>