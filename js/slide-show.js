var slideIndex = 1;
function close_slide_show(){
	//	get all the images to thier original state
	photos();
	$('#image_container').css({'margin-top': '4%'})
	$('.close').css({
		'right': '50px'
	});
	$('#close_slide').css({
		'display': 'none'
	});
	$('.num').css({
		'display': 'none', 
	});
	$('.next').css({
		'display': 'none'
	});
	$('.prev').css({
		'display': 'none'
	});
}
function slide_show_current(me){
	slide_show(slideIndex += me)
}
function plus_slide(n){
	slide_show(slideIndex += n)
}
function slide_show(n){
	var i;
	var slides = document.getElementsByClassName("image");
	$('#select').css({'display':'none'})
	$('#image_container').css({
		'position': 'fixed', 
		'z-index': '1',
		'left': '0',
		'top': '0',
		'width': '100%',
		'height': '100%',
		'overflow': 'auto',
		'background-color': 'rgba(0,0,0,.9)',
        'margin-top': '0'
	});
	$('#image_container .images .image').css({
		'height': 'auto',
		'width': '100%', 
	    'padding': '2%'
	})
	if(window.innerWidth < 800){
		$('.images').css({
			'width': '96%',
			'height': '100%',
			'position': 'relative',
			'margin': 'auto',
			'padding-top': '15%'
		});
	}else if(window.innerWidth < 1200){
		$('.images').css({
			'width': '96%',
			'height': '80%',
			'position': 'relative',
			'margin': 'auto',
			'padding-top': '2%'
		});
		$('#image_container .images .image').css({
			'height': '350px',
			'width': '100%'
		})
	}else{
		$('.images').css({
			'width': '96%',
			'height': '70%',
			'position': 'relative',
			'margin': 'auto',
			'padding-top': '2%'
		});
		$('#image_container .images .image').css({
			'height': '500px',
			'width': '100%'
		})
	}
	$('#image_container .image img').css({
		'width': '100%'
	});
	$('.close').css({
		'right': '25px'
	});
	$('#close_slide').css({
		'display': 'block'
	});
	$('.num').css({
		'display': 'block', 
	});
	$('.next').css({
		'display': 'block'
	});
	$('.prev').css({
		'display': 'block'
	});

	if(n > slides.length){
		slideIndex = 1;
	}
	if(n < 1){
		slideIndex = slides.length;
	}
	for(i = 0; i < slides.length; i++){
		slides[i].style.display = 'none';
	}
	slides[slideIndex - 1].style.display = "block";
}