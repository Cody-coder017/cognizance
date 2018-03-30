<?php

require_once('config.php');

class DbUtils {
	
	public static function get($tableName) {
		$conn = getDBConnection();
		return $conn->query('select * from '.$tableName);
	}
}

