$(document).ready(function () {
	if ($.browser.msie === true && $.browser.version === '6.0') {  // anti pattern
		// fix spans
		$('.row div[class^="span"]:first-child').not('[class*="offset"]').addClass('first-child');

		// fix offsets
		$('.row div[class*="offset"]:first-child').each(function () {
			var margin_left = parseInt($(this).css('margin-left'), 10) - 20;
			$(this).css('margin-left', margin_left);
		});
	}
});