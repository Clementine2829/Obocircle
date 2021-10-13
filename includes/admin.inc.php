<?php
	class User_access {
		private $id;
		private $name;
		private $email;
		private $profile_status;
		private $user_type;

		//pass them as session variable only
		function __construct($id, $name, $email, $profile_status, $user_type){
			$this->id = $id;
			$this->name = $name;
			$this->email = $email;
			$this->profile_status = $profile_status;
			$this->user_type = $user_type;
		}

		/*
		create private function to send a link to 
		request user to enter their id and validate it in here 
		if it is wrong they get notified and access denied
		else send a login notification on to thier email, get time, location and type of device they used

		they must verify either by numbers or by that capture thing 
		*/
		public function give_access(){
			return $this->$user_type;
		}
	}

	//create this so that it vill validate in private and if access give return it by function
	//else give an error and stop 

?>