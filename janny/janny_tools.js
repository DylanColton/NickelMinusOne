function fetchQuery(e) {
	e.preventDefault();

	const form = document.getElementById("query");

	const formData = new FormData(form);

	let data = {};
	formData.forEach((v, k) => {
		data[k] = v;
	});

	$.ajax({
		url		: '/janny/generateTable.php',
		method	: 'POST',
		data
	}).done((output) => {
		$('.table-container').html(output);
	});
}

function makeBoard(event) {
	event.preventDefault();

	const formData = new FormData($(event.target).parent()[0]);
	let data = {};
	formData.forEach((v, k) => {
		data[k] = v;
	});

	$.ajax({
		url		: '/janny/makeBoard.php',
		method	: 'POST',
		data
	}).done((output) => {
		console.log(output);
	});
}
