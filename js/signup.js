
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('#send_data').click(function(){
		let f_name = get_f_name();
		let m_name = get_m_name();
		let l_name = get_l_name();
		let gender = get_gender();
		let birthdate = get_birthdate();
		let email = get_email();
		let p1 = get_password();
		let p2 = get_password2();
		let phone = get_phone();
		let ref_code = get_ref();
		if(ref_code == 2){
			let r = confirm("The ref CODE is invalid.\nPlease if you cannot rememeber it, leave the field blank/empty\nDo you want  to leave it blank?");

			if(r){
				$("#ref_code").val("");
			}
		}
		if(f_name == "" || l_name == "" || gender == "" || birthdate == "" || 
			email == "" || p1 == "" || p2 == "" || phone == "" || ref_code == 2) return;
		if($('.sub_container:last-child span :checkbox').prop("checked") ==  false){
			$('.agree').css({'color':'red'})
			return;
		}else $('.agree').css({'color':'black'})

		$('#signup_form').submit();
	});
});

function get_f_name(){
	let name = "First name";
	let txt = $('#f_name');
	let err_msg = $('#err_f_name')
	let pattern = /^[a-zA-Z]+$/;
	txt = validate_text(name, txt, err_msg, pattern);
	return (txt == "") ? "" : txt; 
}
function get_m_name(){
	let name = "Nickname";
	let txt = $('#m_name');
	let pattern = /^[a-zA-Z]+$/;
	let err_msg = $('#err_m_name')
	if(txt.val() != "")
		txt = validate_text(name, txt, err_msg, pattern);
	return (txt == "") ? "" : txt; 
}
function get_l_name(){
	let name = "Surname";
	let txt = $('#l_name');
	let err_msg = $('#err_l_name')
	let pattern = /^[a-zA-Z]+$/;
	txt = validate_text(name, txt, err_msg, pattern);
	return (txt == "") ? "" : txt; 
}
function get_gender(){
	if($('#m').prop("checked") || $('#f').prop("checked")) {
		$("#err_gender").html(" * ");
		return true;		
	}else {
		$("#err_gender").html(" * Select gender");
		return false;
	}
}
function get_birthdate(){
	let name = "Date of birth";
	let txt = $('#birthdate');
	let err_msg = $('#err_birthdate')
//			let pattern = /^(0[1‐9]|[12][0‐9]|3[01])+[\/‐]+(0[1‐9]|1[012])[\/-]+\d{4}+$/;
	let pattern = /^[0-9\-]*$/;
	txt = validate_text(name, txt, err_msg, pattern);
	return (txt == "") ? "" : txt; 
}
function get_email(){
	let txt = $('#email');
	let val = txt.val();
	let err_msg = $('#err_email');
	let pattern = /^[a-zA-Z0-9\.]+@+[a-zA-Z]+\.+[a-zA-Z]*$/g;
	let pattern2 = /^[a-zA-Z0-9\.]+\@+(gmail.com|icloud.com|outlook.com|yandex.mail|yahoo.com)+$/g;
	if(val == ""){
		err_msg.html("Enter Email address");
		err_box(txt);
		return "";
	}else if(!val.match(pattern) || !check_email(val)){
		err_msg.html("Invalid email address");
		err_box(txt);
		return "";
	}else if(!val.match(pattern2)){
		err_msg.html("Email type not supported");
		err_box(txt);
		return "";
	}else{
		err_msg.html(' * ');
		suc_box(txt);
		return val;
	}
}
function check_email(str){	
	var atPos = str.lastIndexOf('@');
	var dotPos = str.lastIndexOf('.');
	if((dotPos < atPos) || (atPos < 3) || ((str.length - dotPos) < 2))
		return false;
	else return true;
}
function get_password(){
	let txt = $('#password1');
	let p1 = txt.val();
	let err_msg1 = $('#err_password');
	let pattern = /^[a-zA-Z0-9\.\!\@\#\$\%\&\?\,\s]*$/;
	if(p1 == ""){
		err_msg1.html("Password is required");
		err_box(txt);
		return "";
	}else if(p1.length < 8 || p1.length > 25){
		err_msg1.html("Password too short/long");
		err_box(txt);
		return "";
	}else if(!p1.match(pattern)) {
		err_msg1.html("Invalid use of some special characters");
		err_box(txt);
		return "";
	}else {
		err_msg1.html(" * ");
		suc_box(txt);
		return p1;				
	}
}
function get_password2(){
	let txt = $('#password2');
	let p2 = txt.val();
	let err_msg1 = $('#err_password2');
	let password = $('#password1').val();
	if(password == ""){
		err_msg1.html("");
		err_box(txt);
		return "";
	}else if(password !== p2){
		err_msg1.html("Password does not match");
		err_box(txt);
		return "";
	}else {
		err_msg1.html(" * ");
		suc_box(txt);
		return p2;				
	}
}
function get_phone(){
	let name = "Phone";
	let txt = $('#cellphone1');
	let  err_msg = $('#err_cellphone1');
	let pattern = /^[0-9]*$/;
	txt = validate_text(name, txt, err_msg, pattern, 10);
	return (txt == "") ? "" : txt; 
}
function get_ref(){
	let txt = $('#ref_code').val();
	let pattern = /\d{6}/;
	if(txt != ""){
		if(txt.match(pattern)){
			$('#err_ref').html("");
		}else{
			$('#err_ref').html("Invalid code");
			txt = 2;
		}
	}
	return (txt == "") ? "" : txt; 
}

function validate_text(name, txt, err_msg, pattern, len = ""){
	let val = txt.val();
	if(val == ""){
		err_msg.html(name + " is required.");
		err_box(txt);
		return "";
	}else if(!val.match(pattern)){
		err_msg.html("Invalid use of special characters.");
		err_box(txt);
		return "";
	}else if(typeof(len) == 'number'){
		if(val.length != len){
			err_msg.html(name + " is invalid.");
			err_box(txt);
			return "";
		}else{
			err_msg.html(' * ');
			suc_box(txt);
			return val;					
		}
	}else{
		err_msg.html(' * ');
		suc_box(txt);
		return val;
	}
}
function suc_box(x){x.css({'border':'1.5px solid lightblue'})}
function err_box(x){x.css({'border':'1px solid red'})}
