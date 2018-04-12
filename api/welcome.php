<?php

session_start();
$path = realpath(dirname(dirname(__FILE__))) . str_replace('/', DIRECTORY_SEPARATOR, '/includes/db_utils.php');
require_once($path);

function sanitizeId($id) {
	return intval(trim($id));
}

$requiredParameters = ['gender_id', 'reason-for-usage', 'frequency'];

// processes requests from the form on welcome.php.
function validateWelcome($conn) {
	global $requiredParameters;
	foreach ($requiredParameters as $requiredParameter) {
		if (!isset($_POST[$requiredParameter])) {
			return $requiredParameter . ' required';
		}
	}
	if (!isset($_POST['date-of-birth'])) {
		return 'date-of-birth required';
	}
	// Check that gender_id can be found in database.
	$gender = DbUtils::get('genders', sanitizeId($_POST['gender_id']));
	if (!$gender) {
		return 'gender not matched';
	}
	$usageReason = DbUtils::get('usage_reasons', sanitizeId($_POST['reason-for-usage']));
	if (!$usageReason) {
		return 'usage reason not matched';
	}
	$usageFrequency = DbUtils::get('usage_frequencies', sanitizeId($_POST['frequency']));
	if (!$usageFrequency) {
		return 'usage frequency not matched';
	}

	return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = getDBConnection();
	$msg = validateWelcome($conn);
	if ($msg) {
		$response = ['success' => false, 'message' => $msg];
		echo json_encode($response);
		http_response_code(422);
		exit();
	}

	foreach ($requiredParameters as $parameter) {
		$_SESSION[$parameter] = sanitizeId($_POST[$parameter]);
	}
	$_SESSION['date-of-birth'] = trim($_POST['date-of-birth']);

	$response = ['success' => true];
	echo json_encode($response);
}
else {
	http_response_code(405);
}