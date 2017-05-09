$(document).ready(function() {
	// class del nó sẽ xóa phần nào có class del trong 5s
	if ($('.del')) {
		setTimeout(function() {
			$('.del').fadeOut('slow', function() {
				$(this).remove();
			});
		}, 5000);
	}

	// file upload
	$('#fileUpload').change(function() {
		var object = $(this)[0];
		var countFiles = object.files.length;
		var imgPath = object.value;
		var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		var imgHolder = document.getElementById('imgHolder');
		$(imgHolder).empty();

		var accept = 'image/jpeg, image/png, image/jpg';
		var ext = ['jpeg', 'jpg', 'png'];
		if ($.inArray(extn, ext)) {
			if (typeof(FileReader) != undefined) {
				for (var i = 0; i < countFiles; i++) {
					var reader = new FileReader();
					reader.onload = function(e) {
						$('<div class="panel panel-default">' +
							'<div class="panel-body">' +
							'<img src="' + e.target.result + '" class="imgToUpload" width="50%" alt="picture" accept="' + accept + '" />' +
							'</div><div class="panel-footer"><textarea name="message[]" class="form-control" rows="5"></textarea>' +
							'</div></div>').appendTo(imgHolder);
					}
					$(imgHolder).show();
					reader.readAsDataURL(object.files[i]);
				}
			} else {
				alert('This browser doesn\'t support FileReader');
			}
		} else {
			alert('Please select only images !');
		}
	});
	// ./file upload
});