$(document).ready(function() {
	
	function sendCredentials() {
		var data = {
			'username': $('#username').val().trim(),
			'password': $('#password').val().trim()
		};
		return $.ajax({
			'url': 'api/signin.php',
			'method': 'POST',
			'data': data,
			'error': processAJAXError
		});
	}

	function navClicked() {
		var msg = validate();
		if (msg === 0) {
			sendCredentials().then(function() {
				location.href = 'test2_directions.php';
			});
		}
		else {
			console.log(msg);
		}
	}
	
	$('.main-navigation-button').attr('type', 'button').click(navClicked);
});