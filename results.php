<?php
require_once('includes/header_footers.php');
require_once('includes/db_utils.php');
require_once('includes/RatingCalculator.php');


// FIXME: get the rating level from a calculation off collected test results.
$ratingLevel = RatingCalculator::getRatingFor($_GET['user_rating_id']);
$ratingLevelInt = round($ratingLevel);
$ratingData = DBUtils::get('rating_results', $ratingLevelInt);

printHeader('results', []);
?>
	<div class="content rating-<?php echo $ratingLevelInt; ?>">
		<h1>My Results</h1>
		
		<div class="rating-name"><?php echo $ratingData['name']; ?></div>
		
		<div class="circle-row">
			<?php for ($i = 1; $i <= 5; $i ++): ?>
				<div class="circle rating-<?php echo $i; ?>"></div>
			<?php endfor; ?>
		</div>
		
		<h2 class="rating-number"><?php echo sprintf('%.1f', $ratingLevel); ?></h2>
		
		<p class="rating-description">
		<?php echo $ratingData['description']; ?>
		</p>
	</div>
<?php

printFooter();