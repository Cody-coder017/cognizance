function indicateInvalid($element) {
	$element.addClass('invalid');
}

function indicateValid($element) {
	$element.removeClass('invalid');
}

function processAJAXError(jqXHR, textStatus, errorThrown) {
	if ( jqXHR.status === 422 ) {
		try {
			var responseData = JSON.parse(jqXHR.responseText);
			if (responseData.message) {
				$('#validation-message').text(responseData.message);
			}
		}
		catch (e) {
			console.error(e);
		}
	}
}

function validate() {
	var $groups = $('.form-inputs > div:not(#validation-message)');
	var num_invalid = 0;
	$groups.each(function() {
		var $input = $(this).find('select, input');
		var tagName = $(this).prop("tagName");
		var val = '' + $input.val();
		if ($input.attr('type') === 'radio' ) {
			val = $('input[name=' + $input.attr('name') + ']:checked').val();
		}
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
