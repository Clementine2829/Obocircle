	function s_box_err(x){
		x.css({'border-left':'3px solid red'})
	}
	function s_box_success(x){
		x.css({'border-left':'3px solid #007bff'})
	}
	function sname(){
		var name_box = $('#name');
		var err_msg = $('#name_err');
		var msg = " * Name is required";	
		var patten = /^[a-zA-Z\s\'\.]*$/;
		var name = validate_pass(name_box, err_msg, msg, 30, patten)
		if(name) return name;
		else return "";
	}
	function ssubject(){
		var name_box = $('#subject');
		var err_msg = $('#subject_err');
		var msg = " * Subject is required";	
		var patten = /^[a-zA-Z 0-9\s\'\"\?\,\.\/\\\(\)\@\+\-\*\=]*$/;
		var subject = validate_pass(name_box, err_msg, msg, 30, patten)
		if(subject) return subject;
		else return "";
	}
	function smessage(){
		var name_box = $('#message');
		var err_msg = $('#message_err');
		var msg = " * Message is required";	
		var patten = /^[a-zA-Z 0-9\s\'\"\?\,\.\/\\\(\)\@\+\-\*\=]*$/;
		var message = validate_pass(name_box, err_msg, msg, 500, patten)
		if(message) return message;
		else return "";
	}
	function validate_pass(name_box, err_msg, msg, len, patten){
		var name = name_box.val();
		if(name == ""){
			s_box_err(name_box);
			err_msg.html(msg);
			return "";
		}else if(!name.match(patten)){
			s_box_err(name_box);
			err_msg.html(" * Invalid use of special characters");
			return "";
		}else if(name.length > len){
			s_box_err(name_box);
			err_msg.html(" * Max number of charecters is " + len);
			return "";
		}else{
			err_msg.html(" * ");
			s_box_success(name_box);
			return name;
		}
	}
	function semail(){
		var email = $('#email').val();
		var patten2 = /^[a-zA-Z0-9\.]+@+[a-zA-Z]+\.+[a-zA-Z\.]*$/;
		var err_msg = $("#email_err");
		if(email == ""){
			err_msg.html(" * Email is required");
			s_box_err($('#email'))
			return "";
		}else if(!email.match(patten2)){
			err_msg.html(" * Invalid email format");
			s_box_err($('#email'))
			return "";
		}else if(!check_email(email)){
			err_msg.html(" * Email Address too small");
			s_box_err($('#email'))
			return "";
		}else{
			err_msg.html(" * ");
			s_box_success($('#email'))
			return email;
		}
	}
	function check_email(str){
		var atPos = str.lastIndexOf('@');
		var dotPos = str.lastIndexOf('.');
		if((dotPos < atPos) || (atPos < 4) || ((str.length - dotPos) < 3)){
			return false;
		}else{
			return true;
		}
	}
	function send_msg(){
		var name = sname();
		var subject = ssubject();
		var email = semail();
		var message = smessage();

		if (name == "" ||
			subject == "" ||
			email == "" ||
			message == "") {
			return; 
		}
		var data = "name=" + name + 
					"&email=" + email +  
					"&subject=" + subject +  
					"&message=" + message ;
		$("#success_msg").css({'color':'blue', 'font-weight':'bold'})
		var con = confirm("Are you sure this email address " + email + " is correct?");
		if(con){
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function(){
				if (this.readyState > 0 || this.readyState < 4)
					document.getElementById('success_msg').innerHTML = "Loading...";
				if (this.readyState == 4 && this.status == 200)
					$('#success_msg').html("Thank you for contacting us. <br>"
							+ "Message sent successfully.<br>We will get back to you ASAP "
							+ "<span class='fas fa-thumbs-up'></span>");
			}
			xhttp.open("POST", "./server/contact-us.inc.php?" + data, true);
			xhttp.send();
			document.getElementById('name').value = "";
			document.getElementById('subject').value = "";
			document.getElementById('email').value = "";
			document.getElementById('message').value = "";
		}
	}