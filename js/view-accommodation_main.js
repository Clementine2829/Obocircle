var modal = document.getElementById('rating_row');
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        setTimeout(function() { reviews();}, 2000);
    }
}

/***************************************************/
var clicked = 0;		
function check_values(x, x_msg, y = "", lv = 1, hv = 5){
    if((x < lv || x > hv) || (isNaN(x))){
        $('#rate_msg_err').html(x_msg);
        y.css({'border' : '1px solid red'});
        return false;
    }else{		
//			y.css({'border' : '1px solid rgb(160, 160, 160)'});
        return x;
    }
}

function star_ratings() {
    var originalTable = "";
//		document.getElementById('my_table').innerHTML = "";
    err_msg = "Select stars for ratings";
    if(check_values(clicked, err_msg))$('#rate_msg_err').html("");
    else return;
    $('#rate_msg_success').html("");
    var payload = $("#accommodation").val();
    var err_msg = "Select Location";
    var location = check_values($('#rate_location').val(), err_msg, $('#rate_location'));
    if(!location) return; 
    else $('#rate_location').css({'border' : '1px solid rgb(160, 160, 160)'});
    err_msg = "Select Services";
    var service = check_values($('#rate_services').val(), err_msg, $('#rate_services'));
    if(!service) return;
    else $('#rate_services').css({'border' : '1px solid rgb(160, 160, 160)'});
    err_msg = "Select rooms";
    var rooms = check_values($('#rate_rooms').val(), err_msg, $('#rate_rooms'));
    if(!rooms) return;
    else $('#rate_rooms').css({'border' : '1px solid rgb(160, 160, 160)'});
    var err_msg = "Select stuff";
    var stuff = check_values($('#rate_stuff').val(), err_msg, $('#rate_stuff'));
    if(!stuff) return; 
    else $('#rate_location').css({'border' : '1px solid rgb(160, 160, 160)'});
    err_msg = "Enter valid value on recommendation";
    var recommend = check_values($('#recommend').val(), err_msg, $('#recommend'), 0, 10);
    if(!recommend) return;
    else $('#recommend').css({'border' : '1px solid rgb(160, 160, 160)'});
    $('#rate_msg_err').html("");
    var data = "stars=" + clicked + "&location=" + location + "&service=" + service 
                + "&rooms=" + rooms + "&stuff=" + stuff + "&scale=" + recommend + "&payload=" + payload;
    alert(data); return;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (this.readyState > 0 || this.readyState < 4)
            $('#rate_msg_success').html("Loading...");
        if (this.readyState == 4 && this.status == 200)
            $('#rate_msg_success').html("Survey send successfully. " + 
                                    "<span style='color:green'>" +
                                    "<br>Thank you for taking part in this survay." + 
                                            "We appreciate your participation</span>" +
                                    "<br><span style='color:red'>" +
                                    "NB. If you previously gave ratings to this accommodation.." + 
                                            "They will be overwritten</span>");
            $('.btns_rates').css({'display':'none'})
            document.getElementById('rate_msg_success').innerHTML += this.responseText; 
    }
    xhttp.open("POST", "../server/accommodation-survey.php?" + data, true);
    xhttp.send();
    document.getElementById('my_table').innerHTML = originalTable;
    document.getElementById('rating_row').style.display = "inline";
}
function checked_n(x) {
    var i = 0;
    $("#u_ratings span").each(function(){
        if(x >= 0 && i < x){
            $(this).css({
                'color': 'orange'
            });
        }
        i++;
    });	
}

function unchecked_n(x) {
    $("#u_ratings span").each(function(){
        $(this).css({
            'color': 'black'
        });
    });	
}