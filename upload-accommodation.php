    <!--header-->
    <?php require_once('./header.php'); ?>
    <!--end header-->
    <?php
        $_SESSION['redir'] = './upload-accommodation.php';

        if(!isset($_SESSION['s_id'])){
            echo "<style type='text/css'>#access_denied{margin: 5% 9%;}</style>";
            require_once "offile.html";  
        }else if(!isset($_SESSION['s_user_type']) || 
                 (isset($_SESSION['s_user_type']) && !preg_match('/(premium_user|manager)/', $_SESSION['s_user_type']))){
            echo "<style type='text/css'>#access_denied{margin: 5% 9%;}</style>";
            require_once "access_denied.html";               
        }else{
            ?>
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
                    <input type="radio" name="address_type" onchange="switch_location()" value="google" checked> Use Google maps
                    <input type="radio" name="address_type" onchange="switch_location()" value="manual"> Enter address manually<br> 
                    <div id="maps1">
                        <div id="pac-container">
                            <input id="pac-input" type="text" placeholder="Enter a location" /> 
                            <span id="err_google_address" class="err"> * </span> 
                        </div>
                        <div id="map"></div>
                        <div id="infowindow-content">
                            <span id="place-name" class="title"></span><br />
                            <span id="place-address"></span>
                        </div>                    
                    </div>
                    <div id="maps2">                    
                        <input type="text" id="line1" onblur="validate_address1()" placeholder="Address Line 1">
                        <span class="err" id="err_line1"> *</span> <br>
                        <input type="text" id="line2" onblur="validate_address2()" placeholder="Address Line 2">
                        <span lass="err" id="err_line2"> </span> <br>
                        <input type="text" id="town" onblur="validate_town()" placeholder="Town/City">
                        <span class="err" id="err_town"> *</span> <br>
                        <input type="number" id="code" onblur="validate_code()" placeholder="Address code">
                        <span class="err" id="err_code"> *</span> <br>
                        <br>
                    </div>   
                    
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
            <?php
        }
    ?>

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

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwwuWaT4B4W0Rlwch_OOItCWuPyTFILV8&libraries=places&callback=initMap"></script>
	<script type="text/javascript">
        
        function switch_location(){
            let loc = $("input[type=radio]:checked").val();
            
            if(loc == "manual"){
                $("#maps1").css({"display": "none"})
                $("#maps2").css({"display": "inline-block"})
            }else{
                $("#maps1").css({"display": "inline-block"})
                $("#maps2").css({"display": "none"})
            }
        }
        
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
            var loc = $("input[type=radio]:checked").val();
            var address = $("#pac-input").val();
            
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
            $("#err_google_address").html(" * ");
            if(loc == "manual" && (name == "" || address1 == "" || town == "" || code == "" || about == "")){
                address = "";
                return;
            }else if((loc == "google" && address == "") && (name == "" || about == "")){
                address1 = ""; 
                address2 = ""; 
                town = "";
                code = "";
                $("#err_google_address").html("Google maps required");
                return;
            } 
            
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
                //alert(data); return;
                
                document.getElementById("success_msg").style.color = "blue";
                var xhttp = new XMLHttpRequest();
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
                xhttp.open("POST", "./server/upload-accommodation.inc.php?" + data, true);
                xhttp.send();
            }
            data = "";
            $("#success_msg").html("");
        }
        function response(){
            document.getElementById('submit').remove();
            $("#success_msg").html("<b style='color: blue'>Posted successfully. <br> \
                <span style='color:green'>Redirecting in <span id='sec'>3</span> sec...</span></b>");
            setInterval(function(){
                let x = $('#sec').html();
                if(x == 3) $('#sec').html(2);
                else if(x == 2) $('#sec').html(1);
                else if(x == 1) $('#sec').html(0);
            }, 1000);
            setInterval(function(){window.location = "./dashboard.php"}, 3000);
        }
	</script>
    <script type="text/javascript">

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 40.749933, lng: -73.98633 },
    zoom: 13,
    mapTypeControl: false,
  });
  //const card = document.getElementById("pac-card");
  const input = document.getElementById("pac-input");
  //const biasInputElement = document.getElementById("use-location-bias");
  //const strictBoundsInputElement = document.getElementById("use-strict-bounds");
  const options = {
    fields: ["formatted_address", "geometry", "name"],
    strictBounds: false,
    types: ["establishment"],
  };

  //map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

  const autocomplete = new google.maps.places.Autocomplete(input, options);

  // Bind the map's bounds (viewport) property to the autocomplete object,
  // so that the autocomplete requests use the current map bounds for the
  // bounds option in the request.
  autocomplete.bindTo("bounds", map);

  const infowindow = new google.maps.InfoWindow();
  const infowindowContent = document.getElementById("infowindow-content");

  infowindow.setContent(infowindowContent);

  const marker = new google.maps.Marker({
    map,
    anchorPoint: new google.maps.Point(0, -29),
  });

  autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =
      place.formatted_address;
    infowindow.open(map, marker);
  });

  // Sets a listener on a radio button to change the filter type on Places
  // Autocomplete.
  function setupClickListener(id, types) {
    const radioButton = document.getElementById(id);

    radioButton.addEventListener("click", () => {
      autocomplete.setTypes(types);
      input.value = "";
    });
  }
  //setupClickListener("changetype-all", []);
/*
  biasInputElement.addEventListener("change", () => {
    if (biasInputElement.checked) {
      autocomplete.bindTo("bounds", map);
    } else {
      // User wants to turn off location bias, so three things need to happen:
      // 1. Unbind from map
      // 2. Reset the bounds to whole world
      // 3. Uncheck the strict bounds checkbox UI (which also disables strict bounds)
      autocomplete.unbind("bounds");
      autocomplete.setBounds({ east: 180, west: -180, north: 90, south: -90 });
      strictBoundsInputElement.checked = biasInputElement.checked;
    }

    input.value = "";
  });
  strictBoundsInputElement.addEventListener("change", () => {
    autocomplete.setOptions({
      strictBounds: strictBoundsInputElement.checked,
    });
    if (strictBoundsInputElement.checked) {
      biasInputElement.checked = strictBoundsInputElement.checked;
      autocomplete.bindTo("bounds", map);
    }

    input.value = "";
  });*/
}
        
    </script>
</body>      
</html>