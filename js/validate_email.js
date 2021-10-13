/**
*	@email text box containing email value
*	@err_email location to post the error message 
*	@errorMsg1 error message for empty email
*	@errorMsg2 error message for invalid email
*	@return validated email or false;
*/
function get_email(email, err_email, error_msg_1="", error_msg_2="", patten=""){
	if(patten=="") patten = /^[a-zA-Z0-9\.]+@+[a-zA-Z]+\.+[a-zA-Z\.]*$/;
	if(email.val() == ""){
		err_email.html(error_msg_1);
		err_email.css({"color":"red"})
		return false;
	}else if(!email.val().match(patten) || !check_email(email.val())){
		err_email.html(error_msg_2);
		err_email.css({"color":"red"})
		return false;
	}else{
		err_email.html("");
		err_email.css({"color":"lightblue"})
		return email.val();
	}
}
function check_email(str){
	var atPos = str.lastIndexOf('@');
	var dotPos = str.lastIndexOf('.');
	if((dotPos < atPos) || (atPos < 3) || ((str.length - dotPos) < 3)){
		return false;
	}else{
		return true;
	}
}