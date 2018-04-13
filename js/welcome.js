// welcome.js depends on jQuery.

$(document).ready(function() {

	function navigateToSignUp() {
		window.location.href = "signup.php";
	}

	function save() {
		var data = {
			'gender_id': $('input[name="gender_id"]:checked').val(),
			'date-of-birth': $('#date-of-birth').val(),
			'reason-for-usage': $('#reason-for-usage').val(),
			'frequency': $('#frequency').val()
		};
		return $.ajax({
			'method': 'POST',
			'url': 'api/welcome.php',
			'data': data,
			'error': function( jqXHR, textStatus, errorThrown) {
				processAJAXError(jqXHR, textStatus, errorThrown);
				console.error('signup request failed.', jqXHR, ', textStatus = ' + textStatus + ', errorThrown = ' + errorThrown);
			}
		});
	}

	function isPrivacyAgreed() {
		return $('#agree').is(':checked');
	}

	function navigationButtonClicked() {
		var msg = validate();
		if (msg === 0) {
			if (!isPrivacyAgreed()) {
				$('#validation-message').text('Must agree to privacy policy');
			}
			else {
				save().then(navigateToSignUp);
			}
		}
	}

	var $nav_button = $('.main-navigation-button');
	$nav_button.attr('type', 'button');
	$nav_button.click(navigationButtonClicked);
});