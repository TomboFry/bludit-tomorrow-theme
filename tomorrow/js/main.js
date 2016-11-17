var canresize = true;

$( '.dropdown' ).hover(
	function(){
		if (canresize) { $(this).children('.submenu').slideDown(200, stop()); }
	},
	function(){
		if (canresize) { $(this).children('.submenu').slideUp(200, stop()); }
	}
);
// run test on initial page load
checkSize();

// run test on resize of the window
$(window).resize(checkSize);

$(".dropdown-btn").on('click', function(event) {
	var elm = $(this).parent().children('.submenu');
	if(elm.css("display") != "block") {
		elm.slideDown(200, stop());
	} else {
		elm.slideUp(200, stop());
	}
});
$("#menu-btn").on('click', function(event) {
	if($(this).hasClass('selected')) {
		$(this).removeClass('selected');
		$("#top-level-nav").animate({"left": "100%"}, 300);
	} else {
		$(this).addClass('selected');
		$("#top-level-nav").animate({"left": "0"}, 300);
	}
});

function stop(){
	$('.submenu').stop(true, true);
}

function checkSize(){
	var elm = $("#top-level-nav");
	if ($(".invisiblock").css("opacity") == "1"){
		canresize = true;
		if(elm.hasClass('mobile')) {
			elm.removeClass('mobile');
			elm.css('left', '0');
		}
		elm.css('top', '0');
	} else {
		canresize = false;
		if(!elm.hasClass('mobile')) {
			elm.addClass('mobile');
			elm.css('left', '100%');
		}
		elm.css('top', $("header").height());
	}
}
