<?php

function printHeader($page_class_name, $scripts = [])
{
	?><!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>Cognizance</title>
		<!--[if IE]><link rel="shortcut icon" href="images/favicon.ico"><![endif]-->
		<link rel="icon" href="images/favicon.png">
		<meta name="author" content="Josh Greig">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<script src="js/jquery-3.3.1.min.js"></script>
		<?php foreach ($scripts as $script): ?>
		<script src="<?php echo $script; ?>"></script>
		<?php endforeach; ?>
		 <link rel="manifest" href="manifest.json" />
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
