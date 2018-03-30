<?php
require_once('includes/header_footers.php');
require_once('includes/db_utils.php');
printHeader('welcome', ['js/utils.js', 'js/welcome.js']);
?>	<h1>Welcome to Cognizance</h1>
	<p>Please answer the following questions before taking tests</p>
	<form method="post">
		<div class="form-inputs">
		   <div class="genders">
				<label>Gender</label>
				<div class="equally-spaced">
					<?php foreach (DbUtils::get('genders') as $gender): ?>
					<div>
						<input name="gender_id" type="radio" value="<?php
						echo $gender['id'];
						?>"><label><?php echo $gender['name']; ?></label>
					</div>
					<?php endforeach; ?>
				</div>
		   </div>
		   <div>
				<label for="date-of-birth">Date of birth</label>
				<input id="date-of-birth" name="date-of-birth" type="date">
		   </div>
		   <div>
				<label for="reason-for-usage">Reason for usage</label>
				<div>
					<select id="reason-for-usage" name="reason-for-usage">
					<?php foreach (DbUtils::get('usage_reasons') as $frequency): ?>
						<option value="<?php 
							echo $frequency['id'];
						?>"><?php echo $frequency['name']; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
		   </div>
		   <div>
				<label for="frequency">Frequency of usage</label>
				<div>
					<select id="frequency" name="frequency">
					<?php foreach (DbUtils::get('usage_frequencies') as $frequency): ?>
						<option value="<?php 
							echo $frequency['id'];
						?>"><?php echo $frequency['name']; ?></option>
					<?php endforeach; ?>
					</select>
				</div>
		   </div>
		   <div class="agree">
			   <input id="agree" name="agree" type="checkbox">
			   <label for="agree">Agree to use, privacy, safety terms</label>
		   </div>
	   </div>
	   <button class="main-navigation-button start-with-tests" type="submit">
			Start with Tests
	   </button>
	</form>
<?php

printFooter();
?>