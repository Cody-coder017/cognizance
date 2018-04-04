$(document).ready(function() {
	
	function navClicked() {
		var msg = validate();
		if (msg === 0) {
			location.href = 'test2_directions.php';
		}
		else {
			console.log(msg);
		}
	}
	
	$('.main-navigation-button').attr('type', 'button').click(navClicked);
});