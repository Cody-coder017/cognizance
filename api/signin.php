<?php

// processes requests from the form on signup.php.
session_start();

$path = realpath(dirname(dirname(__FILE__))) . str_replace('/', DIRECTORY_SEPARATOR, '/includes/db_utils.php');
require_once($path);

function sanitizeUsername($username) {
	return trim($username);
}

function getMatchingUser($conn, $username, $password) {
	$query = $conn->prepare("select id from users where email=:email and password_hash=:password_hash");
	$query->bindParam(':email', $username);
	$query->bindParam(':password_hash', $password);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_ASSOC);
	if ( empty($results) ) {
		return null; // indicate no matches.
	}
	return $results[0];
}

function validateSignin($conn) {
	$required_parameters = ['username', 'password'];
	foreach ($required_parameters as $required_parameter) {
		if (!isset($_POST[$required_parameter])) {
			return $required_parameter . ' is required.';
		}
	}
	$user_id = getMatchingUser($conn, sanitizeUsername($_POST['username']), $_POST['password']);
	if ( !$user_id ) {
		return 'invalid username and password combination';
	}

	return '';
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$conn = getDBConnection();
	$msg = validateSignin($conn);
	if ($msg) {
		$response = ['success' => false, 'message' => $msg];
		echo json_encode($response);
		http_response_code(422);
		exit();
	}

	$_SESSION['user_id'] = getMatchingUser($conn, sanitizeUsername($_POST['username']), $_POST['password']);
	$response = ['success' => true];
	echo json_encode($response);
}
else {
	http_response_code(405);
}