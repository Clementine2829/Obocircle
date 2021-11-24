<?php
	function to_text($features){
		$f1 = $features[0];
		if($f1 == '1') $f1 = "1 Person Rooms";
		else if($f1 == '2') $f1 = "/1/2/ Persons Rooms";
		else if($f1 == '3') $f1 = "/1/2/3+ Persons Rooms";
		else $f1 = 0;
		$f2 = $features[1];
		if($f2 == '1') $f2 = "Own/Inroom kitchen";
		else if($f2 == '2') $f2 = "Commune Sharing kitchen";
		else if($f2 == '3') $f2 = "Floor Sharing kitchen";
		else $f2 = 0;
		$f3 = $features[2];
		if($f3 == '1') $f3 = "Own/Inroom bathroom";
		else if($f3 == '2') $f3 = "Commune Sharing bathroom";
		else if($f3 == '3') $f3 = "Floor Sharing bathroom";
		else $f3 = 0;

		$f4 = $features[3];
		if($f4 == '1') $f4 = "Security 24/7";
		else $f4 = 0;
		$f5 = $features[4];
		if($f5 == '1') $f5 = "CCTV";
		else $f5 = 0;
		$f6 = $features[5];
		if($f6 == '1') $f6 = "Biometric Access Control";
		else $f6 = 0;
		$f7 = $features[6];
		if($f7 == '1') $f7 = "Fully Furnished";
		else $f7 = 0;
		$f8 = $features[7];
		if($f8 == '1') $f8 = "Sports fields";
		else $f8 = 0;
		$f9 = $features[8];
		if($f9 == '1') $f9 = "Recreational/ Entertainment Area";
		else $f9 = 0;

		$f10 = $features[9];
		if($f10 == '1') $f10 = "Free Uncapped WiFi";
		else if($f10 == '2') $f10 = "Uncapped WiFi";
		else $f10 = 0;
		$f11 = $features[10];
		if($f11 == '1') $f11 = "Free Transport";
		else if($f11 == '2') $f11 = "Transport";
		else $f11 = 0;
		$f12 = $features[11];
		if($f12 == '1') $f12 = "Free Computers";
		else if($f12 == '2') $f12 = "Computers";
		else $f12 = 0;
		$f13 = $features[12];
		if($f13 == '1') $f13 = "Free indoor gym";
		else if($f13 == '2') $f13 = "Free outdoor gym";
		else if($f13 == '3') $f13 = "Intdoor gym";
		else if($f13 == '4') $f13 = "Outdoor gym";
		else $f13 = 0;
		$f14 = $features[13];
		if($f14 == '1') $f14 = "Own/Inroom TV";
		else if($f14 == '2') $f14 = "Commune Sharing TV";
		else if($f14 == '3') $f14 = "Floor Sharing TV";
		else $f14 = 0;

		$f15 = $features[14];
		if($f15 == '1') $f15 = "Cinema  room";
		else $f15 = 0;
		$f16 = $features[15];
		if($f16 == '1') $f16 = "Playstation TV";
		else $f16 = 0;
		$f17 = $features[16];
		if($f17 == '1') $f17 = "Shops";
		else $f17 = 0;
		$f18 = $features[17];
		if($f18 == '1') $f18 = "Bar";
		else $f18 = 0;
		$f19 = $features[18];
		if($f19 == '1') $f19 = "Study Area";
		else $f19 = 0;
		$f20 = $features[19];
		if($f20 == '1') $f20 = "Comfortable Beds";
		else $f20 = 0;
		$f21 = $features[20];
		if($f21 == '1') $f21 = "Games Rooms";
		else $f21 = 0;
		$f22 = $features[21];
		if($f22 == '1') $f22 = "First Aid Kit provided";
		else $f22 = 0;
		$f23 = $features[22];
		if($f23 == '1') $f23 = "Handicapped friently";
		else $f23 = 0;

		$f24 = $features[23];
		if($f24 == '1') $f24 = "Free Laundry Facilities";
		else if($f24 == '2') $f24 = "Laundry Facilities";
		else $f24 = 0;

		$f25 = $features[24];
		if($f25 == '1') $f25 = "Washing Line";
		else $f25 = 0;

		$f26 = $features[25];
		if($f26 == '1') $f26 = "Free Electricity";
		else if($f26 == '2') $f26 = "Prepaid Electricity";
		else $f26 = 0;
		$f27 = $features[26];
		if($f27 == '1') $f27 = "Free Parking";
		else if($f27 == '2') $f27 = "Parking";
		else $f27 = 0;

		$f28 = $features[27];
		if($f28 == '1') $f28 = "Soccer team";
		else $f28 = 0;
		$f29 = $features[28];
		if($f29 == '1') $f29 = "Netball team";
		else $f29 = 0;
		$f30 = $features[29];
		if($f30 == '1') $f30 = "Swimming pool";
		else $f30 = 0;

		$f_array = array();
		array_push($f_array, $f1, $f2, $f3, $f4, $f5, $f6, $f7, $f8, $f9, $f10, $f11, $f12, $f13, $f14,
		$f15,$f16, $f17, $f18, $f19, $f20, $f21, $f22, $f23, $f24, $f25, $f26, $f27, $f28, $f29, $f30);
		return $f_array;
	}
?>