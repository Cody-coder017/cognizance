<?php

require_once('db_utils.php');

class RatingCalculator
{
	private static function calculateGuessCount($data) {
		if (!$data) {
			return 5;
		}
		$guessed_number = $data->guessed_number;
		$actual_number = 0;
		$events = $data->events; 
		foreach ($events as $event) {
			if (property_exists($event, 'type') && strpos($event->type, 'shape/') === 0) {
				$actual_number++;
			}
		}
		if ($guessed_number === 0 && $actual_number === 0) {
			$ratingValue = 5;
		}
		else {
			$ratingValue = 5 - 5 * abs(($guessed_number - $actual_number) / max($guessed_number, $actual_number));
		}
		if ($ratingValue < 1) {
			$ratingValue = 1;
		}
		return $ratingValue;
	}
	
	private static function getAverageDistanceRating($data) {
		$avgSize = 1;
		$touchX = 0;
		$touchY = 0;
		$x = 0;
		$y = 0;
		$numTimes = 0;
		$totalDistanceRatio = 0;
		$events = [];
		if ( is_array($data) ) {
			$events = $data['events'];
		}
		else {
			$events = $data->events;
		}

		foreach ($events as $event) {
			if ( $event->type === 'viewport/resize' ) {
				$avgSize = ($event->width + $event->height) * 0.5;
			}
			if ( $event->type === 'input/touchmove' ) {
				$x = $event->x;
				$y = $event->y;
			}
			if ( $event->type === 'position/move' && $avgSize > 0 ) { 
				$touchX = $event->x;
				$touchY = $event->y;

				$dx = $x - $touchX;
				$dy = $y - $touchY;
				$distance = sqrt($dx * $dx + $dy * $dy);
				$totalDistanceRatio += $distance / $avgSize;
				$numTimes ++;
			}
		}
		$result = 5 - 4 * ($totalDistanceRatio / $numTimes);
		if ( $result < 1 ) {
			return 1;
		}
		if ( $result > 5 ) {
			return 5;
		}
		return $result;
	}
	
	private static function calculateRatingFromGamePlayData($data) {
		$shapeCountGuessRating = self::calculateGuessCount($data);
		$averageDistnaceRating = self::getAverageDistanceRating($data);
		return ($shapeCountGuessRating + $averageDistnaceRating) * 0.5;
	}
	
	public static function getRatingFor($user_rating_id) {
		$rating = DBUtils::get('user_ratings', intval($user_rating_id));
		if ( $rating && $rating['cached_rating'] ) {
			return $rating['cached_rating'];
		}
		else if (!$rating) {
			echo 'Unable to get rating for id: ' . $user_rating_id;
			return 0;
		}
		else {
			$data = json_decode($rating['game_play_data']);
			return RatingCalculator::calculateRatingFromGamePlayData($data);
		}
	}
}
