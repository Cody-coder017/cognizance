<?php
require_once('includes/header_footers.php');

printHeader('test2 test', ['js/test2.js']);
?>
<div class="content">
	<svg xmlns="http://www.w3.org/2000/svg" version="1.1">
		<rect id="background"></rect>
		<circle id="followed-circle" />
	</svg>
</div>
<?php

printFooter();
?>