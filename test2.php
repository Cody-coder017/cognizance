<?php
require_once('includes/header_footers.php');

if (!isset($_SESSION['user_id'])) {
	header("Location: signin.php?redirect_message=Sign+up+or+sign+in+required+for+testing");
	die();
}

printHeader('test2 test', ['js/utils.js', 'js/svg.js', 'js/test2.js'], false);
?>
<div class="content" id="svg-display">
	<div class="touch-point-marker hidden"></div>
</div>
<div class="game-over">
	<form>
		<h1>Game Over!</h1>
		<div class="form-inputs">
			<div id="validation-message"></div>
			<p>How many shapes did you see?</p>
			<input id="number-of-shapes" type="number" min="0" step="1">
		</div>
	</form>
   <button class="main-navigation-button" type="submit" disabled>
		View the Results
   </button>
</div>
<?php

printFooter();
?>