function get_window(){
    return "";
    return (window.innerWidth < 500) ? w = "1" : w = "";
}
function get_btns(){
	let btns = 0;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if (this.readyState > 0 || this.readyState < 4){
			//do nothing, while loading in bg...
		}
  		if (this.readyState == 4 && this.status == 200){
			btns = parseInt(this.responseText, 10);
			set_buttons(btns)
		}
	}
	xhttp.open("POST", set_urls(set_url), true); //url function in another page
	xhttp.send();
	return btns;
}
function set_buttons(btns){
	if(isNaN(btns) || btns == 0){
		btns = 1;
	}else{
		if((btns % 10) != 0){
			let temp_btns = (btns / 10).toFixed(1);
/*					
			let token = temp_btns.split('.');
			//force it to round to the above following number
			btns = (token[1] < 5) ? parseInt(parseInt(temp_btns, 10).toFixed(), 10) + 1 : parseInt(temp_btns, 10).toFixed();
*/
			btns = parseInt(parseInt(temp_btns, 10).toFixed(), 10) + 1;
		}else{
			btns = parseInt(btns / 10);
		}
	} 
	if(get_window() != 1){btns++;}
	//if(window.location.href == "http://localhost:9090/dashboard/obocircle/featured.php"){btns--;}
	let div = "";
	if(btns > 0){
		let num = 0;
		let i = 0;
		div += "<button class='next_page' onclick='set_btn_action(\"prev\", -1, " + function_type + ")'>Prev</button>";
		if(btns > 4){
			div += "<div class='inner_page'>";
		}
		for (i = 0; i < btns; i++) {
			num = parseInt(i) + 1;
			div += "<button class='next_page' onclick='set_btn_action(\"\", " + num + ", " + function_type + ")'>" + num + "</button>";					
		}
		if(btns > 2){
			div += "</div>";
		}
		div += "<button class='next_page' onclick='set_btn_action(\"next\", -2, " + function_type + ")'>Next</button>";
	}else{
		div += "<button class='next_page' onclick=\"alert('No more files available')\" disabled>No more files available</button>";				
	}
	$("#next_page").html(div);
	disable_btns();	
}

function set_btn_action(btn_type="", i=-1, type){
	document.body.scrollTop = 0; //for safar
	document.documentElement.scrollTop = 0; //for other browsers
	
	if(i <= -1){
		i = 1;
	}else if(i == ""){
		i = page;
	}
	if(btn_type == "prev"){
		page--;
	}else if(btn_type == "next"){
		page++;
	}else{
		page = i;			
	}
	if(page < 1) {
		page = 1;
	}

	disable_btns();	
	//make it flexible by checing if it is default, search or filter that is being used
    if(function_type == 1) search_here();
    else if(function_type == 2) search_filters();
    else default_display();
}
function disable_btns(){
	let btns = $("#next_page .next_page").length;
	//disable both prev and next if no many btns 
	if((page == 1) && ((btns - page) < 3)){
		$("#next_page .next_page:first-child").prop("disabled", true);
		$("#next_page .next_page:last-child").prop("disabled", true);
		$("#next_page .next_page:first-child").css({"color":"rgb(60, 60, 60)"});
		$("#next_page .next_page:last-child").css({"color":"rgb(60, 60, 60)"});
	}
	//disable "prev" btn when on first page
	if(page == 1){
		$("#next_page .next_page:first-child").prop("disabled", true);
		$("#next_page .next_page:last-child").prop("disabled", false);
		$("#next_page .next_page:first-child").css({"color":"rgb(60, 60, 60)"});
		$("#next_page .next_page:last-child").css({"color":"white"});
	} 
	//disable "next" btn when on last page
	if((btns - page) < 3){
		$("#next_page .next_page:last-child").prop("disabled", true);
		$("#next_page .next_page:first-child").prop("disabled", false);
		$("#next_page .next_page:first-child").css({"color":"white"});
		$("#next_page .next_page:last-child").css({"color":"rgb(60, 60, 60)"});
	}
}
function set_defaults(x, y){
//	alert("function_type: " + function_type + "\nx: " + x + "\ny: " + y)

	if(function_type == x) {search();}
	else if(function_type == y) {sort_by();}
	else{
		let url = get_url() + "&w=" + get_window();
		if(typeof(GLOBAL_CATEGORY) !== "undefined")
		url = get_url(GLOBAL_CATEGORY) + "&w=" + get_window();
//		get_btns();
//		alert(url);
		tamplate_function(url);
	}

}
function default_display() {
	let url = get_url();
	get_btns();
	send_data(url, displayer, "#display_results");
}
