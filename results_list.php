<?php
require_once('includes/header_footers.php');
require_once('includes/db_utils.php');
require_once('includes/RatingCalculator.php');

$ratingsData = DBUtils::get('user_ratings');

printHeader('results-list', []);
?>
	<h1>My Ratings</h1>
	<div class="content">
		<?php foreach ($ratingsData as $rating): ?>
		<div>
			<a href="results.php?user_rating_id=<?php echo $rating['id']; ?>">Score <?php printf('%.2f', RatingCalculator::getRatingFor($rating['id'])); ?></a>
		</div>
		<?php endforeach; ?>
	</div>
<?php

printFooter();