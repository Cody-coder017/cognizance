<?php
require_once('includes/header_footers.php');

printHeader('test2 test', ['js/svg.js', 'js/test2.js']);
?>
<div class="content" id="svg-display">
</div>
<div class="game-over">
	<form>
		<h1>Game Over!</h1>
		<div class="form-inputs">
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