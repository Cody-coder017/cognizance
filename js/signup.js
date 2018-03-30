$(document).ready(function() {
	
	function navigateToTest2Directions() {
		window.location.href = 'test2_directions.php';
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
			navigateToTest2Directions();
		}
	}
	
	var $nav_button = $('.main-navigation-button');
	$nav_button.attr('type', 'button');
	$nav_button.click(navButtonClicked);
});