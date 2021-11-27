<?php
	require("conn.inc.php");
	class User extends Dbh {
		private $name;
		private $pass;
		function __construct($name, $pass){
			$this->name = $name;
			$this->pass = $pass;
		}
		public function get_user(){
			return ($this->validate_inputs());
		}
		public function validate_user_password($user_id, $password){
			$sql = "SELECT password   
					FROM users  where id = \"$user_id\" limit 1";
			$sql_results = new SQL_results();
			$result = $sql_results->results_profile($sql);
			$hashed = "";
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$hashed = $row['password'];
			}
//			echo "Hash: " . $hashed;
//			echo "<br>pass: " . password_hash($password, PASSWORD_DEFAULT);
//			echo "<br>Matchde" . (password_verify($password, $hashed) ? "yes" : "nop");
			return (password_verify($password, $hashed));
		}
		private final function validate_inputs(){
			$pattern = '/^[a-zA-Z0-9\.]+\@+(gmail.com|icloud.com|outlook.com|yandex.mail|yahoo.com)+$/';
			if(!preg_match($pattern, $this->name)) return false;
			$sql = "SELECT users.id, users.password, users.email, users.first_name, 
                            users_extended.user_type, users_extended.profile_status   
					FROM (users
                        INNER JOIN users_extended ON users.id = users_extended.user_id)
                    where users.email = \"$this->name\" limit 1";
            
			$sql_results = new SQL_results();
			$result = $sql_results->results_profile($sql);
			if ($result->num_rows == 1) {
				while ($row = $result->fetch_assoc()) {
					$hashed = $row['password'];
					//echo (password_verify($this->pass, $hashed) ? "True":"false") . " string " . $this->pass . " " . $hashed;
					if(password_verify($this->pass, $hashed) && $this->name == $row["email"]){
						if(preg_match('/^[a-zA-Z0-9]+$/', $row["id"]) && 
							preg_match('/^[a-zA-Z0-9\s]+$/', $row["first_name"]) && 
							preg_match('/^[a-zA-Z\_]+$/', $row["user_type"]) && 
							preg_match('/\d{1,1}/', $row["profile_status"])){
								$_SESSION["s_id"] = $row["id"];
								$_SESSION["s_first_name"] = $row["first_name"];
								$_SESSION["s_email"] = $row["email"];
                                preg_match($pattern, $row["email"]) && 
								$_SESSION["s_profile_status"] = $row['profile_status'];
								$_SESSION['s_user_type'] = $row['user_type'];
								$temp_id = $row['id'];
							$sql = "SELECT  image
									FROM display_picture
									where user_id = '$temp_id' 
									limit 1";
							$result = $sql_results->results_profile($sql);
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc())
									$_SESSION["s_dp"] = $row["image"];
							}
							return true;
						}
					}
				}
			}
			return false;			
		}
	}
?>