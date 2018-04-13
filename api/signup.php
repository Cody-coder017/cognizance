<?php

// processes requests from the form on signup.php.
session_start();

$path = realpath(dirname(dirname(__FILE__))) . str_replace('/', DIRECTORY_SEPARATOR, '/includes/db_utils.php');
require_once($path);

function sanitizeUsername($username) {
	return trim($username);
}

function validateSignup($conn) {
	$required_parameters = ['username', 'password'];
	foreach ($required_parameters as $required_parameter) {
		if (!isset($_POST[$required_parameter])) {
			return $required_parameter . ' is required.';
		}
	}
	if ( strlen(sanitizeUsername($_POST['username'])) < 4 ) {
		return 'username must be at least 4 characters';
	}
	if ( strlen($_POST['password']) < 6 ) {
		return 'password must be at least 6 characters';
	}
	$username = sanitizeUsername($_POST['username']);
	$query = $conn->prepare("select 1 from users where email=:email");
	$query->bindParam(':email', $username);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_ASSOC);
	if ( !empty($results) ) {
		return 'username unavailable';
	}
	
	return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = getDBConnection();
	$msg = validateSignup($conn);
	if ($msg) {
		$response = ['success' => false, 'message' => $msg];
		echo json_encode($response);
		http_response_code(422);
		exit();
	}
	
	$gender_id = null;
	if ( isset($_SESSION['gender_id']) ) {
		$gender_id = $_SESSION['gender_id'];
	}

	$frequency = null;
	if ( isset($_SESSION['frequency']) ) {
		$frequency = $_SESSION['frequency'];
	}

	$usage_reason = null;
	if ( isset($_SESSION['reason-for-usage']) ) {
		$usage_reason = $_SESSION['reason-for-usage'];
	}

	$stmt = $conn->prepare("INSERT INTO users (email, password_hash, gender_id, usage_frequency_id, usage_reason_id) VALUES (:email, :password_hash, :gender_id, :frequency, :reason)");
	$stmt->bindParam(':email', sanitizeUsername($_POST['username']));
	$stmt->bindParam(':password_hash', trim($_POST['password']));
	$stmt->bindParam(':gender_id', $gender_id);
	$stmt->bindParam(':frequency', $frequency);
	$stmt->bindParam(':reason', $usage_reason);
	$stmt->execute();
	
	$newUserId = $conn->lastInsertId();
	$_SESSION['user_id'] = $newUserId;

	$response = ['success' => true, 'user_id' => $newUserId ];
	echo json_encode($response);
}
else {
	http_response_code(405);
}