(function() {
	// $('#dataTables-get_status').DataTable();
	$('#dataTables-messrank').DataTable({
		"aLengthMenu": [
			[15, 30, 75, -1],
			[15, 30, 75, "All"]
		],
		"iDisplayLength": 15
	});
})();