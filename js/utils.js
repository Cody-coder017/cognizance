function indicateInvalid($element) {
	$element.addClass('invalid');
}

function indicateValid($element) {
	$element.removeClass('invalid');
}

function validate() {
	var $groups = $('.form-inputs > div');
	var num_invalid = 0;
	$groups.each(function() {
		var $input = $(this).find('select, input');
		var tagName = $(this).prop("tagName");
		var val = '' + $input.val();
		if ($input.attr('type') === 'radio' ) {
			val = $('input[name=' + $input.attr('name') + ']:checked').val();
		}
		console.log('val = ' + val);
		if (val === undefined || val.trim() === '') {
			indicateInvalid($(this));
			num_invalid++;
		}
		else {
			indicateValid($(this));
		}
	});
	return num_invalid;
}
