$(document).ready(function() {
	// dataTables
	/*$('#dataTables-send_sms, #dataTables-post_wall, #dataTables-post_group, #dataTables-unfriend').DataTable({
		responsive: true
	});

	var all_friends = document.querySelectorAll('input[function=send_sms]').length;
	document.getElementById('all_friends').innerHTML = all_friends;

	$('#check_all').change(function() {
		$("input[name='send_sms[]']").prop('checked', $(this).prop('checked'));
		document.getElementById('friend_select').innerHTML = this.checked ? all_friends : 0;
	});

	$("input[name='send_sms[]']").change(function() {
		var friend_select = $("input[name='send_sms[]']:checked").length;

		document.getElementById('friend_select').innerHTML = friend_select;
		if (friend_select_count == all_friends) {
			$('#check_all').prop('checked', true);
			return true;
		}

		$(this).each(function(key, value) {
			if ($(value[key]).prop('unchecked', $(this).prop('checked'))) {
				$('#check_all').prop('checked', false);
				return false;
			}
		});
	});*/
	// ./dataTables


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