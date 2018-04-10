<?php

require_once('config.php');

class DbUtils {
	
	public static function get($tableName, $id = null) {
		$conn = getDBConnection();
		$sql = 'select * from '.$tableName;
		if ($id) {
			$sql .= ' where id = :id';
			$preparedStatement = $conn->prepare($sql);
			$preparedStatement->execute([':id' => $id]);
			return $preparedStatement->fetchAll()[0];
		}
		else {
			return $conn->query($sql);
		}
	}
}

