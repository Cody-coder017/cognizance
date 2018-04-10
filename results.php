<?php
require_once('includes/header_footers.php');
require_once('includes/db_utils.php');

// FIXME: get the rating level from a calculation off collected test results.
$ratingLevel = 3.0;
$ratingLevelInt = round($ratingLevel);
$ratingData = DBUtils::get('rating_results', $ratingLevelInt);

printHeader('results', []);
?>
	<div class="content rating-<?php echo $ratingLevelInt; ?>">
		<h1>My Results</h1>
		
		<div class="rating-name"><?php echo $ratingData['name']; ?></div>
		
		<h2 class="rating-number"><?php echo sprintf('%.1f', $ratingLevel); ?></h2>
		
		<p class="rating-description">
		<?php echo $ratingData['description']; ?>
		</p>
	</div>
<?php

printFooter();