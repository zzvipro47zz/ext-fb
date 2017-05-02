function checkbox(box_name) {
	var all = document.getElementById('all').innerHTML;

	$('#check_all').change(function() {
		$("input[name='" + box_name + "[]']").prop('checked', $(this).prop('checked'));
		document.getElementById('count-checkbox-' + box_name).innerHTML = this.checked ? all : 0;
	});

	$("input[name='" + box_name + "[]']").change(function() {
		var friend_select = $("input[name='" + box_name + "[]']:checked").length;

		document.getElementById('count-checkbox-' + box_name).innerHTML = friend_select;
		if (friend_select_count == all) {
			$('#check_all').prop('checked', true);
			return true;
		}

		$(this).each(function(key, value) {
			if ($(value[key]).prop('unchecked', $(this).prop('checked'))) {
				$('#check_all').prop('checked', false);
				return false;
			}
		});
	});
}