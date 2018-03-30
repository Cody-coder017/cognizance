<?php

function printHeader($page_class_name, $scripts = [])
{
	?><!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>Cognizance</title>
		<meta name="author" content="Josh Greig">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="js/jquery-3.3.1.min.js"></script>
		<?php foreach ($scripts as $script): ?>
		<script src="<?php echo $script; ?>"></script>
		<?php endforeach; ?>
	</head>
	<body <?php 
		if (isset($page_class_name)) {
			?> class="<?php 
			echo $page_class_name;
			?>"<?php
		} ?>>
	<?php	
}

function printFooter()
{
	?> </body>
</html><?php
}