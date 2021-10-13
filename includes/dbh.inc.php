<?php
	class Dbh{
		private $servername;
		private $db_username;
		private $db_password;
		private $db_name;
		protected function connection($servername, $db_username, $db_password, $db_name){
			$this->servername = $servername;
			$this->db_username = $db_username;
			$this->db_password = $db_password;
			$this->db_name = $db_name;
			try {
				$connection = new mysqli($this->servername, $this->db_username, $this->db_password, $this->db_name);
				if ($connection->connect_error){
					echo "warning here ";
				}
			} catch (Exception $e) {
				if(mysqli_connect_error()){
					throw new Exception("<br><b style='margin:3%;'>Connection failed</b>");
					die();
				}
			} 
			if ($connection->connect_error){
				throw new Exception("<br><b style='margin:3%;'>Connection failed</b>");
				die();
			};
			return $connection;
		}
	}
?>