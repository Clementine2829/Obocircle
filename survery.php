<!--header-->
<?php require_once('./header.php'); ?>
<!--end header-->

<style type="text/css">
.main{
    width: 100%;
    float: left;
    padding: 2% 8%;
}        
.main .main_info{
    text-align:center;
    color: orange;
    border-bottom: 2px solid orange;
    padding-bottom: 3%;
}
.container{

}
.container form .sub_container{
	margin-bottom: 2%;

}
.container form .sub_container:nth-child(1) .inner_s .inner_sub, 
.container form .sub_container:nth-child(2) .inner_s .inner_sub{
	cursor: pointer;
	border: 1px solid orange;
	padding: 2px 5px;
	border-radius: 7px;
	margin-right: 10px;

}
.container form .sub_container:nth-child(1) input[type=radio], 
.container form .sub_container:nth-child(2) input[type=radio]{
	opacity: 0;
	width: 0;
	height: 0;
}
.container form .sub_container label{
	margin-bottom: 0px;
}
.container form .sub_container select{
	width: 20%;
	border-radius: 7px;
	border: 1px solid orange;
	padding: 2px 4px;
}
.container form .sub_container textarea{
	height: 120px;
	width: 40%;
	border-radius: 7px;
	border: 1px solid orange;
	padding: 5px 10px;
}
.container form .sub_container select:active, 
.container form .sub_container select:focus,
.container form .sub_container textarea:active,
.container form .sub_container textarea:focus{
	outline: none;
}
.container form .sub_container input[type=button]{
	text-align: center;
	width: 15%;
	padding: 10px;
	background-color: orange;
	border: 1px solid orange;
	border-radius: 7px;
}
.container form .sub_container .other{display:none}
.container form .sub_container .err{color:red;}

</style>
    <div class="main">
        <div class="main_info">
            <h4>Your support is very much appreciated</h4>
            <p>Thank you for choosing Obocircle.com for services</p>
            <p>Your contribution to this survey will help us @ Obocircl.com to bring the best services at all time.<br> 
            	Please be informed that this survey is anonymous, and is used purely for quality purposes.</p>
        </div>
    </div>

	<div class="container">
		<form id="survey_form" action="survey.html" method="post">
			<div class="sub_container">
				<label><strong>Race: </strong></label> 
				<span class="err" id="err_race" name="err_race"> * </span>
				<div class="inner_s">
					<span class="inner_sub" onclick="checked_race(1)"><input type="radio" name="race" value="b">Black</span>
					<span class="inner_sub" onclick="checked_race(2)"><input type="radio" name="race" value="w">White</span>
					<span class="inner_sub" onclick="checked_race(3)"><input type="radio" name="race" value="i">Indian</span>
					<span class="inner_sub" onclick="checked_race(4)"><input type="radio" name="race" value="o">Other</span>
				</div>
			</div>
			<div class="sub_container">
				<label><strong>Gender: </strong></label> 
				<span class="err" id="err_gender" name="err_gender"> * </span>
				<div class="inner_s">
					<span class="inner_sub" onclick="checked_gender(1)"><input type="radio" name="gender" value="M">Male</span>
					<span class="inner_sub" onclick="checked_gender(2)"><input type="radio" name="gender" value="F">Female</span>
					<span class="inner_sub" onclick="checked_gender(3)"><input type="radio" name="gender" value="o">Other</span>
				</div>
			</div>
			<div class="sub_container">
				<label>Institution</label>
				<span class="err" id="err_institution" name="err_institution"> * </span>
				<div>
					<select id="institution" name="institution" >
						<option value="select">--Select--</option>
						<option value="university">University</option>
						<option value="university_tech">University of Technologg</option>
						<option value="college">College</option>
					</select>
				</div>
				<div>
					<select id="institution" name="institution" class="other" >
						<option value="select">--Select--</option>
						<option value="uj">University of Cape Town</option>
						<option value="ufs">University of Free State</option>
						<option value="uj">University of Johannesburg</option>
						<option value="ukzn">University of KwaZulu Natal</option>
						<option value="ul">University of Limpopo</option>
						<option value="up">University of Pretoria</option>
						<option value="wits">Witwatersrand University</option>
					</select>
				</div>
			</div>
			<div class="sub_container">
				<label>Which service(s) did you use (You can select more than one)</label>
				<span class="err" id="err_services_used" name="err_services_used"> * </span>
				<div>
					<span class="inner_us"><input type="checkbox" id="accommodations" name="accommodations" value="accommodations"> Accommodations<br></span>
					<span class="inner_us"><input type="checkbox" id="books" name="books" value="books"> Books<br></span>
					<span class="inner_us"><input type="checkbox" id="electronics" name="electronics" value="electronics"> Electronics<br></span>
				</div>			
			</div>
			<div class="sub_container">
				<label>How satisfied are you with our service(s) selected above</label>
				<span class="err" id="err_services_provide" name="err_services_provide"> * </span>
				<div>
					<select>
						<option value="select">--Select--</option>
						<option value="very_s">Very Satisfied</option>
						<option value="s">Satisfied</option>
						<option value="fine">Somehow satisfied</option>
						<option value="very_d">Dissatisfied</option>
						<option value="d">Very Dissatisfied</option>
					</select>
				</div>
			</div>
			<div class="sub_container">
				<label>How likely are you to recommend us a friend, family member or colleagues</label>
				<span class="err" id="err_recommendation" name="err_recommendation"> * </span>
				<div>
					<select>
						<option value="select">--Select--</option>
						<option value="very_s">Very Likely</option>
						<option value="s">Likely</option>
						<option value="fine">Somehow likely</option>
						<option value="very_d">Unlikely</option>
						<option value="d">Very Unlikely</option>
					</select>
				</div>
			</div>
			<div class="sub_container">
				<label>How easy was it to find what you were looking for?</label>
				<span class="err" id="err_easy" name="err_easy"> * </span>
				<div>
					<span class="inner_sub"><input type="radio" name="find_what_you_looking_for" value="5"> Very easy<br></span>
					<span class="inner_sub"><input type="radio" name="find_what_you_looking_for" value="4"> easy<br></span>
					<span class="inner_sub"><input type="radio" name="find_what_you_looking_for" value="3"> Somehow easy<br></span>
					<span class="inner_sub"><input type="radio" name="find_what_you_looking_for" value="2"> Difficult<br></span>
					<span class="inner_sub"><input type="radio" name="find_what_you_looking_for" value="1"> Very difficult<br></span>
				</div>
			</div>
			<div class="sub_container">
				<label>What was your reason for your visit to the website today</label>
				<span class="err" id="err_reason_for_visit" name="err_reason_for_visit"> * </span>
				<div>
					<span class="inner_sub"><input type="checkbox" value="a" name="a"> Find/Upload Accommodations<br></span>
					<span class="inner_sub"><input type="checkbox" value="b" name="b"> Buy/Sell Books<br></span>
					<span class="inner_sub"><input type="checkbox" value="e" name="e"> Buy/Sell Electronics<br></span>
					<span class="inner_sub"><input type="checkbox" value="o" name="o"> Other</span>
				</div>
			</div>
			<div class="sub_container">
				<label>How/Where did you hear about us </label>
				<span class="err" id="err_hear_about_us" name="err_hear_about_us"> * </span>
				<div>
					<span class="inner_sub"><input type="radio" name="heared" id="social_media" value="social_media"> Social media( news feeds)<br></span>
					<span class="inner_sub"><input type="radio" name="heared" id="friend" value="friend"> From friend/family/colleague<br></span>
					<span class="inner_sub"><input type="radio" name="heared" id="search_engine" value="search"> Search engine(E.g. Google search)<br></span>
					<span class="inner_sub"><input type="radio" name="heared" id="accommodation" value="accommodation"> From accommodation i went/stay<br></span>
					<span class="inner_sub"><input type="radio" name="heared" id="book" value="book"> Book store<br></span>
					<span class="inner_sub"><input type="radio" name="heared" id="electronic" value="electronic"> Electronic store<br></span>
					<span class="inner_sub"><input type="radio" name="heared" id="seller" value="seller"> From a seller<br></span>
					<span class="inner_sub"><input type="radio" name="heared" id="other_hear" value="other"> Other<br></span>
				</div>
			</div>
			<div class="sub_container">
				<label>Are you a first time shopper?</label>
				<span class="err" id="err_first_time_shopper" name="err_first_time_shopper"> * </span>
				<div>
					<span class="inner_sub"><input type="radio" name="first_timer" id="1" value="1"> Yes<br></span>
					<span class="inner_sub"><input type="radio" name="first_timer" id="2" value="2"> No<br></span>
				</div>
			</div>
			<div class="sub_container">
				<label>What is your favorite tool or portion of the product or service?</label>
				<span class="err" id="err_favorite_tool" name="err_favorite_tool"> * </span>
				<div>
					<span class="inner_sub"><input type="checkbox" id="f1" name="f1"> Accommodation portion <br></span>
					<span class="inner_sub"><input type="checkbox" id="f2" name="f2"> Books portion <br></span>
					<span class="inner_sub"><input type="checkbox" id="f3" name="f3"> Electronics portion <br></span>
					<span class="inner_sub"><input type="checkbox" id="f4" name="f4"> Other <br></span>
				</div>
			</div>
			<div class="sub_container">
				<label>Do you have any suggestions on how we could improve our website/product/service/customer service</label>
				<span class="err" id="err_improvement" name="err_improvement"> * </span>
				<div>
					<input type="radio" name="suggestion" id="s1" value="s1"> Yes<br>
					<input type="radio" name="suggestion" id="s2" value="s2"> Not now <br>
					<textarea id="s3" class="other" name="s3" placeholder="Type your suggestion here..." ></textarea>
				</div>
			</div>
			<div class="sub_container">
				<label>Overall, how satisfied are you with obocircle.com?</label>
				<span class="err" id="err_overrall" name="err_overrall"> * </span>
				<div>
					<select name="overall" id="overall">
						<option value="select">--Select--</option>
						<option value="very_s">Very Satisfied</option>
						<option value="s">Satisfied</option>
						<option value="fine">Fine</option>
						<option value="d">Dissatisfied</option>
						<option value="very_d">Very Dissatisfied</option>
					</select>
				</div>
			</div>
			<div class="sub_container">
				<label>Leave a note(Optional)</label>
				<span class="err" id="err_note" name="err_note">  </span>
				<div>
					<textarea id="note" name="note" placeholder="Type your note here..." ></textarea>
				</div>
			</div>
			<div class="sub_container">
				<input type="button" onclick="submit_form()" value="Submit">
			</div>
		</form>
	</div>

<!--
race
gender
institutions

which service did you use? accommodation, books or electronics
How satisfied are you with our services
did you find what you where looking for?
if no 
would you buy from us again
How lickely are you to recommend us a friend, family member or colleagues


How easy was it to find what you were looking for? Answers ranging from very difficult to very easy

What was your reason for your visit to the website today

How did you hear about us 
Are you a first time shopper?

What is your favorite tool or portion of the product or service?

Where should we improve/done do better to get a 10/10 

Do you have any suggestions on how we could improve our website/product/service/customer service

overrall, how satisfied are you with obocircle.com? satisfied, fine, dissatisfied

your note(type here )

-->

	<div class="row" >
		<div class="col-sm-12" >
			<div id="the_footer"></div>
		</div>
	</div>

    <script src="jquery-3.3.1.min.js" type="text/javascript"></script>
	<script type="text/javascript">

		/*
			Create jason data for universities dn colleges and put them on the list as they naigate through
		*/	
		function submit_form(){

radiocheckbox_selected();
/*
			let con = confirm("Are you sure");
			if(con)$('#survey_form').submit();
			else return;
*/
		}

//	function checkbox_selected(x, btn, err_msg){
	function radiocheckbox_selected(){
		checked = false;
		alert($(".container form .sub_container:nth-child(7) .looking_for input").prop('checked'));
		for(var i = 0; i < 5; i++){
			if($(".container form .sub_container:nth-child(7) .looking_for input").prop('checked')){
				checked = true;
				break; //it means one is checked at least
			}
		}
		if(!checked) $("#err_easy").html(" Select one below");
		else $("#err_easy").html(" * ");
//		alert(checked);
//		return checked;		

		//alert($(".container form .sub_container:nth-child(7) :find_what_you_looking_for:nth-child(1)").val());

	}
	function checkbox_selected(btn, err_msg){


	}

    function checked_btn(x, y){
		$(".container form .sub_container:nth-child(" + x + ") .inner_s .inner_sub input").prop('checked', false);
		$(".container form .sub_container:nth-child(" + x + ") .inner_s .inner_sub:nth-child(" + y + ") input").prop('checked', true);                                                                                                                                           
    }
    function checked_race(x){
        checked_btn(1, x);
        $(".container form .sub_container:nth-child(1) .inner_s .inner_sub").css({"background-color": "white"});
        $(".container form .sub_container:nth-child(1) .inner_s .inner_sub:nth-child(" + x + ")").css({"background-color": "orange"});
    }
    function checked_gender(x){
        checked_btn(2, x);
        $(".container form .sub_container:nth-child(2) .inner_s .inner_sub").css({"background-color": "white"});
        $(".container form .sub_container:nth-child(2) .inner_s .inner_sub:nth-child(" + x + ")").css({"background-color": "orange"});
    }


	</script>
</body>
</html>
