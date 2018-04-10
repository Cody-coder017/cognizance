<?php

$conn = false;

function getConfigData()
{
	$path = realpath(dirname(dirname(__FILE__))) . str_replace('/', DIRECTORY_SEPARATOR, '/db/config.json');
	return json_decode(file_get_contents($path));
}

function getDBConnection()
{
	global $conn;
	if ($conn) {
		return $conn;
	}
	$config = getConfigData();
	
	$host = $config->host;
	$db = $config->database;
	$charset = 'latin1';
	$user = $config->username;
	$pass = $config->password;
	$dsn = 'mysql:dbname='.$db.';host='.$host;
	$opt = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	$pdo = new PDO($dsn, $user, $pass, $opt);
	$conn = $pdo;
	return $pdo;
}

?>