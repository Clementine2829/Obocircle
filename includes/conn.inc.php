<?php
	require("dbh.inc.php");
	define("ERR_OFFLINE", -1, false);
	define("ERR_ACC_NOT_ACTIVATED", -2, false);
	define("ERR_UNKNOWN", -3, false);
	define("GeneralUser", -4, false);
	define("PremiumUser", -5, false);
	define("AssistantManager", -6, false);
	define("Manager", -7, false);

	class DB_login extends Dbh {
		public function connect_db($servername, $db_username, $db_password, $db_name, $sql){
			try {
				return $this->connection($servername, $db_username, $db_password, $db_name)->query($sql);
			} catch (Exception $e) {
				$e->getMessage();
				die();
			}
		}
	}
	class DB_login_updates extends Dbh {
		public function connect_db($db){
			try {
				return $this->connection_db($db);			
			} catch (Exception $e) {
				$e->getMessage();
				die();
			}
		}
		private function connection_db($db){
			return $this->connection("localhost", "clementine@obocircle", "8wwmnmAjVdCbRer8", $db);
		}
	}
	class SQL_results{
		private function connection($db, $sql){
			$db_login = new DB_login();
			return $db_login->connect_db("localhost", "clementine@obocircle", "8wwmnmAjVdCbRer8", $db, $sql);
		}
		public function results_accommodations($sql){
			$db_connection = $this->connection("accommodations", $sql);
			return $db_connection;
		}
		public function results_profile($sql){
			$db_connection = $this->connection("obo_users", $sql);
			return $db_connection;
		}  
		public function results_applicaations($sql){
			$db_connection = $this->connection("applications", $sql);
			return $db_connection;
		}        
		private function check_user(){
			/*
				check if user is online else restrict access, 

				this function returns different error values, eg, error 1, 2, 3 or 4
				access denied, unauthorized access denied. 
			*/
			$user = new user_status;
			$user_state = $user->return_user_status();
			//created function that checks if a user is allowed to write or read from this database
			return $user_state;

		}
	}

	class user_status{
		public function return_user_status(){
			return $this->get_user_status();
		}
		private function get_user_status(){
			if(!isset($_SESSION['s_first_name']) || !isset($_SESSION['s_id'])){
				return ERR_OFFLINE;
			}else if(isset($_SESSION['s_profile_status']) && !$_SESSION['s_profile_status'] == 0){
				return ERR_ACC_NOT_ACTIVATED;
			}else if(isset($_SESSION['s_user_type'])){
				if($_SESSION['s_user_type'] == "general_user"){
					return GeneralUser;
				}else if($_SESSION['s_user_type'] == "premium_user"){
					return PremiumUser;
				}else if($_SESSION['s_user_type'] == "AssistantManager"){
					return AssistantManager;
				}else if($_SESSION['s_user_type'] == "Manager"){
					return Manager;
				}else{
					return ERR_UNKNOWN;
				}
			}else{	
				return ERR_UNKNOWN;
			}
		}
	}
?>