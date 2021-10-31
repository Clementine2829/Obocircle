    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->

	<link rel="stylesheet" type="text/css" href="./css/style-upload-accommodation.css">
    <div class="heading">
        <h5>Use the form below to post your new accommodation</h5>
    </div>
    <div id="form">
		<form method="post" id="uploads">
			<label for="" >Accomodation Name: </label><br>
			<input type="text" id="name" onblur="accomodation_name()" placeholder="E.g. House  Africa"> 
			<span class="err" id="err_name"> *</span> <br>
			<br>
			<label for="">Physical Address:</label><br>
			<input type="text" id="line1" onblur="validate_address1()" placeholder="Address Line 1">
			<span class="err" id="err_line1"> *</span> <br>
			<input type="text" id="line2" onblur="validate_address2()" placeholder="Address Line 2">
			<span class="err" id="err_line2"> </span> <br>
			<input type="text" id="town" onblur="validate_town()" placeholder="Town/City">
			<span class="err" id="err_town"> *</span> <br>
			<input type="number" id="code" onblur="validate_code()" placeholder="Address code">
			<span class="err" id="err_code"> *</span> <br>
			<br>
			<label for="" >Types of Rooms Available:</label>
			<span class="err" id="err_rooms"> *</span> <br>
			<input type="checkbox" id="single" checked> Single rooms<br>
			<input type="checkbox" id="two" checked> Double sharing<br>
			<input type="checkbox" id="three" > Multiple Sharing<br>
			<br>
			<label for="" >Short Summary of this Accommodation</label>
			<span class="err" id="err_summary"> *</span> <br>
			<textarea id="about_accommo" onblur="validate_message()" ></textarea><br>
			<span>
				<input type="checkbox" id="declare">
				<span id="declare_info">
					I declare that this information provided is legit. 
					And that I own/manage this accommodation or have been granted permission by the owner/manager
					to post it on this webiste<br>
				</span> 
				For more information, please visit our <a href="./terms_of_use.html">T&C</a>.
			</span>
			<p id="success_msg" ></p>
			<input type="button" id="submit" value="Submit" onclick="upload()">
			<input type="button" id="re_btn" style="background-color: red;"
					value="My accommodation" onclick="window.location='dashboard.php'">
		</form>
	</div>

    <!--footer-->
    <div class="row">
        <div class="col-sm-12">
            <div id="the_footer"></div>
        </div>
    </div>
    <!--end footer-->   
    <!--script-->
	<script src="js/validate_email.js" type="text/javascript"></script>
	<script src="js/footer.js" type="text/javascript"></script>
	<script type="text/javascript">
        function accomodation_name(){
            var txt = $('#name').val();
            var err_msg = $('#err_name');
            var msg = "Name";	
            txt = validate_txt(txt, err_msg, msg);
            return (txt == "") ? "" : txt;
        }	
        function validate_address1(){
            var txt = $('#line1').val();
            var err_msg = $('#err_line1');
            var msg = "Address line 1";
            txt = validate_txt(txt, err_msg, msg);
            return (txt == "") ? "" : txt; 
        }
        function validate_address2(){
            var txt = $('#line2').val();
            if(txt != "") {
                var err_msg = $('#err_line2');
                var msg = "Address line 2";
                txt = validate_txt(txt, err_msg, msg);
            };	
            return (txt == "") ? "" : txt; 
        }	
        function validate_town(){
            var txt = $('#town').val();
            var err_msg = $('#err_town');
            var msg = "Town";
            txt = validate_txt(txt, err_msg, msg);
            return (txt == "") ? "" : txt; 
        }	
        function validate_code(){
            var txt = $('#code').val();
            var err_msg = $('#err_code');
            if(txt == "" || txt.length != 4 || !txt.match(/\d{4}/)){
                err_msg.html("Invalid address code number");
                return "";
            }else{
                err_msg.html(" * ");
                return txt;
            }
        }	
        function validate_message(){
            var txt = $('#about_accommo').val();
            var err_msg = $('#err_summary');
            var msg = "Summary";
            var pattern = /^[a-zA-Z0-9\'\.\@\,\(\)\s\!\?\"\%]*$/;
            txt = validate_txt(txt, err_msg, msg);
            return (txt == "") ? "" : txt; 
        }	
        function validate_txt(txt, err_msg, msg, pattern = ""){
            var msg = msg + " is required";	
            var msg2 = "Invalid use of special characters";	
            if(pattern == "") pattern = /^[a-zA-Z0-9\'\.\@\,\s]*$/;
            if(txt == ""){
                err_msg.html(msg);
                return "";
            }else if(!txt.match(pattern)){
                err_msg.html(msg2);
                return "";
            }else{
                err_msg.html(" * ");
                return txt;
            }
        }
        function checkBox(x){
            return (x == true) ? 1 : 0;
        }
        function upload(){
            let uploads = $('#uploads').html();
            var declare = checkBox(document.getElementById('declare').checked);
            if(declare == 0) document.getElementById('declare_info').style.color = "red";

            var name = accomodation_name();
            var address1 = validate_address1();
            var address2 = validate_address2();
            var town = validate_town();
            var code = validate_code();
            var about = validate_message();

            var checkbox1 = document.getElementById('single').checked;
            var checkbox2 = document.getElementById('two').checked;
            var checkbox3 = document.getElementById('three').checked;

            if(!checkbox1 && !checkbox2 && !checkbox3){
                $('#err_rooms').html("Please select the type of rooms available");
                return;
            }else $('#err_rooms').html(" * ");
            if(declare == 0) return;
            document.getElementById('declare_info').style.color = "black";

            checkbox1 = checkBox(checkbox1);
            checkbox2 = checkBox(checkbox2);
            checkbox3 = checkBox(checkbox3);
            if (name == "" ||
                address1 == "" ||
                town == "" ||
                code == "" ||
                about == "") 
                return;
            var confirm_this = confirm('Are you sure all the supplied infomation is Correct?\n' +
                                        'Because you cannot change them going forward!');
            if (confirm_this){
                var data = "name=" + name + 
                            "&address1=" + address1 +  
                            "&address2=" + address2 +  
                            "&town=" + town +  
                            "&code=" + code +  
                            "&about=" + about +
                            "&checkbox1=" + checkbox1 +  
                            "&checkbox2=" + checkbox2 +  
                            "&checkbox3=" + checkbox3 +
                            "&declare=" + declare ;
                var xhttp;
                document.getElementById("success_msg").style.color = "blue";
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function(){
                    if (this.readyState > 0 || this.readyState < 4){
                        document.getElementById('submit').disabled = "true";
                        $('#submit').css({'background-color':'rgba(0, 0, 150, 0.8)'});
                        document.getElementById('submit').value = "Loading...Please wait";
                        document.getElementById('re_btn').disabled = "true";
                    }
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('re_btn').disabled = "false";
                        $('#submit').css({'display':'none'});
                        if(this.responseText == "success") response();
                        else{
                            document.getElementById("success_msg").style.color = "red";
                            $("#success_msg").html(this.responseText);
                        }
                    }
                }
                xhttp.open("POST", "upload-accommodation.inc.php?" + data, true);
                xhttp.send();
            }
            data = "";
            $("#success_msg").html("");
        }
        function response(){
            $("#success_msg").html("<b style='color: blue'>Posted successfully. <br> \
                <span style='color:green'>Redirecting in <span id='sec'>3</span> sec...</span></b>");
            setInterval(function(){
                let x = $('#sec').html();
                if(x == 3) $('#sec').html(2);
                else if(x == 2) $('#sec').html(1);
                else if(x == 1) $('#sec').html(0);
            }, 1000);
            setInterval(function(){window.location = "./dashboad.php"}, 3000);
        }
	</script>

</body>      
</html>