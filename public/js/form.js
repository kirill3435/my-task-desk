$(document).ready(function () {
	$('form').submit(function (event) {
		formId = $(this).attr('id');
		let json;
		event.preventDefault();
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function (result) {
				if (formId != 'login' && formId != 'readyMark') {
					json = jQuery.parseJSON(result); console.log(json);
					alert(json.status + ' - ' + json.message);
				}
				location.reload();
			},
		});
	});
});