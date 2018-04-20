<?php
require_once('includes/header_footers.php');
require_once('includes/config.php');
require_once('includes/RatingCalculator.php');

$userId = $_SESSION['user_id'];
if (!$userId) {
	header('Location: signin.php');
	die();
}
$conn = getDBConnection();
$stmt = $conn->prepare('select * from user_ratings where user_id = :user_id order by create_datetime');
$stmt->execute(array(':user_id' => intval($userId)));
$ratingsData = $stmt->fetchAll();

printHeader('results-list', []);
?>
	<h1>My Ratings</h1>
	<div class="content">
		<?php foreach ($ratingsData as $rating): ?>
		<div>
			<a href="results.php?user_rating_id=<?php echo $rating['id']; ?>">
			<span class="created-date"><?php
			$date = date_create($rating['create_datetime']);
			echo date_format($date, 'Y-m-d h:i:s A');
			?></span>
			
			Score <?php printf('%.2f', RatingCalculator::getRatingFor($rating['id'])); ?></a>
		</div>
		<?php endforeach; ?>
	</div>
<?php

printFooter();