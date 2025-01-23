function init() {
	$('.form').hide();
}

function initThread() {
	console.log("Initializing Thread");

	$('.file').attr('class', 'file thumb');
}

function openForm() {
	$('.form').show();
}

function closeForm() {
	$('.form').hide();
}

function refreshThread() {
	console.log("Refreshing Thread");
}

function refreshBoard() {
	console.log("Refreshing Board");
}

function changeStyle(event) {
	var style = event.target.value;
	$.ajax({
		url		: "/php/changeStyle.php",
		data	: {
			style	: style,
			return	: "/"
		}
	}).done(() => {
		$('#style').attr('href', `/css/${style}`);
	});
}

function swapMedia(event) {
	event.preventDefault();
	let target	= $(event.target);

	if (target[0].tagName !== "IMG")
		target = target.parent().children().eq(1);

	let reloc	= target[0].src.replace(/(https|http):\/\//, "").replace(/[^\/]+/m, "").replace(/[^\/]+$/m, "");
	let media	= target[0].src.replace(/.*\//g, "");
	let isThumb	= (media.match(/_thumb\./) ? true : false);

	$.ajax({
		url		: '/php/swapMedia.php',
		method	: 'POST',
		data	: {
			reloc	: reloc,
			thumb	: isThumb,
			media	: media
		}
	}).done((output) => {
		target.parent().html(output).attr("class", (isThumb ? "file" : "file file-mini"));
	});
}
