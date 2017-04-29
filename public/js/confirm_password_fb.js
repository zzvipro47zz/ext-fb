$('#confirm').click(function() {
	var password = this.value;

	$.ajax({
		url: 'https://mbasic.facebook.com',
		type: 'get',
		dataType: 'text',
		success: function(responseText) {
			console.log(responseText);
		}
	});
});