<?php

session_start();

function isPWA()
{
	if ((isset($_GET['using_pwa']) && $_GET['using_pwa']) || (isset($_SESSION['using_pwa']) && $_SESSION['using_pwa'])) {
		$_SESSION['using_pwa'] = true;
		return true;
	}
	return false;
}

function printHeader($page_class_name, $scripts = [], $allow_scale = true)
{
	if (isPWA()) {
		$allow_scale = false;
	}

	?><!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8"> 
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>Cognizance</title>
		<!--[if IE]><link rel="shortcut icon" href="images/favicon.ico"><![endif]-->
		<link rel="icon" href="images/favicon.png">
		<meta name="author" content="Josh Greig">
		<?php if ($allow_scale): ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php else: ?>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<?php endif; ?>
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
