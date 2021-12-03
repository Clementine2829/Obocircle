function send_application(){
	let originalTable = $('#this_table').html(); 
	let full_name = get_names();
	let surname = get_surname();
	let student_no = get_student_no();
	let gender = get_gender();
	let phone = get_phone();
	let email = get_email().toLowerCase();
	let address_line_1 = get_address_line_1();
	let address_line_2 = get_address_line_2();
	let address_town = get_address_town();
	let address_code = get_address_code();
	let learning = get_learning();
	let payment_mode = get_payment_mode();
	let room_type = get_room_type();
	let communication_mode = get_communication_mode();
	let move_in = get_move_in();
	let transportation = get_transportation();
	let location = get_location();
	let agreement = get_agreement();
	let accommodation = $('#a_id').html();

//	alert(communication_mode);

	if((full_name == "" || surname == "" || student_no == "" || gender == "" || phone == "" 
		|| email == "" || address_line_1 == "" || address_town == "" 
		|| address_code == "" || learning == "" || payment_mode == "" || room_type == "" || 
		communication_mode == "" || move_in == "" || transportation == "" || 
		accommodation == "" || !agreement) ||
		((transportation == 1 || transportation == 3) && location == "")){
		$("#all_errors").css({'color':'red'});
		$("#all_errors").html("Fix error(s) encountered on the form<br>");
		return;
	} 

	let data = 'full_name=' + full_name + '&surname=' + surname + '&student_no=' + student_no + 
				'&gender=' + gender + 
				'&phone=' + phone + '&email=' + email + '&address_line_1=' + address_line_1
				+ '&address_line_2=' + address_line_2 + '&address_town=' + address_town
				+ '&address_code=' + address_code + '&learning=' + learning + '&payment_mode=' 
				+ payment_mode + '&room_type=' + room_type + '&communication_mode=' + 
				communication_mode + '&move_in=' + move_in + '&transportation=' + transportation
				 + '&location=' + location + '&accommodation=' + accommodation;

	let x = confirm("Are you sure that all the supplied information is correct");
	if(x){
		$('#send_a').attr('disabled', true);
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState > 0 || this.readyState < 4){
				$('#send_a').val("Loading...Please wait");
			}
			if (this.readyState == 4 && this.status == 200){
				$('#send_a').val("Submited");
				$('#returned_msg').html(this.responseText);
				if(this.responseText.search("successfully")){
					$('#this_table').html(originalTable);
					$('#this_table').css({'display': 'none'})
				}
			}
		}
		xhttp.open("POST", "./server/applications-for-accommodation.php?" + data, true);
		xhttp.send();
	}
}
function get_names(){
	let box = $('#firstnames');
	let err_msg = $('#err_names');
	let name = "Name";
	let pattern = /^[a-zA-Z\s\']+$/;
	box = validate_text(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_surname(){
	let box = $('#surname');
	let err_msg = $('#err_surname');
	let name = "Surname";
	let pattern = /^[a-zA-Z\s\']+$/;
	box = validate_text(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_student_no(){
	let box = $('#student_no');
	let err_msg = $('#err_student_no');
	let name = "Student no";
	let pattern = /^[a-zA-Z0-9]+$/;
	box = validate_text(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
$("#gender :radio:nth-child(1)").blur(function(){
	alert('hey');
});
function get_gender(){
	if($('#gender :radio:nth-child(1)').prop('checked') == true){
		$('#err_gender').html(' * ');
		return "F";
	}else if($('#gender :radio:nth-child(2)').prop('checked') == true){
		$('#err_gender').html(' * ');
		return "M";
	}else{
		$('#err_gender').html('Select gender');
		return "";		
	}
/*	if($(this).prop('checked') == true){
		$('#gender :radio').attr('checked', false);
		$(this).attr('checked', true);
	}
	if($(this).attr('id'))
	return 'M';
*/
}
function get_phone(){
	let box = $('#phone');
	let err_msg = $('#err_get_phone');
	let name = "Phone no ";
	let pattern = /\d{10}/;
	box = validate_number(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_email(){
	let box = $('#a_email');
	let email = box.val();
	let msg = $('#err_get_email');
	let pattern = /^[a-zA-Z0-9\.]+@+[a-zA-Z]+\.+[a-zA-Z]*$/g;
	if(email == ""){
		msg.html("Email address required");
		err_box(box);
		return "";
	}else if(!email.match(pattern) || !check_email(email)){
		msg.html("Invalid email address provided");
		err_box(box);
		return "";
	}else{
		msg.html(' * ');
		suc_box(box);
		return email;
	}
}
function check_email(str){	
	var atPos = str.lastIndexOf('@');
	var dotPos = str.lastIndexOf('.');
	if((dotPos < atPos) || (atPos < 4) || ((str.length - dotPos) < 2))
		return false;
	else return true;
}
function get_address_line_1(){
	let box = $('#address_line_1');
	let err_msg = $('#err_address_line_1');
	let name = "Address line 1";
	let pattern = /^[a-zA-Z0-9\s\'\@\&\.]+$/;
	box = validate_text(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_address_line_2(){
	let box = $('#address_line_2');
	let err_msg = $('#err_address_line_2');
	let name = "Address line 2";
	let pattern = /^[a-zA-Z0-9\s\'\@\&\.]+$/;
	box = validate_text_empty(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_address_town(){
	let box = $('#address_town');
	let err_msg = $('#err_address_town');
	let name = "Town/City";
	let pattern = /^[a-zA-Z0-9\s\'\@\&\.]+$/;
	box = validate_text(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_address_code(){
	let box = $('#address_code');
	let err_msg = $('#err_address_code');
	let name = "Address code";
	let pattern = /\d{4}/;
	box = validate_number(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_learning(){
	let box = $('#learning_institution');
	let err_msg = $('#err_institution');
	let name = "learning institution";
	let pattern = /^[a-zA-Z\s\']+$/;
	box = validate_text(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_payment_mode(){
	let box = $('#payment_mode');
	let err_msg = $('#err_payment');
	let name = "Payment method";
	let pattern = /^[1234]+$/;
	box = validate_select(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_room_type(){
	let box = $('#preffered_room');
	let err_msg = $('#err_room_type');
	let name = "Field";
	let pattern = /^[1234]+$/;
	box = validate_select(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
$(document).ready(function(){
});
function get_communication_mode(){
	if($('#communication :radio:nth-child(1)').prop('checked')){
		$('#communication :radio:nth-child(1)').attr('checked', true);
		$('#preffered_communication').html(' * ');
		return $('#communication :radio:nth-child(1)').val();
	}else if($('#communication :radio:nth-child(2)').prop('checked')){
		$('#communication :radio:nth-child(2)').attr('checked', true);
		$('#preffered_communication').html(' * ');
		return $('#communication :radio:nth-child(2)').val();
	}else{
		$('#communication :radio:nth-child(1)').attr('checked', false);
		$('#communication :radio:nth-child(2)').attr('checked', false);
		$('#preffered_communication').html(' Select mode of communication');
		return "";
	};
};
function get_move_in(){
	let box = $('#move_in');
	let err_msg = $('#err_move_in');
	let name = "Field";
	let pattern = /^[0-9\-]*$/;
	box = validate_select(box, err_msg, name, pattern);
	return (box != "") ? box : ""; 
}
function get_transportation(){
	let box = $('#transportation');
	let err_msg = $('#err_transportation');
	let name = "Field";
	let pattern = /^[123]+$/;
	box = validate_select(box, err_msg, name, pattern);
	if(box != ""){
		if(box == 1 || box == 3){
			$('#transport_notice').css({
				'display':'inline', 
				'padding': '0px 5px 5px 5px', 
				'margin': '4% auto 3% auto', 
				'border-radius': '7px'
			});
			$("#my_location").css({'display':'inherit'});
		}else{
			$('#transport_notice').css({'display':'none'});
			$("#my_location").css({'display':'none'});
			$("#my_location input").val("");
			$("#my_location input").attr('checked', false);
			$("#err_my_loc").html("");
		} 
		return box;
	}else{
		$('#transport_notice').css({'display':'none'});
		$("#my_location").css({'display':'none'});
		return "";
	} 
}
function get_location(){
	let loc = "";
	let err_msg = $('#err_my_loc');
	let box = $('#my_location :text');
	if($('#my_location :checkbox').prop('checked')){
		let err = "Location denied\nPlease click on the key lock next to the URL bar to allow " + 
		"this site to use your location for this function";
		loc = get_geoloc(err);
		$('#my_location :text').val('');
		err_msg.html("");
		suc_box(box);
	}else{
		loc = box.val();
		$('#my_location :checkbox').attr('checked', false);
		if(loc == ""){
			err_msg.html("Location is required");
			err_box(box);
			loc = "";
		}else if(!loc.match(/^[a-zA-Z0-9\,\@\'\s]*$/)){
			err_msg.html("Invalid use of special characters on location");
			err_box(box);			
			loc = "";
		}else{
			err_msg.html("");
			suc_box(box);
		}
	}
	return loc;
}
function get_agreement(){
	if($('#agreement :checkbox').prop('checked') == false){
		$("#err_agreement").css({'color':'red'});
		return false;
	}else{
		$("#err_agreement").css({'color':'black'});
		return true;
	}
}
function validate_text(box, err_msg, name, pattern){
	let txt = box.val();
	if(txt == ""){
		err_msg.html(name + " is required");
		err_box(box);
		return "";
	}else if(!txt.match(pattern)){
		err_msg.html("Invalid use of special characters");
		err_box(box);
		return "";
	}else{
		err_msg.html(" * ");
		suc_box(box);
		return txt;
	}
}
function validate_text_empty(box, err_msg, name, pattern){
	return (box.val() != "") ? box = validate_text(box, err_msg, name, pattern) : box = "";
}
function validate_number(box, err_msg, name, pattern, len){
	let txt = box.val();
	if(txt == ""){
		err_msg.html(name + " is required");
		err_box(box);
		return "";
	}else if(!txt.match(pattern)){
		err_msg.html(name + " is invalid");
		err_box(box);
		return "";
	}else{
		err_msg.html(" * ");
		suc_box(box);
		return txt;
	}
}
function validate_number_empty(box, err_msg, name, pattern, len){
	return (box.val() != "") ? box = validate_number(box, err_msg, name, pattern, len) : box = "";
} 

function validate_select(box, err_msg, name, pattern){
	let txt = box.val();
	if(txt.match(pattern)){
		err_msg.html(" * ");
		suc_box(box);
		return txt;
	}else{
		err_msg.html(name + " is invalid");
		err_box(box);
		return "";
	}
}
function err_box(x){x.css({'border':'1px solid red'})}
function suc_box(x){x.css({'border':'2px solid lightblue'})}