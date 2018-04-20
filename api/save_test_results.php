<?php

// processes requests from the form on signup.php.
session_start();

$path = realpath(dirname(dirname(__FILE__))) . str_replace('/', DIRECTORY_SEPARATOR, '/includes/db_utils.php');
require_once($path);

function sanitizeTestId($test_id) {
	return intval(trim($test_id));
}

// Copied from: https://stackoverflow.com/questions/6041741/fastest-way-to-check-if-a-string-is-json-in-php
function isJson($str1) {
	json_decode($str1);
	return (json_last_error() == JSON_ERROR_NONE);
}

function validateTestResults() {
	$required_parameters = ['test_id', 'game_play_data'];
	foreach ($required_parameters as $required_parameter) {
		if (!isset($_POST[$required_parameter])) {
			return $required_parameter . ' is required.';
		}
	}
	$test_id = sanitizeTestId($_POST['test_id']);
	if ($test_id < 1 || $test_id > 4) {
		return 'test_id must be in 1, 2, 3, 4';
	}

	if (!isJson($_POST['game_play_data'])) {
		return 'invalid json data in game_play_data';
	}

	if (!isset($_SESSION['user_id'])) {
		return 'not signed in';
	}

	return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$msg = validateTestResults();
	if ($msg) {
		$response = ['success' => false, 'message' => $msg];
		echo json_encode($response);
		http_response_code(422);
		exit();
	}
	$conn = getDBConnection();
	$stmt = $conn->prepare("INSERT INTO user_ratings (create_datetime, user_id, test_id, game_play_data) VALUES (now(), :user_id, :test_id, :game_play_data)");
	$userId = $_SESSION['user_id'];
	$userId = intval($userId);
	$testId = sanitizeTestId($_POST['test_id']);
	$stmt->bindParam(':user_id', $userId);
	$stmt->bindParam(':test_id', $testId);
	$stmt->bindParam(':game_play_data', $_POST['game_play_data']);
	$stmt->execute();

	$response = ['success' => true, 'user_rating_id' => intval($conn->lastInsertId()) ];
	echo json_encode($response);
}
else {
	http_response_code(405);
}