<?php
require_once('includes/header_footers.php');
printHeader('signin', ['js/utils.js', 'js/signin.js']);
?>	<h1>Cognizance Sign In</h1>
	<p>Please sign in to view past results and try again</p>
	<form method="post">
		<div class="form-inputs">
		   <div>
				<label for="username">Username</label>
				<input name="username" id="username" type="text">
		   </div>
		   <div>
				<label for="password">Password</label>
				<input id="password" name="password" type="password">
		   </div>
	   </div>
	   <button class="main-navigation-button" type="submit">
			Start with Tests
	   </button>
	</form>
<?php

printFooter();
?>