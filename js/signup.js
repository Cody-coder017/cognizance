$(document).ready(function() {

	function navigateToTest2Directions() {
		window.location.href = 'test2_directions.php';
	}

	function sendSignupRequest() {
		var data = {
			'username': $('#username').val().trim(),
			'password': $('#password').val().trim()
		};
		return $.ajax({
			'method': 'POST',
			'url': 'api/signup.php',
			'data': data,
			'success': function(response) {
				
			},
			'error': function( jqXHR, textStatus, errorThrown) {
				processAJAXError(jqXHR, textStatus, errorThrown);
				console.error('signup request failed.', jqXHR, ', textStatus = ' + textStatus + ', errorThrown = ' + errorThrown);
			}
		});
	}

	function validateAll() {
		var msg = validate();
		if (msg)
			return msg;
		else {
			// Does password and password confirmation match?
			var password = $('#password').val();
			var password_confirmation = $('#password_confirmation').val();
			if (password !== password_confirmation) {
				indicateInvalid($('.passwords'));
				return 'passwords do not match';
			}
			else {
				indicateValid($('.passwords'));
			}
		}
	}

	function navButtonClicked() {
		if (!validateAll()) {
			sendSignupRequest().then(function() {
				navigateToTest2Directions();
			});
		}
	}

	var $nav_button = $('.main-navigation-button');
	$nav_button.attr('type', 'button');
	$nav_button.click(navButtonClicked);
});