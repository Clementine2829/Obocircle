<?php
	function check_inputs($data){
		$data = trim($data);
		$data = stripcslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	function price_format($x){
		return number_format( sprintf( "%.2f", ($x)), 2, '.', '' );
	}

?>