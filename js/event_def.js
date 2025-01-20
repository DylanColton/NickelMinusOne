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
