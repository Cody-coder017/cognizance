// welcome.js depends on jQuery.

$(document).ready(function() {

	function navigateToSignUp() {
		window.location.href = "signup.php";
	}

	function navigationButtonClicked() {
		var msg = validate();
		if (msg === 0) {
			navigateToSignUp();
		}
	}

	var $nav_button = $('.main-navigation-button');
	$nav_button.attr('type', 'button');
	$nav_button.click(navigationButtonClicked);
});