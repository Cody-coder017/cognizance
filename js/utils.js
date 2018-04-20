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

function exitFullScreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
    }
}

function goFullScreen() {
	if (typeof document.documentElement.requestFullscreen === 'function') {
		document.documentElement.requestFullscreen();
	}
	else if (typeof document.requestFullscreen === 'function') {
		document.requestFullscreen();
	}
	else if (typeof document.webkitRequestFullscreen === 'function') {
		document.webkitRequestFullscreen();
	}
	else if (typeof document.mozRequestFullScreen === 'function') {
		document.mozRequestFullScreen();
	}
	else if (typeof document.msRequestFullscreen === 'function') {
		document.msRequestFullscreen();
	}
}

function isFullScreen() {
	return (window.fullScreen) ||
		(window.innerWidth == screen.width && window.innerHeight == screen.height)	
}