	$(document).ready(function(){
		onload(true);
		$("#header_btns a:nth-child(1)").click(function(){onload();})
		$("#header_btns a:nth-child(2)").click(function(){photos();})
		$("#header_btns a:nth-child(3)").click(function(){google_map();})
		$("#header_btns a:nth-child(4)").click(function(){about();})
		$("#header_btns a:nth-child(5)").click(function(){reviews();})
	})
	function onload(loading=false){ temp_fun_ext("overview", 1); }
	function photos(){ temp_fun_ext("images", 2); }
	function google_map(){ temp_fun_ext("maps", 3); }
	function about(){ temp_fun_ext("about", 4); }
	function reviews(){ temp_fun_ext("reviews", 5); }
    function temp_fun_ext(action, num){
        let accommodation = $("#accommodation").val();
        var url = "./server/view-accommodation.inc.php?accommoation=" + accommodation + "&action=" + action;
        temp_fan(url, "", loading=false);

        $("#header_container a").css({'border-bottom':'none'})
        $("#header_container a:nth-child(" + num + ")").css({'border-bottom':'2px solid red'})
    }
	function temp_fan(url, fun = "", loading = false){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if(loading){
				if (this.readyState > 0 || this.readyState < 4)
					document.getElementById(loc).innerHTML = "Loading. Please wait";
			}
			if (this.readyState == 4 && this.status == 200) {
				$("#display_accommodation").html(this.responseText);
/*            if(fun == 'r'){
					$('[data-toggle="tooltip"]').tooltip();
					load_location1();
					load_location2();
					load_location3();
				}
				if(fun == 'p'){
					photos_click();
				}
				$(document).ready(function(){
					$("#u_ratings span").each(function(){
						$(this).click(function() {
							$this = $(this);
							clicked = $("#u_ratings span").index($this) + 1;
							$this.prop("checked", true);
//								alert($("#u_ratings span").index($this) + 1);
//								alert(clicked);
							unchecked_n($("#u_ratings span").index($this) + 1);
							checked_n($("#u_ratings span").index($this) + 1);
						});
					});
					if(fun == 'l'){
						$('#communication :radio:nth-child(1)').click(function(){
							if($('#communication :radio:nth-child(1)').prop('checked')){
//							alert($('#communication :radio:nth-child(1)').val());
								$('#communication :radio:nth-child(2)').attr('checked', false);
								$('#communication :radio:nth-child(1)').attr('checked', false);
								$('#preffered_communication').html(' * ');
								return "";
							}else{
								$('#communication :radio:nth-child(2)').attr('checked', false);
								$('#communication :radio:nth-child(1)').attr('checked', true);
								return $('#communication :radio:nth-child(1)').val();
							}
						});
						$('#communication :radio:nth-child(2)').click(function(){
							if($('#communication :radio:nth-child(2)').prop('checked')){
								$('#communication :radio').attr('checked', false);
								$('#preffered_communication').html(' * ');
								return "";
							}else{
								$('#communication :radio:nth-child(1)').attr('checked', false);
								$('#communication :radio:nth-child(2)').attr('checked', true);
							$('#preffered_communication').html(' * ');
								return $('#communication :radio:nth-child(2)').val();
							}
						});	

					}
				});*/
			}
		}
		xhttp.open("POST", url, true);
		xhttp.send();
	}
	var modal = document.getElementById('rating_row');
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
			close_rate();
		}
	}
	function photos_click(){
/*			$('.images .image').click(function(){
			$('#close_image').css({'display':'block'})
			$('#select').css({'display':'none'});
			$('.images .image img').css({
				'height': '90%',
				'width': '100%',
				'padding': '2%'
			});
			$(this).css({
				'position': 'fixed',
				'z-index': '1',
				'left': '0',
				'top': '0',
				'width': '100%',
				'height': '100%',
				'overflow': 'auto',
				'padding':'15%;',
				'background-color': 'rgba(0,0,0,.8)',
				'padding-top': '60px'
			});
			$('.images .close_image').css({
				'display':'block',
				'position': 'absolute',
				'right': '25px',
				'top': '25px',
				'color': 'red',
				'font-size': '40px',
				'font-weight': 'bold' 
			})
		});
*/		}
	function min_image(){
		document.getElementById('select').style.display= 'block';			
		$('.images .image').css({
			'height': '150px',
			'width': '25%',
			'float': 'left'
		})
		$('.images .image img').css({
			'width': '100%',
			'height': '100%',
			'padding': '2%'
		})
	}
	function rate_give(){
		document.getElementById('rating_row').style.display= 'block';
		document.getElementById('select').style.display= 'none';
		document.getElementById('apply_container').style.display='none';
	}
	function close_rate(){
		document.getElementById('rating_row').style.display='none';
		document.getElementById('apply_container').style.display='none';
		document.getElementById('select').style.display= 'block';
		setTimeout(function() { reviews();}, 300);
	}
	function close_apply(){
		document.getElementById('apply_container').style.display='none';
		document.getElementById('select').style.display= 'block';
	}
