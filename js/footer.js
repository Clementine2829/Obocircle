$(document).ready(function () {
    footer();
	let cart = $("#cart").html();
    load_cart();
    setTimeout(function(){
		if(cart == 0){	
		    load_cart();
		}else{
			setTimeout(load_cart(), 5000);
		}
		console.log("running again\n");
    }, 50000);
});
function load_cart(){
	let loc = "#cart";
	let url = "./server/notifications.inc.php?action=cart";
	send_data(url, displayer, loc, " ", " ");
}
function footer(){
	let loc = "#the_footer";
	let url = "./footer.php";
	send_data(url, displayer, loc);
}
function displayer(data, loc){
	$(loc).html(data);
}
function foo(){}
/**
*Load data asych
*	@loading show when loading or not, and if so provide the location where it should display
*	#loading_text text to display if loading on button, defauld is 'Submit'
*	@loc the location that the results should be displayed 
*	@url the place where the data should be requested from
*	@func function to pass once the data has been fetched
*	@btn Button to get disabled while the call is being made
*	@return the data that was fetched
*/
function send_data(url,func=foo, loc, loading="", loading_text="", btn=""){
	if(loading == "")
		loading = '<div style="background-color: lightgray; padding:2%; width: 100%;">Loading, please wait...</div>';
	if(loading_text == "") loading_text = "Submit";
    if(btn != "") $(btn).prop("disabled", true);
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState > 0 || this.readyState < 4){
			$(loc).html(loading);
		}
		if (this.readyState == 4 && this.status == 200) {
            if(btn != "") $(btn).prop("disabled", false);
			$(loc).html(loading_text);
			func(this.responseText, loc);
		}
	}
	xhttp.open("POST", url, true);
	xhttp.send();	
}
//used by the subscribe footer page
function subscribe(){
	let email = $("#email_footer");
	let err_email = $("#err_email_footer");
	let err_msg_1 = (((window.innerWidth < 500) ? "<br style='display: block'>": "") + "Email address is required<br>");
	let err_msg_2 = (((window.innerWidth < 500) ? "<br style='display: block'>": "") + "Enter valid email address<br>");
	return get_email(email, err_email, err_msg_1, err_msg_2, '');
}
function footer_subscribe(){
	let email = subscribe();
	let loc = $("#err_email_footer");
	send_subscription(email, loc);
}
function send_subscription(email, loc, name="", category=1){
	if(email){
		let url = "./server/subscribe.inc.php?email=" + email;
        let loading = (((window.innerWidth < 500) ? "<br style='display: block'>": "") + "Loading, please wait");
		send_data(url, clear_subscribe, loc, loading);
	}	
}
function clear_subscribe(data, loc){
    if(data == "Thank you for subscribing with us."){
        $("#email_footer").val("");
    }
    $(loc).html(data);
    setTimeout(function(){
        $("#err_email_footer").html("");
    }, 90000); //clear after 90sec
}