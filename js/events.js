$(document).ready(() => {
	init();
});

// Dragging event
let dragging	= false;
let offX, offY;

$(document).ready(() => {
	$('.form-title').on("mousedown", function(e) {
		dragging = true;

		offX = e.pageX - $('.form').offset().left;
		offY = e.pageY - $('.form').offset().top;

		$('.form').css('cursor', 'grabbing');
	});

	$(document).on('mousemove', function (e) {
		if (dragging) {
			$('.form').css({
				left	: (e.pageX - offX) + 'px',
				top		: (e.pageY - offY) + 'px',
			});
		}
	});

	$(document).on('mouseup', function(e) {
		if (dragging) {
			dragging = false;
			$('.form').css("cursor", "default");
		}
	});
});
