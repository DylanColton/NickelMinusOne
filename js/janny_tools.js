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
