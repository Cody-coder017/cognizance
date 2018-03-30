<?php
require_once('includes/header_footers.php');
require_once('includes/db_utils.php');
printHeader('signup', ['js/utils.js', 'js/signup.js']);
?>	<h1>Cognizance Sign Up</h1>
	<p>Please give credentials so you can sign in any time</p>
	<form method="post">
		<div class="form-inputs">
		   <div>
				<label for="username">Username</label>
				<input name="username" id="username" type="text">
		   </div>
		   <div class="passwords">
				<label for="password">Password</label>
				<input id="password" name="password" type="password">
		   </div>
		   <div class="passwords">
				<label for="password_confirmation">Password Confirmation</label>
				<input id="password_confirmation" name="password_confirmation" type="password">
		   </div>
	   </div>
	   <button class="main-navigation-button" type="submit">
			Start with Tests
	   </button>
	</form>
<?php

printFooter();
?>