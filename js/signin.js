$(document).ready(function() {
	
	function navClicked() {
		if (validate() === undefined) {
			location.href = 'test2_directions.php';
		}
	}
	
	$('.main-navigation-button').attr('type', 'button').click(navClicked);
});