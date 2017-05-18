$(document).ready(function() {
	(function() {
		// scroll to top
		var id_btn = '#scroll_to_top';
		var duration = 500;
		var offset = 200;

		$(window).scroll(function() {
			if ($(this).scrollTop() > offset) {
				$(id_btn).fadeIn(duration);
			} else {
				$(id_btn).fadeOut(duration);
			}
		});

		$(id_btn).click(function(event) {
			event.preventDefault();
			$('html, body').animate({
				scrollTop: 0
			}, duration);
			return false;
		});
		// /. scroll to top
	})();

	// class del nó sẽ xóa phần nào có class del trong 5s
	if ($('.del')) {
		setTimeout(function() {
			$('.del').fadeOut('slow', function() {
				$(this).remove();
			});
		}, 5000);
	}
});